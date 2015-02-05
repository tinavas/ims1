<?php
session_start();
include "getemployee.php";
ob_start();
$cond = "";
if($_GET['fromdate']=="" && $_GET['todate']=="")
{
	$fromdate=date("Y-m-d");
	$todate=date("Y-m-d");
}
else {
	
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}
$party = $_GET['name'];
if($party=="")
{
	$party="All";
}
$dis=$_GET['dis'];
if(!isset($_GET['dis']))
 $dis="All";

if($party <> "All")
 $cond = "AND oc_salesorder.vendor = '$party'";  
 if($dis <> "All")
 $cond1 = "AND oc_salesorder.warehouse = '$dis'"; 
 else
 $cond1="";
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
<?php include "phprptinc/ewrfn3.php"; 
      include "reportheader.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

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
<?php include "phprptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "/";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "/"; // Default date separator
</script>
<script type="text/javascript" src="phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";
function reloadpage()
{
	
	var name = document.getElementById('party').value;
	var dis = document.getElementById('dis').value;
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "pendingsalesordersmry.php?fromdate=" + fdate + "&todate=" + tdate+"&name=" + name+"&dis=" + dis ;
}
</script>

<?php } ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Pending Sales Order</font></strong></td>
</tr>
<?php if($party <> "All") { ?>
<tr height="5px"></tr>
<tr>
	<td align="center">
	<strong><font color="#3e3276">Customer </font></strong><?php echo $party; ?>
	</td>
</tr>	
<?php } ?>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
</table>
<br/>

<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<center>

<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="pendingsalesordersmry.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $party; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="pendingsalesordersmry.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $party; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="pendingsalesordersmry.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $party; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="pendingsalesordersmry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $party; ?>">Reset All Filters</a>
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
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>
<span class="phpreportmaker">

<td>From Date</td>
<td>
<input type="text" class="datepicker" id="fromdate" name="fromdate" size="11" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" onchange="reloadpage();"/>
</td>
<td>To Date</td>
<td>
<input type="text" class="datepicker" id="todate" name="todate" size="11" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" onchange="reloadpage();"/></td>

<td>Customer</td>
 <td>
	<select name = "party" id = "party" style = "width:180px" onchange="reloadpage();"  >
<option value = "">-select-</option>
<option <?php if($party=="All") { ?> selected="selected" <?php } ?> value = "All">All</option>
<?php 
$q  = "select distinct(vendor) from oc_salesorder where flag='1' and psflag='0'  order by vendor ";
$r = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
?>
<option value = "<?php echo $qr['vendor'];?>" <?php if($party==$qr['vendor']){ ?> selected="selected" <?php } ?> title="<?php echo $qr['vendor'];?>"><?php echo $qr['vendor'];?></option>
<?php } ?>
</select></td>
<td>Dispatch Location</td>
 <td>
	<select name = "dis" id = "dis" style = "width:100px" onchange="reloadpage();"  >
<option value = "">-select-</option>
<option <?php if($dis=="All") { ?> selected="selected" <?php } ?> value = "All">All</option>
<?php 
$q  = "select distinct(warehouse) from oc_salesorder where `flag`='1' and psflag='0'  order by warehouse ";
$r = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
?>
<option value = "<?php echo $qr['warehouse'];?>" <?php if($dis==$qr['warehouse']){ ?> selected="selected" <?php } ?> title="<?php echo $qr['warehouse'];?>"><?php echo $qr['warehouse'];?></option>
<?php } ?>
</select></td>

</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps))
	$nStopGrp = $nTotalGrps;
$nRecCount = 0;

// Get first row
if ($nTotalGrps > 0) {
	GetRow(1);
	$nGrpCount = 1;
}
//while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	//if ($bShowFirstHeader) 
	{
?>
	<thead>
	<tr>
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Delivery Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Delivery Date</td>
			
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Purchase Order" align="center">
		Po
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Purchase Order">Po</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Customer</td>
			
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Code</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Description</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?></td>
			</tr></table>
		</td>
<?php } ?>

<?php if($_SESSION['db']=="vista") {?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Pieces
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Pieces</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Order Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Order Date</td>
			
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Warehouse</td>
			
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php

	}

 $query = "SELECT * FROM `oc_salesorder` WHERE `flag`='1' and psflag='0' ".$cond.$cond1." and deliverydate between '$fromdate' and '$todate' order by deliverydate , po ";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{			
?>
	<tr>
	<?php if($d1!=$rows['deliverydate']) {
	$datesample = date("d.m.Y",strtotime($rows['deliverydate']));?>
	<td<?php echo $sItemRowClass; ?>>
<?php  echo ewrpt_ViewValue($datesample);
      ?>
	</td>
	<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['po']);
      ?>
	  </td>
	<?php } else { ?>
	<td<?php echo $sItemRowClass; ?>>
		<?php  echo ewrpt_ViewValue();?>
	</td>
	<?php if($po1!=$rows['po']) { ?>
	<td <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['po']);
      ?>
	  </td>
	  <?php }
	  else
	  {
	  ?>
	  <td <?php echo $sItemRowClass; ?>>
		<?php echo ewrpt_ViewValue();?>
	  </td>
	  <?php } } ?>
<?php/*
 $query = "SELECT code FROM contactdetails WHERE name = '$x_vendor' AND type LIKE '%party'";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 $rows = mysql_fetch_assoc($result);
 $code = $rows['code'];*/
?>
	
	 <td<?php echo $sItemRowClass; ?>>
<?php  echo ewrpt_ViewValue($rows['vendor']);
     ?>
	</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['code']) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['description']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['quantity'])) ?>
</td>
<?php if($_SESSION['db']=="vista") { ?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['packets'])) ?>
</td>

<?php } ?>
	
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($rows['date']))) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['warehouse']) ?>
</td>


	</tr>
<?php
$d1 = date("Y-m-d",strtotime($rows['deliverydate']));
$po1=$rows['po'];
}
		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
	$nGrpCount++;
//} // End while
?>
	</tbody>
	<tfoot>
<?php

?>
<?php if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="8"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="9">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if (@$sExport == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td valign="top"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php
$conn->Close();

// display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php include "phprptinc/footer.php"; ?>
<?php

?>
