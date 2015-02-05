<?php 
include "config.php";
$type= $_POST['type'];
session_start();
$db = $_SESSION['db'];
$local = $_POST['client'];
$ucode= $_POST['ucode'];
$udesc= $_POST['udesc'];
$cap= $_POST['capacity'];
$type = "";
for($i=0;$i< count($_POST['type']);$i++)
{
 $type = $type . $_POST['type'][$i] . ",";
}
echo $type;
$query1 = "insert into layer_farm(type,code,description,capacity,local,client) values ( '$type','$ucode','$udesc','$cap','$local','$client')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
if($type == 'Layer')
{

include "mainconfig.php";
$uname = $_POST['username'];
$q1 = "select * from tbl_users where username = '$uname'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1))
{
$x = $qr['layer'];
}
if($x == "")
{
$h = $ucode;
}
else
{
$h = $x.",".$ucode;
}
$query = " update tbl_users set layer = '$h' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());

}
else if($type == 'Breeder')
{
include "mainconfig.php";
$uname = $_POST['username'];
$q1 = "select * from tbl_users where username = '$uname'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1))
{
$x = $qr['breeder'];
}
if($x == "")
{
$h = $ucode;
}
else
{
$h = $x.",".$ucode;
}
$query = " update tbl_users set breeder = '$h' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());

}
else if($type == 'Broiler')
{
include "mainconfig.php";
$uname = $_POST['username'];
$q1 = "select * from tbl_users where username = '$uname'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1))
{
$x = $qr['broiler'];
}
if($x == "")
{
$h = $ucode;
}
else
{
$h = $x.",".$ucode;
}
$query = " update tbl_users set broiler = '$h' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());

}
else
{
include "mainconfig.php";
$uname = $_POST['username'];
$q1 = "select * from tbl_users where username = '$uname'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1))
{
$x = $qr['hatchery'];
}
if($x== "")
{
$h = $ucode;
}
else
{
$h = $x.",".$ucode;
}
$query = " update tbl_users set hatchery = '$h' where username = '$uname'";
$result = mysql_query($query,$conn) or die(mysql_error());

}

echo "<script type='text/javascript'>";
//echo "document.location = 'dashboard.php?page=layer_farm';";
echo "</script>";
?>