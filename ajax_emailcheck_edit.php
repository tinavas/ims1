<?php 
include "mainconfig.php";
$email=explode('##',$_POST[email]);
if($email[0]==$email[1])
echo '0';
else
echo mysql_num_rows(mysql_query("select email from tbl_users where email='$email[0]' and email <> '$email[1]' "));
?>
