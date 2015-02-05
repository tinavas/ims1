<?php
include "config.php";
 $id = $_POST['idnum'];



 $vt = "";
for($i=0;$i<count($_POST['vt']);$i++)
{

if($vt == "")
{
$vt = $_POST['vt'][$i];
}
else
{
 $vt = $vt . ",". $_POST['vt'][$i] ;
}
}

 
 
$ccode= $_POST['ccode'];
$cdesc= $_POST['cdesc'];
 $remarks= $_POST['remarks'];

$query = "update vehicle_chargemaster set vehicletype = '$vt',chargecode = '$ccode',chargedescription = '$cdesc',narration = '$remarks' where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_chargemaster';";
echo "</script>";
?>








