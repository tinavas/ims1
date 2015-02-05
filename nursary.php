
<?php
include "config.php";
mysql_select_db("nursarytrial");

$q="Show tables";
$res=mysql_query($q,$conn);
while($row=mysql_fetch_array($res))
{

$sql=mysql_query(
        "SELECT client FROM `$row[0]`");

if (!$sql){
$date=date("Y-m-d");

mysql_query("ALTER TABLE  `$row[0]` CHANGE  `client`  `client` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'NURSARYTRIAL'");

 
echo 'adate created';

}else{


echo 'adate exists!';

}




}





?>