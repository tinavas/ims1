<?php
	include("config.php");
?>

<?php
	$fromdate=date('Y-m-d',strtotime($_REQUEST['fromdate']));
	$todate=date('Y-m-d',strtotime($_REQUEST['todate']));
	$cash_limit=$_REQUEST['cash_limit'];
	
	$query="INSERT INTO tds_limit(fromDate, toDate, `limit`) values('".$fromdate."', '".$todate."', '".$cash_limit."')";
	$result=mysql_query($query, $conn);
	//echo mysql_insert_id($result);
			header("Location:dashboardsub.php?page=tds_limit");
?>	