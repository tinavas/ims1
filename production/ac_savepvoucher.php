<?php 
include "config.php";
//session_start();
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
$mode = $_POST['mode'];
$username=$_SESSION['valid_user'];
$voucher = 'P';
$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher'  and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['mid']; $tnum = $tnum + 1;	} 
$tno = $tnum;
$transactioncode = $tno;
$vouchernumber = $_POST['vno'];
$manual_trnum=$_POST['manual_tno'];
$bccodeno = $_POST['cno'];
$drtotal = $_POST['drtotal'];
$crtotal = $_POST['crtotal'];
$name = ucwords($_POST['pname']);
$pmode = $_POST['pmode'];
if($pmode == 'Cheque')
{
  $q = "SELECT * FROM ac_chequeseries WHERE acno = '$bccodeno'";
  $r = mysql_query($q,$conn);
  while($r1 = mysql_fetch_assoc($r))
  {
    $rchls = $r1['rchls'];
  }
  $rchls = $rchls - 1;
  $q2 = "UPDATE ac_chequeseries SET rchls = '$rchls' WHERE acno = '$bccodeno'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());

}
$allcodes = "";
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

$chno = $_POST['chno'];

$date=date("Y-m-d",strtotime($_POST['date']));

for($i = 0,$k = -1;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$remarks = $_POST['remarks'][$i];
$code = $_POST['code'][$i];
$desc = $arraycode[$_POST['code'][$i]];
$crdr = $_POST['drcr'][$i];
$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];
$empname1 = $_POST['emp'][$i];
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
if($_SESSION['db'] == "feedatives"  || $_SESSION['db'] == "alkhumasiyabrd"){
if($vouchernumber == "") $vouchernumber = 0;
 $q = "insert into ac_gl (username,mode,transactioncode,vouchernumber,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client) VALUES ('$username','$m','$transactioncode','$vouchernumber','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','P','A','$unit','$client')";
}

else if($_SESSION['db'] == "golden")
{
$q = "insert into ac_gl (username,mode,transactioncode,manual_trnum,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client) VALUES ('$username','$m','$transactioncode','$manual_trnum','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','P','A','$unit','$client')";}

else
{
 $q = "insert into ac_gl (username,mode,transactioncode,bccodeno,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,name,pmode,chequeno,date,status,voucher,vstatus,warehouse,client) VALUES ('$username','$m','$transactioncode','$bccodeno','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','$name','$pmode','$chno','$date','U','P','A','$unit','$client')";
}

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
}// echo $countcashentries;
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

if($_SESSION['db'] == "fortress"  && $warehouse != "")
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
		  
		 if($_SESSION['db'] == "fortress"  && $warehouse != "")
		  {
		  $war1= $warehouse;
		  }
		  else if($sectoremp == "")
		  {
		  $war1= $unit;
		  }
		  else
		  {
		   $war1= $sectoremp;
		   }
		  //////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code' and date = '$date' and crdr = '$crdr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$code','$amount','$crdr','$war1','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code'and date = '$date' and crdr = '$crdr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
}
}



/*
$q = "update ac_gl set vstatus = 'A' where transactioncode = '$transactioncode' AND voucher = 'P' and client='$client' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());*/

/* $q = "select * from ac_gl where transactioncode = '$transactioncode' AND voucher = 'P' and client='$client' ";
	    $qrs = mysql_query($q,$conn) or die(mysql_error());
	    while($qr = mysql_fetch_assoc($qrs))
		{
		 if ( $qr['crdr'] == "Cr" )
		 {
		   $amount = $qr['cramount'];
		 }
		 else
		 {
           $amount = $qr['dramount'];		 
		 }
		  $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client) VALUES ('$qr[date]','$qr[crdr]','$qr[code]','$amount','$transactioncode','PV','$client') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  }*/
		  echo "<script type='text/javascript'>";
		 echo "document.location = 'dashboardsub.php?page=ac_pvoucher';";
		  echo "</script>";
		
?>