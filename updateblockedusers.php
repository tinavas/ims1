<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include "mainconfig.php";
//print_r($_POST);
//echo $_POST[users][0];
for($i=0;$i<count($_POST[users]);$i++)
{
 $a=$_POST[users][$i];
 $q="delete from blockedusers where uname='$a'";
$q1=mysql_query($q,$conn) or die(mysql_error());
}
header('Location:dashboardsub.php?page=');
?>
</body>
</html>
