<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['id_client'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit;
}

// Ambil data session
$client_nib = $_SESSION['nib'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SERASI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SERASI Dashboard</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Selamat datang, <?php echo htmlspecialchars($client_nib); ?>!</h1>

    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Informasi Akun</div>
                <div class="card-body">
                    <h5 class="card-title">NIB: <?php echo $client_nib; ?></h5>
                    <p class="card-text">Anda login sebagai client pengguna SERASI.</p>
                </div>
            </div>
        </div>

        <!-- Card 2 (Contoh Statistik) -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <h5 class="card-title">Aktif</h5>
                    <p class="card-text">Akun Anda aktif dan dapat digunakan.</p>
                </div>
            </div>
        </div>

        <!-- Card 3 (Bisa diisi data dari DB) -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Notifikasi</div>
                <div class="card-body">
                    <h5 class="card-title">0 Notifikasi</h5>
                    <p class="card-text">Belum ada notifikasi terbaru.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    &copy; <?php echo date("Y"); ?> SERASI - Sistem Registrasi dan Aktivasi
</footer>

</body>
</html>
