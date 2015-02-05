<?php

$trnum=$_GET['trnum'];

 $q1="delete from  distribution_salesman where trnum='$trnum'";

$q1=mysql_query($q1) or die(mysql_error());

header("Location:dashboardsub.php?page=distribution_salesman");



?>