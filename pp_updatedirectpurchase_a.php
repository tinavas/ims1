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
	if($_SESSION['db'] == 'albustanlayer' && $cat == 'Layer Feed')
	{
	$sentquantity = $_POST['qtys'][$i] *1000;
	$qtyr = $_POST['qtyr'][$i]*1000;
	$price = $_POST['price'][$i]/1000;
	}
	else
	{
	$sentquantity = $_POST['qtys'][$i];
	$qtyr = $_POST['qtyr'][$i];
	$price = $_POST['price'][$i];
	}
	
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$fqty = $_POST['fqty'][$i]; if($fqty=='') $fqty=0;
	$bags = $_POST['bags'][$i];
	$bagtype1 = explode("@",$_POST['bagtype'][$i]);
	$bagtype = $bagtype1[0];
	$bagunits = $bagtype1[1];
	
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
	$resultw=mysql_query("select farmcode as unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
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
 			  echo "document.location='dashboardsub.php?page=pp_directpurchase_a'";
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
	if($_SESSION['db'] == "albustanlayer")
	{
	 $batchno = $_POST['batch'][$i];
	 $expdate = date("Y-m-d",strtotime($_POST['expdate'][$i]));
	  $q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,warehouse,sentquantity,credittermcode,credittermdescription,credittermvalue,batchno,expdate,fqty) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$warehouse','$sentquantity','$ctermcode','$ctermdesc','$ctermvalue','$batchno','$expdate','$fqty')";
	}	
	elseif($_SESSION['db'] == "suriya")
	{
	 $billdate = date("Y-m-d",strtotime($_POST['billdate']));
	  $q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,warehouse,sentquantity,credittermcode,credittermdescription,credittermvalue,billdate) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$warehouse','$sentquantity','$ctermcode','$ctermdesc','$ctermvalue','$billdate')";
   }	
	else
	  $q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,warehouse,sentquantity,credittermcode,credittermdescription,credittermvalue) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$warehouse','$sentquantity','$ctermcode','$ctermdesc','$ctermvalue')";
	
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

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase_a';";
echo "</script>";
?>