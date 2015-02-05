<?php 
include "config.php";
$name=$_POST['name']; 
$result = mysql_query("select name from oc_employee where name='$name'",$conn) or die(mysql_error());
echo mysql_num_rows($result);
?>
