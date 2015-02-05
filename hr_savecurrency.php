<?php
include "config.php";

for($i = 0; $i < count($_POST['country']); $i++)
{
 if($_POST['country'][$i] <> "select" && $_POST['currency'][$i] <> "")
 {
  $query = "INSERT INTO currency (id,country,currency,client) VALUES (NULL,'".$_POST['country'][$i]."','".$_POST['currency'][$i]."','$client')";
  $result = mysql_query($query,$conn) or die(mysql_error());
 }
}
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_currency'";
echo "</script>";

?>