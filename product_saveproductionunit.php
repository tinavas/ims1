<?php


//print_r($_POST);


include "getemployee.php";

$flag=$cflag=0;
if($_POST['production']!=""&&$_POST['date1']!=""&&$_POST['warehouse']!=""&&$_POST['producttype']!=""&&$_POST['formula']!=""&&$_POST['production']!="0" && $_POST['batches']!=""&&$_POST['batches']!="0")
{
$date1=$date = $_POST['date1'];

$date = date("Y-m-j", strtotime($date)); 



//-----------------code to check for stock and conversion units-----

 $query5 = "SELECT * FROM product_fformula where sid = '$_POST[formula]' and producttype = '$_POST[producttype]'  ORDER BY ingredient ASC ";
$result5 = mysql_query($query5,$conn)or die(mysql_error()) ; 
$numrows5 = mysql_num_rows($result5);
while($row5 = mysql_fetch_assoc($result5))
   { 
   
      $code=$row5['ingredient'];
   
  $warehouse=$_POST['warehouse'];

$cquantity=$quantity=round($row5['quantity']*$_POST['batches'],5);

$query9 = "SELECT * FROM ims_itemcodes WHERE code = '$code'";
     $result9 = mysql_query($query9,$conn);
     while($row = mysql_fetch_assoc($result9))
     {
       $mode = $row['cm'];
       $stdcost = $row['stdcost'];
       $iac = $row['iac'];
       $wpac = $row['wpac'];
       $prvac = $row['prvac'];
	   $prvac=$consac=$row['consac'];
      
     }

$crquant=$drquant=$totquant=$qtycr1=$qtydr1=$qty1=0;



$qi="select code,cunits,sunits from ims_itemcodes where code='$row5[ingredient]'";

   $qi=mysql_query($qi) or die(mysql_error());
   
   $ri=mysql_fetch_assoc($qi);
   
   $sunits=$ri['sunits'];
   
   $cunits=$ri['cunits'];
   
   if($sunits!=$cunits)
  {
  
  $qc="select * from ims_convunits where fromunits='$sunits' and tounits='$cunits'";
  
  $qc=mysql_query($qc) or die(mysql_error());
  
  $rc=mysql_fetch_assoc($qc);
  
  $qc=mysql_num_rows($qc);
  
  if($qc=="" || $qc==0)
  {
  echo "<script type='text/javascript'>";
  echo "alert('No Coversion units for $row5[ingredient]');";
  echo "</script>";
  $cflag=1;
  }
  else
  {
  
  $conunits=$rc['conunits'];
  
 $sprice=round(calculatenew($warehouse,$mode,$code,$date),5);
  
  $cprice=($sprice/$conunits);
  
  $squantity=round($cquantity/$conunits,5);
  
 }
  
  
  } 
  else
  {
  $conunits=1;
  
  $squantity=round($cquantity,5);
  
  $cprice=$sprice=round(calculatenew($warehouse,$mode,$code,$date),5);
  
  }


$allcodes[$code]=array("squantity"=>$squantity,"cquantity"=>$cquantity,"sprice"=>$sprice,"cprice"=>$cprice,"conunits"=>$conunits,"sunits"=>$sunits,"cunits"=>$cunits);



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
 

if($squantity>$qty1)
{
$flag=1;
echo "<script type='text/javascript'>";
echo "alert('Quantity is exceed for Item : $code  ,Avalible qty= $qty1');";
echo "</script>"; 
}

}

//print_r($allcodes);
   
if($flag==1 || $cflag==1)
{
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=product_productionunit';";
echo "</script>";
}





//echo $flag;
if($flag==0 && $cflag==0)
{

 $q = "select id from product_formula where producttype = '$_POST[producttype]' and name = '$_POST[formula]' ";
$qrs = mysql_query($q,$conn) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$formulaid = $qr['id'];


 $query="INSERT INTO product_productionunit (id,formulaid,matconsumed,shrinkage,production,materialcost,shrinkagecost,
shrinkageper,noofunits,costperunit,productcostperkg,producttype,producttypedesc,date,formula,warehouse,batches,kgs,packing,other,etotal,empid,empname)
VALUES (NULL,'$formulaid','".$_POST['matconsumed']."','".$_POST['shrinkage']."','".$_POST['production']."'
,'".$_POST['materialcost']."','".$_POST['shrinkagecost']."','".$_POST['shrinkageper']."','".$_POST['noofunits']."','".$_POST['costperunit']."'
,'".$_POST['costperunit']."','".$_POST['producttype']."','".$_POST['producttypedesc']."','".$date."'
,'".$_POST['formula']."','".$_POST['warehouse']."','".$_POST['batches']."','".$_POST['matconsumed']."','".$_POST['packing']."'
,'".$_POST['other']."','$etotal','$empid','$empname')" ;
 
 
 $get_entriess_res1 = mysql_query($query,$conn)or die(mysql_error())  ;




$query5 = "SELECT max(id) as `id` FROM product_productionunit";
$result5 = mysql_query($query5,$conn)or die(mysql_error()) ; 
while($row5 = mysql_fetch_assoc($result5))
 { 
   $pid = $row5['id'];
 }

$cflag=0;

$query5 = "SELECT * FROM product_fformula where sid = '$_POST[formula]' and producttype = '$_POST[producttype]'  ORDER BY ingredient ASC ";
$result5 = mysql_query($query5,$conn)or die(mysql_error()) ; 
$numrows5 = mysql_num_rows($result5);
if( $numrows5 > 0 )
 {
   while($row5 = mysql_fetch_assoc($result5))
   { 
      
	   $code=$row5['ingredient'];
	   
	 $deduction = $row5['quantity'] * $_POST['batches'] ;
	   $query="INSERT INTO product_itemwise (id,date,warehouse,producttype,producttypedesc,ingredient,quantity,pid,formulae,sunits,squantity,sprice,cunits,cquantity,cprice,conunits)
       VALUES (NULL,'".$date."','".$_POST['warehouse']."','".$_POST['producttype']."','".$_POST['producttypedesc']."','".$row5['ingredient']."','".$deduction."','".$pid."','".$_POST['formula']."','".$allcodes[$code]['sunits']."','".$allcodes[$code]['squantity']."','".$allcodes[$code]['sprice']."','".$allcodes[$code]['cunits']."','".$allcodes[$code]['cquantity']."','".$allcodes[$code]['cprice']."','".$allcodes[$code]['conunits']."')" ;
       $get_entriess_res1 = mysql_query($query,$conn)or die(mysql_error())  ;

   }
 } 



////////Authorize///////////////




$formulaa = $_POST['formula'];
$warehouse = $_POST['warehouse'];
$date = $date;
$producttype = $_POST['producttype'];
$production = $_POST['production'];


$get_entriess3 = "UPDATE `product_productionunit` SET `flag` = 1 WHERE id = '$pid';";
$get_entriess_res3 = mysql_query($get_entriess3,$conn) or die(mysql_error());


 $query5 = "SELECT * FROM product_itemwise where pid = '$pid' and formulae = '$formulaa'  ORDER BY ingredient ASC ";
$result5 = mysql_query($query5,$conn); 
$numrows5 = mysql_num_rows($result5);
if( $numrows5 > 0 )
 {
   while($row5 = mysql_fetch_assoc($result5))
   { 
     $deduction = $row5['squantity']; 
	 
     $date = $row5['date'];      
	 
     $formula = $row5['formulae'];

     $code = $row5['ingredient'];
 
    
      $tamount = 0;

    
 $tamount = round($row5['squantity'] * $row5['sprice'],5);

    $type = "Item Consumed";

    $tttamount = round($tttamount + $tamount,5);

    $crdr = "Dr";
	
	
	if(($deduction > 0) or ($tamount > 0))
	{

    $crdr = "Cr";
     $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$code."','".$crdr."','".$iac."','".$deduction."','".$tamount."','".$type."','".$formula."','".$warehouse."','".$warehouse."')";
   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   ///insert into ac_financialpostingssummary
		 
   }
   
  

  }
 } 


$q = "select * from ims_itemcodes where code = '$producttype' ";
    $qrs = mysql_query($q,$conn) or die(mysql_error());
    while($qr = mysql_fetch_assoc($qrs))
    {
	  $stdcost = $qr['stdcost'];
        $iac = $qr['iac'];
        $prvac=$wpac = $qr['wpac'];
		$mode=$qr['cm'];
       
    }


$type = "product Produced";

if($mode=="Weighted Average")
{

$pvflag=0;
$tamount=$tttamount;

}
else
{	
    $pvflag=1;
    $tamount = round($production * $stdcost);
	
}


    $final = round($tttamount - $tamount,5);

    $crdr = "Dr";
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$producttype."','".$crdr."','".$iac."','".$production."','".$tamount."','".$type."','".$formula."','".$warehouse."','".$warehouse."')";
    $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
	
	
 if($final != 0 && $pvflag==1)
    {
    if($final < 0) { $crdr = "Cr"; $final = -($final); } else { $crdr = "Dr"; }
    $q1 = "insert into ac_financialpostings(date,itemcode,crdr,coacode,quantity,amount,type,trnum,venname,warehouse) values('".$date."','".$producttype."','".$crdr."','".$prvac."','".$production."','".$final."','".$type."','".$formula."','".$warehouse."','".$warehouse."')";
   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
   
    ///insert into ac_financialpostingssummary
		 
   
    }
	
}
}
?>
<?php
echo "<script type='text/javascript'>";
echo "document.location = 'dashboardsub.php?page=product_productionunit';";
echo "</script>";
?>