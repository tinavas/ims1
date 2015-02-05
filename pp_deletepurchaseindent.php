<?php
include "config.php";
$pi=$_GET['pi'];

$get_entriess = "DELETE FROM pp_purchaseindent WHERE pi = '$pi'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_purchaseindent';";
echo "</script>";
?>

