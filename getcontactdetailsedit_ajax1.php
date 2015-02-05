<?php 
include "config.php";
$name=$_POST['name'];
$oldid = $_POST['oldid']; 
$result = mysql_query("select name from oc_employee where name='$name' AND id <> '$oldid'",$conn) or die(mysql_error());
echo mysql_num_rows($result);
?>
