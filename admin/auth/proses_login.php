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

     // Minimal 8 karakter, mengandung setidaknya satu huruf (besar/kecil), satu angka, dan satu karakter spesial.
    $regex_password = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s]).{8,}$/";

    if (!preg_match($regex_password, $password)) {
        echo '<script>alert("Password harus minimal 8 karakter dan mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu karakter spesial!"); window.location.href="../login.php";</script>';
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
