<?php
header('Content-Type: application/json');
include "../../../conf/conn.php";
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Cek apakah email terdaftar
    $stmt = $conn->prepare("SELECT * FROM tb_perusahaan WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Email tidak ditemukan.";
        exit;
    }

    // Generate token
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Simpan token ke database
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expires);
    $stmt->execute();

    // Kirim email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // sesuaikan
    $mail->SMTPAuth = true;
    $mail->Username = 'faulfa162@gmail.com'; // email Anda
    $mail->Password = 'jial pzop murw pgow'; // password aplikasi
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('faulfa162@gmail.com', 'SERASI');
    $mail->addAddress($email);
    $mail->Subject = 'Reset Password SERASI';
    $mail->Body = "Klik link berikut untuk reset password Anda: \n\n" .
        "http://localhost/serasi/user/pages/auth/reset_password.php?token=$token";

    if ($mail->send()) {
        echo "Link reset dikirim ke email.";
    } else {
        echo "Gagal kirim email: " . $mail->ErrorInfo;
    }
}
