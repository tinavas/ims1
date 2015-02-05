<?php
include "config.php";

	$id=$_GET['id'];
	$query="delete from hr_incometax where id='$id'";
	$result=mysql_query($query,$conn);

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_incometax';";
echo "</script>";

?>
