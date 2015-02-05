<?php 
include "config.php";
include "getemployee.php";

$type = $_POST['type'];

$vendor = $_POST['vendor'];

$vendorid = '0';
$brokerid = '0';
$empname=$_SESSION['valid_user'];

$r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $vendorcode=$a['code'];

$gr = $_POST['gr'];
$date = date("Y-m-d",strtotime($_POST['date']));

$m = $_POST['m'];
$y = $_POST['y'];
   $query1 = "SELECT MAX(sobiincr) as piincr FROM pp_sobi  where m = '$m' AND y = '$y' ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $piincr = 0;
   while($row1 = mysql_fetch_assoc($result1))
   {
	 $piincr = $row1['piincr'];
   }
   $piincr = $piincr + 1;

if ($piincr < 10)
    $pi = 'SOBI-'.$m.$y.'-000'.$piincr;
else if($piincr < 100 && $piincr >= 10)
    $pi = 'SOBI-'.$m.$y.'-00'.$piincr;
else
   $pi = 'SOBI-'.$m.$y.'-0'.$piincr;
$so = $pi;
$sobiincr = $piincr;
$invoice = $_POST['invoice'];

$pocost = $_POST['grandtotal'];
$remarks = $_POST['remarks'];
$grandtotal = $_POST['grandtotal'];

for($i=0;$i<count($_POST['code']);$i++)
{
      $po = $_POST['po'][$i];
     
	  $gr = $_POST['grs'][$i];
	$code = $_POST['code'][$i];

	$query = "select distinct(sunits) from ims_itemcodes where code = '$code'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	$units = $rows['sunits'];
	}
	
	$taxamount=0;
	$discountamount=0;
	$freightamount=0;
	$taxvalue=0;
	$freightvalue=0;
	$discountvalue=0;
	$description = $_POST['description'][$i];
	$receivedquantity = $_POST['receivedquantity'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$tot = $_POST['tot'][$i];

     
      $tandccode = $_POST['tandccode'][$i];
      $tandc = $_POST['tandc'][$i];

	$taxcode = $_POST['taxcode'][$i];
	$taxvalue = $_POST['taxvalue'][$i];
	$taxamount = $_POST['taxamount'][$i];
	$taxformula = $_POST['taxformula'][$i];
	$taxie = $_POST['taxie'][$i];

	$freightcode = $_POST['freightcode'][$i];
	$freightvalue = $_POST['freightvalue'][$i];
	$freightamount = $_POST['freightamount'][$i];

	$freightie = $_POST['freightie'][$i];


	$discountvalue = $_POST['discountvalue'][$i];
	$discountamount = $_POST['discountamount'][$i];
	
	$discountie = $_POST['discountie'][$i];

	
//Getting warehouse form Purchase Order
$query1 = "SELECT deliverylocation FROM pp_purchaseorder WHERE po = '$po' AND code = '$code'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
  $warehouse = $rows['deliverylocation'];
}


	$totalamount = $_POST['totalamount'][$i];
	$flag = 0;
$q = "insert into pp_sobi (po,gr,so,sobiincr,m,y,date,invoice,vendor,code,description,receivedquantity,rateperunit,taxcode,taxvalue,taxamount,taxformula,freightcode,freightvalue,freightamount,discountvalue,discountamount,totalamount,pocost,grandtotal,flag,empid,empname,sector,taxie,freightie,discountie,tandccode,tandc,remarks,dflag,warehouse,itemunits,sentquantity) values ('$po','$gr','$so','$sobiincr','$m','$y','$date','$invoice','$vendor','$code','$description','$receivedquantity','$rateperunit','$taxcode','$taxvalue','$taxamount','$taxformula','$freightcode','$freightvalue','$freightamount','$discountvalue','$discountamount','$totalamount','$pocost','$grandtotal','$flag','$empid','$empname','$sector','$taxie','$freightie','$discountie','$tandccode','$tandc','$remarks','1','$warehouse','$units','$receivedquantity')";
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	$q = "update pp_goodsreceipt set sobiflag = '1' where gr = '$gr' and po = '$po'";
	$qr = mysql_query($q,$conn) or die(mysql_error());
	
}

	$q = "update pp_sobi set grandtotal = '$grandtotal',balance = '$grandtotal' where so = '$so'";
	$qr = mysql_query($q,$conn) or die(mysql_error());


/**********Authorization Starts here *******************/

$so = $_POST['so'];
$adate = date("Y-m-d",strtotime($_POST['date']));
$venname = $vendor;
$receivedquantity=0;
$q = "select distinct(va) from contactdetails where name = '$venname' and type like '%vendor%' order by va";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$va = $qr['va'];
for($j = 0;$j<count($_POST['code']);$j++)
 {
  $po = $_POST['po'][$j];
  $itemcode = $_POST['code'][$j]; 
  $receivedquantity =$receivedquantity+ $_POST['receivedquantity'][$j];
  $total = $_POST['totalamount'][$j]; 

//Getting warehouse form Purchase Order
$query1 = "SELECT deliverylocation,unit FROM pp_purchaseorder WHERE po = '$po' AND code = '$itemcode'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
 $warehouse = $rows['deliverylocation'];
 $units = $rows['unit'];
}


}
  
  
  
  $grandtotal = $_POST['grandtotal']; 
  
  $type = 'SOBI';
  
    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$adate."','','Dr','".$vsac."','".$receivedquantity."','".$grandtotal."','".$so."','".$type."','".$venname."','$warehouse','$empname','$adate')";
    $result3 = mysql_query($query3,$conn) or die(mysql_error());
	
	
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$adate."','','Cr','".$va."','".$receivedquantity."','".$grandtotal."','".$so."','".$type."','".$venname."','$warehouse','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	

	

$query5 = "UPDATE pp_sobi SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where so = '$so'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


/*********Authorization ends here **********************/


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_sobi'";
echo "</script>";
?>