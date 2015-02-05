<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$adate = date("Y-m-d",strtotime($_POST['date']));
for($i = 0; $i<count($_POST['code']); $i++)
{
 if($_POST['code'][$i]!= '' && $_POST['quantity'][$i]!= '' && $_POST['rateperunit'][$i]!= '')
 {
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	$description = $_POST['description'][$i];
	$quantity = $_POST['quantity'][$i];
	$units = $_POST['units'][$i];
	$rateperunit = $_POST['rateperunit'][$i];
	$amount = $quantity * $rateperunit;
	$coa = "99999";
	$lot = "";
	$serial = "";
	$warehouse = $_POST['warehouse'][$i];
	
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];
	
	 $crsum = 0;$crqtysum = 0;
	 $query3 = "SELECT sum(amount) as crsum,sum(quantity) as crqtysum FROM ac_financialpostings WHERE itemcode = '$code' AND coacode = '$iac' AND crdr = 'Cr' AND warehouse = '$warehouse' AND date <= '$date'";
  $result3 = mysql_query($query3,$conn)  or die(mysql_error());
  if($qr = mysql_fetch_assoc($result3))
  {
	$crsum = $qr['crsum'];
	$crqtysum = $qr['crqtysum'];
  }
	$drsum = 0;$drqtysum = 0;
	$query3 = "SELECT sum(amount) as drsum,sum(quantity) as drqtysum FROM ac_financialpostings WHERE itemcode = '$code' AND coacode = '$iac' AND crdr = 'Dr' AND warehouse = '$warehouse' AND date <= '$date'";
  $result3 = mysql_query($query3,$conn)  or die(mysql_error());
  if($qr = mysql_fetch_assoc($result3))
  {
	 $drsum = $qr['drsum'];
	$drqtysum = $qr['drqtysum'];
  }
  $coa1= "99999";
  //if(($crqtysum > $drqtysum) && ($crsum > $drsum))
  //echo "cr sum ".$crqtysum."dr sum ".$drqtysum;
  if($crqtysum > $drqtysum)
  {
  $riflag1 = 'R';
  $type1 = 'IR';
	$tid = 0;
	$q1 = "select max(tid) as tid from ims_intermediatereceipt WHERE riflag = '$riflag1'";
	$q1rs = mysql_query($q1,$conn) ;
	if($q1r = mysql_fetch_assoc($q1rs))
	$tid = $q1r['tid'];
	$tid = $tid + 1;
	$qty1 = $crqtysum - $drqtysum;
	$amt1 = $crsum - $drsum;
	$rate1 = $amt1/$qty1;
	
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	 VALUES('".$adate."','$code','Dr','".$iac."','$qty1','".$amt1."','".$tid."','".$type1."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
		
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	VALUES('".$adate."','$code','Cr','".$coa1."','$qty1','".$amt1."','".$tid."','".$type1."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	 	$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,units,rateperunit,amount,coa,lot,serial,warehouse,empid,empname,sector,riflag) values ('$tid','$date','$cat','$code','$description','$qty1','$units','$rate1','$amt1','$coa1','$lot','$serial','$warehouse','$empid','$empname','$sector','$riflag1') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());

  }
  //else if(($crqtysum < $drqtysum) && ($crsum < $drsum))
  else if($crqtysum < $drqtysum)
  {
  $riflag1 = 'I';
  $type1 = 'II';
	$tid = 0;
	$q1 = "select max(tid) as tid from ims_intermediatereceipt WHERE riflag = '$riflag1'";
	$q1rs = mysql_query($q1,$conn) ;
	if($q1r = mysql_fetch_assoc($q1rs))
	$tid = $q1r['tid'];
	$tid = $tid + 1;
	$qty1 = $drqtysum - $crqtysum;
	$amt1 = $drsum - $crsum;
	$rate1 = $amt1/$qty1;
	
		 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	 VALUES('".$adate."','$code','Dr','".$coa1."','$qty1','".$amt1."','".$tid."','".$type1."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
		
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	VALUES('".$adate."','$code','Cr','".$iac."','$qty1','".$amt1."','".$tid."','".$type1."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,units,rateperunit,amount,coa,lot,serial,warehouse,empid,empname,sector,riflag) values ('$tid','$date','$cat','$code','$description','$qty1','$units','$rate1','$amt1','$coa1','$lot','$serial','$warehouse','$empid','$empname','$sector','$riflag1') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
  }
  
  
 
	
	

	 $riflag = 'R';
  $type = 'IR';
  $tid = 0;
	$q1 = "select max(tid) as tid from ims_intermediatereceipt WHERE riflag = '$riflag'";
	$q1rs = mysql_query($q1,$conn) ;
	if($q1r = mysql_fetch_assoc($q1rs))
	$tid = $q1r['tid'];
	$tid = $tid + 1;
	$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,units,rateperunit,amount,coa,lot,serial,warehouse,empid,empname,sector,riflag) values ('$tid','$date','$cat','$code','$description','$quantity','$units','$rateperunit','$amount','$coa','$lot','$serial','$warehouse','$empid','$empname','$sector','$riflag') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	
	 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','$code','Dr','".$iac."','$quantity','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
   $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse) 
	          VALUES('".$adate."','$code','Cr','".$coa1."','$quantity','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
}
}
$query5 = "UPDATE ims_intermediatereceipt SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where tid = '$tid' AND riflag = '$riflag'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


//echo "Success";
echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_addintermediate'";
echo "</script>";

?>