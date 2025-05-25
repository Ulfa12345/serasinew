<?php
session_start();
include "../../../conf/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validasi session
        if (!isset($_SESSION['id_perusahaan'])) {
            throw new Exception('Session perusahaan tidak valid');
        }

        $id_perusahaan = $_SESSION['id_perusahaan'];
        
        // Sanitasi input
        $nama_gudang = trim($_POST['nama_gudang'] ?? '');
        $alamat_gudang = trim($_POST['alamat_gudang'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');
        
        // Validasi input kosong
        if (empty($nama_gudang) || empty($alamat_gudang)) {
            throw new Exception('Nama dan alamat gudang wajib diisi');
        }

        // Konfigurasi upload file
        $targetDir = __DIR__ . 'pages/upload/nib/';
        $allowedTypes = ['pdf', 'jpg', 'png'];
        $maxSize = 100 * 1024 * 1024; // 10MB

        // Validasi file upload
        if (!isset($_FILES['upload_nib']) || $_FILES['upload_nib']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File NIB wajib diupload');
        }

        $file = $_FILES['upload_nib'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, $allowedTypes)) {
            throw new Exception('Format file tidak didukung');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('Ukuran file melebihi batas 10MB');
        }

        // Membuat direktori jika belum ada
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                throw new Exception('Gagal membuat direktori upload');
            }
        }

        // Generate nama file unik
        $newFileName = uniqid('nibnew_', true) . '.' . $fileExt;
        $targetPath = $targetDir . $newFileName;

        // Mulai transaksi
        $conn->begin_transaction();

        try {
            // Update NIB di perusahaan
            $updateQuery = "UPDATE tb_perusahaan SET upload_nib = ? WHERE id_perusahaan = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param('si', $newFileName, $id_perusahaan);
            
            if (!$stmtUpdate->execute()) {
                throw new Exception('Gagal update NIB: ' . $stmtUpdate->error);
            }

            // Insert data gudang
            $insertQuery = "INSERT INTO tb_gudang 
                            (id_perusahaan, nama_gudang, alamat_gudang, keterangan) 
                            VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($insertQuery);
            $stmtInsert->bind_param('isss', $id_perusahaan, $nama_gudang, $alamat_gudang, $keterangan);
            
            if (!$stmtInsert->execute()) {
                throw new Exception('Gagal simpan gudang: ' . $stmtInsert->error);
            }

            // Pindahkan file setelah semua operasi database berhasil
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Gagal menyimpan file ke server');
            }

            // Commit transaksi
            $conn->commit();

            $_SESSION['success'] = 'Data berhasil disimpan';
            header('Location: ../../index.php?page=formupload');
            exit;

        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: ../../index.php?page=profil');
        exit;
    }
} else {
    header('Location: ../../index.php');
    exit;
}