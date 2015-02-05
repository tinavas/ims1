<?php 
include "config.php";
$voucher = 'J';
$mode = $_POST['mode'];
$transactioncode = $_POST['tno'];


$q = "update ac_gl set vstatus = 'A' where transactioncode = '$transactioncode' AND voucher = '$voucher'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

  $q = "select * from ac_gl where transactioncode = '$transactioncode' AND voucher = '$voucher'";
	    $qrs = mysql_query($q,$conn) or die(mysql_error());
	    while($qr = mysql_fetch_assoc($qrs))
	   {
	     if ( $qr['crdr'] == "Cr" )
		 {
		   $amount = $qr['cramount'];
		 }
		 else
		 {
           $amount = $qr['dramount'];		 
		 }
	      $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type) VALUES ('$qr[date]','$qr[crdr]','$qr[code]','$amount','$transactioncode','Journal') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	   
	   }


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_jvoucher';";
echo "</script>";



?>
