<?php
include "../../../../../conf/conn.php";

$query_dropbox=$conn -> query("SELECT * FROM dropbox WHERE id_dropbox = 1");
$row_dropbox=mysqli_fetch_array($query_dropbox);

require __DIR__ . '/../../../../vendor2/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

$dropboxKey = $row_dropbox['key_dropbox'];
$dropboxSecret = $row_dropbox['secret'];
$token = $row_dropbox['token'];
$appName = $row_dropbox['appname'];
$folder = $row_dropbox['folder'];

$app = new DropboxApp($dropboxKey, $dropboxSecret, $token);
//Configure Dropbox service
$dropbox = new Dropbox($app);

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
	$audit = $_POST['audit'];

	//Menentukan id psb
	$date=date_create("now",timezone_open("Asia/Jakarta"));
	$tanggal = date_format($date,"Y-m-d H:i:s");

	$id_psb = strtotime($tanggal);

$sql = ("INSERT INTO tbl_psb_pangan(id_psb, tgl_psb, perihal_psb, id_detail, id_komoditi, jenispangan, nama_cp, notelp_cp, pilihan_psb, status_psb) VALUES ('".$id_psb."','".$tglmohon."','".$perihal."','".$idpemohon."','".$idkomoditi."','".$jenispangan."','".$namacp."','".$notelpcp."','".$audit."','0')");

$insert_doc = $conn -> query("SELECT * FROM tbl_doc WHERE perihal = '".$perihal."'");

while($insert = mysqli_fetch_array($insert_doc)){
	$sql2 = $conn -> query("INSERT INTO tbl_doc_psb_pangan(id_doc_psb, id_komoditi, id_psb, id_doc, link_doc, status) VALUES ('','".$idkomoditi."','".$id_psb."','".$insert['id_doc']."','0','0')");
}

if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Pengajuan PSB Anda berhasil masuk database");
	window.location.href="../../../../index.php?page=2121"</script>';
	$dropbox->createFolder("/".$folder.'/'.$id_psb);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}

$conn->close();

?>