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
                            echo "<span class='badge badge-warning'>Menunggu Konfirmasi</span>"; 
                          }
                        ?>
                      </td>
                      <td>
                          <a href="#" class="btn btn-secondary" type="button" id="preview" title="Preview Data PSB" data-toggle="modal" data-id=""><i class="fa fa-eye"></i></a>&nbsp;
                          <?php
                            if($detpsb['perihal_psb'] == 'produksi'){
                          ?>
                          <a href="index.php?page=docprod&id=<?=$detpsb['id_psb'];?>" class="btn btn-warning" type="button" id="uploadproduksi" title="Upload Data PSB Produksi"><i class="fa fa-upload"></i></a>&nbsp;
                          <?php
                            } else if($detpsb['perihal_psb'] == 'distribusi'){
                          ?>
                          <a href="index.php?page=docdist&id=<?=$detpsb['id_psb'];?>" class="btn btn-warning" type="button" id="uploaddistribusi" title="Upload Data PSB Distribusi"><i class="fa fa-upload"></i></a>&nbsp;
                          <?php
                            }
                          ?>
                          <a href="pages/driver/hapus.php?id=<?=$row_drv['id_driver'];?>" class="btn btn-danger" role="button" title="Hapus Data Driver" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><i class="fa fa-trash"></i></a>
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