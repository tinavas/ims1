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
"DELETE FROM ac_gl WHERE transactioncode = '$transactioncode' AND voucher = 'P' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


$get_entriess1 = 
"DELETE FROM ac_financialpostings WHERE trnum = '$transactioncode' AND type = 'PV' and  client='$client'";
$get_entriess_res11 = mysql_query($get_entriess1,$conn) or die(mysql_error());


//To fill cash,bank,cashcode,bankcode,schdule
for($i = 0,$k = -1,$l = -1;$i<count($_POST['code']);$i++)
 if($_POST['code'][$i] != "")
    $entrycode[++$k] = $_POST['code'][$i];

$c = $b = $n = $o = -1;	//$c means cash index and $b means bank index
$ce = $be = $countcashentries = $countbankentries = 0;	//$ce means cash entry and $be means bank entry
$q = "SELECT code,controltype FROM ac_coa WHERE (controltype = 'Cash' OR controltype LIKE '%Bank%') AND client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($rr = mysql_fetch_assoc($r))
{ 
 if($rr['controltype'] == 'Cash')
 { 
  $cashcodearray[++$c] = $rr['code'];
  if(in_array($rr['code'],$entrycode))
  { $ce = 1; $countcashentries++; $cashentriesarray[++$o] = $rr['code']; $creditcashcode = $rr['code']; }	// It means one cash entry record is there   
 }
 elseif( strlen(strstr($rr['controltype'],"Bank")) > 0)  
 {
  $bankcodearray[++$b] = $rr['code'];
  if(in_array($rr['code'],$entrycode))
  { $be = 1; $countbankentries++; $bankentriesarray[++$n] = $rr['code']; $creditbankcode = $rr['code'];}	// It means one bank entry record is there   
 } 
}
//End

if($_SESSION['db'] == "fortress")
{
 $q = "SELECT * FROM ac_bankcashcodes WHERE code = '$bccodeno'";
  $r = mysql_query($q,$conn);
  while($r1 = mysql_fetch_assoc($r))
  {
    $warehouse = $r1['sector'];
  }
}


for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['crdr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];
$empname1 = $_POST['emp'][$i];
$remarks = ucwords($_POST['remarks'][$i]);
$sectoremp = "";$empname ="";
if($empname1 != "")
{
$emparr = explode("@",$empname1);
$empname = $emparr[0];
$sectoremp = $emparr[1];
}
else
{
$empname = "";
} 
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
	if($controltype != ""  && $m == "")
	{
	$m = $controltype;
	}
}
$vno = $_POST['vno'];
if($vno == "") $vno = "0";
if($_SESSION['db'] == "feedatives" || $_SESSION['db'] == "alkhumasiyabrd")
$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,warehouse,vouchernumber) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','P','A','$client','$unit','$vno')";
else
$q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,client,warehouse) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','P','A','$client','$unit')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set tflag = '1' where code = '$code' ";
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
   $bankcode = $creditbankcode;
  }
 }
 elseif(in_array($code,$bankcodearray))
 {
  $bank = 'NO';
  if($ce == 1)
  {
   $cash = 'YES';
   $cashcode = $creditcashcode;
  }
 }
 else
 {
  if($ce == 1) { $cash = 'YES'; $cashcode = $creditcashcode; }
  if($be == 1) { $bank = 'YES'; $bankcode = $creditbankcode; }
 } 

if($countbankentries == 2)	//If the transaction is made between two banks, it is used
{
 if($code == $bankentriesarray[0])
 { $bank = 'YES'; $bankcode = $bankentriesarray[1]; }
 elseif($code == $bankentriesarray[1])
 { $bank = 'YES'; $bankcode = $bankentriesarray[0]; }
} //echo $countcashentries;
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
 $q = "SELECT schedule FROM ac_coa WHERE code = '$code' AND client = '$client'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];
}
//End

if($_SESSION['db'] == "fortress" && $warehouse != "")
{
$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule) VALUES ('$date','$crdr','$code','$amount','$transactioncode','PV','$client','$warehouse','$empname','$cash','$bank','$cashcode','$bankcode','$schedule') ";
}
else if($sectoremp == "")
{
$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule) VALUES ('$date','$crdr','$code','$amount','$transactioncode','PV','$client','$unit','$empname','$cash','$bank','$cashcode','$bankcode','$schedule') ";
}
else
{
$q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,venname,cash,bank,cashcode,bankcode,schedule) VALUES ('$date','$crdr','$code','$amount','$transactioncode','PV','$client','$sectoremp','$empname','$cash','$bank','$cashcode','$bankcode','$schedule') ";
}
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  
		 
}
}

    	  echo "<script type='text/javascript'>";
		  echo "document.location = 'dashboardsub.php?page=ac_pvoucher_a';";
		  echo "</script>";
		
?>

