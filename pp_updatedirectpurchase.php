<?php
include "config.php";
include "getemployee.php";
$id = $_POST['invoice'];
$delete = 0;
?>
<?php 
//Inserting 

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$temp=explode('@',$vendor);
$vendor=$temp[0];
$vendorcode=$temp[2];
$so = $_POST['invoice'];
$bookinvoice = $_POST['bookinvoice'];
$sobiincr = $_POST['sobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];

$basic = $_POST['basic'];
$discount = $_POST['disamount'];
$broker = $_POST['broker'];
$vno = $_POST['vno'];
$driver = $_POST['driver']; 
$remarks=$_POST['remarks'];
$freighttype = $_POST['freighttype'];
$freight = $_POST['cfamount'];
$viaf = $_POST['cvia'];
$datedf = date("Y-m-d",strtotime($_POST['cdate']));
$cashbankcode = $_POST['cashbankcode'];
$coa = $_POST['coa'];
$cheque = $_POST['cheque'];
$discountamount = $_POST['discountamount'];

$grandtotal = $_POST['tpayment'];
$totalquantity = 0;



$conversion = 1;
$edit = $_POST['edit'];


$cterm = $_POST['cterm'];
$query="select code,description from ims_creditterm where value='$cterm'";
$r=mysql_query($query);
if($a=mysql_fetch_assoc($r)) {
$ctermcode = $a[code];
$ctermdesc = $a[description]; }

$ctermvalue = $cterm;
if($ctermvalue == "") $ctermvalue = 0;

for($i = 0;$i<count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] != '' )
{
$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];

	//$q1 = "select distinct(warehouse) from ims_itemcodes where code = '$code'";
	//$q1rs = mysql_query($q1,$conn) or die(mysql_error());
	//if($q1r = mysql_fetch_assoc($q1rs))
	//$warehouse = $q1r['warehouse'];

	$sentquantity = $_POST['qtys'][$i];
	$qtyr = $_POST['qtyr'][$i];
	$price = $_POST['price'][$i];

	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$fqty = $_POST['fqty'][$i]; if($fqty=='') $fqty=0;
	$bags = $_POST['bags'][$i];
	$bagtype1 = explode("@",$_POST['bagtype'][$i]);
	$bagtype = $bagtype1[0];
	$bagunits = $bagtype1[1];
	
	$vat = $_POST['vat'][$i];
	$queryvat = "SELECT code,formula,rule FROM ims_taxcodes WHERE codevalue= '$vat' AND taxflag = 'P'";
	$resultvat = mysql_query($queryvat,$conn) or die(mysql_error());
	$rowsvat = mysql_fetch_assoc($resultvat);
	$taxcode = $rowsvat['code'];
	$taxformula = $rowsvat['formula'];
	$taxie = $rowsvat['rule'];
	$flock = $_POST['doffice'][$i];
	
	$warehouse = $_POST['doffice'][$i];
	
	
	
	$oldwarehouse = "";
	$oldwarehouse = $_POST['olddoffice'][$i];
	$oldflock = "";
	$oldflock = $_POST['oldflock'][$i];
	$taxamount = $_POST['taxamount'][$i];
	$execute = 1;
	$autoflock ="";


	/////////////////////////////////
	

	if($taxamount == "Infinity")
	$taxamount = 0;
	$totalquantity+= $qtyr;

	  $q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,warehouse,sentquantity,credittermcode,credittermdescription,credittermvalue,taxcode,taxie,taxformula,receiveflag) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$warehouse','$sentquantity','$ctermcode','$ctermdesc','$ctermvalue','$taxcode','$taxie','$taxformula','0')";
	
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
/********first delete the previous records*********/

//Updating the Stock
if($delete == 0)
{ $delete = 1;
$query1 = "SELECT code,receivedquantity,warehouse FROM pp_sobi WHERE so = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $qty = $rows1['receivedquantity'];
 $query2 = "UPDATE ims_stock SET quantity = quantity - $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 
 $result2 = mysql_query($query2,$conn) or die(mysql_error());
}
//End of updating the Stock

$get_entriess = "DELETE FROM pp_sobi WHERE so = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
}	//End of Delete
/********end of delete****************/
 $qrs = mysql_query($q,$conn) or die(mysql_error());
} 
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
 $q = "update pp_sobi set totalquantity = '$totalquantity' where so = '$so'";
$qr = mysql_query($q,$conn) or die(mysql_error());
}	
?>	
<?php 
//Financial Postings Starts Here
$adate = $date;
//$freighttype = $_POST['freighttype'];
$freightamount = $freight;
//$discountamount = $_POST['discountamount'];
//$vendor = $_POST['vendor'];


$query5 = "SELECT sum(sentquantity) as totqty FROM pp_sobi where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
while($row5 = mysql_fetch_assoc($result5))
{
	$totalquantity = $row5['totqty'];
	
}

$type = "SOBI";



if($freightamount > 0 && $freighttype <> "Freight Amount in Bill")
{
 
$q = "select coacode from ac_bankmasters where code = '$cashbankcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$coacode = $qr['coacode']; 
 
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coacode."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
//To fill cash,bank,cashcode,bankcode,schdule
if($viaf == 'Cash')
{ $cash = 'YES'; $bank = 'NO'; $cashcode = $coacode; $bankcode = ""; }
elseif($viaf == 'Cheque')
{ $cash = 'NO'; $bank = 'YES'; $cashcode = ""; $bankcode = $coacode; }

 $q = "SELECT schedule FROM ac_coa WHERE code = '$coa'";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $schedule = $rr['schedule'];

$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
	          VALUES('".$adate."','','Dr','".$coa."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
}

	$q = "select distinct(va) as code1 from contactdetails where name = '$vendor' order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$code1."','$totalquantity','".($grandtotal * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   

for($i = 0;$i < count($_POST['code']); $i++)
{
if( $_POST['code'][$i] != '-Select-' )
{
    $cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	if($_SESSION[db]=='albustanlayer')
	$quantityr = $_POST['qtyr'][$i]+$_POST['fqty'][$i];
	
	if($_SESSION[db]=='albustanlayer' && $cat == 'Layer Feed')
	{
	$quantityr = ($_POST['qtyr'][$i])*1000;
	$quantity = ($_POST['qtys'][$i])*1000;
	$rateperunit = ($_POST['price'][$i])/1000;
	}
	else
	{
	$quantityr = $_POST['qtyr'][$i];
	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
    }
	  $units = $_POST['units'][$i];
      $warehouse = $_POST['doffice'][$i];
	  
	  
	
	$taxamount = $_POST['taxamount'][$i];
	
	
	
	$itemcost = $quantity * $rateperunit;
	
	
	if($taxamount == "Infinity")
	$taxamount = 0;
	 $itemcost+=$taxamount; // with Taxamount
	if($freighttype == "Included")
    
	 $itemcost-= ($freightamount*$quantity/$totalquantity); // with freight inclusion
	$itemcost-= ($discountamount*$quantity/$totalquantity); // with discount
	$itemcost = round($itemcost,3);
     
///stock update/////////////
  $stockqty = 0;
  $cnt = 0;
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result3 = mysql_query($query3,$conn);
  $cnt = mysql_num_rows($result3);
   if ( $cnt == 0 )
  {
   $iunits = 0;
  $query31 = "SELECT * FROM ims_itemcodes WHERE code = '$code' ";
  $result31 = mysql_query($query31,$conn);
   while($row31 = mysql_fetch_assoc($result31))
   {
      $iunits = $row31['sunits']; 
   }
   $query51 = "insert into ims_stock(warehouse,itemcode,quantity,unit)Values('$warehouse','$code',0,'$iunits')";
 $result51 = mysql_query($query51,$conn) or die(mysql_error());
  }
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  }

  if($stockunit == $units)
  {
      $stockqty = $stockqty + $quantityr;    
  }
  else
  {
      $stockqty = $stockqty + convertqty($quantityr,$units,$stockunit,1);
  }
 
  $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  

  ///////////end of stock update//////////////


/*	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))*/
	$coacode = 'PTR01';
	
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$coacode."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

}
  
}
$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase';";
echo "</script>";

?>