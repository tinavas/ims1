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
     $pdf->line(20,770,588,770);	//Top Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,400);		//Left Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,400,588,400);	//Bottom Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(588,770,588,400);	//Right Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(273,757,10,"<b>Sender Copy<b>");
	 
    include "config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}
$address1 = html_entity_decode($address);

     if($_SESSION['db'] == "souza") {
       $pdf->addText(25,760,10,"<b>Souza Hatcheries.</b>");
       $pdf->addText(25,745,10,"Souza Commercial Complex,");
       $pdf->addText(25,732,10,"Highlands,Falnir Road,");
       $pdf->addText(25,717,10,"Mangalore - 575002");
       $pdf->addText(25,702,10,"TIN : 29640098794");
     }
	 else if($_SESSION['db'] == "golden")
	 {
	   $pdf->addText(25,760,10,"<b>Golden Group.</b>");
       $pdf->addText(25,745,10,"No.3,Queen's Road Cross,");
       $pdf->addText(25,732,10,"Near Congress Committee Office,");
       $pdf->addText(25,717,10,"Bangalore - 560052");
       
	 }
	 

	 else if($_SESSION['db'] == "sumukh")
	 {
	   $pdf->addText(25,760,10,"<b>SUMUKH HATCHERIES</b>");
       $pdf->addText(25,745,10,"TAMPCS Building,");
       $pdf->addText(25,732,10,"Balraj Urs Road,");
       $pdf->addText(25,717,10,"Shimoga-577201");
       
	 }
	 else if($_SESSION['db'] == "feedatives")
	 {
	   $pdf->addText(25,760,10,"<b>FEEDATIVES</b>");
       $pdf->addText(25,745,10,"2, Jawaharlal Nehru Road,");
       $pdf->addText(25,732,10,"Room no. - 6A/1, 3rd Floor,");
       $pdf->addText(25,717,10,"Kolkata - 700 013, W. B., India.");
       
	 }
	 else if($_SESSION['db'] == "fortress")
	 {
	   $pdf->addText(25,760,10,"<b>FORTRESS</b>");
      $pdf->addText(25,745,10,"Po Box 2358, Arikuyeri Village,");
       $pdf->addText(25,732,10,"Iyana Offa, Dugbe Ibadan Oyo State,");
       $pdf->addText(25,717,10,"Nigeria, Tel: +234 2 7536921, +234 805 319 5155.");
       
	 }
	 else if($_SESSION['db'] == "skdnew")
	 {
	  $pdf->addText(25,760,10,"<b>SKD Consultants</b>");
       $pdf->addText(25,745,10,"Nashik");
	 }
	 else if($_SESSION['db'] == "maharashtra")
	 {
       $pdf->addText(25,755,10,"<b>Maharashtra Feeds and General Commadities</b>");
       $pdf->addText(25,740,10,"Manjunatha Weigh Bridge,Opp.Dairy Petrol Bunk,");
       $pdf->addText(25,727,10,"Dairy Circle, B.M Road,Hassan-573201.");
       $pdf->addText(25,712,10,"Ph:08172-240750, Fax:08172-240850, 9980082750.");
      /* $pdf->addText(25,697,10,"E-mail:mfgc77@gmail.com");
	   $pdf->addText(25,682,10,"TIN No: 29330780147");	 */
	 }
	 else if($_SESSION['db'] == "suriya")
	 {
	   $pdf->addText(25,760,10,"<b>SURIYA POULTRY</b>");
      $pdf->addText(25,745,10,"Katpadi Taluk,");
       $pdf->addText(25,732,10,"Vellore Dist.");
       $pdf->addText(25,717,10,"Tamil nadu-632520.");
       
	 }
	  else if($_SESSION['db'] == "jeeval")
	 {
       $pdf->addText(25,755,10,"<b>JEEVAL ENTERPRISES</b>");
       $pdf->addText(25,740,10,"Office No. 14,Golden Willow,");
       $pdf->addText(25,727,10,"Off. B.R.Road, Near Swapna Nagari,");
       $pdf->addText(25,712,10,"Mulund West Mumbai - 400 080");
      /* $pdf->addText(25,697,10,"E-mail:mfgc77@gmail.com");
	   $pdf->addText(25,682,10,"TIN No: 29330780147");	 */
	 }


     $pdf->setLineStyle(0.5);
     $pdf->line(20,700,588,700);
     $pdf->setStrokeColor(0,0,0);
	 
	 $pdf->addText(30,683,10,"Start Location        : ");
	 $pdf->addText(30,670,10,"Delivery Location  : ");
	 $pdf->addText(30,657,10,"Vehicle Number    : ");
     $pdf->setLineStyle(0.5);
     $pdf->line(20,655,588,655);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(340,700,340,515);	//Page Dividing Line(Half)
     $pdf->setStrokeColor(0,0,0);
	 
	 	 	
		 	 
	 $pdf->addText(345,683,10,"Date     : ");
	 $pdf->addText(345,670,10,"DC No. : ");
	 $pdf->addText(345,657,10,"Driver   : ");

	 $pdf->addText(45,640,10,"Item");
	 $pdf->addText(190,640,10,"Description");
	 $pdf->addText(500,640,10,"Quantity");
	  $pdf->addText(390,640,10,"Units");
	 //$pdf->addText(440,640,10,"Rate");
	 //$pdf->addText(520,640,10,"Amount");

     $pdf->setLineStyle(0.5);
     $pdf->line(20,630,588,630);	//Horizontal Line after Item,qty,rate,amount
     $pdf->setStrokeColor(0,0,0);

     //$pdf->setLineStyle(0.5);
    // $pdf->line(415,655,415,455);	//Vertical Line after Qty.
     //$pdf->setStrokeColor(0,0,0);
	 
	  $pdf->setLineStyle(0.5);
     $pdf->line(464,655,464,514);	//Vertical Line after units.
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(100,655,100,514);	//Vertical Line after item.
     $pdf->setStrokeColor(0,0,0);

    // $pdf->setLineStyle(0.5);
     //$pdf->line(493,655,493,455);	//Vertical Line after Rate
    // $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(30,500,10,"Total Quantity (in words)");
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(20,515,588,515);	//Horizontal Line above discount parameters
     $pdf->setStrokeColor(0,0,0);

	 /*$pdf->addText(420,500,10,"Discount");	 	 
     $pdf->setLineStyle(0.5);
     $pdf->line(415,495,588,495);	//Horizontal Line after discount
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(420,480,10,"Freight");	 
     $pdf->setLineStyle(0.5);
     $pdf->line(415,475,588,475);	//Horizontal Line after freight
     $pdf->setStrokeColor(0,0,0);*/

	 //$pdf->addText(420,460,10,"Net Amount");
	 //$pdf->addText(420,500,10,"Net Amount");

     $pdf->setLineStyle(0.5);
     $pdf->line(20,455,588,455);	//Horizontal Line above signatures
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(100,410,10,"Sender Signature");	 	 
	 $pdf->addText(320,410,10,"Driver Signature");	 
	 /*$pdf->addText(30,415,10,"* Item once sold cannot be taken back");
	 $pdf->addText(30,405,10,"  An egg a day keeps doctor away");*/


	 

     include "config.php";
     $tid = $_GET['tid'];
	 $towar = $_GET['towar'];
session_start();
$finaltotal = 0;
$discount = 0;
$qty1 = 0;
$rowindex = 615; 
$rowindex2 = 235;
$query1 = "SELECT * FROM ims_stocktransfer WHERE  tid = '$tid' and towarehouse = '$towar'  group by tid ORDER BY id ASC";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
   		  $fromwarehouse = $row1['fromwarehouse'];
          $towarehouse = $row1['towarehouse'];
          $dc = $row1['tmno'];
		  if($_SESSION['db'] == 'suriya')
		  $dc = $_GET['tid'];
          $date = date('d/m/Y',strtotime($row1['date']));
		  $vehicleno = $row1['vehicleno'];
		  $driver = $row1['driver'];
		  $tcost = $row1['tcost'];
}
$query1 = "SELECT sum(tcost) as tcost FROM ims_stocktransfer WHERE  tid = '$tid' and towarehouse = '$towar'  ";
$result1 = mysql_query($query1,$conn);
while($row1 = mysql_fetch_assoc($result1))
{
		  $tcost = $row1['tcost'];
}
$tamount = 0;
$query = "SELECT * FROM ims_stocktransfer WHERE tid = '$tid' and towarehouse = '$towar'  order by id asc";
$result = mysql_query($query,$conn) or die(mysql_error());
while($row = mysql_fetch_assoc($result))
{
  			
			 $qty = $row['quantity'];
			 $tounits = $row['tounits'];
			 $code = $row['code'];
			 // $tqty = $tqty + $row['quantity'];
             //$price = changeprice($row['price']);
             // $amount = changeprice($qty * $price);  
			 // $tamount = $tamount + ($qty * $price);
             
		
  
  $query1 = "SELECT description FROM ims_itemcodes WHERE code = '$code' ";
  $result1 = mysql_query($query1,$conn) or die(mysql_error());
  $rows1 = mysql_fetch_assoc($result1);
  $desc = $rows1['description'];
  $code = $code;
 // $codedesc = $desc." ( ".$code. " )";
  $qty1 += $qty;
  
	 $pdf->addText(40,$rowindex,10,$code);
	 $pdf->addText(125,$rowindex,10,$desc);	
	 $pdf->addText(510,$rowindex,10,$qty);	 
	 $pdf->addText(390,$rowindex,10,$tounits);	 
	 //$pdf->addText(450,$rowindex,10,$price);
	// $pdf->addText(520,$rowindex,10,$amount);
	
  $rowindex -= 15; 
	//For Office Copy
	 $pdf->addText(40,$rowindex2,10,$code);	
	 $pdf->addText(125,$rowindex2,10,$desc); 
	 $pdf->addText(510,$rowindex2,10,$qty);	 
	 $pdf->addText(390,$rowindex2,10,$tounits);	
	// $pdf->addText(450,$rowindex2,10,$price);
	// $pdf->addText(520,$rowindex2,10,$amount);
  $rowindex2 -= 15; 

}



//$tcost1 = changeprice($tcost);

$finaltotal = $qty1;
$finaltotal1 = changeprice($finaltotal);
$discount =0;
$freight = 0;
$discount = changeprice($discount);
$freight = changeprice($freight);


	 $pdf->addText(130,683,10,$fromwarehouse);	 	 
	 $pdf->addText(130,670,10,$towarehouse);	 
	 $pdf->addText(130,657,10,$vehicleno);	
	 $pdf->addText(390,683,10,$date);
	 $pdf->addText(390,670,10,$dc);
	 $pdf->addText(390,657,10,$driver);

	 /*$pdf->addText(510,500,10,$discount);	 	 
	 $pdf->addText(510,480,10,$tcost1);	 */
	 //$pdf->addText(510,460,10,"<b>$finaltotal1</b>");
	  $pdf->addText(510,500,10,"<b>$finaltotal1</b>");
	 
$word = convert_number($finaltotal);
$pdf->addText(30,480,12,"<b>$word Only</b>");
	 
	//For Office Copy
	 $pdf->addText(130,303,10,$fromwarehouse);	 	 
	 $pdf->addText(130,290,10,$towarehouse);	 
	 $pdf->addText(130,277,10,$vehicleno);	
	 $pdf->addText(390,303,10,$date);
	 $pdf->addText(390,290,10,$dc);
	  $pdf->addText(390,277,10,$driver);

	 /*$pdf->addText(510,120,10,$discount);	 	 
	 $pdf->addText(510,100,10,$tcost1);*/	 
	 //$pdf->addText(510,80,10,"<b>$finaltotal1</b>");
	  $pdf->addText(510,120,10,"<b>$finaltotal1</b>");
	 
$word = convert_number($finaltotal);
$pdf->addText(30,100,12,"<b>$word Only</b>");	 

	//Office Copy

     $pdf->setLineStyle(0.5);
     $pdf->line(20,390,588,390);	//Top Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,390,20,20);		//Left Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(20,20,588,20);		//Bottom Line
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(588,390,588,20);	//Right Line
     $pdf->setStrokeColor(0,0,0);

     
	 
	 $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
     $pdf->addText(265,375,10,"<b>Receiver Copy<b>");
	 
    include "config.php"; $query = "SELECT * FROM home_logo "; 
     $result = mysql_query($query,$conn1); 
      while($row1 = mysql_fetch_assoc($result)) { $address = $row1['address'];
$image = $row1['image'];}
$address1 = html_entity_decode($address);

     if($_SESSION['db'] == "souza") {
       $pdf->addText(25,378,10,"<b>Souza Hatcheries.</b>");
       $pdf->addText(25,365,10,"Souza Commercial Complex,");
       $pdf->addText(25,352,10,"Highlands,Falnir Road,");
       $pdf->addText(25,337,10,"Mangalore - 575002");
       $pdf->addText(25,322,10,"TIN : 29640098794");
     }
	 else if($_SESSION['db'] == "golden")
	 {
	   $pdf->addText(25,378,10,"<b>Golden Group.</b>");
       $pdf->addText(25,365,10,"No.3,Queen's Road Cross,");
       $pdf->addText(25,352,10,"Near Congress Committee Office,");
       $pdf->addText(25,337,10,"Bangalore - 560052");
       
	 }
	 

	 else if($_SESSION['db'] == "sumukh")
	 {
	   $pdf->addText(25,378,10,"<b>SUMUKH HATCHERIES</b>");
       $pdf->addText(25,365,10,"TAMPCS Building,");
       $pdf->addText(25,352,10,"Balraj Urs Road,");
       $pdf->addText(25,337,10,"Shimoga-577201");
       
	 }
	 else if($_SESSION['db'] == "feedatives")
	 {
	   $pdf->addText(25,378,10,"<b>FEEDATIVES</b>");
       $pdf->addText(25,365,10,"2, Jawaharlal Nehru Road,");
       $pdf->addText(25,352,10,"Room no. - 6A/1, 3rd Floor,");
       $pdf->addText(25,337,10,"Kolkata - 700 013, W. B., India.");
       
	 }
	 else if($_SESSION['db'] == "fortress")
	 {
	   $pdf->addText(25,378,10,"<b>FORTRESS</b>");
      $pdf->addText(25,365,10,"Po Box 2358, Arikuyeri Village,");
       $pdf->addText(25,352,10,"Iyana Offa, Dugbe Ibadan Oyo State,");
       $pdf->addText(25,337,10,"Nigeria, Tel: +234 2 7536921, +234 805 319 5155.");
       
	 }
	 else if($_SESSION['db'] == "skdnew")
	 {
	  $pdf->addText(25,378,10,"<b>SKD Consultants</b>");
       $pdf->addText(25,365,10,"Nashik");
	 }
	 else if($_SESSION['db'] == "maharashtra")
	 {
       $pdf->addText(25,370,10,"<b>Maharashtra Feeds and General Commadities</b>");
       $pdf->addText(25,355,10,"Manjunatha Weigh Bridge,Opp.Dairy Petrol Bunk,");
       $pdf->addText(25,342,10,"Dairy Circle, B.M Road,Hassan-573201.");
       $pdf->addText(25,330,10,"Ph:08172-240750, Fax:08172-240850, 9980082750.");
       /*$pdf->addText(25,297,10,"E-mail:mfgc77@gmail.com");
	   $pdf->addText(25,282,10,"TIN No: 29330780147");*/	 
	 }


 else if($_SESSION['db'] == "suriya")
	 {
	   $pdf->addText(25,370,10,"<b>SURIYA POULTRY</b>");
      $pdf->addText(25,355,10,"Katpadi Taluk,");
       $pdf->addText(25,342,10,"Vellore Dist.");
       $pdf->addText(25,330,10,"Tamil nadu-632520.");
       
	 }
	  else if($_SESSION['db'] == "jeeval")
	 {
       $pdf->addText(25,370,10,"<b>JEEVAL ENTERPRISES</b>");
       $pdf->addText(25,355,10,"Office No. 14,Golden Willow,");
       $pdf->addText(25,342,10,"Off. B.R.Road, Near Swapna Nagari,");
       $pdf->addText(25,330,10,"Mulund West Mumbai - 400 080");
	 }
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(20,320,588,320);
     $pdf->setStrokeColor(0,0,0);
	 
	/* $pdf->addText(30,305,12,"Party    : ");
	 $pdf->addText(30,285,12,"Invoice : ");*/
	 
	 
	  $pdf->addText(30,303,10,"Start Location        : ");
	 $pdf->addText(30,290,10,"Delivery Location  : ");
	 $pdf->addText(30,277,10,"Vehicle Number    : ");	
	 
	
	 

     $pdf->setLineStyle(0.5);
     $pdf->line(20,275,588,275);
     $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(340,320,340,135);	//Page Dividing Line(Half)
     $pdf->setStrokeColor(0,0,0);
	 
	 	 
	 $pdf->setLineStyle(0.5);
     $pdf->line(100,275,100,135);	
     $pdf->setStrokeColor(0,0,0);
	 	 	 
	 /*$pdf->addText(306,305,12,"Date              : ");
	 $pdf->addText(306,285,12,"Book Invoice : ");*/
	 
	  $pdf->addText(345,303,10,"Date     : ");
	 $pdf->addText(345,290,10,"DC No. : ");
	 $pdf->addText(345,277,10,"Driver   : ");

	 $pdf->addText(45,260,10,"Item");
	 $pdf->addText(190,260,10,"Description");
	 $pdf->addText(500,260,10,"Quantity");
	 $pdf->addText(390,260,10,"Units");
	 //$pdf->addText(440,260,10,"Rate");
	// $pdf->addText(520,260,10,"Amount");

     $pdf->setLineStyle(0.5);
     $pdf->line(20,250,588,250);	//Horizontal Line after Item,qty,rate,amount
     $pdf->setStrokeColor(0,0,0);
	 
	 //$pdf->setLineStyle(0.5);
    // $pdf->line(415,275,415,75);	//Vertical Line after Qty.
    // $pdf->setStrokeColor(0,0,0);

     $pdf->setLineStyle(0.5);
     $pdf->line(464,275,464,135);	//Vertical Line after units.
     $pdf->setStrokeColor(0,0,0);

     //$pdf->setLineStyle(0.5);
    // $pdf->line(493,275,493,75);	//Vertical Line after Rate
    // $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(30,120,10,"Total Quantity (in words)");
	 
     $pdf->setLineStyle(0.5);
     $pdf->line(20,135,588,135);	//Horizontal Line above discount parameters
     $pdf->setStrokeColor(0,0,0);

	 /*$pdf->addText(420,120,10,"Discount");	 	 
     $pdf->setLineStyle(0.5);
     $pdf->line(415,115,588,115);	//Horizontal Line after discount
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(420,100,10,"Freight");	 
     $pdf->setLineStyle(0.5);
     $pdf->line(415,95,588,95);		//Horizontal Line after freight
     $pdf->setStrokeColor(0,0,0);*/

	 //$pdf->addText(420,80,10,"Net Amount");
	  //$pdf->addText(420,120,10,"Net Amount");

     $pdf->setLineStyle(0.5);
     $pdf->line(20,75,588,75);		//Horizontal Line above signatures
     $pdf->setStrokeColor(0,0,0);

	 $pdf->addText(100,35,10,"Receiver Signature");	 	 
	 $pdf->addText(320,35,10,"Driver Signature");	 
	 /*$pdf->addText(30,40,10,"* Item once sold cannot be taken back");
	 $pdf->addText(30,30,10,"  An egg a day keeps doctor away");*/

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

