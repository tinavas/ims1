<?php
include "config.php";

session_start();
$fromname = $_SESSION['valid_user'];
$date = date("d.m.y"); 
$date = date("Y-m-j",strtotime($date));


 $query="INSERT INTO common_messages (id,title,message,fromname,toname,date)
 VALUES (NULL,'".$_POST['title']."','".$_POST['message']."','".$fromname."','".$_POST['toname']."','".$date."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=common_messages&id=fromname');
?>
