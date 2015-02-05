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
function calculate2($mode,$itemcode,$adate,$wh1)
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
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	     $itemaccount = $row2['iac'];
	     $stdcost = $row2['stdcost'];
	  }
	  $wh="";
	  $query3="SELECT sector,type FROM `tbl_sector` where type='$wh1'";
	  $result3=mysql_query($query3,$conn);
	  if($num>0)
	  {
	  while($rows3=mysql_fetch_assoc($result3))
	  {
		  $wh="'".$rows3['sector']."','".$rows3['type']."'";
		  }
	  }
	  else
	  {
		  $query3="SELECT sector,type FROM `tbl_sector` where sector='$wh1'";
		  $result3=mysql_query($query3,$conn);  
		  while($rows3=mysql_fetch_assoc($result3))
		  {
		  $wh="'".$rows3['sector']."','".$rows3['type']."'";
		  }
	  }
	  
	    $query2 = "SELECT sum(quantity) as quantity,sum(amount) as amount FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and warehouse in ($wh) and crdr= 'Dr' and amount > 0 order by date,type ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $row2['quantity']; 
	     $wtval = $row2['amount']; 
      } 
	  // Cr Outwards
	   
	    $query2 = "SELECT sum(quantity) as quantity,sum(amount) as amount FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and warehouse in ($wh) and crdr= 'Cr' and amount > 0 order by date,type ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $rtqty = $rtqty + $row2['quantity']; 
	     $rtval = $rtval + $row2['amount']; 
      } 
	 
	
	   if(($_SESSION['db'] == "golden") or ($_SESSION['db'] == "souza") or ($_SESSION['db'] == "sumukh") or ($_SESSION['db'] == "maharashtra") or ($_SESSION['db'] == "feedatives") or ($_SESSION['db'] == "suriya") or ($_SESSION['db'] == "mpc"))
	   { 
	    $wtqty = $wtqty;
	    $wtval = $wtval;
	   }
	   else
	   {
	    $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	   }
	  
			  
	if(round(($wtval/$wtqty),2) > 0)
	 $val = ($wtval/$wtqty);
	else
	 $val = $stdcost; 
  }
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
	return $val;
	}
function calculate($mode,$itemcode,$adate,$usqty)
{
  include "config.php";
		  if($_SESSION['db'] == "golden")
		  {
		  $query9 = "SELECT iac FROM ims_itemcodes WHERE code = '$itemcode'";
          $result9 = mysql_query($query9,$conn);
          while($row = mysql_fetch_assoc($result9))
			$iac = $row['iac'];

			$query = "SELECT round((amount/quantity),2) AS price FROM ac_financialpostings WHERE date <= '$adate' AND itemcode = '$itemcode' AND coacode = '$iac' AND crdr = 'Dr' ORDER BY date DESC,id DESC LIMIT 1";
			$result  = mysql_query($query,$conn) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);
			$amount = $rows['price'];
			//echo "$code/$amount<br>";
			return $amount;
		  }
  
  
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
	 
	  //Initial Stock
	 /*  $query2 = "SELECT * FROM ims_initialstock WHERE itemcode = '$itemcode'  ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $wtqty + $row2['quantity']; 
	   $wtval = $wtval + $row2['amount']; 
      }*/ 
	  //DR(Inwards)
	  
	    $query2 = "SELECT sum(quantity) as quantity,sum(amount) as amount FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount'  and date <= '$adate' and crdr= 'Dr' and amount > 0 order by date,type ";
      $result2 = mysql_query($query2,$conn);
	  $cnt2 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	      $rate= 0;
         $wtqty = $row2['quantity']; 
	     $wtval = $row2['amount']; 
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
	 
	
	   if(($_SESSION['db'] == "golden") or ($_SESSION['db'] == "souza") or ($_SESSION['db'] == "sumukh") or ($_SESSION['db'] == "maharashtra") or ($_SESSION['db'] == "feedatives") or ($_SESSION['db'] == "suriya") or ($_SESSION['db'] == "mpc"))
	   {
	    $wtqty = $wtqty;
	    $wtval = $wtval;
	   }
	   else
	   {
	    $wtqty = $wtqty - $rtqty;
	    $wtval = $wtval - $rtval;
	   }
	  
			  
	if(round(($wtval/$wtqty),2) > 0)
	 $val = round(($wtval/$wtqty),2);
	else
	 $val = $stdcost;
	/* echo "/".$wtqty."/".$wtval;
	 echo "<br/> val = $val <br/>";*/
	  //if($_SESSION['db'] == "golden"  )
	   //echo $itemcode."/".$val; echo "</br>";
	   
	 	 
  }




  if ( $mode == "Fifo" )
  {
     $totqty = 0;
	 $query2 = "SELECT * FROM ims_itemcodes WHERE code = '$itemcode'  ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	     $itemaccount = $row2['iac'];
	     $stdcost = $row2['stdcost'];
	  }
     $query2 = "SELECT sum(quantity) as totqty FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount' and crdr = 'Cr' and date <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totqty = $row2['totqty'];
	  }
	  $totinqty = 0;
	   $query2 = "SELECT sum(quantity) as totqty FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount' and crdr = 'Dr' and date <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  while($row2 = mysql_fetch_assoc($result2))
      {
	    $totinqty = $row2['totqty'];
	  }
	  if($totinqty > $totqty)
	  {
	  $purqty = 0;
	  $bal = 0;
	  $fifoval = 0;
	  $pkqty = $usqty;
      $dumqty = $pkqty;
	 $query2 = "SELECT * FROM ac_financialpostings WHERE itemcode = '$itemcode' and coacode = '$itemaccount' and date <='$adate' order by adate ";
      $result2 = mysql_query($query2,$conn);
	  $cnt = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	    if ( $dumqty > 0)
		{
		   if ( $totqty > $purqty )
		 {
		     $purqty = $purqty + $row2['quantity'];
			 if ( $purqty > $totqty )
			 {
			     $bal = $purqty  - $totqty;
				 if ( bal > $pkqty )
				 {
				    $fifoval = $fifoval + round((round(($row2['amount']/$row2['quantity']),4) * $dumqty),4);
					$dumqty = 0;
				 }
				 else
				 {
				   $fifoval = $fifoval + $row2['amount'];
				   $dumqty = $pkqty - $bal;
				 }
			 }
		 }
		 else
		 {
		    if ($row2['quantity'] > $dumqty )
			{
			   $fifoval = $fifoval + round((round(($row2['amount']/$row2['quantity']),4) * $dumqty),4);
			   $dumqty = 0;
			}
			else
			{
			    $fifoval = $fifoval + $row2['amount'];
			    $dumqty = $dumqty - $row2['quantity'];
			}		   
		 }
		}
	     
	  }
	  }
	  else 
	  {
	  $fifoval = 0;
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
  if($_SESSION['db'] == "golden")
  echo $mode."/".$itemcode."/".$val."<br>";
  //if($itemcode == "MED235")
  //echo $mode."/".$val;
return $val;
}



////////////beginning of calculate1 function////////////
function calculate1($mode,$itemcode,$adate,$warehouse)
{
  include "config.php";
		  if($_SESSION['db'] == "golden")
		  {
		  $query9 = "SELECT iac FROM ims_itemcodes WHERE code = '$code'";
          $result9 = mysql_query($query9,$conn);
          while($row = mysql_fetch_assoc($result9))
			$iac = $row['iac'];

			$query = "SELECT round((amount/quantity),2) AS price FROM ac_financialpostings WHERE date <= '$adate' AND itemcode = '$itemcode' AND coacode = '$iac' AND crdr = 'Dr' ORDER BY date DESC,id DESC LIMIT 1";
			$result  = mysql_query($query,$conn) or die(mysql_error());
			$rows = mysql_fetch_assoc($result);
			$amount = $rows['price'];
			//echo "$code/$amount<br>";
			return $amount;
		  }
  
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
	 /* $query2 = "SELECT * FROM oc_packslip WHERE itemcode = '$itemcode' and flag = '1' and adate <='$adate' ";
      $result2 = mysql_query($query2,$conn);
	  $cnt5 = mysql_num_rows($result2);
      while($row2 = mysql_fetch_assoc($result2))
      {
	     $rtqty = $rtqty + $row2['quantity'];
		 $rtval = $rtval + round(($row2['prodprice'] * $row2['quantity']),2); 
      } */
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
	 /* $query2 = "SELECT * FROM breeder_consumption WHERE itemcode = '$itemcode' and date2 <='$adate' ";
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
		
      } */
	 
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
