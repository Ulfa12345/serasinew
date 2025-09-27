<?php
include "../conf/conn.php";
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'] ?? '';

if (empty($email)) {
    die('Email wajib diisi');
}

// cek email di database
$stmt = $conn->prepare("SELECT email FROM tb_perusahaan WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Email tidak ditemukan');
}

// buat token
$token = bin2hex(random_bytes(32));
$created_at = date('Y-m-d H:i:s');

// simpan token di tabel password_resets
$conn->query("DELETE FROM password_resets WHERE email='$email'");
$stmt2 = $conn->prepare("INSERT INTO password_resets (email, token, created_at) VALUES (?,?,?)");
$stmt2->bind_param("sss", $email, $token, $created_at);
$stmt2->execute();

// kirim email
$link = "localhost/serasi/user/resetpwd.php?token=" . $token;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'serasi.bbpomsurabaya@gmail.com';
    $mail->Password = 'sith rrgr pqwu rhlw'; // App password Gmail
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('serasi.bbpomsurabaya@gmail.com', 'Admin SERASI');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Reset Password Akun SERASI';
    $mail->Body = "Klik link berikut untuk reset password Anda:<br><a href='$link'>$link</a><br>Link berlaku 1 jam.";

    $mail->send();
    echo "Link reset password telah dikirim ke email Anda.";
} catch (Exception $e) {
    echo "Email gagal dikirim: {$mail->ErrorInfo}";
}
