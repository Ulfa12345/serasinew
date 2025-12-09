<!-- Form Tambah Gudang Section -->
<div class="container-fluid">
    <div class="page-header">
        <h1 class="h3 mb-1 fw-bold text-dark">Data Gudang</h1>
        <p class="text-muted">Kelola informasi dan gudang Anda</p>
    </div>
    <div class="card shadow mb-4 ">
         <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar data gudang</span>
             <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#tambahGudangModal">
                + Tambah Gudang
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <?php
                if (!isset($_SESSION['id_perusahaan'])) {
                    header("Location: ../login.php");
                    exit();
                }
                $id_perusahaan = $_SESSION['id_perusahaan'];
                $query = "SELECT g.*, p.nama_perusahaan 
                          FROM tb_gudang g
                          INNER JOIN tb_perusahaan p 
                          ON g.id_perusahaan = p.id_perusahaan
                          WHERE g.id_perusahaan = ?
                          ORDER BY g.id_gudang DESC";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_perusahaan);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <table class="table table-bordered table-striped table-hover">
                    <thead class="bg-success text-white">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Alamat</th>
                            <th>File SIPA APJ</th>
                            <th>Nomor SIPA APJ</th>
                            <th>Tgl Berlaku SIPA APJ</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama_gudang']); ?></td>
                                <td><?= htmlspecialchars($row['alamat_gudang']); ?></td>
                                <td class="text-center">
                                    <?php if (!empty($row['file_sipa_apj_gudang'])): ?>
                                        <a href="uploads/sipa_apj_gudang/<?= htmlspecialchars($row['file_sipa_apj_gudang']); ?>" target="_blank" class="btn btn-sm btn-success">
                                            Lihat File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">- Tidak ada file -</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($row['no_sipa_apj_gudang']); ?></td>
                                <td><?= $row['tgl_sipa_apj_gudang']; ?></td>
                                <td class="text-center">
                                    <div class="d-flex p-2">
                                        <button class="btn btn-warning btn-sm btn-edit mr-2 p-2"
                                            data-id="<?= $row['id_gudang']; ?>"
                                            data-nama="<?= htmlspecialchars($row['nama_gudang']); ?>"
                                            data-alamat="<?= htmlspecialchars($row['alamat_gudang']); ?>"
                                            data-no_sipa="<?= $row['no_sipa_apj_gudang']; ?>"
                                            data-tgl_sipa="<?= $row['tgl_sipa_apj_gudang']; ?>"
                                            data-file_sipa="<?= $row['file_sipa_apj_gudang']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm btn-delete p-2" data-id="<?= $row['id_gudang']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Gudang -->
<div class="modal fade" id="tambahGudangModal" tabindex="-1" aria-labelledby="tambahGudangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="tambahGudangLabel">Tambah Gudang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formTambahGudang" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Gudang</label>
                        <input type="text" class="form-control" name="nama_gudang" placeholder="Masukkan nama gudang" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Gudang</label>
                        <textarea class="form-control" name="alamat_gudang" rows="3" placeholder="Masukkan alamat gudang" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor SIPA APJ</label>
                            <input type="text" class="form-control" name="no_sipa_apj_gudang" placeholder="Contoh: 503/123/45.67/6789" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Berlaku SIPA</label>
                            <input type="date" class="form-control" name="tgl_sipa_apj_gudang" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File SIPA (PDF)</label>
                        <div class="dropzone" id="dropzoneTambahGudang">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Klik atau seret file SIPA ke sini</p>
                            <p class="file-info">Format: PDF (Maks. 5MB)</p>
                        </div>
                        <small class="text-muted">Format: PDF. Maksimal 2 MB.</small>
                        <input type="file" name="file_sipa_apj_gudang" id="fileTambahGudang" hidden accept="application/pdf" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Edit Gudang -->
<div class="modal fade" id="modalEditGudang" tabindex="-1" aria-labelledby="editGudangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editGudangLabel">Edit Data Gudang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="formEditGudang" enctype="multipart/form-data">
                <div class="modal-body">

                    <input type="hidden" name="id_gudang" id="edit_id_gudang">

                    <div class="mb-3">
                        <label class="form-label">Nama Gudang</label>
                        <input type="text" class="form-control" name="nama_gudang" id="edit_nama_gudang" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Gudang</label>
                        <textarea class="form-control" name="alamat_gudang" id="edit_alamat_gudang" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor SIPA APJ</label>
                            <input type="text" class="form-control" name="no_sipa_apj_gudang" id="edit_no_sipa">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Berlaku SIPA</label>
                            <input type="date" class="form-control" name="tgl_sipa_apj_gudang" id="edit_tgl_sipa">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File SIPA (PDF)</label>
                        <div id="dropzoneEditGudang" class="dropzone">
                            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                            <p class="mb-1">Klik atau seret file SIPA ke sini</p>
                            <p class="file-info">Format: PDF (Maks. 5MB)</p>
                        </div>
                        <input type="file" id="fileEditGudang" name="file_sipa_apj_gudang" accept="application/pdf" style="display:none;">
                        <small class="text-muted">Abaikan jika tidak ingin mengganti file. Maks 2 MB.</small>
                        <div class="mt-2">
                            <a id="file_sipa_lama" href="#" target="_blank">Lihat File Lama</a>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Dropzone & JS -->
<script>
    $(document).ready(function() {
        // Dropzone klik trigger
        $('#dropzoneTambahGudang').click(function() {
            $('#fileTambahGudang').click();
        });
        $('#fileTambahGudang').change(function() {
            let fileName = $(this).val().split('\\').pop();
            $('#dropzoneTambahGudang').text(fileName);
        });


        // Tambah Gudang AJAX
        $('#formTambahGudang').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: 'pages/profil/proses_tambah_gudang.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: () => Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                }),
                success: function(res) {
                    Swal.close();
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        $('#tambahGudangModal').modal('hide');
                        location.reload();
                    } else Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
                },
                error: () => Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tidak dapat menghubungi server!'
                })
            });
        });

        $('.btn-edit').click(function() {
            let data = $(this).data();
            $('#edit_id_gudang').val(data.id);
            $('#edit_nama_gudang').val(data.nama);
            $('#edit_alamat_gudang').val(data.alamat);
            $('#edit_no_sipa').val(data.no_sipa);
            $('#edit_tgl_sipa').val(data.tgl_sipa);

            if (data.file_sipa) {
                $('#file_sipa_lama').removeClass('d-none').attr('href', 'uploads/sipa_apj_gudang/' + data.file_sipa);
            } else {
                $('#file_sipa_lama').addClass('d-none');
            }

            //$('#dropzoneEditGudang').text('Klik untuk pilih file PDF');
            $('#fileEditGudang').val(''); // Reset file input

            $('#modalEditGudang').modal('show');
        });

        // Click dropzone untuk pilih file
        $('#dropzoneEditGudang').click(function() {
            $('#fileEditGudang').click();
        });

        // Tampilkan nama file ketika dipilih
        $('#fileEditGudang').change(function() {
            let fileName = $(this).val().split('\\').pop();
            $('#dropzoneEditGudang').text(fileName);
        });

        // Submit form edit via AJAX
        $('#formEditGudang').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "pages/profil/proses_edit_gudang.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Berhasil!', response.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Tidak dapat menghubungi server', 'error');
                }
            });
        });


        // Hapus Gudang
        $('.btn-delete').click(function() {

            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin hapus?',
                text: 'Data tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('pages/profil/proses_delete_gudang.php', {
                        id_gudang: id
                    }, function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: res.message,
                                timer: 1200,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1200);
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    }, 'json');
                }
            });
        });

    });
</script>

<style>
    .dropzone {
        border: 2px dashed #28a745;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        color: #28a745;
        font-weight: 500;
    }

    .dropzone:hover {
        background-color: #e6f4ea;
    }
</style>