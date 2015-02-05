<?php
include "config.php";
$id=$_GET['id'];

$query1 = "select * from ac_chequeseries where id = '$id'";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
 $acno = $row1['acno'];
}

  $queryu="UPDATE ac_bankmasters set flag = '0' WHERE acno = '$acno'" or die(mysql_error());
  $get_entriess_resu1 = mysql_query($queryu,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_chequeseries WHERE id = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_chequeseries';";
echo "</script>";
?>

