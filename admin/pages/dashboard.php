<?php
// 1. Panggil Logic & Security
include '../layouts/init.php';

// 2. Panggil Header HTML (Head, CSS) - *Asumsi Anda sudah punya file header.php*
include '../layouts/header.php';
?>

<div id="content">

    <?php include '../layouts/topbar.php';

    // Query menghitung jumlah perusahaan
    $query = "SELECT COUNT(*) as total FROM tb_perusahaan";
    $stmt = $conn->prepare($query);
    // Eksekusi query
    $stmt->execute();
    // Ambil hasil
    $result = $stmt->get_result();
    $row = $result->fetch_assoc(); // Menggunakan fetch_assoc untuk mysqli
    $total_perusahaan = $row['total'];
    $stmt->close();

    // Query menghitung jumlah pengajuan denah
    $querypengajuan = "SELECT COUNT(*) as totalpengajuan FROM tb_dokumen";
    $stmtpengajuan = $conn->prepare($querypengajuan);
    // Eksekusi query
    $stmtpengajuan->execute();
    // Ambil hasil
    $resultpengajuan = $stmtpengajuan->get_result();
    $rowpengajuan = $resultpengajuan->fetch_assoc(); // Menggunakan fetch_assoc untuk mysqli
    $total_pengajuan = $rowpengajuan['totalpengajuan'];
    $stmtpengajuan->close();

    // Query menghitung jumlah pengajuan denah yang belum di proses
    $queryproses = "SELECT COUNT(*) as totalproses FROM tb_dokumen WHERE status=0";
    $stmtproses = $conn->prepare($queryproses);
    // Eksekusi query
    $stmtproses->execute();
    // Ambil hasil
    $resultproses = $stmtproses->get_result();
    $rowproses = $resultproses->fetch_assoc(); // Menggunakan fetch_assoc untuk mysqli
    $total_proses = $rowproses['totalproses'];
    $stmtproses->close();




    ?>

    <div class="container-fluid">

        <?php
        if (file_exists("../../conf/pageadmin.php")) {
            include "../../conf/pageadmin.php";
        } else {
            echo "<h2>Halaman Dashboard Utama</h2>";
            // Isi dashboard default disini
        }
        ?>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah Perusahaan</div>
                                <i class="fas fa-home fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto">
                                <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_perusahaan; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Pengajuan</div>
                                <i class="fas fa-clipboard fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto">
                                <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_pengajuan; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengajuan Belum diproses
                                </div>
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto">
                                <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_proses; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pengajuan Belum diproses
                                </div>
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                            <div class="col-auto">
                                <div class="h2 mb-0 font-weight-bold text-gray-800"><?php echo $total_proses; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card shadow mb-2">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Keterangan Warna Status Pengajuan</h6>
                    </div>
                    <div class="card-body">
                        <table class="table-statistik">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-clock"></i>&nbsp; Proses
                                        </span>
                                    </td>
                                    <td class="h6 mb-0 font-weight-bold text-gray-800">Dokumen telah terkirim dan Masih dalam Proses</td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-list-alt"></i>&nbsp; Revisi
                                        </span>
                                    </td>
                                    <td class="h6 mb-0 font-weight-bold text-gray-800">Ada dokumen yang perlu diperbaiki</td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-contract"></i>&nbsp; Menunggu Persetujuan
                                        </span>
                                    </td>
                                    <td class="h6 mb-0 font-weight-bold text-gray-800">Menunggu Persetujuan pimpinan</td>
                                </tr>

                                <tr>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i>&nbsp; Selesai
                                        </span>
                                    </td>
                                    <td class="h6 mb-0 font-weight-bold text-gray-800">Dokumen telah Selesai di TTE</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php include '../layouts/footer.php'; ?>
    <?php
    // 7. Panggil Script JS (Paling bawah) - *Asumsi Anda buat file scripts.php*
    // include 'layouts/scripts.php'; 
    ?>