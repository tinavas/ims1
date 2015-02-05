<?php
 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);
 

 session_start();

 $db = $_SESSION['db'];
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "tulA0#s!";

 $db_name = $db;



$client = $_SESSION['client'];

 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);
$datephp = $_SESSION['datephp'];
$datejava = $_SESSION['datejava'];
 $empname = $_SESSION['valid_user'];

 mysql_query("SET @user='$empname'") or die(mysql_error());
 
 
 set_time_limit(0);
 ini_set("memory_limit","-1");
 

 ?>