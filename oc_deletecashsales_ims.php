<?php

include "config.php";

$id=$_GET['id'];



//Updating the Stock

$i = 0;

$query1 = "SELECT code,quantity,warehouse FROM oc_cobi WHERE invoice = '$id'";

$result1 = mysql_query($query1,$conn) or die(mysql_error());

while($rows1 = mysql_fetch_assoc($result1))

{

 $qty = $rows1['quantity'];

 $query2 = "UPDATE ims_stock SET quantity = quantity + $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 

 $result2 = mysql_query($query2,$conn) or die(mysql_error());

}



$query = "select tid FROM oc_receipt WHERE socobi = '$id' and client = '$client'";

$result = mysql_query($query,$conn) or die(mysql_error());

$rows=mysql_fetch_assoc($result);



$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$rows[tid]' and type = 'RCT' ";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$get_entriess = "DELETE FROM oc_cobi WHERE invoice = '$id'";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'COBI' ";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$get_entriess = "DELETE FROM oc_receipt WHERE socobi = '$id' and client = '$client'";

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";

 echo "document.location = 'dashboardsub.php?page=oc_cashsales_ims';";

echo "</script>";

?>





