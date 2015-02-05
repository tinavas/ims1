<?php
include "config.php";
$alert = 0; $alertmsg = "";
for($i = 0; $i < count($_POST['currency']); $i++)
{
 if($_POST['currency'][$i] <> "select" && $_POST['rate'][$i] <> "")
 {
  $from = date("Y-m-d",strtotime($_POST['fromdate'][$i]));
  $to = date("Y-m-d",strtotime($_POST['todate'][$i]));
  $temp = explode('@',$_POST['currency'][$i]);
  $country = $temp[0];
  $currency = $temp[1];
  $q = "SELECT id FROM hr_conversion WHERE (('$from' BETWEEN fromdate AND todate) OR ('$to' BETWEEN fromdate AND todate)) AND currency = '$currency' AND country = '$country'";
  $r = mysql_query($q,$conn) or die(mysql_error());
  $numrows = mysql_num_rows($r);
  if($numrows == 0)
  {
  $query = "INSERT INTO hr_conversion (id,fromdate,todate,country,currency,rate,client) VALUES (NULL,'$from','$to','$country','$currency','".$_POST['rate'][$i]."','$client')";
  $result = mysql_query($query,$conn) or die(mysql_error());
  }
  else
  {
   $alertmsg .= "The conversion rate is already entered for country ".$country." in the given timeperiod. ";
   $alert = 1;
  } 
 }
}
echo "<script type='text/javascript'>";
if($alert == '1')
 echo "alert('$alertmsg');";
echo "document.location='dashboardsub.php?page=hr_conversion'";
echo "</script>";

?>