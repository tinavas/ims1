<?php 
include "config.php";

$mode = $_POST['type'];
$mode1 = $_POST['mode'];
$transactioncode = $_POST['tno'];
$vendor = $_POST['vendor'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$date=date("Y-m-d",strtotime($_POST['date']));
$remarks = $_POST['remarks'];
$totamount = $_POST['vendamount'];
$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");

$q = "select max(id) as maxid,min(id) as minid from ac_crdrnote where crnum = '$transactioncode'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
   	$maxid = $qr['maxid'];
	$minid = $qr['minid'];
}

$preid = $minid;
$i = 0;
for($j = $minid;$j <= $maxid ;$j++)
{
$cramount = $_POST['cramount'][$i];
$dramount = $_POST['dramount'][$i];
$q = "update ac_crdrnote set cramount = '$cramount',amount = '$dramount',remarks = '$remarks',crtotal = '$crtotal',drtotal = '$drtotal',date = '$date',totalamount = '$totamount',vcode = '$vendor',empname='$empname',adate='$adate'  where crnum = '$transactioncode' and id = '$preid' ";
#$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1',empname='$empname',adate='$adate' where code = '$code' ";
#$qrs = mysql_query($q,$conn) or die(mysql_error()); 

$i = $i + 1;
$preid = $preid + 1;

}

echo "<script type='text/javascript'>";
#echo "top.location = 'dashboard.php?page=pp_creditnote&type=$mode'";
echo "</script>";


?>