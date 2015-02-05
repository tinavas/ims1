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
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Commission Details</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

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
&nbsp;&nbsp;<a href="chicken_commission.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chicken_commission.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chicken_commission.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chicken_commission.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();" size="10"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();" size="10" /></td>
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
		Supplier
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Supplier</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Commission
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Commission</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Description</td>
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
<?php } ?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Purchase Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Purchase Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sale Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sale Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Commission
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Commission</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$query = "SELECT * FROM chicken_commission WHERE date BETWEEN '$fromdate' AND '$todate' ORDER BY date,id";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
 if($pvendor == $rows['vendor'] && $pparty == $rows['party'])
  $dvendor = $dparty = "";
 else
 { $dvendor = $rows['vendor']; $dparty = $rows['party']; } 
 if($pdate == $rows['date'])
  $ddate = "";
 else
 {
  $ddate = date($datephp,strtotime($rows['date']));
  $dvendor = $rows['vendor']; 
  $dparty = $rows['party'];
 }
 $totqty += $rows['quantity'];
 $totpamount += $rows['pamount'];
 $totsamount += $rows['samount']; 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($ddate); ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($dvendor); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($dparty); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['description']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice1($rows['quantity'])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['pamount'])); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['samount'])); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['commission'])); ?></td>
	</tr>
<?php
 $pdate = $rows['date'];
 $pvendor = $rows['vendor'];
 $pparty = $rows['party'];
}
?>
<tr>
 <td  class="ewRptGrpField2" colspan="5" align="right"><b>Total</b></td>
 <td class="ewRptGrpField1" align="right"><b><?php echo changeprice1($totqty); ?></b></td>
 <td class="ewRptGrpField1" align="right"><b><?php echo changeprice($totpamount); ?></b></td>
 <td class="ewRptGrpField1" align="right"><b><?php echo changeprice($totsamount); ?></b></td>
 <td class="ewRptGrpField1" align="right"><b><?php echo changeprice($totsamount - $totpamount); ?></b></td>
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
	document.location = "chicken_commission.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>