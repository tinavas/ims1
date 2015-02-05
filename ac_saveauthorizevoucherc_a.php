<?php
include "config.php";
$alltids = $_POST['alltids'];
$alltids = explode('*',$alltids);
$type = $_POST['rtype'];
$voucher = substr($type,0,1);

for($i = 0; $i < count($alltids); $i++)
 $tids .= $alltids[$i].",";
$tids = substr($tids,0,-1);

$query = "INSERT INTO ac_financialpostings (date,crdr,coacode,quantity,amount,trnum,type,venname,cash,bank,cashcode,bankcode,schedule,client,warehouse) select date,crdr,code,0,(cramount+dramount),transactioncode,'$type','',cash,bank,cashcode,bankcode,schedule,client,warehouse FROM ac_gl WHERE transactioncode IN ($tids) and voucher = '$voucher' ORDER BY id";
$result = mysql_query($query,$conn) or die(mysql_error());

$query = "update ac_gl SET vstatus = 'A' where transactioncode IN ($tids) and voucher = '$voucher'";
$result = mysql_query($query,$conn) or die(mysql_error());

$userlogged = $_SESSION['valid_user'];
$query1 = "SELECT employeename,sector FROM common_useraccess where username= '$userlogged' ORDER BY username ASC LIMIT 1";
$result1 = mysql_query($query1,$conn); 
while($row11 = mysql_fetch_assoc($result1))
{
	$empname = $row11['employeename'];
	$sector = $row11['sector'];
	$aempid = $row11['employeeid'];
}
$adate = date("Y-m-d");
$query = "INSERT INTO authorization (id,type,trnum,adate,name,sector,client) VALUES (NULL,'$type','$tids','$adate','$empname','$sector','$client')";
$result = mysql_query($query,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=authorize';";
echo "</script>";

?>