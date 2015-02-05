<?php

include "config.php";



for($i=0;$i<count($_POST['minqty']);$i++)
{
  if($_POST['minqty'][$i] != "0" && $_POST['minqty'][$i] != "")
  {
   $q = "insert into common_alerts(item,minqty,maxqty,type,units) values('".$_POST[item][$i]."','".$_POST[minqty][$i]."','".$_POST[maxqty][$i]."','".$_POST[type][$i]."','".$_POST[unit][$i]."')";
   $qrs = mysql_query($q,$conn);
  }
}




header('Location:dashboardsub.php?page=common_alert');
?>

