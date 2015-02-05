<?php 
include "config.php";
include "getemployee.php";

$tid = $_POST['tid'];
$adate = date("Y-m-d",strtotime($_POST['date']));
$type = "EMPSAL";

$q = "select * from hr_payment where tid = '$tid' order by id";
$qrs =mysql_query($q,$conn) or die(msyql_error());
while($qr = mysql_fetch_assoc($qrs))
{
$eid = $qr['eid'];
$name = $qr['name'];
$amount = $qr['paid'];
$coacode = $qr['coacode'];

$q1 = "select salaryac from hr_employee where employeeid = '$eid'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
$salaryac = $q1r['salaryac'];

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$adate','Cr','$coacode','$amount','$tid','$type','$name','$name')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$adate','Dr','$salaryac','$amount','$tid','$type','$name','$name')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
}


$query5 = "UPDATE hr_payment SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salpayment';";
echo "</script>";


?>