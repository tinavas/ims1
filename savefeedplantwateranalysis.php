<?php 
include "config.php";
$sdate = date("Y-m-d", strtotime($_POST['sampledate']));
$rdate = date("Y-m-d", strtotime($_POST['reportdate']));

$feeddesc = $_POST['feeddesc'];
$remarks = $_POST['remarks'];


$tid = "";
$q = "select max(tid) as tid from feedplantwateranalysis";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;

for($i = 0; $i < count($_POST['sample']); $i++)
{
if($_POST['ph'][$i]=='0' || $_POST['ph'][$i]== '')
{
$query = "select * from feedplantwateranalysis";
$result = mysql_query($query,$conn)or die(mysql_error());
}
else
{
$sample = $_POST['sample'][$i];

$ph = $_POST['ph'][$i];
$hardness = $_POST['hardness'][$i];
$td = $_POST['td'][$i];
$equalai = $_POST['equalai'][$i];




$query1 = "insert into feedplantwateranalysis
(tid,sampleddate,reporteddate,feedmill,sample,ph,hardness,totaldissolve,equalai,remarks,client) values ('$tid','$sdate','$rdate','$feeddesc','$sample','$ph','$hardness','$td','$equalai','$remarks','$client') ";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=feedplantwateranalysis';";
echo "</script>";

?>
