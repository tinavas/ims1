<?php 
include "config.php";
include "getemployee.php";

$date = date("Y-m-d",strtotime($_POST['date']));
$cat = $_POST['cat'];
$fromwarehouse1 = explode('@',$_POST['warehouse']);
$fromwarehouse = $fromwarehouse1[0];
$adate=date("Y-m-d");

$type = "STR";

 if($_POST['saed'] == "edit")
	 {
	$tmno = $_POST['tmno'];
	}
	else
	{
	$c="select * from ims_stocktransfer where tmno='$_POST[tmno]'";
	 $c1=mysql_query($c,$conn) or die(mysql_error());
	$n=mysql_num_rows($c1);
	if($n>0)
	{
	 echo "<script type='text/javascript'>";
echo "alert('Document No  $_POST[tmno] Already Exists');";
echo "document.location='dashboardsub.php?page=ims_stocktransfer'";
echo "</script>"; 
	}
	}

for($i = 0;$i < count($_POST['squantity']); $i++)
if( $_POST['squantity'][$i] != '0' && $_POST['squantity'][$i] != '' && $_POST['code'][$i] != '')
{
    $warehouse =$fromwarehouse;
  
	$cat = $_POST['cat'][$i];
	$temp = explode("@",$_POST['code'][$i]);
	$code = $temp[0];	

	$description = $temp[1];	
	
	$units = $_POST['units'][$i];
	$towarehouse = $_POST['towarehouse'][$i];
	$qtyr = $_POST['squantity'][$i];

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
  
  
  if($_POST['saed'] == "edit")
{
      $qty2=$qty1;
  $q="select quantity from ims_stocktransfer where code='$code' and id = '$_POST[oid]' and fromwarehouse='$warehouse'";
  $r=mysql_query($q,$conn);
  $r1=mysql_fetch_array($r);
  $qty1=$qty1+$r1['quantity'];
}	  
	  if($qtyr<=$qty1 )
	 
	  {

$c=0;
}
else
 {$c=1;
 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty1');";
echo "document.location='dashboardsub.php?page=ims_Stocktransfer'";
echo "</script>"; 
	 }
$j=$i;	
$j++; 
	
}
$empname=$_SESSION['valid_user'];
$adate=date("Y-m-d");
if($_POST['saed'] == "edit")
{
$empname=$_POST['cuser'];



}

if($c==0)
{

if($_POST['saed'] == "edit")
{

 $q = "delete from ac_financialpostings where trnum = '$_POST[oid]' AND type ='$_POST[otype]' AND date='$_POST[odate]' AND client='$client'";
   $qr = mysql_query($q,$conn) ;

  $q = "delete from ims_stocktransfer where id = '$_POST[oid]' AND client='$client'";
  $qr = mysql_query($q,$conn) ;
 
}


	$tnum=0;
	$trnum1="";		
 $q = "select tid from ims_stocktransfer where client = '$client'"; 
$qrs = mysql_query($q,$conn) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs)) {  
$trnum = substr($qr['tid'],4);

if($trnum>$trnum1)
{$trnum1=$trnum;
  $tnum=$trnum;
 $tnum = $tnum + 1;
 }
 }
$tnum = "STR-$tnum";
if(mysql_num_rows($qrs)==0)
{
$tnum="STR-1";

}
$tid=$tnum;

for($i = 0; $i < count($_POST['code']); $i++)
if($fromwarehouse != "")
{
if($_POST['code'][$i] != "" && $_POST['towarehouse'][$i] != "" && $_POST['squantity'][$i] != "")
{
     $cat = $_POST['cat'][$i];
	
	$temp = explode("@",$_POST['code'][$i]);
	$code = $temp[0];	

	$description = $temp[1];	
	
	$units = $temp[2];
	$towarehouse = $_POST['towarehouse'][$i];
	$quantity = $_POST['squantity'][$i];
	
	$query = "select cm from ims_itemcodes where code = '$code'";
	 $result = mysql_query($query,$conn);
	  $res=mysql_fetch_assoc($result);
	  $mode = $res['cm'];
	  
	$price=0;
	$price = calculatenew($fromwarehouse,$mode,$code,$date);
	
	$tmno = $_POST['tmno'];
	
	$vno = $_POST['vno'][$i];
	
	$remarks = $_POST['remarks'][$i];
      $amount = 0; 


	 $q = "insert into ims_stocktransfer (tid,date,cat,fromwarehouse,fromunits,towarehouse,tounits,code,quantity,empid,empname,sector,adate,aempid,aempname,asector,price,vehicleno,tmno,remarks,flag,client) values ('$tid','$date','$cat','$fromwarehouse','$units','$towarehouse','$units','$code','$quantity','$empid','$empname','$sector','$date','$empid','$empname','$sector','$price','$vno','$tmno','$remarks','0','$client') ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());

/////////financial postings//////////


$q = "select max(id) as tid from ims_stocktransfer where client = '$client'";
$qrs =mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$id = $qr['tid'];




 
      $q1 = "SELECT * FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
      $r1 = mysql_query($q1,$conn);
      while($row1 = mysql_fetch_assoc($r1))
      {
        $mode = $row1['cm'];
	  $iac = $row1['iac'];
	  $wpac = $row1['wpac'];
      }

	 $amount = $quantity * $price;

  $crdr = "Cr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client,empname,adate) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$tflock','$fromwarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn);
	

    $crdr = "Dr";
   
	if($_SESSION[db]=='singhsatrang')
	{
 $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client,empname,adate) values('$date','$code','$crdr','STTR1','$quantity','$amount','$type','$id','$aflock','$fromwarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn);
	}
	else
	{
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse,client,empname,adate) values('$date','$code','$crdr','$iac','$quantity','$amount','$type','$id','$tflock','$towarehouse','$client','$empname','$adate')";
    $qrs1 = mysql_query($q1,$conn);
	}
	



/////////financial postings//////////
	
}
}

}
echo "<script type='text/javascript'>";
if($alertmsg <> "")
 echo "alert('$alertmsg');";
echo "document.location = 'dashboardsub.php?page=ims_stocktransfer'";
echo "</script>";

?>