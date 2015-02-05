<?php

include "config.php";
 $q="show tables";
$res=mysql_query($q) or die(mysql_error());
while($result=mysql_fetch_array($res))
{

	echo $q1="ALTER TABLE  `$result[0]` CHANGE  `client`  `client` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'MEW'";
	
	$res1=mysql_query($q1);
	
	echo "<br/>";
	
	
	echo $q2="update `$result[0]`  set client='MEW' where client like '%'";
	$res2=mysql_query($q2);
	echo "<br/>";


}


?>