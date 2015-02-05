<?php 
include "config.php";
session_start();
$client = $_SESSION['client'];
$proc = $_POST['proc'];
	
$get_entriess ="DELETE FROM ims_egg_procedure where client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn);

$q = "insert into ims_egg_procedure(`procedure`,`client`) values ('".$proc."','".$client."')";
$r = mysql_query($q,$conn);

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_eggprocedure';";
echo "</script>";

?>