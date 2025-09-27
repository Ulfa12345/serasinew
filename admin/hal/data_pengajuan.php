<?php
$sql = "
SELECT d.*, p.nama_perusahaan 
FROM tb_dokumen d
JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
ORDER BY d.tanggal_pengajuan DESC
";
$stmt = $conn->prepare($sql);
//$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
?>
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
                            $server_path_sipa = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_sipa']);
                            $web_path_sipa = '/user/pages/dokumen/uploads/' . basename($row['upload_sipa']);

                            $server_path_sph = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);
                            $web_path_sph = '/user/pages/dokumen/uploads/' . basename($row['upload_suratpermohonan']);

                            $server_path_spn = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);
                            $web_path_spn = '/user/pages/dokumen/uploads/' . basename($row['upload_suratpernyataan']);

                            $server_path_pbf = $_SERVER['DOCUMENT_ROOT'] . '/user/pages/dokumen/uploads/' . basename($row['upload_ijin_pbf']);
                            $web_path_pbf = '/user/pages/dokumen/uploads/' . basename($row['upload_ijin_pbf']);

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
                                        <?php // Cek dan tampilkan setiap dokumen jika ada 
                                        ?>
                                        <li><a href="<?= $web_path_sipa ?>" target="_blank">SIPA</a></li>
                                        <li><a href="<?= $web_path_sph ?>" target="_blank">Surat Permohonan</a></li>
                                        <li><a href="<?= $web_path_spn ?>" target="_blank">Surat Pernyataan</a></li>
                                        <li><a href="<?= $web_path_pbf ?>" target="_blank">Ijin PBF</a></li>
                                        <?php if (!empty($row['upload_denahlama'])): ?>
                                            <li><a href="<?= $web_path_dnhlma ?>" target="_blank">Denah Lama</a></li>
                                        <?php endif; ?>
                                        <li><a href="<?= $web_path_dnhbru ?>" target="_blank">Denah Baru</a></li>
                                    </ul>
                                </td>
                                <td><?php if ($row['status'] == 0) : ?>
                                        <span class="badge badge-dark">Proses Evaluasi</span>
                                    <?php elseif ($row['status'] == 1): ?>
                                        <span class="badge badge-primary">Selesai</span>
                                    <?php elseif ($row['status'] == 2): ?>
                                        <span class="badge badge-danger">Revisi</span>
                                    <?php endif ?>
                                <td>
                                    <button class="btn btn-warning btn-verify"
                                        data-bs-toggle="modal"
                                        data-bs-target="#verificationModal"
                                        data-id="<?= $row['id_dok'] ?>"
                                        data-status="<?= $row['status'] ?? 1 ?>"
                                        data-note="<?= $row['catatan_verifikasi'] ?? '' ?>">
                                        <i class="fas fa-edit me-1"></i> Verifikasi
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

<!-- Verification Modal (Sederhana) -->
<div class="modal fade" id="verificationModal" tabindex="-1" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Verifikasi Pengajuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="verificationForm">
                    <div class="mb-3">
                        <label class="form-label">Status Verifikasi</label>
                        <select class="form-control" id="verificationStatus" required>
                            <option value="0">Proses Evaluasi</option>
                            <option value="1">Selesai</option>
                            <option value="2">Revisi</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan Verifikasi</label>
                        <textarea class="form-control" id="verificationNote" rows="3" placeholder="Berikan catatan verifikasi..." required></textarea>
                    </div>

                    <input type="hidden" id="submissionId">

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header toast-success">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Verifikasi berhasil disimpan!
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/ajax@0.0.4/lib/ajax.min.js"></script>


<link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    // Tangani ketika modal ditampilkan
    const verificationModal = document.getElementById('verificationModal');
    verificationModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;

        // Ambil data dari atribut data-*
        const submissionId = button.getAttribute('data-id');
        const currentStatus = button.getAttribute('data-status');
        const currentNote = button.getAttribute('data-note');

        // Isi data di modal
        document.getElementById('submissionId').value = submissionId;
        document.getElementById('verificationStatus').value = currentStatus;
        document.getElementById('verificationNote').value = currentNote;
    });

    // Tangani submit form
    document.getElementById('verificationForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submissionId = document.getElementById('submissionId').value;
        const status = document.getElementById('verificationStatus').value;
        const note = document.getElementById('verificationNote').value;

        // Tampilkan indikator loading
        const saveButton = this.querySelector('button[type="submit"]');
        const originalContent = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        saveButton.disabled = true;

        // Kirim data ke server menggunakan AJAX
        const formData = new FormData();
        formData.append('id', submissionId);
        formData.append('status', status);
        formData.append('note', note);
        formData.append('action', 'update_verification');

        fetch('hal/proses_verifikasi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Verifikasi berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 1000
                    });

                    setTimeout(() => {
                        // Tutup modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('verificationModal'));
                        modal.hide();

                        // Reload jika memang dibutuhkan
                        location.reload();
                    }, 1000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal menyimpan: ' + data.msg
                    });
                }
            })
            .catch((error) => {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan!',
                });
            })
            .finally(() => {
                saveBtn.innerHTML = originalContent;
                saveBtn.disabled = false;
            });
    });


    $(document).ready(function() {
        $('#tampilPengajuan').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            responsive: true,
            info: true,
            ordering: true,
            paging: true,
        });
    });
</script>