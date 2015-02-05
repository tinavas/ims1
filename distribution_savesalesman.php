<?php

//print_r($_POST);

include "getemployee.php";

$addempname=$empname;

$addempid=$empid;


$q1="select max(tid) as tid from distribution_salesman";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

if($r1['tid']=="")
{
$incr=1;
}
else
{
$incr=$r1['tid']+1;
}

$trnum="ASP-".$incr;

if($_POST['edit']=='1')
{
	
	$trnum=$_POST['oldid'];
	
	$value1=explode("-",$trnum);
	
	$incr=$value1[1];
	
	
	$q1="select addempname,addempid from distribution_salesman where trnum='$trnum'";

    $q1=mysql_query($q1) or die(mysql_error());
	
	$r1=mysql_fetch_assoc($q1);
	
	$addempname=$r1['addempname'];	
	
	$addempid=$r1['addempid'];
	
	$editempname=$empname;

    $editempid=$empid;
	
	$q1="delete from distribution_salesman where trnum='$trnum'";
	
	$q1=mysql_query($q1) or die(mysql_error());
	
	$r1=mysql_fetch_assoc($q1);
	
	
	
}



$fromdate=date("Y-m-d",strtotime($_POST['fromdate']));

$todate=date("Y-m-d",strtotime($_POST['todate']));

$salesman=$_POST['salesman'];

$superstockist=$_POST['superstockist'];

$allcheckvalues=explode("$",$_POST['allcheckvalues']);

for($i=0;$i<count($allcheckvalues);$i++)
{

$areacode=$allcheckvalues[$i];


$q2="select name from distribution_distributor where areacode='$areacode'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$distributor=$r2['name'];


$q2="select areaname from distribution_area where areacode='$areacode'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$areaname=$r2['areaname'];



 $q1="INSERT INTO `distribution_salesman` ( `tid`, `trnum`, `fromdate`, `todate`, `salesman`, `superstockist`, `areacode`, `areaname`, `distributor`, `addempname`, `addempid`, `editempname`, `editempid`) values('$incr','$trnum','$fromdate','$todate','$salesman','$superstockist','$areacode','$areaname','$distributor','$addempname','$addempid','$editempname','$editempid')";

$q1=mysql_query($q1) or die(mysql_error());



}


header("Location:dashboardsub.php?page=distribution_salesman");


?>
