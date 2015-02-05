<center>
<?php
session_start();
ob_start();
include "reportheader.php";
include "config.php";
$url = "&type=".$_GET['type']."&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];
$url1 = "?type=".$_GET['type']."&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
$g_noofeggsset = $g_rejections = $g_hatch = $g_culls = $g_saleablechicks = 0;
for($i = 0; $i < 10; $i++)
{
$hreggs[$i] = 0;
$sreggs[$i] = 0;
$treggs[$i] = 0;
}

$gdih = 0;
$lbtype = $_GET['type']; 
if($lbtype == "all")
$lc = "<>";
else
$lc = "=";
?>
</center>
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
define("EW_REPORT_TABLE_VAR", "quail_hatchery_hatchrecord1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "quail_hatchery_hatchrecord1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "quail_hatchery_hatchrecord1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "quail_hatchery_hatchrecord1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "quail_hatchery_hatchrecord1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "quail_hatchery_hatchrecord1_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "quail_hatchery_hatchrecord";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT quail_hatchery_hatchrecord.hetype,quail_hatchery_hatchrecord.hatchdate, quail_hatchery_hatchrecord.settingno, quail_hatchery_hatchrecord.unit, quail_hatchery_hatchrecord.shed, quail_hatchery_hatchrecord.flock, quail_hatchery_hatchrecord.noofeggsset, quail_hatchery_hatchrecord.code, quail_hatchery_hatchrecord.rejections, quail_hatchery_hatchrecord.percentage, quail_hatchery_hatchrecord.totalrejections, quail_hatchery_hatchrecord.hatch, quail_hatchery_hatchrecord.hatchper, quail_hatchery_hatchrecord.culls, quail_hatchery_hatchrecord.cullsper, quail_hatchery_hatchrecord.saleablechicks, quail_hatchery_hatchrecord.saleableper, quail_hatchery_hatchrecord.avgweight, quail_hatchery_hatchrecord.waterlossper, quail_hatchery_hatchrecord.before12, quail_hatchery_hatchrecord.before24, quail_hatchery_hatchrecord.hatchery FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "'$fromdate' <= quail_hatchery_hatchrecord.hatchdate and quail_hatchery_hatchrecord.hatchdate <= '$todate' and quail_hatchery_hatchrecord.hetype $lc '$lbtype'";
$EW_REPORT_TABLE_SQL_GROUPBY = "quail_hatchery_hatchrecord.hatchdate, quail_hatchery_hatchrecord.settingno, quail_hatchery_hatchrecord.unit, quail_hatchery_hatchrecord.shed, quail_hatchery_hatchrecord.flock, quail_hatchery_hatchrecord.noofeggsset, quail_hatchery_hatchrecord.code, quail_hatchery_hatchrecord.rejections, quail_hatchery_hatchrecord.percentage, quail_hatchery_hatchrecord.totalrejections, quail_hatchery_hatchrecord.hatch, quail_hatchery_hatchrecord.hatchper, quail_hatchery_hatchrecord.culls, quail_hatchery_hatchrecord.cullsper, quail_hatchery_hatchrecord.saleablechicks, quail_hatchery_hatchrecord.saleableper, quail_hatchery_hatchrecord.avgweight, quail_hatchery_hatchrecord.waterlossper, quail_hatchery_hatchrecord.before12, quail_hatchery_hatchrecord.before24";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "quail_hatchery_hatchrecord.hatchdate ASC, quail_hatchery_hatchrecord.settingno ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "quail_hatchery_hatchrecord.hatchdate", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `hatchdate` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(quail_hatchery_hatchrecord.noofeggsset) AS SUM_noofeggsset, SUM(quail_hatchery_hatchrecord.totalrejections) AS SUM_totalrejections, SUM(quail_hatchery_hatchrecord.hatch) AS SUM_hatch, SUM(quail_hatchery_hatchrecord.culls) AS SUM_culls, SUM(quail_hatchery_hatchrecord.saleablechicks) AS SUM_saleablechicks FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_hatchdate = NULL; // Popup filter for hatchdate
$af_settingno = NULL; // Popup filter for settingno
$af_unit = NULL; // Popup filter for unit
$af_shed = NULL; // Popup filter for shed
$af_flock = NULL; // Popup filter for flock
$af_noofeggsset = NULL; // Popup filter for noofeggsset
$af_code = NULL; // Popup filter for code
$af_rejections = NULL; // Popup filter for rejections
$af_percentage = NULL; // Popup filter for percentage
$af_totalrejections = NULL; // Popup filter for totalrejections
$af_hatch = NULL; // Popup filter for hatch
$af_hatchper = NULL; // Popup filter for hatchper
$af_culls = NULL; // Popup filter for culls
$af_cullsper = NULL; // Popup filter for cullsper
$af_saleablechicks = NULL; // Popup filter for saleablechicks
$af_saleableper = NULL; // Popup filter for saleableper
$af_avgweight = NULL; // Popup filter for avgweight
$af_waterlossper = NULL; // Popup filter for waterlossper
$af_before12 = NULL; // Popup filter for before12
$af_before24 = NULL; // Popup filter for before24
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
$EW_REPORT_FIELD_HATCHDATE_SQL_SELECT = "SELECT DISTINCT quail_hatchery_hatchrecord.hatchdate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_HATCHDATE_SQL_ORDERBY = "quail_hatchery_hatchrecord.hatchdate";
$EW_REPORT_FIELD_SETTINGNO_SQL_SELECT = "SELECT DISTINCT quail_hatchery_hatchrecord.settingno FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SETTINGNO_SQL_ORDERBY = "quail_hatchery_hatchrecord.settingno";
$EW_REPORT_FIELD_UNIT_SQL_SELECT = "SELECT DISTINCT quail_hatchery_hatchrecord.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNIT_SQL_ORDERBY = "quail_hatchery_hatchrecord.unit";
$EW_REPORT_FIELD_SHED_SQL_SELECT = "SELECT DISTINCT quail_hatchery_hatchrecord.shed FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHED_SQL_ORDERBY = "quail_hatchery_hatchrecord.shed";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT quail_hatchery_hatchrecord.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "quail_hatchery_hatchrecord.flock";
?>
<?php

// Field variables
$x_hatchery = NULL;
$x_hetype = NULL;
$x_hatchdate = NULL;
$x_settingno = NULL;
$x_unit = NULL;
$x_shed = NULL;
$x_flock = NULL;
$x_noofeggsset = NULL;
$x_code = NULL;
$x_rejections = NULL;
$x_percentage = NULL;
$x_totalrejections = NULL;
$x_hatch = NULL;
$x_hatchper = NULL;
$x_culls = NULL;
$x_cullsper = NULL;
$x_saleablechicks = NULL;
$x_saleableper = NULL;
$x_avgweight = NULL;
$x_waterlossper = NULL;
$x_before12 = NULL;
$x_before24 = NULL;

// Group variables
$o_hatchdate = NULL; $g_hatchdate = NULL; $dg_hatchdate = NULL; $t_hatchdate = NULL; $ft_hatchdate = 133; $gf_hatchdate = $ft_hatchdate; $gb_hatchdate = ""; $gi_hatchdate = "0"; $gq_hatchdate = ""; $rf_hatchdate = NULL; $rt_hatchdate = NULL;
$o_settingno = NULL; $g_settingno = NULL; $dg_settingno = NULL; $t_settingno = NULL; $ft_settingno = 200; $gf_settingno = $ft_settingno; $gb_settingno = ""; $gi_settingno = "0"; $gq_settingno = ""; $rf_settingno = NULL; $rt_settingno = NULL;

$o_hatchery = NULL; $g_hatchery = NULL; $dg_hatchery = NULL; $t_hatchery = NULL;

// Detail variables
$o_unit = NULL; $t_unit = NULL; $ft_unit = 200; $rf_unit = NULL; $rt_unit = NULL;
$o_shed = NULL; $t_shed = NULL; $ft_shed = 200; $rf_shed = NULL; $rt_shed = NULL;
$o_flock = NULL; $t_flock = NULL; $ft_flock = 200; $rf_flock = NULL; $rt_flock = NULL;
$o_noofeggsset = NULL; $t_noofeggsset = NULL; $ft_noofeggsset = 3; $rf_noofeggsset = NULL; $rt_noofeggsset = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_rejections = NULL; $t_rejections = NULL; $ft_rejections = 200; $rf_rejections = NULL; $rt_rejections = NULL;
$o_percentage = NULL; $t_percentage = NULL; $ft_percentage = 200; $rf_percentage = NULL; $rt_percentage = NULL;
$o_totalrejections = NULL; $t_totalrejections = NULL; $ft_totalrejections = 5; $rf_totalrejections = NULL; $rt_totalrejections = NULL;
$o_hatch = NULL; $t_hatch = NULL; $ft_hatch = 3; $rf_hatch = NULL; $rt_hatch = NULL;
$o_hatchper = NULL; $t_hatchper = NULL; $ft_hatchper = 5; $rf_hatchper = NULL; $rt_hatchper = NULL;
$o_culls = NULL; $t_culls = NULL; $ft_culls = 3; $rf_culls = NULL; $rt_culls = NULL;
$o_cullsper = NULL; $t_cullsper = NULL; $ft_cullsper = 5; $rf_cullsper = NULL; $rt_cullsper = NULL;
$o_saleablechicks = NULL; $t_saleablechicks = NULL; $ft_saleablechicks = 3; $rf_saleablechicks = NULL; $rt_saleablechicks = NULL;
$o_saleableper = NULL; $t_saleableper = NULL; $ft_saleableper = 5; $rf_saleableper = NULL; $rt_saleableper = NULL;
$o_avgweight = NULL; $t_avgweight = NULL; $ft_avgweight = 5; $rf_avgweight = NULL; $rt_avgweight = NULL;
$o_waterlossper = NULL; $t_waterlossper = NULL; $ft_waterlossper = 5; $rf_waterlossper = NULL; $rt_waterlossper = NULL;
$o_before12 = NULL; $t_before12 = NULL; $ft_before12 = 5; $rf_before12 = NULL; $rt_before12 = NULL;
$o_before24 = NULL; $t_before24 = NULL; $ft_before24 = 5; $rf_before24 = NULL; $rt_before24 = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 19;
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
$col = array(FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_hatchdate = "";
$seld_hatchdate = "";
$val_hatchdate = "";
$sel_settingno = "";
$seld_settingno = "";
$val_settingno = "";
$sel_unit = "";
$seld_unit = "";
$val_unit = "";
$sel_shed = "";
$seld_shed = "";
$val_shed = "";
$sel_flock = "";
$seld_flock = "";
$val_flock = "";

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
<?php $jsdata = ewrpt_GetJsData($val_hatchdate, $sel_hatchdate, $ft_hatchdate) ?>
ewrpt_CreatePopup("quail_hatchery_hatchrecord1_hatchdate", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_settingno, $sel_settingno, $ft_settingno) ?>
ewrpt_CreatePopup("quail_hatchery_hatchrecord1_settingno", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unit, $sel_unit, $ft_unit) ?>
ewrpt_CreatePopup("quail_hatchery_hatchrecord1_unit", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shed, $sel_shed, $ft_shed) ?>
ewrpt_CreatePopup("quail_hatchery_hatchrecord1_shed", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("quail_hatchery_hatchrecord1_flock", [<?php echo $jsdata ?>]);
</script>
<div id="quail_hatchery_hatchrecord1_hatchdate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_hatchery_hatchrecord1_settingno_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_hatchery_hatchrecord1_unit_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_hatchery_hatchrecord1_shed_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_hatchery_hatchrecord1_flock_Popup" class="ewPopup">
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
<table align="center" border="0">
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Hatchery Hatch Record</font></strong></td>
</tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">From Date&nbsp;</font></strong><?php echo $_GET['fromdate']; ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date &nbsp;</font></strong><?php echo $_GET['todate'];?></font></td>
</tr>
</table>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="quail_hatchery_hatchrecord2smry.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_hatchery_hatchrecord2smry.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_hatchery_hatchrecord2smry.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_hatchery_hatchrecord2smry.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
<?php } ?>
<br /><br />
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
<center>
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="quail_hatchery_hatchrecord2smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
	<span class="phpreportmaker"></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
		Hatchery
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Hatchery</td>
			</tr></table>
		</td>
<?php } ?>
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Setting<br/>No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Setting<br/>No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
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
		No. of<br/>Eggs Set
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>No. of<br/>Eggs Set</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Saleable<br/>Chicks
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Saleable<br/>Chicks</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Saleable<br/>%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Saleable<br/>%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Culls %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Culls %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Hatch
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Hatch</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Hatch %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Hatch %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dead<br/>In<br/>Hatch
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dead<br/>In<br/>Hatch</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Dead<br/>In<br/>Hatch&nbsp;%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dead<br/>In<br/>Hatch&nbsp;%</td>
			</tr></table>
		</td>
<?php } ?>

<?php 
 $q = "select distinct(code),description from ims_itemcodes where iusage = 'Rejected' or iusage = 'Produced or Sale or Rejected' order by code DESC";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
		<td valign="bottom" class="ewTableHeader">
		<?php echo $qr['description']; ?>
		</td>
		<td valign="bottom" class="ewTableHeader">
		<?php echo $qr['description'] . " %" ; ?>
		</td>
<?php
}
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total<br/>Rejections
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total<br/>Rejections</td>
			</tr></table>
		</td>
<?php } ?>





<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Avg.<br/>Chick<br/>Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Avg.<br/>Chick<br/>Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<!--<td valign="bottom" class="ewTableHeader">
		Water Loss %
		</td>-->
<?php } else { ?>
		<!--<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Water Loss %</td>
			</tr></table>
		</td>-->
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<!--<td valign="bottom" class="ewTableHeader">
		Before 12
		</td>-->
<?php } else { ?>
		<!--<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Before 12</td>
			</tr></table>
		</td>-->
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<!--<td valign="bottom" class="ewTableHeader">
		Before 24
		</td>-->
<?php } else { ?>
		<!--<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Before 24</td>
			</tr></table>
		</td>-->
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	// }

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_hatchdate, EW_REPORT_DATATYPE_DATE);
$query = "SELECT * FROM quail_hatchery_hatchrecord ORDER BY hatchdate";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_hatchdate, EW_REPORT_DATATYPE_DATE, $gb_hatchdate, $gi_hatchdate, $gq_hatchdate);
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
		$dg_hatchdate = $x_hatchdate;
		if ((is_null($x_hatchdate) && is_null($o_hatchdate)) ||
			(($x_hatchdate <> "" && $o_hatchdate == $dg_hatchdate) && !ChkLvlBreak(1))) {
			$dg_hatchdate = "&nbsp;";
		} elseif (is_null($x_hatchdate)) {
			$dg_hatchdate = EW_REPORT_NULL_LABEL;
		} elseif ($x_hatchdate == "") {
			$dg_hatchdate = EW_REPORT_EMPTY_LABEL;
		}
		$dg_settingno = $x_settingno;
		if ((is_null($x_settingno) && is_null($o_settingno)) ||
			(($x_settingno <> "" && $o_settingno == $dg_settingno) && !ChkLvlBreak(2))) {
			$dg_settingno = "&nbsp;";
		} elseif (is_null($x_settingno)) {
			$dg_settingno = EW_REPORT_NULL_LABEL;
		} elseif ($x_settingno == "") {
			$dg_settingno = EW_REPORT_EMPTY_LABEL;
		}
		$dg_hatchery = $x_hatchery;
		if ((is_null($x_hatchery) && is_null($o_hatchery)) ||
			(($x_hatchery <> "" && $o_hatchery == $dg_hatchery) && !ChkLvlBreak(2))) {
			$dg_hatchery = "&nbsp;";
		} elseif (is_null($x_hatchery)) {
			$dg_hatchery = EW_REPORT_NULL_LABEL;
		} elseif ($x_hatchery == "") {
			$dg_hatchery = EW_REPORT_EMPTY_LABEL;
		} 
?>
	<tr>
	
		<td class="ewRptGrpField1">
		<?php $t_hatchdate = $x_hatchdate; $x_hatchdate = $dg_hatchdate; ?>
<?php echo ewrpt_ViewValue(date($datephp,strtotime($rows['hatchdate']))); ?>
		<?php $x_hatchdate = $t_hatchdate; ?></td>
		
		<td class="ewRptGrpField1">
		<?php $t_hatchery = $x_hatchery; $x_hatchery = $dg_hatchery; ?>
<?php echo ewrpt_ViewValue($rows['hatchery']) ?>
		<?php $x_hatchery = $t_hatchery; ?></td>

		<td  class="ewRptGrpField1">
<?php echo ewrpt_ViewValue(ucfirst($rows['hetype'])) ?>
</td>
<td class="ewRptGrpField2">
		<?php $t_settingno = $x_settingno; $x_settingno = $dg_settingno; ?>
<?php echo ewrpt_ViewValue($rows['settingno']) ?>
		<?php $x_settingno = $t_settingno; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['unit']) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['shed']) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($rows['flock']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['noofeggsset']) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($rows['saleablechicks'],2)) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($rows['saleableper'],2)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['culls']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['cullsper']) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['hatch']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($rows['hatchper'],2)) ?>
</td>
<?php 
$dih = 0;
$dihper = 0;
$sdih = 0;
$sdihper = 0;
$q = "select * from quail_hatchery_hatchrecord where settingno = '$rows[settingno]' order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
 $dih = $qr['dih'];
 $dihper = $qr['dihper'];
}

$q = "select sum(dih) as sdih from quail_hatchery_hatchrecord where hatchdate = '$rows[hatchdate]'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
 $sdih = $qr['sdih'];
}

$q = "select sum(dih) as gdih from quail_hatchery_hatchrecord  where hatchdate = '$rows[hatchdate]'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
 $gdih = $qr['gdih'];
}

?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($dih) ?>
</td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($dihper,2)) ?>
</td>		
<?php
$rc = explode(",",$x_code);
$rq = explode(",",$x_rejections);
$rp = explode(",",$x_percentage);

$q = "select distinct(code),description from ims_itemcodes where iusage = 'Rejected' or iusage = 'Produced or Sale or Rejected' order by code DESC";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$count = mysql_num_rows($qrs);
$j = 0;
while($qr = mysql_fetch_assoc($qrs))
{
$reggs = 0;
$reggsp = 0;
for($i = 0; $i < count($rc); $i++)
if($rc[$i] == $qr['code'])
{
$reggs = $rq[$i];
$reggsp = $rp[$i];
$sreggs[$j]+= $rq[$i];
break; 
}

?>
		<td<?php echo $sItemRowClass; ?> align="right">
		<?php echo $reggs; ?>
		</td>
		<td<?php echo $sItemRowClass; ?> align="right">
		<?php echo round($reggsp,2); ?>
		</td>
<?php
$j++;
}
?>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['totalrejections']) ?>
</td>
		
		

		
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['avgweight']) ?>
</td>
		<!--<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['waterlossper']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['before12']) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($rows['before24']) ?>
</td>-->
	</tr>
<?php
	}
		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_hatchdate = $x_hatchdate;
		$o_settingno = $x_settingno;
		$o_hatchery = $x_hatchery;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="<?php echo 19 + $count *2 ; ?>" class="ewRptGrpSummary2">Summary for Settingno: <?php $t_settingno = $x_settingno; $x_settingno = $o_settingno; ?>
<?php echo ewrpt_ViewValue($x_settingno) ?>
<?php $x_settingno = $t_settingno; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<!--<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="1" class="ewRptGrpSummary2">SUM</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2" align="right">-->
		<?php $t_noofeggsset = $x_noofeggsset; ?>
		<?php $x_noofeggsset = $smry[2][4]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_noofeggsset); ?>
		<?php $x_noofeggsset = $t_noofeggsset; ?>
		<!--</td>
		<td class="ewRptGrpSummary2" align="right">-->
		<?php $t_saleablechicks = $x_saleablechicks; ?>
		<?php $x_saleablechicks = $smry[2][13]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_saleablechicks) ?>
		<?php $x_saleablechicks = $t_saleablechicks; ?>
		<!--</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2" align="right">-->
		<?php $t_culls = $x_culls; ?>
		<?php $x_culls = $smry[2][11]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_culls) ?>
		<?php $x_culls = $t_culls; ?>
		<!--</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2" align="right">-->
		<?php $t_hatch = $x_hatch; ?>
		<?php $x_hatch = $smry[2][9]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_hatch) ?>
		<?php $x_hatch = $t_hatch; ?>
		<!--</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>-->
		<?php for($i = 0; $i < $count; $i++) { ?>
		<!--<td class="ewRptGrpSummary2" align="right">--><?php //echo $sreggs[$i]; 
		$hreggs[$i]+= $sreggs[$i]; $sreggs[$i] = 0;?><!--</td>
		<td class="ewRptGrpSummary2"></td>-->
		<?php } ?>
		
		<!--<td class="ewRptGrpSummary2" align="right">-->
		<?php $t_totalrejections = $x_totalrejections; ?>
		<?php $x_totalrejections = $smry[2][8]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_totalrejections) ?>
		<?php $x_totalrejections = $t_totalrejections; ?>
		<!--</td>
		
		
		
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
	</tr>-->
<?php

			// Reset level 2 summary
			ResetLevelSummary(2);
		} // End check level check
?>
<?php
	// } // End detail records loop
?>
<?php
?>
	<tr style="display:none">
		<td colspan="<?php echo 18 + $count * 2; ?>" class="ewRptGrpSummary1">Summary for Hatchdate: <?php $t_hatchdate = $x_hatchdate; $x_hatchdate = $o_hatchdate; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_hatchdate,7)) ?>
<?php $x_hatchdate = $t_hatchdate; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<!--<tr>
		<td colspan="2" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">-->
		<?php $t_noofeggsset = $x_noofeggsset; ?>
		<?php $x_noofeggsset = $h_noofeggsset = $smry[1][4]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_noofeggsset); 
$g_noofeggsset+= $x_noofeggsset; ?>
		<?php $x_noofeggsset = $t_noofeggsset; ?>
		<!--</td>
		<td class="ewRptGrpSummary1" align="right">-->
		<?php $t_saleablechicks = $x_saleablechicks; ?>
		<?php $x_saleablechicks = $h_saleablechicks = $smry[1][13]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_saleablechicks); 
$g_saleablechicks+= $x_saleablechicks; ?>
		<?php $x_saleablechicks = $t_saleablechicks; ?>
		<!--</td>
		<td class="ewRptGrpSummary1" align="right"><?php echo round((($h_saleablechicks/$h_noofeggsset)*100),2); ?></td>
		<td class="ewRptGrpSummary1" align="right">-->
		<?php $t_culls = $x_culls; ?>
		<?php $x_culls = $h_culls = $smry[1][11]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_culls); 
$g_culls+= $x_culls; ?>
		<?php $x_culls = $t_culls; ?>
		<!--</td>
		<td class="ewRptGrpSummary1" align="right"><?php echo round((($h_culls/$h_noofeggsset)*100),2); ?></td>
		<td class="ewRptGrpSummary1" align="right">-->
		<?php $t_hatch = $x_hatch; ?>
		<?php $x_hatch = $h_hatch = $smry[1][9]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_hatch); 
$g_hatch+= $x_hatch; ?>
		<?php $x_hatch = $t_hatch; ?>
		<!--</td>
		<td class="ewRptGrpSummary1" align="right"><?php echo round((($h_hatch/$h_noofeggsset)*100),2); ?></td>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sdih; ?></td>
		<td class="ewRptGrpSummary1" align="right"><?php echo round((($sdih/$h_noofeggsset)*100),2); ?></td>-->
		<?php for($i = 0; $i < $count; $i++) { ?>
		<!--<td class="ewRptGrpSummary1" align="right"><?php echo $hreggs[$i]; ?></td>
		<td class="ewRptGrpSummary1" align="right">--><?php //echo round((($hreggs[$i]/$h_noofeggsset)*100),2); 
		$treggs[$i] += $hreggs[$i]; $hreggs[$i] = 0;?><!--</td>-->
		<?php } ?>
		<!--<td class="ewRptGrpSummary1" align="right">-->
		<?php $t_totalrejections = $x_totalrejections; ?>
		<?php $x_totalrejections = $smry[1][8]; // Load SUM ?>
<?php //echo ewrpt_ViewValue($x_totalrejections);
 $g_totalrejections+= $x_totalrejections; ?>
		<?php $x_totalrejections = $t_totalrejections; ?>
		<!--</td>
		
		
		
		
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>-->
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_hatchdate = $x_hatchdate; // Save old group value
	$o_hatchery = $x_hatchery;
	GetGrpRow(2);
	$nGrpCount++;
// } // End while
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
		$grandsmry[4] = $rsagg->fields("SUM_noofeggsset");
		$grandsmry[8] = $rsagg->fields("SUM_totalrejections");
		$grandsmry[9] = $rsagg->fields("SUM_hatch");
		$grandsmry[11] = $rsagg->fields("SUM_culls");
		$grandsmry[13] = $rsagg->fields("SUM_saleablechicks");
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
	<!-- tr><td colspan="20"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="20">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" height="35px">
		<td colspan="2" class="ewRptGrpAggregate">GRAND TOTAL</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right">
		<?php $t_noofeggsset = $x_noofeggsset; ?>
		<?php $x_noofeggsset = $grandsmry[4]; // Load SUM ?>
<?php echo $g_noofeggsset; #ewrpt_ViewValue($x_noofeggsset) ?>
		<?php $x_noofeggsset = $t_noofeggsset; ?>
		</td>
		<td align="right">
		<?php $t_saleablechicks = $x_saleablechicks; ?>
		<?php $x_saleablechicks = $grandsmry[13]; // Load SUM ?>
<?php echo $g_saleablechicks; #ewrpt_ViewValue($x_saleablechicks) ?>
		<?php $x_saleablechicks = $t_saleablechicks; ?>
		</td>
		<td align="right"><?php echo round((($g_saleablechicks/$g_noofeggsset)*100),2); ?></td>
		<td align="right">
		<?php $t_culls = $x_culls; ?>
		<?php $x_culls = $grandsmry[11]; // Load SUM ?>
<?php echo $g_culls; #ewrpt_ViewValue($x_culls) ?>
		<?php $x_culls = $t_culls; ?>
		</td>
		<td align="right"><?php echo round((($g_culls/$g_noofeggsset)*100),2); ?></td>
		<td align="right">
		<?php $t_hatch = $x_hatch; ?>
		<?php $x_hatch = $grandsmry[9]; // Load SUM ?>
<?php echo $g_hatch#ewrpt_ViewValue($x_hatch) ?>
		<?php $x_hatch = $t_hatch; ?>
		</td>
		<td align="right"><?php echo round((($g_hatch/$g_noofeggsset)*100),2); ?></td>
		<td align="right"><?php echo $gdih; ?></td>
		<td align="right"><?php echo round((($gdih/$g_noofeggsset)*100),2); ?></td>
		
		<?php for($i = 0; $i < $count; $i++) { ?>
		<td align="right"><?php echo $treggs[$i]; ?></td>
		<td align="right"><?php echo round((($treggs[$i]/$g_noofeggsset)*100),2); $treggs[$i] = 0;?></td>
		<?php } ?>
		<td align="right">
		<?php $t_totalrejections = $x_totalrejections; ?>
		<?php $x_totalrejections = $grandsmry[8]; // Load SUM ?>
<?php echo $g_totalrejections; #ewrpt_ViewValue($x_totalrejections) ?>
		<?php $x_totalrejections = $t_totalrejections; ?>
		</td>
		
		
		
		<td>&nbsp;</td>
		<!--<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>-->
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="quail_hatchery_hatchrecord2smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="quail_hatchery_hatchrecord2smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_hatchdate"]) && !is_null($GLOBALS["o_hatchdate"])) ||
				(!is_null($GLOBALS["x_hatchdate"]) && is_null($GLOBALS["o_hatchdate"])) ||
				($GLOBALS["x_hatchdate"] <> $GLOBALS["o_hatchdate"]);
		case 2:
			return (is_null($GLOBALS["x_settingno"]) && !is_null($GLOBALS["o_settingno"])) ||
				(!is_null($GLOBALS["x_settingno"]) && is_null($GLOBALS["o_settingno"])) ||
				($GLOBALS["x_settingno"] <> $GLOBALS["o_settingno"]) || ChkLvlBreak(1); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_hatchdate"] = "";
	if ($lvl <= 2) $GLOBALS["o_settingno"] = "";

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
		$GLOBALS['x_hatchdate'] = "";
	} else {
		$GLOBALS['x_hatchdate'] = $rsgrp->fields('hatchdate');
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
	$GLOBALS['x_hetype'] = $rs->fields('hetype');
	$GLOBALS['x_hatchery'] = $rs->fields('hatchery');
		$GLOBALS['x_settingno'] = $rs->fields('settingno');
		$GLOBALS['x_unit'] = $rs->fields('unit');
		$GLOBALS['x_shed'] = $rs->fields('shed');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_noofeggsset'] = $rs->fields('noofeggsset');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_rejections'] = $rs->fields('rejections');
		$GLOBALS['x_percentage'] = $rs->fields('percentage');
		$GLOBALS['x_totalrejections'] = $rs->fields('totalrejections');
		$GLOBALS['x_hatch'] = $rs->fields('hatch');
		$GLOBALS['x_hatchper'] = $rs->fields('hatchper');
		$GLOBALS['x_culls'] = $rs->fields('culls');
		$GLOBALS['x_cullsper'] = $rs->fields('cullsper');
		$GLOBALS['x_saleablechicks'] = $rs->fields('saleablechicks');
		$GLOBALS['x_saleableper'] = $rs->fields('saleableper');
		$GLOBALS['x_avgweight'] = $rs->fields('avgweight');
		$GLOBALS['x_waterlossper'] = $rs->fields('waterlossper');
		$GLOBALS['x_before12'] = $rs->fields('before12');
		$GLOBALS['x_before24'] = $rs->fields('before24');
		$val[1] = $GLOBALS['x_unit'];
		$val[2] = $GLOBALS['x_shed'];
		$val[3] = $GLOBALS['x_flock'];
		$val[4] = $GLOBALS['x_noofeggsset'];
		$val[5] = $GLOBALS['x_code'];
		$val[6] = $GLOBALS['x_rejections'];
		$val[7] = $GLOBALS['x_percentage'];
		$val[8] = $GLOBALS['x_totalrejections'];
		$val[9] = $GLOBALS['x_hatch'];
		$val[10] = $GLOBALS['x_hatchper'];
		$val[11] = $GLOBALS['x_culls'];
		$val[12] = $GLOBALS['x_cullsper'];
		$val[13] = $GLOBALS['x_saleablechicks'];
		$val[14] = $GLOBALS['x_saleableper'];
		$val[15] = $GLOBALS['x_avgweight'];
		$val[16] = $GLOBALS['x_waterlossper'];
		$val[17] = $GLOBALS['x_before12'];
		$val[18] = $GLOBALS['x_before24'];
	} else {
		$GLOBALS['x_hetype'] = "";
		$GLOBALS['x_settingno'] = "";
		$GLOBALS['x_hatchery'] = "";
		$GLOBALS['x_unit'] = "";
		$GLOBALS['x_shed'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_noofeggsset'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_rejections'] = "";
		$GLOBALS['x_percentage'] = "";
		$GLOBALS['x_totalrejections'] = "";
		$GLOBALS['x_hatch'] = "";
		$GLOBALS['x_hatchper'] = "";
		$GLOBALS['x_culls'] = "";
		$GLOBALS['x_cullsper'] = "";
		$GLOBALS['x_saleablechicks'] = "";
		$GLOBALS['x_saleableper'] = "";
		$GLOBALS['x_avgweight'] = "";
		$GLOBALS['x_waterlossper'] = "";
		$GLOBALS['x_before12'] = "";
		$GLOBALS['x_before24'] = "";
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
	// Build distinct values for hatchdate

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_HATCHDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_HATCHDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_hatchdate = $rswrk->fields[0];
		if (is_null($x_hatchdate)) {
			$bNullValue = TRUE;
		} elseif ($x_hatchdate == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_hatchdate = $x_hatchdate;
			$dg_hatchdate = ewrpt_FormatDateTime($x_hatchdate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_hatchdate"], $g_hatchdate, $dg_hatchdate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_hatchdate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_hatchdate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for settingno
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SETTINGNO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SETTINGNO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_settingno = $rswrk->fields[0];
		if (is_null($x_settingno)) {
			$bNullValue = TRUE;
		} elseif ($x_settingno == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_settingno = $x_settingno;
			$dg_settingno = $x_settingno;
			ewrpt_SetupDistinctValues($GLOBALS["val_settingno"], $g_settingno, $dg_settingno, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_settingno"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_settingno"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			$t_unit = $x_unit;
			ewrpt_SetupDistinctValues($GLOBALS["val_unit"], $x_unit, $t_unit, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unit"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unit"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for shed
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SHED_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SHED_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_shed = $rswrk->fields[0];
		if (is_null($x_shed)) {
			$bNullValue = TRUE;
		} elseif ($x_shed == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_shed = $x_shed;
			ewrpt_SetupDistinctValues($GLOBALS["val_shed"], $x_shed, $t_shed, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shed"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shed"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			$t_flock = $x_flock;
			ewrpt_SetupDistinctValues($GLOBALS["val_flock"], $x_flock, $t_flock, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('hatchdate');
			ClearSessionSelection('settingno');
			ClearSessionSelection('unit');
			ClearSessionSelection('shed');
			ClearSessionSelection('flock');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Hatchdate selected values

	if (is_array(@$_SESSION["sel_quail_hatchery_hatchrecord1_hatchdate"])) {
		LoadSelectionFromSession('hatchdate');
	} elseif (@$_SESSION["sel_quail_hatchery_hatchrecord1_hatchdate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_hatchdate"] = "";
	}

	// Get Settingno selected values
	if (is_array(@$_SESSION["sel_quail_hatchery_hatchrecord1_settingno"])) {
		LoadSelectionFromSession('settingno');
	} elseif (@$_SESSION["sel_quail_hatchery_hatchrecord1_settingno"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_settingno"] = "";
	}

	// Get Unit selected values
	if (is_array(@$_SESSION["sel_quail_hatchery_hatchrecord1_unit"])) {
		LoadSelectionFromSession('unit');
	} elseif (@$_SESSION["sel_quail_hatchery_hatchrecord1_unit"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unit"] = "";
	}

	// Get Shed selected values
	if (is_array(@$_SESSION["sel_quail_hatchery_hatchrecord1_shed"])) {
		LoadSelectionFromSession('shed');
	} elseif (@$_SESSION["sel_quail_hatchery_hatchrecord1_shed"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shed"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_quail_hatchery_hatchrecord1_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_quail_hatchery_hatchrecord1_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
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
	$_SESSION["sel_quail_hatchery_hatchrecord1_$parm"] = "";
	$_SESSION["rf_quail_hatchery_hatchrecord1_$parm"] = "";
	$_SESSION["rt_quail_hatchery_hatchrecord1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_quail_hatchery_hatchrecord1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_quail_hatchery_hatchrecord1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_quail_hatchery_hatchrecord1_$parm"];
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

	// Field hatchdate
	// Setup your default values for the popup filter below, e.g.
	// $seld_hatchdate = array("val1", "val2");

	$GLOBALS["seld_hatchdate"] = "";
	$GLOBALS["sel_hatchdate"] =  $GLOBALS["seld_hatchdate"];

	// Field settingno
	// Setup your default values for the popup filter below, e.g.
	// $seld_settingno = array("val1", "val2");

	$GLOBALS["seld_settingno"] = "";
	$GLOBALS["sel_settingno"] =  $GLOBALS["seld_settingno"];

	// Field unit
	// Setup your default values for the popup filter below, e.g.
	// $seld_unit = array("val1", "val2");

	$GLOBALS["seld_unit"] = "";
	$GLOBALS["sel_unit"] =  $GLOBALS["seld_unit"];

	// Field shed
	// Setup your default values for the popup filter below, e.g.
	// $seld_shed = array("val1", "val2");

	$GLOBALS["seld_shed"] = "";
	$GLOBALS["sel_shed"] =  $GLOBALS["seld_shed"];

	// Field flock
	// Setup your default values for the popup filter below, e.g.
	// $seld_flock = array("val1", "val2");

	$GLOBALS["seld_flock"] = "";
	$GLOBALS["sel_flock"] =  $GLOBALS["seld_flock"];
}

// Check if filter applied
function CheckFilter() {

	// Check hatchdate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_hatchdate"], $GLOBALS["sel_hatchdate"]))
		return TRUE;

	// Check settingno popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_settingno"], $GLOBALS["sel_settingno"]))
		return TRUE;

	// Check unit popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unit"], $GLOBALS["sel_unit"]))
		return TRUE;

	// Check shed popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_shed"], $GLOBALS["sel_shed"]))
		return TRUE;

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field hatchdate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_hatchdate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_hatchdate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Hatchdate<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field settingno
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_settingno"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_settingno"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Settingno<br />";
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

	// Field shed
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_shed"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_shed"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Shed<br />";
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
	if (is_array($GLOBALS["sel_hatchdate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_hatchdate"], "quail_hatchery_hatchrecord.hatchdate", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_hatchdate"], $GLOBALS["gb_hatchdate"], $GLOBALS["gi_hatchdate"], $GLOBALS["gq_hatchdate"]);
	}
	if (is_array($GLOBALS["sel_settingno"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_settingno"], "quail_hatchery_hatchrecord.settingno", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_settingno"], $GLOBALS["gb_settingno"], $GLOBALS["gi_settingno"], $GLOBALS["gq_settingno"]);
	}
	if (is_array($GLOBALS["sel_unit"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unit"], "quail_hatchery_hatchrecord.unit", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unit"]);
	}
	if (is_array($GLOBALS["sel_shed"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shed"], "quail_hatchery_hatchrecord.shed", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shed"]);
	}
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "quail_hatchery_hatchrecord.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"]);
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
			$_SESSION["sort_quail_hatchery_hatchrecord1_hatchdate"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_settingno"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_unit"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_shed"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_flock"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_noofeggsset"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_code"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_rejections"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_percentage"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_totalrejections"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_hatch"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_hatchper"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_culls"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_cullsper"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_saleablechicks"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_saleableper"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_avgweight"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_waterlossper"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_before12"] = "";
			$_SESSION["sort_quail_hatchery_hatchrecord1_before24"] = "";
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
