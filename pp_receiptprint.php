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
     $pdf->line(20,770,20,320);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,450,600,450);
     $pdf->setStrokeColor(0,0,0);
	 
     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,320);
     $pdf->setStrokeColor(0,0,0);


	 
//HEADER BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(23,767,597,767);	//Top Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(23,767,23,729);	//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(23,729,597,729);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(597,767,597,729);	//Right Line
     $pdf->setStrokeColor(0,0,0);
	
	
	//Tr.No. BORDER	
	  $pdf->setLineStyle(0.5);
     $pdf->line(23,729,23,704);	//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	   $pdf->setLineStyle(0.5);
     $pdf->line(23,704,120,704);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
	   $pdf->setLineStyle(0.5);
     $pdf->line(120,729,120,704);	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//Date BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(490,729,490,704);		//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(490,704,597,704);		//Bottom Line
	  $pdf->setStrokeColor(0,0,0);
	  
	  $pdf->setLineStyle(0.5);
     $pdf->line(597,729,597,704);		//Right Line
	  $pdf->setStrokeColor(0,0,0);
	  
		 
	//Cash Payment Voucher BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(222,729,222,704);		//Left Line
     $pdf->setStrokeColor(0,0,0);
	
	 $pdf->setLineStyle(0.5);
     $pdf->line(222,704,390,704);		//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(390,729,390,704);	//Right Line
     $pdf->setStrokeColor(0,0,0);
	 
	 

	//DEBIT BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(23,703,597,703);	//Top Line
     $pdf->setStrokeColor(0,0,0);

    
    $pdf->setLineStyle(0.5);
     $pdf->line(23,703,23,677);		//Left Line
     $pdf->setStrokeColor(0,0,0);


     $pdf->setLineStyle(0.5);
     $pdf->line(23,677,597,677);		//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(597,702,597,677);		//Right Line
     $pdf->setStrokeColor(0,0,0);
	 
	 
	 
   //PARTICULARS BORDER	
   
  
     $pdf->setLineStyle(0.5);
     $pdf->line(20,674,600,674);	//Top Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(23,702,23,677);	//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,650,600,650);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);

$pdf->setLineStyle(0.5);
     $pdf->line(470,674,470,400);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);
   
$pdf->setLineStyle(0.5);
     $pdf->line(400,674,400,480);	//Near Amount CrDr Line
     $pdf->setStrokeColor(0,0,0);

    

     $pdf->selectFont("fonts/Helvetica.afm");
   

     include "configinvoice.php";
     $gr = $_GET[id];
session_start();
 $currencyunits=$_SESSION['currency'];
$finaltotal = 0;
 $totalaccqty = 0;
  $totalrecqty = 0;
  $totshrinkage = 0;

	if($_SESSION['db'] == 'feedatives')
	{
	  $pdf->addText(230,755,14,"<b>Feedatives Pharma Pvt. Ltd.</b>");
       $pdf->addText(265,740,10,"46. Chanditolla Street");
       
	
	}
    else if($_SESSION['db'] == "souza") {
       $pdf->addText(250,755,14,"<b>Souza Hatcheries</b>");
       $pdf->addText(245,740,10,"Souza Commercial Complex");
       
     }
	 else if($_SESSION['db'] == "golden")
	 {
	   $pdf->addText(250,755,14,"<b>GOLDEN GROUP</b>");
       $pdf->addText(250,740,10,"No.3,Queen's Road Cross,");
       
	 }
	 else if($_SESSION['db'] == "skdnew")
	 {
	  $pdf->addText(250,755,14,"<b>SKD CONSULTANTS</b>");
       $pdf->addText(290,740,10,"NASHIK");
	 }
	 else if($_SESSION['db'] == "central")
	 {
	  $pdf->addText(220,750,14,"<b>CENTRAL POULTRY 2000 LTD.</b>");
       $pdf->addText(290,735,10,"MALAWI");
	 }
	 else if($_SESSION['db'] == "alkhumasiyabrd")
	 {
	  $pdf->addText(220,750,14,"<b>AL-KHUMASIA COMPANY,</b>");
       $pdf->addText(225,735,10,"P.O.BOX 8344,RIYADH 11482,KSA.");
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
     $pdf->addText(27,712,10,"Tr. No. :");
	 $pdf->addText(493,712,10,"DATE :");
	  $pdf->addText(275,712,12,"<b> RECEIPT </b>");
	 //$pdf->addText(27,684,12,"Cash Code :");
	 // $pdf->addText(440,684,10,"Acc.No :");
	 $pdf->addText(180,654,12,"<b>PARTICULARS<b>");
	 $pdf->addText(420,654,12,"Cr/Dr");
	 $pdf->addText(483,654,12,"AMOUNT ($currencyunits)");
	 $pdf->addText(80,325,12,"PREPARED");
	 $pdf->addText(275,325,12,"APPROVED");
	 $pdf->addText(470,325,12,"RECEIVED");
	
	
	 
	 $pdf->addText(30,430,12,"Amount (in words)");
	 $pdf->addText(30,460,12,"Cheque No :");
	  $pdf->addText(200,460,12,"Cheque Date:");
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,480,600,480);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);
	
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,400,600,400);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(425,420,12,"TOTAL");

     
$pdf->setLineStyle(0.5);
     $pdf->line(20,320,600,320);		//Horizontal Line above signatures
     $pdf->setStrokeColor(0,0,0);

  
 include "config.php";
     $trno = $_GET['id'];
session_start();
$finaltotal = 0;
$discount = 0;
$rowindex = 635; 

$query = "SELECT * FROM oc_receipt WHERE  tid = '$trno' AND client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
$username=$row['aempname'];
 $date = $row['date'];
 $date1 = date("d.m.Y",strtotime($date));
 $amount = $row['amount'];
 $desc = $row['party'];
 $crdr = $row['dr'];
 
 if($row['flag']==1)
 $aname=$row['aempname'];
 
 $uname=$row['addemp'];

 $cashcode = $row['description'];
 $acno = $row['code'];
  $mode = $row['paymentmode'];
  $cheque = $row['cheque'];
  $cdate = date("d.m.Y",strtotime($row['cdate']));
  $name = $row['name'];
if($mode == "Cheque")
 $pdf->addText(27,684,12,"Bank Code :");
else
 $pdf->addText(27,684,12,"Cash Code :");

 //$finaltotal = $cramount - $dramount;
 $amount1 = changeprice($amount);
  
	 $pdf->addText(40,$rowindex,12,$desc);	 	 
	 $pdf->addText(425,$rowindex,12,$crdr);	 	 
	 $pdf->addText(510,$rowindex,12,$amount1);
  $rowindex -= 18; 

}
$finaltotal1 = changeprice($amount);

	 $pdf->addText(65,712,12,"<b>$trno<b>");	 	 
	 $pdf->addText(525,712,12,"<b>$date1<b>");	 
	 $pdf->addText(100,684,12,"$cashcode");
	 //$pdf->addText(480,684,12,"$acno");
	 if($mode == "Cheque")
       $pdf->addTextWrap(0,684,590,12,"A/c No. $acno",'right');
	// else
		//$pdf->addText(440,684,10,"A/c No :");	 	 
	 
	 $pdf->addText(505,420,12,"<b>$finaltotal1</b>");
	 if($mode == "Cheque") {
	  $pdf->addText(105,460,12,"<b>$cheque</b>");
	   $pdf->addText(280,460,12,"<b>$cdate</b>");
	 }
	 
$word = convertNumber($amount);
$pdf->addText(30,410,12,"<b>$word</b>");	 

    
/*  $pdf->addText(25,350,10,"<b>Terms & Conditions</b>");
$t  = explode(',',$tandc);
$siz = sizeOf($t); 
$kk= 320;
$l = 1;



$kk = $kk - 60;
$kkk = $kk - 20;
$pdf->addText(25,$kk,10,"<b>__________________________</b>");
$pdf->addText(55,$kkk,10,"<b>Accepted By</b>");
$pdf->addText(425,$kk,10,"<b>__________________________</b>");
$pdf->addText(445,$kkk,10,"<b>Authorized Signature</b>");*/

//PREPARED BORDER	
	 $pdf->setLineStyle(0.5);
     $pdf->line(75,340,75,320);	//LEFT Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(75,340,152,340);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(152,340,152,320);	//Right Line
     $pdf->setStrokeColor(0,0,0);
	
//APPROVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(270,340,270,320);	//lEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,340,347,340);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(347,340,347,320);	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//RECEIVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(465,340,465,320);	//LEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(465,340,538,340);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(538,340,538,320);	//Right Line
     $pdf->setStrokeColor(0,0,0);

$pdf->addTextWrap(0,10,595,8,"Prepared by $username ",'right') ;
$pdf->addText(80,350,12,"<b>$uname</b>");
	 $pdf->addText(275,350,12,"<b>$aname</b>");
	 $pdf->addText(470,350,12,"");
	
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
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

?>

