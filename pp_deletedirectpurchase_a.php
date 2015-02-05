<?php
include "config.php";
$id=$_GET['id'];
$query="DELETE FROM pp_sobi WHERE so = '$id'";
$result=mysql_query($query,$conn) or die(mysql_error());
$query1="DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' and client = '$client'";
$result1=mysql_query($query1,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_directpurchase_a';";
echo "</script>";
?>