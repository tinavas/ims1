<?php 
include "config.php";
include "getemployee.php";

if($_POST['edit'])
{

$id=$_POST['edit'];

$get_entriess = "DELETE FROM pp_paymentfarmer WHERE tid = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'PMTFARMER' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = $id and type = 'PMTFARMER'";
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


$q = "select max(tid) as tid from pp_paymentfarmer";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$tid = $tid + 1;


$date = date("Y-m-d",strtotime($_POST['date']));
$farmer = $_POST['farmer'];
$flock = $_POST['flock'];
$choice = "On A/C";
$paymentmode = $_POST['paymentmode'];
$cashbankcode=$code = $_POST['code'];
$remarks=$_POST['remarks'];
$code1 = $_POST['code1'];
$description = $_POST['description'];
$cr = $_POST['cr'];
$amount = $_POST['amount'];
$cheque = $_POST['cheque'];
$cdate = date("Y-m-d",strtotime($_POST['cdate']));
$type = "PMTFARMER";
$quantity =0;			
	 $q1 = "insert into pp_paymentfarmer (tid,date,farmer,flock,paymentmode,bankcashcode,coacode,description,type,amount,cheque,cdate,narration,aempname,asector,client) values('$tid','$date','$farmer','$flock','$paymentmode','$code','$code1','$description','PAYMENT','$amount','$cheque','$cdate','$remarks','','','$client')";
$q1rs = mysql_query($q1,$conn) or die(mysql_error()) ;


//Start of Financialpostings
   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$date."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$farmer."','".$flock."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
//////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code' and date = '$date' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		  $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code','$amount','Cr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code'and date = '$date' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

	
	
	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $cashbankcode; $bankcode = ""; }
	elseif($paymentmode == 'Cheque')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $cashbankcode; $cashcode = ""; }
	
	$code1 = "LI103";
	$schedule = "Trade Payable";
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$date."','','Dr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$farmer."','".$flock."','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

////insert into ac_financialpostingssummary
$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code1' and date = '$date' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code1','$amount','Dr','$venname','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code1'and date = '$date' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

$query5 = "UPDATE pp_paymentfarmer SET adate = '$date',aempname = '$empname',asector = '$sector' where id = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_paymentfarmer';";
echo "</script>";
?>
