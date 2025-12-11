<?php
session_start();

$timeout = 18000; // Number of seconds until it times out.
//$logout_redirect = 'login.php';

// Check if the timeout field exists.
if (isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {

        // remove all session variables
        session_unset();
        // Destroy the session and restart it.
        session_destroy();
        echo "<script type='text/javascript'>alert('Sesi telah berakhir, silahkan login kembali');window.location.href='login.php'</script>";
        // session_start();
    }
}
$_SESSION['start_session'] = time();
// Update the timout field with the current time.
$_SESSION['timeout'] = time();

include "../conf/conn.php";
// Pastikan user sudah login

$perusahaan = [];
$needCompletePerusahaan = false;
$needCompleteGudang = false;

if (isset($_SESSION['id_perusahaan'])) {
    $id_perusahaan = $_SESSION['id_perusahaan'];

    // Ambil data perusahaan
    $stmt = $conn->prepare("SELECT * FROM tb_perusahaan WHERE id_perusahaan = ?");
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $result = $stmt->get_result();
    $perusahaan = $result->fetch_assoc();
    $stmt->close();

    // Cek kelengkapan data perusahaan
    if (
        empty($perusahaan['upload_nib']) ||
        empty($perusahaan['upload_ijin_pbf']) ||
        empty($perusahaan['upload_cdob']) ||
        empty($perusahaan['nomor_cdob']) ||
        empty($perusahaan['tgl_berlaku_cdob']) ||
        empty($perusahaan['upload_sipa']) ||
        empty($perusahaan['no_sipa']) ||
        empty($perusahaan['tgl_berlaku_sipa'])
    ) {
        $needCompletePerusahaan = true;
    }


    // Cek data gudang
    $gudangStmt = $conn->prepare("SELECT * FROM tb_gudang WHERE id_perusahaan = ? LIMIT 1");
    $gudangStmt->bind_param("i", $id_perusahaan);
    $gudangStmt->execute();
    $gudangResult = $gudangStmt->get_result();
    $needCompleteGudang = $gudangResult->num_rows === 0;
    $gudangStmt->close();

    // var_dump($needCompleteGudang, $needCompletePerusahaan);
    // die;

    // Simpan status di JavaScript variable
    echo "<script>
        var needCompletePerusahaan = " . ($needCompletePerusahaan ? 'true' : 'false') . ";
        var needCompleteGudang = " . ($needCompleteGudang ? 'true' : 'false') . ";
    </script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SERASI - Dashboard</title>

    <link rel="shortcut icon" href="../img/favicon.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/ajax@0.0.4/lib/ajax.min.js"></script>
    <style>
        :root {
            --primary: #2c5aa0;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fb;
            color: #333;
        }

        .page-header {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            margin-bottom: 24px;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #eaeaea;
            padding: 16px 20px;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        .info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 500;
            color: #555;
            min-width: 180px;
        }

        .info-value {
            color: #222;
            font-weight: 400;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #eaeaea;
        }

        .file-upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #fafbfc;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: var(--primary);
            background-color: #f0f7ff;
        }

        .file-upload-area.dragover {
            border-color: var(--primary);
            background-color: #e6f2ff;
        }

        .file-info {
            font-size: 0.85rem;
            color: var(--secondary);
            margin-top: 8px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 10px 24px;
            font-weight: 500;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #234a8c;
            border-color: #234a8c;
        }

        .alert-section {
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .alert-icon {
            color: var(--danger);
            font-size: 1.5rem;
            margin-right: 12px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .document-preview {
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* Otomatis beri bintang merah pada label required */
        label.required::after {
            content: " *";
            color: red;
        }

        h5.required::after {
            content: " *";
            color: red;
        }

        .dropzone {
            border: 2px dashed #28a745;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            color: #28a745;
            font-weight: 500;
        }

        .dropzone:hover {
            background-color: #e6f4ea;
        }

        @media (max-width: 768px) {
            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 4px;
            }
        }
    </style>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img href="../img/favicon.png">
                </div>
                <div class="sidebar-brand-text mx-3">USER SERASI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./index.php?page=dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                PERUSAHAAN
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Perusahaan</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./index.php?page=dataperusahaan">Data Perusahaan</a>
                        <a class="collapse-item" href="./index.php?page=datagudang">Data Gudang</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-map"></i>
                    <span>Pengajuan Denah</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="./index.php?page=formupload">Form Upload Dokumen</a>
                        <a class="collapse-item" href="./index.php?page=data_dokumen">Data Dokumen</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Setting
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pengguna</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="./index.php?page=resetpwd">Reset Password</a>
                    </div>
                </div>
            </li>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $perusahaan['nama_perusahaan'] ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../img/favicon.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="./index.php?page=dataperusahaan">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <!--<a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout_process.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?php include "../conf/page.php"; ?>


                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="modalData"
                        data-need-perusahaan="<?php echo $needCompletePerusahaan ? 'true' : 'false'; ?>"
                        data-need-gudang="<?php echo $needCompleteGudang ? 'true' : 'false'; ?>">
                    </div>
                </div>
                <!-- /.container-fluid -->

                <!-- End of Main Content -->
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Tim IT BBPOM Surabaya</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>


    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin logout</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>