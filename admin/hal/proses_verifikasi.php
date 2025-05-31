<?php
session_start();
include "../../conf/conn.php";

header('Content-Type: application/json');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tangkap data dari AJAX
$id = $_POST['id'];
$status = $_POST['status'];
$note = $_POST['note'];

// Update database
$sql = "UPDATE tb_dokumen 
        SET status = ?, catatan = ?, tanggal_pengajuan = NOW() 
        WHERE id_dok = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isi", $status, $note, $id);

$response = ['success' => false, 'message' => ''];

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Verifikasi berhasil disimpan';
} else {
    $response['message'] = 'Error: ' . $stmt->error;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>