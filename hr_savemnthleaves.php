<?php
include "config.php";
$client = $_SESSION['client'];

for($i=0;$i<count($_POST['nodays']);$i++) 
{
if ($_POST['nodays'][$i] != "") 
{
$sector = $_POST['sector'][$i];
$desig  = $_POST['desig'][$i];
$nodays = $_POST['nodays'][$i];
$fmonths = $_POST['month'][$i];

 $query = "select count(*) as c1 from hr_mnthleaves where sector = '$sector' and  designation = '$desig'";
$rs= mysql_query($query,$conn) or die(mysql_error());
while($r = mysql_fetch_assoc($rs))
{
 $c1 = $r['c1'];
}

if($c1 == 0)
{
 $q1 = "insert into hr_mnthleaves(sector,designation,allowedleaves,forwardmnths,client) values('".$sector."','".$desig."','".$nodays."','".$fmonths."','".$client."')";
 }
 else if($c1 >0)
 {
 $q1 = "update hr_mnthleaves set allowedleaves = '$nodays' ,forwardmnths = '$fmonths'  where sector = '$sector' and designation = '$desig'";
 }
 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnthleaves';"; 
echo "</script>";

?>