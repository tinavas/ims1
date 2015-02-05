<?php
session_start();
ob_start();
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
<?php include "reportheader.php";?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Processing Report</font></strong></td>
</tr>
</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "chickenprocessing", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "chickenprocessing_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "chickenprocessing_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "chickenprocessing_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "chickenprocessing_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "chickenprocessing_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "chicken_chickentransfer";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT chicken_chickentransfer.date, chicken_chickentransfer.unit, chicken_chickentransfer.birds, chicken_chickentransfer.fromtype, chicken_chickentransfer.category, chicken_chickentransfer.tocode, chicken_chickentransfer.todescription, chicken_chickentransfer.units, chicken_chickentransfer.quantity FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "chicken_chickentransfer.date ASC, chicken_chickentransfer.unit ASC, chicken_chickentransfer.fromtype ASC, chicken_chickentransfer.category ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "chicken_chickentransfer.date", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = NULL; // Popup filter for date
$af_unit = NULL; // Popup filter for unit
$af_birds = NULL; // Popup filter for birds
$af_fromtype = NULL; // Popup filter for fromtype
$af_category = NULL; // Popup filter for category
$af_tocode = NULL; // Popup filter for tocode
$af_todescription = NULL; // Popup filter for todescription
$af_units = NULL; // Popup filter for units
$af_quantity = NULL; // Popup filter for quantity
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
$nDisplayGrps = 100; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "chicken_chickentransfer.date";
$EW_REPORT_FIELD_UNIT_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNIT_SQL_ORDERBY = "chicken_chickentransfer.unit";
$EW_REPORT_FIELD_FROMTYPE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.fromtype FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMTYPE_SQL_ORDERBY = "chicken_chickentransfer.fromtype";
$EW_REPORT_FIELD_CATEGORY_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.category FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CATEGORY_SQL_ORDERBY = "chicken_chickentransfer.category";
$EW_REPORT_FIELD_TOCODE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.tocode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TOCODE_SQL_ORDERBY = "chicken_chickentransfer.tocode";
$EW_REPORT_FIELD_TODESCRIPTION_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.todescription FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TODESCRIPTION_SQL_ORDERBY = "chicken_chickentransfer.todescription";
?>
<?php

// Field variables
$x_date = NULL;
$x_unit = NULL;
$x_birds = NULL;
$x_fromtype = NULL;
$x_category = NULL;
$x_tocode = NULL;
$x_todescription = NULL;
$x_units = NULL;
$x_quantity = NULL;

// Group variables
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_unit = NULL; $g_unit = NULL; $dg_unit = NULL; $t_unit = NULL; $ft_unit = 200; $gf_unit = $ft_unit; $gb_unit = ""; $gi_unit = "0"; $gq_unit = ""; $rf_unit = NULL; $rt_unit = NULL;
$o_fromtype = NULL; $g_fromtype = NULL; $dg_fromtype = NULL; $t_fromtype = NULL; $ft_fromtype = 200; $gf_fromtype = $ft_fromtype; $gb_fromtype = ""; $gi_fromtype = "0"; $gq_fromtype = ""; $rf_fromtype = NULL; $rt_fromtype = NULL;
$o_category = NULL; $g_category = NULL; $dg_category = NULL; $t_category = NULL; $ft_category = 200; $gf_category = $ft_category; $gb_category = ""; $gi_category = "0"; $gq_category = ""; $rf_category = NULL; $rt_category = NULL;

// Detail variables
$o_birds = NULL; $t_birds = NULL; $ft_birds = 3; $rf_birds = NULL; $rt_birds = NULL;
$o_tocode = NULL; $t_tocode = NULL; $ft_tocode = 200; $rf_tocode = NULL; $rt_tocode = NULL;
$o_todescription = NULL; $t_todescription = NULL; $ft_todescription = 200; $rf_todescription = NULL; $rt_todescription = NULL;
$o_units = NULL; $t_units = NULL; $ft_units = 200; $rf_units = NULL; $rt_units = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 3; $rf_quantity = NULL; $rt_quantity = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 6;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_unit = "";
$seld_unit = "";
$val_unit = "";
$sel_fromtype = "";
$seld_fromtype = "";
$val_fromtype = "";
$sel_category = "";
$seld_category = "";
$val_category = "";
$sel_tocode = "";
$seld_tocode = "";
$val_tocode = "";
$sel_todescription = "";
$seld_todescription = "";
$val_todescription = "";

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

// popup fields
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("chickenprocessing_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unit, $sel_unit, $ft_unit) ?>
ewrpt_CreatePopup("chickenprocessing_unit", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromtype, $sel_fromtype, $ft_fromtype) ?>
ewrpt_CreatePopup("chickenprocessing_fromtype", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_category, $sel_category, $ft_category) ?>
ewrpt_CreatePopup("chickenprocessing_category", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_tocode, $sel_tocode, $ft_tocode) ?>
ewrpt_CreatePopup("chickenprocessing_tocode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_todescription, $sel_todescription, $ft_todescription) ?>
ewrpt_CreatePopup("chickenprocessing_todescription", [<?php echo $jsdata ?>]);
</script>
<div id="chickenprocessing_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="chickenprocessing_unit_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="chickenprocessing_fromtype_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="chickenprocessing_category_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="chickenprocessing_tocode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="chickenprocessing_todescription_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3" align="center"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="chickenprocessingsmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="chickenprocessingsmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="chickenprocessingsmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chickenprocessingsmry.php?cmd=reset">Reset All Filters</a>
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>

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
while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Unit</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_unit', false, '<?php echo $rf_unit; ?>', '<?php echo $rt_unit; ?>');return false;" name="x_unit<?php echo $cnt[0][0]; ?>" id="x_unit<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		From Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>From Category</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_fromtype', false, '<?php echo $rf_fromtype; ?>', '<?php echo $rt_fromtype; ?>');return false;" name="x_fromtype<?php echo $cnt[0][0]; ?>" id="x_fromtype<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		To Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>To Category</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_category', false, '<?php echo $rf_category; ?>', '<?php echo $rt_category; ?>');return false;" name="x_category<?php echo $cnt[0][0]; ?>" id="x_category<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php if($_SESSION['db']=="vista") {?>Pieces<?php } else {?>Birds<?php } ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
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
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_tocode', false, '<?php echo $rf_tocode; ?>', '<?php echo $rt_tocode; ?>');return false;" name="x_tocode<?php echo $cnt[0][0]; ?>" id="x_tocode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td>Description</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'chickenprocessing_todescription', false, '<?php echo $rf_todescription; ?>', '<?php echo $rt_todescription; ?>');return false;" name="x_todescription<?php echo $cnt[0][0]; ?>" id="x_todescription<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
<?php if($_SESSION['db']=="vista") {?>Pieces <?php } else { ?> Quantity<?php } ?>
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php if($_SESSION['db']=="vista") {?>Pieces <?php } else { ?> Quantity<?php } ?>
		</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php if($_SESSION['db']=="vista") {?>Weight(kgs) <?php } else { ?> Kgs<?php } ?>
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php if($_SESSION['db']=="vista") {?>Weight(kgs) <?php } else { ?> Kgs<?php } ?>
		</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
		$dumm1 = 0;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_date, EW_REPORT_DATATYPE_DATE);
$we_total=0;
	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_date, EW_REPORT_DATATYPE_DATE, $gb_date, $gi_date, $gq_date);
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
		$dg_date = $x_date;
		if ((is_null($x_date) && is_null($o_date)) ||
			(($x_date <> "" && $o_date == $dg_date) && !ChkLvlBreak(1))) {
			$dg_date = "&nbsp;";
		} elseif (is_null($x_date)) {
			$dg_date = EW_REPORT_NULL_LABEL;
		} elseif ($x_date == "") {
			$dg_date = EW_REPORT_EMPTY_LABEL;
		}
		$dg_unit = $x_unit;
		if ((is_null($x_unit) && is_null($o_unit)) ||
			(($x_unit <> "" && $o_unit == $dg_unit) && !ChkLvlBreak(2))) {
			$dg_unit = "&nbsp;";
		} elseif (is_null($x_unit)) {
			$dg_unit = EW_REPORT_NULL_LABEL;
		} elseif ($x_unit == "") {
			$dg_unit = EW_REPORT_EMPTY_LABEL;
		}
		$dg_fromtype = $x_fromtype;
		if ((is_null($x_fromtype) && is_null($o_fromtype)) ||
			(($x_fromtype <> "" && $o_fromtype == $dg_fromtype) && !ChkLvlBreak(3))) {
			$dg_fromtype = "&nbsp;";
		} elseif (is_null($x_fromtype)) {
			$dg_fromtype = EW_REPORT_NULL_LABEL;
		} elseif ($x_fromtype == "") {
			$dg_fromtype = EW_REPORT_EMPTY_LABEL;
		}
		$dg_category = $x_category;
		if ((is_null($x_category) && is_null($o_category)) ||
			(($x_category <> "" && $o_category == $dg_category) && !ChkLvlBreak(4))) {
			$dg_category = "&nbsp;";
		} elseif (is_null($x_category)) {
			$dg_category = EW_REPORT_NULL_LABEL;
		} elseif ($x_category == "") {
			$dg_category = EW_REPORT_EMPTY_LABEL;
		}
$date = date("d.m.Y",strtotime($x_date));
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php if(($date <> $oldcode1) or ($dumm1 == 0)){ echo ewrpt_ViewValue($date);
     $oldcode1 = $date; $dumm1 = 1;
	 $ab=1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
		 $ab=0;
	 } ?>
</td>
		<td class="ewRptGrpField2">
		<?php $t_unit = $x_unit; $x_unit = $dg_unit; ?>
<?php echo ewrpt_ViewValue($x_unit) ?>
		<?php $x_unit = $t_unit; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_fromtype = $x_fromtype; $x_fromtype = $dg_fromtype; ?>
<?php echo ewrpt_ViewValue($x_fromtype) ?>
		<?php $x_fromtype = $t_fromtype; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_category = $x_category; $x_category = $dg_category; ?>
<?php echo ewrpt_ViewValue($x_category) ?>
		<?php $x_category = $t_category; ?></td>
		
		
		<td class="ewRptGrpField1">
		<?php if(($x_birds <> $oldcode112) or ($dumm112 == 0)){ echo ewrpt_ViewValue($x_birds);
     $oldcode112 = $x_birds; $dumm112 = 1;
	 $b=$b+$x_birds; 
	 
	  }
else if($ab==1)
{
echo ewrpt_ViewValue($x_birds);
$b=$b+$x_birds;
    	
}
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
</td>
		
		
		
<?php
$query = "select weight from chicken_chickentransfer where date =  '$x_date' and unit='$x_unit' and birds='$x_birds' and tocode='$x_tocode' and todescription='$x_todescription' and client = '$client' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $we1=$rows['weight'];	
 $we_total1=$we_total1+$we1;
}

?>

<td class="ewRptGrpField1">
		<?php if(($we1 <> $oldcode1123) or ($dumm1123 == 0)){ echo ewrpt_ViewValue($we1);
     $oldcode1123 = $we1; $dumm1123 = 1;
	 $b1=$b1+$we1; 
	 
	  }
		
		else if($ab==1)
{
echo ewrpt_ViewValue($we1);
$b1=$b1+$we1;
    	
}
		
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
</td>




		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_tocode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_todescription) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php

echo ewrpt_ViewValue($x_units) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php
$q=$q+$x_quantity;
 echo ewrpt_ViewValue($x_quantity) ?>
</td>
<?php 


 $query = "select kgs from chicken_chickentransfer where date =  '$x_date' and unit='$x_unit' and birds='$x_birds' and tocode='$x_tocode' and todescription='$x_todescription' and client = '$client' ";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $we11=$rows['kgs'];	
 $we_total11=$we_total11+$we11;
}

?>
<td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($we11);?></td>
<?php

 /*?><?php

 if(($we <> $wei) or ($dumm3 == 0)){ echo ewrpt_ViewValue($we);
     $wei = $we; $dumm3 = 1;
 $we1=$we1+$we; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td><?php */?>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date = $x_date;
		$o_unit = $x_unit;
		$o_fromtype = $x_fromtype;
		$o_category = $x_category;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_date = $x_date; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
<tr><td colspan="4" align="right">Total</td>
<td align="right" ><?php echo round($b) ;?></td>
<td align="right" ><?php echo round($b1) ;?></td>
<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
<td align="right" ><?php echo round($q) ;?></td>

<td align="right" ><?php echo round($we_total11) ;?></td>
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
	<!-- tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>

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
			return (is_null($GLOBALS["x_date"]) && !is_null($GLOBALS["o_date"])) ||
				(!is_null($GLOBALS["x_date"]) && is_null($GLOBALS["o_date"])) ||
				($GLOBALS["x_date"] <> $GLOBALS["o_date"]);
		case 2:
			return (is_null($GLOBALS["x_unit"]) && !is_null($GLOBALS["o_unit"])) ||
				(!is_null($GLOBALS["x_unit"]) && is_null($GLOBALS["o_unit"])) ||
				($GLOBALS["x_unit"] <> $GLOBALS["o_unit"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_fromtype"]) && !is_null($GLOBALS["o_fromtype"])) ||
				(!is_null($GLOBALS["x_fromtype"]) && is_null($GLOBALS["o_fromtype"])) ||
				($GLOBALS["x_fromtype"] <> $GLOBALS["o_fromtype"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_category"]) && !is_null($GLOBALS["o_category"])) ||
				(!is_null($GLOBALS["x_category"]) && is_null($GLOBALS["o_category"])) ||
				($GLOBALS["x_category"] <> $GLOBALS["o_category"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_date"] = "";
	if ($lvl <= 2) $GLOBALS["o_unit"] = "";
	if ($lvl <= 3) $GLOBALS["o_fromtype"] = "";
	if ($lvl <= 4) $GLOBALS["o_category"] = "";

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
		$GLOBALS['x_date'] = "";
	} else {
		$GLOBALS['x_date'] = $rsgrp->fields('date');
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
		$GLOBALS['x_unit'] = $rs->fields('unit');
		$GLOBALS['x_birds'] = $rs->fields('birds');
		$GLOBALS['x_fromtype'] = $rs->fields('fromtype');
		$GLOBALS['x_category'] = $rs->fields('category');
		$GLOBALS['x_tocode'] = $rs->fields('tocode');
		$GLOBALS['x_todescription'] = $rs->fields('todescription');
		$GLOBALS['x_units'] = $rs->fields('units');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$val[1] = $GLOBALS['x_birds'];
		$val[2] = $GLOBALS['x_tocode'];
		$val[3] = $GLOBALS['x_todescription'];
		$val[4] = $GLOBALS['x_units'];
		$val[5] = $GLOBALS['x_quantity'];
	} else {
		$GLOBALS['x_unit'] = "";
		$GLOBALS['x_birds'] = "";
		$GLOBALS['x_fromtype'] = "";
		$GLOBALS['x_category'] = "";
		$GLOBALS['x_tocode'] = "";
		$GLOBALS['x_todescription'] = "";
		$GLOBALS['x_units'] = "";
		$GLOBALS['x_quantity'] = "";
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
			$dg_date = ewrpt_FormatDateTime($x_date,5);
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

	// Build distinct values for unit
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_UNIT_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_UNIT_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_unit = $rswrk->fields[0];
		if (is_null($x_unit)) {
			$bNullValue = TRUE;
		} elseif ($x_unit == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_unit = $x_unit;
			$dg_unit = $x_unit;
			ewrpt_SetupDistinctValues($GLOBALS["val_unit"], $g_unit, $dg_unit, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unit"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unit"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for fromtype
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FROMTYPE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FROMTYPE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_fromtype = $rswrk->fields[0];
		if (is_null($x_fromtype)) {
			$bNullValue = TRUE;
		} elseif ($x_fromtype == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_fromtype = $x_fromtype;
			$dg_fromtype = $x_fromtype;
			ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], $g_fromtype, $dg_fromtype, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for category
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_CATEGORY_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_CATEGORY_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_category = $rswrk->fields[0];
		if (is_null($x_category)) {
			$bNullValue = TRUE;
		} elseif ($x_category == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_category = $x_category;
			$dg_category = $x_category;
			ewrpt_SetupDistinctValues($GLOBALS["val_category"], $g_category, $dg_category, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_category"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_category"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for tocode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TOCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TOCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_tocode = $rswrk->fields[0];
		if (is_null($x_tocode)) {
			$bNullValue = TRUE;
		} elseif ($x_tocode == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_tocode = $x_tocode;
			ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], $x_tocode, $t_tocode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for todescription
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TODESCRIPTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TODESCRIPTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_todescription = $rswrk->fields[0];
		if (is_null($x_todescription)) {
			$bNullValue = TRUE;
		} elseif ($x_todescription == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_todescription = $x_todescription;
			ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], $x_todescription, $t_todescription, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('date');
			ClearSessionSelection('unit');
			ClearSessionSelection('fromtype');
			ClearSessionSelection('category');
			ClearSessionSelection('tocode');
			ClearSessionSelection('todescription');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_chickenprocessing_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_chickenprocessing_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Unit selected values
	if (is_array(@$_SESSION["sel_chickenprocessing_unit"])) {
		LoadSelectionFromSession('unit');
	} elseif (@$_SESSION["sel_chickenprocessing_unit"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unit"] = "";
	}

	// Get Fromtype selected values
	if (is_array(@$_SESSION["sel_chickenprocessing_fromtype"])) {
		LoadSelectionFromSession('fromtype');
	} elseif (@$_SESSION["sel_chickenprocessing_fromtype"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromtype"] = "";
	}

	// Get Category selected values
	if (is_array(@$_SESSION["sel_chickenprocessing_category"])) {
		LoadSelectionFromSession('category');
	} elseif (@$_SESSION["sel_chickenprocessing_category"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_category"] = "";
	}

	// Get Tocode selected values
	if (is_array(@$_SESSION["sel_chickenprocessing_tocode"])) {
		LoadSelectionFromSession('tocode');
	} elseif (@$_SESSION["sel_chickenprocessing_tocode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_tocode"] = "";
	}

	// Get Todescription selected values
	if (is_array(@$_SESSION["sel_chickenprocessing_todescription"])) {
		LoadSelectionFromSession('todescription');
	} elseif (@$_SESSION["sel_chickenprocessing_todescription"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_todescription"] = "";
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
				$nDisplayGrps = 100; // Non-numeric, load default
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
			$nDisplayGrps = 100; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_chickenprocessing_$parm"] = "";
	$_SESSION["rf_chickenprocessing_$parm"] = "";
	$_SESSION["rt_chickenprocessing_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_chickenprocessing_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_chickenprocessing_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_chickenprocessing_$parm"];
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

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];

	// Field unit
	// Setup your default values for the popup filter below, e.g.
	// $seld_unit = array("val1", "val2");

	$GLOBALS["seld_unit"] = "";
	$GLOBALS["sel_unit"] =  $GLOBALS["seld_unit"];

	// Field fromtype
	// Setup your default values for the popup filter below, e.g.
	// $seld_fromtype = array("val1", "val2");

	$GLOBALS["seld_fromtype"] = "";
	$GLOBALS["sel_fromtype"] =  $GLOBALS["seld_fromtype"];

	// Field category
	// Setup your default values for the popup filter below, e.g.
	// $seld_category = array("val1", "val2");

	$GLOBALS["seld_category"] = "";
	$GLOBALS["sel_category"] =  $GLOBALS["seld_category"];

	// Field tocode
	// Setup your default values for the popup filter below, e.g.
	// $seld_tocode = array("val1", "val2");

	$GLOBALS["seld_tocode"] = "";
	$GLOBALS["sel_tocode"] =  $GLOBALS["seld_tocode"];

	// Field todescription
	// Setup your default values for the popup filter below, e.g.
	// $seld_todescription = array("val1", "val2");

	$GLOBALS["seld_todescription"] = "";
	$GLOBALS["sel_todescription"] =  $GLOBALS["seld_todescription"];
}

// Check if filter applied
function CheckFilter() {

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check unit popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unit"], $GLOBALS["sel_unit"]))
		return TRUE;

	// Check fromtype popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromtype"], $GLOBALS["sel_fromtype"]))
		return TRUE;

	// Check category popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_category"], $GLOBALS["sel_category"]))
		return TRUE;

	// Check tocode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_tocode"], $GLOBALS["sel_tocode"]))
		return TRUE;

	// Check todescription popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_todescription"], $GLOBALS["sel_todescription"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

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

	// Field unit
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_unit"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_unit"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Unit<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field fromtype
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_fromtype"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_fromtype"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fromtype<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field category
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_category"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_category"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Category<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field tocode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_tocode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_tocode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Tocode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field todescription
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_todescription"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_todescription"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Todescription<br />";
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
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "chicken_chickentransfer.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_unit"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unit"], "chicken_chickentransfer.unit", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unit"], $GLOBALS["gb_unit"], $GLOBALS["gi_unit"], $GLOBALS["gq_unit"]);
	}
	if (is_array($GLOBALS["sel_fromtype"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromtype"], "chicken_chickentransfer.fromtype", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromtype"], $GLOBALS["gb_fromtype"], $GLOBALS["gi_fromtype"], $GLOBALS["gq_fromtype"]);
	}
	if (is_array($GLOBALS["sel_category"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_category"], "chicken_chickentransfer.category", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_category"], $GLOBALS["gb_category"], $GLOBALS["gi_category"], $GLOBALS["gq_category"]);
	}
	if (is_array($GLOBALS["sel_tocode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_tocode"], "chicken_chickentransfer.tocode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_tocode"]);
	}
	if (is_array($GLOBALS["sel_todescription"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_todescription"], "chicken_chickentransfer.todescription", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_todescription"]);
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
			$_SESSION["sort_chickenprocessing_date"] = "";
			$_SESSION["sort_chickenprocessing_unit"] = "";
			$_SESSION["sort_chickenprocessing_fromtype"] = "";
			$_SESSION["sort_chickenprocessing_category"] = "";
			$_SESSION["sort_chickenprocessing_birds"] = "";
			$_SESSION["sort_chickenprocessing_tocode"] = "";
			$_SESSION["sort_chickenprocessing_todescription"] = "";
			$_SESSION["sort_chickenprocessing_units"] = "";
			$_SESSION["sort_chickenprocessing_quantity"] = "";
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
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
