<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">SERASI BBPOM di Surabaya</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-user"></i> Profil Pengguna</h6>
            </div>
            <div class="card-body">
              
              <div class="form-group row">
                  <label for="username" class="col-sm-4 col-form-label">Username</label>
                  <div class="col-sm-8">
                    <input type="text" name="username" class="form-control-plaintext form-control-user" id="username" value="<?php echo $det['username']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-8">
                    <input type="text" name="nama" class="form-control-plaintext form-control-user" id="nama" value="<?php echo $det['nama_detail']; ?>"readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamat" class="form-control-plaintext form-control-user" id="alamat" value="<?php echo $det['alamat_detail']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
                  <div class="col-sm-8">
                    <input type="text" name="jabatan" class="form-control-plaintext form-control-user" id="alamat" value="<?php echo $det['jabatan_detail']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="email" class="col-sm-4 col-form-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" name="email" class="form-control-plaintext form-control-user" id="email" value="<?php echo $det['email']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelp" class="col-sm-4 col-form-label">No. Telepon/HP</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelp" class="form-control-plaintext form-control-user" id="notelp" value="<?php echo $det['notelp_detail']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="pswd" class="col-sm-4 col-form-label">Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="pswd" class="form-control-plaintext form-control-user" id="pswd" value="<?php echo $det['password']; ?>" readonly>
                  </div>
              </div>

                <div style="width: 100%; text-align: center;">
                  <a href="#editPenggunaModal" class="btn btn-success" type="button" id="edit" title="Edit Profil Pengguna" data-toggle="modal" data-id="<?php echo $det['id_detail'] ?>"><i class="fa fa-edit"></i> Ubah Data</a>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-sitemap"></i> Profil Perusahaan</h6>
            </div>
            <div class="card-body">
              
              <div class="form-group row">
                  <label for="namaperusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                  <div class="col-sm-8">
                    <input type="text" name="namaperusahaan" class="form-control-plaintext form-control-user" id="namaperusahaan" value="<?php echo $det['nama_perusahaan'] == '0' ? '' : $det['nama_perusahaan']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="npwpperusahaan" class="col-sm-4 col-form-label">NPWP</label>
                  <div class="col-sm-8">
                    <input type="text" name="npwpperusahaan" class="form-control-plaintext form-control-user" id="npwpperusahaan" value="<?php echo $det['npwp_perusahaan'] == '0' ? '' : $det['npwp_perusahaan']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamatperusahaan" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamatperusahaan" class="form-control-plaintext form-control-user" id="alamatperusahaan" value="<?php echo $det['alamat_perusahaan'] == '0' ? '' : $det['alamat_perusahaan']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelpperusahaan" class="col-sm-4 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelpperusahaan" class="form-control-plaintext form-control-user" id="notelpperusahaan" value="<?php echo $det['notelp_perusahaan'] == '0' ? '' : $det['notelp_perusahaan']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="ketperusahaan" class="col-sm-4 col-form-label">Keterangan</label>
                  <div class="col-sm-8">
                    <input type="text" name="ketperusahaan" class="form-control-plaintext form-control-user" id="ketperusahaan" value="<?php echo $det['ket_perusahaan'] == '0' ? '' : $det['ket_perusahaan']; ?>" readonly>
                  </div>
              </div>

                <div style="width: 100%; text-align: center;">
                  <a href="#editPerusahaanModal" class="btn btn-success" type="button" id="edit" title="Edit Profil Pengguna" data-toggle="modal" data-id="<?php echo $det['id_detail'] ?>"><i class="fa fa-edit"></i> Ubah Data</a>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-truck"></i> Profil Pabrik/Gudang</h6>
            </div>
            <div class="card-body">
              
              <div class="form-group row">
                  <label for="namagudag" class="col-sm-4 col-form-label">Nama Gudang</label>
                  <div class="col-sm-8">
                    <input type="text" name="namagudang" class="form-control-plaintext form-control-user" id="namagudang" value="<?php echo $det['nama_gudang'] == '0' ? '' : $det['nama_gudang']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="npwpgudang" class="col-sm-4 col-form-label">NPWP</label>
                  <div class="col-sm-8">
                    <input type="text" name="npwpgudang" class="form-control-plaintext form-control-user" id="npwpgudang" value="<?php echo $det['npwp_gudang'] == '0' ? '' : $det['npwp_gudang']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="alamatgudang" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamatgudang" class="form-control-plaintext form-control-user" id="alamatgudang" value="<?php echo $det['alamat_gudang'] == '0' ? '' : $det['alamat_gudang']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="notelpgudang" class="col-sm-4 col-form-label">Nomor Telepon</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelpgudang" class="form-control-plaintext form-control-user" id="notelpgudang" value="<?php echo $det['notelp_gudang'] == '0' ? '' : $det['notelp_gudang']; ?>" readonly>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="ketgudang" class="col-sm-4 col-form-label">Keterangan</label>
                  <div class="col-sm-8">
                    <input type="text" name="ketgudang" class="form-control-plaintext form-control-user" id="ketgudang" value="<?php echo $det['ket_gudang'] == '0' ? '' : $det['ket_gudang']; ?>" readonly>
                  </div>
              </div>

                <div style="width: 100%; text-align: center;">
                  <a href="#editGudangModal" class="btn btn-success" type="button" id="edit" title="Edit Profil Pengguna" data-toggle="modal" data-id="<?php echo $det['id_detail'] ?>"><i class="fa fa-edit"></i> Ubah Data</a>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


  <div class="modal fade" id="editPenggunaModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Edit Profil Pengguna
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPerusahaanModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Edit Profil Perusahaan
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="editGudangModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Edit Profil Pabrik/Gudang
                </div>
                <div class="modal-body">
                    <div class="fetched-data"></div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>

        <script src="vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#editPenggunaModal').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/profilmodal.php',
                data :  'row='+ row,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
        $('#editPerusahaanModal').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/perusahaanmodal.php',
                data :  'row='+ row,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
        $('#editGudangModal').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/gudangmodal.php',
                data :  'row='+ row,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>