<?php
include "config.php";
include "getemployee.php";

$id = $_POST['id'];
$query = "DELETE FROM ac_financialpostings WHERE trnum='$id' AND type='FFT'";
$result = mysql_query($query,$conn) or die(mysql_error());

$idate = date("Y-m-d",strtotime($_POST['idate']));
 $vtype =($_POST['vt']);
$vnumber =($_POST['vnum']);
$temp =explode('@',($_POST['ftype']));
$ftype =  $temp[0];
$coa=$_POST['coa'];
$fuelcode = $temp[1];
$fl = ($_POST['fl']);
$bill = ($_POST['bill']);
$amount = ($_POST['amt']);
if($amount=="")
$amount=0;
$ratel = ($_POST['ratel']);
if($rate1=="")
$rate1=0;
$reading =($_POST['reading']);

$driver =($_POST['driver']);
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
$remarks = ($_POST['remarks']);
$type=$_POST['type'];
$warehouse=$_POST['ware'];
$query = "UPDATE vehicle_fuelfilling SET vtype  = '$vtype', vnumber = '$vnumber', date='$idate',fueltype='$ftype',fuel = '$fl',reading = '$reading',driver = '$driver',narration = '$remarks',billnumber = '$bill', coa='$coa', fuelcode='$fuelcode',type='$type',warehouse='$warehouse' WHERE id = '$id'";     
$result = mysql_query($query,$conn) or die(mysql_error());


//Financial Postings 
$q="SELECT cm,iac FROM ims_itemcodes WHERE code='$fuelcode'";
$res=mysql_query($q, $conn);
$data=mysql_fetch_array($res) ;
$iac=$data['iac'];
$cm=$data['cm'];

$amount=calculate($cm, $fuelcode, date('Y-m-d'));
$tot=$fl*$amount;

//Selected COA code will be Debited
$query="INSERT INTO ac_financialpostings ";
$query.="(date, itemcode, crdr, coacode, quantity, amount, trnum, type,warehouse) ";
$query.="VALUES('$idate', '$fuelcode', 'Dr', '$coa', $fl, $tot, '$id', 'FFT','$warehouse')";
$result=mysql_query($query, $conn) ;

////Selected Fuel Type will be Credited
$query="INSERT INTO ac_financialpostings ";
$query.="(date, itemcode, crdr, coacode, quantity, amount, trnum, type,warehouse) ";
$query.="VALUES('$idate', '$fuelcode', 'Cr', '$iac', '$fl', $tot, '$id', 'FFT','$warehouse')";
$result=mysql_query($query, $conn);



//Update amount in vehicle_fuelfilling
$rate=round($tot/$fl,2);
$query="UPDATE vehicle_fuelfilling SET amount='$tot', rate='$rate' WHERE id='$trnum'";
$result=mysql_query($query, $conn);


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=vehicle_fuelfilling'";
echo "</script>";

?>







