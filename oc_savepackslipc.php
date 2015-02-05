<?php 
include "config.php";
include "getemployee.php";

$flag = '0';
$cobiflag = '0'; 
$so = $_POST['so'];
$pocost = 0;
$dbcode = $_SESSION['dbcode'];
$empcode = $_SESSION['empcode'];
	
$date1 = date("d.m.Y",strtotime($_POST['date']));
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
 
$addempid = $empid;
$addempname = $empname;
$addempsector = $sector;		
$entrydate = date("Y-m-d");
$c=0;

$warehouse = $_POST['warehouse'];
$date = date("Y-m-d",strtotime($_POST['date']));
if($_POST['saed'] == 1)

 $ps1 = $_POST['ps'];
 
 
 $cflag=0;

for($i = 0; $i<count($_POST['quantity']); $i++)

if($_POST['quantity'][$i] >0)
{
$quantity = $_POST['quantity'][$i];
$rateperunit = $_POST['rateperunit'][$i];
$units = $_POST['units'][$i];
$itemcode = $_POST['itemcode'][$i];
$description = $_POST['description'][$i];
	 
	$q = "select code,cunits,sunits,iac from ims_itemcodes where code = '$itemcode'";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	if($qr = mysql_fetch_assoc($qrs))
	{
	$iac = $qr['iac'];
    $cunits=$qr['cunits'];
	$isunits=$qr['sunits'];
	}
	 if($isunits!=$cunits)
  {
  
  $qc="select * from ims_convunits where fromunits='$isunits' and tounits='$cunits'";
  
  $qc=mysql_query($qc) or die(mysql_error());
  
  $rc=mysql_fetch_assoc($qc);
  
  $qc=mysql_num_rows($qc);
  
  if($qc=="" || $qc==0)
  {
  echo "<script type='text/javascript'>";
  echo "alert('No Coversion units for $itemcode');";
  echo "</script>";
  $cflag=1;
  }
  else
  {
  
  $conunits=$rc['conunits'];
  
  $sqauntity=$quantity=round(($quantity/$conunits),3);
  
  $sprice=$rateperunit*$conunits;
  
  }
  }
  else
  {
  
  $conunits=1;
  
  $sqauntity=$quantity=round(($quantity/$conunits),3);
  
  $sprice=$rateperunit*$conunits;
  }
  
	
	$allcodes[$itemcode]=array("squantity"=>$sqauntity,"sprice"=>$sprice,"sunits"=>$isunits,"convunit"=>$conunits);
	
	$query2 = "SELECT sum(quantity) as quantity,crdr FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$iac'  and date <= '$date' and quantity > 0 and warehouse='$warehouse' group by crdr order by date,type ";
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
 
 
 $q="select quantity from oc_packslip where ps='$ps1'  and itemcode='$itemcode' and warehouse='$warehouse'";
 $r=mysql_query($q,$conn);
 $r1=mysql_fetch_array($r);
 $qty1=$qty1+$r1['quantity'];
  
 
	  if($quantity <=$qty1 && $rateperunit!=0 && $cflag==0)
	 
	  {

      }
else
 { $c=1;
 echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $itemcode  ,Avalible qty= $qty1');";
echo "document.location='dashboardsub.php?page=oc_packslip'";
echo "</script>"; 
	 }
$j=$i;	
$j++; 
if($rateperunit==0)
{
echo "<script type='text/javascript'>";
echo "alert('Rate per unit is 0 at Row $j ');";
echo "document.location='dashboardsub.php?page=oc_packslip'";
echo "</script>"; 

}	
}

//print_r($allcodes);

if($c==0 && $cflag==0)
{

 
if($_POST['saed'] == 1)
{
 $ps1 = $_POST['ps'];
 $m=$_POST['m'];
 $y=$_POST['y'];
 $psincr=$_POST['psincr'];
 $eempid = $empid;
 $eempname = $empname;
 
  $query = "SELECT itemcode,quantity,empid,empname,sector,empdate FROM oc_packslip WHERE ps='$ps1' ORDER BY itemcode";
 $result = mysql_query($query,$conn) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {

  $query1 = "UPDATE oc_salesorder SET sentquantity = sentquantity - $rows[quantity] WHERE code = '$rows[itemcode]' AND po='$so'";

   mysql_query($query1,$conn) or die(mysql_error());
   $addempid = $rows['empid'];
   $addempname = $rows['empname'];
   $addempsector = $rows['sector'];
   $entrydate = $rows['empdate'];
 }
 $query = "DELETE FROM oc_packslip WHERE ps = '$ps1'";
 mysql_query($query,$conn) or die(mysql_error());
 
 $query = "DELETE FROM ac_financialpostings WHERE trnum = '$ps1' AND type = 'PS'";
 mysql_query($query,$conn) or die(mysql_error());
 
}	



$date1 = date("d.m.Y",strtotime($_POST['date']));
$strdot1 = explode('.',$date1); 
$ignore = $strdot1[0]; 
$m = $strdot1[1];
$y = substr($strdot1[2],2,4);
 

   
if($_POST['saed'] == 1)
{


$psincr=$_POST['psincr'];
	
$temp=explode("-",$ps1);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
$ps1=$ps1;

else
{
$query1 = "SELECT MAX(psincr) as psincr FROM oc_packslip where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $psincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$psincr = $row1['psincr']; 
$psincr = $psincr + 1;
if ($psincr < 10) 
 $ps1 = "PS-".$m.$y.'-000'.$psincr.$code; 
else if($psincr < 100 && $psincr >= 10) 
$ps1 = "PS-".$m.$y.'-00'.$psincr.$code; 
else if($psincr < 1000 && $psincr >= 100) 
$ps1 = "PS-".'-'.$dbcode.'-'.$empcode.'-'.$m.$y.'-0'.$psincr.$code; 
else $ps1 = "PS-".$m.$y.'-'.$psincr.$code;
 }
 
}
 
 if($_POST['saed'] <>1)
 {
 $query1 = "SELECT MAX(psincr) as psincr FROM oc_packslip where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $psincr = 0; 
while($row1 = mysql_fetch_assoc($result1)) 
$psincr = $row1['psincr']; 
$psincr = $psincr + 1;
if ($psincr < 10) 
 $ps1 = "PS-".$m.$y.'-000'.$psincr.$code; 
else if($psincr < 100 && $psincr >= 10) 
$ps1 = "PS-".$m.$y.'-00'.$psincr.$code; 
else if($psincr < 1000 && $psincr >= 100) 
$ps1 = "PS-".'-'.$dbcode.'-'.$empcode.'-'.$m.$y.'-0'.$psincr.$code; 
else $ps1 = "PS-".$m.$y.'-'.$psincr.$code;

 
 
}


$warehouse = $_POST['warehouse'];
$date = date("Y-m-d",strtotime($_POST['date']));
$party = $_POST['party'];
$partycode = $_POST['partycode'];
$so = $_POST['so'];

$freight = $_POST['freight'];
$adate = date("Y-m-d");


for($i = 0; $i<count($_POST['quantity']); $i++)
{

$freightie="";
if($_POST['quantity'][$i] >0)
{

 $quantity = $_POST['quantity'][$i];

$rateperunit = $_POST['rateperunit'][$i];
$units = $_POST['units'][$i];
$itemcode = $_POST['itemcode'][$i];
$description = $_POST['description'][$i];
$items2 = explode('@',$_POST['items'][$i]);

$basic = $quantity * $rateperunit;

 $freightcode=$_POST['fricode'][$i];
 $cashcode=$_POST['cash'][$i];
 $freightie=$_POST['freightie'][$i];
 $freightamount=$_POST['freightamt'][$i];
 $freightvalue=$_POST['freightamt'][$i];;
 
 


 
   $q = "select * from oc_salesorder where po = '$so' and code = '$itemcode' and warehouse = '$warehouse'";


  $qrs2 = mysql_query($q,$conn) or die(mysql_error());

  if($qres = mysql_fetch_assoc($qrs2))

   {
        $quantity1 = $qres['quantity']; 

      $per = $_POST['quantity'][$i] / $quantity1;

       $rateperunit = $qres['rateperunit']; 
   
   }
$taxcode = $qres['taxcode'];

	  $taxvalue = $qres['taxvalue'];

      $taxamount = $qres['taxamount'] * $per;

	  $taxformula = $qres['taxformula'];

      $taxie = $qres['taxie'];




	


	  $discountvalue = $qres['discountamount'] * $per;

      $discountamount = $qres['discountamount'] * $per;

	
 
 

 if($_POST['saed']<> 1)
$empname= $_SESSION['valid_user'];
else
$empname=$_POST['cuser']; 

$tandcdesc = urldecode($tandcdesc);
$finalcost = 0;

$itemcost = $basic;
   if($taxie == "Exclude")
    $itemcost += $taxamount;
	
   if($freightie == "Exclude")
    $itemcost += $freightamount;
	
   $itemcost -= $discountamount;

$finalcost = round(($itemcost),2);
$pocost+=$finalcost;

if ( $freight == "")
  $freight = 0;
if ( $cobiflag == "")
  $cobiflag = 0;
  
  $entrydate="";
  $entrydate=date("Y-m-d");

	 $q = "insert into oc_packslip (psincr,m,y,date,party,ps,so,itemcode,description,quantity,units,rateperunit,totalcost,flag,empid,empname,sector,taxamount,freightamount,discountamount,warehouse,aempid,aempname,adate,taxcode,taxvalue,taxformula,taxie,freightcode,freightvalue,freightformula,freightie,discountvalue,cashcode,sunits,squantity,sprice,convunit) 
	 
	values('$psincr','$m','$y','$date','$party','$ps1','$so','$itemcode','$description','$quantity','$units','$rateperunit','$finalcost','$flag','$addempid','$empname','$addempsector','$taxamount','$freightamount','$discountamount','$warehouse','$eempid','$eempname','$entrydate','$taxcode','$taxvalue','$taxformula','$taxie','$freightcode','$freightvalue','$freightformula','$freightie','$discountvalue','$cashcode',"."'".$allcodes[$itemcode]['sunits']."'".","."'".$allcodes[$itemcode]['squantity']."'".","."'".$allcodes[$itemcode]['sprice']."'".","."'".$allcodes[$itemcode]['convunit']."'".")";
$qrs = mysql_query($q,$conn) or die(mysql_error());


 $q = "update oc_salesorder set sentquantity = sentquantity + '$quantity',psflag = '1',empname='$empname',adate='$adate' where po = '$so' AND code = '$itemcode'";


$qrs = mysql_query($q,$conn) or die(mysql_error());



}
}
$q = "update oc_packslip set pocost = '$pocost',cobiflag = '$cobiflag' where ps = '$ps1'";
$qrs = mysql_query($q,$conn) or die(mysql_error());


$type = "GR";
$query = "select * from oc_packslip where ps = '$ps1' AND flag = 0 ORDER BY id";
$result = mysql_query($query,$conn) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $query9 = "SELECT cm,sunits,iac,cogsac FROM ims_itemcodes WHERE code = '$rows[itemcode]'";
  $result9 = mysql_query($query9,$conn);
  $row = mysql_fetch_assoc($result9);
  $mode = $row['cm'];
  $sunits = $row['sunits'];
  $iac = $row['iac'];
  $cogsac = $row['cogsac'];
  
  $ps = $rows['ps'];
  $party = $rows['party'];
  $partycode = $rows['partycode'];
  $warehouse = $rows['warehouse'];
  $date = $rows['date'];
  $vehicleno = $rows['vehicleno'];
  $driver = $rows['driver'];
  $transport = $rows['transport'];
  $dumid = $rows['id'];
  $val = 0;
  $code = $rows['itemcode'];
  $date = date("Y-m-d",strtotime($_POST['date']));
 $val = round(calculatenew($warehouse,$mode,$code,$date),2);
 
  //$fpqty = $rows[quantity];
 
 $fpqty=$rows['squantity'];
 
 
//////// calculations
 $amount = round(($fpqty*$val),2);
 $type = 'PS';
  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$rows[itemcode]' LIMIT 1";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  {
  $query31 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) VALUES ('$date','$code','Dr','$cogsac','$fpqty','$amount','$ps','$type','$party','$warehouse','$empname','$adate'), ('$date','$code','Cr','$iac','$fpqty','$amount','$ps','$type','$party','$warehouse','$empname','$adate')";

   $result31 = mysql_query($query31,$conn) or die(mysql_error());
  }
   $query5 = "UPDATE oc_packslip SET prodprice = '$val' where ps = '$ps' and itemcode = '$rows[itemcode]' and id = '$dumid' ";
   $result5 = mysql_query($query5,$conn) or die(mysql_error()); ;
}

$adate = date("Y-m-d");
$userlogged = $_SESSION['valid_user'];
$query1 = "SELECT employeename,sector FROM common_useraccess where username= '$userlogged' ORDER BY username ASC LIMIT 1";
$result1 = mysql_query($query1,$conn) or die(mysql_error()); 
while($row11 = mysql_fetch_assoc($result1))
{
	$empname = $row11['employeename'];
	$sector = $row11['sector'];
	$aempid = $row11['employeeid'];
}
$empname= $_SESSION['valid_user'];
$query5 = "UPDATE oc_packslip SET flag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where ps = '$ps1'";
$result5 = mysql_query($query5,$conn) or die(mysql_error());

//$ps1 = str_replace("'","",$ps1);
$query = "INSERT INTO authorization (id,type,trnum,name,sector,client,empname,adate) VALUES (NULL,'$type','$ps1','$empname','$sector','$client','$empname','$adate')";
$result = mysql_query($query,$conn) or die(mysql_error());


}


echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=oc_packslip'";
echo "</script>";
?>