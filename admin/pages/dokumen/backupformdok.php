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

$server_path_denah = $_SERVER['DOCUMENT_ROOT'] . '/serasinew/admin/pages/dokumen/uploads/' . basename($dok['upload_denahbaru']);
$web_path_denah = '/serasinew/admin/pages/dokumen/uploads/' . basename($dok['upload_denahbaru']);
                        
?>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Form Pengajuan Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Jenis Pengajuan</label>
                                <select class="form-select" id="jenis_pengajuan" name="jenis_pengajuan" required>
                                    <option value="" selected disabled>Pilih jenis pengajuan</option>
                                    <option value="Permohonan Baru">Permohonan Baru</option>
                                    <option value="Perubahan Denah">Perubahan Denah</option>
                                </select>
                            </div>
                            
                            <div class="info-box" id="infoPermohonanBaru" style="display: none;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Permohonan Baru:</strong> Mengajukan denah baru untuk pertama kali
                            </div>
                            
                            <div class="info-box" id="infoPerubahanDenah" style="display: none;">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Perubahan Denah:</strong> 
                                Sistem akan otomatis menyimpan denah terakhir sebagai denah lama
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="mb-3">Upload Dokumen Wajib</h6>
                                
                                <div class="upload-field">
                                    <label class="form-label">SIPA</label>
                                    <input type="file" class="form-control" name="upload_sipa" accept=".pdf,.jpg,.png" required>
                                </div>
                                
                                <div class="upload-field">
                                    <label class="form-label">Izin PBF</label>
                                    <input type="file" class="form-control" name="upload_ijin_pbf" accept=".pdf,.jpg,.png" required>
                                </div>
                                
                                <div class="upload-field">
                                    <label class="form-label">Surat Permohonan</label>
                                    <input type="file" class="form-control" name="upload_suratpermohonan" accept=".pdf,.jpg,.png" required>
                                </div>
                                
                                <div class="upload-field">
                                    <label class="form-label">Surat Pernyataan</label>
                                    <input type="file" class="form-control" name="upload_suratpernyataan" accept=".pdf,.jpg,.png" required>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="mb-3">Upload Denah</h6>
                                
                                <div class="upload-field">
                                    <label class="form-label" id="denahLabel">Upload Denah Baru</label>
                                    <input type="file" class="form-control" name="upload_denahbaru" accept=".jpg,.png" required>
                                    <div class="form-text mt-2">
                                        <span id="denahInfo">Denah untuk lokasi baru</span>
                                    </div>
                                </div>
                                
                                <div class="upload-field" id="denahLamaInfo" style="display: none; background-color: #fff8e1;">
                                    <label class="form-label">Informasi Denah Lama</label>
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Denah lama akan otomatis diambil dari pengajuan terakhir
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-submit btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
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
                infoPermohonanBaru.style.display = 'block';
                infoPerubahanDenah.style.display = 'none';
                denahLamaInfo.style.display = 'none';
                denahLabel.textContent = 'Upload Denah Baru';
                denahInfo.textContent = 'Denah untuk lokasi baru';
            } 
            else if (this.value === 'Perubahan Denah') {
                infoPermohonanBaru.style.display = 'none';
                infoPerubahanDenah.style.display = 'block';
                denahLamaInfo.style.display = 'block';
                denahLabel.textContent = 'Upload Denah Baru (Perubahan)';
                denahInfo.textContent = 'Denah baru setelah perubahan';
            }
        });
    </script>