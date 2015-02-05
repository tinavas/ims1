<?php 
include "config.php";
include "getemployee.php";

//////GR Generation/////
$gr = explode("-",$_POST['ge']);
	$gr[0] = "GR";
	$gr1 = "";
	for($i = 0;$i<count($gr)-1;$i++)
	{
		$gr1.=$gr[$i] . "-";
	}
	$gr1.=$gr[$i];

$vendor = $_POST['vendor'];
$vendorid = '0';
$type = $_POST['type'];
if($type == "vendor")
{
$vendor = $_POST['vendor'];
$vendorid = '0';
}
else if($type == "broker")
{
$broker = $_POST['vendor'];
$brokerid = '0';
}



$ge = $_POST['ge'];
$date = date("Y-m-d",strtotime($_POST['date']));
$remarks = $_POST['remarks'];

for($i = 0; $i<count($_POST['po']); $i++)
{
$po = $_POST['po'][$i];
$vid = $_POST['vid'][$i];
if($type == "vendor")
{
$q = "select broker,brokerid,vendorcode from pp_gateentry where combinedpo = '$po' and id='$vid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$broker = $qr['broker'];
$brokerid = $qr['brokerid'];
$vendorcode = $qr['vendorcode'];
}
}
else if($type == "broker")
{
$q = "select vendor,vendorid,vendorcode from pp_gateentry where combinedpo = '$po' and id='$vid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$vendor = $qr['vendor'];
$vendorid = $qr['vendorid'];
$vendorcode = $qr['vendorcode'];
}
}

 
$itemcode = $_POST['itemcode'][$i];
$description = $_POST['description'][$i];
$aquantity = $_POST['aquantity'][$i];
$rquantity = $_POST['rquantity'][$i];
$shrinkage = $_POST['shrinkage'][$i];
$rateperunit = $_POST['rateperunit'][$i];
$itemunits = $_POST['units'][$i];
$bags = $_POST['bags'][$i];
$bagtype1 = explode('@',$_POST['bagtype'][$i]);
$bagtypecode = $bagtype1[0];
$bagtypedescription = $bagtype1[1];
$bagtypeunits = $bagtype1[2];
$aflag = 0;
$sobiflag = 0;

$credittermcode = $_POST['credittermcode'][$i];
$credittermdescription = $_POST['credittermdescription'][$i];
$credittermvalue = $_POST['credittermvalue'][$i];

$tandccode = $_POST['tandccode'][$i];
$tandc = $_POST['tandc'][$i];

$taxcode = $_POST['taxcode'][$i];
$taxvalue = $_POST['taxvalue'][$i];
$taxamount = $_POST['taxamount'][$i];
$taxformula = $_POST['taxformula'][$i];
$taxie = $_POST['taxie'][$i];

$freightcode = $_POST['freightcode'][$i];
$freightvalue = $_POST['freightvalue'][$i];
$freightamount = $_POST['freightamount'][$i];
$freightformula = $_POST['freightformula'][$i];
$freightie = $_POST['freightie'][$i];

$brokeragecode = $_POST['brokeragecode'][$i];
$brokeragevalue = $_POST['brokeragevalue'][$i];
$brokerageamount = $_POST['brokerageamount'][$i];
$brokerageformula = $_POST['brokerageformula'][$i];
$brokerageie = $_POST['brokerageie'][$i];

$discountcode = $_POST['discountcode'][$i];
$discountvalue = $_POST['discountvalue'][$i];
$discountamount = $_POST['discountamount'][$i];
$discountformula = $_POST['discountformula'][$i];
$discountie = $_POST['discountie'][$i];

$totalamount = $_POST['finalcost'][$i];

$pocost = $_POST['pocost'][$i];
$warehouse = $_POST['warehouse'][$i];
if($taxamount == "" OR $taxamount == 0) $taxamount = 0;
if($freightamount == "" OR $freightamount == 0) $freightamount = 0;
if($discountamount == "" OR $discountamount == 0) $discountamount = 0;
if($brokerageamount == "" OR $brokerageamount == 0) $brokerageamount = 0;

/*
if($taxie == "Exclude") $totalamount = $totalamount + $taxamount;
if($freightie == "Exclude") $totalamount = $totalamount + $freightamount;
if($brokerageie == "Exclude") $totalamount = $totalamount + $brokerageamount;
if($discountie == "Exclude") $totalamount = $totalamount - $discountamount;

*/

//$totalamount = ($aquantity * $rateperunit) + ($taxamount + $freightamount - $discountamount);

///////// INSERT tbl_goodsreceipt////////
if($_SESSION['client'] == 'FEEDATIVES')
{
$batchno = "";
$exp = "";
$query10 = "SELECT cat FROM ims_itemcodes WHERE code = '$itemcode'";
$result10 = mysql_query($query10,$conn) or die(mysql_error());
$rows10 = mysql_fetch_assoc($result10);
$cat = $rows10['cat'];
if($cat == 'Medicines' || $cat == 'Vaccines')
{
$batchno = $_POST['batch'][$i];
$expdate = $_POST['expdate'][$i];
$exp = date("Y-m-d",strtotime($expdate));
}
if($exp == "")
 $exp = date("Y-m-d");
$qinsert = "insert into pp_goodsreceipt (vendorcode ,date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,batchno,expirydate,warehouse,dflag) values ('$vendorcode ','$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$batchno','$exp','$warehouse','1')";
}
else
{
$qinsert = "insert into pp_goodsreceipt (vendorcode,date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,warehouse) values ('$vendorcode ','$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$warehouse')";
}
$qisnertqr = mysql_query($qinsert,$conn) or die(mysql_error());

////////// UPDATE purchaseorder /////////
$q1 = "update pp_gateentry set grflag = '1' WHERE ge = '$ge' and combinedpo = '$po'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());

}



echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_goodsreceipt_a'";
echo "</script>";
?>