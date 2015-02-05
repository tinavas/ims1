<?php
include "config.php";
$id = $_POST['oldid'];

for($i = 0; $i < count($_POST['country']); $i++)
{
 if($_POST['country'][$i] <> "select" && $_POST['currency'][$i] <> "")
 {
  $query = "UPDATE currency SET country = '".$_POST['country'][$i]."',currency = '".$_POST['currency'][$i]."' WHERE id = '$id'";
  $result = mysql_query($query,$conn) or die(mysql_error());
 }
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_currency'";
echo "</script>";

?>