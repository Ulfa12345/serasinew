<?php
session_start();
require_once '../../conf/conn.php'; // Sesuaikan path

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Ambil data dari form
        $data = [
            'nama_perusahaan' => $_POST['nama_perusahaan'],
            'alamat_perusahaan' => $_POST['alamat_perusahaan'],
            'penanggung_jawab' => $_POST['penanggung_jawab'],
            'no_wa_pic' => $_POST['no_wa_pic'],
            'email' => $_POST['email']
        ];

        // Validasi data
        foreach ($data as $key => $value) {
            if (empty($value)) {
                throw new Exception("Field $key wajib diisi!");
            }
        }

        // Update database
        $stmt = $conn->prepare("UPDATE tb_perusahaan SET 
            nama_perusahaan = ?,
            alamat_perusahaan = ?,
            nama_pic = ?,
            no_wa_pic = ?,
            email = ?
            WHERE id_perusahaan = ?");

        $stmt->bind_param("sssssi",
            $data['nama_perusahaan'],
            $data['alamat_perusahaan'],
            $data['penanggung_jawab'],
            $data['no_hp'],
            $data['email'],
            $_SESSION['id_perusahaan']
        );

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            throw new Exception("Gagal update data: " . $stmt->error);
        }

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
?>