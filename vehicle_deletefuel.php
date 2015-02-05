<?php 
include "config.php";

$query = "delete from vehicle_fuelfilling where id = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());

$query = "DELETE FROM ac_financialpostings WHERE trnum='$_GET[id]' AND type='FFT'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_fuelfilling';";
echo "</script>";
?>