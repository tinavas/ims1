<?php 
include "config.php";

$mode = $_POST['mode'];
$transactioncode = $_POST['tno'];
$bccodeno = $_POST['cno'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$name = $_POST['pname'];
$pmode = $_POST['pmode'];
$chno = $_POST['chno'];
$remarks = $_POST['remarks'];
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


$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
}

$q = "insert into ac_gl (mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,remarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus) VALUES ('$mode','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','R','U')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}

echo "<script type='text/javascript'>";
echo "top.location = 'dashboard.php?page=ac_rvoucher';";
echo "</script>";



?>