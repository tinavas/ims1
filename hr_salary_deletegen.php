<?php 
include "config.php";
$id = $_GET['id'];
$name = $_GET['name'];
$date = $_GET['date'];
$salid = $_GET['salid'];
$eid=$_GET['eid'];
$tid=$_GET['tid'];

$rsQuery=mysql_query("SELECT sector FROM hr_employee WHERE employeeid='".$eid."'");
$rsDataSector=mysql_fetch_assoc($rsQuery);
$sector=$rsDataSector['sector'];
		
$query="delete from hr_salary_generation where id='$id'";
$result=mysql_query($query,$conn);

$query1 = "delete from ac_financialpostings where type='EMPGEN' and date ='$date' and venname = '$name' and warehouse = '$sector' and trnum='$tid'";
$result1=mysql_query($query1,$conn);

$get_entriess = "update hr_salary_parameters set flag = '0' where id='$salid'" ;
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
	
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salary_gen';";
echo "</script>";
?>