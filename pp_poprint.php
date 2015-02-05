<?php
     include_once ('class.ezpdf.php');
     //ezpdf: from http://www.ros.co.nz/pdf/?
     //docs: http://www.ros.co.nz/pdf/readme.pdf
     //note: xy origin is at the bottom left
include "configinvoice.php";
     //data
     $colw = array(      80 ,    40,   220,    80,     40  );//column widths
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


     //x is 0-600, y is 0-780 (origin is at bottom left corner)
     $pdf =& new Cezpdf('LETTER');


     ///topmost horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,600,770);
     $pdf->setStrokeColor(0,0,0);


     /////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,400);
     $pdf->setStrokeColor(0,0,0);


     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,400);
     $pdf->setStrokeColor(0,0,0);


     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,425,600,425);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,400,600,400);
     $pdf->setStrokeColor(0,0,0);


     /////for the horizontal line after the company address
     $pdf->setLineStyle(0.5);
     $pdf->line(20,670,600,670);
     $pdf->setStrokeColor(0,0,0);

      /////for the horizontal line after po date
     $pdf->setLineStyle(0.5);
     $pdf->line(20,620,600,620);
     $pdf->setStrokeColor(0,0,0);

     /////for the horizontal line after itemname
     $pdf->setLineStyle(0.5);
     $pdf->line(20,580,600,580);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after item name
     $pdf->setLineStyle(0.5);
     $pdf->line(150,620,150,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after units
     $pdf->setLineStyle(0.5);
     $pdf->line(210,620,210,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after quantity
     $pdf->setLineStyle(0.5);
     $pdf->line(265,620,265,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after price
     $pdf->setLineStyle(0.5);
     $pdf->line(320,620,320,400);
     $pdf->setStrokeColor(0,0,0);
	 
	  ///vertical line after discount
     $pdf->setLineStyle(0.5);
     $pdf->line(375,620,375,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after amount
     $pdf->setLineStyle(0.5);
     $pdf->line(435,620,435,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after delivery date
     $pdf->setLineStyle(0.5);
     $pdf->line(500,620,500,400);
     $pdf->setStrokeColor(0,0,0);

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(30,650,10,"Supplier Name :");
	  
     $pdf->addText(30,630,10,"PO # :");     
     $pdf->addText(445,630,10,"Date :");   
  
     $pdf->addText(30,600,10,"Item Name"); 
	
	
	 	$pdf->addText(170,600,10,"Units");
     $pdf->addText(215,600,10,"Quantity");
     $pdf->addText(274,600,10,"Price/");
	 $pdf->addText(274,590,10,"Unit");
	 $pdf->addText(325,600,10,"Discount");
	 
     $pdf->addText(380,600,10,"Amount");
     $pdf->addText(445,600,10,"Delivery");
     $pdf->addText(445,590,10,"  Date");
     $pdf->addText(515,600,10,"Delivery");
     $pdf->addText(515,590,10,"Location");

     
     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$query = "SELECT * FROM pp_purchaseorder WHERE  po = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['vendor'];
  $date1 = $row['date'];
  $date1 = date("d.m.Y", strtotime($date1));
  $ware = $row['deliverylocation'];
  $broker = $row['broker'];
}
$totqty = 0;
$totbags = 0;
$totala = 0; $totalquant = 0;
$query = "SELECT sum(quantity) as totqty,sum(basic) as total, tandc FROM pp_purchaseorder WHERE  po = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $totqty = $row['totqty'];
  $total = $row['total'];
  $tandc = $row['tandc'];
}
$query = "SELECT * FROM home_logo "; 
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address']; }
$address1 = html_entity_decode($address);


$temp = explode('</p>',$address1);
for($i = 0,$j = 770;$i < count($temp); $i++)
{
 $temp2 = preg_replace("/<[^\>]+\>/","",$temp[$i]);
 $width = $pdf->getTextWidth(10,$temp2);
  for($k = $width;$k>0;$k-=250)
  {
   $j-=13;  
   $temp2=$pdf->addTextWrap(25,$j,550,10,"<b>$temp2</b>","center");
  }
}



     $pdf->addText(110,650,10,"<b>$party</b>");

     $pdf->addText(60,630,10,"<b>$invoice</b>");
     $pdf->addText(470,630,10,"<b>$date1</b>");

     $ik = 560; $tax=$discount=0;
     include "config.php";
     $querya = "SELECT * FROM pp_purchaseorder WHERE po = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
             $quantity = $rowa['quantity'];
             $units = $rowa['unit'];
             $price = changeprice($rowa['rateperunit']);
             $amount = round(($rowa['quantity'] * $rowa['rateperunit']),2);  
			 $discount1 = changeprice($rowa['discountamount']);
             $totalquant = $totalquant + $quantity;
             $totala = $totala + $amount;
             $amount1 = changeprice($amount);
             $ddate = $rowa['deliverydate'];
             $ddate = date("d.m.Y", strtotime($ddate));
             $dlocation = $rowa['deliverylocation'];
			// $tax += $rowa['taxamount'];
			 $discount += $rowa['discountamount'];
			 $brokerage += $rowa['brokerageamount'];

             $pdf->addText(25,$ik,10,"<b>$description</b>");
             $pdf->addText(155,$ik,10,"<b>$units</b>");
             $pdf->addText(215,$ik,10,"<b>$quantity</b>");
             $pdf->addText(270,$ik,10,$price);
			 $pdf->addText(330,$ik,10,$discount1);
             $pdf->addText(375,$ik,10,$amount1);
             $pdf->addText(440,$ik,10,"<b>$ddate</b>");
             $pdf->addText(502,$ik,10,"<b>$dlocation</b>");

             $ik = $ik - 20;
     }
	 

	 $totalamount = $totala + $tax - $discount;
     $pdf->addText(100,410,10,"<b>Total</b>");
     $pdf->addText(30,380,10,"<b>Total in words :</b>");
     $total1 = changeprice($totalamount);
     $pdf->addText(220,410,10,"<b>$totalquant</b>");
	 $pdf->addText(340,410,10,"<b>$discount</b>");
     $pdf->addText(375,410,10,"<b>$total1</b>");
     $word = convert_number($totalamount);
     $pdf->addText(110,380,10,"<b>$word Only</b>");


    $pdf->addText(25,350,10,"<b>Terms & Conditions</b>");
$t  = explode(',',$tandc);
$siz = sizeOf($t); 
$kk= 320;
$l = 1;

for($k=0;$k<$siz;$k++)
{
    $pdf->addText(25,$kk,10,"<b>$l.$t[$k].</b>");
    $kk = $kk - 20;
    $l = $l + 1;
}

$kk = $kk - 60;
$kkk = $kk - 20;
$pdf->addText(25,$kk,10,"<b>__________________________</b>");
$pdf->addText(55,$kkk,10,"<b>Prepared By</b>");
$pdf->addText(425,$kk,10,"<b>__________________________</b>");
$pdf->addText(445,$kkk,10,"<b>Approved By</b>");
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
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
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
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

?>

