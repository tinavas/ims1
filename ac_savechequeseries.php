<?php
include "config.php";
$acno = $_POST['acno'];
$flag = '0';
$tflag = '0';
$query = "select * from ac_bankmasters where acno = '$acno' AND mode = 'Bank'";
$resultb = mysql_query($query,$conn);
while($rowc = mysql_fetch_assoc($resultb))
{
 $name = $rowc['name'];
 $code = $rowc['code'];
 $micr = $rowc['micr'];
}


 $query="INSERT INTO ac_chequeseries(bankcode,clen,chls,schls,start,rchls,echls,name,acno,micr,flag,tflag)
 VALUES ('".$code."','".$_POST['clen']."','".$_POST['chls']."','".$_POST['schls']."','".$_POST['schls']."','".$_POST['chls']."','".$_POST['echls']."','".$name."','".$_POST['acno']."','".$micr."','".$flag."','".$tflag."')" or die(mysql_error());

 $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());


$queryu="UPDATE ac_bankmasters set flag = '1' WHERE code = '$code'" or die(mysql_error());
$get_entriess_resu1 = mysql_query($queryu,$conn) or die(mysql_error());

 header('Location:dashboardsub.php?page=ac_chequeseries');
 
?>
