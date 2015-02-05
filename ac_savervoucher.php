<?php 
include "config.php";
include "cashcheck.php";
//session_start();
$client = $_SESSION['client'];
$unit = $_POST['unitc'];

for($f = 0;$f<count($_POST['code']);$f++)
{
$flag=0;
if($_POST['code'][$f] != "")
{
 $code = $_POST['code'][$f];
$crdr = $_POST['drcr'][$f];
$dramount = $_POST['dramount'][$f];
$cramount = $_POST['cramount'][$f];

 if ( $crdr == "Cr" )
		 {
		   $amount = $cramount;
		 }
		 else
		 {
           $amount = $dramount;		 
		 }


 $flag=cashcheck($code,$amount,$crdr);
if($flag=='1')
{
	 echo "<script type='text/javascript'>";
echo "alert('Remainder: Insufficient Funds in $code account');";
echo "</script>"; 
}
}
}

$mode = $_POST['mode'];
$username=$_SESSION['valid_user'];
//$manual_trnum=$_POST['manual_tno'];
$voucher = 'R';
	$tnum=0;
	$trnum1="";		
 $q = "select transactioncode as tid from  `ac_gl` where client = '$client' and voucher = '$voucher'  "; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],3);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tnum = "RV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="RV-1";

}

$transactioncode = $tnum;
$vouchernumber = $_POST['vno'];
$bccodeno = $_POST['cno'];
$drtotal = round($_POST['drtotal'],2);
$crtotal = round($_POST['crtotal'],2);
$name = $_POST['pname'];
$pmode = $_POST['pmode'];
$chno = $_POST['chno'];

$date=date("Y-m-d",strtotime($_POST['date']));

$adate=date("Y-m-d");

//To fill cash,bank,cashcode,bankcode,schdule
for($i = 0,$k = -1,$l = -1;$i<count($_POST['code']);$i++)
 if($_POST['code'][$i] != "")
 {
   $entrycode[++$k] = $_POST['code'][$i];
   $allcodes .= "'".$_POST['code'][$i]."',";
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

for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$remarks = $_POST['remarks'][$i];
$code = $_POST['code'][$i];
$desc = $arraycode[$_POST['code'][$i]];
$crdr = $_POST['drcr'][$i];
$dramount = round($_POST['dramount'][$i],2);
$cramount = round($_POST['cramount'][$i],2);
 if ( $crdr == "Cr" )
		 {
		   $amount = $cramount;
		 }
		 else
		 {
           $amount = $dramount;		 
		 }

$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
	if($controltype != "" && $m == "")
	{
	$m = $controltype;
	}
}

$q = "insert into ac_gl (username,mode,vouchernumber,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,warehouse,empname,adate) VALUES ('$username','$m','$vouchernumber','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','R','A','$client','$unit','$username','$adate')";


$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

//To fill cash,bank,cashcode,bankcode,schdule
$cash = $bank = 'NO';
$cashcode = $bankcode = $schedule = "";
 if(in_array($code,$cashcodearray))
 { 
  $cash = 'NO';
  if($be == 1)
  {
   $bank = 'YES';
   $bankcode = $debitbankcode;
  }
 }
 elseif(in_array($code,$bankcodearray))
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
 if($code == $bankentriesarray[0])
 { $bank = 'YES'; $bankcode = $bankentriesarray[1]; }
 elseif($code == $bankentriesarray[1])
 { $bank = 'YES'; $bankcode = $bankentriesarray[0]; }
}
if($countcashentries == 2)	//If the transaction is made between two CASH, it is used
{
 if($code == $cashentriesarray[0])
 { $cash = 'YES'; $cashcode = $cashentriesarray[1]; }
 elseif($code == $cashentriesarray[1])
 { $cash = 'YES'; $cashcode = $cashentriesarray[0]; }
} 

if($countbankentries == 1 && $countcashentries == 1 && $k == 1)	//If the transaction is made only through cash & bank, it is used
{
 if($code == $cashentriesarray[0])
 { $cash = 'NO'; $bank = 'YES'; $bankcode = $bankentriesarray[0]; }
 elseif($code == $bankentriesarray[0])
 { $cash = 'YES'; $bank = 'NO'; $cashcode = $cashentriesarray[0]; }
}

if($cash == 'YES' or $bank == 'YES')
{
 $q = "SELECT schedule FROM ac_coa WHERE code = '$code'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];
}
//End


$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,cash,bank,cashcode,bankcode,schedule,warehouse,empname,adate) VALUES ('$date','$crdr','$code','$amount','$transactioncode','RV','$client','$cash','$bank','$cashcode','$bankcode','$schedule','$unit','$empname','$adate') ";



          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	
		
	
}

}


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ac_rvoucher';";
echo "</script>";



?>