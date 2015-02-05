<?php
include "config.php";


if($_POST['vt'])
 $vtype = $_POST['vt'];
else
{
 $vtype = $_POST['newvt'];
 $q1 = "insert into vehicle_type(vtype,client) values('".$vtype."','$client')";
 $qrs1 = mysql_query($q1,$conn);
 
 
 }
$vnumber =($_POST['vno']);


if($_POST['unit'])
 $unit = $_POST['unit'];
else
{
 $unit = $_POST['newunit'];
 }
 $rc = ($_POST['rc']);
$insuranceno =($_POST['ino']);

$pcost =($_POST['pc']);

$idate = date("Y-m-d",strtotime($_POST['idate']));
$capacity =($_POST['cap']);
$remarks = ($_POST['remarks']);

$pdate = date("Y-m-d",strtotime($_POST['pdate']));



 
$image = "";
if($_FILES[uploadedfile]['name'])
{
	$file = basename($_FILES['uploadedfile']['name']);
	$image = $file;
	$target_path = "vehicleimages/"; 
	$target_path = $target_path . basename($_FILES['uploadedfile']['name']); 
	$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
	

//echo $image;
}
 $q = "insert into vehicle_master(vtype,vnumber,unit,rcnumber,insurancenumber,purchasedate,iexpirydate,purchasecost,capacity,remarks,client,image)
values('$vtype','$vnumber','$unit','$rc','$insuranceno','$pdate','$idate','$pcost','$capacity','$remarks','$client','".$image."')"; 
$qrs = mysql_query($q,$conn);

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_master'";
echo "</script>";

?>







