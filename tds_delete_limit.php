<?php
	include("config.php");
?>

<?php
		
	$query="DELETE FROM tds_limit WHERE id='".$_GET['id']."'";
	$result=mysql_query($query, $conn);
	//echo mysql_insert_id($result);
			//header("location:dashboardsub.php?page=CT_limit");
			echo "<script language='javascript'>";
			echo "window.location='dashboardsub.php?page=tds_limit';";
			echo "</script>";
?>	