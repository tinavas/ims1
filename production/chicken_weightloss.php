<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Weight Loss</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="chicken_weightloss.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chicken_weightloss.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chicken_weightloss.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chicken_weightloss.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Opening</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Purchasees
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Purchases</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sales</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Closing</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Actual Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Actual Closing</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight Loss %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight Loss %</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$pdate = date("Y-m-d",(strtotime($fromdate) - (24 * 60 * 60)));
$query = "SELECT code,description FROM ims_itemcodes WHERE cat LIKE '%Birds%'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $code = $rows['code'];
 $query1 = "SELECT quantitywt FROM chicken_closingstock WHERE date = '$pdate' AND code = '$code'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $opening = $rows1['quantitywt'];
 
 $purchase = $sale = 0;
 $query1 = "SELECT sum(weight) AS weight FROM pp_sobi WHERE date BETWEEN '$fromdate' AND '$todate' AND code = '$code'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $purchase += $rows1['weight'];
 
 $query1 = "SELECT sum(weight) AS weight FROM ims_intermediatereceipt WHERE date BETWEEN '$fromdate' AND '$todate' AND code = '$code' AND riflag = 'R'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $purchase += $rows1['weight'];
 
 $query1 = "SELECT sum(weight) AS weight FROM oc_cobi WHERE date BETWEEN '$fromdate' AND '$todate' AND code = '$code'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $sale += $rows1['weight'];
 
 $query1 = "SELECT sum(weight) AS weight FROM ims_intermediatereceipt WHERE date BETWEEN '$fromdate' AND '$todate' AND code = '$code' AND riflag = 'I'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $sale += $rows1['weight'];
 
 $query1 = "SELECT sum(weight) AS weight FROM chicken_chickentransfer WHERE date BETWEEN '$fromdate' AND '$todate' AND fromcode = '$code'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $sale += $rows1['weight'];
 
 $closing = $purchase - $sale;

 $query1 = "SELECT quantitywt FROM chicken_closingstock WHERE date = '$todate' AND code = '$code'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
 $aclosing = $rows1['quantitywt'];
 
 $weightloss = round((($closing - $aclosing) / $closing * 100),2);
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo $rows['description'] ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo changeprice1($opening); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo changeprice1($purchase); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo changeprice1($sale); ?></td>
		<td align="right">
<?php echo changeprice1($closing); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo changeprice1($aclosing); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo changeprice1($weightloss); ?></td>
	</tr>
<?php
}
}
?>
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
	document.location = "chicken_weightloss.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>