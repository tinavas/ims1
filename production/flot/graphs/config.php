<?php
 
 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

 session_start();

 $db = $_SESSION['db'];
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "4(vQLs+#-b";

 $db_name = $db;


 $conn1=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 ?>