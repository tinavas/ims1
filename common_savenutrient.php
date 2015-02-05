<?php 
include "config.php";
$nutrient = $_POST['nutrient'];
if($_POST['saed'] == 1)
{
$id = $_POST['id'];
echo $query = "DELETE FROM common_nutrient WHERE id = '$id' and client = '$client'";
mysql_query($query,$conn) or die(mysql_error());
}	
$query1 = "insert into common_nutrient(nutrient,client) values ( '$nutrient','$client')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=common_nutrient';";
echo "</script>";

?>