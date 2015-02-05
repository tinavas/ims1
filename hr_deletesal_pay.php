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

$query2="select * from hr_salary_payment where id='$id'";
$result2=mysql_query($query2,$conn);
$rows=mysql_fetch_assoc($result2);
$get_entriess = "update hr_salary_generation set pflag = '0' where eid='$eid' and  month1 = '$rows[month1]' and year1 = '$rows[year1]'" ;
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
		
$query="delete from hr_salary_payment where id='$id'";
$result=mysql_query($query,$conn);

$query1 = "delete from ac_financialpostings where type='EMPSAL' and date ='$date' and venname = '$name' and warehouse = '$sector' and trnum='$tid'";
$result1=mysql_query($query1,$conn);


	
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salary_pay';";
echo "</script>";
?>