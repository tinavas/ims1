<?php
include "config.php";
$po = $_POST['po'];
$date = $_POST['cldate'];
$date1 = date("Y-m-d",strtotime($date));
$narration = $_POST['narration'];

$query = "UPDATE pp_purchaseorder set cldate = '$date1', narration = '$narration', clflag = 1 WHERE po = '$po' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchaseorder'";
echo "</script>";

?>