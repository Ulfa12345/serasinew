<?php

$id_dok = $_GET['id'] ?? 0;

$sql = "SELECT * FROM tb_dokumen WHERE id_dok = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_dok);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
?>

<div class="container-fluid">
    <div class="card shadow-sm mt-4">
        <div class="card-header text-white">
            <h4 class="mb-0">Edit Data Dokumen</h4>
        </div>

        <div class="card-body">

            <form action="update_dokumen.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id_dok" value="<?= $data['id_dok']; ?>">

                <!-- Jenis Pengajuan -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Jenis Pengajuan</label>
                    <input type="text" name="jenis_pengajuan" class="form-control"
                        value="<?= $data['jenis_pengajuan']; ?>" required>
                </div>

                <!-- Surat Permohonan -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Upload Surat Permohonan <small>(kosongkan jika tidak diubah)</small></label>
                    <input type="file" name="upload_suratpermohonan" class="form-control">
                    <small class="text-muted">File saat ini: <?= $data['upload_suratpermohonan']; ?></small>
                </div>

                <!-- Surat Pernyataan -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Upload Surat Pernyataan <small>(kosongkan jika tidak diubah)</small></label>
                    <input type="file" name="upload_suratpernyataan" class="form-control">
                    <small class="text-muted">File saat ini: <?= $data['upload_suratpernyataan']; ?></small>
                </div>

                <!-- Denah Baru -->
                <div class="form-group mb-3">
                    <label class="fw-bold">Upload Denah Baru <small>(kosongkan jika tidak diubah)</small></label>
                    <input type="file" name="upload_denahbaru" class="form-control">
                    <small class="text-muted">File saat ini: <?= $data['upload_denahbaru']; ?></small>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>

        </div>
    </div>
</div>
