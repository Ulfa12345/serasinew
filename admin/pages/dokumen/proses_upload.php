<?php
session_start();
include "../../../conf/conn.php";
// Pastikan user sudah login dan memiliki session id_perusahaan
if (!isset($_SESSION['id_perusahaan'])) {
    die("Anda tidak memiliki akses ke halaman ini.");
}

// Konversi semua nilai ke variabel yang bisa di-referensi
$id_perusahaan = $_SESSION['id_perusahaan'];
$jenis_pengajuan = $_POST['jenis_pengajuan'];

// Ekstrak nilai dari $fileData ke variabel terpisah
$sipa = $fileData['upload_sipa'] ?? null;
$ijin_pbf = $fileData['upload_ijin_pbf'] ?? null;
$surat_permohonan = $fileData['upload_suratpermohonan'] ?? null;
$surat_pernyataan = $fileData['upload_suratpernyataan'] ?? null;
$denah_baru = $fileData['upload_denahbaru'] ?? null;
$denah_lama = $fileData['upload_denahlama'] ?? null;

// Direktori penyimpanan file
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$allowedExtensions = ['pdf', 'jpg', 'png', 'jpeg'];
$requiredFields = [];
$errors = [];

// Tentukan field yang wajib berdasarkan jenis pengajuan
if ($_POST['jenis_pengajuan'] == 'Permohonan Baru') {
    $requiredFields = [
        'upload_sipa',
        'upload_ijin_pbf',
        'upload_suratpermohonan',
        'upload_suratpernyataan',
        'upload_denahbaru'
    ];
} elseif ($_POST['jenis_pengajuan'] == 'Perubahan Denah') {
    $requiredFields = [
        'upload_sipa',
        'upload_ijin_pbf',
        'upload_suratpermohonan',
        'upload_suratpernyataan',
        'upload_denahbaru',
        'upload_denahlama'
    ];
} else {
    die("Jenis pengajuan tidak valid.");
}

// Validasi file wajib
foreach ($requiredFields as $field) {
    if ($_FILES[$field]['error'] != UPLOAD_ERR_OK) {
        $errors[] = "File $field wajib diupload.";
    }
}

if (!empty($errors)) {
    die(implode("<br>", $errors));
}

// Proses upload file
$fileData = [];
foreach ($_FILES as $field => $file) {
    if ($file['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions)) {
            die("Ekstensi file tidak diizinkan untuk $field.");
        }
        
        $newName = uniqid() . '.' . $ext;
        $targetPath = $uploadDir . $newName;
        
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            die("Gagal mengupload file $field.");
        }
        
        $fileData[$field] = $newName;
    }
}

// Insert ke database
// Insert ke database
try {
    $stmt = $conn->prepare("INSERT INTO tb_dokumen (
        id_perusahaan,
        jenis_pengajuan,        
        upload_suratpermohonan,
        upload_suratpernyataan,
        upload_ijin_pbf,
        upload_sipa,
        upload_denahbaru,
        upload_denahlama,
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameter menggunakan variabel
    $stmt->bind_param(
        "isssssss", 
        $id_perusahaan,
        $jenis_pengajuan,
        $surat_permohonan,
        $surat_pernyataan,
        $ijin_pbf,
        $sipa,
        $denah_baru,
        $denah_lama
    );

    if ($stmt->execute()) {
        echo "Pengajuan berhasil disimpan!";
    } else {
        throw new Exception("Error: " . $stmt->error);
    }
} catch (Exception $e) {
    die($e->getMessage());
} finally {
    $stmt->close();
    $conn->close();
}