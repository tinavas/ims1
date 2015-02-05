<?php 

include "config.php";

session_start();

$client = $_SESSION['client']; 

for ($i = 0; $i < count($_POST['tax']); $i++)

{

if($_POST['salfrom'][$i] != "" && $_POST['coa'][$i] != "")

{

$salfrom = $_POST['salfrom'][$i];

$salto = $_POST['salto'][$i];

$tax = $_POST['tax'][$i];
$coa=$_POST['coa'][$i];
$q = "insert into hr_pf (salfrom,salto,tax,coa,client) values('".$salfrom."','".$salto."','".$tax."','". $coa ."','".$client."')";

$r = mysql_query($q,$conn);

}

}

echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=hr_pf';";

echo "</script>";



?>