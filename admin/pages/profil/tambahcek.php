<!-- Button Trigger Modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGudangModal">
  + Tambah Gudang
</button>

<!-- Modal -->
<div class="modal fade" id="tambahGudangModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Gudang Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formTambahGudang">
        <div class="modal-body">
          <div class="mb-3">
            <label for="id_perusahaan" class="form-label">ID Perusahaan</label>
            <input type="number" class="form-control" id="id_perusahaan" name="id_perusahaan" required>
          </div>
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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
  $('#formTambahGudang').submit(function(e) {
    e.preventDefault();
    
    $.ajax({
      url: 'proses_tambahgudang.php',
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

</script>