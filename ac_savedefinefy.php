<?php
include "config.php";

$fdatedump = $_POST['date2'];
$fdate = date("Y-m-j", strtotime($fdatedump));

$tdatedump = $_POST['date3'];
$tdate = date("Y-m-j", strtotime($tdatedump));

// $query="TRUNCATE TABLE ac_definefy " or die(mysql_error());
// $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());



 $query="INSERT INTO ac_definefy (id,fdate,tdate,fdatedump,tdatedump)
 VALUES (NULL,'".$fdate."','".$tdate."','".$fdatedump."','".$tdatedump."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=ac_definefy');
?>
