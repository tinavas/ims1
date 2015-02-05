<?php 
include "config.php";
include "jquery.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$m=$_POST['m'];
$y=$_POST['y'];


$sre="";


$query1 = "SELECT MAX(sreincr) as sreincr FROM oc_salesreturn  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $preincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $sreincr = $row1['sreincr']; }
$sreincr = $sreincr + 1;
if ($sreincr < 10) { $sre = 'SRE-'.$m.$y.'-000'.$sreincr; }
else if($sreincr < 100 && $sreincr >= 10) { $sre = 'SRE-'.$m.$y.'-00'.$sreincr; }
else { $sre = 'SRE-'.$m.$y.'-0'.$sreincr; } 



$vendor = $_POST['name'];
$r= mysql_query("select code from contactdetails where name='$vendor'");
   $a=mysql_fetch_assoc($r);
   $partycode=$a['code'];
   $docno=$_POST[docno];

$cobi = $_POST['cobi'];
$remarks = ucwords($_POST['remarks']);
$date=date("Y-m-d",strtotime($_POST['date']));
$type = "SR";
$totalreturnquantity = 0;
$totalreturnamount = 0;

$adate=date("Y-m-d");
$empname=$_SESSION['valid_user'];


for($i = 0;$i<count($_POST['code']);$i++)
{
if($_POST['retqty'][$i] != "")
{
$code = $_POST['code'][$i];
$iname = $_POST['itemname'][$i];
$soldquantity = $_POST['soldqty'][$i];
$recquantity = $_POST['retqty'][$i];
$status=$_POST['wastage'][$i];
$warehouse=$_POST['warehouse'][$i];
$rate = 0;

 $query = "SELECT * FROM oc_cobi where invoice = '$cobi' and code = '$code' ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
		      $rate = $row1['price'];
			  $cobidate = $row1['date'];
		   }

 $q = "insert into oc_salesreturn (date,m,y,sreincr,trid,cobi,code,description,quantity,remarks,flag,cobidate,rate,type,sre,party,partycode,docno,empname,adate,warehouse) VALUES ('$date','$m','$y','$sreincr','$sre','$cobi','$code','$iname','$recquantity','$remarks','1','$cobidate','$rate','$status','$sre','$vendor','$partycode','$docno','$empname','$adate','$warehouse')";
$qrs = mysql_query($q,$conn) or die(mysql_error());

	$totalreturnquantity += $recquantity;
	$returnamount = $recquantity * $rate;
	$totalreturnamount += $returnamount;
	
	$q1 = "SELECT * FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $mode = $row1['cm'];
	 	$srac = $row1['srac'];
		$iac = $row1['iac'];
		$cogsac = $row1['cogsac'];
	 }
	 
	
     $price = calculatenew($warehouse,$mode,$code,$date);
	$amount = $recquantity * $price;
	
	if($status == "addtostock")
	{
	
	
	//item account
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
           VALUES('$date','$code','Dr','$iac','$recquantity','$amount','$sre','$type','$vendor','$warehouse')";
		  
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
//cog account
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
           VALUES('$date','$code','Cr','$cogsac','$recquantity','$amount','$sre','$type','$vendor','$warehouse')";
		  
    $result4 = mysql_query($query4,$conn) or die(mysql_error());

	 $query = "select * from ims_stock where itemcode = '$code' and warehouse = '$warehouse'";
	
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 $res = mysql_fetch_assoc($result);
	
	 $previousquantity = $res['quantity'];

	 $previousquantity += $recquantity;

  $query2 = "update ims_stock set quantity = '$previousquantity',adate='$adate',empname='$empname' where itemcode = '$code' and warehouse = '$warehouse'";
	 
	$result2 = mysql_query($query2,$conn) or die(mysql_error()); 
 	 
	}
	
	
	//salesreturn
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
           VALUES('$date','$code','Dr','$srac','$recquantity','$returnamount','$sre','$type','$vendor','$warehouse')";
		  
 $result4 = mysql_query($query4,$conn) or die(mysql_error());	


}
}
$q = "select ca from contactdetails where name = '$vendor'";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$coacode = $qr['ca'];
//customer account

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('$date','','Cr','$coacode','$totalreturnquantity','$totalreturnamount','$sre','$type','$vendor','$warehouse')";
			 
			  
 $result4 = mysql_query($query4,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=oc_salesreturn';";
echo "</script>";



?>