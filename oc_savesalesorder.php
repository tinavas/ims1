<?php
include "getemployee.php";
include "config.php";



$initiatorid = $empid;
$initiatorname = $empname;
$initiatorsector = $sector;
$warehouse = $_POST['warehouse'];
$po = $_POST['po'];
$flag = 1;


 
if($_POST['saed'] == 1)
{
	$po = $_POST['oldso'];
	$query = "DELETE FROM oc_salesorder WHERE po = '$po'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	
}

$poincr = $_POST['poincr'];
$m = $_POST['m'];
$y = $_POST['y'];
$vendor = $_POST['vendor'];

$vendorid = $_POST['vendorid'];

$time=$_POST['time'];
$date = $_POST['mdate'];
$adate=$date = date("Y-m-d", strtotime($date));


$pocost = 0;



  
if($_POST['saed'] == 1)
{
	
$temp=explode("-",$po);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$po=$po;

else
{
$po="";


$query1 = "SELECT MAX(poincr) as poincr FROM oc_Salesorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $poincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'SO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'SO-'.$m.$y.'-00'.$poincr; }
else { $po = 'SO-'.$m.$y.'-0'.$poincr; }  

 
 }
 
}



$desc=$_POST['disc'];
	if ($desc){
	 foreach ($desc as $desc1){ $descs .= $desc1; $descs .= ","; }
	}
$descs1 = substr($descs, 0, strlen($descs)-1); 
$tandccode = "";
$tandcdesc = "";
$desc2 = explode(',',$descs1);
for($j=0;$j<sizeOf($desc2);$j++)
{
 $tandc = explode('@',$desc2[$j]);
 $tandccode .= $tandc[0].',';
 $tandcdesc .= $tandc[1].',';
}

$tandccode = substr($tandccode,0,-1);
$tandcdesc = substr($tandcdesc,0,-1);


for($i=0;$i<count($_POST['category']);$i++)
{
  if($_POST['category'][$i] != "" && $_POST['code'][$i] != "" && $_POST['description'][$i] != "" && $_POST['quantity'][$i] != "" )
  {
  
   $category = $_POST['category'][$i];
   
   $temp=$_POST['code'][$i];;
   {
   
   $temp1=explode("@",$temp);
   $itemcode = $temp1[0];
   
   $desc = $temp1[1];
   
   }
   $qty = $_POST['quantity'][$i];
   $units = $_POST['units'][$i];
   $rate = $_POST['rate'][$i];
   $rdate = $_POST['rdate'][$i];
   $rdate = date("Y-m-j", strtotime($rdate));

$taxvalue=0;
$freightvalue=0;
$discountvalue=0;
  $itemcost7 = $_POST['quantity'][$i]*$_POST['rate'][$i]; 
   
   $tax1 = explode("@",$_POST['tax'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxmode = $tax1[2];
   $taxie = $tax1[3];
   $tax7=0;
   $discount7=0;
   $taxamount=0;
   
   if($taxie=="Exclude")
   {
   
   if($taxmode=="Percent")
   {
   
    	$tax7=($itemcost7*$taxvalue	)/100;
		
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
   
   	$taxa=(($itemcost7*100)/(100+$taxvalue));
	$tax7=$itemcost7-$taxa;
   $taxamount=$itemcost7;
   
   }
   else
   {
   	$tax7=$taxvalue;
   $taxamount=$itemcost7;
   }
   }

   


$freightamount=0;

$freight7=0;$freightamount=0;$freightvalue=0;
   $freight1 = $_POST['freight'][$i];
  
  
   $freightie = $freight1;




	/*
 if($freightie=="Exclude")
   {
   
   if($freightmode=="Percent")
   {
   
 $freight7=($itemcost7*$freightvalue)/100;

   $freightamount=$itemcost7+$freight7;
   
   }
   else
   {
   	$freight7=$freightvalue;
   $freightamount=$itemcost7+$freight7;
   }
   }


$icost=$itemcost7;
 if($freightie=="Includepaidbycustomer")
   {
   
   if($freightmode=="Percent")
   {
   
   	 $freight7=($itemcost7*$freightvalue)/100;

   $freightamount=$itemcost7;
   
   }
   else
   {
   	$freight7=$freightvalue;
   $freightamount=$icost;
   }
   }


 if($freightie=="Include")
   {
   
   if($freightmode=="Percent")
   {
   
 $freight7=($itemcost7*$freightvalue)/100;

   $freightamount=$itemcost7;
   
   }
   else
   {
   	$freight7=$freightvalue;
   $freightamount=$itemcost7;
   }
   }*/



    $discountvalue=0;$discountamount=0;
   $discount1 = $_POST['discount'][$i];

   $discountvalue = $discount1;

  
 
 $discount7=$discountvalue ;
 
  $discountamount=$itemcost7-$discount7;
 
 


   if($taxie=="Exclude")
   {
   
     $itemcost7 = $itemcost7 +$tax7;
   }
   else
   $itemcost7 = $itemcost7;

 if($freightie=="Exclude")
   {
   
     $itemcost7 = $itemcost7 + $freight7;
   }
   
  if($freightie=="Includepaidbycustomer")
   {
   
     $itemcost7 = $itemcost7 - $freight7;
   }
    
   
if($discount7!= 0 )
{
  $itemcost7 = $itemcost7 - $discount7;
}

   $pocost = $pocost + $itemcost7;
   $salesperson = $_POST['salesperson'];
   
if($taxvalue=="")
$taxvalue=0;

if($freightvalue=="")
$freightvalue=0;
   
   
   if($discountvalue=="")
$discountvalue=0;

if($discount7=="")
$discount7=0;
$discount7=round($discount7,2);
$discountamount=round($discountamount,2);
$freightamount=round($freightamount,2);

 $freight7=round( $freight7,2);
$taxamount=round($taxamount,2);
$tax7=round($tax7,2);

if($rate=="")
$rate=0;

if($qty=="")
$qty=0;

if($freightvalue=="")
$freightvalue=0;
if($taxvalue=="")
$taxvalue=0;
if($discountvalue=="")
$discountvalue=0;
if($_POST['saed']==1)
$empname=$_POST['cuser'];

//code to get the storage quantity and storage price and units

$unitsq="select cunits,sunits,iac from ims_itemcodes where code='$itemcode'";

$unitsq=mysql_query($unitsq) or die(mysql_error());

$unitsq=mysql_fetch_assoc($unitsq);

$sunits=$unitsq['sunits'];

$convunit="select conunits from ims_convunits where fromunits='$sunits' and tounits='$units'";

$convunit=mysql_query($convunit) or die(mysql_error());

$convunit=mysql_fetch_assoc($convunit);

$convunit=$convunit['conunits'];

if($sunits==$units)
{
$convunit=1;
}

$squantity=round(($qty/$convunit),3);

$sprice=$rate*$convunit;

//------------------------------------
   
 $q = "insert into oc_salesorder (poincr,m,y,po,vendor,date,category,code,description,quantity,unit,rateperunit,deliverydate,initiatorid,initiator,initiatorsector,taxcode,taxie,taxvalue,taxformula,taxamount,totalwithtax,freightcode,freightie,freightvalue,freightformula,freightamount,totalwithfreight,discountcode,discountvalue,discountformula,discountamount,totalwithdiscount,finalcost,tandccode,tandc,warehouse,sentquantity,empname,adate,sunits,squantity,sprice,convunit)
    values('$poincr','$m','$y','$po','$vendor','$date','$category','$itemcode','$desc','$qty','$units','$rate','$rdate','$initiatorid','$initiatorname','$initiatorsector','$taxcode','$taxie','$taxvalue','$taxmode','$tax7','$taxamount','$freightcode','$freightie','$freightvalue','$freightmode','$freight7','$freightamount','$discountcode','$discountvalue','$discountmode','$discount7','$discountamount','$itemcost7','$tandccode','$tandcdesc','$warehouse','0','$empname','$adate','$sunits','$squantity','$sprice','$convunit')";
$qrs = mysql_query($q,$conn) or die(mysql_error());
  }
}

$get_entriess = "UPDATE `oc_salesorder` SET `pocost` = '$pocost' , flag = '$flag' ,adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector', psflag = 0 WHERE `oc_salesorder`.`po` = '$po';";     
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

//header('Location:dashboardsub.php?page=oc_salesorder');
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_salesorder'";
echo "</script>";

?>



