<?php 
include "config.php";
 $table = $_GET['name'];
$id = $_GET['id'];
$col = $_GET['col'];


  $get_entriess3 = "DELETE FROM ac_financialpostings WHERE trnum = '$_GET[formula]' AND date = '$_GET[date]' AND venname = '$_GET[warehouse]' AND (type = 'product produced' || type = 'item consumed')";     
 $get_entriess_res3 = mysql_query($get_entriess3,$conn) or die(mysql_error());
 
 
 
 $q3="select id from product_productionunit where $col = '$id'";
 
 $q3=mysql_query($q3) or die(mysql_error());
 
 $r3=mysql_fetch_assoc($q3);
 
 $ppid=$r3['id'];
 
 $q3="delete from product_itemwise where pid='$ppid'";
 
 $q3=mysql_query($q3) or die(mysql_error());



  $q = "delete from product_productionunit where $col = '$id'";
$qr = mysql_query($q,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=product_productionunit';";
echo "</script>";

?>