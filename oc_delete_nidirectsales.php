<?php

include "config.php";

$id=$_GET['id'];



//Updating the Stock

$i = 0;

//$query1 = "SELECT code,total,warehouse FROM oc_cobi WHERE invoice = '$id'";
//
//$result1 = mysql_query($query1,$conn) or die(mysql_error());
//
//while($rows1 = mysql_fetch_assoc($result1))
//
//{
//
// $qty = $rows1['total'];

 //$query2 = "UPDATE ims_stock SET quantity = quantity + $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 
//
// $result2 = mysql_query($query2,$conn) or die(mysql_error());

//}

//End of updating the Stock

$get_entriess = "DELETE FROM oc_cobi WHERE invoice = '$id'";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'COBI' and  client='$client'";

$r1q = mysql_query($q1q,$conn) or die(mysql_error());

while($qr = mysql_fetch_assoc($r1q))

{

$amount123 = $qr['amount'];

 $date12 = $qr['date'];

 $coacode = $qr['coacode'];

 $crdr = $qr['crdr'];

$warehouse = $qr['warehouse'];



$q1 = "update ac_financialpostingssummary set amount = amount - $amount123 where coacode = '$coacode'and date = '$date12' and crdr = '$crdr' AND warehouse = '$warehouse'";

$r1 = mysql_query($q1,$conn) or die(mysql_error());

}



$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'COBI' ";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";

 echo "document.location = 'dashboardsub.php?page=oc_noninv_directsales';";

echo "</script>";

?>





