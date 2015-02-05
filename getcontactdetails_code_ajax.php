<?php 
include "config.php";
$code=$_POST['code']; 
$result = mysql_query("select name from contactdetails where code='$code'",$conn) or die(mysql_error());
echo mysql_num_rows($result);
?>
