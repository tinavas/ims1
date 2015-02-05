
<html>
<head>
</head>
<body>
<?php 
include "config.php";

$id = $_GET['id'];
$col = $_GET['col'];
  if($col == "toname")
  $get_entriess3 = "UPDATE `common_messages` SET `receivedflag` = '0' WHERE `common_messages`.`id` = '$id' AND client = '$client'";     
  else
   $get_entriess3 = "UPDATE `common_messages` SET `sentflag` = '0' WHERE `common_messages`.`id` = '$id' AND client = '$client'";     

   $get_entriess_res3 = mysql_query($get_entriess3,$conn) or die(mysql_error());

header("location:dashboardsub.php?page=common_messages&id=$col");

?>

</body>
</html>
