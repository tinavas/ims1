<?php

include "config.php";



$code = strtoupper($_POST['code']);

$description = ucwords($_POST['description']);

$flag = 'Added';

$ptype = $_POST['direct'];

$query="INSERT INTO ac_schedule(schedule,type,pschedule,flag,ptype)

 VALUES ('".$description."','".$_POST['type']."','".$_POST['schedule']."','".$flag."','".$ptype."')" or die(mysql_error());



$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";

echo "document.location = 'dashboardsub.php?page=ac_schedule';";

echo "</script>";

?>