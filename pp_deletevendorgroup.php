<?php 
include "config.php";

$tno = $_GET['id'];


$get_entriess = 
"DELETE FROM ac_vgrmap WHERE vgroup = '$tno' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_vendorgroup'";
echo "</script>";

?>

