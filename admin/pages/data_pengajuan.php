<?php
include '../layouts/init.php';
include '../layouts/header.php';
?>

<?php
$sql = "
SELECT d.*, p.nama_perusahaan, a.nama AS nama_admin
FROM tb_dokumen d
LEFT JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
LEFT JOIN tb_admin a ON d.id_admin = a.id_admin
ORDER BY d.tanggal_pengajuan DESC
";
$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();

// --- Ambil petugas dari tabel user ---
$sql_petugas = "SELECT id_admin, nama FROM tb_admin WHERE role = 'petugas' ORDER BY nama ASC";
$stmt_petugas = $conn->prepare($sql_petugas);
$stmt_petugas->execute();
$data_petugas = $stmt_petugas->get_result();

?>
<div id="content">
    <?php include '../layouts/topbar.php'; ?>
    <div class="container-fluid">
        <h3 class="mb-4">Data Pengajuan Dokumen</h3>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-fw fa-table mr-1"></i> Daftar Pengajuan
                </h5>
            </div>


            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tampilPengajuan" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="py-3">No</th>
                                    <th class="py-3">Perusahaan</th>
                                    <th class="py-3">Jenis</th>
                                    <th class="py-3">Tanggal Pengajuan</th>
                                    <th class="py-3">Dokumen</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3">Disposisi</th>
                                    <th class="py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result->fetch_assoc()):
                                    // Path files
                                    $paths = [
                                        'surat_permohonan' => $row['upload_suratpermohonan'],
                                        'surat_pernyataan' => $row['upload_suratpernyataan'],
                                        'denah_lama' => $row['upload_denahlama'],
                                        'denah_baru' => $row['upload_denahbaru']
                                    ];
                                ?>
                                    <tr>
                                        <td class="font-weight-bold align-middle"><?= $no++ ?></td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold text-dark"><?= htmlspecialchars($row['nama_perusahaan']) ?></div>
                                        </td>
                                        <td class="align-middle">
                                            <?= htmlspecialchars($row['jenis_pengajuan']) ?>
                                        </td>
                                        <td class="align-middle text-nowrap">
                                            <i class="far fa-calendar-alt mr-1 text-muted"></i>
                                            <?= date('d/m/Y', strtotime($row['tanggal_pengajuan'])) ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-paperclip mr-1"></i>Lihat Dokumen
                                                </button>
                                                <div class="dropdown-menu p-2">
                                                    <?php
                                                    $labels = [
                                                        'surat_permohonan' => 'Surat Permohonan',
                                                        'surat_pernyataan' => 'Surat Pernyataan',
                                                        'denah_lama' => 'Denah Lama',
                                                        'denah_baru' => 'Denah Baru'
                                                    ];
                                                    foreach ($paths as $key => $file):
                                                        if (!empty($file)):
                                                            // Asumsi path file adalah dari root web
                                                            $web_path = '../../uploads/' . basename($file);
                                                    ?>
                                                            <a class="dropdown-item d-flex align-items-center"
                                                                href="<?= $web_path ?>" target="_blank">
                                                                <i class="fas fa-file-pdf text-danger mr-2"></i>
                                                                <?= $labels[$key] ?>
                                                            </a>
                                                    <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <?php
                                            $statusConfig = [
                                                0 => ['class' => 'secondary', 'icon' => 'clock', 'text' => 'Proses'],
                                                1 => ['class' => 'warning', 'icon' => 'list-alt', 'text' => 'Revisi'],
                                                2 => ['class' => 'primary', 'icon' => 'file-contract', 'text' => 'Menunggu Persetujuan'],
                                                3 => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Selesai']
                                            ];
                                            $status = $row['status'];
                                            $config = $statusConfig[$status] ?? $statusConfig[0]; // Default ke Proses jika status tidak ada
                                            ?>
                                            <span class="badge badge-<?= $config['class'] ?> px-3 py-2">
                                                <i class="fas fa-<?= $config['icon'] ?> mr-1"></i>
                                                <?= $config['text'] ?>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <?php if ($row['id_admin'] == null): ?>
                                                <span class="badge badge-light border px-3 py-2 text-warning">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Belum Didisposisi
                                                </span>
                                            <?php else: ?>
                                                <div>
                                                    <span class="badge badge-success px-3 py-2 mb-1">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Disposisi ke Petugas
                                                    </span>
                                                    <div class="small text-muted mt-1">
                                                        <i class="fas fa-user-tie mr-1"></i>
                                                        <?= $row['nama_admin'] ?? 'Tidak Dikenal' ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-primary btn-sm px-3 py-2 mr-1 btn-verify"
                                                    data-toggle="modal"
                                                    data-target="#verificationModal"
                                                    data-id="<?= $row['id_dok'] ?>"
                                                    data-status="<?= htmlspecialchars($row['status']) ?>"
                                                    data-catatan="<?= htmlspecialchars($row['catatan'] ?? '') ?>"
                                                    title="Verifikasi/Ubah Status">
                                                    <i class="fas fa-edit fa-sm"></i>
                                                </button>

                                                <a class="btn btn-info btn-sm px-3 py-2 mr-1"
                                                    href="detail_pengajuan.php?id=<?= $row['id_dok'] ?>"
                                                    title="Detail">
                                                    <i class="fas fa-eye fa-sm"></i>
                                                </a>

                                                <?php if (isset($admin['role']) && $admin['role'] === 'supervisor'): ?>
                                                    <?php if ($row['id_admin'] == null): ?>
                                                        <button class="btn btn-warning btn-sm px-3 py-2"
                                                            data-toggle="modal"
                                                            data-target="#modalDisposisi"
                                                            data-id="<?= $row['id_dok'] ?>"
                                                            title="Disposisi">
                                                            <i class="fas fa-paper-plane fa-sm"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-inbox fa-4x text-gray-300"></i>
                        </div>
                        <h4 class="text-gray-700 mb-3">Belum ada data pengajuan dokumen</h4>
                        <p class="text-muted mb-4">Saat ini tidak ada pengajuan dokumen yang perlu diverifikasi</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- Success alert (Bootstrap 4 style) - awalnya toast BS5, diganti dengan alert sederhana -->
<div id="successAlert" class="alert alert-success alert-dismissible fade" role="alert" style="position: fixed; top:20px; right:20px; z-index: 1060; display:none;">
    <strong>Sukses!</strong> <span id="successAlertText">Operasi berhasil.</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!--Modal Disposisi (Bootstrap 4) -->
<div class="modal fade" id="modalDisposisi" tabindex="-1" role="dialog" aria-labelledby="modalDisposisiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDisposisiLabel">Disposisi Pengajuan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <form id="formDisposisi" method="POST" action="proses_disposisi.php">
                <div class="modal-body">

                    <!-- Input ID Pengajuan (hidden) -->
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan">

                    <!-- Pilih Petugas -->
                    <div class="form-group">
                        <label for="petugas">Disposisi ke</label>
                        <select class="form-control" name="petugas" id="petugas" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php while ($row = $data_petugas->fetch_assoc()) : ?>
                                <option value="<?= $row['id_admin']; ?>"><?= htmlspecialchars($row['nama']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Catatan Disposisi -->
                    <div class="form-group">
                        <label for="cat_disposisi">Catatan Disposisi</label>
                        <textarea name="cat_disposisi" id="cat_disposisi" class="form-control" rows="3" placeholder="Tuliskan catatan..." required></textarea>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan Disposisi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Verification Modal (Bootstrap 4) -->
<div class="modal fade" id="verificationModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle mr-2"></i> Verifikasi Pengajuan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <form id="verificationForm" enctype="multipart/form-data" class="p-4">
                <div class="form-group">
                    <label>Status Verifikasi</label>
                    <select class="form-control" id="verificationStatus" name="status" required onchange="toggleUploadFields(this.value)">
                        <option value="0">Proses</option>
                        <option value="1">Revisi</option>
                        <option value="2">Menunggu Persetujuan</option>
                        <option value="3">Selesai</option>
                    </select>
                </div>

                <div id="uploadSection" class="d-none bg-light p-3 mb-3 rounded border">
                    <h6 class="text-primary mb-3"><i class="fas fa-upload mr-1"></i> Upload Dokumen Final</h6>

                    <div class="form-group">
                        <label class="small font-weight-bold">Surat Persetujuan (TTE)</label>
                        <input type="file" class="form-control" id="fileSurat" name="surat_persetujuan" accept=".pdf">
                        <small class="text-muted">Format: PDF (Max 2MB)</small>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Denah Final (ACC)</label>
                        <input type="file" class="form-control" id="fileDenah" name="denah_acc" accept=".pdf">
                        <small class="text-muted">Format: PDF/JPG (Max 5MB)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan Verifikasi</label>
                    <textarea class="form-control" id="verificationNote" name="catatan" rows="3" placeholder="Berikan catatan verifikasi..." required></textarea>
                </div>

                <input type="hidden" id="submissionId" name="id">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$script_js = <<<HTML
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet">
<link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
<script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    // 1. Tangani Modal Verifikasi (Bootstrap 4 + jQuery)
    $('#verificationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var submissionId = button.data('id') || '';
        var currentStatus = button.data('status') || '0';
        var currentNote = button.data('note') || '';

        console.log(submissionId);
        // Isi ke dalam input modal
        $('#submissionId').val(submissionId);
        $('#verificationStatus').val(currentStatus);
        $('#verificationNote').val(currentNote);

        // Trigger fungsi toggle agar tampilan upload sesuai status saat ini
        toggleUploadFields(currentStatus);
    });

    // 2. Tangani Modal Disposisi (Bootstrap 4)
    $('#modalDisposisi').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id_pengajuan = button.data('id') || '';
        $('#id_pengajuan').val(id_pengajuan);
    });

    // 3. Fungsi Toggle Upload (Show/Hide)
    function toggleUploadFields(status) {
        var uploadSection = $('#uploadSection');
        var fileSurat = $('#fileSurat');
        var fileDenah = $('#fileDenah');

        if (!uploadSection.length) return;

        if (status == '3') { // Status Selesai
            uploadSection.removeClass('d-none');
            fileSurat.attr('required', 'required');
            fileDenah.attr('required', 'required');
        } else {
            uploadSection.addClass('d-none');
            fileSurat.removeAttr('required');
            fileDenah.removeAttr('required');
            if (fileSurat.length) fileSurat.val('');
            if (fileDenah.length) fileDenah.val('');
        }
    }

    // 4. Tangani Submit Form Verifikasi (AJAX)
    $('#verificationForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var saveButton = $(form).find('button[type="submit"]');
        var originalContent = saveButton.html();

        saveButton.html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
        saveButton.prop('disabled', true);

        var formData = new FormData(form);
        formData.append('action', 'update_verification');

        fetch('proses_verifikasi.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.msg || 'Verifikasi berhasil disimpan.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    $('#verificationModal').modal('hide');
                    // optional: tampilkan alert kecil
                    // $('#successAlertText').text(data.msg || 'Verifikasi berhasil disimpan.');
                    // $('#successAlert').show().addClass('show');
                    location.reload();
                });
            } else {
                Swal.fire('Gagal!', data.msg || 'Terjadi kesalahan.', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan koneksi server.', 'error');
        })
        .finally(function() {
            saveButton.html(originalContent);
            saveButton.prop('disabled', false);
        });
    });

    // 5. Tangani Submit Form Disposisi (AJAX)
    $('#formDisposisi').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var saveButton = $(form).find('button[type="submit"]');
        var originalContent = saveButton.html();

        saveButton.html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
        saveButton.prop('disabled', true);

        var formData = new FormData(form);
        formData.append('action', 'disposisi');

        fetch('proses_disposisi.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response){ return response.json(); })
        .then(function(data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.msg || 'Disposisi berhasil disimpan.',
                    timer: 1500,
                    showConfirmButton: false
                }).then(function() {
                    $('#modalDisposisi').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire('Gagal!', data.msg || 'Terjadi kesalahan.', 'error');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan koneksi server.', 'error');
        })
        .finally(function() {
            saveButton.html(originalContent);
            saveButton.prop('disabled', false);
        });
    });

    // 6. Inisialisasi DataTables
    \$(document).ready(function() {
        if (\$('#tampilPengajuan').length) {
            \$('#tampilPengajuan').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                },
                responsive: true
            });
        }
    });
</script>
HTML;
?>
<?php include '../layouts/footer.php'; ?>