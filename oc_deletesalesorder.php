<?php
$po = $_GET['po'];

	 $query = "DELETE FROM oc_salesorder WHERE po = '$po'";
	$result = mysql_query($query,$conn) or die(mysql_error());

//header('location:dashboardsub.php?page=oc_salesorder');


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_salesorder'";
echo "</script>";
?>