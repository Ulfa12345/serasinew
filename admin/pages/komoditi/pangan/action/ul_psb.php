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

		//upload file
	$ekstensi_granted = array('pdf');
	$nama_file_temp = $_FILES['dokumen']['name'];
	$x = explode('.', $nama_file_temp);
	$ekstensi = strtolower(end($x));
	// $nama_file = round(microtime(true)) . '.' . end($x);
	$nama_file = $idpsb.'_'.$idkomoditi.'_'.$iddocpsb.'_'.$iddoc.'.'.end($x);
	$ukuran = $_FILES['dokumen']['size'];
	$file_tmp = $_FILES['dokumen']['tmp_name'];

if(in_array($ekstensi, $ekstensi_granted) === true){
				if($ukuran < 10440700){			
					move_uploaded_file($file_tmp, '../upload/'.$nama_file);

					$pathToLocalFile = __DIR__ . "/../upload/".$nama_file;

					// Create stream through file stream
					$fileStream = fopen($pathToLocalFile, DropboxFile::MODE_READ);
					$dropboxFile = DropboxFile::createByStream($nama_file, $fileStream);

					$file = $dropbox->upload($dropboxFile, '/'.$folder.'/'.$idpsb.'/'.$nama_file, ['autorename' => true]);

					//Uploaded File
					$file->getName();

					//Delete Local File
					unlink('../upload/'.$nama_file);

					$sql = ("UPDATE tbl_doc_psb_pangan SET link_doc='".$nama_file."',status='1' WHERE id_doc_psb ='$iddocpsb'");

					if ($conn->query($sql) === TRUE) {
 						   echo '<script>alert("Data Berhasil Diperbarui !!!");
							window.location.href="../../../../index.php?page=docprod&id='.$idpsb.'"</script>';
					} else {
    						echo "Error: " . $sql . "<br>" . $conn->error;
					}}else{
					echo '<script>alert("Ukuran File terlalu besar !!!");
							window.location.href="../../../../index.php?page=docprod&id='.$idpsb.'"</script>';
				}
}else{
				echo '<script>alert("Ekstensi File tidak diizinkan !!!");
							window.location.href="../../../../index.php?page=docprod&id='.$idpsb.'"</script>';
	}
}
$conn->close();

?>

