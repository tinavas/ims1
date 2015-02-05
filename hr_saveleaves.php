<?php 

include "config.php";
 $id = $_POST['id'];
 $sm = $_POST['sm'];

$q = "select max(tid) as tid from hr_leaves";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;

if($sm == "s")
{
$date = date("Y-m-j", strtotime($_POST['date1']));
$adate = date("Y-m-j", strtotime($_POST['date4']));
$d = date("D", strtotime($_POST['date1']));

$q = "insert into hr_leaves (tid,empid,fromdate,todate,reason,approver,approveddate,flag) values('$tid','".$id. "','".$date."','".$date."','".$_POST['reason1']."','$_POST[approver]','$adate','0')";
$r = mysql_query($q,$conn) or die(mysql_error());

$flag = 0;
$hquery = "select * from hr_holidays order by date ASC";
$hrs = mysql_query($hquery,$conn) or die(mysql_error());
$noofholidays = mysql_num_rows($hrs);

while($hrr = mysql_fetch_assoc($hrs))
{
if($date != $hrr['date'])
{
 	$flag++;
}
}
if($noofholidays == $flag)
{
	$getsal = "select finalsal from hr_salaryparameters where eid = '$id'";
	$getsalrs = mysql_query($getsal,$conn) or die(mysql_error());
	while($getsalr = mysql_fetch_assoc($getsalrs))
	{
		$salary = $getsalr['finalsal'];
	}
	if($d != "Sun")
	{
	$leavesal = round($salary/30,0);
	$ok = 1;
	}
	else
	{
	$leavesal = 0;
	$ok = 0;
	}
	$qupd1 = "update hr_leaves set diff = '$ok',leavesal = '$leavesal' where tid = '$tid' ";
	$qupdrs1 = mysql_query($qupd1,$conn) or die(mysql_error());
}
}


else if($sm == "m")
{
$date2 = date("Y-m-j", strtotime($_POST['date2']));
$date3 = date("Y-m-j", strtotime($_POST['date3']));
$adate = date("Y-m-j", strtotime($_POST['date5']));

$q = "insert into hr_leaves (tid,empid,fromdate,todate,reason,diff,approver,approveddate,flag) values('$tid','".$id. "','".$date2."','".$date3."','".$_POST['reason2']."','".$_POST['diff']."','$_POST[approver1]','$adate','0')";
$r = mysql_query($q,$conn) or die(mysql_error());

$date21 = strtotime($date2);
$date31 = strtotime($date3);
$leavedays = (($date31 - $date21)/86400)+1;

$count1 = $leavedays;

$d1 = strtotime($_POST['date2']);
for($index = 0; $index < $count1; $index++)
{
$d2 = date("D", $d1);
if($d2 == "Sun")
$leavedays--;
$d1 += (24 * 60 * 60);
}


$hquery = "select * from hr_holidays order by date ASC";
$hrs = mysql_query($hquery,$conn) or die(mysql_error());
$noofholidays = mysql_num_rows($hrs);
 
while($hrr = mysql_fetch_assoc($hrs))
if(($date2 <= $hrr['date']) && ($date3 >= $hrr['date']))
{
$d100 = strtotime($hrr['date']);
$d200 = date("D", $d100);
if($d200 != "Sun")
 	$leavedays--;
}

$qupd = "update hr_leaves set diff = '$leavedays' where tid = '$tid'";
$qupdrs = mysql_query($qupd,$conn) or die(mysql_error());
if( $leavedays > 0 )
{
	$getsal = "select finalsal from hr_salaryparameters where eid = '$id'";
	$getsalrs = mysql_query($getsal,$conn) or die(mysql_error());
	while($getsalr = mysql_fetch_assoc($getsalrs))
	{
		$finalsal = $getsalr['finalsal'];
	}

$leavesal = round((($finalsal/30)*$leavedays),0);
$qupd = "update hr_leaves set leavesal = '$leavesal' where tid = '$tid'";
$qupdrs = mysql_query($qupd,$conn) or die(mysql_error());

}
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_employee'";
echo "</script>";
?>