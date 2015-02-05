<?php 
include "config.php";
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
 $mode = $_POST['mode'];
$transactioncode = $_POST['tno'];
$bccodeno = $_POST['cno'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$name = ucwords($_POST['pname']);
$pmode = $_POST['pmode'];
$chno = $_POST['chno'];
$remarks = ucwords($_POST['remarks']);
$date=date("Y-m-d",strtotime($_POST['date']));
$username=$_SESSION['valid_user'];
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



for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['crdr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];
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
if($_SESSION['db'] == "feedatives" || $_SESSION['db'] == "alkhumasiyabrd")
$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,vouchernumber) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','R','A','$client','$vno')";
else
$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','R','A','$client')";
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

$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,cash,bank,cashcode,bankcode,schedule,warehouse) VALUES ('$date','$crdr','$code','$amount','$transactioncode','RV','$client','$cash','$bank','$cashcode','$bankcode','$schedule','$unit') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  
		  
		   $newamount = $amount + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$code' and date = '$date' and crdr = '$crdr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code','$amount','$crdr','$unit','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code','$amount','$crdr','$unit','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}


}

}


    	  echo "<script type='text/javascript'>";
		  echo "document.location='dashboardsub.php?page=ac_rvoucher_a';";
		  echo "</script>";
		
?>

