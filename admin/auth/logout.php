<?php
session_start();

// 1. Kosongkan semua data session
$_SESSION = [];

// 2. Hancurkan session di server
session_destroy();

// 3. Arahkan kembali ke halaman Login Utama
// Sesuaikan path ini ke file login Anda
echo "<script>alert('Anda berhasil logout!'); window.location='login.php';</script>";
exit;
?>