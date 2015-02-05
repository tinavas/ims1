<?php
include "config.php";
$id = $_POST['oldid'];

for($i = 0; $i < count($_POST['country']); $i++)
{
 if($_POST['country'][$i] <> "" )
 {
  $query = "UPDATE countries SET country_name = '".$_POST['country'][$i]."' WHERE country_id = '$id'";
  $result = mysql_query($query,$conn) or die(mysql_error());
 }
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_country'";
echo "</script>";

?>