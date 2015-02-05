 <?php 
include "config.php";
$id = $_GET['id'];
$gquery = "select * from pp_goodsreceipt where gr = '$id'";

$gresult = mysql_query($gquery,$conn) or die(mysql_error());
while($gres = mysql_fetch_assoc($gresult))
{
$warehouse = $gres['warehouse'];

$query = "SELECT * FROM ims_stock WHERE itemcode = '$gres[code]' and warehouse = '$warehouse'";
$result2 = mysql_query($query,$conn) or die(mysql_error());
$res2=mysql_fetch_assoc($result2);

$updatedqty = ($res2['quantity'] - $gres['receivedquantity']);

$query = "update ims_stock set quantity = '$updatedqty' where itemcode = '$gres[code]' and warehouse = '$warehouse'";
$result = mysql_query($query,$conn) or die(mysql_error());


$q1 = "update pp_gateentry set grflag = '0' WHERE ge = '$gres[ge]' and combinedpo = '$gres[po]' and code = '$gres[code]'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());



$q1q = "select * from ac_financialpostings where trnum = '$gres[gr]' and type = 'GR' and itemcode = '$gres[code]' and warehouse = '$warehouse'";
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




$query = "delete from ac_financialpostings where trnum = '$gres[gr]' and type = 'GR' and itemcode = '$gres[code]' and warehouse = '$warehouse'";
$result = mysql_query($query,$conn) or die(mysql_error());

}
$query = "delete from ac_financialpostings where trnum = '$id' and type = 'GR'";
$result = mysql_query($query,$conn) or die(mysql_error());

$query = "delete from pp_goodsreceipt where gr = '$id'";
$result = mysql_query($query,$conn);

header('Location:dashboardsub.php?page=pp_goodsreceipt_a');

?>