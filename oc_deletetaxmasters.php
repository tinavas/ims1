<?php 
include "config.php";

$id = $_GET['id'];

$query = "DELETE FROM ims_taxcodes where id='$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_taxmasters'";
echo "</script>";
?>