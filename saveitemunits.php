<?php

include "config.php";

$units = strtoupper($_POST['units']);
$empname=$_SESSION['valid_user'];;

$query = "INSERT INTO ims_itemunits (id,sunits,client,cunits,empname) VALUES (NULL,'$units','$client','$units','$empname')";

$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=ims_additemcodes'";

echo "</script>";



?>