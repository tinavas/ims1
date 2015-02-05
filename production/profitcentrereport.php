
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>
<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 12px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		text-align:left;
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>

<style type="text/css" media="print">
.printbutton {
  visibility: hidden;
  display: none;
}
</style>
</head>
<body>
<center>
<script>
document.write("<input type='button' " +
"onClick='window.print()' " +
"class='printbutton' " +
"value='Print This Page'/><br /><br />");
</script>
<?php
include "config.php";
$client = $_SESSION['client'];
$presentdate = date("Y-m-d",strtotime($_GET['date']));
$pc = $_GET['pc'];
$fdate = date("Y-m-d",strtotime($_GET['fdate']));
$tdate = date("Y-m-d",strtotime($_GET['tdate']));
$diffdate = (strtotime($tdate) - strtotime($fdate))/(24*60*60);
/////////////////INPUT ITEMS IN THE STOCK///////////////
$query = "SELECT sum(toeggs) as toeggs from ims_eggtransfer where towarehouse in (select type from tbl_sector where sector = '$pc' and client = '$client')|| towarehouse = '$pc' and date < '$presentdate' and tocode LIKE '%EG%' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$toeggs = $rows['toeggs'];
$query = "SELECT sum(quantity) as steggs from ims_stocktransfer where towarehouse in (select type from tbl_sector where sector = '$pc' and client = '$client')|| towarehouse = '$pc'and date < '$presentdate' and cat = 'Hatch Eggs' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$steggs = $rows['steggs'];
$tottoeggs = $steggs + $toeggs;
$query = "SELECT sum(eggsset) as eggsset from hatchery_traysetting where settingdate < '$presentdate' and hatchery = '$pc' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$eggsset = $rows['eggsset'];
$ipitemsstock = $tottoeggs - $eggsset;
/////////////////MARKET PRICE AS ON DATE FOR INPUT ITEM///////////////
$query = "select * from ims_marketprice where profitcentre in (select sector from tbl_sector where profitcentre = '1' and client = '$client') and cat = 'Hatch Eggs' and date = '$presentdate' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$price  = $rows['price'];
/////////////////MANAGMENT COST / INPUT ITEM////////////////////////
$cr = 0;
$dr = 0;
$query="select * from tbl_profitcenter ";
$result=mysql_query($query);
while($row=mysql_fetch_assoc($result))
{$cc=explode(',',$row['costcenter']);
$i=0; while($cc[$i])  
{$cc[$i];
$query1 = "select amount from ac_financialpostings where coacode in (select code from ac_coa where costcentre = '$cc[$i]' and client = '$client') and date between '$fdate' and '$tdate' and crdr = 'Cr' and client = '$client'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($qr1 = mysql_fetch_assoc($result1))
{$cr = $cr + $qr1['amount'];}
$query1 = "select amount from ac_financialpostings where coacode in (select code from ac_coa where costcentre = '$cc[$i]' and client = '$client') and date between '$fdate' and '$tdate' and crdr = 'Dr' and client = '$client'";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($qr1 = mysql_fetch_assoc($result1))
{$dr = $dr + $qr1['amount'];}
$crdr = $dr - $cr;$i++; }}
//////////////////////////////////////////////////////////////////////////////////////
$tdate2 = 21*24*60*60;
$todate = strtotime($tdate) - $tdate2;
$gdate = date("Y-m-d",$todate);
$q1 = "select sum(eggsset) as eggsset from hatchery_traysetting where settingdate between '$fdate' and '$gdate' and client = '$client'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
$rows1 = mysql_fetch_assoc($r1);
$eggsset = $rows1['eggsset'];
$fromdate = strtotime($fdate) - $tdate2;
$hdate = date("Y-m-d",$fromdate);
$eggsset1 = 0;
$q1 = "select * from hatchery_traysetting where settingdate between '$hdate' and '$fdate' and client = '$client'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr1 = mysql_fetch_assoc($r1))
{
$eggsset1 =$qr1['eggsset'];
$setdate = strtotime($qr1['settingdate']);
$frdate = strtotime($fdate);
$t = $frdate - $setdate;
$r44 = ($tdate2 - $t)/(24*60*60);
$r = $r44 + 1;
if($r > $diffdate)
{$ttt = $diffdate;}
else 
{$ttt = $r;}
//echo $eggsset1."/".$ttt;echo "<br/>";
$eggdays += $eggsset1 * $ttt;}
//echo $gdate."/".$fdate;
if($gdate <= $fdate)
{$gdate = $fdate;}

$q1 = "select * from hatchery_traysetting where settingdate between '$gdate' and '$tdate' and client = '$client'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
while($qr1 = mysql_fetch_assoc($r1))
{
$eggsset2 = $qr1['eggsset'];
$setdate2 = strtotime($qr1['settingdate']);
$trdate = strtotime($tdate);
$t2 = $trdate - $setdate2;
$r23 = $t2/(24*60*60);
$r2 = $r23 + 1;
if($r2 > $diffdate)
{$ttt3 = $diffdate;}
else {$ttt3 = $r2;}
$eggdays2 += $eggsset2 * $ttt3; 
}
$total = $eggsset + $eggdays + $eggdays2;
$managementcstperegg = round((($crdr/$total)*21),0);
/////////////////TENTATIVE OUTPUT ITEMS FOR THE STOCK///////////////
$query = "select sum(units) as units from tbl_ioratio where profitcenter in (select sector from tbl_sector where profitcentre = '1') and outputcat = 'Broiler Chicks' and '$presentdate' between fdate and tdate";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$tentativeop  = round((($rows['units']/100)*($ipitemsstock)),2);
/////////////////MARKET RATE/ OUTPUT ITEM///////////////////////////
$query = "select price from ims_marketprice where profitcentre in (select sector from tbl_sector where profitcentre = '1') and cat = 'Broiler Chicks' and date = '$presentdate'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$opmarketprice  = $rows['price'];
//////////////////MINIMUM RATE PER OUTPUT ITEM//////////////////////
$a = (($managementcstperegg+$price) * $ipitemsstock )/$tentativeop;

?>
<div style="width:700px" >
<!-- Header -->
<center>
<table border="1" style="border-color:#000000; padding-left:0px;">
 <tr height="120px">
   <td style="text-align:left; padding-left:30px;">
<?php
session_start();
if($_SESSION['db'] == "bims1")
{
?>
   <table>
    <tr>
	<td width="55">
   <img src="sujaylogo.png" width="50">   </td>
   <td width="126" style="text-align:left"><font size="4">SUJAY<br/>
     FEEDS</font></td></tr>
   <tr>
   <td colspan="2"> #80, "Lavanya Apartments"<br/>1st Floor, 13th Cross,<br/>
   Ganganagar, Bangalore - 560024<br/>Tel: (080) - 23335858<br/>Fax: (080) - 23339786</td></tr>
   </table></td>
 </tr>   
</table>
<?php } ?>
<?php
if($_SESSION['db'] == "souza")
{
?>
<table border="0">
 <tr height="120px">
   <td width="250px" style="text-align:left"><img src="souza.jpg" /></td>
   <td width="450" style="text-align:left;padding-left:150px">
 
<font size="6">Souza Hatcheries</font><br /><br />
Souza Commercial Complex, Highlands,<br />
Falnir Road, Mangalore - 575 002.<br />
Phone: + 91 - 824 - 2432018, 2432192.
   </td>
 </tr>   
</table>
<?php } ?>
<?php
if($_SESSION['db'] == "golden")
{
?>
<table border="0">
 <tr height="120px">
   <td width="250px" style="text-align:left"><img src="logo/thumbnails/golden.png" /></td>
   <td width="450" style="text-align:left;padding-left:150px">
 
<font size="6">Golden Group</font><br /><br />
No.3,Queen's Road Cross,<br />
Near Congress Committee Office,<br />
Bangalore - 560052
   </td>
 </tr>   
</table>
<?php } ?>
<?php
if($_SESSION['db'] == "fpc")
{
?>
<table border="0">
 <tr height="120px">
   <td width="250px" style="text-align:left"><img src="fpc.jpg" /></td>
   <td width="450" style="text-align:left;padding-left:150px">
 
<font size="6">Farmers Poultry Farms</font><br /><br />
Baravanna Devara Mutt Road, Nelamangala,<br />
Pin Code - 562123.
   </td>
 </tr>   
</table>
<?php } 
if($_SESSION['db'] == "bims5")
{
?>
   <table>
    <tr>
	<td width="55"><!--   <img src="sujaylogo.png" width="50">   --></td>
   <td width="126" style="text-align:left"><font size="4">D.Farms<br/>
     &amp; Agros</font></td></tr>
   <tr>
   <td colspan="2"> Alkapura, 1<sup>st</sup>Lane<br/>Behind Gov't ITI,<br/>
   Berhampur, Ganjam Dist. Orrisa</td></tr>
   </table></td>
 </tr>   
</table>
<?php } 

if($_SESSION['db'] == "poultrysms1")
{
?>
   <table>
    <tr>
   <td width="186" style="text-align:left"><font size="4">Pooja Feeds and Farms<br/></font></td></tr>
   <tr>
   <td colspan="2"> Arasikere Road,<br/>Katihalli Industrial Area,<br/>
   Hassan, 573201<br/>
   Ph:- 08172-240118</td></tr>
   </table></td>
 </tr>   
</table>
<?php } ?>

</center><!-- /Header -->
<br/>
<center><h3 >Profit Centre Report for Date: <?php echo $_GET['date']; ?>  <br /></h3></center><br />
<center><h3 >For Unit: <?php echo $_GET['pc']; ?> <br/>Costs Evaluated between&nbsp;&nbsp;<?php echo $_GET['fdate']; ?> &nbsp;&nbsp;and &nbsp;&nbsp;<?php echo $_GET['tdate']; ?><br /></h3></center><br />
<table border="0" style="text-align:left">
 
 <tr>
   <td width="300px">Input items in stock</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $ipitemsstock; ?></td>
  
 </tr>
 
 <tr>
    <td width="300px">Market price as on date for input item</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $price; ?></td>
  
 </tr> 

 <tr>
   <td width="300px">Management cost per input item</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $managementcstperegg; ?></td>
   
 </tr>
 
 <tr>
   <td width="300px">Tentative output items for the stock</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $tentativeop; ?></td>
   
 </tr> 

 
 
 <tr>
   <td width="300px">Minimum rate per output item</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $a; ?></td>
  
 </tr> 

 <tr>
   <td width="300px">Market rate per output item</td>
   <td width="10px">:</td>
   <td width="100px"><?php echo $opmarketprice; ?></td>
 
 </tr> 
 
 
</table>
<br /><br />
</div>
</center>
</body>
</html>