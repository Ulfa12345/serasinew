<?php
$detail_psb=$conn -> query("SELECT * FROM tbl_psb_pangan
                                INNER JOIN tbl_detail_client ON tbl_psb_pangan.id_detail=tbl_detail_client.id_detail
                                WHERE tbl_psb_pangan.id_detail = '".$_SESSION['id_detail']."'");
?>

<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">SERASI BBPOM di Surabaya</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-credit-card"></i> Data Permohonan Pemeriksaan Sarana Bangunan</h6>
            </div>
            <div class="card-body">
              <a href="./index.php?page=new_psb" class="btn btn-primary" type="button" id="tambah" title="Tambah Data PSB"><i class="fa fa-plus"></i> Ajukan PSB</a><br><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                  <thead>
                    <tr class="bg-success text-light">
                      <th>Tanggal Pengajuan</th>
                      <th>Jenis Sarana</th>
                      <th>Jenis Pangan</th>
                      <th>Status</th>
                      <th style="width:200px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while($detpsb = mysqli_fetch_array($detail_psb)){
                    ?>
                    <tr>
                      <td><?php echo $detpsb['tgl_psb']; ?></td>
                      <td style="text-transform: capitalize;"><?php echo $detpsb['perihal_psb']; ?></td>
                      <td style="text-transform: capitalize;"><?php echo $detpsb['jenispangan']; ?></td>
                      <td>
                        <?php
                          if ($detpsb['status_psb'] == '0'){
                            echo "<span class='badge badge-success'>Data Profil Lengkap</span><br>";
                            echo "<span class='badge badge-warning'>Belum Upload Dokumen</span>";
                          }
                          else if($detpsb['status_psb'] == '1'){
                            echo "<span class='badge badge-success'>Data Profil Lengkap</span><br>";
                            echo "<span class='badge badge-success'>Dokumen Lengkap</span><br>"; 
                            echo "<span class='badge badge-warning'>Tanggal Pemeriksaan Belum Ditentukan</span>"; 
                          }
                          else if($detpsb['status_psb'] == '2'){
                            echo "<span class='badge badge-success'>Data Profil Lengkap</span><br>";
                            echo "<span class='badge badge-success'>Dokumen Lengkap</span><br>"; 
                            echo "<span class='badge badge-success'>Tanggal Pemeriksaan Sudah Ditentukan</span>"; 
                            echo "<span class='badge badge-warning'>Menunggu Konfirmasi</span>"; 
                          }
                          else if($detpsb['status_psb'] == '3'){
                            echo "<span class='badge badge-success'>Data Profil Lengkap</span><br>";
                            echo "<span class='badge badge-success'>Dokumen Lengkap</span><br>"; 
                            echo "<span class='badge badge-success'>Tanggal Pemeriksaan Sudah Ditentukan</span><br>"; 
                            echo "<span class='badge badge-success'>Tanggal Sudah dikonfirmasi</span><br>"; 
                            echo "<span class='badge badge-primary'>PSB Sarana Anda sudah dijadwalkan</span>"; 
                          }
                          else if($detpsb['status_psb'] == '4'){
                            echo "<span class='badge badge-success'>Data Profil Lengkap</span><br>";
                            echo "<span class='badge badge-success'>Dokumen Lengkap</span><br>"; 
                            echo "<span class='badge badge-success'>Tanggal Pemeriksaan Sudah Ditentukan</span><br>"; 
                            echo "<span class='badge badge-success'>Tanggal Sudah dikonfirmasi</span><br>"; 
                            echo "<span class='badge badge-danger'>Pengajuan Anda Belum diterima</span>"; 
                          }
                        ?>
                      </td>
                      <td>
                          <?php
                          if ($detpsb['status_psb'] == '0'){
                            if($detpsb['perihal_psb'] == 'produksi'){
                          ?>
                          <a href="index.php?page=docprod&id=<?=$detpsb['id_psb'];?>" class="btn btn-warning" type="button" id="uploadproduksi" title="Upload Data PSB Produksi"><i class="fa fa-upload"></i></a>&nbsp;
                          <?php
                            } else if($detpsb['perihal_psb'] == 'distribusi'){
                          ?>
                          <a href="index.php?page=docdist&id=<?=$detpsb['id_psb'];?>" class="btn btn-warning" type="button" id="uploaddistribusi" title="Upload Data PSB Distribusi"><i class="fa fa-upload"></i></a>&nbsp;
                          <?php
                            }} else if ($detpsb['status_psb'] == '1'){
                          ?>
                          <a href="#tanggalperiksa" class="btn btn-primary" type="button" id="tanggalperiksa<?php echo $detpsb['id_psb']; ?>" title="Tetapkan Tanggal Pemeriksaan" data-toggle="modal" data-id="<?php echo $detpsb['id_psb']; ?>"><i class="fa fa-calendar"></i></a>&nbsp;
                        <?php } else if ($detpsb['status_psb'] == '2'){ ?>
                          <a href="#" class="btn btn-primary" type="button" id="preview" title="Lihat Hasil Konfirmasi PSB" data-toggle="modal" data-id=""><i class="fa fa-eye"></i></a>&nbsp;
                        <?php } else if ($detpsb['status_psb'] == '3'){ ?>
                          <a href="pages/komoditi/pangan/print_form.php?id=<?=$detpsb['id_psb'];?>" target="_blank" class="btn btn-primary" type="button" id="download" title="Download Form"><i class="fa fa-download"></i></a>&nbsp;
                        <?php } ?>
                          <a href="#konfirmasipsb" class="btn btn-warning" type="button" id="konfirmasipsb<?php echo $detpsb['id_psb']; ?>" title="Konfirmasi Tanggal Pemeriksaan" data-toggle="modal" data-id="<?php echo $detpsb['id_psb']; ?>"><i class="fa fa-edit"></i></a>&nbsp;
                          <!-- <a href="pages/komoditi/pangan/action/del_psb.php?id=<?=$detpsb['id_psb'];?>" class="btn btn-danger dsabled" role="button" title="Hapus Data Driver" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class="fa fa-trash"></i></a> -->
                      </td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <div class="modal fade" id="tanggalperiksa" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Tanggal Pemeriksaan
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

    <div class="modal fade" id="konfirmasipsb" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Konfirmasi Tanggal Pemeriksaan
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

 <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
        $('#tanggalperiksa').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/komoditi/pangan/modal/tgl_psb.php',
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
        $('#konfirmasipsb').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/komoditi/pangan/modal/konfirmasi_psb.php',
                data :  'row='+ row,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>