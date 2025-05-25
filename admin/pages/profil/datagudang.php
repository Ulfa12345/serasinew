<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">PROFIL PERUSAHAAN</h1>

    <!-- Profil Perusahaan Section -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-sm-6">
                    <div class="form-group row mb-3">
                        <label for="nib" class="col-sm-4 col-form-label">NIB</label>
                        <div class="col-sm-8">
                            <input type="text" name="nib" class="form-control-plaintext form-control-user" 
                                id="nib" value="<?php echo $perusahaan['nib']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="nama_perusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                        <div class="col-sm-8">
                            <input type="text" name="nama_perusahaan" class="form-control-plaintext form-control-user" 
                                id="nama_perusahaan" value="<?php echo $perusahaan['nama_perusahaan']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="alamat_perusahaan" class="col-sm-4 col-form-label">Alamat Perusahaan</label>
                        <div class="col-sm-8">
                            <input type="text" name="alamat_perusahaan" class="form-control-plaintext form-control-user" 
                                id="alamat_perusahaan" value="<?php echo $perusahaan['alamat_perusahaan']; ?>" disabled>
                        </div>
                    </div>

                    <!-- Preview NIB -->
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Dokumen NIB</label>
                        <div class="col-sm-8">
                            <?php if(!empty($perusahaan['upload_nib'])): ?>
                        <div class="card border-left-primary shadow">
                            <div class="card-body p-2">
                                <?php
                                $file_ext = pathinfo($perusahaan['upload_nib'], PATHINFO_EXTENSION);
                                
                                // Path yang benar sesuai struktur folder
                                $server_path = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/admin/pages/upload/nib/' . basename($perusahaan['upload_nib']);
                                $web_path = '/serasinew/admin/pages/upload/nib/' . basename($perusahaan['upload_nib']);
                                
                                if(file_exists($server_path)): ?>
                                    <?php if(in_array($file_ext, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?= $web_path ?>" 
                                            class="img-fluid rounded mb-2 preview-doc" 
                                            alt="Preview NIB"
                                            style="max-height: 200px">
                                            
                                    <?php elseif($file_ext === 'pdf'): ?>
                                        <iframe src="<?= $web_path ?>#toolbar=0&navpanes=0" 
                                                style="width:100%; height:200px;" 
                                                frameborder="0">
                                        </iframe>
                                    <?php endif; ?>
                                    
                                    <div class="mt-2">
                                        <a href="<?= $web_path ?>" 
                                            target="_blank" 
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-expand"></i> Fullscreen
                                        </a>
                                        <a href="<?= $web_path ?>" 
                                            download 
                                            class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger py-1">
                                        <i class="fas fa-times-circle"></i> File tidak ditemukan di server
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-muted">
                            <i class="fas fa-exclamation-circle"></i> Belum ada dokumen terupload
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                </div>

                <!-- Kolom 2 -->
                <div class="col-sm-6">
                    <div class="form-group row mb-3">
                        <label for="nama_pic" class="col-sm-4 col-form-label">Penanggung Jawab</label>
                        <div class="col-sm-8">
                            <input type="text" name="nama_pic" class="form-control-plaintext form-control-user" 
                                id="nama_pic" value="<?php echo $perusahaan['nama_pic']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="no_wa_pic" class="col-sm-4 col-form-label">No. Telepon/HP</label>
                        <div class="col-sm-8">
                            <input type="tel" name="no_wa_pic" class="form-control-plaintext form-control-user" 
                                id="no_wa_pic" value="<?php echo $perusahaan['no_wa_pic']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control-plaintext form-control-user" 
                                id="email" value="<?php echo $perusahaan['email']; ?>" disabled>
                        </div>
                    </div>

                    <button class="btn btn-warning" data-toggle="modal" data-target="#editPerusahaanModal">
                        <i class="fas fa-edit"></i> Edit Data Perusahaan
                    </button>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah Gudang Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="index.php?page=profil" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Gudang</span>
            </a>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <?php

                // Pastikan session perusahaan sudah ada
                if (!isset($_SESSION['id_perusahaan'])) {
                    header("Location: ../login.php");
                    exit();
                }

                $id_perusahaan = $_SESSION['id_perusahaan'];

                // Query dengan JOIN ke tabel perusahaan dan filter session
                $query = "SELECT g.*, p.nama_perusahaan 
                        FROM tb_gudang g
                        INNER JOIN tb_perusahaan p 
                        ON g.id_perusahaan = p.id_perusahaan 
                        WHERE g.id_perusahaan = ?
                        ORDER BY g.id_gudang DESC";

                // Menggunakan prepared statement
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_perusahaan);
                $stmt->execute();
                $result = $stmt->get_result();

                // Tampilkan error jika query gagal
                if (!$result) {
                    die("Error menampilkan data: " . $conn->error);
                }
                ?>

                <!-- Tampilan HTML -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while($row = $result->fetch_assoc()) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_gudang']); ?></td>
                            <td><?= htmlspecialchars($row['alamat_gudang']); ?></td>
                            <td><?= htmlspecialchars($row['keterangan']); ?></td>
                            <td>
                                <!-- Tombol edit dengan data attribute -->
                                <button class="btn btn-warning btn-edit" 
                                        data-id="<?= $row['id_gudang'] ?>"
                                        data-nama="<?= htmlspecialchars($row['nama_gudang']) ?>"
                                        data-alamat="<?= htmlspecialchars($row['alamat_gudang']) ?>"
                                        data-keterangan="<?= htmlspecialchars($row['keterangan']) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk DataTables -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>

<!-- Modal Edit Perusahaan -->
<div class="modal fade" id="editPerusahaanModal" tabindex="-1" role="dialog" aria-labelledby="editPerusahaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editPerusahaanModalLabel">Edit Profil Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditPerusahaan" method="POST" action="pages/profil/proses_edit_perusahaan.php">
                <div class="modal-body">
                    <!-- NIB -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">NIB</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nib" value="<?php echo $perusahaan['nib']; ?>" disabled>
                        </div>
                    </div>

                    <!-- Nama Perusahaan -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_perusahaan" value="<?php echo $perusahaan['nama_perusahaan']; ?>" required>
                        </div>
                    </div>

                    <!-- Alamat Perusahaan -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="alamat_perusahaan" rows="2" required><?php echo $perusahaan['alamat_perusahaan'] ?></textarea>
                        </div>
                    </div>

                    <!-- Penanggung Jawab -->
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama_pic" value="<?php echo $perusahaan['nama_pic']; ?>" required>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">No. HP <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="tel" class="form-control" name="no_wa_pic" value="<?php echo $perusahaan['no_wa_pic']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" value="<?php echo $perusahaan['email']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
// Script untuk handle form submit dengan AJAX
$(document).ready(function() {
    $('#formEditPerusahaan').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: 'POST',
            url: 'pages/profil/proses_edit_perusahaan.php',
            data: $(this).serialize(),
            dataType: 'json', // <- tambahkan ini
            success: function(response) {
                // Tidak perlu JSON.parse()
                if(response.status === 'success') {
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.statusText);
            }
        });

    });
});
</script>


<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel">Edit Data Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="pages/profil/proses_edit_gudang.php">
                <div class="modal-body">
                    <input type="hidden" name="id_gudang" id="editId">
                    
                    <div class="form-group">
                        <label for="editNama">Nama Gudang</label>
                        <input type="text" class="form-control" id="editNama" name="nama_gudang" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editAlamat">Alamat Gudang</label>
                        <input type="text" class="form-control" id="editAlamat" name="alamat_gudang" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="editKeterangan">Keterangan</label>
                        <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Script untuk menangani modal edit
document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua tombol edit
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            // Ambil data dari atribut data-*
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const alamat = this.dataset.alamat;
            const keterangan = this.dataset.keterangan;

            // Isi data ke form modal
            document.getElementById('editId').value = id;
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editKeterangan').value = keterangan;

            // Tampilkan modal
            $('#editModal').modal('show');
        });
    });

    // Handle form submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Kirim data menggunakan AJAX
        const formData = new FormData(this);
        
        fetch('pages/profil/proses_edit_gudang.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                // Refresh halaman setelah 1 detik
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('Gagal menyimpan perubahan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>