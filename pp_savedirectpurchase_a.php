 <?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$temp=explode('@',$vendor);
$vendor=$temp[0];
$vendorcode=$temp[2];
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

if($_SESSION['db'] == "mlcf" or $_SESSION['db'] == "mbcf" or $_SESSION['db'] == "ncf")
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

$cterm = $_POST['cterm'];
$query="select code,description from ims_creditterm where value='$cterm'";
$r=mysql_query($query);
if($a=mysql_fetch_assoc($r)) {
$ctermcode = $a[code];
$ctermdesc = $a[description]; }

$ctermvalue = $cterm;
if($ctermvalue == "") $ctermvalue = 0;
$noofentries = 0;
for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] !='')
{
    $noofentries++;
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	if($_SESSION['db'] == 'albustanlayer' && $cat == 'Layer Feed')
	{
	$price = ($_POST['price'][$i])/1000;
	$qtyr = ($_POST['qtyr'][$i])*1000;
	$sentquantity = ($_POST['qtys'][$i])*1000;
	}
	else
	{
	$price = $_POST['price'][$i];
	$qtyr = $_POST['qtyr'][$i];
	$sentquantity = $_POST['qtys'][$i];
	}
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$fqty = $_POST['fqty'][$i]; if($fqty=='') $fqty=0;
	$bags = $_POST['bags'][$i];
	$bagtype1 = explode("@",$_POST['bagtype'][$i]);
	$bagtype = $bagtype1[0];
	$bagunits = $bagtype1[1];
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
	if(($_SESSION['db'] == "mlcf" && $cat == "Layer Feed") or ($_SESSION['db'] == "mbcf" && $cat == "Broiler Feed") or ($_SESSION['db'] == "ncf" && ($cat == "Broiler Feed" || $cat == "Layer Feed" || $cat == "Native Feed")))
	{
	$sentquantity *= $bagscapacity[$bagtype]; 
	$qtyr *= $bagscapacity[$bagtype]; 
	$price = round($price/$bagscapacity[$bagtype],4);
	$vat = round($vat/$bagscapacity[$bagtype],4);
	}
	
	if($cat == "Broiler Chicks" or cat == 'Broiler Day Old Chicks' or $cat == "Native Chicks")
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
	
	//////////////////////////////////
	if($cat == "Broiler Feed" or $cat == 'Native Feed')
	{
	  if($_SESSION['db'] == 'mbcf' || $_SESSION['db'] == 'ncf' || $_SESSION['db'] == 'farmvalley' )
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
			 $query5="SELECT * from pp_sobi where warehouse = '$warehouse'  and code in (select code from ims_itemcodes where ( cat = 'Broiler Feed' or cat = 'Native Feed')) order by date DESC LIMIT 1";
			}
			else
			{
			  $query5="SELECT * from pp_sobi where warehouse = '$warehouse' and date > '$trdate' and code in (select code from ims_itemcodes where (cat = 'Broiler Feed' or cat = 'Native Feed')) order by date DESC LIMIT 1";
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
if($_SESSION['client'] == 'FEEDATIVES')
{
$mrp = $_POST['mrp'][$i];
$batchno = $_POST['batch'][$i];
$expdate = $_POST['expdate'][$i];
$exp = date("Y-m-d",strtotime($expdate));
if($cat == "Medicines" or $cat == "Vaccines")
{
if($_POST['type'][$i] == 'Existing')
$autoflock = $_POST['existflock'][$i];
else
$autoflock = $_POST['aflock'][$i];
}
	$q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,mrp,batchno,expirydate,credittermcode,credittermdescription,credittermvalue) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr','$price','$units','$bags','$bagtype','$bagunits','$vat','$taxamount','$freight','$basic','$grandtotal','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$sentquantity','$warehouse','$mrp','$batchno','$exp','$ctermcode','$ctermdesc','$ctermvalue')";

}
elseif($_SESSION['db'] == "albustanlayer")
{
$batchno = $_POST['batch'][$i];
$expdate = $_POST['expdate'][$i];
$exp = date("Y-m-d",strtotime($expdate));
	
$q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,credittermcode,credittermdescription,credittermvalue,batchno,expdate,fqty) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$autoflock','$sentquantity','$warehouse','$ctermcode','$ctermdesc','$ctermvalue','$batchno','$exp','$fqty')";
}
elseif($_SESSION['db'] == "suriya")
{	
$billdate = date("Y-m-d",strtotime($_POST['billdate']));
$q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,credittermcode,credittermdescription,credittermvalue,billdate) 
	values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$autoflock','$sentquantity','$warehouse','$ctermcode','$ctermdesc','$ctermvalue','$billdate')";
}else
{	
$q = "insert into pp_sobi (vendorcode,remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,credittermcode,credittermdescription,credittermvalue,fqty) 
values('$vendorcode','$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$autoflock','$sentquantity','$warehouse','$ctermcode','$ctermdesc','$ctermvalue','$fqty')";
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
 $qrs = mysql_query($q,$conn) or die(mysql_error());
} 
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
if($_SESSION['db'] == "central") 
 $q = "update pp_sobi set totalquantity = '$totalquantity',orgamount =  '$grandtotal',camount = '$conversion' where so = '$so'";
else
 $q = "update pp_sobi set totalquantity = '$totalquantity' where so = '$so'";

 $qr = mysql_query($q,$conn) or die(mysql_error());
}



	//end of EXECUTE = 1
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase_a'";
echo "</script>";

?>

