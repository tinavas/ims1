<?php
//print_r($_POST)

session_start();
$db = $_SESSION['db'];
$client = $_SESSION['client'];
$currency=$_SESSION['currency'];
$emp=$_SESSION[valid_user];
include "mainconfig.php";
   $get_entriess = "DELETE FROM tbl_users WHERE username = '$_POST[uname]' and client = '$client'";
   $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

if($_POST['pass']!="")
$password=$_POST['pass'];
else
$password=$_POST['password'];

$sector='';
$i=0;
while($_POST['sector'][$i])
    $sector.=$_POST['sector'][$i++].',';
$sec1=$sector=substr($sector,0,-1);

$authorizesectors='';
$i=0;
while($_POST['authorizesectors'][$i] && $_POST[admin])
    $authorizesectors.=$_POST['authorizesectors'][$i++].',';

if($_POST[admin])
  $admin=1;
else
  $admin=0;
  
 if($_SESSION['db']=="singhsatrang")
 {
  if(count($_POST['superstockist'])>0)
 {
 $superstockist=implode(",",$_POST['superstockist']);
 }
 
echo $query="INSERT INTO tbl_users (id,username,password,email,dbase,client,sectortype,currency,admin,authorizesectors,authorizesuperstockists,country)
 VALUES (NULL,'".$_POST['uname']."','$password','".$_POST['email']."','".$db."','".$client."','".$sector."','".$currency."','".$admin."','".$authorizesectors."','".$superstockist."','".$_SESSION['country']."')" ;

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 

 }
 else
 {
  $query="INSERT INTO tbl_users (id,username,password,email,dbase,client,sectortype,currency,admin,authorizesectors,country)
 VALUES (NULL,'".$_POST['uname']."','$password','".$_POST['email']."','".$db."','".$client."','".$sector."','".$currency."','".$admin."','".$authorizesectors."','".$_SESSION['country']."')" ;

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 }

 if($_SESSION['db']=="singhsatrang")
 {
 
 include "config.php";
  if(count($_POST['superstockist'])>0)
 {
 $superstockist=implode(",",$_POST['superstockist']);
 }
 
 
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
   include "config.php";
   
$empid = $_POST['empid'];
$empname = $_POST['employee'];
$sector = $_POST['empsector'];
   
   $oldq="select * from common_useraccess WHERE username = '$_POST[uname]' AND client = '$client'";
   $oldr=mysql_query($oldq);
   while($r=mysql_fetch_array($oldr))
   {
   $oldsec=$r[sector];
   $oldsstk=$r[superstockist];
   }
 $get_entriess = "DELETE FROM common_useraccess WHERE username = '$_POST[uname]' AND client = '$client'";
  $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo  $query="INSERT INTO common_useraccess (id,username,email,view,addv,editv,deletev,authorize,employeeid,employeename,sector,superstockist,client)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['email']."','".$temp."','".$temp1."','".$temp2."','".$temp3."','".$temp4."','".$empid."','".$empname."','".$sec1."','".$superstockist."','".$client."')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());
 
   $date=date('Y-m-d');
 $query1="insert into userrightslog(date,username,employeename,type,oldsectors,newsectors,oldsuperstockist,newsuperstockist) values ('".$date."','".$_POST[uname]."','".$emp."','Edit','".$oldsec."','".$sec1."','".$oldsstk."','".$superstockist."')";
mysql_query($query1,$conn) or die(mysql_error());

}
 else
 {

if($_POST['view']!="")
{
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

   
   include "config.php";
   
$empid = $_POST['empid'];
$empname = $_POST['employee'];
$sector = $_POST['empsector'];
   
 echo $get_entriess = "DELETE FROM common_useraccess WHERE username = '$_POST[uname]' AND client = '$client'";
  $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
  


 $query="INSERT INTO common_useraccess (id,username,email,view,addv,editv,deletev,authorize,employeeid,employeename,sector,client)
 VALUES (NULL,'".$_POST['uname']."','".$_POST['email']."','".$temp."','".$temp1."','".$temp2."','".$temp3."','".$temp4."','".$empid."','".$empname."','".$sector."','".$client."')";
 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

}
}
//header('Location:dashboardsub.php?page=common_users');
?>