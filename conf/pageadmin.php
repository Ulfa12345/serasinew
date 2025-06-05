<?php
if (isset($_GET['pageadmin'])) {
    $pageadmin = $_GET['pageadmin'];

    switch ($pageadmin) {
        case 'data_perusahaan':
            include "hal/data_perusahaan.php";
            break;

        case 'data_pengajuan':
            include "hal/data_pengajuan.php";
            break;

        case 'detail_perusahaan':
            include "hal/detail_perusahaan.php";
            break;

        default:
            echo "<h4>Halaman tidak ditemukan.</h4>";
            break;
    }
} else {
    // Default halaman jika parameter tidak ada
    include "hal/home.php";
}
?>
