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
        $rowm=mysqli_fetch_array($query);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/profil/action/editprofil.php" method="post" class="form-horizontal">
            <input type="hidden" name="iddetail" value="<?php echo $rowm['id_detail'] ?>">
                <div class="control-group">                     
                      <label class="control-label" for="username" style="width:auto;">Username</label>
                      <div class="controls">
                        <input type="text" class="span3" id="username" name="username" value="<?php echo $rowm['username']; ?>" readonly>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="nama_detail" style="width:auto;">Nama Lengkap</label>
                      <div class="controls">
                        <input type="text" class="span3" id="nama_detail" name="nama_detail" value="<?php echo $rowm['nama_detail']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="alamat_detail" style="width:auto;">Alamat</label>
                      <div class="controls">
                        <input type="text" class="span3" id="alamat_detail" name="alamat_detail" value="<?php echo $rowm['alamat_detail']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="jabatan_detail" style="width:auto;">Jabatan</label>
                      <div class="controls">
                        <input type="text" class="span3" id="jabatan_detail" name="jabatan_detail" value="<?php echo $rowm['jabatan_detail']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="email_detail" style="width:auto;">Email</label>
                      <div class="controls">
                        <input type="text" class="span3" id="email_detail" name="email_detail" value="<?php echo $rowm['email']; ?>" readonly>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="notelp_detail" style="width:auto;">Nomor Telpon/HP</label>
                      <div class="controls">
                        <input type="number" class="span3" id="notelp_detail" name="notelp_detail" value="<?php echo $rowm['notelp_detail']; ?>">
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

                <div class="control-group">                     
                      <label class="control-label" for="password" style="width:auto;">Password</label>
                      <div class="controls">
                        <input type="password" class="span3" id="password_detail" name="password_detail" value="<?php echo $rowm['password']; ?>" required>
                      </div> <!-- /controls -->       
                </div> <!-- /control-group -->

          <div class="form-group" style="text-align: right;">
              <button class="btn btn-primary" type="submit"><i class="icon-ok"></i> Kirim</button>
            </div>
        </form>
 
        <?php  }  
    $conn->close();
?>