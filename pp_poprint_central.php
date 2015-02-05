<?php
     include_once ('class.ezpdf.php');
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
     $pdf->line(200,620,200,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after quantity
     $pdf->setLineStyle(0.5);
     $pdf->line(265,620,265,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after units
     $pdf->setLineStyle(0.5);
     $pdf->line(315,620,315,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after price
     $pdf->setLineStyle(0.5);
     $pdf->line(375,620,375,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after amount
     $pdf->setLineStyle(0.5);
     $pdf->line(450,620,450,400);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after delivery date
     $pdf->setLineStyle(0.5);
     $pdf->line(510,620,510,400);
     $pdf->setStrokeColor(0,0,0);

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(30,650,10,"Supplier Name :");
	 $pdf->addText(30,630,10,"Broker Name   :");   
     $pdf->addText(380,650,10,"PO # :");     
     $pdf->addText(380,630,10,"Date :");   
  
     $pdf->addText(30,600,10,"Item Name");     
     $pdf->addText(210,600,10,"Quantity");
     $pdf->addText(275,600,10,"Units");
     $pdf->addText(320,600,10,"Price/Unit");
     $pdf->addText(385,600,10,"Amount");
     $pdf->addText(460,600,10,"Delivery");
     $pdf->addText(460,590,10,"  Date");
     $pdf->addText(520,600,10,"Delivery");
     $pdf->addText(520,590,10,"Location");

     include "configinvoice.php";
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
$query = "select currencyflag,currency from contactdetails where name = '$party' and type like '%vendor%'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$cflag = $rows['currencyflag'];
$currency = $rows['currency'];
$display = "(in ".$currency.")";
if($cflag == 0)
{
 $q = "select bcurrency from bccurrency";
 $r = mysql_query($q,$conn) or die(mysql_error());
 $rr = mysql_fetch_assoc($r);
 $bcurrency = $rr['bcurrency'];
 $display = "(in ".$bcurrency.")";
}
$pdf->addText(385,590,10,$display);

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

	if($_SESSION['db'] == 'feedatives')
	{
	  $pdf->addText(230,755,14,"<b>Feedatives Pharma Pvt. Ltd.</b>");
       $pdf->addText(265,740,10,"46. Chanditolla Street,");
       $pdf->addText(250,727,10,"UTTARPARA - 712 258. W.R.");
       $pdf->addText(262,712,10,"VAT NO: 19733499096");
	
	}
    else if($_SESSION['db'] == "souza") {
       $pdf->addText(250,755,14,"<b>Souza Hatcheries</b>");
       $pdf->addText(245,740,10,"Souza Commercial Complex,");
       $pdf->addText(255,727,10,"Highlands,Falnir Road,");
       $pdf->addText(260,712,10,"Mangalore - 575002.");
       $pdf->addText(260,697,10,"TIN : 29640098794");
     }
	 else if($_SESSION['db'] == "golden")
	 {
	   $pdf->addText(250,755,14,"<b>GOLDEN GROUP</b>");
       $pdf->addText(250,740,10,"No.3,Queen's Road Cross,");
       $pdf->addText(235,727,10,"Near Congress Committee Office,");
       $pdf->addText(260,712,10,"Bangalore - 560052.");
       
	 }
	 else if($_SESSION['db'] == "skdnew")
	 {
	  $pdf->addText(250,755,14,"<b>SKD CONSULTANTS</b>");
       $pdf->addText(290,740,10,"NASHIK");
	 }
	 else if($_SESSION['db'] == "central")
	 {
	  $pdf->addText(220,755,14,"<b>CENTRAL POULTRY 2000 LTD.</b>");
       $pdf->addText(290,740,10,"MALAWI");
	 }
	 

     $pdf->addText(110,650,10,"<b>$party</b>");
	  $pdf->addText(110,630,10,"<b>$broker</b>");
     $pdf->addText(430,650,10,"<b>$invoice</b>");
     $pdf->addText(430,630,10,"<b>$date1</b>");

     $ik = 560; $tax=$discount=0;
     include "config.php";
     $querya = "SELECT * FROM pp_purchaseorder WHERE po = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
             $quantity = $rowa['quantity'];
             $units = $rowa['unit'];
			 $conversion = $rowa['camount'];
             $price = changeprice($rowa['rateperunit'] / $conversion);
             $amount = round(($rowa['quantity'] * $rowa['rateperunit'] / $conversion),2);  
             $totalquant = $totalquant + $quantity;
             $totala = $totala + $amount;
             $amount1 = changeprice($amount);
             $ddate = $rowa['deliverydate'];
             $ddate = date("d.m.Y", strtotime($ddate));
             $dlocation = $rowa['deliverylocation'];
			 $tax += ($rowa['taxamount'] / $conversion);
			 $discount += ($rowa['discountamount'] / $conversion);

             $pdf->addText(25,$ik,10,"<b>$description</b>");
             $pdf->addText(210,$ik,10,"<b>$quantity</b>");
             $pdf->addText(270,$ik,10,"<b>$units</b>");
             $pdf->addText(320,$ik,10,$price);
             $pdf->addText(385,$ik,10,$amount1);
             $pdf->addText(455,$ik,10,"<b>$ddate</b>");
             $pdf->addText(517,$ik,10,"<b>$dlocation</b>");

             $ik = $ik - 20;
     }
	 $pdf->addText(100,445,10,"VAT / CST");
	 $pdf->addText(100,430,10,"Discount");
	 $pdf->addText(395,445,10,changeprice($tax));
	 $pdf->addText(395,430,10,changeprice($discount));
	 $totalamount = $totala + $tax - $discount;
     $pdf->addText(100,410,10,"<b>Total</b>");
     $pdf->addText(30,380,10,"<b>Total in words $display :</b>");
     $total1 = changeprice($totalamount);
     $pdf->addText(210,410,10,"<b>$totalquant</b>");
     $pdf->addText(385,410,10,"<b>$total1</b>");
     $word = convert_number($totalamount);
     $pdf->addText(150,380,10,"<b>$word Only</b>");


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
$pdf->addText(55,$kkk,10,"<b>Accepted By</b>");
$pdf->addText(425,$kk,10,"<b>__________________________</b>");
$pdf->addText(445,$kkk,10,"<b>Authorized Signature</b>");
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

