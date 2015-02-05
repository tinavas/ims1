<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

include "config.php";

$q=mysql_query("select distinct(trnum),date,superstockist from distributor_ob") or die(mysql_error());
while($r=mysql_fetch_array($q))
{

$q1=mysql_query("select * from distributor_ob where trnum='$r[trnum]'") or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{

 $q3="insert into distribution_financialpostings(date,itemcode,crdr,quantity,amount,trnum,type,warehouse) values ('$r1[date]','','Dr','0','$r1[openingbal]','$r1[trnum]','DTOB','$r1[distributor]') ";
mysql_query($q3,$conn) or die(mysql_error());

$cnfamount+=$r1[openingbal];

}

 $q3="insert into distribution_financialpostings(date,itemcode,crdr,quantity,amount,trnum,type,warehouse) values ('$r[date]','','Cr','0','$cnfamount','$r[trnum]','DTOB','$r[superstockist]') ";
mysql_query($q3,$conn) or die(mysql_error());

}
?>
</body>
</html>
