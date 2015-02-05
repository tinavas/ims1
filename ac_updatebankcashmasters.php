<?php
include "config.php";
$id=$_POST['id'];
$flag=$_POST['flag'];
$mode = $_POST['mode'];
$code = strtoupper($_POST['code']);
$name = ucwords($_POST['name']);
$micr = $_POST['micr'];
$address = ucwords($_POST['address']);
$email = $_POST['email'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$sector = $_POST['sector'];

$person = ucwords($_POST['person']);
$coacode=$_POST['coa'];
$acno=$_POST['acno'];

session_start();

$q="select * from ac_bankcashcodes where id='$id'";

$r=mysql_query($q,$conn);
while($row=mysql_fetch_array($r))
{
$oldcode=$row['code'];


}

if($flag == "1")
{
 $get_entriess = "UPDATE ac_bankcashcodes SET name = '$name',micr = '$micr',address='$address',email='$email',phone = '$phone',fax = '$fax',person = '$person',sector = '$sector' WHERE id = '$id' LIMIT 1  ;";     
 $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
}
else
{
 $get_entriess = "UPDATE ac_bankcashcodes SET code = '$code', name = '$name',micr = '$micr',address='$address',email='$email',phone = '$phone',fax = '$fax',person = '$person',sector = '$sector' WHERE id = '$id' LIMIT 1  ;";     
 $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
}


if($mode=="Bank")
{
$get_entriess = "UPDATE ac_bankmasters SET code = '$code', name = '$name',micr = '$micr',address='$address',email='$email',phone = '$phone',fax = '$fax',coacode='$coacode',acno='$acno' WHERE code = '$oldcode' LIMIT 1  ;";  
}

else {

$get_entriess = "UPDATE ac_bankmasters SET code = '$code', name = '$name',micr = '$micr',address='$address',email='$email',phone = '$phone',fax = '$fax',coacode='$coacode',acno='$code' WHERE code = '$oldcode' LIMIT 1  ;"; 
}   
 $get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ac_bankcashmasters';";
echo "</script>";


?>