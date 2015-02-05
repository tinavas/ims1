<?php
include "config.php";
//print_r($_POST);
$id = $_POST['oldinv'];
$date = date("Y-m-d",strtotime($_POST['date']));
$invoice = $_POST['oldinv'];
$cobiincr = $_POST['cobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];
$tot=0;

$c=0;

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '' && $_POST['code'][$i] != '')
{
    $warehouse =$_POST['aaa'];;
    $flock = $_POST['flock'][$i];
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$t = explode('@',$code);
	$code = $t[0];
	$description = $t[1];
	$description = $_POST['description'][$i];
	$units = $_POST['units'][$i];
	$qtyr = $_POST['qtys'][$i];
	
$rateperunit=$_POST['price'][$i];
if(rateperunit=="")
$rateperunit=0;
	 
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

$query2 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$code' and coacode = '$iac'  and date <= '$date' and quantity > 0 and warehouse='$warehouse' and trnum !='$invoice' group by crdr order by date,type ";
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
 $qtyr=$qtydr1-$qtycr1;
  
  $q0="select quantity from oc_cobi where code='$code' and invoice='$invoice' and warehouse='$warehouse'";
  $r0=mysql_query($q0,$conn);
  $r10=mysql_fetch_array($r0);
$qty0=$r10['quantity'];

	  if($qty0<=$qtyr)
	 
	  {

}
else
 {$c=1;
 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qtyr $sunits');";
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

}	*/
}


if($c==0)
{


$get_entriess = "DELETE FROM oc_cobi WHERE invoice = '$id'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


$get_entriess = "DELETE FROM ac_financialpostings WHERE trnum = '$id' and type = 'COBI' ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());



$temp=explode("-",$id);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$invoice=$id;

else
{
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

 
 }


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

$bookinvoice = $_POST['bookinvoice'];
$remarks = $_POST['remarks'];
$cobiincr = $_POST['cobiincr'];
$m = $_POST['m'];
$y = $_POST['y'];

$basic = $_POST['basic'];


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


$empname=$_POST['cuser'];
$adate=date("Y-m-d");


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
	if($sunits==$units || $conunit=="")
	{
		$conunit=1;
		}
	$qtyr = $_POST['qtys'][$i];
	$qtys = $_POST['qtys'][$i]/$conunit;
	$qtys=round($qtys,5);
	$price = $_POST['price'][$i];
	$prices = $_POST['price'][$i]*$conunit;	
	
	$totalquantity+= $qtyr;
	$totalquantitys+= $qtys;

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
$free=$_POST['fre'][$i];


   
if($taxvalue=="")
$taxvalue=0;

   
   
   if($discountvalue=="")
$discountvalue=0;


$discountamount=round($discountamount,5);


$taxamount=round($taxamount,5);

  $empid = 0;
 $q = "insert into oc_cobi (partycode,remarks,date,cobiincr,m,y,invoice,bookinvoice,party,code,description,quantity,cquantity,freequantity,price,pricec,freightamount,total,finaltotal,balance,empid,empname,sector,flag,vno,driver,freighttype,viaf,datedf,cashbankcode,dflag,srflag,discountamount,coacode,cno,units,warehouse,client,adate,taxcode,taxie,taxformula,discountcode,discountvalue,discountformula,taxvalue,taxamount,freightie) 
	values('$partycode','$remarks','$date','$cobiincr','$m','$y','$invoice','$bookinvoice','$party','$code','$description','$qtyr','$qtys','$free','$prices','$price','$freight','$basic','$grandtotal','$grandtotal','$empid','$empname','$sector','0','$vno','$driver','$freighttype','$viaf','$datedf','$cashbankcode','0','0','$discountamount','$coa','$cheque','$units','$globalwarehouse','".$client."','$adate','$taxcode','$taxie','$taxmode','$disccode','$discvalue','$discmode','$taxvalue','$taxamount','$freighttype')";
 
  
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
}
$q = "update oc_cobi set totalquantity = '$totalquantitys',finaltotal = '$grandtotal',empname='$empname',adate='$adate' where invoice = '$invoice' and client = '$client' ";
$qr = mysql_query($q,$conn) or die(mysql_error());



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
	if($sunits==$units || $conunit=="")
	{
		 $conunit=1;
		}
		//echo $_POST['qtys'][$i]/$conunit."/".$i."ewfdsfjdsfhiksnfkjkgbfjhds<br><br><br>";
	 $quantity = $_POST['qtys'][$i];
	$quantity1 = $_POST['qtys'][$i]/$conunit;
	 $quantity1=round($quantity1,5);
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
  
	
	$discount1 = explode("@",$_POST['disc'][$i]);
   $disccode = $discount1[0];
   $discvalue = $discount1[1];
  $discmode = $discount1[2];
	
	
	
	//$warehouse = $_POST['doffice'][$i];
	$taxamount = $_POST['taxamount'][$i];
$discountamount = $_POST['discountamount'][$i];
	$warehouse = $_POST['flock'][$i];
	
	
	

$itemcost = round($quantity * $rateperunit,5);
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
  $date = date("Y-m-d",strtotime($_POST['date']));
  $warehouse =$_POST['aaa'];
    $mode = $row3['cm']; 
  
	$cogsac = $row3['cogsac'];
	$itemac = $row3['iac'];
	$sac = $row3['sac'];
	$stdcost=calculatenew($warehouse,$mode,$code,$date);
  }

  //echo $stdcost;

 $warehouse1 = $postingswarehouse;
 $stdcost = $stdcost * $quantity;
	////Item Account Credit

    $warehouse = $postingswarehouse;	
$dummyquantity = 0;
$stdcost = round($stdcost,5);
		
		
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

   



   /// COGS A/C Debit
   
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Dr','".$cogsac."','".$quantity*$capacity."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	///Sales A/C Credit
if($rateperunit>0)
{
	$salesamount = round($salesamount,5);
	$tot =$tot + $salesamount;
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','$code','Cr','".$sac."','0','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());
 $code1="SATR01";
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Dr','".$code1."','0','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
 }



  $query2 = "SELECT coa FROM ims_taxcodes WHERE code = '$taxcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];
	  
	  
	//tax
	
  if($taxamount > 0)
  {$taxamount=round($taxamount,5);
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$adate."','".$taxcode."','Cr','".$ta."','".$quantity1."','".$taxamount."','".$invoice."','".$type."','".$vendor."','$globalwarehouse')";
  $result4 = mysql_query($query4,$conn) or die(mysql_error());

  }

	
if($freightie=="Include Paid By Customer")
$finaltotal=$finaltotal-$freightamount;


	}
	
}





if($freightamount > 0)
{
$freightamount=round($freightamount,5);
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


/*	$q = "select distinct(ca) as code1 from contactdetails where name = '$vendor' and type like '%party%' and client = '$client'  order by ca";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$code1 = $qr['code1'];

   ///Customer Account Debit
  

	$totqty=$totalquantitys;
	if($totqty=="")
	$totqty=0;*/
	 $gt = round($grandtotal-$tot,5);
	 if($gt>0)
	 {
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Dr','".$code1."','$totqty','".$gt."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	}
	




 $query5 = "UPDATE oc_cobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where invoice = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

}

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_directsales'";
echo "</script>";
?>