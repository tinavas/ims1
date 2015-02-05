<?php
include "config.php";
$id=$_GET["id"];

//Updating the Stock
$i = 0;
$query1 = "SELECT code,quantity,unit,type FROM ims_stockadjustment WHERE trnum = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $qty = $rows1['quantity'];
 if($rows1['type'] == "Deduct")
  $query2 = "UPDATE ims_stock SET quantity = quantity + $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[unit]'"; 
 elseif($rows1['type'] == "Add")
  $query2 = "UPDATE ims_stock SET quantity = quantity - $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[unit]'"; 
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
}
//End of updating the Stock

$query1="delete from ims_stockadjustment where trnum = '$id'";
$result1=mysql_query($query1,$conn);

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'STA' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];
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


$query1="delete from ac_financialpostings where trnum = '$id' and type = 'STA'";
$result1=mysql_query($query1,$conn);

header('Location:dashboardsub.php?page=ims_stockadjust');
?>