<?php
include "config.php";
$id = $_GET['id'];
$name = $_GET['name'];
$daten = $_GET['daten'];
$salid = $_GET['salid'];

$q11 = "delete from ac_financialpostings where type='EMPSAL' and date ='$daten' and venname = '$name' and warehouse = '$name'";
$qrs11 = mysql_query($q11,$conn) or die(mysql_error());

$c1 = 0;
 $q22 = "select count(*) as c1 from hr_salary_payment where salparamid='$salid'";
$qrs22 = mysql_query($q22,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs22))
 $c1 = $qr['c1'];
 if($c1 == 1)
 {
 $get_entriess = "update hr_salary_parameters set flag = '1' where id='$salid'" ;
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
 }

$q1 = "delete from hr_salary_payment where id = '$id'";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());
  
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salary_payment';"; 
echo "</script>";

?>