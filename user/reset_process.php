<?php
include "../conf/conn.php";

$email = $_POST['email'] ?? '';
$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($token) || empty($password)) {
    die('Data tidak lengkap');
}

// cek token
$stmt = $conn->prepare("SELECT email FROM password_resets WHERE email=? AND token=?");
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Token tidak valid');
}

// update password
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt2 = $conn->prepare("UPDATE tb_perusahaan SET password=? WHERE email=?");
$stmt2->bind_param("ss", $hashed, $email);
$stmt2->execute();

// hapus token
$conn->query("DELETE FROM password_resets WHERE email='$email'");

echo "Password berhasil direset. Silakan login.";
