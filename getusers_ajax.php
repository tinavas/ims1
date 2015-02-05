<?php 
include "mainconfig.php";
$username=$_POST[username];
echo mysql_num_rows(mysql_query("select username from tbl_users where username='$username'"));
?>
