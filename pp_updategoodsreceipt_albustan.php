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

$q1 = "update pp_purchaseorder set geflag = '0' WHERE po = '$gres2[ge]' and code = '$gres2[code]'";
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
$q = "select broker,brokerid,vendorcode from pp_purchaseorder where po = '$po' and id='$vid'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
$broker = $qr['broker'];
$brokerid = $qr['brokerid'];
}
}
else if($type == "broker")
{
$q = "select vendor,vendorid,vendorcode from pp_purchaseorder where po = '$po' and id='$vid'";
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
$bquantity = $_POST['bquantity'][$i];
$price = $_POST['price'] [$i];
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

$qinsert = "insert into pp_goodsreceipt (vendorcode,date,po,ge,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,remarks,bags,bagtypecode,bagtypedescription,bagtypeunits,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,brokeragecode,brokeragevalue,brokerageie,brokerageformula,brokerageamount,discountcode,discountvalue,discountie,discountformula,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,warehouse) values ('$vendorcode','$date','$po','$ge','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$itemcode','$description','$aquantity','$rquantity','$shrinkage','$rateperunit','$itemunits','$remarks','$bags','$bagtypecode','$bagtypedescription','$bagtypeunits','$gr1','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$brokeragecode','$brokeragevalue','$brokerageie','$brokerageformula','$brokerageamount','$discountcode','$discountvalue','$discountie','$discountformula','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$warehouse')";

$qisnertqr = mysql_query($qinsert,$conn) or die(mysql_error());

////////// UPDATE purchaseorder /////////
$q1 = "update pp_purchaseorder set geflag = '1' WHERE po = '$po'";
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


  $total = $_POST['finalcost'][$j]; //$_POST['total'][$j]; 

  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  {
  	$drcode = $row2['iac'];
  }



  $type = 'GR';
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$itemcode."','Dr','".$drcode."','".$receivedqty."','".$total."','".$gr."','".$type."','".$venname."','$warehouse')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());

////insert into ac_financialpostingssummary
	
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$drcode' and date = '$adate' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$drcode','$total','Dr','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$drcode'and date = '$adate' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
               VALUES('".$adate."','".$itemcode."','Cr','".$vsac."','".$receivedqty."','".$total."','".$gr."','".$type."','".$venname."','$warehouse')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 //////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$vsac' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$vsac','$total','Cr','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $total;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$vsac'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
 

for($s = 0;$s<4;$s++)
{
  $drcr = "Dr";
  $drcr1 = "Cr";

  if($s == 0) { $p = "tax"; $l = $tca; }
  if($s == 1) { $p = "freight"; $l = $fca; }
  if($s == 2) { $p = "brokerage"; $l = $bca; }
  if($s == 3) { $p = "discount"; $l = $dca; $drcr = "Cr"; $drcr1 = "Dr"; }

  if($_POST[$p.'ie'][$j] == "Exclude")
  {
    $taxcode = $_POST[$p.'code'][$j];

    $ttotal = $_POST[$p.'amount'][$j]; 

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname) 
               VALUES('".$adate."','".$itemcode."','$drcr1','".$vsac."','".$receivedqty."','".$ttotal."','".$gr."','".$type."','".$venname."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$vsac' and date = '$adate' and crdr = '$drcr1'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$vsac','$ttotal','$drcr1','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $ttotal;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$vsac'and date = '$adate' and crdr = '$drcr1'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname) 
               VALUES('".$adate."','".$taxcode."','".$drcr."','".$l."','".$receivedqty."','".$ttotal."','".$gr."','".$type."','".$venname."')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$l' and date = '$adate' and crdr = '$drcr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$l','$ttotal','$drcr','','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $ttotal;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$l'and date = '$adate' and crdr = '$drcr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
  }
}

}

$query5 = "UPDATE pp_goodsreceipt SET aflag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where gr = '$gr'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


/********Authorization ends ***********/


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_goodsreceipt_albustan'";
echo "</script>";
?>