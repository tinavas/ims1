<?php
include "config.php";
$id=$_GET['id'];

if($_SESSION['db'] == "central")
 $query = "select choice,amountpaid,posobi,orgamount from pp_payment where tid = '$id'";
else
 $query = "select choice,amountpaid,posobi from pp_payment where tid = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $choice = $rows['choice'];
 if($choice == 'SOBIs')
 {
  $sobi = $rows['posobi'];
  $amountpaid = $rows['amountpaid'];
  $orgamount = $rows['orgamount'];
  if($_SESSION['db'] == "central")
   $q2 = "update pp_sobi set balance = balance + ($orgamount * camount) where so = '$sobi'";
  else
   $q2 = "update pp_sobi set balance = balance + $amountpaid where so = '$sobi'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());
 }
}

$get_entriess = "DELETE FROM pp_payment WHERE tid = $_GET[id]";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'PMT' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = $_GET[id] and type = 'PMT'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date12' and crdr = '$crdr'";
		$res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		$amountnew = $qhr1['amount'];
		 }
	
		 $amt = $amountnew - $amount123;
		   
		$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$date12' and crdr = '$crdr'";
		$r1 = mysql_query($q1,$conn) or die(mysql_error());
		

}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_payment';";
echo "</script>";
?>

