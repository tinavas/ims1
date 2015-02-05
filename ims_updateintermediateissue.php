<?php 
include "config.php";
include "getemployee.php";
$riflag = 'I';
$tid = $_POST['tid'];
$remarks=$_POST['remarks'];
$client = $_SESSION['client']; 
    $code1 = $_POST['code'][0];
	$code2 = explode("@",$code1);
	$code = $code2[0];
	$description=$code2[1];
	$quantity = $_POST['quantity'][0];
	$quantity1 = $_POST['quantity1'][0];
$date = date("Y-m-d",strtotime($_POST['date']));
$c=0;


$date = date("Y-m-d",strtotime($_POST['date']));
$adate = date("Y-m-d",strtotime($_POST['date']));
for($i = 0; $i<count($_POST['code']); $i++)
{
 if($_POST['code'][$i]!= '' && $_POST['quantity'][$i]!= '' && $_POST['coa'][$i]!= ''&& $_POST['warehouse']!="")
 {
	$cat = $_POST['cat'][$i];
	$units = $_POST['units'][$i];
	$type = "II";
		
	
	$q="select cm,code,sunits from ims_itemcodes where code='$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$mode=$qr['cm'];
	$sunits=$qr["sunits"];	
	}
	$q="select conunits from ims_convunits where fromunits='$sunits' and tounits='$units'";
	$qrs=mysql_query($q,$conn);
	$qr=mysql_fetch_assoc($qrs);
	$conunit=$qr["conunits"];
	 
	if($sunits==$units)
	{
		$conunit=1;
		}
	$quantity = $_POST['quantity'][$i]/$conunit;
	
 $rateperunit=calculatenew($warehouse,$mode,$code,$date);
$amount = $quantity * $rateperunit;
	$coa = $_POST['coa'][$i];
	$lot = $_POST['lot'][$i];
	$serial = $_POST['serial'][$i];
	$warehouse = $_POST['warehouse'][$i];
	$flock = $_POST['flock'][$i];
	
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];
	
	
	
$query2 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$code' and coacode = '$iac'  and date <= '$date' and quantity > 0 and warehouse='$warehouse' group by crdr order by date,type ";
 $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
	  $qty1=0;
      while($row2 = mysql_fetch_assoc($result2))
      {
          if($row2['crdr']=="Cr")
		  {
         $qtycr1 = $row2['quantity']; 
		  }
		  else
		  {
		 $qtydr1 = $row2['quantity'];
		  }
      } 
	 $qty1=$qtydr1-$qtycr1;
	  
	    $qty2=$qty1;
$q="select quantity from ims_intermediatereceipt WHERE riflag = 'I' and tid = '$tid'  code='$code' and  warehouse='$warehouse'";
  $r=mysql_query($q,$conn);
  $r1=mysql_fetch_array($r);
  $qty1=$qty1+$r1['quantity'];
	  
	  
	  if($quantity<=$qty1)
	 
	  {
	  
	  }
	  
	  else
	  {
	  $c=1;
	  
	  echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty1');";
echo "document.location='dashboardsub.php?page=ims_intermediateissue'";

echo "</script>"; 
	  
	  }
	
	
	
	
	
	
	}
	}





	  if($c!=1)
	 
	  {

	$q =  "select * from ims_intermediatereceipt WHERE riflag = 'I' and tid = '$tid'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$code= $qr['code']; $warehouse2 = $qr['warehouse'];
	$quantity  = $qr['quantity'];$rateperunit = $qr['$rateperunit'];
	$units = $qr['units'];
	 
}


$get_entriess = "DELETE FROM ims_intermediatereceipt  WHERE riflag='I' and  tid = '$tid'";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());




$get_entriess = "DELETE FROM ac_financialpostings WHERE  trnum = '$tid' and type = 'II'   ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
 $empname = $_POST['cuser'];

$date = date("Y-m-d",strtotime($_POST['date']));
$adate = date("Y-m-d",strtotime($_POST['date']));
$doc=$_POST['doc'];
for($i = 0; $i<count($_POST['code']); $i++)
{
 if($_POST['code'][$i]!= '' && $_POST['quantity'][$i]!= '' && $_POST['coa'][$i]!= ''&& $_POST['warehouse']!="")
 {
	$cat = $_POST['cat'][$i];
	
	
	$quantity = $_POST['quantity'][$i];
	$units = $_POST['units'][$i];
	$type = "II";
		
	
	$q="select cm,code,sunits from ims_itemcodes where code='$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$mode=$qr['cm'];
	$sunits=$qr["sunits"];	
	}
	$q="select conunits from ims_convunits where fromunits='$sunits' and tounits='$units'";
	$qrs=mysql_query($q,$conn);
	$qr=mysql_fetch_assoc($qrs);
	$conunit=$qr["conunits"]; 
	if($sunits==$units)
	{
		$conunit=1;
		}
	$quantity1 = $_POST['quantity'][$i]/$conunit;
	
 $rateperunit=calculatenew($warehouse,$mode,$code,$date);
$amount = $quantity1 * $rateperunit;
	$coa = $_POST['coa'][$i];
	$lot = $_POST['lot'][$i];
	$serial = $_POST['serial'][$i];
	$warehouse = $_POST['warehouse'][$i];
	$flock = $_POST['flock'][$i];
	
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];
if($_SESSION['db']=="mew") 
{
	$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,cquantity,units,rateperunit,amount,coa,lot,serial,warehouse,empid,empname,sector,riflag,adate,docno,narration) values ('$tid','$date','$cat','$code','$description','$quantity1','$quantity','$units','$rateperunit','$amount','$coa','$lot','$serial','$warehouse','$empid','$empname','$sector','$riflag','$adate','$doc','$remarks') ";	
	$qrs = mysql_query($q,$conn) or die(mysql_error());
}
else
{
$q = "insert into ims_intermediatereceipt (tid,date,cat,code,description,quantity,cquantity,units,rateperunit,amount,coa,lot,serial,warehouse,empid,empname,sector,riflag,adate,docno) values ('$tid','$date','$cat','$code','$description','$quantity1','$quantity','$units','$rateperunit','$amount','$coa','$lot','$serial','$warehouse','$empid','$empname','$sector','$riflag','$adate','$doc') ";	
	$qrs = mysql_query($q,$conn) or die(mysql_error());	
}
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','$code','Cr','".$iac."','$quantity1','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	
	
	
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','$code','Dr','".$coa."','$quantity1','".$amount."','".$tid."','".$type."','".$warehouse."','".$warehouse."','$empname','$adate')";
    $result4 = mysql_query($query4,$conn) or die(mysql_error());
	
	
	
 }
}

$query5 = "UPDATE ims_intermediatereceipt SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector',empname='$empname' where tid = '$tid' AND riflag = '$riflag'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());


}


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=ims_intermediateissue'";
echo "</script>";

?>