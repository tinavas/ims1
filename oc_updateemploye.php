<?php
include "config.php";
$id=$_POST['id'];
$name = strtoupper($_POST['name']);


$getName="select name from oc_employee where id='$id'";
$getName_result=mysql_query($getName,$conn) or die(mysql_error());
$getName_rows=mysql_fetch_array($getName_result);
$oldName=$getName_rows['name'];
 
$query_update="update oc_employee set name='".$name."',address = '".$_POST['address']."',phone ='".$_POST['phone']."',mobile ='".$_POST['mobile']."',note ='".$_POST['note']."',place ='".$_POST['place']."',pan ='".$_POST['pan']."',ctype ='".$_POST['ctype']."' where id='".$id."'";
$query_result=mysql_query($query_update,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=oc_employee');
?>

