<?php 
include "config.php";
include "getemployee.php";

$gr = $_POST['id'];
$query = "select * from pp_goodsreceipt where gr = '$gr'";
$resultg = mysql_query($query,$conn) or die(mysql_error());
while($gres2 = mysql_fetch_assoc($resultg))
{
$warehouse = $gres2['warehouse'];


$query = "SELECT * FROM ims_stock WHERE itemcode = '$gres2[code]' and warehouse = '$warehouse'";
$result2 = mysql_query($query,$conn) or die(mysql_error());
$res2=mysql_fetch_assoc($result2);

$updatedqty = ($res2['quantity'] - $gres2['receivedquantity']);

$query = "update ims_stock set quantity = '$updatedqty' where itemcode = '$gres2[code]' and warehouse = '$warehouse'";
$result = mysql_query($query,$conn) or die(mysql_error());

$q1 = "update pp_gateentry set grflag = '0' WHERE ge = '$gres2[ge]' and combinedpo = '$gres2[po]' and code = '$gres2[code]'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());

$query = "delete from ac_financialpostings where trnum = '$gres2[gr]' and type = 'GR' and itemcode = '$gres2[code]' and warehouse = '$warehouse'";
$result = mysql_query($query,$conn) or die(mysql_error());

}

$query = "delete from pp_goodsreceipt where gr = '$gr'";
$result = mysql_query($query,$conn);



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
$r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $vendorcode=$a['code'];
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
if($taxvalue == "") $taxvalue = 0;
if($exp == "")
 $exp = date("Y-m-d");

 $qinsert = "insert into pp_goodsreceipt (vendorcode,date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,batchno,expirydate,warehouse) values ('$vendorcode','$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$batchno','$exp','$warehouse')";
}
else
{
$qinsert = "insert into pp_goodsreceipt (vendorcode,date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,warehouse) values ('$vendorcode','$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$warehouse')";
}
$qisnertqr = mysql_query($qinsert,$conn) or die(mysql_error());

////////// UPDATE purchaseorder /////////
$q1 = "update pp_gateentry set grflag = '1' WHERE ge = '$ge' and combinedpo = '$po'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());

}

/**********Authorization****************/

$gr = $gr1;
$adate = date("Y-m-d",strtotime($_POST['date']));
$venname = $vendor;

for($j = 0;$j<count($_POST['po']);$j++)
 {
 $po = $_POST['po'][$j];
  $itemcode = $_POST['itemcode'][$j]; 
 
  //$warehouse = $_POST['warehouse'][$j]; 
   $units = $_POST['units'][$j]; 
  $warehouse =$_POST['warehouse'][$j];
  $acceptedquantity = $_POST['aquantity'][$j]; //$_POST['acceptedquantity'][$j];
  $receivedqty = $_POST['rquantity'][$j];
  
/*  $query1 = "SELECT deliverylocation,unit FROM pp_purchaseorder WHERE po = '$po' AND code = '$itemcode'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
 $warehouse = $rows['deliverylocation'];
}
if($warehouse == "")
 $warehouse = 'Godown1';*/

  ///stock update/////////////
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode'  and client = '$client' and warehouse = '$warehouse' ";

  $result3 = mysql_query($query3,$conn);
   $numrows3 = mysql_num_rows($result3);
	  if($numrows3 == 0)
	  {
	  $query31 = "select * from ims_itemcodes where code = '$itemcode' and client = '$client'";
	 	   $result31 = mysql_query($query31,$conn) or die(mysql_error());
	   $rows31 = mysql_fetch_assoc($result31);
	   $unit = $rows31['sunits'];
	  $query32 = "insert into ims_stock(id,warehouse,itemcode,unit,quantity,client) values(NULL,'$warehouse','$itemcode','$unit',0,'$client')";
	 
	   $result32 = mysql_query($query32,$conn) or die(mysql_error());
	  }
	   
	   
	$result3 = mysql_query($query3,$conn); 
  while($row3 = mysql_fetch_assoc($result3))
  {
   	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  

  if($stockunit == $units)
  {
      //$stockqty = $stockqty + $acceptedquantity;  
	   $stockqty = $stockqty + $receivedqty; 
	    
  }
  else
  {
      //$stockqty = $stockqty + convertqty($acceptedquantity,$units,$stockunit,1);
	   $stockqty = $stockqty + convertqty($receivedqty,$units,$stockunit,1);
	   
  }
  

  $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$itemcode' and warehouse = '$warehouse'";

  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  }
  ///////////end of stock update//////////////
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_goodsreceipt_a'";
echo "</script>";
?>