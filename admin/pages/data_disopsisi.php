<?php
include '../layouts/init.php';
include '../layouts/header.php';

// Pastikan user sudah login dan memiliki id_admin
if (!isset($_SESSION['id_admin'])) {
    die("User tidak dikenali (belum login).");
}

$id_admin = $_SESSION['id_admin'];

// Query mengambil dokumen berdasarkan admin yang login
$sql = "
SELECT d.*, p.nama_perusahaan 
FROM tb_dokumen d
JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
WHERE d.id_admin = ?
ORDER BY d.tanggal_pengajuan DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$result = $stmt->get_result();
?>

<div id="content">
    <?php include '../layouts/topbar.php'; ?>
    <div class="container-fluid">
        <h3 class="mb-4">Data Pengajuan Dokumen</h3>
        <div class="card shadow mb-4">
            <div class="card-body">
                <?php if ($result->num_rows > 0): ?>
                    <table class="table table-bordered" id="tampilPengajuan">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>Jenis Pengajuan</th>
                                <th>Tanggal Diajukan</th>
                                <th>Dokumen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()):
                                // Ambil path file untuk setiap row
                                $server_path_sph = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);
                                $web_path_sph = '/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);

                                $server_path_spn = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);
                                $web_path_spn = '/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);

                                $server_path_dnhlma = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_denahlama']);
                                $web_path_dnhlma = '/user/pages/dokumen/uploads/' . basename($row['upload_denahlama']);

                                $server_path_dnhbru = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_denahbaru']);
                                $web_path_dnhbru = '/user/pages/dokumen/uploads/' . basename($row['upload_denahbaru']);
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                                    <td><?= htmlspecialchars($row['jenis_pengajuan']) ?></td>
                                    <td><?= $row['tanggal_pengajuan'] ?></td>
                                    <td>
                                        <ul style="padding-left: 16px;">
                                            <?php // Tampilkan jika path tersedia (jaga dari variable undefined di original)
                                            if (!empty($web_path_sph)): ?>
                                                <li><a href="<?= $web_path_sph ?>" target="_blank">Surat Permohonan</a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($web_path_spn)): ?>
                                                <li><a href="<?= $web_path_spn ?>" target="_blank">Surat Pernyataan</a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($web_path_dnhlma) && !empty($row['upload_denahlama'])): ?>
                                                <li><a href="<?= $web_path_dnhlma ?>" target="_blank">Denah Lama</a></li>
                                            <?php endif; ?>
                                            <?php if (!empty($web_path_dnhbru)): ?>
                                                <li><a href="<?= $web_path_dnhbru ?>" target="_blank">Denah Baru</a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] == 0) : ?>
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
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-verify"
                                            data-toggle="modal"
                                            data-target="#verificationModal"
                                            data-id="<?= $row['id_dok'] ?>"
                                            data-status="<?= $row['status'] ?? 1 ?>"
                                            data-note="<?= htmlspecialchars($row['catatan_verifikasi'] ?? '') ?>">
                                            <i class="fas fa-edit mr-1"></i> Verifikasi
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center py-4">
                <i class="fas fa-exclamation-circle fa-2x mb-3"></i>
                <h4>Belum ada data pengajuan dokumen</h4>
                <p class="mb-0">Saat ini tidak ada pengajuan dokumen yang perlu diverifikasi</p>
            </div>
        <?php endif; ?>
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
                        <input type="file" class="form-control" id="fileSurat" name="file_surat" accept=".pdf">
                        <small class="text-muted">Format: PDF (Max 2MB)</small>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Denah Final (ACC)</label>
                        <input type="file" class="form-control" id="fileDenah" name="file_denah" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF/JPG (Max 5MB)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Catatan Verifikasi</label>
                    <textarea class="form-control" id="verificationNote" name="catatan" rows="3" placeholder="Berikan catatan verifikasi..." required></textarea>
                </div>

                <input type="hidden" id="submissionId" name="id_pengajuan">

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
        var button = $(event.relatedTarget); // Button that triggered the modal
        var submissionId = button.data('id') || '';
        var currentStatus = button.data('status') || '0';
        var currentNote = button.data('note') || '';

        // Isi ke dalam input modal
        $('#submissionId').val(submissionId);
        $('#verificationStatus').val(currentStatus);
        $('#verificationNote').val(currentNote);

        // Trigger fungsi toggle agar tampilan upload sesuai status saat ini
        toggleUploadFields(currentStatus);
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
