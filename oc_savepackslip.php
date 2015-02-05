<?php 
include "config.php";
include "getemployee.php";

$flag = '0'; 
$cobiflag = '0';
$so = $_POST['so'];
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];

$date1 = date("d.m.Y",strtotime($_POST['date']));
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(psincr) as psincr FROM oc_packslip where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $psincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$psincr = $row1['psincr']; 
$psincr = $psincr + 1;
if ($psincr < 10) 
 $ps1 = 'PS-'.strtoupper($_SESSION['valid_user']).'-'.$dbcode.'-'.$empcode.'-'.$m.$y.'-000'.$psincr.$code; 
else if($psincr < 100 && $psincr >= 10) 
$ps1 = "PS-".strtoupper($_SESSION['valid_user']).'-'.$dbcode.'-'.$empcode.$m.$y.'-00'.$psincr.$code; 
else $ps1 = "PS-".strtoupper($_SESSION['valid_user']).'-'.$dbcode.'-'.$empcode.$m.$y.'-0'.$psincr.$code;
$addempid = $empid;
$addempname = $empname;
$addempsector = $sector;		

if($_POST['saed'] == 1)
{
 $ps1 = $_POST['ps'];
 $psincr = $_POST['psincr'];
 $m = $_POST['m'];
 $y = $_POST['y'];
 $eempid = $empid;
 $eempname = $empname;
 
  $query = "SELECT itemcode,quantity,ordermode,packets,empid,empname,empdate,sector,adate,aempid,aempname,asector FROM oc_packslip WHERE ps='$ps1' ORDER BY itemcode";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
 if($rows['ordermode'] == "Packets")
 {
 $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[packets] WHERE code = '$rows[itemcode]' AND po='$so'";
 }
 else
 {
  $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[quantity] WHERE code = '$rows[itemcode]' AND po='$so'";
 }
 $audate = $rows['adate'];
 $auempid = $rows['aempid'];
 $auempname = $rows['aempname'];
 $ausector = $rows['asector'];
 $addempid = $rows['empid'];
 $addempname = $rows['empname'];
 $addempsector = $rows['sector'];
 $entrydate = $rows['empdate'];
   mysql_query($query1,$conn) or die(mysql_error());
 }
 
 $query = "DELETE FROM oc_packslip WHERE ps = '$ps1'";
 mysql_query($query,$conn) or die(mysql_error());
 $query = "DELETE FROM ac_financialpostings WHERE trnum = '$ps1' AND type = 'PS'";
 mysql_query($query,$conn) or die(mysql_error());
}	
$warehouse = $_POST['warehouse'];

$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$partycode = $_POST['partycode'];
$so = $_POST['so'];
$transporter = $_POST['transporter'];
$transport = $_POST['transport'];
$tme = $_POST['tme'];
$vehicleno = strtoupper($_POST['vehicleno']);
$driver = ucwords($_POST['driver']);
$freight = $_POST['freight'];

for($i = 0; $i<count($_POST['quantity']); $i++)
{
if($_POST['quantity'][$i] >0)
{
$quantity = $_POST['quantity'][$i];
$packets = $_POST['packets'][$i];
if($packets == 'NA' || $packets == '')
{
$packets = 0;
}
$rateperunit = $_POST['rateperunit'][$i];
$units = $_POST['units'][$i];
$itemcode = $_POST['itemcode'][$i];
$description = $_POST['description'][$i];
$items2 = explode('@',$_POST['items'][$i]);
$flock = $_POST['flock'][$i];
$mode=$_POST['mode'][$i];
if($mode=='Kgs')
{
$basic = $quantity * $rateperunit;
}
else if($mode == 'Pieces')
{
$basic = $packets * $rateperunit;
}
else
$basic = $quantity * $rateperunit;

$discountvalp = 0;$discountvalamount = 0;

$packingitemcode = $items2[0];
$packingitemdescription = $items2[1];
$packingitems = $_POST['items1'][$i];
$lot = $_POST['lot'][$i];
$serial = $_POST['serial'][$i];

 $taxcode = $_POST['taxcode'][$i];
 $taxvalue = $_POST['taxvalue'][$i];
 $taxie = $_POST['taxie'][$i];
 if($_POST['taxamount'][$i] <= 0)
  $taxamount1 = 0;
 else
  $taxamount1 = abs($_POST['taxamount'][$i] - $basic);
 $taxformula = $_POST['taxformula'][$i];

 $freightcode = $_POST['freightcode'][$i];
 $freightvalue = $_POST['freightvalue'][$i];
 if($_POST['freightamount'][$i] <= 0)
  $freightamount1 = 0;
 else
  $freightamount1 = abs($_POST['freightamount'][$i] - $basic);
 $freightformula = $_POST['freightformula'][$i];
 $freightie = $_POST['freightie'][$i];

 $brokeragecode = $_POST['brokeragecode'][$i];
 $brokeragevalue = $_POST['brokeragevalue'][$i];
 if($_POST['freightamount'][$i] <= 0)
  $brokerageamount1 = 0;
 else
  $brokerageamount1 = abs($_POST['brokerageamount'][$i] - $basic);
 $brokerageformula = $_POST['brokerageformula'][$i];
 $brokerageie = $_POST['brokerageie'][$i];

 $discountcode = $_POST['discountcode'][$i];
 $discountvalue = $_POST['discountper'][$i];
 $discountamount1 = $_POST['discountamount'][$i];
 $discountformula = $_POST['discountformula'][$i];
 
$discountvalp = 0;$discountvalamount = 0;
if($_POST['discountper'][$i] <=0)
{
     $discountvalp = 0;
	 $discountvalamount = $basic;
}
else
{
 if($taxie == "Exclude")
 {
    $discountvalp = (($_POST['discountper'][$i]*$basic)/100);
	$discountvalamount = $basic - $discountvalp;
 }
 else if($taxie == "Include")
 {
    $discountvalp = (($_POST['discountper'][$i]*($basic-$taxamount1))/100);
	$discountvalamount = ($basic-$taxamount1) - $discountvalp;
 } 
}
 
$ordermode = $_POST['ordermode'][$i];
 

$tandcdesc = urldecode($tandcdesc);
$finalcost = 0;

$itemcost = $basic;
   if($taxie == "Exclude")
    $itemcost += $taxamount1;
	
   if($freightie == "Exclude")
    $itemcost += $freightamount1;
	
   $itemcost -= $discountvalp;

$finalcost = round(($itemcost),2);
$pocost+=$finalcost;

if ( $freight == "")
  $freight = 0;
if ( $cobiflag == "")
  $cobiflag = 0;

 $q = "insert into oc_packslip (psincr,m,y,date,party,partycode,ps,so,transporter,transport,tme,vehicleno,driver,freight,itemcode,description,quantity,units,rateperunit,packingitemcode,packingitemdescription,packingitems,lot,serial,totalcost,flag,empid,empname,sector,taxamount,freightamount,brokerageamount,discountamount,warehouse,packets,ordermode,eempid,eempname,empdate,taxcode,taxvalue,taxformula,taxie,freightcode,freightvalue,freightformula,freightie,brokeragecode,brokeragevalue,brokerageformula,brokerageie,discountcode,discountvalue,discountformula,flock) values('$psincr','$m','$y','$date','$party','$partycode','$ps1','$so','$transporter','$transport','$tme','$vehicleno','$driver','$freight','$itemcode','$description','$quantity','$units','$rateperunit','$packingitemcode','$packingitemdescription','$packingitems','$lot','$serial','$finalcost','$flag','$addempid','$addempname','$addempsector','$taxamount1','$freightamount1','$brokerageamount1','$discountvalp','$warehouse','$packets','$ordermode','$eempid','$eempname','$entrydate','$taxcode','$taxvalue','$taxformula','$taxie','$freightcode','$freightvalue','$freightformula','$freightie','$brokeragecode','$brokeragevalue','$brokerageformula','$brokerageie','$discountcode','$discountvalue','$discountformula','$flock')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
}

$q = "update oc_packslip set pocost = '$pocost',cobiflag = '$cobiflag' where ps = '$ps1'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


if($ordermode == "Packets")
{
$q = "update oc_salesorder set sentquantity = sentquantity + '$packets',psflag = '1' where po = '$so' AND code = '$itemcode'";
}
else
{
$q = "update oc_salesorder set sentquantity = sentquantity + '$quantity',psflag = '1' where po = '$so' AND code = '$itemcode'";
}

$qrs = mysql_query($q,$conn) or die(mysql_error());
}

/********Authorization Starts here*********/

$adate = date("Y-m-d",strtotime($_POST['date']));
$ps = $ps1;
$query1 = "select * from oc_packslip where ps = '$ps'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($row1 = mysql_fetch_assoc($result1))
{

  $query9 = "SELECT cm,sunits,iac,cogsac FROM ims_itemcodes WHERE code = '$row1[itemcode]'";
  $result9 = mysql_query($query9,$conn);
  $row = mysql_fetch_assoc($result9);
  $mode = $row['cm'];
  $sunits = $row['sunits'];
  $iac = $row['iac'];
  $cogsac = $row['cogsac'];

  $party = $row1['party'];
  $date = $row1['date'];
  $vehicleno = $row1['vehicleno'];
  $driver = $row1['driver'];
  $transport = $row1['transport'];
  $dumid = $row1['id'];
  $val = 0;
  $code = $row1['itemcode'];
  $val = round(calculate($mode,$code,$adate),3);
//////// calculations
  $fpqty = $rows[quantity];
  if($rows[ordermode] == "Packets" and $rows[units] != "Kgs")
    $fpqty = $rows[packets];
  
 $type = 'PS';
  //$query2 = "SELECT * FROM ims_itemcodes WHERE code = '$row1[itemcode]'";
  //$result2 = mysql_query($query2,$conn);
  //while($row2 = mysql_fetch_assoc($result2))
  {
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,vencode,warehouse) VALUES ('$date','$code','Dr','$cogsac','$fpqty','$amount','$ps','$type','$party','$partycode','$warehouse'), ('$date','$code','Cr','$iac','$fpqty','$amount','$ps','$type','$party','$partycode','$warehouse')";
   $result4 = mysql_query($query4,$conn) ;
  }
   $query5 = "UPDATE oc_packslip SET prodprice = '$val' where ps = '$ps' and itemcode = '$row1[itemcode]' and id = '$dumid' ";
   $result5 = mysql_query($query5,$conn) ;

  } 
  
$query5 = "UPDATE oc_packslip SET flag = '1',adate = '$audate',aempid = '$auempid',aempname = '$auempname',asector = '$ausector' where ps = '$ps'";
$result5 = mysql_query($query5,$conn) ;

/*********Authorization ends here ************/

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_packslip'";
echo "</script>";
?>