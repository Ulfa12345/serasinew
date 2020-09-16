<?php
include "../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$iddetail = $_POST['iddetail'];
	$username = $_POST['username'];
	$nama_detail = $_POST['namadetail'];
	$alamat_detail = $_POST['alamatdetail'];
	$jabatan_detail = $_POST['jabatandetail'];
	$email_detail = $_POST['emaildetail'];
	$notelp_detail = $_POST['notelpdetail'];
	$password_detail = $_POST['pswd'];
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