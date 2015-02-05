<?php
include "config.php";
$client = $_SESSION['client'];

$eid = $_POST['employeeid'];
$image = "";
if($_FILES[uploadedfile]['name'])
{
$file = $client . "_" .$eid. "_" .basename($_FILES['uploadedfile']['name']);
$image = $file;
$target_path = "employeeimages/"; 
$target_path = $target_path .$client . "_" .$eid. "_" . basename($_FILES['uploadedfile']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);

$target_path2 = "employeeimages/reduced/"; 
$target_path2 = $target_path2 .$client . "_" .$eid. "_" . basename($_FILES['uploadedfile']['name']); 
$j = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path2);

//file_get_contents("http://pms2.spectacularsys.com/thumb.php?src=" . $j . "&dest=" . $j . "&x=70&y=60");
//file_get_contents("http://pms2.spectacularsys.com/thumb1.php?src=" . $j . "&dest=" . $j . "&x=340&y=320");

}


//$image = basename( $_FILES['uploadedfile']['name']);
//if($_FILES['uploadedfile']['name'])
/*if($_FILES['uploadedfile']['name'])
{
$image = $client . "_" .$eid. "_" . basename( $_FILES['uploadedfile']['name']);
$target_path = "employeeimages/"; 
$target_path = $target_path . $client . "_" .$eid. "_" .basename( $_FILES['uploadedfile']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);
}
*/
/*$image = $client.$eid."_".basename( $_FILES['uploadedfile']['name']);
//echo $image = $file;
$target_path = "employeeimages/"; 
$target_path = $target_path . $image;
//"fphoto_" . basename( $_FILES['fphoto']['name']); 
$i = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path);*/


if ($_POST['bank'] == "other")
{
 $bank = $_POST['bankname'];
}
else
{
 $bank = $_POST['bank'];
}

$dob = $_POST['dob'];
$dob = date("Y-m-j", strtotime($dob));

$joiningdate = $_POST['joiningdate'];
$joiningdate = date("Y-m-j", strtotime($joiningdate));

$expvinsurance = $_POST['expvinsurance'];
$expvinsurance = date("Y-m-j", strtotime($expvinsurance));

$expdlicense = $_POST['expdlicense'];
$expdlicense = date("Y-m-j", strtotime($expdlicense));

$sect=$_POST['sector'];
$desig=$_POST['designation'];

 $query="INSERT INTO hr_employee (id,sector,groupname,employeeid,salarytype,name,salary,fname,sex,dob,vehicleno,
qualification,designation,vinsurance,joiningdate,drivinglicense,address,expvinsurance,personalcontact,expdlicense,companycontact,
farm,bank,accountno,bankbranch,ifsc,pancard,reportingto,image,ref1name,ref1address,ref1contact1,ref1contact2
,ref2name,ref2address,ref2contact1,ref2contact2,country,ref1country,ref2country,spouse,title,bloodgroup,eref1name,eref1address,eref1contact1,eref1contact2,eref1country,salaryac,loanac,client,leaves)
 VALUES (NULL,'".htmlentities($_POST['sector'], ENT_QUOTES)."','".htmlentities($_POST['group'], ENT_QUOTES)."','".htmlentities($_POST['employeeid'], ENT_QUOTES)."','".htmlentities($_POST['salarytype'], ENT_QUOTES)."','".htmlentities($_POST['name'], ENT_QUOTES)."'
,'".htmlentities($_POST['salary'], ENT_QUOTES)."','".htmlentities($_POST['fname'], ENT_QUOTES)."','".htmlentities($_POST['sex'], ENT_QUOTES)."','".$dob."'
,'".htmlentities($_POST['vehicleno'], ENT_QUOTES)."','".htmlentities($_POST['qualification'], ENT_QUOTES)."','".htmlentities($_POST['designation'], ENT_QUOTES)."','".htmlentities($_POST['vinsurance'], ENT_QUOTES)."','".$joiningdate."'
,'".htmlentities($_POST['drivinglicense'], ENT_QUOTES)."','".htmlentities($_POST['address'], ENT_QUOTES)."','".$expvinsurance."','".htmlentities($_POST['personalcontact'], ENT_QUOTES)."','".$expdlicense."','".htmlentities($_POST['companycontact'], ENT_QUOTES)."'
,'".htmlentities(join(",",$_POST['farm']), ENT_QUOTES)."','".htmlentities($bank, ENT_QUOTES)."','".htmlentities($_POST['accountno'], ENT_QUOTES)."','".htmlentities($_POST['bankbranch'], ENT_QUOTES)."','".htmlentities($_POST['ifsc'], ENT_QUOTES)."','".htmlentities($_POST['pancard'], ENT_QUOTES)."'
,'".htmlentities($_POST['reportingto'], ENT_QUOTES)."','".$image."','".htmlentities($_POST['ref1name'], ENT_QUOTES)."','".htmlentities($_POST['ref1address'], ENT_QUOTES)."','".htmlentities($_POST['ref1contact1'], ENT_QUOTES)."','".htmlentities($_POST['ref1contact2'], ENT_QUOTES)."'
,'".htmlentities($_POST['ref2name'], ENT_QUOTES)."','".htmlentities($_POST['ref2address'], ENT_QUOTES)."','".htmlentities($_POST['ref2contact1'], ENT_QUOTES)."','".htmlentities($_POST['ref2contact2'], ENT_QUOTES)."','".htmlentities($_POST['country'], ENT_QUOTES)."'
,'".htmlentities($_POST['ref1country'], ENT_QUOTES)."','".htmlentities($_POST['ref2country'], ENT_QUOTES)."','".htmlentities($_POST['spouse'], ENT_QUOTES)."','".htmlentities($_POST['title'], ENT_QUOTES)."','".htmlentities($_POST['bloodgroup'], ENT_QUOTES)."','".htmlentities($_POST['eref1name'], ENT_QUOTES)."','".htmlentities($_POST['eref1address'], ENT_QUOTES)."','".htmlentities($_POST['eref1contact1'], ENT_QUOTES)."','".htmlentities($_POST['eref1contact2'], ENT_QUOTES)."','".htmlentities($_POST['eref1country'], ENT_QUOTES)."','".htmlentities($_POST['salaryac'], ENT_QUOTES)."','".htmlentities($_POST['loanac'], ENT_QUOTES)."','".$client."','".htmlentities($_POST['leaves'], ENT_QUOTES)."')" or die(mysql_error());
  $get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

 $qqq = "select * from hr_employee";
  $qqqrs = mysql_query($qqq,$conn) or die(mysql_error());
 if(mysql_num_rows($qqqrs) == 1)
 {
 	$uq = "update hr_employee set reportingto = '".htmlentities($_POST['name'])."'";
  $uqrs = mysql_query($uq,$conn) or die(mysql_error());
 }
$joiningdate1 = split("-",$joiningdate);

//$salary = $_POST['salary'];
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
//$salparars = mysql_query($salparaq,$conn) or die(mysql_error());

  $q="select * from hr_salary_parameters where sector='$sect' and designation='$desig' order by fromdate,todate";
$res=mysql_query($q);
$n=mysql_num_rows($res);
while($row=mysql_fetch_assoc($res))
{
$fromdate=$row['fromdate'];
$todate=$row['todate'];
$param1=$row['param1'];
$basic=$row['Basic'];
//$tax=$row['TTAX'];
}
		
$eid=$_POST['employeeid'];
$name=$_POST['name'];
$salary=$_POST['salary'];
$basicsal=$salary*(50/100);
$query33 = "SELECT tax FROM hr_pf where '$salary' between salfrom and salto";
		$result33 = mysql_query($query33);
		while($row33 = mysql_fetch_assoc($result33))
		{
			$ProfessionalTax = $row33['tax'];
			
		}
		if($ProfessionalTax=="")
		$ProfessionalTax =0;
		
$finalsal=$basicsal+$param1;
$finalsal = $finalsal - $ProfessionalTax;

 if($n>0)
{
  $q1="INSERT INTO `hr_salary_parameters` (`eid` ,`sector` ,`designation` ,`name` ,`fromdate` ,`todate` ,`salary` ,`Basic` ,`param1` ,`ProfessionalTax` ,`finalsal` ,`flag`) VALUES ( '$eid','$sect',  '$desig','$name','$fromdate','$todate','$salary', '$basicsal','$param1','$ProfessionalTax','$finalsal','0')";
$res=mysql_query($q1);
}


 header('Location:dashboardsub.php?page=hr_employee');

?>