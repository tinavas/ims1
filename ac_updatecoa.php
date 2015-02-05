<?php
include "config.php";
$id=$_POST['id'];
$description=ucwords($_POST['description']);
if($_SESSION['db'] <> 'central') 
 $get_entriess = "UPDATE `ac_coa` SET `description` = '$description' WHERE `ac_coa`.`id` = '$id' LIMIT 1  ;";     
else if($_SESSION['db'] == 'central')
{
 $centre = $_POST['costcentre'];
 $get_entriess = "UPDATE `ac_coa` SET `description` = '$description',costcentre = '$centre' WHERE `ac_coa`.`id` = '$id' LIMIT 1 ";     
}
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=ac_coa'); 

?>