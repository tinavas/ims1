<?php 
include "config.php";

$fromunits = $_POST['fromunits'];
$tounits = $_POST['tounits'];
$conunits=$_POST["conunits"];

$q = "INSERT INTO ims_convunits (fromunits,tounits,conunits,client) VALUES ('$fromunits','$tounits','$conunits','$client')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_units'";
echo "</script>";
?>