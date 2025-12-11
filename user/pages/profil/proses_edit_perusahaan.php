<?php
session_start();
include "../../../conf/conn.php";

// Pastikan user login dan punya id_perusahaan
if (!isset($_SESSION['id_perusahaan'])) {
    echo json_encode(["status" => "error", "message" => "Session perusahaan tidak ditemukan"]);
    exit;
}

$id_perusahaan = $_SESSION['id_perusahaan'];

// Folder upload
$upload_dir = "../../uploads/";

// die(var_dump($_POST));

// Fungsi upload file
function uploadFile($field_name, $upload_dir, $old_file = "")
{
    if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] === 0) {
        $allowed_ext = ['pdf'];

        $file_name = $_FILES[$field_name]['name'];
        $file_tmp  = $_FILES[$field_name]['tmp_name'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_ext)) {
            return $old_file; // kalau ekstensi salah, ignore
        }

        $new_name = $field_name . "_" . time() . "." . $ext;
        $destination = $upload_dir . $new_name;

        if (move_uploaded_file($file_tmp, $destination)) {
            return $new_name;
        }
    }
    return $old_file;
}

// Ambil data lama
$q_old = mysqli_query($conn, "SELECT * FROM tb_perusahaan WHERE id_perusahaan='$id_perusahaan'");
$data_lama = mysqli_fetch_assoc($q_old);

// Upload file (jika ada)
$upload_nib      = uploadFile('upload_nib', $upload_dir, $data_lama['upload_nib']);
$upload_ijin_pbf = uploadFile('upload_ijin_pbf', $upload_dir, $data_lama['upload_ijin_pbf']);
$upload_cdob     = uploadFile('upload_cdob', $upload_dir, $data_lama['upload_cdob']);
$upload_sipa     = uploadFile('upload_sipa', $upload_dir, $data_lama['upload_sipa']);

// Ambil input text/date
$nomor_cdob        = $_POST['no_cdob'] ?? $data_lama['nomor_cdob'];
$tgl_berlaku_cdob  = $_POST['tgl_berlaku_cdob'] ?? $data_lama['tgl_berlaku_cdob'];

$nomor_sipa        = $_POST['no_sipa'] ?? $data_lama['no_sipa'];
$tgl_berlaku_sipa  = $_POST['tgl_berlaku_sipa'] ?? $data_lama['tgl_berlaku_sipa'];

// Query update
$sql = "UPDATE tb_perusahaan SET
            upload_nib='$upload_nib',
            upload_ijin_pbf='$upload_ijin_pbf',
            upload_cdob='$upload_cdob',
            nomor_cdob='$nomor_cdob',
            tgl_berlaku_cdob='$tgl_berlaku_cdob',
            upload_sipa='$upload_sipa',
            no_sipa='$nomor_sipa',
            tgl_berlaku_sipa='$tgl_berlaku_sipa'
        WHERE id_perusahaan='$id_perusahaan'";

if (mysqli_query($conn, $sql)) {
    echo json_encode([
        "status" => "success",
        "message" => "Data perusahaan berhasil diperbarui!",
        "redirect" => "index.php?page=datagudang",
    ]);
    // echo "<script>alert('Data perusahaan berhasil diperbarui'); window.location='index.php?page=dataperusahaan';</script>";
} else {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
    // echo "<script>alert('Gagal update data'); history.back();</script>";
}
