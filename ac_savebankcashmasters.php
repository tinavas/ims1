<?php
include "config.php";
$mode = $_POST['mode'];
$code = strtoupper($_POST['code']);
$name = ucwords($_POST['name']);
$sector = $_POST['sector'];
$coacode=$_POST['coa'];

$flag = '0';
if($_POST['mode'] == 'Cash')
{
session_start();

 $q = "INSERT INTO ac_bankcashcodes (mode,code,name,flag,sector) VALUES ('$mode','$code','$name','$flag','$sector')";
}
else
{
$micr = $_POST['micr'];
$address = ucwords($_POST['address']);
$email = $_POST['email'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$acno=$_POST['acno'];
$person = ucwords($_POST['person']);
session_start();

$q = "INSERT INTO ac_bankcashcodes (mode,code,name,micr,address,email,phone,fax,person,flag,sector) VALUES ('$mode','$code','$name','$micr','$address','$email','$phone','$fax','$person','$flag','$sector')";
}
 $get_entriess_res1 = mysql_query($q,$conn) or die(mysql_error());

//echo "document.getElementById('myIframe').src = ''";





$flag = '0';
$tflag = '0';
$rflag = '0';


$query1 = "select * from ac_bankcashcodes where code = '$code'";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
 $name = $row1['name'];
 $micr = $row1['micr'];
 $address = $row1['address'];
 $email = $row1['email'];
 $phone = $row1['phone'];
}


if($_POST['mode'] == 'Cash')
{
$q = "INSERT INTO ac_bankmasters (mode,code,name,coacode,flag,tflag,rflag,acno) VALUES ('$mode','$code','$name','$coacode','$flag','$tflag','$rflag','$code')";
}
else
{
$acno = $_POST['acno'];
$q = "INSERT INTO ac_bankmasters (mode,code,name,coacode,acno,micr,address,email,phone,flag,tflag,rflag) VALUES ('$mode','$code','$name','$coacode','$acno','$micr','$address','$email','$phone','$flag','$tflag','$rflag')";
}
 $get_entriess_res1 = mysql_query($q,$conn) or die(mysql_error());


$query2="UPDATE ac_coa set flag = '1' WHERE code = '$coacode'" or die(mysql_error());
$result2 = mysql_query($query2,$conn) or die(mysql_error());


$query3="UPDATE ac_bankcashcodes set flag = '1' WHERE code = '$code'" or die(mysql_error());
$result3 = mysql_query($query3,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "parent.location = 'dashboardsub.php?page=ac_bankcashmasters';";
echo "</script>";

?>