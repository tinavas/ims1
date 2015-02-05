<?php
include "config.php";
include "getemployee.php";
$quantity = 0;
$q = "select max(tid) as tid from oc_receipt where client = '$client' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $tid = $qr['tid'];

for($i = 0; $i <count($_POST['party']); $i++)
{ 
 if($_POST['party'][$i] <> "" && $_POST['cashbankcode'][$i] <> "" && $_POST['amount'][$i] <> "" && $_POST['amount'][$i] > 0)
 { 
  $date = date("Y-m-d",strtotime($_POST['date'][$i]));
  $party = $_POST['party'][$i];
  $doc = $_POST['docno'][$i];
  $paymentmode = $_POST['pmode'][$i];
  $code1 = $_POST['cashbankcode'][$i];
  $amount = $_POST['amount'][$i];
  $chequeno = $_POST['cheque'][$i];
  $cdate = date("Y-m-d",strtotime($_POST['chequedate'][$i]));
  
$tid++;
$q = "select acno from ac_bankmasters where coacode = '$code1' and client = '$client' ";
$qrs = mysql_query($q) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$cbcode = $qr['acno'];

$q = "select distinct(description) from ac_coa where code = '$code1' and client = '$client' order by description";
$qrs = mysql_query($q) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$description = $qr['description'];
  
	$q = "insert into oc_receipt (remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,adate,aempid,aempname,asector,client,actualamount,amountreceived,balance) 
values('$remarks','$tid','$date',\"$party\",'Receipt','Without TDS','','','','0','0','$paymentmode','$cbcode','$code1','$description','Dr','$amount','$amount','','','$chequeno','$cdate','On A/C','1','$date','$empid','$empname','$sector','$client','$amount','$amount','0')";
  $r = mysql_query($q,$conn) or die(mysql_error());
$coacode = $code1;
//Financial Postings-Bank A/c 
$type = "RCT"; 
$query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) VALUES('".$date."','','Dr','".$code1."','$quantity','".$amount."','".$tid."','".$type."',\"$party\",\"$party\",'$client')";
$result3 = mysql_query($query3,$conn) or die(mysql_error());

//Financial Postings-Customer A/c  
$q = "select distinct(ca) as code1 from contactdetails where name = \"$party\" AND (type = 'party' OR type = 'vendor and party')  and client = '$client' order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $code1 = $qr['code1'];
	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $coacode; $bankcode = ""; }
	elseif($paymentmode == 'Cheque')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $coacode; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];

$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,cash,bank,cashcode,bankcode,schedule)
VALUES('".$date."','','Cr','".$code1."','$quantity','".$amount."','".$tid."','".$type."',\"$party\",\"$party\",'$client','$cash','$bank','$cashcode','$bankcode','$schedule')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
 }
}
header("Location:dashboardsub.php?page=tally_receipts");
?>