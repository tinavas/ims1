<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$bookinvoice = $_POST['bookinvoice'];
$temp = explode('-',$date);
$m = $temp[1];
$y = substr($temp[0],2);
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
//// retriving bags weight if the category is layer feed

if($_SESSION['db'] == "mlcf" or $_SESSION['db'] == "mbcf")
{
$result=mysql_query("select code,description,capacity from ims_bagdetails",$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$bagscapacity[$res['code']] = $res['capacity'];
}
$conversion = 1;
if($_SESSION['db'] == 'central')
{
 $conversion = $_POST['conversion'];
 $q = "update hr_conversion set flag = 1 where id = '".$_POST['currencyid']."'";		//To Lock the Record
 $r = mysql_query($q,$conn) or die(mysql_error());
} 

for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] !='')
{
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$sentquantity = $_POST['qtys'][$i];
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtyr'][$i];
	$bags = $_POST['bags'][$i];
	$bagtype1 = explode("@",$_POST['bagtype'][$i]);
	$bagtype = $bagtype1[0];
	$bagunits = $bagtype1[1];
	$price = $_POST['price'][$i];
	$vat = $_POST['vat'][$i];
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
	$flock = $_POST['flock'][$i];
	$warehouse = $_POST['flock'][$i];
	if($cat == "Male Birds" || $cat == "Female Birds")
	{
	$resultw=mysql_query("select unitcode from breeder_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	else if($cat == "LB Male Birds" || $cat == "LB Female Birds")
	{
	$resultw=mysql_query("select unitcode from layerbreeder_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	else if($cat == "Layer Birds")
	{
	$resultw=mysql_query("select farmcode as unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	
	
	$execute = 1;
	$autoflock ="";
	if(($_SESSION['db'] == "mlcf" && $cat == "Layer Feed") or ($_SESSION['db'] == "mbcf" && $cat == "Broiler Feed"))
	{
	$sentquantity *= $bagscapacity[$bagtype]; 
	$qtyr *= $bagscapacity[$bagtype]; 
	$price = round($price/$bagscapacity[$bagtype],4);
	$vat = round($vat/$bagscapacity[$bagtype],4);
	}
	
	
	
	if($cat == "Broiler Chicks" or cat == 'Broiler Day Old Chicks')
	{
	  if($_SESSION['client'] <> 'SOUZANEW')
	  {		   
	    $transflock = "";
		   $transflockdig = 0;
		   $trdate = "";
		   $farcode = "";
		   		$query3="select farm,farmcode from broiler_farm where farm = '$warehouse' ";
				$result3=mysql_query($query3,$conn);
				while($rows3=mysql_fetch_array($result3))
				{
					$farcode = $rows3['farmcode'];
				}
	  $query2="SELECT * from ims_stocktransfer where towarehouse = '$warehouse' and (cat = 'Broiler Chicks' or cat = 'Broiler Feed') order by date DESC LIMIT 1";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			while($rows9=mysql_fetch_array($result2))
			{
			    $transflock = $rows9['aflock'];
			   $transflkdig = $rows9['flock'];
			   $trdate = $rows9['date'];
			}
			if($trdate == "") 
			{
			 $query5="SELECT * from pp_sobi where warehouse = '$warehouse'  and code = 'BROC101' order by date DESC LIMIT 1";
			}
			else
			{
			  $query5="SELECT * from pp_sobi where warehouse = '$warehouse' and date > '$trdate' and code = 'BROC101' order by date DESC LIMIT 1";
			}
			
			   $result5=mysql_query($query5,$conn);
			   while($rows5=mysql_fetch_array($result5))
			   {
			    $transflock = $rows5['flock'];
			   }
			$cflag = 999;
			$cntrows = 0;
		 	$query2="SELECT * from broiler_daily_entry where flock = '$transflock' order by cullflag DESC LIMIT 1 ";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			$cntrows = mysql_num_rows($result2);
			if($cntrows > 0){
			while($rows9=mysql_fetch_array($result2))
			{
			   $cflag = $rows9['cullflag'];
			}
			}
			 
			
			if($cflag == 0)
			{
			 $query10 = "SELECT * from broiler_daily_entry where flock = '$transflock' order by age DESC LIMIT 1 ";
			 $result10 = mysql_query($query10,$conn) or die(mysql_error());
			 $rows10 = mysql_fetch_assoc($result10);
			 $age = $rows10['age'];
			 if($age >= 5)
			 {
			  $execute =0;
			  echo "<script type='text/javascript'>";
			  echo "alert('Please cull the previous flock');";
 			  echo "document.location='dashboardsub.php?page=pp_directpurchase'";
			  echo "</script>"; 
			 }
			} 

			if($cflag == 1)
				{
				 	 $get_flock=$transflock;
					 $temp=split('-',$get_flock);
					if($temp[1]=="" || $temp[1] == "@")
					{
					  $number = "1";
					 }
					else
					{
					 $number = $transflkdig + 1;
					}
					 $aflock = $farcode."-".$number;
				 }
			else if($transflock == "")
			{
				$query3="select farm,farmcode from broiler_farm where farm = '$warehouse' ";
				$result3=mysql_query($query3,$conn);
				while($rows3=mysql_fetch_array($result3))
				{
					$aflock = $rows3['farmcode']."-1";
				}
				
			}
			else
			{ 
				$aflock = $transflock;
				$number = $transflkdig;
			
			 } 
			 $autoflock = $aflock;
	 }
	 else if($_SESSION['client'] == 'SOUZANEW')
	 {
	  $autoflock = $_POST['flock'][$i];
	 }		 
	}
	else if(($cat == "Female Birds") || ($cat == "Male Birds"))
	{
	$autoflock = $_POST['flock'][$i];
	}
	
	if($taxamount == "Infinity")
	$taxamount = 0;
	$totalquantity+= $qtyr;
if($_SESSION['client'] == 'FEEDATIVES')
{
$mrp = $_POST['mrp'][$i];
$batchno = $_POST['batch'][$i];
$expdate = $_POST['expdate'][$i];
$exp = date("Y-m-d",strtotime($expdate));

	$q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,mrp,batchno,expirydate) 
	values('$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr','$price','$units','$bags','$bagtype','$bagunits','$vat','$taxamount','$freight','$basic','$grandtotal','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$sentquantity','$warehouse','$mrp','$batchno','$exp')";

}
else
{	
$q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse) 
	values('$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$autoflock','$sentquantity','$warehouse')";
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
 $qrs = mysql_query($q,$conn) or die(mysql_error());
} 
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
if($_SESSION['db'] <> "central")
 $q = "update pp_sobi set totalquantity = '$totalquantity' where so = '$so'";
elseif($_SESSION['db'] == "central") 
 $q = "update pp_sobi set totalquantity = '$totalquantity',orgamount =  '$grandtotal',camount = '$conversion' where so = '$so'";
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

if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{

$query5 = "SELECT sum(sentquantity) as totqty FROM pp_sobi where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
while($row5 = mysql_fetch_assoc($result5))
{
	$totalquantity = $row5['totqty'];
	
}

$type = "SOBI";



if($freightamount > 0)
{

if($freighttype == "Included")
{
 
 $q = "select coacode from ac_bankmasters where code = '$cashbankcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $coacode = $qr['coacode']; 
 
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coacode."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
 //////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($freightamount * $conversion),'Cr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($freightamount * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

 
 }
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
 //////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coa' and date = '$adate' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coa',($freightamount * $conversion),'Dr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($freightamount * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coa'and date = '$adate' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

}




	$q = "select distinct(va) as code1 from contactdetails where name = '$vendor' order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$code1."','$totalquantity','".($grandtotal * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$code1' and date = '$adate' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1',($grandtotal * $conversion),'Cr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($grandtotal * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$code1'and date = '$adate' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }
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
	if($cat == "Male Birds" || $cat == "Female Birds")
	{
	$resultw=mysql_query("select unitcode from breeder_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	else if($cat == "LB Male Birds" || $cat == "LB Female Birds")
	{
	$resultw=mysql_query("select unitcode from layerbreeder_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	else if($cat == "Layer Birds")
	{
	$resultw=mysql_query("select farmcode as unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	
	$taxamount = $_POST['taxamount'][$i];
	
	if(($_SESSION['db'] == "mlcf" && $cat == "Layer Feed")  or ($_SESSION['db'] == "mbcf" && $cat == "Broiler Feed"))
	{
	$quantity *= $bagscapacity[$bagtype]; 
	$quantityr *= $bagscapacity[$bagtype]; 
	$rateperunit = round($rateperunit/$bagscapacity[$bagtype],4);
	
	}
	$itemcost = $quantity * $rateperunit;
	
	
	if ($i == ((count($_POST['code'])) - 1))
	{
	   $itemcost = $grandtotal - $totalcost;
	}
	else
	{
	  if($taxamount == "Infinity")
	  $taxamount = 0;
	 $itemcost+=$taxamount; // with Taxamount
	 if($freighttype == "Included")
	
	$itemcost-= ($freightamount*$quantity/$totalquantity); // with freight inclusion
	$itemcost-= ($discountamount*$quantity/$totalquantity); // with discount
	$itemcost = round($itemcost,3);
	$totalcost = $totalcost + $itemcost;
	}
	
     
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


	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$coacode = $qr['iac'];
	
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$coacode."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$adate' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($itemcost * $conversion),'Dr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + ($itemcost * $conversion);
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$adate' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }


$bagtype1 = explode("@",$_POST['bagtype'][$i]);      
$bagcode = $bagtype1[0];
$bags = $_POST['bags'][$i];
$bagunits = $bagtype1[1];


///stock update/////////////

  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$bagcode' AND warehouse = '$warehouse'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  }

  if($stockunit == $bagunits)
  {
      $stockqty = $stockqty + $bags;    
  }
  else
  {
      $stockqty = $stockqty + convertqty($bags,$bagunits,$stockunit,1);
  }

  $query51 = "UPDATE ims_stock SET quantity = '$stockqty' WHERE itemcode = '$bagcode' AND warehouse = '$warehouse'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());

  ///////////end of stock update//////////////

}
  
}

$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}	//end of EXECUTE = 1
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase'";
echo "</script>";

?>

