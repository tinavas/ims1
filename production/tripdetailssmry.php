<?php
session_start();
ob_start();
include "reportheader.php";
if($_GET['fromdate'] <> "")
 $fromdate =date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
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
define("EW_REPORT_TABLE_VAR", "tripdetailssmry", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "tripdetailssmry_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "tripdetailssmry_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "tripdetailssmry_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "tripdetailssmry_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "tripdetailssmry_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`vehicle_tripdetails`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "startdate between '$fromdate' and '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`startdate` ASC, `startplace` ASC, `vehicletype` ASC, `vehiclenumber` ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`startdate`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `startdate` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_vehicletype = NULL; // Popup filter for vehicletype
$af_vehiclenumber = NULL; // Popup filter for vehiclenumber
$af_driver = NULL; // Popup filter for driver
$af_startdate = NULL; // Popup filter for startdate
$af_starttime = NULL; // Popup filter for starttime
$af_startplace = NULL; // Popup filter for startplace
$af_startreading = NULL; // Popup filter for startreading
$af_enddate = NULL; // Popup filter for enddate
$af_endtime = NULL; // Popup filter for endtime
$af_endplace = NULL; // Popup filter for endplace
$af_endreading = NULL; // Popup filter for endreading
$af_expensesincurred = NULL; // Popup filter for expensesincurred
$af_wload = NULL; // Popup filter for wload
$af_remarks = NULL; // Popup filter for remarks
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
$EW_REPORT_FIELD_STARTDATE_SQL_SELECT = "SELECT DISTINCT `startdate` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_STARTDATE_SQL_ORDERBY = "`startdate`";
$EW_REPORT_FIELD_STARTPLACE_SQL_SELECT = "SELECT DISTINCT `startplace` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_STARTPLACE_SQL_ORDERBY = "`startplace`";
$EW_REPORT_FIELD_VEHICLETYPE_SQL_SELECT = "SELECT DISTINCT `vehicletype` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_VEHICLETYPE_SQL_ORDERBY = "`vehicletype`";
$EW_REPORT_FIELD_VEHICLENUMBER_SQL_SELECT = "SELECT DISTINCT `vehiclenumber` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_VEHICLENUMBER_SQL_ORDERBY = "`vehiclenumber`";
$EW_REPORT_FIELD_ENDDATE_SQL_SELECT = "SELECT DISTINCT `enddate` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_ENDDATE_SQL_ORDERBY = "`enddate`";
$EW_REPORT_FIELD_ENDPLACE_SQL_SELECT = "SELECT DISTINCT `endplace` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_ENDPLACE_SQL_ORDERBY = "`endplace`";
?>
<?php
$i=0;
// Field variables
$x_id = NULL;
$x_vehicletype = NULL;
$x_vehiclenumber = NULL;
$x_driver = NULL;
$x_startdate = NULL;
$x_starttime = NULL;
$x_startplace = NULL;
$x_startreading = NULL;
$x_enddate = NULL;
$x_endtime = NULL;
$x_endplace = NULL;
$x_endreading = NULL;
$x_expensesincurred = NULL;
$x_wload = NULL;
$x_remarks = NULL;
$x_updated = NULL;
$x_client = NULL;
$x_enteredby = NULL;

// Group variables
$o_startdate = NULL; $g_startdate = NULL; $dg_startdate = NULL; $t_startdate = NULL; $ft_startdate = 133; $gf_startdate = $ft_startdate; $gb_startdate = ""; $gi_startdate = "0"; $gq_startdate = ""; $rf_startdate = NULL; $rt_startdate = NULL;
$o_startplace = NULL; $g_startplace = NULL; $dg_startplace = NULL; $t_startplace = NULL; $ft_startplace = 200; $gf_startplace = $ft_startplace; $gb_startplace = ""; $gi_startplace = "0"; $gq_startplace = ""; $rf_startplace = NULL; $rt_startplace = NULL;
$o_vehicletype = NULL; $g_vehicletype = NULL; $dg_vehicletype = NULL; $t_vehicletype = NULL; $ft_vehicletype = 200; $gf_vehicletype = $ft_vehicletype; $gb_vehicletype = ""; $gi_vehicletype = "0"; $gq_vehicletype = ""; $rf_vehicletype = NULL; $rt_vehicletype = NULL;
$o_vehiclenumber = NULL; $g_vehiclenumber = NULL; $dg_vehiclenumber = NULL; $t_vehiclenumber = NULL; $ft_vehiclenumber = 200; $gf_vehiclenumber = $ft_vehiclenumber; $gb_vehiclenumber = ""; $gi_vehiclenumber = "0"; $gq_vehiclenumber = ""; $rf_vehiclenumber = NULL; $rt_vehiclenumber = NULL;

// Detail variables
$o_driver = NULL; $t_driver = NULL; $ft_driver = 200; $rf_driver = NULL; $rt_driver = NULL;
$o_starttime = NULL; $t_starttime = NULL; $ft_starttime = 134; $rf_starttime = NULL; $rt_starttime = NULL;
$o_startreading = NULL; $t_startreading = NULL; $ft_startreading = 3; $rf_startreading = NULL; $rt_startreading = NULL;
$o_enddate = NULL; $t_enddate = NULL; $ft_enddate = 133; $rf_enddate = NULL; $rt_enddate = NULL;
$o_endtime = NULL; $t_endtime = NULL; $ft_endtime = 134; $rf_endtime = NULL; $rt_endtime = NULL;
$o_endplace = NULL; $t_endplace = NULL; $ft_endplace = 200; $rf_endplace = NULL; $rt_endplace = NULL;
$o_endreading = NULL; $t_endreading = NULL; $ft_endreading = 3; $rf_endreading = NULL; $rt_endreading = NULL;
$o_expensesincurred = NULL; $t_expensesincurred = NULL; $ft_expensesincurred = 3; $rf_expensesincurred = NULL; $rt_expensesincurred = NULL;
$o_wload = NULL; $t_wload = NULL; $ft_wload = 200; $rf_wload = NULL; $rt_wload = NULL;
$o_remarks = NULL; $t_remarks = NULL; $ft_remarks = 200; $rf_remarks = NULL; $rt_remarks = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 11;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_startdate = "";
$seld_startdate = "";
$val_startdate = "";
$sel_startplace = "";
$seld_startplace = "";
$val_startplace = "";
$sel_vehicletype = "";
$seld_vehicletype = "";
$val_vehicletype = "";
$sel_vehiclenumber = "";
$seld_vehiclenumber = "";
$val_vehiclenumber = "";
$sel_enddate = "";
$seld_enddate = "";
$val_enddate = "";
$sel_endplace = "";
$seld_endplace = "";
$val_endplace = "";

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
<?php $jsdata = ewrpt_GetJsData($val_startdate, $sel_startdate, $ft_startdate) ?>
ewrpt_CreatePopup("tripdetailssmry_startdate", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_startplace, $sel_startplace, $ft_startplace) ?>
ewrpt_CreatePopup("tripdetailssmry_startplace", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_vehicletype, $sel_vehicletype, $ft_vehicletype) ?>
ewrpt_CreatePopup("tripdetailssmry_vehicletype", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_vehiclenumber, $sel_vehiclenumber, $ft_vehiclenumber) ?>
ewrpt_CreatePopup("tripdetailssmry_vehiclenumber", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_enddate, $sel_enddate, $ft_enddate) ?>
ewrpt_CreatePopup("tripdetailssmry_enddate", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_endplace, $sel_endplace, $ft_endplace) ?>
ewrpt_CreatePopup("tripdetailssmry_endplace", [<?php echo $jsdata ?>]);
</script>
<div id="tripdetailssmry_startdate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="tripdetailssmry_startplace_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="tripdetailssmry_vehicletype_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="tripdetailssmry_vehiclenumber_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="tripdetailssmry_enddate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="tripdetailssmry_endplace_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>

<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Trip Sheet<br /> </font></strong></td>
</tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
</table><br />
<center>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="tripdetailssmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="tripdetailssmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="tripdetailssmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="tripdetailssmry.php?cmd=reset">Reset All Filters</a>
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
<div class="ewGridLowerPanel">
<form action="tripdetailssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
 <td>From Date</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To Date</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
		Start Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Start Date</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_startdate', false, '<?php echo $rf_startdate; ?>', '<?php echo $rt_startdate; ?>');return false;" name="x_startdate<?php echo $cnt[0][0]; ?>" id="x_startdate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		Start Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Start Place</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_startplace', false, '<?php echo $rf_startplace; ?>', '<?php echo $rt_startplace; ?>');return false;" name="x_startplace<?php echo $cnt[0][0]; ?>" id="x_startplace<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Vehicle Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Vehicle Type</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_vehicletype', false, '<?php echo $rf_vehicletype; ?>', '<?php echo $rt_vehicletype; ?>');return false;" name="x_vehicletype<?php echo $cnt[0][0]; ?>" id="x_vehicletype<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		Vehicle Number
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Vehicle Number</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_vehiclenumber', false, '<?php echo $rf_vehiclenumber; ?>', '<?php echo $rt_vehiclenumber; ?>');return false;" name="x_vehiclenumber<?php echo $cnt[0][0]; ?>" id="x_vehiclenumber<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Driver
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Driver</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Start Time
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Start Time</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Start Reading
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Start Reading</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		End Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>End Date</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_enddate', false, '<?php echo $rf_enddate; ?>', '<?php echo $rt_enddate; ?>');return false;" name="x_enddate<?php echo $cnt[0][0]; ?>" id="x_enddate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		End Time
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>End Time</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		End Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>End Place</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'tripdetailssmry_endplace', false, '<?php echo $rf_endplace; ?>', '<?php echo $rt_endplace; ?>');return false;" name="x_endplace<?php echo $cnt[0][0]; ?>" id="x_endplace<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		End Reading
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>End Reading</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Expenses Incurred
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Expenses Incurred</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Work Load
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Work Load</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Mileage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Mileage</td>
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
			<td>Remarks</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_startdate, EW_REPORT_DATATYPE_DATE);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_startdate, EW_REPORT_DATATYPE_DATE, $gb_startdate, $gi_startdate, $gq_startdate);
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
$i++;
		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$dg_startdate = $x_startdate;
		if ((is_null($x_startdate) && is_null($o_startdate)) ||
			(($x_startdate <> "" && $o_startdate == $dg_startdate) && !ChkLvlBreak(1))) {
			$dg_startdate = "&nbsp;";
		} elseif (is_null($x_startdate)) {
			$dg_startdate = EW_REPORT_NULL_LABEL;
		} elseif ($x_startdate == "") {
			$dg_startdate = EW_REPORT_EMPTY_LABEL;
		}
		$dg_startplace = $x_startplace;
		if ((is_null($x_startplace) && is_null($o_startplace)) ||
			(($x_startplace <> "" && $o_startplace == $dg_startplace) && !ChkLvlBreak(2))) {
			$dg_startplace = "&nbsp;";
		} elseif (is_null($x_startplace)) {
			$dg_startplace = EW_REPORT_NULL_LABEL;
		} elseif ($x_startplace == "") {
			$dg_startplace = EW_REPORT_EMPTY_LABEL;
		}
		$dg_vehicletype = $x_vehicletype;
		if ((is_null($x_vehicletype) && is_null($o_vehicletype)) ||
			(($x_vehicletype <> "" && $o_vehicletype == $dg_vehicletype) && !ChkLvlBreak(3))) {
			$dg_vehicletype = "&nbsp;";
		} elseif (is_null($x_vehicletype)) {
			$dg_vehicletype = EW_REPORT_NULL_LABEL;
		} elseif ($x_vehicletype == "") {
			$dg_vehicletype = EW_REPORT_EMPTY_LABEL;
		}
		$dg_vehiclenumber = $x_vehiclenumber;
		if ((is_null($x_vehiclenumber) && is_null($o_vehiclenumber)) ||
			(($x_vehiclenumber <> "" && $o_vehiclenumber == $dg_vehiclenumber) && !ChkLvlBreak(4))) {
			$dg_vehiclenumber = "&nbsp;";
		} elseif (is_null($x_vehiclenumber)) {
			$dg_vehiclenumber = EW_REPORT_NULL_LABEL;
		} elseif ($x_vehiclenumber == "") {
			$dg_vehiclenumber = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_startdate = $x_startdate; $x_startdate = $dg_startdate; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_startdate,7)) ?>
		<?php $x_startdate = $t_startdate; ?></td>
		<td class="ewRptGrpField2">
		<?php $t_startplace = $x_startplace; $x_startplace = $dg_startplace; ?>
<?php echo ewrpt_ViewValue($x_startplace) ?>
		<?php $x_startplace = $t_startplace; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_vehicletype = $x_vehicletype; $x_vehicletype = $dg_vehicletype; ?>
<?php echo ewrpt_ViewValue($x_vehicletype) ?>
		<?php $x_vehicletype = $t_vehicletype; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_vehiclenumber = $x_vehiclenumber; $x_vehiclenumber = $dg_vehiclenumber; ?>
<?php echo ewrpt_ViewValue($x_vehiclenumber) ?>
		<?php $x_vehiclenumber = $t_vehiclenumber; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_driver) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_starttime) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_startreading) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_enddate,7)) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_endtime) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_endplace) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_endreading) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_expensesincurred) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_wload) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php 

 echo ewrpt_ViewValue($avg=$x_endreading-$x_startreading);
 $sum=$sum+$avg; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_remarks) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_startdate = $x_startdate;
		$o_startplace = $x_startplace;
		$o_vehicletype = $x_vehicletype;
		$o_vehiclenumber = $x_vehiclenumber;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_startdate = $x_startdate; // Save old group value
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
	<!-- tr><td colspan="14"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="13">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td><td class="ewRptGrandSummary"> <?php echo round(($sum/$i),2); ?></td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php /*?><?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="tripdetailssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="tripdetailssmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="tripdetailssmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="tripdetailssmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="tripdetailssmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<?php */?>	</tr>
</table>
</form>
</div>
<?php /*?><?php } ?><?php */?>
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
			return (is_null($GLOBALS["x_startdate"]) && !is_null($GLOBALS["o_startdate"])) ||
				(!is_null($GLOBALS["x_startdate"]) && is_null($GLOBALS["o_startdate"])) ||
				($GLOBALS["x_startdate"] <> $GLOBALS["o_startdate"]);
		case 2:
			return (is_null($GLOBALS["x_startplace"]) && !is_null($GLOBALS["o_startplace"])) ||
				(!is_null($GLOBALS["x_startplace"]) && is_null($GLOBALS["o_startplace"])) ||
				($GLOBALS["x_startplace"] <> $GLOBALS["o_startplace"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_vehicletype"]) && !is_null($GLOBALS["o_vehicletype"])) ||
				(!is_null($GLOBALS["x_vehicletype"]) && is_null($GLOBALS["o_vehicletype"])) ||
				($GLOBALS["x_vehicletype"] <> $GLOBALS["o_vehicletype"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_vehiclenumber"]) && !is_null($GLOBALS["o_vehiclenumber"])) ||
				(!is_null($GLOBALS["x_vehiclenumber"]) && is_null($GLOBALS["o_vehiclenumber"])) ||
				($GLOBALS["x_vehiclenumber"] <> $GLOBALS["o_vehiclenumber"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_startdate"] = "";
	if ($lvl <= 2) $GLOBALS["o_startplace"] = "";
	if ($lvl <= 3) $GLOBALS["o_vehicletype"] = "";
	if ($lvl <= 4) $GLOBALS["o_vehiclenumber"] = "";

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
		$GLOBALS['x_startdate'] = "";
	} else {
		$GLOBALS['x_startdate'] = $rsgrp->fields('startdate');
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
		$GLOBALS['x_id'] = $rs->fields('id');
		$GLOBALS['x_vehicletype'] = $rs->fields('vehicletype');
		$GLOBALS['x_vehiclenumber'] = $rs->fields('vehiclenumber');
		$GLOBALS['x_driver'] = $rs->fields('driver');
		$GLOBALS['x_starttime'] = $rs->fields('starttime');
		$GLOBALS['x_startplace'] = $rs->fields('startplace');
		$GLOBALS['x_startreading'] = $rs->fields('startreading');
		$GLOBALS['x_enddate'] = $rs->fields('enddate');
		$GLOBALS['x_endtime'] = $rs->fields('endtime');
		$GLOBALS['x_endplace'] = $rs->fields('endplace');
		$GLOBALS['x_endreading'] = $rs->fields('endreading');
		$GLOBALS['x_expensesincurred'] = $rs->fields('expensesincurred');
		$GLOBALS['x_wload'] = $rs->fields('wload');
		$GLOBALS['x_remarks'] = $rs->fields('remarks');
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$GLOBALS['x_enteredby'] = $rs->fields('enteredby');
		$val[1] = $GLOBALS['x_driver'];
		$val[2] = $GLOBALS['x_starttime'];
		$val[3] = $GLOBALS['x_startreading'];
		$val[4] = $GLOBALS['x_enddate'];
		$val[5] = $GLOBALS['x_endtime'];
		$val[6] = $GLOBALS['x_endplace'];
		$val[7] = $GLOBALS['x_endreading'];
		$val[8] = $GLOBALS['x_expensesincurred'];
		$val[9] = $GLOBALS['x_wload'];
		$val[10] = $GLOBALS['x_remarks'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_vehicletype'] = "";
		$GLOBALS['x_vehiclenumber'] = "";
		$GLOBALS['x_driver'] = "";
		$GLOBALS['x_starttime'] = "";
		$GLOBALS['x_startplace'] = "";
		$GLOBALS['x_startreading'] = "";
		$GLOBALS['x_enddate'] = "";
		$GLOBALS['x_endtime'] = "";
		$GLOBALS['x_endplace'] = "";
		$GLOBALS['x_endreading'] = "";
		$GLOBALS['x_expensesincurred'] = "";
		$GLOBALS['x_wload'] = "";
		$GLOBALS['x_remarks'] = "";
		$GLOBALS['x_updated'] = "";
		$GLOBALS['x_client'] = "";
		$GLOBALS['x_enteredby'] = "";
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
	// Build distinct values for startdate

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
			$g_startdate = $x_startdate;
			$dg_startdate = ewrpt_FormatDateTime($x_startdate,5);
			ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], $g_startdate, $dg_startdate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for startplace
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_STARTPLACE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_STARTPLACE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_startplace = $rswrk->fields[0];
		if (is_null($x_startplace)) {
			$bNullValue = TRUE;
		} elseif ($x_startplace == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_startplace = $x_startplace;
			$dg_startplace = $x_startplace;
			ewrpt_SetupDistinctValues($GLOBALS["val_startplace"], $g_startplace, $dg_startplace, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startplace"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startplace"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for vehicletype
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_VEHICLETYPE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_VEHICLETYPE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_vehicletype = $rswrk->fields[0];
		if (is_null($x_vehicletype)) {
			$bNullValue = TRUE;
		} elseif ($x_vehicletype == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_vehicletype = $x_vehicletype;
			$dg_vehicletype = $x_vehicletype;
			ewrpt_SetupDistinctValues($GLOBALS["val_vehicletype"], $g_vehicletype, $dg_vehicletype, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vehicletype"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vehicletype"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for vehiclenumber
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_VEHICLENUMBER_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_VEHICLENUMBER_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_vehiclenumber = $rswrk->fields[0];
		if (is_null($x_vehiclenumber)) {
			$bNullValue = TRUE;
		} elseif ($x_vehiclenumber == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_vehiclenumber = $x_vehiclenumber;
			$dg_vehiclenumber = $x_vehiclenumber;
			ewrpt_SetupDistinctValues($GLOBALS["val_vehiclenumber"], $g_vehiclenumber, $dg_vehiclenumber, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vehiclenumber"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vehiclenumber"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for enddate
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_ENDDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_ENDDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_enddate = $rswrk->fields[0];
		if (is_null($x_enddate)) {
			$bNullValue = TRUE;
		} elseif ($x_enddate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_enddate = ewrpt_FormatDateTime($x_enddate,5);
			ewrpt_SetupDistinctValues($GLOBALS["val_enddate"], $x_enddate, $t_enddate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_enddate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_enddate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for endplace
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_ENDPLACE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_ENDPLACE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_endplace = $rswrk->fields[0];
		if (is_null($x_endplace)) {
			$bNullValue = TRUE;
		} elseif ($x_endplace == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_endplace = $x_endplace;
			ewrpt_SetupDistinctValues($GLOBALS["val_endplace"], $x_endplace, $t_endplace, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_endplace"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_endplace"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('startdate');
			ClearSessionSelection('startplace');
			ClearSessionSelection('vehicletype');
			ClearSessionSelection('vehiclenumber');
			ClearSessionSelection('enddate');
			ClearSessionSelection('endplace');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Startdate selected values

	if (is_array(@$_SESSION["sel_tripdetailssmry_startdate"])) {
		LoadSelectionFromSession('startdate');
	} elseif (@$_SESSION["sel_tripdetailssmry_startdate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_startdate"] = "";
	}

	// Get Startplace selected values
	if (is_array(@$_SESSION["sel_tripdetailssmry_startplace"])) {
		LoadSelectionFromSession('startplace');
	} elseif (@$_SESSION["sel_tripdetailssmry_startplace"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_startplace"] = "";
	}

	// Get Vehicletype selected values
	if (is_array(@$_SESSION["sel_tripdetailssmry_vehicletype"])) {
		LoadSelectionFromSession('vehicletype');
	} elseif (@$_SESSION["sel_tripdetailssmry_vehicletype"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_vehicletype"] = "";
	}

	// Get Vehiclenumber selected values
	if (is_array(@$_SESSION["sel_tripdetailssmry_vehiclenumber"])) {
		LoadSelectionFromSession('vehiclenumber');
	} elseif (@$_SESSION["sel_tripdetailssmry_vehiclenumber"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_vehiclenumber"] = "";
	}

	// Get Enddate selected values
	if (is_array(@$_SESSION["sel_tripdetailssmry_enddate"])) {
		LoadSelectionFromSession('enddate');
	} elseif (@$_SESSION["sel_tripdetailssmry_enddate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_enddate"] = "";
	}

	// Get Endplace selected values
	if (is_array(@$_SESSION["sel_tripdetailssmry_endplace"])) {
		LoadSelectionFromSession('endplace');
	} elseif (@$_SESSION["sel_tripdetailssmry_endplace"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_endplace"] = "";
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
				$nDisplayGrps = ALL; // Non-numeric, load default
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
			$nDisplayGrps = All; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_tripdetailssmry_$parm"] = "";
	$_SESSION["rf_tripdetailssmry_$parm"] = "";
	$_SESSION["rt_tripdetailssmry_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_tripdetailssmry_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_tripdetailssmry_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_tripdetailssmry_$parm"];
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

	// Field vehicletype
	// Setup your default values for the popup filter below, e.g.
	// $seld_vehicletype = array("val1", "val2");

	$GLOBALS["seld_vehicletype"] = "";
	$GLOBALS["sel_vehicletype"] =  $GLOBALS["seld_vehicletype"];

	// Field vehiclenumber
	// Setup your default values for the popup filter below, e.g.
	// $seld_vehiclenumber = array("val1", "val2");

	$GLOBALS["seld_vehiclenumber"] = "";
	$GLOBALS["sel_vehiclenumber"] =  $GLOBALS["seld_vehiclenumber"];

	// Field startdate
	// Setup your default values for the popup filter below, e.g.
	// $seld_startdate = array("val1", "val2");

	$GLOBALS["seld_startdate"] = "";
	$GLOBALS["sel_startdate"] =  $GLOBALS["seld_startdate"];

	// Field startplace
	// Setup your default values for the popup filter below, e.g.
	// $seld_startplace = array("val1", "val2");

	$GLOBALS["seld_startplace"] = "";
	$GLOBALS["sel_startplace"] =  $GLOBALS["seld_startplace"];

	// Field enddate
	// Setup your default values for the popup filter below, e.g.
	// $seld_enddate = array("val1", "val2");

	$GLOBALS["seld_enddate"] = "";
	$GLOBALS["sel_enddate"] =  $GLOBALS["seld_enddate"];

	// Field endplace
	// Setup your default values for the popup filter below, e.g.
	// $seld_endplace = array("val1", "val2");

	$GLOBALS["seld_endplace"] = "";
	$GLOBALS["sel_endplace"] =  $GLOBALS["seld_endplace"];
}

// Check if filter applied
function CheckFilter() {

	// Check vehicletype popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_vehicletype"], $GLOBALS["sel_vehicletype"]))
		return TRUE;

	// Check vehiclenumber popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_vehiclenumber"], $GLOBALS["sel_vehiclenumber"]))
		return TRUE;

	// Check startdate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_startdate"], $GLOBALS["sel_startdate"]))
		return TRUE;

	// Check startplace popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_startplace"], $GLOBALS["sel_startplace"]))
		return TRUE;

	// Check enddate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_enddate"], $GLOBALS["sel_enddate"]))
		return TRUE;

	// Check endplace popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_endplace"], $GLOBALS["sel_endplace"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field vehicletype
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_vehicletype"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_vehicletype"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Vehicletype<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field vehiclenumber
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_vehiclenumber"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_vehiclenumber"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Vehiclenumber<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

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

	// Field startplace
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_startplace"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_startplace"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Startplace<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field enddate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_enddate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_enddate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Enddate<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field endplace
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_endplace"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_endplace"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Endplace<br />";
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
	if (is_array($GLOBALS["sel_vehicletype"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_vehicletype"], "`vehicletype`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_vehicletype"], $GLOBALS["gb_vehicletype"], $GLOBALS["gi_vehicletype"], $GLOBALS["gq_vehicletype"]);
	}
	if (is_array($GLOBALS["sel_vehiclenumber"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_vehiclenumber"], "`vehiclenumber`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_vehiclenumber"], $GLOBALS["gb_vehiclenumber"], $GLOBALS["gi_vehiclenumber"], $GLOBALS["gq_vehiclenumber"]);
	}
	if (is_array($GLOBALS["sel_startdate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_startdate"], "`startdate`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_startdate"], $GLOBALS["gb_startdate"], $GLOBALS["gi_startdate"], $GLOBALS["gq_startdate"]);
	}
	if (is_array($GLOBALS["sel_startplace"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_startplace"], "`startplace`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_startplace"], $GLOBALS["gb_startplace"], $GLOBALS["gi_startplace"], $GLOBALS["gq_startplace"]);
	}
	if (is_array($GLOBALS["sel_enddate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_enddate"], "`enddate`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_enddate"]);
	}
	if (is_array($GLOBALS["sel_endplace"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_endplace"], "`endplace`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_endplace"]);
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
			$_SESSION["sort_tripdetailssmry_startdate"] = "";
			$_SESSION["sort_tripdetailssmry_startplace"] = "";
			$_SESSION["sort_tripdetailssmry_vehicletype"] = "";
			$_SESSION["sort_tripdetailssmry_vehiclenumber"] = "";
			$_SESSION["sort_tripdetailssmry_driver"] = "";
			$_SESSION["sort_tripdetailssmry_starttime"] = "";
			$_SESSION["sort_tripdetailssmry_startreading"] = "";
			$_SESSION["sort_tripdetailssmry_enddate"] = "";
			$_SESSION["sort_tripdetailssmry_endtime"] = "";
			$_SESSION["sort_tripdetailssmry_endplace"] = "";
			$_SESSION["sort_tripdetailssmry_endreading"] = "";
			$_SESSION["sort_tripdetailssmry_expensesincurred"] = "";
			$_SESSION["sort_tripdetailssmry_wload"] = "";
			$_SESSION["sort_tripdetailssmry_remarks"] = "";
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
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	
	document.location = "tripdetailssmry.php?fromdate=" +fdate + "&todate=" +tdate;
}

</script>