<?php
include "config.php";
$id=$_GET['id'];
$type=$_GET['type'];
$mode=$_GET['mode'];

$tid=$_GET['tid'];
$query2="DELETE FROM ac_crdrnote WHERE tid='$tid' and  crnum = '".$id."' AND mode = '".$mode."'";
$result2=mysql_query($query2,$conn) or die(mysql_error());



$query1="DELETE FROM ac_financialpostings WHERE trnum = '".$tid."' AND type = '".$mode."'";
$result1=mysql_query($query1,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_creditnote&type=$type'";
echo "</script>";

?>