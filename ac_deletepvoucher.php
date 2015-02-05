<?php 
include "config.php";
$voucher = 'P';
$tno = $_GET['id'];

$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$tno' AND voucher = '$voucher' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_pvoucher';";
echo "</script>";


?>