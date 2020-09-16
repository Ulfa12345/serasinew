<?php
if(isset($_GET['page'])){
  $page = $_GET['page'];
switch ($page) {
// Profil
  case 'profil':
    include "pages/profil/profil.php";
    break;

//Komoditi Pangan
  case '2121':
    include "pages/komoditi/pangan/data_pangan.php";
    break;
  case 'new_psb':
    include "pages/komoditi/pangan/new_psb.php";
    break;
  case 'docprod':
    include "pages/komoditi/pangan/upload_prod.php";
    break;
  case 'docdist':
    include "pages/komoditi/pangan/upload_dist.php";
    break;
  }
}else{
  //Beranda
    include "pages/home.php";
  }
?>