<?php
include "config.php";

for($i = 0; $i < count($_POST['country']); $i++)
{
 if($_POST['country'][$i] <> "")
 {
  $query = "INSERT INTO countries (country_id,country_name) VALUES (NULL,'".$_POST['country'][$i]."')";
  $result = mysql_query($query,$conn) or die(mysql_error());
 }
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_country'";
echo "</script>";

?>