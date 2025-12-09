<?php
if (isset($_GET['pageadmin'])) {
    $pageadmin = $_GET['pageadmin'];
    // Petugas
    switch ($pageadmin) {
        case 'dashboard':
            include "dashboard.php";
            break;
        case 'data_perusahaan':
            include "data_perusahaan.php";
            break;

        case 'data_pengajuan':
            include "data_pengajuan.php";
            break;

        case 'detail_perusahaan':
            include "detail_perusahaan.php";
            break;
            
        default:
            echo "<h4>Halaman tidak ditemukan.</h4>";
            break;
    }
} 