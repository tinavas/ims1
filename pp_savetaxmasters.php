<?php 
include "config.php";

$type = $_POST['type'];

$code = $_POST['code'];
$code=strtoupper($code);
$description = $_POST['description'];
$rule = $_POST['rule'];
$coa = $_POST['coa'];
$basic = $_POST['basic'];
$codevalue = $_POST['codevalue'];
$formula = $_POST['formula'];
 $mode=$_POST['opt'];
 

 

$q = "insert into ims_taxcodes (type,code,description,rule,coa,basic,codevalue,formula,taxflag,mode) values('$type','$code','$description','$rule','$coa','$basic','$codevalue','$formula','P','$mode')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_taxmasters'";
echo "</script>";
?>