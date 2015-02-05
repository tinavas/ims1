<?php 
include "config.php";
session_start();
$client = $_SESSION['client']; 
$id = $_GET['id'];

$q = "delete from hr_pf where id='$id' and  client='$client'";
$r = mysql_query($q,$conn);

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_pf';";
echo "</script>";

?>