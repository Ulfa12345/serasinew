<?php
$conn = new mysqli("localhost","root","","db_serasi");

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}
?>