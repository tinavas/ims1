<?php 
include "config.php";
include "getemployee.php";

$vendor = $_POST['vendor'];
   $r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $vendorcode=$a['code'];
$sobi = $_POST['sobi'];
$date = date("Y-m-d",strtotime($_POST['date']));
$m=$_POST['m'];
$y=$_POST['y'];


$pre="";


$query1 = "SELECT MAX(preincr) as preincr FROM pp_purchasereturn  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $preincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $preincr = $row1['preincr']; }
$preincr = $preincr + 1;
if ($preincr < 10) { $pre = 'PRE-'.$m.$y.'-000'.$preincr; }
else if($preincr < 100 && $preincr >= 10) { $pre = 'PRE-'.$m.$y.'-00'.$preincr; }
else { $pre = 'PRE-'.$m.$y.'-0'.$preincr; } 



$type = "PPRTN";
$totalreturnquantity = 0;
$totalreturnamount = 0;
$narr=$_POST['narr'];
$adate=$date;
$empname=$_SESSION['valid_user'];
$status="Remove From Stock";
for($i = 0; $i < count($_POST['code']); $i++)
{
if($_POST['returnquantity'][$i]!="" && $_POST['returnquantity'][$i]>0 )
{
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$purchasedquantity = $_POST['purchasedquantity'][$i];
	$returnquantity = $_POST['returnquantity'][$i];
	$shrinkage = $purchasedquantity - $returnquantity;
	$warehouse = $_POST['warehouse'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$amount = $_POST['amount'][$i];	
	$q = "insert into pp_purchasereturn (date,m,y,preincr,trid,vendor,vendorcode,sobi,code,description,purchasedquantity,returnquantity,shrinkage,rateperunit,amount,status,flag,warehouse,narration,empname,adate) values ('$date','$m','$y','$preincr','$pre','$vendor','$vendorcode','$sobi','$code','$description','$purchasedquantity','$returnquantity','$shrinkage','$rateperunit','$amount','$status','0','$warehouse','$narr','$empname','$adate')";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	
	
	$totalreturnquantity+= $returnquantity;
	$returnamount = $returnquantity * $rateperunit;
	$totalreturnamount+= $returnamount;
	
	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];

//item acoocunt

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
           VALUES('$date','$code','Cr','$iac','$returnquantity','$returnamount','$pre','$type','$vendor','$warehouse')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());	

	
	 $query = "select * from ims_stock where itemcode = '$code' and warehouse = '$warehouse'";
	
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 $res = mysql_fetch_assoc($result);
	
	 $previousquantity = $res['quantity'];


	 
	 $previousquantity -= $returnquantity;
 
	 $query2 = "update ims_stock set quantity = '$previousquantity' where itemcode = '$code' and warehouse = '$warehouse'";
	 $result2 = mysql_query($query2,$conn) or die(mysql_error()); 
 	 
	
	}
	 
}

//vendor account
$q = "select va from contactdetails where name = '$vendor'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$va = $qr['va'];


 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('$date','$code','Dr','$va','$totalreturnquantity','$totalreturnamount','$pre','$type','$vendor','$warehouse')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());



 
 
 
$query5 = "UPDATE pp_purchasereturn SET flag = '1',adate = '$date',aempid = '$empid',aempname = '$empname',asector = '$sector' where trid = '$pre'";

$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchasereturn'";
echo "</script>";

?>