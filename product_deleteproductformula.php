<?php 
include "config.php";
$formulaid = $_GET['formulaid'];

echo $q = "select * from product_productionunit where formulaid = '$formulaid'";
//$qrs = mysql_query($q,$conn) or die(mysql_error());
if(mysql_num_rows($qrs) > 0)
{
echo "<script type='text/javascript'>";
echo "alert('You should not select this formula');";
echo "document.location = 'dashboard.php?page=feed_feedformula';";
echo "</script>";
}
else
{
	$q = "delete from product_formula where id = '$formulaid'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	$q = "delete from product_fformula where formulaid = '$formulaid'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	header('Location:dashboardsub.php?page=product_productformula');
}

?>