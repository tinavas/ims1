<?php
include "config.php";
$client = $_SESSION['client'];
$id = $_POST['id'];
$farmp = $_POST['farmp'];

$file = "fphoto_" .basename( $_FILES['fphoto']['name']);
//echo $image = $file;
$target_path = "uploads/"; 
$target_path = $target_path . "fphoto_" . basename( $_FILES['fphoto']['name']); 
$i = move_uploaded_file($_FILES['fphoto']['tmp_name'], $target_path);

if(basename( $_FILES['fphoto']['name']))
{
}
else
{
$file = $farmp;
}

$dob = $_POST['dob'];
$dob = date("Y-m-j", strtotime($dob));

$get_entriess = "DELETE FROM tbl_farmreg WHERE id = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

 $query="INSERT INTO tbl_farmreg(id,farmvillage,farmer,fatherrhusband,farmaddress,residentaddress,dob,education,poultryexp,bankersname,bankaddress,backacnotype,pan,farmphoto,client)
 VALUES ('$id','".htmlentities($_POST['frvname'], ENT_QUOTES)."','".htmlentities($_POST['fname'], ENT_QUOTES)."','".htmlentities($_POST['fhname'], ENT_QUOTES)."','".htmlentities($_POST['faddress'], ENT_QUOTES)."','".htmlentities($_POST['raddress'], ENT_QUOTES)."'
,'".$dob."','".htmlentities($_POST['edu'], ENT_QUOTES)."','".htmlentities($_POST['pexp'], ENT_QUOTES)."','".htmlentities($_POST['bname'], ENT_QUOTES)."','".htmlentities($_POST['baddress'], ENT_QUOTES)."','".htmlentities($_POST['bactype'], ENT_QUOTES)."','".htmlentities($_POST['pan'], ENT_QUOTES)."','".$file."','".$client."')";
 $get_entriess_res1 = mysql_query($query,$conn);

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=farmregdisplay';"; 
echo "</script>";
//echo "Farm Details Successfully Registered";
?>
