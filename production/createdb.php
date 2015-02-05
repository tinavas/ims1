

<?php 

$conn=mysql_connect("localhost","poultry","tulA0#s!");
mysql_select_db("ims_trial");
$q="show tables";
 $r=mysql_query($q,$conn);
while($row=mysql_fetch_array($r))
{


echo $q1="ALTER TABLE `$row[0]` CHANGE `client` `client` VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'IMSTRIAL'";
echo $r1=mysql_query($q1,$conn);


$q2="update '$row[0]' set `client`= 'IMSTRAIL'";

$r2=mysql_query($q1,$conn);


}

?>