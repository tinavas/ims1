<?php
include "config.php";
$useraccess = "";
$dresult = mysql_query("show databases",$conn);
while($dres = mysql_fetch_assoc($dresult))
if($dres['Database'] <> "information_schema" && $dres['Database'] <> "choice")
{
$dbase = $dres['Database'];
$query = "update table $dbase.hr_mnthattendance set client = '$client'";
$result = mysql_query($query,$conn);
echo $dbase;
echo "<br>";
}


