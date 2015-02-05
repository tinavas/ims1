<?php 
include "config.php";

$id=$_GET['id'];

$del=mysql_query("delete from oc_pricemaster where id='$id'");

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_pricemaster'";
echo "</script>";
?>