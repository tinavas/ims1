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
       $pdf->addText(225,735,10,"P.O.BOX 8344,RIYADH 11482,KSA.");
	 }
	 else if($_SESSION['db']=="albustan" || $_SESSION['db']=="albustanlayer" )
	 {
	 $pdf->addText(220,750,14,"<b>AL BUSTAN POULTRY FARMS</b>");
	 $pdf->addText(235,735,10,"P.O. Box. 45662,Abu Dhabi - U.A.E.");
	 }
	 else if($_SESSION['db']=="vista" )
	 {
	 $pdf->addText(220,750,14,"<b>Vista Management Services Ltd.
</b>");
	 $pdf->addText(145,735,10,"Plot No. 4, Beside Jyoti Service Station Near Fly Over, Cuttack Road,Bhubaneswar-751006,

");
	 }
	 if($_SESSION['db']=='vista')
	 {
    $pdf->setLineStyle(0.5);
     $pdf->line(250,674,250,480);	//Near Amount CrDr Line
     $pdf->setStrokeColor(0,0,0);
}
	 
     $pdf->addText(27,712,10,"Tr. No. :");
	 $pdf->addText(493,712,10,"DATE :");
	  $pdf->addText(225,712,12,"<b> PAYMENT VOUCHER</b>");
	 //$pdf->addText(27,684,12,"Cash Code :");
	 // $pdf->addText(440,684,10,"Acc.No :");
	 if($_SESSION['db']=='vista')
	 {
	 $pdf->addText(20,654,12,"<b>PARTICULARS<b>");
	 $pdf->addText(270,654,12,"<b>NARRATION<b>");
	 }
	 else {
		  $pdf->addText(180,654,12,"<b>PARTICULARS<b>");
	 }
	 $pdf->addText(420,654,12,"Cr/Dr");
	 $pdf->addText(483,654,12,"AMOUNT ($currencyunits)");
	 
	 
	 $pdf->addText(80,325,12,"PREPARED");
	 $pdf->addText(275,325,12,"APPROVED");
	 $pdf->addText(470,325,12,"RECEIVED");
	
	
	 
	 $pdf->addText(30,430,12,"Amount (in words)");
	 $pdf->addText(30,460,12,"Cheque No :");
	  $pdf->addText(200,460,12,"Payee:");
	 
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

$query = "SELECT * FROM ac_gl WHERE  transactioncode = '$trno' AND client = '$client' and voucher = 'P' ORDER BY id ASC LIMIT 1,100";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{

 $date = $row['date'];
 $date1 = date("d.m.Y",strtotime($date));
 $debit = $row['dramount'];
 $rremarks=$row['rremarks'];
 $desc = $row['description'];
 $amount = $row['dramount'];
 $crdr = $row['crdr'];
 if($crdr == "Cr")
 {
  $cramount += $row['cramount'];
  $amount = $row['cramount'];
 } 
 else
 {
  $dramount += $row['dramount']; 
  $amount = $row['dramount']; 
 } 
  $cashcode = $row['bccodeno'];
  $mode = $row['mode'];
  $cheque = $row['chequeno'];
  $name = $row['name'];
if($mode == "Bank")
{
$q = "SELECT name FROM ac_bankmasters where acno = '$cashcode' and client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qrr = mysql_fetch_assoc($r))
{
$acno  = $cashcode;
$cashcode = $qrr['name'];
}
$pdf->addText(27,684,12,"Bank Code :");
}
else
{
$pdf->addText(27,684,12,"Cash Code :");
$q = "SELECT name FROM ac_bankmasters where code = '$cashcode' and client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qrr = mysql_fetch_assoc($r))
{
$cashcode = $qrr['name'];
}
}
 //$finaltotal = $cramount - $dramount;
 $amount1 = changeprice($amount);
   if($_SESSION['db']=='vista')
   {
	 $pdf->addText(20,$rowindex,10,$desc);
	 
	
	 $pdf->addText(260,$rowindex,10,$rremarks);	
   }
   else {
       $pdf->addText(100,$rowindex,12,$desc);	 
   } 	 
	 $pdf->addText(425,$rowindex,12,$crdr);	 	 
	 $pdf->addText(510,$rowindex,12,$amount1);
  $rowindex -= 18; 

}
$finaltotal = $dramount-$cramount; 
$finaltotal1 = changeprice(($dramount-$cramount));

	 $pdf->addText(65,712,12,"<b>$trno<b>");	 	 
	 $pdf->addText(525,712,12,"<b>$date1<b>");	 
	 $pdf->addText(100,684,12,"$cashcode");
	 //$pdf->addText(480,684,12,"$acno");
	 if($acno <> "")
       $pdf->addTextWrap(0,684,590,12,"A/c No. $acno",'right');
	// else
		//$pdf->addText(440,684,10,"A/c No :");	 	 
	 
	 $pdf->addText(505,420,12,"<b>$finaltotal1</b>");
	  $pdf->addText(105,460,12,"<b>$cheque</b>");
	   $pdf->addText(250,460,12,"<b>$name</b>");
	 
$word = convert_number($finaltotal);
$pdf->addText(30,410,12,"<b>$word Only</b>");	 
 
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

