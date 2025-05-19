<?php
include "../../../conf/conn.php";
//require_once('../../../assets/library-email/function.php');


if($_POST)
{
	$email = $_POST['email'];
	$nib = $_POST['nib'];
	$pwd = $_POST['password'];
	$nama = $_POST['nama'];
	//$alamat = $_POST['alamat'];
	//$jabatan = $_POST['jabatan'];
	$notelp = $_POST['no_wa'];
	//$id_komoditi = $_POST['id_komoditi'];

	//Menentukan id perusahaan dan id gudang
	//$date=date_create("now",timezone_open("Asia/Jakarta"));
	//$tanggal = date_format($date,"Y-m-d H:i:s");

	//$id_perusahaan = strtotime($tanggal);
	//$id_gudang = (strtotime($tanggal))*99;

	/*generate password
	function password_generate($chars) 
	{
	  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	  return substr(str_shuffle($data), 0, $chars);
	}
	$password = password_generate(7);*/

	//Kirim Email Otomatis
	//$msg = "Hai, ".$nama." <br><br>Silahkan login menggunakan username dan password berikut<br><br>Username : ".$username."<br>Password : ".$password."<br><br>Segera ganti password pada saat melengkapi data. Terimakasih";
	
    $subject  = 'Informasi Login Akun SERASI';

	$sql = ("INSERT INTO tb_client(nib, nama_pic, password, email, no_wa_pic, role) VALUES ('".$nib."','".$nama."','".$pwd."','".$email."','".$notelp."','user')");

	//$sql2 = ("INSERT INTO tbl_perusahaan(id, id_perusahaan, npwp_perusahaan, nama_perusahaan, alamat_perusahaan, notelp_perusahaan, ket_perusahaan) VALUES ('','".$id_perusahaan."','0','0','0','0','0')");

	//$sql3 = ("INSERT INTO tbl_gudang(id, id_gudang, npwp_gudang, nama_gudang, alamat_gudang, notelp_gudang, ket_gudang) VALUES ('','".$id_gudang."','0','0','0','0','0')");
	// API token dari Wablas
	$token = '0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb';

	// Nomor tujuan (format internasional TANPA tanda +)
	$to = $_POST['no_wa'];

	// Isi pesan
	$message = 'Halo, ini notifikasi dari sistem PHP Anda.';

	// Endpoint kirim pesan
	$url = 'https://jogja.wablas.com/api/v2/send-message';

	// Data yang dikirim ke API
	$data = [
		'phone' => $to,
		'message' => $message,
		'secret' => false,  // opsional
		'priority' => false, // opsional
		'isGroup' => false,  // untuk kirim ke grup WA, ubah jadi true
	];

	// Set header dan curl
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, [
		"Authorization: $token",
		"Content-Type: application/json"
	]);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	// Output respon dari Wablas
	if ($err) {
		echo "cURL Error #: " . $err;
	} else {
		echo "Respon API Wablas: " . $response;
	}

	if($conn->query($sql) === TRUE ){
		
		//Aktifkan saat diupload di hosting
		//smtp_mail($email, $subject, $msg, '', '', 0, 0, true);

		echo '<script>alert("Pendaftaran Berhasil.!!!");
			window.location.href="../../login.php"</script>';
	} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			//echo 'belum berhasil';
		}

}
//$conn->close();

?>