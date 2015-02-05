<?php
include "config.php";
$date1 = date("d.m.o"); 
$date = date("Y-m-j",strtotime($date1));
$client = $_SESSION['client'];
$sector = $_POST['sector'];
$ename = $_POST['ename'];


$eid = $_POST['eid'];
$id = $_POST['id'];
$salary = $_POST['salary'];

$bfix = $_POST['bfix'];
$hrafix = $_POST['hrafix'];
$cmpfix = $_POST['cmpfix'];
$dresfix = $_POST['dresfix'];
$tafix = $_POST['tafix'];
$pffix = $_POST['pffix'];
$ptaxfix = $_POST['ptaxfix'];
$esicfix = $_POST['esicfix'];
$kitfix = $_POST['kitfix'];
$travexp = $_POST['travexp'];

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

$cfrom = 0;$cto =0;
 $query = "select count(*) as count from hr_salaryparameters where fromdate <= '$fdate' and todate >='$fdate' and sector = '$sector' and name = '$ename' and id <> '$id'";
$result = mysql_query($query);
while($rfrm = mysql_fetch_assoc($result))
{
 $cfrom = $rfrm['count'];
}
 $query = "select count(*) as count from hr_salaryparameters where fromdate <= '$tdate' and todate >='$tdate'  and sector = '$sector' and name = '$ename' and id <> '$id'";
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
$sallowance = 0;
$conveyance = 0;
$eallowance = 0;
$oallowance = 0;

$pf = $basic  * ($pffix/100);
$ptax = $ptaxfix;
$incometax = 0;
$loan = 0;
$other = 0;

$gearnings = $basic + $cmpa + $hra + $ta + $dresa + $kita + $travexp + $sallowance + $conveyance + $eallowance + $oallowance + $ma + $cca ;
$esic = $gearnings * ($esicfix/100);

$tdeduction = $pf + $ptax + $esic + $incometax + $loan + $other;
$net = $gearnings - $tdeduction;

//$finalsal = $salary + $net;
$finalsal =  $net;

$newdate = explode('.',$date);
$date = date("Y-m-j", strtotime($date));

//$delquery = "delete from hr_salaryparameters where eid = '$id'";
//$result = mysql_query($delquery);

$get_entriess = "update hr_salaryparameters set fromdate='$fdate', todate = '$tdate',bfix = '$basic', hrafix ='$hra',tafix='$ta',pffix='$pf',ptaxfix='$ptax',dressmaintain='$dresa',esic='$esic',compallowance='$cmpa',kitallowance='$kita',travelexpense='$travexp',finalsal= '". round($finalsal,3) . "' where id='$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
}

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salaryparameters_feedatives';";
echo "</script>";

?>