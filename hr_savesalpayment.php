$empname <?php 
include "config.php";
include "jquery.php";

$tid = 0;
$q = "select max(tid) as tid from hr_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;
$date = date("Y-m-d",strtotime($_POST['date']));

$dateq = date("Y-m-d",strtotime($_POST['dateq']));
$date100 = explode("-",$dateq);
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

 $q = "select salaryac,sector from hr_employee where employeeid = '" .$_POST['employeeid'][$i]. "'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
 $salaryac = $qr['salaryac'];
 $sectoremp= $qr['sector'];

$ot = $_POST['ot'][$i];
if($ot == "")
{
$ot = 0;
}
$query = "insert into hr_payment (tid,date,month1,year1,eid,name,totalsal,paid,deduction,bal,paymode,code,coacode,cddno,flag,ot) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$_POST['paid'][$i]."','".round($_POST['deduction'][$i],3)."','".round($_POST['bal'][$i],3)."','".$_POST['paymode'][$i]."','".$_POST['code'][$i]."','".$_POST['coacode'][$i]."','".$cddno."','1','".$ot."')";
$rs = mysql_query($query,$conn) or die(mysql_error());

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Cr','".$_POST['coacode'][$i]."','".$_POST['paid'][$i]."','$tid','EMPSAL','".$_POST['employeename'][$i]."','$sectoremp')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
$amot1 = $_POST['paid'][$i];
 $co = $_POST['coacode'][$i];
$e1 = $sectoremp;

////////insert into ac_financialpostingssummary


		   $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$co' and date = '$date' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		   $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$co','$amot1','Cr','$e1','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amot1;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$co' and date = '$date' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) 
VALUES('$date','Dr','".$salaryac."','".$_POST['paid'][$i]."','$tid','EMPSAL','".$_POST['employeename'][$i]."','$sectoremp')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

//////insert into ac_financialpostingssummary

		   $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$salaryac' and date = '$date' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		   $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$salaryac','$amot1','Dr','$e1','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $amot1;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$salaryac' and date = '$date' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }



 $q = "update hr_leaves set flag = '1' where empid = '" .$_POST['employeeid'][$i]. "'";
$rs = mysql_query($q,$conn) or die(mysql_error());
} 
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salpayment';";
echo "</script>";
?>
