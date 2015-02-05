<?php

$id=$_GET['id'];


$q1="delete from distribution_shop where id='$id'";


$q1=mysql_query($q1) or die(mysql_error());


header("Location:dashboardsub.php?page=distribution_shop");



?>