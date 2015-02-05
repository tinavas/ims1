<?php
include "config.php";
$id = $_POST['id'];
$chls = $_POST['chls'];
$schls = $_POST['schls'];
$rchls = $_POST['chls'];
$echls = $_POST['echls'];

 $query="UPDATE ac_chequeseries SET chls = '$chls', schls = '$schls', start = '$schls', rchls = '$chls',echls = '$echls' WHERE id = '$id'" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=ac_chequeseries');
 
?>
