<?php 
include "config.php";
include "getemployee.php";
$freeqty=0;
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$bookinvoice = $_POST['bookinvoice'];
if($_POST['saed'] == 1)
{
$invoice = $_POST['invoice'];
$cobiincr = $_POST['cobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];
$query = "DELETE FROM oc_cobi WHERE invoice = '$invoice'";
$result = mysql_query($query,$conn) or die(mysql_error());
}
else
{
$m = $_POST['m'];
$y = $_POST['y'];
$query1 = "SELECT MAX(cobiincr) as cobiincr FROM oc_cobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $cobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$cobiincr = $row1['cobiincr']; 
$cobiincr = $cobiincr + 1;
if ($cobiincr < 10) 
$cobi = 'COBI-'.$m.$y.'-000'.$cobiincr; 
else if($cobiincr < 100 && $cobiincr >= 10) 
$cobi = 'COBI-'.$m.$y.'-00'.$cobiincr; 
else $cobi = 'COBI-'.$m.$y.'-0'.$cobiincr;
$invoice = $cobi;
}
$basic = $_POST['basic'];
$discount = $_POST['disamount'];
$broker = $_POST['broker'];
$vno = $_POST['vno'];
$driver = $_POST['driver'];
$remarks = $_POST['remarks'];
$freighttype = $_POST['freighttype'];
$freight = $_POST['cfamount'];
$viaf = $_POST['cvia'];
$datedf = date("Y-m-d",strtotime($_POST['cdate']));
$cashbankcode = $_POST['cashbankcode'];
$fcoa = $coa = $_POST['coa'];
$cheque = $_POST['cheque'];
$discountamount = $_POST['discountamount'];
$finaldiscountamount = $_POST['finaldiscount'];
$grandtotal = $_POST['tpayment'];
$globalwarehouse = $_POST['aaa'];
$totalquantity = 0;
$cnt = 0;
$cterm = $_POST['cterm'];
$temp = explode('@',$cterm);
$ctermcode = $temp[0];
$ctermdesc = $temp[1];
$ctermvalue = $temp[2];
if($ctermvalue == "") $ctermvalue = 0;

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '' && $_POST['code'][$i] != '')
{
    $warehouse = "";
    $flock = $_POST['flock'][$i];
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];
	
	if($_SESSION['db'] == "alkhumasiyabrd"&&($cat=='Female Feed'||$cat=='Male Feed'))
	  $bagtype = $_POST['bagtype'][$i];
	else
	  $bagtype='Not aplicable';
	  
	 if(($_SESSION['db'] == "alkhumasiyabrd")&&($cat=='Female Feed'||$cat=='Male Feed'))
	  {
	  $q='select capacity from ims_bagdetails where code='."'".$bagtype."'";
	  if($a=mysql_fetch_assoc(mysql_query($q)))
	    $qtyr*=$a[capacity];
	  } 
	if(($_SESSION['db'] == "golden") or ($_SESSION['db'] == "johnson"))
	$unitt = $_POST['unit'][$i];
	$price = $_POST['price'][$i];
	$totalquantity+= $qtyr;

	$query3 = "SELECT warehouse FROM ims_itemcodes WHERE code = '$code' and client = '$client' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  	$warehouse = $row3['warehouse'];

  if($flock == '-Select-')
  {
   $flock = "";
   $warehouse1 = $warehouse;
  }
  else
  {
   $warehouse1 = $flock;
  }
  $empid = 0;
  $mw = $qtyr * $price;
  if($cat == 'Female Birds'||$cat=='Male Birds')
   $weight = $_POST['weight'][$i];
if($weight == "")
$weight = 0;
  //echo $m."/".$basic."/".$discountamount;
$dis = round((($mw/$basic)*($discountamount)),2);


   $q = "insert into oc_cobi (remarks,date,cobiincr,m,y,invoice,bookinvoice,party,broker,code,description,quantity,price,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,flock,bagtype,individualdiscount,weight,credittermcode,credittermdescription,credittermvalue) 
	values('$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$broker','$code','$description','$qtyr','$price','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$flock','$bagtype','$dis','$weight','$ctermcode','$ctermdesc','$ctermvalue')";	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	$cnt = $cnt + 1;

}
$q = "update oc_cobi set totalquantity = '$totalquantity',finaltotal = '$grandtotal' where invoice = '$invoice' and client = '$client' ";
$qr = mysql_query($q,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_directsales'";
echo "</script>";
?>