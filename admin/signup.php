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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SERASI | Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico" />

</head>

<body class="bg-gradient-success">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block my-auto" style="text-align: center;">
                <img src="../assets/img/logo.png" class="img-fluid" alt="Responsive image" width="75%">
              </div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun Baru <span class="badge badge-primary" style="font-size: 50%;">Komoditi <?php echo $ckom['nama_komoditi']; ?></span></h1>
              </div>
              <form class="user" action="pages/auth/signup_process.php" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Alamat" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="jabatan" name="jabatan" placeholder="Jabatan" required>
                </div>
                <div class="form-group">
                  <input type="number" class="form-control form-control-user" id="notelp" name="notelp" placeholder="Nomor Telepon / HP" required>
                </div>
                <div class="form-group row alert alert-secondary">
                  <div class="col-sm-6 text-center">
                    Komoditi
                  </div>
                  <div class="col-sm-6 text-center">
                    <?php echo $ckom['nama_komoditi']; ?>
                    <input type="hidden" id="id_komoditi" name="id_komoditi" value="<?php echo $ckom['id_komoditi']; ?>" placeholder="Komoditi" class="login"/>
                  </div>
                </div>
                <button class="button btn btn-success btn-large btn-user btn-block" type="submit">Register</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">Lupa Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Sudah Punya Akun? Login!</a>
              </div>
              <div class="text-center">
                <a class="small" href="../">Kembali Ke Beranda</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script type="text/javascript">
    $(function() {
        $('#username').on('keypress', function(e) {
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