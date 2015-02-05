<?php 
include "config.php";
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
$voucher = 'J';
$q = "select max(transactioncode) as mid from ac_gl WHERE voucher = '$voucher'  and client = '$client' "; $qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) { $tnum = $qr['mid']; $tnum = $tnum + 1;	} 
$tno = $tnum;

 $vouchernumber = $_POST['vno'];
$date=date("Y-m-d",strtotime($_POST['date']));
if($_POST['saed'] == "1")
{
$query = "DELETE FROM ac_gl WHERE transactioncode = '$tno' and voucher = 'J'";
mysql_query($query,$conn) or die(mysql_error());
}

for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$remarks = $_POST['remarks'][$i];
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
if($_POST['saed'] == 1)
 $crdr = $_POST['crdr'][$i];
else
 $crdr = $_POST['drcr'][$i];
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
  $q = "insert into ac_gl (code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,client,costcenter,warehouse) VALUES ('$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','U','$tno','Journal','0','$date','$client','$unit','$unit')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

}
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ac_jvoucher';";
echo "</script>";

?>