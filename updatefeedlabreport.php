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

 $query = "update feedlabreport set sampledate = '$sdate',reportdate='$rdate',samplecode ='$sampcode',feeddescription = '$feeddesc',farmtype ='$ftype' ,farmname ='$fname',moisture ='$moisture',protein='$protein',oil='$oil',fibre='$fibre',tash='$tash',sandsilica = '$sns',calcium ='$calcium',phosphorous ='$phosphorous' ,salt='$salt',atoxin='$atoxin',ge='$gekcal',me='$mekcal',remarks='$remarks' where id = '$id'";
	$result = mysql_query($query,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=feedlabreport';";
echo "</script>";

?>

















