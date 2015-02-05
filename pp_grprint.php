<?php
      include_once ('class.ezpdf.php');
	  //ezpdf: from http://www.ros.co.nz/pdf/?
     //docs: http://www.ros.co.nz/pdf/readme.pdf
     //note: xy origin is at the bottom left
     //data
     include "configinvoice.php";
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


     /////for the horizontal line after the company address
     $pdf->setLineStyle(0.5);
     $pdf->line(20,690,600,690);
     $pdf->setStrokeColor(0,0,0);


      /////for the horizontal line after po date
     $pdf->setLineStyle(0.5);
     $pdf->line(20,620,600,620);
     $pdf->setStrokeColor(0,0,0);

     /////for the horizontal line after itemname
     $pdf->setLineStyle(0.5);
     $pdf->line(20,580,600,580);
     $pdf->setStrokeColor(0,0,0);


	 
	 $pdf->addText(238,775,12,"<b>GOODS RECIEPT </b>");
     $pdf->selectFont("fonts/Helvetica.afm");
     $pdf->setColor(0/255,0/255,0/255);
      $pdf->addText(30,670,10,"Date :");
	 $pdf->addText(30,650,10,"WareHouse :");
	 
     $pdf->addText(380,670,10,"GR # :");     
     $pdf->addText(380,650,10,"Vendor :");	
     $pdf->addText(30,600,10,"Item Code");     
     $pdf->addText(140,600,10,"Descrption");
     $pdf->addText(280,600,10,"Units");
	
    
	 	$pdf->addText(350,600,10,"Received Quantity");
	
	 $pdf->addText(520,600,10,"Po");

     
     $invoice = $_GET[id];
session_start();
$finaltotal = 0;
$query = "SELECT date,vendor,ge ,aflag,aempname,po FROM pp_goodsreceipt WHERE  gr = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $party = $row['vendor'];
  $date1 = $row['date'];
  $emp2 = $row['empname'];
  $date1 = date("d.m.Y", strtotime($date1));
  $po=$row['po'];
  
}

$query="SELECT `deliverylocation` FROM `pp_purchaseorder` where `po`='$po'";
$result = mysql_query($query,$conn);
$row = mysql_fetch_assoc($result);
$warehouse = $row['deliverylocation'];
$totqty = 0;
$totbags = 0;
$totala = 0; 
$totalquant = 0;
$query = "SELECT sum(quantity) as totqty,sum(basic) as total, tandc FROM pp_goodsreceipt WHERE  gr = '$invoice'";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
  $totqty = $row['totqty'];
  $total = $row['total'];
  $tandc = $row['tandc'];
}

$query = "SELECT * FROM home_logo "; 
$result = mysql_query($query,$conn); 
while($row1 = mysql_fetch_assoc($result)) 
{ 
$address = $row1['address']; 
}

$address1 = html_entity_decode($address);
$temp = explode('</p>',$address1);
for($i = 0,$j = 770;$i < count($temp); $i++)
{
 $temp2 = preg_replace("/<[^\>]+\>/","",$temp[$i]);
 $width = $pdf->getTextWidth(10,$temp2);
  for($k = $width;$k>0;$k-=250)
  {
   $j-=11;  
   $temp2=$pdf->addTextWrap(25,$j,550,10,"<b>$temp2</b>","center");
  }
}

     $pdf->addText(110,670,10,"<b>$date1</b>");
	  $pdf->addText(110,650,10,"<b>$warehouse</b>");
     $pdf->addText(430,670,10,"<b>$invoice</b>");
     $pdf->addText(430,650,10,"<b>$party</b>");
	 $pdf->addText(110,630,10,"<b>$status</b>");

     $ik = 560; 
	 $tax=$discount=0;
     $totalsquant=0;
     include "config.php";
     $querya = "SELECT code,description,acceptedquantity,receivedquantity,units,po FROM pp_goodsreceipt WHERE gr = '$_GET[id]' order by id";
     $resulta = mysql_query($querya,$conn);
     while($rowa = mysql_fetch_assoc($resulta))
     {
	 		 $code=$rowa['code'];
             $description = $rowa['description'];
			 $sentquantity = $rowa['acceptedquantity'];
             $quantity = $rowa['receivedquantity'];
             $units = $rowa['units'];
			 $po = $rowa['po'];
			 $totalsquant = $totalsquant + $sentquantity;
             $totalquant = $totalquant + $quantity;
			 $query = "select deliverydate from pp_purchaseorder where po = '$po' and description = '$description'";
			 $result1 = mysql_query($query,$conn) or die(mysql_error());
			 $rows = mysql_fetch_assoc($result1);
			 $ddate = date("d.m.Y",strtotime($rows['deliverydate']));
			 $pdf->addText(25,$ik,10,"<b>$code</b>");
             $pdf->addText(105,$ik,10,"<b>$description</b>");
             $pdf->addText(275,$ik,10,"<b>$units</b>");
            
             $pdf->addText(385,$ik,10,"<b>$quantity</b>");
			 $pdf->addText(475,$ik,10,"<b>$po</b>");

             $ik = $ik - 20;
    }
	
	$id = $ik - 50;
	 ////bottom horizontal line before total
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$id,600,$id);
     $pdf->setStrokeColor(0,0,0);
	 $id = $id - 25;

     ////bottom horizontal line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,$id,600,$id);
     $pdf->setStrokeColor(0,0,0);
	 
	 
	      ///vertical line after item Code
     $pdf->setLineStyle(0.5);
     $pdf->line(100,620,100,$id);
     $pdf->setStrokeColor(0,0,0);

	///vertical line after Description
     $pdf->setLineStyle(0.5);
     $pdf->line(270,620,270,$id);
     $pdf->setStrokeColor(0,0,0);
	 
     ///vertical line after units
     $pdf->setLineStyle(0.5);
     $pdf->line(340,620,340,$id);
     $pdf->setStrokeColor(0,0,0);

   
	///vertical line after received qty
     $pdf->setLineStyle(0.5);
     $pdf->line(470,620,470,$id);
     $pdf->setStrokeColor(0,0,0);
	 
	 
	/////leftmost vertical line
     $pdf->setLineStyle(0.5);
     $pdf->line(20,770,20,$id);
     $pdf->setStrokeColor(0,0,0);

     ///rightmost vertical line
     $pdf->setLineStyle(0.5);     
	 $pdf->line(600,770,600,$id);
     $pdf->setStrokeColor(0,0,0);
	 
	 $id = $id + 8;
	 $pdf->addText(235,$id,10,"<b>Total</b>");
	
     $pdf->addText(385,$id,10,"<b>$totalquant</b>");
	 $id = $id - 25;
	 $empname1="ENTERED BY: ".$emp2;

$pdf->addText(25,$id,12,"$empname1");
	 $id = $id - 25;
     $pdf->addText(30,$id,10,"<b>Total Quantity in words :</b>");
     $total1 = changeprice($totalamount);

     $word = convert_number($totalquant);
     $pdf->addText(150,$id,10,"<b>$word Only</b>");

$id = $id - 60;
$kk= $id;
$l = 1;
$kk = $kk - 60;
$kkk = $kk - 20;
$pdf->addText(25,$kk,10,"<b>__________________________</b>");
$pdf->addText(55,$kkk,10,"<b>Accepted By</b>");
$pdf->addText(425,$kk,10,"<b>__________________________</b>");
$pdf->addText(445,$kkk,10,"<b>Authorized Signature</b>");

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



