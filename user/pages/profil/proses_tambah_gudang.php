<?php
session_start();
header('Content-Type: application/json');
include "../../../conf/conn.php";

// Pastikan user sudah login dan ada id_perusahaan
if (!isset($_SESSION['id_perusahaan'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session perusahaan tidak ditemukan."
    ]);
    exit;
}

$id_perusahaan = $_SESSION['id_perusahaan'];

// Ambil data POST
$nama_gudang   = trim($_POST['nama_gudang'] ?? '');
$alamat_gudang = trim($_POST['alamat_gudang'] ?? '');
$no_sipa       = trim($_POST['no_sipa_apj_gudang'] ?? '');
$tgl_sipa      = trim($_POST['tgl_sipa_apj_gudang'] ?? '');



// Validasi input wajib
if ($nama_gudang == '' || $alamat_gudang == '') {
    echo json_encode([
        "status" => "error",
        "message" => "Nama gudang dan alamat gudang wajib diisi."
    ]);
    exit;
}


$file_sipa = NULL;
if (isset($_FILES['file_sipa_apj_gudang']) && $_FILES['file_sipa_apj_gudang']['error'] === 0) {

    $allowed_types = ['pdf', 'jpg', 'jpeg', 'png'];
    $file_name = $_FILES['file_sipa_apj_gudang']['name'];
    $file_tmp  = $_FILES['file_sipa_apj_gudang']['tmp_name'];

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_types)) {
        echo json_encode([
            "status" => "error",
            "message" => "Format file tidak diizinkan (hanya PDF/JPG/PNG)."
        ]);
        exit;
    }

    // Pastikan folder benar (SESUIKAN LOKASI FILE PHP-MU)
    $targetDir = "../../../uploads/sipa_apj_gudang/";

    // Buat nama file baru
    $newFileName = 'SIPA_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $targetPath = $targetDir . $newFileName;

    if (!move_uploaded_file($file_tmp, $targetPath)) {
        echo json_encode([
            "status" => "error",
            "message" => "Gagal mengupload file SIPA. Path: " . $targetPath
        ]);
        exit;
    }

    // VARIABEL BENAR
    $file_sipa = $newFileName;
}


// -----------------------------
// Simpan ke Database
// -----------------------------
$query = "INSERT INTO tb_gudang 
            (id_perusahaan, nama_gudang, alamat_gudang, 
             no_sipa_apj_gudang, tgl_sipa_apj_gudang, file_sipa_apj_gudang)
          VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param(
    "isssss",
    $id_perusahaan,
    $nama_gudang,
    $alamat_gudang,
    $no_sipa,
    $tgl_sipa,
    $file_sipa
);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Data gudang berhasil disimpan."
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menyimpan data: " . $conn->error
    ]);
}
