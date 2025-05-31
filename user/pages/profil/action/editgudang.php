<?php
include "../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$idgudang = $_POST['idgudang'];
	$namagudang = $_POST['namagudang'];
	$npwpgudang = $_POST['npwpgudang'];
	$alamatgudang = $_POST['alamatgudang'];
	$notelpgudang = $_POST['notelpgudang'];
	$ketgudang = $_POST['ketgudang'];

$sql = ("UPDATE tbl_gudang SET npwp_gudang='$npwpgudang',nama_gudang='$namagudang',alamat_gudang='$alamatgudang',notelp_gudang='$notelpgudang',ket_gudang='$ketgudang' WHERE id_gudang ='$idgudang'");

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Data berhasil diperbarui !!!");
	window.location.href="../../../index.php?page=profil"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>