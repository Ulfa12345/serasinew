<?php
$date=date_create("now",timezone_open("Asia/Jakarta"));
$tanggal = date_format($date,"Y-m-d H:i:s");

echo strtotime($tanggal);
echo "<br>";
echo (strtotime($tanggal))*99;
?>