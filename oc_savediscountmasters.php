<?php
include "config.php";
//print_r($_POST);
$fdate=date("Y-m-d",strtotime($_POST[fdate]));
$tdate=date("Y-m-d",strtotime($_POST[tdate]));
$wh=explode('@',$_POST[aaa]);
if($_POST[edit]==1)
{
$q1="delete from oc_discounts where  id='$_POST[oldid]'";
mysql_query($q1);
$cat=$_POST[cat];

$c=explode('@',$_POST[code]);
$code=$c[0];
$desc=$c[1];
$units=$_POST[units];
$price=$_POST[price];

$q1="insert into oc_discounts(`fromdate`,`todate`,`customer`,`cat`,`code`,`desc`,`units`,`discount`) values('$fdate','$tdate','$wh[0]','$cat','$code','$desc','$units','$price')";
mysql_query($q1);
}
else
{
for($i=0;$i<count($_POST[price])-1;$i++)
{
echo $cat=$_POST[cat][$i];
$c=explode('@',$_POST[code][$i]);
$code=$c[0];
$desc=$c[1];
$units=$_POST[units][$i];
$price=$_POST[price][$i];

 $q1="insert into oc_discounts(`fromdate`,`todate`,`customer`,`cat`,`code`,`desc`,`units`,`discount`) values('$fdate','$tdate','$wh[0]','$cat','$code','$desc','$units','$price')";
mysql_query($q1);
}
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_discountmaster'";
echo "</script>";

 ?>
