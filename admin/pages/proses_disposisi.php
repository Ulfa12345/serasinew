<?php
session_start();
header('Content-Type: application/json');

include "../../conf/conn.php";

// --- START: Deklarasi dan Fungsi (Dibiarkan sama) ---
$id_admin_session = isset($_SESSION['id_admin']) ? $_SESSION['id_admin'] : NULL;
$id_perusahaan_dok = NULL; 

function insertLog($conn, $id_dok, $id_perusahaan, $id_admin, $description) {
 $stmt_log = $conn->prepare("
  INSERT INTO tb_dokumen_log (id_dok, id_perusahaan, id_admin, description) 
  VALUES (?, ?, ?, ?)
 ");

$stmt_log->bind_param("iiis", $id_dok, $id_perusahaan, $id_admin, $description);


 if (!$stmt_log->execute()) {
  error_log("Gagal memasukkan log: " . $stmt_log->error);
 }
 $stmt_log->close();
}

if ($conn->connect_error) {
 echo json_encode(['success' => false, 'msg' => 'Database Error!', 'error' => $conn->connect_error]);
 exit;
}



$id_pengajuan = $_POST['id_pengajuan']; 
$id_admin_tujuan = $_POST['petugas']; 
$catatan  = $_POST['cat_disposisi']; 

$query_data = $conn->prepare("
    SELECT 
        d.id_perusahaan,
        a.nama 
    FROM tb_dokumen d
    JOIN tb_admin a ON a.id_admin = ?
    WHERE d.id_dok = ?
");
$query_data->bind_param("ii", $id_admin_tujuan, $id_pengajuan);
$query_data->execute();
$result_data = $query_data->get_result();

if ($result_data->num_rows === 0) {
     echo json_encode(['success' => false, 'msg' => 'Data dokumen atau admin tujuan tidak ditemukan!']);
     exit;
}
$data_dok = $result_data->fetch_assoc();
// $id_perusahaan_dok = $data_dok['id_perusahaan']; 
$nama_admin_tujuan = $data_dok['nama']; 


// 2. Query update (Disposisi)
$stmt = $conn->prepare(
 "UPDATE tb_dokumen 
 SET id_admin = ?, catatan_disposisi = ?
 WHERE id_dok = ?"
);

$stmt->bind_param("isi", $id_admin_tujuan, $catatan, $id_pengajuan);
$ok = $stmt->execute();


if ($ok) {
 // Cek ulang data (untuk dikirim ke response JSON)
 $check = $conn->prepare("SELECT id_admin, catatan_disposisi FROM tb_dokumen WHERE id_dok = ?");
 $check->bind_param("i", $id_pengajuan);
 $check->execute();
 $result = $check->get_result();
 $row = $result->fetch_assoc();

 
    // --- PERBAIKAN LOGGING ---
 $log_description = "Dokumen didisposisi kepada **" . $nama_admin_tujuan . "** (ID: " . $id_admin_tujuan . ") oleh Admin yang login (ID: " . $id_admin_session . "). Catatan Disposisi: " . (empty($catatan) ? "Tidak ada" : $catatan);
 
    // Variabel yang digunakan:
    // $id_pengajuan (ID Dokumen)
    // $id_perusahaan_dok (ID Perusahaan, sudah diambil di Query 1)
    // $id_admin_session (ID Admin yang melakukan aksi)
    // $log_description (Deskripsi)
    
 insertLog($conn, $id_pengajuan, $id_perusahaan_dok, $id_admin_session, $log_description);
    // --- AKHIR PERBAIKAN LOGGING ---

 echo json_encode([
  'success' => true,
  'msg' => 'Disposisi berhasil dikirim.',
  'updated_data' => $row 
 ]);
} else {
 echo json_encode([
  'success' => false,
  'msg' => 'Gagal menyimpan disposisi!',
  'error' => $stmt->error
 ]);
}

$stmt->close();
$conn->close();