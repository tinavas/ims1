<?php 
include "config.php";
$client = $_SESSION['client'];
$unit = $_POST['unitc'];
$username=$_SESSION['valid_user'];
$voucher = 'J';

	
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
$tno = "JV-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tno="JV-1";

}



$adate=date("Y-m-d");

 $vouchernumber = $_POST['vno'];
$date=date("Y-m-d",strtotime($_POST['date']));
for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$remarks = $_POST['remarks'][$i];
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
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



$crtotal =round($_POST['crtotal'],2);
$drtotal =round($_POST['drtotal'],2);

$q = "select * from ac_coa where code = '$code'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$type = $qr['type'];
	$controltype = $qr['controltype'];
	$schedule = $qr['schedule'];
}

  $q = "insert into ac_gl (username,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,vouchernumber,client,empname,adate,warehouse) VALUES ('$username','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','A','$tno','Journal','0','$date','$vouchernumber','$client','$empname','$adate','$unit')";

 
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

 $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,empname,adate) VALUES ('$date','$crdr','$code','$amount','$tno','JV','$client','$unit','$empname','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		

}
}



echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ac_jvoucher';";
echo "</script>";

?>