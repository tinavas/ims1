<?php
include "mainconfig.php";
$id=$_GET['id'];
$client=$_SESSION['client'];
$emp=$_SESSION[valid_user];
$get_entriess = "DELETE FROM tbl_users WHERE username = '$id' AND client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
include "config.php";
  $oldq="select * from common_useraccess WHERE username = '$id' AND client = '$client'";
   $oldr=mysql_query($oldq);
   while($r=mysql_fetch_array($oldr))
   {
   $sector=$r[sector];
   $superstockist=$r[superstockist];
   }

 $date=date('Y-m-d');
 $query1="insert into userrightslog(date,username,employeename,type,oldsectors,newsectors,oldsuperstockist,newsuperstockist) values ('".$date."','".$id."','".$emp."','Delete','','".$sector."','','".$superstockist."','".$client."')";
mysql_query($query1,$conn) or die(mysql_error());

$query= "DELETE FROM common_useraccess WHERE username = '$id' AND client = '$client'";
$result=mysql_query($query,$conn) or die(mysql_error());
header('Location:dashboardsub.php?page=common_users');
?>