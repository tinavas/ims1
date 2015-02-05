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
				$currencyunits = $row11['currencyunit'];
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

function changequantity($num){


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
$a  = explode('',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 2) { $c = ""; }
$stringtoreturn = $stringtoreturn.$c;
return $stringtoreturn;
}
function makecomma($input)
{
if($_SESSION[millionformate])
{
if(strlen($input)<=3)
{ return $input; }
$length=substr($input,0,strlen($input)-3);
$formatted_input = makecomma($length).",".substr($input,-3);
return $formatted_input;
}

else {
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}
}

function changeprice($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00000";}
else { $decimalpart= substr($num, $pos+1,6); $num = substr($num,0,$pos); }

if(strlen($num)>5 & strlen($num) <= 12){
$last3digits = substr($num, -5 );
$numexceptlastdigits = substr($num, 0, -5 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=5){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 5);
}

if(substr($stringtoreturn,0,5)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,5);}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 5) { $c = "0"; }
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

function calculate($mode,$itemcode,$adate,$usqty)
{

  include "config.php"; 

  if ( $mode == "Weighted Average")
  {  $wtqty = 0; 
      $wtval = 0;
	  $rtqty = 0;
	  $rtval = 0;
	  $cnt = 0;
	  $itemaccount = "";
	  //Item Account
	  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'  ";
      $result2 = mysql_query($query2,$conn1);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	     $itemaccount = $row2['iac'];
	     $stdcost = $row2['stdcost'];
	  }
	 

	   $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Dr' and amount > 0 order by date,type ";
      $result2 = mysql_query($query2,$conn1);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	     $wtval = $wtval + $row2['amount']; 
      } 
	  // Cr Outwards
	    $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Cr' order by date,type ";
      $result2 = mysql_query($query2,$conn1);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $rtqty = $rtqty + $row2['quantity']; 
	     $rtval = $rtval + $row2['amount']; 
      } 
	 if ( $stdcost > 0)
	 {
	   $val = $stdcost;
	 }
	 else
	 {
	   if(($_SESSION['db'] == "golden") or ($_SESSION['db'] == "souza") or ($_SESSION['db'] == "maharashtra") or ($_SESSION['db'] == "suriya") or ($_SESSION['db'] == "trupti"))
	   {
	    $wtqty = $wtqty;
	    $wtval = $wtval;
	   }
	   else
	   {
	    $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	   }
	// echo $wtqty."/".$wtval."/".$itemcode;echo "</br>";
		
	   $val = round(($wtval/$wtqty),2);
	  // echo $itemcode."/".$val;
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
	  
	
	
	 
	  if ( $cnt == 0 AND $cnt1 == 0 AND $cnt2 == 0 AND $cnt3 == 0 AND $cnt4 == 0 AND $cnt5 == 0 AND $cnt6 == 0 AND $cnt7 == 0)
	  {
	   $val = $row1['stdcost'];
	  }
	  else
	  { 
	   $wtqty = $wtqty;
	    $wtval = $wtval;
	   $val = round(($wtval/$wtqty),4);
	  }	 
  }


return $val;
}

?>


