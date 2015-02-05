<?php
include "config.php";
$id=$_GET['id'];
$client=$_SESSION['client'];
$q = "delete from ingr_nutrientstandards where id = '$id' AND client='$client'";
$qr = mysql_query($q,$conn);
header('Location:dashboardsub.php?page=ims_nutrientstandards');
?>