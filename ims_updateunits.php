<?php 
include "config.php";

$fromunits = $_POST['fromunits'];
$tounits = $_POST['tounits'];
$id=$_POST["id"];
$conunits=$_POST["conunits"];

$q = "update ims_convunits set fromunits='$fromunits',tounits='$tounits' ,conunits='$conunits' where id='$id'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_units'";
echo "</script>";
?>