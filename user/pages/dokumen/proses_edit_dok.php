<?php
session_start();

include "koneksi.php";

// Pastikan ada id yang akan diedit
if (!isset($_POST['id'])) {
    die("ID tidak ditemukan.");
}

$id = $_POST['id']; // id yang diberlakukan untuk proses edit

// File yang diterima
$sipa = $_FILES['sipa'];
$izin_pbf = $_FILES['izin_pbf'];
$surat_permohonan = $_FILES['surat_permohonan'];
$surat_pernyataan = $_FILES['surat_pernyataan'];
$denah = $_FILES['denah_new']; // sesuai form upload denah


// Fungsi untuk upload
function uploadFile($file, $folder = 'uploads') {
    if ($file['error'] == 0) {
        $filename = time() . "_" . basename($file['name']);
        $path = $folder . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $path)) {
            return $path;
        }
    }
    return '';
}

$sipa_file = uploadFile($sipa);
$izin_pbf_file = uploadFile($izin_pbf);
$surat_permohonan_file = uploadFile($surat_permohonan);
$surat_pernyataan_file = uploadFile($surat_pernyataan);
$denah_file = uploadFile($denah);

// Update di database
$stmt = $conn->prepare("UPDATE dokumen SET sipa = ?, izin_pbf = ?, surat_permohonan = ?, surat_pernyataan = ?, denah = ? WHERE id = ?");
$stmt->bind_param("sssssi", $sipa_file, $izin_pbf_file, $surat_permohonan_file, $surat_pernyataan_file, $denah_file, $id);

if ($stmt->execute()) {
    echo "<script>alert('Data berhasil diupdate');window.location='index.php'</script>";
} else {
    echo "<script>alert('Gagal menyimpan');window.location='index.php'</script>";
}

$stmt->close();
$conn->close();

?>
