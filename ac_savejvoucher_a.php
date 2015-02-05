<?php 
include "config.php";
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
$username=$_SESSION['valid_user'];
$voucher = 'J';
$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher'  and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['mid']; $tnum = $tnum + 1;	} 
$tno = $tnum;

 $vouchernumber = $_POST['vno'];
$date=date("Y-m-d",strtotime($_POST['date']));
if($_POST['saed']=="1")
{
	$tno=$_POST['tno'];
	$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$tno' AND voucher = '$voucher' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

}
for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
if($_POST['saed']=="1")
{
$crdr=$_POST['crdr'][$i];
}
else
{
$crdr = $_POST['drcr'][$i];
}
$remarks = $_POST['remarks'][$i];
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];

$dramount = $_POST['dramount'][$i];
$cramount = $_POST['cramount'][$i];



 if ( $crdr == "Cr" )
		 {
		   $amount = $cramount;
		 }
		 else
		 {
           $amount = $dramount;		 
		 }



$crtotal = $_POST['crtotal'];
$drtotal = $_POST['drtotal'];

$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
}
//To fill cash,bank,cashcode,bankcode,schdule
$cash = $bank = 'NO';
$cashcode = $bankcode = "";
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
/*
if($cash == 'YES' or $bank == 'YES')
{
 $q = "SELECT schedule FROM ac_coa WHERE code = '$code' AND client = '$client'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];
}*/
//End
$vno = $_POST['vno'];
if($_SESSION['db'] == "feedatives"){
 $q = "insert into ac_gl (username,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,vouchernumber,mode,bccodeno,date,client,warehouse) VALUES ('$username','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','U','$tno','$vouchernumber','Journal','0','$date','$client','$unit')";
 } else {
 $q = "insert into ac_gl (username,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,client,warehouse,cash,bank,cashcode,bankcode) VALUES ('$username','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','U','$tno','Journal','0','$date','$client','$unit','$cash','$bank','$cashcode','$bankcode')";
 }
 
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ac_jvoucher_a';";
echo "</script>";

?>