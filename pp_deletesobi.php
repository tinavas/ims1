<?php 
include "config.php";

$query = "select gr from pp_sobi where so = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());

while($res = mysql_fetch_assoc($result))
{
$q = "update pp_goodsreceipt set sobiflag = '0' where gr = '$res[gr]'";
$qr = mysql_query($q,$conn) or die(mysql_error());
}
$query = "delete from ac_financialpostings where trnum = '$_GET[id]' and type = 'SOBI'";
$result = mysql_query($query,$conn) or die(mysql_error());
$query = "delete from pp_sobi where so = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_sobi'";
echo "</script>";
?>