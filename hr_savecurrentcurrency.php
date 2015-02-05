<?php
include "config.php";
$bcountry = $_POST['bcountry'];
$bcurrency = $_POST['bcurrency'];
$temp = explode('@',$_POST['ccurrency']);
$ccurrency = $temp[1];
$ccountry = $temp[0];

 $query="TRUNCATE TABLE bccurrency " or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 $query="INSERT INTO bccurrency (id,bcountry,bcurrency,ccountry,ccurrency) VALUES (NULL,'$bcountry','$bcurrency','$ccountry','$ccurrency')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=hr_currentcurrency');
?>
