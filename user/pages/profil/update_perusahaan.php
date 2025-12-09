<?php

include "../conf/conn.php";

$id = $_GET['id']; // Ambil ID dari URL
$sql = "SELECT * FROM tb_perusahaan WHERE id_perusahaan = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data perusahaan tidak ditemukan.");
}
?>

<style>
    :root {
        --primary: #2c5aa0;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --warning: #ffc107;
        --light: #f8f9fa;
        --dark: #212529;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f5f7fb;
        color: #333;
    }

    .page-header {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 24px;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid #eaeaea;
        padding: 16px 20px;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
    }

    .info-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #555;
        min-width: 180px;
    }

    .info-value {
        color: #222;
        font-weight: 400;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #eaeaea;
    }

    .file-upload-area {
        border: 2px dashed #cbd5e0;
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
        background-color: #fafbfc;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: var(--primary);
        background-color: #f0f7ff;
    }

    .file-upload-area.dragover {
        border-color: var(--primary);
        background-color: #e6f2ff;
    }

    .file-info {
        font-size: 0.85rem;
        color: var(--secondary);
        margin-top: 8px;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        padding: 10px 24px;
        font-weight: 500;
        border-radius: 8px;
    }

    .btn-primary:hover {
        background-color: #234a8c;
        border-color: #234a8c;
    }

    .alert-section {
        background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
        border: 1px solid #feb2b2;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .alert-icon {
        color: var(--danger);
        font-size: 1.5rem;
        margin-right: 12px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .document-preview {
        max-width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 768px) {
        .info-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .info-label {
            min-width: auto;
            margin-bottom: 4px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="h3 mb-1 fw-bold text-dark">Perbarui Data Perusahaan</h1>
        <p class="text-muted">Kelola informasi perusahaan Anda</p>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Edit Data Perusahaan</h4>
        </div>
        <div class="card-body">

            <form action="pages/profil/proses_update_perusahaan.php" method="POST" enctype="multipart/form-data" id="update_data">

                <input type="hidden" name="id_perusahaan" value="<?= $data['id_perusahaan'] ?>">

                <h5 class="mb-3 border-bottom pb-2">Data Umum</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" value="<?= $data['nama_perusahaan'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIB</label>
                        <input type="text" class="form-control" name="nib" value="<?= $data['nib'] ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat Perusahaan</label>
                    <textarea class="form-control" name="alamat_perusahaan" rows="3" required><?= $data['alamat_perusahaan'] ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="(Kosongkan jika tidak ingin mengganti password)">
                        <small class="text-muted">Biarkan kosong untuk menggunakan password lama.</small>
                    </div>
                </div>

                <h5 class="mb-3 mt-4 border-bottom pb-2">Data PIC</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" class="form-control" name="nama_pic" value="<?= $data['nama_pic'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. WA PIC</label>
                        <input type="text" class="form-control" name="no_wa_pic" value="<?= $data['no_wa_pic'] ?>" required>
                    </div>
                </div>

                <h5 class="mb-3 mt-4 border-bottom pb-2">Dokumen CDOB & SIPA</h5>

                <!-- Upload NIB -->
                <div class="form-section">
                    <h5 class="section-title">Dokumen NIB</h5>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="file-upload-area" id="nibUploadArea">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik atau seret file NIB ke sini</p>
                                <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                <input type="file" name="upload_nib" class="d-none" id="upload_nib" accept=".pdf">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="nibPreview" class="mb-2"></div>
                            <?php if (!empty($data['upload_nib'])): ?>
                                <div class="mt-1 small alert alert-info py-1 px-2 d-inline-block">
                                    <i class="fas fa-file-alt me-1"></i> File Tersimpan:
                                    <a href="uploads/<?= $data['upload_nib'] ?>" target="_blank" class="text-decoration-none fw-bold">Lihat File</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Upload Ijin PBF -->
                <div class="form-section">
                    <h5 class="section-title">Ijin PBF</h5>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="file-upload-area" id="ijinPbfUploadArea">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik atau seret file Ijin PBF ke sini</p>
                                <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                <input type="file" name="upload_ijin_pbf" class="d-none" id="upload_ijin_pbf" accept=".pdf">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="ijinPbfPreview" class="mb-2"></div>
                            <?php if (!empty($data['upload_ijin_pbf'])): ?>
                                <div class="mt-1 small alert alert-info py-1 px-2 d-inline-block">
                                    <i class="fas fa-file-alt me-1"></i> File Tersimpan:
                                    <a href="uploads/<?= $data['upload_ijin_pbf'] ?>" target="_blank" class="text-decoration-none fw-bold">Lihat File</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- SIPA -->
                <div class="form-section">
                    <h5 class="section-title">SIPA</h5>
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6">
                            <div class="file-upload-area" id="sipaUploadArea">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-1">Klik atau seret file SIPA ke sini</p>
                                <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                <input type="file" name="upload_sipa" class="d-none" id="upload_sipa" accept=".pdf">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="sipaPreview" class="mb-2"></div>
                            <?php if (!empty($data['upload_sipa'])): ?>
                                <div class="mt-1 small alert alert-info py-1 px-2 d-inline-block">
                                    <i class="fas fa-file-alt me-1"></i> File Tersimpan:
                                    <a href="uploads/<?= $data['upload_sipa'] ?>" target="_blank" class="text-decoration-none fw-bold">Lihat File</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Nomor SIPA</label>
                            <input type="text" name="no_sipa" class="form-control" value="<?= $data['no_sipa'] ?>">
                        </div>
                        <div class=" col-md-6 mb-3">
                            <label class="form-label fw-medium">Tanggal Berlaku SIPA</label>
                            <input type="date" name="tgl_berlaku_sipa" value="<?= $data['tgl_berlaku_sipa'] ?>" class=" form-control">
                        </div>
                    </div>


                    <!-- CDOB -->
                    <div class="form-section">
                        <h5 class="section-title">Sertifikat CDOB</h5>
                        <div class="row align-items-center mb-4">
                            <div class="col-md-6">
                                <div class="file-upload-area" id="cdobUploadArea">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-1">Klik atau seret file Sertifikat CDOB ke sini</p>
                                    <p class="file-info">Format: PDF (Maks. 5MB)</p>
                                    <input type="file" name="upload_cdob" class="d-none" id="upload_cdob" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="cdobPreview" class="mb-2"></div>
                                <?php if (!empty($data['upload_cdob'])): ?>
                                    <div class="mt-1 small alert alert-info py-1 px-2 d-inline-block">
                                        <i class="fas fa-file-alt me-1"></i> File Tersimpan:
                                        <a href="uploads/<?= $data['upload_cdob'] ?>" target="_blank" class="text-decoration-none fw-bold">Lihat File</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Nomor Sertifikat CDOB</label>
                                <input type="text" name="nomor_cdob" value="<?= $data['nomor_cdob'] ?>" class="form-control" placeholder="Masukkan nomor sertifikat" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Tanggal Berlaku Sertifikat CDOB</label>
                                <input type="date" name="tgl_berlaku_cdob" value="<?= $data['tgl_berlaku_cdob'] ?>" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg">Update Data</button>
                        <a href="index.php?page=dataperusahaan" class="btn btn-secondary">Batal</a>
                    </div>

            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup file upload areas
        const uploadAreas = [{
                area: 'nibUploadArea',
                input: 'upload_nib',
                preview: 'nibPreview'
            },
            {
                area: 'ijinPbfUploadArea',
                input: 'upload_ijin_pbf',
                preview: 'ijinPbfPreview'
            },
            {
                area: 'sipaUploadArea',
                input: 'upload_sipa',
                preview: 'sipaPreview'
            },
            {
                area: 'cdobUploadArea',
                input: 'upload_cdob',
                preview: 'cdobPreview'
            }
        ];

        uploadAreas.forEach(item => {
            const area = document.getElementById(item.area);
            const input = document.getElementById(item.input);
            const preview = document.getElementById(item.preview);

            // Cek apakah elemen ada di HTML sebelum lanjut (Mencegah Error Null)
            if (!area || !input || !preview) {
                console.warn(`Elemen tidak lengkap untuk ${item.area}. Pastikan ID HTML sudah benar.`);
                return;
            }

            // Click trigger
            area.addEventListener('click', () => input.click());

            // Drag & Drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                area.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                area.addEventListener(eventName, () => area.classList.add('dragover'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                area.addEventListener(eventName, () => area.classList.remove('dragover'), false);
            });

            area.addEventListener('drop', (e) => {
                const files = e.dataTransfer.files;
                input.files = files;
                handleFiles(files, preview, area);
            }, false);

            input.addEventListener('change', function() {
                handleFiles(this.files, preview, area);
            });
        });

        function handleFiles(files, previewElement, areaElement) {
            if (files.length > 0) {
                const file = files[0];

                // Validasi Ukuran (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal 5MB'
                    });
                    // Reset input
                    areaElement.classList.remove('border-success');
                    return;
                }

                // Update UI Visual Area
                areaElement.style.borderColor = "var(--success)";
                areaElement.style.backgroundColor = "#f0fff4";

                // Tampilkan Preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        previewElement.innerHTML = `<img src="${e.target.result}" class="document-preview shadow-sm" style="max-height:100px;">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.innerHTML = `
                        <div class="d-flex align-items-center text-success bg-white p-2 border rounded shadow-sm">
                            <i class="fas fa-file-pdf fa-2x me-2"></i>
                            <div>
                                <small class="fw-bold d-block text-truncate" style="max-width: 150px;">${file.name}</small>
                                <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                            </div>
                        </div>`;
                }
            }
        }

        // Form Submission via AJAX
        const form = document.getElementById('update_data');
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // SweetAlert Loading
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const formData = new FormData(form);

                // Pastikan path ini benar relatif dari index.php
                const response = await fetch('pages/profil/proses_update_perusahaan.php', {
                    method: 'POST',
                    body: formData
                });

                // Cek isi response mentah (untuk debugging jika PHP error)
                const rawText = await response.text();

                try {
                    // Coba parse ke JSON
                    const result = JSON.parse(rawText);

                    if (result.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data perusahaan berhasil diperbarui.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Redirect atau reload
                            window.location.href = result.redirect || 'index.php?page=profil_perusahaan';
                        });
                    } else {
                        throw new Error(result.message || 'Gagal menyimpan data.');
                    }

                } catch (jsonError) {
                    // Jika gagal parse JSON (biasanya karena ada Error PHP yang tampil)
                    console.error("Response bukan JSON:", rawText);
                    throw new Error('Terjadi kesalahan server (PHP Error). Cek console browser.');
                }

            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.message
                });
            }
        });
    });
</script>