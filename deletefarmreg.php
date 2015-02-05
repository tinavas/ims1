<?php
include "config.php";
$id = $_GET['id'];

$get_entriess = "DELETE FROM tbl_farmreg WHERE id = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=farmregdisplay';"; 
echo "</script>";
//echo "Farm Details Successfully Registered";
?>
