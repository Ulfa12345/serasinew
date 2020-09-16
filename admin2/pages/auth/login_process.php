<?php
include "../../../conf/conn.php";
$username = $conn -> real_escape_string($_POST['username']);
$password = $conn -> real_escape_string($_POST['pswd']);
$check    = $conn->query("SELECT * FROM tbl_detail_client
							INNER JOIN tbl_perusahaan ON tbl_detail_client.id_perusahaan=tbl_perusahaan.id_perusahaan
  							INNER JOIN tbl_gudang ON tbl_detail_client.id_gudang=tbl_gudang.id_gudang
  							WHERE username = '$username' AND password = '$password'") or die($conn->error());
if(mysqli_num_rows($check) >= 1){
	while($row = mysqli_fetch_array($check)){
		session_start();
		$_SESSION['id_detail'] = $row['id_detail'];
		$_SESSION['username'] = $row['username'];

		if($row['npwp_perusahaan'] == '0' || $row['npwp_gudang'] == '0'){
			?>
			<script>alert("Data Anda belum Lengkap. Silahkan Melengkapi Data Terlebih Dahulu");
			window.location.href="../../index.php?page=profil"</script>
			<?php
		} else{
		?>
			<script>window.location.href="../../index.php"</script>
		<?php
		}
	}
}else{
	echo '<script>alert("Masukan Username dan Password dengan Benar !!!");
	window.location.href="../../login.php"</script>';
}
?>