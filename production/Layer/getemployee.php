<?php
session_start();
include "config.php"; 

$query2 = "SELECT * FROM ac_coa WHERE controltype = 'Vendor Contra Account'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
 $vsac = $row2['code']; 

$query2 = "SELECT * FROM ac_coa WHERE controltype = 'Tax Contra Account'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
 $tca = $row2['code']; 

$query2 = "SELECT * FROM ac_coa WHERE controltype = 'Charge Contra Account'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
 $cca = $row2['code']; 

$query2 = "SELECT * FROM ac_coa WHERE controltype = 'Discount Contra Account'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
 $dca = $row2['code']; 

$query2 = "SELECT * FROM ac_coa WHERE controltype = 'Brokerage Contra Account'";
$result2 = mysql_query($query2,$conn);
while($row2 = mysql_fetch_assoc($result2))
 $bca = $row2['code']; 

$userlogged = $_SESSION['valid_user'];
           $query1 = "SELECT * FROM common_useraccess where username= '$userlogged' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
                //$rights = $row11['page'];
				$empid = $row11['employeeid'];
				$empname = $row11['employeename'];
				$sector = $row11['sector'];
           }
		   $query2 = "SELECT * FROM tbl_sector where sector= '$sector' ORDER BY sector ASC ";
           $result2 = mysql_query($query2,$conn); 
           while($row2 = mysql_fetch_assoc($result2))
           {
                $sectortype = $row2['type1'];
           }


function convertqty($qty,$sunit,$cunit,$flag)
{
  include "config.php";
  $query2 = "SELECT * FROM ims_itemunits WHERE sunits = '$sunit' and cunits = '$cunit'";
  $result2 = mysql_query($query2,$conn);
  while($row2 = mysql_fetch_assoc($result2))
  {
    $cvalue = $row2['cvalue'];
  }
  if($flag)
  $total = $qty * $cvalue;
  else
  $total = $qty / $cvalue;
  return $total;
}


function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

function changeprice($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00";}
else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=3){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}

if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 2) { $c = "0"; }
$stringtoreturn = $stringtoreturn.$c;
return $stringtoreturn;
}





function changeprice1($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00";}
else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits;
}elseif(strlen($num)<=3){
$stringtoreturn = $num;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}

if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
return $stringtoreturn;
}

?>



 
<?php

function calculate($mode,$itemcode,$adate)
{
  include "config.php"; 
  if ( $mode == "Weighted Average")
  {  $wtqty = 0; 
      $wtval = 0;
	  $rtqty = 0;
	  $rtval = 0;
	  $cnt = 0;
	  // Goods Receipt
      $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and aflag = '1' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	$cnt1 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	   $rate= 0;
         $wtqty = $wtqty + $row2['receivedquantity']; 
	   $wtval = $wtval + $row2['totalamount']; 
      }
	  //Initial Stock
	   $query2 = "SELECT * FROM ims_initialstock WHERE itemcode = '$itemcode' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	   $wtval = $wtval + $row2['amount']; 
      } 
	  //Direct Purchase
	  $query2 = "SELECT * FROM pp_sobi WHERE code = '$itemcode' and dflag = 0 and flag = 1 and adate <= '$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt3 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['receivedquantity']; 
	   $wtval = $wtval + ($row2['receivedquantity'] * $row2['rateperunit']); 
      }
	  
	  //Production
	   
	  $query2 = "SELECT * FROM breeder_production WHERE itemcode = '$itemcode' and date1 <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt4 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $wtqty = $wtqty + $row2['quantity'];
	    $query21 = "select * from ac_financialpostings where itemcode = '$itemcode' and trnum = '$row2[flock]' and type = 'Production' and date = '$row2[date1]'";
          $result21 = mysql_query($query21,$conn);
	      while($row21 = mysql_fetch_assoc($result21))
            { 
		   $wtval = $wtval + $row21['amount']; 
		 }
		
      }
	  //PackSlip
	  $query2 = "SELECT * FROM oc_packslip WHERE itemcode = '$itemcode' and flag = '1' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt5 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	     $rtqty = $rtqty + $row2['quantity'];
		 $rtval = $rtval + round(($row2['prodprice'] * $row2['quantity']),2); 
      }
	  //Direct Sales
	   //Direct Purchase
	  $query2 = "SELECT * FROM oc_cobi WHERE code = '$itemcode' and dflag = 0 and flag = 1 and adate <= '$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt6 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	   $wtval = $wtval + ($row2['quantity'] * $row2['price']); 
      }
	  
	  //Consumption
	  $query2 = "SELECT * FROM breeder_consumption WHERE itemcode = '$itemcode' and date2 <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	 $cnt7 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rtqty = $rtqty + $row2['quantity'];
		  $query21 = "select * from ac_financialpostings where itemcode = '$itemcode' and trnum = '$row2[flock]' and  type = 'Consumption' and date = '$row2[date2]' group by trnum ";
          $result21 = mysql_query($query21,$conn);
	      while($row21 = mysql_fetch_assoc($result21))
         { 
		    $rtval = $rtval + $row21['amount']; 
		 }
		
      }
	 
	  if ( $cnt == 0 AND $cnt1 == 0 AND $cnt2 == 0 AND $cnt3 == 0 AND $cnt4 == 0 AND $cnt5 == 0 AND $cnt6 == 0 AND $cnt7 == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  { 
	   $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	   $val = round(($wtval/$wtqty),4);
	  }	 
  }




  if ( $mode == "Fifo" )
  {
     $totqty = 0;
     $query2 = "SELECT sum(quantity) as totqty FROM oc_packslip WHERE itemcode = '$itemcode' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totqty = $row2['totqty'];
	  }
	  
	  $purqty = 0;
	  $bal = 0;
	  $fifoval = 0;
	  $pkqty = $row1['quantity'];
      $dumqty = $pkqty;
	 $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and adate <='$adate' order by adate ";
      $result2 = mysql_query($query2,$conn);
	  $cnt = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	    if ( $dumqty > 0)
		{
		   if ( $totqty > $purqty )
		 {
		     $purqty = $purqty + $row2['receivedquantity'];
			 if ( $purqty > $totqty )
			 {
			     $bal = $purqty  - $totqty;
				 if ( bal > $pkqty )
				 {
				    $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
					$dumqty = 0;
				 }
				 else
				 {
				   $fifoval = $fifoval + $row2['totalamount'];
				   $dumqty = $pkqty - $bal;
				 }
			 }
		 }
		 else
		 {
		    if ($row2['receivedquantity'] > $dumqty )
			{
			   $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
			   $dumqty = 0;
			}
			else
			{
			    $fifoval = $fifoval + $row2['totalamount'];
			    $dumqty = $dumqty - $row2['receivedquantity'];
			}		   
		 }
		}
	     
	  }
	   if ( $cnt == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  {
	   $val = round(($fifoval/$pkqty),4);
	  }
	  
  }
  if ( $mode == "Lifo")
  {
      $totqty = 0;
     $query2 = "SELECT sum(quantity) as totqty FROM oc_packslip WHERE itemcode = '$itemcode' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totqty = $row2['totqty'];
	  }
	  
	  $purqty = 0;
	  $bal = 0;
	  $fifoval = 0;
	  $pkqty = $row1['quantity'];
      $dumqty = $pkqty;
	 $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and adate <='$adate' order by adate DESC ";
      $result2 = mysql_query($query2,$conn);
	  $cnt = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	    if ( $dumqty > 0)
		{
		   if ( $totqty > $purqty )
		 {
		     $purqty = $purqty + $row2['receivedquantity'];
			 if ( $purqty > $totqty )
			 {
			     $bal = $purqty  - $totqty;
				 if ( bal > $pkqty )
				 {
				    $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
					$dumqty = 0;
				 }
				 else
				 {
				   $fifoval = $fifoval + $row2['totalamount'];
				   $dumqty = $pkqty - $bal;
				 }
			 }
		 }
		 else
		 {
		    if ($row2['receivedquantity'] > $dumqty )
			{
			   $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
			   $dumqty = 0;
			}
			else
			{
			    $fifoval = $fifoval + $row2['totalamount'];
			    $dumqty = $dumqty - $row2['receivedquantity'];
			}		   
		 }
		}
	     
	  }
	   if ( $cnt == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  {
	   $val = round(($fifoval/$pkqty),4);
	  }
  
  }
return $val;
}



////////////beginning of calculate1 function////////////
function calculate1($mode,$itemcode,$adate,$warehouse)
{
  include "config.php"; 
  if ( $mode == "Weighted Average")
  {  $wtqty = 0; 
      $wtval = 0;
	  $rtqty = 0;
	  $rtval = 0;
	  $cnt = 0;
	  // Goods Receipt
      $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and aflag = '1' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn1);
	$cnt1 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	   $rate= 0;
         $wtqty = $wtqty + $row2['receivedquantity']; 
	   $wtval = $wtval + $row2['totalamount']; 
      }
	  //Initial Stock
	$query2 = "SELECT * FROM ims_initialstock WHERE itemcode = '$itemcode' AND warehouse = '$warehouse'";
      $result2 = mysql_query($query2,$conn1);
	$cnt2 = mysql_num_rows($result2); 
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	   $wtval = $wtval + $row2['amount']; 
      }  
	  //Direct Purchase
	  $query2 = "SELECT * FROM pp_sobi WHERE code = '$itemcode' and dflag = 0 and flag = 1 and warehouse = '$warehouse' and adate <= '$adate' ";
      $result2 = mysql_query($query2,$conn1);
	  $cnt3 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['receivedquantity']; 
	   $wtval = $wtval + ($row2['receivedquantity'] * $row2['rateperunit']); 
      }
	  
	  //Production
	   
	  $query2 = "SELECT * FROM breeder_production WHERE itemcode = '$itemcode' and date1 <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt4 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $wtqty = $wtqty + $row2['quantity'];
	    $query21 = "select * from ac_financialpostings where itemcode = '$itemcode' and trnum = '$row2[flock]' and type = 'Production' and date = '$row2[date1]'";
          $result21 = mysql_query($query21,$conn);
	      while($row21 = mysql_fetch_assoc($result21))
            { 
		   $wtval = $wtval + $row21['amount']; 
		 }
		
      }
	  //PackSlip
	  $query2 = "SELECT * FROM oc_packslip WHERE itemcode = '$itemcode' and flag = '1' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt5 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	     $rtqty = $rtqty + $row2['quantity'];
		 $rtval = $rtval + round(($row2['prodprice'] * $row2['quantity']),2); 
      }
	  //Direct Sales
	   //Direct Purchase
	  $query2 = "SELECT * FROM oc_cobi WHERE code = '$itemcode' and dflag = 0 and warehosue = '$warehouse' and flag = 1 and adate <= '$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt6 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	   $wtval = $wtval + ($row2['quantity'] * $row2['price']); 
      }
	  
	  //Consumption
	  $query2 = "SELECT * FROM breeder_consumption WHERE itemcode = '$itemcode' and date2 <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	 $cnt7 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rtqty = $rtqty + $row2['quantity'];
		  $query21 = "select * from ac_financialpostings where itemcode = '$itemcode' and trnum = '$row2[flock]' and  type = 'Consumption' and date = '$row2[date2]' group by trnum ";
          $result21 = mysql_query($query21,$conn);
	      while($row21 = mysql_fetch_assoc($result21))
         { 
		    $rtval = $rtval + $row21['amount']; 
		 }
		
      }
	 
	  if ( $cnt == 0 AND $cnt1 == 0 AND $cnt2 == 0 AND $cnt3 == 0 AND $cnt4 == 0 AND $cnt5 == 0 AND $cnt6 == 0 AND $cnt7 == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  { 
	   $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	   $val = round(($wtval/$wtqty),4);
	  }	 
  }




  if ( $mode == "Fifo" )
  {
     $totqty = 0;
     $query2 = "SELECT sum(quantity) as totqty FROM oc_packslip WHERE itemcode = '$itemcode' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totqty = $row2['totqty'];
	  }
	  
	  $purqty = 0;
	  $bal = 0;
	  $fifoval = 0;
	  $pkqty = $row1['quantity'];
      $dumqty = $pkqty;
	 $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and adate <='$adate' order by adate ";
      $result2 = mysql_query($query2,$conn);
	  $cnt = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	    if ( $dumqty > 0)
		{
		   if ( $totqty > $purqty )
		 {
		     $purqty = $purqty + $row2['receivedquantity'];
			 if ( $purqty > $totqty )
			 {
			     $bal = $purqty  - $totqty;
				 if ( bal > $pkqty )
				 {
				    $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
					$dumqty = 0;
				 }
				 else
				 {
				   $fifoval = $fifoval + $row2['totalamount'];
				   $dumqty = $pkqty - $bal;
				 }
			 }
		 }
		 else
		 {
		    if ($row2['receivedquantity'] > $dumqty )
			{
			   $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
			   $dumqty = 0;
			}
			else
			{
			    $fifoval = $fifoval + $row2['totalamount'];
			    $dumqty = $dumqty - $row2['receivedquantity'];
			}		   
		 }
		}
	     
	  }
	   if ( $cnt == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  {
	   $val = round(($fifoval/$pkqty),4);
	  }
	  
  }
  if ( $mode == "Lifo")
  {
      $totqty = 0;
     $query2 = "SELECT sum(quantity) as totqty FROM oc_packslip WHERE itemcode = '$itemcode' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totqty = $row2['totqty'];
	  }
	  
	  $purqty = 0;
	  $bal = 0;
	  $fifoval = 0;
	  $pkqty = $row1['quantity'];
      $dumqty = $pkqty;
	 $query2 = "SELECT * FROM pp_goodsreceipt WHERE code = '$itemcode' and adate <='$adate' order by adate DESC ";
      $result2 = mysql_query($query2,$conn);
	  $cnt = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	    if ( $dumqty > 0)
		{
		   if ( $totqty > $purqty )
		 {
		     $purqty = $purqty + $row2['receivedquantity'];
			 if ( $purqty > $totqty )
			 {
			     $bal = $purqty  - $totqty;
				 if ( bal > $pkqty )
				 {
				    $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
					$dumqty = 0;
				 }
				 else
				 {
				   $fifoval = $fifoval + $row2['totalamount'];
				   $dumqty = $pkqty - $bal;
				 }
			 }
		 }
		 else
		 {
		    if ($row2['receivedquantity'] > $dumqty )
			{
			   $fifoval = $fifoval + round((round(($row2['totalamount']/$row2['receivedquantity']),4) * $dumqty),4);
			   $dumqty = 0;
			}
			else
			{
			    $fifoval = $fifoval + $row2['totalamount'];
			    $dumqty = $dumqty - $row2['receivedquantity'];
			}		   
		 }
		}
	     
	  }
	   if ( $cnt == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  {
	   $val = round(($fifoval/$pkqty),4);
	  }
  
  }
return $val;
}
/////////////end of function calculate1/////////////
?>


