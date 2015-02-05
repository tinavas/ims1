<?php 

include "config.php";

$client = $_SESSION['client'];

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



 $q = "insert into hr_params (code,description,unit,basis,defaultval,params,formula,type,coa,client) values('$code','$description','$unit','$based','$default','$params','$formula','$incex','$coa','$client')";

$qrs = mysql_query($q,$conn) or die(mysql_error());



echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=hr_salparams'";

echo "</script>";

?>