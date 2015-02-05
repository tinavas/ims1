<?php
include "config.php";
$q1 = "delete from hr_salary_procedure";
$r1 = mysql_query($q1,$conn);

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salprocedure';";
echo "</script>";

?>
