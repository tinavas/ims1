
<?php
include "config.php";

$q="Show tables";
$res=mysql_query($q,$conn);
while($row=mysql_fetch_array($res))
{

$sql=mysql_query(
        "SELECT adate FROM `$row[0]`");

if (!$sql){
$date=date("Y-m-d");

mysql_query("ALTER TABLE `$row[0]`  ADD `adate` DATE NULL DEFAULT NULL AFTER `empname`  ");

 
echo 'adate created';

}else{


echo 'adate exists!';

}




}





?>