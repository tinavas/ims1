<?php
include "config.php";
$id=$_GET['id'];

$q="select * from ac_bankcashcodes where id='$id'";

$r=mysql_query($q,$conn);
while($row=mysql_fetch_array($r))
{
$oldcode=$row['code'];


}


$q="select * from ac_bankmasters where code='$oldcode'";

$r=mysql_query($q,$conn);
while($row=mysql_fetch_array($r))
{
$coa=$row['coacode'];


}



$query2="UPDATE ac_coa set flag = '0' WHERE code = '$coa'" or die(mysql_error());
$result2 = mysql_query($query2,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_bankmasters WHERE code ='$oldcode'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_bankcashcodes WHERE id = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_bankcashmasters';";
echo "</script>";
?>

