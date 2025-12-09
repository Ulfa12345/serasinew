<?php
session_start();
include "../../conf/conn.php";
define('BASE_URL', 'http://localhost/serasi/');

// --- 1. LOGIKA TIMEOUT (AUTO LOGOUT) ---
$timeout = 18000; // 5 Jam
if (isset($_SESSION['timeout'])) {
    $duration = time() - (int)$_SESSION['timeout'];
    if ($duration > $timeout) {
        session_unset();
        session_destroy();
        echo "<script>alert('Sesi telah berakhir, silahkan login kembali');window.location.href='../auth/login.php'</script>";
        exit;
    }
}
$_SESSION['timeout'] = time();

// --- 2. LOGIKA AMBIL DATA ADMIN ---
$admin = [];
if (isset($_SESSION['id_admin'])) {
    $id_adm = $_SESSION['id_admin'];
    $stmt = $conn->prepare("SELECT * FROM tb_admin WHERE id_admin = ?");
    $stmt->bind_param("i", $id_adm);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
} else {
    // Redirect jika mencoba masuk tanpa login
    header("Location: ../auth/login.php");
    exit();
}
?>