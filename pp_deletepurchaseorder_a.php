 <?php
include "config.php";
$po=$_GET['po'];
$query = "SELECT pr,code FROM pp_purchaseorder WHERE po = '$po'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $query1 = "UPDATE pp_purchaseindent SET flag = 0 WHERE pi='$rows[pr]' AND icode = '$rows[code]'";
 $result1 = mysql_query($query1,$conn) or die(mysql_error());
}
$get_entriess = "DELETE FROM pp_purchaseorder WHERE po='$po'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=pp_purchaseorder_a';";
echo "</script>";
?>

