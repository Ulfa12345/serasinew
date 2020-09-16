<?php
include "../../../conf/conn.php";

if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
 
    if($_POST['row']) {
        $id = $_POST['row'];
        $query = $conn -> query("SELECT * FROM tbl_detail_client
                                INNER JOIN tbl_perusahaan ON tbl_detail_client.id_perusahaan=tbl_perusahaan.id_perusahaan
                                INNER JOIN tbl_gudang ON tbl_detail_client.id_gudang=tbl_gudang.id_gudang
                                WHERE id_detail = '".$id."'");
        $rown=mysqli_fetch_array($query);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/profil/action/editperusahaan.php" method="post" class="form-horizontal">
            <input type="hidden" name="idperusahaan" value="<?php echo $rown['id_perusahaan'] ?>">
                <div class="control-group">                     
                      <label class="control-label" for="namaperusahaan" style="width:auto;">Nama Perusahaan</label>
                      <div class="controls">
                        <input type="text" class="span3" id="namaperusahaan" name="namaperusahaan" value="<?php echo $rown['nama_perusahaan']; ?>">
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="npwpperusahaan" style="width:auto;">NPWP</label>
                      <div class="controls">
                        <input type="text" class="span3" id="npwpperusahaan" name="npwpperusahaan" value="<?php echo $rown['npwp_perusahaan']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">
                      <label class="control-label" for="alamatperusahaan" style="width:auto;">Alamat</label>
                      <div class="controls">
                        <input type="text" class="span3" id="alamatperusahaan" name="alamatperusahaan" value="<?php echo $rown['alamat_perusahaan']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">
                      <label class="control-label" for="notelpperusahaan" style="width:auto;">Nomor Telepon/HP</label>
                      <div class="controls">
                        <input type="number" class="span3" id="notelpperusahaan" name="notelpperusahaan" value="<?php echo $rown['notelp_perusahaan']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="ketperusahaan" style="width:auto;">Keterangan</label>
                      <div class="controls">
                        <input type="text" class="span3" id="ketperusahaan" name="ketperusahaan" value="<?php echo $rown['ket_perusahaan']; ?>">
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

          <div class="form-group" style="text-align: right;">
              <button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Kirim</button>
            </div>
        </form>
 
        <?php  }
    $conn->close();
?>