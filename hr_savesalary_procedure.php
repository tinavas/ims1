<?php 
include "config.php";
session_start();
$client = $_SESSION['client'];
$proc = $_POST['proc'];
	
$get_entriess ="DELETE FROM hr_salary_procedure";
$get_entriess_res1 = mysql_query($get_entriess,$conn);

$q = "insert into hr_salary_procedure(`procedure`,`client`) values ('".$proc."','".$client."')";
$r = mysql_query($q,$conn);

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_salprocedure';";
echo "</script>";

?>