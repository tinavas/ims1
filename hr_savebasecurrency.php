<?php
include "config.php";
$temp = explode('@',$_POST['bcurrency']);
$bcountry = $temp[0];
$bcurrency = $temp[1];
$ccountry = $_POST['ccountry'];
$ccurrency = $_POST['ccurrency'];

 $query="TRUNCATE TABLE bccurrency " or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 $query="INSERT INTO bccurrency (id,bcountry,bcurrency,ccountry,ccurrency) VALUES (NULL,'$bcountry','$bcurrency','$ccountry','$ccurrency')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=hr_basecurrency');
?>
