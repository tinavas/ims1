<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['bookinvoice'];

$cobiincr = $_POST['cobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];

$basic = $_POST['basic'];
$discount = $_POST['disamount'];
$broker = $_POST['broker'];
$vno = $_POST['vno'];
$driver = $_POST['driver'];

$freighttype = $_POST['freighttype'];
$freight = $_POST['cfamount'];
$freightamount = $_POST['cfamount'];
$viaf = $_POST['cvia'];
$datedf = date("Y-m-d",strtotime($_POST['cdate']));
$cashbankcode = $_POST['cashbankcode'];
$coa = $_POST['coa'];
$cheque = $_POST['cheque'];
$discountamount = $_POST['discountamount'];
$vendor = $party;
$grandtotal = $_POST['tpayment'];
$totalquantity = 0;
$cnt = 0;
for($i = 0;$i < count($_POST['price']);$i++)
{
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != ''  && $_POST['code'][$i] != '')
{
$cnt = $cnt + 1;
}
}
$discountdiv = round(($discount/$cnt),2);

$adate = date("Y-m-d",strtotime($_POST['date']));
$so = $invoice;

$type = "COBI";

	$q = "select distinct(ca) as code1 from contactdetails where name = '$vendor' order by ca";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];



for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != ''  && $_POST['code'][$i] != '')
{
      $warehouse = $_POST['flock'][$i];
	  $unit = $_POST['unit'][$i];
	$cat = $_POST['cat'][$i];
	$flock = $_POST['flock'][$i];
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];

	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
	$itemcost = $quantity * $rateperunit;

	//$bags = $_POST['bags'][$i];
	//$bagtype = $_POST['bagtype'][$i];
	$price = $_POST['price'][$i];
	$free = $_POST['free'][$i];
	//$vat = $_POST['vat'][$i];
	//$taxamount = $_POST['taxamount'][$i];
	//if($taxamount == "Infinity")
	//$taxamount = 0;
	$totalquantity+= $qtyr;

  if($warehouse == "")
 {
	$query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
    $result3 = mysql_query($query3,$conn);
    while($row3 = mysql_fetch_assoc($result3))
    {
  	$warehouse = $row3['warehouse'];
	
    }
 }

  $empid = 0;
	$q = "insert into oc_cobi (flock,date,cobiincr,m,y,invoice,bookinvoice,party,broker,code,description,quantity,price,freechicks,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,unit) 
	values('$flock','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$broker','$code','$description','$qtyr','$price','$free','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$units','$warehouse','$unit')";
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());


$stdcost = 0;
$cogsac = "";
$itemac = "";
$sac = "";
  $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stdcost = $row3['stdcost'];	
	$cogsac = $row3['cogsac'];
	$itemac = $row3['iac'];
	$sac = $row3['sac'];
	//$warehouse = $row3['warehouse'];
  }

$query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' and warehouse = '$warehouse' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
	
  }
 
  
   $query3 = "SELECT * FROM oc_cobi where invoice = '$invoice' and code = '$code' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	 $freighttype = $row3['freighttype'];
	 $units = $row3['units'];
  }
 
  if($stockunit == $units)
  {
      $stockqty = $stockqty - $quantity;    
  }
  else
  {
      $stockqty = $stockqty - convertqty($quantity,$units,$stockunit,1);
  }
  $mainitemcost = $itemcost;
   if($i == ($cnt - 1))
  {
  $discountdiv1 = $discountamount - ($discountdiv * ($cnt - 1));
  $mainitemcost = $mainitemcost - $discountdiv1;
  $freightdiv1 = $freightamount - ($freightdiv * ($cnt - 1));
 
  }
  else
  {
  $mainitemcost = $mainitemcost - $discountdiv;
  }
  
 // $mainitemcost = $mainitemcost - $discountdiv;
  
  if ( $freighttype == "Excluded")
  {
    // $mainitemcost = $mainitemcost - $freightdiv;
  }
  if ( $freighttype == "Included")
  {
    // $mainitemcost = $mainitemcost + $freightdiv;
  }
  $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$code' and warehouse = '$warehouse' ";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  ///////////end of stock update//////////////
   $stdcost = $stdcost * $quantity;
	////Item Account Credit
$dummyquantity = 0;
$stdcost = round($stdcost,3);
     $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$quantity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

   /// COGS A/C Debit
   
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$cogsac."','".$quantity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	///Sales A/C Credit
	$mainitemcost = round($mainitemcost,3);
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$sac."','$dummyquantity','".$mainitemcost."','".$so."','".$type."','".$vendor."','".$warehouse."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	///Freight A/C debit/credit
	
	
	///Discount A/C debit



}
if ( $freightamount > 0)
{
   if( $freighttype == "Included")
   {
      $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Dr','".$coa."','0','".$freightamount."','".$so."','".$type."','".$vendor."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$cashbankcode."','0','".$freightamount."','".$so."','".$type."','".$vendor."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
   }
   else if ( $freighttype == "Excluded" )
   {
      $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coa."','0','".$freightamount."','".$so."','".$type."','".$vendor."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
   }
}

$q = "update oc_cobi set totalquantity = '$totalquantity',finaltotal = '$grandtotal',flag = '1' where invoice = '$invoice'";
$qr = mysql_query($q,$conn) or die(mysql_error());



$grandtotal = round($grandtotal,3);
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Dr','".$code1."','$totalquantity','".$grandtotal."','".$so."','".$type."','".$vendor."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 $cnt = count($_POST['itemcode']);
$freightdiv = $freightamount/$cnt;
$discountdiv = $discountamount/$cnt;


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_directsales';";
echo "</script>";


?>