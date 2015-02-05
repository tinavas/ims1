<?php	//This is common file for SAVE,UPDATE,DELETE
include "config.php";

if($_GET['delete'] == 1)	//DELETE
{
 $delid = $_GET['id'];
$query = "DELETE FROM ims_creditterm WHERE id = '$delid' AND client = '$client'";
mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 0)		//SAVE
{
$code = $_POST['code'];
$desc = $_POST['desc'];
$value = $_POST['value1'];

$query = "INSERT INTO ims_creditterm (id,code,description,value,client) VALUES (NULL,'$code','$desc','$value','$client')";
$result = mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 1)	//UPDATE
{
 $oldid = $_POST['oldid'];
$code = $_POST['code'];
$desc = $_POST['desc'];
$value = $_POST['value1'];

$query = "UPDATE ims_creditterm SET code = '$code',description='$desc',value='$value' WHERE id='$oldid' AND client='$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
}
header("location:dashboardsub.php?page=pp_creditterm");

?>