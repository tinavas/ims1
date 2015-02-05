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
if($_SESSION['db'] == "gujarath")
{
$q1="select * from home_logo";
$r1=mysql_query($q1);
while($row=mysql_fetch_array($r1))
{
	  $img = ImageCreatefromjpeg('logo/thumbnails/GAFL LOGO.jpg');
//$img = ImageCreatefromjpeg($row[2]);
	   $pdf-> addImage($img,22,$pdf->y-52,70,57);
	//   $pdf->addText(10,2,10,$row[2]);
	   $pdf->addText(10,22,10,$row[1]);
	   }
	  }	
	  
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
     $pdf->line(270,650,580,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,610,580,610);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,570,580,570);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,530,580,530);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,530,270,530);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,650,270,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,505,580,505);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,530,270,155);
     $pdf->setStrokeColor(0,0,0);
	 if($_SESSION['db']=="mew")
	{
		$pdf->setLineStyle(0.5);
		$pdf->line(325,530,325,155);
		$pdf->setStrokeColor(0,0,0);
		$pdf->setLineStyle(0.5);
		$pdf->line(370,530,370,155);
		$pdf->setStrokeColor(0,0,0);
	}
	else
	{
		$pdf->setLineStyle(0.5);
		$pdf->line(350,530,350,155);
		$pdf->setStrokeColor(0,0,0);
	}

     $pdf->setLineStyle(0.5);
     $pdf->line(425,530,425,155);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(500,530,500,155);
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
     $pdf->addText(25,637,10,"Consignee");
     $pdf->addText(275,757,10,"Invoice No.");
     $pdf->addText(430,757,10,"Dated");
     $pdf->addText(275,717,10,"Delivery Note");
     $pdf->addText(430,717,10,"Mode/Terms of Payment");
     $pdf->addText(275,677,10,"Sales Order No.");
     $pdf->addText(430,677,10,"Sales Order Date");
	 if($_SESSION['db']=='maharashtra')
	 {
	 $pdf->addText(275,637,10,"Vehicle No.");
	 }
	 else
	 {
     $pdf->addText(275,637,10,"Pack Slip No.");
	 }
     $pdf->addText(430,637,10,"Pack Slip Date");
     $pdf->addText(275,597,10,"Despatch Document No.");
     $pdf->addText(430,597,10,"Dated");
	 if($_SESSION['db']=='golden')
	 {
	 $pdf->addText(275,557,10,"Vehicle No.");
	 }
	 else
	 {
    $pdf->addText(275,557,10,"Despatched through");
	 }
     
     $pdf->addText(430,557,10,"Destination");



     $pdf->addText(100,515,10,"Description of Goods");
	 if($_SESSION['db']!="mew") {
     if($_SESSION['db']=="vista") { $pdf->addText(290,515,10,"Weight"); } else {$pdf->addText(290,515,10,"Quantity");} 
     }
	 if($_SESSION['db']=="mew")
	 {
		$pdf->addText(290,515,10,"Length");
		$pdf->addText(335,515,10,"Width");
	 }
     $pdf->addText(375,515,10,"Rate");
     $pdf->addText(455,515,10,"Per");
     $pdf->addText(520,515,10,"Amount");
     if($_SESSION['db']=='maharashtra')
     {
     $pdf->addText(230,210,10,"VAT");
	 }
	 $pdf->addText(230,195,10,"Freight");
     $pdf->addText(240,165,10,"Total");
     $pdf->addText(25,140,10,"Amount Chargeable (in words)");
     $pdf->addText(535,140,10,"E. & O.E.");
     if($_SESSION['db'] == "souza") { $pdf->addText(478,70,10,"for Souza Hatcheries"); }
     $pdf->addText(480,30,10,"Authorised Signatory");
     $pdf->addText(25,74,8,"<b>Terms & Conditions</b>");
	 if($_SESSION['db']=="gujarath")
	  $pdf->addText(25,110,10,"<b>Narration:</b>");
	 /*
     $pdf->addText(25,63,6,"Form 32: 1.We certify that we are registered under VAT act 2003 and we shall pay tax in respect of the goods sold under");
     $pdf->addText(25,53,6,"this invoice.2.Goods once sold cannot be taken back or exchanged.3.Interest at 24% p.a.will be charged on all A/cs Over-");
     $pdf->addText(25,43,6,"-due more than 21 days. 4.Payments should be made by Draft or Cheques in the name of company only. 5.In case if you ");
     $pdf->addText(25,33,6,"find inadvertent error please inform us for refund difference. 6.Free goods in this Tax Invoice has no commercial Value.");
	 if($_SESSION['db'] == "sumukh") {
     $pdf->addText(25,23,6,"7.Any dispute arising out of this transaction Shimoga will be the sole jurisdiction.");
	 }
	 elseif($_SESSION['db'] == "maharashtra")
	 {
	  $pdf->addText(25,23,6,"7.Any dispute arising out of this transaction Hassan will be the sole jurisdiction.");
	 } 
	 elseif($_SESSION['db'] == "alkhumasiyabrd")
	 {
	  $pdf->addText(25,23,6,"7.Any dispute arising out of this transaction Riyad will be the sole jurisdiction.");
	 } 
	 else
	 {
	  $pdf->addText(25,23,6,"7.Any dispute arising out of this transaction Mangalore will be the sole jurisdiction.");

	 }
	 */
	 $t = 1;
	 $tandc = "";
	 include "configinvoice.php";
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
$query = "SELECT * FROM oc_cobi WHERE  invoice = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['party'];
  $date1 = $row['date'];
  $date1 = date("d.m.y", strtotime($date1));
  $freight = $row['freightamount'];
  $vehnum = $row['vno'];
    $taxamount = $taxamount+$row['taxamount'];
  $discount = $row['discountamount'];
  $finaltotal = $finaltotal + ($row['finaltotal']);
  $destination = $row['destination'];
  $bookinvoice = $row['bookinvoice'];
  $narration = $row['remarks'];
  $ps=$row['ps'];
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

if($_SESSION['db']=="vista")
{
$query = "SELECT cop,date,ps,so FROM oc_packslip WHERE  ps = '$ps'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $cop = $row['cop'];
  $pdate = $row['date'];
  $ps = $row['ps'];
  $pdate = date("d.m.y", strtotime($pdate));
   $so = $row['so'];
}

$query = "SELECT po,date,co FROM oc_salesorder WHERE  po = '$so'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $po = $row['po'];
  $sdate = $row['date'];
 
  $sdate = date("d.m.y", strtotime($sdate));
   $co = $row['co'];
}

}

$q1 = "SELECT * FROM contactdetails WHERE name = '$party'";
$r1 = mysql_query($q1,$conn);
$rows = mysql_fetch_assoc($r1);
$addr = $rows['address'];

    if($discount)
    {

     $pdf->setLineStyle(0.5);
     $pdf->line(20,215,580,215);
     $pdf->setStrokeColor(0,0,0);
$discount=changeprice($discount);
     $pdf->addText(223,205,10,"Discount");
     $pdf->addText(520,205,10,"<b>$discount</b>");
    } 
 include "config.php"; 
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
   $temp2=$pdf->addTextWrap(25,$j,250,10,"<b>$temp2</b>","left");
  }
}

     $pdf->addText(25,620,10,"<b>$party</b>");
	 $addr=explode(',',$addr);
	 $length=count($addr);
	 $k=605;
	 for($i=0;$i<$length;$i++)
	 {
	 $pdf->addText(25,$k,10,"$addr[$i]");
	 $k=$k-15;
	 }
	 //$pdf->addText(25,605,10,"$addr");
     $pdf->addText(275,740,10,"<b>$invoice</b>");
     $pdf->addText(430,740,10,"<b>$date1</b>");
     $pdf->addText(430,540,10,"<b>$destination</b>");
	 $pdf->addText(275,700,10,"NA");
	 $pdf->addText(430,700,10,"NA");
	 
	 if($_SESSION['db']=='golden')
	 {
	 
	 $pdf->addText(275,540,10,"$vehnum");
	 }
	 else
	 {
	 $pdf->addText(275,540,10,"");
	 }
	 
	 $pdf->addText(275,660,10,"$po($co)");
	 
	
	 $pdf->addText(430,660,10,"$sdate");
	 if($_SESSION['db']=='maharashtra')
	 {
	 
	 $pdf->addText(275,620,10,"$vehnum");
	 }
	 else
	 {
	 $pdf->addText(275,620,10,"$ps($cop)");
	 }
	 $pdf->addText(430,620,10,"$pdate");
	 $pdf->addText(275,580,10,$bookinvoice);
	 $pdf->addText(430,580,10,"NA");
	 //$pdf->addText(275,540,10,"NA");
	 $pdf->addText(430,540,10,"NA");

     $ik = 490;
     include "config.php";
     $querya = "SELECT * FROM oc_cobi WHERE invoice = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
			  $itemcode = $rowa['code'];
			 if($_SESSION['db']=='maharashtra')
			 {
			 	
			$querya1 = "SELECT * FROM ims_itemcodes WHERE  cat!='Broiler Feed' and cat!='Medicines' and code in(SELECT code FROM oc_cobi WHERE invoice = '$_GET[id]' order by id)";
     $resulta1 = mysql_query($querya1,$conn);
     while($rowa1 = mysql_fetch_assoc($resulta1))
     {
     		$code=$rowa1['code'];
			if($code==$itemcode)
			{
				
				 $description=$description."(doc)";
			}


			
			 }
	
		

			 }
			
			 $q = "select cat from ims_itemcodes where code = '$itemcode'";
			 $r = mysql_query($q,$conn) or die(mysql_error());
			 $rows = mysql_fetch_assoc($r);
			 $cat = $rows['cat'];
			 if($_SESSION['db']=="vista")
			 $bags=$rowa['weight'];
			
			 else
			 {
			 if($cat == 'Female Birds' or $cat == 'Male Birds')
			  $bags = $rowa['weight'];
			 else
              $bags = $rowa['quantity'];
			  
			  } 
             $units = $rowa['units'];
			 if($_SESSION['db']=="vista")
			  $tbags = $tbags + $rowa['weight'];
			 else
             $tbags = $tbags + $rowa['quantity'];
             $price = $rowa['price'];
             $amount = $rowa['total'];  
             $totala = $rowa['finaltotal'];
             $amount1 = changeprice($bags * $price);
			  if($_SESSION['db']=="mew")
			 {
				$tlength=$tlength+$rowa['length'];
				$twidth=$twidth+$rowa['width'];
			 }
             $temp = $rowa['weight'];
             if($rowa['weight']) { $units = "Kgs"; }
			 $bags = round($bags,2);
			  if($_SESSION['db']=="mew")
			 {
				$length = $rowa['length'];
				$width = $rowa['width'];
				$amount1=$length*$width*$price;
			 }
             $pdf->addText(25,$ik,10,"<b>$description</b>");
			  if($_SESSION['db']=="mew")
			 {
				$pdf->addText(289,$ik,10,"<b>$length</b>");
				$pdf->addText(333,$ik,10,"<b>$width</b>");
			 }
			 else
			 {
				$pdf->addText(289,$ik,10,"<b>$bags</b>");
			 }
             $pdf->addText(375,$ik,10,changeprice($price));
             $pdf->addText(453,$ik,10,$units);
             $pdf->addText(520,$ik,10,"<b>$amount1</b>");
			   
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
	 $freight= changeprice($freight);
	 $tlength=changeprice($tlength);
	 $twidth=changeprice($twidth);
	 if($_SESSION['db']=="mew")
	 {
		$pdf->addText(289,165,10,"<b>$tlength</b>");
		$pdf->addText(333,165,10,"<b>$twidth</b>");
	 }
	 else
	 {
		$pdf->addText(289,165,10,"<b>$tbags</b>");
	 }
     $pdf->addText(520,165,10,"<b>$total1</b>");
	 if($_SESSION['db']=='maharashtra')
	 {
	 $pdf->addText(520,210,10,"<b>$taxamount</b>");
	 }
	 $pdf->addText(520,195,10,"<b>$freight</b>");
     $word = convert_number($totala);
     $pdf->addText(25,125,10,"<b>$word Only</b>");
	 if($_SESSION['db']=="gujarath")
	 {
	 //$pdf->addText(75,110,10,"$narration");
	 $len=strlen($narration);
	 $nar=$narration;
$word1=substr($nar,0,113);
$len1=$len-113;
$word2=substr($nar,113,$len1);
if($len<113)
{
	$pdf->addText(75,110,10," $word1");
}
else {
	

$pdf->addText(75,110,10," $word1");	
$pdf->addText(75,93,10,"$word2"); 
}
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

