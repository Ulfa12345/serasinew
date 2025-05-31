<?php
session_start();
include "../../../conf/conn.php";

// Pastikan tidak ada output sebelum header
if (ob_get_length()) ob_clean();
header('Content-Type: application/json');

try {
    // Validasi metode request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Hanya metode POST yang diizinkan", 405);
    }

    // Validasi session
    if (!isset($_SESSION['id_perusahaan'])) {
        throw new Exception("Session tidak valid. Silakan login kembali.", 401);
    }

    // Handle file upload (jika ada)
    $uploadedFile = null;
    if (!empty($_FILES['upload_nib']['name'])) {
        $file = $_FILES['upload_nib'];
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        // Validasi error upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error upload file: " . $file['error']);
        }

        // Validasi tipe file
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Hanya PDF, JPG, dan PNG yang diizinkan");
        }

        // Validasi ukuran file
        if ($file['size'] > $maxSize) {
            throw new Exception("Ukuran file maksimal 2MB");
        }

        // Generate nama file unik
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uploadedFile = uniqid('nib_') . '.' . $fileExt;
        //$targetDir = __DIR__ . 'pages/upload/nib/';
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/upload/nib/';

        // Buat direktori jika belum ada
        if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
            throw new Exception("Gagal membuat direktori upload");
        }

        // Pindahkan file
        if (!move_uploaded_file($file['tmp_name'], $targetDir . $uploadedFile)) {
            throw new Exception("Gagal menyimpan file");
        }
    }

    // Validasi input wajib
    $requiredFields = [
        'nama_perusahaan' => "Nama perusahaan wajib diisi",
        'alamat_perusahaan' => "Alamat perusahaan wajib diisi",
        'nama_pic' => "Nama penanggung jawab wajib diisi",
        'no_wa_pic' => "Nomor HP wajib diisi",
        'email' => "Email wajib diisi"
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($_POST[$field])) {
            throw new Exception($message);
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE tb_perusahaan SET 
        nama_perusahaan = ?,
        alamat_perusahaan = ?,
        nama_pic = ?,
        no_wa_pic = ?,
        upload_nib = COALESCE(?, upload_nib),
        email = ?
        WHERE id_perusahaan = ?");

    $stmt->bind_param(
        "ssssssi",
        $_POST['nama_perusahaan'],
        $_POST['alamat_perusahaan'],
        $_POST['nama_pic'],
        $_POST['no_wa_pic'],
        $uploadedFile,
        $_POST['email'],
        $_SESSION['id_perusahaan']
    );

    if (!$stmt->execute()) {
        throw new Exception("Gagal update database: " . $stmt->error);
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Data berhasil diperbarui'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
}

exit();