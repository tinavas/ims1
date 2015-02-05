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
     $pdf->line(20,770,20,220);
     $pdf->setStrokeColor(0,0,0);


     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,220);
     $pdf->setStrokeColor(0,0,0);


     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,245,600,245);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,220,600,220);
     $pdf->setStrokeColor(0,0,0);


     /////for the horizontal line after the company address
     $pdf->setLineStyle(0.5);
     $pdf->line(20,720,600,720);
     $pdf->setStrokeColor(0,0,0);

      /////for the horizontal line after Itemcode
     $pdf->setLineStyle(0.5);
     $pdf->line(20,620,600,620);
     $pdf->setStrokeColor(0,0,0);

     /////for the horizontal line after itemname
     $pdf->setLineStyle(0.5);
     $pdf->line(20,580,600,580);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after Itemcode
     $pdf->setLineStyle(0.5);
     $pdf->line(100,620,100,245);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after Description
     $pdf->setLineStyle(0.5);
     $pdf->line(270,620,270,245);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after Units
     $pdf->setLineStyle(0.5);
     $pdf->line(330,620,330,220);
     $pdf->setStrokeColor(0,0,0);
	 
	 ///vertical line after Packets
     $pdf->setLineStyle(0.5);
     $pdf->line(390,620,390,220);
     $pdf->setStrokeColor(0,0,0);

     ///vertical line after quantity
     $pdf->setLineStyle(0.5);
     $pdf->line(480,620,480,220);
     $pdf->setStrokeColor(0,0,0);

    
     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(40,700,8,"Customer Name :");
	 $pdf->addText(88,680,8,"PS :");   
     $pdf->addText(410,700,8,"Date :");     
     $pdf->addText(390,680,8,"D.Location:"); 
	   $pdf->addText(85,660,8,"Unit :");
	   $pdf->addText(388,660,8,"Vehicle NO:"); 
	    $pdf->addText(80,640,8,"Driver:");
	   $pdf->addText(408,640,8,"Time :"); 
	     
  
     $pdf->addText(30,600,8,"Item Code");     
     $pdf->addText(105,600,8,"Description");
     $pdf->addText(275,600,8,"Units");
	 $pdf->addText(338,600,8,"Packets");
     $pdf->addText(400,600,8,"Quantity");
     $pdf->addText(495,600,8,"SO");
       

     include "configinvoice.php";
     $ps = $_GET[id];
session_start();
$finaltotal = 0;
$query = "SELECT * FROM oc_packslip WHERE ps = '$ps'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['party'];
  $date1 = $row['date'];
  $date1 = date("d.m.Y", strtotime($date1));
  $unit = $row['warehouse'];
  $vnum = $row['vehicleno'];
  $driver = $row['driver'];
  $time = $row['tme'];
  $so = $row['so'];
 // $broker = $row['broker'];
}
$q = "select * from oc_salesorder where po = '$so'";
$r = mysql_query($q,$conn);
while($row = mysql_fetch_assoc($r))
{
$dloc = $row['deliveryloc'];
}
 $totalaccqty = 0;
  $totalrecqty = 0;
  $totshrinkage = 0;


$query = "SELECT * FROM home_logo "; 
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address']; }
$address1 = html_entity_decode($address);


$temp = explode('</p>',$address1);
for($i = 0,$j = 770;$i < count($temp) && $i < 3; $i++)
{
 $temp2 = preg_replace("/<[^\>]+\>/","",$temp[$i]);
 $width = $pdf->getTextWidth(10,$temp2);
  for($k = $width;$k>0;$k-=250)
  {
   $j-=07;  
   $temp2=$pdf->addTextWrap(25,$j,550,10,"<b>$temp2</b>","center");
  }
}
	 
	$pdf->addTextWrap(25,775,550,12,"<b>DELIVERY NOTE</b>","center");
     $pdf->addText(115,700,8,"<b>$party</b>");
	  $pdf->addText(115,680,8,"<b>$ps</b>");
     $pdf->addText(455,700,8,"<b>$date1</b>");
     $pdf->addText(455,680,8,"<b>$dloc</b>");
	 $pdf->addText(115,660,8,"<b>$unit</b>");
	  $pdf->addText(455,660,8,"<b>$vnum</b>");
	  $pdf->addText(115,640,8,"<b>$driver</b>");
	  $pdf->addText(455,640,8,"<b>$time</b>");

     $ik = 560; $tax=$discount=0; $totalquant =  $totalpack  = 0;
     include "config.php";
     $querya = "SELECT * FROM oc_packslip WHERE ps = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $item = $rowa['itemcode'];
             $desc = $rowa['description'];
			 $units = $rowa['units'];
			 $qty = $rowa['quantity'];
			 $pac = $rowa['packets'];
			 $so = $rowa['so'];
			 if($so == "withoutso")
			 {
			 $so = "N/A";
			 }
			 $totalquant = $totalquant + $qty;
			  $totalpack = $totalpack + $pac;
			 
             $pdf->addText(30,$ik,8,$item);
             $pdf->addText(105,$ik,8,$desc);
             $pdf->addText(275,$ik,8,$units);
			 
			 $pdf->addText(338,$ik,8,$pac);
             $pdf->addText(400,$ik,8,changeprice($qty));
            $pdf->addText(490,$ik,8,$so);
 
             $ik = $ik - 20;
     }
	 $totalquantcc =  changeprice($totalquant);
     $pdf->addText(290,230,8,"<b>Total</b>");
     $pdf->addText(30,200,8,"<b>Total in words $display :</b>");
     //$total1 = changeprice($totalaccqty);
	 $pdf->addText(338,230,8,"<b>$totalpack</b>");
     $pdf->addText(400,230,8,"<b>$totalquantcc</b>");
     //$pdf->addText(385,410,10,"<b>$totalaccqty</b>");
	// $pdf->addText(450,410,10,"<b>$totalrecqty</b>");
	 // $pdf->addText(520,410,10,"<b>$totshrinkage</b>");
     $word = convert_number($totalquant);
	 $word = $word." Only";
	 $tempword = explode('</p>',$word);
for($i = 0,$j = 200;$i < count($tempword); $i++)
{
 $temp2 = preg_replace("/<[^\>]+\>/","",$tempword[$i]);
 $width = $pdf->getTextWidth(40,$temp2);
  for($k = $width;$k>0;$k-=250)
  {
   $j-=15;  
   $temp2=$pdf->addTextWrap(30,$j,550,10,"$temp2","left");
  }
}
	 
     //$pdf->addText(150,380,10,"<b>$word Only</b>");


  //  $pdf->addText(25,350,10,"<b>Terms & Conditions</b>");
$t  = explode(',',$tandc);
$siz = sizeOf($t); 
$kk= 100;
$l = 1;


/*
$kk = $kk - 60;
$kkk = $kk - 20;
$pdf->addText(25,$kk,8,"<b>__________________________</b>");
$pdf->addText(55,$kkk,8,"<b>Accepted By</b>");
$pdf->addText(425,$kk,8,"<b>__________________________</b>");
$pdf->addText(445,$kkk,8,"<b>Authorized Signature</b>"); */
	 $pdf->addText(30,165,10,"Checked by:");
	 $pdf->addText(210,150,10,"__________________________");
	 $pdf->addText(270,135,10,"Name");
	 $pdf->addText(390,150,10,"__________________________");
	 $pdf->addText(450,135,10,"Date");
	 
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,130,600,130);
     $pdf->setStrokeColor(0,0,0);
	 
	 
	 $pdf->addText(30,110,10,"Goods received in good order for the Customer by:");
	 
	 $pdf->addText(25,90,10,"_________________");
	 $pdf->addText(60,70,10,"Name");
	 $pdf->addText(140,90,10,"_________________");
	 $pdf->addText(155,70,10,"Designation");
	 $pdf->addText(260,90,10,"_________________");
	 $pdf->addText(285,70,10,"Signature");
	 $pdf->addText(380,90,10,"_________________");
	 $pdf->addText(420,70,10,"Date");
	 $pdf->addText(500,90,10,"_________________");
	 $pdf->addText(510,70,10,"Company Stamp");
	 
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,60,600,60);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->addText(30,40,10,"Note:");
	 $pdf->addText(70,40,10,"Any Returns or Shortages need to be recorded on a return for Credit Voucher");
	 
	 $pdf->addText(30,15,10,"Ref. No.");
	 $pdf->addText(70,15,10,"_____________");

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
   if (($number < 0) || ($number > 999999999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 
	$Tn = floor($number / 1000000000000);  /* Millions (giga) */ 
    $number -= $Tn * 1000000000000;
	$Bn = floor($number / 1000000000);  /* Millions (giga) */ 
    $number -= $Bn * 1000000000;
    $Mn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Mn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 
	if ($Tn) 
    { 
       if($Tn > 1)
        $res .= convert_number($Tn) . " Trillions "; 
       else 
        $res .= convert_number($Tn) . " Tillion "; 
    } 
	
	if ($Bn) 
    { 
       if($Bn > 1)
        $res .= convert_number($Bn) . " Billions "; 
       else 
        $res .= convert_number($Bn) . " Billion "; 
    } 
	
    if ($Mn) 
    { 
       if($Mn > 1)
        $res .= convert_number($Mn) . " Millions "; 
       else 
        $res .= convert_number($Mn) . " Million "; 
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
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", 
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
if(strlen($input)<=3)
{ return $input; }
$length=substr($input,0,strlen($input)-3);
$formatted_input = makecomma($length).",".substr($input,-3);
return $formatted_input;
}

?>

