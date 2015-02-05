<?php

include "config.php";



for($i=0;$i<count($_POST['price']);$i++)
{
  if($_POST['price'][$i] != "0" && $_POST['price'][$i] != "")
  {
  $type = $_POST['type'][$i];
  $code = $_POST['code'][$i];
  $description = $_POST['description'][$i];
  $fweek = $_POST['fweek'][$i];
  $tweek = $_POST['tweek'][$i];
  $price = $_POST['price'][$i];
  
   $q = "insert into common_stdprices(type,code,description,stdprice,fromweek,toweek) values('$type','$code','$description','$price','$fweek','$tweek')";
   $qrs = mysql_query($q,$conn);
  }
}




header('Location:dashboardsub.php?page=common_stdprice');
?>

