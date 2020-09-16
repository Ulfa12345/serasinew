<?php
$profil=$conn -> query("SELECT * FROM tbl_detail_client
  INNER JOIN tbl_perusahaan ON tbl_detail_client.id_perusahaan=tbl_perusahaan.id_perusahaan
  INNER JOIN tbl_gudang ON tbl_detail_client.id_gudang=tbl_gudang.id_gudang
  WHERE id_detail = '".$_SESSION['id_detail']."'");
$pro = mysqli_fetch_array($profil);
?>
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-user-md"></i>
              <h3> Profil Pengguna</h3>
            </div>
            <a href="#editPenggunaModal" class="pull-right btn btn-primary" type="button" id="7" title="Edit Profil Pengguna" data-toggle="modal" data-id="<?php echo $pro['id_detail'] ?>"><i class="icon-edit"></i> Ubah Data</a>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                      <span class="span4">Username</span>
                      <div class="span7"><?php echo $pro['username']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Nama Lengkap</span>
                      <div class="span7"><?php echo $pro['nama_detail']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Alamat</span>
                      <div class="span7"><?php echo $pro['alamat_detail']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Jabatan</span>
                      <div class="span7"><?php echo $pro['jabatan_detail']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Email</span>
                      <div class="span7"><?php echo $pro['email']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Nomor Telepon/HP</span>
                      <div class="span7"><?php echo $pro['notelp_detail']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Password</span>
                      <div class="span7">*******</div>
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-sitemap"></i>
              <h3> Data Perusahaan</h3>
            </div>
            <a href="#editPerusahaanModal" class="pull-right btn btn-primary" type="button" id="edit" title="Edit Data Perusahaan" data-toggle="modal" data-id="<?php echo $pro['id_detail'] ?>"><i class="icon-edit"></i> Ubah Data</a>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                      <span class="span4">Nama Perusahaan</span>
                      <div class="span7"><?php echo $pro['nama_perusahaan'] == '0' ? '' : $pro['nama_perusahaan']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">NPWP</span>
                      <div class="span7"><?php echo $pro['npwp_perusahaan'] == '0' ? '' : $pro['npwp_perusahaan']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Alamat</span>
                      <div class="span7"><?php echo $pro['alamat_perusahaan'] == '0' ? '' : $pro['alamat_perusahaan']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Nomor Telepon/HP</span>
                      <div class="span7"><?php echo $pro['notelp_perusahaan'] == '0' ? '' : $pro['notelp_perusahaan']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Keterangan</span>
                      <div class="span7"><?php echo $pro['ket_perusahaan'] == '0' ? '' : $pro['ket_perusahaan']; ?></div>
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
        <div class="span12">
          <div class="widget widget-nopad">
            <div class="widget-header"> <i class="icon-truck"></i>
              <h3> Data Gudang</h3>
            </div>
            <a href="#editGudangModal" class="pull-right btn btn-primary" type="button" id="edit" title="Edit Data Gudang" data-toggle="modal" data-id="<?php echo $pro['id_detail'] ?>"><i class="icon-edit"></i> Ubah Data</a>
            <!-- /widget-header -->
            <div class="widget-content">
              <div class="widget big-stats-container">
                <div class="widget-content">
                  <div id="big_stats" class="cf">
                      <span class="span4">Nama Gudang</span>
                      <div class="span7"><?php echo $pro['nama_gudang'] == '0' ? '' : $pro['nama_gudang']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">NPWP</span>
                      <div class="span7"><?php echo $pro['npwp_gudang'] == '0' ? '' : $pro['npwp_gudang']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Alamat</span>
                      <div class="span7"><?php echo $pro['alamat_gudang'] == '0' ? '' : $pro['alamat_gudang']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Nomor Telepon/HP</span>
                      <div class="span7"><?php echo $pro['notelp_gudang'] == '0' ? '' : $pro['notelp_gudang']; ?></div>
                  </div>
                  <div id="big_stats" class="cf">
                      <span class="span4">Keterangan</span>
                      <div class="span7"><?php echo $pro['ket_gudang'] == '0' ? '' : $pro['ket_gudang']; ?></div>
                  </div>
                </div>
                <!-- /widget-content --> 
                
              </div>
            </div>
          </div>
          <!-- /widget -->
        </div>
        <!-- /span6 --> 
      </div>
      <!-- /row --> 
    </div>
    <!-- /container --> 
  </div>
  <!-- /main-inner --> 
</div>
<!-- /main -->

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
                    Edit Data Perusahaan
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
                    Edit Data Gudang
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


<script src="js/jquery.min.js"></script> 
<script src="bootstrap/js/bootstrap.bundle.min.js"></script> 

<script type="text/javascript">
    $(document).ready(function(){
        $('#editPenggunaModal').on('show.bs.modal', function (e) {
            var rowl = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/profilmodal.php',
                data :  'row='+rowl,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                console.log(data);
                }
            });
         });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
        $('#editPerusahaanModal').on('show.bs.modal', function (e) {
            var rows = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/perusahaanmodal.php',
                data :  'row='+ rows,
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
            var rowq = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/profil/gudangmodal.php',
                data :  'row='+ rowq,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>