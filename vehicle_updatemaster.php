<?php
include "config.php";

$id = $_POST['id'];
 $vtype =($_POST['vt']);
$vnumber =($_POST['vno']);
$unit =($_POST['unit']);
$rc = ($_POST['rc']);
$insuranceno =($_POST['ino']);
$pcost =($_POST['pc']);
$idate = date("Y-m-d",strtotime($_POST['idate']));
$capacity =($_POST['cap']);
$remarks = ($_POST['remarks']);;
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


$query = "UPDATE vehicle_master SET vtype  = '$vtype', vnumber = '$vnumber', unit='$unit',rcnumber='$rc',insurancenumber = '$insuranceno',iexpirydate = '$idate',purchasedate = '$pdate',purchasecost = '$pcost',capacity = '$capacity',remarks = '$remarks',image='".$image."' WHERE id = '$id'";     
 $result = mysql_query($query,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_master'";
echo "</script>";

?>







