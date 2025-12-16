<?php
// 1. Header WAJIB untuk JSON
header('Content-Type: application/json');
error_reporting(0); // Matikan warning PHP agar tidak merusak format JSON

session_start();
include "../../../conf/conn.php";

// Inisialisasi array response default
$response = [
    'status' => 'error',
    'message' => 'Terjadi kesalahan tidak diketahui',
    'redirect' => ''
];

try {
    // Validasi Session
    if (!isset($_SESSION['id_perusahaan'])) {
        throw new Exception("Sesi kadaluarsa, silakan login kembali.");
    }

    // Ambil ID
    $id_perusahaan = $_POST['id_perusahaan'];

    // 2. Fungsi Helper Upload (Path diperbaiki)
    function handleFileUpload($conn, $id, $inputName, $dbColumn)
    {
        // Path Folder Upload (Mundur 2 folder dari pages/profil/ ke root/uploads/)
        $targetDir = "../../../uploads/";

        // Jika ada file baru diupload
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0) {

            // Generate nama file unik
            $fileExtension = pathinfo($_FILES[$inputName]["name"], PATHINFO_EXTENSION);
            $fileName = time() . "_" . $inputName . "_" . $id . "." . $fileExtension;
            $targetFilePath = $targetDir . $fileName;

            // Pindahkan file
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                return $fileName; // Kembalikan nama file baru
            } else {
                throw new Exception("Gagal mengupload file: " . $inputName . ". Cek permission folder uploads.");
            }
        }

        // JIKA TIDAK ADA file baru, ambil nama file lama dari database
        // Gunakan intval untuk keamanan ID
        $safeId = intval($id);
        $query = "SELECT $dbColumn FROM tb_perusahaan WHERE id_perusahaan = $safeId";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row[$dbColumn]; // Kembalikan nama file lama
        }

        return null; // Jika data tidak ditemukan
    }

    // 3. Siapkan Data Text
    $nib = $_POST['nib'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat_perusahaan'];
    $email = $_POST['email'];
    $nama_pic = $_POST['nama_pic'];
    $no_wa_pic = $_POST['no_wa_pic'];
    $nomor_cdob = $_POST['nomor_cdob'];
    $tgl_cdob = !empty($_POST['tgl_berlaku_cdob']) ? $_POST['tgl_berlaku_cdob'] : NULL;
    $no_sipa = $_POST['no_sipa'];
    $tgl_sipa = !empty($_POST['tgl_berlaku_sipa']) ? $_POST['tgl_berlaku_sipa'] : NULL;

    // 4. Logika Password
    $password_query_part = "";
    if (!empty($_POST['password'])) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_query_part = ", password = '$password_hash'";
    }

    // 5. Eksekusi Upload File
    $file_nib = handleFileUpload($conn, $id_perusahaan, 'upload_nib', 'upload_nib');
    $file_pbf = handleFileUpload($conn, $id_perusahaan, 'upload_ijin_pbf', 'upload_ijin_pbf');
    $file_cdob = handleFileUpload($conn, $id_perusahaan, 'upload_cdob', 'upload_cdob');
    $file_sipa = handleFileUpload($conn, $id_perusahaan, 'upload_sipa', 'upload_sipa');

    // 6. Query Update
    $sql = "UPDATE tb_perusahaan SET 
            nib=?, nama_perusahaan=?, alamat_perusahaan=?, email=?, 
            nama_pic=?, no_wa_pic=?, 
            upload_nib=?, upload_ijin_pbf=?, upload_cdob=?, 
            nomor_cdob=?, tgl_berlaku_cdob=?, 
            upload_sipa=?, no_sipa=?, tgl_berlaku_sipa=?
            $password_query_part 
            WHERE id_perusahaan=?";

    $stmt = $conn->prepare($sql);

    // Pastikan jumlah 's' sesuai dengan jumlah variabel (14 's' + 1 'i')
    $stmt->bind_param(
        "ssssssssssssssi",
        $nib,
        $nama_perusahaan,
        $alamat,
        $email,
        $nama_pic,
        $no_wa_pic,
        $file_nib,
        $file_pbf,
        $file_cdob,
        $nomor_cdob,
        $tgl_cdob,
        $file_sipa,
        $no_sipa,
        $tgl_sipa,
        $id_perusahaan
    );

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Data berhasil diupdate!';
        $response['redirect'] = 'index.php?page=dataperusahaan';
    } else {
        throw new Exception("Gagal update database: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {

    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

// 7. Output Final (PENTING AGAR JS BISA BACA)
echo json_encode($response);
