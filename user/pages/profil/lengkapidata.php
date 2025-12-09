<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">PROFIL PERUSAHAAN</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
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

                    <!-- Alert 
                    <form class="upload-form" action="pages/profil/uploadnib.php" method="post" enctype="multipart/form-data"> 
                        <div class="alert alert-danger alert-dismissible fade show danger-pulse" role="alert">                  
                        <label for="email" class="col-sm-4 col-form-label">Upload NIB</label>
                        <input type="file" id="file-input" name="upload_nib" accept=".pdf,.jpg,.png">   
                        </div>

                        <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save"></i> Simpan
                        </button>                
                        </div>

                    </form>-->

                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah Gudang Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 alert alert-danger alert-dismissible fade show danger-pulse ">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fa fa-warehouse"></i> Lengkapi Data
            </h6>
        </div>

        <div class="card p-4 shadow">
            <h4 class="mb-3">Form Upload Dokumen</h4>
            <form method="POST" id="lengkapiData" enctype="multipart/form-data">

                <!-- Baris 1: Upload NIB -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Upload NIB</label>
                        <input type="file" name="upload_nib" class="form-control">
                    </div>
                </div>

                <!-- Baris 2: Upload Ijin PBF -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Upload Ijin PBF</label>
                        <input type="file" name="upload_ijin_pbf" class="form-control">
                    </div>
                </div>

                <!-- Baris 3: SIPA -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Upload SIPA</label>
                        <input type="file" name="upload_sipa" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor SIPA</label>
                        <input type="text" name="no_sipa" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Berlaku SIPA</label>
                        <input type="date" name="tgl_berlaku_sipa" class="form-control">
                    </div>
                </div>

                <!-- Baris 4: CDOB -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Upload Sertifikat CDOB</label>
                        <input type="file" name="upload_cdob" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nomor Sertifikat CDOB</label>
                        <input type="text" name="no_cdob" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Berlaku Sertifikat CDOB</label>
                        <input type="date" name="tgl_berlaku_cdob" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            </form>
        </div>
        </form>
    </div>
</div>
</div>

<!-- Script untuk menampilkan nama file -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('.custom-file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = this.files.length > 0 ? this.files[0].name : 'Pilih file...';
                const label = this.nextElementSibling;
                if (label) {
                    label.textContent = fileName;
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('lengkapiData');
        const fileInput = document.getElementById('upload_nib');
        const fileLabel = document.querySelector('.custom-file-label');

        // Update file input label when file is selected
        fileInput.addEventListener('change', function() {
            fileLabel.textContent = this.files.length > 0 ? this.files[0].name : 'Pilih file...';
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Validate form inputs
            if (!form.checkValidity()) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Form Tidak Lengkap',
                    text: 'Harap isi semua field yang wajib diisi',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            // Validate file if uploaded
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

                if (!allowedTypes.includes(file.type)) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Hanya menerima file PDF, JPG, atau PNG',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    await Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 5MB',
                        confirmButtonColor: '#3085d6'
                    });
                    return;
                }
            }

            // Show loading indicator
            const swalInstance = Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Sedang memproses data Anda',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
                willClose: () => Swal.hideLoading()
            });

            try {
                const formData = new FormData(form);
                const response = await fetch('pages/profil/proses_lengkapidata.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                await swalInstance.close();

                if (result.success) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Disimpan!',
                        text: 'Data perusahaan dan gudang telah tersimpan',
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Lanjut',
                        timer: 3000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = result.redirect || 'index.php?page=dataperusahaan';
                        }
                    });
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Data',
                        text: result.message || 'Terjadi kesalahan saat menyimpan data',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                await swalInstance.close();
                await Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi masalah koneksi atau server. Silakan coba beberapa saat lagi.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Mengerti'
                });
            }
        });
    });
</script>





<!-- Custom CSS Alert2 blink2 -->
<style>
    /* Animasi Kombinasi Blink + Pulse */
    @keyframes red-alert {
        0% {
            transform: scale(1);
            background-color: transparent;
        }

        50% {
            transform: scale(1.02);
            background-color: transparent;
        }

        100% {
            transform: scale(1);
            background-color: transparent;
        }
    }

    .danger-pulse {
        animation: red-alert 1s infinite;
        border: 2px solid #dc3545;
    }

    .danger-pulse:hover {
        animation: none;
        background-color: transparent;
    }

    .alert-title {
        color: #dc3545;
        font-weight: bold;
        font-size: 1.2em;
    }
</style>