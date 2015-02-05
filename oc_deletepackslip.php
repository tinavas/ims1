<?php
include "config.php";
 $ps1 = $_GET['ps'];
 
if ($_SESSION[db]=='alkhumasiyabrd') 
{
$query="SELECT eggreceiveddate,quantity,flock,itemcode FROM `oc_packslip` WHERE `ps` LIKE '$ps1'";
$result=mysql_query($query);
while($array=mysql_fetch_array($result))
{
 if($array['itemcode'] == 'BROC101')
 $query4="update hatchery_hatchrecord set availableqty=availableqty+$array[quantity] where hatchdate='".$array['eggreceiveddate']."' and flock='$array[flock]' LIMIT 1";
 else 
 $query4="update ims_eggreceiving set availableeggs=availableeggs+$array[quantity] where date='".$array['eggreceiveddate']."' and flock='$array[flock]' and tocode in (select code from ims_itemcodes where cat='hatch eggs')";
 mysql_query($query4,$conn) or die(mysql_error());
}
}

 $query = "SELECT itemcode,quantity FROM oc_packslip WHERE ps='$ps1' ORDER BY itemcode";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
  $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[quantity] WHERE code = '$rows[itemcode]' AND po= (SELECT po FROM oc_packslip WHERE ps = '$ps1' LIMIT 1)";
   mysql_query($query1,$conn) or die(mysql_error());
 }

$query = "SELECT id FROM oc_packslip WHERE so = (SELECT so FROM oc_packslip WHERE ps = '$ps1' LIMIT 1)";
$result = mysql_query($query,$conn) or die(mysql_error());
if(! mysql_num_rows($result))
{
 $q = "update oc_salesorder set psflag = '0',sentquantity = 0 where po = (SELECT so FROM oc_packslip WHERE ps = '$ps1' LIMIT 1)";
 $qrs = mysql_query($q,$conn) or die(mysql_error());
} 
 
 $query = "DELETE FROM oc_packslip WHERE ps = '$ps1'";
 mysql_query($query,$conn) or die(mysql_error());
 $query = "DELETE FROM ac_financialpostings WHERE trnum = '$ps1' AND type = 'PS'";
 mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_packslip'";
echo "</script>";

?>