<?php
include "config.php";

$invoice = $_GET['invoice'];
 
 
  $query2 = "SELECT ps FROM oc_cobi WHERE invoice = '$invoice' LIMIT 1";
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 $ps1 = $rows2['ps'];
 }

 $query = "SELECT itemcode,quantity,ordermode,packets,so FROM oc_packslip WHERE ps='$ps1' ORDER BY itemcode";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {

  if($rows['ordermode'] == "Packets")
 {
  $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[packets] WHERE code = '$rows[itemcode]' AND po='$so'";
 }
 else 
 {
 $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[quantity] WHERE code = '$rows[itemcode]' AND po='$so'";
 }
    mysql_query($query1,$conn) or die(mysql_error());
 }
$q = "update oc_packslip set cobiflag = '0' where ps = '$ps1'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
 $query = "DELETE FROM oc_cobi WHERE invoice = '$invoice'";
mysql_query($query,$conn) or die(mysql_error());
 $query = "DELETE FROM ac_financialpostings WHERE trnum = '$invoice' AND type = 'COBI'";
mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_cobi'";
echo "</script>";

?>