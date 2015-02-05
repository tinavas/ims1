<?php 
include "config.php";
mysql_query("delete from ims_budget where id='$_GET[id]'");
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=ims_budgets';";
echo "</script>";
?>