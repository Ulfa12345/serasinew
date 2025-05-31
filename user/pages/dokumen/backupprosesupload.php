<?php
session_start();
include "../../../conf/conn.php";
// Fungsi bantu untuk upload file
function uploadFile($fieldName, $uploadDir = 'uploads/') {
    if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES[$fieldName]['name']);
        $tmpName = $_FILES[$fieldName]['tmp_name'];

        // Buat folder jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destination = $uploadDir . time() . '_' . $filename;
        if (move_uploaded_file($tmpName, $destination)) {
            return $destination;
        }
    }
    return null;
}

// Ambil data dari form
$id_perusahaan = $_SESSION['id_perusahaan'] ?? 1; // sesuaikan cara ambil ID perusahaan
$jenis_pengajuan = $_POST['jenis_pengajuan'] ?? '';

// Upload semua file (boleh kosong kecuali yang required)
$upload_sipa              = uploadFile('upload_sipa');
$upload_ijin_pbf          = uploadFile('upload_ijin_pbf');
$upload_suratpermohonan   = uploadFile('upload_suratpermohonan');
$upload_suratpernyataan   = uploadFile('upload_suratpernyataan');
$upload_denahbaru         = uploadFile('upload_denahbaru');
$upload_denahlama         = uploadFile('upload_denahlama');
$status = 0;

// Cek apakah file wajib ada
if (!$upload_suratpermohonan) {
    die("Gagal: Surat permohonan wajib diupload.");
}

// Simpan ke database
$query = "INSERT INTO tb_dokumen (
    id_perusahaan,
    jenis_pengajuan,
    upload_sipa,
    upload_ijin_pbf,
    upload_suratpermohonan,
    upload_suratpernyataan,
    upload_denahbaru,
    upload_denahlama,
    status
) VALUES (
    '$id_perusahaan',
    '$jenis_pengajuan',
    " . ($upload_sipa ? "'$upload_sipa'" : "NULL") . ",
    " . ($upload_ijin_pbf ? "'$upload_ijin_pbf'" : "NULL") . ",
    '$upload_suratpermohonan',
    " . ($upload_suratpernyataan ? "'$upload_suratpernyataan'" : "NULL") . ",
    " . ($upload_denahbaru ? "'$upload_denahbaru'" : "NULL") . ",
    " . ($upload_denahlama ? "'$upload_denahlama'" : "NULL") . ",
    '$status'
)";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "Pengajuan berhasil disimpan!";
    // redirect jika perlu: header("Location: ../index.php?page=dokumen");
} else {
    echo "Gagal menyimpan ke database: " . mysqli_error($conn);
}
?>
