<?php
 include "mainconfig.php";
 $country = $_POST['country'];
 $db = $_SESSION['db'];
  $query = "UPDATE tbl_users SET country = '$country' WHERE dbase = '$db'";
  mysql_query($query,$conn) or die(mysql_error());
  header("Location:dashboardsub.php?page=home_country&status=1");
?>  