<div class="container-fluid">
    <!-- Form Tambah Gudang Section -->
    <div class="card shadow mb-4">
        
        <div class="card-body">
            <div class="table-responsive">
                <?php

                // Query dengan JOIN ke tabel perusahaan dan filter session
                $query = "SELECT p.*, g.nama_gudang
                        FROM tb_perusahaan p
                        JOIN tb_gudang g 
                        ON p.id_perusahaan = g.id_perusahaan 
                        ORDER BY p.id_perusahaan DESC";

                // Menggunakan prepared statement
                $stmt = $conn->prepare($query);
                //$stmt->bind_param("i", $id_perusahaan);
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
                            <th>NIB</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat Perusahaan</th>
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
                            <td><?= htmlspecialchars($row['nib']); ?></td>
                            <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                            <td><?= htmlspecialchars($row['alamat_perusahaan']); ?></td>
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
            <form id="formEditPerusahaan" method="POST" action="pages/profil/proses_edit_perusahaan.php" enctype="multipart/form-data">
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

                    <div class="form-group row">
                    <div class="col-md-6 mb-3 upload-field" id="field_sipa">
                        <label class="form-label">Upload NIB</label>
                        <input type="file" class="form-control" name="upload_nib" accept=".pdf,.jpg,.png">
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
$('#formEditPerusahaan').submit(function(e) {
    e.preventDefault();
    
    // Kirim data sebagai FormData (untuk file upload)
    const formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: 'pages/profil/proses_edit_perusahaan.php',
        data: formData,
        contentType: false, // Penting untuk file upload
        processData: false, // Penting untuk file upload
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert('Berhasil: ' + response.message);
                window.location.reload();
            } else {
                alert('Gagal: ' + response.message);
            }
        },
        error: function(xhr) {
            let errorMessage = "Terjadi kesalahan: ";
            try {
                const response = JSON.parse(xhr.responseText);
                errorMessage += response.message || xhr.statusText;
            } catch {
                errorMessage += xhr.statusText;
            }
            alert(errorMessage);
        }
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

<!-- Modal -->
<div class="modal fade" id="tambahGudangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Gudang Baru</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTambahGudang" method="POST" action="pages/profil/proses_tambahgudang.php">
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_gudang" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" required>
          </div>
          <div class="mb-3">
            <label for="alamat_gudang" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat_gudang" name="alamat_gudang" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Script popup tambah gudang
$(document).ready(function() {
  $('#formTambahGudang').submit(function(e) {
    e.preventDefault();
    
    $.ajax({
      url: 'pages/profil/proses_tambahgudang.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(response) {
        if(response.status == 'success') {
          $('#tambahGudangModal').modal('hide');
          alert('Data berhasil disimpan!');
          // Refresh tabel atau tambahkan data ke tabel
          location.reload();
        } else {
          alert('Error: ' + response.message);
        }
      },
      error: function(xhr) {
        alert('Terjadi kesalahan. Silakan coba lagi.');
      }
    });
  });
});


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