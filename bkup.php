
<?php
 include "config.php";

$dt=$_POST['dt'];

// ....................................................................... non iac Coa Accounts........................................................................................
		 echo $qq="select sum(amount) as amount,sum(quantity) as quantity,crdr,coacode,warehouse from ac_financialpostings where warehouse!=''  and warehouse is not null and coacode not in (select  distinct iac from ims_itemcodes) and  date <='$dt' group by coacode,crdr,warehouse order by warehouse,coacode";
	  $q1=mysql_query($qq,$conn);
	  while($r1=mysql_fetch_array($q1))
	  {
	  if($r1[crdr]=='Cr')
	  {
	 $arr[$r1[coacode]][quantity][cr][$r1[warehouse]]=$r1[quantity];
	 $arr[$r1[coacode]][amount][cr][$r1[warehouse]]=$r1[amount];
	  }
	  else
	  {
	  $arr[$r1[coacode]][quantity][dr][$r1[warehouse]]=$r1[quantity];
	 $arr[$r1[coacode]][amount][dr][$r1[warehouse]]=$r1[amount];
	  }
	  //echo "<br>";
	  }
	  
	  // .......................................................................  iac Coa Accounts(need Item Wise Details)........................................................................................

	  		 echo $qq="select sum(amount) as amount,sum(quantity) as quantity,crdr,coacode,warehouse,itemcode from ac_financialpostings where warehouse!=''  and warehouse is not null and coacode in (select  distinct iac from ims_itemcodes) and  date <='$dt' group by coacode,crdr,warehouse,itemcode order by warehouse,coacode,itemcode";
	  $q1=mysql_query($qq,$conn);
	  while($r1=mysql_fetch_array($q1))
	  {
	  if($r1[crdr]=='Cr')
	  {
	 $arr1[$r1[coacode]][quantity][cr][$r1[warehouse]][$r1[itemcode]]=$r1[quantity];
	 $arr1[$r1[coacode]][amount][cr][$r1[warehouse]][$r1[itemcode]]=$r1[amount];
	  }
	  else
	  {
	  $arr1[$r1[coacode]][quantity][dr][$r1[warehouse]][$r1[itemcode]]=$r1[quantity];
	 $arr1[$r1[coacode]][amount][dr][$r1[warehouse]][$r1[itemcode]]=$r1[amount];
	  }
	  //echo "<br>";
	  }


		  
		   $q2=mysql_query("select distinct warehouse as wh,coacode as code,itemcode from ac_financialpostings where warehouse!='' and warehouse is not null and coacode in (select  distinct iac from ims_itemcodes) group by warehouse,coacode,itemcode order by warehouse,coacode,itemcode");
	  echo mysql_num_rows($q2);
	  while($r2=mysql_fetch_array($q2))
	  {
$qq=mysql_query("select schedule as s from ac_coa where code=''$r2[code']");
while($qr=mysql_fetch_array($qq))
{
$schedule=$qr['s'];
}
	  //$ab[]=array("code"=>$r2['code'],"val"=>$arr[$r2[code]][quantity][dr][$r2[wh]]-$arr[$r2[code]][quantity][cr][$r2[wh]]);
	  // $abc[]=array("code"=>$r2['code'],"val"=>$arr[$r2[code]][amount][dr][$r2[wh]]-$arr[$r2[code]][amount][cr][$r2[wh]]);
// Forwarding Balance to Nxt Date of Closing...................................................
	     
		 $dt1=mysql_query("select date_add($dt interval 1 day) as date");
		 $ddt=mysql_fetch_array($dt1);

$q1="insert into ac_financialpostings (`date`, `itemcode`, `crdr`, `coacode`, `quantity`, `amount`, `trnum`, `type`, `warehouse`, `schedule`) values('$ddt[date]','$r2[itemcode]','$crdr','$r2[code]','$qty','$amt','Initial','Initial','','$r2[wh]','$schedule')";
		 
	   	  }

		  
/*$q1=mysql_query("delete from ac_crdrnote where date<='$dt'");
$q1=mysql_query("delete from ac_financialpostings where date<='$dt'");
$q1=mysql_query("delete from deletelog where date<='$dt'");
$q1=mysql_query("delete from ims_initialstock where date<='$dt'");
$q1=mysql_query("delete from ims_intermediatereceipt where date<='$dt'");
$q1=mysql_query("delete from ims_stock where date<='$dt'");
$q1=mysql_query("delete from ims_stockadjustment where date<='$dt'");
$q1=mysql_query("delete from ims_stocktransfer where date<='$dt'");
$q1=mysql_query("delete from ims_stockreceive where date<='$dt'");
$q1=mysql_query("delete from oc_cobi where date<='$dt'");
$q1=mysql_query("delete from oc_cobiclearance where date<='$dt'");
$q1=mysql_query("delete from oc_discounts where date<='$dt'");
$q1=mysql_query("delete from oc_packslip where date<='$dt'");
$q1=mysql_query("delete from oc_payment where date<='$dt'");
$q1=mysql_query("delete from oc_pricemaster where date<='$dt'");
$q1=mysql_query("delete from oc_receipt where date<='$dt'");
$q1=mysql_query("delete from oc_salesorder where date<='$dt'");
$q1=mysql_query("delete from oc_salesreturn where date<='$dt'");
$q1=mysql_query("delete from pp_gateentry where date<='$dt'");
$q1=mysql_query("delete from pp_goodsreceipt where date<='$dt'");
$q1=mysql_query("delete from pp_payment where date<='$dt'");
$q1=mysql_query("delete from pp_purchaseindent where date<='$dt'");
$q1=mysql_query("delete from pp_purchaseorder where date<='$dt'");
$q1=mysql_query("delete from pp_purchasereceive where date<='$dt'");
$q1=mysql_query("delete from pp_purchasereturn where date<='$dt'");
$q1=mysql_query("delete from pp-receipt where date<='$dt'");
$q1=mysql_query("delete from pp_sobi where date<='$dt'");
$q1=mysql_query("delete from product_fformula where date<='$dt'");
$q1=mysql_query("delete from product_formula where date<='$dt'");
$q1=mysql_query("delete from product_itemwise where date<='$dt'");
$q1=mysql_query("delete from product_productionunit where date<='$dt'");*/


$username = $db_user; 
$password =  $db_pass; 
$hostname =  $db_host; 
$dbname   =  $db_name;
 
// if mysqldump is on the system path you do not need to specify the full path
// simply use "mysqldump --add-drop-table ..." in this case
$dumpfname = $dbname . "_" . date("Y-m-d_H-i-s").".sql";

$q1="SHOW VARIABLES LIKE 'basedir'";
$q1=mysql_query($q1);
$r1=mysql_fetch_row($q1);
 $wamp=$r1[1]."/bin";
 
 $wamp=str_replace("//","/",$wamp);
 
 $file_data="";
 $file_data .= "cd $wamp".PHP_EOL;
echo $file_data .= "mysqldump -h $host --user=$username --password=\"$password\"  --routines $dbname  >\"$dumpfname\"";
 $fp = fopen("mysqlbackup.bat","w");
if(! $fp)
 echo "<br>File Not Opened<br>";
fwrite ($fp,$file_data);
fclose ($fp);
if(!file_exists($path))
{
exec("mysqlbackup.bat");
}



echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=closingtrs'";
echo "</script>";
?>