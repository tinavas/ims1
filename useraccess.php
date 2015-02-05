<?php
include "config.php";
$useraccess = "";
/*$dresult = mysql_query("show databases",$conn);
while($dres = mysql_fetch_assoc($dresult))
if($dres['Database'] <> "information_schema" && $dres['Database'] <> "mysql")
{
$dbase = $dres['Database'];*/
$query = "select * from golden.common_useraccess";
$result = mysql_query($query,$conn);
while($res = mysql_fetch_assoc($result))
{
$all = $res['view'];
$all = explode(',',$all);
$size = sizeof($all);

for($i = 0; $i <= $size; $i++)
if(strlen(strstr($all[$i],'15'))>0  )
if(strlen(strstr($useraccess,$all[$i]))==0)
$useraccess .= $all[$i].",";
}

/*}*/

echo $useraccess;
