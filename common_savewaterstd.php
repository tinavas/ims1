<?php

include "config.php";



for($i=0;$i<count($_POST['parameters']);$i++)
{
  if($_POST['parameters'][$i] != "0" && $_POST['parameters'][$i] != "")
  {
   $q = "insert into water_standards(parameter,unit,maxlimit) values('".$_POST[parameters][$i]."','".$_POST[units][$i]."','".$_POST[limit][$i]."')";
   $qrs = mysql_query($q,$conn);
  }
}




header('Location:dashboardsub.php?page=common_waterstd');
?>

