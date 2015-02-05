<?php	//This is common file for SAVE,UPDATE,DELETE
include "config.php";

if($_GET['delete'] == 1)	//DELETE
{
 $delid = $_GET['id'];
$query = "DELETE FROM oc_tandc WHERE id = '$delid' AND client = '$client'";
mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 0)		//SAVE
{
$tandc = $_POST['tandc'];
$query = "INSERT INTO oc_tandc (id,tandc,client) VALUES (NULL,'$tandc','$client')";
$result = mysql_query($query,$conn) or die(mysql_error());
}
elseif($_POST['saed'] == 1)	//UPDATE
{
 $oldid = $_POST['oldid'];
$tandc = $_POST['tandc'];

$query = "UPDATE oc_tandc SET tandc = '$tandc' WHERE id='$oldid' AND client='$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
}
header("location:dashboardsub.php?page=oc_tandc");

?>