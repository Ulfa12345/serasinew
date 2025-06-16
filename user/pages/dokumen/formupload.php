<?php
$id_perusahaan = $_SESSION['id_perusahaan'] ?? null;

if (!$id_perusahaan) {
    die("Anda harus login terlebih dahulu.");
}

// Ambil data pengajuan
$sql = "SELECT * FROM tb_dokumen WHERE id_perusahaan = ? ORDER BY tanggal_pengajuan DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_perusahaan);
$stmt->execute();
$result = $stmt->get_result();
$dok = $result->fetch_assoc();
$stmt->close();

//$server_path_denah = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/admin/pages/dokumen/uploads/' . basename($dok['upload_denahbaru']);
//$web_path_denah = '/serasinew/admin/pages/dokumen/uploads/' . basename($dok['upload_denahbaru']);

?>
<div class="container-fluid">

    <h3 class="mb-4">Form Pengajuan Dokumen dan Denah</h3>
    <div class="card shadow-lg">
        <div class="card-body">
            <form method="POST" id="uploadForm" enctype="multipart/form-data">
                <!-- Jenis Pengajuan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Pengajuan <span class="text-danger">*</span></label>
                            <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                                <option value="" selected disabled>Pilih jenis pengajuan</option>
                                <option value="Permohonan Baru">Permohonan Baru</option>
                                <option value="Perubahan Denah">Perubahan Denah</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Info Boxes -->
                <div class="alert alert-info mb-4" id="infoPermohonanBaru" style="display: none;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Permohonan Baru:</strong> Mengajukan denah baru untuk pertama kali
                </div>

                <div class="alert alert-info mb-4" id="infoPerubahanDenah" style="display: none;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Perubahan Denah:</strong>
                    Sistem akan otomatis menyimpan denah sebelumnya sebagai denah lama
                </div>

                <!-- Dokumen Wajib -->
                <div class="mb-4">
                    <h5 class="mb-3 pb-2 border-bottom"><i class="fas fa-file-alt me-2 text-primary"></i>Upload Dokumen </h5>

                    <div class="mb-3 border rounded p-3 bg-light">
                        <label class="form-label fw-medium">SIPA</label> 
                        <input type="file" class="form-control" name="upload_sipa" accept=".pdf,.jpg,.png">
                        <div class="form-text">Format: PDF, JPG, atau PNG (maks. 5MB)</div>
                    </div>

                    <div class="mb-3 border rounded p-3 bg-light">
                        <label class="form-label fw-medium">Izin PBF</label>
                        <input type="file" class="form-control" name="upload_ijin_pbf" accept=".pdf,.jpg,.png" required>
                        <div class="form-text">Format: PDF, JPG, atau PNG (maks. 5MB)</div>
                    </div>

                    <div class="mb-3 border rounded p-3 bg-light">
                        <label class="form-label fw-medium">Surat Permohonan</label>
                        <span class="badge badge-warning"><a href="/serasi/user/img/Surat Permohonan.docx" target="_blank">Format Surat Permohonan</a></span>
                        <input type="file" class="form-control" name="upload_suratpermohonan" accept=".pdf,.jpg,.png" required>
                        <div class="form-text">Format: PDF, JPG, atau PNG (maks. 5MB)</div>
                    </div>

                    <div class="mb-3 border rounded p-3 bg-light">
                        <label class="form-label fw-medium">Surat Pernyataan</label>
                        
                        <span class="badge badge-warning"><a href="/serasi/user/img/Surat Pernyataan.docx" target="_blank">Format Surat Pernyataan</a></span>
                        <input type="file" class="form-control" name="upload_suratpernyataan" accept=".pdf,.jpg,.png" required>
                        <div class="form-text">Format: PDF, JPG, atau PNG (maks. 5MB)</div>
                    </div>
                </div>

                <!-- Upload Denah -->
                <div class="mb-4">
                    <h5 class="mb-3 pb-2 border-bottom"><i class="fas fa-map me-2 text-primary"></i>Upload Denah</h5>

                    <div class="mb-3 border rounded p-3 bg-light">
                        <label class="form-label fw-medium" id="denahLabel">Upload Denah Baru</label>
                        <span class="badge badge-warning"><a href="/serasi/user/img/Format Denah.docx" target="_blank">Format Denah</a></span>
                        <input type="file" class="form-control" name="upload_denahbaru" accept=".jpg,.png" required>
                        <div class="form-text mt-2">
                            <span id="denahInfo">Denah untuk lokasi baru</span> | Format: JPG atau PNG (maks. 5MB)
                        </div>
                    </div>

                    <div class="alert alert-warning" id="denahLamaInfo" style="display: none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Denah lama akan otomatis diambil dari pengajuan terakhir
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="d-grid mt-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    // Tampilkan info berdasarkan jenis pengajuan
    const jenisPengajuan = document.getElementById('jenis_pengajuan');
    const infoPermohonanBaru = document.getElementById('infoPermohonanBaru');
    const infoPerubahanDenah = document.getElementById('infoPerubahanDenah');
    const denahLamaInfo = document.getElementById('denahLamaInfo');
    const denahLabel = document.getElementById('denahLabel');
    const denahInfo = document.getElementById('denahInfo');

    jenisPengajuan.addEventListener('change', function() {
        if (this.value === 'Permohonan Baru') {
            infoPermohonanBaru.style.display = 'none';
            infoPerubahanDenah.style.display = 'none';
            denahLamaInfo.style.display = 'none';
            denahLabel.textContent = 'Upload Denah Baru';
            denahInfo.textContent = 'Denah untuk lokasi baru';
        } else if (this.value === 'Perubahan Denah') {
            infoPermohonanBaru.style.display = 'none';
            infoPerubahanDenah.style.display = 'block';
            denahLamaInfo.style.display = 'block';
            denahLabel.textContent = 'Upload Denah Baru (Perubahan)';
            denahInfo.textContent = 'Denah baru setelah perubahan';
        }
    });

    //uploadForm

   $(document).ready(function() {
    // Tangani submit form
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'pages/dokumen/proses_upload_dok.php',
            type: 'POST',
            data: new FormData(this), // Gunakan FormData untuk handle file upload
            contentType: false,       // Penting untuk FormData
            processData: false,      // Penting untuk FormData
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        window.location.href = "index.php?page=data_dokumen";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengirim data';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message
                });
            }
        });
    });
});
</script>