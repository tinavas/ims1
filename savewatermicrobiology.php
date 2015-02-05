<?php 
include "config.php";
$sdate = date("Y-m-d", strtotime($_POST['sampledate']));
$rdate = date("Y-m-d", strtotime($_POST['reportdate']));
$snum = $_POST['samplenum'];
$ftype = $_POST['ftype'];
$fname = $_POST['fname'];
 $remarks = $_POST['remarks'];

$tid = "";
$q = "select max(tid) as tid from watermicrobiology";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'] + 1;

for($i = 0; $i < count($_POST['sample']); $i++)
{
if($_POST['ecoil'][$i]=='0' || $_POST['ecoil'][$i]== '')
{
$query = "select * from watermicrobiology";
$result = mysql_query($query,$conn)or die(mysql_error());
}
else
{
 $sample = $_POST['sample'][$i];
 $ecoil = $_POST['ecoil'][$i]; 
 $ph = $_POST['ph'][$i];
 $hardness = $_POST['hardness'][$i];


 $query1 = "insert into watermicrobiology
(tid,sampledate,reportdate,farmtype,farmname,sample,ecoil,ph,hardness,remarks,client,samplenumber) values ('$tid','$sdate','$rdate','$ftype','$fname','$sample','$ecoil','$ph','$hardness','$remarks','$client','$snum') ";
	$result1 = mysql_query($query1,$conn) or die(mysql_error());
}
}
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=watermicrobiology';";
echo "</script>";

?>