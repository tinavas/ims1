<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include "config.php";
$q1="select distinct trnum from distribution_stockissuetodistributor where superstockist='RUSHAB MARKETING' and date between '2014-11-01' and '2014-11-30' and category='Pouches' order by trnum";
$r2=mysql_query($q1);
while($re=mysql_fetch_array($r2))
{
$totamount=0;
$q1="select * from distribution_stockissuetodistributor where trnum='$re[trnum]'";
$r1=mysql_query($q1);
while($res=mysql_fetch_array($r1))
{
$totamount+=$res[amount];
$q2="update ac_financialpostings set quantity='$res[quantity]',amount='$res[amount]' where trnum='$res[trnum]' and itemcode='$res[code]'";
$r2=mysql_query($q2);
$tr=$re[trnum];
}
$q4="update distribution_stockissuetodistributor set totalamount='$totamount' where trnum='$re[trnum]'";
$r4=mysql_query($q4);
}
?>
</body>
</html>
