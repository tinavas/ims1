<?php
include "config.php";
$client = $_SESSION['client'];
$i = 0;
$query="select a.id as id,b.party as party,a.venname as ven,a.trnum as trnum from ac_financialpostings a, oc_cobi b WHERE a.trnum = b.invoice
AND a.venname != b.party AND a.itemcode = 'BROB101'";
 $result = mysql_query($query,$conn); 
 while($row1 = mysql_fetch_assoc($result))
 {
 //echo "id ".$row1['id']. "ven ".$row1['ven']."trnum ".$row1['trnum']."party ".$row1['party'];
  $query51 = "UPDATE ac_financialpostings SET venname = '$row1[party]' WHERE  id = '$row1[id]'";
 $result51 = mysql_query($query51,$conn) or die(mysql_error());
 ++$i;
// echo "<br>";
 }
echo $i . " rows effected.";echo "<br>";
echo "success"; 
echo "<script type='text/javascript'>";
//echo "document.location = 'dashboardsub.php?page=farmregdisplay';"; 
echo "</script>";
?>
