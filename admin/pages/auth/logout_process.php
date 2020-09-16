<?php
session_start();
include '../../../conf/conn.php';
$sess_admin = $_SESSION['id_detail'];
if (isset($sess_admin))
{
// remove all session variables
session_unset();
session_destroy();
echo '<script>window.location.href="../../login.php"</script>';
}
?>