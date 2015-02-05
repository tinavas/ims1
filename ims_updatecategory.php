<?php
include "config.php";
$cat = $_POST['cat'];
$id = $_POST['oldid'];
$query = "UPDATE ims_itemtypes SET type = '$cat' WHERE id = '$id' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_category'";
echo "</script>";

?>