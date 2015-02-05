<?php 
include "config.php";
include "jquery.php";

$oldid=$_POST['oldid'];
$date = date("Y-m-d",strtotime($_POST['date']));
$oldpdate = $_POST['oldpdate'];
$name = $_POST['employeename'];
echo $q11 = "delete from ac_financialpostings where type='EMPSAL' and date ='$oldpdate' and venname = '$name' and warehouse = '$name'";
$qrs11 = mysql_query($q11,$conn) ;


if( $_POST['paid'] != "0" && $_POST['paid'] != "" && $_POST['paymode'] != "" ) 
{
$cddno = "";
if($_POST['paymode'] == "Cash")
$cddno = "";
else if($_POST['paymode'] == "Cheque")
$cddno = $_POST['cddno'];

////////////// Getting salary account from employee table  //////////

 $q = "select salaryac from hr_employee where employeeid = '" .$_POST['employeeid']. "'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $salaryac = $qr['salaryac'];

$query = "update hr_payment set date='$date',ot='".$_POST['ot']."',coacode='".$_POST['coacode']."' ,cddno='".$cddno."',paid= '".$_POST['paid']."',paymode= '".$_POST['paymode']."' ,code='".$_POST['code']."' where id='$oldid'";
/*$query = "insert into hr_payment (tid,date,month1,year1,eid,name,totalsal,paid,deduction,bal,paymode,code,coacode,cddno,flag,ot) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$_POST['paid'][$i]."','".round($_POST['deduction'][$i],3)."','".round($_POST['bal'][$i],3)."','".$_POST['paymode'][$i]."','".$_POST['code'][$i]."','".$_POST['coacode'][$i]."','".$cddno."','0','".$_POST['ot'][$i]."')";*/
$rs = mysql_query($query,$conn) or die(mysql_error());


$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Cr','".$_POST['coacode']."','".$_POST['paid']."','$tid','EMPSAL','".$_POST['employeename']."','".$_POST['employeename']."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Dr','".$_POST['coacode']."','".$_POST['paid']."','$tid','EMPSAL','".$_POST['employeename']."','".$_POST['employeename']."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());


} 


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salpayment';";
echo "</script>";
?>
