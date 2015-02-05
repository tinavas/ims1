
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
$cat = $_GET['cat'];
/////////////////INPUT ITEMS IN THE STOCK///////////////
$query = "SELECT sum(toeggs) as toeggs from ims_eggtransfer where towarehouse in (select type from tbl_sector where sector = '$pc' and client = '$client')|| towarehouse = '$pc' and date < '$presentdate' and tocode in(select distinct(code) from ims_itemcodes where cat = '$cat') and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$toeggs = $rows['toeggs'];
$query = "SELECT sum(quantity) as steggs from ims_stocktransfer where towarehouse in (select type from tbl_sector where sector = '$pc' and client = '$client')|| towarehouse = '$pc'and date < '$presentdate' and cat = '$cat' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$steggs = $rows['steggs'];
$tottoeggs = $steggs + $toeggs;
if($cat == "Hatch Eggs")
{
$ty = "Breeder";
$output = "Broiler Chicks";
}
else
{
$ty = "Layer Breeder";
$output = "Layer Chicks";
}
$query = "SELECT sum(eggsset) as eggsset from hatchery_traysetting where settingdate < '$presentdate' and hatchery = '$pc' and client = '$client' and hetype = '$ty'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$eggsset = $rows['eggsset'];
$ipitemsstock = $tottoeggs - $eggsset;
/////////////////MARKET PRICE AS ON DATE FOR INPUT ITEM///////////////
$query = "select * from ims_marketprice where profitcentre in (select distinct(sector) from tbl_sector where profitcentre = '1' and client = '$client') and cat = '$cat' and date = '$presentdate' and client = '$client'";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$price  = $rows['price'];
/////////////////MANAGMENT COST / INPUT ITEM////////////////////////
$cr = 0;
$dr = 0;

$query1 = "select sum(amount) as cramount from ac_financialpostings where (warehouse in(select distinct(costcenter) from tbl_profitcenter where profitcenter = '$pc' and client = '$client') || warehouse = '$pc') and client = '$client' and (date between '$fdate' and '$tdate') and crdr = 'Cr' and client = '$client' and coacode in (select distinct(code) from ac_coa where schedule = 'Indirect Expenses')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$qr1 = mysql_fetch_assoc($result1);
$cr = $qr1['cramount'];
$query1 = "select sum(amount) as dramount from ac_financialpostings where (warehouse in(select distinct(costcenter) from tbl_profitcenter where profitcenter = '$pc' and client = '$client') || warehouse = '$pc') and date between '$fdate' and '$tdate' and crdr = 'Dr' and client = '$client' and coacode in (select distinct(code) from ac_coa where schedule = 'Indirect Expenses')";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
$qr1 = mysql_fetch_assoc($result1);
$dr = $qr1['dramount'];
$crdr = $dr - $cr; 
//////////////////////////////////////////////////////////////////////////////////////
$tdate2 = 21*24*60*60;
$todate = strtotime($tdate) - $tdate2;
$gdate = date("Y-m-d",$todate);
 $q1 = "select sum(eggsset) as eggsset from hatchery_traysetting where settingdate between '$fdate' and '$gdate' and client = '$client'";
$r1 = mysql_query($q1,$conn) or die(mysql_error());
$rows1 = mysql_fetch_assoc($r1);
$eggsset = $rows1['eggsset'] * 21;
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
$eggdays += $eggsset1 * $ttt;}
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
$y = explode('-',$fdate);
$d1 = $y[2];
$m1 = $y[1];
$i = explode('-',$tdate);
$d2 = $i[2];
$m2 = $i[1];
$dif = $m2 - $m1;
if($dif > 1)
{
$query3 = "select sum(totalsal) as totsal from hr_salary_payment where (month1 > '$m1' and month1 < '$m2') and name in (select distinct(name) from hr_employee where client = '$client' and (sector in(select type from tbl_sector where sector = '$pu' and client = '$client') || sector = '$pc')) and client = '$client'";
$result3 = mysql_query($query3,$conn) or die(mysql_error());
$rows3 = mysql_fetch_assoc($result3);
$totsal = $rows3['totsal'];
}

$query3a = "select sum(totalsal) as totsal from hr_salary_payment where (month1 = '$m1') and name in (select distinct(name) from hr_employee where client = '$client' and (sector in(select type from tbl_sector where sector = '$pu' and client = '$client') || sector = '$pc')) and client = '$client'";
$result3a = mysql_query($query3a,$conn) or die(mysql_error());
$rows3a = mysql_fetch_assoc($result3a);
 $totsal1 = $rows3a['totsal']/$d1;

$query3b = "select sum(totalsal) as totsal from hr_salary_payment where (month1 = '$m2') and name in (select distinct(name) from hr_employee where client = '$client' and (sector in(select type from tbl_sector where sector = '$pu' and client = '$client') || sector = '$pc')) and client = '$client'";
$result3b = mysql_query($query3b,$conn) or die(mysql_error());
$rows3b = mysql_fetch_assoc($result3b);
$totsal2 = $rows3b['totsal']/$d2;

$hrfinalsal = $totsal + $totsal1 + $totsal2;
$crdr = $crdr + $hrfinalsal;
$total = $eggsset + $eggdays + $eggdays2;
//echo $crdr."/".$total;
$managementcstperegg = round((($crdr/$total)*21),0);
/////////////////TENTATIVE OUTPUT ITEMS FOR THE STOCK///////////////
$query = "select sum(units) as units from tbl_ioratio where profitcenter in (select sector from tbl_sector where profitcentre = '1') and inputcat  = '$cat' and '$presentdate' between fdate and tdate";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$tentativeop  = round((($rows['units']/100)*($ipitemsstock)),2);
/////////////////MARKET RATE/ OUTPUT ITEM///////////////////////////
$query = "select price from ims_marketprice where profitcentre in (select sector from tbl_sector where profitcentre = '1') and cat = '$output' and date = '$presentdate'";
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

 ?>

</center><!-- /Header -->
<br/>
<center><h3 >Hatchery Profit Centre Report for Date: <?php echo $_GET['date']; ?>  <br /></h3></center><br />
<center><h3 >For Unit: <?php echo $_GET['pc']; ?> <br/>Costs Evaluated between&nbsp;&nbsp;<?php echo $_GET['fdate']; ?> &nbsp;&nbsp;and &nbsp;&nbsp;<?php echo $_GET['tdate']; ?><br /></h3></center><br />
<table border="0" style="text-align:left">
 
 <tr>
   <td width="300px">Input items in stock</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($ipitemsstock <> "") { echo $ipitemsstock;} else {echo "0";} ?></td>
  
 </tr>
 
 <tr>
    <td width="300px">Market price as on date for input item</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($price <> "") { echo $price;} else {echo "0";} ?></td>
  
 </tr> 

 <tr>
 <td width="300px"><a href="hatcherymanagementcostcalc.php?date=<?php echo $_GET['date'];?>&unit=<?php echo $_GET['pc']; ?>&fdate=<?php echo $_GET['fdate']; ?>&tdate=<?php echo $_GET['tdate']; ?>&cat=<?php echo $_GET['cat']; ?>">Management cost per input item</a></td>
   <td width="10px">:</td>
   <td width="100px"><?php if($managementcstperegg <> "") { echo round($managementcstperegg,2);} else {echo "0";} ?></td>
   
 </tr>
 
 <tr>
   <td width="300px">Tentative output items for the stock</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($tentativeop <> "") { echo $tentativeop;} else {echo "0";} ?></td>
   
 </tr> 

 
 
 <tr>
   <td width="300px">Minimum rate per output item</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($a <> "") { echo round($a,2);} else {echo "0";} ?></td>
  
 </tr> 

 <tr>
   <td width="300px">Market rate per output item</td>
   <td width="10px">:</td>
   <td width="100px"><?php if($opmarketprice <> "") { echo $opmarketprice;} else {echo "0";} ?></td>
 
 </tr> 
 
 
</table>
<br /><br />
</div>
</center>
</body>
</html>