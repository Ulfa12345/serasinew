<?php
include '../layouts/init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $nama     = $_POST['nama'];
    $no_hp    = $_POST['no_hp'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    // --- HASH PASSWORD ---
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tb_admin (username, nama, no_hp, password, role) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $nama, $no_hp, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Pengguna berhasil ditambahkan'); window.location.href='data_pengguna.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah pengguna'); window.location.href='data_pengguna.php';</script>";
    }
}
?>
