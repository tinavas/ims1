<?php
include "config.php";
$id=$_GET['id'];

$query1 = "select * from ac_bankmasters where id = '$id'";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
 $coacode = $row1['coacode'];
 $code = $row1['code'];
}

  $queryu="UPDATE ac_coa set flag = '0' WHERE code = '$coacode'" or die(mysql_error());
  $get_entriess_resu1 = mysql_query($queryu,$conn) or die(mysql_error());



  $queryu1="UPDATE ac_bankcashcodes set flag = '0' WHERE code = '$code'" or die(mysql_error());
  $get_entriess_resu11 = mysql_query($queryu1,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_bankmasters WHERE id = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_bankcashcoamapping';";
echo "</script>";
?>

