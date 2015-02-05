<?php
$i = 1;
$query = "select id from broiler_farm order by id";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
if($i < 10)
$code = "F000".$i;
else if($i>=10 && $i < 100)
$code = "F00".$i;
else if($i>=100 && $i < 1000)
$code = "F0".$i;

$query = "update broiler_farm set farmcode = '$code' where id = $res[id]";
$result2 = mysql_query($query,$conn) or die(mysql_error());

$i++;
}
echo "Farm Codes Updated Successfully!";
?>