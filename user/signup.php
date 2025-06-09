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
  <link rel="icon" type="image/x-icon" href="../img/favicon.png" />

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
                <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun Baru <span class="badge badge-primary" style="font-size: 50%;"></span></h1>
              </div>
              <form class="user" id="registrationForm" action="pages/auth/register_proces.php" method="POST">
                <div class="form-group">
                  <input type="number" class="form-control form-control-user" id="username" name="nib" placeholder="Input NIB yang telah didapatkan dari OSS" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="username" name="nama_perush" placeholder="Nama Perusahaan" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control form-control-user" id="nama" name="alamat_perush" placeholder="Alamat Perusahaan" required rows="3"></textarea>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Perusahaan" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Penanggung Jawab" required>
                </div>
                <div class="form-group">
                  <input type="number" class="form-control form-control-user" id="notelp" name="no_wa" placeholder="Nomor WA yang bisa dihubungi untuk notifikasi pendaftaran" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Buat password untuk login ke akun anda" required>
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

  <!-- Swal and ajax-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/ajax@0.0.4/lib/ajax.min.js"></script>
  <script>
    //Sweet Alert
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch(this.action, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Pendaftaran Berhasil!',
              text: 'Akun Anda telah berhasil dibuat. Silakan login.',
              confirmButtonText: 'OK'
            }).then(() => {
              window.location.href = 'login.php';
            });
          } else {
            Swal.fire({
              icon: 'warning',
              //title: 'Pendaftaran Gagal',
              text: data.message || 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
              confirmButtonText: 'OK'
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
            confirmButtonText: 'OK'
          });
        });
    });
  </script>

</body>

</html>