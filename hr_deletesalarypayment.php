<?php
include "config.php";
$id = $_GET['id'];
$name = $_GET['name'];
$daten = $_GET['daten'];


$q11 = "delete from ac_financialpostings where type='EMPSAL' and date ='$daten' and venname = '$name' and warehouse = '$name'";
$qrs11 = mysql_query($q11,$conn) or die(mysql_error());

$q1 = "delete from hr_salary_payment where id = '$id'";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salpayment';"; 
echo "</script>";

?>