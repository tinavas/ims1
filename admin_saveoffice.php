<?php
include "config.php";
$client = $_SESSION['client'];

 $q = "select max(sectorid) as maxid from tbl_sector";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
 if($qr = mysql_fetch_assoc($qrs))
 $maxid = $qr['maxid'];
 $maxid++;
$warehouse2='';
if($_POST['warehouse'] != "-Select-")
$warehouse2=$warehouse = $_POST['warehouse'];
else
$warehouse = "SubOffice";

 

 $query="INSERT INTO tbl_sector (sector,type,type1,sectorid,warehouse)
 VALUES ('".ucwords($_POST['name'])."','$warehouse','".$_POST['type']."','$maxid','$warehouse2')" or die(mysql_error());
 
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 

 
 
 
 header('Location:dashboardsub.php?page=admin_office');
?>