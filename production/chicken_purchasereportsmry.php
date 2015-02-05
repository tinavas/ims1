<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php

session_start();$currencyunits=$_SESSION['currency'];
ob_start();
include "config.php";
include "getemployee.php";
if($currencyunits == "")
{
$currencyunits = "Rs";
}
if(!isset($_GET['fdate']))
$fdate = date("Y-m-d");
else
$fdate = date("Y-m-d",strtotime($_GET['fdate']));
$datef = date($datephp,strtotime($fdate));
if(!isset($_GET['tdate']))
$tdate = date("Y-m-d");
else
$tdate = date("Y-m-d",strtotime($_GET['tdate']));
$datet = date($datephp,strtotime($tdate));
if(!isset($_GET['vendor']))
$vendor = "All";
else
$vendor = $_GET['vendor'];

if($vendor == "All")
$vc = "<>";
else
$vc = "=";

$date1 = "1970-01-01";
$totalquantity = $totalamount = 0;
if(!isset($_GET['code']))
$code = "All";
else
$code = $_GET['code'];
if($code== "All")
$cod = "<>";
else
$cod = "=";
if(!isset($_GET['description']))
$description = "All";
else
$description = $_GET['description'];
if($description== "All")
$desc = "<>";
else
$desc = "=";

if($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf')
{
if(!isset($_GET['warehouse']))
$warehouse = "All";
else
$warehouse = $_GET['warehouse'];
if($warehouse== "All")
$ware = "<>";
else
$ware = "=";
}
?>
<?php include "reportheader.php"; ?>

<br/>
<?php if($_SESSION['client'] == 'KEHINDE')
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in ₦</p></center>

<?php 
}
else
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits;?></p></center>
<?php } ?>
<br/>
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


<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Purchases Report</font></strong></td>
</tr>

<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">From : </font></strong><?php echo $datef; ?></td>
<td colspan="1" align="center"><strong><font color="#3e3276">To : </font></strong><?php echo $datet; ?></td>

 </tr>


<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Supplier : </font></strong><?php echo $vendor; ?></td>
</tr>
<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">Code : </font></strong><?php echo $code; ?></td>
  <td colspan="1" align="center"><strong><font color="#3e3276">Description : </font></strong><?php echo $description; ?></td>

</tr>
<?php if(($_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse <> 'All') { ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Warehouse : </font></strong><?php echo $warehouse; ?></td>
</tr>
<?php } ?>
</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "purchasereport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "purchasereport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "purchasereport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "purchasereport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "purchasereport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "purchasereport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "pp_sobi";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal , pp_sobi.code , pp_sobi.description FROM " . $EW_REPORT_TABLE_SQL_FROM;
if(($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse <> 'All')
{
$EW_REPORT_TABLE_SQL_WHERE = " pp_sobi.vendor $vc '$vendor' and pp_sobi.code $cod '$code' and pp_sobi.description $desc '$description'and pp_sobi.date >= '$fdate' and pp_sobi.date <= '$tdate' AND pp_sobi.warehouse = '$warehouse'";
}
else
{
$EW_REPORT_TABLE_SQL_WHERE = " pp_sobi.vendor $vc '$vendor' and pp_sobi.code $cod '$code' and pp_sobi.description $desc '$description'and pp_sobi.date >= '$fdate' and pp_sobi.date <= '$tdate' ";
}
$EW_REPORT_TABLE_SQL_GROUPBY = "pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal,pp_sobi.code,pp_sobi.description";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "pp_sobi.vendor ASC, pp_sobi.date ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "pp_sobi.vendor", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `vendor` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(pp_sobi.totalquantity) AS SUM_totalquantity, SUM(pp_sobi.grandtotal) AS SUM_grandtotal FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_vendor = NULL; // Popup filter for vendor
$af_date = NULL; // Popup filter for date
$af_so = NULL; // Popup filter for so
$af_totalquantity = NULL; // Popup filter for totalquantity
$af_grandtotal = NULL; // Popup filter for grandtotal
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
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 500; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_VENDOR_SQL_SELECT = "SELECT DISTINCT pp_sobi.vendor FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_VENDOR_SQL_ORDERBY = "pp_sobi.vendor";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT pp_sobi.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "pp_sobi.date";
$EW_REPORT_FIELD_SO_SQL_SELECT = "SELECT DISTINCT pp_sobi.so FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SO_SQL_ORDERBY = "pp_sobi.so";
?>
<?php

// Field variables
$x_vendor = NULL;
$x_date = NULL;
$x_so = NULL;
$x_totalquantity = NULL;
$x_grandtotal = NULL;

// Group variables
$o_vendor = NULL; $g_vendor = NULL; $dg_vendor = NULL; $t_vendor = NULL; $ft_vendor = 200; $gf_vendor = $ft_vendor; $gb_vendor = ""; $gi_vendor = "0"; $gq_vendor = ""; $rf_vendor = NULL; $rt_vendor = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;

// Detail variables
$o_so = NULL; $t_so = NULL; $ft_so = 200; $rf_so = NULL; $rt_so = NULL;
$o_totalquantity = NULL; $t_totalquantity = NULL; $ft_totalquantity = 5; $rf_totalquantity = NULL; $rt_totalquantity = NULL;
$o_grandtotal = NULL; $t_grandtotal = NULL; $ft_grandtotal = 5; $rf_grandtotal = NULL; $rt_grandtotal = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 4;
$nGrps = 3;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, TRUE, TRUE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_vendor = "";
$seld_vendor = "";
$val_vendor = "";
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_so = "";
$seld_so = "";
$val_so = "";

// Load default filter values
LoadDefaultFilters();

// Set up popup filter
SetupPopup();

// Extended filter
$sExtendedFilter = "";

// Build popup filter
$sPopupFilter = GetPopupFilter();

//echo "popup filter: " . $sPopupFilter . "<br>";
if ($sPopupFilter <> "") {
	if ($sFilter <> "")
		$sFilter = "($sFilter) AND ($sPopupFilter)";
	else
		$sFilter = $sPopupFilter;
}

// Check if filter applied
$bFilterApplied = CheckFilter();

// Get sort
$sSort = getSort();

// Get total group count
$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_GROUP, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
$nTotalGrps = GetGrpCnt($sSql);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Show header
$bShowFirstHeader = ($nTotalGrps > 0);

//$bShowFirstHeader = TRUE; // Uncomment to always show header
// Set up start position if not export all

if (EW_REPORT_EXPORT_ALL && @$sExport <> "")
    $nDisplayGrps = $nTotalGrps;
else
    SetUpStartGroup(); 

// Get current page groups
$rsgrp = GetGrpRs($sSql, $nStartGrp, $nDisplayGrps);

// Init detail recordset
$rs = NULL;
?>
<?php include "phprptinc/header.php"; ?>
<?php if (@$sExport == "") { ?>
<script type="text/javascript">
var EW_REPORT_DATE_SEPARATOR = "-";
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

// popup fields
<?php $jsdata = ewrpt_GetJsData($val_vendor, $sel_vendor, $ft_vendor) ?>
ewrpt_CreatePopup("purchasereport_vendor", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("purchasereport_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_so, $sel_so, $ft_so) ?>
ewrpt_CreatePopup("purchasereport_so", [<?php echo $jsdata ?>]);
</script>
<div id="purchasereport_vendor_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchasereport_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchasereport_so_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" align="center" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="chicken_purchasereportsmry.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>&code=<?php echo $code; ?>&description=<?php echo $description; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chicken_purchasereportsmry.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>&code=<?php echo $code; ?>&description=<?php echo $description; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chicken_purchasereportsmry.php?export=word&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>&code=<?php echo $code; ?>&description=<?php echo $description; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chicken_purchasereportsmry.php?cmd=reset&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>&code=<?php echo $code; ?>&description=<?php echo $description; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>

<?php if (@$sExport == "") { ?>
<br /><br />
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
<div id="report_summary" align="center">
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" align="center" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel" align="left">
From Date
<input type="text" size="12" id="date" name="date" value="<?php echo date($datephp,strtotime($fdate)); ?>" class="datepicker" onchange="reloadpage();"/>


To Date
<input type="text" size="12" id="date1" name="date1" value="<?php echo date($datephp,strtotime($tdate)); ?>" class="datepicker" onchange="reloadpage();"/>

Supplier
<select id="vendor" name="vendor" onchange="reloadpage();">
<option value="All" <?php if($vendor == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$q = "select distinct(vendor) from pp_sobi order by vendor";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>

<option value="<?php echo $qr['vendor']; ?>" <?php if($vendor == $qr['vendor']) { ?> selected="selected" <?php } ?> ><?php echo $qr['vendor']; ?></option>
<?php } ?>

</select>

Code
<select id="code" name="code" style="width:80px;" onchange = "getdescription(this.id);">
<option value="All" <?php if($code == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php
$q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['code']; ?>" <?php if($code == $qr['code']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['code']; ?></option>
<?php } ?>
</select>

Description
<select id="desc" name="desc" style="width:100px;"  onchange = "getcode(this.id);">
<option value="All" <?php if($description == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$q = "select distinct(description) from pp_sobi order by description";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['description']; ?>" <?php if($description == $qr['description']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['description']; ?></option>
<?php } ?>
</select>
<?php
if(($_SESSION['db'] == 'fortress') || ($_SESSION['db'] == 'vaibhav'))
{
?>
Warehouse
<select id="warehouse" name="warehouse" style="width:100px;"  onchange="reloadwarehouse();">
<option value="All" <?php if($warehouse == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$query1 = "SELECT distinct(warehouse) as sector FROM pp_sobi WHERE client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['sector']; ?>" title="<?php echo $rows1['sector']; ?>" <?php if($warehouse == $rows1['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows1['sector']; ?></option>
<?php
}
?>
</select>
<?php
}
?>
<?php
if($_SESSION['db'] == 'golden' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf')
{
?>
Warehouse
<select id="warehouse" name="warehouse" style="width:100px;"  onchange="reloadwarehouse();">
<option value="All" <?php if($warehouse == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
if($_SESSION['db'] == "mlcf")
$query1 = "select distinct(flockcode) as sector from layer_flock order by flockcode";
else
$query1 = "SELECT sector FROM tbl_sector WHERE type1 IN ('Administration Office', 'Warehouse') AND client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['sector']; ?>" title="<?php echo $rows1['sector']; ?>" <?php if($warehouse == $rows1['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows1['sector']; ?></option>
<?php
}
?>
</select>
<?php
}
?>

</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table align="center" class="ewTable ewTableSeparate" cellspacing="0">
<?php
$finalqty = 0;
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
	GetGrpRow(1);
	$nGrpCount = 1;
}
while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Supplier
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supplier</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchasereport_vendor', false, '<?php echo $rf_vendor; ?>', '<?php echo $rt_vendor; ?>');return false;" name="x_vendor<?php echo $cnt[0][0]; ?>" id="x_vendor<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchasereport_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		SO #
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>SO #</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchasereport_so', false, '<?php echo $rf_so; ?>', '<?php echo $rt_so; ?>');return false;" name="x_so<?php echo $cnt[0][0]; ?>" id="x_so<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Invoice No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Invoice No.</td>
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
		<td valign="bottom" class="ewTableHeader">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Price</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Weight</td>
			</tr></table>
		</td>
<?php } ?>

<?php
if($_SESSION['db'] == 'vista')
{
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Received Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Received Quantity</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Received Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Received Weight</td>
			</tr></table>
		</td>
<?php } ?>


<?php
}
?>	

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Amount</td>
			</tr></table>
		</td>
<?php } ?>

<?php if($_SESSION['db']=="vista") {?>
	
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Credit Term
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Credit Term</td>
			</tr></table>
		</td>
<?php } ?>

	
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Credit Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Credit Date</td>
			</tr></table>
		</td>
<?php } ?>
	
	<?php } ?>

<?php
if(($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse == 'All')
{
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php
}
?>	

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_vendor, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_vendor, EW_REPORT_DATATYPE_STRING, $gb_vendor, $gi_vendor, $gq_vendor);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	while ($rs && !$rs->EOF) { // Loop detail records
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$dg_vendor = $x_vendor;
		if ((is_null($x_vendor) && is_null($o_vendor)) ||
			(($x_vendor <> "" && $o_vendor == $dg_vendor) && !ChkLvlBreak(1))) {
			$dg_vendor = "&nbsp;";
		} elseif (is_null($x_vendor)) {
			$dg_vendor = EW_REPORT_NULL_LABEL;
		} elseif ($x_vendor == "") {
			$dg_vendor = EW_REPORT_EMPTY_LABEL;
		}
		$dg_date = $x_date;
		if ((is_null($x_date) && is_null($o_date)) ||
			(($x_date <> "" && $o_date == $dg_date) && !ChkLvlBreak(2))) {
			$dg_date = "&nbsp;";
		} elseif (is_null($x_date)) {
			$dg_date = EW_REPORT_NULL_LABEL;
		} elseif ($x_date == "") {
			$dg_date = EW_REPORT_EMPTY_LABEL;
		}
?>
<?php 
$code = $description = $quantity = $price = $binvoice = $weight=$rquantity = $rweight = ""; $totqty = 0; $totwt = 0;
$q = "select * from pp_sobi where date = '$x_date' and vendor = '$x_vendor' and so = '$x_so' order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$tot=mysql_num_rows($qrs);

while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	
	if($_SESSION['db']=="vista")
	{
	
	if($qr['code']=="BROB101" || $qr['code']=="LBRD101")
	{
	$quantity.= changeprice($qr['sentquantity']) . "/";
	$weight .= changeprice($qr['sendweight']) . "/";
	$totqty += $qr['sentquantity'];
	$totwt += $qr['sendweight'];
	$rquantity.=changeprice($qr['receivedquantity'])."/";
	$rweight.=changeprice($qr['weight']) . "/";
	}
	else
	{
	$quantity.= changeprice($qr['sentquantity']) . "/";
	$weight .= changeprice($qr['sendweight']) . "/";
	$totqty += $qr['sentquantity'];
	$totwt += $qr['sendweight'];
	$rquantity.=changeprice($qr['receivedquantity'])."/";
	$rweight.=changeprice($qr['weight']) . "/";
	}
	}
	else
	{
	$quantity.= changeprice($qr['sentquantity']) . "/";
	$weight .= changeprice($qr['weight']) . "/";
	$totqty += $qr['sentquantity'];
	$totwt += $qr['weight'];
	}
	$description.= $qr['description'] . "/";
	
	$price.= changeprice($qr['rateperunit']). "/";
	$binvoice = $qr['invoice'];
	$creditterm=$qr['credittermvalue'];
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$weight = substr($weight,0,-1);
$price = substr($price,0,-1);
$rquantity = substr($rquantity,0,-1);
$rweight = substr($rweight,0,-1);

$allow = 1;
$holdso = $x_so;
if($holdso == $oldso)
$allow = 0;
if($allow == 1)
{
?>

	<tr>
		<td class="ewRptGrpField1" align="left">
		<?php $t_vendor = $x_vendor; $x_vendor = $dg_vendor; ?>
<?php echo ewrpt_ViewValue($x_vendor) ?>
		<?php $x_vendor = $t_vendor; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php if(date("d.m.Y",strtotime($x_date)) <> "01.01.1970") echo ewrpt_ViewValue(date($datephp,strtotime($x_date))); else echo ewrpt_ViewValue(); ?>
<?php $date1 = $x_date ?>
		<?php $x_date = $t_date; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_so) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $binvoice; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $code; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $description; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $quantity; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $weight; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $price; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($totqty)); $totalquantity+= $totqty; $finalqty += $totqty;?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($totwt)); $totalweight+= $totwt; $finalweight += $totwt;?>
</td>
<?php 
if($_SESSION['db']=="vista")
	{
	?>
<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $rquantity; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $rweight; ?></td>
<?php } ?>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_grandtotal)); $totalamount+= $x_grandtotal; $finalamt += $x_grandtotal;?>
</td>


<?php if($_SESSION['db']=="vista") {
	
?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($creditterm); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php 




$date11 = date('d.m.Y',strtotime($x_date.' +'.$creditterm.' days'));

echo ewrpt_ViewValue($date11); ?>
</td>
<?php } ?>

<?php
if(($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse == 'All')
{
$query11 = "SELECT warehouse FROM pp_sobi WHERE so = '$x_so' AND client = '$client'";
$result11 = mysql_query($query11,$conn1) or die(mysql_error());
$rows11 = mysql_fetch_assoc($result11);
$ware = $rows11['warehouse'];
?>
<td<?php echo $sItemRowClass; ?> align="left">
<?php echo ewrpt_ViewValue($ware) ?>
<?php
}
?>	

	</tr>
	<?php $oldso = $x_so; } ?>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_vendor = $x_vendor;
		$o_date = $x_date;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
?>
	<!--<tr>
		<td colspan="2" class="ewRptGrpSummary1" align="left">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php #$t_totalquantity = $x_totalquantity; ?>
		<?php #$x_totalquantity = $smry[1][2]; // Load SUM ?>
<?php echo changeprice($totalquantity); $totalquantity = 0; #echo ewrpt_ViewValue($x_totalquantity) ?>
		<?php #$x_totalquantity = $t_totalquantity; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php #$t_grandtotal = $x_grandtotal; ?>
		<?php #$x_grandtotal = $smry[1][3]; // Load SUM ?>
<?php echo changeprice($totalamount); $totalamount = 0; #echo ewrpt_ViewValue($x_grandtotal) ?>
		<?php #$x_grandtotal = $t_grandtotal; ?>
		</td>
	<?php if(($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse == "All") { ?>
		<td colspan="3" class="ewRptGrpSummary1" align="left">&nbsp;</td>
	<?php }?>
	</tr>-->
	<?php if(($_SESSION['db'] == 'fortress' or $_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') && $warehouse == "All") { ?>
		<!--<tr><td colspan="11" class="ewRptGrpSummary1" align="left">&nbsp;</td></tr>-->
	<?php } else { ?>
		<!--<tr><td colspan="10" class="ewRptGrpSummary1" align="left">&nbsp;</td></tr>-->
	<?php } ?>
	
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_vendor = $x_vendor; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php

	// Get total count from sql directly
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_COUNT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
	$rstot = $conn->Execute($sSql);
	if ($rstot)
		$rstotcnt = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
	else
		$rstotcnt = 0;

	// Get total from sql directly
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT_AGG, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
	$sSql = $EW_REPORT_TABLE_SQL_AGG_PFX . $sSql . $EW_REPORT_TABLE_SQL_AGG_SFX;

	//echo "sql: " . $sSql . "<br>";
	$rsagg = $conn->Execute($sSql);
	if ($rsagg) {
		$grandsmry[2] = $rsagg->fields("SUM_totalquantity");
		$grandsmry[3] = $rsagg->fields("SUM_grandtotal");
	}
	else {

		// Accumulate grand summary from detail records
		$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, "", "");
		$rs = $conn->Execute($sSql);
		if ($rs) {
			GetRow(1);
			while (!$rs->EOF) {
				AccumulateGrandSummary();
				GetRow(2);
			}
		}
	}
?>
<?php if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="5"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="5">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="2" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_totalquantity = $x_totalquantity; ?>
		<?php $x_totalquantity = $grandsmry[2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_totalquantity) ?>
		<?php $x_totalquantity = $t_totalquantity; ?>
		</td>
		<td>
		<?php $t_grandtotal = $x_grandtotal; ?>
		<?php $x_grandtotal = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_grandtotal) ?>
		<?php $x_grandtotal = $t_grandtotal; ?>
		</td>
	</tr>
<?php } ?>
	<tr>
	 <td colspan="9" align="right">Total</td>
	 <td align="right"><?php echo changeprice($finalqty); ?></td>
	 <td align="right"><?php echo changeprice($finalweight); ?></td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right"><?php echo changeprice($finalamt); ?></td>
	 
	</tr> 

	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel" style="display:none">
<form action="chicken_purchasereportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="chicken_purchasereportsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="chicken_purchasereportsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="chicken_purchasereportsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="chicken_purchasereportsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="1"<?php if ($nDisplayGrps == 1) echo " selected" ?>>1</option>
<option value="2"<?php if ($nDisplayGrps == 2) echo " selected" ?>>2</option>
<option value="3"<?php if ($nDisplayGrps == 3) echo " selected" ?>>3</option>
<option value="4"<?php if ($nDisplayGrps == 4) echo " selected" ?>>4</option>
<option value="5"<?php if ($nDisplayGrps == 5) echo " selected" ?>>5</option>
<option value="10"<?php if ($nDisplayGrps == 10) echo " selected" ?>>10</option>
<option value="20"<?php if ($nDisplayGrps == 20) echo " selected" ?>>20</option>
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
<option value="500"<?php if ($nDisplayGrps == 500) echo " selected" ?>>500</option>
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
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
<tr><td colspan="4"><div id="ewBottom" class="phpreportmaker">
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

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return (is_null($GLOBALS["x_vendor"]) && !is_null($GLOBALS["o_vendor"])) ||
				(!is_null($GLOBALS["x_vendor"]) && is_null($GLOBALS["o_vendor"])) ||
				($GLOBALS["x_vendor"] <> $GLOBALS["o_vendor"]);
		case 2:
			return (is_null($GLOBALS["x_date"]) && !is_null($GLOBALS["o_date"])) ||
				(!is_null($GLOBALS["x_date"]) && is_null($GLOBALS["o_date"])) ||
				($GLOBALS["x_date"] <> $GLOBALS["o_date"]) || ChkLvlBreak(1); // Recurse upper level
	}
}

// Accummulate summary
function AccumulateSummary() {
	global $smry, $cnt, $col, $val, $mn, $mx;
	$cntx = count($smry);
	for ($ix = 0; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy]++;
			if ($col[$iy]) {
				$valwrk = $val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$smry[$ix][$iy] += $valwrk;
					if (is_null($mn[$ix][$iy])) {
						$mn[$ix][$iy] = $valwrk;
						$mx[$ix][$iy] = $valwrk;
					} else {
						if ($mn[$ix][$iy] > $valwrk) $mn[$ix][$iy] = $valwrk;
						if ($mx[$ix][$iy] < $valwrk) $mx[$ix][$iy] = $valwrk;
					}
				}
			}
		}
	}
	$cntx = count($smry);
	for ($ix = 1; $ix < $cntx; $ix++) {
		$cnt[$ix][0]++;
	}
}

// Reset level summary
function ResetLevelSummary($lvl) {
	global $smry, $cnt, $col, $mn, $mx, $nRecCount;

	// Clear summary values
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnty = count($smry[$ix]);
		for ($iy = 1; $iy < $cnty; $iy++) {
			$cnt[$ix][$iy] = 0;
			if ($col[$iy]) {
				$smry[$ix][$iy] = 0;
				$mn[$ix][$iy] = NULL;
				$mx[$ix][$iy] = NULL;
			}
		}
	}
	$cntx = count($smry);
	for ($ix = $lvl; $ix < $cntx; $ix++) {
		$cnt[$ix][0] = 0;
	}

	// Clear old values
	if ($lvl <= 1) $GLOBALS["o_vendor"] = "";
	if ($lvl <= 2) $GLOBALS["o_date"] = "";

	// Reset record count
	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {
	global $cnt, $col, $val, $grandsmry, $grandmn, $grandmx;
	@$cnt[0][0]++;
	for ($iy = 1; $iy < count($grandsmry); $iy++) {
		if ($col[$iy]) {
			$valwrk = $val[$iy];
			if (is_null($valwrk) || !is_numeric($valwrk)) {

				// skip
			} else {
				$grandsmry[$iy] += $valwrk;
				if (is_null($grandmn[$iy])) {
					$grandmn[$iy] = $valwrk;
					$grandmx[$iy] = $valwrk;
				} else {
					if ($grandmn[$iy] > $valwrk) $grandmn[$iy] = $valwrk;
					if ($grandmx[$iy] < $valwrk) $grandmx[$iy] = $valwrk;
				}
			}
		}
	}
}

// Get group count
function GetGrpCnt($sql) {
	global $conn;

	//echo "sql (GetGrpCnt): " . $sql . "<br>";
	$rsgrpcnt = $conn->Execute($sql);
	$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
	return $grpcnt;
}

// Get group rs
function GetGrpRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
}

// Get group row values
function GetGrpRow($opt) {
	global $rsgrp;
	if (!$rsgrp)
		return;
	if ($opt == 1) { // Get first group

		//$rsgrp->MoveFirst(); // NOTE: no need to move position
	} else { // Get next group
		$rsgrp->MoveNext();
	}
	if ($rsgrp->EOF) {
		$GLOBALS['x_vendor'] = "";
	} else {
		$GLOBALS['x_vendor'] = $rsgrp->fields('vendor');
	}
}

// Get row values
function GetRow($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	if (!$rs->EOF) {
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_so'] = $rs->fields('so');
		$GLOBALS['x_totalquantity'] = $rs->fields('totalquantity');
		$GLOBALS['x_grandtotal'] = $rs->fields('grandtotal');
		$val[1] = $GLOBALS['x_so'];
		$val[2] = $GLOBALS['x_totalquantity'];
		$val[3] = $GLOBALS['x_grandtotal'];
	} else {
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_so'] = "";
		$GLOBALS['x_totalquantity'] = "";
		$GLOBALS['x_grandtotal'] = "";
	}
}

//  Set up starting group
function SetUpStartGroup() {
	global $nStartGrp, $nTotalGrps, $nDisplayGrps;

	// Exit if no groups
	if ($nDisplayGrps == 0)
		return;

	// Check for a 'start' parameter
	if (@$_GET[EW_REPORT_TABLE_START_GROUP] != "") {
		$nStartGrp = $_GET[EW_REPORT_TABLE_START_GROUP];
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (@$_GET["pageno"] != "") {
		$nPageNo = $_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartGrp = ($nPageNo-1)*$nDisplayGrps+1;
			if ($nStartGrp <= 0) {
				$nStartGrp = 1;
			} elseif ($nStartGrp >= intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1) {
				$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps)*$nDisplayGrps+1;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
		} else {
			$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];
		}
	} else {
		$nStartGrp = @$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP];	
	}

	// Check if correct start group counter
	if (!is_numeric($nStartGrp) || $nStartGrp == "") { // Avoid invalid start group counter
		$nStartGrp = 1; // Reset start group counter
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (intval($nStartGrp) > intval($nTotalGrps)) { // Avoid starting group > total groups
		$nStartGrp = intval(($nTotalGrps-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to last page first group
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} elseif (($nStartGrp-1) % $nDisplayGrps <> 0) {
		$nStartGrp = intval(($nStartGrp-1)/$nDisplayGrps) * $nDisplayGrps + 1; // Point to page boundary
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	}
}

// Set up popup
function SetupPopup() {
	global $conn, $sFilter;

	// Initialize popup
	// Build distinct values for vendor

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_vendor = $rswrk->fields[0];
		if (is_null($x_vendor)) {
			$bNullValue = TRUE;
		} elseif ($x_vendor == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_vendor = $x_vendor;
			$dg_vendor = $x_vendor;
			ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], $g_vendor, $dg_vendor, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for date
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_date = $rswrk->fields[0];
		if (is_null($x_date)) {
			$bNullValue = TRUE;
		} elseif ($x_date == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_date = $x_date;
			$dg_date = ewrpt_FormatDateTime($x_date,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_date"], $g_date, $dg_date, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for so
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_so = $rswrk->fields[0];
		if (is_null($x_so)) {
			$bNullValue = TRUE;
		} elseif ($x_so == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_so = $x_so;
			ewrpt_SetupDistinctValues($GLOBALS["val_so"], $x_so, $t_so, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_so"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_so"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Process post back form
	if (count($_POST) > 0) {
		$sName = @$_POST["popup"]; // Get popup form name
		if ($sName <> "") {
		$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
			if ($cntValues > 0) {
				$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
				if (trim($arValues[0]) == "") // Select all
					$arValues = EW_REPORT_INIT_VALUE;
				$_SESSION["sel_$sName"] = $arValues;
				$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
				$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
				ResetPager();
			}
		}

	// Get 'reset' command
	} elseif (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];
		if (strtolower($sCmd) == "reset") {
			ClearSessionSelection('vendor');
			ClearSessionSelection('date');
			ClearSessionSelection('so');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Vendor selected values

	if (is_array(@$_SESSION["sel_purchasereport_vendor"])) {
		LoadSelectionFromSession('vendor');
	} elseif (@$_SESSION["sel_purchasereport_vendor"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_vendor"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_purchasereport_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_purchasereport_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get So selected values
	if (is_array(@$_SESSION["sel_purchasereport_so"])) {
		LoadSelectionFromSession('so');
	} elseif (@$_SESSION["sel_purchasereport_so"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_so"] = "";
	}
}

// Reset pager
function ResetPager() {

	// Reset start position (reset command)
	global $nStartGrp, $nTotalGrps;
	$nStartGrp = 1;
	$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
}
?>
<?php

// Set up number of groups displayed per page
function SetUpDisplayGrps() {
	global $nDisplayGrps, $nStartGrp;
	$sWrk = @$_GET[EW_REPORT_TABLE_GROUP_PER_PAGE];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayGrps = intval($sWrk);
		} else {
			if (strtoupper($sWrk) == "ALL") { // display all groups
				$nDisplayGrps = -1;
			} else {
				$nDisplayGrps = 500; // Non-numeric, load default
			}
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = $nDisplayGrps; // Save to session

		// Reset start position (reset command)
		$nStartGrp = 1;
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = $nStartGrp;
	} else {
		if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] <> "") {
			$nDisplayGrps = $_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE]; // Restore from session
		} else {
			$nDisplayGrps = 500; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_purchasereport_$parm"] = "";
	$_SESSION["rf_purchasereport_$parm"] = "";
	$_SESSION["rt_purchasereport_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_purchasereport_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_purchasereport_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_purchasereport_$parm"];
}

// Load default value for filters
function LoadDefaultFilters() {

	/**
	* Set up default values for non Text filters
	*/

	/**
	* Set up default values for extended filters
	* function SetDefaultExtFilter($parm, $so1, $sv1, $sc, $so2, $sv2)
	* Parameters:
	* $parm - Field name
	* $so1 - Default search operator 1
	* $sv1 - Default ext filter value 1
	* $sc - Default search condition (if operator 2 is enabled)
	* $so2 - Default search operator 2 (if operator 2 is enabled)
	* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
	*/

	/**
	* Set up default values for popup filters
	* NOTE: if extended filter is enabled, use default values in extended filter instead
	*/

	// Field vendor
	// Setup your default values for the popup filter below, e.g.
	// $seld_vendor = array("val1", "val2");

	$GLOBALS["seld_vendor"] = "";
	$GLOBALS["sel_vendor"] =  $GLOBALS["seld_vendor"];

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];

	// Field so
	// Setup your default values for the popup filter below, e.g.
	// $seld_so = array("val1", "val2");

	$GLOBALS["seld_so"] = "";
	$GLOBALS["sel_so"] =  $GLOBALS["seld_so"];
}

// Check if filter applied
function CheckFilter() {

	// Check vendor popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_vendor"], $GLOBALS["sel_vendor"]))
		return TRUE;

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check so popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_so"], $GLOBALS["sel_so"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field vendor
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_vendor"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_vendor"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Vendor<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field date
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_date"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_date"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Date<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field so
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_so"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_so"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "So<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Show Filters
	if ($sFilterList <> "")
		echo "CURRENT FILTERS:<br />$sFilterList";
}

/**
 * Regsiter your Custom filters here
 */

// Setup custom filters
function SetupCustomFilters() {

	// 1. Register your custom filter below (see example)
	// 2. Write your custom filter function (see example fucntions: GetLastMonthFilter, GetStartsWithAFilter)

}

/**
 * Write your Custom filters here
 */

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression) {
	$today = getdate();
	$lastmonth = mktime(0, 0, 0, $today['mon']-1, 1, $today['year']);
	$sVal = date("Y|m", $lastmonth);
	$sWrk = $FldExpression . " BETWEEN " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 1), EW_REPORT_DATATYPE_DATE) .
		" AND " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 2), EW_REPORT_DATATYPE_DATE);
	return $sWrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression) {
	return $FldExpression . " LIKE 'A%'";
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	if (is_array($GLOBALS["sel_vendor"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_vendor"], "pp_sobi.vendor", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_vendor"], $GLOBALS["gb_vendor"], $GLOBALS["gi_vendor"], $GLOBALS["gq_vendor"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "pp_sobi.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_so"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_so"], "pp_sobi.so", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_so"]);
	}
	return $sWrk;
}
?>
<?php

//-------------------------------------------------------------------------------
// Function getSort
// - Return Sort parameters based on Sort Links clicked
// - Variables setup: Session[EW_REPORT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
function getSort()
{

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_purchasereport_vendor"] = "";
			$_SESSION["sort_purchasereport_date"] = "";
			$_SESSION["sort_purchasereport_so"] = "";
			$_SESSION["sort_purchasereport_totalquantity"] = "";
			$_SESSION["sort_purchasereport_grandtotal"] = "";
		}

	// Check for an Order parameter
	} elseif (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY]) > 0) {
		$sSortSql = "";
		$sSortField = "";
		$sOrder = @$_GET[EW_REPORT_TABLE_ORDER_BY];
		if (strlen(@$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE]) > 0) {
			$sOrderType = @$_GET[EW_REPORT_TABLE_ORDER_BY_TYPE];
		} else {
			$sOrderType = "";
		}
	}

	// Set up default sort
	if (@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] == "") {
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "pp_sobi.so ASC";
		$_SESSION["sort_purchasereport_so"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>

<script type="text/javascript">
function reloadpage1()
{
if(document.getElementById('code').value == "All")
{
var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value = "All";
	
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" + code + "&description=" + "All";

}
else if(document.getElementById('desc').value == "All")
{
var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value = "All";
	var description = document.getElementById('desc').value ;
	
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" +"All" + "&description=" + "All";

}
else
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" + code + "&description=" + description;
}
}


function reloadpage()
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;	
<?php	if($_SESSION['db'] == 'vaibhav' or $_SESSION['db'] == 'mlcf' or $_SESSION['db'] == 'maharashtra' or $_SESSION['db'] == 'mbcf') { ?>
    var warehouse = document.getElementById('warehouse').value;
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&warehouse=" + warehouse + "&code=" + code + "&description=" + description;
<?php } else { ?>
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" + code + "&description=" + description;
<?php } ?>
}
function reloadwarehouse()
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	var warehouse = document.getElementById('warehouse').value;
	document.location = "chicken_purchasereportsmry.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&warehouse=" + warehouse + "&code=" + code + "&description=" + description;;
}

function getdescription(codeid)
{

var temp = codeid.split("e");
     var tempindex = temp[1];
var y = document.getElementById(codeid).value;

removeAllOptions(document.getElementById('desc'+ tempindex));
myselect1 = document.getElementById('desc' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "desc";
myselect1.style.width = "100px";
<?php 
	$q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{    
	
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['description']; ?>");
theOption1.value = "<?php echo $qr['description']; ?>";
<?php echo "if(y == '$qr[code]') { "; ?>

theOption1.selected= true;
<?php echo "}"; ?>
theOption1.title = "<?php echo $qr['code']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


<?php }?>
reloadpage1();

}
function getcode(codeid)
{

var temp = codeid.split("c");
     var tempindex = temp[1];
var y = document.getElementById(codeid).value;

removeAllOptions(document.getElementById('code'+ tempindex));
myselect1 = document.getElementById('code' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code";
myselect1.style.width = "160px";
<?php 
	    $q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{    
?>


theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.value = "<?php echo $qr['code']; ?>";
<?php echo "if(y == '$qr[description]') {"; ?>
theOption1.selected= true;


<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


<?php }?>
reloadpage1();
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
</script>
