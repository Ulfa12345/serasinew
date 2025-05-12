<?php
include "../../../../../conf/conn.php";
if($_POST)
{
	// $date=date_create("now",timezone_open("Asia/Jakarta"));
	// $tanggal = date_format($date,"Y-m-d H:i:s");
	$idpsb = $_POST['idpsb'];
	$tglperiksa = $_POST['tglperiksa'];
	$setuju = $_POST['setuju'];

$sql = ("UPDATE tbl_tgl_psb SET hasil_tgl='$setuju' WHERE id_psb ='$idpsb'");

if ($conn->query($sql) === TRUE) {
	if($setuju == '1'){
		$conn -> query("UPDATE tbl_psb_pangan SET status_psb='3' WHERE id_psb = '".$idpsb."'");
	} else if($setuju == '0'){
		$conn -> query("UPDATE tbl_psb_pangan SET status_psb='4' WHERE id_psb = '".$idpsb."'");
	}
    echo '<script>alert("Data berhasil diperbarui !!!");
	window.location.href="../../../../index.php?page=2121"</script>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>