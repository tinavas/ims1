<?php
include "getemployee.php";
include "config.php";
//updating  pp_gateentry
$ge = $_POST['id'];

$aflag = 1;
$query = "select combinedpo,code,warehouse,receivedquantity,aflag from pp_gateentry where ge = '$ge'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
$po = $res['combinedpo'];
$itemcode = $res['code'];
$warehouse = $res['warehouse'];
if($_SESSION['db'] == "central" or $_SESSION['db'] == "alwadi")
 $aflag = $res['aflag'];

$q1 = "UPDATE pp_purchaseorder SET geflag = '0',receivedquantity = receivedquantity - $res[receivedquantity],acceptedquantity = acceptedquantity - $res[receivedquantity] WHERE po = '$po' AND code = '$itemcode' and deliverylocation = '$warehouse'";
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());

}

$query = "delete from pp_gateentry where ge='$ge'";
$result = mysql_query($query,$conn) or die(mysql_error());

//saving New entries
$previouspo = "";
$grflag = '0';
$round = "0";
$arraycheckfloag = 0;
$al = 0;
$date = date("Y-m-d",strtotime($_POST['date']));
$ge = $_POST['ge'];
$geincr = $_POST['geincr'];
$m = $_POST['m'];
$y = $_POST['y'];
$type = $_POST['type'];
if($type == "vendor")
{
$vendor = $_POST['vendor'];
}
else if($type == "broker")
{
$broker = $_POST['vendor'];
}

$vendorid = '0';
$vehicleno = $_POST['vehicleno'];
 $warehouse = $_POST['warehouse'];



for($i = 0; $i < count($_POST['itemcode']);$i++)
{
 if($_POST['quantity'][$i] != '')
 {
  $itemcode = $_POST['itemcode'][$i];
  $description = $_POST['description'][$i];
  $weight = $_POST['quantity'][$i];
  $bird = $_POST['bird'][$i];
  
  $qc = $_POST['qc'][$i];
  
  if($qc == "Yes")
  {
  $flag  = '0';
  $qcflag  = '0';
  }
  else 
  {
  $flag = '1';
  $qcflag = '1';
  }

  $po1 = $_POST['hpo'][$i];
  $poa = explode(',',$po1);
 
  //for($j = 0; $j < sizeof($poa);$j++)
  $temp = explode('@',$_POST['po'][$i]);
  $po = $posel = $temp[0];
  {
  $q = "select * from pp_purchaseorder where po = '$posel' and code = '$itemcode' and deliverylocation = '$warehouse'";   
   $qrs2 = mysql_query($q,$conn) or die(mysql_error());
   while($qres = mysql_fetch_assoc($qrs2))
   {
   
     $vendorcode=$qres['vendorcode'];
      if($type == "vendor")
      {
        $brokerid = $qres['brokerid'];
        $broker = $qres['broker'];
      }
      else if($type == "broker")
      {
       $vendor = $qres['vendor'];
       $vendorid = $qres['vendorid'];
      }
      
      $quantity = $qres['quantity']; 
	  $per = $_POST['quantity'][$i] / $quantity;

	  $credittermcode = $qres['credittermcode'];
      $credittermdescription = $qres['credittermdescription'];
      $credittermvalue = $qres['credittermvalue'];
      $tandccode = $qres['tandccode'];
      $tandc = $qres['tandc'];
	  if($_SESSION['db'] == "feedatives")
	   $rateperunit = $_POST['price'][$i];
	  else 
	   $rateperunit = $qres['rateperunit']; 
	  $unit = $qres['unit']; 
      $basic = $_POST['quantity'][$i] * $rateperunit;
    
	  $taxcode = $qres['taxcode'];
	  $taxvalue = $qres['taxvalue'];
      $taxamount = $qres['taxamount'] * $per;
	  $taxformula = $qres['taxformula'];
      $taxie = $qres['taxie'];

	  $freightcode = $qres['freightcode'];
	  $freightvalue = $qres['freightvalue'];
      $freightamount = $qres['freightamount'] * $per;
	  $freightformula = $qres['freightformula'];
      $freightie = $qres['freightie'];
	
      $brokeragecode = $qres['brokeragecode'];
	  $brokeragevalue = $qres['brokeragevalue'];
      $brokerageamount = $qres['brokerageamount'] * $per;
	  $brokerageformula = $qres['brokerageformula'];
      $brokerageie = $qres['brokerageie'];

	  $discountcode = $qres['discountcode'];
	  $discountvalue = $qres['discountvalue'];
      $discountamount = $qres['discountamount'] * $per;
	  $discountformula = $qres['discountformula'];
      $discountie = $qres['discountie'];

      //$finalcost = $qres['finalcost'];
	  $finalcost = ($_POST['quantity'][$i] * $rateperunit) + $taxamount + $freightamount + $brokerageamount - $discountamount;
      $pocost += $finalcost;
	  $receivedquantity = $qres['quantity'];
      if($qc == "Yes") $acceptedquantity = '0';
      else $acceptedquantity = $_POST['quantity'][$i];
    
if($pocost == "")
$pocost = 0;
	 if($_SESSION['db']=="vista") 
	 $q = "insert into pp_gateentry (vendorcode,geincr,m,y,date,code,desc1,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,combinedpo,qc,ge,vehicleno,weight,flag,aflag,qcaflag,grflag,taxcode,taxvalue,taxie,taxamount,taxformula,freightcode,freightvalue,freightie,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageie,brokerageamount,brokerageformula,discountcode,discountvalue,discountie,discountamount,discountformula,quantity,receivedquantity,acceptedquantity,rateperunit,unit,finalcost,pocost,tandccode,tandc,empid,empname,sector,basic,warehouse,bird) values('$vendorcode','$geincr','$m','$y','$date','$itemcode','$description','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$po','$qc','$ge','$vehicleno','$weight','$flag','$aflag','$qcflag','$grflag','$taxcode','$taxvalue','$taxie','$taxamount','$taxformula','$freightcode','$freightvalue','$freightie','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountie','$discountamount','$discountformula','$quantity','$acceptedquantity','$acceptedquantity','$rateperunit','$unit','$finalcost','$pocost','$tandccode','$tandc','$empid','$empname','$sector','$basic','$warehouse','$bird')";
	 
	 else
	 $q = "insert into pp_gateentry (vendorcode,geincr,m,y,date,code,desc1,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,combinedpo,qc,ge,vehicleno,weight,flag,aflag,qcaflag,grflag,taxcode,taxvalue,taxie,taxamount,taxformula,freightcode,freightvalue,freightie,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageie,brokerageamount,brokerageformula,discountcode,discountvalue,discountie,discountamount,discountformula,quantity,receivedquantity,acceptedquantity,rateperunit,unit,finalcost,pocost,tandccode,tandc,empid,empname,sector,basic,warehouse) values('$vendorcode','$geincr','$m','$y','$date','$itemcode','$description','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$po','$qc','$ge','$vehicleno','$weight','$flag','$aflag','$qcflag','$grflag','$taxcode','$taxvalue','$taxie','$taxamount','$taxformula','$freightcode','$freightvalue','$freightie','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountie','$discountamount','$discountformula','$quantity','$acceptedquantity','$acceptedquantity','$rateperunit','$unit','$finalcost','$pocost','$tandccode','$tandc','$empid','$empname','$sector','$basic','$warehouse')";
	 
	 
  
    $qrs = mysql_query($q,$conn) or die(mysql_error());
		
    
  $q1 = "UPDATE pp_purchaseorder SET receivedquantity = receivedquantity + $acceptedquantity,acceptedquantity =  acceptedquantity + $acceptedquantity WHERE po = '$po' AND code = '$itemcode' and deliverylocation = '$warehouse'";
 
  $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   }//end of inner while
  }//end of inner for
 }//end of outer if
}//end of outer for

$q = "update pp_gateentry set pocost = '$pocost',finalcost = '$pocost',aflag = '$aflag',adate = '$date', aempid = '$empid', aempname = '$empname', asector = '$sector' where ge = '$ge'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

header('Location:dashboardsub.php?page=pp_gateentry');
?>