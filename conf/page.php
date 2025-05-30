<?php
if(isset($_GET['page'])){
  $page = $_GET['page'];
switch ($page) {
// Profil
  case 'lengkapidata':
    include "pages/profil/lengkapidata.php";
    break;
  case 'dataperusahaan':
    include "pages/profil/dataperusahaan.php";
    break;

// Dokumen
  case 'formupload':
    include "pages/dokumen/formupload.php";
    break;
  case 'data_dokumen':
    include "pages/dokumen/data_dokumen.php";
    break;

//Pengguna
  case 'resetpwd':
    include "pages/auth/resetpwd.php";
    break;
  }
}else{
  //Beranda
    include "pages/home.php";
  }
?>