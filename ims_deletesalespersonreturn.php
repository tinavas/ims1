<?php 
include "config.php";

$query = "delete from ims_salespersonreturn where client='$client' and tid = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
$query = "delete from ac_financialpostings where client='$client' and trnum = '$_GET[id]' and type = 'SPEIR'";
$result = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=ims_salespersonreturn');
?>
