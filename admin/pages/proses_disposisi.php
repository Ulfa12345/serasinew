<?php
session_start();
header('Content-Type: application/json');

include "../../conf/conn.php";

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Database Error!', 'error' => $conn->connect_error]);
    exit;
}

// die(var_dump($_POST));
// Ambil data dari AJAX
$id_pengajuan = $_POST['id_pengajuan'];  
$id_admin     = $_POST['petugas'];       
$catatan      = $_POST['cat_disposisi']; 

// Query update
$stmt = $conn->prepare(
    "UPDATE tb_dokumen 
     SET id_admin = ?, catatan_disposisi = ?
     WHERE id_dok = ?"
);

$stmt->bind_param("isi", $id_admin, $catatan, $id_pengajuan);
$ok = $stmt->execute();

if ($ok) {
    $check = $conn->prepare("SELECT id_admin, catatan_disposisi FROM tb_dokumen WHERE id_dok = ?");
    $check->bind_param("i", $id_pengajuan);
    $check->execute();
    $result = $check->get_result();
    $row = $result->fetch_assoc();

    echo json_encode([
        'success' => true,
        'msg' => 'Disposisi berhasil dikirim.',
        'updated_data' => $row  // hasil cek ulang
    ]);
} else {
    echo json_encode([
        'success' => false,
        'msg' => 'Gagal menyimpan disposisi!',
        'error' => $stmt->error
    ]);
}