<?php
include "config.php";


$ip = "";
for($i=0;$i<count($_POST['ip']);$i++)
{
if($ip == "")
{
$ip = $_POST['ip'][$i];
}
else
{
$ip = $ip . ",". $_POST['ip'][$i];
}
}
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


 $scode= $_POST['scode'];
$sdesc= $_POST['sdesc'];
 $remarks= $_POST['remarks'];
/////////insert into vehicle_spareparts
$q = "insert into vehicle_servicemaster(vehicletype,servicecode,servicedescription,includedparts,narration,client)
values('$vt','$scode','$sdesc','$ip','$remarks','$client')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_service'";
echo "</script>";

?>







