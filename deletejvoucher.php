<?php 
include "config.php";
$client = $_SESSION['client'];
$voucher = 'J';
$tno = $_GET['id'];

$get_entriess = 
"DELETE FROM ac_gl WHERE transactioncode = '$tno' AND voucher = '$voucher' and  client='$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_jvoucher';";
echo "</script>";


?>