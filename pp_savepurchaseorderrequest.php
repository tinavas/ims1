<?php
include "getemployee.php";
include "config.php";

$flag = '1';
$grflag = '0';

$initiatorid = $empid;
$initiatorname = $empname;
$initiatorsector = $sector;
$date = date("Y-m-d",strtotime($_POST['date']));
$temp = explode('-',$date);
$m = $temp[1];
$y = substr($temp[0],-2);
$conversion = 1;

if($_POST['edit'] == "yes")
{

 $q = "update hr_conversion set flag = 1 where id = '".$_POST['currencyid']."'";		//To Lock the Record
 $r = mysql_query($q,$conn) or die(mysql_error());
}



if($_POST['saed'] == 1)
{
 $po = $_POST['oldpo'];

  $query = "select flag from pp_purchaseorder where po = '$po'";
 $result = mysql_query($query,$conn) or die(mysql_error());
 $rows = mysql_fetch_assoc($result);


 $get_entriess = "delete from pp_purchaseorder WHERE po= '$po';"; 
 mysql_query($get_entriess,$conn) or die(mysql_error());
 
 $poincr=$_POST['poincr'];
 
 
 
  
 
$temp=explode("-",$po);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$po=$po;

else
{
$po="";


$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $piincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; }  

 
 }
 
 
 
 
}



if($_POST['saed'] <> 1)
{
$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $poincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; }  


}

$vendor = $_POST['vendor'];
$query = "select distinct(code) from contactdetails where name = '$vendor'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$vendorcode = $rows['code'];
}
$creditterm = explode('@',$_POST['creditterm']);
$credittermcode = $creditterm[0];
$credittermdescription = $creditterm[1];
$credittermvalue = $creditterm[2];
$tandcdesc = $_POST['tandcdesc'];
$desc=$_POST['tandccode'];
	if ($desc){
	 foreach ($desc as $desc1){ $descs .= $desc1; $descs .= ","; }
	}
$descs1 = substr($descs, 0, strlen($descs)-1); 
$tandccode = "";
$desc2 = explode(',',$descs1);
for($j=0;$j<sizeOf($desc2);$j++)
{
 $tandc = explode('@',$desc2[$j]);
 $tandccode .= $tandc[0].',';
}
$tandccode = substr($tandccode,0,-1);
$temp = substr($tandcdesc,-1);
if($temp == ',')
 $tandcdesc = substr($tandcdesc,0,-1);

for($i=0; $i < count($_POST['category']); $i++)
{
  if($_POST['category'][$i] != ""  && $_POST['pr'][$i] != "" && $_POST['rate'][$i] > 0 && $_POST['doffice'][$i] != "")
  {
   $category = $_POST['category'][$i];
   $temp = explode('@',$_POST['code'][$i]);
   $itemcode = $temp[0];
   $desc = $temp[1];
   $qty = $_POST['qty'][$i];
   $units = $temp[2];
   $rate = $_POST['rate'][$i];
   $temp = explode('@',$_POST['pr'][$i]);
   $pr = $temp[0];
   $rdate = $date;
   $doffice = $_POST['doffice'][$i];
   $demp = $_POST['demp'][$i];
   
   $itemcost7 = $_POST['qty'][$i]*$_POST['rate'][$i];
   $basic = $_POST['qty'][$i]*$_POST['rate'][$i];
   $tax1 = explode("@",$_POST['tax'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
   $taxie = $tax1[3];
   $taxamount = $_POST['taxamount'][$i];
   $adate=date("Y-m-d");
    $tax7=0;
	$discount7=0;
   if($taxie=="Exclude")
   {
   
   if($taxmode=="Percent")
   {
   
   	$tax7=($basic*$taxvalue)/100;
   
   $taxamount=$tax7+$itemcost7;
   }
   else
   {
   	$tax7=$taxvalue;
   $taxamount=$tax7+$itemcost7;
   }
   }



 if($taxie=="Include")
   {
   
   if($taxmode=="Percent")
   {
   
   	$taxa=(($basic*100)/(100+$taxvalue));
	$tax7=$basic-$taxa;
   $taxamount=$itemcost7;
   
   }
   else
   {
   	$tax7=$taxvalue;
   $taxamount=$itemcost7;
   }
   }

$freight7=0;
 $freightamount=0;

  
   $freightcode = "";
   $freightvalue = 0;
   $freightmode = "";
   $freightie = $_POST['freight'][$i];
  // $freightamount = $_POST['freightamount'][$i];

 
   /*if($freightie=="Excludepiadbysupplier")
   {
   
   if($freightmode=="Percent")
   {
   
 	$freight7=($basic*$freightvalue)/100;
   
  $freightamount=$freight7+$itemcost7;
   }
   else if ($freightmode=="Flat")
   {
 $freight7=$freightvalue;
 $freightamount=$freight7+$itemcost7;
   }
   }



 if($freightie=="Exclude")
   {
   
   if($freightmode=="Percent")
   {
   
 $freight7=($basic*$freightvalue)/100;

   $freightamount=$itemcost7;
   
   }
   else
   {
   	$freight7=$freightvalue;
   $freightamount=$itemcost7;
   }
   }



 if($freightie=="Include")
   {
   
   if($freightmode=="Percent")
   {
   
   	$fria=(($basic*100)/(100+$freightvalue));
	$freight7=$basic-$fria;
   $freightamount=$itemcost7;
   
   }
   else
   {
   	$freight7=$freightvalue;
   $freightamount=$itemcost7;
   }
   }*/
 $discount7=0;
 $discountamount=0;
	
 $discount7=round($_POST['disc'][$i],2);
 
 $discountamount = $itemcost7 -$discount7;;
   
$discountvalue=round($_POST['disc'][$i],2);

 $discountamount= round($discountamount,2);


   if($taxie=="Include")
   {
   
     $itemcost7 = $itemcost7;
   }


if($taxie=="Exclude")
   {
   
     $itemcost7 = $itemcost7+$tax7;
   }


 /*if($freightie=="Exclude")
   {
   
     $itemcost7 = $itemcost7;
   }



 if($freightie=="Include")
   {
   
     $itemcost7 = $itemcost7-$freight7;
   }



 if($freightie=="Excludepiadbysupplier")
   {
   
     $itemcost7 = $itemcost7 + $freight7;
   }*/
if($discount7!= 0 )
{
  $itemcost7 = $itemcost7 - $discount7;
}


if($taxamount == "")
 $taxamount = 0;
if($freightamount == "")
 $freightamount = 0;
if($brokerageamount == "")
 $brokerageamount = 0;
if($discountamount == "")
 $discountamount = 0;
if($taxvalue == "")
 $taxvalue = 0;
 
  $taxamount=round($taxamount,2);
 $freightamount=round($freightamount,2);
  $discountamount=round($discountamount,2);
  
  $itemcost7=round($itemcost7,2);
  $tax7=round($tax7,2);
  $discount7=round($discount7,2);
  $freight7=round($freight7,2);
 
   
if($credittermvalue == "")
{
$credittermvalue = 0;
}
  $pocost = $pocost + $itemcost7;
  $q = "insert into pp_purchaseorder (poincr,m,y,po,vendorid,vendor,vendorcode,credittermcode,credittermdescription,credittermvalue,brokerid,broker,date,category,code,description,quantity,unit,rateperunit,deliverydate,deliverylocation,receiver,initiatorid,initiator,initiatorsector,taxcode,taxvalue,taxformula,taxie,taxamount,totalwithtax,freightcode,freightvalue,freightformula,freightie,freightamount,totalwithfreight,discountcode,discountvalue,discountformula,discountamount,totalwithdiscount,basic,finalcost,tandccode,tandc,flag,grflag,pr,empname,adate) values('$poincr','$m','$y','$po','$vendorid','$vendor','$vendorcode','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$date','$category','$itemcode','$desc','$qty','$units',($rate *  $conversion),'$rdate','$doffice','$demp','$initiatorid','$initiatorname','$initiatorsector','$taxcode','$taxvalue','$taxmode','$taxie','$tax7',($taxamount * $conversion),'$freightcode',($freightvalue * $conversion),'$freightmode','$freightie','$freight7',($freightamount * $conversion),'$discountcode',($discountvalue * $conversion),'$discountmode','$discount7',($discountamount * $conversion),($basic * $conversion),($itemcost7 * $conversion),'$tandccode','$tandcdesc','$flag','$grflag','$pr','$empname','$adate')";
   $qrs = mysql_query($q,$conn) or die(mysql_error());

   $query = "UPDATE pp_purchaseindent SET flag = 1 WHERE pi = '$pr' AND icode = '$itemcode'";
   $result = mysql_query($query,$conn) or die(mysql_error());
  }
}

$get_entriess = "UPDATE `pp_purchaseorder` SET `pocost` = ($pocost) WHERE `pp_purchaseorder`.`po` = '$po'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchaseorder'";
echo "</script>";

?>