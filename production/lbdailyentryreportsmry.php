<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  
<?php } ?>
<?php
session_start();
ob_start();
include "config.php";
include "reportheader.php";
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));

$i = $ffop = $fmop = $ffcl = $fmcl = $ffmort = $fmmort = $ffcull = $fmcull = $few = $fwater = $ffeed = $mfeed = $ftableeggs = $fhatcheggs = $ftotaleggs = $fhep = $fshep = $fpp = $fspp = 0;
$s = $sfop = $sprodper = $smop = $sfcl = $smcl = $sfmort = $smmort = $sfcull = $smcull = $sew = $swater = $sffeed = $smfeed = $stableeggs = $shatcheggs = $stotaleggs = $shep = $sshep = $spp = $sspp = 0;
$fl = $flfop = $flprodper = $flmop = $flfcl = $flmcl = $flfmort = $flmmort = $flfcull = $flmcull = $flew = $flwater = $flffeed = $flmfeed = $fltableeggs = $flhatcheggs = $fltotaleggs = $flhep = $flshep = $flpp = $flspp = 0;
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
define("EW_REPORT_TABLE_VAR", "dailyentryreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "dailyentryreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "dailyentryreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "dailyentryreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "dailyentryreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "dailyentryreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layerbreeder_consumption Inner Join layerbreeder_flock On layerbreeder_consumption.flock = layerbreeder_flock.flockcode";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layerbreeder_flock.farmcode, layerbreeder_flock.shedcode, layerbreeder_consumption.flock, layerbreeder_consumption.date2, layerbreeder_consumption.age, layerbreeder_consumption.fmort, layerbreeder_consumption.mmort, layerbreeder_consumption.fcull, layerbreeder_consumption.mcull, layerbreeder_consumption.fweight, layerbreeder_consumption.mweight, layerbreeder_consumption.eggwt, layerbreeder_consumption.water, layerbreeder_consumption.avgwt, layerbreeder_consumption.reportedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "'$fromdate' <= layerbreeder_consumption.date2 and layerbreeder_consumption.date2 <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "layerbreeder_flock.farmcode, layerbreeder_flock.shedcode, layerbreeder_consumption.flock, layerbreeder_consumption.date2, layerbreeder_consumption.age, layerbreeder_consumption.fmort, layerbreeder_consumption.mmort, layerbreeder_consumption.fcull, layerbreeder_consumption.mcull, layerbreeder_consumption.fweight, layerbreeder_consumption.mweight, layerbreeder_consumption.eggwt, layerbreeder_consumption.water, layerbreeder_consumption.avgwt, layerbreeder_consumption.reportedby";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "layerbreeder_flock.farmcode ASC, layerbreeder_flock.shedcode ASC, layerbreeder_consumption.flock ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "layerbreeder_flock.farmcode", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `farmcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(layerbreeder_consumption.fmort) AS SUM_fmort, SUM(layerbreeder_consumption.mmort) AS SUM_mmort, SUM(layerbreeder_consumption.fcull) AS SUM_fcull, SUM(layerbreeder_consumption.mcull) AS SUM_mcull, SUM(layerbreeder_consumption.water) AS SUM_water FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_farmcode = NULL; // Popup filter for farmcode
$af_shedcode = NULL; // Popup filter for shedcode
$af_flock = NULL; // Popup filter for flock
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
$af_age = NULL; // Popup filter for age
$af_fmort = NULL; // Popup filter for fmort
$af_mmort = NULL; // Popup filter for mmort
$af_fcull = NULL; // Popup filter for fcull
$af_mcull = NULL; // Popup filter for mcull
$af_fweight = NULL; // Popup filter for fweight
$af_mweight = NULL; // Popup filter for mweight
$af_eggwt = NULL; // Popup filter for eggwt
$af_water = NULL; // Popup filter for water
$af_avgwt = NULL; // Popup filter for avgwt
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
$EW_REPORT_FIELD_FARMCODE_SQL_SELECT = "SELECT DISTINCT layerbreeder_flock.farmcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FARMCODE_SQL_ORDERBY = "layerbreeder_flock.farmcode";
$EW_REPORT_FIELD_SHEDCODE_SQL_SELECT = "SELECT DISTINCT layerbreeder_flock.shedcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY = "layerbreeder_flock.shedcode";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT layerbreeder_consumption.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "layerbreeder_consumption.flock";
$EW_REPORT_FIELD_DATE2_SQL_SELECT = "SELECT DISTINCT layerbreeder_consumption.date2 FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE2_SQL_ORDERBY = "layerbreeder_consumption.date2";
$EW_REPORT_FIELD_AGE_SQL_SELECT = "SELECT DISTINCT layerbreeder_consumption.age FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_AGE_SQL_ORDERBY = "layerbreeder_consumption.age";
?>
<?php

// Field variables
$x_farmcode = NULL;
$x_shedcode = NULL;
$x_flock = NULL;
$x_date2 = NULL;
$x_age = NULL;
$x_fmort = NULL;
$x_mmort = NULL;
$x_fcull = NULL;
$x_mcull = NULL;
$x_fweight = NULL;
$x_mweight = NULL;
$x_eggwt = NULL;
$x_water = NULL;
$x_avgwt = NULL;
$x_reportedby = NULL;

// Group variables
$o_farmcode = NULL; $g_farmcode = NULL; $dg_farmcode = NULL; $t_farmcode = NULL; $ft_farmcode = 200; $gf_farmcode = $ft_farmcode; $gb_farmcode = ""; $gi_farmcode = "0"; $gq_farmcode = ""; $rf_farmcode = NULL; $rt_farmcode = NULL;
$o_shedcode = NULL; $g_shedcode = NULL; $dg_shedcode = NULL; $t_shedcode = NULL; $ft_shedcode = 200; $gf_shedcode = $ft_shedcode; $gb_shedcode = ""; $gi_shedcode = "0"; $gq_shedcode = ""; $rf_shedcode = NULL; $rt_shedcode = NULL;
$o_flock = NULL; $g_flock = NULL; $dg_flock = NULL; $t_flock = NULL; $ft_flock = 200; $gf_flock = $ft_flock; $gb_flock = ""; $gi_flock = "0"; $gq_flock = ""; $rf_flock = NULL; $rt_flock = NULL;

// Detail variables
$o_date2 = NULL; $t_date2 = NULL; $ft_date2 = 133; $rf_date2 = NULL; $rt_date2 = NULL;
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_fmort = NULL; $t_fmort = NULL; $ft_fmort = 5; $rf_fmort = NULL; $rt_fmort = NULL;
$o_mmort = NULL; $t_mmort = NULL; $ft_mmort = 5; $rf_mmort = NULL; $rt_mmort = NULL;
$o_fcull = NULL; $t_fcull = NULL; $ft_fcull = 5; $rf_fcull = NULL; $rt_fcull = NULL;
$o_mcull = NULL; $t_mcull = NULL; $ft_mcull = 5; $rf_mcull = NULL; $rt_mcull = NULL;
$o_fweight = NULL; $t_fweight = NULL; $ft_fweight = 5; $rf_fweight = NULL; $rt_fweight = NULL;
$o_mweight = NULL; $t_mweight = NULL; $ft_mweight = 5; $rf_mweight = NULL; $rt_mweight = NULL;
$o_eggwt = NULL; $t_eggwt = NULL; $ft_eggwt = 5; $rf_eggwt = NULL; $rt_eggwt = NULL;
$o_water = NULL; $t_water = NULL; $ft_water = 5; $rf_water = NULL; $rt_water = NULL;
$o_avgwt = NULL; $t_avgwt = NULL; $ft_avgwt = 5; $rf_avgwt = NULL; $rt_avgwt = NULL;
$o_reportedby = NULL; $t_reportedby = NULL; $ft_reportedby = 200; $rf_reportedby = NULL; $rt_reportedby = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 13;
$nGrps = 4;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_farmcode = "";
$seld_farmcode = "";
$val_farmcode = "";
$sel_shedcode = "";
$seld_shedcode = "";
$val_shedcode = "";
$sel_flock = "";
$seld_flock = "";
$val_flock = "";
$sel_date2 = "";
$seld_date2 = "";
$val_date2 = "";
$sel_age = "";
$seld_age = "";
$val_age = "";

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
<?php $jsdata = ewrpt_GetJsData($val_farmcode, $sel_farmcode, $ft_farmcode) ?>
ewrpt_CreatePopup("dailyentryreport_farmcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shedcode, $sel_shedcode, $ft_shedcode) ?>
ewrpt_CreatePopup("dailyentryreport_shedcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("dailyentryreport_flock", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date2, $sel_date2, $ft_date2) ?>
ewrpt_CreatePopup("dailyentryreport_date2", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_age, $sel_age, $ft_age) ?>
ewrpt_CreatePopup("dailyentryreport_age", [<?php echo $jsdata ?>]);
</script>
<div id="dailyentryreport_farmcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="dailyentryreport_shedcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="dailyentryreport_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="dailyentryreport_date2_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="dailyentryreport_age_Popup" class="ewPopup">
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
<br />
<table  border="0">
<tr>
<td  style="padding-left:300px"><strong><font color="#3e3276">Daily Entry Report From <?php if($_GET['fromdate']) { echo $_GET['fromdate']; } else { echo date("d.m.Y"); }  ?> To <?php if($_GET['todate']) { echo $_GET['todate']; } else { echo date("d.m.Y"); }  ?></font></strong></td>
</tr>
</table>
<br/>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="lbdailyentryreportsmry.php?export=html&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="lbdailyentryreportsmry.php?export=excel&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Excel</a>
&nbsp;&nbsp;<a href="lbdailyentryreportsmry.php?export=word&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="lbdailyentryreportsmry.php?cmd=reset&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Reset All Filters</a>
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
<form action="lbdailyentryreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr <?php if (@$sExport != "") { ?> style="display:none" <?php } ?>>
	<td>
<span class="phpreportmaker">
From Date&nbsp;
<input type="text" class="datepicker" id="fromdate" name="fromdate" value="<?php if($_GET['fromdate']) { echo $_GET['fromdate']; } else { echo date("d.m.Y"); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;

To Date&nbsp;
<input type="text" class="datepicker" id="todate" name="todate" value="<?php if($_GET['todate']) { echo $_GET['todate']; } else { echo date("d.m.Y"); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;
</span>

<?php if ($nTotalGrps > 0) { ?>
		<td nowrap style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap style="display:none"><span class="phpreportmaker">Groups Per Page&nbsp;
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
<tr height="10px"><td>&nbsp;</td></tr>

	<tr>
	<td >
	<b>F.Op. :</b> Female Opening&nbsp;&nbsp;&nbsp;<b>M.Op. :</b> Male Opening&nbsp;&nbsp;&nbsp;<b>F.Mort. :</b> Female Mortality&nbsp;&nbsp;&nbsp;<b>M.Mort. :</b> Male Mortality&nbsp;&nbsp;&nbsp;<b>F.Cull. :</b> Female Culled&nbsp;&nbsp;&nbsp;<b>M.Cull. :</b> Male Culled&nbsp;&nbsp;&nbsp;<b>F.Cl. :</b> Female Closing&nbsp;&nbsp;&nbsp;<b>M.Cl. :</b> Male Closing&nbsp;&nbsp;&nbsp;<b>FBW :</b> Female Body Weight&nbsp;&nbsp;&nbsp;<b>Std.FBW :</b> Standard Female Body Weight&nbsp;&nbsp;&nbsp;<b>MBW :</b> Male Body Weight&nbsp;&nbsp;&nbsp;<b>Std.MBW :</b> Standard Male Body Weight&nbsp;&nbsp;&nbsp;<b>Egg Wt. :</b> Egg Weight&nbsp;&nbsp;&nbsp;<b>Std.EW :</b> Standard Egg Weight&nbsp;&nbsp;&nbsp;<b>HE. % :</b> Hatch Eggs %&nbsp;&nbsp;&nbsp;<b>Std. HE. % :</b> Standard Hatch Eggs %&nbsp;&nbsp;&nbsp;<b>Prod. % :</b> Production %&nbsp;&nbsp;&nbsp;<b>Std. Prod. % :</b> Standard Production %
	</td>
	</tr>
<tr height="10px"><td>&nbsp;</td></tr>
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
	//if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Farm
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farm</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Shed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shed</td>
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
		<td valign="bottom" class="ewTableHeader" title="Female Opening">
		F.Op.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Opening">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Op.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Opening">
		M.Op.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Opening">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Op.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Mortality">
		F.Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Mortality">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Mort</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Mortality">
		M.Mort
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Mortality">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Mort</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Culled">
		F.Cull
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Culled">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Cull</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Culled">
		M.Cull
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Culled">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Cull</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Closing">
		F.Cl.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Closing">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Cl.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Closing">
		M.Cl.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Closing">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Cl.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Body Weight">
		FBW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>FBW</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Female Body Weight">
		Std.FBW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Female Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.FBW</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Body Weight">
		MBW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>MBW</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Male Body Weight">
		Std.MBW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Male Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.MBW</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Egg Weight">
		Egg Wt.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Egg Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Egg Wt.</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Egg Weight">
		Std.EW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Egg Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.EW</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Feed <br />(Kgs)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Feed <br />(Kgs)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Feed/Bird <br />(Gms)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Feed/Bird <br />(Gms)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std. Female Feed/Bird <br />(Gms)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Female Feed/Bird <br />(Gms)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Feed <br />(Kgs)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Feed <br />(Kgs)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Feed/Bird <br />(Gms)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Feed/Bird <br />(Gms)</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std. Male Feed/Bird <br />(Gms)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Male Feed/Bird <br />(Gms)</td>
			</tr></table>
		</td>
<?php } ?>
<?php 

$query = "SELECT * FROM ims_itemcodes where cat = 'Layer Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn1); 
             while($row1 = mysql_fetch_assoc($result))
             { 
        ?>
        <?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="<?php echo $row1['description']; ?>">
		<?php echo $row1['code']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="<?php echo $row1['description']; ?>"><tr>
			<td><?php echo $row1['code']; ?></td>
			</tr></table>
		</td>
<?php } ?>
        <?php } ?>

        <?php
		$m=0;
             $query = "SELECT * FROM ims_itemcodes where cat = 'Layer Breeder Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn1); 
             while($row1 = mysql_fetch_assoc($result))
             { $m=$m+1; $total[$m]=0;
        ?>
       <?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="<?php echo $row1['description']; ?>">
		<?php echo $row1['code']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="<?php echo $row1['description']; ?>"><tr>
			<td><?php echo $row1['code']; ?></td>
			</tr></table>
		</td>
<?php } ?>
        <?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Hatch Eggs Percentage">
		HE. %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>HE. %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Hatch Eggs Percentage">
		Std. HE. %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. HE. %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Production Percentage">
		Prod. %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Prod. %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Production Percentage">
		Std. Prod. %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Prod. %</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	//}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_farmcode, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_farmcode, EW_REPORT_DATATYPE_STRING, $gb_farmcode, $gi_farmcode, $gq_farmcode);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	//while ($rs && !$rs->EOF) { // Loop detail records
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$dg_farmcode = $x_farmcode;
		if ((is_null($x_farmcode) && is_null($o_farmcode)) ||
			(($x_farmcode <> "" && $o_farmcode == $dg_farmcode) && !ChkLvlBreak(1))) {
			$dg_farmcode = "&nbsp;";
		} elseif (is_null($x_farmcode)) {
			$dg_farmcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_farmcode == "") {
			$dg_farmcode = EW_REPORT_EMPTY_LABEL;
		}
		$dg_shedcode = $x_shedcode;
		if ((is_null($x_shedcode) && is_null($o_shedcode)) ||
			(($x_shedcode <> "" && $o_shedcode == $dg_shedcode) && !ChkLvlBreak(2))) {
			$dg_shedcode = "&nbsp;";
		} elseif (is_null($x_shedcode)) {
			$dg_shedcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_shedcode == "") {
			$dg_shedcode = EW_REPORT_EMPTY_LABEL;
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
?>
<?php
$i=0;
$fl = $flfop = $flmop = $flprodper = $flfcl = $flmcl = $flfmort = $flmmort = $flfcull = $flmcull = $flew = $flwater = $flffeed = $flmfeed = $fltableeggs = $flhatcheggs = $fltotaleggs = 0;
$query = "select t1.farmcode,t1.shedcode,t2.flock,t2.date2,t2.age,t2.fmort,t2.mmort,t2.fcull,t2.mcull,t2.fweight,t2.mweight,t2.eggwt,t2.water,t2.avgwt,t2.reportedby from layerbreeder_flock t1,layerbreeder_consumption t2 where t2.flock = t1.flockcode and date2 between '$fromdate' and '$todate' group by t1.farmcode,t1.shedcode,t2.flock,t2.date2,t2.age,t2.fmort,t2.mmort,t2.fcull,t2.mcull,t2.fweight,t2.mweight,t2.eggwt,t2.water,t2.avgwt,t2.reportedby  order by farmcode,shedcode,flockcode,date2";
$result = mysql_query($query,$conn1) or die(mysql_error());
$daycount=mysql_num_rows($result);
while($rows = mysql_fetch_assoc($result))
{
 $x_flock = $rows['flock'];
 $x_age = $rows['age'];
 $x_farmcode = $rows['farmcode'];
 $x_shedcode = $rows['shedcode'];
 $x_date2 = $rows['date2'];
 $x_fmort = $rows['fmort'];
 $x_mmort = $rows['mmort'];
 $x_fcull = $rows['fcull'];
 $x_mcull = $rows['mcull'];
 $x_fweight = $rows['fweight'];
 $x_mweight = $rows['mweight'];
 $x_eggwt = $rows['eggwt'];
 $x_water = $rows['water'];
 $x_avgwt = $rows['avgwt'];
 $x_reportedby = $rows['reportedby'];	
 
			  $nrSeconds = $x_age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              $nrYearsPassed = floor($nrSeconds / 31536000); 
 if($nrWeeksPassed >= 66)
 {
  $nrWeeksPassed1 = 66;
 }
 else
 {
  $nrWeeksPassed1 = $nrWeeksPassed;
 }			
       $qbr = "select breed from layerbreeder_flock where flockcode = '$x_flock'"; 
  		$qrsbr = mysql_query($qbr,$conn1) or die(mysql_error());
		while($qrbr = mysql_fetch_assoc($qrsbr))
		{
		$flkbreed = $qrbr['breed'];
		}
			if($flkbreed != "")
			{
			$q = "select * from layerbreeder_standards where Age = '$nrWeeksPassed' and breed = '$flkbreed'";
			}
			else
			{
			$q = "select * from layerbreeder_standards where Age = '$nrWeeksPassed1'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				 $sfbw = $qr['fweight'];
				 $smbw = $qr['mweight'];
				$spp = $qr['productionper'];
				$shep = $qr['heggper'];
				$sew = $qr['Averageeggweight'];
			}
			
			if($flkbreed != "")
			{
			$q = "select * from layerbreeder_standards where age = '$nrWeeksPassed1'  and breed = '$flkbreed'";
			}
			else
			{
			$q = "select * from layerbreeder_standards where age = '$nrWeeksPassed1'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$sfbw = $qr['fweight'];
				$smbw = $qr['mweight'];
			}


 if($nrWeeksPassed >= 66)
 {
  $nrWeeksPassed1 = 66;
 }
 else
 {
  $nrWeeksPassed1 = $nrWeeksPassed;
 }

 if($flkbreed != "")
 {
  $getstd = "SELECT * FROM layerbreeder_standards WHERE age = '$nrWeeksPassed'  and breed = '$flkbreed'";
 }
 else
 {
 $getstd = "SELECT * FROM layerbreeder_standards WHERE age = '$nrWeeksPassed1'";
 }
 $resultstd = mysql_query($getstd,$conn1);
 while($rowstd = mysql_fetch_assoc($resultstd))
 {
  $stdffeed = $rowstd['ffeed'];
  $stdmfeed = $rowstd['mfeed'];
  $hstd= $rowstd['heggper'];
  $pstd= $rowstd['productionper'];
 }


$femalefeed = 0;
//$q1 = "select code from ims_itemcodes where cat = 'LB Female Feed' order by code";
//$q1rs = mysql_query($q1,$conn1) or die(mysql_error());
//while($q1r = mysql_fetch_assoc($q1rs))
//{
$q = "select ffeed as quantity from layerbreeder_consumption where flock = '$x_flock' and date2 = '$x_date2'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$femalefeed = $qr['quantity'];
//}
if($femalefeed == "")
$femalefeed = 0;
$malefeed = 0;
//$q1 = "select code from ims_itemcodes where cat = 'LB Male Feed' order by code";
//$q1rs = mysql_query($q1,$conn1) or die(mysql_error());
//while($q1r = mysql_fetch_assoc($q1rs))
//{
$q = "select mfeed as quantity from layerbreeder_consumption where flock = '$x_flock' and date2 = '$x_date2'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$malefeed = $qr['quantity'];
//}

if($malefeed == "")
$malefeed = 0;

$tableeggs = 0;
$q = "select sum(quantity) as quantity from layerbreeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemdesc <> 'Layer Hatch Eggs'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tableeggs = $qr['quantity'];
if($tableeggs == "")
$tableeggs = 0;

$hatcheggs = 0;
$q = "select sum(quantity) as quantity from layerbreeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemdesc = 'Layer Hatch Eggs'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$hatcheggs = $qr['quantity'];
if($hatcheggs == "")
$hatcheggs = 0;

$totaleggs = $tableeggs + $hatcheggs;

$fopening =0;$mopening=0;$fquantob =0;$mquantob=0;
 $q = "select * from layerbreeder_flock where flockcode = '$x_flock'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                {
				$fopening = $qr['femaleopening'];
				$mopening = $qr['maleopening'];
				}

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),fmort,fcull,mmort,mcull from layerbreeder_consumption where flock = '$x_flock' and date2 < '$x_date2' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                {
				 $minus = $minus + $qr['fmort'] + $qr['fcull'];
				 $minus1 = $minus1 + $qr['mmort'] + $qr['mcull'];
				}


             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ftransfer = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ttransfer = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ftransfer1 = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ttransfer1 = $qr['quantity'];
				
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date < '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')"; 
    		  $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fquantob = $fquantob + $qr['quant'];
               }
             }
             else
             {
                $fquantob = 0;
             } 
			 
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date < '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')"; 
    		  $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantob = $mquantob + $qr['quant'];
               }
             }
             else
             {
                $mquantob = 0;
             } 
				

             $femaleop = $fopening - $minus - $ftransfer + $ttransfer + $fquantob;
			 $maleop = $mopening - $minus1 - $ftransfer1 + $ttransfer1 + $mquantob;

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $fto = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $fti = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $mto = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $mti = $qr['quantity'];
				
				if($fti == "")
				$fti = 0;
				if($fto == "")
				$fto = 0;
				if($mti == "")
				$mti = 0;
				if($mto == "")
				$mto = 0;
				$fpur =0;
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fpur = $fpur + $qr['quant'];
               }
             }
  			 
			 $mpur =0;
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mpur = $mpur + $qr['quant'];
               }
             }
			 
			 	$fsale =0;
				$q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fsale = $fsale + $qr['quant'];
               }
             }
  			 
			 $msale =0;
				$q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $msale = $msale + $qr['quant'];
               }
             }
			 
			// $femalecl = $femaleop - $x_fmort - $x_fcull - $fto + $fti + $fpur - $fsale;
			// $malecl = $maleop - $x_mmort - $x_mcull - $mto + $mti  + $mpur - $msale;
			 
			 $femalecl = $femaleop - $x_fmort - $x_fcull - $fto + $fti + $fpur ;
			 $malecl = $maleop - $x_mmort - $x_mcull - $mto + $mti  + $mpur ;
if($i == 0)
{
$f1fop = $femaleop;
$f1mop = $maleop;
}
$i++;

$f1fmort+= $x_fmort;
$f1mmort+= $x_mmort;
$f1fcull+= $x_fcull;
$f1mcull+= $x_mcull;
$f1ew+= $x_eggwt;
$f1water+= $x_water;

$f1fcl = $femalecl;
$f1mcl = $malecl;

$f1feed+= $femalefeed;
$f1mfeed+= $malefeed;
$f1tableeggs+= $tableeggs;
$f1hatcheggs+= $hatcheggs;
$f1totaleggs+= $totaleggs;


?>

	<tr>
		<td class="ewRptGrpField1">
		<?php if($x_farmcode <> $ofarmcode) { echo ewrpt_ViewValue($x_farmcode); } else { echo ewrpt_ViewValue(); }?>
		</td>
		<td class="ewRptGrpField2">
		<?php if($x_shedcode <> $oshedcode) { echo ewrpt_ViewValue($x_shedcode); } else { echo ewrpt_ViewValue(); }?></td>
		<td class="ewRptGrpField3">
		<?php if($x_flock <> $oflock) { echo ewrpt_ViewValue($x_flock); } else { echo ewrpt_ViewValue(); }?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date2,7)) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($femaleop) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($maleop) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_fmort) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_mmort) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_fcull) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_mcull) ?>
</td>
<!--
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($fti) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($fto) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($mti) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($mto) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($femalecl) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($malecl) ?>
</td>



		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_fweight) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($sfbw) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_mweight) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($smbw) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_eggwt) ?>
</td>
<!--		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_water) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_avgwt) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($sew) ?>
</td>

<!--
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_reportedby) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?>>
<?php echo $femalefeed; ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo round(($femalefeed/$femaleop)*1000,2); ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo $stdffeed; ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo $malefeed; ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo round(($malefeed/$maleop)*1000,2); ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo $stdmfeed; ?>
</td>
<?php 
$query11 = "SELECT * FROM ims_itemcodes where cat = 'Layer Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result11 = mysql_query($query11,$conn1); 
             while($row111 = mysql_fetch_assoc($result11))
             {

		$hatcheggs1 = 0;
$qnew = "select sum(quantity) as quantity from layerbreeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemcode='$row111[code]'";
$qrsnew = mysql_query($qnew,$conn1) or die(mysql_error());
if($qrnew = mysql_fetch_assoc($qrsnew))
$hatcheggs1 = $qrnew['quantity'];
if($hatcheggs1 == "")
$hatcheggs1 = 0;
?>
       	<td<?php echo $sItemRowClass; ?>>
<?php echo $hatcheggs1; ?>
</td>
        <?php } ?>

        <?php $n=0;
             $query11 = "SELECT * FROM ims_itemcodes where cat = 'Layer Breeder Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result11 = mysql_query($query11,$conn1); 
             while($row111 = mysql_fetch_assoc($result11))
             { $n=$n+1; 
       
	   $tableeggs1 = 0;
$qnew = "select sum(quantity) as quantity from layerbreeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemcode='$row111[code]'";
$qrsnew = mysql_query($qnew,$conn1) or die(mysql_error());
if($qrnew = mysql_fetch_assoc($qrsnew))
$tableeggs1 = $qrnew['quantity'];
if($tableeggs1 == "")
$tableeggs1 = 0;  $total[$n]=$total[$n]+$tableeggs1?>
       <td<?php echo $sItemRowClass; ?>>
<?php echo $tableeggs1; ?>
</td>
        <?php } ?>
		
	
		<td<?php echo $sItemRowClass; ?>>
<?php echo $totaleggs; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo round($hatcheggs/$totaleggs * 100,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $hstd; $fshep = $shep; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo round($totaleggs/$femaleop * 100,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $pstd; $fspp = $spp; ?>
</td>
	</tr>
<?php
$ofarmcode = $rows['farmcode'];
$oshedcode = $rows['shedcode'];
$oflock = $rows['flock'];
}		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_farmcode = $x_farmcode;
		$o_shedcode = $x_shedcode;
		$o_flock = $x_flock;

		// Get next record
		GetRow(2);

		// Show Footers
?>


	<tr>
		<td <?php echo $sItemRowClass; ?> colspan="5" >Total</td>
		<td <?php echo $sItemRowClass; ?>>
		<?php echo ($f1fop); ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
		<?php echo ($f1mop); ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1fmort); ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1mmort); ?>		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1fcull); ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1mcull); ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1fcl);  ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1mcl);  ?></td>

<td <?php echo $sItemRowClass; ?> colspan="4">
<?php echo "";  ?>

	<td <?php echo $sItemRowClass; ?>>&nbsp;
	
		</td>
		<td <?php echo $sItemRowClass; ?>>&nbsp;
	
		</td>
		
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1feed);  ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>
<?php echo round((($f1feed/$f1fop)*100),2);  ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>&nbsp;</td>
		
		<td <?php echo $sItemRowClass; ?>>
<?php echo ($f1mfeed);  ?></td>

<td <?php echo $sItemRowClass; ?>>
<?php echo round((($f1mfeed/$f1mop)*100),2);  ?>
		</td>
		<td <?php echo $sItemRowClass; ?>>&nbsp;</td>
	    
       	<td<?php echo $sItemRowClass; ?>>
		
<?php echo $f1hatcheggs; ?>
</td>
        

        <?php
		for($j=1;$j<=$m;$j++)
		{

?>
       <td<?php echo $sItemRowClass; ?>>
<?php echo $total[$j]; ?>
</td>
 <?php } ?>    
		
	
		<td<?php echo $sItemRowClass; ?>>
<?php echo $f1totaleggs; ?>
</td>
		<td class="ewRptGrpSummary1">
		<?php echo round(($f1hatcheggs/$f1totaleggs) * 100,2); ?>
		</td>
		<td class="ewRptGrpSummary1">
		<?php echo "";  ?>
		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round((($f1totaleggs/$f1fop)*100)/$daycount,2);  ?>
		</td>
		<td class="ewRptGrpSummary1">
		<?php echo ""; ?>
		</td>
	</tr>
<?php


			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_farmcode = $x_farmcode; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
//} // End while
?>
	</tbody>
	</tfoot>
	
</table>
</div>
<?php if ($nTotalGrps > 0) {} ?>
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
function ChkLvlBreak($lvl) {}

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
	if ($lvl <= 1) $GLOBALS["o_farmcode"] = "";
	if ($lvl <= 2) $GLOBALS["o_shedcode"] = "";
	if ($lvl <= 3) $GLOBALS["o_flock"] = "";

	// Reset record count
	$nRecCount = 0;
}

// Accummulate grand summary
function AccumulateGrandSummary() {}

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
		$GLOBALS['x_farmcode'] = "";
	} else {
		$GLOBALS['x_farmcode'] = $rsgrp->fields('farmcode');
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
		$GLOBALS['x_shedcode'] = $rs->fields('shedcode');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_date2'] = $rs->fields('date2');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_fmort'] = $rs->fields('fmort');
		$GLOBALS['x_mmort'] = $rs->fields('mmort');
		$GLOBALS['x_fcull'] = $rs->fields('fcull');
		$GLOBALS['x_mcull'] = $rs->fields('mcull');
		$GLOBALS['x_fweight'] = $rs->fields('fweight');
		$GLOBALS['x_mweight'] = $rs->fields('mweight');
		$GLOBALS['x_eggwt'] = $rs->fields('eggwt');
		$GLOBALS['x_water'] = $rs->fields('water');
		$GLOBALS['x_avgwt'] = $rs->fields('avgwt');
		$GLOBALS['x_reportedby'] = $rs->fields('reportedby');
		$val[1] = $GLOBALS['x_date2'];
		$val[2] = $GLOBALS['x_age'];
		$val[3] = $GLOBALS['x_fmort'];
		$val[4] = $GLOBALS['x_mmort'];
		$val[5] = $GLOBALS['x_fcull'];
		$val[6] = $GLOBALS['x_mcull'];
		$val[7] = $GLOBALS['x_fweight'];
		$val[8] = $GLOBALS['x_mweight'];
		$val[9] = $GLOBALS['x_eggwt'];
		$val[10] = $GLOBALS['x_water'];
		$val[11] = $GLOBALS['x_avgwt'];
		$val[12] = $GLOBALS['x_reportedby'];
	} else {
		$GLOBALS['x_shedcode'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_date2'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_fmort'] = "";
		$GLOBALS['x_mmort'] = "";
		$GLOBALS['x_fcull'] = "";
		$GLOBALS['x_mcull'] = "";
		$GLOBALS['x_fweight'] = "";
		$GLOBALS['x_mweight'] = "";
		$GLOBALS['x_eggwt'] = "";
		$GLOBALS['x_water'] = "";
		$GLOBALS['x_avgwt'] = "";
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
function SetupPopup() {}

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
	$_SESSION["sel_dailyentryreport_$parm"] = "";
	$_SESSION["rf_dailyentryreport_$parm"] = "";
	$_SESSION["rt_dailyentryreport_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_dailyentryreport_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_dailyentryreport_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_dailyentryreport_$parm"];
}

// Load default value for filters
function LoadDefaultFilters() {}

// Check if filter applied
function CheckFilter() {}

// Show list of filters
function ShowFilterList() {}

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
function GetPopupFilter() {}
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
			$_SESSION["sort_dailyentryreport_farmcode"] = "";
			$_SESSION["sort_dailyentryreport_shedcode"] = "";
			$_SESSION["sort_dailyentryreport_flock"] = "";
			$_SESSION["sort_dailyentryreport_date2"] = "";
			$_SESSION["sort_dailyentryreport_age"] = "";
			$_SESSION["sort_dailyentryreport_fmort"] = "";
			$_SESSION["sort_dailyentryreport_mmort"] = "";
			$_SESSION["sort_dailyentryreport_fcull"] = "";
			$_SESSION["sort_dailyentryreport_mcull"] = "";
			$_SESSION["sort_dailyentryreport_fweight"] = "";
			$_SESSION["sort_dailyentryreport_mweight"] = "";
			$_SESSION["sort_dailyentryreport_eggwt"] = "";
			$_SESSION["sort_dailyentryreport_water"] = "";
			$_SESSION["sort_dailyentryreport_avgwt"] = "";
			$_SESSION["sort_dailyentryreport_reportedby"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "layerbreeder_consumption.date2 ASC";
		$_SESSION["sort_dailyentryreport_date2"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">
function reloadfun()
{
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;


var dt1  = parseInt(fdate.substring(0,2),10); 
var mon1 = parseInt(fdate.substring(3,5),10);
var yr1  = parseInt(fdate.substring(6,10),10); 
var dt2  = parseInt(tdate.substring(0,2),10); 
var mon2 = parseInt(tdate.substring(3,5),10); 
var yr2  = parseInt(tdate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

//document.location='lbdailyentryreportsmry.php?fromdate=' + fdate + '&todate=' + tdate;

if(Date.parse(date1) < Date.parse(date2))
{
document.location='lbdailyentryreportsmry.php?fromdate=' + fdate + '&todate=' + tdate;
}
else
{
alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}
</script>