<?php 
include "config.php";
include "cashcheck.php";

$flag=$flag1=0;

for($i = 0; $i < count($_POST['tdscode']);$i++)
{
$tdsamount=$_POST['tdsamount'][$i];
$tdscode=$_POST['tdscode'][$i];
 $flag1=cashcheck($tdscode,$tdsamount,Cr);
if($flag1=='1')
{
echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}
if($_POST['code'] != "")
{
 $code = $_POST['code'];
$amount = $_POST['amount'];
$code1 = $_POST['code1'];
 $flag=cashcheck($code1,$amount,Cr);
if($flag=='1')
{
echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}


$empname=$_SESSION['valid_user'];
if($_POST['saed'] <> "")
{
$empname=$_POST['cuser'];
$deltid = $_POST['deltid'];
$q = "delete from pp_payment where tid = '$deltid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$empname=$_POST['cuser'];
}


$q = "delete from ac_financialpostings where trnum = '$deltid' and type = 'PMT'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;

$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$unit=$_POST['unitc'];
$adate=$date;
$vendor=$temp[0];
$vendorcode=$temp[1];
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



if($paymentmode=="Cheque")
{
$cheque = $_POST['cheque'];


}


$cdate = date("Y-m-d",strtotime($_POST['cdate']));

$tdscode = "";
$tdsdescription = "";
$tdscr = "";
$tdsamount = 0;
$tdsamount1 = "";


$q = "select va as code1,id from contactdetails where name = '$vendor' and (type = 'vendor' OR type = 'vendor and party') order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $codecontact = $qr['code1'];

if($codecontact <> "")
{

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


	$tempamount = $amount + $tdsamount;
			
 $q = "insert into pp_payment (vendorcode,remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,flag,actualamount,amountpaid,balance,doc_no,unit,empname,adate) 
values('$vendorcode','$remarks','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdscr','$tdsamount','$paymentmode','$code','$code1','$description','$cr','$amount','$cheque','$cdate','$choice','$flag','$amount','$amount','$amount','$doc','$unit','$empname','$adate')";
$qrs = mysql_query($q,$conn) or die(mysql_error());





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

$empname=$_SESSION['valid_user'];
if($_POST['saed'] <> "")
{
$empname=$_POST['cuser'];

}
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
	


	$q = "select distinct(va) as code1 from contactdetails where name = '$venname' and (type = 'vendor' OR type = 'vendor and party') order by va";
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
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule,empname,adate) 
               VALUES('".$adate."','','Dr','".$code1."','$quantity','".$grandtotal."','".$tid."','".$type."','".$venname."','".$unit."','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());



 $query5 = "UPDATE pp_payment SET flag = '1',adate = '$adate',aempname = '$empname',asector = '$sector',adate='$adate' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_payment';";
echo "</script>";

}
else
{
echo "<script type='text/javascript'>";
echo "alert('Please Select Customer Group for this customer');";
//echo "document.location='dashboardsub.php?page=pp_editsupplier&id=$qr[id]'";
echo "</script>";
}

?>
