<?php 
include "config.php";
session_start();
$_SESSION['holi'] = "Holiday(s) have been saved successfully";
for ($i = 0; $i < count($_POST['date1']); $i++)
{
$date = date("Y-m-j", strtotime($_POST['date1'][$i]));
$q = "insert into hr_holidays (date,dumpdate,reason) values('".$date."','".$_POST['date1'][$i]."','".$_POST['reason'][$i]."')";
$r = mysql_query($q,$conn);
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_holidays';";
echo "</script>";

?>