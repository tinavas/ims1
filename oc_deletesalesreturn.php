<?php
include "config.php";
$trid = $_GET['id'];

//Updating the Stock
$q = "SELECT t1.code,t1.quantity,t1.type,t2.warehouse FROM oc_salesreturn t1,oc_cobi t2 WHERE t1.trid = '$trid' AND t1.cobi = t2.invoice AND t1.client = '$client' AND t2.client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($r);
$qty = $rows['quantity'];
$code = $rows['code'];
$warehouse = $rows['warehouse'];
$type = $rows['type'];
if($type == "addtostock")
{
 $q2 = "UPDATE ims_stock SET quantity = quantity - $qty WHERE itemcode = '$code' AND warehouse = '$warehouse'";
 $r2 = mysql_query($q2,$conn) or die(mysql_error());
}
//End of updating the Stock

$query = "delete from oc_salesreturn where trid = '$trid'";
$result = mysql_query($query,$conn) or die(mysql_error());


$query2 = "delete from ac_financialpostings where trnum = '$trid' and type = 'SR'";
$result2 = mysql_query($query2,$conn);

header("location:dashboardsub.php?page=oc_salesreturn");
?>