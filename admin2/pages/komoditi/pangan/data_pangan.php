<?php
$detail_psb=$conn -> query("SELECT * FROM tbl_psb_pangan
                                INNER JOIN tbl_detail_client ON tbl_psb_pangan.id_detail=tbl_detail_client.id_detail
                                WHERE tbl_psb_pangan.id_detail = '".$_SESSION['id_detail']."'");
?>

<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="widget-header"> <i class="icon-th-list"></i>
              <h3 class="m-0 font-weight-bold text-primary">Data Permohonan Pemeriksaan Sarana Bangunan</h3>
              <div class="pull-right">
              <a href="./index.php?page=new_psb" class="btn btn-primary" type="button" id="tambah" title="Tambah Data PSB"><i class="fa fa-plus"></i> Ajukan PSB</a>
            </div>
            </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0">
                  <thead>
                    <tr class="bg-primary text-light">
                      <th>Tanggal Pengajuan</th>
                      <th>Jenis Sarana</th>
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
                      <td><?php echo $detpsb['perihal_psb']; ?></td>
                      <td><?php echo $detpsb['status_psb']; ?></td>
                      <td><a href="#" class="btn btn-warning" type="button" id="preview" title="Preview Data PSB" data-toggle="modal" data-id=""><i class="icon-eye-open"></i> Preview</a>&nbsp; <a href="pages/driver/hapus.php?id=<?=$row_drv['id_driver'];?>" class="btn btn-danger" role="button" title="Hapus Data Driver" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class="icon-trash"></i> Hapus</a></td>
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