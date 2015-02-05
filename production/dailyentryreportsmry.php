
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php 
/*$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 25px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:20px; 
            overflow: scroll; 
        }
    </style>
<?php }*/ ?>
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
$EW_REPORT_TABLE_SQL_FROM = "breeder_consumption Inner Join breeder_flock On breeder_consumption.flock = breeder_flock.flockcode";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT breeder_flock.farmcode, breeder_flock.shedcode, breeder_consumption.flock, breeder_consumption.date2, breeder_consumption.age, breeder_consumption.fmort, breeder_consumption.mmort, breeder_consumption.fcull, breeder_consumption.mcull, breeder_consumption.fweight, breeder_consumption.mweight, breeder_consumption.eggwt, breeder_consumption.water, breeder_consumption.avgwt, breeder_consumption.reportedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "'$fromdate' <= breeder_consumption.date2 and breeder_consumption.date2 <= '$todate' AND breeder_flock.cullflag = 0";
$EW_REPORT_TABLE_SQL_GROUPBY = "breeder_flock.farmcode, breeder_flock.shedcode, breeder_consumption.flock, breeder_consumption.date2, breeder_consumption.age, breeder_consumption.fmort, breeder_consumption.mmort, breeder_consumption.fcull, breeder_consumption.mcull, breeder_consumption.fweight, breeder_consumption.mweight, breeder_consumption.eggwt, breeder_consumption.water, breeder_consumption.avgwt, breeder_consumption.reportedby";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "breeder_flock.farmcode ASC, breeder_flock.shedcode ASC, breeder_consumption.flock ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "breeder_flock.farmcode", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `farmcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(breeder_consumption.fmort) AS SUM_fmort, SUM(breeder_consumption.mmort) AS SUM_mmort, SUM(breeder_consumption.fcull) AS SUM_fcull, SUM(breeder_consumption.mcull) AS SUM_mcull, SUM(breeder_consumption.water) AS SUM_water FROM " . $EW_REPORT_TABLE_SQL_FROM;
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
$EW_REPORT_FIELD_FARMCODE_SQL_SELECT = "SELECT DISTINCT breeder_flock.farmcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FARMCODE_SQL_ORDERBY = "breeder_flock.farmcode";
$EW_REPORT_FIELD_SHEDCODE_SQL_SELECT = "SELECT DISTINCT breeder_flock.shedcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY = "breeder_flock.shedcode";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT breeder_consumption.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "breeder_consumption.flock";
$EW_REPORT_FIELD_DATE2_SQL_SELECT = "SELECT DISTINCT breeder_consumption.date2 FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE2_SQL_ORDERBY = "breeder_consumption.date2";
$EW_REPORT_FIELD_AGE_SQL_SELECT = "SELECT DISTINCT breeder_consumption.age FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_AGE_SQL_ORDERBY = "breeder_consumption.age";
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
<td  style="padding-left:300px"><strong><font color="#3e3276">Daily Entry Report From <?php if($_GET['fromdate']) { echo $_GET['fromdate']; } else { echo date($datephp); }  ?> To <?php if($_GET['todate']) { echo $_GET['todate']; } else { echo date($datephp); }  ?></font></strong></td>
</tr>
</table>
<br/>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="dailyentryreportsmry.php?export=html&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="dailyentryreportsmry.php?export=excel&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Excel</a>
&nbsp;&nbsp;<a href="dailyentryreportsmry.php?export=word&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="dailyentryreportsmry.php?cmd=reset&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Reset All Filters</a>
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
<form action="dailyentryreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr <?php if (@$sExport != "") { ?> style="display:none" <?php } ?>>
	<td>
<span class="phpreportmaker">
From Date&nbsp;
<input type="text" class="datepicker" id="fromdate" name="fromdate" value="<?php if($_GET['fromdate']) { echo $_GET['fromdate']; } else { echo date($datephp); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;

To Date&nbsp;
<input type="text" class="datepicker" id="todate" name="todate" value="<?php if($_GET['todate']) { echo $_GET['todate']; } else { echo date($datephp); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;
</span>
</td>
	
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
while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		Farm		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farm</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'dailyentryreport_farmcode', false, '<?php echo $rf_farmcode; ?>', '<?php echo $rt_farmcode; ?>');return false;" name="x_farmcode<?php echo $cnt[0][0]; ?>" id="x_farmcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Shed		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shed</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'dailyentryreport_shedcode', false, '<?php echo $rf_shedcode; ?>', '<?php echo $rt_shedcode; ?>');return false;" name="x_shedcode<?php echo $cnt[0][0]; ?>" id="x_shedcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Flock		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'dailyentryreport_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'dailyentryreport_date2', true, '<?php echo $rf_date2; ?>', '<?php echo $rt_date2; ?>');return false;" name="x_date2<?php echo $cnt[0][0]; ?>" id="x_date2<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'dailyentryreport_age', false, '<?php echo $rf_age; ?>', '<?php echo $rt_age; ?>');return false;" name="x_age<?php echo $cnt[0][0]; ?>" id="x_age<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Opening">
		F.Op.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Opening">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Op.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Opening">
		M.Op.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Opening">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Op.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Mortality">
		F.Mort.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Mortality">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Mort</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Mortality">
		M.Mort		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Mortality">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Mort</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Culled">
		F.Cull		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Culled">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Cull</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Culled">
		M.Cull		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Culled">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Cull</td>
			</tr></table>		</td>
<?php } ?>
<!--
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Tr. In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Tr. In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Tr. Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Tr. Out</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Tr. In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Tr. In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Tr. Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Tr. Out</td>
			</tr></table>
		</td>
<?php } ?>
-->
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Closing">
		F.Cl.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Closing">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.Cl.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Closing">
		M.Cl.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Closing">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>M.Cl.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Female Body Weight">
		FBW		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Female Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>FBW</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Female Body Weight">
		Std.FBW		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Female Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.FBW</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Male Body Weight">
		MBW		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Male Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>MBW</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Male Body Weight">
		Std.MBW		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Male Body Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.MBW</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Egg Weight">
		Egg Wt.		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Egg Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Egg Wt.</td>
			</tr></table>		</td>
<?php } ?>
<!--
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Water
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Water</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Average Egg Weight">
		AEW
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Average Egg Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>AEW</td>
			</tr></table>
		</td>
<?php } ?>
-->
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Egg Weight">
		Std.EW		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Egg Weight">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std.EW</td>
			</tr></table>		</td>
<?php } ?>

<!--
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Reported By
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Reported By</td>
			</tr></table>
		</td>
<?php } ?>
-->
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Feed <br />(Kgs)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Feed <br />(Kgs)</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Feed/Bird <br />(Gms)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Feed/Bird <br />(Gms)</td>
			</tr></table>		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std. Female Feed/Bird <br />(Gms)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Female Feed/Bird <br />(Gms)</td>
			</tr></table>		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Feed <br />(Kgs)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Feed <br />(Kgs)</td>
			</tr></table>		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Feed/Bird <br />(Gms)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Feed/Bird <br />(Gms)</td>
			</tr></table>		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std. Male Feed/Bird <br />(Gms)		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Male Feed/Bird <br />(Gms)</td>
			</tr></table>		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Table Eggs		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Table Eggs</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Hatch Eggs		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Hatch Eggs</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Eggs		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Eggs</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Hatch Eggs Percentage">
		HE. %		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>HE. %</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Hatch Eggs Percentage">
		Std. HE. %		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. HE. %</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Production Percentage">
		Prod. %		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Prod. %</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Production Percentage">
		Std. Prod. %		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Standard Production Percentage">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std. Prod. %</td>
			</tr></table>		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

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
	while ($rs && !$rs->EOF) { // Loop detail records
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
       $qbr = "select breed from breeder_flock where flockcode = '$x_flock'"; 
  		$qrsbr = mysql_query($qbr,$conn1) or die(mysql_error());
		while($qrbr = mysql_fetch_assoc($qrsbr))
		{
		$flkbreed = $qrbr['breed'];
		}
			if($flkbreed != "")
			{
			$q = "select * from breeder_standards where Age = '$nrWeeksPassed1' and breed = '$flkbreed'";
			}
			else
			{
			$q = "select * from breeder_standards where Age = '$nrWeeksPassed1'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$sfbw = $qr['fweight'];
				$smbw = $qr['mweight'];
				$spp = $qr['productionper'];
				$shep = $qr['heggper'];
				$sew = $qr['eggwt'];
			}
			
			if($flkbreed != "")
			{
			$q = "select * from breeder_standards where age = '$nrWeeksPassed1'  and breed = '$flkbreed'";
			}
			else
			{
			$q = "select * from breeder_standards where age = '$nrWeeksPassed1'";
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
 $getstd = "SELECT * FROM breeder_standards WHERE age = '$nrWeeksPassed1'  and breed = '$flkbreed'";
 }
 else
 {
 $getstd = "SELECT * FROM breeder_standards WHERE age = '$nrWeeksPassed1'";
 }
 $resultstd = mysql_query($getstd,$conn1);
 while($rowstd = mysql_fetch_assoc($resultstd))
 {
  $stdffeed = $rowstd['ffeed'];
  $stdmfeed = $rowstd['mfeed'];
 }


$femalefeed = 0;
//$q1 = "select code from ims_itemcodes where cat = 'Female Feed' order by code";
//$q1rs = mysql_query($q1,$conn1) or die(mysql_error());
//while($q1r = mysql_fetch_assoc($q1rs))
//{
$q = "select ffeed as quantity from breeder_consumption where flock = '$x_flock' and date2 = '$x_date2'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$femalefeed = $qr['quantity'];
//}
if($femalefeed == "")
$femalefeed = 0;
$malefeed = 0;
//$q1 = "select code from ims_itemcodes where cat = 'Male Feed' order by code";
//$q1rs = mysql_query($q1,$conn1) or die(mysql_error());
//while($q1r = mysql_fetch_assoc($q1rs))
//{
$q = "select mfeed as quantity from breeder_consumption where flock = '$x_flock' and date2 = '$x_date2'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$malefeed = $qr['quantity'];
//}

if($malefeed == "")
$malefeed = 0;

$tableeggs = 0;
$q = "select sum(quantity) as quantity from breeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemdesc not in (select distinct(description) from ims_itemcodes where cat = 'Hatch Eggs')";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$tableeggs = $qr['quantity'];
if($tableeggs == "")
$tableeggs = 0;

$hatcheggs = 0;
$q = "select sum(quantity) as quantity from breeder_production where flock = '$x_flock' and date1 = '$x_date2' and itemdesc in (select distinct(description) from ims_itemcodes where cat = 'Hatch Eggs')";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
$hatcheggs = $qr['quantity'];
if($hatcheggs == "")
$hatcheggs = 0;

$totaleggs = $tableeggs + $hatcheggs;

$fopening =0;$mopening=0;$fquantob =0;$mquantob=0;
 $q = "select * from breeder_flock where flockcode = '$x_flock'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                {
				$fopening = $qr['femaleopening'];
				$mopening = $qr['maleopening'];
				}

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),fmort,fcull,mmort,mcull from breeder_consumption where flock = '$x_flock' and date2 < '$x_date2' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                {
				$minus = $minus + $qr['fmort'] + $qr['fcull'];
				$minus1 = $minus1 + $qr['mmort'] + $qr['mcull'];
				}


             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ftransfer = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ttransfer = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ftransfer1 = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$x_flock' and date < '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $ttransfer1 = $qr['quantity'];
				
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date < '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')"; 
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
			 
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date < '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')"; 
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
				
			 $q = "SELECT sum(shortagefemale) - sum(excessfemale) AS female FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date < '$x_date2'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $fadjust = $rr['female'];

			 $q = "SELECT sum(shortagemale) - sum(excessmale) AS male FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date < '$x_date2'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $madjust = $rr['male'];


             $femaleop = $fopening - $minus - $ftransfer + $ttransfer + $fquantob + $fadjust;
			 $maleop = $mopening - $minus1 - $ftransfer1 + $ttransfer1 + $mquantob + $madjust;

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $fto = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $fti = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$x_flock' and date = '$x_date2'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		   if($qr = mysql_fetch_assoc($qrs))
                $mto = $qr['quantity'];

             $q = "select sum(quantity) as quantity from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$x_flock' and date = '$x_date2'"; 
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
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fpur = $fpur + $qr['quant'];
               }
             }
  			 
			 $mpur =0;
				$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mpur = $mpur + $qr['quant'];
               }
             }
			 
			 	$fsale =0;
				$q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fsale = $fsale + $qr['quant'];
               }
             }
  			 
			 $msale =0;
				$q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$x_flock' AND date = '$x_date2' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $msale = $msale + $qr['quant'];
               }
             }
			 $q = "SELECT sum(shortagefemale) - sum(excessfemale) AS female FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date = '$x_date2'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $fadjust = $rr['female'];

			 $q = "SELECT sum(shortagemale) - sum(excessmale) AS male FROM breeder_birdsadjustment WHERE flock = '$x_flock' AND date = '$x_date2'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $madjust = $rr['male'];
			 
			// $femalecl = $femaleop - $x_fmort - $x_fcull - $fto + $fti + $fpur - $fsale;
			// $malecl = $maleop - $x_mmort - $x_mcull - $mto + $mti  + $mpur - $msale;
			 
			 $femalecl = $femaleop - $x_fmort - $x_fcull - $fto + $fti + $fpur + $fadjust;
			 $malecl = $maleop - $x_mmort - $x_mcull - $mto + $mti  + $mpur + $madjust;
if($i == 0)
{
$ffop = $femaleop;
$fmop = $maleop;
}
$i++;

$ffmort+= $x_fmort;
$fmmort+= $x_mmort;
$ffcull+= $x_fcull;
$fmcull+= $x_mcull;
$few+= $x_eggwt;
$fwater+= $x_water;

$ffcl = $femalecl;
$fmcl = $malecl;

$ffeed+= $femalefeed;
$mfeed+= $malefeed;
$ftableeggs+= $tableeggs;
$fhatcheggs+= $hatcheggs;
$ftotaleggs+= $totaleggs;


?>

	<tr>
		<td class="ewRptGrpField1">
		<?php $t_farmcode = $x_farmcode; $x_farmcode = $dg_farmcode; ?>
		<?php echo ewrpt_ViewValue($x_farmcode) ?>		<?php $x_farmcode = $t_farmcode; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_shedcode = $x_shedcode; $x_shedcode = $dg_shedcode; ?>
<?php echo ewrpt_ViewValue($x_shedcode) ?>
		<?php $x_shedcode = $t_shedcode; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_flock = $x_flock; $x_flock = $dg_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
		<?php $x_flock = $t_flock; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date2,7)) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right"><?php echo $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($femaleop) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($maleop) ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_fmort) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_mmort) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_fcull) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_mcull) ?></td>
<!--
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($fti) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($fto) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($mti) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($mto) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($femalecl) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($malecl) ?></td>



		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_fweight) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($sfbw) ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_mweight) ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($smbw) ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_eggwt) ?></td>
<!--		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_water) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($x_avgwt) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ($sew) ?></td>

<!--
		<td<?php echo $sItemRowClass; ?>>
<?php echo ($x_reportedby) ?>
</td>
-->
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $femalefeed; ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo round(($femalefeed/$femaleop)*1000,2); ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $stdffeed; ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $malefeed; ?></td>

		<td<?php echo $sItemRowClass; ?>  align="right">
<?php echo round(($malefeed/$maleop)*1000,2); ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $stdmfeed; ?></td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $tableeggs; ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $hatcheggs; ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $totaleggs; ?></td>
		<td<?php echo $sItemRowClass; ?>  align="right">
<?php echo round($hatcheggs/$totaleggs * 100,2); ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $shep; $fshep = $shep; ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo round($totaleggs/$femaleop * 100,2); ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $spp; $fspp = $spp; ?></td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_farmcode = $x_farmcode;
		$o_shedcode = $x_shedcode;
		$o_flock = $x_flock;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(3)) {
?>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="32" class="ewRptGrpSummary3">Summary for Flock: <?php $t_flock = $x_flock; $x_flock = $o_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
<?php $x_flock = $t_flock; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="5" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($ffop); $sfop = $sfop + $ffop; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($fmop); $smop = $smop + $fmop; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($ffmort); $sfmort = $sfmort + $ffmort; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($fmmort); $smmort = $smmort + $fmmort; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($ffcull); $sfcull = $sfcull + $ffcull; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($fmcull); $smcull = $smcull + $fmcull; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($ffcl); $sfcl = $sfcl + $ffcl; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($fmcl); $smcl = $smcl + $fmcl; ?>		</td>
		<!--<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
<?php echo "&nbsp;";#($few) ?>		</td>
		<!--<td class="ewRptGrpSummary1">
		<?php $t_water = $x_water; ?>
		<?php $x_water = $smry[1][9]; // Load SUM ?>
<?php echo ($fwater); $swater = $swater + $fwater; ?>
		<?php $x_water = $t_water; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $ffeed; $sffeed = $sffeed + $ffeed; ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $mfeed; $smfeed = $smfeed + $mfeed; ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>

		<td class="ewRptGrpSummary1">
		<?php echo $ftableeggs; $stableeggs = $stableeggs + $ftableeggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $fhatcheggs; $shatcheggs = $shatcheggs + $fhatcheggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $ftotaleggs; $stotaleggs = $stotaleggs + $ftotaleggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round(($fhatcheggs/$ftotaleggs) * 100,2); ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $fshep; $sshep = $sshep + $fshep; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $te = round(($ftotaleggs/$ffop)/$i * 100,2); $sprodper = $sprodper + $te; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $fspp; $sspp = $sspp + $fspp; ?>		</td>
	</tr>
<?php
$s++;
$i = $ffop = $fmop = $ffcl = $fmcl = $ffmort = $fmmort = $ffcull = $fmcull = $few = $fwater = $ffeed = $mfeed = $ftableeggs = $fhatcheggs = $ftotaleggs = 0;

			// Reset level 3 summary
			ResetLevelSummary(3);
		} // End check level check
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="32" class="ewRptGrpSummary2">Summary for Shedcode: <?php $t_shedcode = $x_shedcode; $x_shedcode = $o_shedcode; ?>
<?php echo ewrpt_ViewValue($x_shedcode) ?>
<?php $x_shedcode = $t_shedcode; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="5" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($sfop); $flfop = $flfop + $sfop; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($smop); $flmop = $flmop + $smop; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($sfmort); $flfmort = $flfmort + $sfmort; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($smmort); $flmmort = $flmmort + $smmort; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($sfcull); $flfcull = $flfcull + $sfcull; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($smcull); $flmcull = $flmcull + $smcull; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($sfcl); $flfcl = $flfcl + $sfcl; ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($smcl); $flmcl = $flmcl + $smcl; ?>		</td>
		<!--<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
<?php echo "&nbsp;";#($few) ?>		</td>
		<!--<td class="ewRptGrpSummary1">
		<?php $t_water = $x_water; ?>
		<?php $x_water = $smry[1][9]; // Load SUM ?>
<?php echo ($swater); $flwater = $flwater + $swater; ?>
		<?php $x_water = $t_water; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $sffeed; $flffeed = $flffeed + $sffeed; ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $smfeed;  $flmfeed = $flmfeed + $smfeed; ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>

		<td class="ewRptGrpSummary1">
		<?php echo $stableeggs; $fltableeggs = $fltableeggs + $stableeggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $shatcheggs; $flhatcheggs = $flhatcheggs + $shatcheggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $stotaleggs; $fltotaleggs = $fltotaleggs + $stotaleggs; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round(($shatcheggs/$stotaleggs) * 100,2); ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $ft = round($sshep/$s,2); $flshep = $flshep + $ft; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $ft1 = round($sprodper/$s,2); $flprodper = $flprodper + $ft1; ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $ft2 = round($sspp/$s,2); $flspp = $flspp + $ft2; ?>		</td>
	</tr>
<?php
$fl++;
$s = $sfop = $smop = $sprodper = $sfcl = $smcl = $sfmort = $smmort = $sfcull = $smcull = $sew = $swater = $sffeed = $smfeed = $stableeggs = $shatcheggs = $stotaleggs = 0;

			// Reset level 2 summary
			ResetLevelSummary(2);
		} // End check level check
?>
<?php
	} // End detail records loop
?>
<?php
?>
	<tr>
		<td colspan="32" class="ewRptGrpSummary1">Summary for Farmcode: <?php $t_farmcode = $x_farmcode; $x_farmcode = $o_farmcode; ?>
<?php echo ewrpt_ViewValue($x_farmcode) ?>
<?php $x_farmcode = $t_farmcode; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="5" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($flfop); ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo ($flmop); ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flfmort); ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flmmort); ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flfcull); ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flmcull); ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flfcl);  ?>		</td>
		<td class="ewRptGrpSummary1">
<?php echo ($flmcl);  ?>		</td>
		<!--<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
<?php echo "&nbsp;";#($few) ?>		</td>
		<!--<td class="ewRptGrpSummary1">
		<?php $t_water = $x_water; ?>
		<?php $x_water = $smry[1][9]; // Load SUM ?>
<?php echo ($flwater); ?>
		<?php $x_water = $t_water; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>-->
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $flffeed;  ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php echo $flmfeed;  ?>		</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>
	     <td class="ewRptGrpSummary1">&nbsp;</td>

		<td class="ewRptGrpSummary1">
		<?php echo $fltableeggs;  ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $flhatcheggs;  ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo $fltotaleggs;  ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round(($flhatcheggs/$fltotaleggs) * 100,2); ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round($flshep/$fl,2);  ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round($flprodper/$fl,2);  ?>		</td>
		<td class="ewRptGrpSummary1">
		<?php echo round($flspp/$fl,2); ?>		</td>
	</tr>
<?php
$fl = $flfop = $flmop = $flprodper = $flfcl = $flmcl = $flfmort = $flmmort = $flfcull = $flmcull = $flew = $flwater = $flffeed = $flmfeed = $fltableeggs = $flhatcheggs = $fltotaleggs = 0;

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_farmcode = $x_farmcode; // Save old group value
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
		$grandsmry[4] = $rsagg->fields("SUM_mmort");
		$grandsmry[5] = $rsagg->fields("SUM_fcull");
		$grandsmry[6] = $rsagg->fields("SUM_mcull");
		$grandsmry[10] = $rsagg->fields("SUM_water");
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
	<!-- tr><td colspan="15"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="32">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="3" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_fmort = $x_fmort; ?>
		<?php $x_fmort = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_fmort) ?>
		<?php $x_fmort = $t_fmort; ?>		</td>
		<td>
		<?php $t_mmort = $x_mmort; ?>
		<?php $x_mmort = $grandsmry[4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_mmort) ?>
		<?php $x_mmort = $t_mmort; ?>		</td>
		<td>
		<?php $t_fcull = $x_fcull; ?>
		<?php $x_fcull = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_fcull) ?>
		<?php $x_fcull = $t_fcull; ?>		</td>
		<td>
		<?php $t_mcull = $x_mcull; ?>
		<?php $x_mcull = $grandsmry[6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_mcull) ?>
		<?php $x_mcull = $t_mcull; ?>		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_water = $x_water; ?>
		<?php $x_water = $grandsmry[10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_water) ?>
		<?php $x_water = $t_water; ?>		</td>
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
<form action="dailyentryreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		
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
			return (is_null($GLOBALS["x_farmcode"]) && !is_null($GLOBALS["o_farmcode"])) ||
				(!is_null($GLOBALS["x_farmcode"]) && is_null($GLOBALS["o_farmcode"])) ||
				($GLOBALS["x_farmcode"] <> $GLOBALS["o_farmcode"]);
		case 2:
			return (is_null($GLOBALS["x_shedcode"]) && !is_null($GLOBALS["o_shedcode"])) ||
				(!is_null($GLOBALS["x_shedcode"]) && is_null($GLOBALS["o_shedcode"])) ||
				($GLOBALS["x_shedcode"] <> $GLOBALS["o_shedcode"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_flock"]) && !is_null($GLOBALS["o_flock"])) ||
				(!is_null($GLOBALS["x_flock"]) && is_null($GLOBALS["o_flock"])) ||
				($GLOBALS["x_flock"] <> $GLOBALS["o_flock"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_farmcode"] = "";
	if ($lvl <= 2) $GLOBALS["o_shedcode"] = "";
	if ($lvl <= 3) $GLOBALS["o_flock"] = "";

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
function SetupPopup() {
	global $conn, $sFilter;

	// Initialize popup
	// Build distinct values for farmcode

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FARMCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FARMCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_farmcode = $rswrk->fields[0];
		if (is_null($x_farmcode)) {
			$bNullValue = TRUE;
		} elseif ($x_farmcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_farmcode = $x_farmcode;
			$dg_farmcode = $x_farmcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], $g_farmcode, $dg_farmcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for shedcode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SHEDCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_shedcode = $rswrk->fields[0];
		if (is_null($x_shedcode)) {
			$bNullValue = TRUE;
		} elseif ($x_shedcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_shedcode = $x_shedcode;
			$dg_shedcode = $x_shedcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], $g_shedcode, $dg_shedcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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

	// Build distinct values for age
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_AGE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_AGE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_age = $rswrk->fields[0];
		if (is_null($x_age)) {
			$bNullValue = TRUE;
		} elseif ($x_age == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_age = $x_age;
			ewrpt_SetupDistinctValues($GLOBALS["val_age"], $x_age, $t_age, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_age"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_age"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('farmcode');
			ClearSessionSelection('shedcode');
			ClearSessionSelection('flock');
			ClearSessionSelection('date2');
			ClearSessionSelection('age');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Farmcode selected values

	if (is_array(@$_SESSION["sel_dailyentryreport_farmcode"])) {
		LoadSelectionFromSession('farmcode');
	} elseif (@$_SESSION["sel_dailyentryreport_farmcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_farmcode"] = "";
	}

	// Get Shedcode selected values
	if (is_array(@$_SESSION["sel_dailyentryreport_shedcode"])) {
		LoadSelectionFromSession('shedcode');
	} elseif (@$_SESSION["sel_dailyentryreport_shedcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shedcode"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_dailyentryreport_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_dailyentryreport_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
	}

	// Get Date 2 selected values
	if (is_array(@$_SESSION["sel_dailyentryreport_date2"])) {
		LoadSelectionFromSession('date2');
	} elseif (@$_SESSION["sel_dailyentryreport_date2"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date2"] = "";
	}

	// Get Age selected values
	if (is_array(@$_SESSION["sel_dailyentryreport_age"])) {
		LoadSelectionFromSession('age');
	} elseif (@$_SESSION["sel_dailyentryreport_age"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_age"] = "";
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

	// Field farmcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_farmcode = array("val1", "val2");

	$GLOBALS["seld_farmcode"] = "";
	$GLOBALS["sel_farmcode"] =  $GLOBALS["seld_farmcode"];

	// Field shedcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_shedcode = array("val1", "val2");

	$GLOBALS["seld_shedcode"] = "";
	$GLOBALS["sel_shedcode"] =  $GLOBALS["seld_shedcode"];

	// Field flock
	// Setup your default values for the popup filter below, e.g.
	// $seld_flock = array("val1", "val2");

	$GLOBALS["seld_flock"] = "";
	$GLOBALS["sel_flock"] =  $GLOBALS["seld_flock"];

	// Field date2
	// Setup your default values for the popup filter below, e.g.
	// $seld_date2 = array("val1", "val2");

	$GLOBALS["seld_date2"] = "";
	$GLOBALS["sel_date2"] =  $GLOBALS["seld_date2"];

	// Field age
	// Setup your default values for the popup filter below, e.g.
	// $seld_age = array("val1", "val2");

	$GLOBALS["seld_age"] = "";
	$GLOBALS["sel_age"] =  $GLOBALS["seld_age"];
}

// Check if filter applied
function CheckFilter() {

	// Check farmcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_farmcode"], $GLOBALS["sel_farmcode"]))
		return TRUE;

	// Check shedcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_shedcode"], $GLOBALS["sel_shedcode"]))
		return TRUE;

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;

	// Check date2 popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date2"], $GLOBALS["sel_date2"]))
		return TRUE;

	// Check age popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_age"], $GLOBALS["sel_age"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field farmcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_farmcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_farmcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Farmcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field shedcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_shedcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_shedcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Shedcode<br />";
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

	// Field age
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_age"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_age"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Age<br />";
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
	if (is_array($GLOBALS["sel_farmcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_farmcode"], "breeder_flock.farmcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_farmcode"], $GLOBALS["gb_farmcode"], $GLOBALS["gi_farmcode"], $GLOBALS["gq_farmcode"]);
	}
	if (is_array($GLOBALS["sel_shedcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shedcode"], "breeder_flock.shedcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shedcode"], $GLOBALS["gb_shedcode"], $GLOBALS["gi_shedcode"], $GLOBALS["gq_shedcode"]);
	}
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "breeder_consumption.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"], $GLOBALS["gb_flock"], $GLOBALS["gi_flock"], $GLOBALS["gq_flock"]);
	}
	if (is_array($GLOBALS["sel_date2"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date2"], "breeder_consumption.date2", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date2"]);
	}
	if (is_array($GLOBALS["sel_age"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_age"], "breeder_consumption.age", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_age"]);
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "breeder_consumption.date2 ASC";
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

//document.location='dailyentryreportsmry.php?fromdate=' + fdate + '&todate=' + tdate;

if(Date.parse(date1) < Date.parse(date2))
{
document.location='dailyentryreportsmry.php?fromdate=' + fdate + '&todate=' + tdate;
}
else
{
alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}
</script>