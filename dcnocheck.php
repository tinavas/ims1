<?php
include "config.php";
$q="SELECT dcno FROM `broiler_chickentransfer` where dcno='".$_POST['dcno']."'";
$rows=mysql_num_rows(mysql_query($q));
if($rows>0)
echo "already this dcno occupied";
else
echo "";
?>
