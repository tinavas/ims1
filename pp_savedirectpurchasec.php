<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$vendor = $_POST['vendor'];
$bookinvoice = $_POST['bookinvoice'];
$temp = explode('-',$date);
$m = $temp[1];
$y = substr($temp[0],2);
if($_POST['saed'] == 1)
{
$so = $_POST['invoice'];
$sobiincr = $_POST['sobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];
$query = "DELETE FROM pp_sobi WHERE so = '$so'";
$result = mysql_query($query,$conn) or die(mysql_error());
}
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

$conversion = 1;
$edit = $_POST['edit'];
 if($edit <> "yes" && $_SESSION['db'] == "central")
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
  
$cterm = $_POST['cterm'];
$temp = explode('@',$cterm);
$ctermcode = $temp[0];
$ctermdesc = $temp[1];
$ctermvalue = $temp[2];
if($ctermvalue == "") $ctermvalue = 0;

for($i = 0;$i < count($_POST['price']); $i++)
if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] !='')
{
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	if($_POST['saed'] <> 1)
	{
	 $t = explode('@',$code);
	 $code = $t[0];
	} 
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
	$taxamount = $_POST['taxamount'][$i];
	$flock = $_POST['flock'][$i];
	if($_POST['saed'] == 1)
	 $warehouse = $_POST['doffice'][$i];
	else
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
	$resultw=mysql_query("select unitcode from layer_flock where flockcode = '$flock'",$conn) or die(mysql_error());
while($resw = mysql_fetch_assoc($resultw))
$warehouse = $resw['unitcode'];
	}
	
	
	$execute = 1;
	$autoflock ="";
	
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
			$cflag = 1;
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
	
	if($_SESSION['db'] == "central")	//Central has dual currency
		$q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,credittermcode,credittermdescription,credittermvalue)	values('$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr',($price * $conversion),'$units','$bags','$bagtype','$bagunits',($vat * $conversion),($taxamount * $conversion),($freight * $conversion),($basic * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),($grandtotal * $conversion),'$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0',($discountamount * $conversion),'$coa','$cheque','$autoflock','$sentquantity','$warehouse','$ctermcode','$ctermdesc','$ctermvalue')";
	else
		$q = "insert into pp_sobi (remarks,date,sobiincr,m,y,so,invoice,vendor,broker,code,description,receivedquantity,rateperunit,itemunits,bags,bagtype,bagunits,taxvalue,taxamount,freightamount,totalamount,pocost,grandtotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coa,cno,flock,sentquantity,warehouse,credittermcode,credittermdescription,credittermvalue)	values('$remarks','$date','$sobiincr','$m','$y','$so','$bookinvoice','$vendor','$broker','$code','$description','$qtyr','$price','$units','$bags','$bagtype','$bagunits','$vat','$taxamount','$freight','$basic','$grandtotal','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$autoflock','$sentquantity','$warehouse','$ctermcode','$ctermdesc','$ctermvalue')";
	

if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
 $qrs = mysql_query($q,$conn) or die(mysql_error());
} 
}
if($execute == 1)	//IF EXECUTE = 0 means, they should cull the previous flock
{
 if($_SESSION['db'] == "central")	//Central has dual currency
  $q = "update pp_sobi set totalquantity = '$totalquantity',orgamount =  '$grandtotal',camount = '$conversion' where so = '$so'";
 else
  $q = "update pp_sobi set totalquantity = '$totalquantity' where so = '$so'";
 $qr = mysql_query($q,$conn) or die(mysql_error());
}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_directpurchase'";
echo "</script>";

?>

