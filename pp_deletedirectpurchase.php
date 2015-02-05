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

$q1q = "delete from ac_financialpostings where trnum = '$id' and type = 'SOBI' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";
	echo "document.location = 'dashboardsub.php?page=pp_directpurchase';";
echo "</script>";
?>


