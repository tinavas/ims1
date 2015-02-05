<?php
include("mainconfig.php");
session_start();
echo $_SESSION['valid_user'];
echo $_SESSION['valid_email'];

$_SESSION['db'] = "";
$nemail = $_POST['nemail'];
$pemail = $_POST['pemail'];
$uname = $_POST['username'];
$query = "select * from tbl_users where username = '$uname'";
$result= mysql_query($query,$conn) or die(mysql_error());
$count = mysql_num_rows($result);
echo $user=$_POST['username'];


while($qr = mysql_fetch_assoc($result))
{
$uname=$qr['username'];

$email = $qr['email'];
$uname = $qr['username'];
 
      $client = $qr['client'];
    $db = $qr['dbase']; 
if($pemail != $email)
{
echo " Enter the Correct Previous email-id ";
  $_SESSION['valid_user'] = $user;
$_SESSION['client'] = $client;
$_SESSION['db'] = $db;
 // if($_POST['company'] == "0") {   $_SESSION['db'] = $db; } else { echo $_SESSION['db'] = $_POST['company']; } 
  header('Location:dashboardsub.php?page=change_email');
}



if($pemail == $email)
{
echo $query = " update tbl_users set email = '$nemail' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());
  $_SESSION['valid_user'] = $user;
 $_SESSION['client'] = $client;
 $_SESSION['db'] = $db;
//if($_POST['company'] == "0") { echo  $_SESSION['db'] = $db; } else { echo $_SESSION['db'] = $_POST['company']; } 
header('Location:dashboardsub.php?page=');

 }

}


?>