<?php
include "../../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$tglmohon = $_POST['tglmohon'];
	$perihal = $_POST['perihal'];
	$idpemohon = $_POST['idpemohon'];
	$idkomoditi = $_POST['idkomoditi'];
	$jenispangan = trim($_POST['jenispangan']);
	$namacp = $_POST['namacp'];
	$notelpcp = $_POST['notelpcp'];

$sql = ("INSERT INTO tbl_psb_pangan(id_psb, tgl_psb, perihal_psb, id_detail, id_komoditi, jenispangan, nama_cp, notelp_cp, status_psb) VALUES ('','".$tglmohon."','".$perihal."','".$idpemohon."','".$idkomoditi."','".$jenispangan."','".$namacp."','".$notelpcp."','0')");

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Pengajuan PSB Anda berhasil masuk database");
	window.location.href="../../../../index.php?page=2121"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>