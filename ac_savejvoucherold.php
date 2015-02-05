<?php 
include "config.php";

$tno = $_POST['tno'];
$date=date("Y-m-d",strtotime($_POST['date']));
for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['drcr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];
$remarks = $_POST['remarks'][$i];

$crtotal = $_POST['crtotal'];
$drtotal = $_POST['drtotal'];

$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
}

$q = "insert into ac_gl (code,description,type,controltype,schedule,crdr,cramount,dramount,remarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date) VALUES ('$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','U','$tno','Journal','0','$date')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}
echo "<script type='text/javascript'>";
echo "top.location = 'dashboard.php?page=ac_jvoucher';";
echo "</script>";

?>