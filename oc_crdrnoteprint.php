<?php
     include_once ('class.ezpdf.php');
	 $type = $_GET['type'];

 if($type == 'Credit') { $mode = 'Customer Credit'; $mode1 = 'CCN'; }
 else if($type == 'Debit') { $mode = 'Customer Debit'; $mode1 = 'CDN'; }
 
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
     $pdf->line(20,770,20,280);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,450,600,450);
     $pdf->setStrokeColor(0,0,0);
	 
     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,280);
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
     $pdf->line(23,704,150,704);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
	   $pdf->setLineStyle(0.5);
     $pdf->line(150,729,150,704);	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//Date BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(460,729,460,704);		//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(460,704,597,704);		//Bottom Line
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
     $pdf->line(295,674,295,480);	//Near Cr/Dr Vertical Line
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(345,674,345,450);	//Near Cr Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);


     $pdf->setLineStyle(0.5);
     $pdf->line(465,674,465,450);	//Near Dr Amount Vertical Line
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

	if($_SESSION['db'] == "albustanlayer")
	 {
	  $pdf->addText(220,750,12,"<b>ALBUSTAN POULTRY FARMS.</b>");
      $pdf->addText(210,735,10,"P.O. Box. 10236,Sweihan Abu Dhabi - U.A.E.");
	 }
	 	

     $pdf->addText(27,712,10,"DATE :");
	 $pdf->addText(462,712,10,"Tr. No. :");
	  $pdf->addText(250,712,10,"<b> $mode Note</b>");
	 $pdf->addText(27,684,10,"Customer :");
	  $pdf->addText(415,684,10,"Total Amount:");
	 $pdf->addText(30,654,10,"<b>PARTICULARS</b>");
	 $pdf->addText(300,654,10,"<b>CR/DR</b>");
	 $pdf->addText(350,654,10,"<b>CR AMOUNT ($currencyunits)</b>");
	  $pdf->addText(470,654,10,"<b>DR AMOUNT ($currencyunits)</b>");
	 $pdf->addText(80,285,10,"PREPARED");
	 $pdf->addText(275,285,10,"APPROVED");
	 $pdf->addText(470,285,10,"AUTHORIZED");
	
	
	 
	 $pdf->addText(30,430,10,"<b>Amount (in words</b>)");
	
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,480,600,480);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);
	
	  $pdf->setLineStyle(0.5);
     $pdf->line(20,400,600,400);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(300,460,10,"<b>TOTAL</b>");

     
     $pdf->setLineStyle(0.5);
     $pdf->line(20,280,600,280);		//Horizontal Line above signatures
     $pdf->setStrokeColor(0,0,0);

  
 include "config.php";
     $trno = $_GET['id'];
session_start();
$finaltotal = 0;
$discount = 0;
$rowindex = 635; 

$query = "SELECT * FROM ac_crdrnote WHERE  crnum = '$trno' AND client = '$client' AND mode = '$mode1' ORDER BY id ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
 $date = $row['date'];
 $vcode = $row['vcode'];
 $vencode = $row['vpcode'];
 $totalamount  = $row['totalamount'];
 $date1 = date("d.m.Y",strtotime($date));
 
 $debit = $row['dramount'];
 $desc = $row['description'];
 $coa = $row['coa'];
 $crdr = $row['crdr'];
 $dramount = $row['dramount'];
 $cramount = $row['cramount'];
 $crtotal = $row['crtotal'];
 $drtotal = $row['drtotal'];
 $narration = "<b>Narration : </b>".$row['remarks'];
 
 $cramount1 = changeprice($cramount);
  $dramount1 = changeprice($dramount); 
  
	 $pdf->addText(30,$rowindex,10,$desc." ( ".$coa." )");	
	 $pdf->addText(300,$rowindex,10,$crdr);	 	 
	 $pdf->addText(350,$rowindex,10,$cramount1);
	 $pdf->addText(470,$rowindex,10,$dramount1);
  $rowindex -= 18;
}
$totalamount1 = changeprice($totalamount);
$crtotal1 = changeprice($crtotal);
 $drtotal1 = changeprice($drtotal);

	 $pdf->addText(65,712,10,"<b>$date1<b>");	 	 
	 $pdf->addText(503,712,10,"<b>$trno<b>");	 
	 $pdf->addText(80,684,10,"$vcode ( $vencode )");
	 $pdf->addText(480,684,10,"$totalamount1");
	 $pdf->addText(350,460,10,"<b>$crtotal1</b>");
	 $pdf->addText(470,460,10,"<b>$drtotal1</b>");
	 
//$word = convert_number($totalamount);
//$pdf->addText(30,410,10,"<b>$word Only</b>");	 

$temp = explode('.',$totalamount);
$rs = $temp[0];
$paisa = $temp[1];	 
$word = convert_number($rs) . " $currencyunits";
if($paisa)
 $word = $word . " and " . convert_number($paisa) . " Fils";
$word .= " Only";

  $width = $pdf->getTextWidth(10,$word);
  for($k = $width,$j = 410;$k>0;$k-=550,$j-=15)
   $word=$pdf->addTextWrap(30,$j,550,10,"$word","justify");
    
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

//$pdf->addText(25,380,10,$narration);
 $width = $pdf->getTextWidth(10,$narration);
 for($j= $width,$y = 380; $j>0; $j -= 550,$y -= 12)
  $narration = $pdf->addTextWrap(25,$y,550,10,$narration,'full');

//PREPARED BORDER	
	 $pdf->setLineStyle(0.5);
     $pdf->line(75,300,75,280);	//LEFT Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(75,300,152,300);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(152,300,152,280);	//Right Line
     $pdf->setStrokeColor(0,0,0);
	
//APPROVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(270,300,270,280);	//lEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,300,347,300);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(347,300,347,280);	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//RECEIVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(465,300,465,280);	//LEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(465,300,538,300);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(538,300,538,280);	//Right Line
     $pdf->setStrokeColor(0,0,0);


     $pdf->setLineStyle(0.5);
     $pdf->line(20,350,600,350);		//Horizontal Line after narration
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

