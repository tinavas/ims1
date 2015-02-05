<?php 
include "config.php";
$voucher = 'P';
$mode = $_POST['mode'];
$transactioncode = $_POST['tno'];
$bccodeno = $_POST['cno'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$name = $_POST['pname'];
$pmode = $_POST['pmode'];
$chno = $_POST['chno'];
$username=$_POST['cuser'];
$date=date("Y-m-d",strtotime($_POST['date']));

$q = "select max(id) as maxid,min(id) as minid from ac_gl where transactioncode = '$transactioncode' AND voucher = '$voucher'";
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



//$desc = $_POST['desc'][$i];
//$crdr = $_POST['drcr'][$i];
$cramount = $_POST['cramount'][$i];
$dramount = $_POST['dramount'][$i];


$remarks = $_POST['remarks'][$i];

$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
}



$q = "update ac_gl set mode = '$mode',cramount = '$cramount',dramount = '$dramount',remarks = '$remarks',crtotal = '$crtotal',drtotal = '$drtotal',name = '$name',pmode = '$pmode',chequeno = '$chno',date = '$date',status = 'U',voucher = 'P',vstatus = 'U' where transactioncode = '$transactioncode' and id = '$preid'  AND voucher = '$voucher'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error()); 

$i = $i + 1;
$preid = $preid + 1;

}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_pvoucher';";
echo "</script>";



?>