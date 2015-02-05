<?php

     include_once ('class.ezpdf.php');
	 //include_once ('getemployee.php');

     //ezpdf: from http://www.ros.co.nz/pdf/?

     //docs: http://www.ros.co.nz/pdf/readme.pdf

     //note: xy origin is at the bottom left



     //dat

     $colw = array(      70 ,    40,   220,    70,     40  );//column widths

     $rows = array(

         array('company','size','desc','cost','instock'),

         array("WD", "70GB","WD700AAJS SATA2 7200rpm 7mb"        ,"$36.90","Y"),

         array("WD","160GB","WD1600AAJS SATA300 7mb 7200rpm"     ,"$39.77","Y"),

         array("WD", "70GB","700jd SATA2 7200rpm 7mb"            ,"$41.90","Y"),

         array("WD","250GB","WD2500AAKS SATA300 16mb 7200rpm"    ,"$49.77","Y"),

         array("WD","320GB","WD3200AAKS SATA300 16mb 7200rpm"    ,"$49.90","Y"),

         array("WD","160GB","1600YS SATA raid 16mb 7200rpm"      ,"$59.90","Y"),

         array("WD","500GB","500gb WD5000AAKS SATA2 16mb 7200rpm","$64.90","Y"),

         array("WD","250GB","2500ys SATA raid 7200rpm 16mb"      ,"$69.90","Y"),

     );


$type = $_GET['type'];

 if($type == 'Credit') {$mode5 = 'VENDOR CREDIT'; $mode = 'Vendor Credit'; $mode1 = 'VCN';$mode6 = '(VCN)'; }
 else if($type == 'Debit') { $mode5 = 'VENDOR DEBIT';$mode = 'Vendor Debit'; $mode1 = 'VDN';$mode6 = '(VDN)'; }
     


     //x is 0-600, y is 0-770 (origin is at bottom left corner)

     $pdf =& new Cezpdf('LETTER');

 

     ///topmost horizontal line

     $pdf->setLineStyle(0.5);

     $pdf->line(20,789,600,789);

     $pdf->setStrokeColor(0,0,0);



     /////leftmost vertical line

     $pdf->setLineStyle(0.5);

     $pdf->line(20,789,20,428);

     $pdf->setStrokeColor(0,0,0);



     ////bottom horizontal line before total

     

	 

     ///rightmost vertical line

     $pdf->setLineStyle(0.5);

     $pdf->line(600,789,600,428);

     $pdf->setStrokeColor(0,0,0);




//horizontal line after address
$pdf->setLineStyle(1.0);

     $pdf->line(20,735,600,735);		

     $pdf->setStrokeColor(0,0,0);

//total horizontal Lines
$pdf->setLineStyle(0.5);

     $pdf->line(20,719,600,719);		

     $pdf->setStrokeColor(0,0,0);
	 
$pdf->setLineStyle(0.5);

     $pdf->line(20,705,600,705);		

     $pdf->setStrokeColor(0,0,0);

  $pdf->setLineStyle(1.0);

     $pdf->line(20,690,600,690);		

     $pdf->setStrokeColor(0,0,0); 
	 $pdf->setLineStyle(1.0);

     $pdf->line(20,655,600,655);		

     $pdf->setStrokeColor(0,0,0);     
	

	

	$pdf->setLineStyle(1.0);

     $pdf->line(20,630,600,630);		

     $pdf->setStrokeColor(0,0,0);
	   

	 $pdf->setLineStyle(0.5);

     $pdf->line(20,500,600,500);		

     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);

     $pdf->line(20,475,600,475);		

     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);

     $pdf->line(20,450,600,450);		

     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);

     $pdf->line(20,428,600,428);		

     $pdf->setStrokeColor(0,0,0);
	  

// first vertical line

$pdf->setLineStyle(0.5);

     $pdf->line(130,675,130,735);

     $pdf->setStrokeColor(0,0,0);
	 //VERTICAL LINE FOR CHECK
	 $pdf->setLineStyle(0.5);

     $pdf->line(270,705,270,735);

     $pdf->setStrokeColor(0,0,0);
	 //VERTICAL LINE FOR ACCOUNTS CODE
	  $pdf->setLineStyle(1.0);

     $pdf->line(130,500,130,675);

     $pdf->setStrokeColor(0,0,0);
	 //VERTICAL LINE FOR PARTICULARS
	  
	 //VERTICAL LINE AFTER PARTICULARS
	  

//VERTICAL AFTER CHECK
$pdf->setLineStyle(0.5);

     $pdf->line(420,705,420,735);

     $pdf->setStrokeColor(0,0,0);
	 
	 
	 
	 
	 
	 
	  
	 
	 
	 
	 $pdf->setLineStyle(0.5);

     $pdf->line(520,690,520,475);

     $pdf->setStrokeColor(0,0,0);
	 
	 
	 
	 
	  $pdf->setLineStyle(0.5);

     $pdf->line(440,655,440,475);

     $pdf->setStrokeColor(0,0,0);

	//Date BORDER	

      if($type=='Credit')  
   {
   $mode100='CREDITED TO';
   }
   else
   {
    $mode100='DEBITED TO';
   }
//heading
$pdf->addText(27,723,8,"<b>VOUCHER #</b>");
$pdf->addText(27,708,8,"<b>VOUCHER DATE</b>");		 
$pdf->addText(27,695,8,"<b>$mode100</b>");	
$pdf->addText(27,670,8,"<b>NARRATION</b>");	
$pdf->addText(23,640,8,"<b> CODE</b>");


//CHECK HEADING

$pdf->addText(310,723,8,"<b>REFERENCE #</b>");
$pdf->addText(310,708,8,"<b>LOCATION</b>");	
	//Cash Payment Voucher BORDER	

    //AMOUNT
	 $pdf->addText(470,675,8,"<b>AMOUNT</b>");
	 $pdf->addText(470,695,8,"<b></b>");	
	 $pdf->addText(260,640,8,"<b>PARTICULAR</b>");	
	 $pdf->addText(470,640,8,"<b>DR</b>");	
	 $pdf->addText(560,640,8,"<b>CR</b>");	
$pdf->addText(25,480,8,"<b>AMOUNT IN WORDS:</b>");
$pdf->addText(40,455,8,"<b>USERNAME:</b>");	
	 $pdf->addText(50,435,8,"<b>PREPARED BY:</b>");	
	  $pdf->addText(400,435,8,"<b>AUTHORIZED BY:</b>");	
	
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

       $pdf->addText(250,740,10,"No.3,Queen's Road Cross");

       

       

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

       $pdf->addText(225,735,10,"P.O.BOX 7344,RIYADH 11472,KSA.");

	 }
	 

	  //$pdf->addText(200,773,12,"<b>M/s. Mega Poultry Company (P) Limited,</b>");

     
 include "config.php";  

	$q = "select * from home_logo";
$r = mysql_query($q,$conn);
while($qr = mysql_fetch_assoc($r))
{
$im = $qr['image'];
$add = $qr['address'];

}
$img = ImageCreatefromjpeg('logo/thumbnails/LOGO.jpg');
 $pdf->addImage($img,40,747,45,35);
	 

     $pdf->addText(27,77,10,"");

	 $pdf->addText(493,77,10,"");
 $pdf->addText(250,740,9,"<b> $mode5 NOTE $mode6</b>");
	  //$pdf->addText(250,740,9,"<b> </b>");
	  $pdf->addText(490,740,9," PRINT DATE:");
	  $date7=date("d.m.Y");
	  $pdf->addText(550,740,9,"$date7");

	 //$pdf->addText(27,674,7,"Cash Code :");

	 // $pdf->addText(440,674,10,"Acc.No :");

	 $pdf->addText(50,654,7,"<b><b>");
	 
	 $pdf->addText(200,654,7,"<b><b>");
	 
	 $pdf->addText(360,654,7,"<b><b>");

	 $pdf->addText(453,654,7,"");

	 $pdf->addText(500,654,7,"");

	 $pdf->addText(70,325,7,"");

	 $pdf->addText(275,325,7,"");

	 $pdf->addText(470,325,7,"");

	

	

	 

	 $pdf->addText(30,430,7,"");

	 $pdf->addText(30,460,7,"");

	  $pdf->addText(200,460,7,"");

	 

	  

	

	 

 include "config.php";

     $trno = $_GET['id'];

session_start();

$finaltotal = 0;

$discount = 0;

$rowindex = 625; 
$rowindex1 = 615; 


$rowline = 0;
$stopped = 0;
$query = "SELECT * FROM ac_crdrnote WHERE  crnum = '$trno' AND client = '$client' AND mode = '$mode1' ORDER BY id ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
$count = mysql_num_rows($result);
while($row = mysql_fetch_assoc($result))
{ 
 $camount = $row['camount'];
 $tid=$row['crnum'];
 $date = $row['date'];
  $user = $row['addemp'];
   $authorize = strtoupper($row['authorize']);
 $vcode = $row['vcode'];
 $vencode = $row['vpcode'];
 $totalamount  = $row['totalamount'];
 $date1 = date("d.m.Y",strtotime($date));
if($crdr == "Cr")
  $crtotal += $amount = $row['cramount'];
 else
  $drtotal += $amount = $row['dramount']; 

$desc = substr($row['description'],0,50);

  $code= $row['coa'];
 
 if($row['remarks']!="")
 $narration11 = $row['remarks'];
 
$location = substr($row['unit'],0,20);

 $amount = $row['dramount'];

 $crdr = $row['crdr'];

 

  

  

if($mode == "Bank")

{

$q = "SELECT name FROM ac_bankmasters where acno = '$cashcode' and client = '$client'";

$r = mysql_query($q,$conn) or die(mysql_error());

while($qrr = mysql_fetch_assoc($r))

{

$acno  = $cashcode;

$cashcode = $qrr['name'];

}



}

else

{

//$pdf->addText(27,684,12,"Cash Code :");

$q = "SELECT name FROM ac_bankmasters where code = '$cashcode' and client = '$client'";

$r = mysql_query($q,$conn) or die(mysql_error());

while($qrr = mysql_fetch_assoc($r))

{

$cashcode = $qrr['name'];

}

}

 //$finaltotal = $cramount - $dramount;
$amount20=$totalamount;
 $amount1 = changeprice($totalamount);

  
	
 if($crdr =="Cr")

 {

  $amount14+=$row['cramount'];

  $amount11 = $row['cramount'];
  
  $amount11= changeprice($amount11);
   $pdf->addText(530,$rowindex1,8,"<b>$amount11</b>");

 } 

 if($crdr =="Dr")

 {

   
$amount13+=$row['dramount'];
  $amount11 = $row['dramount']; 
  $amount11= changeprice($amount11);
  
   $pdf->addText(445,$rowindex1,8,"<b>$amount11</b>");

 } 
	

	 //$pdf->addText(25,$rowindex,9);	
	 
	 $pdf->addText(175,$rowindex1,8,"<b>$desc</b>");
	 $pdf->addText(45,$rowindex1,8,"<b>$code</b>");

 

  //$dramount += $row['dramount']; 

  




  $rowindex -= 15; 
 $rowindex1 -= 15;


}
//data
$pdf->addText(215,723,8,"<b>$tid<b>");	
$pdf->addText(200,708,8,"<b>$date1<b>");	
$pdf->addText(470,723,8,"<b><b>");	
$pdf->addText(490,708,8,"<b>$location<b>");
$finaltotal = $amount20; 

$finaltotal1 = changeprice($amount20);
$amount13 = changeprice($amount13);	
$amount14 = changeprice($amount14);
$pdf->addText(530,675,8,"<b>$amount1<b>");

//$pdf->addText(140,670,8,"<b>$narration11<b>");


$word=strtoupper($narration11);
$word=strtoupper($word);
$len=strlen($word);
$word1=substr($word,0,60);
$len1=$len-60;
$word2=substr($word,60,$len1);
if($len<60)
{
	$pdf->addText(134,670,7,"$word1 ");
}
else {
	

$pdf->addText(134,670,7,"$word1");	
$pdf->addText(134,660,7,"$word2 "); 
}
$name=$_SESSION['valid_user'];
$name=strtoupper($name);
 
$pdf->addText(90,455,8,"<b>$name<b>");
$pdf->addText(110,435,8,"<b>$user<b>");
$pdf->addText(140,695,8,"<b>$vcode $vencode<b> ");

$pdf->addText(470,435,8,"<b>$authorize<b>");


	 $pdf->addText(65,712,12,"<b><b>");	 	 

	 $pdf->addText(525,712,12,"<b><b>");	 

	 $pdf->addText(100,684,12,"");
	 

	 if($acno <> "")

      

	 $pdf->addText(505,420,12,"<b></b>");

	  $pdf->addText(105,460,12,"<b></b>");

	   $pdf->addText(250,460,12,"<b></b>");

	 

$word = convertNumber($finaltotal);

$word=strtoupper($word);
$len=strlen($word);
$word1=substr($word,0,67);
$len1=$len-67;
$word2=substr($word,67,$len1);
if($len<67)
{
	$pdf->addText(110,480,7,"<b>$word1 ONLY</b>");
}
else {
	

$pdf->addText(110,490,7,"<b>$word1</b>");	
$pdf->addText(110,480,7,"<b>$word2 ONLY</b>"); 
} 
if($amount13==".00")$amount13="";
$pdf->addText(450,480,8,"<b>$amount13</b>");
if($amount14==".00")$amount14="";
$pdf->addText(530,480,8,"<b>$amount14</b>");





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

    return $output;
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


$cheque_amt = 7747474 ; 
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



