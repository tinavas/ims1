<?php 
include "config.php";
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
$mode = $_POST['mode'];
$transactioncode = $_POST['tno'];
$bccodeno = $_POST['cno'];
$drtotal = round($_POST['drtotal'],2);
$crtotal = round($_POST['crtotal'],2);
$name = ucwords($_POST['pname']);
$pmode = $_POST['pmode'];
$chno = $_POST['chno'];
$remarks = ucwords($_POST['remarks']);
$date=date("Y-m-d",strtotime($_POST['date']));
$username=$_POST['cuser'];
$adate=date("Y-m-d");
$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$transactioncode' AND voucher = 'R' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$q = "select * from ac_financialpostings where trnum = '$transactioncode' AND type = 'RV' and  client='$client'";
$r = mysql_query($q,$conn);

while($qr = mysql_fetch_assoc($r))
{
  $coacode = $qr['coacode'];
		 $crdr = $qr['crdr'];
		 $date1 = $qr['date'];
		 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date1' and crdr = '$crdr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amt = $qhr1['amount'];
		 }
		 $amt = $amt - $qr['amount'];
 		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode' and date = '$date1' and crdr = '$crdr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
 }

$get_entriess1 = 
"DELETE FROM ac_financialpostings WHERE trnum = '$transactioncode' AND type = 'RV' and  client='$client'";
$get_entriess_res11 = mysql_query($get_entriess1,$conn) or die(mysql_error());


//To fill cash,bank,cashcode,bankcode,schdule
for($i = 0,$k = -1,$l = -1;$i<count($_POST['code']);$i++)
 if($_POST['code'][$i] != "")
   $entrycode[++$k] = $_POST['code'][$i];

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



for($i = 0;$i<count($_POST['code']);$i++)
{


if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $arraycode[$_POST['code'][$i]];
$crdr = $_POST['crdr'][$i];
$dramount = round($_POST['dramount'][$i],2);
$cramount = round($_POST['cramount'][$i],2);
$remarks = ucwords($_POST['remarks'][$i]);
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
$vno = $_POST['vno'];
if($vno == "") $vno = "0";

$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,empname,adate,vouchernumber,warehouse) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','R','A','$client','$username','$adate','$vno','$unit')"; 
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

$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,cash,bank,cashcode,bankcode,schedule,warehouse,empname,adate) VALUES ('$date','$crdr','$code','$amount','$transactioncode','RV','$client','$cash','$bank','$cashcode','$bankcode','$schedule','$unit','$username','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  
		  
	

}

}


    	  echo "<script type='text/javascript'>";
		  echo "document.location='dashboardsub.php?page=ac_rvoucher';";
		  echo "</script>";
		
?>

