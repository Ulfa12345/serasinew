<?php
session_start();

// --- 1. JIKA SUDAH LOGIN SEBAGAI ADMIN (Role 1, 2, 3) ---
if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['super_admin', 'verifikator', 'approver'])) {
    // Arahkan langsung ke dashboard admin
    header("Location: admin/dashboard/index.php");
    exit;
}

// --- 2. JIKA SUDAH LOGIN SEBAGAI USER PEMOHON ---
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user_pemohon') {
    // Arahkan langsung ke dashboard user
    header("Location: user/dashboard.php");
    exit;
}

// --- 3. JIKA BELUM LOGIN (GUEST) ---
// Karena Anda punya 2 halaman login terpisah (Admin & User),
// standarnya kita lempar ke Login User (Masyarakat Umum).
// Admin nanti bisa login lewat link khusus atau tombol di halaman login user.

header("Location: /serasi/admin/login.php");
exit;
