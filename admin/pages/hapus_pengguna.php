<?php
include '../layouts/init.php';

$id = $_GET['id'];

$query = "DELETE FROM tb_admin WHERE id_admin=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

echo "<script>alert('Pengguna berhasil dihapus'); window.location.href='data_pengguna.php';</script>";
