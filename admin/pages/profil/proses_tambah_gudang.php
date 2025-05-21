<?php
session_start();
include "../../../conf/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_gudang = trim($_POST['nama_gudang']);
    $alamat_gudang = trim($_POST['alamat_gudang']);
    $keterangan = trim($_POST['keterangan']);

    $id_perusahaan = $_SESSION['id_perusahaan'] ?? null;

    if (!$id_perusahaan) {
        echo "<script>alert('Session perusahaan tidak ditemukan.'); window.location.href='../../index.php';</script>";
        exit;
    }

    $sql = "INSERT INTO tb_gudang (id_perusahaan, nama_gudang, alamat_gudang, keterangan) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isss", $id_perusahaan, $nama_gudang, $alamat_gudang, $keterangan);
        if ($stmt->execute()) {
            echo "<script>alert('Data gudang berhasil disimpan.'); window.location.href='../../index.php?page=datagudang';</script>";
        } else {
            echo "Gagal eksekusi: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare gagal: " . $conn->error;
    }
} else {
    header('Location: ../../index.php?page=profil.php');
    exit;
}
?>
