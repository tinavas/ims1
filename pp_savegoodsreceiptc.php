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
if($_POST['saed'] == 1)
{
$id = $gr1;
$gquery = "select po,ge,code,warehouse from pp_goodsreceipt where gr = '$id'";
$gresult = mysql_query($gquery,$conn) or die(mysql_error());
while($gres = mysql_fetch_assoc($gresult))
{
 $warehouse = $gres['warehouse'];
 $q1 = "update pp_gateentry set grflag = '0' WHERE ge = '$gres[ge]' and combinedpo = '$gres[po]' and code = '$gres[code]'";
 $q1rs = mysql_query($q1,$conn) or die(mysql_error());
}
$query = "delete from pp_goodsreceipt where gr = '$id'";
$result = mysql_query($query,$conn);
}

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
$q = "select broker,brokerid from pp_gateentry where combinedpo = '$po' and id='$vid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$broker = $qr['broker'];
$brokerid = $qr['brokerid'];
}
}
else if($type == "broker")
{
$q = "select vendor,vendorid from pp_gateentry where combinedpo = '$po' and id='$vid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$vendor = $qr['vendor'];
$vendorid = $qr['vendorid'];
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

///////// INSERT tbl_goodsreceipt////////

$qinsert = "insert into pp_goodsreceipt (date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,warehouse) values ('$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$warehouse')";
$qisnertqr = mysql_query($qinsert,$conn) or die(mysql_error());

////////// UPDATE purchaseorder /////////
$q1 = "update pp_gateentry set grflag = '1' WHERE ge = '$ge' and combinedpo = '$po'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());

}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_goodsreceipt'";
echo "</script>";
?>