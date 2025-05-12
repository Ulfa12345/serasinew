<?php
include "../../../../../conf/conn.php";

if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
 
    if($_POST['row']) {
        $id = $_POST['row'];
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/komoditi/pangan/action/tgl_psb.php" method="post">
            <div class="form-group row">
                  <label for="tglperiksa" class="col-sm-4 col-form-label">Tanggal</label>
                  <div class="col-sm-8">
                    <input type="hidden" name="idpsb" class="form-control form-control-user" id="idpsb" value="<?php echo $id; ?>">
                    <input type="date" name="tglperiksa" class="form-control form-control-user" id="tglperiksa">
                  </div>
            </div>

            
          <div class="form-group" style="text-align: center;">
              <button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Kirim</button>
            </div>
        </form>
 
        <?php  }  
    $conn->close();
?>