<?php

include "getemployee.php";

include "config.php";



$aflag = 1;



$pocost = 0; 

$previouspo = "";

$grflag = '0';

$round = "0";

$arraycheckfloag = 0;

$al = 0;

$date = date("Y-m-d",strtotime($_POST['date']));

$grincr=$_POST['grincr'];

$m = $_POST['m'];

$y = $_POST['y'];

if($_POST['saed'] <> 1)
{
$gr=$_POST['gr'];

}


if($_POST['saed'] == 1)
{

  $gr = $_POST['oldgr'];

 $gquery = "select * from pp_goodsreceipt where gr = '$gr'";

$gresult1 = mysql_query($gquery,$conn) or die(mysql_error());
while($gres=mysql_fetch_array($gresult1))
{ 

$resqty=$gres['receivedquantity'];

$query = "SELECT * FROM pp_purchaseorder WHERE code = '$gres[code]' and po='$gres[po]' order by id asc";
$result2 = mysql_query($query,$conn) or die(mysql_error());
while($res2=mysql_fetch_assoc($result2))
{

if( $resqty<=$res2['acceptedquantity'] && $resqty>0)
{
 $updatedqty1 = ($res2['acceptedquantity'] - $resqty);


  $q1 = "update pp_purchaseorder set grflag = '0', acceptedquantity='$updatedqty1',receivedquantity='$updatedqty1' WHERE po='$gres[po]'  and code = '$gres[code]' and id ='$res2[id]'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
 

$resqty=0;

}


else 
if( $resqty>=$res2['acceptedquantity'] && $resqty>0)

{




  $q1 = "update pp_purchaseorder set grflag = '0', acceptedquantity='0',receivedquantity='0' WHERE po='$gres[po]'  and code = '$gres[code]' and id ='$res2[id]'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());


$resqty=$resqty-$res2['acceptedquantity'];



}
}
 }
 



   $get_entriess = "delete from pp_goodsreceipt WHERE gr= '$gr';"; 
 mysql_query($get_entriess,$conn) or die(mysql_error());
 
 $get_entriess = "delete from ac_financialpostings WHERE type='GR' and trnum= '$gr';"; 
 mysql_query($get_entriess,$conn) or die(mysql_error());
 
 
 
 
 $temp=explode("-",$gr);
 $m1=substr($temp[1],0,2);
 $y1=substr($temp[1],2,2);


if($m1==$m && $y1==$y)
 $gr=$gr;

else
{
$gr="";


$query1 = "SELECT MAX(grincr) as grincr,m,y FROM pp_goodsreceipt where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $grincr = 0; 

while($row1 = mysql_fetch_assoc($result1)) { $grincr = $row1['grincr']; }
$grincr = $grincr + 1;
if ($grincr < 10) { $gr = 'GR-'.$m.$y.'-000'.$grincr; }
else if($grincr < 100 && $grincr >= 10) { $gr = 'GR-'.$m.$y.'-00'.$grincr; }
else { $gr = 'GR-'.$m.$y.'-0'.$grincr; }  


 }
 
 
 
 
 

  
  }

$vendor = $_POST['vendor'];



$vendorid = '0';

$vehicleno = $_POST['vehicleno'];

$warehouse = $_POST['warehouse'];

$adate=$date;



for($i = 0; $i < count($_POST['itemcode']);$i++)

{

 if($_POST['quantity'][$i] != '')

 {

  $itemcode = $_POST['itemcode'][$i];

  $description = $_POST['description'][$i];

 

  $qty = $_POST['quantity'][$i];

$cash=$_POST['cash'][$i];




  

  $temp = explode('@',$_POST['po'][$i]);

  $po = $posel = $temp[0];

  {

  

  $q = "select * from pp_purchaseorder where po = '$posel' and code = '$itemcode' and deliverylocation = '$warehouse'";

   

  $qrs2 = mysql_query($q,$conn) or die(mysql_error());

  if($qres = mysql_fetch_assoc($qrs2))

   {

    $vendorcode = $qres[vendorcode];

     

   
   

      $quantity = $qres['quantity']; 

      $per = $_POST['quantity'][$i] / $quantity;

      

	  $credittermcode = $qres['credittermcode'];

      $credittermdescription = $qres['credittermdescription'];

      $credittermvalue = $qres['credittermvalue'];

      $tandccode = $qres['tandccode'];

      $tandc = $qres['tandc'];

	
	   $rateperunit = $qres['rateperunit']; 

	  $unit = $qres['unit']; 

      $basic = $_POST['quantity'][$i] * $rateperunit;



	  $taxcode = $qres['taxcode'];

	  $taxvalue = $qres['taxvalue'];

      $taxamount = $qres['taxamount'] * $per;

	  $taxformula = $qres['taxformula'];

      $taxie = $qres['taxie'];




      $freightie = $_POST['freightie'][$i];
	  
 	  $freightcode=$_POST['fricode'][$i]; 
	  $freightvalue=$_POST['freightamt'][$i];
	  
	 $freightamount =$_POST['freightamt'][$i];

	 

	  $discountvalue = $qres['discountvalue'];

      $discountamount = $qres['discountamount'] * $per;

			  
		$freightamount=round($freightamount,2);
		$taxamount=round($taxamount,2);
		$discountamount=round($discountamount,2);
      //$finalcost = $qres['finalcost'];


	    
 $totalamount = $qty*$rateperunit ;

$pocost = $qty*$rateperunit ;


if($pocost == "")

$pocost = 0;

$aflag = 0;
$sobiflag = 0;
$acceptedquantity=$qty;



 $q="insert into pp_goodsreceipt (vendorcode,date,m,y,grincr,po,vendorid,vendor,code,description,acceptedquantity,receivedquantity,shrinkage,rateperunit,units,gr,aflag,sobiflag,taxcode,taxvalue,taxie,taxformula,taxamount,freightcode,freightvalue,freightie,freightformula,freightamount,cashcode,discountvalue,discountamount,tandccode,tandc,totalamount,pocost,empid,empname,sector,warehouse,vehicleno,adate) values ('$vendorcode','$date','$m','$y','$grincr','$po','$vendorid','$vendor','$itemcode','$description','$qty','$qty','0','$rateperunit','$unit','$gr','$aflag','$sobiflag','$taxcode','$taxvalue','$taxie','$taxformula','$taxamount','$freightcode','$freightvalue','$freightie','$freightformula','$freightamount','$cash','$discountvalue','$discountamount','$tandccode','$tandc','$totalamount','$pocost','$empid','$empname','$sector','$warehouse','$vehicleno','$adate')";





 $qrs = mysql_query($q,$conn) or die(mysql_error());


  
   }//end of inner while



 
 
  }//end of inner for
  
  
  
  
   
  	
 $qu1="select * from pp_purchaseorder where po='$po' and code='$itemcode' and 
deliverylocation = '$warehouse' order by id asc";
$ru=mysql_query($qu1,$conn);
while($re1=mysql_fetch_array($ru))
{

if($re1['quantity']>$re1['receivedquantity'])
{

		if(($acceptedquantity<=($re1['quantity']-$re1['receivedquantity'])) && $acceptedquantity>0)
		{
		
	
	 $q1 = "UPDATE pp_purchaseorder SET receivedquantity = receivedquantity + $acceptedquantity,acceptedquantity =  acceptedquantity + $acceptedquantity,empname='$empname',adate='$adate' WHERE po = '$po' AND code = '$itemcode' and deliverylocation = '$warehouse' and grflag<>1 and id='$re1[id]'";

   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   

   
   $recqty=$re1['receivedquantity']+$acceptedquantity;
   

  $q1 = "update pp_purchaseorder set grflag = '1',empname='$empname',adate='$adate' WHERE po = '$po' and quantity='$recqty'  and grflag<>1 and id='$re1[id]'";
$q1rs = mysql_query($q1,$conn) or die(mysql_error());
	 

   
		$acceptedquantity=0;
		
	
		}
		
		else if(($acceptedquantity > ($re1['quantity']-$re1['receivedquantity'])) && $acceptedquantity>0)
		{
		
		$balqty=$re1['quantity']-$re1['receivedquantity'];
	
		
	 $q1 = "UPDATE pp_purchaseorder SET receivedquantity = receivedquantity + $balqty,acceptedquantity =  acceptedquantity + $balqty,empname='$empname',adate='$adate' WHERE po = '$po' AND code = '$itemcode' and deliverylocation = '$warehouse' and grflag<>1 and id='$re1[id]'";

        $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   
   		$acceptedquantity1=$acceptedquantity-$balqty;
	
        $recqty=$re1['receivedquantity']+$balqty;
  
		
   $q1 = "update pp_purchaseorder set grflag = '1',empname='$empname',adate='$adate' WHERE po = '$po' and quantity='$recqty' and grflag<>1 and id='$re1[id]'";
 $q1rs = mysql_query($q1,$conn) or die(mysql_error());

   
		$acceptedquantity=$acceptedquantity1;
		
		
		
		}


}
 
 }
 
  
  
  
  

 }//end of outer if
 
 

 
 
 

}//end of outer for


$adate = date("Y-m-d",strtotime($_POST['date']));
$venname = $vendor;

for($j = 0;$j<count($_POST['po']);$j++)
 {
 $po = $_POST['po'][$j];
  $itemcode = $_POST['itemcode'][$j]; 
   $temp = explode('@',$_POST['po'][$j]);

  $po = $posel = $temp[0];
 
   $units = $_POST['units'][$j]; 
  $warehouse =$_POST['warehouse'];
  $acceptedquantity = $_POST['quantity'][$j]; 
  $receivedquantity = $_POST['quantity'][$j];
  $receivedqty= $receivedquantity;
  
      $q = "select * from pp_purchaseorder where po = '$posel' and code = '$itemcode' and deliverylocation = '$warehouse'";

   

  $qrs2 = mysql_query($q,$conn) or die(mysql_error());
  $taxamount=0;
  $freightamount=0;
  $discountamount=0;
  $total=0;

  if($qres = mysql_fetch_assoc($qrs2))

   {

    $rateperunit=$qres['rateperunit'];
	
    $taxamount=$qres['taxamount'];

    $oqty = $qres['quantity']; 

    $per = $receivedquantity / $oqty;

      


	  $taxcode = $qres['taxcode'];

	  $taxvalue = $qres['taxvalue'];

	  $taxamount = $qres['taxamount'] * $per;

	  $taxformula = $qres['taxformula'];

      $taxie = $qres['taxie'];



	  $freightcoa = $_POST['fricode'][$j];

	  $freightvalue = $_POST['freightamt'][$j];

      $freightamount =$_POST['freightamt'][$j];

	  $freightie = $_POST['freightie'][$j];
	  
	  
	  
	  $discountcode = $qres['discountcode'];

	  $discountvalue = $qres['discountvalue'];

      $discountamount = $qres['discountamount'] * $per;

	  $discountformula = $qres['discountformula'];

    


$freightamount=round($freightamount,2);
$taxamount=round($taxamount,2);
$discountamount=round($discountamount,2);	

}
  
$total = $receivedquantity * $rateperunit ;
$total=round($total,2);

 if($discountamount!="")

$total=$total-$discountamount;
  
$gtotal=$gtotal+$total;


  ///stock update/////////////
  $query3 = "SELECT * FROM ims_stock WHERE itemcode = '$itemcode'  and client = '$client' and warehouse = '$warehouse' ";

  $result3 = mysql_query($query3,$conn);
   $numrows3 = mysql_num_rows($result3);
	  if($numrows3 == 0)
	  {
	  $query31 = "select * from ims_itemcodes where code = '$itemcode' and client = '$client'";
	 	   $result31 = mysql_query($query31,$conn) or die(mysql_error());
	   $rows31 = mysql_fetch_assoc($result31);
	   $unit = $rows31['sunits'];
	  $query32 = "insert into ims_stock(id,warehouse,itemcode,unit,quantity,client,empname,adate) values(NULL,'$warehouse','$itemcode','$unit',0,'$client','$empname','$adate')";
	 
	   $result32 = mysql_query($query32,$conn) or die(mysql_error());
	  }
	   
	   
	$result3 = mysql_query($query3,$conn); 
  while($row3 = mysql_fetch_assoc($result3))
  {
   	$stockqty = $row3['quantity'];
  	$stockunit = $row3['unit'];
  

  if($stockunit == $units)
  {
      
	   $stockqty = $stockqty + $receivedqty; 
	    
  }
  else
  {
     
	   $stockqty = $stockqty + convertqty($receivedqty,$units,$stockunit,1);
	   
  }
  

  $query51 = "UPDATE ims_stock SET quantity = '$stockqty',empname='$empname',adate='$adate' WHERE itemcode = '$itemcode' and warehouse = '$warehouse'";

  $result51 = mysql_query($query51,$conn) or die(mysql_error());
  }
  ///////////end of stock update//////////////



  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  {
  	$drcode = $row2['iac'];
  }



  $type = 'GR';
  
  
  
 if($taxie=="Include")
  {
  $total=$total-$taxamount;
 $gtotal=$gtotal-$taxamount; 
} 



   $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 

               VALUES('".$adate."','".$itemcode."','Dr','".$drcode."','".$acceptedquantity."','".$total."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());




  $drcr = "Dr";

  $drcr1 = "Cr";



  if($taxie == "Exclude")

  {



    $ttotal = $taxamount; 


$qu1="SELECT `coa` FROM `ims_taxcodes` where `code`='$taxcode'";
$re1=mysql_query($qu1,$conn);
while($ree1=mysql_fetch_array($re1))
{
$taxcoa=$ree1['coa'];

}




    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','".$taxcode."','".$drcr."','".$taxcoa."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());



  }
  
  
  
  
  
  
  
  if($taxie == "Include")

  {




    $ttotal = $taxamount; 


$qu1="SELECT `coa` FROM `ims_taxcodes` where `code`='$taxcode'";
$re1=mysql_query($qu1,$conn);
while($ree1=mysql_fetch_array($re1))
{
$taxcoa=$ree1['coa'];

}



 $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 

               VALUES('".$adate."','".$taxcode."','".$drcr."','".$taxcoa."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());



  }
  
  
  
  


if($freightie=="Exclude Paid By Supplier")
{


    $ttotal = $freightamount; 
	$gtotal=$gtotal+$ttotal;



  $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','".$freightcode."','".$drcr."','".$freightcoa."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());



}






if($freightie=="Exclude")
{
  $ttotal = $freightamount; 

$gtotal=$gtotal;
$qu1="SELECT `coa` FROM `ims_taxcodes` where `code`='$freightcode'";
$re1=mysql_query($qu1,$conn);
while($ree1=mysql_fetch_array($re1))
{
$freightcoa=$ree1['coa'];

}



    $query3 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
 

               VALUES('".$adate."','".$freightcode."','".$drcr."','".$freightcoa."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result3 = mysql_query($query3,$conn) or die(mysql_error());




$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 

               VALUES('".$adate."','".$itemcode."','$drcr1','".$cash."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());




}





if($freightie=="Include")
{
  $ttotal = $freightamount; 

$gtotal=$gtotal-$ttotal;



$query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 

               VALUES('".$adate."','".$itemcode."','$drcr1','".$cash."','".$acceptedquantity."','".$ttotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());




}


  
  
  

/*}*/

$gtotal=$gtotal+$taxamount;

  

 



}

 $query4 = "INSERT INTO ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,trnum,type,venname,warehouse,empname,adate) 
               VALUES('".$adate."','','Cr','".$vsac."','".$acceptedquantity."','".$gtotal."','".$gr."','".$type."','".$venname."','$warehouse','$empname','$adate')";

    $result4 = mysql_query($query4,$conn) or die(mysql_error());

$query5 = "UPDATE pp_goodsreceipt SET aflag = '1',adate = '$adate',aempid = '$empid',aempname = '$empname',asector = '$sector' where gr = '$gr'";

$result5 = mysql_query($query5,$conn) or die(mysql_error());





echo "<script type='text/javascript'>";
echo "document.location='dashboardsub.php?page=pp_goodsreceipt'";

echo "</script>";

?>

