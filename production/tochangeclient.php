<?php
include 'config.php';
$client=$_SESSION['client'];
 $db='Tables_in_'.$_SESSION[db];
$r=mysql_query('show tables');
while($a=mysql_fetch_assoc($r)) 
{
 echo '<br>'. $q= "update $a[$db] set client='$client'"; mysql_query($q);
 echo ' , '. $q="ALTER TABLE $a[$db] CHANGE `client` `client` VARCHAR( 100 )  NOT NULL DEFAULT '$client'" ; mysql_query($q);
}
?>
