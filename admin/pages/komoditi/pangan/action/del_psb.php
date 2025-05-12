<?php
include "../../../../../conf/conn.php";
$id = $_GET['id'];

	$sql = ("DELETE FROM tbl_psb_pangan WHERE id_psb ='$id'");
	$sql2 = ("DELETE FROM tbl_tgl_psb WHERE id_psb ='$id'");
		if ($conn->query($sql) === TRUE) {
    		echo '<script>alert("Data Berhasil Dihapus !!!");
			window.location.href="../../../../index.php?page=2121"</script>';
		} else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
		}


$conn->close();
?>