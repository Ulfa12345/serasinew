<?php
if (isset($_GET['pilihan'])){
	$pilihan = $_GET['pilihan'];

include "../conf/conn.php";

$currentkomoditi = $conn -> query("SELECT * FROM tbl_komoditi WHERE id_komoditi = '".$pilihan."'");
$ckom = mysqli_fetch_array($currentkomoditi);
?>
<!DOCTYPE html>
<html lang="en">
  
 <head>
    <meta charset="utf-8">
    <title>SERASI - BBPOM di Surabaya</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />

<link href="css/font-awesome.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />
    
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/pages/signin.css" rel="stylesheet" type="text/css">

</head>

<body>
	
	<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="../">
				Sistem Informasi Registrasi & Sertifikasi				
			</a>		
			
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li class="">						
						<a href="login.php" class="">
							Sudah Punya Akun? Masuk
						</a>
						
					</li>
					<li class="">						
						<a href="../" class="">
							<i class="icon-chevron-left"></i>
							Kembali Ke Beranda
						</a>
						
					</li>
				</ul>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->



<div class="account-container register">
	
	<div class="content clearfix">
		
		<form action="pages/auth/signup_process.php" method="post">
		
			<h2>Pendaftaran Akun Baru</h2>
			
			<div class="login-fields">
				
				<p>Komoditi <span class="badge badge-warning"><?php echo $ckom['nama_komoditi']; ?></span></p>
				
				<div class="field">
					<label for="email">Alamat Email:</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="usrname">Username:</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="nama">Nama Lengkap:</label>	
					<input type="text" id="nama" name="nama" value="" placeholder="Nama Lengkap" class="login" />
				</div> <!-- /field -->

				<div class="field">
					<label for="alamat">Alamat:</label>	
					<input type="text" id="alamat" name="alamat" value="" placeholder="Alamat" class="login" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="jabatan">Jabatan:</label>
					<input type="text" id="jabatan" name="jabatan" value="" placeholder="Jabatan" class="login"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="notelp">Nomor Telepon/HP:</label>
					<input type="number" id="notelp" name="notelp" value="" placeholder="Nomor Telepon/HP" class="login"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="komoditi">Komoditi:</label>
					<input type="text" id="komoditi" name="komoditi" value="<?php echo $ckom['nama_komoditi']; ?>" placeholder="Komoditi" class="login badge badge-success" readonly/>
					<input type="hidden" id="id_komoditi" name="id_komoditi" value="<?php echo $ckom['id_komoditi']; ?>" placeholder="Komoditi" class="login"/>
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">Agree with the Terms & Conditions.</label>
				</span>
									
				<button class="button btn btn-primary btn-large">Register</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Sudah Punya Akun? <a href="login.php">Masuk</a>
</div> <!-- /login-extra -->


<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/bootstrap.js"></script>

<script src="js/signin.js"></script>

<script type="text/javascript">
    $(function() {
        $('#username').on('keypress', function(e) {
            if (e.which == 32){
                // console.log('Space Detected');
                return false;
            }
        });

        $('#notelp').on('keypress', function(e) {
            if (e.which == 32){
                // console.log('Space Detected');
                return false;
            }
        });
});
</script>

</body>

 </html>
<?php
} else{
	echo '<script>alert("Silahkan Memilih Komoditi Terlebih Dahulu !!!");
	window.location.href="../"</script>';
}
 ?>
