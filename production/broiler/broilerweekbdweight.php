<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
$sExport = @$_GET["export"]; /*
if (@$sExport == "") { ?>
 
  <style type="text/css">
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
    </style>
<?php } ?>

<?php*/
session_start();
ob_start();
$oldfarmer = "";
$oldfarmer1 = "";
$oldflock = "";
$oldflock1 = "";
$oldtype = "";
$oldtype1 = "";
$oldsupervisor = "";
$oldsupervisor1 = "";
$olddate = "";
$olddate1 = "";
$oldage = "";
$age = "";
$previousbirdssent = 0;
if($_GET['fromdate'] <> "")
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}
else
$fromdate = $todate = date("Y-m-d");
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
<?php include "../../getemployee.php"; ?>
<?php include "reportheader.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Broiler Weekly Body Weight & FCR</font></strong></td>
</tr>
<tr>
<td> From : <?php echo date($datephp,strtotime($fromdate)); ?></td><td>&nbsp; To : <?php echo date($datephp,strtotime($todate)); ?></td>
</tr>
</table>
<center>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "weeklybodyweight", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "weeklybodyweight_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "weeklybodyweight_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "weeklybodyweight_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "weeklybodyweight_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "weeklybodyweight_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "broiler_daily_entry";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT broiler_daily_entry.place, broiler_daily_entry.supervisior, broiler_daily_entry.farm, broiler_daily_entry.entrydate, broiler_daily_entry.flock, broiler_daily_entry.birds, broiler_daily_entry.age, broiler_daily_entry.feedconsumed, broiler_daily_entry.average_weight FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "age in ('1','7','14','21','28','35','42','49','56','63','70') and cullflag = 0 and broiler_daily_entry.entrydate >= '$fromdate' and broiler_daily_entry.entrydate <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "broiler_daily_entry.place, broiler_daily_entry.supervisior, broiler_daily_entry.farm, broiler_daily_entry.entrydate, broiler_daily_entry.flock, broiler_daily_entry.birds, broiler_daily_entry.age, broiler_daily_entry.feedconsumed, broiler_daily_entry.average_weight";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "broiler_daily_entry.place ASC, broiler_daily_entry.supervisior ASC, broiler_daily_entry.farm ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "broiler_daily_entry.place", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `place` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(broiler_daily_entry.feedconsumed) AS SUM_feedconsumed FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_place = NULL; // Popup filter for place
$af_supervisior = NULL; // Popup filter for supervisior
$af_farm = NULL; // Popup filter for farm
$af_entrydate = array(); // Popup filter for entrydate
$af_entrydate[0][0] = "@@1";
$af_entrydate[0][1] = "Past";
$af_entrydate[0][2] = ewrpt_IsPast(); // Return sql part
$af_entrydate[1][0] = "@@2";
$af_entrydate[1][1] = "Future";
$af_entrydate[1][2] = ewrpt_IsFuture(); // Return sql part
$af_entrydate[2][0] = "@@3";
$af_entrydate[2][1] = "Last 30 days";
$af_entrydate[2][2] = ewrpt_IsLast30Days(); // Return sql part
$af_entrydate[3][0] = "@@4";
$af_entrydate[3][1] = "Last 14 days";
$af_entrydate[3][2] = ewrpt_IsLast14Days(); // Return sql part
$af_entrydate[4][0] = "@@5";
$af_entrydate[4][1] = "Last 7 days";
$af_entrydate[4][2] = ewrpt_IsLast7Days(); // Return sql part
$af_entrydate[5][0] = "@@6";
$af_entrydate[5][1] = "Next 7 days";
$af_entrydate[5][2] = ewrpt_IsNext7Days(); // Return sql part
$af_entrydate[6][0] = "@@7";
$af_entrydate[6][1] = "Next 14 days";
$af_entrydate[6][2] = ewrpt_IsNext14Days(); // Return sql part
$af_entrydate[7][0] = "@@8";
$af_entrydate[7][1] = "Next 30 days";
$af_entrydate[7][2] = ewrpt_IsNext30Days(); // Return sql part
$af_entrydate[8][0] = "@@9";
$af_entrydate[8][1] = "Yesterday";
$af_entrydate[8][2] = ewrpt_IsYesterday(); // Return sql part
$af_entrydate[9][0] = "@@10";
$af_entrydate[9][1] = "Today";
$af_entrydate[9][2] = ewrpt_IsToday(); // Return sql part
$af_entrydate[10][0] = "@@11";
$af_entrydate[10][1] = "Tomorrow";
$af_entrydate[10][2] = ewrpt_IsTomorrow(); // Return sql part
$af_entrydate[11][0] = "@@12";
$af_entrydate[11][1] = "Last month";
$af_entrydate[11][2] = ewrpt_IsLastMonth(); // Return sql part
$af_entrydate[12][0] = "@@13";
$af_entrydate[12][1] = "This month";
$af_entrydate[12][2] = ewrpt_IsThisMonth(); // Return sql part
$af_entrydate[13][0] = "@@14";
$af_entrydate[13][1] = "Next month";
$af_entrydate[13][2] = ewrpt_IsNextMonth(); // Return sql part
$af_entrydate[14][0] = "@@15";
$af_entrydate[14][1] = "Last two weeks";
$af_entrydate[14][2] = ewrpt_IsLast2Weeks(); // Return sql part
$af_entrydate[15][0] = "@@16";
$af_entrydate[15][1] = "Last week";
$af_entrydate[15][2] = ewrpt_IsLastWeek(); // Return sql part
$af_entrydate[16][0] = "@@17";
$af_entrydate[16][1] = "This week";
$af_entrydate[16][2] = ewrpt_IsThisWeek(); // Return sql part
$af_entrydate[17][0] = "@@18";
$af_entrydate[17][1] = "Next week";
$af_entrydate[17][2] = ewrpt_IsNextWeek(); // Return sql part
$af_entrydate[18][0] = "@@19";
$af_entrydate[18][1] = "Next two weeks";
$af_entrydate[18][2] = ewrpt_IsNext2Weeks(); // Return sql part
$af_entrydate[19][0] = "@@20";
$af_entrydate[19][1] = "Last year";
$af_entrydate[19][2] = ewrpt_IsLastYear(); // Return sql part
$af_entrydate[20][0] = "@@21";
$af_entrydate[20][1] = "This year";
$af_entrydate[20][2] = ewrpt_IsThisYear(); // Return sql part
$af_entrydate[21][0] = "@@22";
$af_entrydate[21][1] = "Next year";
$af_entrydate[21][2] = ewrpt_IsNextYear(); // Return sql part
$af_flock = NULL; // Popup filter for flock
$af_birds = NULL; // Popup filter for birds
$af_age = NULL; // Popup filter for age
$af_feedconsumed = NULL; // Popup filter for feedconsumed
$af_average_weight = NULL; // Popup filter for average_weight
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
//
$oldage = "";
$oldfarmer = "";
$oldflock = "";
$age = "";
$oldsupervisor = "";
// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = "All"; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_PLACE_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.place FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PLACE_SQL_ORDERBY = "broiler_daily_entry.place";
$EW_REPORT_FIELD_SUPERVISIOR_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.supervisior FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SUPERVISIOR_SQL_ORDERBY = "broiler_daily_entry.supervisior";
$EW_REPORT_FIELD_FARM_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.farm FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FARM_SQL_ORDERBY = "broiler_daily_entry.farm";
$EW_REPORT_FIELD_ENTRYDATE_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.entrydate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_ENTRYDATE_SQL_ORDERBY = "broiler_daily_entry.entrydate";
?>
<?php

// Field variables
$x_place = NULL;
$x_supervisior = NULL;
$x_farm = NULL;
$x_entrydate = NULL;
$x_flock = NULL;
$x_birds = NULL;
$x_age = NULL;
$x_feedconsumed = NULL;
$x_average_weight = NULL;

// Group variables
$o_place = NULL; $g_place = NULL; $dg_place = NULL; $t_place = NULL; $ft_place = 200; $gf_place = $ft_place; $gb_place = ""; $gi_place = "0"; $gq_place = ""; $rf_place = NULL; $rt_place = NULL;
$o_supervisior = NULL; $g_supervisior = NULL; $dg_supervisior = NULL; $t_supervisior = NULL; $ft_supervisior = 200; $gf_supervisior = $ft_supervisior; $gb_supervisior = ""; $gi_supervisior = "0"; $gq_supervisior = ""; $rf_supervisior = NULL; $rt_supervisior = NULL;
$o_farm = NULL; $g_farm = NULL; $dg_farm = NULL; $t_farm = NULL; $ft_farm = 200; $gf_farm = $ft_farm; $gb_farm = ""; $gi_farm = "0"; $gq_farm = ""; $rf_farm = NULL; $rt_farm = NULL;

// Detail variables
$o_entrydate = NULL; $t_entrydate = NULL; $ft_entrydate = 133; $rf_entrydate = NULL; $rt_entrydate = NULL;
$o_flock = NULL; $t_flock = NULL; $ft_flock = 200; $rf_flock = NULL; $rt_flock = NULL;
$o_birds = NULL; $t_birds = NULL; $ft_birds = 5; $rf_birds = NULL; $rt_birds = NULL;
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_feedconsumed = NULL; $t_feedconsumed = NULL; $ft_feedconsumed = 5; $rf_feedconsumed = NULL; $rt_feedconsumed = NULL;
$o_average_weight = NULL; $t_average_weight = NULL; $ft_average_weight = 5; $rf_average_weight = NULL; $rt_average_weight = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 7;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_place = "";
$seld_place = "";
$val_place = "";
$sel_supervisior = "";
$seld_supervisior = "";
$val_supervisior = "";
$sel_farm = "";
$seld_farm = "";
$val_farm = "";
$sel_entrydate = "";
$seld_entrydate = "";
$val_entrydate = "";

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
<?php $jsdata = ewrpt_GetJsData($val_place, $sel_place, $ft_place) ?>
ewrpt_CreatePopup("weeklybodyweight_place", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_supervisior, $sel_supervisior, $ft_supervisior) ?>
ewrpt_CreatePopup("weeklybodyweight_supervisior", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_farm, $sel_farm, $ft_farm) ?>
ewrpt_CreatePopup("weeklybodyweight_farm", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_entrydate, $sel_entrydate, $ft_entrydate) ?>
ewrpt_CreatePopup("weeklybodyweight_entrydate", [<?php echo $jsdata ?>]);
</script>
<div id="weeklybodyweight_place_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="weeklybodyweight_supervisior_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="weeklybodyweight_farm_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="weeklybodyweight_entrydate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" align="center" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="broilerweekbdweight.php?export=html&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="broilerweekbdweight.php?export=excel&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="broilerweekbdweight.php?export=word&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broilerweekbdweight.php?cmd=reset">Reset All Filters</a>
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
<center>
<div id="report_summary">
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" align="center" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<center>
<form action="broilerweekbdweight.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table>
 <tr>
 <td>From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage('');"/></td>
  <td>To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage('');"/></td>
</tr>
</table>
<table border="0" cellspacing="0" align="center" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<center>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel" align="center">

<table class="ewTable ewTableSeparate" cellspacing="0" align="center">
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
		Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" align="center"><tr>
			<td>Place</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'weeklybodyweight_place', false, '<?php echo $rf_place; ?>', '<?php echo $rt_place; ?>');return false;" name="x_place<?php echo $cnt[0][0]; ?>" id="x_place<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Supervisior
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supervisior</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'weeklybodyweight_supervisior', false, '<?php echo $rf_supervisior; ?>', '<?php echo $rt_supervisior; ?>');return false;" name="x_supervisior<?php echo $cnt[0][0]; ?>" id="x_supervisior<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Farm
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farm</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'weeklybodyweight_farm', false, '<?php echo $rf_farm; ?>', '<?php echo $rt_farm; ?>');return false;" name="x_farm<?php echo $cnt[0][0]; ?>" id="x_farm<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Entrydate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Entrydate</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'weeklybodyweight_entrydate', true, '<?php echo $rf_entrydate; ?>', '<?php echo $rt_entrydate; ?>');return false;" name="x_entrydate<?php echo $cnt[0][0]; ?>" id="x_entrydate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
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
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php 
if($_SESSION['db'] == 'central')
{
if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer <br /> Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer <br /> Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer<br />Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer<br /> Weight</td>
			</tr></table>
		</td>
<?php } }?>
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
		Feedconsumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feedconsumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Average Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Average Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>F.C.R</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_place, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_place, EW_REPORT_DATATYPE_STRING, $gb_place, $gi_place, $gq_place);
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
		$dg_place = $x_place;
		if ((is_null($x_place) && is_null($o_place)) ||
			(($x_place <> "" && $o_place == $dg_place) && !ChkLvlBreak(1))) {
			$dg_place = "&nbsp;";
		} elseif (is_null($x_place)) {
			$dg_place = EW_REPORT_NULL_LABEL;
		} elseif ($x_place == "") {
			$dg_place = EW_REPORT_EMPTY_LABEL;
		}
		$dg_supervisior = $x_supervisior;
		if ((is_null($x_supervisior) && is_null($o_supervisior)) ||
			(($x_supervisior <> "" && $o_supervisior == $dg_supervisior) && !ChkLvlBreak(2))) {
			$dg_supervisior = "&nbsp;";
		} elseif (is_null($x_supervisior)) {
			$dg_supervisior = EW_REPORT_NULL_LABEL;
		} elseif ($x_supervisior == "") {
			$dg_supervisior = EW_REPORT_EMPTY_LABEL;
		}
		$dg_farm = $x_farm;
		if ((is_null($x_farm) && is_null($o_farm)) ||
			(($x_farm <> "" && $o_farm == $dg_farm) && !ChkLvlBreak(3))) {
			$dg_farm = "&nbsp;";
		} elseif (is_null($x_farm)) {
			$dg_farm = EW_REPORT_NULL_LABEL;
		} elseif ($x_farm == "") {
			$dg_farm = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_place = $x_place; $x_place = $dg_place; ?>
<?php echo ewrpt_ViewValue($x_place) ?>
		<?php $x_place = $t_place; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_supervisior = $x_supervisior; $x_supervisior = $dg_supervisior; ?>
<?php echo ewrpt_ViewValue($x_supervisior) ?>
		<?php $x_supervisior = $t_supervisior; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_farm = $x_farm; $x_farm = $dg_farm; ?>
<?php echo ewrpt_ViewValue($x_farm) ?>
		<?php $x_farm = $t_farm; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php if(date("d.m.Y",strtotime($x_entrydate)) <> "01.01.1970") echo ewrpt_ViewValue(date($datephp,strtotime($x_entrydate))); else echo ewrpt_ViewValue(); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flock) ?>
</td>
<?php 
   include "../config.php";
$sentbirds =0;
  $sentweight = 0;
  if ( $oldfarmer == $x_farm and $flock == $x_flock )
{ 
  $birds = 0;
  
  $query111a = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$x_flock' and towarehouse = '$x_farm' AND cat = 'Broiler Chicks'"; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
  if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { $birds = $birds + $row111a['chicks'];  } }

  if(($birds == "") OR ($birds == 0))
  {
   $query111a = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$x_flock' and warehouse = '$x_farm' and category = 'Broiler Chicks' "; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds + $row111a['chicks'];  } }
  }
  $x = "0"; $mortcumm = $mortcumm + $x_mortality; $cummfeed = $cummfeed + $x_feedconsumed; $oldfarmer = $x_farm; $flock = $x_flock;
  //if ($birds == "") { $birds = $birds - $x_mortality; } else { $birds = $birds - $x_mortality; }
  $birds = $birds - $mortcumm;
  
  if($_SESSION[db]=='mallikarjunkld')
   {
  $query111a = "SELECT birds as chicks from broiler_chickentransfer where flock = '$x_flock' "; $result111a = mysql_query(   $query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds - $row111a['chicks'];  } }
  }
  
  if($_SESSION['db'] == 'central')
{
 $sentquery = "SELECT birds,weight from broiler_chickentransfer where flock = '$x_flock' and date = '$x_entrydate' ";
  $sentresult = mysql_query($sentquery,$conn1); 
  while($sentres = mysql_fetch_assoc($sentresult))
  {   $birds = $birds - $sentres['birds']; 
      $sentbirds += $sentres['birds']; 
	  $previousbirdssent += $sentres['birds'];
	  $sentweight+=$sentres['weight']; 
  } 
  }
  
}
else
{
 $x = "1"; include "../config.php"; $b = 0; $birds = 0;
 $query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$x_flock' and towarehouse = '$x_farm' and date = '$x_entrydate'  "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $birds = $birds + $row111['chicks']; } }

 if(($birds == "") OR ($birds == 0))
 {
  $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$x_flock' and warehouse = '$x_farm' and adate = '$x_entrydate' and category = 'Broiler Chicks'  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $birds = $birds + $row111['chicks'];  } }
 }
 else
  {
    $birds = $birds;
  }

 $birds = $birds - $x_mortality;
 $oldfarmer = $x_farm;
 $flock = $x_flock;
 $mortcumm = "0";
 $cummfeed = "0";
 $mortcumm = $mortcumm + $x_mortality;
 $cummfeed = $cummfeed + $x_feedconsumed;
 $birds = $birds - $mortcum;
 
 if($_SESSION[db]=='mallikarjunkld')
   {
  $query111a = "SELECT birds as chicks from broiler_chickentransfer where flock = '$x_flock' "; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds - $row111a['chicks'];  } }
  }
 
 if($_SESSION['db'] == 'central')
{
 $sentquery = "SELECT birds,weight from broiler_chickentransfer where flock = '$x_flock' and date = '$x_entrydate' ";
  $sentresult = mysql_query($sentquery,$conn1); 
  while($sentres = mysql_fetch_assoc($sentresult))
  {   $birds = $birds - $sentres['birds']; 
      $sentbirds += $sentres['birds']; 
	  $previousbirdssent += $sentres['birds'];
	  $sentweight+=$sentres['weight']; 
  } 
  }
 
 
 
}
?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($birds) ?>
</td>

<?php 
if($_SESSION['db'] == 'central')
{?>
	<td<?php echo $sItemRowClass; ?>>
<?php echo $sentbirds; ?>
</td> 
<td<?php echo $sItemRowClass; ?>>
<?php echo $sentweight; ?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_age) ?>
</td>
<?php

$feedconsumed = "0"; 
              $query = "SELECT sum(feedconsumed) as feedconsumed FROM broiler_daily_entry where farm = '$x_farm' and flock = '$x_flock' and age <= '$x_age'  ";
              $result = mysql_query($query,$conn1); 
              while($row1 = mysql_fetch_assoc($result))
              {
                $feedconsumed = $feedconsumed + $row1['feedconsumed'];
              }   
			  $maxweight = "0"; 
              $query = "SELECT max(average_weight) as weight FROM broiler_daily_entry where farm = '$x_farm' and flock = '$x_flock' and age <= '$x_age'  ";
              $result = mysql_query($query,$conn1); 
              while($row1 = mysql_fetch_assoc($result))
              {
                $maxweight = $row1['weight'];
              }   
?>		

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($feedconsumed) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($maxweight) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($feedconsumed / ((ewrpt_ViewValue($maxweight) / 1000) * $birds), 2)) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_place = $x_place;
		$o_supervisior = $x_supervisior;
		$o_farm = $x_farm;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(3)) {
?>
	<!--<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td <?php if($_SESSION['db'] == 'central'){ ?> colspan="10" <?php } else {?> colspan="8"<?php }?> class="ewRptGrpSummary3">Summary for Farm: <?php $t_farm = $x_farm; $x_farm = $o_farm; ?>
<?php echo ewrpt_ViewValue($x_farm) ?>
<?php $x_farm = $t_farm; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="2" class="ewRptGrpSummary3"></td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<?php 
         if($_SESSION['db'] == 'central')
         {
		 $previousbirdssent = 0;
		 ?>
		 
		 <td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<?php }?>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">
		<?php $t_feedconsumed = $x_feedconsumed; ?>
		<?php $x_feedconsumed = $smry[3][5]; // Load SUM ?>
<?php #echo ewrpt_ViewValue($x_feedconsumed) ?>
		<?php $x_feedconsumed = $t_feedconsumed; ?>
		</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
	</tr>-->
<?php

			// Reset level 3 summary
			ResetLevelSummary(3);
		} // End check level check
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_place = $x_place; // Save old group value
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
		$grandsmry[5] = $rsagg->fields("SUM_feedconsumed");
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
	<tr class="ewRptGrandSummary"><td colspan="9">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="broilerweekbdweight.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="broilerweekbdweight.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_place"]) && !is_null($GLOBALS["o_place"])) ||
				(!is_null($GLOBALS["x_place"]) && is_null($GLOBALS["o_place"])) ||
				($GLOBALS["x_place"] <> $GLOBALS["o_place"]);
		case 2:
			return (is_null($GLOBALS["x_supervisior"]) && !is_null($GLOBALS["o_supervisior"])) ||
				(!is_null($GLOBALS["x_supervisior"]) && is_null($GLOBALS["o_supervisior"])) ||
				($GLOBALS["x_supervisior"] <> $GLOBALS["o_supervisior"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_farm"]) && !is_null($GLOBALS["o_farm"])) ||
				(!is_null($GLOBALS["x_farm"]) && is_null($GLOBALS["o_farm"])) ||
				($GLOBALS["x_farm"] <> $GLOBALS["o_farm"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_place"] = "";
	if ($lvl <= 2) $GLOBALS["o_supervisior"] = "";
	if ($lvl <= 3) $GLOBALS["o_farm"] = "";

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
		$GLOBALS['x_place'] = "";
	} else {
		$GLOBALS['x_place'] = $rsgrp->fields('place');
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
		$GLOBALS['x_supervisior'] = $rs->fields('supervisior');
		$GLOBALS['x_farm'] = $rs->fields('farm');
		$GLOBALS['x_entrydate'] = $rs->fields('entrydate');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_birds'] = $rs->fields('birds');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_feedconsumed'] = $rs->fields('feedconsumed');
		$GLOBALS['x_average_weight'] = $rs->fields('average_weight');
		$val[1] = $GLOBALS['x_entrydate'];
		$val[2] = $GLOBALS['x_flock'];
		$val[3] = $GLOBALS['x_birds'];
		$val[4] = $GLOBALS['x_age'];
		$val[5] = $GLOBALS['x_feedconsumed'];
		$val[6] = $GLOBALS['x_average_weight'];
	} else {
		$GLOBALS['x_supervisior'] = "";
		$GLOBALS['x_farm'] = "";
		$GLOBALS['x_entrydate'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_birds'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_feedconsumed'] = "";
		$GLOBALS['x_average_weight'] = "";
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
	// Build distinct values for place

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_PLACE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_PLACE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_place = $rswrk->fields[0];
		if (is_null($x_place)) {
			$bNullValue = TRUE;
		} elseif ($x_place == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_place = $x_place;
			$dg_place = $x_place;
			ewrpt_SetupDistinctValues($GLOBALS["val_place"], $g_place, $dg_place, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_place"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_place"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for supervisior
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SUPERVISIOR_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SUPERVISIOR_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_supervisior = $rswrk->fields[0];
		if (is_null($x_supervisior)) {
			$bNullValue = TRUE;
		} elseif ($x_supervisior == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_supervisior = $x_supervisior;
			$dg_supervisior = $x_supervisior;
			ewrpt_SetupDistinctValues($GLOBALS["val_supervisior"], $g_supervisior, $dg_supervisior, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_supervisior"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_supervisior"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for farm
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FARM_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FARM_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_farm = $rswrk->fields[0];
		if (is_null($x_farm)) {
			$bNullValue = TRUE;
		} elseif ($x_farm == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_farm = $x_farm;
			$dg_farm = $x_farm;
			ewrpt_SetupDistinctValues($GLOBALS["val_farm"], $g_farm, $dg_farm, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farm"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farm"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for entrydate
	ewrpt_SetupDistinctValuesFromFilter($GLOBALS["val_entrydate"], $GLOBALS["af_entrydate"]); // Set up popup filter
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_ENTRYDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_ENTRYDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_entrydate = $rswrk->fields[0];
		if (is_null($x_entrydate)) {
			$bNullValue = TRUE;
		} elseif ($x_entrydate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_entrydate = ewrpt_FormatDateTime($x_entrydate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], $x_entrydate, $t_entrydate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('place');
			ClearSessionSelection('supervisior');
			ClearSessionSelection('farm');
			ClearSessionSelection('entrydate');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Place selected values

	if (is_array(@$_SESSION["sel_weeklybodyweight_place"])) {
		LoadSelectionFromSession('place');
	} elseif (@$_SESSION["sel_weeklybodyweight_place"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_place"] = "";
	}

	// Get Supervisior selected values
	if (is_array(@$_SESSION["sel_weeklybodyweight_supervisior"])) {
		LoadSelectionFromSession('supervisior');
	} elseif (@$_SESSION["sel_weeklybodyweight_supervisior"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_supervisior"] = "";
	}

	// Get Farm selected values
	if (is_array(@$_SESSION["sel_weeklybodyweight_farm"])) {
		LoadSelectionFromSession('farm');
	} elseif (@$_SESSION["sel_weeklybodyweight_farm"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_farm"] = "";
	}

	// Get Entrydate selected values
	if (is_array(@$_SESSION["sel_weeklybodyweight_entrydate"])) {
		LoadSelectionFromSession('entrydate');
	} elseif (@$_SESSION["sel_weeklybodyweight_entrydate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_entrydate"] = "";
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
				$nDisplayGrps = "-1"; // Non-numeric, load default
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
	$_SESSION["sel_weeklybodyweight_$parm"] = "";
	$_SESSION["rf_weeklybodyweight_$parm"] = "";
	$_SESSION["rt_weeklybodyweight_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_weeklybodyweight_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_weeklybodyweight_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_weeklybodyweight_$parm"];
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

	// Field place
	// Setup your default values for the popup filter below, e.g.
	// $seld_place = array("val1", "val2");

	$GLOBALS["seld_place"] = "";
	$GLOBALS["sel_place"] =  $GLOBALS["seld_place"];

	// Field supervisior
	// Setup your default values for the popup filter below, e.g.
	// $seld_supervisior = array("val1", "val2");

	$GLOBALS["seld_supervisior"] = "";
	$GLOBALS["sel_supervisior"] =  $GLOBALS["seld_supervisior"];

	// Field farm
	// Setup your default values for the popup filter below, e.g.
	// $seld_farm = array("val1", "val2");

	$GLOBALS["seld_farm"] = "";
	$GLOBALS["sel_farm"] =  $GLOBALS["seld_farm"];

	// Field entrydate
	// Setup your default values for the popup filter below, e.g.
	// $seld_entrydate = array("val1", "val2");

	$GLOBALS["seld_entrydate"] = "";
	$GLOBALS["sel_entrydate"] =  $GLOBALS["seld_entrydate"];
}

// Check if filter applied
function CheckFilter() {

	// Check place popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_place"], $GLOBALS["sel_place"]))
		return TRUE;

	// Check supervisior popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_supervisior"], $GLOBALS["sel_supervisior"]))
		return TRUE;

	// Check farm popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_farm"], $GLOBALS["sel_farm"]))
		return TRUE;

	// Check entrydate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_entrydate"], $GLOBALS["sel_entrydate"]))

		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field place
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_place"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_place"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Place<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field supervisior
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_supervisior"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_supervisior"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Supervisior<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field farm
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_farm"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_farm"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Farm<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field entrydate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_entrydate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_entrydate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Entrydate<br />";
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
	if (is_array($GLOBALS["sel_place"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_place"], "broiler_daily_entry.place", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_place"], $GLOBALS["gb_place"], $GLOBALS["gi_place"], $GLOBALS["gq_place"]);
	}
	if (is_array($GLOBALS["sel_supervisior"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_supervisior"], "broiler_daily_entry.supervisior", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_supervisior"], $GLOBALS["gb_supervisior"], $GLOBALS["gi_supervisior"], $GLOBALS["gq_supervisior"]);
	}
	if (is_array($GLOBALS["sel_farm"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_farm"], "broiler_daily_entry.farm", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_farm"], $GLOBALS["gb_farm"], $GLOBALS["gi_farm"], $GLOBALS["gq_farm"]);
	}
	if (is_array($GLOBALS["sel_entrydate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_entrydate"], "broiler_daily_entry.entrydate", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_entrydate"]);
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
			$_SESSION["sort_weeklybodyweight_place"] = "";
			$_SESSION["sort_weeklybodyweight_supervisior"] = "";
			$_SESSION["sort_weeklybodyweight_farm"] = "";
			$_SESSION["sort_weeklybodyweight_entrydate"] = "";
			$_SESSION["sort_weeklybodyweight_flock"] = "";
			$_SESSION["sort_weeklybodyweight_birds"] = "";
			$_SESSION["sort_weeklybodyweight_age"] = "";
			$_SESSION["sort_weeklybodyweight_feedconsumed"] = "";
			$_SESSION["sort_weeklybodyweight_average_weight"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "broiler_daily_entry.entrydate ASC";
		$_SESSION["sort_weeklybodyweight_entrydate"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>

<script type="text/javascript">

function reloadpage(a)
{
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;
document.location = 'broilerweekbdweight.php?export=' + a + '&fromdate=' + fdate + '&todate=' + tdate;
}
</script>