<?php

//print_r($_POST);


include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

$fromdate=date("Y-m-d",strtotime($_POST['fromdate']));

$todate=date("Y-m-d",strtotime($_POST['todate']));

$area=$_POST['area'];

$areaname=$_POST['areaname'];

$q1="select max(tid) as tid from distribution_stocklevel";

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

$trnum="DISTRIBUTE-".$incr;


if($_POST['edit']=="1")
{

$trnum=$_POST['oldid'];

$tr=explode("-",$trnum);

$incr=$tr[1];


$q2="select addempname,addempid from distribution_stocklevel where trnum='$trnum' limit 1";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

$addempname=$r2['addempname'];

$addempid=$r2['addempid'];

$editempname=$empname;

$editempid=$empid;

$q3="delete from distribution_stocklevel where trnum='$trnum' ";

$q3=mysql_query($q3) or die(mysql_error());


}


for($i=0;$i<count($_POST['category']);$i++)
 {

$cat=$_POST['category'][$i];

$code=$_POST['code'][$i];

$description=$_POST['description'][$i];

$units=$_POST['units'][$i];

$stock=$_POST['stock'][$i];

if($cat!="" && $code!="" && $stock!="")

{

  $q1="INSERT INTO `distribution_stocklevel` ( `tid`, `trnum`, `fromdate`, `todate`, `areacode`,areaname,`category`, `code`, `description`, `units`, `stock`, `addempname`, `addempid`, `editempname`, `editempid`) VALUES ('$incr','$trnum','$fromdate','$todate','$area','$areaname','$cat','$code','$description','$units','$stock','$addempname','$addempid','$editempname','$editempid');";


$q1=mysql_query($q1) or die(mysql_error());



}

}

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=distribution_distributionminimumstock';";

echo "</script>";


?>