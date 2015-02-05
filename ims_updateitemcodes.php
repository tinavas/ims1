<?php 
include "config.php";
include "getemployee.php";

$oldid = $_POST['oldid'];
$cm = $_POST['cm'];
$stdcost = $_POST['stdcost'];
$cat = $_POST['cat'];


$q = "UPDATE ims_itemcodes set cm='$cm',stdcost='$stdcost' where id='$oldid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_itemcodes'";
echo "</script>";


?>