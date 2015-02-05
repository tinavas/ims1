<?php 
include "config.php";


$empname=$_SESSION['valid_user'];


if($_POST['id'])
{

$empname=$_POST['cuser'];
//////ac_financialpostings
	$q = "select * from ac_financialpostings where trnum = '$_POST[id]' and type = 'PPRCT' and client = '$client'";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
 while($qr = mysql_fetch_assoc($qrs))
 { 
         $coacode = $qr['coacode'];
		 $crdr = $qr['crdr'];
		 $date1 = $qr['date'];
		 
 }

$q= "delete from ac_financialpostings where trnum = '$_POST[id]' and type = 'PPRCT'";
$res = mysql_query($q,$conn) or die(mysql_error());

$q = "delete from pp_receipt where tid = '$_POST[id]'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}

$q = "select max(tid) as tid from pp_receipt";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$flag = '0';
$tid = $tid + 1;

$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('@',$_POST['vendor']);
$vendor = $temp[0];
$vendorcode = $temp[1];
$paymentmethod = $_POST['paymentmethod'];
$tds = $_POST['tds'];

$choice = $_POST['choice'];
$paymentmode = $_POST['paymentmode'];
$code = $_POST['code'];

$code1 = $_POST['code1'];
$description = $_POST['description'];
$dr = $_POST['dr'];
$amount = $_POST['amount'];

if($paymentmode=="Cheque")
{
$cheque = $_POST['cheque'];


}
$cdate = date("Y-m-d",strtotime($_POST['cdate']));
$unit=$_POST['unitc'];
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
$adate = $date;

		
$q1 = "insert into pp_receipt (vendorcode,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdsdr,tdsamount,tdsamount1,paymentmode,code,code1,description,dr,amount,cheque,cdate,totalamount,choice,flag,unit,empname,adate) values('$vendorcode','$tid','$date','$vendor','$paymentmethod','$tds','$tdscode','$tdsdescription','$tdsdr','$tdsamount','$tdsamount1','$paymentmode','$code','$code1','$description','$dr','$amount','$cheque','$cdate','$totalamount','$choice','$flag','$unit','$empname','$adate')";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
///////////financialpostings
$quantity = '0';
$tid = $tid;
$adate = $date;
$vendor = $vendor;
$tdscode = split(",",$tdscode);
$tdsamount1 = split(",",$tdsamount1);
$amount = $amount;
$totalamount = $totalamount;
$code = $code1;
$type = 'PPRCT';

$empname=$_SESSION['valid_user'];


if($_POST['id'])
{

$empname=$_POST['cuser'];
}

for($i = 0; $i < count($tdscode); $i++)
{ 
  if($tdsamount1[$i] > 0)
  {
	$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','','Dr','".$tdscode[$i]."','$quantity','".$tdsamount1[$i]."','".$tid."','".$type."','".$vendor."','".$unit."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
  }
}

    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$adate."','','Dr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$vendor."','".$unit."','$empname','$adate')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	
	
	$q = "select distinct(va) as code1 from contactdetails where name = '$vendor' order by va";
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
               VALUES('".$adate."','','Cr','".$code1."','$quantity','".$totalamount."','".$tid."','".$type."','".$vendor."','".$unit."','$cash','$bank','$cashcode','$bankcode','$schedule','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());



$query5 = "UPDATE pp_receipt SET flag = '1',adate = '$adate',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_receipt'";
echo "</script>";

?>