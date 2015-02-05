<?php
include "config.php";
$id = $_GET['id'];

  $q = "delete from ims_stockreceive where id = '$id' AND client='$client'";
  $qr = mysql_query($q,$conn) or die(mysql_error());
  
  
  
     $q = "delete from ac_financialpostings where trnum = '$_GET[tid]'  AND type ='SR' AND date='$_GET[date]' AND client='$client'";
   $qr = mysql_query($q,$conn) or die(mysql_error());

$q2=mysql_query("update ims_stocktransfer set flag='0' where tid='$_GET[str]'");

   header('Location:dashboardsub.php?page=ims_stockreceive');
?>