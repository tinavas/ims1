<?php
include "config.php";
session_start();
$time=date("H:i:s");
$sql=mysql_query("select time(now()) as currenttime;");
 $q=mysql_fetch_array($sql);
 $time=$q['currenttime'];
$q1=mysql_query("update logdetails set sessionendtime='$time' where sessionid='$_SESSION[sessionid]'") ;
?>