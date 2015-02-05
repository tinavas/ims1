 <?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <!--<style type="text/css">
        thead tr {
            position: absolute; 
            height: 30px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:30px; 
            overflow: scroll; 
        }
    </style>-->
<?php } ?> 
<?php include "reportheader.php";
include "config.php"; ?>

<?php
session_start();
$client = $_SESSION['client'];
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
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "breedconsumption", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "breedconsumption_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "breedconsumption_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "breedconsumption_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "breedconsumption_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "breedconsumption_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layer_consumption Inner Join ims_itemcodes On layer_consumption.itemcode = ims_itemcodes.code";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layer_consumption.flock, layer_consumption.wo, layer_consumption.age, layer_consumption.date2, layer_consumption.fmort, layer_consumption.fcull, layer_consumption.fweight, layer_consumption.eggwt, layer_consumption.tempmin, layer_consumption.tempmax, layer_consumption.water, layer_consumption.avgwt, layer_consumption.itemcode, layer_consumption.units, layer_consumption.quantity, ims_itemcodes.description, layer_consumption.reportedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "layer_consumption.flock ASC, layer_consumption.wo ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "layer_consumption.flock", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `flock` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(layer_consumption.fmort) AS SUM_fmort, SUM(layer_consumption.fcull) AS SUM_fcull, SUM(layer_consumption.fweight) AS SUM_fweight, SUM(layer_consumption.eggwt) AS SUM_eggwt, SUM(layer_consumption.tempmin) AS SUM_tempmin, SUM(layer_consumption.tempmax) AS SUM_tempmax, SUM(layer_consumption.water) AS SUM_water, SUM(layer_consumption.avgwt) AS SUM_avgwt, SUM(layer_consumption.quantity) AS SUM_quantity FROM " .$EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_flock = NULL; // Popup filter for flock
$af_wo = NULL; // Popup filter for wo
$af_age = NULL; // Popup filter for age
$af_date2 = array(); // Popup filter for date2
$af_date2[0][0] = "@@1";
$af_date2[0][1] = "Past";
$af_date2[0][2] = ewrpt_IsPast(); // Return sql part
$af_date2[1][0] = "@@2";
$af_date2[1][1] = "Future";
$af_date2[1][2] = ewrpt_IsFuture(); // Return sql part
$af_date2[2][0] = "@@3";
$af_date2[2][1] = "Last 30 days";
$af_date2[2][2] = ewrpt_IsLast30Days(); // Return sql part
$af_date2[3][0] = "@@4";
$af_date2[3][1] = "Last 14 days";
$af_date2[3][2] = ewrpt_IsLast14Days(); // Return sql part
$af_date2[4][0] = "@@5";
$af_date2[4][1] = "Last 7 days";
$af_date2[4][2] = ewrpt_IsLast7Days(); // Return sql part
$af_date2[5][0] = "@@6";
$af_date2[5][1] = "Next 7 days";
$af_date2[5][2] = ewrpt_IsNext7Days(); // Return sql part
$af_date2[6][0] = "@@7";
$af_date2[6][1] = "Next 14 days";
$af_date2[6][2] = ewrpt_IsNext14Days(); // Return sql part
$af_date2[7][0] = "@@8";
$af_date2[7][1] = "Next 30 days";
$af_date2[7][2] = ewrpt_IsNext30Days(); // Return sql part
$af_date2[8][0] = "@@9";
$af_date2[8][1] = "Yesterday";
$af_date2[8][2] = ewrpt_IsYesterday(); // Return sql part
$af_date2[9][0] = "@@10";
$af_date2[9][1] = "Today";
$af_date2[9][2] = ewrpt_IsToday(); // Return sql part
$af_date2[10][0] = "@@11";
$af_date2[10][1] = "Tomorrow";
$af_date2[10][2] = ewrpt_IsTomorrow(); // Return sql part
$af_date2[11][0] = "@@12";
$af_date2[11][1] = "Last month";
$af_date2[11][2] = ewrpt_IsLastMonth(); // Return sql part
$af_date2[12][0] = "@@13";
$af_date2[12][1] = "This month";
$af_date2[12][2] = ewrpt_IsThisMonth(); // Return sql part
$af_date2[13][0] = "@@14";
$af_date2[13][1] = "Next month";
$af_date2[13][2] = ewrpt_IsNextMonth(); // Return sql part
$af_date2[14][0] = "@@15";
$af_date2[14][1] = "Last two weeks";
$af_date2[14][2] = ewrpt_IsLast2Weeks(); // Return sql part
$af_date2[15][0] = "@@16";
$af_date2[15][1] = "Last week";
$af_date2[15][2] = ewrpt_IsLastWeek(); // Return sql part
$af_date2[16][0] = "@@17";
$af_date2[16][1] = "This week";
$af_date2[16][2] = ewrpt_IsThisWeek(); // Return sql part
$af_date2[17][0] = "@@18";
$af_date2[17][1] = "Next week";
$af_date2[17][2] = ewrpt_IsNextWeek(); // Return sql part
$af_date2[18][0] = "@@19";
$af_date2[18][1] = "Next two weeks";
$af_date2[18][2] = ewrpt_IsNext2Weeks(); // Return sql part
$af_date2[19][0] = "@@20";
$af_date2[19][1] = "Last year";
$af_date2[19][2] = ewrpt_IsLastYear(); // Return sql part
$af_date2[20][0] = "@@21";
$af_date2[20][1] = "This year";
$af_date2[20][2] = ewrpt_IsThisYear(); // Return sql part
$af_date2[21][0] = "@@22";
$af_date2[21][1] = "Next year";
$af_date2[21][2] = ewrpt_IsNextYear(); // Return sql part
$af_fmort = NULL; // Popup filter for fmort
$af_fcull = NULL; // Popup filter for fcull
$af_fweight = NULL; // Popup filter for fweight
$af_eggwt = NULL; // Popup filter for eggwt
$af_tempmin = NULL; // Popup filter for tempmin
$af_tempmax = NULL; // Popup filter for tempmax
$af_water = NULL; // Popup filter for water
$af_avgwt = NULL; // Popup filter for avgwt
$af_itemcode = NULL; // Popup filter for itemcode
$af_units = NULL; // Popup filter for units
$af_quantity = NULL; // Popup filter for quantity
$af_description = NULL; // Popup filter for description
$af_reportedby = NULL; // Popup filter for reportedby
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
$nDisplayGrps = "ALL"; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT layer_consumption.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "layer_consumption.flock";
$EW_REPORT_FIELD_WO_SQL_SELECT = "SELECT DISTINCT layer_consumption.wo FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_WO_SQL_ORDERBY = "layer_consumption.wo";
$EW_REPORT_FIELD_DATE2_SQL_SELECT = "SELECT DISTINCT layer_consumption.date2 FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE2_SQL_ORDERBY = "layer_consumption.date2";
?>
<?php

// Field variables
$x_flock = NULL;
$x_wo = NULL;
$x_age = NULL;
$x_date2 = NULL;
$x_fmort = NULL;
$x_fcull = NULL;
$x_fweight = NULL;
$x_eggwt = NULL;
$x_tempmin = NULL;
$x_tempmax = NULL;
$x_water = NULL;
$x_avgwt = NULL;
$x_itemcode = NULL;
$x_units = NULL;
$x_quantity = NULL;
$x_description = NULL;
$x_reportedby = NULL;

// Group variables
$o_flock = NULL; $g_flock = NULL; $dg_flock = NULL; $t_flock = NULL; $ft_flock = 200; $gf_flock = $ft_flock; $gb_flock = ""; $gi_flock = "0"; $gq_flock = ""; $rf_flock = NULL; $rt_flock = NULL;
$o_wo = NULL; $g_wo = NULL; $dg_wo = NULL; $t_wo = NULL; $ft_wo = 200; $gf_wo = $ft_wo; $gb_wo = ""; $gi_wo = "0"; $gq_wo = ""; $rf_wo = NULL; $rt_wo = NULL;

// Detail variables
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_date2 = NULL; $t_date2 = NULL; $ft_date2 = 133; $rf_date2 = NULL; $rt_date2 = NULL;
$o_fmort = NULL; $t_fmort = NULL; $ft_fmort = 5; $rf_fmort = NULL; $rt_fmort = NULL;
$o_fcull = NULL; $t_fcull = NULL; $ft_fcull = 5; $rf_fcull = NULL; $rt_fcull = NULL;
$o_fweight = NULL; $t_fweight = NULL; $ft_fweight = 5; $rf_fweight = NULL; $rt_fweight = NULL;
$o_eggwt = NULL; $t_eggwt = NULL; $ft_eggwt = 5; $rf_eggwt = NULL; $rt_eggwt = NULL;
$o_tempmin = NULL; $t_tempmin = NULL; $ft_tempmin = 5; $rf_tempmin = NULL; $rt_tempmin = NULL;
$o_tempmax = NULL; $t_tempmax = NULL; $ft_tempmax = 5; $rf_tempmax = NULL; $rt_tempmax = NULL;
$o_water = NULL; $t_water = NULL; $ft_water = 5; $rf_water = NULL; $rt_water = NULL;
$o_avgwt = NULL; $t_avgwt = NULL; $ft_avgwt = 5; $rf_avgwt = NULL; $rt_avgwt = NULL;
$o_itemcode = NULL; $t_itemcode = NULL; $ft_itemcode = 200; $rf_itemcode = NULL; $rt_itemcode = NULL;
$o_units = NULL; $t_units = NULL; $ft_units = 200; $rf_units = NULL; $rt_units = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
$o_reportedby = NULL; $t_reportedby = NULL; $ft_reportedby = 200; $rf_reportedby = NULL; $rt_reportedby = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 16;
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
$col = array(FALSE, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE, TRUE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_flock = "";
$seld_flock = "";
$val_flock = "";
$sel_wo = "";
$seld_wo = "";
$val_wo = "";
$sel_date2 = "";
$seld_date2 = "";
$val_date2 = "";

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
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("breedconsumption_flock", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_wo, $sel_wo, $ft_wo) ?>
ewrpt_CreatePopup("breedconsumption_wo", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date2, $sel_date2, $ft_date2) ?>
ewrpt_CreatePopup("breedconsumption_date2", [<?php echo $jsdata ?>]);
</script>
<div id="breedconsumption_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="breedconsumption_wo_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="breedconsumption_date2_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Flock Production Report</font></strong></td>
</tr>
</table>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="flocksmryproduction.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="flocksmryproduction.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="flocksmryproduction.php?export=word">Export to Word</a><br /><br />
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="flocksmryproduction.php?cmd=reset">Reset All Filters</a>
<?php } ?>
<?php } ?>

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
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="flocksmryproduction.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'breedconsumption_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age</td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'breedconsumption_date2', true, '<?php echo $rf_date2; ?>', '<?php echo $rt_date2; ?>');return false;" name="x_date2<?php echo $cnt[0][0]; ?>" id="x_date2<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<!--<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		O.Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Opening Birds">O.Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Mort
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Mortality">Mort</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cull
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cull</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		T.In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Transfer In">T.In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		T.Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Transfer Out">T.Out</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sales</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		C.Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Closing Birds">C.Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Qty<br />(Kgs)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed Consumed">Qty<br />(Kgs)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed / Bird<br />(Gms)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed / Bird<br />(Gms)</td>
			</tr></table>
		</td>
<?php } ?>-->
<?php
  
  $query467 = "SELECT * FROM ims_itemcodes where cat like 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
  $result467 = mysql_query($query467,$conn1); 
  while($row467 = mysql_fetch_assoc($result467))
  { 
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		<?php echo $row467['code'] . "<br />" . $row467['description']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php echo $row467['code'] . "<br />" . $row467['description']; ?></td>
			</tr></table>
		</td>
<?php } ?>

<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		T.Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Total Eggs">T.Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Production %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Production %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Remarks
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Egg Weight">Remarks</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_flock, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_flock, EW_REPORT_DATATYPE_STRING, $gb_flock, $gi_flock, $gq_flock);
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
		$dg_flock = $x_flock;
		if ((is_null($x_flock) && is_null($o_flock)) ||
			(($x_flock <> "" && $o_flock == $dg_flock) && !ChkLvlBreak(1))) {
			$dg_flock = "&nbsp;";
		} elseif (is_null($x_flock)) {
			$dg_flock = EW_REPORT_NULL_LABEL;
		} elseif ($x_flock == "") {
			$dg_flock = EW_REPORT_EMPTY_LABEL;
		}
		$dg_wo = $x_wo;
		if ((is_null($x_wo) && is_null($o_wo)) ||
			(($x_wo <> "" && $o_wo == $dg_wo) && !ChkLvlBreak(2))) {
			$dg_wo = "&nbsp;";
		} elseif (is_null($x_wo)) {
			$dg_wo = EW_REPORT_NULL_LABEL;
		} elseif ($x_wo == "") {
			$dg_wo = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
<?php
$newflock = $x_flock;
if($newflock <> $oldflock) 
{ 
$xbirds = 0; $xsales = 0; $xclose = 0; 


$query467 = "SELECT * FROM ims_itemcodes where cat like '%Layer Eggs%' and client = '$client'  ORDER BY code ASC ";
$result467 = mysql_query($query467,$conn1); 
while($row467 = mysql_fetch_assoc($result467))
{ 
 $xeggs[$row467['code']] = 0;
}

$query = "select date,narration from layer_narration where flockcode = '$newflock'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$narration[$res['date']] = $res['narration'];
$oldflock = $newflock; 
} 
?>
		<td class="ewRptGrpField1">
		<?php $t_flock = $x_flock; $x_flock = $dg_flock; ?>
<?php echo ewrpt_ViewValue($x_flock); ?>
		<?php $x_flock = $t_flock; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php               
              $age = $x_age;
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              $nrYearsPassed = floor($nrSeconds / 31536000); 
              echo ewrpt_ViewValue($nrWeeksPassed . "." . $nrDaysPassed); 
?>
</td>
		<td <?php echo $sItemRowClass; ?>>
<?php if(date("d.m.Y",strtotime($x_date2)) <> "01.01.1970") echo ewrpt_ViewValue(date($datephp,strtotime($x_date2))); else echo ewrpt_ViewValue(); ?>
</td>

<?php

///////////// Opening Birds ///////////////////

             $fopening = 0;
             $q = "select femaleopening from layer_flock where flockcode = '$x_flock' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$x_flock' and client = '$client'  and date2 < '$x_date2' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }

        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$x_flock' and client = '$client'  and date < '$x_date2' and code in (select distinct(code) from ims_itemcodes where cat = 'Layer Birds' and client = '$client')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where warehouse = '$x_flock' and client = '$client'  and date < '$x_date2' and code in (select distinct(code) from ims_itemcodes where cat = 'Layer Birds' and client = '$client')"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpur = $qr['quantity'];
               }
             }
             else
             {
                $tpur = 0;
             } 
			 
             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale + $tpur;
			// echo $fopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$tsale."/".$tpur;
?>


<?php

///////////// Transfer In ////////////////
              
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
             if($ttransfer == "") { $ttransfer = 0; }
?>
<?php
  $totaleggs = 0;
  
  $query467 = "SELECT * FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
  $result467 = mysql_query($query467,$conn1); 
  while($row467 = mysql_fetch_assoc($result467))
  { 

            $q1 = "select sum(quantity) as 'quantity' from layer_production where itemcode = '$row467[code]' and client = '$client'  and flock = '$x_flock' and date1 = '$x_date2' group by flock order by flock"; 
  		$qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1))
            {
		  while($qr1 = mysql_fetch_assoc($qrs1))
		  {
                   $qty = $qr1['quantity'];
              }
            }
            else
            {
                   $qty = 0; 
            }
            $xeggs[$row467['code']] = $xeggs[$row467['code']] + $qty; 
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $qty; $totaleggs = $totaleggs + $qty; ?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $totaleggs; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo round(($totaleggs/$remaining) * 100,2); ?>
</td>
	<td<?php echo $sItemRowClass; ?>>
<?php 
echo ewrpt_ViewValue($narration[$x_date2]) ?>
</td>


	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
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
?>
	<tr>
		<td colspan="25" class="ewRptGrpSummary1">Summary for Flock: <?php $t_flock = $x_flock; $x_flock = $o_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
<?php $x_flock = $t_flock; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="2" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
<?php
  $ieggs = 0;
  $query467 = "SELECT * FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
  $result467 = mysql_query($query467,$conn1); 
  while($row467 = mysql_fetch_assoc($result467))
  { 

?>
		<td class="ewRptGrpSummary1"><?php echo $xeggs[$row467['code']]; $ieggs = $ieggs + $xeggs[$row467['code']]; ?></td>
<?php } ?>
		<td class="ewRptGrpSummary1"><?php echo $ieggs; ?></td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_flock = $x_flock; // Save old group value
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
		$grandsmry[3] = $rsagg->fields("SUM_fmort");
		$grandsmry[4] = $rsagg->fields("SUM_fcull");
		$grandsmry[5] = $rsagg->fields("SUM_fweight");
		$grandsmry[6] = $rsagg->fields("SUM_eggwt");
		$grandsmry[7] = $rsagg->fields("SUM_tempmin");
		$grandsmry[8] = $rsagg->fields("SUM_tempmax");
		$grandsmry[9] = $rsagg->fields("SUM_water");
		$grandsmry[10] = $rsagg->fields("SUM_avgwt");
		$grandsmry[13] = $rsagg->fields("SUM_quantity");
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
	<!-- tr><td colspan="17"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="17">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="2" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_fmort = $x_fmort; ?>
		<?php $x_fmort = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_fmort) ?>
		<?php $x_fmort = $t_fmort; ?>
		</td>
		<td>
		<?php $t_fcull = $x_fcull; ?>
		<?php $x_fcull = $grandsmry[4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_fcull) ?>
		<?php $x_fcull = $t_fcull; ?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_water = $x_water; ?>
		<?php $x_water = $grandsmry[9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_water) ?>
		<?php $x_water = $t_water; ?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $grandsmry[13]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr class="ewRptGrandSummary"  style="display:none">
		<td colspan="2" class="ewRptGrpAggregate">AVERAGE</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_fweight = $x_fweight; ?>
		<?php if ($rstotcnt > 0) $x_fweight = $grandsmry[5]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_fweight) ?>
		<?php $x_fweight = $t_fweight; ?>
		</td>
		<td>
		<?php $t_eggwt = $x_eggwt; ?>
		<?php if ($rstotcnt > 0) $x_eggwt = $grandsmry[6]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_eggwt) ?>
		<?php $x_eggwt = $t_eggwt; ?>
		</td>
		<td>
		<?php $t_tempmin = $x_tempmin; ?>
		<?php if ($rstotcnt > 0) $x_tempmin = $grandsmry[7]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_tempmin) ?>
		<?php $x_tempmin = $t_tempmin; ?>
		</td>
		<td>
		<?php $t_tempmax = $x_tempmax; ?>
		<?php if ($rstotcnt > 0) $x_tempmax = $grandsmry[8]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_tempmax) ?>
		<?php $x_tempmax = $t_tempmax; ?>
		</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_avgwt = $x_avgwt; ?>
		<?php if ($rstotcnt > 0) $x_avgwt = $grandsmry[10]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_avgwt) ?>
		<?php $x_avgwt = $t_avgwt; ?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="flocksmryproduction.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="flocksmryproduction.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_flock"]) && !is_null($GLOBALS["o_flock"])) ||
				(!is_null($GLOBALS["x_flock"]) && is_null($GLOBALS["o_flock"])) ||
				($GLOBALS["x_flock"] <> $GLOBALS["o_flock"]);
		case 2:
			return (is_null($GLOBALS["x_wo"]) && !is_null($GLOBALS["o_wo"])) ||
				(!is_null($GLOBALS["x_wo"]) && is_null($GLOBALS["o_wo"])) ||
				($GLOBALS["x_wo"] <> $GLOBALS["o_wo"]) || ChkLvlBreak(1); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_flock"] = "";
	if ($lvl <= 2) $GLOBALS["o_wo"] = "";

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
		$GLOBALS['x_flock'] = "";
	} else {
		$GLOBALS['x_flock'] = $rsgrp->fields('flock');
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
		$GLOBALS['x_wo'] = $rs->fields('wo');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_date2'] = $rs->fields('date2');
		$GLOBALS['x_fmort'] = $rs->fields('fmort');
		$GLOBALS['x_fcull'] = $rs->fields('fcull');
		$GLOBALS['x_fweight'] = $rs->fields('fweight');
		$GLOBALS['x_eggwt'] = $rs->fields('eggwt');
		$GLOBALS['x_tempmin'] = $rs->fields('tempmin');
		$GLOBALS['x_tempmax'] = $rs->fields('tempmax');
		$GLOBALS['x_water'] = $rs->fields('water');
		$GLOBALS['x_avgwt'] = $rs->fields('avgwt');
		$GLOBALS['x_itemcode'] = $rs->fields('itemcode');
		$GLOBALS['x_units'] = $rs->fields('units');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_reportedby'] = $rs->fields('reportedby');
		$val[1] = $GLOBALS['x_age'];
		$val[2] = $GLOBALS['x_date2'];
		$val[3] = $GLOBALS['x_fmort'];
		$val[4] = $GLOBALS['x_fcull'];
		$val[5] = $GLOBALS['x_fweight'];
		$val[6] = $GLOBALS['x_eggwt'];
		$val[7] = $GLOBALS['x_tempmin'];
		$val[8] = $GLOBALS['x_tempmax'];
		$val[9] = $GLOBALS['x_water'];
		$val[10] = $GLOBALS['x_avgwt'];
		$val[11] = $GLOBALS['x_itemcode'];
		$val[12] = $GLOBALS['x_units'];
		$val[13] = $GLOBALS['x_quantity'];
		$val[14] = $GLOBALS['x_description'];
		$val[15] = $GLOBALS['x_reportedby'];
	} else {
		$GLOBALS['x_wo'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_date2'] = "";
		$GLOBALS['x_fmort'] = "";
		$GLOBALS['x_fcull'] = "";
		$GLOBALS['x_fweight'] = "";
		$GLOBALS['x_eggwt'] = "";
		$GLOBALS['x_tempmin'] = "";
		$GLOBALS['x_tempmax'] = "";
		$GLOBALS['x_water'] = "";
		$GLOBALS['x_avgwt'] = "";
		$GLOBALS['x_itemcode'] = "";
		$GLOBALS['x_units'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_reportedby'] = "";
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

	// Build distinct values for date2
	ewrpt_SetupDistinctValuesFromFilter($GLOBALS["val_date2"], $GLOBALS["af_date2"]); // Set up popup filter
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DATE2_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DATE2_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_date2 = $rswrk->fields[0];
		if (is_null($x_date2)) {
			$bNullValue = TRUE;
		} elseif ($x_date2 == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_date2 = ewrpt_FormatDateTime($x_date2,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_date2"], $x_date2, $t_date2, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date2"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date2"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('flock');
			ClearSessionSelection('wo');
			ClearSessionSelection('date2');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Flock selected values

	if (is_array(@$_SESSION["sel_breedconsumption_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_breedconsumption_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
	}

	// Get Wo selected values
	if (is_array(@$_SESSION["sel_breedconsumption_wo"])) {
		LoadSelectionFromSession('wo');
	} elseif (@$_SESSION["sel_breedconsumption_wo"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_wo"] = "";
	}

	// Get Date 2 selected values
	if (is_array(@$_SESSION["sel_breedconsumption_date2"])) {
		LoadSelectionFromSession('date2');
	} elseif (@$_SESSION["sel_breedconsumption_date2"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date2"] = "";
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
	$_SESSION["sel_breedconsumption_$parm"] = "";
	$_SESSION["rf_breedconsumption_$parm"] = "";
	$_SESSION["rt_breedconsumption_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_breedconsumption_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_breedconsumption_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_breedconsumption_$parm"];
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

	// Field date2
	// Setup your default values for the popup filter below, e.g.
	// $seld_date2 = array("val1", "val2");

	$GLOBALS["seld_date2"] = "";
	$GLOBALS["sel_date2"] =  $GLOBALS["seld_date2"];
}

// Check if filter applied
function CheckFilter() {

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;

	// Check wo popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_wo"], $GLOBALS["sel_wo"]))
		return TRUE;

	// Check date2 popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date2"], $GLOBALS["sel_date2"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

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

	// Field date2
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_date2"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_date2"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Date 2<br />";
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
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "layer_consumption.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"], $GLOBALS["gb_flock"], $GLOBALS["gi_flock"], $GLOBALS["gq_flock"]);
	}
	if (is_array($GLOBALS["sel_wo"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_wo"], "layer_consumption.wo", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_wo"], $GLOBALS["gb_wo"], $GLOBALS["gi_wo"], $GLOBALS["gq_wo"]);
	}
	if (is_array($GLOBALS["sel_date2"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date2"], "layer_consumption.date2", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date2"]);
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
			$_SESSION["sort_breedconsumption_flock"] = "";
			$_SESSION["sort_breedconsumption_wo"] = "";
			$_SESSION["sort_breedconsumption_age"] = "";
			$_SESSION["sort_breedconsumption_date2"] = "";
			$_SESSION["sort_breedconsumption_fmort"] = "";
			$_SESSION["sort_breedconsumption_fcull"] = "";
			$_SESSION["sort_breedconsumption_fweight"] = "";
			$_SESSION["sort_breedconsumption_eggwt"] = "";
			$_SESSION["sort_breedconsumption_tempmin"] = "";
			$_SESSION["sort_breedconsumption_tempmax"] = "";
			$_SESSION["sort_breedconsumption_water"] = "";
			$_SESSION["sort_breedconsumption_avgwt"] = "";
			$_SESSION["sort_breedconsumption_itemcode"] = "";
			$_SESSION["sort_breedconsumption_units"] = "";
			$_SESSION["sort_breedconsumption_quantity"] = "";
			$_SESSION["sort_breedconsumption_description"] = "";
			$_SESSION["sort_breedconsumption_reportedby"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "layer_consumption.age ASC";
		$_SESSION["sort_breedconsumption_age"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
