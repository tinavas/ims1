<?php 
include "config.php";
mysql_query("delete from tbl_profitcenter where id='$_GET[id]'");
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=common_profitcenter';";
echo "</script>";
?>