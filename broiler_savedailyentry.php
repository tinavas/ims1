<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
print_r($_POST);
include "config.php";


for($i=0;$i<count($_POST[date1]);$i++)
{
$farm=$_POST['farm'][$i];
$house=$_POST['place'][$i];
$flock=$_POST['flock'][$i];
$date=date("Y-m-d",strtotime($_POST['date1'][$i]));
$age=$_POST['age'][$i];
$mort=$_POST['mort'][$i];
$cull=$_POST['cull'][$i];
$feedtype=$_POST['feedtype'][$i];
$consumed=$_POST['consumed'][$i];
$weight=$_POST['weight'][$i];
$water=$_POST['water'][$i];

$q1="INSERT INTO `singhsatrang`.`broiler_consumption` (`place`, `farm`, `flock`, `age`, `mortality`, `cull`, `feedtype`, `feedconsumed`, `average_weight`, `water`, `remarks`, `entrydate`, `birds`, `cullflag`, `date`, `date1`) VALUES ('$house','$farm','$flock','$age','$mort','$cull','$feedtype','$consumed','weight','$water','$remarks','$date','$birds','0','$date','$date')";
$r1=mysql_query($q1);

}
?>
</body>
</html>
