<?php 
function cashcheck($code,$amount,$crdr)
{
include "config.php";
$q1=mysql_query("select group_concat(distinct code separator '*') as code from ac_coa where controltype in ('Cash','Bank')",$conn) or die(mysql_error());
$r1=mysql_fetch_array($q1);
$codes=explode("*",$r1['code']);


if(in_array($code,$codes))
{
 $q2="select sum(amount) as amount,coacode from ac_financialpostings where coacode='$code' and crdr='Dr' group by coacode";
$q2=mysql_query($q2,$conn) or die(mysql_error());
$r2=mysql_fetch_array($q2);

$q3="select sum(amount) as amount,coacode from ac_financialpostings where coacode='$code' and crdr='Cr' group by coacode";
$q3=mysql_query($q3,$conn) or die(mysql_error());
$r3=mysql_fetch_array($q3);

 $crdramt= intval($r2[amount])-intval($r3[amount]);
 //echo "<br>";
// echo $amount;
if($crdr=='Cr')
$cdamt= ($crdramt-$amount);
if($crdr=='Dr')
$cdamt= ($crdramt+$amount);

if(intval($cdamt)<0)
return 1;
else
return 0;
}
}
?>