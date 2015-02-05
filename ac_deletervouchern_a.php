<?php 
include "config.php";
$client = $_SESSION['client'];
$voucher = 'R';
$tno = $_GET['id'];

$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$tno' AND voucher = '$voucher' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "select * from ac_financialpostings where trnum = '$tno' AND type = 'RV' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];



$get_entriess1 = 
"DELETE FROM ac_financialpostings WHERE trnum = '$tno' AND type = 'RV' and  client='$client'";
$get_entriess_res11 = mysql_query($get_entriess1,$conn) or die(mysql_error());

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
echo "document.location = 'dashboardsub.php?page=ac_rvoucher_a';";
echo "</script>";


?>