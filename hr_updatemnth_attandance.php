<?php
include "config.php";
$id = $_POST['rid'];
$date1 = date("d.m.o"); 
$date1 = date("Y-m-j",strtotime($date1));
$days=0;
$ext=0;
$leav=0;
$days = $_POST['days'];
$ext = $_POST['extra'];
$leav=$_POST['leave'];
$pleav=$_POST['pleave'];
if($days=="")
$days=0;
if($ext=="")
$ext=0;
if($leav=="")
$leav=0;

$empname=$_SESSION['valid_user'];
 
  $q2 = "update hr_mnth_attendance set date='$date1' , dayspresent = '$days', extra = '$ext',leaves='$leav',paidleaves='$pleav',empname='$empname' where id = '$id'";
  $qrs2 = mysql_query($q2,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_mnth_attendance';"; 
echo "</script>";

?>