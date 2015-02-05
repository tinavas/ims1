<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>


<?php 
include "config.php";

$q="SELECT * FROM `pp_sobi` where so not in (select trnum from ac_financialpostings where type='SOBI' )group by so order by so";
$r=mysql_query($q);
while($rs=mysql_fetch_array($r))
{
$q1="SELECT * FROM `pp_sobi` where so='$rs[so]'";
$r1=mysql_query($q1);
while($res=mysql_fetch_array($r1))
{


  $type = 'SOBI';
  
  echo   $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$res[date]."','$res[code]','Dr','PTR01','".$res[receivedquantity]."','".$res[grandtotal]."','".$res[so]."','".$type."','".$res[vendor]."','$res[warehouse]','$res[empname]','$res[date]')";
   $result3 = mysql_query($query3,$conn) or die(mysql_error());

   // $result4 = mysql_query($query4,$conn) or die(mysql_error());
	echo "<br>$res[receiveflag]<br>";
	
if($res[receiveflag]=='1')
{

 $ia=mysql_query("select iac from ims_itemcodes where code='$ra[code]' ",$conn) or die(mysql_error());
 $rr=mysql_fetch_array($ia);
echo $q= "insert into ac_financialpostings(`date` ,itemcode,crdr,quantity,amount,coacode,trnum,type,venname,warehouse)  select '$res[date]', '$res[code]','Dr',quantity,amount,'$rr[iac]',trnum,type,venname,warehouse from ac_financialpostings where trnum='$res[so]' and coacode='PTR01' and itemcode='$res[code]'";
 echo  mysql_query($q,$conn) or die(mysql_error());
echo "<br>";
}
}
	$q = "select distinct(va) from contactdetails where name = '$rs[vendor]' and type like '%vendor%' order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$va = $qr['va'];
	
 echo    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$rs[date]."','','Cr','".$va."','".$rs[receivedquantity]."','".$rs[grandtotal]."','".$rs[so]."','".$type."','".$rs[vendor]."','$rs[warehouse]','$rs[empname]','$rs[date]')";
			   
			   echo "<br><br>";
	echo mysql_query($query4,$conn) or die(mysql_error());
	
			   
if($rs[receiveflag]=='1')
{
echo $q3= "insert into ac_financialpostings(`date` ,crdr,amount,coacode,trnum,type,venname,warehouse) select '$rs[date]', 'Cr',sum(amount),coacode,trnum,type,venname,warehouse from ac_financialpostings where trnum='$rs[so]' and coacode='PTR01'";

echo "<br><br>";
echo mysql_query($q3,$conn) or die(mysql_error());
}
}

?>
</body>
</html>
