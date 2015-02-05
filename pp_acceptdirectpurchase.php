<?php 
include "config.php";
print_r($_POST);
$sobi=$_POST[sobi];
$rdt=date('Y-m-d',strtotime($_POST[date]));
$code='';
$des='';
 $qa1="select * from pp_sobi where so='$sobi'";
 $qa=mysql_query($qa1,$conn) or die(mysql_error());
while($ra=mysql_fetch_array($qa))
{
$code=$code.$ra[code]."/";
 $des=$des.$ra[description]."/";
 $warehouse=$ra[warehouse];
 $vendor=$ra[vendor];
 $invdate=$ra[date];
 $inv=$ra[so];
 $tqty=$ra[totalquantity];
 
 $ia=mysql_query("select iac from ims_itemcodes where code='$ra[code]' ",$conn) or die(mysql_error());
 $rr=mysql_fetch_array($ia);
 
echo $q= "insert into ac_financialpostings(`date` ,itemcode,crdr,quantity,amount,coacode,trnum,type,venname,warehouse)  select '$rdt', '$ra[code]','Dr',quantity,amount,'$rr[iac]',trnum,type,venname,warehouse from ac_financialpostings where trnum='$sobi' and coacode='PTR01' and itemcode='$ra[code]'";
 echo  mysql_query($q,$conn) or die(mysql_error());
}
echo $q1="insert into pp_purchasereceive(recdate,invoice,invdate,vendor,warehouse,code,description,totalquantity) values('$rdt','$inv','$invdate','$vendor','$warehouse','$code','$des','$tqty')";
echo  mysql_query($q1,$conn) or die(mysql_error());
 echo $q3= "insert into ac_financialpostings(`date` ,crdr,amount,coacode,trnum,type,venname,warehouse) select '$rdt', 'Cr',sum(amount),coacode,trnum,type,venname,warehouse from ac_financialpostings where trnum='$sobi' and coacode='PTR01'";
echo mysql_query($q3,$conn) or die(mysql_error());
echo $q2="update pp_sobi set receiveflag='1' , recdate='$rdt' where so='$sobi'";
echo mysql_query($q2,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase'";
echo "</script>";
?>