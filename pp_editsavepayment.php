<?php 
include "config.php";
$deltid = $_POST['deltid'];
$q = "delete from pp_payment where tid = '$deltid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


$q = "delete from ac_financialpostings where trnum = '$deltid' and type = 'PMT'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;
$doc=$_POST['doc_no'];
$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$vendor=$temp[0];
$vendorcode=$temp[1];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$remarks=$_POST['remarks'];
$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];

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
$unit=$_POST['unitc'];
$adate=$date;

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
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no,unit,empname,adate) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$po','$poactualamount','$poamountpaid','$pobalance','$flag','$doc','$unit','$empname','$adate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Pre Payment" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
			
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,actualamount,amountpaid,cheque,cdate,choice,flag,doc_no,unit,empname,adate) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$amount','$amount','$cheque','$cdate','$choice','$flag','$doc','$unit','$empname','$adate')";
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
$q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no,unit,empname,adate) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$totalamount','$cheque','$cdate','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc','$unit','$empname','$adate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$query5 = "UPDATE pp_sobi SET balance = '$balance' where so = '$sobi'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}
}
else if($paymentmethod == "Payment" && $choice == "On A/C")
{ 
	$actualamount = $amount + $tdsamount;
       $amountpaid = $amount + $tdsamount; $balance = '0';
	
			
		$q1 = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,cheque,cdate,totalamount,choice,posobi,actualamount,amountpaid,balance,flag,doc_no,unit,empname,adate) values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$totalamount','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc','$unit','$empname','$adate')";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
	//}
}



?>
<?php 
//Start of Financialpostings
include "config.php";
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
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','','Cr','".$tdscode[$i]."','$quantity','".$tdsamount1[$i]."','".$tid."','".$type."','".$venname."','".$unit."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	
 }
}


   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$adate."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$unit."','$empname','$adate')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	

	
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
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule,empname,adate) 
               VALUES('".$adate."','','Dr','".$code1."','$quantity','".$grandtotal."','".$tid."','".$type."','".$venname."','".$unit."','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	

	
	


$query5 = "UPDATE pp_payment SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_payment'";
echo "</script>";
?>
