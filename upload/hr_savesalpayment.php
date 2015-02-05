<?php 
include "config.php";
include "jquery.php";

$tid = 0;
$q = "select max(tid) as tid from hr_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;
$date = date("Y-m-d",strtotime($_POST['dateq']));

$date100 = explode("-",$date);
$month1 = $date100[1];
$year1 = $date100[0];

for($i = 0;$i<count($_POST['employeeid']);$i++)
{
if( $_POST['paid'][$i] != "0" && $_POST['paid'][$i] != "" && $_POST['paymode'][$i] != "" ) 
{
$cddno = "";
if($_POST['paymode'][$i] == "Cash")
$cddno = "";
else if($_POST['paymode'][$i] == "Cheque")
$cddno = $_POST['cddno'][$i];

////////////// Getting salary account from employee table  //////////

 $q = "select salaryac from hr_employee where employeeid = '" .$_POST['employeeid'][$i]. "'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $salaryac = $qr['salaryac'];


$query = "insert into hr_payment (tid,date,month1,year1,eid,name,totalsal,paid,deduction,bal,paymode,code,coacode,cddno,flag) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$_POST['paid'][$i]."','".round($_POST['deduction'][$i],3)."','".round($_POST['bal'][$i],3)."','".$_POST['paymode'][$i]."','".$_POST['code'][$i]."','".$_POST['coacode'][$i]."','".$cddno."','0')";
$rs = mysql_query($query,$conn) or die(mysql_error());

 $q = "update hr_leaves set flag = '1' where empid = '" .$_POST['employeeid'][$i]. "'";
$rs = mysql_query($q,$conn) or die(mysql_error());
} 
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salpayment';";
echo "</script>";
?>
