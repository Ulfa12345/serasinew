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
        $rowo=mysqli_fetch_array($query);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/profil/action/editgudang.php" method="post" class="form-horizontal">
            <input type="hidden" name="idgudang" value="<?php echo $rowo['id_gudang'] ?>">

            <div class="form-group row">
                  <label for="namagudang" class="col-sm-4 col-form-label">Nama Pabrik/Gudang</label>
                  <div class="col-sm-8">
                    <input type="text" name="namagudang" class="form-control form-control-user" id="namagudang" value="<?php echo $rowo['nama_gudang'] == '0' ? '' : $rowo['nama_gudang']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="npwpgudang" class="col-sm-4 col-form-label">NPWP</label>
                  <div class="col-sm-8">
                    <input type="text" name="npwpgudang" class="form-control form-control-user" id="npwpgudang" value="<?php echo $rowo['npwp_gudang'] == '0' ? '' : $rowo['npwp_gudang']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="alamatgudang" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamatgudang" class="form-control form-control-user" id="alamatgudang" value="<?php echo $rowo['alamat_gudang'] == '0' ? '' : $rowo['alamat_gudang']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="notelpgudang" class="col-sm-4 col-form-label">Nomor Telepon/HP</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelpgudang" class="form-control form-control-user" id="notelpgudang" value="<?php echo $rowo['notelp_gudang'] == '0' ? '' : $rowo['notelp_gudang']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="ketgudang" class="col-sm-4 col-form-label">Keterangan</label>
                  <div class="col-sm-8">
                    <select name="ketgudang" class="form-control" id="ketgudang" required>
                    <option value="" hidden><?php echo $rowo['ket_gudang'] == '0' ? 'Nonaktif' : 'Aktif'; ?></option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
                  </div>
            </div>

           <div class="form-group" style="text-align: center;">
              <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Selesai</button>
            </div>
        </form>
 
        <?php  }
    $conn->close();
?>