
<?php
session_start();$currencyunits=$_SESSION['currency'];
ob_start();
include "config.php";
include "reportheader.php";
include "jquery.php";

if($_GET['category'] == "")
 $category = "All";
else
 $category = $_GET['category'];
if($category == "All")
$cg = "<>";
else
$cg = "=";
if(($_GET['fromdate'] == "") OR ($_GET['todate'] == ""))
{
 $q1 = "SELECT * FROM ac_definefy";
 $r1 = mysql_query($q1,$conn1);
 while($row1 = mysql_fetch_assoc($r1))
 {
  $fromdate = $row1['fdate'];
  $todate = $row1['tdate'];
 }
}
else
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}

if($_GET['supplier'] == "")
 $supplier = "All";
else
 $supplier = $_GET['supplier'];

?>
<?php 
$sExport = @$_GET["export"]; 
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
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "feed_production", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "feed_production_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "feed_production_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "feed_production_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "feed_production_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "feed_production_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "feed_productionunit";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "feed_productionunit.feedmill", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `feedmill` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(feed_productionunit.batches) AS SUM_batches FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_feedmill = NULL; // Popup filter for feedmill
$af_mash = NULL; // Popup filter for mash
$af_formula = NULL; // Popup filter for formula
$af_date = NULL; // Popup filter for date
$af_batches = NULL; // Popup filter for batches
$af_matconsumed = NULL; // Popup filter for matconsumed
$af_production = NULL; // Popup filter for production
$af_shrinkage = NULL; // Popup filter for shrinkage
$af_materialcost = NULL; // Popup filter for materialcost
$af_shrinkagecost = NULL; // Popup filter for shrinkagecost
$af_bagtype = NULL; // Popup filter for bagtype
$af_noofbags = NULL; // Popup filter for noofbags
$af_labourcharges = NULL; // Popup filter for labourcharges
$af_noofunits = NULL; // Popup filter for noofunits
$af_costperunit = NULL; // Popup filter for costperunit
$af_packing = NULL; // Popup filter for packing
$af_transport = NULL; // Popup filter for transport
$af_other = NULL; // Popup filter for other
$af_feedcostperbag = NULL; // Popup filter for feedcostperbag
$af_feedcostperkg = NULL; // Popup filter for feedcostperkg
$af_formulaid = NULL; // Popup filter for formulaid
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
$nDisplayGrps = 3; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_FEEDMILL_SQL_SELECT = "SELECT DISTINCT feed_productionunit.feedmill FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FEEDMILL_SQL_ORDERBY = "feed_productionunit.feedmill";
$EW_REPORT_FIELD_MASH_SQL_SELECT = "SELECT DISTINCT feed_productionunit.mash FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_MASH_SQL_ORDERBY = "feed_productionunit.mash";
$EW_REPORT_FIELD_FORMULA_SQL_SELECT = "SELECT DISTINCT feed_productionunit.formula FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FORMULA_SQL_ORDERBY = "feed_productionunit.formula";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT feed_productionunit.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "feed_productionunit.date";
?>
<?php

// Field variables
$x_feedmill = NULL;
$x_mash = NULL;
$x_formula = NULL;
$x_date = NULL;
$x_batches = NULL;
$x_matconsumed = NULL;
$x_production = NULL;
$x_shrinkage = NULL;
$x_materialcost = NULL;
$x_shrinkagecost = NULL;
$x_bagtype = NULL;
$x_noofbags = NULL;
$x_labourcharges = NULL;
$x_noofunits = NULL;
$x_costperunit = NULL;
$x_packing = NULL;
$x_transport = NULL;
$x_other = NULL;
$x_feedcostperbag = NULL;
$x_feedcostperkg = NULL;
$x_formulaid = NULL;

// Group variables
$o_feedmill = NULL; $g_feedmill = NULL; $dg_feedmill = NULL; $t_feedmill = NULL; $ft_feedmill = 200; $gf_feedmill = $ft_feedmill; $gb_feedmill = ""; $gi_feedmill = "0"; $gq_feedmill = ""; $rf_feedmill = NULL; $rt_feedmill = NULL;
$o_mash = NULL; $g_mash = NULL; $dg_mash = NULL; $t_mash = NULL; $ft_mash = 200; $gf_mash = $ft_mash; $gb_mash = ""; $gi_mash = "0"; $gq_mash = ""; $rf_mash = NULL; $rt_mash = NULL;
$o_formula = NULL; $g_formula = NULL; $dg_formula = NULL; $t_formula = NULL; $ft_formula = 200; $gf_formula = $ft_formula; $gb_formula = ""; $gi_formula = "0"; $gq_formula = ""; $rf_formula = NULL; $rt_formula = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;

// Detail variables
$o_batches = NULL; $t_batches = NULL; $ft_batches = 5; $rf_batches = NULL; $rt_batches = NULL;
$o_matconsumed = NULL; $t_matconsumed = NULL; $ft_matconsumed = 5; $rf_matconsumed = NULL; $rt_matconsumed = NULL;
$o_production = NULL; $t_production = NULL; $ft_production = 5; $rf_production = NULL; $rt_production = NULL;
$o_shrinkage = NULL; $t_shrinkage = NULL; $ft_shrinkage = 5; $rf_shrinkage = NULL; $rt_shrinkage = NULL;
$o_materialcost = NULL; $t_materialcost = NULL; $ft_materialcost = 5; $rf_materialcost = NULL; $rt_materialcost = NULL;
$o_shrinkagecost = NULL; $t_shrinkagecost = NULL; $ft_shrinkagecost = 5; $rf_shrinkagecost = NULL; $rt_shrinkagecost = NULL;
$o_bagtype = NULL; $t_bagtype = NULL; $ft_bagtype = 200; $rf_bagtype = NULL; $rt_bagtype = NULL;
$o_noofbags = NULL; $t_noofbags = NULL; $ft_noofbags = 5; $rf_noofbags = NULL; $rt_noofbags = NULL;
$o_labourcharges = NULL; $t_labourcharges = NULL; $ft_labourcharges = 5; $rf_labourcharges = NULL; $rt_labourcharges = NULL;
$o_noofunits = NULL; $t_noofunits = NULL; $ft_noofunits = 5; $rf_noofunits = NULL; $rt_noofunits = NULL;
$o_costperunit = NULL; $t_costperunit = NULL; $ft_costperunit = 5; $rf_costperunit = NULL; $rt_costperunit = NULL;
$o_packing = NULL; $t_packing = NULL; $ft_packing = 5; $rf_packing = NULL; $rt_packing = NULL;
$o_transport = NULL; $t_transport = NULL; $ft_transport = 5; $rf_transport = NULL; $rt_transport = NULL;
$o_other = NULL; $t_other = NULL; $ft_other = 5; $rf_other = NULL; $rt_other = NULL;
$o_feedcostperbag = NULL; $t_feedcostperbag = NULL; $ft_feedcostperbag = 5; $rf_feedcostperbag = NULL; $rt_feedcostperbag = NULL;
$o_feedcostperkg = NULL; $t_feedcostperkg = NULL; $ft_feedcostperkg = 5; $rf_feedcostperkg = NULL; $rt_feedcostperkg = NULL;
$o_formulaid = NULL; $t_formulaid = NULL; $ft_formulaid = 3; $rf_formulaid = NULL; $rt_formulaid = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 18;
$nGrps = 5;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_feedmill = "";
$seld_feedmill = "";
$val_feedmill = "";
$sel_mash = "";
$seld_mash = "";
$val_mash = "";
$sel_formula = "";
$seld_formula = "";
$val_formula = "";
$sel_date = "";
$seld_date = "";
$val_date = "";

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
<?php $jsdata = ewrpt_GetJsData($val_feedmill, $sel_feedmill, $ft_feedmill) ?>
ewrpt_CreatePopup("feed_production_feedmill", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_mash, $sel_mash, $ft_mash) ?>
ewrpt_CreatePopup("feed_production_mash", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_formula, $sel_formula, $ft_formula) ?>
ewrpt_CreatePopup("feed_production_formula", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("feed_production_date", [<?php echo $jsdata ?>]);
</script>
<div id="feed_production_feedmill_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_mash_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_formula_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<center><strong>Purchase Cost Analysis <br /> From <?php echo date("d.m.Y",strtotime($fromdate));?> To <?php echo date("d.m.Y",strtotime($todate));?><br/> Category :: <?php echo $category;?></strong></center>
<br />
<center>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="purchasecostanalysis.php?export=html&category=<?php echo $category;?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&supplier=<?php echo $supplier;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchasecostanalysis.php?export=excel&category=<?php echo $category;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate; ?>&supplier=<?php echo $supplier;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="purchasecostanalysis.php?export=word&category=<?php echo $category;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate; ?>&supplier=<?php echo $supplier;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchasecostanalysis.php?cmd=reset&category=<?php echo $category;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate; ?>&supplier=<?php echo $supplier;?>">Reset All Filters</a>
<?php } ?>
<?php } ?>
<?php if (@$sExport == "") { ?>
</center>
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
<div id="report_summary">
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="purchasecostanalysis.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>Category&nbsp;&nbsp;&nbsp;</td>
	<td>
	<select id="category" onchange="reloadpage();">
	<option value="All" <?php if($category == "All") { ?> selected="selected"<?php } ?>>All</option>
	
	<?php 
	$q = "select distinct(cat) from ims_itemcodes where code in (SELECT distinct(code) FROM pp_sobi ) ORDER BY cat ASC";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
	<option value="<?php echo $qr['cat'];?>" <?php if($qr['cat'] == $category) { ?> selected="selected"<?php } ?>><?php echo $qr['cat'];?></option>
	<?php } ?>
	</select>
	</td>
	
	<td>
<span class="phpreportmaker">
&nbsp;&nbsp;From Date&nbsp;
<input type="text" class="datepicker" id="fromdate" name="fromdate" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;

To Date&nbsp;
<input type="text" class="datepicker" id="todate" name="todate" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;
Supplier&nbsp;&nbsp;
	<select id="supplier" onchange="reloadpage();">
	<option value="All" <?php if($supplier == "All") { ?> selected="selected"<?php } ?>>All</option>
	<?php 
	$q = "SELECT distinct(vendor) FROM pp_sobi ORDER BY vendor ASC";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
	<option value="<?php echo $qr['vendor'];?>" <?php if($qr['vendor'] == $supplier) { ?> selected="selected"<?php } ?>><?php echo $qr['vendor'];?></option>
	<?php } ?>
</select>
</span>
</td>
</tr>	
	
	
</table>
</form>
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
	GetGrpRow(1);
	$nGrpCount = 1;
}
//while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Item</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if ($supplier == "All") { ?>
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Supplier
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">supplier</td>
			</tr></table>
		</td>
<?php } } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Quantity Purchased
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Quantity Purchased</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Minimum Rate/unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Minimum Rate/unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Maximum Rate/unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Maximum Rate/unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Material Consumed">
		Average Rate/unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Material Consumed">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Average Rate/unit</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_feedmill, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_feedmill, EW_REPORT_DATATYPE_STRING, $gb_feedmill, $gi_feedmill, $gq_feedmill);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	//while ($rs && !$rs->EOF) { // Loop detail records
?>
<?php
if($supplier <> "All")
{
$query = "SELECT code,sum(sentquantity) as sentqty, max(rateperunit) as max, min(rateperunit) as min, sum(rateperunit) as sumrate FROM pp_sobi WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat $cg '$category') AND date between  '$fromdate' AND '$todate' AND vendor = '$supplier' GROUP BY code ORDER BY code ASC";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
<tr>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['code']) ?>
</td>
<?php
$query1 = "SELECT description FROM ims_itemcodes WHERE code = '$rows[code]' AND client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows1['description']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['sentqty']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['min']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['max']) ?>
</td>
<?php
if($supplier <> "All")
$query2 = "SELECT count(*) as count FROM pp_sobi WHERE code = '$rows[code]' AND date between  '$fromdate' AND '$todate' AND vendor = '$supplier'";
elseif($supplier == "All")
$query2 = "SELECT count(*) as count FROM pp_sobi WHERE code = '$rows[code]' AND date between  '$fromdate' AND '$todate' AND vendor = '$rowsa[vendor]' GROUP BY code ORDER BY code ASC";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$avg = round($rowsaa['sumrate'] / $rows2['count'],2);
?>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($avg) ?>
</td>

</td>
</tr>
<?php }}
elseif($supplier == "All")
{
$query = "SELECT distinct(code) FROM pp_sobi WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat $cg '$category') AND date between  '$fromdate' AND '$todate' GROUP BY code ORDER BY code ASC";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{

$querya = "SELECT distinct(vendor) FROM pp_sobi WHERE code = '$rows[code]' AND client = '$client'";
$resulta = mysql_query($querya,$conn1) or die(mysql_error());
while($rowsa = mysql_fetch_assoc($resulta))
{
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		
$queryaa = "SELECT code,sum(sentquantity) as sentqty, max(rateperunit) as max, min(rateperunit) as min, sum(rateperunit) as sumrate FROM pp_sobi WHERE code = '$rows[code]' AND vendor= '$rowsa[vendor]' AND date between  '$fromdate' AND '$todate' GROUP BY code ORDER BY code ASC";
$resultaa = mysql_query($queryaa,$conn1) or die(mysql_error());
while($rowsaa = mysql_fetch_assoc($resultaa))
{
	

?>

	<tr>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['code']) ?>
</td>
<?php
$query1 = "SELECT description FROM ims_itemcodes WHERE code = '$rowsaa[code]' AND client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
?>
		
	<td<?php echo $sItemRowClass; ?>>
<?php if(($rows1['description'] <> $oldcode) or ($dumm == 0)){ echo ewrpt_ViewValue($rows1['description']);
     $oldcode = $rows1['description']; $dumm = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
<?php if($supplier == "All") { ?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rowsa['vendor']) ?>
</td>
<?php } ?>
	 
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rowsaa['sentqty']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rowsaa['min']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rowsaa['max']) ?>
</td>
<?php
if($supplier <> "All")
$query2 = "SELECT count(*) as count FROM pp_sobi WHERE code = '$rows[code]' AND date between  '$fromdate' AND '$todate' AND vendor = '$supplier'";
elseif($supplier == "All")
$query2 = "SELECT count(*) as count FROM pp_sobi WHERE code = '$rows[code]' AND date between  '$fromdate' AND '$todate' AND vendor = '$rowsa[vendor]' GROUP BY code ORDER BY code ASC";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$avg = round($rowsaa['sumrate'] / $rows2['count'],2);
?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($avg) ?>
</td>

</td>
<?php
} } } }
?>

	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_feedmill = $x_feedmill;
		$o_mash = $x_mash;
		$o_formula = $x_formula;
		$o_date = $x_date;

		// Get next record
		GetRow(2);

		// Show Footers
?>

<?php
	//} // End detail records loop
?>
<?php

	// Next group
	$o_feedmill = $x_feedmill; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
//} // End while
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
		$grandsmry[1] = $rsagg->fields("SUM_batches");
		$grandsmry[2] = $rsagg->fields("SUM_matconsumed");
		$grandsmry[3] = $rsagg->fields("SUM_production");
		$grandsmry[4] = $rsagg->fields("SUM_shrinkage");
		$grandsmry[5] = $rsagg->fields("SUM_materialcost");
		$grandsmry[6] = $rsagg->fields("SUM_shrinkagecost");
		$grandsmry[8] = $rsagg->fields("SUM_noofbags");
		$grandsmry[9] = $rsagg->fields("SUM_labourcharges");
		$grandsmry[10] = $rsagg->fields("SUM_noofunits");
		$grandsmry[11] = $rsagg->fields("SUM_costperunit");
		$grandsmry[12] = $rsagg->fields("SUM_packing");
		$grandsmry[13] = $rsagg->fields("SUM_transport");
		$grandsmry[14] = $rsagg->fields("SUM_other");
		$grandsmry[15] = $rsagg->fields("SUM_feedcostperbag");
		$grandsmry[16] = $rsagg->fields("SUM_feedcostperkg");
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

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return (is_null($GLOBALS["x_feedmill"]) && !is_null($GLOBALS["o_feedmill"])) ||
				(!is_null($GLOBALS["x_feedmill"]) && is_null($GLOBALS["o_feedmill"])) ||
				($GLOBALS["x_feedmill"] <> $GLOBALS["o_feedmill"]);
		case 2:
			return (is_null($GLOBALS["x_mash"]) && !is_null($GLOBALS["o_mash"])) ||
				(!is_null($GLOBALS["x_mash"]) && is_null($GLOBALS["o_mash"])) ||
				($GLOBALS["x_mash"] <> $GLOBALS["o_mash"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_formula"]) && !is_null($GLOBALS["o_formula"])) ||
				(!is_null($GLOBALS["x_formula"]) && is_null($GLOBALS["o_formula"])) ||
				($GLOBALS["x_formula"] <> $GLOBALS["o_formula"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_date"]) && !is_null($GLOBALS["o_date"])) ||
				(!is_null($GLOBALS["x_date"]) && is_null($GLOBALS["o_date"])) ||
				($GLOBALS["x_date"] <> $GLOBALS["o_date"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_feedmill"] = "";
	if ($lvl <= 2) $GLOBALS["o_mash"] = "";
	if ($lvl <= 3) $GLOBALS["o_formula"] = "";
	if ($lvl <= 4) $GLOBALS["o_date"] = "";

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
		$GLOBALS['x_feedmill'] = "";
	} else {
		$GLOBALS['x_feedmill'] = $rsgrp->fields('feedmill');
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
		$GLOBALS['x_mash'] = $rs->fields('mash');
		$GLOBALS['x_formula'] = $rs->fields('formula');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_batches'] = $rs->fields('batches');
		$GLOBALS['x_matconsumed'] = $rs->fields('matconsumed');
		$GLOBALS['x_production'] = $rs->fields('production');
		$GLOBALS['x_shrinkage'] = $rs->fields('shrinkage');
		$GLOBALS['x_materialcost'] = $rs->fields('materialcost');
		$GLOBALS['x_shrinkagecost'] = $rs->fields('shrinkagecost');
		$GLOBALS['x_bagtype'] = $rs->fields('bagtype');
		$GLOBALS['x_noofbags'] = $rs->fields('noofbags');
		$GLOBALS['x_labourcharges'] = $rs->fields('labourcharges');
		$GLOBALS['x_noofunits'] = $rs->fields('noofunits');
		$GLOBALS['x_costperunit'] = $rs->fields('costperunit');
		$GLOBALS['x_packing'] = $rs->fields('packing');
		$GLOBALS['x_transport'] = $rs->fields('transport');
		$GLOBALS['x_other'] = $rs->fields('other');
		$GLOBALS['x_feedcostperbag'] = $rs->fields('feedcostperbag');
		$GLOBALS['x_feedcostperkg'] = $rs->fields('feedcostperkg');
		$GLOBALS['x_formulaid'] = $rs->fields('formulaid');
		$val[1] = $GLOBALS['x_batches'];
		$val[2] = $GLOBALS['x_matconsumed'];
		$val[3] = $GLOBALS['x_production'];
		$val[4] = $GLOBALS['x_shrinkage'];
		$val[5] = $GLOBALS['x_materialcost'];
		$val[6] = $GLOBALS['x_shrinkagecost'];
		$val[7] = $GLOBALS['x_bagtype'];
		$val[8] = $GLOBALS['x_noofbags'];
		$val[9] = $GLOBALS['x_labourcharges'];
		$val[10] = $GLOBALS['x_noofunits'];
		$val[11] = $GLOBALS['x_costperunit'];
		$val[12] = $GLOBALS['x_packing'];
		$val[13] = $GLOBALS['x_transport'];
		$val[14] = $GLOBALS['x_other'];
		$val[15] = $GLOBALS['x_feedcostperbag'];
		$val[16] = $GLOBALS['x_feedcostperkg'];
		$val[17] = $GLOBALS['x_formulaid'];
	} else {
		$GLOBALS['x_mash'] = "";
		$GLOBALS['x_formula'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_batches'] = "";
		$GLOBALS['x_matconsumed'] = "";
		$GLOBALS['x_production'] = "";
		$GLOBALS['x_shrinkage'] = "";
		$GLOBALS['x_materialcost'] = "";
		$GLOBALS['x_shrinkagecost'] = "";
		$GLOBALS['x_bagtype'] = "";
		$GLOBALS['x_noofbags'] = "";
		$GLOBALS['x_labourcharges'] = "";
		$GLOBALS['x_noofunits'] = "";
		$GLOBALS['x_costperunit'] = "";
		$GLOBALS['x_packing'] = "";
		$GLOBALS['x_transport'] = "";
		$GLOBALS['x_other'] = "";
		$GLOBALS['x_feedcostperbag'] = "";
		$GLOBALS['x_feedcostperkg'] = "";
		$GLOBALS['x_formulaid'] = "";
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
	// Build distinct values for feedmill

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FEEDMILL_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FEEDMILL_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_feedmill = $rswrk->fields[0];
		if (is_null($x_feedmill)) {
			$bNullValue = TRUE;
		} elseif ($x_feedmill == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_feedmill = $x_feedmill;
			$dg_feedmill = $x_feedmill;
			ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], $g_feedmill, $dg_feedmill, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for mash
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_MASH_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_MASH_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_mash = $rswrk->fields[0];
		if (is_null($x_mash)) {
			$bNullValue = TRUE;
		} elseif ($x_mash == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_mash = $x_mash;
			$dg_mash = $x_mash;
			ewrpt_SetupDistinctValues($GLOBALS["val_mash"], $g_mash, $dg_mash, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_mash"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_mash"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for formula
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FORMULA_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FORMULA_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_formula = $rswrk->fields[0];
		if (is_null($x_formula)) {
			$bNullValue = TRUE;
		} elseif ($x_formula == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_formula = $x_formula;
			$dg_formula = $x_formula;
			ewrpt_SetupDistinctValues($GLOBALS["val_formula"], $g_formula, $dg_formula, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_formula"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_formula"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('feedmill');
			ClearSessionSelection('mash');
			ClearSessionSelection('formula');
			ClearSessionSelection('date');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Feedmill selected values

	if (is_array(@$_SESSION["sel_feed_production_feedmill"])) {
		LoadSelectionFromSession('feedmill');
	} elseif (@$_SESSION["sel_feed_production_feedmill"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_feedmill"] = "";
	}

	// Get Mash selected values
	if (is_array(@$_SESSION["sel_feed_production_mash"])) {
		LoadSelectionFromSession('mash');
	} elseif (@$_SESSION["sel_feed_production_mash"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_mash"] = "";
	}

	// Get Formula selected values
	if (is_array(@$_SESSION["sel_feed_production_formula"])) {
		LoadSelectionFromSession('formula');
	} elseif (@$_SESSION["sel_feed_production_formula"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_formula"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_feed_production_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_feed_production_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
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
				$nDisplayGrps = 3; // Non-numeric, load default
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
			$nDisplayGrps = 3; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_feed_production_$parm"] = "";
	$_SESSION["rf_feed_production_$parm"] = "";
	$_SESSION["rt_feed_production_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_feed_production_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_feed_production_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_feed_production_$parm"];
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

	// Field feedmill
	// Setup your default values for the popup filter below, e.g.
	// $seld_feedmill = array("val1", "val2");

	$GLOBALS["seld_feedmill"] = "";
	$GLOBALS["sel_feedmill"] =  $GLOBALS["seld_feedmill"];

	// Field mash
	// Setup your default values for the popup filter below, e.g.
	// $seld_mash = array("val1", "val2");

	$GLOBALS["seld_mash"] = "";
	$GLOBALS["sel_mash"] =  $GLOBALS["seld_mash"];

	// Field formula
	// Setup your default values for the popup filter below, e.g.
	// $seld_formula = array("val1", "val2");

	$GLOBALS["seld_formula"] = "";
	$GLOBALS["sel_formula"] =  $GLOBALS["seld_formula"];

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];
}

// Check if filter applied
function CheckFilter() {

	// Check feedmill popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_feedmill"], $GLOBALS["sel_feedmill"]))
		return TRUE;

	// Check mash popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_mash"], $GLOBALS["sel_mash"]))
		return TRUE;

	// Check formula popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_formula"], $GLOBALS["sel_formula"]))
		return TRUE;

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field feedmill
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_feedmill"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_feedmill"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Feedmill<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field mash
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_mash"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_mash"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Mash<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field formula
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_formula"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_formula"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Formula<br />";
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
	if (is_array($GLOBALS["sel_feedmill"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_feedmill"], "feed_productionunit.feedmill", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_feedmill"], $GLOBALS["gb_feedmill"], $GLOBALS["gi_feedmill"], $GLOBALS["gq_feedmill"]);
	}
	if (is_array($GLOBALS["sel_mash"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_mash"], "feed_productionunit.mash", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_mash"], $GLOBALS["gb_mash"], $GLOBALS["gi_mash"], $GLOBALS["gq_mash"]);
	}
	if (is_array($GLOBALS["sel_formula"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_formula"], "feed_productionunit.formula", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_formula"], $GLOBALS["gb_formula"], $GLOBALS["gi_formula"], $GLOBALS["gq_formula"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "feed_productionunit.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
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
			$_SESSION["sort_feed_production_feedmill"] = "";
			$_SESSION["sort_feed_production_mash"] = "";
			$_SESSION["sort_feed_production_formula"] = "";
			$_SESSION["sort_feed_production_date"] = "";
			$_SESSION["sort_feed_production_batches"] = "";
			$_SESSION["sort_feed_production_matconsumed"] = "";
			$_SESSION["sort_feed_production_production"] = "";
			$_SESSION["sort_feed_production_shrinkage"] = "";
			$_SESSION["sort_feed_production_materialcost"] = "";
			$_SESSION["sort_feed_production_shrinkagecost"] = "";
			$_SESSION["sort_feed_production_bagtype"] = "";
			$_SESSION["sort_feed_production_noofbags"] = "";
			$_SESSION["sort_feed_production_labourcharges"] = "";
			$_SESSION["sort_feed_production_noofunits"] = "";
			$_SESSION["sort_feed_production_costperunit"] = "";
			$_SESSION["sort_feed_production_packing"] = "";
			$_SESSION["sort_feed_production_transport"] = "";
			$_SESSION["sort_feed_production_other"] = "";
			$_SESSION["sort_feed_production_feedcostperbag"] = "";
			$_SESSION["sort_feed_production_feedcostperkg"] = "";
			$_SESSION["sort_feed_production_formulaid"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "feed_productionunit.batches ASC";
		$_SESSION["sort_feed_production_batches"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>


<script type="text/javascript">
function reloadpage()
{
	var category = document.getElementById('category').value;	
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
	var supplier = document.getElementById('supplier').value;
	document.location = "purchasecostanalysis.php?category="+category+"&fromdate=" + fromdate + "&todate=" + todate + "&supplier=" + supplier;
}
</script>

