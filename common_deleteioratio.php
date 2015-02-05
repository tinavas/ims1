<?php 
include "config.php";
mysql_query("delete from tbl_ioratio where id='$_GET[id]'");
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=common_ioratio';";
echo "</script>";
?>