<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<table align="center">
<?php
include "config.php";
include "jquery.php";
include "getemployee.php";
 
if($_GET['fromdate'] <> "")

 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));

else

 $fromdate = date("Y-m-d");

if($_GET['todate'] <> "")

 $todate = date("Y-m-d",strtotime($_GET['todate']));

else

 $todate = date("Y-m-d"); 
 
 
 $qq=mysql_query("select distinct(warehouse) as party from ac_financialpostings");
 while($rr=mysql_fetch_array($qq))
 {
  $cus1[]=$rr[party];
 }
 ?>
<table align="center">
<tr>
<td>From</td>

 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"/></td>

 <td>To</td>

 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 
 </tr>
 </table>

<?php 

$qdif=mysql_query("select datediff('$todate','$fromdate') as days");
$rdiff=mysql_fetch_array($qdif);
echo $days=$rdiff['days'];
$dt1=$fromdate;
echo "<br>";
for($j=0;$j<$days;$j++)
{

//for($k=count($cus1);$k>=0;$k--)



{
// echo $cus=$cus1[$k];
$dtt=mysql_query("select date_add('$dt1', interval $j day)");
$rtt=mysql_fetch_array($dtt);
echo  $dt=$rtt[0];

echo $two="select * from product_productionunit where date='$dt'";
$a=mysql_query($two);
while($a1=mysql_fetch_array($a))
{
$mode="Weighted Average";
$amt=0;
$b=mysql_query("select * from product_itemwise where date='$dt' and warehouse='$a1[warehouse]' and producttype='$a1[producttype]' and formulae='$a1[formula]'");
while($b1=mysql_fetch_array($b))
{
 $b1[squantity];
//echo "<br>";
$pr=calculatenew($b1[warehouse],$mode,$b1[ingredient],$dt);
$amt+= $aamt=$b1[squantity]*$pr;
 $c="update ac_financialpostings set amount='$aamt' where date='$dt' and itemcode='$b1[ingredient]' and trnum='$b1[formulae]'  and warehouse='$b1[warehouse]'";
mysql_query($c);
}
echo "<br>";
 $c="update ac_financialpostings set amount='$amt' where date='$dt' and itemcode='$a1[producttype]' and trnum='$a1[formula]'  and warehouse='$a1[warehouse]'";
mysql_query($c);
 $d="update product_productionunit set materialcost='$amt',costperunit='$ct',productioncostperkg='$ct' where  date='$dt' and producttype='$a1[producttype]' and formula='$a1[formula]'  and warehouse='$a1[warehouse]'";
mysql_query($d);
}

echo $qs1="select * from ims_stocktransfer where date='$dt'";
$qs=mysql_query($qs1);
echo mysql_num_rows($qs);
while($rs=mysql_fetch_array($qs))
{
$pr=$at=0;
$mode="Weighted Average";
$pr=calculatenew($rs[fromwarehouse],$mode,$rs[code],$dt);
$at=$pr*$rs[quantity];
echo $qu="update ims_stocktransfer set price='$pr' where tid='$rs[tid]' and code='$rs[code]'";
mysql_query($qu);
echo $qp="update ac_financialpostings set amount='$at' where trnum='$rs[id]' and type='STR' and itemcode='$rs[code]'";
mysql_query($qp);
if($rs[flag]=='1')
{
echo $qu="update ims_stockreceive set price='$pr' where transferid='$rs[tmno]' and code='$rs[code]'";
mysql_query($qu);
$qt=mysql_query("select tid from ims_stockreceive where transferid='$rs[tmno]' and code='$rs[code]'");
$rt=mysql_fetch_array($qt);
 echo $qp="update ac_financialpostings set amount=quantity*$pr where trnum='$rt[tid]' and type='SRC' and itemcode='$rs[code]'";
mysql_query($qp);
}
echo "<br>";
}




echo $one="select distinct(invoice) as invoice,date,party,srflag from oc_cobi where date ='$dt' order by date";
$q1=mysql_query($one)or die(mysql_error());
while($r1=mysql_fetch_array($q1))
{
//echo $r1[date]."gdfg".$fromdate;



 
//............................Production.............

$n=0;
$q3="select ca from contactdetails where name='$r1[party]'";

$q3=mysql_query($q3) or die(mysql_error());

$r3=mysql_fetch_assoc($q3);

$ca=$r3['ca'];

$qcobi=mysql_query("select * from ac_financialpostings where coacode='$ca' and trnum='$r1[invoice]'");

if(mysql_num_rows($qcobi)>0)
{
$n=0;
}
else
{
$n=1;
}

$amt=0;
$q2=mysql_query("select * from oc_cobi where invoice='$r1[invoice]'");
while($r2=mysql_fetch_array($q2))
{
if($invoice!=$r2[invoice])
{
$q4="delete from ac_financialpostings where trnum='$r2[invoice]'";
$r4=mysql_query($q4);
}
$date=$r2['date'];
echo $code=$r2[code];
$tot=0;
$freeqty=0;
$party = $r2['party'];

$bookinvoice = $r2['bookinvoice'];

$m = $r2['m'];
$y = $r2['y'];

echo $invoice = $r2[invoice];

$discount = $r2['discountvalue'];
$vno = $r2['vno'];
$driver = $r2['driver'];
$remarks = $r2['remarks'];
$freighttype = $r2['freighttype'];
$freight = $r2['freightamount'];
$viaf = $r2['cvia'];
$datedf = $r2['datedf'];
$cashbankcode = $r2['cashbankcode'];
$fcoa = $coa = $r2['coacode'];
$cheque = $r2['cno'];
$damt += $r2['discountamount'];
$finaldiscountamount = $r2['finaldiscount'];
$grandtotal =$gr = $r2['finaltotal'];
$globalwarehouse = $r2['warehouse'];
$totalquantity = 0;
$cnt = 0;
$c=0;

$g=$gr-$discountamount;

    $warehouse =$r2['warehouse'];
	$code = $r2['code'];

	$description = $r2['description'];
	$units = $r2['units'];
	$rateperunit=$r2['pricec'];
	 
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$iac = $qr['iac'];
	}

	$qtyr = $r2['quantity'];
	
	$qtyr=round($qtyr,5);
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
	  if($qtyr<=$qty1)
	 
	  {

}
else
 {
//echo "aaaaaaaaaaa";
	//$c=1;
	 }

$empname=$r2[empname];
if($c==0)
{
	 $price = $r2['pricec'];	
	//echo "dfh<br><br>";
	$totalquantity+= $qtyr;
$freightamount = $freight;
$vendor = $party;
$adate = $date;
$so = $r2[invoice];
$type = "COBI";


	$capacity=1;
$discvalue=0;
$qd=mysql_query("select discount from oc_discounts where '$date' between fromdate and todate and customer='$party' and code='$code'");
$rd=mysql_fetch_array($qd);

   $discvalue = $rd['discount'];
	$taxamount = $r2['taxamount'];
	$discountamount =0;
$discountamount = (($r2[quantity]*$r2[price])* $discvalue)/100;

if($discvalue=='' ||$discvalue=='0')
$discvalue= $discountamount=0;

$itemcost = round($qtyr * $rateperunit,5);
//echo $itemcost."/".$discountamount;

$salesamount=$itemcost-$discountamount;
 $amt +=round($salesamount,5);

//echo "sale<br>";
 if($taxie=="Include")
    $salesamount= $salesamount-$taxamount;
	
$stdcost = 0;
$cogsac = "";
$itemac = "";
$sac = "";
 $warehouse = "$r2[warehouse]";
 $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$code' ";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
    $mode = $row3['cm']; 
	$cogsac = $row3['cogsac'];
	$itemac = $row3['iac'];
	$sac = $row3['sac'];
	 	echo $stdcost=calculatenew($warehouse,$mode,$code,$date);
  }
echo "<br><br>";
//echo $stdcost;
echo "<br><br>";
$query5 = "UPDATE oc_cobi SET discountamount='$discountamount',discountvalue='$discvalue' where invoice = '$r2[invoice]' and code='$code'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
   $stdcost = $stdcost * $qtyr;
$stdcost = round($stdcost,5);
$salesamount = round($salesamount,5);
	$tot = $tot + $salesamount;
	$code1 ="SATR01";
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$itemac."','".$qtyr."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate'),
			  ('".$adate."','".$code."','Dr','".$cogsac."','".$qtyr."','".$stdcost."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate'),
			  ('".$adate."','','Cr','".$sac."','$qtyr','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
			      $result4 = mysql_query($query4,$conn) or die(mysql_error());
?>

<?php 
			  if($n>0)
			  {
			 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES ('".$adate."','','Dr','".$code1."','$qtyr','".$salesamount."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
			  $result4 = mysql_query($query4,$conn) or die(mysql_error());
			  }
			  else
			  {
			  
			  }
			  
echo "<br><br>";
  $query2 = "SELECT coa FROM ims_taxcodes WHERE code = '$r2[taxcode]'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  	  $ta = $row2['coa'];
  if($taxamount > 0)
  {
  $taxamount=round($taxamount,5);
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) VALUES('".$adate."','".$taxcode."','Cr','".$ta."','".$qtyr."','".$taxamount."','".$invoice."','".$type."','".$vendor."','$globalwarehouse')";
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
$ft=$amt-$freightamount;
if($n>0)
{
}
else
{
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','','Dr','".$ca."','".$ft."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
}

   $gt = round($amt-$damt,5);
    if($g>$gt)
	{
	$f=$g-$gt;
	//echo $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          //VALUES('".$adate."','','Dr','".$code1."','$qtyr','".$f."','".$so."','".$type."','".$vendor."','".$globalwarehouse."','".$client."','$empname','$adate')";
   // $result4 = mysql_query($query4,$conn) or die(mysql_error());
}
echo "<br>";

 $query5 = "UPDATE oc_cobi SET flag = '1',finaltotal='$ft',balance='$ft', freightamount='$freightamount' where invoice = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
if($r1[srflag]==1)
{
$qq=mysql_query("select trnum from distribution_salesreceipt where invoice='$r1[invoice]'");
$rq=mysql_fetch_array($qq);
$cnt=mysql_num_rows($qq);
//$q5="delete from ac_financialpostings where trnum='$rq[tid]'";
//mysql_query($q5);
if($cnt>0)
{
$query4 = "update ac_financialpostings set amount='$ft' where trnum='$rq[trnum]' ";
mysql_query($query4);
$query5 = "update distribution_salesreceipt set finaltotal='$ft' where trnum='$rq[trnum]' ";
mysql_query($query5);
}
else
{

}
}

}


}
}
?>
</table>
</body>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "dashboardsub.php?page=rerun&fromdate=" + fdate + "&todate=" + tdate;
 //+"&flk=" +flk;
}
</script>
</html>
