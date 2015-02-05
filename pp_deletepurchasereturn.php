<?php
include "config.php";
$trid = $_GET['id'];
$query = "delete from pp_purchasereturn where trid = '$trid'";
$result = mysql_query($query,$conn) or die(mysql_error());



$q1q = "select * from ac_financialpostings where trnum = '$trid' and type = 'PPRTN' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];

$query2 = "delete from ac_financialpostings where trnum = '$trid' and coacode = '$coacode' and type = 'PPRTN' and client = '$client'";
$result2 = mysql_query($query2,$conn);


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



$query = "select returnquantity,code,warehouse from pp_purchasereturn where trid = '$trid'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$quantity = $rows['returnquantity'];
$code  = $rows['code'];
$warehouse = $rows['warehouse'];

$query2 = "UPDATE ims_stock SET quantity = quantity + $quantity WHERE itemcode = '$code' AND warehouse = '$warehouse'"; 
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
}

header("location:dashboardsub.php?page=pp_purchasereturn");
?>