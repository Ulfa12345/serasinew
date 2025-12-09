<?php
session_start();
include "../../../conf/conn.php";

header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request!");
    }

    if (!isset($_POST['id_gudang'])) {
        throw new Exception("ID gudang tidak ditemukan!");
    }

    $id = intval($_POST['id_gudang']);

    // Ambil file lama
    $queryFile = $conn->prepare("SELECT file_sipa_apj_gudang FROM tb_gudang WHERE id_gudang = ?");
    $queryFile->bind_param("i", $id);
    $queryFile->execute();
    $resultFile = $queryFile->get_result()->fetch_assoc();

    if (!$resultFile) {
        throw new Exception("Data gudang tidak ditemukan!");
    }

    $file_lama = $resultFile['file_sipa_apj_gudang'];
    $upload_path = "../../../uploads/sipa_apj_gudang/";

    // Hapus file fisik jika ada
    if (!empty($file_lama) && file_exists($upload_path . $file_lama)) {
        unlink($upload_path . $file_lama);
    }

    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM tb_gudang WHERE id_gudang = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        throw new Exception("Gagal menghapus data: " . $stmt->error);
    }

    echo json_encode([
        "status" => "success",
        "message" => "Data gudang berhasil dihapus!"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
