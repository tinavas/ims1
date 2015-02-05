<?php
include "config.php";
 $sdate = date("Y-m-d", strtotime($_POST['sampledate']));
 $rdate = date("Y-m-d", strtotime($_POST['reportdate']));

 $sampcode =($_POST['sampcode']);
$feeddesc = ($_POST['feeddesc']);
 $ftype = ($_POST['ftype']);
 $fname = ($_POST['fname']);
 $moisture = ($_POST['moisture']);
 $protein = ($_POST['protein']);
 $oil = ($_POST['oil']);
 $fibre = ($_POST['fibre']);
 $tash = ($_POST['tash']);
 $sns = ($_POST['sns']);
 $calcium = ($_POST['calcium']);
 $phosphorous = ($_POST['phosphorous']);
 $salt = ($_POST['salt1']);
 $atoxin = ($_POST['atoxin']);
$gekcal = ($_POST['gekcal']);
 $mekcal = ($_POST['mekcal']);
 $remarks = ($_POST['remarks']);
 $id = ($_POST['id']);

 $query = "insert into feedlabreport(sampledate,reportdate,samplecode,feeddescription,farmtype,farmname,moisture,protein,oil,fibre,tash,sandsilica,calcium,phosphorous,salt,atoxin,ge,me,remarks,client) 
values ('$sdate','$rdate','$sampcode','$feeddesc','$ftype','$fname','$moisture','$protein','$oil','$fibre','$tash','$sns','$calcium','$phosphorous','$salt','$atoxin','$gekcal','$mekcal','$remarks','$client')";
	$result = mysql_query($query,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=feedlabreport'";
echo "</script>";

?>








