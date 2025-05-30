<?php
session_start();
include "../../../conf/conn.php";
// Fungsi bantu untuk upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_perusahaan = $_SESSION['id_perusahaan'];
    $jenis_pengajuan = $_POST['jenis_pengajuan'];
    $status = 0;
    
    // Fungsi untuk upload file
    function uploadFile($name) {
        if (!isset($_FILES[$name])) return null;
        
        $file = $_FILES[$name];
        if ($file['error'] !== UPLOAD_ERR_OK) return null;
        
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $ext;
        $targetPath = 'uploads/' . $newName;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $newName;
        }
        return null;
    }
    
    // Upload semua file
    $files = [
        'sipa' => uploadFile('upload_sipa'),
        'ijin_pbf' => uploadFile('upload_ijin_pbf'),
        'surat_permohonan' => uploadFile('upload_suratpermohonan'),
        'surat_pernyataan' => uploadFile('upload_suratpernyataan'),
        'denah_baru' => uploadFile('upload_denahbaru')
    ];
    
    // Handle berdasarkan jenis pengajuan
    if ($jenis_pengajuan === 'Permohonan Baru') {
        // Insert baru tanpa denah lama
        $stmt = $conn->prepare("INSERT INTO tb_dokumen (
            id_perusahaan,
            jenis_pengajuan,
            upload_sipa,
            upload_ijin_pbf,
            upload_suratpermohonan,
            upload_suratpernyataan,
            upload_denahbaru,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "isssssss",
            $id_perusahaan,
            $jenis_pengajuan,
            $files['sipa'],
            $files['ijin_pbf'],
            $files['surat_permohonan'],
            $files['surat_pernyataan'],
            $files['denah_baru'],
            $status
        );
    } 
    elseif ($jenis_pengajuan === 'Perubahan Denah') {
        // 1. Ambil denah lama terbaru
        $denah_lama = null;
        $getLastDenah = $conn->prepare("
            SELECT upload_denahbaru 
            FROM tb_dokumen 
            WHERE id_perusahaan = ? 
            ORDER BY id_dok DESC 
            LIMIT 1
        ");
        $getLastDenah->bind_param("i", $id_perusahaan);
        $getLastDenah->execute();
        $result = $getLastDenah->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $denah_lama = $row['upload_denahbaru'];
        }
        
        // 2. Insert dengan denah lama dan baru
        $stmt = $conn->prepare("INSERT INTO tb_dokumen (
            id_perusahaan,
            jenis_pengajuan,
            upload_sipa,
            upload_ijin_pbf,
            upload_suratpermohonan,
            upload_suratpernyataan,
            upload_denahlama,
            upload_denahbaru,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "issssssss",
            $id_perusahaan,
            $jenis_pengajuan,
            $files['sipa'],
            $files['ijin_pbf'],
            $files['surat_permohonan'],
            $files['surat_pernyataan'],
            $denah_lama, // Diambil dari database
            $files['denah_baru'], // File baru yang diupload
            $status
        );
    }
    
    // Eksekusi query
    if ($stmt->execute()) {
        echo "Pengajuan berhasil disimpan!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>