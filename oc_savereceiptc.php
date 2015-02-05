<?php 
include "config.php";
if($_POST['saed'] == 1)
{
$tid = $_POST['deltid'];
$query = "DELETE FROM oc_receipt WHERE tid = '$tid'";
mysql_query($query,$conn) or die(mysql_error());
}
else
{
$q = "select max(tid) as tid from oc_receipt";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$tid = $tid + 1;
}
$flag = '0';
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
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
$q = "insert into oc_receipt (remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,socobi,actualamount,amountreceived,balance,flag,doc_no) 
values('$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$so','$soactualamount','$soamountreceived','$sobalance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Advance" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
			
$q = "insert into oc_receipt (remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,doc_no) 
values('$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}

else if($paymentmethod == "Receipt" && $choice == "COBIs")
{
$tempamount = 0;
for($i = 0; $i < count($_POST['cobi']); $i++)
if($_POST['amountreceived'][$i] != 0 && $_POST['amountreceived'][$i] != '' && $_POST['cobi'][$i] != '')
{
$cobi = $_POST['cobi'][$i];
$actualamount = $_POST['actualamount'][$i];
$amountreceived = $_POST['amountreceived'][$i];
$balance = $actualamount - $amountreceived;
if($balance < 0)
$balance = 0;
$tempamount+= ($amountreceived - $actualamount);
$q = "insert into oc_receipt (remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,socobi,actualamount,amountreceived,balance,flag,doc_no) 
values('$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$cobi','$actualamount','$amountreceived','$balance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q5 = "update oc_cobi set balance = '$balance' where invoice = '$cobi'";
$result5 = mysql_query($q5,$conn) or die(mysql_error());
}
}

else if($paymentmethod == "Receipt" && $choice == "On A/C")
{
	$tempamount = $amount + $tdsamount;
// New Code //	
	$q = "insert into oc_receipt (remarks,tid,date,party,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,totalamount,bank,branch,cheque,cdate,choice,flag,doc_no) 
values('$remarks','$tid','$date','$party','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$totalamount','$bank','$branch','$cheque','$cdate','$choice','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_receipt'";
echo "</script>";
?>