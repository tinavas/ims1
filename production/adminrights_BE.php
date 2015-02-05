<?php 
session_start();
 $location=$_POST['location'];
if($_POST['password']=='jaffa@5' && $_POST['admin'])
{
  $_SESSION['admin']=$_POST['admin'];
 header('Location:usernames.php');
}
else
{
 $_SESSION['admin']='';
 header('Location:usernames.php');
}
?>