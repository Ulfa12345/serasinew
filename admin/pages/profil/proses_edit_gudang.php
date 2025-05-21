<?php
session_start();
include "../../../conf/conn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        //$id_perusahaan = $_SESSION['id_perusahaan'];
        $id = $_POST['id_gudang'];
        $nama = $_POST['nama_gudang'];
        $alamat = $_POST['alamat_gudang'];
        $keterangan = $_POST['keterangan'];

        // Validasi input
        if (empty($nama) || empty($alamat)) {
            throw new Exception("Nama dan alamat wajib diisi!");
        }

        $stmt = $conn->prepare("UPDATE tb_gudang SET 
            nama_gudang = ?, 
            alamat_gudang = ?, 
            keterangan = ?
            WHERE id_gudang = ?");
        
        $stmt->bind_param("sssi", $nama, $alamat, $keterangan, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception("Gagal update: " . $stmt->error);
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
?>