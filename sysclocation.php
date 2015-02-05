<?php
include 'config.php';
$client=$_SESSION['client'];
 $db='Tables_in_'.$_SESSION[db];
$r=mysql_query('show tables');
while($a=mysql_fetch_assoc($r)) {
 echo '<br>'.$q="ALTER TABLE `$a[$db]`  ADD `sychlocation` VARCHAR(50) NULL DEFAULT 'online'" ;  mysql_query($q) or die(mysql_error()); }
?>
