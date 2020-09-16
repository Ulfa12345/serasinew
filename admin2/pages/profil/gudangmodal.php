<?php
include "../../../conf/conn.php";

if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
 
    if($_POST['row']) {
        $id = $_POST['row'];
        $query = $conn -> query("SELECT * FROM tbl_detail_client
                                INNER JOIN tbl_perusahaan ON tbl_detail_client.id_perusahaan=tbl_perusahaan.id_perusahaan
                                INNER JOIN tbl_gudang ON tbl_detail_client.id_gudang=tbl_gudang.id_gudang");
        $rowo=mysqli_fetch_array($query);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/profil/action/editgudang.php" method="post" class="form-horizontal">
            <input type="hidden" name="idgudang" value="<?php echo $rowo['id_gudang'] ?>">
                <div class="control-group">                     
                      <label class="control-label" for="namagudang" style="width:auto;">Nama Gudang</label>
                      <div class="controls">
                        <input type="text" class="span3" id="namagudang" name="namagudang" value="<?php echo $rowo['nama_gudang']; ?>">
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="npwpgudang" style="width:auto;">NPWP</label>
                      <div class="controls">
                        <input type="text" class="span3" id="npwpgudang" name="npwpgudang" value="<?php echo $rowo['npwp_gudang']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="alamatgudang" style="width:auto;">Alamat</label>
                      <div class="controls">
                        <input type="text" class="span3" id="alamatgudang" name="alamatgudang" value="<?php echo $rowo['alamat_gudang']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                  <div class="control-group">                     
                      <label class="control-label" for="notelpgudang" style="width:auto;">Nomor Telepon/HP</label>
                      <div class="controls">
                        <input type="number" class="span3" id="notelpgudang" name="notelpgudang" value="<?php echo $rowo['notelp_gudang']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="ketgudang" style="width:auto;">Keterangan</label>
                      <div class="controls">
                        <input type="text" class="span3" id="ketgudang" name="ketgudang" value="<?php echo $rowo['ket_gudang']; ?>">
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

          <div class="form-group" style="text-align: right;">
              <button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Kirim</button>
            </div>
        </form>
 
        <?php  }
    $conn->close();
?>