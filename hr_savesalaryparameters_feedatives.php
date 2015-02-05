<?php
include "config.php";
$date1 = date("d.m.o"); 
$date = date("Y-m-j",strtotime($date1));
$client = $_SESSION['client'];
$sector = $_POST['sector'];

$bfix = $_POST['bfix'];
$hrafix = $_POST['hrafix'];
$cmpfix = $_POST['cmpfix'];
$dresfix = $_POST['dresfix'];
$tafix = $_POST['tafix'];
$pffix = $_POST['pffix'];
$esicfix = $_POST['esicfix'];
$kitfix = $_POST['kitfix'];

$mafix = 0;
$ccafix = 0;

$sallowancefix = 0;
$conveyancefix = 0;
$eallowancefix = 0;
$oallowancefix = 0;

$incometaxfix = 0;
$loanfix = 0;
$otherfix = 0;
$fromdate =$_POST['fdate'];
$fdate = date("Y-m-j",strtotime($fromdate));
$todate =$_POST['tdate'];
$tdate = date("Y-m-j",strtotime($todate));

 $q = "select distinct(employeeid),name,designation,salary  from hr_employee where sector = '$sector'";
$qrs = mysql_query($q,$conn);
while($qr = mysql_fetch_assoc($qrs))
{
 $ename = $qr['name'];
 $id = $qr['employeeid'];
 $desig = $qr['designation'];
 $salary = $qr['salary'];


$cfrom = 0;$cto =0;
 $query = "select count(*) as count from hr_salaryparameters where fromdate <= '$fdate' and todate >='$fdate' and sector = '$sector' and name='$ename'";
$result = mysql_query($query);
while($rfrm = mysql_fetch_assoc($result))
{
 $cfrom = $rfrm['count'];
}
 $query = "select count(*) as count from hr_salaryparameters where fromdate <= '$tdate' and todate >='$tdate'  and sector = '$sector' and name='$ename'";
$result = mysql_query($query);
while($rto = mysql_fetch_assoc($result))
{
 $cto = $rto['count'];
}

if(($cfrom == "0") &&($cto == "0"))
{ 
$basic = $salary * ($bfix/100);
	$cmpa =  $salary * ($cmpfix/100);
	$dresa = $salary * ($dresfix/100);
	$kita = $salary * ($kitfix/100);
$hra = $salary * ($hrafix/100);

$ma = 0;
$cca = 0;
$ta = $salary * ($tafix/100);
//$ta = 0;
$sallowance = 0;
$conveyance = 0;
$eallowance = 0;
$oallowance = 0;

$pf = $basic  * ($pffix/100);
//  professional tax to be calculated $ptax = $ptaxfix;
if($salary <= 1500)
{
$ptax = 0;
}
else if(($salary > 1500) && ($salary <= 2000))
{
$ptax = 18;
}
else if(($salary > 2000) && ($salary <= 3000))
{
$ptax = 25;
}
else if(($salary > 3000) && ($salary <= 5000))
{
$ptax = 30;
}
else if(($salary > 5000) && ($salary <= 6000))
{
$ptax = 40;
}
else if(($salary > 6000) && ($salary <= 7000))
{
$ptax = 45;
}
else if(($salary > 7000) && ($salary <= 8000))
{
$ptax = 50;
}
else if(($salary > 8000) && ($salary <= 9000))
{
$ptax = 90;
}
else if(($salary > 9000) && ($salary <= 15000))
{
$ptax = 110;
}
else if(($salary > 15000) && ($salary <= 25000))
{
$ptax = 130;
}
else if(($salary > 25000) && ($salary <= 40000))
{
$ptax = 150;
}
else if(($salary > 40000))
{
$ptax = 200;
}



$incometax = 0;
$loan = 0;
$other = 0;
$travexp = 0;

$gearnings = $basic + $cmpa + $hra + $ta + $dresa + $kita + $travexp + $sallowance + $conveyance + $eallowance + $oallowance + $ma + $cca ;
if($desig == "AGM")
{
$esic = 0;
}
else
{
$esic = $gearnings * ($esicfix/100);
}

$tdeduction = $pf + $ptax + $esic + $incometax + $loan + $other;
$net = $gearnings - $tdeduction;

//$finalsal = $salary + $net;
$finalsal =  $net;

$newdate = explode('.',$date);
$date = date("Y-m-j", strtotime($date));

//$delquery = "delete from hr_salaryparameters where eid = '$id'";
//$result = mysql_query($delquery);

  $get_entriess = "INSERT INTO hr_salaryparameters VALUES(NULL," . $id . ",'" . $sector . "','" . $ename . "','" . $date . "','" . $fdate . "','" . $tdate . "','" . $newdate[1] . "','" . $newdate[2] . "','" . $salary . "','" . $basic . "','" . $hra . "','"  . $ma . "','"  . $cca . "','"  . $ta . "','"  . $sallowance . "','"  . $conveyance. "','"  . $eallowance . "','"  . $oallowance . "','"  . $pf . "','"  . $ptax . "','"  . $incometax . "','"  . $loan . "','". $other . "','" . $dresa . "','" . $esic . "','". $cmpa . "','" . $kita . "', '" . $travexp . "', '". round($finalsal,3) . "','0','0',NULL,'$client')";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
}
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salaryparameters_feedatives';";
echo "</script>";

?>