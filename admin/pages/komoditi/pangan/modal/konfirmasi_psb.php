<?php
include "../../../../../conf/conn.php";

if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
 
    if($_POST['row']) {
        $id = $_POST['row'];

        $q_tgl = $conn -> query("SELECT * FROM tbl_tgl_psb WHERE id_psb='".$id."'");
        $r_tgl = mysqli_fetch_array($q_tgl);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/komoditi/pangan/action/konfirmasi_psb.php" method="post">
            <div class="form-group row">
                  <label for="tglperiksa" class="col-sm-5 col-form-label">Tanggal Pemeriksaan</label>
                  <div class="col-sm-7">
                    <input type="hidden" name="idpsb" class="form-control form-control-user" id="idpsb" value="<?php echo $r_tgl['id_psb']; ?>">
                    <input type="text" name="tglperiksa" class="form-control form-control-user" readonly id="tglperiksa" value="<?php echo $r_tgl['tanggal_psb']; ?>">
                  </div>
            </div>

            <div class="form-group row">
                  <label for="setuju" class="col-sm-5 col-form-label">Hasil</label>
                  <div class="col-sm-7">
                    <select name="setuju" class="form-control" id="setuju" required>
                    <option value="" hidden> - </option>
                    <option value="1">Disetujui</option>
                    <option value="0">Ditolak</option>
                </select>
                  </div>
            </div>

            
          <div class="form-group" style="text-align: center;">
              <button class="btn btn-primary" type="submit"><i class="fa fa-paper-plane"></i> Kirim</button>
            </div>
        </form>
 
        <?php  }  
    $conn->close();
?>