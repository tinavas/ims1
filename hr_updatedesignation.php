<?php
include "config.php";
 
$name = $_POST['designation'];
$id = ($_POST['id']);

 $query = "update hr_designation set name = '$name' where id = '$id' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_designation';";
echo "</script>";
?>








