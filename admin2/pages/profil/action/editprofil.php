<?php
include "../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$iddetail = $_POST['iddetail'];
	$username = $_POST['username'];
	$nama_detail = $_POST['nama_detail'];
	$alamat_detail = $_POST['alamat_detail'];
	$jabatan_detail = $_POST['jabatan_detail'];
	$email_detail = $_POST['email_detail'];
	$notelp_detail = $_POST['notelp_detail'];
	$password_detail = $_POST['password_detail'];
$sql = ("UPDATE tbl_detail_client SET email='$email_detail',username='$username',nama_detail='$nama_detail',alamat_detail='$alamat_detail',jabatan_detail='$jabatan_detail',notelp_detail='$notelp_detail',password='$password_detail' WHERE id_detail ='$iddetail'");

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Data berhasil diperbarui !!!");
	window.location.href="../../../index.php?page=profil"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>