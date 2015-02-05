<?php 
include "config.php";

$query = "delete from watermicrobiology where tid = '$_GET[tid]'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=watermicrobiology';";
echo "</script>";
?>