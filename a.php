
var d= document.getElementById("date").value;
var loc=document.getElementById("location").value;
<?php
$flag=0;
for($n=0;$n<count($cn);$n++)
{ 

$co="";
$co= $cn[$n];
for($l=0;$l<count($c);$l++)
{
echo $flag;
$n1=0;
$qq="select * from packing_packingcost where '$d1' between fromdate and todate and code='$c[$l]' and contractor='$co'";
$q=mysql_query($qq,$conn) or die(mysql_error());
 $n1=mysql_num_rows($q);
?>
<?php 
if($n1<=0 || $n1==" ")
{
 $flag=1;
break;
}
}
if($flag==1)
{
echo $flag;
echo "alert('Packing Cost Not entered');";
echo "document.location='dashboardsub.php?page=packing_adddailypacking1';";
}
}
?>
<?php if($flag==0){?>
document.location="dashboardsub.php?page=packing_adddailypacking1&dt="+d+"&loc="+loc;
<?php }?>
