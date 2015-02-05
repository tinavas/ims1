<?php

 $trnum=$_GET['id'];

$q1="delete from distribution_stockadjustment where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());


header('Location:dashboardsub.php?page=distribution_stockadjust');
?>