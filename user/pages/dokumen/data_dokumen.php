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
    <h3 class="mb-4">Data Pengajuan Dokumen</h3>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Jenis Pengajuan</th>
                            <th>Tanggal Diajukan</th>
                            <th>Dokumen</th>
                            <th>Aksi</th>
                            <th>Status</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()):
                            // Ambil path file untuk setiap row
                            $server_path_sipa = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_sipa']);
                            $web_path_sipa = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_sipa']);

                            $server_path_sph = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);
                            $web_path_sph = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);

                            $server_path_spn = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);
                            $web_path_spn = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);

                            $server_path_pbf = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_ijin_pbf']);
                            $web_path_pbf = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_ijin_pbf']);

                            $server_path_dnhlma = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_denahlama']);
                            $web_path_dnhlma = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_denahlama']);

                            $server_path_dnhbru = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_denahbaru']);
                            $web_path_dnhbru = '/serasi/user/pages/dokumen/uploads/' . basename($row['upload_denahbaru']);

                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['jenis_pengajuan']) ?></td>
                                <td><?= $row['tanggal_pengajuan'] ?></td>
                                <td>
                                    <ul style="padding-left: 16px;">
                                        <?php // Cek dan tampilkan setiap dokumen jika ada 
                                        ?>
                                        <li><a href="<?= $web_path_sipa ?>" target="_blank">SIPA</a></li>
                                        <li><a href="<?= $web_path_sph ?>" target="_blank">Surat Permohonan</a></li>
                                        <li><a href="<?= $web_path_spn ?> ?>" target="_blank">Surat Pernyataan</a></li>
                                        <li><a href="<?= $web_path_pbf ?> ?>" target="_blank">Ijin PBF</a></li>
                                        <?php if (!empty($row['upload_denahlama'])): ?>
                                            <li><a href="<?= $web_path_dnhlma ?> ?>" target="_blank">Denah Lama</a></li>
                                        <?php endif; ?>
                                        <li><a href="<?= $web_path_dnhbru ?> ?>" target="_blank">Denah Baru</a></li>
                                    </ul>
                                </td>
                                <td><a href='edit_dokumen.php?id=<?= $row['id_dokumen'] ?>' class='btn btn-warning'>Edit</a></td>
                                <td><?php if ($row['status'] == 0) : ?>
                                        <span class="badge badge-dark">Proses Evaluasi</span>
                                    <?php elseif ($row['status'] == 1): ?>
                                        <span class="badge badge-primary">Selesai</span>
                                    <?php elseif ($row['status'] == 2): ?>
                                        <span class="badge badge-danger">Revisi</span>
                                    <?php endif ?>
                                <td><?= $row['catatan'] ?></td>
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