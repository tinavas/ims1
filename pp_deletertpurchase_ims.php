<?php
include "config.php";
$id=$_GET['id'];

//Updating the Stock
$i = 0;
$query1 = "SELECT code,receivedquantity,warehouse FROM pp_sobi WHERE so = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $qty = $rows1['receivedquantity'];
 $query2 = "UPDATE ims_stock SET quantity = quantity - $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 
$result2 = mysql_query($query2,$conn) or die(mysql_error());
}
//End of updating the Stock


$get_entriess = "DELETE FROM pp_sobi WHERE so = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'SOBI' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and coacode = '$coacode' and type = 'SOBI' and client = '$client'";
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



 
 $query = "select choice,amountpaid,posobi,tid from pp_payment where posobi = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{

  $pmttid=$rows['tid'];
 
  $sobi = $rows['posobi'];
  $amountpaid = $rows['amountpaid'];
 
  $pmttid=$rows['tid'];
  $q2 = "update pp_sobi set balance = balance + $amountpaid where so = '$id'";
  $r2 = mysql_query($q2,$conn) or die(mysql_error());
 }

$get_entriess = "DELETE FROM pp_payment WHERE posobi ='$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$pmttid' and type = 'PMT'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_rtpurchase';";
echo "</script>";
?>


