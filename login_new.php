<?php
include("mainconfig.php");
session_start();
$_SESSION['db'] = "";
$_SESSION['sectorall'] = "";
$_SESSION['sectorlist'] = "";
$_SESSION['sectorwarelist'] = "";

$user=$_GET['username'];
$pass=$_GET['pass'];

echo $get_entriess = "select * from tbl_users where username='$user' and password='$pass' order by id desc ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

 while ($post_info = mysql_fetch_array($get_entriess_res1)) {
      $uname = $post_info['username'];
	  $email = $post_info['email'];
      $password = $post_info['password'];
      $client = $post_info['client'];
      $db = $post_info['dbase']; 
	  $sectorr = $post_info['sectortype'];
	  $currency = $post_info['currency'];
	  
$sectorlist = "'dummy'";
$sectorrwarelist = "'dummy'";
$sectorcnt = 0;
$query = "SELECT count(*) as c1 FROM tbl_users WHERE username = '$uname' and sectortype = 'all'";
$result = mysql_query($query,$conn); 
if($row1 = mysql_fetch_assoc($result))
{ 
  $sectorcnt = $row1['c1'];
}
if($sectorcnt > 0)
{
$sectorall = "all";
$_SESSION['sectorall'] = $sectorall;
}
else
{
$sectorall = "";
$_SESSION['sectorall'] = $sectorall;
$query = "SELECT distinct(sectortype) FROM tbl_users WHERE username = '$uname'";
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result))
{ 
			$query2 = "SELECT * FROM tbl_sector where place = '$row1[sectortype]'";
            $result2 = mysql_query($query2,$conn); 
            while($row2 = mysql_fetch_assoc($result2))
            {
			$sectorrwarelist = $sectorrwarelist.",'". $row2['sector']. "'";
			}
			
  $sectorlist = $sectorlist . ",'" . $row1['sectortype'] . "'";
}
$_SESSION['sectorlist'] = $sectorlist;
$_SESSION['sectorwarelist'] = $sectorrwarelist; 
}
	  
if ($user == $uname and $pass == $password )
 {
  $_SESSION['valid_user'] = $user;
  $_SESSION['valid_email'] = $email;
  $_SESSION['sectorr'] = $sectorr;
  $_SESSION['client'] = $client;
  $_SESSION['currency'] = $currency;
  
  if($_GET['company'] == "0") {  
   $_SESSION['db'] = $db; } 
  else { 
  	$_SESSION['db'] = $_GET['company'];
	if($_SESSION['db'] == 'medivet') $_SESSION['client'] = 'MEDIVET';
	elseif($_SESSION['db'] == 'ncf') $_SESSION['client'] = 'NCF';
	elseif($_SESSION['db'] == 'mlcf') $_SESSION['client'] = 'MLCF';
	elseif($_SESSION['db'] == 'tnm') $_SESSION['client'] = 'TNM';
	elseif($_SESSION['db'] == 'mbcf') $_SESSION['client'] = 'MBCF';
  } 
 header('Location:dashboard.php?page=');
  exit(0);
 }
}

header('Location:index_new.php?wrong=yes');

?>
