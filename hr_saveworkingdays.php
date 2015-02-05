<?php
include "config.php";
 $date1 = $_POST['date1'];
 $date1 = date("Y-m-j",strtotime($date1));
for($i=0;$i<count($_POST['nodays']);$i++) 
{
if ($_POST['nodays'][$i] != "0" && $_POST['nodays'][$i] != "") 
{
$month = $_POST['month'][$i];
$year = $_POST['year'][$i];
$nodays = $_POST['nodays'][$i];

$query1="select count(*) as count from hr_workingdays where month = '$month' AND year = '$year'";
$result1 = mysql_query($query1,$conn); 
while($row1 = mysql_fetch_assoc($result1))
{
 $no2 = $row1['count'];
}
if($no2 == "0")
{
   $q1 = "insert into hr_workingdays(date,month,year,noofdays) values('".$date1."','".$month."','".$year."','".$nodays."')";
}
else
{
   $q1 = "update hr_workingdays set date = '$date1', noofdays = '$nodays' where month = '$month' and year ='$year'";
}
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_workingdays';"; 
echo "</script>";

?>