<?php
session_start();
ob_start();
$iitem = "";
$iquantity = "";

$oitem = "";
$oquantity = "";
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
define("EW_REPORT_TABLE_VAR", "workorder", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "workorder_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "workorder_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "workorder_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "workorder_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "workorder_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "breeder_woinputs Inner Join breeder_wooutputs On breeder_woinputs.wo = breeder_wooutputs.wo";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT breeder_woinputs.date, breeder_woinputs.bom, breeder_woinputs.flock, breeder_woinputs.wo, breeder_woinputs.iitem, breeder_woinputs.iquantity, breeder_woinputs.iunits, breeder_wooutputs.oitem, breeder_wooutputs.oquantity, breeder_wooutputs.ounits FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "breeder_woinputs.date ASC, breeder_woinputs.bom ASC, breeder_woinputs.flock ASC, breeder_woinputs.wo ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "breeder_woinputs.date", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = array(); // Popup filter for date
$af_date[0][0] = "@@1";
$af_date[0][1] = "Past";
$af_date[0][2] = ewrpt_IsPast(); // Return sql part
$af_date[1][0] = "@@2";
$af_date[1][1] = "Future";
$af_date[1][2] = ewrpt_IsFuture(); // Return sql part
$af_date[2][0] = "@@3";
$af_date[2][1] = "Last 30 days";
$af_date[2][2] = ewrpt_IsLast30Days(); // Return sql part
$af_date[3][0] = "@@4";
$af_date[3][1] = "Last 14 days";
$af_date[3][2] = ewrpt_IsLast14Days(); // Return sql part
$af_date[4][0] = "@@5";
$af_date[4][1] = "Last 7 days";
$af_date[4][2] = ewrpt_IsLast7Days(); // Return sql part
$af_date[5][0] = "@@6";
$af_date[5][1] = "Next 7 days";
$af_date[5][2] = ewrpt_IsNext7Days(); // Return sql part
$af_date[6][0] = "@@7";
$af_date[6][1] = "Next 14 days";
$af_date[6][2] = ewrpt_IsNext14Days(); // Return sql part
$af_date[7][0] = "@@8";
$af_date[7][1] = "Next 30 days";
$af_date[7][2] = ewrpt_IsNext30Days(); // Return sql part
$af_date[8][0] = "@@9";
$af_date[8][1] = "Yesterday";
$af_date[8][2] = ewrpt_IsYesterday(); // Return sql part
$af_date[9][0] = "@@10";
$af_date[9][1] = "Today";
$af_date[9][2] = ewrpt_IsToday(); // Return sql part
$af_date[10][0] = "@@11";
$af_date[10][1] = "Tomorrow";
$af_date[10][2] = ewrpt_IsTomorrow(); // Return sql part
$af_date[11][0] = "@@12";
$af_date[11][1] = "Last month";
$af_date[11][2] = ewrpt_IsLastMonth(); // Return sql part
$af_date[12][0] = "@@13";
$af_date[12][1] = "This month";
$af_date[12][2] = ewrpt_IsThisMonth(); // Return sql part
$af_date[13][0] = "@@14";
$af_date[13][1] = "Next month";
$af_date[13][2] = ewrpt_IsNextMonth(); // Return sql part
$af_date[14][0] = "@@15";
$af_date[14][1] = "Last two weeks";
$af_date[14][2] = ewrpt_IsLast2Weeks(); // Return sql part
$af_date[15][0] = "@@16";
$af_date[15][1] = "Last week";
$af_date[15][2] = ewrpt_IsLastWeek(); // Return sql part
$af_date[16][0] = "@@17";
$af_date[16][1] = "This week";
$af_date[16][2] = ewrpt_IsThisWeek(); // Return sql part
$af_date[17][0] = "@@18";
$af_date[17][1] = "Next week";
$af_date[17][2] = ewrpt_IsNextWeek(); // Return sql part
$af_date[18][0] = "@@19";
$af_date[18][1] = "Next two weeks";
$af_date[18][2] = ewrpt_IsNext2Weeks(); // Return sql part
$af_date[19][0] = "@@20";
$af_date[19][1] = "Last year";
$af_date[19][2] = ewrpt_IsLastYear(); // Return sql part
$af_date[20][0] = "@@21";
$af_date[20][1] = "This year";
$af_date[20][2] = ewrpt_IsThisYear(); // Return sql part
$af_date[21][0] = "@@22";
$af_date[21][1] = "Next year";
$af_date[21][2] = ewrpt_IsNextYear(); // Return sql part
$af_bom = NULL; // Popup filter for bom
$af_flock = NULL; // Popup filter for flock
$af_wo = NULL; // Popup filter for wo
$af_iitem = NULL; // Popup filter for iitem
$af_iquantity = NULL; // Popup filter for iquantity
$af_iunits = NULL; // Popup filter for iunits
$af_oitem = NULL; // Popup filter for oitem
$af_oquantity = NULL; // Popup filter for oquantity
$af_ounits = NULL; // Popup filter for ounits
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
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT breeder_woinputs.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "breeder_woinputs.date";
$EW_REPORT_FIELD_BOM_SQL_SELECT = "SELECT DISTINCT breeder_woinputs.bom FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_BOM_SQL_ORDERBY = "breeder_woinputs.bom";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT breeder_woinputs.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "breeder_woinputs.flock";
$EW_REPORT_FIELD_WO_SQL_SELECT = "SELECT DISTINCT breeder_woinputs.wo FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_WO_SQL_ORDERBY = "breeder_woinputs.wo";
$EW_REPORT_FIELD_IITEM_SQL_SELECT = "SELECT DISTINCT breeder_woinputs.iitem FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_IITEM_SQL_ORDERBY = "breeder_woinputs.iitem";
$EW_REPORT_FIELD_OITEM_SQL_SELECT = "SELECT DISTINCT breeder_wooutputs.oitem FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_OITEM_SQL_ORDERBY = "breeder_wooutputs.oitem";
?>
<?php

// Field variables
$x_date = NULL;
$x_bom = NULL;
$x_flock = NULL;
$x_wo = NULL;
$x_iitem = NULL;
$x_iquantity = NULL;
$x_iunits = NULL;
$x_oitem = NULL;
$x_oquantity = NULL;
$x_ounits = NULL;

// Group variables
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_bom = NULL; $g_bom = NULL; $dg_bom = NULL; $t_bom = NULL; $ft_bom = 200; $gf_bom = $ft_bom; $gb_bom = ""; $gi_bom = "0"; $gq_bom = ""; $rf_bom = NULL; $rt_bom = NULL;
$o_flock = NULL; $g_flock = NULL; $dg_flock = NULL; $t_flock = NULL; $ft_flock = 200; $gf_flock = $ft_flock; $gb_flock = ""; $gi_flock = "0"; $gq_flock = ""; $rf_flock = NULL; $rt_flock = NULL;
$o_wo = NULL; $g_wo = NULL; $dg_wo = NULL; $t_wo = NULL; $ft_wo = 200; $gf_wo = $ft_wo; $gb_wo = ""; $gi_wo = "0"; $gq_wo = ""; $rf_wo = NULL; $rt_wo = NULL;

// Detail variables
$o_iitem = NULL; $t_iitem = NULL; $ft_iitem = 200; $rf_iitem = NULL; $rt_iitem = NULL;
$o_iquantity = NULL; $t_iquantity = NULL; $ft_iquantity = 5; $rf_iquantity = NULL; $rt_iquantity = NULL;
$o_iunits = NULL; $t_iunits = NULL; $ft_iunits = 200; $rf_iunits = NULL; $rt_iunits = NULL;
$o_oitem = NULL; $t_oitem = NULL; $ft_oitem = 200; $rf_oitem = NULL; $rt_oitem = NULL;
$o_oquantity = NULL; $t_oquantity = NULL; $ft_oquantity = 5; $rf_oquantity = NULL; $rt_oquantity = NULL;
$o_ounits = NULL; $t_ounits = NULL; $ft_ounits = 200; $rf_ounits = NULL; $rt_ounits = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 7;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_bom = "";
$seld_bom = "";
$val_bom = "";
$sel_flock = "";
$seld_flock = "";
$val_flock = "";
$sel_wo = "";
$seld_wo = "";
$val_wo = "";
$sel_iitem = "";
$seld_iitem = "";
$val_iitem = "";
$sel_oitem = "";
$seld_oitem = "";
$val_oitem = "";

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
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("workorder_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_bom, $sel_bom, $ft_bom) ?>
ewrpt_CreatePopup("workorder_bom", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("workorder_flock", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_wo, $sel_wo, $ft_wo) ?>
ewrpt_CreatePopup("workorder_wo", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_iitem, $sel_iitem, $ft_iitem) ?>
ewrpt_CreatePopup("workorder_iitem", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_oitem, $sel_oitem, $ft_oitem) ?>
ewrpt_CreatePopup("workorder_oitem", [<?php echo $jsdata ?>]);
</script>
<div id="workorder_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="workorder_bom_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="workorder_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="workorder_wo_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="workorder_iitem_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="workorder_oitem_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
Work Order
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="workordersmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="workordersmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="workordersmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="workordersmry.php?cmd=reset">Reset All Filters</a>
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
<div class="ewGridUpperPanel">
<form action="workordersmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
<?php } ?>
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
while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
<tr>
<td class="ewTableHeader" colspan="4"></td>
<td class="ewTableHeader" colspan="4" style="text-align:center">Inputs Required</td>
<td class="ewTableHeader" colspan="4" style="text-align:center">Outputs Produced</td>
</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_date', true, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		B.O.M
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Bill Of Material">B.O.M</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_bom', false, '<?php echo $rf_bom; ?>', '<?php echo $rt_bom; ?>');return false;" name="x_bom<?php echo $cnt[0][0]; ?>" id="x_bom<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		Work Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Work Order</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_wo', false, '<?php echo $rf_wo; ?>', '<?php echo $rt_wo; ?>');return false;" name="x_wo<?php echo $cnt[0][0]; ?>" id="x_wo<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Input Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Input Item</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_iitem', false, '<?php echo $rf_iitem; ?>', '<?php echo $rt_iitem; ?>');return false;" name="x_iitem<?php echo $cnt[0][0]; ?>" id="x_iitem<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
		Output Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Output Item</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'workorder_oitem', false, '<?php echo $rf_oitem; ?>', '<?php echo $rt_oitem; ?>');return false;" name="x_oitem<?php echo $cnt[0][0]; ?>" id="x_oitem<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Units</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_date, EW_REPORT_DATATYPE_DATE);

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
		$dg_bom = $x_bom;
		if ((is_null($x_bom) && is_null($o_bom)) ||
			(($x_bom <> "" && $o_bom == $dg_bom) && !ChkLvlBreak(2))) {
			$dg_bom = "&nbsp;";
		} elseif (is_null($x_bom)) {
			$dg_bom = EW_REPORT_NULL_LABEL;
		} elseif ($x_bom == "") {
			$dg_bom = EW_REPORT_EMPTY_LABEL;
		}
		$dg_flock = $x_flock;
		if ((is_null($x_flock) && is_null($o_flock)) ||
			(($x_flock <> "" && $o_flock == $dg_flock) && !ChkLvlBreak(3))) {
			$dg_flock = "&nbsp;";
		} elseif (is_null($x_flock)) {
			$dg_flock = EW_REPORT_NULL_LABEL;
		} elseif ($x_flock == "") {
			$dg_flock = EW_REPORT_EMPTY_LABEL;
		}
		$dg_wo = $x_wo;
		if ((is_null($x_wo) && is_null($o_wo)) ||
			(($x_wo <> "" && $o_wo == $dg_wo) && !ChkLvlBreak(4))) {
			$dg_wo = "&nbsp;";
		} elseif (is_null($x_wo)) {
			$dg_wo = EW_REPORT_NULL_LABEL;
		} elseif ($x_wo == "") {
			$dg_wo = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
		<?php $x_date = $t_date; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_bom = $x_bom; $x_bom = $dg_bom; ?>
<?php echo ewrpt_ViewValue($x_bom) ?>
		<?php $x_bom = $t_bom; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_flock = $x_flock; $x_flock = $dg_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
		<?php $x_flock = $t_flock; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_wo = $x_wo; $x_wo = $dg_wo; ?>
<?php echo ewrpt_ViewValue($x_wo) ?>
		<?php $x_wo = $t_wo; ?></td>

<?php
 if($iitem <> $x_iitem)
 {
   $iitem = $x_iitem;
   $iquantity = $x_iquantity;
   $iunits = $x_iunits;
 }
 else
 {   
   $iitem = "";
   $iquantity = "";
   $iunits = "";
 }


 if($oitem <> $x_oitem)
 {
   $oitem = $x_oitem;
   $oquantity = $x_oquantity;
   $ounits = $x_ounits;
 }
 else
 {   
   $oitem = "";
   $oquantity = "";
   $ounits = "";
 }
?>
<?php
   include "config.php";
   $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$iitem'";
   $result3 = mysql_query($query3,$conn1);
   while($row3 = mysql_fetch_assoc($result3))
   {
     $iitemdesc = $row3['description'];
   }
?>
<?php
   include "config.php";
   $query3 = "SELECT * FROM ims_itemcodes WHERE code = '$oitem'";
   $result3 = mysql_query($query3,$conn1);
   while($row3 = mysql_fetch_assoc($result3))
   {
     $oitemdesc = $row3['description'];
   }
?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($iitem) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($iitemdesc) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($iquantity) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($iunits) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($oitem) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($oitemdesc) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($oquantity) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($ounits) ?>
</td>
	</tr>
<?php
$iitemdesc = "";
$oitemdesc = "";

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date = $x_date;
		$o_bom = $x_bom;
		$o_flock = $x_flock;
		$o_wo = $x_wo;

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
	<!-- tr><td colspan="10"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="10">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="workordersmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="workordersmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_bom"]) && !is_null($GLOBALS["o_bom"])) ||
				(!is_null($GLOBALS["x_bom"]) && is_null($GLOBALS["o_bom"])) ||
				($GLOBALS["x_bom"] <> $GLOBALS["o_bom"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_flock"]) && !is_null($GLOBALS["o_flock"])) ||
				(!is_null($GLOBALS["x_flock"]) && is_null($GLOBALS["o_flock"])) ||
				($GLOBALS["x_flock"] <> $GLOBALS["o_flock"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_wo"]) && !is_null($GLOBALS["o_wo"])) ||
				(!is_null($GLOBALS["x_wo"]) && is_null($GLOBALS["o_wo"])) ||
				($GLOBALS["x_wo"] <> $GLOBALS["o_wo"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 2) $GLOBALS["o_bom"] = "";
	if ($lvl <= 3) $GLOBALS["o_flock"] = "";
	if ($lvl <= 4) $GLOBALS["o_wo"] = "";

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
		$GLOBALS['x_bom'] = $rs->fields('bom');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_wo'] = $rs->fields('wo');
		$GLOBALS['x_iitem'] = $rs->fields('iitem');
		$GLOBALS['x_iquantity'] = $rs->fields('iquantity');
		$GLOBALS['x_iunits'] = $rs->fields('iunits');
		$GLOBALS['x_oitem'] = $rs->fields('oitem');
		$GLOBALS['x_oquantity'] = $rs->fields('oquantity');
		$GLOBALS['x_ounits'] = $rs->fields('ounits');
		$val[1] = $GLOBALS['x_iitem'];
		$val[2] = $GLOBALS['x_iquantity'];
		$val[3] = $GLOBALS['x_iunits'];
		$val[4] = $GLOBALS['x_oitem'];
		$val[5] = $GLOBALS['x_oquantity'];
		$val[6] = $GLOBALS['x_ounits'];
	} else {
		$GLOBALS['x_bom'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_wo'] = "";
		$GLOBALS['x_iitem'] = "";
		$GLOBALS['x_iquantity'] = "";
		$GLOBALS['x_iunits'] = "";
		$GLOBALS['x_oitem'] = "";
		$GLOBALS['x_oquantity'] = "";
		$GLOBALS['x_ounits'] = "";
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

	ewrpt_SetupDistinctValuesFromFilter($GLOBALS["val_date"], $GLOBALS["af_date"]); // Set up popup filter
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

	// Build distinct values for bom
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_BOM_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_BOM_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_bom = $rswrk->fields[0];
		if (is_null($x_bom)) {
			$bNullValue = TRUE;
		} elseif ($x_bom == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_bom = $x_bom;
			$dg_bom = $x_bom;
			ewrpt_SetupDistinctValues($GLOBALS["val_bom"], $g_bom, $dg_bom, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_bom"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_bom"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for flock
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FLOCK_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FLOCK_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_flock = $rswrk->fields[0];
		if (is_null($x_flock)) {
			$bNullValue = TRUE;
		} elseif ($x_flock == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_flock = $x_flock;
			$dg_flock = $x_flock;
			ewrpt_SetupDistinctValues($GLOBALS["val_flock"], $g_flock, $dg_flock, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for wo
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_WO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_WO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_wo = $rswrk->fields[0];
		if (is_null($x_wo)) {
			$bNullValue = TRUE;
		} elseif ($x_wo == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_wo = $x_wo;
			$dg_wo = $x_wo;
			ewrpt_SetupDistinctValues($GLOBALS["val_wo"], $g_wo, $dg_wo, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_wo"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_wo"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for iitem
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_IITEM_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_IITEM_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_iitem = $rswrk->fields[0];
		if (is_null($x_iitem)) {
			$bNullValue = TRUE;
		} elseif ($x_iitem == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_iitem = $x_iitem;
			ewrpt_SetupDistinctValues($GLOBALS["val_iitem"], $x_iitem, $t_iitem, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_iitem"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_iitem"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for oitem
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_OITEM_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_OITEM_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_oitem = $rswrk->fields[0];
		if (is_null($x_oitem)) {
			$bNullValue = TRUE;
		} elseif ($x_oitem == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_oitem = $x_oitem;
			ewrpt_SetupDistinctValues($GLOBALS["val_oitem"], $x_oitem, $t_oitem, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_oitem"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_oitem"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('bom');
			ClearSessionSelection('flock');
			ClearSessionSelection('wo');
			ClearSessionSelection('iitem');
			ClearSessionSelection('oitem');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_workorder_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_workorder_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Bom selected values
	if (is_array(@$_SESSION["sel_workorder_bom"])) {
		LoadSelectionFromSession('bom');
	} elseif (@$_SESSION["sel_workorder_bom"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_bom"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_workorder_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_workorder_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
	}

	// Get Wo selected values
	if (is_array(@$_SESSION["sel_workorder_wo"])) {
		LoadSelectionFromSession('wo');
	} elseif (@$_SESSION["sel_workorder_wo"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_wo"] = "";
	}

	// Get Iitem selected values
	if (is_array(@$_SESSION["sel_workorder_iitem"])) {
		LoadSelectionFromSession('iitem');
	} elseif (@$_SESSION["sel_workorder_iitem"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_iitem"] = "";
	}

	// Get Oitem selected values
	if (is_array(@$_SESSION["sel_workorder_oitem"])) {
		LoadSelectionFromSession('oitem');
	} elseif (@$_SESSION["sel_workorder_oitem"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_oitem"] = "";
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
	$_SESSION["sel_workorder_$parm"] = "";
	$_SESSION["rf_workorder_$parm"] = "";
	$_SESSION["rt_workorder_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_workorder_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_workorder_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_workorder_$parm"];
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

	// Field bom
	// Setup your default values for the popup filter below, e.g.
	// $seld_bom = array("val1", "val2");

	$GLOBALS["seld_bom"] = "";
	$GLOBALS["sel_bom"] =  $GLOBALS["seld_bom"];

	// Field flock
	// Setup your default values for the popup filter below, e.g.
	// $seld_flock = array("val1", "val2");

	$GLOBALS["seld_flock"] = "";
	$GLOBALS["sel_flock"] =  $GLOBALS["seld_flock"];

	// Field wo
	// Setup your default values for the popup filter below, e.g.
	// $seld_wo = array("val1", "val2");

	$GLOBALS["seld_wo"] = "";
	$GLOBALS["sel_wo"] =  $GLOBALS["seld_wo"];

	// Field iitem
	// Setup your default values for the popup filter below, e.g.
	// $seld_iitem = array("val1", "val2");

	$GLOBALS["seld_iitem"] = "";
	$GLOBALS["sel_iitem"] =  $GLOBALS["seld_iitem"];

	// Field oitem
	// Setup your default values for the popup filter below, e.g.
	// $seld_oitem = array("val1", "val2");

	$GLOBALS["seld_oitem"] = "";
	$GLOBALS["sel_oitem"] =  $GLOBALS["seld_oitem"];
}

// Check if filter applied
function CheckFilter() {

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check bom popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_bom"], $GLOBALS["sel_bom"]))
		return TRUE;

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;

	// Check wo popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_wo"], $GLOBALS["sel_wo"]))
		return TRUE;

	// Check iitem popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_iitem"], $GLOBALS["sel_iitem"]))
		return TRUE;

	// Check oitem popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_oitem"], $GLOBALS["sel_oitem"]))
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

	// Field bom
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_bom"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_bom"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Bom<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field flock
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_flock"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_flock"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Flock<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field wo
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_wo"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_wo"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Wo<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field iitem
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_iitem"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_iitem"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Iitem<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field oitem
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_oitem"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_oitem"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Oitem<br />";
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
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "breeder_woinputs.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_bom"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_bom"], "breeder_woinputs.bom", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_bom"], $GLOBALS["gb_bom"], $GLOBALS["gi_bom"], $GLOBALS["gq_bom"]);
	}
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "breeder_woinputs.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"], $GLOBALS["gb_flock"], $GLOBALS["gi_flock"], $GLOBALS["gq_flock"]);
	}
	if (is_array($GLOBALS["sel_wo"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_wo"], "breeder_woinputs.wo", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_wo"], $GLOBALS["gb_wo"], $GLOBALS["gi_wo"], $GLOBALS["gq_wo"]);
	}
	if (is_array($GLOBALS["sel_iitem"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_iitem"], "breeder_woinputs.iitem", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_iitem"]);
	}
	if (is_array($GLOBALS["sel_oitem"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_oitem"], "breeder_wooutputs.oitem", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_oitem"]);
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
			$_SESSION["sort_workorder_date"] = "";
			$_SESSION["sort_workorder_bom"] = "";
			$_SESSION["sort_workorder_flock"] = "";
			$_SESSION["sort_workorder_wo"] = "";
			$_SESSION["sort_workorder_iitem"] = "";
			$_SESSION["sort_workorder_iquantity"] = "";
			$_SESSION["sort_workorder_iunits"] = "";
			$_SESSION["sort_workorder_oitem"] = "";
			$_SESSION["sort_workorder_oquantity"] = "";
			$_SESSION["sort_workorder_ounits"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "breeder_woinputs.iitem ASC, breeder_wooutputs.oitem ASC";
		$_SESSION["sort_workorder_iitem"] = "ASC";
		$_SESSION["sort_workorder_oitem"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
