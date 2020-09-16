<?php
include "../../../../../conf/conn.php";

if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
 
    if($_POST['row']) {
        $id = $_POST['row'];
        $ul_query = $conn -> query("SELECT * FROM tbl_doc_psb_pangan
                                    INNER JOIN tbl_doc ON tbl_doc_psb_pangan.id_doc=tbl_doc.id_doc
                                    WHERE id_doc_psb = '".$id."'");
        $ulr=mysqli_fetch_array($ul_query);
         ?>
 
        <!-- MEMBUAT FORM -->
        <form action="pages/komoditi/pangan/action/view_psb.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="idpsb" value="<?php echo $ulr['id_psb'] ?>">
            <input type="hidden" name="iddocpsb" value="<?php echo $ulr['id_doc_psb'] ?>">
            <input type="hidden" name="idkomoditi" value="<?php echo $ulr['id_komoditi'] ?>">
            <input type="hidden" name="iddoc" value="<?php echo $ulr['id_doc'] ?>">
            <div class="form-group bg-light text-primary">
              <div class="sm-12 text-center"><b><?php echo $ulr['jenis_doc']; ?></b><br><small class="text-success"><?php echo $ulr['ket_doc']; ?></small></div>
            </div>

            
          <div class="form-group" style="text-align: center;">
              <button class="btn btn-primary" type="submit"><i class="fa fa-download"></i> Download Dokumen</button>
            </div>
        </form>
 
        <?php  }  
    $conn->close();
?>