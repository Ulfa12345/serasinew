<?php
$id_perusahaan = $_SESSION['id_perusahaan'] ?? null;

if (!$id_perusahaan) {
    die("Anda harus login terlebih dahulu.");
}

$sql = "
SELECT d.*, p.nama_perusahaan 
FROM tb_dokumen d
JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
WHERE d.id_perusahaan = ?
ORDER BY d.tanggal_pengajuan DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="h3 mb-1 fw-bold text-dark">Data Pengajuan Dokumen</h1>
        <p class="text-muted">Kelola informasi pengajuan dokumen Anda</p>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar pengajuan dokumen</span>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Jenis Pengajuan</th>
                            <th>Tanggal Diajukan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()):
                            //serasi/serasinew/uploads
                            // Ambil path file untuk setiap row

                            //$server_path_sipa = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_sipa']);
                            //$web_path_sipa = '/serasinew/uploads/' . basename($row['upload_sipa']);

                            $server_path_sph = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_suratpermohonan']);
                            $web_path_sph = '/serasinew/uploads/' . basename($row['upload_suratpermohonan']);

                            $server_path_spn = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_suratpernyataan']);
                            $web_path_spn = '/serasinew/uploads/' . basename($row['upload_suratpernyataan']);

                            //$server_path_pbf = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_ijin_pbf']);
                            //$web_path_pbf = '/serasinew/uploads/' . basename($row['upload_ijin_pbf']);

                            $server_path_dnhlma = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_denahlama']);
                            $web_path_dnhlma = '/serasinew/uploads/' . basename($row['upload_denahlama']);

                            $server_path_dnhbru = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/uploads/' . basename($row['upload_denahbaru']);
                            $web_path_dnhbru = '/serasinew/uploads/' . basename($row['upload_denahbaru']);

                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['jenis_pengajuan']) ?></td>
                                <td><?= $row['tanggal_pengajuan'] ?></td>
                                <td>
                                    <ul style="padding-left: 16px;">
                                        <?php // Cek dan tampilkan setiap dokumen jika ada 
                                        ?>
                                        <li><a href="<?= $web_path_sph ?>" target="_blank">Surat Permohonan</a></li>
                                        <li><a href="<?= $web_path_spn ?>" target="_blank">Surat Pernyataan</a></li>
                                        <?php if (!empty($row['upload_denahlama'])): ?>
                                            <li><a href="<?= $web_path_dnhlma ?>" target="_blank">Denah Lama</a></li>
                                        <?php endif; ?>
                                        <li><a href="<?= $web_path_dnhbru ?>" target="_blank">Denah Baru</a></li>
                                    </ul>
                                </td>
                                <td><?php if ($row['status'] == 0) : ?>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-clock"></i>&nbsp; Proses
                                        </span>

                                    <?php elseif ($row['status'] == 1): ?>
                                        <span class="badge badge-warning">
                                            <i class="fas fa-list-alt"></i>&nbsp; Revisi
                                        </span>

                                    <?php elseif ($row['status'] == 2): ?>
                                        <span class="badge badge-primary">
                                            <i class="fas fa-file-contract"></i>&nbsp; Menunggu Persetujuan
                                        </span>

                                    <?php elseif ($row['status'] == 3): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i>&nbsp; Selesai
                                        </span>

                                    <?php endif ?>
                                <td><?= $row['catatan'] ?></td>
                                <td>
                                    <?php if ($row['status'] == '1') : ?>
                                        <a href="index.php?page=form_edit_dok&id=<?= $row['id_dok'] ?>" class="btn btn-warning btn-sm">Edit</a>

                                    <?php elseif ($row['status'] == '3') : ?>
                                        <?php if ($row['surat_persetujuan'] && $row['surat_persetujuan'] != 'Tidak ada') : ?>
                                           <a href="../uploads/<?= $row['surat_persetujuan'] ?>"
                                                class="btn btn-success btn-sm mb-1"
                                                target="_blank" download>
                                                Surat Persetujuan
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($row['denah_acc'] && $row['denah_acc'] != 'Tidak ada') : ?>
                                            <a href="../uploads/<?= $row['denah_acc'] ?>"
                                                class="btn btn-info btn-sm mb-1"
                                                target="_blank" download>
                                                Denah ACC
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">Belum ada data pengajuan dokumen.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
//$stmt->close();
$conn->close();
?>