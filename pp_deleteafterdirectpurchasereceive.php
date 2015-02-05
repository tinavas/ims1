<?php
include "config.php";
$id=$_GET['id'];

//Updating the Stock
$i = 0;
$flag=0;
$query1 = "SELECT * FROM pp_sobi WHERE so = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
$crqty=$drqty=$crqty1=$drqty1=0;
$q1=mysql_query("select iac from ims_itemcodes where code='$rows1[code]'",$conn) or die(mysql_error());
$r1=mysql_fetch_array($q1);


 $q2=mysql_query("select sum(quantity) as qty,crdr from ac_financialpostings where date <='$rows1[date]' and trnum not like '$rows1[so]' and coacode='$r1[iac]' and itemcode='$rows1[code]' and warehouse='$rows1[warehouse]' group by crdr",$conn) or die(mysql_error()) ;
while($r2=mysql_fetch_array($q2))
{

if($r2[crdr]=='Cr')
$crqty=$r2[qty];
if($r2[crdr]=='Dr')
$drqty=$r2[qty];

}

$q3=mysql_query("select sum(quantity) as qty,crdr from ac_financialpostings where coacode='$r1[iac]' and trnum not like '$rows1[so]' and itemcode='$rows1[code]' and warehouse='$rows1[warehouse]' group by crdr",$conn) or die(mysql_error()) ;
while($r3=mysql_fetch_array($q3))
{

if($r3[crdr]=='Cr')
$crqty1=$r3[qty];
if($r3[crdr]=='Dr')
$drqty1=$r3[qty];

}

if(($drqty-$crqty)<0 || ($drqty1-$crqty1)<0 )
{
$flag=1;
}
else
{

}
}
if($flag==0)
{
$get_entriess = "DELETE FROM pp_sobi WHERE so = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$q1q = "delete from ac_financialpostings where trnum = '$id' and type = 'SOBI' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());

$q1q = "delete from pp_purchasereceive where invoice = '$id'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
}
else
{
echo "<script type='text/javascript'>";
	echo "alert('if You Delete This, Stock Issues Will Come');";
echo "</script>";
}
echo "<script type='text/javascript'>";
	echo "document.location = 'dashboardsub.php?page=pp_directpurchase';";
echo "</script>";
?>


