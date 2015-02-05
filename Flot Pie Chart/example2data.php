<?php

//procudure to create and call
/*
delimiter $$
create procedure getallsalesamount(out saleamount varchar(100))
begin
declare b int(100);
declare k int(100);
declare allamount varchar(100);
declare code1,coa1 varchar(100);
declare amount1 varchar(100);
declare c1 cursor for select `code`,sac from ims_itemcodes where iusage in ('Produced or Sale','Sale');
select count(code) into b  from ims_itemcodes where iusage in ('Produced or Sale','Sale');
set allamount=0;
set k=0;
OPEN c1;
REPEAT
FETCH c1 INTO code1,coa1;
select sum(amount) into amount1 from ac_financialpostings where coacode=coa1 and crdr='Cr' and itemcode=code1;
if amount1 is null then
set amount1=0;
end if;
set allamount=allamount+amount1;
set k=k+1;
UNTIL b = k
END REPEAT;
set saleamount=allamount;
end
$$

*/





$conn=mysql_connect("localhost","root","") or die(mysql_error());
$db=mysql_select_db("central");

/*//$sacsum=0;
$q1="select distinct sac from ims_itemcodes  where iusage in ('Produced or Sale','Sale')";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$q2="select sum(amount) as amount from ac_financialpostings where coacode='$r1[sac]' and crdr='Cr' ";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
$sacsum=$sacsum+$r2['amount'];
}
echo $sacsum;
*/
$totsum=0;
$q1=mysql_query("call getallsalesamount(@val)") or die(mysql_error());
$q1=mysql_query("select @val as value") or die(mysql_error());
$r1=mysql_fetch_row($q1);
$totsum=$r1[0];


echo $totsum,"<br/>";

$beefsum=0;
$q1=mysql_query("select  * from ims_itemcodes where iusage in ('Produced or Sale','Sale') and cat='Beef'") or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$amount=0;
$code=$r1['code'];
$coacode=$r1['sac'];
$q2="select sum(amount) as amount from ac_financialpostings where coacode='$coacode' and crdr='Cr' and itemcode='$code'";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
if($r2['amount']>=0 && $r2['amount']!="")
{
$item[]=array("code"=>$code,"amount"=>$r2['amount']);
$itemcode[]=$code;
$itemval[$code]=$r2['amount'];
}
//$itemsum[]=$r2['amount'];
//echo $code,"-",$r2['amount'],"<br/>";
$beefsum=$beefsum+$r2['amount'];
}

echo $beefsum,"</br>";

//echo array_sum($itemsum),"</br>";

/*$beefsum1=0;
$q1=mysql_query("select  * from ims_itemcodes where iusage in ('Produced or Sale','Sale') and cat!='Beef'") or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$amount=0;
$code=$r1['code'];
$coacode=$r1['sac'];
$q2="select sum(amount) as amount from ac_financialpostings where coacode='$coacode' and crdr='Cr' and itemcode='$code'";
$q2=mysql_query($q2) or die(mysql_error());
$r2=mysql_fetch_assoc($q2);
$item[]=array("code"=>$code,"amount"=>$r2['amount']);
//echo $code,"-",$r2['amount'],"<br/>";
$beefsum1=$beefsum1+$r2['amount'];
}

echo $beefsum1,"</br>";*/
//print_r(($itemval));
$val2=arsort($itemval);
//print_r(($val2));
foreach($itemval as $k=>$val)
{

echo $k."=>".$val,"</br>";
}





// Obtain a list of columns
/*foreach ($item as $key => $row) {
    $volume[$key]  = $row['code'];
    $edition[$key] = $row['amount'];
}

// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
$array=array_multisort($volume, SORT_DESC, $edition, SORT_DESC, $item);
print_r($array);*/




for($i=0;$i<count($item);$i++)
{
//echo $totsum;
//echo $item[$i]['code'],"-",(round(($item[$i]['amount']/$totsum)*100,2)),"<br/>";
//echo (round(($item[$i]['amount']/$totsum)*100,3)),"<br/>";
$persum=$persum+(round(($item[$i]['amount']/$totsum)*100,3));

}

echo $persum,"<br/>";
echo $others=round(100-$persum,2),"<br/>";




?>
