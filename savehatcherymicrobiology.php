<?php 
include "config.php";
$sdate = date("Y-m-d", strtotime($_POST['sampledate']));
$rdate = date("Y-m-d", strtotime($_POST['reportdate']));
$farm = $_POST['feeddesc'];

$remarks = $_POST['remarks'];

$tid = "";
$q = "select max(tid) as tid from hatcherymicrobiology";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;

for($i = 0; $i < count($_POST['poe']); $i++)
{
if($_POST['score'][$i]=='0' || $_POST['score'][$i]== '')
{
$query = "select * from hatcherymicrobiology";
$result = mysql_query($query,$conn)or die(mysql_error());
}
else
{
$tcount = 0;
$ccount = 0;
$fungalcount =0;
$poe = $_POST['poe'][$i];
$score = $_POST['score'][$i]; 
$query1 = "insert into hatcherymicrobiology
(tid,sampleddate,reporteddate,farm,placeofexposure,score,impressionmethod,totalcount,coliformcount,fungalcount,remarks,client) values ('$tid','$sdate','$rdate','$farm','$poe','$score','$im','$tcount','$ccount','$fungalcount','$remarks','$client') "; 
	$result1 = mysql_query($query1,$conn) or die(mysql_error());

}
}

for($i = 0; $i < count($_POST['im']); $i++)
{
if($_POST['tcount'][$i]=='0' || $_POST['tcount'][$i]== '')
{
$query = "select * from hatcherymicrobiology";
$result = mysql_query($query,$conn)or die(mysql_error());
}
else
{
$score = 0;
$im = $_POST['im'][$i];
$tcount = $_POST['tcount'][$i]; 
$ccount = $_POST['ccount'][$i]; 
$fungalcount = $_POST['fungalcount'][$i]; 
$query2 = "insert into hatcherymicrobiology
(tid,sampleddate,reporteddate,farm,placeofexposure,score,impressionmethod,totalcount,coliformcount,fungalcount,remarks,client) values ('$tid','$sdate','$rdate','$farm','NULL','$score','$im','$tcount','$ccount','$fungalcount','$remarks','$client') "; 
	$result2= mysql_query($query2,$conn) or die(mysql_error());

}



}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hatcherymicrobiology';";
echo "</script>";

?>
