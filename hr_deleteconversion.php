<?php
include "config.php";

$id = $_GET['id'];
$query = "DELETE FROM hr_conversion WHERE id = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_conversion'";
echo "</script>";

?>