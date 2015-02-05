<?php 
include "config.php";
if($_GET['type'] == "PP")
{
$query = "delete from pp_sobiclearance where trid = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=pp_sobiclearance');
}
else
{
if($_SESSION['db'] == "albustanlayer")
{
$q = "select cobi,cobiamount from oc_cobiclearance where trid = '$_GET[id]' and client = '$client'";
$r = mysql_query($q,$conn);
while($qr = mysql_fetch_assoc($r))
{
 $q5 = "update oc_cobi set balance = balance + '$qr[cobiamount]' where invoice = '$qr[cobi]'";
$result5 = mysql_query($q5,$conn) or die(mysql_error());
}
}
$query = "delete from oc_cobiclearance where trid = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=oc_cobiclearance');

}
?>