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
     $pdf->line(23,729,23,677);	//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	   $pdf->setLineStyle(0.5);
     $pdf->line(23,704,160,704);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);
	 
	   $pdf->setLineStyle(0.5);
     $pdf->line(160,704,160,677);	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//Date BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(490,704,490,677);		//Left Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(490,704,597,704);		//Bottom Line
	  $pdf->setStrokeColor(0,0,0);
	  
	  $pdf->setLineStyle(0.5);
     $pdf->line(597,729,597,677);		//Right Line
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
	 
	 



     $pdf->setLineStyle(0.5);
     $pdf->line(23,677,597,677);		//Bottom Line
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


     $pdf->selectFont("fonts/Helvetica.afm");
   

     include "configinvoice.php";
     $gr = $_GET[id];
session_start();
 $currencyunits=$_SESSION['currency'];
$finaltotal = 0;
 $totalaccqty = 0;
  $totalrecqty = 0;
  $totshrinkage = 0;


	 if($_SESSION['db'] == "central")
	 {
	  $pdf->addTextWrap(0,750,600,14,"<b>CENTRAL POULTRY 2000 LTD.</b>","center");
       $pdf->addTextWrap(0,735,600,10,"MALAWI","center");
	 }
	 elseif($_SESSION['db'] == "centralfeeds")
	 {
	  $pdf->addTextWrap(0,750,600,14,"<b>CP FEEDS</b>","center");
       $pdf->addTextWrap(0,735,600,10,"Lilongwe.","center");
	 }
	else if($_SESSION['db'] == 'feedatives')
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
	 
	 
	 
     $pdf->addText(27,689,10,"Tr. No. :");
	 $pdf->addText(493,689,10,"DATE :");
	 $pdf->addText(245,712,12,"<b> JOURNAL VOUCHER</b>");
	 $pdf->addText(100,654,10,"<b>PARTICULARS</b>");
	 $pdf->addText(395,654,10,"<b>DR AMOUNT ($currencyunits)</b>");
	 $pdf->addText(500,654,10,"<b>CR AMOUNT ($currencyunits)</b>");
	
		 
 
include "config.php";
$trno = $_GET['id'];
session_start();
$finaltotal = 0;
$discount = 0;
$rowindex = 635; 

$rowline = 0;
$stopped = 0;
$query = "SELECT * FROM ac_gl WHERE  transactioncode = '$trno' AND client = '$client' and voucher = 'J' ORDER BY id ASC";
$result = mysql_query($query,$conn) or die(mysql_error());
$count = mysql_num_rows($result);
while($row = mysql_fetch_assoc($result))
{ $rowline++;
  if($rowline == 26)
  {
   $stopped = 1;
   $stoppedrow = 25;
   break;
  } 

 $coacode = $row['code'];
 $date = $row['date'];
 $date1 = date("d.m.Y",strtotime($date));
 $debit = $row['dramount'];
 $desc = $row['description'];
 $crdr = $row['crdr'];
 $remarks = $row['rremarks'];
 if($crdr == "Cr")
  $crtotal += $amount = $row['cramount'];
 else
  $drtotal += $amount = $row['dramount']; 
  $cashcode = $row['bccodeno'];
  $mode = $row['mode'];
  $cheque = $row['chequeno'];
  $name = $row['name'];
  $unit = $row['costcenter'];
  $bi = $row['vouchernumber'];
//if($mode == "Bank")
{
$q = "SELECT * FROM ac_bankmasters where acno = '$cashcode' and client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qrr = mysql_fetch_assoc($r))
{
$cashbankname = $qrr['name'];
$acno  = $qrr['acno'];
}
}
 $finaltotal += $amount;
 $amount1 = changeprice($amount);
  
	 $pdf->addText(30,$rowindex,10,$desc);	 
	 $pdf->addText(330,$rowindex,10,$unit);
	 //$pdf->addText(200,$rowindex,8,$remarks);
	
	if($crdr == 'Dr')
	{
	 $width = $pdf->getTextWidth(10,$amount1);	
	 $pdf->addText((480-$width),$rowindex,10,$amount1);
	}
	if($crdr == 'Cr')
	{
	 $width = $pdf->getTextWidth(10,$amount1);	
	 $pdf->addText((590-$width),$rowindex,10,$amount1);
	}
	
  $rowindex -= 18; 
}

if($count < 10)
 $rowindex -= (10-$count) * 18;
 
	 $pdf->setLineStyle(0.5);
    // $pdf->line(300,674,300,$rowindex);	//After Particulars Vertical Line
     $pdf->setStrokeColor(0,0,0);

	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line BEFORE Cheque No.
     $pdf->setStrokeColor(0,0,0);
	 
	if($bi <> "")
	 {
      
	  $pdf->addText(27,684,12,"Voucher No : $bi");
	 } 

	 $pdf->addText(65,689,12,"<b>$trno</b>");	 	 
	 $pdf->addText(525,689,12,"<b>$date1</b>");	 
	 if($mode == 'Cash')
	 {
      $pdf->addTextWrap(0,684,590,12,"Cash: $cashbankname",'right');
	  $pdf->addText(27,684,12,"Cash Code : $cashcode");
	 } 
	 elseif($mode == 'Bank')
	 {
	  $pdf->addTextWrap(0,684,590,12,"Bank: $cashbankname",'right');
	  $pdf->addText(27,684,12,"Bank Code : $cashcode");
	 }
	 
if($stopped == 0)
{
	 $rowindex -= 20;
	 //$pdf->addText(30,$rowindex,12,"Cheque No : <b>$cheque</b>");
	 //$pdf->addText(200,$rowindex,12,"Payee: <b>$name</b>");
	 $pdf->addText(300,$rowindex,12,"TOTAL");
	 $finaltotal1 = changeprice($crtotal);
	 $width = $pdf->getTextWidth(12,$finaltotal1);	
	 $pdf->addText((590-$width),$rowindex,12,"<b>$finaltotal1</b>");
	 $finaltotal1 = changeprice($drtotal);
	 $width = $pdf->getTextWidth(12,$finaltotal1);	
	 $pdf->addText((480-$width),$rowindex,12,"<b>$finaltotal1</b>");
	 
	 $rowindex -=15;
	 $pdf->setLineStyle(0.5);
     $pdf->line(490,674,490,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);
     $pdf->line(390,674,390,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);

	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);
	 
	 $rowindex -= 20;
	 $pdf->addText(30,$rowindex,12,"Amount (in words)");
	 $rowindex -= 20;
	 
$temp = explode('.',$crtotal);
$rs = $temp[0];
$paisa = $temp[1];	 
$word = convert_number($rs) . " $currencyunits";
if($paisa)
 $word = $word . " and " . convert_number($paisa) . " Fils";
$word .= " Only";
	 
	 //$pdf->addText(30,$rowindex,10,"<b>$word</b>");	 
  $width = $pdf->getTextWidth(10,$word);
  for($k = $width,$j = $rowindex;$k>0;$k-=550,$j-=15)
   $word=$pdf->addTextWrap(30,$j,550,10,"$word","justify");
  $rowindex = $j + 15;	

	 
	 $rowindex -= 15;
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line above signatures
	 
	 $rowindex -= 60;
//PREPARED BORDER	
	 $pdf->setLineStyle(0.5);
     $pdf->line(75,$rowindex,75,($rowindex - 25));	//LEFT Line
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(75,$rowindex,152,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(152,$rowindex,152,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);
	
//APPROVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(270,$rowindex,270,($rowindex - 25));	//lEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,$rowindex,347,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(347,$rowindex,347,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//AUTHORIZED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(465,$rowindex,465,($rowindex - 25));	//LEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(465,$rowindex,550,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(550,$rowindex,550,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);

	 $rowindex -= 20;
	 $pdf->addText(80,$rowindex,12,"PREPARED");
	 $pdf->addText(275,$rowindex,12,"APPROVED");
	 $pdf->addText(470,$rowindex,12,"AUTHORIZED");
	 
	 $rowindex -= 5;
     /////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,$rowindex);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
	 
     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
}	 
while($stopped == 1)
{
	 //$rowindex -=15;
	 $pdf->setLineStyle(0.5);
     $pdf->line(490,674,490,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);
     $pdf->line(390,674,390,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);
     /////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,$rowindex);
     $pdf->setStrokeColor(0,0,0);
     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
	 
     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
	 $rowindex -= 30;
	$pdf->addTextWrap(0,$rowindex,570,10,"(Contd...)","right");
	$pdf->addTextWrap(0,775,585,10,"Page - ".$pdf->ezGetCurrentPageNumber()
,"right");

	//2nd Page
	$pdf->ezNewPage();	
$pdf->line(20,770,600,770);
//HEADER BORDER
 $pdf->line(23,767,597,767);	//Top Line
$pdf->line(23,767,23,729);	//Left Line
$pdf->line(23,729,597,729);	//Bottom Line
$pdf->line(597,767,597,729);	//Right Line

//Tr.No. BORDER	
$pdf->line(23,729,23,677);	//Left Line
$pdf->line(23,704,160,704);	//Bottom Line
$pdf->line(160,704,160,677);	//Right Line

//Date BORDER	
$pdf->line(490,704,490,677);		//Left Line
$pdf->line(490,704,597,704);		//Bottom Line
$pdf->line(597,729,597,677);		//Right Line
//Cash Payment Voucher BORDER	
$pdf->line(222,729,222,704);		//Left Line
$pdf->line(222,704,390,704);		//Bottom Line
$pdf->line(390,729,390,704);	//Right Line


$pdf->line(23,677,597,677);		//Bottom Line

//PARTICULARS BORDER	
$pdf->line(20,674,600,674);	//Top Line
$pdf->line(23,702,23,677);	//Left Line
 $pdf->line(20,650,600,650);	//Bottom Line

	 if($_SESSION['db'] == "central")
	 {
	  $pdf->addTextWrap(0,750,600,14,"<b>CENTRAL POULTRY 2000 LTD.</b>","center");
       $pdf->addTextWrap(0,735,600,10,"MALAWI","center");
	 }
	 elseif($_SESSION['db'] == "centralfeeds")
	 {
	  $pdf->addTextWrap(0,750,600,14,"<b>CP FEEDS</b>","center");
       $pdf->addTextWrap(0,735,600,10,"Lilongwe.","center");
	 }
	else if($_SESSION['db'] == 'feedatives')
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
	 
     $pdf->addText(27,689,10,"Tr. No. :");
	 $pdf->addText(493,689,10,"DATE :");
	  $pdf->addText(245,712,12,"<b> JOURNAL VOUCHER</b>");
	 $pdf->addText(100,654,10,"<b>PARTICULARS</b>");
	 $pdf->addText(395,654,10,"<b>DR AMOUNT ($currencyunits)</b>");
	 $pdf->addText(500,654,10,"<b>CR AMOUNT ($currencyunits)</b>");

$rowindex = 635; 

$rowline = 0;
$stopped = 0;
$query = "SELECT * FROM ac_gl WHERE  transactioncode = '$trno' AND client = '$client' and voucher = 'J' ORDER BY id ASC LIMIT $stoppedrow,1000";
$result = mysql_query($query,$conn) or die(mysql_error());
$count = mysql_num_rows($result);
while($row = mysql_fetch_assoc($result))
{ $rowline++;
  if($rowline == 26)
  {
   $stopped = 1;
   $stoppedrow += 25;
   break;
  }
 $coacode = $row['code'];
 $date = $row['date'];
 $date1 = date("d.m.Y",strtotime($date));
 $debit = $row['dramount'];
 $desc = $row['description'];
 $crdr = $row['crdr'];
 if($crdr == "Cr")
  $crtotal += $amount = $row['cramount'];
 else
  $drtotal += $amount = $row['dramount']; 
  $cashcode = $row['bccodeno'];
  $mode = $row['mode'];
  $cheque = $row['chequeno'];
  $name = $row['name'];
  $unit = $row['costcenter'];
  $bi = $row['vouchernumber'];
 
//if($mode == "Bank")
{
$q = "SELECT * FROM ac_bankmasters where acno = '$cashcode' and client = '$client'";
$r = mysql_query($q,$conn) or die(mysql_error());
while($qrr = mysql_fetch_assoc($r))
{
$cashbankname = $qrr['name'];
$acno  = $qrr['acno'];
}
}
 $finaltotal += $amount;
 $amount1 = changeprice($amount);
  
	 $pdf->addText(30,$rowindex,10,$desc);	 
	 $pdf->addText(330,$rowindex,10,$unit);
	
	if($crdr == 'Dr')
	{
	 $width = $pdf->getTextWidth(10,$amount1);	
	 $pdf->addText((480-$width),$rowindex,10,$amount1);
	}
	if($crdr == 'Cr')
	{
	 $width = $pdf->getTextWidth(10,$amount1);	
	 $pdf->addText((590-$width),$rowindex,10,$amount1);
	}
	
  $rowindex -= 18; 
}
	 
if($count < 10)
 $rowindex -= (10-$count) * 18;
 


	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line BEFORE Cheque No.
     $pdf->setStrokeColor(0,0,0);
	 
	if($bi <> "")
	 {
      
	  $pdf->addText(27,684,12,"Voucher No : $bi");
	 } 

	 $pdf->addText(65,689,12,"<b>$trno</b>");	 	 
	 $pdf->addText(525,689,12,"<b>$date1</b>");	 
	 if($mode == 'Cash')
	 {
      $pdf->addTextWrap(0,684,590,12,"Cash: $cashbankname",'right');
	  $pdf->addText(27,684,12,"Cash Code : $cashcode");
	 } 
	 elseif($mode == 'Bank')
	 {
	  $pdf->addTextWrap(0,684,590,12,"Bank: $cashbankname",'right');
	  $pdf->addText(27,684,12,"Bank Code : $cashcode");
	 }	 
	 
	 //$pdf->addText(30,$rowindex,12,"Cheque No : <b>$cheque</b>");
	 //$pdf->addText(200,$rowindex,12,"Payee: <b>$name</b>");
if($stopped == 0)
{
$pdf->addTextWrap(0,775,585,10,"Page - ".$pdf->ezGetCurrentPageNumber()
,"right");
	 $rowindex -= 20;
	 $pdf->addText(300,$rowindex,12,"TOTAL");
	 $finaltotal1 = changeprice($crtotal);
	 $width = $pdf->getTextWidth(12,$finaltotal1);	
	 $pdf->addText((590-$width),$rowindex,12,"<b>$finaltotal1</b>");
	 $finaltotal1 = changeprice($drtotal);
	 $width = $pdf->getTextWidth(12,$finaltotal1);	
	 $pdf->addText((480-$width),$rowindex,12,"<b>$finaltotal1</b>");
	 
	 $rowindex -=15; 
	 $pdf->setLineStyle(0.5);
     $pdf->line(490,674,490,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);
	 $pdf->setLineStyle(0.5);
     $pdf->line(390,674,390,$rowindex);	//Near Amount Vertical Line
     $pdf->setStrokeColor(0,0,0);

	 $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line BEFORE Amount
     $pdf->setStrokeColor(0,0,0);
	 
	 $rowindex -= 20;
	 $pdf->addText(30,$rowindex,12,"Amount (in words)");
	 $rowindex -= 20;
	 
$temp = explode('.',$crtotal);
$rs = $temp[0];
$paisa = $temp[1];	 
$word = convert_number($rs) . " $currencyunits";
if($paisa)
 $word = $word . " and " . convert_number($paisa) . " Fils";
$word .= " Only";
	 
	// $pdf->addText(30,$rowindex,10,"<b>$word</b>");	 
  $width = $pdf->getTextWidth(10,$word);
  for($k = $width,$j = $rowindex;$k>0;$k-=550,$j-=15)
   $word=$pdf->addTextWrap(30,$j,550,10,"$word","justify");
  $rowindex = $j + 15;	
	 
	 $rowindex -= 15;
     $pdf->line(20,$rowindex,600,$rowindex);		//Horizontal Line above signatures
	 
	 $rowindex -= 60;
//PREPARED BORDER	
	 $pdf->setLineStyle(0.5);
     $pdf->line(75,$rowindex,75,($rowindex - 25));	//LEFT Line
     $pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(75,$rowindex,152,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(152,$rowindex,152,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);
	
//APPROVED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(270,$rowindex,270,($rowindex - 25));	//lEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(270,$rowindex,347,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(347,$rowindex,347,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);

	//AUTHORIZED BORDER	
     $pdf->setLineStyle(0.5);
     $pdf->line(465,$rowindex,465,($rowindex - 25));	//LEFT Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(465,$rowindex,550,$rowindex);		//TOP Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(550,$rowindex,550,($rowindex - 25));	//Right Line
     $pdf->setStrokeColor(0,0,0);

	 $rowindex -= 20;
	 $pdf->addText(80,$rowindex,12,"PREPARED");
	 $pdf->addText(275,$rowindex,12,"APPROVED");
	 $pdf->addText(470,$rowindex,12,"AUTHORIZED");
	 $rowindex -= 5;
 }	 
	 
     /////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,$rowindex);
     $pdf->setStrokeColor(0,0,0);

     ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$rowindex,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
	 
     ///rightmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(600,770,600,$rowindex);
     $pdf->setStrokeColor(0,0,0);
	 //$rowindex += 5;
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

