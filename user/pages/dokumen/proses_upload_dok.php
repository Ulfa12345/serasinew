<?php
session_start();
include "../../../conf/conn.php";

// Set header JSON untuk semua respon
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_perusahaan = $_SESSION['id_perusahaan'];
        $jenis_pengajuan = $_POST['jenis_pengajuan'];
        $status = 0;

        // Fungsi untuk upload file
        function uploadFile($name)
        {
            if (!isset($_FILES[$name])) return null;

            $file = $_FILES[$name];
            if ($file['error'] !== UPLOAD_ERR_OK) return null;

            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowedExtensions)) {
                throw new Exception("Ekstensi file tidak diizinkan untuk $name");
            }

            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxFileSize) {
                throw new Exception("Ukuran file terlalu besar untuk $name (maks 5MB)");
            }

            $newName = uniqid() . '.' . $ext;
            $targetPath = __DIR__ . '/uploads/' . $newName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $newName;
            }
            throw new Exception("Gagal mengupload file $name");
        }

        // Upload semua file dengan validasi
        $files = [];
        $requiredFiles = [
            'upload_sipa' => 'SIPA',
            'upload_ijin_pbf' => 'Izin PBF',
            'upload_suratpermohonan' => 'Surat Permohonan',
            'upload_suratpernyataan' => 'Surat Pernyataan',
            'upload_denahbaru' => 'Denah Baru'
        ];

        foreach ($requiredFiles as $field => $name) {
            $files[$field] = uploadFile($field);
            if (!$files[$field]) {
                throw new Exception("File $name wajib diupload");
            }
        }

        // Handle berdasarkan jenis pengajuan
        if ($jenis_pengajuan === 'Permohonan Baru') {
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
                "issssssi",
                $id_perusahaan,
                $jenis_pengajuan,
                $files['upload_sipa'],
                $files['upload_ijin_pbf'],
                $files['upload_suratpermohonan'],
                $files['upload_suratpernyataan'],
                $files['upload_denahbaru'],
                $status
            );
        } elseif ($jenis_pengajuan === 'Perubahan Denah') {
            // Ambil denah lama terbaru
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
                "isssssssi",
                $id_perusahaan,
                $jenis_pengajuan,
                $files['upload_sipa'],
                $files['upload_ijin_pbf'],
                $files['upload_suratpermohonan'],
                $files['upload_suratpernyataan'],
                $denah_lama,
                $files['upload_denahbaru'],
                $status
            );
        } else {
            throw new Exception("Jenis pengajuan tidak valid");
        }

        // Eksekusi query
        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pengajuan berhasil disimpan!',
                'id_dok' => $stmt->insert_id
            ]);
            exit();
        } else {
            throw new Exception("Gagal menyimpan data ke database: " . $stmt->error);
        }
    } else {
        throw new Exception("Metode request tidak valid");
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
    exit();
}
