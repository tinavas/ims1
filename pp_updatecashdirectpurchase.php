<?php
include "config.php";
include "getemployee.php";
$id = $_POST['invoice'];
?>
<?php 
//Inserting 

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
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


if($_SESSION['db'] == "mlcf" || $_SESSION['db'] == "mbcf" || $_SESSION['db'] == "ncf")
{
$result=mysql_query("select code,description,capacity from ims_bagdetails",$conn) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$bagscapacity[$res['code']] = $res['capacity'];
}
$conversion = 1;
$edit = $_POST['edit'];
if($_SESSION['db'] == 'central')
{
 if($edit <> "yes")
 {
  $query2 = "select rate from hr_conversion where '$date' between fromdate and todate and currency = (select currency from contactdetails where name = '$vendor' and type LIKE '%vendor%' and currencyflag = 1)";
  $result2 = mysql_query($query2,$conn) or die(mysql_error());
  $count = mysql_num_rows($result2);
  $r2 = mysql_fetch_assoc($result2);
  $conversion = $r2['rate'];
  if($count == 0)
   $conversion = 1;
 }
 else
  $conversion = $_POST['conversion'];
}

$cterm = $_POST['cterm'];
$temp = explode('@',$cterm);
$ctermcode = $temp[0];
$ctermdesc = $temp[1];
$ctermvalue = $temp[2];
if($ctermvalue == "") $ctermvalue = 0;

for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] != '' )
{
$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];

	//$q1 = "select distinct(warehouse) from ims_itemcodes where code = '$code'";
	//$q1rs = mysql_query($q1,$conn) or die(mysql_error());
	//if($q1r = mysql_fetch_assoc($q1rs))
	//$warehouse = $q1r['warehouse'];
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
	$flock = $_POST['doffice'][$i];
	
	$warehouse = $_POST['doffice'][$i];
	
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
	$resultw=mysql_query("select unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	
	$oldwarehouse = "";
	$oldwarehouse = $_POST['olddoffice'][$i];
	$oldflock = "";
	$oldflock = $_POST['oldflock'][$i];
	$taxamount = $_POST['taxamount'][$i];
	$execute = 1;
	$autoflock ="";
	
	if(($_SESSION['db'] == "mlcf" && $cat == "Layer Feed") or ($_SESSION['db'] == "mbcf" && $cat == "Broiler Feed") or ($_SESSION['db'] == "ncf" && ($cat == "Broiler Feed" || $cat == "Layer Feed" || $cat == "Native Feed" )))
	{
	$sentquantity *= $bagscapacity[$bagtype]; 
	$qtyr *= $bagscapacity[$bagtype]; 
	$price = round($price/$bagscapacity[$bagtype],4);
	}
	
	if($cat == "Broiler Chicks" or $cat == 'Broiler Day Old Chicks' or $cat == "Native Chicks")
	{
	if($oldwarehouse == $warehouse)
	  {   
	  $autoflock = $oldflock;
	  }
	  else
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
	  $query2="SELECT * from ims_stocktransfer where towarehouse = '$warehouse' and (cat = 'Broiler Chicks' or cat = 'Broiler Feed' or cat = 'Native Chicks') order by date DESC LIMIT 1";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			while($rows9=mysql_fetch_array($result2))
			{
			   $transflock = $rows9['aflock'];
			   $transflkdig = $rows9['flock'];
			   $trdate = $rows9['date'];
			}
			if($trdate == "") 
			{
			 $query5="SELECT * from pp_sobi where warehouse = '$warehouse'  and (code = 'BROC101' or code = 'NATC101') order by date DESC LIMIT 1";
			}
			else
			{
			  $query5="SELECT * from pp_sobi where warehouse = '$warehouse' and date > '$trdate' and (code = 'BROC101' or code = 'NATC101') order by date DESC LIMIT 1";
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
			 if($age <= 5)
			 {
			  $execute =0;
			  echo "<script type='text/javascript'>";
			  echo "alert('Please cull the previous flock');";
 			  echo "document.location='dashboardsub.php?page=pp_directpurchase'";
			  echo "</script>"; 
			 }
			} 
			else if($cflag == 1)
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
				$number = $transflkdig + 1;
			
			 } 
			 $autoflock = $aflock;		 
					
	  }
	  else if($_SESSION['client'] == 'SOUZANEW')
	 {
	  $autoflock = $_POST['doffice'][$i];
	 }	
	 
	  }
	}
	else if(($cat == "Female Birds") || ($cat == "Male Birds"))
	{
	 $autoflock = $_POST['doffice'][$i];
	}
	
	
	//////////////////////////////////
	if(($cat == "Broiler Feed" or $cat == 'Native Feed') && ($_SESSION['db'] == 'mbcf' || $_SESSION['db'] == 'ncf' ))
	{
	if($oldwarehouse == $warehouse)
	  {   
	  $autoflock = $oldflock;
	  }
	  else
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
$query2="SELECT * from ims_stocktransfer where towarehouse = '$warehouse' and (cat = 'Broiler Feed' or cat = 'Native Feed') order by date DESC LIMIT 1";
			$result2=mysql_query($query2,$conn) or die(mysql_error());
			while($rows9=mysql_fetch_array($result2))
			{
			    $transflock = $rows9['aflock'];
			   $transflkdig = $rows9['flock'];
			   $trdate = $rows9['date'];
			}
			if($trdate == "") 
			{
			 $query5="SELECT * from pp_sobi where warehouse = '$warehouse'  and code in (select code from ims_itemcodes where (cat = 'Broiler Feed' or cat = 'Native Feed')) order by date DESC LIMIT 1";
			}
			else
			{
			  $query5="SELECT * from pp_sobi where warehouse = '$warehouse' and date > '$trdate' and code in (select code from ims_itemcodes where ( cat = 'Broiler Feed' or cat = 'Native Feed')) order by date DESC LIMIT 1";
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
			 
    		/*if($cflag == 0)
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
			} */

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
	 
	}
	/////////////////////////////////
	

	if($taxamount == "Infinity")
	$taxamount = 0;
	$totalquantity+= $qtyr;
	  $q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,warehouse,sentquantity,credittermcode,credittermdescription,credittermvalue) 
	values('$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$warehouse','$sentquantity','$ctermcode','$ctermdesc','$ctermvalue')";
	
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
/********first delete the previous records*********/

//Updating the Stock
$i = 0;
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
$tid1 = $_POST['tid1'];
$tid2 = $_POST['tid2'];

$get_entriess = "DELETE FROM pp_payment WHERE posobi = '$id' AND tid = '$tid1' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM pp_payment WHERE posobi = '$id' AND tid = '$tid2' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$tid1' and type = 'PMT' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$tid2' and type = 'PMT' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$q1q = "select * from ac_financialpostings where trnum = '$id' and type = 'SOBI' and  client='$client'";
$r1q = mysql_query($q1q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($r1q))
{
$amount123 = $qr['amount'];
 $date12 = $qr['date'];
 $coacode = $qr['coacode'];
 $crdr = $qr['crdr'];
$warehouse = $qr['warehouse'];

$qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$coacode' and date = '$date12' and crdr = '$crdr'";
		$res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		$amountnew = $qhr1['amount'];
		 }
		
		 
		  $amt = $amountnew - $amount123;
		   
		$q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$coacode'and date = '$date12' and crdr = '$crdr'";
		$r1 = mysql_query($q1,$conn) or die(mysql_error());
		


}
$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'SOBI' and client = '$client'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

/********end of delete****************/
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


$query5 = "SELECT sum(sentquantity) as totqty FROM pp_sobi where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
while($row5 = mysql_fetch_assoc($result5))
{
	$totalquantity = $row5['totqty'];
	
}

$type = "SOBI";



if($freightamount > 0)
{
 
$q = "select coacode from ac_bankmasters where code = '$cashbankcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$coacode = $qr['coacode']; 
 
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coacode."','$totalquantity','".($freightamount * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 $newamount = $freightamount + ($amt * $conversion);
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$coacode' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($freightamount * $conversion),'Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($freightamount * $conversion),'Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
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
 
 
 $newamount = $freightamount + ($amt * $conversion);
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$coa' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coa',($freightamount * $conversion),'Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coa',($freightamount * $conversion),'Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}
 
}




	$q = "select distinct(va) as code1 from contactdetails where name = '$vendor' order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

  $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$code1."','$totalquantity','".($grandtotal * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());
   
   
   $newamount = $grandtotal + ($amt * $conversion);
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$code1' and date = '$adate' and crdr = 'Cr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1',($grandtotal * $conversion),'Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
				
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$code1',($grandtotal * $conversion),'Cr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		}


for($i = 0;$i < count($_POST['code']); $i++)
{
if( $_POST['code'][$i] != '-Select-' )
{
    $cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$quantityr = $_POST['qtyr'][$i];
	$quantity = $_POST['qtys'][$i];
	$rateperunit = $_POST['price'][$i];
      $units = $_POST['units'][$i];
      $warehouse = $_POST['doffice'][$i];
	  
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
	$resultw=mysql_query("select unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	
	$taxamount = $_POST['taxamount'][$i];
	
	
	if(($_SESSION['db'] == "mlcf" && $cat == "Layer Feed") or ($_SESSION['db'] == "mbcf" && $cat == "Broiler Feed") or ($_SESSION['db'] == "ncf" && ($cat == "Broiler Feed" || $cat == "Layer Feed" || $cat == "Native Feed")))
	{
	$quantity *= $bagscapacity[$bagtype]; 
	$quantityr *= $bagscapacity[$bagtype]; 
	$rateperunit = round($rateperunit/$bagscapacity[$bagtype],4);
	
	}
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


	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$coacode = $qr['iac'];
	
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','".$code."','Dr','".$coacode."','$quantityr','".($itemcost * $conversion)."','".$so."','".$type."','".$vendor."','".$warehouse."')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

$newamount = $grandtotal + ($amt * $conversion);
		if($date == $date1)
		{
		$q2 = "update ac_financialpostingssummary set amount = '$newamount' where coacode = '$coacode' and date = '$adate' and crdr = 'Dr'";	
		$r23 = mysql_query($q2,$conn) or die(mysql_error());
		if(mysql_affected_rows() == 0)
		{
		
		
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($itemcost * $conversion),'Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		
		
		}
		}
		else
		{
		$q3 = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$adate','$coacode',($itemcost * $conversion),'Dr','$warehouse','$client')";
		$r = mysql_query($q3,$conn) or die(mysql_error());
		}


 

}
  
}
$balance = $grandtotal - $_POST['pamount1'] - $_POST['pamount2'];

$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',balance = '$balance' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

///Saving Payment - 1
$tid = $_POST['tid1'];
$paymentmethod = "Payment";
$paymentmode = $_POST['paymentmode1'];
$choice = "SOBIs";
$code = $_POST['pcode1'];	//Cash Code OR Bank Code
$code1 = $_POST['code11'];
$description = $_POST['pdescription1'];
$cr = $_POST['cr'];
$amount = $_POST['pamount1'];
$cheque = $_POST['cheque1'];
$cdate = date("Y-m-d",strtotime($_POST['cdate1']));
if($code <> "select" && $amount > 0 && $amount <> "")
{
$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,client,totalamount) values('','$tid','$date','$vendor','$paymentmethod','Without TDS','','','','0','$paymentmode','$code','$code1','$description', 'Cr','$amount','$cheque','$cdate','$choice','$so','$grandtotal','$amount','$balance','1','$client','$amount')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$venname = $vendor;
$type = "PMT";
   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
               VALUES('".$date."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$venname."','$client')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	$q = "select distinct(va) as code1 from contactdetails where name = '$venname' and (type = 'vendor' or type = 'vendor and party') order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $code1 = $qr['code1'];

	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }
	elseif($paymentmode == 'Cheque')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1' AND client = '$client'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$date."','','Dr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$venname."','$client','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());


$query5 = "UPDATE pp_payment SET flag = '1',adate = '$date',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid' and client = '$client'" ;
$result5 = mysql_query($query5,$conn) or die(mysql_error());
}
//End of Payment


///Saving Payment - 2
$tid = $_POST['tid2'];
if($tid == "")
{
$q = "select max(tid) as tid from pp_payment";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tid = $qr['tid'];
$tid++;
}
$paymentmethod = "Payment";
$paymentmode = $_POST['paymentmode2'];
$choice = "SOBIs";
$code = $_POST['pcode2'];	//Cash Code OR Bank Code
$code1 = $_POST['code12'];
$description = $_POST['pdescription2'];
$cr = $_POST['cr'];
$amount = $_POST['pamount2'];
$cheque = $_POST['cheque2'];
$cdate = date("Y-m-d",strtotime($_POST['cdate2']));
if($code <> "select" && $amount > 0 && $amount <> "")
{
$q = "insert into pp_payment (remarks,tid,date,vendor,paymentmethod,tds,tdscode,tdsdescription,tdscr,tdsamount,paymentmode,code,code1,description,cr,amount,cheque,cdate,choice,posobi,actualamount,amountpaid,balance,flag,client,totalamount) values('','$tid','$date','$vendor','$paymentmethod','Without TDS','','','','0','$paymentmode','$code','$code1','$description', 'Cr','$amount','$cheque','$cdate','$choice','$so','$grandtotal','$amount','$balance','1','$client','$amount')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

$venname = $vendor;
$type = "PMT";
   $code = $code1;
   $amount = $amount;
  
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client) 
               VALUES('".$date."','','Cr','".$code."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$venname."','$client')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	$q = "select distinct(va) as code1 from contactdetails where name = '$venname' and (type = 'vendor' or type = 'vendor and party') order by va";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $code1 = $qr['code1'];

	//To get the cash,bank,cashbankcode,schedule
	if($paymentmode == 'Cash')
	{ $cash = 'YES'; $bank = 'NO'; $cashcode = $code; $bankcode = ""; }
	elseif($paymentmode == 'Cheque')
	{ $cash = 'NO'; $bank = 'YES'; $bankcode = $code; $cashcode = ""; }
	$q = "SELECT schedule FROM ac_coa WHERE code = '$code1' AND client = '$client'";
	$r = mysql_query($q,$conn) or die(mysql_error());
	$rr = mysql_fetch_assoc($r);
	$schedule = $rr['schedule'];
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,cash,bank,cashcode,bankcode,schedule) 
               VALUES('".$date."','','Dr','".$code1."','$quantity','".$amount."','".$tid."','".$type."','".$venname."','".$venname."','$client','$cash','$bank','$cashcode','$bankcode','$schedule')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());


$query5 = "UPDATE pp_payment SET flag = '1',adate = '$date',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid' and client = '$client'" ;
$result5 = mysql_query($query5,$conn) or die(mysql_error());
}
//End of Payment




echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_cashdirectpurchase';";
echo "</script>";

?>