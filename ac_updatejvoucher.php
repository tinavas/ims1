<?php 
include "config.php";
$client = $_SESSION['client'];
$voucher = 'J';
$tno = $_POST['tno'];
$unit = $_POST['unitc'];
$username=$_POST['cuser'];
$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$tno' AND voucher = '$voucher' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


$q = "select * from ac_financialpostings where trnum = '$tno' AND type = 'JV' and  client='$client'";
$r = mysql_query($q,$conn);

while($qr = mysql_fetch_assoc($r))
{
  $coacode = $qr['coacode'];
		 $crdr = $qr['crdr'];
		 $date1 = $qr['date'];
		 
	
 }

$get_entriess1 = 
"DELETE FROM ac_financialpostings WHERE trnum = '$tno' AND type = 'JV' and  client='$client'";
$get_entriess_res11 = mysql_query($get_entriess1,$conn) or die(mysql_error());

$date=date("Y-m-d",strtotime($_POST['date']));
$crtotal = round($_POST['crtotal'],2);
$drtotal = round($_POST['drtotal'],2);
$adate=date("Y-m-d");

$vouchernumber=$_POST['vno'];
for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['code'][$i] != "")
{
$code = $_POST['code'][$i];
$desc = $_POST['desc'][$i];
$crdr = $_POST['crdr'][$i];
$dramount = round($_POST['dramount'][$i],2);
$cramount = round($_POST['cramount'][$i],2);
$remarks = $_POST['remarks'][$i];


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
}

$q = "insert into ac_gl (username,code,description,type,controltype,schedule,crdr,cramount,dramount,rremarks,crtotal,drtotal,voucher,vstatus,transactioncode,mode,bccodeno,date,vouchernumber,client,empname,adate,warehouse) VALUES ('$username','$code','$desc','$type','$controltype','$schedule','$crdr','$cramount','$dramount','$remarks','$crtotal','$drtotal','J','A','$tno','Journal','0','$date','$vouchernumber','$client','$username','$adate','$unit')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$q = "update ac_coa set flag = '1' where code = '$code' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());

 $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type,client,warehouse,empname,adate) VALUES ('$date','$crdr','$code','$amount','$tno','JV','$client','$unit','$username','$adate') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		  
	
}
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_jvoucher';";
echo "</script>";

?>