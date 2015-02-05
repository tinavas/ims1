<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tulasi Technologies</title>
</head>
<?php
session_start();
$po=$_GET['id'];
include "config.php";
//$q="select * from pp_purchaseorder where po='$po'";


$q="select taxvalue,tandc,date,broker,vendor,description, quantity*rateperunit as amount,quantity,discountamount,unit,rateperunit,taxamount,deliverydate,deliverylocation,credittermcode,freightamount,freightie,placedby,purpose from pp_purchaseorder where po='$po' ";
//echo $q;
//echo $q;
$r=mysql_query($q,$conn) or die(mysql_error());
$total=0;$total_vat=0;$total_disc=0;$total_fr=0;
$i=0;
while($a=mysql_fetch_assoc($r))
{
$itemname[$i]=$a['description'];
$amount[$i]=$a['amount'];
$quantity[$i]=$a['quantity'];
$disc[$i]=$a['discountamount'];
$unit[$i]=$a['unit'];
$rateperunit[$i]=$a['rateperunit'];
$previousrateperunit[$i]='no latest po';

$query="select rateperunit from pp_purchaseorder where date<'".$a[date]."' and description='".$a[description]."' and vendor='".$a[vendor]."' order by date desc limit  0,1";
$result=mysql_query($query,$conn) or die(mysql_error());
if($array=mysql_fetch_assoc($result))
  $previousrateperunit[$i]=$array[rateperunit];
  
$deliverydate[$i]=date("d-m-Y",strtotime($a['deliverydate']));
$deliverylocation[$i++]=$a['deliverylocation'];
if($i==1)
{
$supplier=$a['vendor'];
$broker=$a['broker'];
$date=date("d-m-Y",strtotime($a['date'])); 
$tndconditions=$a["tandc"];
$purpose=$a[purpose];
$placedby=$a[placedby];
}
$creditterm = $a['credittermcode'];
$temp1 = ($a['amount'] - $a['discountamount']);
$vat = ($temp1 * $a['taxvalue'] ) / 100;
$total_vat += $vat;
$total_disc+=$a['discountamount'];;
$total+=$a['amount']+$vat-$a['discountamount'];

$total_fr += $a[freightamount];
//if($a[freightie]=='included')
   $total += $a[freightamount];
//else
  // $total += $a[freightamount];
}


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
    //echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    //echo $e->getMessage();
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

<style>
#main_body{ min-height:100px; width:900px; margin:10px; border:solid 0.5px #000000;}
#heading{padding-top:#5px; letter-spacing:1px; font-weight:bold; font-size:26px;}
#address{padding-top:#1px; padding-bottom:10px; letter-spacing:1px; font-size:18px;border-bottom:solid 0.5px #000000;}
#colums{ padding-top:-2px;font-weight:bold; padding:10px; border-right:solid 0.5px #000000;border-bottom:solid 0.5px #000000;}
#colums_last{font-weight:bold; padding:0px;border-bottom:solid 0.5px #000000;}
#colums_values{ min-height:20px; padding:5px; border-right:solid 0.5px #000000;}
#colums_values_last{ min-height:20px; padding:5px;}
#total{ min-height:20px; padding:5px; font-weight:bold; border-right:solid 0.5px #000000;}
#total_last{ min-height:20px; padding:5px; font-weight:bold;}
#vat{ margin-top:10px; min-height:20px; padding:5px; font-weight:bold; border-right:solid 0.5px #000000;}
#vat_last{ padding-top:10px; min-height:20px; padding:5px; font-weight:bold;}
#disc{ min-height:20px; padding:5px; border-bottom:solid 0.5px #000000; font-weight:bold; border-right:solid 0.5px #000000;}
#disc_last{ min-height:20px; border-bottom:solid 0.5px #000000; padding:5px; font-weight:bold;}
#top_content{padding-top:#1px; letter-spacing:1px; font-size:18px;border-bottom:solid 0.5px #000000;}
#top_content_div{margin:5px 5px 5px 5px;}
</style>
<body><center>
<table id="main_body">
<tr align="center"><td id="heading" colspan="7"><?php echo $_SESSION['client'] ?></td></tr>

<?php if($_SESSION['client']=="FEEDATIVES") { ?>
<tr align="center"><td id="address" colspan="7">46. Chanditolla Street,<br>
UTTARPARA - 712 258. W.R.
VAT NO: 19733499096</td></tr>
<?php }?>
<?php if($_SESSION['client']=="GOLDEN") { ?>
<tr align="center"><td id="address" colspan="7">
Golden Group,<br />

No.3, Queen's Road Cross, Near Congress Committee Office,<br>

Bangalore, Karnataka-560052</td></tr>
<?php }?>


<tr align="center">
<td id="top_content" colspan="7">
<div id="top_content_div">
<span style="float:left"><label ><b>Supplier Name :</b></label><label><?php echo $supplier; ?></label></span>
<span style="float:right;  margin-right:50px "><label ><b>PO # :</b></label><label style=""><?php echo $po; ?></label><br /></span><br />

<span style="float:left"><label ><b>Broker Name :</b></label><label><?php echo $broker; ?></label></span>
<span style="float:right; margin-right:50px"><label><b>Date:</b></label><label style=""><?php echo $date ?></label></span>
<br />

<span style="float:left"><label ><b>Placed By :</b></label><label><?php echo $placedby; ?></label></span>
<span style="float:right; margin-right:50px"><label><b>Credit Term:</b></label><label style=""><?php echo $creditterm; ?></label></span>
</div>
</td></tr>
<tr><td id="colums" width="210px">Item Name</td>
<td id="colums">Quantity/Kg</td><td id="colums">Units</td><td width="60px" id="colums">Price/Unit/Kg</td><td id="colums" width="100px">Amount</td><td id="colums" width="80px">Delivery Date</td><td id="colums_last">Delivery Location</td>
</tr>
<?php 
for($i=0;$i<mysql_num_rows($r);$i++) {?>
<tr><td id="colums_values"><?php echo $itemname[$i]; ?></td>
<td id="colums_values"><?php echo $quantity[$i]; ?></td><td id="colums_values"><?php echo $unit[$i] ?></td><td align="right" id="colums_values"><?php echo $rateperunit[$i]; ?></td><td align="right" id="colums_values"><?php echo changeprice($amount[$i]); ?></td><td id="colums_values"><?php echo $deliverydate[$i]; ?></td><td id="colums_values_last"><?php echo $deliverylocation[$i]; ?></td>
</tr>

<?php if($previousrateperunit[$i]!='no latest po'){ ?>
<tr height="2px" style="font-size:90%"><td id="colums_values">&nbsp;</td><td id="colums_values">&nbsp;</td><td colspan="2" align="right" id="colums_values"><?php echo 'Latest PO Rate' ?>(<?php echo $previousrateperunit[$i]; ?>)</td><td id="colums_values">&nbsp;</td><td id="colums_values">&nbsp;</td><td id="colums_values_last">&nbsp;</td>
</tr>
<?php } ?>

<?php }?>
<tr><td id="vat" style="padding-left:95px">Discount</td>
<td id="vat"></td><td id="vat"></td><td id="vat"></td><td align="right" id="vat"><?php echo changeprice($total_disc) ?></td><td id="vat"></td><td id="vat_last"></td>
</tr>

<tr><td id="vat" style="padding-left:100px">VAT/CST</td>
<td id="vat"></td><td id="vat"></td><td id="vat"></td><td align="right" id="vat"><?php echo changeprice($total_vat) ?></td><td id="vat" ></td><td id="vat_last"></td>
</tr>

<tr><td id="disc" style="padding-left:100px">Freight</td>
<td id="disc"></td><td id="disc"></td><td id="disc"></td><td align="right" id="disc"><?php echo changeprice($total_fr) ?></td><td id="disc" ></td><td id="disc_last"></td>
</tr>


<tr><td id="total" style="padding-left:75px">Total</td>
<td id="total"></td><td id="total"></td><td id="total"></td><td align="right" id="total"><?php echo changeprice($total) ?></td><td id="total"></td><td id="total_last"></td>
</tr>
</table>

<label style=" float:left; margin-left:50px"><b>Total in words :</b></label><label style=" float:left; margin-left:10px"><?php echo convert_number($total) ?> only</label><br><br />
<?php if($tndconditions!="") { ?>
<label style=" float:left; margin-left:50px"><b>Terms & Conditions</b></label><br />
<label style="float:left; margin-left:50px; text-align:left;"><?php
$temp = explode(',',$tndconditions);
for($i = 0;$i<count($temp);$i++)
 if(strlen($temp[$i]) > 2)
 echo ($i+1).". ".$temp[$i]."<br>";
?></label> <?php } ?><br />
<br />
<?php if($purpose!="") { ?>
<label style=" float:left; margin-left:50px"><b>Purpose</b></label><br />
<label style="float:left; margin-left:50px; text-align:left;"><?php echo $purpose ?></label> <?php } ?><br />

<br /><br />

<label style=" float:left; margin-left:60px; text-align:left;"><b>___________________</b></label><label style=" float:right; margin-right:73px"><b>___________________</b></label><br />
<label style=" float:left; margin-left:80px"><b>Accepted By</b></label><label style=" float:right; margin-right:80px"><b>Authorized Signature</b></label>

</body>
</html>
