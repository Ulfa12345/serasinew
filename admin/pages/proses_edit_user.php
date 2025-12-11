<?php
include '../layouts/init.php';

$id       = $_POST['id_admin'];
$username = $_POST['username'];
$nama     = $_POST['nama'];
$no_hp    = $_POST['no_hp'];
$role     = $_POST['role'];

if (!empty($_POST['password'])) {
    $password = $_POST['password'];
    $query = "UPDATE tb_admin SET username=?, nama=?, no_hp=?, password=?, role=? WHERE id_admin=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $username, $nama, $no_hp, $password, $role, $id);
} else {
    $query = "UPDATE tb_admin SET username=?, nama=?, no_hp=?, role=? WHERE id_admin=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $username, $nama, $no_hp, $role, $id);
}

$stmt->execute();

echo "<script>alert('Pengguna berhasil diperbarui'); window.location.href='data_pengguna.php';</script>";
