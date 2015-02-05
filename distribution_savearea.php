<?php

//print_r($_POST);

include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

if($_POST['edit']=='1')
{
$id=$_POST['oldid'];

$q1="select addempname,addempid from distribution_area where id='$id'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$addempname=$r1['addempname'];

$addempid=$r1['addempid'];

$editempname=$empname;

$editempid=$empid;

$q1="delete from distribution_area where id='$id'";

$q1=mysql_query($q1) or die(mysql_error());

}


$areacode=$_POST['areacode'];

$areaname=$_POST['areaname'];

$superstockist=$_POST['superstockist'];

$state=$_POST['state'];

$district=$_POST['district'];

$q1="INSERT INTO `distribution_area` ( `areacode`, `areaname`, `superstockist`, `state`,`district`, `addempname`, `addempid`, `editempname`, `editempid`) values ('$areacode','$areaname','$superstockist','$state','$district','$addempname','$addempid','$editempname','$editempid')";

$q1=mysql_query($q1) or die(mysql_error());

header("Location:dashboardsub.php?page=distribution_area");



?>