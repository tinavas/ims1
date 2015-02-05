 <?php

include "getemployee.php";
include "config.php";
$po = $_POST['po'];
$get_entriess = "delete from pp_purchaseorder WHERE po= '$po';"; 
mysql_query($get_entriess,$conn) or die(mysql_error());
$flag = $_POST['aflag'];
$geflag = '0';
$initiatorid = $empid;
$initiatorname = $empname;
$initiatorsector = $sector;
$po = $_POST['po'];
$poincr = $_POST['poincr'];
$m = $_POST['m'];
$y = $_POST['y'];
if($_SESSION[db]=='albustan')
{
$temp = explode('@',$_POST['vendor']);
$vendor = $temp[0];
$vendorcode = $temp[1]; 
}
else {
$vendor = $_POST['vendor'];
}
$creditterm = explode('@',$_POST['creditterm']);
$credittermcode = $creditterm[0];
$credittermdescription = $creditterm[1];
$credittermvalue = $creditterm[2];
if($credittermvalue == "")
 $credittermvalue = 0;
$broker = $_POST['broker'];
$vendorid = $_POST['vendorid'];
$brokerid = $_POST['brokerid'];
$date = $_POST['mdate'];
$date = date("Y-m-j", strtotime($date));
$tandcdesc = $_POST['tandcdesc'];
$pocost = 0;
$desc=$_POST['disc'];
	if ($desc){
	 foreach ($desc as $desc1){ $descs .= $desc1; $descs .= ","; }
	}
$descs1 = substr($descs, 0, strlen($descs)-1); 
$tandccode = "";
//$tandcdesc = "";
$desc2 = explode(',',$descs1);
for($j=0;$j<sizeOf($desc2);$j++)
{
 $tandc = explode('@',$desc2[$j]);
 $tandccode .= $tandc[0].',';
 //$tandcdesc .= $tandc[1].',';
}

$tandccode = substr($tandccode,0,-1);
$temp = substr($tandcdesc,-1);
if($temp == ',')
 $tandcdesc = substr($tandcdesc,0,-1);



$category = $_POST['category'][0];

for($i=0; $i < count($_POST['category']); $i++)
{
   if($_POST['category'][$i] != "")
  {
  
   $category = $_POST['category'][$i];
   $itemcode = $_POST['code'][$i];
   $desc = $_POST['description'][$i];
   $qty = $_POST['quantity'][$i];
   $units = $_POST['units'][$i];
   $rate = $_POST['rate'][$i];
   $rdate = $_POST['rdate'][$i];
   $rdate = date("Y-m-j", strtotime($rdate));
   $doffice = $_POST['doffice'][$i];
   $demp = $_POST['demp'][$i];
   
   $itemcost7 = $_POST['quantity'][$i]*$_POST['rate'][$i];
   $basic = $_POST['quantity'][$i]*$_POST['rate'][$i];
   $tax1 = explode("@",$_POST['tax'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxformula = $tax1[2];
   $taxie = $tax1[3];
   $taxamount = $_POST['taxamount'][$i];
   
   if($_POST['taxamount'][$i] <= 0 && $_SESSION['db']!='feedatives' )
   {
     $tax7 = 0;
   }
   else
   {
     if($_SESSION['db']=='feedatives') {
	   $tax7 = $_POST['taxamount1'][$i]; 
	   $taxamount = $tax7+$itemcost7;
	  }
	 else
     $tax7 = $_POST['taxamount'][$i] - $itemcost7;
   }

   $freight1 = explode("@",$_POST['freight'][$i]);
   $freightcode = $freight1[0];
   $freightvalue = $freight1[1];
   $freightformula = $freight1[2];
   $freightie = $freight1[3];
   $freightamount = $_POST['freightamount'][$i];
   if($_POST['freightamount'][$i] <= 0 && $_SESSION['db']!='feedatives')
   {
     $freight7 = 0;
   }
   else
   {
    if($_SESSION['db']=='feedatives')
	 {
	 $freight7  = $_POST['freightamount1'][$i]; 
	 $freightamount =$freight7 +$itemcost7;
	 }
	 else
     $freight7 = $_POST['freightamount'][$i] - $itemcost7;
   }


	if($_SESSION['db'] <> "maharashtra") {
   $brokerage1 = explode("@",$_POST['brokerage'][$i]);
   $brokeragecode = $brokerage1[0];
   $brokeragevalue = $brokerage1[1];
   $brokerageformula = $brokerage1[2];
   $brokerageie = $brokerage1[3];
   $brokerageamount = $_POST['brokerageamount'][$i];
   } else {
   $brokeragecode = $brokeragevalue = $brokerageformula = $brokerageamount = $brokerage7 = $_POST['brokerage'][$i];
   $brokerageie = "";
	}   
   
   if($_POST['brokerageamount'][$i] <=0 && $_SESSION['db'] <> "maharashtra" && $_SESSION['db']!='feedatives')
   {
     $brokerage7 = 0;
   }
   elseif($_SESSION['db']=='feedatives') {
	 $brokerage7 = $_POST['brokerageamount1'][$i];
	$brokerageamount = $brokerage7+ $itemcost7;
	  }
   elseif($_SESSION['db'] <> "maharashtra")
   {
    $brokerage7 = $_POST['brokerageamount'][$i] - $itemcost7;
   }


   $discount1 = explode("@",$_POST['discount'][$i]);
   $discountcode = $discount1[0];
   $discountvalue = $discount1[1];
   $discountformula = $discount1[2];
   $discountie = $discount1[3];
   $discountamount = $_POST['discountamount'][$i];
   if($_POST['discountamount'][$i] <=0 && $_SESSION['db']!='feedatives' )
   {
     $discount7 = 0;
   }
   else
   {
    if($_SESSION['db']=='feedatives') {
	  $discount7 =  $_POST['discountamount1'][$i]; 
	  $discountamount= $itemcost7-$discount7;
	 }
   else
    $discount7 = $itemcost7 - $_POST['discountamount'][$i];
   }
   
if($_SESSION['db']=='feedatives'){
$taxie = "Include";
$freightie = $_POST[freightie][$i];
$discountie =="Include";
}

if($taxie == "Include")
{
  $itemcost7 = $itemcost7 + $tax7;
}
if($freightie == "Include")
{
  $itemcost7 = $itemcost7 + $freight7;
}
if($discountie == "Include")
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
 
 if($taxvalue=='') $taxvalue=0;
  if($brokeragevalue=='') $brokeragevalue=0;
  if($discountvalue=='') $discountvalue=0;
 if($freightvalue=='') $freightvalue=0;
 if($freightvalue=='') $freightvalue=0;
 if($freight7=='') $freight7 = 0;
 if($discount7=='') $discount7=0;
 if($brokerage7=='') $brokerage7 = 0;
 if($tax7=='') $tax7 = 0;
   //$itemcost7 = ( $itemcost7 + $tax7 + $freight7) - $discount7;

   $pocost = $pocost + $itemcost7;
 $q = "insert into pp_purchaseorder (vendorcode,poincr,m,y,po,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,date,category,code,description,quantity,unit,rateperunit,deliverydate,deliverylocation,receiver,initiatorid,initiator,initiatorsector,taxcode,taxvalue,taxformula,taxie,taxamount,totalwithtax,freightcode,freightvalue,freightformula,freightie,freightamount,totalwithfreight,brokeragecode,brokeragevalue,brokerageformula,brokerageie,brokerageamount,totalwithbrokerage,discountcode,discountvalue,discountformula,discountie,discountamount,totalwithdiscount,basic,finalcost,tandccode,tandc,flag,geflag) values('$vendorcode','$poincr','$m','$y','$po','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$date','$category','$itemcode','$desc','$qty','$units','$rate','$rdate','$doffice','$demp','$initiatorid','$initiatorname','$initiatorsector','$taxcode','$taxvalue','$taxformula','$taxie','$tax7','$taxamount','$freightcode','$freightvalue','$freightformula','$freightie','$freight7','$freightamount','$brokeragecode','$brokeragevalue','$brokerageformula','$brokerageie','$brokerage7','$brokerageamount','$discountcode','$discountvalue','$discountformula','$discountie','$discount7','$discountamount','$basic','$itemcost7','$tandccode','$tandcdesc','$flag','$geflag')";
 
 //echo $q;
  $qrs = mysql_query($q,$conn) or die(mysql_error());


  }
}

$get_entriess = "UPDATE `pp_purchaseorder` SET `pocost` = '$pocost' WHERE `pp_purchaseorder`.`po` = '$po';";     
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());


/***************Authorization Starts here*********************/
/*
$po = $_POST['po'];
$vendor = $_POST['vendor'];
$creditterm = explode("@",$_POST['creditterm']);
$credittermcode = $creditterm[0];
$credittermdescription = $creditterm[1];
$credittermvalue = $creditterm[2];
$finalcost = 0;
$finalcost1 = 0;
$pocost = 0;
$adate = date("Y-m-d",strtotime($_POST['mdate']));

$tandcdesc = $_POST['tandcdesc1'];
$tandcdesc = substr($tandcdesc,0,-1);

$tandccode = $_POST['tandccode2'];
$tandccode = substr($tandccode,0,-1);

for($i = 0; $i < count($_POST['quantity']); $i ++)
{
  if($_POST['category'][$i] != "-Select-")
  {
 $code = $_POST['code'][$i];
 $quantity = $_POST['quantity'][$i];
 $rateperunit = $_POST['rate'][$i];

 $basic = $quantity * $rateperunit;

   $tax1 = explode("@",$_POST['tax'][$i]);
   $taxcode = $tax1[0];
   $taxvalue = $tax1[1];
   $taxformula = $tax1[2];
   $taxie = $tax1[3];


 $taxcode = $_POST['taxcode'][$i];
 $taxvalue = $_POST['taxvalue'][$i];
 $taxamount1 = $_POST['taxamount'][$i];
 $taxamount = $_POST['taxamount'][$i] - ($quantity * $rateperunit);
 $taxie = $_POST['taxie'][$i];echo " ";

 $freightcode = $_POST['freightcode'][$i];
 $freightvalue = $_POST['freightvalue'][$i];
 $freightamount1 = $_POST['freightamount'][$i];
 $freightamount = $_POST['freightamount'][$i] - ($quantity * $rateperunit);
 $freightie = $_POST['freightie'][$i];

 $brokeragecode = $_POST['brokeragecode'][$i];
 $brokeragevalue = $_POST['brokeragevalue'][$i];
 $brokerageamount1 = $_POST['brokerageamount'][$i];
 $brokerageamount = $_POST['brokerageamount'][$i] - ($quantity * $rateperunit);
 $brokerageie = $_POST['brokerageie'][$i];

 $discountcode = $_POST['discountcode'][$i];
 $discountvalue = $_POST['discountvalue'][$i];
 $discountamount1 = $_POST['discountamount'][$i];
 $discountamount = ($quantity * $rateperunit) - $_POST['discountamount'][$i];
 $discountie = $_POST['discountie'][$i];

if($taxamount<=0)
$taxamount = 0;
if($freightamount <= 0 )
$freightamount = 0;
if($discountamount == (($quantity * $rateperunit)) )
$discountamount = 0;
if($brokerageamount <= 0 )
$brokerageamount = 0;

if($taxamount1<=0)
$taxamount1 = ($quantity * $rateperunit);
if($freightamount1 <= 0 )
$freightamount1 = ($quantity * $rateperunit);
if($discountamount1 <= 0 )
$discountamount1 = ($quantity * $rateperunit);
if($brokerageamount1 <= 0 )
$brokerageamount1 = ($quantity * $rateperunit);

$tandcdesc = urldecode($tandcdesc);
$finalcost = ($quantity * $rateperunit);
if($taxie == "Include")
$finalcost = $finalcost + $taxamount;
if($freightie == "Include")
$finalcost = $finalcost + $freightamount;
if($discountie == "Include")
$finalcost = $finalcost - $discountamount;


$pocost += $finalcost;

if($taxamount == "")
 $taxamount = 0;
if($$freightamount == "")
 $freightamount = 0;
if($brokerageamount == "")
 $brokerageamount = 0;
if($discountamount == "")
 $discountamount = 0;
if($taxvalue == "")
 $taxvalue = 0;
if($freightvalue == "")
 $freightvalue = 0;
if($brokeragevalue == "")
 $brokeragevalue = 0;
if($discountvalue == "")
 $discountvalue = 0;

$query5 = "UPDATE pp_purchaseorder SET credittermcode = '$credittermcode',credittermdescription = '$credittermdescription',credittermvalue='$credittermvalue',flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',quantity = '$quantity', rateperunit = '$rateperunit', taxcode = '$taxcode',taxvalue = '$taxvalue', taxamount= '$taxamount', freightcode = '$freightcode', freightvalue = '$freightvalue',freightamount = '$freightamount',totalwithfreight='$freightamount1', brokeragecode = '$brokeragecode',brokeragevalue = '$brokeragevalue',brokerageamount = '$brokerageamount',totalwithbrokerage='$brokerageamount1',discountcode = '$discountcode',discountvalue = '$discountvalue', discountamount = '$discountamount',totalwithdiscount='$discountamount1',finalcost = '$finalcost',tandccode = '$tandccode',tandc = '$tandcdesc',basic = '$basic' where po = '$po' and code = '$code' ";
$result5 = mysql_query($query5,$conn) or die(mysql_error());
}
}

$q = "update pp_purchaseorder set pocost = '$pocost' where po = '$po'";
$qrs = mysql_query($q,$conn) or die(mysql_error());

*/
/***************Authorization Ends here***********************/


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchaseorder_a'";
echo "</script>";

?>



