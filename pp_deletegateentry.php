<?php
include "config.php";
//$id=$_GET['id'];
$ge = $_GET['id'];
echo $ge;
$query = "select combinedpo,code,warehouse,receivedquantity from pp_gateentry where ge = '$ge'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{

$po = $res['combinedpo'];
$itemcode = $res['code'];
$warehouse = $res['warehouse'];

$q1 = "UPDATE pp_purchaseorder SET geflag = '0',receivedquantity = receivedquantity - $res[receivedquantity],acceptedquantity = acceptedquantity - $res[receivedquantity] WHERE po = '$po' AND code = '$itemcode' and deliverylocation = '$warehouse'";

  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
}

  
  $query = "delete from pp_gateentry where ge = '$ge'";
  $result = mysql_query($query,$conn) or die(mysql_error());
    
  header('Location:dashboardsub.php?page=pp_gateentry');
?>