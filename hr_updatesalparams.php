<?php 

include "config.php";

$client = $_SESSION['client'];

$id = $_POST['oldid'];

$code = $_POST['code'];

$description = $_POST['description'];

$unit = $_POST['unittd'];

$based = $_POST['based'];

$default = $_POST['default'];

$incex = $_POST['incex'];
$coa=$_POST['coa'];
if($default == "")

{

$default =0;

}

if($based == "Others")

{

$params = "";

for($i=0;$i<count($_POST['paramcode']);$i++)

{

 $params = $params . $_POST['paramcode'][$i] . ",";

}

$formula =  $_POST['formula'];

}



$q = "update hr_params set code='$code',description = '$description',unit = '$unit',basis = '$based', defaultval = '$default',params = '$params',formula = '$formula', type='$incex', coa='$coa' where id='$id'";

$qrs = mysql_query($q,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=hr_salparams'";

echo "</script>";

?>