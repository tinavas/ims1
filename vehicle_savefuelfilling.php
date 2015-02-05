<?php
include "config.php";
include "getemployee.php";

$date     = date("Y-m-d",strtotime($_POST['idate']));
$vtype    = ($_POST['vt']);
$vnumber  = ($_POST['vnum']);
$temp     = explode('@', $_POST['ftype']);
$fueltype = $temp[0];
$fuelcode = $temp[1];
$coa      = $_POST['coa'];
$fl       = ($_POST['fl']);
{
	if($fl=="")
		$fl=0;
}
$ratel    = ($_POST['ratel']);
$bill     = ($_POST['bill']);
$amount   = ($_POST['amt']);
{
	if($amount=="")
		$amount=0;
}

$driver   = ($_POST['driver']);
$type     = ($_POST['type']);
$warehouse= ($_POST['ware']);
$empname  = ($_SESSION['valid_user']);




$driver = "";
for($i=0;$i<count($_POST['driver']);$i++)
{

	if($driver == "")
	{
		$driver = $_POST['driver'][$i];
	}
	else
	{
		$driver = $driver . ",". $_POST['driver'][$i] ;
	}
}
$reading =($_POST['reading']);
$remarks = ($_POST['remarks']);;
if($reading=="")
$reading=0;


$q = "insert into vehicle_fuelfilling(date, vtype, vnumber, fueltype, coa, fuelcode, fuel, reading, driver, narration, billnumber, amount,empname,client,type,warehouse)
values('$date', '$vtype', '$vnumber', '$fueltype', '$coa', '$fuelcode', $fl, '$reading', '$driver', '$remarks', '$bill', '$amount','$empname', '$client','$type','$warehouse')"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());

//Financial Postings 
$q="SELECT cm,iac FROM ims_itemcodes WHERE code='$fuelcode'";
$res=mysql_query($q, $conn);
$data=mysql_fetch_array($res) ;
$iac=$data['iac'];
$cm=$data['cm'];

$amount1=calculatenew($warehouse,$cm, $fuelcode, date('Y-m-d'));
$tot=$fl*$amount1;

//get Transaction id
$q="SELECT MAX(id) as ids FROM vehicle_fuelfilling";
$res=mysql_query($q, $conn);
$data=mysql_fetch_array($res) ;
$trnum=$data['ids'];

if($type=="outside"){
	$iac=$_POST['cashcode'];
	$tot=$amount;
}

//Selected COA code will be Debited
$query="INSERT INTO ac_financialpostings ";
$query.="(date, itemcode, crdr, coacode, quantity, amount, trnum, type, warehouse,empname) ";
$query.="VALUES('$date', '$fuelcode', 'Dr', '$coa', $fl, $tot, '$trnum', 'FFT', '$warehouse','$empname')";
$result=mysql_query($query, $conn) ;



////Selected Fuel Type will be Credited
$query="INSERT INTO ac_financialpostings ";
$query.="(date, itemcode, crdr, coacode, quantity, amount, trnum, type, warehouse,empname) ";
$query.="VALUES('$date', '$fuelcode', 'Cr', '$iac', '$fl', $tot, '$trnum', 'FFT', '$warehouse','$empname')";
$result=mysql_query($query, $conn);

//Update amount in vehicle_fuelfilling
$rate=round($tot/$fl,2);
$query="UPDATE vehicle_fuelfilling SET amount='$tot', rate='$rate' WHERE id='$trnum'";
$result=mysql_query($query, $conn);

echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_fuelfilling'";
echo "</script>";

?>







