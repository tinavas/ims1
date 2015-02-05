<?php
include "config.php";


echo "Hai";
$vtype =($_POST['vt']);
$vnumber =($_POST['vno']);
$unit =($_POST['unit']);
$rc = ($_POST['rc']);
$insuranceno =($_POST['ino']);
$idate = date("Y-m-d",strtotime($_POST['idate']));
$capacity =($_POST['cap']);
$remarks = ($_POST['remarks']);;

$image = "";
if($_FILES[uploadedfile]['name'])
{
	$file = $client . "_" .$vnumber. "_" .basename($_FILES['uploadedfile']['name']);
	$image = $file;
	echo $target_path = "vehicleimages/"; 
	echo $target_path = $target_path .$client . "_" .$vnumber. "_" . basename($_FILES['uploadedfile']['name']); 
	echo $i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
}

echo $q = "insert into vehicle_master(vtype,vnumber,unit,rcnumber,insurancenumber,purchasedate,capacity,remarks,client)
values('$vtype','$vnumber','$unit','$rc','$insuranceno','$idate','$capacity','$remarks','$client')"; 
$result = mysql_query($q,$conn);


echo "<script type='text/javascript'>";
//echo "document.location = 'dashboardsub.php?page=vehicle_master'";
echo "</script>";

?>







