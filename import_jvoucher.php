<?php
include "config.php";
$username = $_SESSION['valid_user'];

for($i = 0; $i < count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> "" && $_POST['amount'][$i] <> "" && $_POST['amount'][$i] <> "0")
 {
	$tid = $_POST['tid'][$i];
	if($previoustid <> $tid)
	{
	$date = date("Y-m-d",strtotime($_POST['date'][$i]));
	$docno = $_POST['docno'][$i];
	$crtotal = $_POST['cramount'][$i];
	}
	$coacode = $_POST['code'][$i];
	$crdr = $_POST['crdr'][$i];
	$cramount = $dramount = 0;
	if($crdr == 'Cr')
	 $amount = $cramount = $_POST['amount'][$i];	
	elseif($crdr == 'Dr')
	 $amount = $dramount = $_POST['amount'][$i];
    $narration = $_POST['narration'][$i];	 
	$query1 = "SELECT description,type,controltype,schedule FROM ac_coa WHERE code = '$coacode'";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	$rows1 = mysql_fetch_assoc($result1);
	$desc = $rows1['description'];
	$type = $rows1['type'];
	$ctype = $rows1['controltype'];
	$schedule = $rows1['schedule'];
	
  $q = "insert into ac_gl (username,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,client) VALUES ('$username','$coacode','$desc','$type','$ctype','$schedule','$crdr','$cramount','$dramount','$narration','$crtotal','$drtotal','J','A','$tid','Journal','0','$date','$client')";
 $qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set tflag = '1' where code = '$coacode' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse) VALUES ('$date','$crdr','$coacode','$amount','$tid','Journal','$client','$unit') ";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());

	
	$previoustid = $tid;
 }
}
header("Location:dashboardsub.php?page=tally_jvoucher");
?>