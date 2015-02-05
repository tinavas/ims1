<?php 
include "config.php";

 $query1="select transactioncode from vehicle_servicing where id = '$_GET[id]'";
$result = mysql_query($query1,$conn) or die(mysql_error());
$row=mysql_fetch_array($result);
 $transactioncode=$row['transactioncode'];
 $query="Delete from ac_financialpostings where trnum='$transactioncode' and type='VS'";
$result=mysql_query($query,$conn);

$query = "delete from vehicle_servicing where id = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_servicing';";
echo "</script>";
?>