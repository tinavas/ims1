<?php

mysql_query("set group_concat_max_len=10000000000");

 $q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd,concat(\"'\",group_concat(code separator \"','\"),\"'\") as allcodes FROM `ims_itemcodes` where source like '%Produced%' and code in (select distinct producttype from product_formula) and cat!='Pouches' group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd'],"allcodes"=>$r1['allcodes']);



}

$q1="SELECT cat,group_concat(code,'$',description,'$',sunits separator '*') as cd,concat(\"'\",group_concat(code separator \"','\"),\"'\") as allcodes FROM `ims_itemcodes` where  cat='Pouches' group by cat";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{
$allcodes[]=array("cat"=>$r1['cat'],"cd"=>$r1['cd'],"allcodes"=>$r1['allcodes']);


}




$allcodesj=json_encode($allcodes);


?>