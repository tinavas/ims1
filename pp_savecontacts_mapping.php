<?php
include "config.php";

if($_GET['delete'] == 1)	//DELETE
{
 $delid = $_GET['id'];
 $query = "UPDATE contactdetails SET tally_name = '' WHERE id = '$delid'";
 mysql_query($query,$conn) or die(mysql_error());
}
else	//SAVE AND UPDATE
{
	for($i = 0; $i < count($_POST['tally']); $i++)
	{
	 if($_POST['tally'][$i] <> '' or $_POST['tally'][$i] <> ' ')
	 {
		$tallyname = $_POST['tally'][$i];
		$software = $_POST['software'][$i];
		$query = "UPDATE contactdetails SET tally_name = '$tallyname' WHERE name = '$software'";
		$result = mysql_query($query,$conn) or die(mysql_error());
	 }
	}
}
header("location:dashboardsub.php?page=pp_contacts_mapping")
?>