<?php
  session_start();
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "tulA0#s!";

 $db_name = "users";

 $client = $_SESSION['client'];

 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);

 ?>