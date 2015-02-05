<?php
include "config.php";

$empname=$_SESSION['valid_user'];
$tid = 0;
$q = "select max(tid) as tid from hr_salary_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;
$date = date("Y-m-d",strtotime($_POST['date']));
$dateq = date("Y-m-d",strtotime($_POST['dateq']));
$date100 = explode("-",$dateq);
$month1 = $date100[1];
$year1 = $date100[0];
$vals=$_POST["vals"];
$val1=explode("/",$vals);

$q3="SELECT code,description FROM `hr_params` WHERE coa != '' order by code ";
$r3=mysql_query($q3,$conn);
while($row1=mysql_fetch_assoc($r3))
{
	$para = $row1['code']; $c =0;
	$q = "select count(*) as count from hr_salary_payment order by`$para`";
	$res1 = mysql_query($q,$conn);
	while($r1 = mysql_fetch_assoc($res1))
	{
	 	$c = $r1['count'];
	}
	if($c == 0)
	{
		$q = "ALTER TABLE `hr_salary_payment`  ADD `$para` DOUBLE NOT NULL DEFAULT  '0' AFTER `oded`";
		$r = mysql_query($q,$conn);
	}
}

for($i = 0;$i<count($_POST['employeeid']);$i++)
{


	{
	for($yy=0;$yy<count($val1);$yy++)
	{
	
	
	if($val1[$yy]==$_POST['employeeid'][$i]) 
	{
	
		$cddno = "";
		if($_POST['paymode'][$i] == "Cash")
		$cddno = "";
		else if($_POST['paymode'][$i] == "Cheque")
		$cddno = $_POST['cddno'][$i];
		
		$salparamid = $_POST['salparamid'][$i];
		$q = "select salaryac,designation from hr_employee where employeeid = '" .$_POST['employeeid'][$i]. "'";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		if($qr = mysql_fetch_assoc($qrs))
		{
		$salaryac = $qr['salaryac'];
		$designation=$qr[designation];
		}
		$sector=$_POST['sector'];
		$leavesded = $_POST['leavesded'][$i];
		if($leavesded == "")
		{
		$leavesded =0 ;
		}
		//echo 'ewf'.$yy.$i;
		//echo $_POST['ewf1'][$i];
		
  $query = "insert into hr_salary_payment (tid,date,month1,year1,eid,name,totalsal,paid,allowances,pbaladd,advded,oded,pf,incometax,paymode,code,coacode,cddno,flag,leavesded,client,salparamid,empname) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$_POST['paid'][$i]."','".$_POST['allowances'][$i]."','".$_POST['addpbal'][$i]."','".$_POST['advdeduction'][$i]."','".$_POST['deduction'][$i]."','".$_POST['pf'][$i]."','".$_POST['incometax'][$i]."','".$_POST['paymode'][$i]."','".$_POST['code'][$i]."','".$_POST['coacode'][$i]."','".$cddno."','1','".$leavesded."','".$_SESSION['client']."','$salparamid','$empname')";
 $rs = mysql_query($query,$conn) or die(mysql_error());
$m=0;
$eid=$_POST['employeeid'][$i];
 $getpar= "SELECT * FROM hr_params  WHERE coa != '' order by code";//echo "<br>";
		$getparres = mysql_query($getpar,$conn);
		while($getpar_row1 = mysql_fetch_assoc($getparres))
		{
			$curpar = 0;
			$par = $getpar_row1['code'];
			$curpar = $_POST['ewf'.$m][$i]; 
			$get_entriess = "update hr_salary_payment set `$par` = '$curpar' where tid='$tid' and eid='$eid'" ;
			$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
			$m=$m+1;
		}
		
		$rsQuery=mysql_query("SELECT sector FROM hr_employee WHERE employeeid='".$_POST['employeeid'][$i]."'");
		$rsDataSector=mysql_fetch_assoc($rsQuery);
		$sector=$rsDataSector['sector'];

//-----------For Salary--(Dr)--------
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Dr','".$salaryac."','".$_POST['paid'][$i]."','$tid','EMPSAL','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

//---------For Cash/Bank--(Cr)-----------
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$_POST['coacode'][$i]."','".$_POST['paid'][$i]."','$tid','EMPSAL','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
$eid1=$_POST['employeeid'][$i];
 $query5="update hr_salary_generation set pflag='1' where sector = '$sector' and designation = '$designation' and eid='$eid1'  and  month1 = '$month1' and year1 = '$year1'";
$rquery = mysql_query($query5,$conn) or die(mysql_error());
	}
	}
	}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salary_pay';";
echo "</script>";
?>