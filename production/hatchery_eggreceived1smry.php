<center>
<?php
session_start();
ob_start();
include "reportheader.php";
$totaleggsreceived = 0;
include "config.php";
for($i = 0; $i < 10; $i++)
{
$freggs[$i] = 0;
$treggs[$i] = 0;
}
$frejections = 0;
$trejections = 0;
$tremaining = 0;

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
define("EW_REPORT_TABLE_VAR", "hatchery_eggreceived1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "hatchery_eggreceived1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "hatchery_eggreceived1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "hatchery_eggreceived1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "hatchery_eggreceived1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "hatchery_eggreceived1_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hatchery_eggreceived";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hatchery_eggreceived.unit, hatchery_eggreceived.shed, hatchery_eggreceived.flock, hatchery_eggreceived.date, hatchery_eggreceived.time, hatchery_eggreceived.lotno, hatchery_eggreceived.eggsreceived, hatchery_eggreceived.totalrejections, hatchery_eggreceived.totaleggs, hatchery_eggreceived.fst, hatchery_eggreceived.fet, hatchery_eggreceived.placeofstorage, hatchery_eggreceived.driver, hatchery_eggreceived.vehicleno, hatchery_eggreceived.receivedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "'$fromdate' <= hatchery_eggreceived.date and hatchery_eggreceived.date <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "hatchery_eggreceived.unit, hatchery_eggreceived.shed, hatchery_eggreceived.flock, hatchery_eggreceived.date, hatchery_eggreceived.time, hatchery_eggreceived.lotno, hatchery_eggreceived.eggsreceived, hatchery_eggreceived.totalrejections, hatchery_eggreceived.totaleggs, hatchery_eggreceived.fst, hatchery_eggreceived.fet, hatchery_eggreceived.placeofstorage, hatchery_eggreceived.driver, hatchery_eggreceived.vehicleno, hatchery_eggreceived.receivedby";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hatchery_eggreceived.unit ASC, hatchery_eggreceived.shed ASC, hatchery_eggreceived.flock ASC, hatchery_eggreceived.date ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "hatchery_eggreceived.unit", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `unit` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hatchery_eggreceived.eggsreceived) AS SUM_eggsreceived, SUM(hatchery_eggreceived.totaleggs) AS SUM_totaleggs FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_unit = NULL; // Popup filter for unit
$af_shed = NULL; // Popup filter for shed
$af_flock = NULL; // Popup filter for flock
$af_date = NULL; // Popup filter for date
$af_time = NULL; // Popup filter for time
$af_lotno = NULL; // Popup filter for lotno
$af_eggsreceived = NULL; // Popup filter for eggsreceived
$af_totalrejections = NULL; // Popup filter for totalrejections
$af_totaleggs = NULL; // Popup filter for totaleggs
$af_fst = NULL; // Popup filter for fst
$af_fet = NULL; // Popup filter for fet
$af_placeofstorage = NULL; // Popup filter for placeofstorage
$af_driver = NULL; // Popup filter for driver
$af_vehicleno = NULL; // Popup filter for vehicleno
$af_receivedby = NULL; // Popup filter for receivedby
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
$EW_REPORT_FIELD_UNIT_SQL_SELECT = "SELECT DISTINCT hatchery_eggreceived.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNIT_SQL_ORDERBY = "hatchery_eggreceived.unit";
$EW_REPORT_FIELD_SHED_SQL_SELECT = "SELECT DISTINCT hatchery_eggreceived.shed FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHED_SQL_ORDERBY = "hatchery_eggreceived.shed";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT hatchery_eggreceived.flock FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "hatchery_eggreceived.flock";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT hatchery_eggreceived.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "hatchery_eggreceived.date";
?>
<?php

// Field variables
$x_unit = NULL;
$x_shed = NULL;
$x_flock = NULL;
$x_date = NULL;
$x_time = NULL;
$x_lotno = NULL;
$x_eggsreceived = NULL;
$x_totalrejections = NULL;
$x_totaleggs = NULL;
$x_fst = NULL;
$x_fet = NULL;
$x_placeofstorage = NULL;
$x_driver = NULL;
$x_vehicleno = NULL;
$x_receivedby = NULL;

// Group variables
$o_unit = NULL; $g_unit = NULL; $dg_unit = NULL; $t_unit = NULL; $ft_unit = 200; $gf_unit = $ft_unit; $gb_unit = ""; $gi_unit = "0"; $gq_unit = ""; $rf_unit = NULL; $rt_unit = NULL;
$o_shed = NULL; $g_shed = NULL; $dg_shed = NULL; $t_shed = NULL; $ft_shed = 200; $gf_shed = $ft_shed; $gb_shed = ""; $gi_shed = "0"; $gq_shed = ""; $rf_shed = NULL; $rt_shed = NULL;
$o_flock = NULL; $g_flock = NULL; $dg_flock = NULL; $t_flock = NULL; $ft_flock = 200; $gf_flock = $ft_flock; $gb_flock = ""; $gi_flock = "0"; $gq_flock = ""; $rf_flock = NULL; $rt_flock = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;

// Detail variables
$o_time = NULL; $t_time = NULL; $ft_time = 200; $rf_time = NULL; $rt_time = NULL;
$o_lotno = NULL; $t_lotno = NULL; $ft_lotno = 200; $rf_lotno = NULL; $rt_lotno = NULL;
$o_eggsreceived = NULL; $t_eggsreceived = NULL; $ft_eggsreceived = 5; $rf_eggsreceived = NULL; $rt_eggsreceived = NULL;
$o_totalrejections = NULL; $t_totalrejections = NULL; $ft_totalrejections = 200; $rf_totalrejections = NULL; $rt_totalrejections = NULL;
$o_totaleggs = NULL; $t_totaleggs = NULL; $ft_totaleggs = 5; $rf_totaleggs = NULL; $rt_totaleggs = NULL;
$o_fst = NULL; $t_fst = NULL; $ft_fst = 200; $rf_fst = NULL; $rt_fst = NULL;
$o_fet = NULL; $t_fet = NULL; $ft_fet = 200; $rf_fet = NULL; $rt_fet = NULL;
$o_placeofstorage = NULL; $t_placeofstorage = NULL; $ft_placeofstorage = 200; $rf_placeofstorage = NULL; $rt_placeofstorage = NULL;
$o_driver = NULL; $t_driver = NULL; $ft_driver = 200; $rf_driver = NULL; $rt_driver = NULL;
$o_vehicleno = NULL; $t_vehicleno = NULL; $ft_vehicleno = 200; $rf_vehicleno = NULL; $rt_vehicleno = NULL;
$o_receivedby = NULL; $t_receivedby = NULL; $ft_receivedby = 200; $rf_receivedby = NULL; $rt_receivedby = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 12;
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
$col = array(FALSE, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_unit = "";
$seld_unit = "";
$val_unit = "";
$sel_shed = "";
$seld_shed = "";
$val_shed = "";
$sel_flock = "";
$seld_flock = "";
$val_flock = "";
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
<?php $jsdata = ewrpt_GetJsData($val_unit, $sel_unit, $ft_unit) ?>
ewrpt_CreatePopup("hatchery_eggreceived1_unit", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shed, $sel_shed, $ft_shed) ?>
ewrpt_CreatePopup("hatchery_eggreceived1_shed", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("hatchery_eggreceived1_flock", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("hatchery_eggreceived1_date", [<?php echo $jsdata ?>]);
</script>
<div id="hatchery_eggreceived1_unit_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_eggreceived1_shed_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_eggreceived1_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hatchery_eggreceived1_date_Popup" class="ewPopup">
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
<center><strong>Hatchery Eggs Received Report(From <?php echo $_GET['fromdate']; ?> To <?php echo $_GET['todate']; ?>)</strong></center>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="hatchery_eggreceived1smry.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatchery_eggreceived1smry.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatchery_eggreceived1smry.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatchery_eggreceived1smry.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="hatchery_eggreceived1smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<td>FST: Fumigation Start Time</td><td width="15px">&nbsp;</td>
<td>FET: Fumigation End Time</td>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php if (@$sExport != "") { ?>
<div class="ewGridUpperPanel">
<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
<td>FST: Fumigation Start Time</td><td width="15px">&nbsp;</td>
<td>FET: Fumigation End Time</td>
	</tr>
</table>
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
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Unit</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_eggreceived1_unit', false, '<?php echo $rf_unit; ?>', '<?php echo $rt_unit; ?>');return false;" name="x_unit<?php echo $cnt[0][0]; ?>" id="x_unit<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_eggreceived1_shed', false, '<?php echo $rf_shed; ?>', '<?php echo $rt_shed; ?>');return false;" name="x_shed<?php echo $cnt[0][0]; ?>" id="x_shed<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_eggreceived1_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hatchery_eggreceived1_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Received Time
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Received Time</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<!--<td valign="bottom" class="ewTableHeader">
		Lot No.
		</td>-->
<?php } else { ?>
		<!--<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Lot No.</td>
			</tr></table>
		</td>-->
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Eggs Received
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Eggs Received</td>
			</tr></table>
		</td>
<?php } ?>
<?php 
$q = "select distinct(code),description from ims_itemcodes where iusage = 'Rejected or Sale' or iusage = 'Produced or Sale or Rejected' or iusage = 'Produced or Rejected' order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
?>
		<td valign="bottom" class="ewTableHeader">
		<?php echo $qr['description'] ; ?>
		</td>
<?php
}
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Rejections
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Rejections</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Remaining Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Remaining Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Fumigation Start Time">
		FST
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Fumigation Start Time">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>FST</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Fumigation End Time">
		FET
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Fumigation End Time">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>FET</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Place Of Storage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Place Of Storage</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
<!--		<td valign="bottom" class="ewTableHeader">
		Driver
		</td>-->
<?php } else { ?>
<!--		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Driver</td>
			</tr></table>
		</td>-->
<?php } ?>
<?php if (@$sExport <> "") { ?>
<!--		<td valign="bottom" class="ewTableHeader">
		Vehicle No.
		</td>-->
<?php } else { ?>
<!--		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Vehicle No.</td>
			</tr></table>
		</td>-->
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Received By
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Received By</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_unit, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_unit, EW_REPORT_DATATYPE_STRING, $gb_unit, $gi_unit, $gq_unit);
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
		$dg_unit = $x_unit;
		if ((is_null($x_unit) && is_null($o_unit)) ||
			(($x_unit <> "" && $o_unit == $dg_unit) && !ChkLvlBreak(1))) {
			$dg_unit = "&nbsp;";
		} elseif (is_null($x_unit)) {
			$dg_unit = EW_REPORT_NULL_LABEL;
		} elseif ($x_unit == "") {
			$dg_unit = EW_REPORT_EMPTY_LABEL;
		}
		$dg_shed = $x_shed;
		if ((is_null($x_shed) && is_null($o_shed)) ||
			(($x_shed <> "" && $o_shed == $dg_shed) && !ChkLvlBreak(2))) {
			$dg_shed = "&nbsp;";
		} elseif (is_null($x_shed)) {
			$dg_shed = EW_REPORT_NULL_LABEL;
		} elseif ($x_shed == "") {
			$dg_shed = EW_REPORT_EMPTY_LABEL;
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
		$dg_date = $x_date;
		if ((is_null($x_date) && is_null($o_date)) ||
			(($x_date <> "" && $o_date == $dg_date) && !ChkLvlBreak(4))) {
			$dg_date = "&nbsp;";
		} elseif (is_null($x_date)) {
			$dg_date = EW_REPORT_NULL_LABEL;
		} elseif ($x_date == "") {
			$dg_date = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_unit = $x_unit; $x_unit = $dg_unit; ?>
<?php echo ewrpt_ViewValue($x_unit) ?>
		<?php $x_unit = $t_unit; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_shed = $x_shed; $x_shed = $dg_shed; ?>
<?php echo ewrpt_ViewValue($x_shed) ?>
		<?php $x_shed = $t_shed; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_flock = $x_flock; $x_flock = $dg_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
		<?php $x_flock = $t_flock; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
		<?php $x_date = $t_date; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_time) ?>
</td>
<!--		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_lotno) ?>
</td>-->
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_eggsreceived) ?>
</td>
<?php 
$q = "select code,rejections from hatchery_eggreceived where lotno = '$x_lotno'";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
if($qr = mysql_fetch_assoc($qrs))
{
	$code = $qr['code'];
	$rej = $qr['rejections'];
}
$rc = explode(",",$code);
$rq = explode(",",$rej);

$q = "select distinct(code),description from ims_itemcodes where iusage = 'Rejected or Sale' or iusage = 'Produced or Sale or Rejected' or iusage = 'Produced or Rejected' order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$count = mysql_num_rows($qrs);
$j = 0;
while($qr = mysql_fetch_assoc($qrs))
{
$reggs = 0;

for($i = 0; $i < count($rc); $i++)
if($rc[$i] == $qr['code'])
{
$reggs = $rq[$i];
$freggs[$j]+= $rq[$i];
break; 
}
?>
		<td<?php echo $sItemRowClass; ?> align="right">
		<?php echo $reggs; ?>
		</td>
<?php
$j++;
}
?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_totalrejections); $frejections+= $x_totalrejections; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_totaleggs);   ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_fst) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_fet) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_placeofstorage) ?>
</td>
		<!--<td<?php #echo $sItemRowClass; ?>>-->
<?php #echo ewrpt_ViewValue($x_driver) ?>
<!--</td>-->
		<!--<td<?php #echo $sItemRowClass; ?>>-->
<?php #echo ewrpt_ViewValue($x_vehicleno) ?>
<!--</td>-->
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_receivedby) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_unit = $x_unit;
		$o_shed = $x_shed;
		$o_flock = $x_flock;
		$o_date = $x_date;

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
		<td colspan="<?php echo 14+$count; ?>" class="ewRptGrpSummary3">Summary for Flock: <?php $t_flock = $x_flock; $x_flock = $o_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
<?php $x_flock = $t_flock; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<!--<td class="ewRptGrpField2">&nbsp;</td>-->
		<td colspan="2" class="ewRptGrpSummary3">SUM</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3" align="right">
		<?php $t_eggsreceived = $x_eggsreceived; ?>
		<?php $x_eggsreceived = $smry[3][3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_eggsreceived); $totaleggreceived+= $x_eggsreceived; ?>
		<?php $x_eggsreceived = $t_eggsreceived; ?>
		</td>
		
		<?php 
		for($i = 0; $i < $count; $i++)
		{
		?>
		<td class="ewRptGrpSummary3" align="right"><?php echo $freggs[$i]; $treggs[$i]+= $freggs[$i]; $freggs[$i] = 0;?></td>
		<?php
		}
		?>
		<td class="ewRptGrpSummary3" align="right"><?php echo $frejections; $trejections+= $frejections; $frejections = 0;?></td>
		<td class="ewRptGrpSummary3" align="right">
		<?php $t_totaleggs = $x_totaleggs; ?>
		<?php $x_totaleggs = $smry[3][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_totaleggs); $tremaining+= $x_totaleggs; ?>
		<?php $x_totaleggs = $t_totaleggs; ?>
		</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<!--<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>-->
	</tr>
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
	$o_unit = $x_unit; // Save old group value
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
		$grandsmry[3] = $rsagg->fields("SUM_eggsreceived");
		$grandsmry[5] = $rsagg->fields("SUM_totaleggs");
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
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="14">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" height="40px">
		<td colspan="4" class="ewRptGrpAggregate">GRAND TOTAL</td>
		<td>&nbsp;</td>
		<!--<td>&nbsp;</td>-->
		<td align="right">
		<?php $t_eggsreceived = $x_eggsreceived; ?>
		<?php $x_eggsreceived = $grandsmry[3]; // Load SUM ?>
<?php echo $totaleggreceived; #ewrpt_ViewValue($x_eggsreceived) ?>
		<?php $x_eggsreceived = $t_eggsreceived; ?>
		</td>
		<?php 
		for($i = 0; $i < $count; $i++)
		{
		?>
		<td align="right"><?php echo $treggs[$i]; $treggs[$i] = 0;?></td>
		<?php
		}
		?>

		<td align="right"><?php echo $trejections; $trejections = 0;?></td>
		<td align="right"><?php echo $tremaining; $tremaining = 0;?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<!--<td>&nbsp;</td>
		<td>&nbsp;</td>-->
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="hatchery_eggreceived1smry.php<?php echo $url1; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->FirstButton->Start ?><?php echo $url; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->PrevButton->Start ?><?php echo $url; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->NextButton->Start ?><?php echo $url; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatchery_eggreceived1smry.php?start=<?php echo $Pager->LastButton->Start ?><?php echo $url; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_unit"]) && !is_null($GLOBALS["o_unit"])) ||
				(!is_null($GLOBALS["x_unit"]) && is_null($GLOBALS["o_unit"])) ||
				($GLOBALS["x_unit"] <> $GLOBALS["o_unit"]);
		case 2:
			return (is_null($GLOBALS["x_shed"]) && !is_null($GLOBALS["o_shed"])) ||
				(!is_null($GLOBALS["x_shed"]) && is_null($GLOBALS["o_shed"])) ||
				($GLOBALS["x_shed"] <> $GLOBALS["o_shed"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_flock"]) && !is_null($GLOBALS["o_flock"])) ||
				(!is_null($GLOBALS["x_flock"]) && is_null($GLOBALS["o_flock"])) ||
				($GLOBALS["x_flock"] <> $GLOBALS["o_flock"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_unit"] = "";
	if ($lvl <= 2) $GLOBALS["o_shed"] = "";
	if ($lvl <= 3) $GLOBALS["o_flock"] = "";
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
		$GLOBALS['x_unit'] = "";
	} else {
		$GLOBALS['x_unit'] = $rsgrp->fields('unit');
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
		$GLOBALS['x_shed'] = $rs->fields('shed');
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_time'] = $rs->fields('time');
		$GLOBALS['x_lotno'] = $rs->fields('lotno');
		$GLOBALS['x_eggsreceived'] = $rs->fields('eggsreceived');
		$GLOBALS['x_totalrejections'] = $rs->fields('totalrejections');
		$GLOBALS['x_totaleggs'] = $rs->fields('totaleggs');
		$GLOBALS['x_fst'] = $rs->fields('fst');
		$GLOBALS['x_fet'] = $rs->fields('fet');
		$GLOBALS['x_placeofstorage'] = $rs->fields('placeofstorage');
		$GLOBALS['x_driver'] = $rs->fields('driver');
		$GLOBALS['x_vehicleno'] = $rs->fields('vehicleno');
		$GLOBALS['x_receivedby'] = $rs->fields('receivedby');
		$val[1] = $GLOBALS['x_time'];
		$val[2] = $GLOBALS['x_lotno'];
		$val[3] = $GLOBALS['x_eggsreceived'];
		$val[4] = $GLOBALS['x_totalrejections'];
		$val[5] = $GLOBALS['x_totaleggs'];
		$val[6] = $GLOBALS['x_fst'];
		$val[7] = $GLOBALS['x_fet'];
		$val[8] = $GLOBALS['x_placeofstorage'];
		$val[9] = $GLOBALS['x_driver'];
		$val[10] = $GLOBALS['x_vehicleno'];
		$val[11] = $GLOBALS['x_receivedby'];
	} else {
		$GLOBALS['x_shed'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_time'] = "";
		$GLOBALS['x_lotno'] = "";
		$GLOBALS['x_eggsreceived'] = "";
		$GLOBALS['x_totalrejections'] = "";
		$GLOBALS['x_totaleggs'] = "";
		$GLOBALS['x_fst'] = "";
		$GLOBALS['x_fet'] = "";
		$GLOBALS['x_placeofstorage'] = "";
		$GLOBALS['x_driver'] = "";
		$GLOBALS['x_vehicleno'] = "";
		$GLOBALS['x_receivedby'] = "";
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
			$g_shed = $x_shed;
			$dg_shed = $x_shed;
			ewrpt_SetupDistinctValues($GLOBALS["val_shed"], $g_shed, $dg_shed, FALSE);
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
			ClearSessionSelection('unit');
			ClearSessionSelection('shed');
			ClearSessionSelection('flock');
			ClearSessionSelection('date');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Unit selected values

	if (is_array(@$_SESSION["sel_hatchery_eggreceived1_unit"])) {
		LoadSelectionFromSession('unit');
	} elseif (@$_SESSION["sel_hatchery_eggreceived1_unit"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unit"] = "";
	}

	// Get Shed selected values
	if (is_array(@$_SESSION["sel_hatchery_eggreceived1_shed"])) {
		LoadSelectionFromSession('shed');
	} elseif (@$_SESSION["sel_hatchery_eggreceived1_shed"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shed"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_hatchery_eggreceived1_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_hatchery_eggreceived1_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_hatchery_eggreceived1_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_hatchery_eggreceived1_date"] == EW_REPORT_INIT_VALUE) { // Select all
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
	$_SESSION["sel_hatchery_eggreceived1_$parm"] = "";
	$_SESSION["rf_hatchery_eggreceived1_$parm"] = "";
	$_SESSION["rt_hatchery_eggreceived1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_hatchery_eggreceived1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_hatchery_eggreceived1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_hatchery_eggreceived1_$parm"];
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
}

// Check if filter applied
function CheckFilter() {

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
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

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
	if (is_array($GLOBALS["sel_unit"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unit"], "hatchery_eggreceived.unit", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unit"], $GLOBALS["gb_unit"], $GLOBALS["gi_unit"], $GLOBALS["gq_unit"]);
	}
	if (is_array($GLOBALS["sel_shed"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shed"], "hatchery_eggreceived.shed", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shed"], $GLOBALS["gb_shed"], $GLOBALS["gi_shed"], $GLOBALS["gq_shed"]);
	}
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "hatchery_eggreceived.flock", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"], $GLOBALS["gb_flock"], $GLOBALS["gi_flock"], $GLOBALS["gq_flock"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "hatchery_eggreceived.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
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
			$_SESSION["sort_hatchery_eggreceived1_unit"] = "";
			$_SESSION["sort_hatchery_eggreceived1_shed"] = "";
			$_SESSION["sort_hatchery_eggreceived1_flock"] = "";
			$_SESSION["sort_hatchery_eggreceived1_date"] = "";
			$_SESSION["sort_hatchery_eggreceived1_time"] = "";
			$_SESSION["sort_hatchery_eggreceived1_lotno"] = "";
			$_SESSION["sort_hatchery_eggreceived1_eggsreceived"] = "";
			$_SESSION["sort_hatchery_eggreceived1_totalrejections"] = "";
			$_SESSION["sort_hatchery_eggreceived1_totaleggs"] = "";
			$_SESSION["sort_hatchery_eggreceived1_fst"] = "";
			$_SESSION["sort_hatchery_eggreceived1_fet"] = "";
			$_SESSION["sort_hatchery_eggreceived1_placeofstorage"] = "";
			$_SESSION["sort_hatchery_eggreceived1_driver"] = "";
			$_SESSION["sort_hatchery_eggreceived1_vehicleno"] = "";
			$_SESSION["sort_hatchery_eggreceived1_receivedby"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "hatchery_eggreceived.lotno ASC, hatchery_eggreceived.eggsreceived ASC";
		$_SESSION["sort_hatchery_eggreceived1_lotno"] = "ASC";
		$_SESSION["sort_hatchery_eggreceived1_eggsreceived"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
