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


     $pdf =& new Cezpdf('KLD');

     $pdf->setLineStyle(0.5);
     $pdf->line(05,445,145,445);
     $pdf->setStrokeColor(0,0,0);


     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
    
	 
    
	 $pdf->addText(05,430,10,"<b>Item</b>"); $pdf->addText(45,430,10,"<b>Qty</b>"); $pdf->addText(75,430,10,"<b>Rate</b>"); $pdf->addText(105,430,10,"<b>Amount</b>");
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(05,420,145,420);
     $pdf->setStrokeColor(0,0,0);
	 
	 include "config.php";
	 $q="select description,quantity,price,cleaningcharges,discountamount,billno  from oc_cobi where invoice='".$_GET[invoice]."' and client='$client'" ;
	 $r=mysql_query($q,$conn) or die(mysql_error());
	 $y=405;
	 $total=$cleaning=$discount=0;
	while( $a=mysql_fetch_assoc($r))
	{
	 $item=substr($a[description],0,7);
	 $quantity=$a[quantity];
	 $rate=$a[price];
	 $cleaning=$a[cleaningcharges];
	 $discount=$a[discountamount];
	 $total+=($quantity*$rate);
	 
	 $pdf->addText(05,450,10,"<b>BillNo</b>"); $pdf->addText(55,450,10,$a[billno]); $pdf->addText(85,450,10,date("d/m/Y")); 
	 
      $pdf->addText(05,$y,10,$item);$pdf->addText(45,$y,10,$quantity);$pdf->addText(75,$y,10,$rate);$pdf->addText(105,$y,10,  changeprice($quantity*$rate));
	  $y-=10;
    }
     $pdf->setLineStyle(0.5);
     $pdf->line(05,$y,145,$y);
     $pdf->setStrokeColor(0,0,0);	 
	 $total=$total-$discount+$cleaning; 
	 $pdf->addText(20,$y-10,10,"<b>Cleaning Cost:</b>"); $pdf->addText(105,$y-10,10,changeprice($cleaning));
	 $pdf->addText(45,$y-20,10,"<b>Discount:</b>"); $pdf->addText(105,$y-20,10,changeprice($discount));
	 $pdf->addText(64,$y-30,10,"<b>Total:</b>"); $pdf->addText(105,$y-30,10,changeprice($total));
	 $pdf->addText(15,$y-60,10,"* Thank You Visit Again *");
	 
	 $pdf->ez['pageHeight']=$y;
	 $pdf->ezStream();     
	  

//-----------------------------------------------------------------------------


function rightalign($string,$maxlength,$y){


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

