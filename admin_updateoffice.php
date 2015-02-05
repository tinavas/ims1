<?php
include "config.php";
$id = $_GET['id'];
$client = $_SESSION['client'];

$query = "SELECT * FROM tbl_sector WHERE id = '$id' ORDER BY sector ASC "; $result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) 
{
  $fid = $row1['sectorid'];
  $oldsecname = $row1['sector'];
}
$name = ucwords($_POST['name']); 
$type = $_POST['type'];
$warehouse2='';
if($_POST['warehouse'] != "-Select-")
$warehouse2=$warehouse = $_POST['warehouse'];
else
$warehouse = "SubOffice";


$get_entriess = "UPDATE `tbl_sector` SET `sector` = '$name', `type` = '$warehouse',`warehouse`='$warehouse2', `type1` = '$type' WHERE `tbl_sector`.`sectorid` = '$fid'";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=admin_office'); 
?>