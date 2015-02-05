<center>
<?php
session_start();
ob_start();
include "reportheader.php";
include "config.php";
$url = "&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];
$url1 = "?fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
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
define("EW_REPORT_TABLE_VAR", "hatchery_loadingdetails1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "hatchery_loadingdetails1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "hatchery_loadingdetails1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "hatchery_loadingdetails1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "hatchery_loadingdetails1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "hatchery_loadingdetails1_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hatchery_loadingdetails";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hatchery_loadingdetails.grade, hatchery_loadingdetails.unit, hatchery_loadingdetails.shed, hatchery_loadingdetails.flock, hatchery_loadingdetails.date, hatchery_loadingdetails.time, hatchery_loadingdetails.settingno, hatchery_loadingdetails.setterno, hatchery_loadingdetails.partitionno, hatchery_loadingdetails.eggsset, hatchery_loadingdetails.eggspertray, hatchery_loadingdetails.eggweight, hatchery_loadingdetails.avgegg, hatchery_loadingdetails.loadedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "'$fromdate' <= hatchery_loadingdetails.date and hatchery_loadingdetails.date <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "hatchery_loadingdetails.grade, hatchery_loadingdetails.unit, hatchery_loadingdetails.shed, hatchery_loadingdetails.flock, hatchery_loadingdetails.date, hatchery_loadingdetails.time, hatchery_loadingdetails.settingno, hatchery_loadingdetails.setterno, hatchery_loadingdetails.partitionno, hatchery_loadingdetails.eggsset, hatchery_loadingdetails.eggspertray, hatchery_loadingdetails.eggweight, hatchery_loadingdetails.avgegg, hatchery_loadingdetails.loadedby";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hatchery_loadingdetails.grade ASC, hatchery_loadingdetails.date ASC, hatchery_loadingdetails.settingno ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "hatchery_loadingdetails.grade", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `grade` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hatchery_loadingdetails.eggsset) AS SUM_eggsset FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_grade = NULL; // Popup filter for grade
$af_unit = NULL; // Popup filter for unit
$af_shed = NULL; // Popup filter for shed
$af_flock = NULL; // Popup filter for flock
$af_date = NULL; // Popup filter for date
$af_time = NULL; // Popup filter for time
$af_settingno = NULL; // Popup filter for settingno
$af_setterno = NULL; // Popup filter for setterno
$af_partitionno = NULL; // Popup filter for partitionno
$af_eggsset = NULL; // Popup filter for eggsset
$af_eggspertray = NULL; // Popup filter for eggspertray
$af_eggweight = NULL; // Popup filter for eggweight
$af_avgegg = NULL; // Popup filter for avgegg
$af_loadedby = NULL; // Popup filter for loadedby
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
$EW_REPORT_FIELD_GRADE_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.grade FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_GRADE_SQL_ORDERBY = "hatchery_loadingdetails.grade";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "hatchery_loadingdetails.date";
$EW_REPORT_FIELD_SETTINGNO_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.settingno FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SETTINGNO_SQL_ORDERBY = "hatchery_loadingdetails.settingno";
$EW_REPORT_FIELD_UNIT_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNIT_SQL_ORDERBY = "hatchery_loadingdetails.unit";
$EW_REPORT_FIELD_SHED_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.shed FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHED_SQL_ORDERBY = "hatchery_loadingdetails.shed";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT hatchery_loadingdetails.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "hatchery_loadingdetails.flock";
?>
<?php

// Field variables
$x_grade = NULL;
$x_unit = NULL;
$x_shed = NULL;
$x_flock = NULL;
$x_date = NULL;
$x_time = NULL;
$x_settingno = NULL;
$x_setterno = NULL;
$x_partitionno = NULL;
$x_eggsset = NULL;
$x_eggspertray = NULL;
$x_eggweight = NULL;
$x_avgegg = NULL;
$x_loadedby = NULL;

// Group variables
$o_grade = NULL; $g_grade = NULL; $dg_grade = NULL; $t_grade = NULL; $ft_grade = 200; $gf_grade = $ft_grade; $gb_grade = ""; $gi_grade = "0"; $gq_grade = ""; $rf_grade = NULL; $rt_grade = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_settingno = NULL; $g_settingno = NULL; $dg_settingno = NULL; $t_settingno = NULL; $ft_settingno = 200; $gf_settingno = $ft_settingno; $gb_settingno = ""; $gi_settingno = "0"; $gq_settingno = ""; $rf_settingno = NULL; $rt_settingno = NULL;

// Detail variables
$o_unit = NULL; $t_unit = NULL; $ft_unit = 200; $rf_unit = NULL; $rt_unit = NULL;
$o_shed = NULL; $t_shed = NULL; $ft_shed = 200; $rf_shed = NULL; $rt_shed = NULL;
$o_flock = NULL; $t_flock = NULL; $ft_flock = 200; $rf_flock = NULL; $rt_flock = NULL;
$o_time = NULL; $t_time = NULL; $ft_time = 200; $rf_time = NULL; $rt_time = NULL;
$o_setterno = NULL; $t_setterno = NULL; $ft_setterno = 200; $rf_setterno = NULL; $rt_setterno = NULL;
$o_partitionno = NULL; $t_partitionno = NULL; $ft_partitionno = 200; $rf_partitionno = NULL; $rt_partitionno = NULL;
$o_eggsset = NULL; $t_eggsset = NULL; $ft_eggsset = 5; $rf_eggsset = NULL; $rt_eggsset = NULL;
$o_eggspertray = NULL; $t_eggspertray = NULL; $ft_eggspertray = 5; $rf_eggspertray = NULL; $rt_eggspertray = NULL;
$o_eggweight = NULL; $t_eggweight = NULL; $ft_eggweight = 5; $rf_eggweight = NULL; $rt_eggweight = NULL;
$o_avgegg = NULL; $t_avgegg = NULL; $ft_avgegg = 5; $rf_avgegg = NULL; $rt_avgegg = NULL;
$o_loadedby = NULL; $t_loadedby = NULL; $ft_loadedby = 200; $rf_loadedby = NULL; $rt_loadedby = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 12;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_grade = "";
$seld_grade = "";
$val_grade = "";
$sel_date = "";
$seld_date = "";
$val_date = "";
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
<?php $jsdata = ewrpt_GetJsData($val_grade, $sel_grade, $ft_grade) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_grade", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_settingno, $sel_settingno, $ft_settingno) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_settingno", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unit, $sel_unit, $ft_unit) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_unit", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shed, $sel_shed, $ft_shed) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_shed", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("hatchery_loadingdetails1_flock", [<?php echo $jsdata ?>]);
</script>
<div id="hatchery_loadingdetails1_grade_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_loadingdetails1_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_loadingdetails1_settingno_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_loadingdetails1_unit_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_loadingdetails1_shed_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_loadingdetails1_flock_Popup" class="ewPopup">
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
<center><strong>Hatchery Loading Details(From <?php echo $_GET['fromdate']; ?> To <?php echo $_GET['todate']; ?>)</strong></center>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="hatchery_loadingdetails1smry.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatchery_loadingdetails1smry.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatchery_loadingdetails1smry.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatchery_loadingdetails1smry.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
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
<div id="report_summary">
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="hatchery_loadingdetails1smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<td valign="bottom" class="ewTableHeader">
		Grade
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Grade</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_grade', false, '<?php echo $rf_grade; ?>', '<?php echo $rt_grade; ?>');return false;" name="x_grade<?php echo $cnt[0][0]; ?>" id="x_grade<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Setting No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Setting No.</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_settingno', false, '<?php echo $rf_settingno; ?>', '<?php echo $rt_settingno; ?>');return false;" name="x_settingno<?php echo $cnt[0][0]; ?>" id="x_settingno<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_unit', false, '<?php echo $rf_unit; ?>', '<?php echo $rt_unit; ?>');return false;" name="x_unit<?php echo $cnt[0][0]; ?>" id="x_unit<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_shed', false, '<?php echo $rf_shed; ?>', '<?php echo $rt_shed; ?>');return false;" name="x_shed<?php echo $cnt[0][0]; ?>" id="x_shed<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_loadingdetails1_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Time
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Time</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Setter No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Setter No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Partition No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Partition No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Eggs Loaded
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Eggs Loaded</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		No. Of Trays
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>No. Of Trays</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Egg Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Egg Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Avg. Egg Weight 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Avg. Egg Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Loaded By
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Loaded By</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_grade, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_grade, EW_REPORT_DATATYPE_STRING, $gb_grade, $gi_grade, $gq_grade);
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
		$dg_grade = $x_grade;
		if ((is_null($x_grade) && is_null($o_grade)) ||
			(($x_grade <> "" && $o_grade == $dg_grade) && !ChkLvlBreak(1))) {
			$dg_grade = "&nbsp;";
		} elseif (is_null($x_grade)) {
			$dg_grade = EW_REPORT_NULL_LABEL;
		} elseif ($x_grade == "") {
			$dg_grade = EW_REPORT_EMPTY_LABEL;
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
		$dg_settingno = $x_settingno;
		if ((is_null($x_settingno) && is_null($o_settingno)) ||
			(($x_settingno <> "" && $o_settingno == $dg_settingno) && !ChkLvlBreak(3))) {
			$dg_settingno = "&nbsp;";
		} elseif (is_null($x_settingno)) {
			$dg_settingno = EW_REPORT_NULL_LABEL;
		} elseif ($x_settingno == "") {
			$dg_settingno = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_grade = $x_grade; $x_grade = $dg_grade; ?>
<?php echo ewrpt_ViewValue($x_grade) ?>
		<?php $x_grade = $t_grade; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
		<?php $x_date = $t_date; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_settingno = $x_settingno; $x_settingno = $dg_settingno; ?>
<?php echo ewrpt_ViewValue($x_settingno) ?>
		<?php $x_settingno = $t_settingno; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_unit) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_shed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flock) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_time) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_setterno) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_partitionno) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_eggsset) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_eggspertray) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_eggweight) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_avgegg) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_loadedby) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_grade = $x_grade;
		$o_date = $x_date;
		$o_settingno = $x_settingno;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(3)) {
?>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="12" class="ewRptGrpSummary3">Summary for Settingno: <?php $t_settingno = $x_settingno; $x_settingno = $o_settingno; ?>
<?php echo ewrpt_ViewValue($x_settingno) ?>
<?php $x_settingno = $t_settingno; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="1" class="ewRptGrpSummary3">SUM</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3" align="right">
		<?php $t_eggsset = $x_eggsset; ?>
		<?php $x_eggsset = $smry[3][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_eggsset) ?>
		<?php $x_eggsset = $t_eggsset; ?>
		</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
	</tr>
<?php

			// Reset level 3 summary
			ResetLevelSummary(3);
		} // End check level check
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="13" class="ewRptGrpSummary2">Summary for Date: <?php $t_date = $x_date; $x_date = $o_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
<?php $x_date = $t_date; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="2" class="ewRptGrpSummary2">SUM</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2" align="right">
		<?php $t_eggsset = $x_eggsset; ?>
		<?php $x_eggsset = $smry[2][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_eggsset) ?>
		<?php $x_eggsset = $t_eggsset; ?>
		</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
	</tr>
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
	<tr style="display:none">
		<td colspan="14" class="ewRptGrpSummary1">Summary for Grade: <?php $t_grade = $x_grade; $x_grade = $o_grade; ?>
<?php echo ewrpt_ViewValue($x_grade) ?>
<?php $x_grade = $t_grade; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="3" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_eggsset = $x_eggsset; ?>
		<?php $x_eggsset = $smry[1][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_eggsset) ?>
		<?php $x_eggsset = $t_eggsset; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_grade = $x_grade; // Save old group value
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
		$grandsmry[7] = $rsagg->fields("SUM_eggsset");
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
	<!-- tr><td colspan="14"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="14">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="3" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_eggsset = $x_eggsset; ?>
		<?php $x_eggsset = $grandsmry[7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_eggsset) ?>
		<?php $x_eggsset = $t_eggsset; ?>
		</td>
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
<form action="hatchery_loadingdetails1smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatchery_loadingdetails1smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_grade"]) && !is_null($GLOBALS["o_grade"])) ||
				(!is_null($GLOBALS["x_grade"]) && is_null($GLOBALS["o_grade"])) ||
				($GLOBALS["x_grade"] <> $GLOBALS["o_grade"]);
		case 2:
			return (is_null($GLOBALS["x_date"]) && !is_null($GLOBALS["o_date"])) ||
				(!is_null($GLOBALS["x_date"]) && is_null($GLOBALS["o_date"])) ||
				($GLOBALS["x_date"] <> $GLOBALS["o_date"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_settingno"]) && !is_null($GLOBALS["o_settingno"])) ||
				(!is_null($GLOBALS["x_settingno"]) && is_null($GLOBALS["o_settingno"])) ||
				($GLOBALS["x_settingno"] <> $GLOBALS["o_settingno"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_grade"] = "";
	if ($lvl <= 2) $GLOBALS["o_date"] = "";
	if ($lvl <= 3) $GLOBALS["o_settingno"] = "";

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
		$GLOBALS['x_grade'] = "";
	} else {
		$GLOBALS['x_grade'] = $rsgrp->fields('grade');
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
		$GLOBALS['x_shed'] = $rs->fields('shed');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_time'] = $rs->fields('time');
		$GLOBALS['x_settingno'] = $rs->fields('settingno');
		$GLOBALS['x_setterno'] = $rs->fields('setterno');
		$GLOBALS['x_partitionno'] = $rs->fields('partitionno');
		$GLOBALS['x_eggsset'] = $rs->fields('eggsset');
		$GLOBALS['x_eggspertray'] = $rs->fields('eggspertray');
		$GLOBALS['x_eggweight'] = $rs->fields('eggweight');
		$GLOBALS['x_avgegg'] = $rs->fields('avgegg');
		$GLOBALS['x_loadedby'] = $rs->fields('loadedby');
		$val[1] = $GLOBALS['x_unit'];
		$val[2] = $GLOBALS['x_shed'];
		$val[3] = $GLOBALS['x_flock'];
		$val[4] = $GLOBALS['x_time'];
		$val[5] = $GLOBALS['x_setterno'];
		$val[6] = $GLOBALS['x_partitionno'];
		$val[7] = $GLOBALS['x_eggsset'];
		$val[8] = $GLOBALS['x_eggspertray'];
		$val[9] = $GLOBALS['x_eggweight'];
		$val[10] = $GLOBALS['x_avgegg'];
		$val[11] = $GLOBALS['x_loadedby'];
	} else {
		$GLOBALS['x_unit'] = "";
		$GLOBALS['x_shed'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_time'] = "";
		$GLOBALS['x_settingno'] = "";
		$GLOBALS['x_setterno'] = "";
		$GLOBALS['x_partitionno'] = "";
		$GLOBALS['x_eggsset'] = "";
		$GLOBALS['x_eggspertray'] = "";
		$GLOBALS['x_eggweight'] = "";
		$GLOBALS['x_avgegg'] = "";
		$GLOBALS['x_loadedby'] = "";
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
	// Build distinct values for grade

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_GRADE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_GRADE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_grade = $rswrk->fields[0];
		if (is_null($x_grade)) {
			$bNullValue = TRUE;
		} elseif ($x_grade == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_grade = $x_grade;
			$dg_grade = $x_grade;
			ewrpt_SetupDistinctValues($GLOBALS["val_grade"], $g_grade, $dg_grade, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_grade"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_grade"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('grade');
			ClearSessionSelection('date');
			ClearSessionSelection('settingno');
			ClearSessionSelection('unit');
			ClearSessionSelection('shed');
			ClearSessionSelection('flock');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Grade selected values

	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_grade"])) {
		LoadSelectionFromSession('grade');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_grade"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_grade"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Settingno selected values
	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_settingno"])) {
		LoadSelectionFromSession('settingno');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_settingno"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_settingno"] = "";
	}

	// Get Unit selected values
	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_unit"])) {
		LoadSelectionFromSession('unit');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_unit"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unit"] = "";
	}

	// Get Shed selected values
	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_shed"])) {
		LoadSelectionFromSession('shed');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_shed"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shed"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_hatchery_loadingdetails1_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_hatchery_loadingdetails1_flock"] == EW_REPORT_INIT_VALUE) { // Select all
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
	$_SESSION["sel_hatchery_loadingdetails1_$parm"] = "";
	$_SESSION["rf_hatchery_loadingdetails1_$parm"] = "";
	$_SESSION["rt_hatchery_loadingdetails1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_hatchery_loadingdetails1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_hatchery_loadingdetails1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_hatchery_loadingdetails1_$parm"];
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

	// Field grade
	// Setup your default values for the popup filter below, e.g.
	// $seld_grade = array("val1", "val2");

	$GLOBALS["seld_grade"] = "";
	$GLOBALS["sel_grade"] =  $GLOBALS["seld_grade"];

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

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];

	// Field settingno
	// Setup your default values for the popup filter below, e.g.
	// $seld_settingno = array("val1", "val2");

	$GLOBALS["seld_settingno"] = "";
	$GLOBALS["sel_settingno"] =  $GLOBALS["seld_settingno"];
}

// Check if filter applied
function CheckFilter() {

	// Check grade popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_grade"], $GLOBALS["sel_grade"]))
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

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check settingno popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_settingno"], $GLOBALS["sel_settingno"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field grade
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_grade"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_grade"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Grade<br />";
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
	if (is_array($GLOBALS["sel_grade"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_grade"], "hatchery_loadingdetails.grade", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_grade"], $GLOBALS["gb_grade"], $GLOBALS["gi_grade"], $GLOBALS["gq_grade"]);
	}
	if (is_array($GLOBALS["sel_unit"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unit"], "hatchery_loadingdetails.unit", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unit"]);
	}
	if (is_array($GLOBALS["sel_shed"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shed"], "hatchery_loadingdetails.shed", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shed"]);
	}
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "hatchery_loadingdetails.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "hatchery_loadingdetails.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_settingno"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_settingno"], "hatchery_loadingdetails.settingno", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_settingno"], $GLOBALS["gb_settingno"], $GLOBALS["gi_settingno"], $GLOBALS["gq_settingno"]);
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
			$_SESSION["sort_hatchery_loadingdetails1_grade"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_date"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_settingno"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_unit"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_shed"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_flock"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_time"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_setterno"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_partitionno"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_eggsset"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_eggspertray"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_eggweight"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_avgegg"] = "";
			$_SESSION["sort_hatchery_loadingdetails1_loadedby"] = "";
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
