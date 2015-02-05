<?php
 include "mainconfig.php";
 $currency = $_POST['currency'];
 $db = $_SESSION['db'];

if($_POST['millionformat'])
  $format=1;
else
  $format=0;
  
  $query = "UPDATE tbl_users SET currency = '$currency',millionformate = '$format' WHERE dbase = '$db'";
  mysql_query($query,$conn) or die(mysql_error());
  header("Location:dashboardsub.php?page=home_currency&status=1");
?>  