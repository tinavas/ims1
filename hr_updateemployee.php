<?php
include "config.php";
$id=$_POST['id'];

$sector=$_POST['sector']; 
$groupname=$_POST['group'];
$salarytype=$_POST['salarytype'];
$name=$_POST['name'];
$salary=$_POST['salary'];
$fname=$_POST['fname'];
//$advance = $_POST['advance'];
$sex=$_POST['sex'];
//$savings=$_POST['savings'];
$dob = date("Y-m-j", strtotime($_POST['dob']));

$vehicleno=$_POST['vehicleno'];
$bloodgroup=$_POST['bloodgroup'];
$qualification=$_POST['qualification'];
$designation=$_POST['designation'];
$vinsurance=$_POST['vinsurance'];
$joiningdate = date("Y-m-j", strtotime($_POST['joiningdate']));
$drivinglicense=$_POST['drivinglicense'];
$address=$_POST['address'];
$expvinsurance = date("Y-m-j", strtotime($_POST['expvinsurance']));
$personalcontact=$_POST['personalcontact'];
$expdlicense = date("Y-m-j", strtotime($_POST['expdlicense']));
$companycontact=$_POST['companycontact'];
$farm=join(",",$_POST['farm']);


if ($_POST['bank'] == "other")
{
 $bank = $_POST['bankname'];
}
else
{
 $bank = $_POST['bank'];
}

$accountno=$_POST['accountno'];
$bankbranch=$_POST['bankbranch'];
$ifsc=$_POST['ifsc'];
$pancard=$_POST['pancard'];
$reportingto=$_POST['reportingto'];

$ref1name=$_POST['ref1name'];
$ref1address=$_POST['ref1address'];
$ref1contact1=$_POST['ref1contact1'];
$ref1contact2=$_POST['ref1contact2'];
$ref2name=$_POST['ref2name'];
$ref2address=$_POST['ref2address'];
$ref2contact1=$_POST['ref2contact1'];
$ref2contact2=$_POST['ref2contact2'];
$country=$_POST['country'];
$ref1country=$_POST['ref1country'];
$ref2country=$_POST['ref2country'];
$eref1country=$_POST['eref1country'];
$spouse=$_POST['spouse'];
$fname=$_POST['fname'];
$title=$_POST['title'];
$bloodgroup=$_POST['bloodgroup'];
$eref1name=$_POST['eref1name'];
$eref1address=$_POST['eref1address'];
$eref1contact1=$_POST['eref1contact1'];
$eref1contact2=$_POST['eref1contact2'];
$leaves =$_POST['leaves'];


$salaryac = $_POST['salaryac'];
$loanac = $_POST['loanac'];
//$expenseac=$_POST['expac'];
//$advanceac=$_POST['advac'];

//if($advance=='') $advance=0;
if($salary=='') $salary=0;
//if($savings=='') $savings=0;
$get_entriess = "UPDATE hr_employee SET name = '$name',sector =  '$sector',groupname = '$groupname',salarytype = '$salarytype',salary = '$salary',fname = '$fname',sex = '$sex',dob = '$dob',vehicleno = '$vehicleno',bloodgroup = '$bloodgroup',qualification = '$qualification',designation = '$designation',vinsurance =' $vinsurance',joiningdate = '$joiningdate',drivinglicense = '$drivinglicense',address = '".htmlentities($_POST['address'], ENT_QUOTES)."',expvinsurance = '$expvinsurance',personalcontact = '$personalcontact',expdlicense = '$expdlicense',companycontact = '$companycontact',bank = '$bank',farm = '$farm',accountno = '$accountno',bankbranch = '$bankbranch',ifsc = '$ifsc',pancard = '$pancard',reportingto = '$reportingto',ref1name = '$ref1name',ref1address = '".htmlentities($_POST['ref1address'], ENT_QUOTES)."',ref1contact1 = '$ref1contact1',ref1contact2 = '$ref1contact2',ref2name = '$ref2name',ref2address = '".htmlentities($_POST['ref2address'], ENT_QUOTES)."',ref2contact1 = '$ref2contact1',ref2contact2 = '$ref2contact2',country =  '$country',ref1country = '$ref1country',ref2country = '$ref2country',spouse = '$spouse',fname='$fname',title = '$title',bloodgroup = '$bloodgroup',eref1name = '$eref1name',eref1address = '".htmlentities($_POST['eref1address'], ENT_QUOTES)."',eref1contact1 = '$eref1contact1',eref1contact2 = '$eref1contact2',salaryac = '$salaryac',loanac = '$loanac', eref1country ='$eref1country', leaves = '$leaves'  WHERE employeeid = '$id' and client='$client'";     

$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


$joiningdate1 = split("-",$joiningdate);
$q = "delete from hr_salaryparameters where eid = '$id'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$salary = $_POST['salary'];
$basic = $salary * (50/100);
$hra = $salary * (15/100);
$ma = $salary * (18/100);
$cca = $salary * (5/100);
$ta = $salary * (12/100);
/*if($salary < 10000)
$ptax = 0;
else if($salary > 10000 && $salary <15000)
$ptax = 150;
else
$ptax = 200;*/
$ptax = 0;

//$finalsal = $salary + $basic + $hra + $ma + $cca + $ta;
$finalsal = $salary ;
$salparaq = "insert into hr_salaryparameters (id,eid,sector,name,date,month1,year1,salary,bfix,hrafix,mafix,ccafix,tafix,sallowancefix,conveyancefix,eallowancefix,oallowancefix,pffix,ptaxfix,incometaxfix,loanfix,otherfix,finalsal,leavesal,flag,client) values
 (NULL,'$_POST[employeeid]','$_POST[sector]','$_POST[name]','$joiningdate','$joiningdate1[1]','$joiningdate1[0]','$_POST[salary]','$basic','$hra','$ma','$cca','$ta','0','0','0','0','0','$ptax','0','0','0','$finalsal','0','0','$client')";
/*echo  $salparaq = "insert into hr_salaryparameters values (NULL,'$_POST[employeeid]','$_POST[sector]','$_POST[name]','$joiningdate','$joiningdate1[1]','$joiningdate1[0]','$_POST[salary]','$basic','$hra','$ma','$cca','$ta','0','0','0','0','0','$ptax','0','0','0','$finalsal','0','0')";*/
//$salparars = mysql_query($salparaq,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=hr_employee'";
echo "</script>";
?>