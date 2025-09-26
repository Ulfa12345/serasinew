<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SERASI | Login</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../img/favicon.png" />

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <style>
    body {
      margin-top: 40px;
      background-image: url(img/bg.jpg);
      background-size: cover;
    }
  </style>

</head>

<body>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

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
                    <h1 class="h4 text-gray-900 mb-4">SERASI | LOGIN<br><small class="badge badge-success">- Sistem Pengajuan Denah PBF -</small></h1>
                  </div>
                  <form action="pages/auth/login_process.php" method="post" class="user" id="loginForm">
                    <div class="form-group">
                      <input type="number" class="form-control form-control-user" id="username" name="nib" aria-describedby="userHelp" placeholder="Masukkan NIB..." required>
                    </div>
                    <div class="input-group">
                      <input class="form-control form-control-user" type="password" name="password" placeholder="Password" id="pswd" autocomplete="current-password">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-eye fa-fw" style="cursor: pointer;" onclick="showpswd()"></i></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Tetap Masuk</label>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-user btn-block">Login</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="pages/auth/send_reset_email.php">Lupa Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="signup.php">Belum Punya Akun? Register!</a>
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
    function showpswd() {
      var x = document.getElementById("pswd");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    $(function() {
      $('#username').on('keypress', function(e) {
        if (e.which == 32) {
          // console.log('Space Detected');
          return false;
        }
      });
    });

    // Password visibility toggle
    function showpswd() {
      const pswdField = document.getElementById('pswd');
      if (pswdField.type === "password") {
        pswdField.type = "text";
      } else {
        pswdField.type = "password";
      }
    }

    // Form submission with SweetAlert
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = this;
      const formData = new FormData(form);

      // Show loading alert
      Swal.fire({
        title: 'Memproses login',
        html: 'Mohon tunggu sebentar...',
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();

          // AJAX submission
          fetch(form.action, {
              method: 'POST',
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              Swal.close();

              if (data.success) {
                // Login success
                Swal.fire({
                  icon: 'success',
                  title: 'Login Berhasil!',
                  text: 'Anda akan diarahkan ke halaman dashboard',
                  timer: 2000,
                  showConfirmButton: false
                }).then(() => {
                  window.location.href = data.redirect || 'index.php';
                });
              } else {
                // Login failed
                Swal.fire({
                  icon: 'error',
                  title: 'Login Gagal',
                  text: data.message || 'NIB atau password salah',
                  confirmButtonText: 'Coba Lagi'
                });
              }
            })
            .catch(error => {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memproses login'
              });
              console.error('Error:', error);
            });
        }
      });
    });
  </script>

</body>

</html>