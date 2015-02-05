<?php 
include "config.php";
include "getemployee.php";


$date = date("Y-m-d",strtotime($_POST['date']));
$coacodeall = $_POST['coa'];
$warehouse = $_POST['unit'];
$empname=$_SESSION['valid_user'];

$narration = $_POST['remarks'];
$doc=$_POST['doc'];
$query0="select max(tid) as tid from ims_stockadjustment";
    $result0=mysql_query($query0,$conn);
    $tid=mysql_fetch_assoc($result0);
    if($tid['tid'] >= 1)
	$tid=$tid['tid'];
	else
	$tid=0;
	$tid++;
	
	$c=0;
	for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '')
{
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	
	$t=explode("@",$code);
	$code=$t[0];
	$description = $t[1];;
	$units = $_POST['units'][$i];
	$type=$_POST['addded'][$i];
	$quantity = $_POST['qtys'][$i];
	$flock = $_POST['flock'][$i];
	
	if($type!="Add")
	{

 
	$q = "select distinct(iac) from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$iac = $qr['iac'];


$query2 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$code' and coacode = '$iac'  and date <= '$date' and quantity > 0 and warehouse='$warehouse' group by crdr order by date,type ";
 $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
	  $qty1=0;
	  $qtycr1=0;
	  $qtydr1=0;
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
	  if($quantity<=$qty1)
	 
	  {

}
else
 {$c=1;

 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty1');";
echo "document.location='dashboardsub.php?page=ims_stockadjust'";
echo "</script>"; 
	 }
$j=$i;	
$j++; 


	
	}
	
	
	}
	
	if($c!=1)
	{
	

for($i = 0;$i < count($_POST['qtys']); $i++)
if( $_POST['qtys'][$i] != '0' && $_POST['qtys'][$i] != '')
{
	$cat = $_POST['cat'][$i];
	$code = $_POST['code'][$i];
	
	$t=explode("@",$code);
	$code=$t[0];
	$description = $t[1];;
	$units = $_POST['units'][$i];
	$type=$_POST['addded'][$i];
	$quantity = $_POST['qtys'][$i];
	$flock = $_POST['flock'][$i];
	
$adate = $date;
$qu="insert into ims_stockadjustment(date,unit,coacode,category,code,description,units,type,quantity,trnum,tid,narration,client,empname,adate,docno) values('$date','$warehouse','$coacodeall','$cat','$code','$description','$units','$type','$quantity','$tid','$tid','$narration','$client','$empname','$adate','$doc')";	

$re=mysql_query($qu,$conn) or die(mysql_error());

 //Financial Postings Starts Here



$query9 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
     $result9 = mysql_query($query9,$conn);
     while($row = mysql_fetch_assoc($result9))
     {
       $mode = $row['cm'];
    //   $stdcost = $row['stdcost'];
    // $iac = $row['iac'];
       //$wpac = $row['wpac'];
       //$prvac = $row['prvac'];
       #$feedmill = $row['warehouse'];
     }


$unitprice=calculatenew($warehouse,$mode,$code,$adate);	
$totalprice=$unitprice*$quantity;


If($type=="Add")
{
$crdr = "Cr";
    $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$coacodeall."','".$quantity."','".$totalprice."','".$tid."','STA','".$warehouse."','".$warehouse."','$empname','$adate')";
}
else
{
$crdr = "Dr";
$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','".$code."','Dr','".$coacodeall."','".$quantity."','".$totalprice."','".$tid."','STA','".$warehouse."','".$warehouse."','$empname','$adate')";

}			  
$result4 = mysql_query($query4,$conn) or die(mysql_error());



$totalcost = 0;
///stock update/////////////
  $stockqty = 0;
  $cnt = 0;
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result3 = mysql_query($query3,$conn);
  $cnt = mysql_num_rows($result3);
   if ( $cnt == 0 )
  {
   $iunits = 0;
  $query31 = "SELECT * FROM ims_itemcodes WHERE code = '$code' ";
  $result31 = mysql_query($query31,$conn);
   while($row31 = mysql_fetch_assoc($result31))
   {
      $iunits = $row31['sunits']; 
   }
   $query51 = "insert into ims_stock(warehouse,itemcode,quantity,unit,empname,adate)Values('$warehouse','$code',0,'$iunits','$empname','$adate')";
 $result51 = mysql_query($query51,$conn) or die(mysql_error());

  }
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result3 = mysql_query($query3,$conn);
  while($row3 = mysql_fetch_assoc($result3))
  {
  	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  }

  if($stockunit == $units)
  {
       if($type == 'Add')
	     $stockqty = $stockqty + $quantity;    
		 else
		 $stockqty = $stockqty - $quantity;      
  }
  else
  {
      if($type == 'Add')
         $stockqty = $stockqty + convertqty($quantity,$units,$stockunit,1);
	   else
	     $stockqty = $stockqty - convertqty($quantity,$units,$stockunit,1);
  }
 if($stockqty)
  $query51 = "UPDATE ims_stock SET quantity = '$stockqty',empname='$empname',adate='$adate' WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  else
  $query51 = "UPDATE ims_stock SET quantity = '$quantity',empname='$empname',adate='$adate' WHERE itemcode = '$code' AND warehouse = '$warehouse'";
  $result51 = mysql_query($query51,$conn) or die(mysql_error());
 
///////////end of stock update//////////////
  
$q = "select iac from ims_itemcodes where code = '$code'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	$coacode = $qr['iac'];

If($type=="Add")
{	
$crdr = "Dr";
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','".$code."','Dr','".$coacode."','$quantity','".$totalprice."','".$tid."','STA','".$warehouse."','".$warehouse."','$empname','$adate')";
			  
}
else
{
$crdr = "Cr";
 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
	          VALUES('".$adate."','".$code."','Cr','".$coacode."','$quantity','".$totalprice."','".$tid."','STA','".$warehouse."','".$warehouse."','$empname','$adate')";

}			  
   $result4 = mysql_query($query4,$conn) or die(mysql_error());

	

 }
 
 }
 
 echo "<script type='text/javascript'>";

echo "document.location='dashboardsub.php?page=ims_stockadjust'";
echo "</script>"; 
 
?>


