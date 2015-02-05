<?php

$conn=mysql_connect("localhost","root","") or die(mysql_error());
$db=mysql_select_db("central");

$q10=mysql_query("set group_concat_max_len=1000000000");
$q1="select distinct cat,code,sac from ims_itemcodes where iusage in ('Produced or Sale','Sale') order by cat";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
//echo "sdfds";
$q3="select sum(amount) as amount1 from ac_financialpostings where coacode='$r1[sac]' and crdr='Cr' and itemcode='$r1[code]' ";
$q3=mysql_query($q3) or die(mysql_error());
$r3=mysql_fetch_assoc($q3);

//$catall[$r1['cat']][$r1['code']]=$r3['amount1'];
$catall[$r1['cat']]=$catall[$r1['cat']]+$r3['amount1'];
}
//print_r($catall);
array_sum($catall);


for($i=0;$i<9;$i++)
{
$per=(round(($itemval[$itemcode[$i]]/$totsum)*100,6));
if($per>0)
{
$first[]=array("code"=>$itemcode[$i],"per"=>$per,"amount"=>$itemval[$itemcode[$i]]);
}
}

for($i=count($itemcode);$i>=9;$i--)
{
//$per=(round(($itemval[$itemcode[$i]]/$totsum)*100,6));
//$second[]=array("code"=>$itemcode[$i],"per"=>$per,"amount"=>$itemval[$itemcode[$i]]);
$otherssum=$otherssum+$itemval[$itemcode[$i]];
}

$othersper=(round(($otherssum/$totsum)*100,6));










?>