<?php
     include_once ('class.ezpdf.php');
	  $invoice = $_GET[id];
	  $tin = 33934244688;
     //ezpdf: from http://www.ros.co.nz/pdf/?
     //docs: http://www.ros.co.nz/pdf/readme.pdf
     //note: xy origin is at the bottom left

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

     $pdf->setLineStyle(0.5);
     $pdf->line(200,750,400,750);
     $pdf->setStrokeColor(0,0,0);
	
     $pdf->setLineStyle(0.5);
     $pdf->line(200,770,400,770);
     $pdf->setStrokeColor(0,0,0);
	 
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(400,770,400,750);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(200,770,200,750);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->addText(250,755,14,"<b>Purchase Order</b>");
	 
	 $pdf->addText(450,755,12,"PO #");
	 
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(490,750,580,750);
     $pdf->setStrokeColor(0,0,0);
	
     $pdf->setLineStyle(0.5);
     $pdf->line(490,770,580,770);
     $pdf->setStrokeColor(0,0,0);
	 
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(580,770,580,750);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(490,770,490,750);
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->addText(500,758,10,"<b>$invoice</b>");
	  
	   $pdf->addText(450,735,10,"Date");
	

     ///topmost horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,730,600,730);
     $pdf->setStrokeColor(0,0,0);


     /////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,730,20,20);
     $pdf->setStrokeColor(0,0,0);


     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,730,600,20);
     $pdf->setStrokeColor(0,0,0);
 
     $pdf->setLineStyle(0.5);
     $pdf->line(350,710,600,710);
     $pdf->setStrokeColor(0,0,0);


     $pdf->setLineStyle(0.5);
     $pdf->line(350,710,350,730);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->addText(355,712,12,"<b>TIN :  $tin</b>");
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,650,600,650);
     $pdf->setStrokeColor(0,0,0);

     /////for the horizontal line after po date
     $pdf->setLineStyle(0.5);
     $pdf->line(20,620,600,620);
     $pdf->setStrokeColor(0,0,0);
	 
	
     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     
	   
     $pdf->addText(260,630,10,"QUANTITY");
     $pdf->addText(360,630,10,"RATE");
	 
     $pdf->addText(30,600,10,"SL No."); 
     $pdf->addText(70,600,10,"PARTICULARS/ITEM");  
	 $pdf->addText(210,600,10,"MAKE");  
     $pdf->addText(260,600,10,"KGS/LTR/MT");
     $pdf->addText(340,600,10,"KGS/LTR/MT");
     $pdf->addText(425,600,10,"AMOUNT");
     $pdf->addText(510,600,10,"EX/FOR");

     include "configinvoice.php";
    
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

$query = "SELECT * FROM contactdetails WHERE  name  = '$party'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $partyaddr = $row['address'];
}


$pdf->addText(500,735,10,"$date1");

$totqty = 0;
$totbags = 0;
$totala = 0; $totalquant = 0;
$query = "SELECT sum(quantity) as totqty,sum(basic) as total, tandc, credittermdescription FROM pp_purchaseorder WHERE  po = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $totqty = $row['totqty'];
  $total = $row['total'];
  $tandc = $row['tandc'];
  $cterm = $row['credittermdescription'];
}


     $pdf->addText(30,718,10,"<b>$party</b>");
	  $pdf->addText(30,705,10,"<b>$partyaddr</b>");
     
	 		
              $pdf->addText(345,555,10,"Include Tax");
             $pdf->addText(510,555,10,"Include Frieght");

     $ik = 540; $tax=$discount=0;$i=0;
     include "config.php";
     $querya = "SELECT * FROM pp_purchaseorder WHERE po = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {$i++;
             $description = $rowa['description'];
             $quantity = $rowa['quantity'];
             $units = $rowa['unit'];
             $price = changeprice($rowa['rateperunit']);
             $amount = round(($rowa['quantity'] * $rowa['rateperunit']),2);  
             $totalquant = $totalquant + $quantity;
             $totala = $totala + $amount;
             $amount1 = changeprice($amount);
             $ddate = $rowa['deliverydate'];
             $ddate = date("d.m.Y", strtotime($ddate));
             $dlocation = $rowa['deliverylocation'];
			 $tax += $rowa['taxamount'];
			 $discount += $rowa['discountamount'];
			 
			 
			
			 $pdf->addText(35,$ik,10,"<b>$i</b>");
             $pdf->addText(75,$ik,10,"<b>$description</b>");
			 
			 $qty = changeprice($quantity);
	$width = $pdf->getTextWidth(10,$qty);		
	$pdf->addText((310-$width),$ik,10,"<b>$qty</b>");	
			 
			 
            
			  $pdf->addText(312,$ik,10,"<b>$units</b>");
			  
			
	$width = $pdf->getTextWidth(10,$price);		
	$pdf->addText((415-$width),$ik,10,"<b>$price</b>");
	

	$width = $pdf->getTextWidth(10,$amount1);		
	$pdf->addText((500-$width),$ik,10,"<b>$amount1</b>");
			  
           


             $ik = $ik - 20;
     }
	
	 
	 
	 $pdf->addText(211,$ik,10,"VAT/CST");
	 $tax = changeprice($tax);
	 $width = $pdf->getTextWidth(10,$tax);		
	$pdf->addText((500-$width),$ik,10,"<b>$tax</b>");
	 
	  $ik = $ik - 20;
	 $pdf->addText(211,$ik,10,"Discount");
	 $discount = changeprice($discount);
	$width = $pdf->getTextWidth(10,$discount);		
	$pdf->addText((500-$width),$ik,10,"<b>$discount</b>");
	 
	  $ijk = $ik -3;
	 ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$ijk,600,$ijk);
     $pdf->setStrokeColor(0,0,0);
	 
	  $totalamount = $totala + $tax - $discount;
     $pdf->addText(211,$ijk-18,10,"<b>Total</b>");
	 
	 $total1 = changeprice($totalamount);	 
	 $totqty = changeprice($totalquant);
	$width = $pdf->getTextWidth(10,$totqty);		
	$pdf->addText((310-$width),$ijk-18,10,"<b>$totqty</b>");
	 
	  
	 $width = $pdf->getTextWidth(10,$total1);		
	$pdf->addText((500-$width),$ijk-18,10,"<b>$total1</b>");
     $word = convert_number($totalamount);
     $ijk = $ijk -25;
	 
	  ///vertical line after sl no
     $pdf->setLineStyle(0.5);
     $pdf->line(65,620,65,$ijk);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after item name
     $pdf->setLineStyle(0.5);
     $pdf->line(205,650,205,$ijk);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after quantity
     $pdf->setLineStyle(0.5);
     $pdf->line(335,650,335,$ijk);
     $pdf->setStrokeColor(0,0,0);

    ///vertical line after price
     $pdf->setLineStyle(0.5);
     $pdf->line(420,620,420,$ijk);
     $pdf->setStrokeColor(0,0,0);
	 
	 
     ////bottom horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$ijk,600,$ijk);
     $pdf->setStrokeColor(0,0,0);
	 
	
	 
	$ijk = $ijk -23;
     $pdf->addText(30,$ijk,10,"<b>(Rupees )</b>");
     
     $pdf->addText(110,$ijk,10,"<b>$word Only</b>");
	 
	 $ijk = $ijk -20;
	 $pdf->addText(25,$ijk,10,"<b>Payment Terms : $cterm</b>");
	  $ijk = $ijk -20;
	  $pdf->addText(25,$ijk,10,"<b>Delivery Schedule : $ddate to $dlocation</b>");
	   $ijk = $ijk -30;
	   $pdf->addText(25,$ijk,10,"<b>ORDERED BY :</b>");
	   $pdf->addText(225,$ijk,10,"<b>APPROVED BY :</b>");
	   $pdf->addText(425,$ijk,10,"<b>SUPPLIER :</b>");
	  $ijk = $ijk -12; 
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$ijk,600,$ijk);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,20,600,20);
     $pdf->setStrokeColor(0,0,0);
	 
	 $ijk = $ijk -10;
    $pdf->addText(25,$ijk,10,"<b>Terms & Conditions</b>");
	
$t  = explode(',',$tandc);
$siz = sizeOf($t); 
$kk= $ijk-20;
$l = 1;

for($k=0;$k<$siz;$k++)
{
    $pdf->addText(25,$kk,10,"<b>$l.$t[$k].</b>");
    $kk = $kk - 20;
    $l = $l + 1;
}


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

