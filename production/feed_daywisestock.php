<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";
include "getemployee.php";
 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
 
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Day wise Raw Material Stock Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr> 
</table>

<?php
session_start();
$client = $_SESSION['client'];
?>
<?php
$sExport = @$_GET["export"]; // Load export request
if ($sExport == "html") {
	// Printer friendly
}
if ($sExport == "excel") {
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
}
if ($sExport == "word") {
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.doc');
}
?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="feed_daywisestock.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="feed_daywisestock.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="feed_daywisestock.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="feed_daywisestock.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if (@$sExport == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>Date</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Raw Material
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Raw Material</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Opening Stock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Opening Stock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Purchased
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Purchased</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Consumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Closing Stock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Closing Stock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		No. of Productions
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">No. of Productions</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Average Ratio
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Average Ratio</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$i = -1;
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $arrayfeed[++$i] = $rows['feedtype'];
$countfeedtypes = count($arrayfeed);

$query = "SELECT sector,type FROM tbl_sector WHERE type1 = 'Feedmill'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$warehouse = $rows['type'];
$feedmill = $rows['sector'];

$i = -1; $codes = "'',";
$query1 = "SELECT DISTINCT(ingredient),quantity,feedtype FROM feed_fformula WHERE formulaid IN (SELECT distinct(formulaid) FROM `feed_productionunit` f1 WHERE mash IN (SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype) AND formulaid = (SELECT formulaid FROM feed_productionunit f2 WHERE f2.mash = f1.mash ORDER BY date DESC LIMIT 1 )) AND quantity >= 0 ORDER BY ingredient";
	//The query will give all the raw materials with latest (feed formula with production)
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $arraycode[++$i] = $rows1['ingredient'];
 $arrayqty[$rows1['feedtype']][$rows1['ingredient']] = $rows1['quantity'];
 $codes .= "'".$rows1['ingredient']."',";
}
$codes = substr($codes,0,-1);
$uniquecodes = array_unique($arraycode,SORT_STRING);

for($i = 0; $i < count($arraycode); $i++) 
{ 
 $code = $uniquecodes[$i];
 if($code <> "")
 {
 $query2 = "SELECT description,cat FROM ims_itemcodes WHERE code = '$code'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $description = $rows2['description'];
 $cat = $rows2['cat'];
 $op = $purchased = $consumed = 0;

 $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$code' AND date < '$fromdate' AND warehouse = '$warehouse' AND dflag = '0'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
  $op += $rowop['quantity'];
 if($op == "") $op = 0;

  $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$code' AND date < '$fromdate' and po in (select distinct(po) from pp_purchaseorder where deliverylocation = '$warehouse') ";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
   $op += $rowop['quantity'];
  if($op == "") $op = 0;

  $getop = "SELECT SUM(quantity) as quantity FROM feed_itemwise WHERE ingredient = '$code' AND date < '$fromdate' AND flag = '0' AND feedmill = '$feedmill' and pid in (select distinct(id) from feed_productionunit where date < '$fromdate' and feedmill = '$feedmill')";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
  $op -= $rowop['quantity'];
  if($op == "") $op = 0;

  $getop = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE code = '$code' AND date < '$fromdate' AND warehouse = '$warehouse'";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
   $op -= $rowop['quantity'];
  if($op == "") $op = 0;

  $getop = "SELECT SUM(quantity) as quantity FROM oc_salesreturn WHERE code = '$code' AND type ='addtostock' and cobi in (select distinct(invoice) from oc_cobi where warehouse = '$warehouse') AND date < '$fromdate'";
  $result = mysql_query($get,$conn1);
  $row = mysql_fetch_assoc($result);
   $op += $row['quantity'];
  if($op == "") $op = 0;

  $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date < '$fromdate' AND warehouse = '$warehouse' and riflag = 'R'";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
    $op += $rowop['quantity'];
  if($op == "") $op = 0;

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date < '$fromdate' AND unit = '$warehouse' and type = 'Add'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $op += $rowop['quantity'];
 if($op == "") $op = 0;

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date < '$fromdate' AND unit = '$warehouse' and type = 'Deduct'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $op -= $rowop['quantity'];
 if($op == "") $sop = 0;

 $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date < '$fromdate' AND warehouse = '$warehouse' and riflag = 'I'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $op -= $rowop['quantity'];
 if($op == "") $op = 0;

if($cat == 'Medicines')  
  $getop = "SELECT sum(medicine_quantity) as quantity FROM broiler_daily_entry WHERE medicine_name = '$code' AND entrydate < '$fromdate' AND farm = '$farm'";
elseif($cat == 'Vaccines')
  $getop = "SELECT sum(vaccine_quantity) as quantity FROM broiler_daily_entry WHERE vaccine_name = '$code' AND entrydate < '$fromdate' AND farm = '$farm'";
if($cat == 'Medicines' OR $cat == 'Vaccines')
{
  $resultop = mysql_query($getop,$conn1) or die(mysql_error());
  $rowop = mysql_fetch_assoc($resultop);
   $op -= $rowop['quantity'];
} 

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date < '$fromdate' and towarehouse = '$warehouse'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $op += $rowop['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date < '$fromdate' and fromwarehouse = '$warehouse'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
  $op -= $rowop['quantity'];
	//End of Opening


 $get = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$code' AND date = '$fromdate' AND warehouse = '$warehouse' AND dflag = '0'";
 $result = mysql_query($get,$conn1);
 $row = mysql_fetch_assoc($result);
   $purchased = $row['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date >= '$fromdate' AND  date <= '$todate' and unit = '$warehouse' and type = 'Add'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $purchased  += $rowop['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$x_code' AND date >= '$fromdate' AND  date <= '$todate' and warehouse = '$warehouse' and riflag = 'R'";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
   $purchased  += $rowop['quantity'];

 $getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$code' AND date = '$fromdate' and po in (select distinct(po) from pp_purchaseorder where deliverylocation = '$warehouse' )";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
  $purchased += $rowop['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date = '$fromdate' and towarehouse = '$warehouse'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
  $purchased += $rowop['quantity'];

 $get = "SELECT SUM(quantity) as quantity FROM feed_itemwise WHERE ingredient = '$code' AND date = '$fromdate' AND flag = '0' AND feedmill = '$feedmill' and pid in (select distinct(id) from feed_productionunit where date = '$fromdate' and feedmill = '$feedmill' )";
 $result = mysql_query($get,$conn1);
 $row = mysql_fetch_assoc($result);
   $consumed += $row['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$code' AND date >= '$fromdate' AND  date <= '$todate' and unit = '$warehouse' and type = 'Deduct'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
  $consumed  += $rowop['quantity'];

 $getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$code' AND date >= '$fromdate' AND  date <= '$todate' and warehouse = '$warehouse' and riflag = 'I'";
 $resultop = mysql_query($getop,$conn1);
 $rowop = mysql_fetch_assoc($resultop);
   $consumed += $rowop['quantity'];  

if($cat == 'Medicines')  
  $getop = "SELECT sum(medicine_quantity) as quantity FROM broiler_daily_entry WHERE medicine_name = '$code' AND entrydate >= '$fromdate' AND  entrydate <= '$todate' AND farm='$farm'";
elseif($cat == 'Vaccines')
  $getop = "SELECT sum(vaccine_quantity) as quantity FROM broiler_daily_entry WHERE vaccine_name = '$code' AND entrydate >= '$fromdate' AND  entrydate <= '$todate' AND farm = '$farm'";
if($cat == 'Medicines' OR $cat == 'Vaccines')
{
  $resultop = mysql_query($getop,$conn1);
  while($rowop = mysql_fetch_assoc($resultop))
  {
   $consumed += $rowop['quantity'];
  }
}

  $getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$code' AND date = '$fromdate' and fromwarehouse = '$warehouse'";
  $resultop = mysql_query($getop,$conn1);
  $rowop = mysql_fetch_assoc($resultop);
   $consumed += $rowop['quantity'];

  $get = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE code = '$code' AND date = '$fromdate' AND warehouse = '$warehouse'";
  $result = mysql_query($get,$conn1);
  $row = mysql_fetch_assoc($result);
  $consumed += $row['quantity'];
   
  $get = "SELECT SUM(quantity) as quantity FROM oc_salesreturn WHERE code = '$code' AND type ='addtostock' and cobi in (select distinct(invoice) from oc_cobi where warehouse = '$warehouse') AND date = '$fromdate' ";
  $result = mysql_query($get,$conn1);
  $row = mysql_fetch_assoc($result);
  $consumed += $row['quantity'];
  
  /////////getting the values between dates/////////

$closing = $op + $purchased - $consumed;
  
  //Average feed quantity for the particular ingredient
  $total = 0;
  for($j = 0; $j < count($arrayfeed); $j++)
   $total += $arrayqty[$arrayfeed[$j]][$code];
  $avg = $total / $countfeedtypes;
//echo $description."**".$total."**".$countfeedtypes;
  $totalavg += $avg;  
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($description) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($op)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($purchased)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($consumed)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($closing)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice1(round($closing/$avg))); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($avg)); ?></td>
	</tr>
<?php
 }
}
?>
	<tr>
		<td class="ewRptGrpField2" colspan="6" align="right"><b>
<?php echo ewrpt_ViewValue("Total") ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php echo ewrpt_ViewValue(changeprice($totalavg)); ?></b></td>
	</tr>
<tr height="10px"></tr>
	<tr>
	<td colspan="3" valign="top">
	<table class="ewTable ewTableSeparate" >
	<tbody>
	<tr class="ewTableHeader">
		<td class="ewRptGrpField2" colspan="2" align="center"><b>
<?php echo ewrpt_ViewValue("Purchases") ?></b></td>
	</tr>
	<tr>
		<td class="ewRptGrpField2" align="center"><b>
<?php echo ewrpt_ViewValue("Item") ?></b></td>
		<td class="ewRptGrpField2" align="center"><b>
<?php echo ewrpt_ViewValue("Quantity") ?></b></td>
	</tr>
<?php
$query = "SELECT sum(receivedquantity) as quantity,description FROM pp_sobi WHERE code IN ($codes) AND date = '$fromdate' GROUP BY description ORDER by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $totalqty += $rows['quantity'];
 ?>
 <tr>
		<td class="ewRptGrpField2" align="left">
<?php echo ewrpt_ViewValue($rows['description']) ?></td>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue(changeprice1($rows['quantity'])) ?></td> 
</tr>
 <?php
}
?>
	<tr>
		<td class="ewRptGrpField2" align="right"><b>
<?php echo ewrpt_ViewValue("Total") ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php echo ewrpt_ViewValue(changeprice1($totalqty)); ?></b></td>
	</tr>
	</tbody>
	</table>
</td>
<!-- Productions -->
<td colspan="4" valign="top">
<table class="ewTable ewTableSeparate" >
<tbody>
	<tr class="ewTableHeader" >
		<td class="ewRptGrpField2" colspan="<?php echo $countfeedtypes; ?>" align="center"><b>
<?php echo ewrpt_ViewValue("Productions") ?></b></td>
	</tr>
	<tr>
	<?php for($i = 0; $i < count($arrayfeed); $i++) { ?>
		<td class="ewRptGrpField2" align="center"><b>
<?php echo ewrpt_ViewValue($arrayfeed[$i]) ?></b></td>
	<?php } ?>
	</tr>
<?php
for($i = 0; $i < count($arrayfeed); $i++) {
$query = "SELECT sum(batches) as quantity FROM feed_productionunit WHERE mash = '$arrayfeed[$i]' AND date = '$fromdate'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$totalbatches += $rows['quantity'];
$batches = $rows['quantity'];
if($batches == "") $batches = 0;
 ?>
		<td class="ewRptGrpField2" align="center">
<?php echo $batches; ?></td>
 <?php
}
?>
	<tr>
		<td class="ewRptGrpField2" colspan="<?php echo $countfeedtypes - 1; ?>" align="right"><b>
<?php echo ewrpt_ViewValue("Total") ?></b></td>
		<td class="ewRptGrpField1" align="right"><b>
<?php echo changeprice1($totalbatches); ?></b></td>
	</tr>
	</tbody>
</table>
</td>
</tr>
	
	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "feed_daywisestock.php?fromdate=" + fdate;
}
</script>