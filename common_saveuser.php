<?php
include "config.php";
session_start();
$db = $_SESSION['db'];
$currency=$_SESSION['currency'];
$mformat = $_SESSION['millionformate'];
$emp1=$_SESSION[valid_user];
$temp = "";
for($i=0;$i<count($_POST['view']);$i++) {
 $temp .= $_POST['view'][$i]; 
 $temp .= ",";
   } 

$temp1 = "";
for($i=0;$i<count($_POST['add']);$i++) {
 $temp1 .= $_POST['add'][$i]; 
 $temp1 .= ",";
   } 

$temp2 = "";
for($i=0;$i<count($_POST['edit']);$i++) {
 $temp2 .= $_POST['edit'][$i]; 
 $temp2 .= ",";
   } 

$temp3 = "";
for($i=0;$i<count($_POST['delete']);$i++) {
 $temp3 .= $_POST['delete'][$i]; 
 $temp3 .= ",";
   } 

$temp4 = "";
for($i=0;$i<count($_POST['authorize']);$i++) {
 $temp4 .= $_POST['authorize'][$i]; 
 $temp4 .= ",";
   } 

$emp = explode('@',$_POST['employee']);
$empid = $emp[0];
$empname = $emp[1];
$sector = $emp[2];

$sector='';

$i=0;
while($_POST['sector'][$i])
    $sector.=$_POST['sector'][$i++].',';
$sector=substr($sector,0,-1); 

$authorizesectors='';
$i=0;
while($_POST['authorizesectors'][$i] && $_POST[admin])
    $authorizesectors.=$_POST['authorizesectors'][$i++].',';

if($_POST[admin])
  $admin=1;
else
  $admin=0;
  //for cleint singh
  
  if($_SESSION['db']=="singhsatrang")
 {
 
 if(count($_POST['superstockist'])>0)
 {
 $superstockist=implode(",",$_POST['superstockist']);
 }
 
  $query="INSERT INTO common_useraccess (id,username,email,view,addv,editv,deletev,authorize,employeeid,employeename,sector,superstockist,client)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['email']."','".$temp."','".$temp1."','".$temp2."','".$temp3."','".$temp4."','".$empid."','".$empname."','".$sector."','".$superstockist."','".$client."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 
 $date=date('Y-m-d');
$query1="insert into userrightslog(date,username,empname,type,newsectors,newsuperstockist) values ('".$date."','".$_POST[uname]."','".$emp1."','Create','".$sector."','".$superstockist."')";
mysql_query($query1,$conn) or die(mysql_error());
 
 include "mainconfig.php";
 $u="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url=parse_url($u);

$query2="INSERT INTO tbl_users (id,username,password,email,dbase,client,sectortype,currency,admin,authorizesectors,url,authorizesuperstockists,millionformate,country)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['pass']."','".$_POST['email']."','".$db."','".$client."','".$sector."','".$currency."','".$admin."','".$authorizesectors."','".$url[host]."','".$superstockist."','$mformat','".$_SESSION['country']."')";

 $get_entriess_res1 = mysql_query($query2,$conn) or die(mysql_error());
 
 
 }
  //---------------------------------------------
 else
 { 
  
 $query="INSERT INTO common_useraccess (id,username,email,view,addv,editv,deletev,authorize,employeeid,employeename,sector,client)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['email']."','".$temp."','".$temp1."','".$temp2."','".$temp3."','".$temp4."','".$empid."','".$empname."','".$sector."','".$client."')" or die(mysql_error());
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 
 include "mainconfig.php";

 $u="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url=parse_url($u);
$query="INSERT INTO tbl_users (id,username,password,email,dbase,client,sectortype,currency,admin,authorizesectors,url,millionformate,country)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['pass']."','".$_POST['email']."','".$db."','".$client."','".$sector."','".$currency."','".$admin."','".$authorizesectors."','".$url[host]."','$mformat','".$_SESSION['country']."')";

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 
 
}


header('Location:dashboardsub.php?page=common_users');
?>