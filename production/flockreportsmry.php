<?php 
 $reporttype="Breeder";
 $sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <!--<style type="text/css">
        thead tr {
            position: absolute; 
            height: 20px;
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
    </style>-->
<?php }
?>
<?php
session_start();
ob_start();
include "reportheader.php"; 
include "getemployee.php";
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
define("EW_REPORT_TABLE_VAR", "flockreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "flockreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "flockreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "flockreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "flockreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "flockreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "breeder_flock";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT breeder_flock.flockcode, breeder_flock.flockdescription, breeder_flock.age, breeder_flock.startdate, breeder_flock.femaleopening, breeder_flock.maleopening, breeder_flock.shedcode, breeder_flock.sheddescription, breeder_flock.farmcode, breeder_flock.farmdescription, breeder_flock.unitcode, breeder_flock.unitdescription FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "breeder_flock.cullflag <> 1";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "breeder_flock.farmcode ASC, breeder_flock.unitcode ASC, breeder_flock.shedcode ASC, breeder_flock.sheddescription ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "breeder_flock.farmcode", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `farmcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(breeder_flock.femaleopening) AS SUM_femaleopening, SUM(breeder_flock.maleopening) AS SUM_maleopening FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_flockcode = NULL; // Popup filter for flockcode
$af_flockdescription = NULL; // Popup filter for flockdescription
$af_age = NULL; // Popup filter for age
$af_startdate = array(); // Popup filter for startdate
$af_startdate[0][0] = "@@1";
$af_startdate[0][1] = "Past";
$af_startdate[0][2] = ewrpt_IsPast(); // Return sql part
$af_startdate[1][0] = "@@2";
$af_startdate[1][1] = "Future";
$af_startdate[1][2] = ewrpt_IsFuture(); // Return sql part
$af_startdate[2][0] = "@@3";
$af_startdate[2][1] = "Last 30 days";
$af_startdate[2][2] = ewrpt_IsLast30Days(); // Return sql part
$af_startdate[3][0] = "@@4";
$af_startdate[3][1] = "Last 14 days";
$af_startdate[3][2] = ewrpt_IsLast14Days(); // Return sql part
$af_startdate[4][0] = "@@5";
$af_startdate[4][1] = "Last 7 days";
$af_startdate[4][2] = ewrpt_IsLast7Days(); // Return sql part
$af_startdate[5][0] = "@@6";
$af_startdate[5][1] = "Next 7 days";
$af_startdate[5][2] = ewrpt_IsNext7Days(); // Return sql part
$af_startdate[6][0] = "@@7";
$af_startdate[6][1] = "Next 14 days";
$af_startdate[6][2] = ewrpt_IsNext14Days(); // Return sql part
$af_startdate[7][0] = "@@8";
$af_startdate[7][1] = "Next 30 days";
$af_startdate[7][2] = ewrpt_IsNext30Days(); // Return sql part
$af_startdate[8][0] = "@@9";
$af_startdate[8][1] = "Yesterday";
$af_startdate[8][2] = ewrpt_IsYesterday(); // Return sql part
$af_startdate[9][0] = "@@10";
$af_startdate[9][1] = "Today";
$af_startdate[9][2] = ewrpt_IsToday(); // Return sql part
$af_startdate[10][0] = "@@11";
$af_startdate[10][1] = "Tomorrow";
$af_startdate[10][2] = ewrpt_IsTomorrow(); // Return sql part
$af_startdate[11][0] = "@@12";
$af_startdate[11][1] = "Last month";
$af_startdate[11][2] = ewrpt_IsLastMonth(); // Return sql part
$af_startdate[12][0] = "@@13";
$af_startdate[12][1] = "This month";
$af_startdate[12][2] = ewrpt_IsThisMonth(); // Return sql part
$af_startdate[13][0] = "@@14";
$af_startdate[13][1] = "Next month";
$af_startdate[13][2] = ewrpt_IsNextMonth(); // Return sql part
$af_startdate[14][0] = "@@15";
$af_startdate[14][1] = "Last two weeks";
$af_startdate[14][2] = ewrpt_IsLast2Weeks(); // Return sql part
$af_startdate[15][0] = "@@16";
$af_startdate[15][1] = "Last week";
$af_startdate[15][2] = ewrpt_IsLastWeek(); // Return sql part
$af_startdate[16][0] = "@@17";
$af_startdate[16][1] = "This week";
$af_startdate[16][2] = ewrpt_IsThisWeek(); // Return sql part
$af_startdate[17][0] = "@@18";
$af_startdate[17][1] = "Next week";
$af_startdate[17][2] = ewrpt_IsNextWeek(); // Return sql part
$af_startdate[18][0] = "@@19";
$af_startdate[18][1] = "Next two weeks";
$af_startdate[18][2] = ewrpt_IsNext2Weeks(); // Return sql part
$af_startdate[19][0] = "@@20";
$af_startdate[19][1] = "Last year";
$af_startdate[19][2] = ewrpt_IsLastYear(); // Return sql part
$af_startdate[20][0] = "@@21";
$af_startdate[20][1] = "This year";
$af_startdate[20][2] = ewrpt_IsThisYear(); // Return sql part
$af_startdate[21][0] = "@@22";
$af_startdate[21][1] = "Next year";
$af_startdate[21][2] = ewrpt_IsNextYear(); // Return sql part
$af_femaleopening = NULL; // Popup filter for femaleopening
$af_maleopening = NULL; // Popup filter for maleopening
$af_shedcode = NULL; // Popup filter for shedcode
$af_sheddescription = NULL; // Popup filter for sheddescription
$af_farmcode = NULL; // Popup filter for farmcode
$af_unitcode = NULL; // Popup filter for unitcode
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
$nDisplayGrps = 10000; // Groups per page
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
$EW_REPORT_FIELD_UNITCODE_SQL_SELECT = "SELECT DISTINCT breeder_flock.unitcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY = "breeder_flock.unitcode";
$EW_REPORT_FIELD_SHEDCODE_SQL_SELECT = "SELECT DISTINCT breeder_flock.shedcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY = "breeder_flock.shedcode";
$EW_REPORT_FIELD_STARTDATE_SQL_SELECT = "SELECT DISTINCT breeder_flock.startdate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_STARTDATE_SQL_ORDERBY = "breeder_flock.startdate";
?>
<?php

// Field variables
$x_flockcode = NULL;
$x_flockdescription = NULL;
$x_age = NULL;
$x_startdate = NULL;
$x_femaleopening = NULL;
$x_maleopening = NULL;
$x_shedcode = NULL;
$x_sheddescription = NULL;
$x_farmcode = NULL;
$x_farmdescription = NULL;
$x_unitcode = NULL;
$x_unitdescription = NULL;

// Group variables
$o_farmcode = NULL; $g_farmcode = NULL; $dg_farmcode = NULL; $t_farmcode = NULL; $ft_farmcode = 200; $gf_farmcode = $ft_farmcode; $gb_farmcode = ""; $gi_farmcode = "0"; $gq_farmcode = ""; $rf_farmcode = NULL; $rt_farmcode = NULL;
$o_unitcode = NULL; $g_unitcode = NULL; $dg_unitcode = NULL; $t_unitcode = NULL; $ft_unitcode = 200; $gf_unitcode = $ft_unitcode; $gb_unitcode = ""; $gi_unitcode = "0"; $gq_unitcode = ""; $rf_unitcode = NULL; $rt_unitcode = NULL;
$o_shedcode = NULL; $g_shedcode = NULL; $dg_shedcode = NULL; $t_shedcode = NULL; $ft_shedcode = 200; $gf_shedcode = $ft_shedcode; $gb_shedcode = ""; $gi_shedcode = "0"; $gq_shedcode = ""; $rf_shedcode = NULL; $rt_shedcode = NULL;
$o_sheddescription = NULL; $g_sheddescription = NULL; $dg_sheddescription = NULL; $t_sheddescription = NULL; $ft_sheddescription = 200; $gf_sheddescription = $ft_sheddescription; $gb_sheddescription = ""; $gi_sheddescription = "0"; $gq_sheddescription = ""; $rf_sheddescription = NULL; $rt_sheddescription = NULL;

// Detail variables
$o_flockcode = NULL; $t_flockcode = NULL; $ft_flockcode = 200; $rf_flockcode = NULL; $rt_flockcode = NULL;
$o_flockdescription = NULL; $t_flockdescription = NULL; $ft_flockdescription = 200; $rf_flockdescription = NULL; $rt_flockdescription = NULL;
$o_age = NULL; $t_age = NULL; $ft_age = 5; $rf_age = NULL; $rt_age = NULL;
$o_startdate = NULL; $t_startdate = NULL; $ft_startdate = 133; $rf_startdate = NULL; $rt_startdate = NULL;
$o_femaleopening = NULL; $t_femaleopening = NULL; $ft_femaleopening = 5; $rf_femaleopening = NULL; $rt_femaleopening = NULL;
$o_maleopening = NULL; $t_maleopening = NULL; $ft_maleopening = 5; $rf_maleopening = NULL; $rt_maleopening = NULL;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_farmcode = "";
$seld_farmcode = "";
$val_farmcode = "";
$sel_unitcode = "";
$seld_unitcode = "";
$val_unitcode = "";
$sel_shedcode = "";
$seld_shedcode = "";
$val_shedcode = "";
$sel_startdate = "";
$seld_startdate = "";
$val_startdate = "";

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
ewrpt_CreatePopup("flockreport_farmcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unitcode, $sel_unitcode, $ft_unitcode) ?>
ewrpt_CreatePopup("flockreport_unitcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shedcode, $sel_shedcode, $ft_shedcode) ?>
ewrpt_CreatePopup("flockreport_shedcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_startdate, $sel_startdate, $ft_startdate) ?>
ewrpt_CreatePopup("flockreport_startdate", [<?php echo $jsdata ?>]);
</script>
<div id="flockreport_farmcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="flockreport_unitcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="flockreport_shedcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="flockreport_startdate_Popup" class="ewPopup">
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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Flock Details Report</font></strong></td>
</tr>
</table>
<br/>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="flockreportsmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="flockreportsmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="flockreportsmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="flockreportsmry.php?cmd=reset">Reset All Filters</a>
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
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="flockreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table align="center" class="ewTable ewTableSeparate" cellspacing="0">
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
		Farm Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farm Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'flockreport_farmcode', false, '<?php echo $rf_farmcode; ?>', '<?php echo $rt_farmcode; ?>');return false;" name="x_farmcode<?php echo $cnt[0][0]; ?>" id="x_farmcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Unit Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Unit Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'flockreport_unitcode', false, '<?php echo $rf_unitcode; ?>', '<?php echo $rt_unitcode; ?>');return false;" name="x_unitcode<?php echo $cnt[0][0]; ?>" id="x_unitcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Shed Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shed Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'flockreport_shedcode', false, '<?php echo $rf_shedcode; ?>', '<?php echo $rt_shedcode; ?>');return false;" name="x_shedcode<?php echo $cnt[0][0]; ?>" id="x_shedcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		Shed Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shed Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Flock Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Flock Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age(In Weeks)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age(In Weeks)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age(In Days)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age(In Days)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Start Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Start Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'flockreport_startdate', true, '<?php echo $rf_startdate; ?>', '<?php echo $rt_startdate; ?>');return false;" name="x_startdate<?php echo $cnt[0][0]; ?>" id="x_startdate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>


<?php if($reporttype=="Layer") { ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Opening Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Opening Birds</td>
			</tr></table>
		</td>
<?php } ?>

<?php } else { ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Female Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Female Opening</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Male Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Male Opening</td>
			</tr></table>
		</td>
<?php } ?>

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
		$dg_unitcode = $x_unitcode;
		if ((is_null($x_unitcode) && is_null($o_unitcode)) ||
			(($x_unitcode <> "" && $o_unitcode == $dg_unitcode) && !ChkLvlBreak(2))) {
			$dg_unitcode = "&nbsp;";
		} elseif (is_null($x_unitcode)) {
			$dg_unitcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_unitcode == "") {
			$dg_unitcode = EW_REPORT_EMPTY_LABEL;
		}
		$dg_shedcode = $x_shedcode;
		if ((is_null($x_shedcode) && is_null($o_shedcode)) ||
			(($x_shedcode <> "" && $o_shedcode == $dg_shedcode) && !ChkLvlBreak(3))) {
			$dg_shedcode = "&nbsp;";
		} elseif (is_null($x_shedcode)) {
			$dg_shedcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_shedcode == "") {
			$dg_shedcode = EW_REPORT_EMPTY_LABEL;
		}
		$dg_sheddescription = $x_sheddescription;
		if ((is_null($x_sheddescription) && is_null($o_sheddescription)) ||
			(($x_sheddescription <> "" && $o_sheddescription == $dg_sheddescription) && !ChkLvlBreak(4))) {
			$dg_sheddescription = "&nbsp;";
		} elseif (is_null($x_sheddescription)) {
			$dg_sheddescription = EW_REPORT_NULL_LABEL;
		} elseif ($x_sheddescription == "") {
			$dg_sheddescription = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_farmcode = $x_farmcode; $x_farmcode = $dg_farmcode; ?>
<?php echo ewrpt_ViewValue($x_farmcode) ?>
		<?php $x_farmcode = $t_farmcode; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_unitcode = $x_unitcode; $x_unitcode = $dg_unitcode; ?>
<?php echo ewrpt_ViewValue($x_unitcode) ?>
		<?php $x_unitcode = $t_unitcode; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_shedcode = $x_shedcode; $x_shedcode = $dg_shedcode; ?>
<?php echo ewrpt_ViewValue($x_shedcode) ?>
		<?php $x_shedcode = $t_shedcode; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_sheddescription = $x_sheddescription; $x_sheddescription = $dg_sheddescription; ?>
<?php echo ewrpt_ViewValue($x_sheddescription) ?>
		<?php $x_sheddescription = $t_sheddescription; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flockcode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flockdescription) ?>
</td>
<?php
 $qj = "select min(date2) as mindate,max(age) as age from breeder_consumption where flock = '$x_flockcode'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
		 {
                $startdate = $qrj['mindate'];
				$age = $qrj['age'];
				}
?>
<?php
 $nume = floor(($age / 7));
 $remai = $age % 7;
$agenew =  $nume.'.'.$remai;
if(($agenew == " ") || ($agenew == "0.0"))
{
$q2a = "select age,startdate from breeder_flock where flockcode = '$x_flockcode'";
$r2a = mysql_query($q2a,$conn1) or die(mysql_error());
while($qr2a = mysql_fetch_assoc($r2a))
{
$a = $qr2a['age'];
$nu = floor(($a / 7));
 $rem = $a % 7;
 $agenew = $nu.'.'.$rem;
 $age = $a;
 $startdate = $qr2a['startdate'];
}
}
 $ftransfer = 0;
           $qj = "select * from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$x_flockcode' and date <= '$startdate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $ftransfer = $ftransfer + $qrj['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
 $mtransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$x_flockcode' and date <= '$startdate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $mtransfer = $mtransfer + $qrj['quantity'];
               }
             }
             else
             {
                $mtransfer = 0;
             } 
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($agenew) ?>
</td>


		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($age) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(date($datephp,strtotime($startdate))) ?>
</td>

<?php 
$femalesum = $x_femaleopening + $ftransfer; 
$malesum = $x_maleopening + $mtransfer;
?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php if($femalesum <> "") { echo ewrpt_ViewValue(changequantity($femalesum));} else {echo "0";} $totfemalesum = $totfemalesum + $femalesum;  ?>
</td>
<?php if($reporttype<>"Layer") { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php if($malesum <> "") { echo ewrpt_ViewValue(changequantity($malesum));} else {echo "0";}  $totmalesum = $totmalesum + $malesum; ?>
</td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_farmcode = $x_farmcode;
		$o_unitcode = $x_unitcode;
		$o_shedcode = $x_shedcode;
		$o_sheddescription = $x_sheddescription;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(3)) {
?>
	
<?php

			// Reset level 3 summary
			ResetLevelSummary(3);
		} // End check level check
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	
<?php

			// Reset level 2 summary
			ResetLevelSummary(2);
		} // End check level check
?>
<?php
	} // End detail records loop
?>
<?php
?>
	
<?php

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
<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField2" colspan="2">SUM</td>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField1" align="right"><?php echo changequantity($totfemalesum);?></td>
		<td class="ewRptGrpField2" align="right"><?php echo changequantity($totmalesum);?></td>
		
	</tr>	

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
		$grandsmry[5] = $rsagg->fields("SUM_femaleopening");
		$grandsmry[6] = $rsagg->fields("SUM_maleopening");
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
	<!-- tr><td colspan="<?php if($reporttype<>"Layer") { echo 11; } else { echo 9; } ?>"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="flockreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
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
			return (is_null($GLOBALS["x_unitcode"]) && !is_null($GLOBALS["o_unitcode"])) ||
				(!is_null($GLOBALS["x_unitcode"]) && is_null($GLOBALS["o_unitcode"])) ||
				($GLOBALS["x_unitcode"] <> $GLOBALS["o_unitcode"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_shedcode"]) && !is_null($GLOBALS["o_shedcode"])) ||
				(!is_null($GLOBALS["x_shedcode"]) && is_null($GLOBALS["o_shedcode"])) ||
				($GLOBALS["x_shedcode"] <> $GLOBALS["o_shedcode"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_sheddescription"]) && !is_null($GLOBALS["o_sheddescription"])) ||
				(!is_null($GLOBALS["x_sheddescription"]) && is_null($GLOBALS["o_sheddescription"])) ||
				($GLOBALS["x_sheddescription"] <> $GLOBALS["o_sheddescription"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 2) $GLOBALS["o_unitcode"] = "";
	if ($lvl <= 3) $GLOBALS["o_shedcode"] = "";
	if ($lvl <= 4) $GLOBALS["o_sheddescription"] = "";

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
		$GLOBALS['x_flockcode'] = $rs->fields('flockcode');
		$GLOBALS['x_flockdescription'] = $rs->fields('flockdescription');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_startdate'] = $rs->fields('startdate');
		$GLOBALS['x_femaleopening'] = $rs->fields('femaleopening');
		$GLOBALS['x_maleopening'] = $rs->fields('maleopening');
		$GLOBALS['x_shedcode'] = $rs->fields('shedcode');
		$GLOBALS['x_sheddescription'] = $rs->fields('sheddescription');
		$GLOBALS['x_farmdescription'] = $rs->fields('farmdescription');
		$GLOBALS['x_unitcode'] = $rs->fields('unitcode');
		$GLOBALS['x_unitdescription'] = $rs->fields('unitdescription');
		$val[1] = $GLOBALS['x_flockcode'];
		$val[2] = $GLOBALS['x_flockdescription'];
		$val[3] = $GLOBALS['x_age'];
		$val[4] = $GLOBALS['x_startdate'];
		$val[5] = $GLOBALS['x_femaleopening'];
		$val[6] = $GLOBALS['x_maleopening'];
	} else {
		$GLOBALS['x_flockcode'] = "";
		$GLOBALS['x_flockdescription'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_startdate'] = "";
		$GLOBALS['x_femaleopening'] = "";
		$GLOBALS['x_maleopening'] = "";
		$GLOBALS['x_shedcode'] = "";
		$GLOBALS['x_sheddescription'] = "";
		$GLOBALS['x_farmdescription'] = "";
		$GLOBALS['x_unitcode'] = "";
		$GLOBALS['x_unitdescription'] = "";
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

	// Build distinct values for unitcode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_unitcode = $rswrk->fields[0];
		if (is_null($x_unitcode)) {
			$bNullValue = TRUE;
		} elseif ($x_unitcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_unitcode = $x_unitcode;
			$dg_unitcode = $x_unitcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], $g_unitcode, $dg_unitcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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

	// Build distinct values for startdate
	ewrpt_SetupDistinctValuesFromFilter($GLOBALS["val_startdate"], $GLOBALS["af_startdate"]); // Set up popup filter
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_STARTDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_STARTDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_startdate = $rswrk->fields[0];
		if (is_null($x_startdate)) {
			$bNullValue = TRUE;
		} elseif ($x_startdate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_startdate = ewrpt_FormatDateTime($x_startdate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], $x_startdate, $t_startdate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('unitcode');
			ClearSessionSelection('shedcode');
			ClearSessionSelection('startdate');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Farmcode selected values

	if (is_array(@$_SESSION["sel_flockreport_farmcode"])) {
		LoadSelectionFromSession('farmcode');
	} elseif (@$_SESSION["sel_flockreport_farmcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_farmcode"] = "";
	}

	// Get Unitcode selected values
	if (is_array(@$_SESSION["sel_flockreport_unitcode"])) {
		LoadSelectionFromSession('unitcode');
	} elseif (@$_SESSION["sel_flockreport_unitcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unitcode"] = "";
	}

	// Get Shedcode selected values
	if (is_array(@$_SESSION["sel_flockreport_shedcode"])) {
		LoadSelectionFromSession('shedcode');
	} elseif (@$_SESSION["sel_flockreport_shedcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shedcode"] = "";
	}

	// Get Startdate selected values
	if (is_array(@$_SESSION["sel_flockreport_startdate"])) {
		LoadSelectionFromSession('startdate');
	} elseif (@$_SESSION["sel_flockreport_startdate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_startdate"] = "";
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
			$nDisplayGrps = "All"; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_flockreport_$parm"] = "";
	$_SESSION["rf_flockreport_$parm"] = "";
	$_SESSION["rt_flockreport_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_flockreport_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_flockreport_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_flockreport_$parm"];
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

	// Field startdate
	// Setup your default values for the popup filter below, e.g.
	// $seld_startdate = array("val1", "val2");

	$GLOBALS["seld_startdate"] = "";
	$GLOBALS["sel_startdate"] =  $GLOBALS["seld_startdate"];

	// Field shedcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_shedcode = array("val1", "val2");

	$GLOBALS["seld_shedcode"] = "";
	$GLOBALS["sel_shedcode"] =  $GLOBALS["seld_shedcode"];

	// Field farmcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_farmcode = array("val1", "val2");

	$GLOBALS["seld_farmcode"] = "";
	$GLOBALS["sel_farmcode"] =  $GLOBALS["seld_farmcode"];

	// Field unitcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_unitcode = array("val1", "val2");

	$GLOBALS["seld_unitcode"] = "";
	$GLOBALS["sel_unitcode"] =  $GLOBALS["seld_unitcode"];
}

// Check if filter applied
function CheckFilter() {

	// Check startdate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_startdate"], $GLOBALS["sel_startdate"]))
		return TRUE;

	// Check shedcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_shedcode"], $GLOBALS["sel_shedcode"]))
		return TRUE;

	// Check farmcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_farmcode"], $GLOBALS["sel_farmcode"]))
		return TRUE;

	// Check unitcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unitcode"], $GLOBALS["sel_unitcode"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field startdate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_startdate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_startdate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Startdate<br />";
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

	// Field unitcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_unitcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_unitcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Unitcode<br />";
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
	if (is_array($GLOBALS["sel_startdate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_startdate"], "breeder_flock.startdate", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_startdate"]);
	}
	if (is_array($GLOBALS["sel_shedcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shedcode"], "breeder_flock.shedcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shedcode"], $GLOBALS["gb_shedcode"], $GLOBALS["gi_shedcode"], $GLOBALS["gq_shedcode"]);
	}
	if (is_array($GLOBALS["sel_farmcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_farmcode"], "breeder_flock.farmcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_farmcode"], $GLOBALS["gb_farmcode"], $GLOBALS["gi_farmcode"], $GLOBALS["gq_farmcode"]);
	}
	if (is_array($GLOBALS["sel_unitcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unitcode"], "breeder_flock.unitcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unitcode"], $GLOBALS["gb_unitcode"], $GLOBALS["gi_unitcode"], $GLOBALS["gq_unitcode"]);
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
			$_SESSION["sort_flockreport_farmcode"] = "";
			$_SESSION["sort_flockreport_unitcode"] = "";
			$_SESSION["sort_flockreport_shedcode"] = "";
			$_SESSION["sort_flockreport_sheddescription"] = "";
			$_SESSION["sort_flockreport_flockcode"] = "";
			$_SESSION["sort_flockreport_flockdescription"] = "";
			$_SESSION["sort_flockreport_age"] = "";
			$_SESSION["sort_flockreport_startdate"] = "";
			$_SESSION["sort_flockreport_femaleopening"] = "";
			$_SESSION["sort_flockreport_maleopening"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "breeder_flock.flockcode ASC";
		$_SESSION["sort_flockreport_flockcode"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
