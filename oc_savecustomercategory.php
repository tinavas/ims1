<?php	//This is common file for SAVE,UPDATE,DELETE
include "config.php";

if($_GET['delete'] == 1)	//DELETE
{
 $delid = $_GET['id'];
$query = "DELETE FROM oc_customercategory WHERE id = '$delid' AND client = '$client'";
mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 0)		//SAVE
{
$category = $_POST['customercategory'];
$query = "INSERT INTO oc_customercategory (id,category,client) VALUES (NULL,'$category','$client')";
$result = mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 1)	//UPDATE
{
 $oldid = $_POST['oldid'];
$category = $_POST['customercategory'];

$query = "UPDATE oc_customercategory SET category = '$category' WHERE id='$oldid' AND client='$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
}
header("location:dashboardsub.php?page=oc_customercategory");

?>