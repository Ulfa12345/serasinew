<?php
include "../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$idperusahaan = $_POST['idperusahaan'];
	$namaperusahaan = $_POST['namaperusahaan'];
	$npwpperusahaan = $_POST['npwpperusahaan'];
	$alamatperusahaan = $_POST['alamatperusahaan'];
	$notelpperusahaan = $_POST['notelpperusahaan'];
	$ketperusahaan = $_POST['ketperusahaan'];

$sql = ("UPDATE tbl_perusahaan SET npwp_perusahaan='$npwpperusahaan',nama_perusahaan='$namaperusahaan',alamat_perusahaan='$alamatperusahaan',notelp_perusahaan='$notelpperusahaan',ket_perusahaan='$ketperusahaan' WHERE id_perusahaan ='$idperusahaan'");

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Data berhasil diperbarui !!!");
	window.location.href="../../../index.php?page=profil"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>