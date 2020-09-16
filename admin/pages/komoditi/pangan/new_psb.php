<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">SERASI BBPOM di Surabaya</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-list-alt"></i> Form Permohonan Pemeriksaan Sarana Bangunan</h6>
            </div>
            <div class="card-body">
              <form class="form-group" action="pages/komoditi/pangan/action/add_psb.php" id="formpsb" method="post">
              <div class="form-group row">
                  <label for="tglmohon" class="col-sm-3 col-form-label">Tanggal Permohonan</label>
                  <div class="col-sm-9">
                    <input type="text" name="tglmohon" class="form-control-plaintext form-control-user" id="tglmohon" value="<?php echo date('d-m-Y'); ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="perihal" class="col-sm-3 col-form-label">Perihal Permohonan</label>
                  <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="perihal" id="perihal" value="produksi" required>
                        <label class="form-check-label" for="perihal">
                          Pemeriksaan Sarana Produksi
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="perihal" id="perihal" value="distribusi" required>
                        <label class="form-check-label" for="perihal">
                          Pemeriksaan Sarana Distribusi
                        </label>
                    </div>
                  </div>
              </div>

              <hr>

              <div class="form-group row">
                  <label for="namapemohon" class="col-sm-3 col-form-label">Nama Pemohon</label>
                  <div class="col-sm-9">
                    <input type="text" name="namapemohon" class="form-control-plaintext form-control-user" id="namapemohon" value="<?php echo $det['nama_detail'] ?>" readonly>
                    <input type="hidden" name="idpemohon" class="form-control-plaintext form-control-user" id="idpemohon" value="<?php echo $det['id_detail'] ?>">
                    <input type="hidden" id="idkomoditi" name="idkomoditi" value="<?php echo $det['id_komoditi']; ?>">
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamatpemohon" class="col-sm-3 col-form-label">Alamat Pemohon</label>
                  <div class="col-sm-9">
                    <input type="text" name="alamatpemohon" class="form-control-plaintext form-control-user" id="alamatpemohon" value="<?php echo $det['alamat_detail'] ?>" readonly>
                  </div>
              </div>

              <hr>

              <div class="form-group row">
                  <label for="namaperusahaan" class="col-sm-3 col-form-label">Nama Perusahaan</label>
                  <div class="col-sm-9">
                    <input type="text" name="namaperusahaan" class="form-control-plaintext form-control-user" id="namaperusahaan" value="<?php echo $det['nama_perusahaan'] ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamatperusahaan" class="col-sm-3 col-form-label">Alamat</label>
                  <div class="col-sm-9">
                    <input type="text" name="alamatperusahaan" class="form-control-plaintext form-control-user" id="alamatperusahaan" value="<?php echo $det['alamat_perusahaan'] ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelpperusahaan" class="col-sm-3 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-9">
                    <input type="text" name="notelpperusahaan" class="form-control-plaintext form-control-user" id="notelpperusahaan" value="<?php echo $det['notelp_perusahaan'] ?>" readonly>
                  </div>
              </div>

              <hr>

              <div class="form-group row">
                  <label for="namagudang" class="col-sm-3 col-form-label">Nama Pabrik/Gudang</label>
                  <div class="col-sm-9">
                    <input type="text" name="namagudang" class="form-control-plaintext form-control-user" id="namagudang" value="<?php echo $det['nama_gudang'] ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamatgudang" class="col-sm-3 col-form-label">Alamat</label>
                  <div class="col-sm-9">
                    <input type="text" name="alamatgudang" class="form-control-plaintext form-control-user" id="alamatgudang" value="<?php echo $det['alamat_gudang'] ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelpgudang" class="col-sm-3 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-9">
                    <input type="text" name="notelpgudang" class="form-control-plaintext form-control-user" id="notelpgudang" value="<?php echo $det['notelp_gudang'] ?>" readonly>
                  </div>
              </div>

              <hr>

              <div class="form-group row">
                  <label for="jenispangan" class="col-sm-3 col-form-label">Jenis Pangan (Kemasan)</label>
                  <div class="col-sm-7">
                    <input type="text" name="jenispangan" class="form-control form-control-user" id="jenispangan" required>
                    <span class="badge badge-warning">Jika lebih dari satu, pisahkan dengan tanda , (koma)</span>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="namacp" class="col-sm-3 col-form-label">Nama Contact Person</label>
                  <div class="col-sm-5">
                    <input type="text" name="namacp" class="form-control form-control-user" id="namacp" required>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelpcp" class="col-sm-3 col-form-label">Nomor Telepon/HP</label>
                  <div class="col-sm-5">
                    <input type="number" name="notelpcp" class="form-control form-control-user" id="notelpcp" required>
                  </div>
              </div>

              <hr>

              <div class="form-group row">
                  <label for="audit" class="col-sm-3 col-form-label">Pilihan Pemeriksaan</label>
                  <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="audit" id="audit" value="onsite" required>
                        <label class="form-check-label" for="audit">
                          Onsite (Pegawai Balai datang ke tempat Anda)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="audit" id="audit" value="online" required>
                        <label class="form-check-label" for="audit">
                          Online (Melalui Aplikasi Video Conference)
                        </label>
                    </div>
                  </div>
              </div>

              <hr>

                <div style="width: 100%; text-align: center;">
                  <button type="submit" class="btn btn-success">Kirim Pengajuan <i class="fa fa-chevron-right"></i></button> 
                      <a href="./index.php?page=2121" class="btn btn-danger">Batal</a>
              </div>
            </form>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->