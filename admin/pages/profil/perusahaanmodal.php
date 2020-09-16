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

            <div class="form-group row">
                  <label for="namaperusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                  <div class="col-sm-8">
                    <input type="text" name="namaperusahaan" class="form-control form-control-user" id="namaperusahaan" value="<?php echo $rown['nama_perusahaan'] == '0' ? '' : $rown['nama_perusahaan']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="npwpperusahaan" class="col-sm-4 col-form-label">NPWP</label>
                  <div class="col-sm-8">
                    <input type="text" name="npwpperusahaan" class="form-control form-control-user" id="npwpperusahaan" value="<?php echo $rown['npwp_perusahaan'] == '0' ? '' : $rown['npwp_perusahaan']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="alamatperusahaan" class="col-sm-4 col-form-label">Alamat</label>
                  <div class="col-sm-8">
                    <input type="text" name="alamatperusahaan" class="form-control form-control-user" id="alamatperusahaan" value="<?php echo $rown['alamat_perusahaan'] == '0' ? '' : $rown['alamat_perusahaan']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="notelpperusahaan" class="col-sm-4 col-form-label">Nomor Telepon/HP</label>
                  <div class="col-sm-8">
                    <input type="text" name="notelpperusahaan" class="form-control form-control-user" id="notelpperusahaan" value="<?php echo $rown['notelp_perusahaan'] == '0' ? '' : $rown['notelp_perusahaan']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="ketperusahaan" class="col-sm-4 col-form-label">Keterangan</label>
                  <div class="col-sm-8">
                    <select name="ketperusahaan" class="form-control" id="ketperusahaan" required>
                    <option value="" hidden><?php echo $rown['ket_perusahaan'] == '0' ? 'Nonaktif' : 'Aktif'; ?></option>
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