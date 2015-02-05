 <?php
include "config.php";
$id = $_POST['invoice'];

//Updating the Stock
$query1 = "SELECT code,quantity,warehouse FROM oc_cobi WHERE invoice = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $qty = $rows1['quantity'];
 $query2 = "UPDATE ims_stock SET quantity = quantity + $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
}
//End of updating the Stock
$get_entriess = "DELETE FROM oc_cobi WHERE invoice = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());





$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'COBI' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

?>
<?php
//Inserting 

?>

<?php 
include "getemployee.php";
$freeqty=0;
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$temp=explode('@',$party);
$party=$temp[0]; $partycode=$temp[2];
$invoice = $_POST['invoice'];
$bookinvoice = $_POST['bookinvoice'];
$remarks = $_POST['remarks'];
$cobiincr = $_POST['cobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];

$basic = $_POST['basic'];
$discount = $_POST['disamount'];
$broker = $_POST['broker'];
$vno = $_POST['vno'];
$driver = $_POST['driver'];
$globalwarehouse = $_POST['aaa'];
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
$totalquantity = 0;
$cnt = 0;
$cterm = $_POST['cterm'];
$query="select code,description from ims_creditterm where value='$cterm'";
$r=mysql_query($query);
if($a=mysql_fetch_assoc($r)) {
$ctermcode = $a[code];
$ctermdesc = $a[description]; }
$ctermvalue = $cterm;
if($ctermvalue == "") $ctermvalue = 0;

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != ''  && $_POST['code'][$i] != '')
{
    $warehouse = "";
     $flock = $_POST['flock'][$i];
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];
	
	if($_SESSION['db']=='alkhumasiyabrd' && $cat='Hatch Eggs') {
	$rdate=explode('@',$_POST['rdate'][$i]);
    $rdate=date('Y-m-d',strtotime($rdate[0]));
 $oldrdate=date('Y-m-d',strtotime($_POST['oldrdate'][$i]));
	$oldflock=$_POST['oldflock'][$i];
	 $query4="update ims_eggreceiving set availableeggs=availableeggs-".$_POST['qtys'][$i]."+".$_POST['oldqtys'][$i]." where date='".$oldrdate."' and tocode in (select code from ims_itemcodes where cat='hatch eggs') and flock='$oldflock'";
 mysql_query($query4,$conn) or die(mysql_error());
	}
	
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
	//$bags = $_POST['bags'][$i];
	//$bagtype = $_POST['bagtype'][$i];
	
	
	
	
	$price = $_POST['price'][$i];
	//$vat = $_POST['vat'][$i];
	//$taxamount = $_POST['taxamount'][$i];
	//if($taxamount == "Infinity")
	//$taxamount = 0;
	$totalquantity+= $qtyr;
	if($_SESSION['db'] == "mlcf" && $cat == "Layer Birds")
	{
	$warehouse = $flock;
	}
	else if($_SESSION['db'] == "feedatives" || $_SESSION['db'] == "maharashtra" )
	{
	$warehouse = $_POST['aaa'];
	}
	else if($_SESSION['db'] == "samar")
	{
	 $warehouse = $_POST['flock'];
	}
	else
	{
	  $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code' and client = '$client' ";
	  $result3 = mysql_query($query3,$conn);
	  while($row3 = mysql_fetch_assoc($result3))
	  {
		$warehouse = $row3['warehouse'];
	  }
	}
  if($flock == '-Select-')
  {
   $flock = "";
   $warehouse1 = $warehouse;
  }
  else
  {
   $warehouse1 = $flock;
  }
  if($cat == 'Female Birds'||$cat=='Male Birds')
   $weight = $_POST['weight'][$i];
if($weight == "")
$weight = 0;
  $empid = 0;
  $mw = $qtyr * $price;
  //echo $mw."/".$basic."/".$discountamount;
$dis = round((($mw/$basic)*($discountamount)),2);
 
  $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,broker,code,description,quantity,price,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,flock,bagtype,individualdiscount,weight,credittermcode,credittermdescription,credittermvalue) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$broker','$code','$description','$qtyr','$price','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$flock','$bagtype','$dis','$weight','$ctermcode','$ctermdesc','$ctermvalue')";
  
  
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	$cnt = $cnt + 1;
}

$q = "update oc_cobi set totalquantity = '$totalquantity',finaltotal = '$grandtotal' where invoice = '$invoice' and client = '$client' ";
$qr = mysql_query($q,$conn) or die(mysql_error());




?>

<?php 

//Insert into ac_financialpostings
//$totalquantity = $_POST['totalquantity'];

//$freighttype = $_POST['freighttype'];
$freightamount = $freight;
//$discountamount = $_POST['discountamount'];
$vendor = $party;

 //$grandtotal = $_POST['grandtotal'];

$adate = $date;
$so = $invoice;

$type = "COBI";

	$q = "select distinct(ca) as code1 from contactdetails where name = '$vendor' and client = '$client'  order by ca";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

   ///Customer Account Debit
   $grandtotal = round($grandtotal,3);
   if($_SESSION['db'] == "feedatives" || $_SESSION['db']=="albustan" || $_SESSION['db']=="albustanlayer")
    $totqty=$totalquantity+$freeqty;
	else
	$totqty=$totalquantity;
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','','Dr','".$code1."','$totqty','".$grandtotal."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$code1', '0', 'Dr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$code1' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $grandtotal WHERE date = '$date' AND coacode = '$code1' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert

/*	
	$newamount = $grandtotal + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$code1' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1','$grandtotal','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1','$grandtotal','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/	
	
// $cnt = count($_POST['price']);
$freightdiv = round(($freightamount/$cnt),2);
if($_SESSION['db'] == "feedatives")
  {
  
   $discountdiv = round((($discountamount + $finaldiscountamount )/$cnt),2);
  }
  else
  {
  $discountdiv = round(($discountamount/$cnt),2);
  }

for($i = 0;$i < count($_POST['qtys']); $i++)
{
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '')
{
	$code = $_POST['code'][$i];
	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
	$weight = $_POST['weight'][$i];
	$cat = $_POST['cat'][$i];
	
	$capacity=1;
	if($_SESSION['db'] == "alkhumasiyabrd"&&($cat=='Female Feed'||$cat=='Male Feed'))
	  $bagtype = $_POST['bagtype'][$i];
	else
	  $bagtype='Not aplicable';
	  
	 if(($_SESSION['db'] == "alkhumasiyabrd")&&($cat=='Female Feed'||$cat='Male Feed'))
	  {
	  $q='select capacity from ims_bagdetails where code='."'".$bagtype."'";
	  if($a=mysql_fetch_assoc(mysql_query($q)))
	    $capacity=$a[capacity];
	  }
	  
	if($cat == "Boar" || $cat == "Sow" || $cat == "Fattener" || $cat == "Broiler Birds" || $cat == "Female Birds" || $cat == "Male Birds")
	{
	$itemcost = $weight * $rateperunit;
	}
	else
	{
	$itemcost = $quantity * $rateperunit;
	}
	
	//$taxamount = $_POST['taxamount'][$i];
	//$itemcost+=$taxamount; // with Taxamount
	//if($freighttype == "Included")
	//$itemcost-= ($freightamount*$quantity/$totalquantity); // with freight inclusion
	//$itemcost-= ($discountamount*$quantity/$totalquantity); // with discount

     
///stock update/////////////
$stdcost = 0;
$cogsac = "";
$itemac = "";
$sac = "";
$postingswarehouse = $warehouse;
 $warehouse = "";
 $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code' and client = '$client' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
     $mode = $row3['cm']; 
  	$stdcost = $row3['stdcost'];	
	$cogsac = $row3['cogsac'];
	$itemac = $row3['iac'];
	$sac = $row3['sac'];
	$defaultwarehouse = $warehouse1 = $row3['warehouse'];
  }
  
  
if($_SESSION['db'] == "mlcf" && $cat == "Layer Birds")
    $warehouse1 = $_POST['flock'][$i];
else if($_SESSION['db'] == "feedatives" || $_SESSION['db'] == "maharashtra" )  
 $warehouse1 = $_POST['aaa'];
else if($_SESSION['db'] == "mlcf")
$warehouse1 = $defaultwarehouse;
else
 $warehouse1 = $postingswarehouse;

if($cat == "Ingredients")
 $stdcost = round(calculate($mode,$code,$adate,$warehouse1),3);
  
 $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code'  and client = '$client' and warehouse = '$warehouse1' ";
  $result3 = mysql_query($query3,$conn);

      $numrows3 = mysql_num_rows($result3);
	  if($numrows3 == 0)
	  {
	   $query31 = "select * from ims_itemcodes where code = '$code' and client = '$client'";
	   $result31 = mysql_query($query31,$conn) or die(mysql_error());
	   $rows31 = mysql_fetch_assoc($result31);
	   $unit = $rows31['sunits'];
	   $query32 = "insert into ims_stock(id,warehouse,itemcode,unit,quantity,client) values(NULL,'$warehouse1','$code','$unit',0,'$client')";
	   $result32 = mysql_query($query32,$conn) or die(mysql_error());
	  }

  $result3 = mysql_query($query3,$conn); 	  
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
	
  }
 
  
   $query3 = "SELECT * FROM oc_cobi where invoice = '$so'  and client = '$client' and code = '$code' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	 $freighttype = $row3['freighttype'];
	 $units = $row3['units'];
	 if($_SESSION['db'] == "samar")
	 {
	   $warehouse = $row3['warehouse'];
	 }
  }
 
  if($stockunit == $units)
  {
      $stockqty = $stockqty - ($quantity*$capacity);    
  }
  else
  {
      $stockqty = $stockqty - convertqty($quantity*$capacity,$units,$stockunit,1);
  }
    
  $mainitemcost = $itemcost;
 
 
  if($i == ($cnt - 1))
  {
	  if($_SESSION['db'] == "feedatives")
	  {
	  	$discountdiv1 = $discountamount + $finaldiscountamount - ($discountdiv * ($cnt - 1));
	  }
	  else
	  { 
	  	$discountdiv1 = $discountamount - ($discountdiv * ($cnt - 1));
	  }
  
 $mainitemcost = $mainitemcost - $discountdiv1;
 $mainitemcostwithoutfreight = $mainitemcost;
  
  $freightdiv1 = $freightamount - ($freightdiv * ($cnt - 1));
  if ( $freighttype == "Excluded")
  {
     $mainitemcost = $mainitemcost - $freightdiv1;
	 $queryf = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) VALUES('".$adate."','".$code."','Cr','".$fcoa."','".$quantity*$capacity."','".$freight."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
	 $resultf = mysql_query($queryf,$conn) or die(mysql_error());
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$adate', '$fcoa', '0', 'Cr', '$warehouse1', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$fcoa' AND crdr = 'Cr' AND warehouse = '$warehouse1' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $freight WHERE date = '$date' AND coacode = '$fcoa' AND crdr = 'Cr' AND warehouse = '$warehouse1' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
 
  }
  if ( $freighttype == "Included")
  {
     $mainitemcost = $mainitemcost + $freightdiv1;
  }
  
  }
  else
  {
//echo "..".$discountdiv;
  $mainitemcost = $mainitemcost - $discountdiv;
  $mainitemcostwithoutfreight = $mainitemcost;
   if ( $freighttype == "Excluded")
  {
     $mainitemcost = $mainitemcost - $freightdiv;
  }
  if ( $freighttype == "Included")
  {
     $mainitemcost = $mainitemcost + $freightdiv;
  }
  }
  
 
  $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$code' and warehouse = '$warehouse1' ";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  ///////////end of stock update//////////////
   $stdcost = $stdcost * $quantity;
	////Item Account Credit
	if($_SESSION['db'] == "mlcf" and $cat == "Layer Birds")
	$warehouse = $warehouse1;	
	else if($_SESSION['db'] == "mlcf")
	$warehouse = $defaultwarehouse;
	else
    $warehouse = $postingswarehouse;
	
$dummyquantity = 0;
$stdcost = round($stdcost,3);
          if($_SESSION['db'] == "feedatives" || $_SESSION['db']=="albustan" || $_SESSION['db']=="albustanlayer")
		  {
		    $fqty=$_POST['fqty'][$i];
		    $quantity+=$fqty;
			}
     $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$itemac', '0', 'Cr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$itemac' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $stdcost WHERE date = '$date' AND coacode = '$itemac' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert

/*   
   ///insert into ac_financialpostingssummary
$newamount = $stdcost + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$itemac' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$itemac','$stdcost','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$itemac','$stdcost','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/

 $queryeg="select * from ims_itemcodes where code = '$code'";
   $resulteg=mysql_query($queryeg,$conn) or die(mysql_error());
   $resulteg=mysql_fetch_assoc($resulteg);
   $eggcat=$resulteg['cat'];
   if($eggcat=="Hatch Eggs" && $_SESSION['db'] == "golden")
   {
        $totbox=floor($quantity/210);
		
		 $remain=$quantity%210;
	$querycode="select * from ims_itemcodes where description='EGG BOX'";
	$resultcode=mysql_query($querycode,$conn) or die(mysql_error());
	$resultcode=mysql_fetch_assoc($resultcode);
	$eggitemcode=$resultcode['code'];
	$eggcoacode=$resultcode['iac'];	 
	$stdprice=$resultcode['stdcost'];
		 $totprice=$totbox*$stdprice;
		 $finalprice=$totprice;
		  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','".$eggitemcode."','Cr','".$eggcoacode."','".$totbox*$capacity."','".$totprice."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$eggcoacode', '0', 'Cr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$eggcoacode' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $totprice WHERE date = '$date' AND coacode = '$eggcoacode' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
/*   
    ///insert into ac_financialpostingssummary
$newamount = $totprice + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$eggcoacode' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$eggcoacode','$totprice','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$eggcoacode','$totprice','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/				 
		 $querycode="select * from ims_itemcodes where description='EGG TRAYS'";
	$resultcode=mysql_query($querycode,$conn) or die(mysql_error());
	$resultcode=mysql_fetch_assoc($resultcode);
	$eggitemcode=$resultcode['code'];
	$eggcoacode=$resultcode['iac'];	 
	$stdprice=$resultcode['stdcost'];
		 $tottray=ceil($quantity/30) + 3;
		 $totprice=$tottray*$stdprice;	 
		 $finalprice+=$totprice;
		 
		 
		 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','".$eggitemcode."','Cr','".$eggcoacode."','".$tottray."','".$totprice."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$eggcoacode', '0', 'Cr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$eggcoacode' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $totprice WHERE date = '$date' AND coacode = '$eggcoacode' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
/*   
   ///insert into ac_financialpostingssummary
$newamount = $totprice + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$eggcoacode' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$eggcoacode','$totprice','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$eggcoacode','$totprice','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/   
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	VALUES('".$adate."','','Dr','99999','0','".$finalprice."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '9999', '0', 'Dr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '9999' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $finalprice WHERE date = '$date' AND coacode = '9999' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
/*   
   ///insert into ac_financialpostingssummary
$newamount = $finalprice + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '99999' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','99999','$finalprice','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','99999','$finalprice','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/   
   	
   	
   }
 


   /// COGS A/C Debit
   
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','".$code."','Dr','".$cogsac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$cogsac', '0', 'Dr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$cogsac' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $stdcost WHERE date = '$date' AND coacode = '$cogsac' AND crdr = 'Dr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
/*	
	///insert into ac_financialpostingssummary
$newamount = $stdcost + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$cogsac' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$cogsac','$stdcost','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$cogsac','$stdcost','Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
*/	
	
	///Sales A/C Credit
if($_SESSION['db'] == 'maharashtra' && $freighttype == 'Included')
{
 $mainitemcostwithoutfreight -= $freight;
}
	$mainitemcostwithoutfreight;
	$mainitemcost = round($mainitemcost,3);
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
	          VALUES('".$adate."','','Cr','".$sac."','$dummyquantity','".$mainitemcostwithoutfreight."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
	 //Insert into ac_financialpostingssummary
	 if($date <> $date1)
	 {
	 $query = "INSERT INTO ac_financialpostingssummary( date, coacode, amount, crdr, warehouse, client ) SELECT '$date', '$sac', '0', 'Cr', '$warehouse', '$client' FROM dual WHERE NOT EXISTS (SELECT coacode FROM ac_financialpostingssummary WHERE date = '$date' AND coacode = '$sac' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client')";
	 $result = mysql_query($query,$conn) or die(mysql_error());	//The row will insert if it is not there
	 }
	 $query = "UPDATE ac_financialpostingssummary SET amount = amount + $mainitemcostwithoutfreight WHERE date = '$date' AND coacode = '$sac' AND crdr = 'Cr' AND warehouse = '$warehouse' AND client = '$client'";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 //End of Insert
/* 
 ///insert into ac_financialpostingssummary
$newamount = $mainitemcostwithoutfreight + $amt;
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$sac' and date = '$adate' and crdr = 'Cr' AND warehouse = '$warehouse'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$sac','$mainitemcostwithoutfreight','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$sac','$mainitemcostwithoutfreight','Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
 */

	///Freight A/C debit/credit
	
	
	///Discount A/C debit
	}
	
}
 $query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where invoice = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_directsales_a'";
echo "</script>";
?>