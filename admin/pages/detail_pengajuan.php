<?php
// Pastikan path ini benar
include '../layouts/init.php';
include '../layouts/header.php';
?>
<?php
$connPath = __DIR__ . '/../../conf/conn.php';

// Pastikan koneksi ($conn) tersedia dari init.php

if (isset($_GET['id'])) {
    $id_dok = $_GET['id'];

    // 1. Ambil Data Dokumen Utama dan JOIN dengan Data Perusahaan
    // Data Perusahaan (P) dan Data Dokumen (D)
    $sql_main = "
        SELECT D.*, P.nama_perusahaan, P.email, P.no_wa_pic
        FROM tb_dokumen D
        JOIN tb_perusahaan P ON D.id_perusahaan = P.id_perusahaan
        WHERE D.id_dok = ?
    ";
    $stmt_main = $conn->prepare($sql_main);
    $stmt_main->bind_param("i", $id_dok);
    $stmt_main->execute();
    $result_main = $stmt_main->get_result();

    if ($result_main->num_rows > 0) {
        $data_dokumen = $result_main->fetch_assoc();
        $id_perusahaan = $data_dokumen['id_perusahaan'];
    } else {
        echo "Data dokumen tidak ditemukan.";
        exit;
    }

    // 2. Ambil Histori Log Dokumen
    $sql_log = "
    SELECT 
        L.*, 
        A.nama AS nama_admin,
        P.nama_perusahaan AS nama_perusahaan
        FROM tb_dokumen_log L
        LEFT JOIN tb_admin A ON L.id_admin = A.id_admin
        LEFT JOIN tb_perusahaan P ON L.id_perusahaan = P.id_perusahaan
        WHERE L.id_dok = ?
        ORDER BY L.action_time DESC
    ";

    $stmt_log = $conn->prepare($sql_log);
    $stmt_log->bind_param("i", $id_dok);
    $stmt_log->execute();
    $result_log = $stmt_log->get_result();
    $log_history = $result_log->fetch_all(MYSQLI_ASSOC);

    // 3. Ambil Nama Admin jika id_admin ada di log (tambahan opsional)
    // Jika Anda ingin menampilkan nama admin, Anda perlu JOIN ke tabel user/admin
    // Untuk saat ini, kita hanya akan menampilkan id_admin.

} else {
    echo "ID dokumen tidak disertakan di URL.";
    exit;
}
?>

<div id="content">
    <?php include '../layouts/topbar.php'; ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Dokumen #<?= htmlspecialchars($data_dokumen['id_dok']) ?></h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Data Perusahaan</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th style="width: 250px;">ID Perusahaan</th>
                        <td>: <?= htmlspecialchars($id_perusahaan) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Perusahaan</th>
                        <td>: <strong><?= htmlspecialchars($data_dokumen['nama_perusahaan']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Email PIC</th>
                        <td>: <?= htmlspecialchars($data_dokumen['email']) ?></td>
                    </tr>
                    <tr>
                        <th>No. WA PIC</th>
                        <td>: <?= htmlspecialchars($data_dokumen['no_wa_pic']) ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Pengajuan</th>
                        <td>: <span class="badge badge-info"><?= htmlspecialchars($data_dokumen['jenis_pengajuan']) ?></span></td>
                    </tr>
                    <tr>
                        <th>Status Dokumen</th>
                        <td>: <span class="badge badge-warning"><?= htmlspecialchars($data_dokumen['status'] ?? 'Menunggu') ?></span></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td>: <?= date('d M Y H:i:s', strtotime($data_dokumen['tanggal_pengajuan'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Detail Dokumen Pengajuan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>Nama File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Surat Permohonan</td>
                            <td><?= htmlspecialchars($data_dokumen['upload_suratpermohonan']) ?></td>
                            <td><a href="../../../uploads/<?= htmlspecialchars($data_dokumen['upload_suratpermohonan']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a></td>
                        </tr>
                        <tr>
                            <td>Surat Pernyataan</td>
                            <td><?= htmlspecialchars($data_dokumen['upload_suratpernyataan']) ?></td>
                            <td><a href="../../../uploads/<?= htmlspecialchars($data_dokumen['upload_suratpernyataan']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a></td>
                        </tr>
                        <?php if ($data_dokumen['upload_denahlama']): ?>
                            <tr>
                                <td>Denah Lama (Perubahan Denah)</td>
                                <td><?= htmlspecialchars($data_dokumen['upload_denahlama']) ?></td>
                                <td><a href="../../../uploads/<?= htmlspecialchars($data_dokumen['upload_denahlama']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td>Denah Baru/Yang Diajukan</td>
                            <td><?= htmlspecialchars($data_dokumen['upload_denahbaru']) ?></td>
                            <td><a href="../../../uploads/<?= htmlspecialchars($data_dokumen['upload_denahbaru']) ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a></td>
                        </tr>

                        <?php if (!empty($data_dokumen['catatan'])): ?>
                            <tr>
                                <td colspan="3"><strong>Catatan User:</strong> <?= htmlspecialchars($data_dokumen['catatan']) ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h3 class="m-0 font-weight-bold text-primary">Histori Dokumen (Aktivitas)</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($log_history)): ?>
                    <div class="timeline">
                        <?php foreach ($log_history as $log): ?>
                            <div class="timeline-item">
                                <span class="text-xs text-muted">
                                    <?= date('d M Y H:i:s', strtotime($log['action_time'])) ?>
                                </span>

                                <p class="mb-1">

                                    <!-- Debug perusahaan -->
                                <pre><?php print_r($log['nama_perusahaan']); ?></pre>

                                <i class="fas fa-clock text-info mr-2"></i>
                                <?= htmlspecialchars($log['description']) ?>

                                <?php if (!empty($log['id_admin'])): ?>
                                    <!-- Tampilkan nama admin -->
                                    <small class="text-secondary">
                                        (Oleh Admin: <?= htmlspecialchars($log['nama_admin']) ?>)
                                    </small>
                                <?php else: ?>
                                    <!-- Tampilkan nama perusahaan -->
                                    <small class="text-secondary">
                                        (Oleh Perusahaan: <?= htmlspecialchars($log['nama_perusahaan']) ?>)
                                    </small>
                                <?php endif; ?>

                                </p>
                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada catatan aktivitas untuk dokumen ini.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include '../layouts/footer.php'; ?>