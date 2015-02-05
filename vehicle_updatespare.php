<?php
include "config.php";
 $id = $_POST['id'];

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


 $query = "update vehicle_spareparts set vehicletype = '$vt',spareparts = '$parts' where id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_spareparts';";
echo "</script>";
?>








