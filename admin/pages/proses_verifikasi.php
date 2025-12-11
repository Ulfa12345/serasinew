<?php
session_start();
header('Content-Type: application/json');

include "../../conf/conn.php";

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Database Error!', 'error' => $conn->connect_error]);
    exit;
}

$id     = $_POST['id']; 
$status = $_POST['status']; 
$note   = $_POST['catatan']; 

// ==== FILE UPLOAD ONLY IF STATUS = 3 (SELESAI) ====
$surat_persetujuan = null;
$denah_acc = null;

$uploadPath = "../../uploads/";  // sesuaikan dengan foldermu

if ($status == 3) {

    // ------------------------------
    // Upload Surat Persetujuan
    // ------------------------------
    if (isset($_FILES['surat_persetujuan']) && $_FILES['surat_persetujuan']['error'] === 0) {

        $ext1 = pathinfo($_FILES['surat_persetujuan']['name'], PATHINFO_EXTENSION);
        $filename1 = "surat_persetujuan_" . time() . "." . $ext1;

        if (!move_uploaded_file($_FILES['surat_persetujuan']['tmp_name'], $uploadPath . $filename1)) {
            echo json_encode(['success' => false, 'msg' => 'Gagal upload surat persetujuan!']);
            exit;
        }

        $surat_persetujuan = $filename1;
    }

    // ------------------------------
    // Upload Denah ACC
    // ------------------------------
    if (isset($_FILES['denah_acc']) && $_FILES['denah_acc']['error'] === 0) {

        $ext2 = pathinfo($_FILES['denah_acc']['name'], PATHINFO_EXTENSION);
        $filename2 = "denah_acc_" . time() . "." . $ext2;

        if (!move_uploaded_file($_FILES['denah_acc']['tmp_name'], $uploadPath . $filename2)) {
            echo json_encode(['success' => false, 'msg' => 'Gagal upload denah ACC!']);
            exit;
        }

        $denah_acc = $filename2;
    }
}


// ========================================================
// UPDATE DATABASE
// ========================================================

// Jika status 3 → update pakai file
if ($status == 3) {
    $stmt = $conn->prepare("
        UPDATE tb_dokumen SET 
            status = ?, 
            catatan = ?, 
            tanggal_pengajuan = NOW(),
            surat_persetujuan = ?, 
            denah_acc = ?
        WHERE id_dok = ?
    ");

    $stmt->bind_param("isssi", $status, $note, $surat_persetujuan, $denah_acc, $id);

} else {
    // status lain → update biasa tanpa file
    $stmt = $conn->prepare("
        UPDATE tb_dokumen SET 
            status = ?, 
            catatan = ?, 
            tanggal_pengajuan = NOW()
        WHERE id_dok = ?
    ");

    $stmt->bind_param("isi", $status, $note, $id);
}


// ========================================================
// EKSEKUSI UPDATE
// ========================================================
if ($stmt->execute()) {

    // Ambil nomor WhatsApp
    $query = mysqli_query($conn, "
        SELECT d.id_perusahaan, p.no_wa_pic, p.nama_perusahaan
        FROM tb_dokumen d
        JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
        WHERE d.id_dok = $id
    ");

    $data = mysqli_fetch_assoc($query);
    $notelp = $data['no_wa_pic'];
    $nama_perusahaan = $data['nama_perusahaan'];

    if ($status == 0) $statusText = "Proses";
    else if ($status == 1) $statusText = "Revisi";
    else if ($status == 2) $statusText = "Menunggu Persetujuan";
    else if ($status == 3) $statusText = "Selesai";
    else $statusText = "Status tidak dikenal.";

    $waMessage = "<p>Proses dokumen $nama_perusahaan status $statusText dengan catatan $note</p>
                  <p>Pesan otomatis ini dikirim melalui sistem, mohon untuk tidak dibalas.</p>";

    // Kirim WA
    $token = "0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb";
    $secret_key = ".XOrMxRzX";

    $apiUrl = 'https://jogja.wablas.com/api/send-message';
    $postData = [
        'phone' => $notelp,
        'message' => $waMessage,
    ];

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: ' . $token . $secret_key,
    ]);

    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo json_encode(['success' => true, 'msg' => 'Verifikasi selesai, WA gagal terkirim!', 'error' => curl_error($curl)]);
    } else {
        echo json_encode(['success' => true, 'msg' => 'Verifikasi selesai & WhatsApp terkirim!']);
    }
    curl_close($curl);

} else {
    echo json_encode(['success' => false, 'msg' => 'Gagal menyimpan!', 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
