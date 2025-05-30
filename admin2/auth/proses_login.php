<?php
session_start();
include "../../conf/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['pwd'];

    // Cek apakah field kosong
    if (empty($username) || empty($password)) {
        echo '<script>alert("Username dan Password tidak boleh kosong!"); window.location.href="../login.php";</script>';
        exit;
    }

    // Ambil data user dari database
    $query = "SELECT * FROM tb_admin WHERE username = '$username'";
    $result = $conn->query($query);

    if (!$result || $result->num_rows === 0) {
        echo '<script>alert("Username tidak ditemukan!"); window.location.href="../login.php";</script>';
        exit;
    }

    $data = $result->fetch_assoc();

    // Bandingkan password (tanpa hashing, karena tidak ada info hash di database)
    if ($password === $data['password']) {
        $_SESSION['id_admin'] = $data['id_admin'];
        echo '<script>alert("Berhasil login!"); window.location.href="../index.php";</script>';
        exit;
    } else {
        echo '<script>alert("Password salah!"); window.location.href="../login.php";</script>';
        exit;
    }
}
?>
