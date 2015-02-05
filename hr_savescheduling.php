<?php
include "config.php";
if($_POST['saed'] == 1)
{
$id = $_POST['id'];
 $query = "DELETE FROM hr_scheduling WHERE id = '$id'";
 mysql_query($query,$conn) or die(mysql_error());
 }	
$date = date("Y-m-d",strtotime($_POST['date']));
$emp = $_POST['emp'];
$sdate = date("Y-m-d",strtotime($_POST['sdate']));
$subject = $_POST['subject'];
$task = $_POST['task'];
$fromname = $_SESSION['valid_user'];


$q = "insert into hr_scheduling(date,user,employee,scheduleddate,task,subject,client)
values('$date','$fromname','$emp','".$sdate."','".htmlentities($_POST['task'], ENT_QUOTES)."','".htmlentities($_POST['subject'], ENT_QUOTES)."','$client')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());

$query = "SELECT username FROM common_useraccess WHERE employeename = '$emp' and client = '$client'"; 
$result = mysql_query($query,$conn); 
while($rows = mysql_fetch_assoc($result))
{
$toname = $rows['username'];
}

$query="INSERT INTO common_messages (id,title,message,fromname,toname,date)
 VALUES (NULL,'".$_POST['subject']."','".$_POST['task']."','".$fromname."','".$toname."','".$date."')";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_scheduling'";
echo "</script>";

?>







