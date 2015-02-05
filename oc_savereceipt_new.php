<?php 
include "config.php";
include "getemployee.php";

$addempid =$eempid= $empid;
$addempname= $eempname = $empname;
$entrydate = date("Y-m-d");
if($_POST['saed'] == 1)
{
$tidincr = $_POST['deltidincr'];
$tid = $_POST['deltid'];

$q = "select choice,aempid,aempname,adate from oc_receipt where tid = '$tid' and client = '$client'";
$r = mysql_query($q,$conn);
if($qr = mysql_fetch_assoc($r))
{
 $oldchoice = $qr['choice'];
 $addempid = $qr['aempid'];
 $addempname = $qr['aempname'];
 $entrydate = $qr['adate'];
}
if($oldchoice == "COBIs")
{
 $q = "select socobi,amountreceived from oc_receipt where tid = '$tid' and client = '$client'";
$r = mysql_query($q,$conn);
while($qr = mysql_fetch_assoc($r))
{
 $q5 = "update oc_cobi set balance = balance + '$qr[amountreceived]' where invoice = '$qr[socobi]'";
$result5 = mysql_query($q5,$conn) or die(mysql_error());
}
}

$query = "DELETE FROM oc_receipt WHERE tid = '$tid'";
mysql_query($query,$conn) or die(mysql_error());

$query = "DELETE FROM ac_financialpostings WHERE type = 'RCT' and trnum = '$tid'";
mysql_query($query,$conn) or die(mysql_error());

}
else
{
/*$q = "select max(tid) as tid from oc_receipt";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$tid = $tid + 1;*/


$q = "select max(tid) as tidincr from oc_receipt";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$tidincr = $qr['tidincr'];
}

$flag = '1';
$tidincr = $tidincr + 1;
$tid = $tidincr;


}
$flag = '1';
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$partycode = $_POST['partycode'];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];
$remarks = $_POST['remarks'];
$doc=$_POST['doc_no'];
$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];

$code1 = $_POST['code1'];
$description = $_POST['description'];
$dr = $_POST['dr'];
$amount = $_POST['amount'];
$bank = $_POST['bank'];
$branch = $_POST['branch'];
$cheque = $_POST['cheque'];
$cdate = date("Y-m-d",strtotime($_POST['cdate']));
//$costcenter = $_POST['costcenter'];

$tdscode = "";
$tdsdescription = "";
$tdscr = "";
$tdsamount = 0;
$tdsamount1 = "";


$q = "select ca as code1,id from contactdetails where name = '$party' AND type LIKE '%party%' order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $codecontact = $qr['code1'];

if($codecontact <>"")
{
if($tds == "With TDS")
{
for($i = 0; $i < count($_POST['tdscode']);$i++)
if($_POST['tdsamount'][$i] != '0' && $_POST['tdsamount'][$i] != '')
{
	$tdscode.=$_POST['tdscode'][$i] . ",";
	$tdsdescription.=$_POST['tdsdescription'][$i] . ",";
	$tdsdr = $_POST['tdsdr'][$i];
	$tdsamount1.=$_POST['tdsamount'][$i] . ",";
	$tdsamount+=$_POST['tdsamount'][$i];
}
$tdscode = substr($tdscode,0,-1);
$tdsdescription = substr($tdsdescription,0,-1);
$tdsamount1 = substr($tdsamount1,0,-1);
}
$totalamount = $tdsamount + $amount;

if($paymentmethod == "Advance" && $choice == "SOs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['so']); $i++)
if($_POST['soamountreceived'][$i] != 0 && $_POST['soamountreceived'][$i] != '' && $_POST['so'][$i] != '')
{
$so = $_POST['so'][$i];
$soactualamount = $_POST['soactualamount'][$i];
$soamountreceived = $_POST['soamountreceived'][$i];
$sobalance = $soactualamount - $soamountreceived;
if($sobalance < 0)
$sobalance = 0;
$tempamount+= ($soamountreceived - $soactualamount);
$q = "insert into oc_receipt (remarks,tid,date,party,partycode,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,socobi,actualamount,amountreceived,balance,flag,doc_no,aempid,aempname,adate) 
values('$remarks','$tid','$date','$party','$partycode','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$so','$soactualamount','$soamountreceived','$sobalance','$flag','$doc','$addempid','$addempname','$entrydate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Advance" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
			
$q = "insert into oc_receipt (remarks,tid,date,party,partycode,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,doc_no,aempid,aempname,adate) 
values('$remarks','$tid','$date','$party','$partycode','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$doc','$addempid','$addempname','$entrydate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}

else if($paymentmethod == "Receipt" && $choice == "COBIs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['cobi']); $i++)
if($_POST['amountreceived'][$i] != 0 && $_POST['amountreceived'][$i] != '0' && $_POST['cobi'][$i] != '')
{
$temp = explode('@',$_POST['cobi'][$i]);
$cobi = $temp[0];
$actualamount = $_POST['actualamount'][$i];
$amountreceived = $_POST['amountreceived'][$i];
$balance = round($actualamount - $amountreceived);
if($balance < 0)
$balance = 0;
$tempamount+= ($amountreceived - $actualamount);
$q = "insert into oc_receipt (remarks,tid,date,party,partycode,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,socobi,actualamount,amountreceived,balance,flag,doc_no,aempid,aempname,adate) 
values('$remarks','$tid','$date','$party','$partycode','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$cobi','$actualamount','$amountreceived','$balance','$flag','$doc','$addempid','$addempname','$entrydate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q5 = "update oc_cobi set balance = balance - '$amountreceived' where invoice = '$cobi'";
$result5 = mysql_query($q5,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Receipt" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
// New Code //	
	$q = "insert into oc_receipt (remarks,tid,date,party,partycode,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,doc_no,aempid,aempname,adate) 
values('$remarks','$tid','$date','$party','$partycode','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$doc','$addempid','$addempname','$entrydate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}


//// financial postings starts here

$quantity = '0';
$adate = $date;
$grandtotal = $amount + $tdsamount;
$type = 'RCT';

 $code = $code1;

  $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','','Dr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$party."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());


if($paymentmethod == "Advance")
      { 
	  $q = "select distinct(cac) as code1 from contactdetails where name = '$party' AND (type = 'party' OR type = 'vendor and party') order by vppa";
      }
	else if($paymentmethod == "Receipt")
      {
	  $q = "select distinct(ca) as code1 from contactdetails where name = '$party' AND (type = 'party' OR type = 'vendor and party') order by va";
      }
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }
	elseif($paymentmode == 'Cheque' or $paymentmode == 'Transfer')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];

$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule)
               VALUES('".$adate."','','Cr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$party."','".$party."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

/*$query5 = "UPDATE oc_receipt SET flag = '1',adate = '$adate',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());*/


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_receipt'";
echo "</script>";
}
else
{
echo "<script type='text/javascript'>";
echo "alert('Please Select Customer Group for this customer');";
echo "document.location='dashboardsub.php?page=oc_editcustomer&id=$qr[id]'";
echo "</script>";
}
?>