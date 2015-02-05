<?php
include "config.php";
include "getemployee.php";
$tid = $_GET['tid'];
$id = $_GET['id'];

$q =  "select * from ims_intermediatereceipt WHERE riflag = 'R' and tid = '$tid'  ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$code= $qr['code']; $warehouse2 = $qr['warehouse'];
	$quantity  = $qr['quantity'];$rateperunit = $qr['$rateperunit'];
	$units = $qr['units'];
	 ///stock update/////////////
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' AND warehouse = '$warehouse2'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty1 = $row3['quantity'];
  	$stockunit1 = $row3['unit'];
  }

  if($stockunit1 == $units)
  {
      $stockqty1 = $stockqty1 - $quantity;    
  }
  else
  {
      $stockqty1 = $stockqty1 - convertqty($quantity,$units,$stockunit1,1);
  }

  $query51 = "UPDATE ims_stock SET quantity = '$stockqty1' WHERE itemcode = '$code' AND warehouse = '$warehouse2'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());






$q = "delete from ims_intermediatereceipt where tid = '$tid' and riflag = 'R'";
$qr = mysql_query($q,$conn);

$q1q = "select * from ac_financialpostings where trnum = '$tid' and type = 'IR' and itemcode = '$code' and client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];

$get_entriess = "DELETE FROM ac_financialpostings WHERE  trnum = '$tid' and type = 'IR' and coacode = '$coacode' and client = '$client' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


		

}
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_intermediatereceipt'";
echo "</script>";
?>