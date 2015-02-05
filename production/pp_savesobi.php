<?php 
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


$r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $vendorcode=$a['code'];

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

for($i=0;$i<count($_POST['code']);$i++)
{
      $po = $_POST['po'][$i];
      $ge = $_POST['ge'][$i];
	  $gr = $_POST['grs'][$i];
	$code = $_POST['code'][$i];
	if($_SESSION['db']=="vista")
	{
	$bird = $_POST['bird'][$i];
	}
	$query = "select distinct(sunits) from ims_itemcodes where code = '$code'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	$units = $rows['sunits'];
	}
	
	
	$description = $_POST['description'][$i];
	$receivedquantity = $_POST['receivedquantity'][$i];
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
	if($_SESSION['db']=="vista")
	$q = "insert into pp_sobi (vendorcode,po,ge,gr,so,sobiincr,m,y,date,invoice,vendor,vendorid,broker,brokerid,credittermcode,credittermdescription,credittermvalue,code,description,receivedquantity,rateperunit,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageamount,brokerageformula,discountcode,discountvalue,discountamount,discountformula,totalamount,pocost,grandtotal,flag,empid,empname,sector,taxie,freightie,brokerageie,discountie,tandccode,tandc,remarks,dflag,warehouse,itemunits,bird) values ('$vendorcode','$po','$ge','$gr','$so','$sobiincr','$m','$y','$date','$invoice','$vendor','$vendorid','$broker','$brokerid','$credittermcode','$credittermdescription','$credittermvalue','$code','$description','$receivedquantity','$rateperunit','$taxcode','$taxvalue','$taxamount','$taxformula','$freightcode','$freightvalue','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountamount','$discountformula','$totalamount','$pocost','$grandtotal','$flag','$empid','$empname','$sector','$taxie','$freightie','$brokerageie','$discountie','$tandccode','$tandc','$remarks','1','$warehouse','$units','$bird')";
	
	else
	$q = "insert into pp_sobi (vendorcode,po,ge,gr,so,sobiincr,m,y,date,invoice,vendor,vendorid,broker,brokerid,credittermcode,credittermdescription,credittermvalue,code,description,receivedquantity,rateperunit,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,freightformula,brokeragecode,brokeragevalue,brokerageamount,brokerageformula,discountcode,discountvalue,discountamount,discountformula,totalamount,pocost,grandtotal,flag,empid,empname,sector,taxie,freightie,brokerageie,discountie,tandccode,tandc,remarks,dflag,warehouse,itemunits) values ('$vendorcode','$po','$ge','$gr','$so','$sobiincr','$m','$y','$date','$invoice','$vendor','$vendorid','$broker','$brokerid','$credittermcode','$credittermdescription','$credittermvalue','$code','$description','$receivedquantity','$rateperunit','$taxcode','$taxvalue','$taxamount','$taxformula','$freightcode','$freightvalue','$freightamount','$freightformula','$brokeragecode','$brokeragevalue','$brokerageamount','$brokerageformula','$discountcode','$discountvalue','$discountamount','$discountformula','$totalamount','$pocost','$grandtotal','$flag','$empid','$empname','$sector','$taxie','$freightie','$brokerageie','$discountie','$tandccode','$tandc','$remarks','1','$warehouse','$units')";
	
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	$q = "update pp_goodsreceipt set sobiflag = '1' where gr = '$gr' and po = '$po'";
	$qr = mysql_query($q,$conn) or die(mysql_error());
	
}

	$q = "update pp_sobi set grandtotal = '$grandtotal',balance = '$grandtotal' where so = '$so'";
	$qr = mysql_query($q,$conn) or die(mysql_error());


/**********Authorization Starts here *******************/

$so = $_POST['so'];
$adate = date("Y-m-d",strtotime($_POST['date']));
$venname = $vendor;

$q = "select distinct(va) from contactdetails where name = '$venname' and type = 'vendor' order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$va = $qr['va'];
for($j = 0;$j<count($_POST['code']);$j++)
 {
  $po = $_POST['po'][$j];
  $itemcode = $_POST['code'][$j]; 
  $receivedquantity = $_POST['receivedquantity'][$j];
  $total = $_POST['totalamount'][$j]; 

//Getting warehouse form Purchase Order
$query1 = "SELECT deliverylocation,unit FROM pp_purchaseorder WHERE po = '$po' AND code = '$itemcode'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
 $warehouse = $rows['deliverylocation'];
 $units = $rows['unit'];
}

  $type = 'SOBI';
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$itemcode."','Dr','".$vsac."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$vsac' and date = '$adate' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$vsac','$total','Dr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$vsac'and date = '$adate' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
	

	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$itemcode."','Cr','".$va."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	//////insert into ac_financialpostingssummary
	$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$va' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$va','$total','Cr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$va'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
	
/******
for($s = 0;$s<4;$s++)
{
  $drcr = "Dr";
  $drcr1 = "Cr";

  if($s == 0) { $p = "tax"; $l = $tca; }
  if($s == 1) { $p = "freight"; $l = $cca; }
  if($s == 2) { $p = "brokerage"; $l = $bca; }
  if($s == 3) { $p = "discount"; $l = $dca; $drcr = "Cr"; $drcr1 = "Dr"; }

  if($_POST[$p.'ie'][$j] == "Exclude")
  { 
    $taxcode = $_POST[$p.'code'][$j];
    $query2 = "SELECT * FROM ims_taxcodes WHERE code = '$taxcode'";
    $result2 = mysql_query($query2,$conn);
    while($row2 = mysql_fetch_assoc($result2))
    {
     	$drcode = $row2['coa'];
    }
    $total = $_POST[$p.'amount'][$j]; 

   echo $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$taxcode."','".$drcr1."','".$l."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$l' and date = '$adate' and crdr = '$drcr1'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$l','$total','$drcr1','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$l'and date = '$adate' and crdr = '$drcr1'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }


   echo $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$taxcode."','".$drcr1."','".$va."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$va' and date = '$adate' and crdr = '$drcr1'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$va','$total','$drcr1','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$va'and date = '$adate' and crdr = '$drcr1'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

  echo  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$taxcode."','".$drcr."','".$drcode."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$drcode' and date = '$adate' and crdr = '$drcr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$drcode','$total','$drcr','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$drcode' and date = '$adate' and crdr = '$drcr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

  echo  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$taxcode."','".$drcr."','".$vsac."','".$receivedquantity."','".$total."','".$so."','".$type."','".$venname."','$warehouse')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$vsac' and date = '$adate' and crdr = '$drcr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$vsac','$total','$drcr','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$vsac' and date = '$adate' and crdr = '$drcr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
	
	
	
  }
}
******/

}

$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


/*********Authorization ends here **********************/


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_sobi'";
echo "</script>";
?>