<?php

include "config.php";
$empname = $_SESSION['valid_user'];
$client = $_SESSION['client'];
$query1 = "SELECT * FROM hr_params order by code";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
	$para = $row1['code']; $c =0;
	$q = "select count(*) as count from hr_salary_parameters order by`$para`";
	$res1 = mysql_query($q,$conn);
	while($r1 = mysql_fetch_assoc($res1))
	{
	 	$c = $r1['count'];
	}
	if($c == 0)
	{
		$q = "ALTER TABLE `hr_salary_parameters`  ADD `$para` DOUBLE NOT NULL DEFAULT  '0' AFTER `salary`";
		$r = mysql_query($q,$conn);
	}
}
$sector = $_POST['sector'];
$designation = $_POST['desig'];
$fromdate =$_POST['fdate'];
$fdate = date("Y-m-j",strtotime($fromdate));
$todate =$_POST['tdate'];
$tdate = date("Y-m-j",strtotime($todate));
$id=$_POST['id'];
$eid1=$_POST['eid'];
 $query2="delete from hr_salary_parameters where id='$id' and eid='$eid1'";
$result2=mysql_query($query2,$conn);
$q1 = "select distinct(employeeid),name,salary  from hr_employee where sector = '$sector' and designation='$designation' and employeeid='$eid1'";
$qrs1 = mysql_query($q1,$conn);
while($qr1 = mysql_fetch_assoc($qrs1))
{
	 $ename = $qr1['name'];
	 $eid = $qr1['employeeid'];
	 $salary = $qr1['salary'];
	$cfrom = 0;$cto =0;
	$query11 = "select count(*) as count from hr_salary_parameters where fromdate <= '$fdate' and todate >='$fdate' and sector = '$sector' and  designation = '$designation' and name='$ename'";
	$result11 = mysql_query($query11);
	while($rfrm11 = mysql_fetch_assoc($result11))
	{
	 	$cfrom = $rfrm11['count'];
	}
	$query22 = "select count(*) as count from hr_salary_parameters where fromdate <= '$tdate' and todate >='$tdate'  and sector = '$sector' and designation = '$designation'  and name='$ename'";
	$result22 = mysql_query($query22);
	while($rto22 = mysql_fetch_assoc($result22))
	{
	 	$cto = $rto22['count'];
	}
	if(($cfrom == "0") &&($cto == "0"))
	{ 
		$finalsal =0;
		$query33 = "SELECT tax FROM hr_pf where '$salary' between salfrom and salto";
		$result33 = mysql_query($query33,$conn);
		while($row33 = mysql_fetch_assoc($result33))
		{
			$ProfessionalTax = $row33['tax'];
			$finalsal = $finalsal - $ProfessionalTax;
		}
		$query44 = "SELECT * FROM  hr_params order by code ";//echo "<br>";
		$result44 = mysql_query($query44,$conn);
		while($row44 = mysql_fetch_assoc($result44))
		{
			$desc = $row44['code'];
			$unit = $row44['unit'];
			$basis = $row44['basis'];
			$type = $row44['type'];
			$descval = $desc."val";
			$$descval = $_POST[$desc];
			if($basis == "Salary" && $unit == "Flat" && $type == "exclude")
			{
				$$desc = $$descval;
				$finalsal = $finalsal - $$descval;
			}
			else if($basis == "Salary" && $unit == "Flat" && $type == "include")
			{
				$$desc = $$descval;
				$finalsal = $finalsal + $$descval;
			}
			else if($basis == "Salary" && $unit == "Per" && $type == "exclude")
			{
				$$desc = $salary * ($$descval/100);
				$finalsal = $finalsal - $$desc;
			}
			else if($basis == "Salary" && $unit == "Per" && $type == "include")
			{
				$$desc = $salary * ($$descval/100);
				$finalsal = $finalsal + $$desc;
			}
		}
		
		$newdate = explode('.',$date);
		$date = date("Y-m-j", strtotime($date));
		if($ProfessionalTax == "")
		{
			$ProfessionalTax =0;
		}
		$get_entriess = "insert into hr_salary_parameters (eid,sector,designation,name,fromdate,todate,salary,ProfessionalTax,leavesal,finalsal,flag,client,empname) values('$eid','$sector','$designation','$ename','$fdate','$tdate','$salary','$ProfessionalTax','0','$finalsal','0','$client','$empname')";
		$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
		$getmax = "select max(id) as currid from hr_salary_parameters";
		$getmax_res1 = mysql_query($getmax,$conn) or die(mysql_error());
		while($getmax_row1 = mysql_fetch_assoc($getmax_res1))
		{
			$currid = $getmax_row1['currid'];
		}
		$getpar= "SELECT * FROM hr_params order by code";//echo "<br>";
		$getparres = mysql_query($getpar,$conn);
		while($getpar_row1 = mysql_fetch_assoc($getparres))
		{
			$curpar = 0;
			$par = $getpar_row1['code'];
			$curpar = $$par;
			$get_entriess = "update hr_salary_parameters set `$par` = '$curpar' where id='$currid'" ;
			$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
		}
	}
}


echo "<script type='text/javascript'>";

echo "document.location = 'dashboardsub.php?page=hr_salary_parameters';";

echo "</script>";



?>