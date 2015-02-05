<?php
include "config.php";
$id = $_GET['id'];

   $q = "delete from ac_financialpostings where trnum = '$_GET[id]' AND type ='TR' AND date='$_GET[date]' AND client='$client'";
   $qr = mysql_query($q,$conn) or die(mysql_error());

  $q = "delete from ims_stocktransfer where id = '$id' AND client='$client'";
  $qr = mysql_query($q,$conn) or die(mysql_error());

  header('Location:dashboardsub.php?page=ims_stocktransferrental');
?>