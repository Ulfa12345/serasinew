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

                    <!--<div class="form-group row mb-3">
                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" name="password" class="form-control-plaintext form-control-user" 
                                id="password" value="<?php echo $perusahaan['password']; ?>" disabled>
                        </div>
                    </div>

                    <a href="index.php?page=profil" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-pencil-alt"></i> 
                        </span>
                        <span class="text">Edit Data Perusahaan</span>
                    </a>-->
                    
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
                            <th>Perusahaan</th>
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
                            <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
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