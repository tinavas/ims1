<?php
include "config.php";
$id=$_GET['id'];

$query = "SELECT * FROM tbl_sector WHERE id = '$id' ORDER BY sector ASC "; $result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) 
{
 $fid = $row1['sectorid'];
}


$get_entriess = "DELETE FROM tbl_sector WHERE sectorid = '$fid'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=admin_office';";
echo "</script>";

?>
