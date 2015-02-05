<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d", strtotime($_POST['date']));
$party = $_POST['party'];
$ps = $_POST['ps'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['invoice1'];
$finaltotal = $_POST['finaltotal1'];  
for($i=0;$i<count($_POST['sentquantity']);$i++)
{
  if($_POST['price'][$i] != "")
  {
   $code = $_POST['itemcode'][$i];
   $description = $_POST['description'][$i];
   $quantity = $_POST['sentquantity'][$i];
   $units = $_POST['units'][$i];
   $price = $_POST['price'][$i];
   $coacode = $_POST['coacode'][$i];

   $taxcode = $_POST['taxcode'][$i];
   $taxvalue = $_POST['taxvalue'][$i];
   $taxamount = $_POST['taxamount'][$i];
   $taxformula = $_POST['taxformula'][$i];
   
   $freightcode = $_POST['freightcode'][$i];
   $freightvalue = $_POST['freightvalue'][$i];
   $freightamount = $_POST['freightamount'][$i];
   $freightformula = $_POST['freightformula'][$i];

   $brokeragecode = $_POST['brokeragecode'][$i];
   $brokeragevalue = $_POST['brokeragevalue'][$i];
   $brokerageamount = $_POST['brokerageamount'][$i];
   $brokerageformula = $_POST['brokerageformula'][$i];

   $discountcode = $_POST['discountcode'][$i];
   $discountvalue = $_POST['discountvalue'][$i];
   $discountamount = $_POST['discountamount'][$i];
   $discountformula = $_POST['discountformula'][$i];
   
   $warehouse = $_POST['warehouse'];
   
   $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$cat = $row3['cat'];
	
  }
   
   if ( $cat == "Feed")
	{}

   $total = $_POST['total'][$i];
   $m =  $_POST['m'];
   $y = $_POST['y'];
   $cobiincr = $_POST['cobiincr'];
  
   $q = "insert into oc_cobi (date,party,ps,invoice,bookinvoice,code,description,quantity,units,price,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageamount,brokerageformula,discountcode,discountvalue,discountamount,discountformula,total,coacode,finaltotal,balance,dflag,m,y,cobiincr,bags,warehouse) 
                       values('$date','$party','$ps','$invoice','$bookinvoice','$code','$description','$quantity','$units','$price','$taxcode','$taxvalue','$taxamount','$taxformula','$freightcode','$freightvalue','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountamount','$discountformula','$total','$coacode','$finaltotal','$finaltotal',1,$m,$y,$cobiincr,'$bags','$warehouse')";
  $qrs = mysql_query($q,$conn) or die(mysql_error());
  }
}

$q = "update oc_packslip set cobiflag = '1' where ps = '$ps'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
/********Authorizatio Starts here*********/

//$invoice = $_POST['invoice'];
//$ps = $_POST['ps'];
$q = "select ps,party from oc_cobi where invoice = '$invoice'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
$ps = $qr['ps'];
$customer = $qr['party'];
}
$adate = date("Y-m-d",strtotime($_POST['date']));

$query2 = "SELECT * FROM contactdetails WHERE name = '$customer'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
$drcode = $row2['ca']; 


for($j=0;$j<count($_POST['sentquantity']);$j++)
{
  if($_POST['price'][$j] != "")
  {
  $itemcode = $_POST['itemcode'][$j];
  $acceptedquantity = $_POST['sentquantity'][$j];
  
  $total = 0;
  $q = "select quantity,rateperunit,totalcost,taxamount,brokerageamount,discountamount,freightamount from oc_packslip where ps = '$ps' and itemcode = '$itemcode'";
  $qrs = mysql_query($q,$conn) or die(mysql_error());
  while($qr = mysql_fetch_assoc($qrs))
  {
   $basic = $qr['quantity'] * $qr['rateperunit']; 
   $total = $qr['totalcost'];
   $taxcode = $qr['taxcode'];
   $taxamount = $qr['taxamount'];
   $freightcode = $qr['freightcode'];
   $freightamount = $qr['freightamount'];
   $discountcode = $qr['discountcode'];
   $discountamount = $qr['discountamount'];
 
  }
     $warehouse = $_POST['warehouse'];
  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	 $sac = $row2['sac'];

  $query2 = "SELECT * FROM ims_taxcodes WHERE code = '$taxcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];

  $query2 = "SELECT * FROM ims_taxcodes WHERE code = '$freightcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $fa = $row2['coa'];

  $query2 = "SELECT * FROM ims_taxcodes WHERE code = '$brokeragecode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ba = $row2['coa'];

  $query2 = "SELECT * FROM ims_taxcodes WHERE code = '$discountcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $da = $row2['coa'];


  $type = 'COBI';
  $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Dr','".$drcode."','".$acceptedquantity."','".$total."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result3 = mysql_query($query3,$conn) or die(mysql_error());

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Cr','".$sac."','".$acceptedquantity."','".$basic."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  if($taxamount > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Cr','".$ta."','".$acceptedquantity."','".$taxamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }
 if($freightamount > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Cr','".$fa."','".$acceptedquantity."','".$freightamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }

  if($discountamount > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Dr','".$da."','".$acceptedquantity."','".$discountamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }

}
}

$query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empid = '$empid',empname = '$empname',sector = '$sector' where invoice = '$invoice'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


/*****Authorization ends here **************/

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_cobi'";
echo "</script>";

?>