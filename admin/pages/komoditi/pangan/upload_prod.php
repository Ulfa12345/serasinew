<?php
$detail_prod=$conn -> query("SELECT * FROM tbl_psb_pangan
                            INNER JOIN tbl_detail_client ON tbl_psb_pangan.id_detail=tbl_detail_client.id_detail
                            WHERE tbl_psb_pangan.id_detail = '".$_SESSION['id_detail']."'
                            AND tbl_psb_pangan.perihal_psb = 'produksi'
                            AND tbl_psb_pangan.id_psb = '".$_GET['id']."'"
                        );


$detprod = mysqli_fetch_array($detail_prod);

$detail_doc = $conn -> query("SELECT * FROM tbl_doc_psb_pangan
                              INNER JOIN tbl_doc ON tbl_doc_psb_pangan.id_doc=tbl_doc.id_doc
                              WHERE tbl_doc_psb_pangan.id_psb = '".$_GET['id']."'");
?>

<!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-success"><i class="fa fa-credit-card"></i> Dokumen Permohonan Pemeriksaan Sarana Bangunan (Produksi)</h6>
            </div>
            <div class="card-body">
            	<div class="form-group row bg-secondary text-light">
                  <label for="tglmohon" class="col-sm-5 col-form-label">Tanggal Pengajuan Permohonan</label>
                  <div class="col-sm-7">
                    <input type="text" name="tglmohon" class="form-control-plaintext form-control-user text-light" id="tglmohon" value="<?php echo $detprod['tgl_psb']; ?>" readonly>
                  </div>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered" id="docTable" cellspacing="0">
                  <thead>
                    <tr class="bg-success text-light">
                      <th>ID Dokumen</th>
                      <th>Jenis Dokumen</th>
                      <th>Status</th>
                      <th style="width:200px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while($prod = mysqli_fetch_array($detail_doc)){
                    ?>
                    <tr>
                      <td><?php echo $prod['id_doc']; ?></td>
                      <td><?php echo $prod['jenis_doc']; ?><br><small><?php echo $prod['ket_doc']; ?></small></td>
                      <td>
                        <?php
                          if($prod['status'] == '0'){
                            echo "<span class='badge badge-danger'>Dokumen belum lengkap</span>";
                          } else if($prod['status'] = '1'){
                            echo "<span class='badge badge-warning'>Dokumen Dalam Proses Validasi</span>";
                          } else if($prod['status'] = '2'){
                            echo "<span class='badge badge-success'>Dokumen Lengkap</span>";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($prod['link_doc'] != '0'){
                        ?>
                      	<a href="#lihatDokumen" class="btn btn-xs btn-light" type="button" id="preview<?php echo $prod['id_doc_psb']; ?>" title="Preview Data PSB" data-toggle="modal" data-id="<?php echo $prod['id_doc_psb']; ?>">Lihat Dokumen</a>&nbsp;
                        <?php
                          } else{
                        ?>
                      	<a href="#uploadDokumen" class="btn btn-xs btn-primary" type="button" id="unggah<?php echo $prod['id_doc_psb']; ?>" title="Upload Data PSB" data-toggle="modal" data-id="<?php echo $prod['id_doc_psb']; ?>">Unggah Dokumen</a>&nbsp;
                        <?php
                          }
                        ?>
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

      <div class="modal fade" id="uploadDokumen" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Upload Dokumen
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

    <div class="modal fade" id="lihatDokumen" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header bg-success text-light">
                    Preview Dokumen
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
    var t = $('#docTable').DataTable({
      "searching" : true,
      "order" : [[0,'asc']],
      "bSort" : false,
      "language": {
        "search" : '<i class="fa fa-filter" aria-hidden="true"></i>',
        //"search" : "_INPUT_", //To remove Search Label
        "searchPlaceholder" : "Cari..."
  		},
  		"columnDefs": [
		    {   "targets": [0],
		        "visible": false,
		        "searchable": false
		    }]
    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
  });
</script>

 <script type="text/javascript">
    $(document).ready(function(){
        $('#uploadDokumen').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/komoditi/pangan/modal/ul_psb.php',
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
        $('#lihatDokumen').on('show.bs.modal', function (e) {
            var row = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'pages/komoditi/pangan/modal/view_psb.php',
                data :  'row='+ row,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
  </script>