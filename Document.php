
<?php 
include "config.php" ;
 $q="select distinct(invoice) from oc_cobi where date >= '2012-07-01' and code like 'HE%' " ;
$r= mysql_query($q);
$i=-1;
 while($a=mysql_fetch_array($r))
 $array[++$i]= $a[invoice];
 $i=-1;
 while(count($array)>$i+1) 
 {
 echo '<br><br><br>';
 echo $q="delete from ac_financialpostings where date >= '2012-07-01' and trnum='".$array[++$i]."' and type='COBI' and itemcode IN ('CONS162','CONS142') "; echo '<br>';
   mysql_query($q) or die(mysql_error());
  $q="select date,party as vendor,warehouse,quantity from oc_cobi where invoice='".$array[$i]."' and date >= '2012-07-01' and code like 'HE%' " ;
   
     $r= mysql_query($q);
	 while($a=mysql_fetch_array($r))
	 {
	 //echo ceil($a[quantity]/210).' ';
	 $temp = ceil($a[quantity]/30) + 3;
	 echo $q="INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$a['date']."','CONS162','Cr','IT115','".ceil($a[quantity]/210)."','0','".$array[$i]."','COBI','".$a[vendor]."','".$a[warehouse]."')";
			  mysql_query($q) or die(mysql_error());;
	 echo $q="INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$a['date']."','CONS142','Cr','IT115','$temp','0','".$array[$i]."','COBI','".$a[vendor]."','".$a[warehouse]."')";
			  mysql_query($q) or die(mysql_error());;
	  echo '<br>';
   }
 }
?>
