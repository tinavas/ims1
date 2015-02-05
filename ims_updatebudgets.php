<?php 
include "config.php";

$id = ($_POST['id']);
$tid = ($_POST['tid']);

$query1 = "delete from ims_budget where tid = '$tid'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());

$costcenter = $_POST['sector'];
$month = $_POST['month'];
$year = $_POST['year'];
$remarks = $_POST['remarks'];
$tid = "";
$q = "select max(tid) as tid from ims_budget";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;
for($i = 0; $i < count($_POST['code']); $i++)
{
if( $_POST['amt'][$i] != '0' && $_POST['amt'][$i] != '')
{


$code = ($_POST['code'][$i]);
 $desc = ($_POST['desc'][$i]);
$crdr = ($_POST['crdr'][$i]);
$amount = ($_POST['amt'][$i]);
$query1 = "insert into ims_budget
(tid,costcentre,month,year,coacode,description,crdr,amount,narration,client) values ('$tid','$costcenter','$month','$year','$code','$desc','$crdr','$amount','$remarks','$client') ";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_budgets';";
echo "</script>";

?>