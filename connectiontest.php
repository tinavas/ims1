<?php
 $db_host = "localhost:3307";

 $db_user = "poultry";

 $db_pass = "tulA0#s!";

 $db_name = "users";
 $conn=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db_name);
echo "HAI";
 $query = "SELECT username FROM tbl_users ORDER BY username LIMIT 10";
echo $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
  echo $rows['username'];
?>