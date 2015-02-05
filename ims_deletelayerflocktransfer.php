<?php
include "config.php";
$id=$_GET['id'];

$q1 = "SELECT * FROM ims_stocktransfer WHERE tid = '$id' and client = '$client'";
$r1 = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($r1))
{
 $fromshed = $row1['fromwarehouse'];
 $toshed = $row1['towarehouse'];
 $flock = $row1['flock'];
}

$q1 = "SELECT * FROM layer_shed WHERE shedcode = '$fromshed' and client = '$client'";
$r1 = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($r1))
{
 $fromsheddesc = $row1['sheddescription'];
}

$q1 = "SELECT * FROM layer_shed WHERE shedcode = '$toshed' and client = '$client'";
$r1 = mysql_query($q1,$conn);
while($row1 = mysql_fetch_assoc($r1))
{
 $tosheddesc = $row1['sheddescription'];
}


$q1 = "UPDATE layer_flock SET shedcode = '$fromshed',sheddescription='$fromsheddesc' WHERE shedcode = '$toshed' AND oldshed='$fromshed' and flockcode='$flock' AND client = '$client'";
$get_entriess_res1 = mysql_query($q1,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ims_stocktransfer WHERE tid = '$id' AND client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_layer_flocktransfer';";
echo "</script>";
?>

