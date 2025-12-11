

<div class="container-fluid py-4">
    <?php
    // Cek apakah 4 dokumen utama sudah ada isinya
    $dokumen_lengkap = !empty($perusahaan['upload_nib']) &&
        !empty($perusahaan['upload_ijin_pbf']) &&
        !empty($perusahaan['upload_sipa']) &&
        !empty($perusahaan['upload_cdob']);
    ?>
    <!-- Header -->
    <div class="page-header">
        <h1 class="h3 mb-1 fw-bold text-dark">Profil Perusahaan</h1>
        <p class="text-muted">Kelola informasi dan dokumen perusahaan Anda</p>
    </div>

    <!-- Alert Section -->
    <?php if (!$dokumen_lengkap): ?>

        <div class="alert-section d-flex align-items-center">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <div>
                <h6 class="mb-1 fw-bold">Lengkapi Data Perusahaan</h6>
                <p class="mb-0">Silakan lengkapi dokumen-dokumen berikut untuk melengkapi profil perusahaan Anda.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Informasi Perusahaan -->
    <div class="card info-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Informasi Perusahaan</span>
            <a href="index.php?page=update_perusahaan.php&id=<?= $perusahaan['id_perusahaan'] ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">NIB</div>
                        <div class="info-value"><?php echo $perusahaan['nib']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nama Perusahaan</div>
                        <div class="info-value"><?php echo $perusahaan['nama_perusahaan']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Alamat Perusahaan</div>
                        <div class="info-value"><?php echo $perusahaan['alamat_perusahaan']; ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">Penanggung Jawab</div>
                        <div class="info-value"><?php echo $perusahaan['nama_pic']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">No. Telepon/HP</div>
                        <div class="info-value"><?php echo $perusahaan['no_wa_pic']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?php echo $perusahaan['email']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Dokumen -->

    <?php if ($dokumen_lengkap): ?>
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i> Data & Dokumen Lengkap
            </div>
            <div class="card-body">
                <div class="alert alert-success">
                    Semua dokumen telah terverifikasi sistem.
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Dokumen Perusahaan</span>
                <span class="status-badge status-pending">Perlu Dilengkapi</span>
            </div>
            <div class="card-body">
                <form method="POST" id="lengkapiData" enctype="multipart/form-data">
                    <div class="form-section">
                        <h5 class="section-title required">Dokumen NIB</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="file-upload-area" id="nibUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik atau seret file NIB ke sini</p>
                                    <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                </div>
                                <input type="file" name="upload_nib" class="d-none" id="upload_nib" accept=".pdf">
                            </div>
                            <div class="col-md-6">
                                <div id="nibPreview" class="text-center">
                                    <p class="text-muted">Belum ada file yang diunggah</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">Ijin PBF</h5>
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="file-upload-area" id="ijinPbfUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik atau seret file Ijin PBF ke sini</p>
                                    <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                </div>
                                <input type="file" name="upload_ijin_pbf" class="d-none" id="upload_ijin_pbf" accept=".pdf">
                            </div>
                            <div class="col-md-6">
                                <div id="ijinPbfPreview" class="text-center">
                                    <p class="text-muted">Belum ada file yang diunggah</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">SIPA</h5>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <div class="file-upload-area" id="sipaUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik atau seret file SIPA ke sini</p>
                                    <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                </div>
                                <input type="file" name="upload_sipa" class="d-none" id="upload_sipa" accept=".pdf">
                            </div>
                            <div class="col-md-6">
                                <div id="sipaPreview" class="text-center">
                                    <p class="text-muted">Belum ada file yang diunggah</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium required">Nomor SIPA</label>
                                <input type="text" name="no_sipa" class="form-control" placeholder="Masukkan nomor SIPA" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium required">Tanggal Berlaku SIPA</label>
                                <input type="date" name="tgl_berlaku_sipa" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="section-title">Sertifikat CDOB</h5>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <div class="file-upload-area" id="cdobUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik atau seret file Sertifikat CDOB ke sini</p>
                                    <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                </div>
                                <input type="file" name="upload_cdob" class="d-none" id="upload_cdob" accept=".pdf">
                            </div>
                            <div class="col-md-6">
                                <div id="cdobPreview" class="text-center">
                                    <p class="text-muted">Belum ada file yang diunggah</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium required">Nomor Sertifikat CDOB</label>
                                <input type="text" name="no_cdob" class="form-control" placeholder="Masukkan nomor sertifikat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium required">Tanggal Berlaku Sertifikat CDOB</label>
                                <input type="date" name="tgl_berlaku_cdob" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-2"></i> Simpan Semua Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const uploadAreas = [{
    //             area: 'nibUploadArea',
    //             input: 'upload_nib',
    //             preview: 'nibPreview'
    //         },
    //         {
    //             area: 'ijinPbfUploadArea',
    //             input: 'upload_ijin_pbf',
    //             preview: 'ijinPbfPreview'
    //         },
    //         {
    //             area: 'sipaUploadArea',
    //             input: 'upload_sipa',
    //             preview: 'sipaPreview'
    //         },
    //         {
    //             area: 'cdobUploadArea',
    //             input: 'upload_cdob',
    //             preview: 'cdobPreview'
    //         }
    //     ];

    //     uploadAreas.forEach(item => {
    //         const area = document.getElementById(item.area);
    //         const input = document.getElementById(item.input);
    //         const preview = document.getElementById(item.preview);

    //         // Klik untuk pilih file
    //         area.addEventListener('click', () => input.click());

    //         // Drag & drop events
    //         ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => area.addEventListener(e, preventDefaults, false));

    //         function preventDefaults(e) {
    //             e.preventDefault();
    //             e.stopPropagation();
    //         }

    //         ['dragenter', 'dragover'].forEach(e => area.addEventListener(e, () => area.classList.add('dragover'), false));
    //         ['dragleave', 'drop'].forEach(e => area.addEventListener(e, () => area.classList.remove('dragover'), false));

    //         area.addEventListener('drop', handleDrop, false);

    //         function handleDrop(e) {
    //             const dt = e.dataTransfer;
    //             const files = dt.files;
    //             if (files.length > 0) {
    //                 input.files = files; // untuk FormData nanti
    //                 handleFiles(files, preview, area);
    //             }
    //         }

    //         input.addEventListener('change', function() {
    //             handleFiles(this.files, preview, area);
    //         });

    //         function handleFiles(files, previewElement, areaElement) {
    //             const file = files[0];
    //             const allowedTypes = ['application/pdf'];

    //             if (!allowedTypes.includes(file.type)) {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Format File Tidak Valid',
    //                     text: 'Hanya PDF yang diterima',
    //                     confirmButtonColor: '#3085d6'
    //                 });
    //                 input.value = '';
    //                 previewElement.innerHTML = '<p class="text-muted">Belum ada file yang diunggah</p>';
    //                 return;
    //             }

    //             if (file.size > 5 * 1024 * 1024) {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'File Terlalu Besar',
    //                     text: 'Maksimal 5MB',
    //                     confirmButtonColor: '#3085d6'
    //                 });
    //                 input.value = '';
    //                 previewElement.innerHTML = '<p class="text-muted">Belum ada file yang diunggah</p>';
    //                 return;
    //             }

    //             // Update UI
    //             areaElement.innerHTML = `
    //             <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
    //             <p class="mb-1">${file.name}</p>
    //             <p class="file-info">${(file.size/1024/1024).toFixed(2)} MB</p>
    //         `;
    //             previewElement.innerHTML = `
    //             <div class="p-3 bg-light rounded">
    //                 <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
    //                 <p class="mb-0">File PDF</p>
    //             </div>
    //         `;
    //         }
    //     });

    //     // Form submit
    //     const form = document.getElementById('lengkapiData');
    //     form.addEventListener('submit', async function(e) {
    //         e.preventDefault();

    //         let isValid = true;

    //         // Validasi semua file wajib
    //         uploadAreas.forEach(item => {
    //             const input = document.getElementById(item.input);
    //             const area = document.getElementById(item.area);

    //             if (!input.files[0]) {
    //                 isValid = false;
    //                 area.classList.add('border', 'border-danger');
    //             } else {
    //                 area.classList.remove('border', 'border-danger');
    //             }
    //         });

    //         // Validasi input text required
    //         form.querySelectorAll('input[required]').forEach(field => {
    //             if (field.type !== 'file' && !field.value.trim()) {
    //                 isValid = false;
    //                 field.classList.add('is-invalid');
    //             } else {
    //                 field.classList.remove('is-invalid');
    //             }
    //         });

    //         if (!isValid) {
    //             await Swal.fire({
    //                 icon: 'error',
    //                 title: 'Form Tidak Lengkap',
    //                 text: 'Harap lengkapi semua file dan field wajib',
    //                 confirmButtonColor: '#3085d6'
    //             });
    //             return;
    //         }

    //         // Submit via FormData
    //         const formData = new FormData(form);

    //         const swalInstance = Swal.fire({
    //             title: 'Menyimpan Data...',
    //             html: 'Sedang memproses data Anda',
    //             allowOutsideClick: false,
    //             didOpen: () => Swal.showLoading()
    //         });

    //         try {
    //             const response = await fetch('pages/profil/proses_edit_perusahaan.php', {
    //                 method: 'POST',
    //                 body: formData
    //             });

    //             const result = await response.json();
    //             await swalInstance.close();

    //             if (result.status) {
    //                 await Swal.fire({
    //                     icon: 'success',
    //                     title: 'Data Berhasil Disimpan!',
    //                     text: 'Data perusahaan dan dokumen telah tersimpan',
    //                     confirmButtonColor: '#28a745',
    //                     timer: 3000,
    //                     timerProgressBar: true,
    //                     willClose: () => {
    //                         window.location.href = result.redirect;
    //                     }
    //                 });
    //             } else {
    //                 await Swal.fire({
    //                     icon: 'error',
    //                     title: 'Gagal Menyimpan Data',
    //                     text: result.message || 'Terjadi kesalahan',
    //                     confirmButtonColor: '#3085d6'
    //                 });
    //             }

    //         } catch (err) {
    //             await swalInstance.close();
    //             await Swal.fire({
    //                 icon: 'error',
    //                 title: 'Kesalahan Sistem',
    //                 text: 'Terjadi masalah koneksi atau server',
    //                 confirmButtonColor: '#3085d6'
    //             });
    //             console.error(err);
    //         }
    //     });
    // });
    document.addEventListener('DOMContentLoaded', function() {
        const uploadAreas = [{
                area: 'nibUploadArea',
                input: 'upload_nib',
                preview: 'nibPreview',
                required: true
            },
            {
                area: 'ijinPbfUploadArea',
                input: 'upload_ijin_pbf',
                preview: 'ijinPbfPreview',
                required: false
            },
            {
                area: 'sipaUploadArea',
                input: 'upload_sipa',
                preview: 'sipaPreview',
                required: true
            },
            {
                area: 'cdobUploadArea',
                input: 'upload_cdob',
                preview: 'cdobPreview',
                required: true
            }
        ];

        uploadAreas.forEach(item => {
            const area = document.getElementById(item.area);
            const input = document.getElementById(item.input);
            const preview = document.getElementById(item.preview);

            // Klik untuk pilih file
            area.addEventListener('click', () => input.click());

            // Drag & drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => area.addEventListener(e, preventDefaults, false));

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(e => area.addEventListener(e, () => area.classList.add('dragover'), false));
            ['dragleave', 'drop'].forEach(e => area.addEventListener(e, () => area.classList.remove('dragover'), false));

            area.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    input.files = files; // untuk FormData nanti
                    handleFiles(files, preview, area);
                }
            }

            input.addEventListener('change', function() {
                handleFiles(this.files, preview, area);
            });

            function handleFiles(files, previewElement, areaElement) {
                const file = files[0];
                const allowedTypes = ['application/pdf'];

                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Valid',
                        text: 'Hanya PDF yang diterima',
                        confirmButtonColor: '#3085d6'
                    });
                    input.value = '';
                    previewElement.innerHTML = '<p class="text-muted">Belum ada file yang diunggah</p>';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal 5MB',
                        confirmButtonColor: '#3085d6'
                    });
                    input.value = '';
                    previewElement.innerHTML = '<p class="text-muted">Belum ada file yang diunggah</p>';
                    return;
                }

                // Update UI
                areaElement.innerHTML = `
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <p class="mb-1">${file.name}</p>
                <p class="file-info">${(file.size/1024/1024).toFixed(2)} MB</p>
            `;
                previewElement.innerHTML = `
                <div class="p-3 bg-light rounded">
                    <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                    <p class="mb-0">File PDF</p>
                </div>
            `;
            }
        });

        // Form submit
        const form = document.getElementById('lengkapiData');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            let isValid = true;

            // Validasi hanya file yang required
            uploadAreas.forEach(item => {
                if (item.required) {
                    const input = document.getElementById(item.input);
                    const area = document.getElementById(item.area);

                    if (!input.files[0]) {
                        isValid = false;
                        area.classList.add('border', 'border-danger');
                    } else {
                        area.classList.remove('border', 'border-danger');
                    }
                }
            });

            // Validasi input text required
            form.querySelectorAll('input[required]').forEach(field => {
                if (field.type !== 'file' && !field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                await Swal.fire({
                    icon: 'error',
                    title: 'Form Tidak Lengkap',
                    text: 'Harap lengkapi semua file dan field wajib',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Submit via FormData
            const formData = new FormData(form);
            const swalInstance = Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Sedang memproses data Anda',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const response = await fetch('pages/profil/proses_edit_perusahaan.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                await swalInstance.close();

                if (result.status) {
                    await Swal.fire({
                        icon: 'success',
                        title: 'Data Berhasil Disimpan!',
                        text: 'Data perusahaan dan dokumen telah tersimpan',
                        confirmButtonColor: '#28a745',
                        timer: 3000,
                        timerProgressBar: true,
                        willClose: () => {
                            window.location.href = result.redirect;
                        }
                    });
                } else {
                    await Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan Data',
                        text: result.message || 'Terjadi kesalahan',
                        confirmButtonColor: '#3085d6'
                    });
                }

            } catch (err) {
                await swalInstance.close();
                await Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Terjadi masalah koneksi atau server',
                    confirmButtonColor: '#3085d6'
                });
                console.error(err);
            }
        });
    });
</script>