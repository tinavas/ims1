<?php 
include "config.php";

$mode = $_POST['mode'];
$voucher = $_POST['voucher'];
$transactioncode = $_POST['tno'];
$type = $_POST['ttype'];

$q = "update ac_gl set vstatus = 'A' where transactioncode = '$transactioncode' AND voucher = '$voucher' ";
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
		 if ( $type == "Payment")
		 {
		  $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type) VALUES ('$qr[date]','$qr[crdr]','$qr[code]','$amount','$transactioncode','PV') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
		 else
		 {
		  $q1 = "insert into ac_financialpostings(date,crdr,coacode,amount,trnum,type) VALUES ('$qr[date]','$qr[crdr]','$qr[code]','$amount','$transactioncode','RV') ";
          $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
	     
	   
	   }


echo "<script type='text/javascript'>";
if ( $type == "Payment") {
echo "document.location = 'dashboardsub.php?page=ac_pvoucher';";
}
else 
{
echo "document.location = 'dashboardsub.php?page=ac_rvoucher';";
}
echo "</script>";



?>