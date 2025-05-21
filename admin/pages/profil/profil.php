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
                    </div>-->
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
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fa fa-warehouse"></i> Lengkapi Data Gudang
            </h6>
        </div>
        <div class="card-body">
            <form method="POST" action="pages/profil/proses_tambah_gudang.php">
                <div class="form-group mb-4">
                    <label for="nama_gudang">Nama Gudang</label>
                    <input type="text" class="form-control" 
                        id="nama_gudang" name="nama_gudang" 
                        maxlength="100" required>
                    <small class="form-text text-muted">Maksimal 100 karakter</small>
                </div>

                <div class="form-group mb-4">
                    <label for="alamat_gudang">Alamat Gudang</label>
                    <input type="text" class="form-control" 
                        id="alamat_gudang" name="alamat_gudang" 
                        maxlength="100" required>
                </div>

                <div class="form-group mb-4">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" 
                        name="keterangan" rows="3" required></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                            <input type="text" class="form-control" name="penanggung_jawab" value="<?php echo $perusahaan['nama_pic']; ?>" required>
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
            success: function(response) {
                const result = JSON.parse(response);
                if(result.status === 'success') {
                    window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.statusText);
            }
        });
    });
});
</script>