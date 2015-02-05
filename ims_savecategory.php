<?php

include "config.php";

$cat = $_POST['cat'];

$query = "INSERT INTO ims_itemtypes (id,type,client) VALUES (NULL,'$cat','$client')";

$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=ims_category'";

echo "</script>";



?>