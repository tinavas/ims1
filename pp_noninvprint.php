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

	  $pdf->setLineStyle(0.5);
     $pdf->line(20,770,580,770);
     $pdf->setStrokeColor(0,0,0);
    $pdf->line(20,770,20,20);
     $pdf->setStrokeColor(0,0,0);
//vertical line last
     $pdf->setLineStyle(0.5);
     $pdf->line(580,770,580,20);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,20,580,20);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
    $pdf->line(210,770,210,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
    // $pdf->line(210,770,210,700);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(370,770,370,155);
     $pdf->setStrokeColor(0,0,0);
//invoice line
     $pdf->setLineStyle(0.5);
     //$pdf->line(210,730,580,730);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
   $pdf->line(270,690,580,690);
     $pdf->setStrokeColor(0,0,0);

    

     $pdf->setLineStyle(0.5);
     $pdf->line(20,690,270,690);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,625,580,625);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(20,650,580,650);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
    $pdf->line(210,650,210,155);
     $pdf->setStrokeColor(0,0,0);

//total horizontal line

 $pdf->setLineStyle(0.5);
     $pdf->line(20,215,580,215);
     $pdf->setStrokeColor(0,0,0);


     $pdf->setLineStyle(0.5);
     $pdf->line(20,185,580,185);
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
     $pdf->addText(25,675,10,"Supplier");
     $pdf->addText(275,757,10,"Invoice No.");
     $pdf->addText(430,757,10,"Dated");
    
	  $pdf->addText(220,775,12,"<b>PURCHASE INVOICE</b>");
     
    
	 
	  $pdf->addText(430,715,10,"Book Invoice");
     $pdf->addText(430,677,10,"Destination");
	 

     $pdf->addText(60,635,10,"Description of Goods");
     $pdf->addText(280,635,10,"Amount");
     //$pdf->addText(290,635,10,"Rate");
     //$pdf->addText(330,635,10,"Units");
	 $pdf->addText(430,635,10,"Discount Amount");
     
	// $pdf->addText(515,635,10,"Destination");
	 
	 	 $pdf->addText(155,165,10,"Grand Total");
     $pdf->addText(25,140,10,"Total Amount (in words)");
     $pdf->addText(535,140,10,"");
     if($_SESSION['db'] == "souza") { $pdf->addText(478,70,10,"for Souza Hatcheries"); }
	 
	 $pdf->addText(310,30,10,"Prepared By:");
     $pdf->addText(510,30,10,"Approved By");
     $pdf->addText(25,87,8,"<b>Terms & Conditions</b>");
	 
	 
	 
	 
	 
     include "configinvoice.php";
     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$discount = 0;
$query = "SELECT * FROM pp_sobi WHERE  so = '$invoice' and niflag = '1'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{ //$camount = $row['camount'];
  $party = $row['vendor'];
  $emp2 = $row['empname'];
  $aname=$row['aempname'];
  $date1 = $row['date'];
  $date1 = date("d.m.Y", strtotime($date1));

   $discount += $row['discountamount'];

  $finaltotal = $row[grandtotal] ;
  $destination = $row['warehouse'];
  $bookinvoice=$row['invoice'];
  $po = $row['po'];
  $po1=$po1.$po."/";
}
    


	
	
	
	
	
$query = "SELECT * FROM home_logo "; 
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address']; }
$address1 = html_entity_decode($address);


$temp = explode('</p>',$address1);
for($i = 0,$j = 770;$i < count($temp) && $i < 5; $i++)
{
 $temp2 = preg_replace("/<[^\>]+\>/","",$temp[$i]);
 $width = $pdf->getTextWidth(10,$temp2);
  for($k = $width;$k>0;$k-=250)
  {
   $j-=10;  
   $temp2=$pdf->addTextWrap(20.5,$j,250,9,"<b>$temp2</b>");
  }
}

 
 $pdf->addText(25,657,10,"<b>$party</b>");
     $pdf->addText(275,740,10,"<b>$invoice</b>");
     $pdf->addText(430,740,10,"<b>$date1</b>");
     $pdf->addText(375,660,10,"<b>$destination</b>");
     $pdf->addText(430,700,10,"<b>$bookinvoice</b>");
	 $len=strlen($po1);
$word1=substr($po1,0,40);
$len1=$len-40;
$word2=substr($po1,40,$len1);
if($len<40)
{
	$pdf->addText(215,665,7,"<b>$word1 </b>");
}
else {
	

$pdf->addText(215,665,7,"<b>$word1 </b>");
$pdf->addText(215,655,7,"<b>$word2 </b>"); 
}
	 

	 
     $ik = 610;
     include "config.php";
     $querya = "SELECT * FROM pp_sobi WHERE so = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
             $description = $rowa['description'];
 
           
			 $dis = $rowa['discountamount'];
			$totalamount +=$rowa['totalamount'];
			 
			
		  $amount = $rowa['totalamount']; 
			
             $totala += $amount;
            
             $amount1 = changeprice($amount);
			 $dis1=changeprice($dis);
			 $gtotal=$gtotal+$amount-$dis;
           
             
			 
			  $len134=strlen($description);
$word1=substr($description,0,35);
$len1=$len134-35;
$word2=substr($description,40,$len1);
if($len134<35)
{
	$pdf->addText(35,$ik,8,"<b>$word1</b>");
}
else {
	

$pdf->addText(35,$ik,8,"<b>$word1</b>");	
$pdf->addText(35,($ik-10),8,"<b>$word2</b>"); 
}
            

			 
		
             $pdf->addText((330-$width),$ik,8,"<b>$amount1</b>");
			
			 
			 $width = $pdf->getTextWidth(8,$amount1);
             $pdf->addText((495-$width),$ik,8,"<b>$dis1</b>");
             
			
			 
             $ik = $ik - 20;

     }

     $totalamount = changeprice($totalamount);
     $total1 = changeprice($finaltotal);
	 $empname1=$emp2;
	 
	 $tdiscount=changeprice($discount);

	  $width = $pdf->getTextWidth(8,$total1);
     $pdf->addText((300-$width),200,8,"<b>$totalamount</b>");
	 
	 $width = $pdf->getTextWidth(8,$discount);
     $pdf->addText((450-$width),200,8,"<b>$tdiscount</b>");
	 
	 
	 
	 
$pdf->addText(370,30,10,"$empname1");
     
	 $width = $pdf->getTextWidth(10,$total1);
     $pdf->addText((300-$width),165,10,"<b>$total1</b>");
     
	 
$temp = explode('.',$finaltotal);
$rs = $temp[0];
$paisa = $temp[1];	 
$word = convert_number($rs) . " ";
if($paisa)
 $word = $word . " and " . convert_number($paisa) . " Fils";
$word .= " Only";

  $width = $pdf->getTextWidth(10,"<b>$word</b>");
  for($k = $width,$j = 125;$k>0;$k-=550,$j-=15)
   $word=$pdf->addTextWrap(25,$j,550,10,"<b>$word</b>","justify");
	 
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

?>

