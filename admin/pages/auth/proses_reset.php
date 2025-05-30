<?php
// reset_password_process.php
session_start();

include "../../../conf/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $userId = $_SESSION['id_perusahaan'];
    
    // Validasi input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: reset_password.php");
        exit();
    }
    
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Password baru dan konfirmasi password tidak cocok!";
        header("Location: reset_password.php");
        exit();
    }
    
    if (strlen($newPassword) < 8) {
        $_SESSION['error'] = "Password minimal 8 karakter!";
        header("Location: reset_password.php");
        exit();
    }
    
    // Dapatkan password saat ini dari database
    $stmt = $conn->prepare("SELECT password FROM tb_perusahaan WHERE id_perusahaan = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Verifikasi password saat ini
    if (!password_verify($currentPassword, $user['password'])) {
        $_SESSION['error'] = "Password saat ini salah!";
        header("Location: reset_password.php");
        exit();
    }
    
    // Hash password baru
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    // Update password di database
    $updateStmt = $conn->prepare("UPDATE tb_perusahaan SET password = ? WHERE id_perusahaan = ?");
    $updateStmt->bind_param("si", $hashedPassword, $userId);
    
    if ($updateStmt->execute()) {
        $_SESSION['success'] = "Password berhasil diubah!";
        header("Location: ../../../login.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi.";
        header("Location: reset_password.php");
        exit();
    }
}
?>