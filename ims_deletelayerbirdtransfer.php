<?php
include "config.php";
$client=$_SESSION['client'];
  $id = $_GET['id'];
 $q1 = "SELECT * FROM ims_stocktransfer WHERE tid='$id' AND client='$client'";
 $qr1 = mysql_query($q1,$conn);
 while($row1 = mysql_fetch_assoc($qr1))
 {
 $cnt11 = 0;
 $cnt12 = 0;
 $codec = $row1['code'];
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$row1[code]' AND warehouse = '$row1[fromwarehouse]' and client = '$client' ";
   $result3 = mysql_query($query3,$conn);
   $cnt11 = mysql_num_rows($result3);
   while($row3 = mysql_fetch_assoc($result3))
   {
     $stockqty = $row3['quantity'];
     $stockunit = $row3['unit'];
   } 
   if($stockunit <> "")
   {
       if($stockunit == $row1['fromunits'])
   {
      $stockqty = $stockqty + $row1['quantity'];    
   } 
   else
   {
      $stockqty = $stockqty + convertqty($row1['quantity'],$row1['fromunits'],$stockunit,1);
   }
   }
 
	if($cnt11 > 0)
  {
   $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$row1[code]' and warehouse = '$row1[fromwarehouse]' and client = '$client'";             
   $result51 = mysql_query($query51,$conn) ;

  }
   $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$row1[code]' AND warehouse = '$row1[towarehouse]' and client = '$client' ";
   $result3 = mysql_query($query3,$conn);
   $cnt12 = mysql_num_rows($result3);
   while($row3 = mysql_fetch_assoc($result3))
   {
     $stockqty = $row3['quantity'];
     $stockunit = $row3['unit'];
   }
   if($stockunit <> "")
   { 
   if($stockunit == $row1['tounits'])
   {
      $stockqty = $stockqty - $row1['quantity'];    
   } 
   else
   {
      $stockqty = $stockqty - convertqty($row1['quantity'],$row1['fromunits'],$stockunit,1);
   }
   }
   if($cnt12 > 0)
   {
   $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$row1[code]' and warehouse = '$row1[towarehouse]' and client = '$client'";             
   $result51 = mysql_query($query51,$conn);
   } 
  
  }

$q = "delete from ac_financialpostings where trnum = '$id' AND type ='TR' AND client='$client'";
$qr = mysql_query($q,$conn)or die(mysql_error()); ;

$q = "delete from ims_stocktransfer where tid = '$id' AND client='$client'";
$qr = mysql_query($q,$conn);

header('Location:dashboardsub.php?page=ims_layer_birdtransfer');
?>