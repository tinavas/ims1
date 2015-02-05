<?php 
//echo "<pre/>"; print_r($_POST); exit;
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
$c=0;

		for($i = 0;$i < count($_POST['price']); $i++)
		if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] != '')
		{
    $warehouse =$_POST['aaa'];
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$description = $t[1];
	$units = $_POST['units'][$i];
	$rateperunit=$_POST['price'][$i];
	 
	$q = "select distinct(iac),sunits from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$iac = $qr['iac'];
	$sunits=$qr["sunits"];
	}
	$q="select conunits from ims_convunits where fromunits='$sunits' and tounits='$units'";
	$qrs=mysql_query($q,$conn);
	$qr=mysql_fetch_assoc($qrs);
	$conunit=$qr["conunits"];
	if($sunits==$units || $conunit=='')
	{
		$conunit=1;
		}
	$qtyr = $_POST['qtys'][$i]/$conunit;
	
	$qtyr=round($qtyr,3);
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
  $dt=date("Y-m-d");
  $query21 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$code' and coacode = '$iac'  and date <= '$dt' and quantity > 0 and warehouse='$warehouse' group by crdr order by date,type ";
 $result21 = mysql_query($query21,$conn);
	  $cnt21 = mysql_num_rows($result21);
	  $qty2=0;
	  $qtycr2=0;
	  $qtydr2=0;
      while($row21 = mysql_fetch_assoc($result21))
      {
          if($row21['crdr']=="Cr")
		  {
        $qtycr2 = $row21['quantity']; 
		  }
		  else
		  {
		 $qtydr2 = $row21['quantity'];
		  }
      }
	  
	   $qty2=$qtydr2-$qtycr2;
	  if($qtyr<=$qty1)
	 
	  {

}
else
 {$c=1;
 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty2  $sunits ' );";
echo "document.location='dashboardsub.php?page=oc_directsales'";
echo "</script>"; 
	 }
$j=$i;	
$j++; 
/*if($rateperunit==0)
{
echo "<script type='text/javascript'>";
echo "alert('Rate per unit is 0 at Row $j ');";
echo "document.location='dashboardsub.php?page=oc_directsales'";
echo "</script>"; 

}*/	
}

$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");
if($c==0)
{

	for($i = 0;$i < count($_POST['price']); $i++)
	if( $_POST['price'][$i] != '0' && $_POST['price'][$i] != '' && $_POST['code'][$i] != '')
	{

	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$description = $t[1];
	$warehouse =$_POST['aaa'];  
	$units = $_POST['units'][$i];
	
	$q = "select distinct(iac),sunits from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$iac = $qr['iac'];
	$sunits=$qr["sunits"];
	}
	$q="select conunits from ims_convunits where fromunits='$sunits' and tounits='$units'";
	$qrs=mysql_query($q,$conn);
	$qr=mysql_fetch_assoc($qrs);
	$conunit=$qr["conunits"];
	if($sunits==$units || $conunit=='')
	{
		$conunit=1;
		}
	$qtyr = $_POST['qtys'][$i];
	$qtys = $_POST['qtys'][$i]/$conunit;
	$qtys=round($qtys,3);
	if($_SESSION['db']=="mew")
	{
		$length=$_POST['length'][$i];
		$width=$_POST['width'][$i];
		$tot_length+=$length;
		$tot_width+=$width;
	}
	$price = $_POST['price'][$i];	
	$prices = $_POST['price'][$i]*$conunit;
	$totalquantity+= $qtyr;
	$totalquantitys+= $qtys;
	if($_SESSION['db']=="mew")
	{
		$totalquantity+= $length*$width;
		$totalquantitys+= $length*$width;
	}

	$tax1 = explode("@",$_POST['vat'][$i]);
   $taxcode = $tax1[0];
  $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
  $taxie = $tax1[3];
  
	
	$discount1 = $_POST['disc'][$i];
   
   $discvalue = $_POST['disc'][$i];
$free=$_POST['free'][$i];
if($free=="on")
$free="No";
else
$free="Yes";
	
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['discountamount'][$i];


   
if($taxvalue=="")
$taxvalue=0;

     
   if($discountvalue=="")
$discountvalue=0;


$discountamount=round($discountamount,3);


$taxamount=round($taxamount,3);






  $empid = 0;
  if($_SESSION['db']=="mew")
  {
	$qtyr=0;
	 $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,length,width,cquantity,price,pricec,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,adate,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,taxvalue,taxamount,freightie,cunits,convunits,totallength,totalwidth) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$code','$description','$length','$width','$qtyr' ,'$prices','$price' ,'$freight' ,'$basic' ,'$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$adate','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$taxvalue','$taxamount','$freighttype','','','0','0')";
	
  }
  else
  {
 $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,quantity,cquantity,freequantity,price,pricec,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,discountamount,coacode,cno,units,warehouse,client,adate,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,taxvalue,taxamount,freightie) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$code','$description','$qtys','$qtyr' ,'$free','$prices','$price' ,'$freight' ,'$basic' ,'$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$adate','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$taxvalue','$taxamount','$freighttype')";
 }
  
	
	$qrs = mysql_query($q,$conn);
	
}
 if($_SESSION['db']=="mew")
  {
	$q = "update oc_cobi set totallength = '$tot_length',totalwidth='$tot_width=',finaltotal = '$grandtotal',empname='$empname',adate='$adate' where invoice = '$invoice' and client = '$client' ";
  }
  else
  {
	$q = "update oc_cobi set totalquantity = '$totalquantitys',finaltotal = '$grandtotal',empname='$empname',adate='$adate' where invoice = '$invoice' and client = '$client' ";
  }
$qr = mysql_query($q,$conn) or die(mysql_error());



?>

<?php 

//Insert into ac_financialpostings

$freightamount = $freight;

$vendor = $party;

$adate = $date;
$so = $invoice;

$type = "COBI";



if($totalquantitys=="")
$totalquantitys=0;


$acceptedquantity=0;


for($i = 0;$i < count($_POST['price']); $i++)
{
if($_POST['price'][$i] != '0' && $_POST['price'][$i] != '')
{


	$code = $_POST['code'][$i];
	
	$t = explode('@',$code);
	$code = $t[0];
	$description=$t[1];
	$query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code' and client = '$client' ";
   $result3 = mysql_query($query3,$conn);
   while($row3 = mysql_fetch_assoc($result3))
   {
		$sunits=$row3["sunits"];
		$cunits=$row3["cunits"];
   }
   $q="select conunits from ims_convunits where fromunits='$sunits' and tounits='$cunits'";
	$qrs=mysql_query($q,$conn);
	$qr=mysql_fetch_assoc($qrs);
	$conunit=$qr["conunits"];
	if($sunits==$units || $conunit=='')
	{
		$conunit=1;
	}
		
	if($_SESSION['db']=="mew"){
	$quantity = $_POST['length'][$i]*$_POST['width'][$i];
	$quantity1 = $_POST['length'][$i]*$_POST['width'][$i]/$conunit;
	}
	else
	{
		$quantity=$_POST['qtys'];
		$quantity1=$_POST['qtys']/$conunit;
	}
	$quantity1=round($quantity1,3);
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
$discountamount = $_POST['discountamount'][$i];
	$warehouse = $_POST['flock'][$i];
	
	
	

$itemcost = round($quantity * $rateperunit,3);
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
$query3 = "SELECT * FROM oc_cobi where invoice = '$so'  and client = '$client' and code = '$code'";
$result3 = mysql_query($query3,$conn);
while($row3 = mysql_fetch_assoc($result3))
  {
  	 $freighttype = $row3['freighttype'];
	 $units = $row3['units'];	 
  }
   $stdcost = $stdcost * $quantity;
	////Item Account Credit

    $warehouse = $postingswarehouse;	
//$quantity1 = 0;
$stdcost = round($stdcost,3);
        
		
		

	$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$quantity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

     

   



   /// COGS A/C Debit
  
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Dr','".$cogsac."','".$quantity1*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
 
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	///Sales A/C Credit
if($rateperunit>0)
{
	$salesamount = round($salesamount,3);
	
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Cr','".$sac."','$quantity1','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";

 $result4 = mysql_query($query4,$conn) or die(mysql_error());

}

  $query2 = "SELECT coa FROM ims_taxcodes WHERE code = '$taxcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];
	  
	  
	//tax
	
  if($taxamount > 0)
  {
  $taxamount=round($taxamount,3);
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$adate."','".$taxcode."','Cr','".$ta."','".$quantity1."','".$taxamount."','".$invoice."','".$type."','".$vendor."','$globalwarehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }
if($freightie=="Include Paid By Customer")
$finaltotal=$finaltotal-$freightamount;
	}
}

if($freightamount > 0)
{
$freightamount=round($freightamount,3);
if($freighttype <> "Include Paid By Customer")
{
 $q = "select coacode from ac_bankmasters where code = '$cashbankcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	 $coacode = $qr['coacode']; 
 
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','','Cr','".$coacode."','$totalquantitys','".($freightamount)."','".$so."','".$type."','".$vendor."','".$globalwarehouse."')";
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
	          VALUES('".$adate."','','Dr','".$coa."','$totalquantitys','".$freightamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','$cash','$bank','$cashcode','$bankcode','$schedule')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 }
}


if($freighttype == "Include Paid By Customer")
{
 
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','','".Dr."','".$coa."','$totalquantitys','".$freightamount."','".$so."','".$type."','".$vendor."','$globalwarehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 
 
 }


}

	$q = "select distinct(ca) as code1 from contactdetails where name = '$vendor' and type like '%party%' and client = '$client'  order by ca";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

   ///Customer Account Debit
   $grandtotal = round($grandtotal,3);

	$totqty=$totalquantitys;
	if($totqty=="")
	$totqty=0;
	
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Dr','".$code1."','$totqty','".$grandtotal."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	




 $query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where invoice = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_directsales'";
echo "</script>";
?>