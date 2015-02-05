<?php

//print_r($_POST);


include "getemployee.php";

$addempname=$empname;

$addempid=$empid;

if($_POST['edit']=='1')
{

$id=$_POST['oldid'];

$q1="select addempname,addempid from distribution_distributor where id='$id'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$addempname=$r1['addempname'];

$addempid=$r1['addempid'];

$editempname=$empname;

$editempid=$empid;

$q1="delete from distribution_distributor where id='$id'";

$q1=mysql_query($q1) or die(mysql_error());

}

$name=$_POST['name'];

$address=$_POST['address'];

$place=$_POST['place'];

$phone=$_POST['phone'];

$mobile=$_POST['mobile'];

$areacode=$_POST['areacode'];

$areaname=$_POST['areaname'];

$pan=$_POST['pan'];

$note=$_POST['note'];


 $q2="select superstockist from distribution_area where areacode='$areacode'";

$q2=mysql_query($q2) or die(mysql_error());

$r2=mysql_fetch_assoc($q2);

 $superstockist=$r2['superstockist'];



 $q1="INSERT INTO `distribution_distributor` ( `name`, `address`, `place`, `phone`, `mobile`,`superstockist` ,`areacode`,areaname, `PAN/TIN`, `note`, `addempname`, `addempid`, `editempname`, `editempid`) values ('$name','$address','$place','$phone','$mobile','$superstockist','$areacode','$areaname','$pan','$note','$addempname','$addempid','$editempname','$editempid')";

$q1=mysql_query($q1) or die(mysql_error());



header("Location:dashboardsub.php?page=distribution_distributor");


?>