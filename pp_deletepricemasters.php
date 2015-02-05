<?php 
include "config.php";

$id=$_GET['id'];
echo
$del=mysql_query("delete from pp_pricemaster where id='$id'");

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_pricemaster'";
echo "</script>";
?>