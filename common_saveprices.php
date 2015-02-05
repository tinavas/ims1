<?php

include "config.php";



for($i=0;$i<count($_POST['price']);$i++)
{
  if($_POST['price'][$i] != "0" && $_POST['price'][$i] != "")
  {
   $date=date("Y-m-d",strtotime($_POST['date'][$i]));
   $q = "insert into common_rates(location,date,type,rate,unit) values('".$_POST[location][$i]."','".$date."','".$_POST[type][$i]."','".$_POST[price][$i]."','".$_POST[unit][$i]."')";
   $qrs = mysql_query($q,$conn);
  }
}




header('Location:dashboardsub.php?page=common_prices');
?>

