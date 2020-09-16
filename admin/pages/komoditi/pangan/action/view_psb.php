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
	$idpsb = $_POST['idpsb'];
	$iddocpsb = $_POST['iddocpsb'];
	$idkomoditi = $_POST['idkomoditi'];
	$iddoc = $_POST['iddoc'];
	// $dokumen = $_POST['dokumen'];

	$query_file = $conn -> query("SELECT * FROM tbl_doc_psb_pangan WHERE id_doc_psb = '".$iddocpsb."'");
	$row_file = mysqli_fetch_array($query_file);

	$file = $dropbox->download($row_file['link_doc']);

	//File Contents
	$contents = $file->getContents();

	//Save file contents to disk
	file_put_contents(__DIR__ . "/dokumen.pdf", $contents);

	//Downloaded File Metadata
	$metadata = $file->getMetadata();

	//Name
	$metadata->getName();
}
$conn->close();

?>

