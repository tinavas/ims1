<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include "config.php";
$q=mysql_query("select distinct invoice,party from oc_cobi where srflag='0' and invoice in (select invoice from distribution_salesreceipt)",$conn) or die(mysql_error());
while($r=mysql_fetch_array($q))
{
$party=$r[party];
$amount1=0;
	$q2=mysql_query("select * from oc_cobi where invoice='$r[invoice]'",$conn) or die(mysql_error());
	while($r2=mysql_fetch_array($q2))
	{
	
	$query3 = "SELECT * FROM ims_itemcodes WHERE code = '$r2[code]'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_array($result3))
  {
	$sac = $row3['sac'];
  }
  $amount=0;
  $amount=($r2[quantity]*$r2[price])-$r2[discountamount];
		$q3="insert into ac_financialpostings (date,trnum,itemcode,crdr,quantity,amount,coacode,type,venname,warehouse,empname) values('$r2[date]','$r2[invoice]','$r2[code]','Cr','$r2[quantity]','$amount','$sac','COBI','$r2[party]','$r2[warehose]','$r2[empname]')";
		mysql_query($q3,$conn) or die(mysql_error());
		
				$q31="insert into ac_financialpostings (date,trnum,itemcode,crdr,quantity,amount,coacode,type,venname,warehouse,empname) values('$r2[date]','$r2[invoice]','$r2[code]','Dr','$r2[quantity]','$amount','SATR01','COBI','$r2[party]','$r2[warehose]','$r2[empname]')";
		mysql_query($q31,$conn) or die(mysql_error());

	}
	
	$qq=mysql_query("select trnum,date from distribution_salesreceipt where invoice='$r[invoice]'",$conn);
	$rr=mysql_fetch_array($qq);
	
	$q3="select ca from contactdetails where name='$party'";

$q3=mysql_query($q3) or die(mysql_error());

$r3=mysql_fetch_array($q3);

$ca=$r3['ca'];

$q5="select sum(amount) as amount from ac_financialpostings where trnum='$r[invoice]' and coacode='SATR01' and type='COBI' and crdr='Dr'";

$q5=mysql_query($q5) or die(mysql_error());

$r5=mysql_fetch_assoc($q5);

$amount1=$r5['amount'];

$date=$rr[date];

 $q6="insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) values ('$date','','Cr','SATR01','0','$amount1','$rr[trnum]','DCOBIR','$party','$warehouse'),
 ('$date','','Dr','$ca','0','$amount1','$rr[trnum]','DCOBIR','$party','$warehouse')";
 
 mysql_query($q6,$conn) or die(mysql_error());
 
  $q7="update oc_cobi set srflag=1 where invoice='$r[invoice]'";
 
 $q7=mysql_query($q7) or die(mysql_error());
		
}
?>
</body>
</html>
