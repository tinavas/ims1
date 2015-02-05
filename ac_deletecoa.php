<?php
include "config.php";
$id=$_GET['id'];

$query1 = "select * from ac_coa where id = '$id'";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
 $schedule = $row1['schedule'];
}

 $query1 = "SELECT * FROM ac_schedule WHERE schedule = '$schedule'";
 $get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
 while($row1 = mysql_fetch_assoc($get_entriess_res2))
 {
  $fg = $row1['flag'];
 }

 if($fg <> 'Fixed')
 {
$query1 = "UPDATE ac_schedule SET flag = 'Added' WHERE schedule = '$schedule'" or die(mysql_error());
$get_entriess_res2 = mysql_query($query1,$conn) or die(mysql_error());
}



$get_entriess = "DELETE FROM ac_coa WHERE id = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_coa';";
echo "</script>";
?>

