<?php
     session_start();
     include_once ('class.ezpdf.php');
     $colw = array(      80 ,    40,   220,    80,     40  );
     $rows = array(
         array('company','size','desc','cost','instock'),
         array("WD", "80GB","WD800AAJS SATA2 7200rpm 8mb"        ,"$36.90","Y"),
         array("WD","160GB","WD1600AAJS SATA300 8mb 7200rpm"     ,"$39.87","Y"),
         array("WD", "80GB","800jd SATA2 7200rpm 8mb"            ,"$41.90","Y"),
         array("WD","250GB","WD2500AAKS SATA300 16mb 7200rpm"    ,"$49.88","Y"),
         array("WD","320GB","WD3200AAKS SATA300 16mb 7200rpm"    ,"$49.90","Y"),
         array("WD","160GB","1600YS SATA raid 16mb 7200rpm"      ,"$59.90","Y"),
         array("WD","500GB","500gb WD5000AAKS SATA2 16mb 7200rpm","$64.90","Y"),
         array("WD","250GB","2500ys SATA raid 7200rpm 16mb"      ,"$69.90","Y"),
     );


     $pdf =& new Cezpdf('LETTER');

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     
	 $t = 1;
	 $tandc = "";
	 include "configinvoice.php";
	 
     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$discount = 0;
$query = "SELECT * FROM oc_cobi WHERE  invoice = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['party'];
  $date1 = $row['date'];
  $date1 = date("d.m.y", strtotime($date1));
  $freight = $row['freightamount'];
  $vehnum = $row['vno'];
  $discount = $row['discountamount'];
  $finaltotal = $finaltotal + ($row['finaltotal']);
  $destination = $row['destination'];
  $bookinvoice = $row['bookinvoice'];
  $narration = $row['remarks'];
}
if($bookinvoice == "")
 $bookinvoice = "NA";
$totqty = 0;
$totbags = 0;
$totala = 0;
$query = "SELECT sum(quantity) as totqty,sum(finaltotal) as total FROM oc_cobi WHERE  invoice = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $totqty = $row['totqty'];
  $total = $row['total'];
}
$q1 = "SELECT * FROM contactdetails WHERE name = '$party'";
$r1 = mysql_query($q1,$conn);
$rows = mysql_fetch_assoc($r1);
$addr = $rows['address'];

    if($discount)
    {

    $discount= changeprice($discount);
	 $pdf->addTextWrap(506,162,100,10,"<b>$discount</b>",'right');
    } 
 include "config.php"; 


     $pdf->addText(75,700,14,"<b>$party</b>");
	 $pdf->addText(1,1,14,".");
     $pdf->addText(55,730,9,"<b>$invoice</b>");
     $pdf->addText(485,730,14,"<b>$date1</b>");
   
     $ik = 630;
     include "config.php";
     $querya = "SELECT * FROM oc_cobi WHERE invoice = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
			 $itemcode = $rowa['code'];
			 $q = "select cat from ims_itemcodes where code = '$itemcode'";
			 $r = mysql_query($q,$conn) or die(mysql_error());
			 $rows = mysql_fetch_assoc($r);
			 $cat = $rows['cat'];
			 if($cat == 'Female Birds' or $cat == 'Male Birds')
			  $bags = $rowa['weight'];
			 else
             $bags = $rowa['quantity']; 
             $units = $rowa['units'];
             $tbags = $tbags + $rowa['quantity'];
             $price = $rowa['price'];
             $amount = $rowa['total'];  
             $totala = $rowa['finaltotal'];
             $amount1 = changeprice($bags * $price);
			 $tot+=($bags * $price);
             $temp = $rowa['weight'];
             if($rowa['weight']) { $units = "Kgs"; }
			$quantity1= changeprice1(round($bags,2));
             $pdf->addText(150,$ik,10,"<b>$description</b>");
			$price1=changeprice($price);
			$pdf->addTextWrap(340,$ik,100,10,"$quantity1",'right');
			$pdf->addTextWrap(414,$ik,100,10,"$price1",'right');
			$pdf->addTextWrap(504,$ik,100,10,"$amount1",'right');
             if($rowa['weight'] && ($rowa['age'])) {
               $ik = $ik - 13;
               $pdf->addText(283,$ik,8,"<b>( $temp Birds )</b>");
             }
			 if($cat == 'Female Birds' or $cat == 'Male Birds' && $_SESSION['db'] == "golden")
			 {
			   $temp = $rowa['quantity'];
               $ik = $ik - 13;
               $pdf->addText(283,$ik,8,"<b>( $temp Birds )</b>");
			 }
             $ik = $ik - 20;
     }

     $tbags = changeprice($tbags);
     $total1 = changeprice($totala);
	 $tot=changeprice($tot);
	 $pdf->addTextWrap(506,190,100,10,"<b>$tot</b>",'right');
     $pdf->addTextWrap(506,135,100,10,"<b>$total1</b>",'right');
     $word = convert_number($totala);
     $pdf->addText(65,135,10,"<b>$word Only</b>");
     $pdf->ezStream(); 

//-----------------------------------------------------------------------------

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


function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 100000);  /* Millions (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
       if($Gn > 1)
        $res .= convert_number($Gn) . " Lakhs"; 
       else 
        $res .= convert_number($Gn) . " Lakh"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 


$cheque_amt = 8747484 ; 
try
    {
    echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }

function makecomma($input)
{
if(strlen($input)<=3)
{ return $input; }
$length=substr($input,0,strlen($input)-3);
$formatted_input = makecomma($length).",".substr($input,-3);
return $formatted_input;
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

