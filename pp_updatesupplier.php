<?php
include "config.php";
$id=$_POST['id'];
$name = strtoupper($_POST['name']);
$cterm =  $_POST['cterm'];
$code=$_POST['vpcode'];
$temp = explode("@",$_POST['vgroup']);
   $vgroup = $temp[0];
   $va = $temp[1];
   $vppa = $temp[2];
if($_POST['type'] == 'vendor and party')
{
   $temp = explode("@",$_POST['cgroup']);
   $cgroup = $temp[0];
   $ca = $temp[1];
   $cppa = $temp[2];
}

if($_SESSION['db']=="naidu")
   {
   	
   $check=$_POST['check'];
   if($check=="")
   {
   	$check="not checked";
   }
   }

$getName="select name from contactdetails where id='$id'";
$getName_result=mysql_query($getName,$conn) or die(mysql_error());
$getName_rows=mysql_fetch_array($getName_result);
$oldName=$getName_rows['name'];
if($oldName <> $name) {
$query1="UPDATE ac_financialpostings SET venname = '".$name."' WHERE venname = '".$oldName."'";
$result1=mysql_query($query1,$conn) or die(mysql_error());

$query2="UPDATE ac_crdrnote SET vcode = '".$name."' WHERE vcode = '".$oldName."'";
$result2=mysql_query($query2,$conn) or die(mysql_error());

$query3="UPDATE pp_sobi SET vendor = '".$name."' WHERE vendor = '".$oldName."'";
$result3=mysql_query($query3,$conn) or die(mysql_error());

$query4="UPDATE pp_receipt SET vendor = '".$name."' WHERE vendor = '".$oldName."'";
$result4=mysql_query($query4,$conn) or die(mysql_error());

$query5="UPDATE pp_payment SET vendor = '".$name."' WHERE vendor = '".$oldName."'";
$result5=mysql_query($query5,$conn) or die(mysql_error());
}
 
if($_SESSION['db'] == 'naidu')
{
 $query_update="update contactdetails set  code='".$code."',cterm='".$cterm."',name='".$name."',address = '".$_POST['address']."',phone ='".$_POST['phone']."',mobile ='".$_POST['mobile']."',type ='".$_POST['type']."',note ='".$_POST['note']."',place ='".$_POST['place']."',pan ='".$_POST['pan']."',vgroup ='".$vgroup."',va ='".$va."',vppa ='".$vppa."',cgroup ='".$cgroup."',ca ='".$ca."',cac ='".$cppa."',custom ='$check' where id='".$id."'";
$query_result=mysql_query($query_update,$conn) or die(mysql_error());
	
}
else {
	$query_update="update contactdetails set  code='".$code."',cterm='".$cterm."',name='".$name."',address = '".$_POST['address']."',phone ='".$_POST['phone']."',mobile ='".$_POST['mobile']."',type ='".$_POST['type']."',note ='".$_POST['note']."',place ='".$_POST['place']."',pan ='".$_POST['pan']."',vgroup ='".$vgroup."',va ='".$va."',vppa ='".$vppa."',cgroup ='".$cgroup."',ca ='".$ca."',cac ='".$cppa."' where id='".$id."'";
$query_result=mysql_query($query_update,$conn) or die(mysql_error());
	
}
header('Location:dashboardsub.php?page=pp_supplier');
?>

