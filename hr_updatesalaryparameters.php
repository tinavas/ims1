<?php
include "config.php";
$client = $_SESSION['client'];
$sector = $_POST['sector'];
$ename = $_POST['ename'];

$id = $_POST['eid'];

$bfix = $_POST['bfix'];
$hrafix = $_POST['hrafix'];
$mafix = $_POST['mafix'];
$ccafix = $_POST['ccafix'];
$tafix = $_POST['tafix'];
$sallowancefix = $_POST['sallowancefix'];
$conveyancefix = $_POST['conveyancefix'];
$eallowancefix = $_POST['eallowancefix'];
$oallowancefix = $_POST['oallowancefix'];

$pffix = $_POST['pffix'];
$ptaxfix = $_POST['ptaxfix'];
$incometaxfix = $_POST['incometaxfix'];
$loanfix = $_POST['loanfix'];
$otherfix = $_POST['otherfix'];
$date = $_POST['date1'];
$salary = $_POST['sal'];

$basic = $bfix;
$hra = $salary * ($hrafix/100);
$ma = $salary * ($mafix/100);
$cca = $salary * ($ccafix/100);
$ta = $salary * ($tafix/100);
$sallowance = $salary * ($sallowancefix/100);
$conveyance = $salary * ($conveyancefix/100);
$eallowance = $salary * ($eallowancefix/100);
$oallowance = $salary * ($oallowancefix/100);

$pf = $pffix;
$ptax = $ptaxfix;
$incometax = $salary * ($incometaxfix/100);
$loan = $salary * ($loanfix/100);
$other = $salary * ($otherfix/100);

$gearnings = $basic + $hra + $sallowance + $conveyance + $eallowance + $oallowance + $ma + $cca + $ta;
$tdeduction = $pf + $ptax + $incometax + $loan + $other;
$net = $gearnings - $tdeduction;

//$finalsal = $salary + $net;
$finalsal =  $net;

$newdate = explode('.',$date);
$date = date("Y-m-j", strtotime($date));

 $delquery = "delete from hr_salaryparameters where eid = '$id'";
$result = mysql_query($delquery,$conn);

 $get_entriess = "INSERT INTO hr_salaryparameters VALUES(NULL," . $id . ",'" . $sector . "','" . $ename . "','" . $date . "','" . $newdate[1] . "','" . $newdate[2] . "','" . $salary . "','" . $basic . "','" . $hra . "','"  . $ma . "','"  . $cca . "','"  . $ta . "','"  . $sallowance . "','"  . $conveyance. "','"  . $eallowance . "','"  . $oallowance . "','"  . $pf . "','"  . $ptax . "','"  . $incometax . "','"  . $loan . "','". $other . "','". round($finalsal,3) . "','0','0',NULL,'$client')";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_salaryparameters';";
echo "</script>";

?>