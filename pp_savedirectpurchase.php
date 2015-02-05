<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
 $rdate=$date;
$vendor = $_POST['vendor'];
@$rf=$_POST['rf'];
if($rf=="")
$rf=0;
$temp=explode('@',$vendor);
$vendor=$temp[0];
$vendorcode=$temp[2];
$bookinvoice = $_POST['bookinvoice'];
$temp = explode('-',$date);
$m = $temp[1];
$y = substr($temp[0],2);

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
 $edit=$_POST['saed'];
 if($edit==1){
 $so=$_POST['invoice'];
 $sobiincr=$_POST['sobiincr'];
 }
 if($edit==1)
 {
 
$id=$_POST['oldinv'];

//Updating the Stock

$query1 = "SELECT code,receivedquantity,warehouse,recdate FROM pp_sobi WHERE so = '$id'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
$rdate=$rows1['recdate'];
 $qty = $rows1['receivedquantity'];
$query2 = "UPDATE ims_stock SET quantity = quantity - $qty WHERE itemcode = '$rows1[code]' AND warehouse = '$rows1[warehouse]'"; 
 $result2 = mysql_query($query2,$conn) or die(mysql_error());

}
//End of updating the Stock

$get_entriess = "DELETE FROM pp_sobi WHERE so = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());




$temp=explode("-",$id);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$so=$id;
else
{
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
$so = $sobi;

 
 }
 }


 
if($_POST['saed'] <>1)
{
$query1 = "SELECT MAX(sobiincr) as sobiincr FROM pp_sobi where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $sobiincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$sobiincr = $row1['sobiincr']; 
$sobiincr = $sobiincr + 1;
if ($sobiincr < 10) 
$sobi = 'SOBI-'.$m.$y.'-000'.$sobiincr; 
else if($sobiincr < 100 && $sobiincr >= 10) 
$sobi = 'SOBI-'.$m.$y.'-00'.$sobiincr; 
else $sobi = 'SOBI-'.$m.$y.'-0'.$sobiincr;
$so = $sobi;
}
 
 $empname=$_SESSION['valid_user'];

  if($edit==1){
 
 $sobiincr=$_POST['sobiincr'];
 $empname=$_POST['cuser'];
 }

$noofentries = 0;
for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] !="")
{
$qtys=0;
$qtyr=0;

    $noofentries++;
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	
	$price = $_POST['price'][$i];
	$qtyr = $_POST['qtyr'][$i];
	$sentquantity = $_POST['qtys'][$i];
	
	$description = $t[1];
	$units = $_POST['units'][$i];
	

	$tax1 = explode("@",$_POST['vat'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
  $taxie = $tax1[3];

   $discvalue =$_POST['disc'][$i]; 
	
	if($discvalue=="")
	$discvalue=0;
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['discountamount'][$i];
	$warehouse = $_POST['flock'][$i];



	
	//////////////////////////////////

	
if($qtyr=="")
$qtyr=0;
	
	
	if($taxamount == "")
	$taxamount = 0;
	$totalquantity+= $qtyr;
	
$q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,freightie,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,sentquantity,warehouse,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,receiveflag,recdate) 
values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units',($taxvalue * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$sentquantity','$warehouse','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$rf','$rdate')";


 $qrs = mysql_query($q,$conn) or die(mysql_error());

}


 $q = "update pp_sobi set totalquantity = '$totalquantity' where so = '$so'";

 $qr = mysql_query($q,$conn) or die(mysql_error());

?>

<?php 
//Financial Postings Starts Here
$adate = $date;
//$freighttype = $_POST['freighttype'];
$freightamount = $freight;
//$discountamount = $_POST['discountamount'];
//$vendor = $_POST['vendor'];
$totalquantity=0;


$query5 = "SELECT sum(sentquantity) as totqty FROM pp_sobi where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
while($row5 = mysql_fetch_assoc($result5))
{
	$totalquantity = $row5['totqty'];
	
}

$type = "SOBI";

$freightamount= round($freightamount, 2);

if($freightamount > 0 && $freighttype!="" )
{

if($freighttype <> "Excludepaidbysupplier")
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
 
 if($freighttype=="Excluded")
 {
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
	          VALUES('".$adate."','','Dr','".$coa."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
 }
}


if($freighttype == "Excludepaidbysupplier")
{
 
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','','".Dr."','".$coa."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','$warehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
 }


}


	$q = "select distinct(va) as code1 from contactdetails where name = '$vendor' order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];
	$grandtotal=round($grandtotal,2);
	if($totalquantity=='')
	$totalquantity=0;
	

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$code1."','$totalquantity','".($grandtotal * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

   $totalcost = 0;
for($i = 0;$i < count($_POST['code']); $i++)
{
if( $_POST['code'][$i] != '' && $_POST['price'][$i] != '')
{
    $cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	

	$quantityr = $_POST['qtyr'][$i];
	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
	
    $units = $_POST['units'][$i];
    $warehouse = $_POST['flock'][$i];

	
	$taxamount = $_POST['taxamount'][$i];
	
$taxamount= round($taxamount, 2);
	$itemcost = $quantity * $rateperunit;
	
	

     
	 
	$tax1 = explode("@",$_POST['vat'][$i]);
    $taxcode = $tax1[0];
    $taxvalue = $tax1[1];
    $taxmode = $tax1[2];
    $taxie = $tax1[3];
  
	
    $discvalue =round($_POST['disc'][$i],2);
 
	
	if($discvalue=="")
	$discvalue=0;
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['discountamount'][$i];
	$warehouse = $_POST['flock'][$i];

	
$itemcost=$itemcost-$discountamount;

	if($taxie=="Include")
	 
	 $itemcost=$itemcost-$taxamount;
	 
	 
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
	if($_POST[edit]==1 && $_POST[rf]==1)
	{
	
	}
	$coacode ='PTR01';
	$itemcost=round($itemcost,5);
	if($quantityr=='')
	$quantity=0;
	
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$coacode."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
if($_POST[edit]==1 && $_POST[rf]==1)
	{
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Cr','".$coacode."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac=$qr[iac];
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$iac."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
	}



if($taxie!="" && $taxamount>0)
{
$taxamount=round($taxamount,5);

$qu1="SELECT `coa` FROM `ims_taxcodes` where `code`='$taxcode'";
$re1=mysql_query($qu1,$conn);
while($ree1=mysql_fetch_array($re1))
{
$taxcoa=$ree1['coa'];

}
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$taxcode."','Dr','".$taxcoa."','$quantityr','".($taxamount)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
}
}
  
}

$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase'";
echo "</script>";

?>

