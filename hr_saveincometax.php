<?php
include "config.php";
$fromdate=date('Y-m-d',strtotime($_POST['fromdate']));
$todate=date('Y-m-d',strtotime($_POST['todate']));
$fromsal=$_POST['fromsal'];
$tosal=$_POST['tosal'];
$balamtded=$_POST['balamtded'];
$amountexceede=$_POST['amtex'];
$deductionper=$_POST['ded'];
$coa=$_POST['coa'];
if($_POST['edit']=="1")
{
	$id=$_POST['id'];
	$query="delete from hr_incometax where id='$id'";
	$result=mysql_query($query,$conn);
	$addemp=$_POST['addemp'];
	$editemp=$_SESSION['valid_user'];
	}
else
{
	$addemp=$_SESSION['valid_user'];
	$editemp="";	
}
$query="insert into hr_incometax (`fromdate`, `todate`, `fromsal`, `tosal`, `balamtded`, `amtexceeded`, `deductionper`, `coa`, `addemp`, `editemp`) values ('$fromdate','$todate','$fromsal','$tosal','$balamtded','$amountexceede','$deductionper','$coa','$addemp','$editemp')";
$result=mysql_query($query,$conn);
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=hr_incometax';";
echo "</script>";

?>
