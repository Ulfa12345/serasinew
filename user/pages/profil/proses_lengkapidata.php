<?php
session_start();
header('Content-Type: application/json');
include "../../../conf/conn.php";

$response = [
    'success' => false,
    'message' => '',
    'redirect' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate session
        if (!isset($_SESSION['id_perusahaan'])) {
            throw new Exception('Session tidak valid. Silakan login kembali.');
        }

        $id_perusahaan = $_SESSION['id_perusahaan'];
        
        // Sanitize inputs
        $nama_gudang = trim($conn->real_escape_string($_POST['nama_gudang'] ?? ''));
        $alamat_gudang = trim($conn->real_escape_string($_POST['alamat_gudang'] ?? ''));
        $keterangan = trim($conn->real_escape_string($_POST['keterangan'] ?? ''));
        
        // Validate required fields
        if (empty($nama_gudang) || empty($alamat_gudang)) {
            throw new Exception('Nama dan alamat gudang wajib diisi');
        }

        // File upload configuration
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/upload/nib/';
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Validate file upload
        if (!isset($_FILES['upload_nib']) || $_FILES['upload_nib']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File NIB wajib diupload');
        }

        $file = $_FILES['upload_nib'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileExt, $allowedTypes)) {
            throw new Exception('Format file harus PDF, JPG, atau PNG');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('Ukuran file maksimal 5MB');
        }

        // Create upload directory if not exists
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception('Gagal membuat direktori upload');
            }
        }

        // Generate unique filename
        $newFileName = 'nib_' . $id_perusahaan . '_' . time() . '.' . $fileExt;
        $targetPath = $uploadDir . $newFileName;

        // Begin transaction
        $conn->begin_transaction();

        try {
            // 1. Update NIB in perusahaan table
            $updateQuery = "UPDATE tb_perusahaan SET upload_nib = ? WHERE id_perusahaan = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param('si', $newFileName, $id_perusahaan);
            
            if (!$stmtUpdate->execute()) {
                throw new Exception('Gagal mengupdate data NIB');
            }

            // 2. Insert warehouse data
            $insertQuery = "INSERT INTO tb_gudang 
                          (id_perusahaan, nama_gudang, alamat_gudang, keterangan) 
                          VALUES (?, ?, ?, ?)";
            $stmtInsert = $conn->prepare($insertQuery);
            $stmtInsert->bind_param('isss', $id_perusahaan, $nama_gudang, $alamat_gudang, $keterangan);
            
            if (!$stmtInsert->execute()) {
                throw new Exception('Gagal menyimpan data gudang');
            }

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                throw new Exception('Gagal menyimpan file ke server');
            }

            // Commit transaction if all operations succeed
            $conn->commit();

            $response['success'] = true;
            $response['message'] = 'Data berhasil disimpan';
            $response['redirect'] = 'index.php?page=dataperusahaan';

        } catch (Exception $e) {
            $conn->rollback();
            // Delete file if it was uploaded but transaction failed
            if (file_exists($targetPath)) {
                unlink($targetPath);
            }
            throw $e;
        }

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
} else {
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);
exit;