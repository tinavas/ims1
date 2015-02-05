<?php
include "config.php";
 $id = $_POST['id'];


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

$query = "update vehicle_servicemaster set vehicletype = '$vt',servicecode = '$scode',servicedescription = '$sdesc',includedparts = '$ip',narration = '$remarks' where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_service';";
echo "</script>";
?>








