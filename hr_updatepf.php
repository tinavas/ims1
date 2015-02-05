<?php 

include "config.php";

session_start();

$client = $_SESSION['client']; 

$id = $_POST['oldid'];

$salfrom = $_POST['salfrom0'];

$salto = $_POST['salto0'];

$tax = $_POST['tax0'];
$coa=$_POST['coa'];


$query = "select count(*) as count from hr_pf where salfrom <= '$salfrom' and salto >='$salfrom' and id!='$id' ";

$result = mysql_query($query);

while($rfrm = mysql_fetch_assoc($result))

{

 $cfrom = $rfrm['count'];

}

$query = "select count(*) as count from hr_pf where salfrom <= '$salto' and salto >='$salto'  and id!='$id'";

$result = mysql_query($query);

while($rto = mysql_fetch_assoc($result))

{

 $cto = $rto['count'];

}



if(($cfrom == "0") &&($cto == "0"))

{

$q = "update hr_pf set salfrom = '$salfrom',salto = '$salto',tax ='$tax',coa='$coa' where id='$id' and  client='$client'";

$r = mysql_query($q,$conn);

}

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=hr_pf';";

echo "</script>";



?>