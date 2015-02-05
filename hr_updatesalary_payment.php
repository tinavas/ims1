<?php 
include "config.php";
include "jquery.php";

$oldid=$_POST['oldid'];
$date = date("Y-m-d",strtotime($_POST['date']));
$oldpdate = $_POST['oldpdate'];
$name = $_POST['employeename'];
$q11 = "delete from ac_financialpostings where type='EMPSAL' and date ='$oldpdate' and venname = '$name' and warehouse = '$name'";
$qrs11 = mysql_query($q11,$conn) ;

if( $_POST['paid'] != "0" && $_POST['paid'] != "" && $_POST['paymode'] != "" ) 
{
$cddno = "";
if($_POST['paymode'] == "Cash")
$cddno = "";
else if($_POST['paymode'] == "Cheque")
$cddno = $_POST['cddno'];
$salparamid = $_POST['salparamid'];

////////////// Getting salary account from employee table  //////////

 $q = "select salaryac from hr_employee where employeeid = '" .$_POST['employeeid']. "'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $salaryac = $qr['salaryac'];


 $query = "update hr_salary_payment set date='$date',totalsal='".$_POST['totalsalary']."',paid= '".$_POST['paid']."',deduction='".round($_POST['deduction'],3)."',bal='".round($_POST['bal'],3)."',paymode= '".$_POST['paymode']."' ,code='".$_POST['code']."',coacode='".$_POST['coacode']."' ,cddno='".$cddno."',bonus='".round($_POST['bonus'],3)."',pbonus='".round($_POST['advbonus'],3)."',advdeduction='".round($_POST['advdeduction'],3)."',ot='".$_POST['ot']."',leavesded = '".$_POST['leavesded']."', salparamid ='$salparamid'  where id='$oldid'";

//$query = "insert into hr_salary_payment (tid,date,month1,year1,eid,name,totalsal,paid,deduction,bal,paymode,code,coacode,cddno,flag,bonus,pbonus,advdeduction,ot,leavesded,client,salparamid) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$_POST['paid'][$i]."','".round($_POST['deduction'][$i],3)."','".round($_POST['bal'][$i],3)."','".$_POST['paymode'][$i]."','".$_POST['code'][$i]."','".$_POST['coacode'][$i]."','".$cddno."','1','".round($_POST['bonus'][$i],3)."','".round($_POST['advbonus'][$i],3)."','".round($_POST['advdeduction'][$i],3)."','".round($_POST['ot'][$i],3)."','".$_POST['leavesded'][$i]."','".$_SESSION['client']."','$salparamid')";
$rs = mysql_query($query,$conn) or die(mysql_error());

//$q = "update hr_leaves set flag = '1' where empid = '" .$_POST['employeeid'][$i]. "'";
//$rs = mysql_query($q,$conn) or die(mysql_error());

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Cr','".$_POST['coacode']."','".$_POST['paid']."','$tid','EMPSAL','".$_POST['employeename']."','".$_POST['employeename']."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

$co = $_POST['coacode'][$i];
$pay = $_POST['paid'][$i];
$emp1 = $_POST['employeename'][$i];
///////insert into ac_financialpostingssummary
$newamount = $pay + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$co' and date = '$date' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$co','$pay','Cr','$emp1','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$co','$pay','Cr','$emp1','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}


$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Dr','". $salaryac."','".$_POST['paid']."','$tid','EMPSAL','".$_POST['employeename']."','".$_POST['employeename']."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());


///////insert into ac_financialpostingssummary
$newamount = $pay + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$salaryac' and date = '$date' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$salaryac','$pay','Dr','$emp1','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$salaryac','$pay','Dr','$emp1','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}

$get_entriess = "update hr_salary_parameters set flag = '0' where id='$salparamid'" ;
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salary_payment';";
echo "</script>";
?>
