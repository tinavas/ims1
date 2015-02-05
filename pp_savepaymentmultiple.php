<?php
include "config.php";
include "getemployee.php";
$quantity = 0;
$q = "select max(tid) as tid from pp_payment where client = '$client' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];

for($i = 0; $i <count($_POST['party']); $i++)
{
 if($_POST['party'][$i] <> "select" && $_POST['code'][$i] <> "select" && $_POST['amount'][$i] <> "" && $_POST['amount'][$i] > 0)
 {
  $date = date("Y-m-d",strtotime($_POST['date'][$i]));
  $party = $_POST['party'][$i];
  $doc = $_POST['bookinvoice'][$i];
  $warehouse = $_POST['warehouse'][$i];
  $paymentmode = $_POST['paymentmode'][$i];
  $code = $_POST['code'][$i];
  $amount = $_POST['amount'][$i];
  $chequeno = $_POST['cheque'][$i];
  $cdate = date("Y-m-d",strtotime($_POST['cdate'][$i]));
  
$tid++;
if( $paymentmode == 'Cash')
 $q = "select coacode from ac_bankmasters where code = '$code' and client = '$client' ";
elseif($paymentmode == 'Cheque') 
 $q = "select coacode from ac_bankmasters where acno = '$code' and client = '$client' ";

$qrs = mysql_query($q) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$cbcode = $code1 = $qr['coacode'];

$q = "select distinct(description) from ac_coa where code = '$code1' and client = '$client' order by description";
$qrs = mysql_query($q) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
$description = $qr['description'];
  
	$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,cheque,cdate,choice,flag,adate,aempid,aempname,asector,client,actualamount,amountpaid) 
values('$remarks','$tid','$date','$party','Payment','Without TDS','','','','0','0','$paymentmode','$code','$code1','$description','Cr','$amount','$amount','$chequeno','$cdate','On A/C','1','$date','$empid','$empname','$sector','$client','$amount','$amount')";
  $r = mysql_query($q,$conn) or die(mysql_error());
$coacode = $code1;
//Financial Postings-Bank A/c 
$type = "PMT"; 
$query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) VALUES('".$date."','','Cr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$party."','$client')";
$result3 = mysql_query($query3,$conn) or die(mysql_error());
/*Financial Postings Summary-Bank A/c
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code1' and date = '$date' and crdr = 'Dr'";
$res1r = mysql_query($qury1r,$conn);
while($qhr1 = mysql_fetch_assoc($res1r))
 $amountnew = $qhr1['amount'];

if($amountnew == "")
{
$q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code1','$amount','Dr','$warehouse','$client')";
$r = mysql_query($q,$conn) or die(mysql_error());
}
else
{
$amt = $amountnew + $amount;
$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code1'and date = '$date' and crdr = 'Dr'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
}
*/
//Financial Postings-Customer A/c  
$q = "select distinct(va) as code1 from contactdetails where name = '$party' AND (type = 'vendor' OR type = 'vendor and party')  and client = '$client' order by va";
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
VALUES('".$date."','','Dr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$party."','$client','$cash','$bank','$cashcode','$bankcode','$schedule')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
/*Financial Postings Summary-Customer A/c
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code1' and date = '$date' and crdr = 'Cr'";
$res1r = mysql_query($qury1r,$conn);
while($qhr1 = mysql_fetch_assoc($res1r))
 $amountnew = $qhr1['amount'];

if($amountnew == "")
{
$q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code1','$amount','Cr','$warehouse','$client')";
$r = mysql_query($q,$conn) or die(mysql_error());
}
else
{
$amt = $amountnew + $amount;
$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code1'and date = '$date' and crdr = 'Cr'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
}
*/
 }
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_addpaymentmultiple'";
echo "</script>";

?>