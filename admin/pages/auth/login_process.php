<?php
session_start();
include "../../../conf/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['nib']);
    $password = $_POST['password'];

    // Cek apakah field kosong
    if (empty($username) || empty($password)) {
        echo '<script>alert("NIB dan Password tidak boleh kosong!"); window.location.href="../../login.php";</script>';
        exit;
    }

    // Query untuk ambil data perusahaan dan gudang
    $query =  "SELECT * FROM tb_perusahaan 
              LEFT JOIN tb_gudang ON tb_perusahaan.id_perusahaan = tb_gudang.id_perusahaan
              WHERE tb_perusahaan.nib = '$username'";
    $result = $conn->query($query);

    if (!$result) {
        echo '<script>alert("Terjadi kesalahan saat mengakses database!"); window.location.href="../../login.php";</script>';
        exit;
    }

    // ...
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION['id_perusahaan'] = $row['id_perusahaan'];
        $_SESSION['nib'] = $row['nib'];
        $_SESSION['nama_perusahaan'] = $row['nama_perusahaan'];

        if ($row['id_gudang'] == '0' || empty($row['id_gudang'])) {
            echo '<script>alert("Data Anda belum lengkap. Silahkan lengkapi data terlebih dahulu."); window.location.href="../../index.php?page=profil";</script>';
        } else {
            echo '<script>window.location.href="../../index.php";</script>';
        }
    } else {
        echo '<script>alert("Password salah!"); window.location.href="../../login.php";</script>';
    }

  } else {
        //die(var_dump($query));
        echo '<script>alert("NIB tidak ditemukan!"); window.location.href="../../login.php";</script>';
    }
}
?>
