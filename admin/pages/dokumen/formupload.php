<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                <i class="fa fa-warehouse"></i> Form Pengajuan Dokumen
            </h6>
        </div>
        <div class="card-body">
            <form id="formPengajuanDokumen" method="POST" action="pages/dokumen/proses_upload.php" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                        <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                            <option value="" selected disabled>Pilih jenis pengajuan</option>
                            <option value="Permohonan Baru">Permohonan Baru</option>
                            <option value="Perubahan Denah">Perubahan Denah</option>
                        </select>
                    </div>
                </div>

                <div class="row" id="uploadFields">
                    <div class="col-md-6 mb-3 upload-field" id="field_sipa">
                        <label class="form-label">Upload SIPA</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_sipa" accept=".pdf,.jpg,.png">
                    </div>

                    <div class="col-md-6 mb-3 upload-field" id="field_ijin_pbf">
                        <label class="form-label">Upload Izin PBF</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_ijin_pbf" accept=".pdf,.jpg,.png">
                    </div>

                    <div class="col-md-6 mb-3 upload-field" id="field_permohonan">
                        <label class="form-label">Upload Surat Permohonan</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_suratpermohonan" accept=".pdf,.jpg,.png">
                    </div>

                    <div class="col-md-6 mb-3 upload-field" id="field_denah_baru">
                        <label class="form-label">Upload Denah Baru</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_denahbaru" accept=".pdf,.jpg,.png">
                    </div>

                    <div class="col-md-6 mb-3 upload-field" id="field_pernyataan">
                        <label class="form-label">Upload Surat Pernyataan</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_suratpernyataan" accept=".pdf,.jpg,.png">
                    </div>

                    <div class="col-md-6 mb-3 upload-field" id="field_denah_lama">
                        <label class="form-label">Upload Denah Lama</label> ||
                        <a href="contoh/contoh_nib.pdf" target="_blank">Contoh Download Disini</a>
                        <input type="file" class="form-control" name="upload_denahlama" accept=".pdf,.jpg,.png">
                    </div>

                    
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MENAMPILKAN FIELD BERDASARKAN PILIHAN -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisPengajuan = document.getElementById('jenis_pengajuan');
        const fields = {
            sipa: document.getElementById('field_sipa'),
            ijin_pbf: document.getElementById('field_ijin_pbf'),
            permohonan: document.getElementById('field_permohonan'),
            pernyataan: document.getElementById('field_pernyataan'),
            denah_lama: document.getElementById('field_denah_lama'),
            denah_baru: document.getElementById('field_denah_baru')
        };

        function hideAllFields() {
            Object.values(fields).forEach(field => field.style.display = 'none');
        }

        function showFieldsFor(value) {
            hideAllFields();
            if (value === 'Perubahan Denah') {
                fields.sipa.style.display = 'block';
                fields.ijin_pbf.style.display = 'block';
                fields.permohonan.style.display = 'block';
                fields.pernyataan.style.display = 'block';
                fields.denah_baru.style.display = 'block';
                fields.denah_lama.style.display = 'block';
            } else if (value === 'Permohonan Baru') {
                fields.sipa.style.display = 'block';
                fields.ijin_pbf.style.display = 'block';
                fields.permohonan.style.display = 'block';
                fields.pernyataan.style.display = 'block';
                fields.denah_baru.style.display = 'block';
            }
        }

        jenisPengajuan.addEventListener('change', function () {
            showFieldsFor(this.value);
        });

        hideAllFields(); // Inisialisasi dengan menyembunyikan semua
    });
</script>
