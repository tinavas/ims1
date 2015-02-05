<?php 
include "config.php";
//echo $_POST[vname];
$codevendor=explode('#',$_POST[vname]); 
$code=explode('@',substr($codevendor[0],0,-1));
$i=0;
while(count($code)>$i)
{
$query="select category,code,unit,description,rateperunit,quantity from pp_purchaseorder where vendor='".$codevendor[1]."' and code='".$code[$i]."' order by date desc limit 0,1";
$result=mysql_query($query) or die(mysql_error());
if($a=mysql_fetch_assoc($result)) {
$data.=$a[category].'#'.$a[code].'#'.$a[description].'#'.$a[quantity].'#'.$a[rateperunit];
$data.='@'; }
$i++;
}
echo substr($data,0,-1);
?>