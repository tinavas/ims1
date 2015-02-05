<?php 
include "config.php";
include "getemployee.php";
$riflag = 'R';
$tid = 0;
$q1 = "select max(tid) as tid from ims_intermediatereceipt WHERE riflag = '$riflag'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
$tid = $q1r['tid'];

$tid = $tid + 1;
$date = date("Y-m-d",strtotime($_POST['date']));
$adate = date("Y-m-d",strtotime($_POST['date']));
$doc=$_POST['doc'];
for($i = 0; $i<count($_POST['code']); $i++)
{
 if($_POST['code'][$i]!= '' && $_POST['quantity'][$i]!= '' && $_POST['rateperunit'][$i]!= '' && $_POST['coa'][$i]!= '')
 {
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	
	$t=explode("@",$code);
	$code=$t[0];
	$description = $t[1];;
	$quantity = $_POST['quantity'][$i];
	$units = $_POST['units'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$amount = round($quantity * $rateperunit,3);
	$coa = $_POST['coa'][$i];
	$lot = $_POST['lot'][$i];
	$serial = $_POST['serial'][$i];
	$warehouse = $_POST['warehouse'][$i];
	$secor=$_POST['warehouse'][$i];;
	$flock = $_POST['flock'][$i];
	$type = "IR";
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];
	
	 $empname = $_SESSION['valid_user'];
	$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,units,rateperunit,amount,coa,warehouse,empid,empname,sector,riflag,adate,docno) values ('$tid','$date','$cat','$code','$description','$quantity','$units','$rateperunit','$amount','$coa','$warehouse','$empid','$empname','$sector','$riflag','$adate','$doc') "; 
	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	 ///stock update/////////////
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result3 = mysql_query($query3,$conn);
   $numrows3 = mysql_num_rows($result3);
	  if($numrows3 == 0)
	  {
	   $query31 = "select * from ims_itemcodes where code = '$code' and client = '$client'";
	   $result31 = mysql_query($query31,$conn) or die(mysql_error());
	   $rows31 = mysql_fetch_assoc($result31);
	   $unit = $rows31['sunits'];
	   $query32 = "insert into ims_stock(id,warehouse,itemcode,unit,quantity,client,empname,adate) values(NULL,'$warehouse','$code','$unit',0,'$client','$empname','$adate')";
	   $result32 = mysql_query($query32,$conn) or die(mysql_error());
	  }
	$result3 = mysql_query($query3,$conn);  
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  }

  if($stockunit == $units)
  {
      $stockqty = $stockqty + $quantity;    
  }
  else
  {
      $stockqty = $stockqty + convertqty($quantity,$units,$stockunit,1);
  }

  $query51 = "UPDATE ims_stock SET quantity = '$stockqty',empname='$empname',adate='$adate' WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());



  $query51 = "UPDATE ims_initialstock SET quantity = '$stockqty',rate='$rateperunit',amount='$amount',empname='$empname',adate='$adate' WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  ///////////end of stock update//////////////


	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','$code','Dr','".$iac."','$quantity','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	

	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,client,empname,adate) 
	          VALUES('".$adate."','$code','Cr','".$coa."','$quantity','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."','".$client."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
 }
}

$query5 = "UPDATE ims_intermediatereceipt SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where tid = '$tid' AND riflag = '$riflag'";

$result5 = mysql_query($query5,$conn) or die(mysql_error());


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_intermediatereceipt'";
echo "</script>";

?>