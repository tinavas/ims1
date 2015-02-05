<?php
include "config.php";
$get_entriess = 
"DELETE FROM hr_attendance WHERE date = '$_GET[id]'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_attendance';";
echo "</script>";

?>
 