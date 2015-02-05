<?php 
include "config.php";

$query = "delete from ims_convunits where id = '$_GET[id]'";

$result = mysql_query($query,$conn);

echo "<script type='text/javascript'>";

echo "document.location = 'dashboardsub.php?page=ims_units';";

echo "</script>";


?>

