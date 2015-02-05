<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
include "config.php";
$date = $_GET['date'];
 
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
&nbsp;&nbsp;<a href="details.php?export=html&date=<?php echo $date; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="details.php?export=excel&date=<?php echo $date; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="details.php?export=word&date=<?php echo $date; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="details.php?cmd=reset&date=<?php echo $date; ?>">Reset All Filters</a>
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
			<td style="width:100px;" align="center">rate</td>
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
$medvacc = 0;
$medvacctotal = 0;
$totmedvacc = 0;
$finalmedvacctotal = 0;
$q4="select sum(quantity) as quantity,itemcode from breeder_consumption where date2='$date' and itemcode in(select distinct(code) from ims_itemcodes where cat In ('Medicines','Vaccines') ) group by itemcode";
$r4=mysql_query($q4,$conn1) or die(mysql_error());
while($rows=mysql_fetch_assoc($r4))
{
$medvacc = $rows['quantity'];
$totmedvacc += $medvacc;
$medvaccitemcode = $rows['itemcode'];

$que = "select distinct(cm) as mode from ims_itemcodes where code = '$medvaccitemcode' order by mode";
$res = mysql_query($que,$conn1) or die(mysql_error());
while($row = mysql_fetch_assoc($res))
{
$medvaccmode = $row['mode']; 

$medvaccrate = calculate($medvaccmode,$medvaccitemcode,$date,$medvacc);

$medvacctotal = $medvacc * $medvaccrate; 
$finalmedvacctotal += $medvacctotal;
?>
	<tr>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($date))); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($medvaccitemcode); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice(round($medvacc,2))); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($medvaccrate); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice(round($medvacctotal,2))); ?></td>
	</tr>
<?php
}
}
?>
<tr>
<td align="right" colspan="2" class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(Total); ?></td>
<td class="ewRptGrpField3" align="right">
<?php if($totmedvacc <> '') { echo ewrpt_ViewValue(changeprice(round($totmedvacc,2))); } else { echo '0.00'; } ?></td>
<td class="ewRptGrpField3">&nbsp;</td>
<td align="right" class="ewRptGrpField3">
<?php if($finalmedvacctotal <> '') { echo ewrpt_ViewValue(changeprice(round($finalmedvacctotal,2))); } else { echo '0.00'; } ?></td>
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
