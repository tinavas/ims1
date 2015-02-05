<?php 
include "config.php";
include "getemployee.php";

$trid = $_POST['pre'];

$query = "delete from pp_purchasereturn where trid = '$trid'";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());

$query = "delete from ac_financialpostings where trnum = '$trid'";
$get_entriess_res1 = mysql_query($query,$conn) or die(mysql_error());


$vendor = $_POST['vendor'];
$vendorcode = $_POST['vendorcode'];
$sobi = $_POST['sobi'];
$date = date("Y-m-d",strtotime($_POST['date']));
$type = "PPRTN";
$totalreturnquantity = 0;
$totalreturnamount = 0;
$narr=$_POST['narr'];
$status="Remove From Stock";
for($i = 0; $i < count($_POST['code']); $i++)
{
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$purchasedquantity = $_POST['purchasedquantity'][$i];
	$returnquantity = $_POST['returnquantity'][$i];
	$shrinkage = $purchasedquantity - $returnquantity;
	$warehouse = $_POST['warehouse'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$amount = $_POST['amount'][$i];	
	$q = "insert into pp_purchasereturn (date,trid,vendor,vendorcode,sobi,code,description,purchasedquantity,returnquantity,shrinkage,rateperunit,amount,status,flag,warehouse,narration) values ('$date','$trid','$vendor','$vendorcode','$sobi','$code','$description','$purchasedquantity','$returnquantity','$shrinkage','$rateperunit','$amount','$status','0','$warehouse','$narr')";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	
	
	$totalreturnquantity+= $returnquantity;
	$returnamount = $returnquantity * $rateperunit;
	$totalreturnamount+= $returnamount;
	
	$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
           VALUES('$date','$code','Cr','$iac','$returnquantity','$returnamount','$trid','$type','$vendor','$warehouse')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());	
//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$iac' and date = '$date' and crdr = 'Cr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		 $amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		 $q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$iac','$returnamount','Cr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $returnamount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$iac'and date = '$date' and crdr = 'Cr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }

	
	 $query = "select * from ims_stock where itemcode = '$code' and warehouse = '$warehouse'";
	
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 $res = mysql_fetch_assoc($result);
	
	 $previousquantity = $res['quantity'];


	 
	 $previousquantity -= $returnquantity;
 
	 $query2 = "update ims_stock set quantity = '$previousquantity' where itemcode = '$code' and warehouse = '$warehouse'";
	 $result2 = mysql_query($query2,$conn) or die(mysql_error()); 
 	 
	
	
	 
}
$q = "select va from contactdetails where name = '$vendor'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$va = $qr['va'];


 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('$date','$code','Dr','$va','$totalreturnquantity','$totalreturnamount','$trid','$type','$vendor','$warehouse')";
 $result4 = mysql_query($query4,$conn) or die(mysql_error());

//////////insert into ac_financialpostingssummary	 
		 $qury1r = "select sum(amount) as amount from ac_financialpostingssummary where coacode = '$va' and date = '$date' and crdr = 'Dr'";
		 $res1r = mysql_query($qury1r,$conn);
		 while($qhr1 = mysql_fetch_assoc($res1r))
		 {
		$amountnew = $qhr1['amount'];
		 }
		 if($amountnew == "")
		 {
		$q = "insert into ac_financialpostingssummary(date,coacode,amount,crdr,warehouse,client) values('$date','$va','$totalreturnamount','Dr','$warehouse','$client')";
		 $r = mysql_query($q,$conn) or die(mysql_error());

		 }
		 else
		 {
		 $amt = $amountnew + $totalreturnamount;
		 $q1 = "update ac_financialpostingssummary set amount = '$amt' where coacode = '$va'and date = '$date' and crdr = 'Dr'";
		 $r1 = mysql_query($q1,$conn) or die(mysql_error());
		 }


 
 
 
$query5 = "UPDATE pp_purchasereturn SET flag = '1',adate = '$date',aempid = '$empid',aempname = '$empname',asector = '$sector' where trid = '$trid'";

$result5 = mysql_query($query5,$conn) or die(mysql_error());

echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_purchasereturn'";
echo "</script>";

?>