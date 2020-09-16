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
        <form action="pages/profil/action/editprofil.php" method="post">
            <input type="hidden" name="iddetail" value="<?php echo $rowm['id_detail'] ?>">

            <div class="form-group row">
                  <label for="username" class="col-sm-4 col-form-label">Username</label>
                  <div class="col-sm-8">
                    <input type="text" name="username" class="form-control form-control-user" id="username" value="<?php echo $rowm['username']; ?>" readonly>
                  </div>
            </div>

            <div class="form-group row">
                  <label for="namadetail" class="col-sm-4 col-form-label">Nama Lengkap</label>
                  <div class="col-sm-8">
                    <input type="text" name="namadetail" class="form-control form-control-user" id="namadetail" value="<?php echo $rowm['nama_detail']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="alamatdetail" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamatdetail" class="form-control form-control-user" id="alamatdetail" value="<?php echo $rowm['alamat_detail']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="jabatandetail" class="col-sm-4 col-form-label">Jabatan</label>
                  <div class="col-sm-8">
                    <input type="text" name="jabatandetail" class="form-control form-control-user" id="jabatandetail" value="<?php echo $rowm['jabatan_detail']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="emaildetail" class="col-sm-4 col-form-label">Email</label>
                  <div class="col-sm-8">
                    <input type="text" name="emaildetail" class="form-control form-control-user" id="emaildetail" value="<?php echo $rowm['email']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="notelpdetail" class="col-sm-4 col-form-label">No Telepon/HP</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelpdetail" class="form-control form-control-user" id="notelpdetail" value="<?php echo $rowm['notelp_detail']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="pswd" class="col-sm-4 col-form-label">Password</label>
                  <div class="col-sm-8">
                    <input type="password" name="pswd" class="form-control form-control-user" id="pswd" value="<?php echo $rowm['password']; ?>">
                  </div>
            </div>


          <div class="form-group" style="text-align: center;">
              <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Selesai</button>
            </div>
        </form>
 
        <?php  }  
    $conn->close();
?>