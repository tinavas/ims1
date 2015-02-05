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
$vt = $vt. "," . $_POST['vt'][$i] ;
}
}
 $parts= $_POST['parts'];
/////////insert into vehicle_spareparts
 $q = "insert into vehicle_spareparts(vehicletype,spareparts,client)
values('$vt','$parts','$client')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_spareparts'";
echo "</script>";

?>







