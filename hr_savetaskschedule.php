<?php
include "config.php";
$id = $_POST['id'];
$compdate = date("Y-m-d",strtotime($_POST['compdate']));
$remarks = $_POST['remarks'];
$emp = $_POST['emp'];
$task = $_POST['task'];
$remarks = $_POST['remarks'];
$q = "update hr_scheduling set completeddate = '$compdate',narration = '$remarks' ,flag = '1' where id = '$id' and client = '$client'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$fromname = $_SESSION['valid_user'];
 
$tit = "Re".":".$_POST['title'];
$query="INSERT INTO common_messages (id,title,message,fromname,toname,date)
 VALUES (NULL,'$tit','".$_POST['remarks']."','".$fromname."','".$emp."','".$compdate."')";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_taskschedule'";
echo "</script>";

?>







