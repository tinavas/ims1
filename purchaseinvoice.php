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

     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,580,770);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(580,770,580,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,20,580,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,770,270,530);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(425,770,425,530);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,730,580,730);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,690,580,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(270,650,580,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(270,610,580,610);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(270,570,580,570);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,650,580,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,650,270,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,690,270,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,615,580,615);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,530,270,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(350,530,350,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(425,530,425,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(500,530,500,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     //$pdf->line(20,185,580,185);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,155,580,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,105,580,105);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(300,105,300,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(25,675,10,"Consignee");
     $pdf->addText(275,757,10,"Document No.");
     $pdf->addText(430,757,10,"Dated");
     $pdf->addText(275,717,10,"Delivery Note");
	 $pdf->addText(220,775,12,"<b>GOODS RECEIPT CHALLAN</b>");
     //$pdf->addText(430,717,10,"Mode/Terms of Payment");
     //$pdf->addText(275,677,10,"Supplier's Ref.");
     //$pdf->addText(430,677,10,"Other Reference(s)");
     //$pdf->addText(275,637,10,"Buyer's Order No.");
     //$pdf->addText(430,637,10,"Dated");
     //$pdf->addText(275,597,10,"Despatch Document No.");
     //$pdf->addText(430,597,10,"Dated");
     //$pdf->addText(275,557,10,"Despatched through");
     $pdf->addText(430,677,10,"Destination");



     $pdf->addText(100,627,10,"Description of Goods");
     $pdf->addText(307,627,10,"Quantity Received");
     //$pdf->addText(375,515,10,"Rate");
     $pdf->addText(485,627,10,"Units");
     //$pdf->addText(520,515,10,"Amount");
     //$pdf->addText(240,165,10,"Total");
     $pdf->addText(25,140,10,"Total Quantity Received (in words)");
     $pdf->addText(535,140,10,"E. & O.E.");
     if($_SESSION['db'] == "souza") { $pdf->addText(478,70,10,"for Souza Hatcheries"); }
	 
     $pdf->addText(480,30,10,"Authorised Signatory");
     $pdf->addText(25,87,8,"<b>Terms & Conditions</b>");
	 
	 $pdf->addText(25,77,7,"Our Responsibilites Ceases on delivery of Goods");
     $pdf->addText(25,67,7,"To the Carrier");
     $pdf->addText(25,57,7,"W.B.S TAX NO.: 19511817042");
     $pdf->addText(25,47,7,"C.S TAX NO.: 19511817042");
     $pdf->addText(25,37,7,"VAT NO.: 19511817042");
	 $pdf->addText(25,27,7,"D.L.NO. 11700 SW & 11512 SBW");

     include "configinvoice.php";
     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$discount = 0;
$query = "SELECT * FROM pp_sobi WHERE  so = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['vendor'];
  $date1 = $row['date'];
  $date1 = date("d.m.Y", strtotime($date1));
  $freight = $row['freightamount'];
  $vehnum = $row['vno'];
  $discount = $row['discountamount'];
  $finaltotal = $finaltotal + ($row['finaltotal']);
  $destination = $row['destination'];
}
$totqty = 0;
$totbags = 0;
$totala = 0;
$query = "SELECT sum(receivedquantity) as totqty,itemunits as total FROM pp_sobi WHERE  so = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $total=$totqty = $row['totqty'];
  //$total = $row['itemunits'];
}
$for = "for ".$party;
if($_SESSION['db'] == "feedatives") { $pdf->addText(410,75,10,$for); }

    /*if($discount)
    {

     $pdf->setLineStyle(0.5);
     $pdf->line(20,215,580,215);
     $pdf->setStrokeColor(0,0,0);

     //$pdf->addText(223,195,10,"Discount");
     //$pdf->addText(520,195,10,"<b>$discount</b>");
    } */
 include "config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}
$address1 = html_entity_decode($address);

     if($_SESSION['db'] == "souza") {
       $pdf->addText(25,755,10,"<b>Souza Hatcheries.</b>");
       $pdf->addText(25,740,10,"Souza Commercial Complex,");
       $pdf->addText(25,727,10,"Highlands,Falnir Road,");
       $pdf->addText(25,712,10,"Mangalore - 575002");
       $pdf->addText(25,697,10,"TIN : 29640098794");
     }
	 else if($_SESSION['db'] == "golden")
	 {
	   $pdf->addText(25,755,10,"<b>Golden Group.</b>");
       $pdf->addText(25,740,10,"No.3,Queen's Road Cross,");
       $pdf->addText(25,727,10,"Near Congress Committee Office,");
       $pdf->addText(25,712,10,"Bangalore - 560052");
       
	 }
	 else if($_SESSION['db'] == "skdnew")
	 {
	  $pdf->addText(25,755,10,"<b>SKD Consultants</b>");
       $pdf->addText(25,740,10,"Nashik");
	 }
	 else if($_SESSION['db'] == "feedatives")
	 {
	  $pdf->addText(25,755,10,"<b>FEEDATIVES PHARMA PVT.LTD.</b>");
       $pdf->addText(25,740,10,"46. CHANDITOLLA STREET,");
       $pdf->addText(25,727,10,"UTTARPARA - 712 258.");
       $pdf->addText(25,712,10,"HOOGHLY");
	 }
     $pdf->addText(25,657,10,"<b>$party</b>");
     $pdf->addText(275,740,10,"<b>$invoice</b>");
     $pdf->addText(430,740,10,"<b>$date1</b>");
     $pdf->addText(430,540,10,"<b>$destination</b>");

     $ik = 590;
     include "config.php";
     $querya = "SELECT * FROM pp_sobi WHERE so = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
 
             $bags = changeprice($rowa['receivedquantity']); 
             $units = $rowa['itemunits'];
             $tbags = $tbags + $rowa['receivedquantity'];
             $price = changeprice($rowa['price']);
             //$amount = $rowa['total'];  
             $totala += $rowa['receivedquantity'];
             $amount1 = changeprice($amount);
             $temp = $rowa['weight'];
             if($rowa['weight']) { $units = "Kgs"; }
             $pdf->addText(25,$ik,10,"<b>$description</b>");
             $pdf->addText(329,$ik,10,"<b>$bags</b>");
             //$pdf->addText(375,$ik,10,$price);
             $pdf->addText(477,$ik,10,$units);
             //$pdf->addText(520,$ik,10,"<b>$amount1</b>");
             if($rowa['weight']) {
               $ik = $ik - 13;
               $pdf->addText(283,$ik,8,"<b>( $temp Birds )</b>");
             }
             $ik = $ik - 20;
     }

     $tbags = changeprice($tbags);
     $total1 = changeprice($totala);
     //$pdf->addText(289,165,10,"<b>$tbags</b>");
     //$pdf->addText(520,165,10,"<b>$total1</b>");
     $word = convert_number($totala);
     $pdf->addText(25,125,10,"<b>$word Only</b>");
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

