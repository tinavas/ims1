<?php 
include "config.php";

$id = $_GET['id'];

  $q = "delete from bagcapacity where id = '$id' AND client = '$client'";
  $qr = mysql_query($q,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=common_bagcapacity');
?>