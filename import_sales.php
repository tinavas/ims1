<?php
include "config.php";
include "getemployee.php";

for($i = 0; $i <count($_POST['party']); $i++)
{
 if($_POST['party'][$i] <> "" && $_POST['code'][$i] <> "")
 {
  $date = date("Y-m-d",strtotime($_POST['date'][$i]));
  $party = $_POST['party'][$i];
  $bi = $_POST['bookinvoice'][$i];
  
  if($date == $prevdate && $party == $prevparty && $bi == $prevbi)
	$nextrow = 1;	//It means it has multiple rows for single purchase
  else
  { 
	$m = date("m",strtotime($date));
	$y = date("y",strtotime($date));
	$discount = $_POST['discount'][$i];
	if($discount == "")
	 $discount = 0;
	$vno = $_POST['vno'][$i];
	$driver = $_POST['driver'][$i];
	$narration = $_POST['narration'][$i];
	$totqty = $_POST['totqty'][$i];
	$grandtotal = $_POST['grandtotal'][$i];
	$noofrows = $_POST['noofrows'][$i];
	$count = 0;
	$totsac_amount = 0;
	$nextrow = 0;
	//To get COBI number
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
  $code = $_POST['code'][$i];
  $qty = $_POST['qty'][$i];
  $price = $_POST['rate'][$i];
  $warehouse = $_POST['warehouse'][$i];
  $total = $qty * $price;
  $basic = $grandtotal + $discount;
  $ind_dis = $total /$basic * $discount; 
  $count++;
 
 
  
	$query = "select description,sunits,iac,stdcost,cogsac,sac from ims_itemcodes where code = '$code'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$itemrows = mysql_num_rows($result);
	$rows = mysql_fetch_assoc($result);
	$description = $rows['description'];
	$units = $rows['sunits'];				
	$stdcost = $rows['stdcost'];
	$iac = $rows['iac'];
	$cogsac = $rows['cogsac'];
	$sac = $rows['sac'];
  
  $q = "INSERT INTO oc_cobi (date,cobiincr,m,y,invoice,bookinvoice,party,code,description,quantity,price,freightamount,discountamount,total,totalquantity,finaltotal,balance,empid,empname,sector,flag,units,warehouse,dflag,client,adate,aempid,aempname,asector,bagtype,unit,individualdiscount,credittermcode,credittermdescription,credittermvalue) VALUES ('$date','$cobiincr','$m','$y','$cobi','$bi',\"$party\",'$code','$description','$qty','$price','0','$discount','$basic','$totqty','$grandtotal','$grandtotal','$empid','$empname','$sector','1','$units','$warehouse','0','$client','$date','$empid','$empname','$sector','','$warehouse',$ind_dis,'','','0')";
	$r = mysql_query($q,$conn) or die(mysql_error());

//Financial Postings-Customer A/c
$type = "COBI";
if($nextrow == 0)
{
	$q = "select distinct(ca) as code1 from contactdetails where name = \"$party\" AND type LIKE '%party%' and client = '$client'  order by ca";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $code1 = $qr['code1'];

	$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client)        VALUES('$date','','Dr','$code1','$totqty','$grandtotal','$invoice','$type',\"$party\",'$warehouse','$client')";
	$result4 = mysql_query($query4,$conn) or die(mysql_error());
}

$itemcost = $stdcost * $qty;
//Financial Postings Item A/c
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client)  VALUES('$date','$code','Cr','$iac','$qty','$itemcost','$invoice','$type',\"$party\",'$warehouse','$client')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

//Financial Postings COGS A/c
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) VALUES('$date','$code','Dr','$cogsac','$qty','$itemcost','$invoice','$type',\"$party\",'$warehouse','$client')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

if($count == $noofrows)
 $sac_amount = $grandtotal - $totsac_amount;
else
 $sac_amount = $total + round(($total / $basic * $discount),2);
$totsac_amount += $sac_amount;
 
//Financial Postings Sales A/c
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) VALUES('$date','','Cr','$sac','$qty','$sac_amount','$invoice','$type',\"$party\",'$warehouse','$client')";
$result4 = mysql_query($query4,$conn) or die(mysql_error());

  $prevdate = $date;
  $prevparty = $party;
  $prevbi = $bi;
 }	
}
header("Location:dashboardsub.php?page=tally_sales");
?>