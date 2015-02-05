<?php
include "config.php";
$username = $_SESSION['valid_user'];

for($i = 0; $i < count($_POST['code']); $i++)
{
 if($_POST['code'][$i] <> "" && $_POST['amount'][$i] <> "" && $_POST['amount'][$i] <> "0")
 {
	$tid = $_POST['tid'][$i];
	if($previoustid <> $tid)
	{
	$date = date("Y-m-d",strtotime($_POST['date'][$i]));
	$docno = $_POST['docno'][$i];
	$mode = $_POST['mode'][$i];
	$cbcode = $_POST['cbcode'][$i];	
	$pmode = $_POST['pmode'][$i];
	$chno = $_POST['cheque'][$i];
	$cdate = date("Y-m-d",strtotime($_POST['cdate'][$i]));
	
	$crtotal = $_POST['cramount'][$i];
	$entrycode = $allcodes = $arraycode = $cashcodearray = $bankcodearray = $cashentriesarray = $bankentriesarray = "";
	
//To fill cash,bank,cashcode,bankcode,schdule
for($temp = $i,$k = -1,$l = -1;$i<count($_POST['code']) && $tid == $_POST['tid'][$temp] ;$temp++)
 if($_POST['code'][$temp] != "")
 {
   $entrycode[++$k] = $_POST['code'][$temp];
   $allcodes .= "'".$_POST['code'][$temp]."',";
  }
$allcodes = substr($allcodes,0,-1);

$query = "SELECT code,description FROM ac_coa WHERE code IN ($allcodes) ORDER BY code";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $arraycode[$rows['code']] = $rows['description'];

$c = $b = $n = $o = -1;	//$c means cash index and $b means bank index
$ce = $be = $countcashentries = $countbankentries = 0;	//$ce means cash entry and $be means bank entry
$q = "SELECT code,controltype FROM ac_coa WHERE controltype IN ('cash','bank')";
$r = mysql_query($q,$conn) or die(mysql_error());
while($rr = mysql_fetch_assoc($r))
{
 if($rr['controltype'] == 'Cash')
 {
  $cashcodearray[++$c] = $rr['code'];
  if(in_array($rr['code'],$entrycode))
  { $ce = 1; $countcashentries++; $cashentriesarray[++$o] = $rr['code']; $debitcashcode = $rr['code']; }	// It means one cash entry record is there
 }  
 elseif($rr['controltype'] == 'Bank')
 {
  $bankcodearray[++$b] = $rr['code'];
  if(in_array($rr['code'],$entrycode))
  { $be = 1; $countbankentries++; $bankentriesarray[++$n] = $rr['code']; $debitbankcode = $rr['code']; } // It means one bank entry record is there
 } 
}
//End

	
	}
	$coacode = $_POST['code'][$i];
	$crdr = $_POST['crdr'][$i];
	$cramount = $dramount = 0;
	if($crdr == 'Cr')
	 $amount = $cramount = $_POST['amount'][$i];	
	elseif($crdr == 'Dr')
	 $amount = $dramount = $_POST['amount'][$i];
    $narration = $_POST['narration'][$i];	 
	$query1 = "SELECT description,type,controltype,schedule FROM ac_coa WHERE code = '$coacode'";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
	$rows1 = mysql_fetch_assoc($result1);
	$desc = $rows1['description'];
	$type = $rows1['type'];
	$ctype = $rows1['controltype'];
	$schedule = $rows1['schedule'];
	
$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,warehouse,chkdate,vouchernumber) VALUES ('$username','$mode','$tid','$cbcode','$coacode','$desc','$type','$ctype','$schedule','$crdr','$cramount','$dramount','$narration','$crtotal','$crtotal','','$pmode','$chno','$date','U','R','A','$client','$unit','$cdate','$docno')";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
 
$q = "update ac_coa set tflag = '1' where code = '$coacode' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());


//To fill cash,bank,cashcode,bankcode,schdule
$cash = $bank = 'NO';
$cashcode = $bankcode = $schedule = "";
 if(in_array($coacode,$cashcodearray))
 { 
  $cash = 'NO';
  if($be == 1)
  {
   $bank = 'YES';
   $bankcode = $debitbankcode;
  }
 }
 elseif(in_array($coacode,$bankcodearray))
 {
  $bank = 'NO';
  if($ce == 1)
  {
   $cash = 'YES';
   $cashcode = $debitcashcode;
  }
 } 
 else
 {
  if($ce == 1) { $cash = 'YES'; $cashcode = $debitcashcode; }
  if($be == 1) { $bank = 'YES'; $bankcode = $debitbankcode; }
 }
if($countbankentries == 2)	//If the transaction is made between two banks, it is used
{
 if($coacode == $bankentriesarray[0])
 { $bank = 'YES'; $bankcode = $bankentriesarray[1]; }
 elseif($coacode == $bankentriesarray[1])
 { $bank = 'YES'; $bankcode = $bankentriesarray[0]; }
}
if($countcashentries == 2)	//If the transaction is made between two CASH, it is used
{
 if($coacode == $cashentriesarray[0])
 { $cash = 'YES'; $cashcode = $cashentriesarray[1]; }
 elseif($coacode == $cashentriesarray[1])
 { $cash = 'YES'; $cashcode = $cashentriesarray[0]; }
} 

if($countbankentries == 1 && $countcashentries == 1 && $k == 1)	//If the transaction is made only through cash & bank, it is used
{
 if($coacode == $cashentriesarray[0])
 { $cash = 'NO'; $bank = 'YES'; $bankcode = $bankentriesarray[0]; }
 elseif($coacode == $bankentriesarray[0])
 { $cash = 'YES'; $bank = 'NO'; $cashcode = $cashentriesarray[0]; }
}

if($cash == 'YES' or $bank == 'YES')
{
 $q = "SELECT schedule FROM ac_coa WHERE code = '$coacode'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];
}
//End


$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,cash,bank,cashcode,bankcode,schedule,warehouse) VALUES ('$date','$crdr','$coacode','$amount','$tid','RV','$client','$cash','$bank','$cashcode','$bankcode','$schedule','$unit') ";
$qrs1 = mysql_query($q1,$conn) or die(mysql_error());

	
	$previoustid = $tid;
 }
}
header("Location:dashboardsub.php?page=tally_rvoucher");
?>