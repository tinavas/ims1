<?php

include "config.php";

$id=$_GET['id'];

$get_entriess = "DELETE FROM ac_schedule WHERE id = $_GET[id]";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";

echo "document.location = 'dashboardsub.php?page=ac_schedule';";

echo "</script>";

?>