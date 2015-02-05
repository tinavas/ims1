<?php
include "config.php";
$tid = 0;

$empname=$_SESSION['valid_user'];
$q = "select max(tid) as tid from hr_salary_generation";
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
	$q = "select count(*) as count from hr_salary_generation order by`$para`";
	$res1 = mysql_query($q,$conn);
	while($r1 = mysql_fetch_assoc($res1))
	{
	 	$c = $r1['count'];
	}
	if($c == 0)
	{
		$q = "ALTER TABLE `hr_salary_generation`  ADD `$para` DOUBLE NOT NULL DEFAULT  '0' AFTER `oded`";
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
		$leavesded = $_POST['leavesded'][$i];
		if($leavesded == "")
		{
		$leavesded =0 ;
		}
		$pf123=0;$ewf01=0;
		$p=explode("@",$_POST['params'][$i]);
		if($p[1]=="PF123")
		$pf123=$p[0];
		else
		$pf123=0;
		if($p[1]=="EWF01")
		$ewf01=$p[0];
		else
		$ewf01=0;
		$paid=round($_POST['paid'][$i],2);
 $query = "insert into hr_salary_generation (tid,date,month1,year1,eid,name,totalsal,paid,allowances,pbaladd,advded,oded,pf,incometax,flag,leavesded,client,salparamid,designation,sector,empname) values ('$tid','$date','$month1','$year1','".$_POST['employeeid'][$i]."','".$_POST['employeename'][$i]."','".$_POST['totalsalary'][$i]."','".$paid."','".$_POST['allowances'][$i]."','".$_POST['addpbal'][$i]."','".$_POST['advdeduction'][$i]."','".$_POST['deduction'][$i]."','".$_POST['pf'][$i]."','".$_POST['incometax'][$i]."','1','".$leavesded."','".$_SESSION['client']."','$salparamid','$designation','$_POST[sector]','$empname')";
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
			 $get_entriess = "update hr_salary_generation set `$par` = '$curpar' where tid='$tid' and eid='$eid'" ;
			$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
			$m=$m+1;
		}
		
		$rsQuery=mysql_query("SELECT sector FROM hr_employee WHERE employeeid='".$_POST['employeeid'][$i]."'");
		$rsDataSector=mysql_fetch_assoc($rsQuery);
		$sector=$rsDataSector['sector'];

//-----------For Salary expance--(Cr)--------
$sal=round($_POST['totalsalary'][$i]+$_POST['allowances'][$i]-$_POST['deduction'][$i]);
$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Dr','".$_POST['coacode']."','".$sal."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

//---------For salary payable--(Cr)-----------
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$salaryac."','".round($_POST['paid'][$i],2)."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

//---------For Advance--(Cr)-----------
if($_POST['advdeduction'][$i]>0)
{
//echo 1;
$query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$_POST['advcode'][$i]."','".round($_POST['advdeduction'][$i],2)."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
}

//---------For Advance--(Dr)-----------
if($_POST['addpbal'][$i]>0)
{
//echo 2;
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Dr','".$_POST['advcode'][$i]."','".round($_POST['addpbal'][$i],2)."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
}

//---------For PF--(Cr)-----------
if($_POST['pf'][$i]>0)
{
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$_POST['pfcode'][$i]."','".$_POST['pf'][$i]."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
//$result4 = mysql_query($query4,$conn) or die(mysql_error());
}

//---------For EWF--(Cr)-----------
for($k=0;$k<$_POST['j'];$k++)
{
if($_POST['ewf'.$k ][$i]>0)
{
  $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$_POST['ewfcode'.$k][$i]."','".round($_POST['ewf'.$k][$i],2)."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
}
}
//---------For Income Tax--(Cr)-----------
if($_POST['incometax'][$i]>0)
{
 $query4 = "INSERT INTO ac_financialpostings(date,crdr,coacode,amount,trnum,type,venname,warehouse) VALUES('$date','Cr','".$_POST['itcode'][$i]."','".round($_POST['incometax'][$i],2)."','$tid','EMPGEN','".$_POST['employeename'][$i]."','".$sector."')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());
}

 $get_entriess = "update hr_salary_parameters set flag = '1' where id='$salparamid'" ;

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
	}
	}
	}
}
echo "<script type='text/javascript'>";
 echo "document.location = 'dashboardsub.php?page=hr_salary_gen';";
echo "</script>";
?>