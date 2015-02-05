 <?php
include "getemployee.php";
include "config.php";


 $flag = 0;

$geflag = '0';

$initiatorid = $empid;
$initiatorname = $empname;
$initiatorsector = $sector;
$m = $_POST['m'];
$y = $_POST['y'];

$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $piincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; }  
if($_SESSION[db]=='albustan' || $_SESSION[db]=='albustanlayer')
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
   if($_POST['taxamount'][$i] <= 0 && $_SESSION['db']!='feedatives')
   {
     $tax7 = 0;
   }
   else
   {
     if($_SESSION['db']=='feedatives') {
	   $tax7 = $_POST['taxamount1'][$i]; 
	   $taxamount = $tax7+$itemcost7;  if($tax7=='') $tax7 = 0;
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
   if($_POST['discountamount'][$i] <=0 && $_SESSION['db']!='feedatives')
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
 if($freight7=='') $freight7 = 0;
 if($discount7=='') $discount7=0;
 if($brokerage7=='') $brokerage7 = 0;
 if($tax7=='') $tax7 = 0;
   //$itemcost7 = ( $itemcost7 + $tax7 + $freight7) - $discount7;
if($credittermvalue == "")
{
$credittermvalue = 0;
}
   $pocost = $pocost + $itemcost7;
  $q = "insert into pp_purchaseorder (vendorcode ,poincr,m,y,po,vendorid,vendor,credittermcode,credittermdescription,credittermvalue,brokerid,broker,date,category,code,description,quantity,unit,rateperunit,deliverydate,deliverylocation,receiver,initiatorid,initiator,initiatorsector,taxcode,taxvalue,taxformula,taxie,taxamount,totalwithtax,freightcode,freightvalue,freightformula,freightie,freightamount,totalwithfreight,brokeragecode,brokeragevalue,brokerageformula,brokerageie,brokerageamount,totalwithbrokerage,discountcode,discountvalue,discountformula,discountie,discountamount,totalwithdiscount,basic,finalcost,tandccode,tandc,flag,geflag) values('$vendorcode','$poincr','$m','$y','$po','$vendorid','$vendor','$credittermcode','$credittermdescription','$credittermvalue','$brokerid','$broker','$date','$category','$itemcode','$desc','$qty','$units','$rate','$rdate','$doffice','$demp','$initiatorid','$initiatorname','$initiatorsector','$taxcode','$taxvalue','$taxformula','$taxie','$tax7','$taxamount','$freightcode','$freightvalue','$freightformula','$freightie','$freight7','$freightamount','$brokeragecode','$brokeragevalue','$brokerageformula','$brokerageie','$brokerage7','$brokerageamount','$discountcode','$discountvalue','$discountformula','$discountie','$discount7','$discountamount','$basic','$itemcost7','$tandccode','$tandcdesc','$flag','$geflag')";
   $qrs = mysql_query($q,$conn) or die(mysql_error());
  }
}

$get_entriess = "UPDATE `pp_purchaseorder` SET `pocost` = '$pocost' WHERE `pp_purchaseorder`.`po` = '$po';";     
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchaseorder_a'";
echo "</script>";

?>



