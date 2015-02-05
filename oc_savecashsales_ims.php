<?php 
include "config.php";
include "getemployee.php";
$freeqty=0;
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$temp=explode('@',$party);
$party=$temp[0];
$partycode=$temp[2];

$bookinvoice = $_POST['bookinvoice'];

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
$memp=$_POST['memp'];

$q = "select max(tid) as tid from oc_receipt";

$qrs = mysql_query($q,$conn) or die(mysql_error());

if($qr = mysql_fetch_assoc($qrs))

$tid = $qr['tid'];

$tid = $tid + 1;

$paymentmethod = "Receipt";

$paymentmode = $_POST['paymentmode1'];

$choice = "COBIs";

$amount = $_POST['pamount1'];

$cheque1 = $_POST['cheque1'];
$balance=$grandtotal-$amount;

$cdate = date("Y-m-d",strtotime($_POST['cdate1']));
$c=0;

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '' && $_POST['code'][$i] != '')
{
    $warehouse =$_POST['aaa'];
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$description = $t[1];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];
	
$rateperunit=$_POST['price'][$i];
	 
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];


$query2 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$code' and coacode = '$iac'  and date <= '$date' and quantity > 0 and warehouse='$warehouse' group by crdr order by date,type ";
 $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
	  $qty1=0;
	  $qtycr1=0;
	  $qtydr1=0;
      while($row2 = mysql_fetch_assoc($result2))
      {
          if($row2['crdr']=="Cr")
		  {
        $qtycr1 = $row2['quantity']; 
		  }
		  else
		  {
		 $qtydr1 = $row2['quantity'];
		  }
      } 
  $qty1=$qtydr1-$qtycr1;
	  if($qtyr<=$qty1 && $rateperunit!=0)
	 
	  {

}
else
 {$c=1;
 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty1');";
echo "document.location='dashboardsub.php?page=oc_cashsales_ims'";
echo "</script>"; 
	 }
$j=$i;	
$j++; 
if($rateperunit==0)
{
echo "<script type='text/javascript'>";
echo "alert('Rate per unit is 0 at Row $j ');";
echo "document.location='dashboardsub.php?page=oc_cashsales_ims'";
echo "</script>"; 

}	
}

$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");
if($c==0)
{

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '' && $_POST['code'][$i] != '')
{
  $warehouse =$_POST['aaa'];
  
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$description = $t[1];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];
	
	

	$price = $_POST['price'][$i];
	
	
	$totalquantity+= $qtyr;


	$tax1 = explode("@",$_POST['vat'][$i]);
   $taxcode = $tax1[0];
  $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
  $taxie = $tax1[3];
  
	
	
	$discount1 = $_POST['disc'][$i];
   
   $discvalue = $_POST['disc'][$i];
	
	
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['discountamount'][$i];


   
if($taxvalue=="")
$taxvalue=0;

   
   
   if($discountvalue=="")
$discountvalue=0;


$discountamount=round($discountamount,2);


$taxamount=round($taxamount,2);






  $empid = 0;
  if($_SESSION['db']=="mew")
 $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,quantity,price,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,adate,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,taxvalue,taxamount,freightie,marketingemp) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$code','$description','$qtyr','$price','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','2','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$adate','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$taxvalue','$taxamount','$freighttype','$memp')";
 
 else
  $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,quantity,price,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,adate,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,taxvalue,taxamount,freightie) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$code','$description','$qtyr','$price','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','2','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$adate','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$taxvalue','$taxamount','$freighttype')";
  
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
}

$code = $_POST['pcode1'];	//Cash Code OR Bank Code

$code1 =$coa1=$_POST['code11'];

$description = $_POST['pdescription1'];

$dr = $_POST['dr'];


if($code <> "select" && $amount > 0 && $amount <> "")

{

$query="insert into `oc_receipt` (`tid`, `date`, `party`,`paymentmethod`, `tds`, `tdscode`,`tdsdescription`, `tdsdr`, `tdsamount`,`paymentmode`, `code`, `code1`, `description`,`dr`, `amount`, `totalamount`, `cheque`, `cdate`, `choice`, `socobi`, `actualamount`,`amountreceived`, `balance`, `flag`,`client`, `remarks`) values('$tid','$date','','$paymentmethod','Without TDS','','','','0','$paymentmode','$code','$code1','$description', 'Dr','$amount','$amount','$cheque1','$cdate','$choice','$invoice','$grandtotal','$amount','$balance','1','$client','')";

$result=mysql_query($query,$conn) or die(mysql_error());

}





$q = "update oc_cobi set totalquantity = '$totalquantity',finaltotal = '$grandtotal' where invoice = '$invoice' and client = '$client' ";

$qr = mysql_query($q,$conn) or die(mysql_error());


//$q = "update oc_cobi set totalquantity = '$totalquantity',finaltotal = '$grandtotal',empname='$empname',adate='$adate' where invoice = '$invoice' and client = '$client' ";
//$qr = mysql_query($q,$conn) or die(mysql_error());



?>

<?php 

//Insert into ac_financialpostings

$freightamount = $freight;

$vendor = $party;

$adate = $date;
$so = $invoice;

$type = "COBI";



if($totalquantity=="")
$totalquantity=0;


$acceptedquantity=0;

for($i = 0;$i < count($_POST['qtys']); $i++)
{
if($_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '')
{


	$code = $_POST['code'][$i];
	
	$t = explode('@',$code);
	$code = $t[0];
	$description=$t[1];
	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
	
	$cat = $_POST['cat'][$i];
	
	$capacity=1;
	
	 $taxvalue=0; 
	 $discvalue =0;
	 
	
	$tax1 = explode("@",$_POST['vat'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
  $taxie = $tax1[3];
  
	
   $discvalue = $_POST['disc'][$i];
	
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['disc'][$i];
	$warehouse = $_POST['flock'][$i];
	
	
	

$itemcost = $quantity * $rateperunit;
$salesamount=$itemcost-$discountamount;


 if($taxie=="Include")
    $salesamount= $salesamount-$taxamount;
	
	
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
  	
	$cogsac = $row3['cogsac'];
	$itemac = $row3['iac'];
	$sac = $row3['sac'];
	 $warehouse =$_POST['aaa'];
	 $defaultwarehouse = $warehouse1 = $row3['warehouse'];
	 	$stdcost=calculatenew($warehouse,$mode,$code,$date);
  }

  

 $warehouse1 = $postingswarehouse;
 

 
 $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code'  and client = '$client' and warehouse = '$warehouse1'";
  $result3 = mysql_query($query3,$conn);

      $numrows3 = mysql_num_rows($result3);
	  if($numrows3 == 0)
	  {
	   $query31 = "select * from ims_itemcodes where code = '$code' and client = '$client'";
	   $result31 = mysql_query($query31,$conn) or die(mysql_error());
	   $rows31 = mysql_fetch_assoc($result31);
	   $unit = $rows31['sunits'];
	   $query32 = "insert into ims_stock(id,warehouse,itemcode,unit,quantity,client,empname,adate) values(NULL,'$warehouse1','$code','$unit',0,'$client','$empname','$adate')";
	   $result32 = mysql_query($query32,$conn) or die(mysql_error());
	  }
      $result3 = mysql_query($query3,$conn); 	  
  
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  }
 
  
  $query3 = "SELECT * FROM oc_cobi where invoice = '$so'  and client = '$client' and code = '$code'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	 $freighttype = $row3['freighttype'];
	 $units = $row3['units'];
	 
  }
 
  if($stockunit == $units)
  {
      $stockqty = $stockqty - ($quantity*$capacity);    
  }
  else
  {
      $stockqty = $stockqty - convertqty($quantity*$capacity,$units,$stockunit,1);
  }
    
;
  
 
  
   $query51 = "UPDATE ims_stock SET quantity = '$stockqty',empname='$emname',adate='$adate' WHERE itemcode = '$code' and warehouse = '$warehouse1' ";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  ///////////end of stock update//////////////
   $stdcost = $stdcost * $quantity;
	////Item Account Credit

    $warehouse = $postingswarehouse;	
$dummyquantity = 0;
$stdcost = round($stdcost,2);
        
		
		
		
     $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

   



   /// COGS A/C Debit
   
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Dr','".$cogsac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	///Sales A/C Credit


	$salesamount = round($salesamount,2);
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Cr','".$sac."','$dummyquantity','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 



  $query2 = "SELECT coa FROM ims_taxcodes WHERE code = '$taxcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];
	  
	  
	//tax
	
  if($taxamount > 0)
  {
  
  $taxamount=round($taxamount,2);
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$adate."','".$taxcode."','Cr','".$ta."','".$quantity."','".$taxamount."','".$invoice."','".$type."','".$vendor."','$globalwarehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }

	
if($freightie=="Includepaidbycustomer")
$finaltotal=$finaltotal-$freightamount;


	}
	
}





if($freightamount > 0)
{
$freightamount=round($freightamount,2);
if($freighttype <> "Include Paid By Customer")
{
 
 $q = "select coacode from ac_bankmasters where code = '$cashbankcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $coacode = $qr['coacode']; 
 
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coacode."','$totalquantity','".($freightamount)."','".$so."','".$type."','".$vendor."','".$globalwarehouse."')";
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

if($freighttype=="Include")
{
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
	          VALUES('".$adate."','','Dr','".$coa."','$totalquantity','".$freightamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 }
}


if($freighttype == "Include Paid By Customer")
{
 
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','','".Dr."','".$coa."','$totalquantity','".$freightamount."','".$so."','".$type."','".$vendor."','$globalwarehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
 }


}



	
	
	$amount = $_POST['pamount1'];

$cheque1 = $_POST['cheque1'];
$cashbank = $_POST['pcode1'];	//Cash Code OR Bank Code

$code1 =$coa1=$_POST['code11'];

$description = $_POST['pdescription1'];



 
//Cash Account Debit

if($viaf == 'Cash')
{ $cash = 'YES'; $bank = 'NO'; $cashcode = $coacode; $bankcode = ""; }
elseif($viaf == 'Cheque')
{ $cash = 'NO'; $bank = 'YES'; $cashcode = ""; $bankcode = $coacode; }
$amount=round($amount,2);
$type1='RCT';
 
 $q4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,cash,bank,cashcode,bankcode,schedule) 
	        VALUES('$adate','','Dr','$coa1',0,'$amount','$tid','$type1','','$globalwarehouse','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $res4 = mysql_query($q4,$conn) or die(mysql_error());
 
 $query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where invoice = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

 
  

}



echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_cashsales_ims'";
echo "</script>";
?>







