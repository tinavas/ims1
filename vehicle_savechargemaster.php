<?php
include "config.php";

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

 $q = "insert into vehicle_chargemaster(vehicletype,chargecode,chargedescription,narration,client)
values('$vt','$ccode','$cdesc','$remarks','$client')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_chargemaster'";
echo "</script>";

?>







