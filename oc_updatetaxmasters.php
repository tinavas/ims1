<?php 
include "config.php";

$id = $_POST['id'];


$code = $_POST['code'];
$description = $_POST['description'];
$rule = $_POST['rule'];
$coa = $_POST['coa'];
$basic = $_POST['basic'];
$codevalue = $_POST['codevalue'];
$formula = $_POST['formula'];

 $mode=$_REQUEST['opt'];
 
 
  $query = "UPDATE ims_taxcodes set code='$code',description='$description',rule='$rule',coa='$coa',basic='$basic',codevalue='$codevalue',formula='$formula',taxflag='S',mode='$mode' where id='$id'";
 

$result = mysql_query($query,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_taxmasters'";
echo "</script>";
?>

