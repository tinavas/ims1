<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
include "config.php";
$date = $_GET['date'];
$production = $_GET['production'];
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Medicines/Vaccines Consumed</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Date </font></strong><?php echo date($datephp,strtotime($date)); ?>&nbsp;&nbsp;</td>
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
&nbsp;&nbsp;<a href="details1.php?export=html&date=<?php echo $date; ?>&production=<?php echo $production; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="details1.php?export=excel&date=<?php echo $date; ?>&production=<?php echo $production; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="details1.php?export=word&date=<?php echo $date; ?>&production=<?php echo $production; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="details1.php?cmd=reset&date=<?php echo $date; ?>&production=<?php echo $production; ?>">Reset All Filters</a>
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
	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Itemcode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Itemcode</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Rate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Rate</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
$cgfeedmedvacc = 0;
$cgfeedtotmedvacc = 0;
$totcgfeedmedvacc = 0;
$finalcgfeedtotmedvacc = 0;
$q8 = "select sum(quantity) as quantity,itemcode from layer_consumption  where date2 = '$date' and itemcode in(select distinct(code) from ims_itemcodes where description <> 'chick' and description <> 'grower' and cat in('Medicines','Vaccines')) and flock in ($production) group by itemcode";
$result8 = mysql_query($q8,$conn1) or die(mysql_error());
while($cgfeed8 = mysql_fetch_assoc($result8))
{
$cgfeedmedvacc = $cgfeed8['quantity'];
$totcgfeedmedvacc += $cgfeedmedvacc;
$cgfeedmedvaccitemcode = $cgfeed8['itemcode'];


$que1 = "select distinct(cm) as mode from ims_itemcodes where code = '$cgfeedmedvaccitemcode' order by mode";
$res1 = mysql_query($que1,$conn1) or die(mysql_error());
while($res11 = mysql_fetch_assoc($res1))
{
 $cgfeedmedvaccmode = $res1['mode'];

$cgfeedtotmedvaccrate = calculate($cgfeedmedvaccmode,$cgfeedmedvaccitemcode,$x_date1,$cgfeedmedvacc);

$cgfeedtotmedvacc = $cgfeedmedvacc * $cgfeedtotmedvaccrate;
$finalcgfeedtotmedvacc += $cgfeedtotmedvacc;
?>
	<tr>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($date))) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($cgfeedmedvaccitemcode); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice(round($cgfeedmedvacc,2))); ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($cgfeedtotmedvaccrate <> '') { echo ewrpt_ViewValue($cgfeedtotmedvaccrate); } else { echo '0.00'; } ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($cgfeedtotmedvacc <> '') { echo ewrpt_ViewValue($cgfeedtotmedvacc); } else { echo '0.00'; } ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td align="right" colspan="2" class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(Total); ?></td>
<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice(round($totcgfeedmedvacc,2))); ?></td>
<td class="ewRptGrpField3">&nbsp;</td>
<td align="right" class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(changeprice(round($finalmedvacctotal,2))); ?></td>
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
	var tdate = document.getElementById('todate').value;
	document.location = "templet.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>