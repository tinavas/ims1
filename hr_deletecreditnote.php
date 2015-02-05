<?php
include "config.php";

$type = $_GET['type'];
$id = $_GET['id'];
$mode = $_GET['mode'];
//$flag=$_GET['flag'];
$query = "DELETE FROM hr_empcrdrnote WHERE mode = '$mode' AND tid = '$id'";
$result = mysql_query($query,$conn) or die(mysql_error());
//if($flag == 1)
 //{
 $query = "DELETE FROM ac_financialpostings WHERE trnum = '$id'";
  $result = mysql_query($query,$conn) or die(mysql_error());
// }
if($mode == "EDN")
{
	$query1="select * from hr_empdr where tid='$id'";
	$result1=mysql_query($query1,$conn);
	while($rows1=mysql_fetch_assoc($result1))
	{
		$query2 = "update hr_empcrdrnote set balamount=balamount+'$rows1[amount]' where tid='$rows1[ecn]'";
		$result2=mysql_query($query2,$conn);
	}
	$query3="delete from hr_empdr where tid='$id'";
	$result3=mysql_query($query3,$conn);
}
echo "<script type='text/javascript'>";
if($mode == "EDN")
 echo "document.location = 'dashboardsub.php?page=hr_debitnote&type=$type';";
 else
  echo "document.location = 'dashboardsub.php?page=hr_creditnote&type=$type';";

echo "</script>";

?>