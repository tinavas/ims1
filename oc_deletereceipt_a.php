 <?php 
include "config.php";

$q = "delete from oc_receipt where tid = '$_GET[id]'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$q1q = "select * from ac_financialpostings where trnum = '$_GET[id]' and type = 'RCT' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];

$q = "delete from ac_financialpostings where trnum = '$_GET[id]' and coacode = '$coacode' and type = 'RCT' and client = '$client'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date12' and crdr = '$crdr' and client = '$client'";
		$res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		$amountnew = $qhr1['amount'];
		 }
	  $amt = $amountnew - $amount123;
 		$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$date12' and crdr = '$crdr' and client = '$client'";
		$r1 = mysql_query($q1,$conn) or die(mysql_error());
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_receipt_a'";
echo "</script>";

?>