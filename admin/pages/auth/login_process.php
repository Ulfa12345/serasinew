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
	// $query =  "SELECT * FROM tb_perusahaan 
	//           LEFT JOIN tb_gudang ON tb_perusahaan.id_perusahaan = tb_gudang.id_perusahaan
	//           WHERE tb_perusahaan.nib = '$username'";
	$query = "SELECT * FROM tb_perusahaan WHERE nib = '$username' LIMIT 1";
	$result = $conn->query($query);

	if (!$result || $result->num_rows === 0) {
		echo '<script>alert("Terjadi kesalahan saat mengakses database!"); window.location.href="../../login.php";</script>';
		exit;
	}

	// ...
	// if ($result->num_rows === 1) {
	$row = $result->fetch_assoc();

	if (!password_verify($password, $row['password'])) {
		//die(var_dump($query));
		echo '<script>alert("Password salah!"); window.location.href="../../login.php";</script>';
	}
	$_SESSION['id_perusahaan'] = $row['id_perusahaan'];
	$_SESSION['nib'] = $row['nib'];
	$_SESSION['nama_perusahaan'] = $row['nama_perusahaan'];

	$id_perusahaan = $row['id_perusahaan'];
	$gudangQuery = "SELECT * FROM tb_gudang WHERE id_perusahaan = '$id_perusahaan' LIMIT 1";
	$gudangResult = $conn->query($gudangQuery);

	if ($gudangResult && $gudangResult->num_rows > 0) {
		echo '<script>window.location.href="../../index.php";</script>';
	} else {
		echo '<script>alert("Data Anda belum lengkap. Silahkan lengkapi data terlebih dahulu."); window.location.href="../../index.php?page=profil";</script>';
	}

	// if ($row['id_gudang'] == '0' || empty($row['id_gudang'])) {
	//     echo '<script>alert("Data Anda belum lengkap. Silahkan lengkapi data terlebih dahulu."); window.location.href="../../index.php?page=profil";</script>';
	// } else {
	//     echo '<script>window.location.href="../../index.php";</script>';
	// }
	// } else {
	//     echo '<script>alert("Password salah!"); window.location.href="../../login.php";</script>';
	// }

	//   } else {
	//         //die(var_dump($query));
	//         echo '<script>alert("NIB tidak ditemukan!"); window.location.href="../../login.php";</script>';
	//     }
};
?>
