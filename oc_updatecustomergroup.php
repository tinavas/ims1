<?php
include "config.php";
$code = $_POST['tno'];
$desc = $_POST['desc'];
$curr = $_POST['curr'];
$ca = $_POST['ca'];
$ppac = $_POST['ppac'];

 
 $query = "UPDATE ac_vgrmap set vdesc = '$desc',vca = '$ca',vppac = '$ppac' where vgroup = '$code' ";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_customergroup';";
echo "</script>";
 


 
?>
