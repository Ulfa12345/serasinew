<?php
session_start();
include "../../../conf/conn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {

        $id             = $_POST['id_gudang'];
        $nama           = trim($_POST['nama_gudang']);
        $alamat         = trim($_POST['alamat_gudang']);
        $no_sipa        = trim($_POST['no_sipa_apj_gudang']);
        $tgl_sipa       = trim($_POST['tgl_sipa_apj_gudang']);

        // Ambil file lama
        $queryOld = $conn->prepare("SELECT file_sipa_apj_gudang FROM tb_gudang WHERE id_gudang = ?");
        $queryOld->bind_param("i", $id);
        $queryOld->execute();
        $resultOld = $queryOld->get_result()->fetch_assoc();
        $file_lama = $resultOld['file_sipa_apj_gudang'];

        // === VALIDASI WAJIB ===
        if (empty($nama) || empty($alamat)) {
            throw new Exception("Nama dan alamat wajib diisi!");
        }

        // ==========================================
        //   PROSES UPLOAD FILE JIKA ADA FILE BARU
        // ==========================================
        $file_baru = $file_lama; // default: pakai file lama

        if (!empty($_FILES['file_sipa_apj_gudang']['name'])) {

            $allowed_ext = ['pdf'];
            $filename = $_FILES['file_sipa_apj_gudang']['name'];
            $tmp       = $_FILES['file_sipa_apj_gudang']['tmp_name'];

            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed_ext)) {
                throw new Exception("Format file harus PDF!");
            }

            if ($_FILES['file_sipa_apj_gudang']['size'] > 2 * 1024 * 1024) {
                throw new Exception("Ukuran file maksimal 2 MB!");
            }

            // Nama file baru
            $file_baru = "SIPA_" . time() . "_" . rand(100, 999) . "." . $ext;

            // Folder upload
            $upload_path = "../../uploads/sipa_apj_gudang/";

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            // Upload file baru
            if (!move_uploaded_file($tmp, $upload_path . $file_baru)) {
                throw new Exception("Gagal meng-upload file!");
            }

            // Hapus file lama
            if (!empty($file_lama) && file_exists($upload_path . $file_lama)) {
                unlink($upload_path . $file_lama);
            }
        }

        // ==========================================
        //                UPDATE DATA
        // ==========================================

        $stmt = $conn->prepare("
            UPDATE tb_gudang SET 
                nama_gudang = ?, 
                alamat_gudang = ?, 
                no_sipa_apj_gudang = ?,
                tgl_sipa_apj_gudang = ?,
                file_sipa_apj_gudang = ?
            WHERE id_gudang = ?
        ");

        $stmt->bind_param(
            "sssssi",
            $nama,
            $alamat,
            $no_sipa,
            $tgl_sipa,
            $file_baru,
            $id
        );

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui!']);
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
