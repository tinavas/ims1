<?php
session_start();
$currencyunits=$_SESSION[currency];
include "config.php"; 

$query2 = "SELECT * FROM ac_coa WHERE description = 'Vendor Contra Account'";
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
if($_SESSION[db]=="singhsatrang")
{
function changeprice($num){
$flag=0;
if($num<0)
{
$flag=1;
}
$num=ltrim($num,'-');
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00000";}
else { $decimalpart= substr($num, $pos+1, 5); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=5){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 5);
}

if(substr($stringtoreturn,0,5)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,5 );}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 5) { $c = "0"; }
$stringtoreturn = $stringtoreturn.$c;
if($flag==0)
return $stringtoreturn;
else
return "-".$stringtoreturn;
}
}
else
{
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
		
  
  if ( $mode == "Standard Costing")
  {
      $query2 = "SELECT stdcost FROM ims_standardcosts WHERE code = '$itemcode' and '$adate' between fromdate and todate ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      if($row2 = mysql_fetch_assoc($result2))
	      $val = $row2['stdcost'];
	  if ( $cnt2 == 0)
	  {
	     $query2 = "SELECT stdcost FROM ims_itemcodes WHERE code = '$itemcode' ";
         $result2 = mysql_query($query2,$conn);
	     //$cnt2 = mysql_num_rows($result2);
         if($row2 = mysql_fetch_assoc($result2))         
	         $val = $row2['stdcost'];          
	  }

  }
  if ( $mode == "Weighted Average")
  {  $wtqty = 0; 
      $wtval = 0;
	  $rtqty = 0;
	  $rtval = 0;
	  $cnt = 0;
	  $itemaccount = "";
	  //Item Account
	  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'  ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	     $itemaccount = $row2['iac'];
	     $stdcost = $row2['stdcost'];
	  }
	 
	  
	  
	  
	     $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Dr' and amount > 0 order by date,type ";
		
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	     $wtval = $wtval + $row2['amount']; 
      } 
	  // Cr Outwards
	 
	    $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Cr' order by date,type ";
		
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $rtqty = $rtqty + $row2['quantity']; 
	     $rtval = $rtval + $row2['amount']; 
      } 
	
	
	  
	    $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	 
			  
	if(round(($wtval/$wtqty),2) > 0)
	 $val = round(($wtval/$wtqty),2);
	else
	 $val = $stdcost;
	 
	  //if($_SESSION['db'] == "golden"  )
	   //echo $itemcode."/".$val; echo "</br>";
	   
	 	 
  }

//if($itemcode == "MED235")
  //echo $mode."/".$val;
return $val;
}



////////////beginning of calculate1 function////////////
function calculate1($mode,$itemcode,$adate,$warehouse)
{
  
  
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
/////////////end of function calculate1/////////////
?>

<?php

//starting of new calculate function

function calculatenew($warehouse,$mode,$itemcode,$adate)
{
  include "config.php";
		
  
  if ( $mode == "Standard Costing")
  {
      $query2 = "SELECT stdcost FROM ims_standardcosts WHERE code = '$itemcode' and '$adate' between fromdate and todate ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      if($row2 = mysql_fetch_assoc($result2))
	      $val = $row2['stdcost'];
	  if ( $cnt2 == 0)
	  {
	     $query2 = "SELECT stdcost FROM ims_itemcodes WHERE code = '$itemcode' ";
         $result2 = mysql_query($query2,$conn);
	     //$cnt2 = mysql_num_rows($result2);
         if($row2 = mysql_fetch_assoc($result2))         
	         $val = $row2['stdcost'];          
	  }

  }
  if ( $mode == "Weighted Average")
  {  $wtqty = 0; 
      $wtval = 0;
	  $rtqty = 0;
	  $rtval = 0;
	  $cnt = 0;
	  $itemaccount = "";
	  //Item Account
	  $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'  ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	     $itemaccount = $row2['iac'];
	     $stdcost = $row2['stdcost'];
	  }
	 
	  
	  
	  
	   $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Dr' and  warehouse='$warehouse' order by date,type ";
		
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	     $wtval = $wtval + $row2['amount']; 
      } 
	  // Cr Outwards
	 
	    $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date < '$adate' and crdr= 'Cr' and warehouse='$warehouse' order by date,type ";
		
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $rtqty = $rtqty + $row2['quantity']; 
	     $rtval = $rtval + $row2['amount']; 
      } 
	
	//echo  $wtqty ."/".$rtqty;
	  //  echo  $wtval ."/". $rtval;
	  
	    $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	 
			  
	if(round(($wtval/$wtqty),5) > 0)
	 $val = round(($wtval/$wtqty),5);
	else
	 $val = $stdcost;
	 
	  //if($_SESSION['db'] == "golden"  )
	   echo $itemcode."/".$wtval/$wtqty; echo "</br>";
 
	 	 
  }

//if($itemcode == "MED235")
  //echo $mode."/".$val;
return $val;
}


//Ending of new calculate function
?>

<script type="text/javascript">
var decimalpart;
function makecomma(input)
{
 input = Number(input);
 if(input < 100)
  return input;
 var length = Math.floor(input/100);
 var formatted_input = makecomma(length) + "," + String(input).substr((String(input).length-2));
 return formatted_input;
}

function changeprice(num)
{
var pos = String(num).lastIndexOf('.');
if(pos == -1)
{
 decimalpart = "00";
 num = String(num);
}
else
{
 decimalpart = String(num).substr(pos+1,2);
 num = String(num).substr(0,pos);
}
if(num.length > 3)
{
 var last3digits = num.substr(num.length-3);
 var numexceptlastdigits = Math.floor(Number(num)/1000);
 var formatted = makecomma(numexceptlastdigits);
 var stringtoreturn = formatted + "," + last3digits + "." + String(decimalpart);
}
else if(num.length <= 3)
 var stringtoreturn = String(num) + "." + String(decimalpart);
return stringtoreturn;
}

</script>
