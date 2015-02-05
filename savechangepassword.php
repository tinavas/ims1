<?php
include("mainconfig.php");
session_start();
$_SESSION['db'] = "";
 $npassword = $_POST['npassword'];
$rpassword = $_POST['rpassword'];
echo $ppassword = $_POST['ppassword'];
$uname = $_POST['username'];
$get_entriess = "select * from tbl_users where username = '$uname'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
echo $count = mysql_num_rows($get_entriess_resl);
$user=$_POST['username'];
$pass=$_POST['pass'];
 while ($post_info = mysql_fetch_array($get_entriess_res1)) {
     $uname = $post_info['username'];
    echo $password = $post_info['password'];
      $client = $post_info['client'];
   echo $db = $post_info['dbase']; 
if($ppassword != $password)
{
echo " Enter the Correct Current Password";
 $_SESSION['valid_user'] = $user;
$_SESSION['client'] = $client;
$_SESSION['db'] = $db;
//  if($_POST['company'] == "0") {   $_SESSION['db'] = $db; } else { echo $_SESSION['db'] = $_POST['company']; } 
  header('Location:dashboardsub.php?page=change_password');
}

if(($ppassword == $password) &&($npassword == $rpassword))
{
$query = " update tbl_users set password = '$rpassword' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());
if ($ppassword == $password)
 {
 $_SESSION['valid_user'] = $user;
$_SESSION['client'] = $client;
$_SESSION['db'] = $db;
//if($_POST['company'] == "0") {   $_SESSION['db'] = $db; } else { echo $_SESSION['db'] = $_POST['company']; } 
  header('Location:dashboardsub.php?page=');
  
 }

}
	  
}

?>