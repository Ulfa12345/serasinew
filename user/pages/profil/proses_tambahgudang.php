<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "../../../conf/conn.php";

header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil ID perusahaan dari session
        if (!isset($_SESSION['id_perusahaan'])) {
            throw new Exception("Session tidak ditemukan. Silakan login ulang.");
        }

        $id_perusahaan = $_SESSION['id_perusahaan'];
        
        // Validasi input
        $nama_gudang = trim($_POST['nama_gudang'] ?? '');
        $alamat_gudang = trim($_POST['alamat_gudang'] ?? '');
        $keterangan = trim($_POST['keterangan'] ?? '');

        if (empty($nama_gudang) || empty($alamat_gudang)) {
            throw new Exception("Nama gudang dan alamat wajib diisi!");
        }

        $stmt = $conn->prepare("INSERT INTO tb_gudang (id_perusahaan, nama_gudang, alamat_gudang, keterangan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_perusahaan, $nama_gudang, $alamat_gudang, $keterangan);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Data berhasil disimpan';
        } else {
            throw new Exception("Gagal menyimpan data: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
    exit();
}
