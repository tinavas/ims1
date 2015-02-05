<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d", strtotime($_POST['date']));
$party = $_POST['party'];
$partycode = $_POST['partycode'];
$ps = $_POST['ps'];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['invoice1'];
$finaltotal = $_POST['finaltotal1'];
$narration = $_POST['remarks'];
$entrydate = date("Y-m-d");
   $m =  $_POST['m'];
   $y = $_POST['y'];
   $cobiincr = $_POST['cobiincr'];
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];

$strdot1 = explode('-',$date); 
$ignore = $strdot1[2]; 
$m = $strdot1[1];
$y = substr($strdot1[0],2,4); 
$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$cobiincr = $row1['cobiincr']; 
$cobiincr = $cobiincr + 1;
if ($cobiincr < 10) 
$cobi = "COBI-".$m.$y.'-000'.$cobiincr.$code; 
else if($cobiincr < 100 && $cobiincr >= 10) 
$cobi = "COBI-".$m.$y.'-00'.$cobiincr.$code; 
else if($cobiincr < 1000 && $cobiincr >= 100) 
$cobi = "COBI-".$m.$y.'-0'.$cobiincr.$code; 
else $cobi = "COBI-".$m.$y.'-'.$cobiincr.$code;
$invoice = $cobi;

$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");
for($i=0;$i<count($_POST['sentquantity']);$i++)
{
  if($_POST['price'][$i] != "" && $_POST['sentquantity'][$i] > 0)
  {
   $code = $_POST['itemcode'][$i];
   $description = $_POST['description'][$i];
   $cquantity = $_POST['sentquantity'][$i];
   $cunits = $_POST['units'][$i];
   $cprice = $_POST['price'][$i];
  
  // Getting the storage details from pack slip
  
  $psq="select sunits,squantity,sprice,convunit from oc_packslip where ps='$ps' and itemcode='$code'";
  
  $psq=mysql_query($psq) or die(mysql_error());
  
  $psq=mysql_fetch_assoc($psq);
  
  $quantity=$psq['squantity'];
  
  $units=$psq['sunits'];
  
  $price=$psq['sprice'];
  
  $convunit=$psq['convunit'];
  
  //-----------------getting inforamtion end here---------
  
   $totalquantity += $quantity;
   
   
  // $coacode = $_POST['coacode'][$i];
   $taxcode = $_POST['taxcode'][$i];
   $taxvalue = $_POST['taxvalue'][$i];
   $taxamount = $_POST['taxamount'][$i];
   $taxformula = $_POST['taxformula'][$i];
   $taxie = $_POST['taxie'][$i];
   
   $freightcode = $_POST['freightcode'][$i];
   $freightvalue = $_POST['freightvalue'][$i];
   $freightamount = $_POST['freightamount'][$i];
  
   $freightie = $_POST['freightie'][$i];
   
   $cashcode=$_POST['cashcode'][$i];


  
   $discountvalue = $_POST['discountvalue'][$i];
   $discountamount = $_POST['discountamount'][$i];
  
   
   $warehouse = $_POST['warehouse'];   
   
   $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$cat = $row3['cat'];
	
  }

   $total = $_POST['total'][$i];
 
 
   
   $q = "insert into oc_cobi (date,party,partycode,ps,invoice,bookinvoice,code,description,quantity,units,price,taxcode,taxvalue,taxamount,taxformula,taxie,freightcode,freightvalue,freightamount,freightformula,freightie,discountcode,discountvalue,discountamount,discountformula,total,finaltotal,balance,dflag,m,y,cobiincr,flag,warehouse,remarks,empid,empname,sector,empdate,totalfreightamount,adate,cashcode,cunits,pricec,cquantity,convunits) values('$date','$party','$partycode','$ps','$invoice','$bookinvoice','$code','$description','$quantity','$units','$price','$taxcode','$taxvalue','$taxamount','$taxformula','$taxie','$freightcode','$freightvalue','$freightamount','$freightformula','$freightie','$discountcode','$discountvalue','$discountamount','$discountformula','$total','$finaltotal','$finaltotal',1,$m,$y,$cobiincr,'0','$warehouse','$narration','$empid','$empname','$sector','$entrydate','$freightamount','$adate','$cashcode','$cunits','$cprice','$cquantity','$convunit')";
  $qrs = mysql_query($q,$conn) or die(mysql_error());
  }
}
 $q = "UPDATE oc_cobi SET totalquantity = '$totalquantity' WHERE invoice = '$invoice'";
$result = mysql_query($q,$conn) or die(mysql_error());



$type = "COBI";
 $query = "select * from oc_cobi where invoice = '$invoice'  ORDER BY id";
$result = mysql_query($query,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($result))
{

 $finaltotal = 0;$total = 0;
   $basic = $qr['quantity'] * $qr['price']; 
   $finaltotal = $qr['finaltotal'];
   $total = round($qr['total'],2);
   $taxcode = $qr['taxcode'];
   $taxamount = round($qr['taxamount'],2);
$freightcode = $qr['freightcode'];

$cashcode=$qr['cashcode'];
   $freightamount = round($qr['freightamount'],2);
   $discountcode = $qr['discountcode'];
  $discountamount = round($qr['discountamount'],2);
  $freightie=$qr['freightie'];
  $taxie=$qr['taxie'];
   $acceptedquantity = $qr['quantity'];
  
   $adate = $date = $qr['date'];
   $itemcode = $qr['code'];
   $invoice = $qr['invoice'];
   $customer = $qr['party'];
   $customercode = $qr['partycode'];
   $warehouse = $qr['warehouse'];
   
   $salesamount = $basic-$discountamount;
   if($taxie=="Include")
    $salesamount= $salesamount-$taxamount;
	
	
   
$query2 = "SELECT * FROM contactdetails WHERE name = '$customer' ";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
$drcode = $row2['ca']; 


  $query2 = "SELECT sac FROM ims_itemcodes WHERE code = '$itemcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	 $sac = $row2['sac'];

  $query2 = "SELECT coa FROM ims_taxcodes WHERE code = '$taxcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];




	
	
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Cr','".$sac."','".$acceptedquantity."','".$salesamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());
    
	
if($taxamount > 0)
  {
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$adate."','".$taxcode."','Cr','".$ta."','".$acceptedquantity."','".$taxamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }
  

 if($freightamount > 0)
  {

  if($freightie=="Include" || $freightie=="Includepaidbycustomer")
  {
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$freightcode."','Dr','".$fa."','".$acceptedquantity."','".$freightamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());
  }
  
if($freightie=="Include" || $freightie=="Exclude")
  
{




  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','".$itemcode."','Cr','".$cashcode."','".$acceptedquantity."','".$freightamount."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());
  
  
  }
  
  
  }


if($freightie=="Includepaidbycustomer")
$finaltotal=$finaltotal-$freightamount;

}




	  
$query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
             VALUES('".$adate."','$itemcode','Dr','".$drcode."','0','".$finaltotal."','".$invoice."','".$type."','".$customer."','$warehouse')";
  $result3 = mysql_query($query3,$conn) or die(mysql_error());
  




$adate = date("Y-m-d");
$userlogged = $_SESSION['valid_user'];
$query1 = "SELECT employeename,sector FROM common_useraccess where username= '$userlogged' ORDER BY username ASC LIMIT 1";
$result1 = mysql_query($query1,$conn) or die(mysql_error()); 
while($row11 = mysql_fetch_assoc($result1))
{
	$empname = $row11['employeename'];
	$sector = $row11['sector'];
	$aempid = $row11['employeeid'];
}






$query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where invoice = '$invoice'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
$invoice = str_replace("'","",$invoice);

$query5 = "UPDATE oc_packslip SET cobiflag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where ps = '$ps'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
$invoice = str_replace("'","",$invoice);


$query = "INSERT INTO authorization (id,type,trnum,adate,name,sector,client) VALUES (NULL,'$type','$tids','$adate','$empname','$sector','$client')";
$result = mysql_query($query,$conn) or die(mysql_error());

 $query = "SELECT id FROM authorization WHERE type = '$type' AND trnum = '$invoice' ORDER BY id DESC LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$id = $rows['id'];



echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_cobi'";
echo "</script>";

?>