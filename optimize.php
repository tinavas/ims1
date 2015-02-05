<?php
include "config.php";
$result = mysql_query("show tables",$conn) or die(mysql_error());
$table = "Tables_in_".$_SESSION['db'];
while($res = mysql_fetch_assoc($result))
{
echo "The Table ";
echo $res[$table];
 $re = mysql_query("optimize table $res[$table]",$conn) or die(mysql_error());
  if($re)
  echo "success fully optimized";
  else
  echo "couldn't optimize";
  echo "<br>";
}
?>