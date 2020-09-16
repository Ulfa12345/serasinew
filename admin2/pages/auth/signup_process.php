<?php
include "../../../conf/conn.php";
require_once('../../../assets/library-email/function.php');
if($_POST)
{
	$email = $_POST['email'];
	$username = $_POST['username'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$jabatan = $_POST['jabatan'];
	$notelp = $_POST['notelp'];
	$id_komoditi = $_POST['id_komoditi'];

	//Menentukan id perusahaan dan id gudang
	$date=date_create("now",timezone_open("Asia/Jakarta"));
	$tanggal = date_format($date,"Y-m-d H:i:s");

	$id_perusahaan = strtotime($tanggal);
	$id_gudang = (strtotime($tanggal))*99;

	//generate password
	function password_generate($chars) 
	{
	  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	  return substr(str_shuffle($data), 0, $chars);
	}
	$password = password_generate(7);

	//Kirim Email Otomatis
	$msg = "Hai, ".$nama." <br><br>Silahkan login menggunakan username dan password berikut<br><br>Username : ".$username."<br>Password : ".$password."<br><br>Segera ganti password pada saat melengkapi data. Terimakasih";
	
    $subject  = 'Informasi Login Akun SERASI';

	$sql = ("INSERT INTO tbl_detail_client(id_detail, email, username, nama_detail, alamat_detail, jabatan_detail, notelp_detail, password,id_perusahaan, id_gudang, id_komoditi) VALUES ('','".$email."','".$username."','".$nama."','".$alamat."','".$jabatan."','".$notelp."','".$password."','".$id_perusahaan."','".$id_gudang."','".$id_komoditi."')");

	$sql2 = ("INSERT INTO tbl_perusahaan(id, id_perusahaan, npwp_perusahaan, nama_perusahaan, alamat_perusahaan, notelp_perusahaan, ket_perusahaan) VALUES ('','".$id_perusahaan."','0','0','0','0','0')");

	$sql3 = ("INSERT INTO tbl_gudang(id, id_gudang, npwp_gudang, nama_gudang, alamat_gudang, notelp_gudang, ket_gudang) VALUES ('','".$id_gudang."','0','0','0','0','0')");

	if($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE && $conn->query($sql3) === TRUE){
		
		//Aktifkan saat diupload di hosting
		//smtp_mail($email, $subject, $msg, '', '', 0, 0, true);

		echo '<script>alert("Pendaftaran Berhasil. Silahkan Cek Email Anda untuk mendapatlkan password !!!");
			window.location.href="../../login.php"</script>';
	} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			echo '<script>alert("Email tidak terkirim !!!");
					window.location.href="../../login.php"</script>';
		}

}
$conn->close();

?>