<?php
include "config.php";
$id=$_POST['id'];
$name = strtoupper($_POST['name']);
$cterm = $_POST['cterm'];
$climit = $_POST['climit'];
$code=$_POST['vpcode'];
if($climit == "") $climit = 0;
$customercategory = $_POST['category'];
$temp = explode("@",$_POST['vgroup']);
   $vgroup = $temp[0];
   $va = $temp[1];
   $vppa = $temp[2];
$temp = explode("@",$_POST['cgroup']);
   $cgroup = $temp[0];
   $ca = $temp[1];
   $cac = $temp[2];

$getName="select name from contactdetails where id='$id'";
$getName_result=mysql_query($getName,$conn) or die(mysql_error());
$getName_rows=mysql_fetch_array($getName_result);
$oldName=$getName_rows['name'];
if($oldName <> $name) {
$query1="UPDATE ac_financialpostings SET venname = '".$name."' WHERE venname = '".$oldName."'";
$result1=mysql_query($query1,$conn) or die(mysql_error());

$query2="UPDATE ac_crdrnote SET vcode = '".$name."' WHERE vcode = '".$oldName."'";
$result2=mysql_query($query2,$conn) or die(mysql_error());

$query3="UPDATE oc_cobi SET party = '".$name."' WHERE party = '".$oldName."'";
$result3=mysql_query($query3,$conn) or die(mysql_error());

$query4="UPDATE oc_receipt SET party = '".$name."' WHERE party = '".$oldName."'";
$result4=mysql_query($query4,$conn) or die(mysql_error());

$query5="UPDATE oc_payment SET party = '".$name."' WHERE party = '".$oldName."'";
$result5=mysql_query($query5,$conn) or die(mysql_error());
}
 
$query_update="update contactdetails set code='".$code."', name='".$name."',address = '".$_POST['address']."',phone ='".$_POST['phone']."',mobile ='".$_POST['mobile']."',type ='".$_POST['type']."',note ='".$_POST['note']."',place ='".$_POST['place']."',pan ='".$_POST['pan']."',vgroup ='".$vgroup."',va ='".$va."',vppa ='".$vppa."',cgroup ='".$cgroup."',ca ='".$ca."',cac ='".$cac."',cterm='$cterm',climit='$climit' where id='".$id."'";

//This is for singh client only-------
if($_SESSION['db']=="singhsatrang")
{
if(isset($_POST['stockist']))
{
$state=$_POST['state'];
$superstockist="YES";
}
else
{
$state="";
$superstockist="NO";
}

 $query_update="update contactdetails set code='".$code."', name='".$name."',address = '".$_POST['address']."',phone ='".$_POST['phone']."',mobile ='".$_POST['mobile']."',type ='".$_POST['type']."',note ='".$_POST['note']."',place ='".$_POST['place']."',pan ='".$_POST['pan']."',vgroup ='".$vgroup."',va ='".$va."',vppa ='".$vppa."',cgroup ='".$cgroup."',ca ='".$ca."',cac ='".$cac."',cterm='$cterm',climit='$climit',superstockist='$superstockist',state='$state' where id='".$id."'";

}
//--------------------------------------

$query_result=mysql_query($query_update,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=oc_customer');
?>

