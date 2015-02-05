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

include "configinvoice.php";

     $pdf =& new Cezpdf('LETTER');
	 $pdf->addText(245,779,12,"<b>SALES ORDER</b>");
	 /*if($_SESSION['db'] == "central")
	  $img = ImageCreatefromjpeg('logo/thumbnails/central.jpg');
	  else if($_SESSION['db'] == "centralfeeds")
	  $img = ImageCreatefromjpeg('logo/thumbnails/cpfeedslogo.jpg');*/
     //$pdf-> addImage($img,22,$pdf->y-52,70,57);

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
     $pdf->line(270,770,270,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(425,770,425,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,730,580,730);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,690,580,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,650,580,650);
     $pdf->setStrokeColor(0,0,0);

    /* $pdf->setLineStyle(0.5);
     $pdf->line(270,610,580,610);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,570,580,570);
     $pdf->setStrokeColor(0,0,0);*/

     $pdf->setLineStyle(0.5);
     $pdf->line(270,620,580,620);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,620,270,620);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,650,270,650);
     $pdf->setStrokeColor(0,0,0);

    /* $pdf->setLineStyle(0.5);
     $pdf->line(20,505,580,505);
     $pdf->setStrokeColor(0,0,0);*/

     $pdf->setLineStyle(0.5);
     $pdf->line(170,650,170,155);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(270,650,270,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(350,650,350,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(425,650,425,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(490,650,490,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,185,580,185);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,155,580,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,85,580,85);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(350,85,350,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     //$pdf->addText(25,637,10,"Consignee");
     $pdf->addText(275,757,10,"Sales Order No.");
     $pdf->addText(430,757,10,"Dated");
     $pdf->addText(275,717,10,"Order Time");
     $pdf->addText(430,717,10,"Dispatch Location");
     $pdf->addText(275,669,10,"Consignee:");
     //$pdf->addText(430,677,10,"Other Reference(s)");
     /*$pdf->addText(275,637,10,"Buyer's Order No.");
     $pdf->addText(430,637,10,"Dated");
     $pdf->addText(275,597,10,"");
     $pdf->addText(430,597,10,"");
     $pdf->addText(275,557,10,"Order taken by");
     $pdf->addText(430,557,10,"Destination");*/



     $pdf->addText(40,625,10,"Description of Goods");
	  if($_SESSION['db']=="vista") { $pdf->addText(175,625,10,"Weight"); } else {$pdf->addText(175,625,10,"Quantity");} 
     
	 $pdf->addText(275,625,10,"Foc%");
     $pdf->addText(355,625,10,"Rate");
     $pdf->addText(430,625,10,"Per");
     $pdf->addText(495,625,10,"Amount");
     $pdf->addText(130,165,10,"Total");
     $pdf->addText(25,140,10,"<b>Amount Chargeable (in words)</b>");
     $pdf->addText(535,140,10,"E. & O.E.");
     if($_SESSION['db'] == "souza") { $pdf->addText(478,70,10,"for Souza Hatcheries"); }
     $pdf->addText(480,30,10,"Authorised Signatory");
     $pdf->addText(25,74,8,"<b>Terms & Conditions</b>");

	 $t = 1;
	 $tandc = "";
	 $query = "select tandc from oc_tandc order by id";
	 $result = mysql_query($query,$conn) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	  $tandc .= $t.". ".$rows[tandc].". ";
	  $t++;
	 }
 $width = $pdf->getTextWidth(6,$tandc);
 for($j= $width,$y = 63; $j>0; $j -= 320,$y -= 8)
  $tandc = $pdf->addTextWrap(25,$y,320,6,$tandc,'full');
	 

     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$discount = 0;
$query = "SELECT * FROM oc_salesorder WHERE  po = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['vendor'];
  $partycode = $row['vendorcode'];
  $date1 = $row['date'];
  $deldate1 = $row['deliverytime'];
  //$deldate1 = date("d.m.Y", strtotime($deldate1));
  $ps = $row['ps'];
   $emp2 = $row['aempname'];
  $date1 = date("d.m.Y", strtotime($date1));
  if($row['freightie'] == "Exclude")
   $freight += $row['freightamount'];
   
  if($row['freighttype'] == "Excluded")
   $freightamount = $row['freightamount'];
  elseif($row['freighttype'] == "Amount paid by Customer")
   $freightamount = -$row['freightamount'];
   
  if($row['taxie'] == "Exclude") 
   $taxamount += $row['taxamount'];
  elseif($row['taxie'] == "Include")
   $taxinclude += $row['taxamount'];
   
  $vehnum = $row['vno'];
  $discount += $row['discountamount'];
  $finaltotal = $finaltotal + ($row['finaltotal']);
  $destination = $row['destination'];
  $bookinvoice = $row['bookinvoice'];
  $narration = $row['remarks'];
  
  if($_SESSION['db']=="vista") $co = $row['co'];
  
  $totalfreightamount = $row['totalfreightamount'];
}
$freight += $totalfreightamount + $freightamount;

if($bookinvoice == "")
 $bookinvoice = "NA";
$totqty = 0;$totpack = 0;
$totbags = 0;
$totala = 0;
$query = "SELECT sum(quantity) as totqty,sum(packets) as totpack,sum(finaltotal) as total,narration FROM oc_salesorder WHERE  po = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $totqty = $row['totqty'];
  $total = $row['total'];
  $totpack = $row['totpack'];
  $narration = $row['remarks'];
}
$so = $_GET['id'];
$query11 = "SELECT date,warehouse FROM oc_salesorder WHERE  po = '".$_GET[id]."'";
$result11 = mysql_query($query11,$conn);
while($row11 = mysql_fetch_assoc($result11))
{
  $sodate = date('d.m.Y',strtotime($row11['date']));
  $deliveryloc = $row11['warehouse'];
  
  $ordertakenby = $row11[ordertakenby];
 }
$q1 = "SELECT * FROM contactdetails WHERE name = '$party'";
$r1 = mysql_query($q1,$conn);
$rows = mysql_fetch_assoc($r1);
$addr = $rows['deliveryaddress'];

	$temp1 = 190;
	if($freight > 0)
	{
	 
     $pdf->addText(180,$temp1,10,"Freight");
	 $freight = changeprice($freight);
	 $width = $pdf->getTextWidth(10,$freight);
     $pdf->addText((575-$width),$temp1,10,"<b>$freight</b>");
	 	 $temp1 += 15;
	} 
	
    if($discount>0)
    {	
	 $temp1 += 5;
     $pdf->addText(180,$temp1,10,"Discount");     
	 $discount = changeprice($discount);
	 $width = $pdf->getTextWidth(10,$discount);
     $pdf->addText((575-$width),$temp1,10,"<b>$discount</b>");
	 	 $temp1 += 15;
    } 
	
	if($taxamount > 0)
	{
	 $temp1 += 5;
     $pdf->addText(180,$temp1,10,"TAX (Excluded)");
	 $tax = changeprice($taxamount);
	 $width = $pdf->getTextWidth(10,$tax);
     $pdf->addText((575-$width),$temp1,10,"<b>$tax</b>");
	 	 $temp1 += 15;
	} 

	if($taxinclude > 0)
	{
	 $temp1 += 5;
     $pdf->addText(180,$temp1,10,"TAX (Included)");
	 $tax = changeprice($taxinclude);
	 $width = $pdf->getTextWidth(10,$tax);
     $pdf->addText((575-$width),$temp1,10,"<b>$tax</b>");
	 	 $temp1 += 15;
	} 

	if($discount > 0 or $taxamount > 0 or $freight >0 or $taxinclude > 0)
	{
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$temp1,580,$temp1);
     $pdf->setStrokeColor(0,0,0);	 
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
   $j-=15;  
   $temp2=$pdf->addTextWrap(20,$j,250,10,"<b>$temp2</b>","left");
  }
}
/*
  $j = 620;
  $width = $pdf->getTextWidth(10,$party);
  for($k = $width;$k>0;$k-=250,$j-=15)
   $party11=$pdf->addTextWrap(25,$j,250,10,"<b>$party ( $partycode )</b>","justify");*/

   // $pdf->addText(25,620,10,"<b>$party</b>");
	 $pdf->addText(5,$j,9,"$addr");
     $pdf->addText(275,740,10,"<b>$invoice($co)</b>");
     $pdf->addText(430,740,10,"<b>$date1</b>");
     //$pdf->addText(430,540,10,"<b></b>");
	 $pdf->addText(275,700,10,"<b>$deldate1</b>");
	 $pdf->addText(430,700,10,"<b>$deliveryloc</b> ");
	 //$pdf->addText(275,660,10,"<b>$party ( $partycode )</b>");
	 $pdf->addText(340,670,10,"<b>$party</b>");
	 //$pdf->addText(275,620,10,"$so");
	 //$pdf->addText(430,620,10,"$sodate");
	 //$pdf->addText(275,580,10,"$ps");
	 //$pdf->addText(430,580,10,"$psdate");
	 //$pdf->addText(275,540,10,"$ordertakenby");
	 //$pdf->addText(430,540,10,"$deliveryloc");

     $ik = 590;
     
     $querya = "SELECT * FROM oc_salesorder WHERE po = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
			 $itemcode = $rowa['code'];
			 $q = "select cat from ims_itemcodes where code = '$itemcode'";
			 $r = mysql_query($q,$conn) or die(mysql_error());
			 $rows = mysql_fetch_assoc($r);
			 $cat = $rows['cat'];
			 if($cat == 'Female Birds' or $cat == 'Male Birds' or $rowa[calcmode] == 'Others')
			  $bags = $rowa['weight'];
			 else
              $bags = $rowa['quantity']; 
             $units = $rowa['unit'];
             $tbags = $tbags + $rowa['quantity'];
			 $foc = $rowa['focper'];
             $price = $rowa['rateperunit'];
             $amount = $rowa['total'];  
             $totala = $rowa['pocost'];
             $amount1 = changeprice($bags * $price);
             $temp = $rowa['weight'];
             //if($rowa['weight']) { $units = "Kgs"; }
			 $bags = round($bags,2);
             $pdf->addText(25,$ik,10,"<b>$description</b>");
             $pdf->addText(175,$ik,10,"<b>$bags</b>");
			 $pdf->addText(275,$ik,10,"<b>$foc</b>");
             $pdf->addText(355,$ik,10,changeprice($price));
             $pdf->addText(430,$ik,10,$units);
			 $width = $pdf->getTextWidth(10,$amount1);
             $pdf->addText((575-$width),$ik,10,"<b>$amount1</b>");
			 
             //$pdf->addText(495,$ik,10,"<b>$amount1</b>");
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
	 $totpack1 = changeprice($totpack1);
     $pdf->addText(175,165,10,"<b>$tbags</b>");
     //$pdf->addText(495,165,10,"<b>$total1</b>");
	 $width = $pdf->getTextWidth(10,$total1);
     $pdf->addText((575-$width),165,10,"<b>$total1</b>");
	 $empname1="ENTERED BY".$emp2;

$pdf->addText(27,90,10,"$empname1");
	 
     $word = convert_number($totala);
	 $word = $word." Only";

	 
$temp = explode('.',$totala);
$rs = $temp[0];
$paisa = $temp[1];	 
$word = convert_number($rs) . " Rs";
if($paisa)
 $word = $word . " and " . convert_number($paisa) . " Tambalas";
$word .= " Only";

  $width = $pdf->getTextWidth(10,$word);
  for($k = $width,$j = 125;$k>0;$k-=550,$j-=15)
   $word=$pdf->addTextWrap(30,$j,550,10,"$word","justify");
  $j += 15;	
	
  $remarks = "<b>Narration</b> :".$narration;
  $width = $pdf->getTextWidth(10,$remarks);
  for($k = $width;$k>0;$k-=550)
  {
   $j-=15;
   $remarks=$pdf->addTextWrap(25,$j,550,10,"$remarks","justify");
  }

    // $pdf->addText(25,125,10,"<b>$word Only</b>");
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

if(strlen($input)<=2)

{ return $input; }

$length=substr($input,0,strlen($input)-2);

$formatted_input = makecomma($length).",".substr($input,-2);

return $formatted_input;

}



?>

