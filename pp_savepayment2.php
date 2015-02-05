<?php 
//This file is only for Central
include "config.php";

$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;
$conversion = 1;
if(isset($_POST['deltid']))
{
$tid = $_POST['deltid'];
$query = "select choice,amountpaid,posobi,orgamount,camount from pp_payment where tid = '$tid'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $choice = $rows['choice'];
 if($choice == 'SOBIs')
 {
  $sobi = $rows['posobi'];
  $amountpaid = $rows['amountpaid'];
  $orgamount = $rows['orgamount'];
  $camount = $rows['camount'];
  $q2 = "update pp_sobi set balance = balance + ($orgamount * camount) where so = '$sobi'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());
 }
 if($_POST['edit'] == "yes")
  $conversion = $_POST['conversion'];
 else
  $conversion = $camount; 
}
$id = $tid;
$get_entriess = "DELETE FROM pp_payment WHERE tid = $tid";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'PMT' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = $tid and type = 'PMT'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date12' and crdr = '$crdr'";
		$res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		$amountnew = $qhr1['amount'];
		 }
	
		 $amt = $amountnew - $amount123;
		   
		$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$date12' and crdr = '$crdr'";
		$r1 = mysql_query($q1,$conn) or die(mysql_error());
}
}
//End of Delete

if($_SESSION['db'] == 'central' && $_POST['edit'] == 'yes')
{
 $q = "update hr_conversion set flag = 1 where id = '".$_POST['currencyid']."'";		//To Lock the Record
 $r = mysql_query($q,$conn) or die(mysql_error());
 $conversion = $_POST['conversion'];
}

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$doc=$_POST['doc_no'];
$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];
$remarks=$_POST['remarks'];
$code1 = $_POST['code1'];
$description = $_POST['description'];
$cr = $_POST['cr'];
$amount = $_POST['amount'];
$cheque = $_POST['cheque'];
$cdate = date("Y-m-d",strtotime($_POST['cdate']));

$tdscode = "";
$tdsdescription = "";
$tdscr = "";
$tdsamount = 0;
$tdsamount1 = "";

if($tds == "With TDS")
{
for($i = 0; $i < count($_POST['tdscode']);$i++)
if($_POST['tdsamount'][$i] != '0' && $_POST['tdsamount'][$i] != '')
{
	$tdscode.=$_POST['tdscode'][$i] . ",";
	$tdsdescription.=$_POST['tdsdescription'][$i] . ",";
	$tdscr = $_POST['tdscr'][$i];
	$tdsamount1.=$_POST['tdsamount'][$i] . ",";
	$tdsamount+=$_POST['tdsamount'][$i];
}
$tdscode = substr($tdscode,0,-1);
$tdsdescription = substr($tdsdescription,0,-1);
$tdsamount1 = substr($tdsamount1,0,-1);
}
$totalamount = $tdsamount + $amount;

if($paymentmethod == "Pre Payment" && $choice == "POs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['po']); $i++)
if($_POST['poamountpaid'][$i] != 0 && $_POST['poamountpaid'][$i] != '' && $_POST['po'][$i] != '')
{
$po = $_POST['po'][$i];
$poactualamount = $_POST['poactualamount'][$i];
$poamountpaid = $_POST['poamountpaid'][$i];
$pobalance = $poactualamount - $poamountpaid;
if($pobalance < 0)
$pobalance = 0;
$tempamount+= ($poamountpaid - $poactualamount);
$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) 
values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$po','$poactualamount','$poamountpaid','$pobalance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Pre Payment" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
			
$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,flag,actualamount,amountpaid,balance,doc_no) 
values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$flag','$amount','$amount','$amount','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}

else if($paymentmethod == "Payment" && $choice == "SOBIs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['sobi']); $i++)
if($_POST['amountpaid'][$i] != 0 && $_POST['amountpaid'][$i] != '' && $_POST['sobi'][$i] != '')
{
$sobi = $_POST['sobi'][$i];
$actualamount = $_POST['actualamount'][$i];
$amountpaid = $_POST['amountpaid'][$i];
$balance = $actualamount - $amountpaid;
if($balance < 0)
$balance = 0;
$tempamount+= ($amountpaid - $actualamount);

 $q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no,orgamount,camount) 
values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr',($amount * $conversion),($totalamount * $conversion),'$cheque','$cdate','$choice','$sobi',($actualamount * $conversion),($amountpaid * $conversion),($balance * $conversion),'$flag','$doc','$amountpaid','$conversion')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

//$balance *= $conversion;
$query5 = "UPDATE pp_sobi SET balance = balance - ($amountpaid * camount) where so = '$sobi'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}
}
else if($paymentmethod == "Payment" && $choice == "On A/C")
{ 
	$actualamount = $amount + $tdsamount;
       $amountpaid = $amount + $tdsamount; $balance = '0';
			
 $q1 = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,cheque,cdate,totalamount,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr',($tdsamount * $conversion),'$tdsamount1','$paymentmode','$code','$code1','$description','$cr',($amount * $conversion),'$cheque','$cdate',($totalamount * $conversion),'$choice','$sobi',($actualamount * $conversion),($amountpaid * $conversion),($balance * $conversion),'$flag','$doc')";
$q1rs = mysql_query($q1,$conn) or die(mysql_error()) ;

if($_SESSION['db'] == "central")
{
 $q = "update pp_payment set orgamount =  '$totalamount',camount = '$conversion' where tid = '$tid'";
 $qr = mysql_query($q,$conn) or die(mysql_error());
}
}
else if($paymentmethod == "Payment" && $choice == "Credit Notes")
{

}


//Start of Financialpostings
include "getemployee.php";
$quantity = '0';
//$tid = $_POST['tid'];
$adate = $date;
$venname = $vendor;
$grandtotal = $amount + $tdsamount;
//$paymentmethod = $_POST['paymentmethod'];

$tdscode = split(",",$tdscode);
$tdsamount1 = split(",",$tdsamount1);
$type = 'PMT';
for($i = 0; $i < count($tdscode); $i++)
{
 if($tdsamount1[$i] > 0)
 {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$tdscode[$i]."','$quantity','".($tdsamount1[$i] * $conversion)."','".$tid."','".$type."','".$venname."','".$venname."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
/////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$tdscode[$i]' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$tdscode[$i]',($tdsamount1[$i] * $conversion),'Cr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($freightamount * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$tdscode[$i]'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
	
 }
}


   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','','Cr','".$code."','$quantity','".($amount * $conversion)."','".$tid."','".$type."','".$venname."','".$venname."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
//////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		  $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code',($amount * $conversion),'Cr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($amount * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

	
	if($paymentmethod == "Pre Payment")
	$q = "select distinct(vppa) as code1 from contactdetails where name = '$venname' and (type = 'vendor' OR type = 'vendor and party') order by vppa";
	else if($paymentmethod == "Payment")
	$q = "select distinct(va) as code1 from contactdetails where name = '$venname' and (type = 'vendor' OR type = 'vendor and party') order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $code1 = $qr['code1'];
	
	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }
	elseif($paymentmode == 'Cheque')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];


for($i = 0; $i < count($_POST['sobi']); $i++)
if($_POST['amountpaid'][$i] != 0 && $_POST['amountpaid'][$i] != '' && $_POST['sobi'][$i] != '')
{
$sobi = $_POST['sobi'][$i];
$actualamount = $_POST['actualamount'][$i];
$amountpaid = $_POST['amountpaid'][$i];
$balance = $actualamount - $amountpaid;
if($balance < 0)
$balance = 0;
$tempamount+= ($amountpaid - $actualamount);

$query = "select grandtotal,camount from pp_sobi where so = '$sobi' LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$sobiamount = $rows['grandtotal'];
$pconversion = $rows['camount'];
//$paymentamount = $actualamount * $pconversion;
//$paymentamount2 = $amountpaid * $conversion;

$pamountpaid = $amountpaid * $pconversion;
$amountpaid = $amountpaid * $conversion;
$diff += ($pamountpaid - $amountpaid);

//$diff = $sobiamount - $paymentamount2;

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$adate."','','Dr','".$code1."','$quantity','".$amountpaid."','".$tid."','".$type."','".$venname."','".$venname."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code1' and date = '$adate' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1',$amountpaid,'Dr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amountpaid;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code1'and date = '$adate' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
}		 
		 
if($diff <> '0')
{
 if($diff > 0)
  $crdr = "Dr";
 else
  $crdr = "Cr";
 $coa = "IE101";
 if($diff < 0)
  $diff = -$diff;
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$adate."','','$crdr','$coa','$quantity','".$diff."','".$tid."','".$type."','".$venname."','".$venname."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
$q = "update ac_coa set tflag = '1' where code = '$coa' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coa' and date = '$adate' and crdr = '$crdr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coa',$diff,'$crdr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $diff;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coa'and date = '$adate' and crdr = '$crdr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

}



$query5 = "UPDATE pp_payment SET flag = '1',adate = '$adate',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());




echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_payment';";
echo "</script>";
?>
