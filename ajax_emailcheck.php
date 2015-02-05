<?php 
include "mainconfig.php";
$email=$_POST[email];
echo mysql_num_rows(mysql_query("select email from tbl_users where email='$email'"));
?>
