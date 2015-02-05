<?php

session_start();
include "config.php";
$sql=mysql_query("select time(now()) as currenttime;");
 $q=mysql_fetch_array($sql);
 $time=$q['currenttime'];
//$time=date("H:i:s");
$q1=mysql_query("update logdetails set sessionendtime='$time' where sessionid='$_SESSION[sessionid]'") ;


 unset($_SESSION['valid_user']);

 unset($_SESSION['db']);

session_destroy();
session_unset();

header('Location:loggedout.php');

?>