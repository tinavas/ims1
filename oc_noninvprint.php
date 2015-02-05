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
     //$pdf->line(170,530,170,155);
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


$pdf->addText(285,775,13,"<b>COBI</b>");
     $pdf->selectFont("fonts/Helvetica.afm");

     $pdf->setColor(0/255,0/255,0/255);

     $pdf->addText(25,637,10,"Consignee");

     $pdf->addText(275,757,10,"Invoice No.");

     $pdf->addText(430,757,10,"Dated");

     $pdf->addText(275,717,10,"Delivery Note");

     $pdf->addText(430,717,10,"Mode/Terms of Payment");

     $pdf->addText(275,677,10,"Supplier's Ref.");

     $pdf->addText(430,677,10,"Other Reference(s)");

     $pdf->addText(275,637,10,"Buyer's Order No.");

     $pdf->addText(430,637,10,"Dated");

     $pdf->addText(275,597,10,"Despatch Document No.");

     $pdf->addText(430,597,10,"Dated");

     $pdf->addText(275,557,10,"Despatched through");

     $pdf->addText(430,557,10,"Destination");
//$pdf->addText(175,515,10,"Delivary challan Num");


$img = ImageCreatefromjpeg('logo/thumbnails/Logo final.jpg');
 $pdf->addImage($img,30,700,50,50);



     $pdf->addText(100,515,10,"Description of Goods");

     $pdf->addText(330,515,10,"Amount");

    // $pdf->addText(375,515,10,"Rate");

     $pdf->addText(455,515,10,"Discount Amount");

     //$pdf->addText(520,515,10,"Amount");

    $pdf->addText(210,165,10,"Grand Total");

     $pdf->addText(25,140,10,"Amount Chargeable (in words)");

     $pdf->addText(535,140,10,"E. & O.E.");

     if($_SESSION['db'] == "souza") { $pdf->addText(478,70,10,"for Souza Hatcheries"); }

     $pdf->addText(480,30,10,"Authorised Signatory");

     $pdf->addText(25,74,8,"<b>Terms & Conditions</b>");

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

$query = "SELECT * FROM oc_cobi WHERE  invoice = '$invoice' and niflag='1'";

$result = mysql_query($query,$conn);

while($row = mysql_fetch_assoc($result))

{

  $party = $row['party'];

  $date1 = $row['date'];

  $date1 = date("d.m.y", strtotime($date1));

  $discount = $row['discountamount'];

  $finaltotal = $finaltotal + ($row['finaltotal']);

  $bookinvoice = $row['bookinvoice'];

  $narration = $row['remarks'];
 // $ps1 = $row['ps'];
  
  $aname=$row['aempname'];



$query11 = "SELECT * FROM oc_packslipmpc WHERE  ps = '$ps1'";

$result11 = mysql_query($query11,$conn);

while($row11 = mysql_fetch_assoc($result11))

{
$so=$row11['salesorder'];

  $so1=$so1.$so."/";
}
}
$len=strlen($so1);
$so1=substr($so1,0,$len-1);

if($bookinvoice == "")

 $bookinvoice = "NA";

$totqty = 0;

$totbags = 0;

$totala = 0;

$query = "SELECT sum(total) as totqty,sum(finaltotal) as total FROM oc_cobi WHERE  invoice = '$invoice'";

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



     $pdf->setLineStyle(0.5);

     $pdf->line(20,215,580,215);

     $pdf->setStrokeColor(0,0,0);



    // $pdf->addText(223,195,10,"Discount");

   //  $pdf->addText(520,195,10,"<b>$discount</b>");

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

	 $len=strlen($addr);
$word1=substr($addr,0,41);
$len1=$len-41;

$word3=substr($addr,41,$len1);
if($len<41)
{
	$pdf->addText(25,605,10,"<b>$word1<b>");
}
else {
	$pdf->addText(25,605,10,"<b>$word1<b>");
	
	$pdf->addText(25,595,10,"<b>$word3<b>");
}

     $pdf->addText(275,740,10,"<b>$invoice</b>");

     $pdf->addText(430,740,10,"<b>$date1</b>");

     $pdf->addText(430,540,10,"<b>$destination</b>");

	 $pdf->addText(275,700,10,"NA");

	 $pdf->addText(430,700,10,"NA");

	 $pdf->addText(275,660,10,"NA");

	// $pdf->addText(430,660,10,"$narration");
	 
	 
	 $len1345=strlen($narration);
$narration1=substr($narration,0,32);
$len1=$len1345-32;
$narration2=substr($narration,32,$len1);
if($len1345<32)
{
	 $pdf->addText(430,666,8,"$narration1");
}
else {
	

 $pdf->addText(430,666,8,"$narration1");	
 $pdf->addText(430,654,8,"$narration2");
}
	 
	 

	// $pdf->addText(275,620,8,"$so1");
	 
	 
	 $len134=strlen($so1);
$word1=substr($so1,0,32);
$len1=$len134-32;
$word2=substr($so1,32,$len1);
if($len134<32)
{
	$pdf->addText(274,625,8,"$word1");
}
else {
	

$pdf->addText(274,625,8,"$word1");	
$pdf->addText(274,615,8,"$word2"); 
}
	 
	 

	 $pdf->addText(430,620,10,"NA");

	 $pdf->addText(275,580,10,$bookinvoice);

	 $pdf->addText(430,580,10,"NA");

	 $pdf->addText(275,540,10,"NA");

	 $pdf->addText(430,540,10,"NA");
	


     $ik = 490;

     include "config.php";

     $querya = "SELECT * FROM oc_cobi WHERE invoice = '$_GET[id]' order by id";

     $resulta = mysql_query($querya,$conn);

     while($rowa = mysql_fetch_assoc($resulta))

     {

             $description = $rowa['description'];

			 $itemcode = $rowa['code'];
			  $discount = $rowa['discountamount'];
			$damount+=$discount;
             $amount = $rowa['total']; 
			 $amount1+= $amount;

             $totala = $rowa['finaltotal'];

             $temp = $rowa['weight'];
				
            
             $pdf->addText(25,$ik,10,"<b>$description</b>");
			// $pdf->addText(195,$ik,10,"<b>$ps</b>");

            // $pdf->addText(289,$ik,10,"<b>$bags</b>");

             //$pdf->addText(375,$ik,10,changeprice($price));

             $pdf->addText(470,$ik,10,"<b>$discount</b>");

             $pdf->addText(330,$ik,10,"<b>$amount</b>");

            // if($rowa['weight'] && ($rowa['age'])) {
//
//               $ik = $ik - 13;
//
//               $pdf->addText(283,$ik,8,"<b>( $temp Birds )</b>");
//
//             }

			// if($cat == 'Female Birds' or $cat == 'Male Birds' && $_SESSION['db'] == "golden")
//
//			 {
//
//			   $temp = $rowa['quantity'];
//
//               $ik = $ik - 13;
//
//               $pdf->addText(283,$ik,8,"<b>( $temp Birds )</b>");
//
//			 }

             $ik = $ik - 20;

     }

$pdf->addText(223,195,10,"Total");
//$pdf->addText(520,195,10,"<b>$discount</b>");
  $pdf->addText(330,195,10,"<b>$amount1</b>");
   $pdf->addText(470,195,10,"<b>$damount</b>");

     $tbags = changeprice($tbags);

     $total1 = changeprice($totala);

   

     $pdf->addText(520,165,10,"<b>$total1</b>");

     $word = convertNumber($totala);

     $pdf->addText(25,125,10,"<b>$word</b>");
	 $pdf->addText(480,50,10,"<b>$aname</b>");

     $pdf->ezStream(); 



//-----------------------------------------------------------------------------
function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " and "
                            : ", "
                    );
            }
        }

        $output = rtrim($output, ", ");
    }
	$output .= " rupees";
    if ($fraction > 0)
    {
        
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction{$i});
        }
		$output.=" paise";
    }

    return ucwords($output." Only");
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
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



