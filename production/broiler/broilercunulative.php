<?php
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL); 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <!--<style type="text/css">
        thead tr {
            position: absolute; 
            height:30px;
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
<?php
session_start();
ob_start();

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 

if(!isset($_GET['cullflag']))
$cullflag = 0;
else
{
 if($_GET['cullflag'] == "Culled Flocks")
 {
  $cullflag = 1;
 }
 else
 {
  $cullflag = 0;
 }
}
$totalsentbirds = 0;
$totalsentweight = 0;

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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Broiler Cumulative Report</font></strong></td></tr><tr><td colspan="2" align="center"><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></font></td>
</tr>

</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Report1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Report1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Report1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Report1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Report1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Report1_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ac_financialpostings";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT count(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "date >='$fromdate' and date <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "broiler_daily_entry.supervisior", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `supervisior` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_flock = NULL; // Popup filter for flock
$af_supervisior = NULL; // Popup filter for supervisior
$af_place = NULL; // Popup filter for place
$af_farm = NULL; // Popup filter for farm
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
$nDisplayGrps = 100; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_SUPERVISIOR_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.supervisior FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SUPERVISIOR_SQL_ORDERBY = "broiler_daily_entry.supervisior";
/*$EW_REPORT_FIELD_PLACE_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.place FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PLACE_SQL_ORDERBY = "broiler_daily_entry.place";
$EW_REPORT_FIELD_FARM_SQL_SELECT = "SELECT DISTINCT broiler_daily_entry.farm FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FARM_SQL_ORDERBY = "broiler_daily_entry.farm";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT (broiler_daily_entry.flock) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "(broiler_daily_entry.flock)";
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT (broiler_daily_entry.entrydate) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "(broiler_daily_entry.entrydate)";*/
?>
<?php

// Field variables
$x_flock = NULL;
$x_supervisior = NULL;
$x_place = NULL;
$x_farm = NULL;

// Group variables
$o_supervisior = NULL; $g_supervisior = NULL; $dg_supervisior = NULL; $t_supervisior = NULL; $ft_supervisior = 200; $gf_supervisior = $ft_supervisior; $gb_supervisior = ""; $gi_supervisior = "0"; $gq_supervisior = ""; $rf_supervisior = NULL; $rt_supervisior = NULL;
$o_place = NULL; $g_place = NULL; $dg_place = NULL; $t_place = NULL; $ft_place = 200; $gf_place = $ft_place; $gb_place = ""; $gi_place = "0"; $gq_place = ""; $rf_place = NULL; $rt_place = NULL;
$o_farm = NULL; $g_farm = NULL; $dg_farm = NULL; $t_farm = NULL; $ft_farm = 200; $gf_farm = $ft_farm; $gb_farm = ""; $gi_farm = "0"; $gq_farm = ""; $rf_farm = NULL; $rt_farm = NULL;

// Detail variables
$o_flock = NULL; $t_flock = NULL; $ft_flock = 200; $rf_flock = NULL; $rt_flock = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 2;
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
$col = array(FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_supervisior = "";
$seld_supervisior = "";
$val_supervisior = "";
$sel_place = "";
$seld_place = "";
$val_place = "";
$sel_farm = "";
$seld_farm = "";
$val_farm = "";
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
<?php $jsdata = ewrpt_GetJsData($val_supervisior, $sel_supervisior, $ft_supervisior) ?>
ewrpt_CreatePopup("Report1_supervisior", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_place, $sel_place, $ft_place) ?>
ewrpt_CreatePopup("Report1_place", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_farm, $sel_farm, $ft_farm) ?>
ewrpt_CreatePopup("Report1_farm", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("Report1_flock", [<?php echo $jsdata ?>]);
</script>
<div id="Report1_supervisior_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report1_place_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report1_farm_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report1_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<center>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="broilercunulative.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="broilercunulative.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="broilercunulative.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broilercunulative.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="broilercunulative.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr><td>
	<div class="ewGridUpperPanel" align="left">

Flock Type&nbsp;
<select id="cullflag" name="cullflag" onChange="reloadpage();">
<option value="">-Select-</option>
<option value="Live Flocks" <?php if($cullflag == 0) { ?> selected="selected" <?php } ?>>Live Flocks</option>
<option value="Culled Flocks" <?php if($cullflag == 1) { ?> selected="selected" <?php } ?>>Culled Flocks</option>
</select>
</div>
</td>
<td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
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
if(1) {

	// Show header
	if (1) {
?>
	<thead>
	<tr>
    <?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Supervisor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supervisor</td>
			</tr></table>
		</td>
<?php } ?>
    <?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
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
		Date(last sale)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date(last sale)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Hatch Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Hatch Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Opening Birds">
		O.Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Opening Birds"><tr>
			<td>O.Birds</td>
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
		<td valign="bottom" class="ewTableHeader" title="Mortality">
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
		<td valign="bottom" class="ewTableHeader" title="Mortality %">
		Mort %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Mortality %">Mort %</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Actual Feed Consumption">
		Act F.C
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Actual Feed Consumption"><tr>
			<td>Act F.C</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Production Cost">
        P.Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Production Cost"><tr>
			<td>P.Cost</td>
			</tr></table>
		</td>
<?php } ?>
<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Remaining">
		Feed Rem
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Feed Remaining"><tr>
			<td>Feed Rem</td>
			</tr></table>
		</td>
<?php } ?><?php */?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Closing Birds">
		C.Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Closing Birds"><tr>
			<td>C.Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="F.C.R">
		F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="F.C.R"><tr>
			<td>F.C.R</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Birds Lifted">
		Birds Lifted
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Birds Lifted"><tr>
			<td>Birds Lifted</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Birds Weight">
		Birds Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Birds Weight"><tr>
			<td>Birds Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Avg Weight">
		Avg Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Avg Weight"><tr>
			<td>Avg Weight</td>
			</tr></table>
		</td>
<?php } ?>

<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Growing Charges Paid">
		Gc Paid
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Growing Charges Paid"><tr>
			<td>Gc Paid</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Excess/Shortage">
		Exce/Short
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Excess/Shortage"><tr>
			<td>Exce/Short</td>
			</tr></table>
		</td>
<?php } ?><?php */?>
<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost/Kg">
		Cost/Kg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cost/Kg"><tr>
			<td>Cost/Kg</td>
			</tr></table>
		</td>
<?php } ?><?php */?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost Of Medicine">
		MedCost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cost Of Medicine"><tr>
			<td>MedCost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost of Feed">
		FeedCost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cost Of feed"><tr>
			<td>FeedCost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost Of Chicks">
		ChickCost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cost Of Chicks"><tr>
			<td>ChickCost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost Of Admin">
		AdminCost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cost Of Admin"><tr>
			<td>AdminCost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Production Cost">
		ProduCost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Production Cost"><tr>
			<td>ProduCost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="EEF">
		EEF
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="EEF"><tr>
			<td>EEF</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="production Incentives">
		Prod(Ince/Rcvry)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Production Incentives"><tr>
			<td>Prod(Ince/Rcvry)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Out">
		FeedOut
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Feed Out"><tr>
			<td>FeedOut</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="1 Week Mortality">
		1st Wk Mort
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="1 Week Mortality"><tr>
			<td>1st Wk Mort</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="1 Week Mortality Percentage">
		1st Wk Mort%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="1 Week Mortality Percentage"><tr>
			<td>1st Wk Mort%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Culls">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Culls"><tr>
			<td>Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Total Cost">
		Total Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Total Cost"><tr>
			<td>Total Cost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Shortage Of Birds Recovery">
		Short.Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Shortage Of Birds Recovery"><tr>
			<td>Short.Birds</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Mortality Incentive">
		Mort Incen
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Mortality Incentive"><tr>
			<td>Mort Incen</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Rate Incentive">
		Rate Incen
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Rate Incentive"><tr>
			<td>Rate Incen</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Recovery of 1week Mortality">
		Recov 1st Mort
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Recovery of 1week Mortality"><tr>
			<td>Recov 1st Mort</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="TDS @1.000">
		TDS @1.000
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="TDS @1.000"><tr>
			<td>TDS @1.000</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="NET Amount Payable">
		NET/Pay
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="NET Amount Payable"><tr>
			<td>NET/Pay</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Other Debits">
		Other Debits
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Other Debits"><tr>
			<td>Other Debits</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Bird Sale">
		Bird Sale
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Bird Sale"><tr>
			<td>Bird Sale</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Equip Sale">
		Equip Sale
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Equip Sale"><tr>
			<td>Equip Sale</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Less Gc Adv Paid">
		Less GC Paid
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Less Gc Adv Paid"><tr>
			<td>Less GC Paid</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title=" Gc Paid per Bird">
		Gc/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title=" Gc Paid per Bird"><tr>
			<td> Gc/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title=" Add Production Cost Incentives">
		 Prod.Cost Penality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title=" Add Production Cost Incentives"><tr>
			<td> Prod.Cost Penality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title=" Feed In">
		Feed In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title=" Feed In"><tr>
			<td>Feed In</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Production Cost Per Kg">
		ProdCost/Kg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title=" Production Cost Per Kg"><tr>
			<td>ProdCost/Kg</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
		$obtotal = 0;
		$cbtotal = 0;
		$morttotal = 0;
		$feedconstotal = 0;
		$totprodcost = 0;
		$totfeedrem = 0;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_supervisior, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_supervisior, EW_REPORT_DATATYPE_STRING, $gb_supervisior, $gi_supervisior, $gq_supervisior);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
	if (1) { // Loop detail records
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

		// Show group values
		$dg_supervisior = $x_supervisior;
		if ((is_null($x_supervisior) && is_null($o_supervisior)) ||
			(($x_supervisior <> "" && $o_supervisior == $dg_supervisior) && !ChkLvlBreak(1))) {
			$dg_supervisior = "&nbsp;";
		} elseif (is_null($x_supervisior)) {
			$dg_supervisior = EW_REPORT_NULL_LABEL;
		} elseif ($x_supervisior == "") {
			$dg_supervisior = EW_REPORT_EMPTY_LABEL;
		}
		$dg_place = $x_place;
		if ((is_null($x_place) && is_null($o_place)) ||
			(($x_place <> "" && $o_place == $dg_place) && !ChkLvlBreak(2))) {
			$dg_place = "&nbsp;";
		} elseif (is_null($x_place)) {
			$dg_place = EW_REPORT_NULL_LABEL;
		} elseif ($x_place == "") {
			$dg_place = EW_REPORT_EMPTY_LABEL;
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
		$oldsuper = "";
		$oldfarm = "";
		
		
	   if($_SESSION['db'] == "feedatives")
		{
		   if($_SESSION['sectorr'] == "all")
		   {
		   $query = "SELECT distinct(supervisior) FROM broiler_daily_entry WHERE client = '$client' ORDER BY supervisior ASC ";
		   }
		   else
		   {
		   $sectorr = $_SESSION['sectorr'];
		   $query = "SELECT distinct(supervisior) FROM broiler_daily_entry WHERE client = '$client' and place = '$sectorr' ORDER BY supervisior ASC ";
		   }
		   
		 }
	   else
	   {
	   $query = "SELECT distinct(supervisior) FROM broiler_daily_entry WHERE client = '$client' and entrydate >='$fromdate' and entrydate <= '$todate' ORDER BY supervisior ASC ";
	   }
		
		 //$querysup = "SELECT distinct(supervisior) from broiler_daily_entry order by supervisior  ";  
		 $resultsup = mysql_query($query,$conn1);   
		 $rowsup = mysql_num_rows($resultsup);
   while($rowsup = mysql_fetch_assoc($resultsup))  {  
  if($cullflag == 0){ 
 $queryfrm = "SELECT distinct(flock),max(entrydate) as sam1 from broiler_daily_entry where   flock not in (select distinct(flock) from broiler_transferrate) and entrydate >='$fromdate' and entrydate <= '$todate' group by flock  order by max(age) desc   ";  $resultfrm = mysql_query($queryfrm,$conn1);
  }
  else
  {
 $queryfrm = "SELECT distinct(flock),max(entrydate) as sam from broiler_daily_entry where  flock in (select distinct(flock) from broiler_transferrate) and entrydate >='$fromdate' and entrydate <= '$todate' group by flock  order by max(entrydate) desc  ";  $resultfrm = mysql_query($queryfrm,$conn1);
  }
     $rowfrm = mysql_num_rows($resultfrm);
   while($rowfrm = mysql_fetch_assoc($resultfrm))  {  
   
   
 /*$queryflk = "SELECT distinct(flock) from broiler_daily_entry where farm = '$rowfrm[farm]' and supervisior = '$rowsup[supervisior]' and entrydate >='$fromdate' and entrydate <= '$todate' group by flock  order by max(entrydate) desc  ";  $resultflk = mysql_query($queryflk,$conn1);   $rowflk = mysql_num_rows($resultflk);
   while($rowflk = mysql_fetch_assoc($resultflk))  {  */
  //$dg_supervisior = $rowsup['supervisior'];
//  $dg_farm = $rowfrm['farm'];


  $x_flock = $rowfrm['flock'];
  $dg_supervisior = $rowsup['supervisior'];
  $x_1 = $rowfrm['sam'];
   if($cullflag == 0){ 
   $x_1 = $rowfrm['sam1'];
   }
  $startdate = "";
$enddate = "";
$age = 0;
$gap = "";
$nxtdate = "";
$totalmortality = 0;
$bodyweight = 0;
$birds = 0;
$soldbirds = 0;
$cbirds = 0;
$feedcons = 0;
$cumfeedstd = 0;
$bodywtstd = 0;
$queryfrm1 = "SELECT distinct(farm) from broiler_daily_entry where  flock ='$x_flock'  ";  $resultfrm1 = mysql_query($queryfrm1,$conn1);
  
     $rowfrm1 = mysql_num_rows($resultfrm1);
   while($rowfrm1= mysql_fetch_assoc($resultfrm1))  {
  $farm = $rowfrm1['farm'];
    
   

 $query1 = "SELECT max(cullflag) as cflag FROM broiler_daily_entry WHERE  flock = '$rowfrm[flock]' and entrydate >='$fromdate' and entrydate <= '$todate' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	  
	   $cflag = $row1['cflag'];
	 }
	 //echo $rowfrm['farm']."/".$rowflk['flock']."/".$cflag;echo "</br>";
	if($cullflag == $cflag)
	{
?>
	<tr>
    <td class="ewRptGrpField1">
		<?php $t_supervisior = $x_supervisior; $x_supervisior = $dg_supervisior; ?>
<?php if($x_supervisior <> $oldsuper) { echo ewrpt_ViewValue($x_supervisior); $oldsuper = $x_supervisior; } else { echo ewrpt_ViewValue("&nbsp;"); } ?>
		<?php ?></td>
    
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($farm) ?>
</td>
		
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flock) ?>
</td>
<?php

 $query111 = "SELECT sum(quantity) as chicks FROM ims_stocktransfer where aflock = '$x_flock'  and (cat = 'Broiler Chicks' or cat='Broiler Day Old Chicks')  "; $result111 = mysql_query($query111,$conn1);  $rows = mysql_num_rows($result111);
 if ( $rows > 0) { while($row111 = mysql_fetch_assoc($result111)) { $birds = $birds + $row111['chicks']; } }
 
/* $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$x_flock' and warehouse = '$x_farm'  and (category = 'Broiler Chicks' or category='Broiler Day Old Chicks'  ";  */
  $query111 = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$x_flock'   and description = 'Broiler Chicks'"; 
   $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $birds = $birds + $row111['chicks'];  } }
  
  $query111 = "SELECT sum(birds) as chicks FROM oc_cobi where flock = '$x_flock'  and code in (select distinct(code) from ims_itemcodes where cat = 'Broiler Birds' )  ";  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $soldbirds = $row111['chicks'];  } }

  if($_SESSION[db]=='mallikarjunkld')
   {
  $query111 = "SELECT birds as chicks from broiler_chickentransfer where flock = '$x_flock'"; $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $chickentransfer = $row111['chicks'];  } }
  }
 // broiler send birds calculation
 $sentbirds = 0;
 $sentweight = 0;
if($_SESSION['db'] == 'central')
{
  $sentquery = "SELECT sum(birds) as birds,sum(weight) as weight from broiler_chickentransfer where flock = '$x_flock'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
  $totalsentbirds += $sentbirds = $sentres['birds']; 
  $totalsentweight +=$sentweight = $sentres['weight']; 
  }
  
  //date
  
  $query1 = "SELECT flock FROM broiler_daily_entry WHERE farm = '$farm' AND entrydate < (SELECT min(entrydate) FROM broiler_daily_entry WHERE farm = '$farm' AND flock = '$x_flock') AND cullflag = 1 ORDER BY entrydate DESC LIMIT 1";	  

$result1 = mysql_query($query1,$conn1) or die(mysql_error());
if($rows1 = mysql_fetch_assoc($result1))
{
	$pvflock = $rows1['flock'];
	$query2 = "SELECT max(entrydate) as date FROM broiler_daily_entry where farm = '$farm' and flock = '$pvflock' AND client = '$client' AND cullflag = 1";
	$result2 = mysql_query($query2,$conn1) or die(mysql_error());
	if($rows2 = mysql_fetch_assoc($result2))
	$pvflockculldate = date("Y-m-d",(strtotime($rows2['date']) + (24 * 60 * 60)));
}
if($pvflockculldate == "")
{
  $query1 = "SELECT min(entrydate) AS mindate FROM broiler_daily_entry WHERE farm = '$farm' AND flock = '$x_flock'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($result1);
  $flockstartdate = $pvflockculldate = $rows1['mindate'];
 $pvflockculldate = "2000-01-01";
}
  
  
  
  
  
  $query100 = "SELECT entrydate as date FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' AND client = '$client' AND cullflag = 1 ORDER BY entrydate DESC LIMIT 1";
$result100 = mysql_query($query100,$conn1) or die(mysql_error());
if($rows100 = mysql_fetch_assoc($result100))
{
 $culldate = $rows100['date'];
 $tempcull = 1;
} 
else
 $culldate = date("Y-m-d");


  $query101 = "SELECT min(entrydate) AS mindate FROM broiler_daily_entry WHERE farm = '$farm' AND flock = '$x_flock'";
 $result101 = mysql_query($query101,$conn1) or die(mysql_error());
 $rows101 = mysql_fetch_assoc($result101);
   $flockstartdate = $rows101['mindate'];


if($tempcull == "1")
{
 $query102 = "SELECT entrydate FROM broiler_daily_entry WHERE farm = '$farm' AND entrydate > (SELECT max(entrydate) FROM broiler_daily_entry WHERE farm = '$farm' AND flock = '$x_flock') ORDER BY entrydate LIMIT 1";	  
$result102 = mysql_query($query102,$conn1) or die(mysql_error());
if($rows102 = mysql_fetch_assoc($result102))
 $nextflockstartdate = date("Y-m-d",(strtotime($rows102['entrydate']) - (24 * 60 * 60)));
else 
 $nextflockstartdate = date("Y-m-d");
}
else
 $nextflockstartdate = $culldate;
  
  
   $query109 = "SELECT min(entrydate) as startdate, max(entrydate) as enddate FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' AND client = '$client'";
           $result109 = mysql_query($query109,$conn1); 
           while($row109 = mysql_fetch_assoc($result109))
           {
             $startdate = $row109['startdate'];
		     $enddate = $row109['enddate'];
           }
  
  
  
  //f.c.r
  
           
 $query = "SELECT SUM(feedconsumed) as sum FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' ORDER BY entrydate ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
              $consumed = $row1['sum'];
			  
           }
        
           
           $query2 = "SELECT SUM(quantity) as sum, SUM(birds) as birds,sum(weight) as weight FROM oc_cobi where farm = '$farm' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' ORDER BY date ASC"; 
           $result2 = mysql_query($query2,$conn1); 
           while($row2 = mysql_fetch_assoc($result2))
           {
                   $farmweight = $row2['sum'];
                   $birdssold = $row2['birds'];
				   $weight = $row2['weight'];
           }
		  $farmweight+=$sentweight;
		 
		$farmweight1=$farmweight;
		 
		 //avg weight
		 
		 
		
          $query = "SELECT SUM(quantity)/SUM(birds) as sum, SUM(quantity) as sum1 FROM oc_cobi where farm = '$farm' and ( date BETWEEN '$flockstartdate' AND '$nextflockstartdate')AND client = '$client'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
		 $avgweight1 = round($row1['sum'],2);
		 $avgweight4 = $row1['sum1'];
           }
               $query1 = "SELECT max(average_weight) as avgwt FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' and client = '$client'";
 	         $result1 = mysql_query($query1,$conn1);
               while($row1 = mysql_fetch_assoc($result1))
               {
		     $avgweight2 = $row1['avgwt']/1000;
               }
//if(($avgweight1 == "") || ($avgweight1 <= 0)) { echo $avgweight = $avgweight1; } else { $avgweight = $avgweight2; }
//if($avgweight1 >= $avgweight2) { $avgweight = $avgweight1; } else { $avgweight = $avgweight2; }
             if($avgweight1)
			 $avgweight = $avgweight1;
			 else
			 $avgweight = $avgweight2;
  
  $fcr1 = round($consumed / $farmweight, 2);
  //int charges
   $query = "SELECT FCRRATE FROM broiler_fcrrate where FCR = '$fcr1' ORDER BY FCRRATE ASC";
           $result = mysql_query($query,$conn1);
           while($row1 = mysql_fetch_assoc($result))
               {
                 $fcrrate = $row1['FCRRATE'];
               }
			   
			   
			   $query = "SELECT SUM(quantity) as chicks, SUM(free) as freechicks,SUM(tmort) as mort, SUM(shortage) as shortage,date FROM ims_stocktransfer where towarehouse = '$farm' and aflock = '$x_flock' and ( cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' ) and date >'$pvflockculldate' and date <= '$culldate' AND client='$client'";
            $result = mysql_query($query,$conn1);
            while($row1 = mysql_fetch_assoc($result))
               {
              $chicks = $row1['chicks'] + $row1['freechicks'] - $row1['mort'] - $row1['shortage'];
			$chicksdate= date("d.m.Y",strtotime($row1['date']));
               }
       $query111a = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where date > '$pvflockculldate' AND date <= '$culldate' and warehouse = '$farm' and description = 'Broiler Chicks'  AND client='$client'"; 
 $result111a = mysql_query($query111a,$conn1); 
  $rowsa = mysql_num_rows($result111a);

   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $chicks = $chicks + $row111a['chicks'];  } }
   
   
   

           
           $query = "SELECT SUM(mortality) as sum FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' ORDER BY entrydate ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $mort = $row1['sum'];
           }
     
     
           
           $query = "SELECT SUM(cull) as sum FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' ORDER BY entrydate ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
              $cull = $row1['sum'];
           }
     

		   
			   
			   
  if($fcrrate == "") $fcrrate = 0;
  
  
  
  //cost/kg
  
  
  
  $query = "SELECT sum(quantity) as totalamount FROM ims_stocktransfer where towarehouse = '$farm' AND ( cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' ) and date >'$pvflockculldate' and date <= '$culldate' AND client = '$client'";


$result = mysql_query($query,$conn1);
           $row1 = mysql_fetch_assoc($result);
           $chickcost = round($row1['totalamount'],2);
		   
		   
		   $query = "SELECT SUM(quantity) as sum FROM ims_stocktransfer where towarehouse = '$farm' and cat = 'Broiler Feed' and date BETWEEN '$pvflockculldate' AND '$culldate' AND client = '$client'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
            $feedcost = $row1['sum'] ;
		  
			  
           }
      $query = "SELECT SUM(quantity) as sum FROM ims_stocktransfer where fromwarehouse = '$farm' and cat = 'Broiler Feed' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' AND client='$client'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
         $feedcost1 = $row1['sum'] ; 
			
           }
 $feed = $feedcost - $feedcost1;
			
		   
		   $query = "select fcost,ccost,mcost,ocost from broiler_growingcharges where flag = 'F' and '$culldate' between fromdate and todate";
$feedress = mysql_query($query,$conn1) or die(mysql_error());
$feedres = mysql_fetch_assoc($feedress);
$chickrate = $feedres['ccost'];
$managecost = $feedres['mcost'];
$ohcost = $feedres['ocost'];
$feedrate = $feedres['fcost'];
$feed *= $feedrate;
		   
		   
		   
		   
		    $chickcost *= $chickrate;
			
			
			
			
			
			
      $query = "select medcost from broiler_growingcharges where '$culldate' between fromdate and todate";
	  $result = mysql_query($query,$conn1) or die(mysql_error());
	  while($res = mysql_fetch_assoc($result))
	  if($res['medcost'])
	  $medcostperbird = $res['medcost'];
	  
	  
	   

	  
	  $medcost = $chicks * $medcostperbird;
	  
	 
	  $query11 = "SELECT SUM(weight) as sum1 FROM broiler_shopreceipt where farm = '$farm' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' ORDER BY date ASC ";
           $result11 = mysql_query($query11,$conn1); 
           while($row11 = mysql_fetch_assoc($result11))
           {
            $shopweight = $row11['sum1'];
           }
		 
		  if($shopweight == "") { }
		   
		   
		   $weightloss = round(($farmweight - $shopweight),2);
		   
		   
		   
		   $query = "SELECT SUM(weight * price) as sum, SUM(weight) as weight1 FROM broiler_shopreceipt where farm = '$farm' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' ORDER BY date ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
 		  $weightlossa = $row1['sum'];
 		  $weight1 = $row1['weight1'];
  	     }
			$weightlossrate = round($weightloss * ($weightlossa/$weight1),2);
			
			
			 $query = "SELECT rate  FROM broiler_transferrate where farmer ='$farm' AND flock ='$x_flock'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
              $transferrate = $row1['rate'];
			  
           }			
	  $admincost = round($chicks * $managecost);
	  
	  $totalcostal = round($chickcost + $medcost + $feed +  $admincost ,2) ;
	 $costperkgal = round($totalcostal / $farmweight, 2);
	  
	  
	   $query1 = "SELECT * FROM broiler_growingcharges WHERE subflag = 'P' and flag ='G' AND (('$startdate' BETWEEN fromdate AND todate) OR ('$enddate' BETWEEN fromdate AND todate)) AND ($costperkgal BETWEEN catfrom AND catto)";
	  $result1 = mysql_query($query1,$conn1) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
 $fcrcost = $rows1['rate1'];
 $amount = round($fcrcost * $farmweight,2);
$saleamount=0;
$query = "SELECT SUM(quantity * price) as sum,sum(quantity) as quantity,AVG(price) as avgprice,max(price) as maxprice FROM oc_cobi where farm = '$farm' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' ORDER BY date ASC";     
		   $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
          	$saleamount = $row1['sum'];
			$saleweight=$row1['quantity'];
			  $avgprice=$row1['avgprice'];
			  
           }
		   
		   $overhead = round($chicks * $ohcost);
	  
$totalcostinitial = $overhead + $admincost + $medcost + $feed + $chickcost;
$prodincenpen = 0;
$query="select productioncost,incentiveper from `broiler_growingchargesnew` where fromdate<='$culldate' and todate>='$culldate'";
	$result=mysql_query($query,$conn1);
	while($rows=mysql_fetch_assoc($result))

	{
		
		 $productioncost1=$rows['productioncost'];
		 $incentiveper = $rows['incentiveper'];
	}
   $stdprodcostnew =$saleweight*$productioncost1; 
	
	
	
		 if($totalcostinitial < $stdprodcostnew)
		{
			  $a=$stdprodcostnew-$totalcostinitial; 
			 $prodincenpen=$incentive=($a/100)*$incentiveper;
			
		}
		else
		{
			 $a=$totalcostinitial - $stdprodcostnew;
			 $penalty=($a/100)*$incentiveper;
			 $prodincenpen = -$penalty;
			 
		}
	  
	  $query="SELECT catfrom,catto,rate1,mpcost FROM `broiler_growingcharges` where ('$culldate' between fromdate and todate) and flag ='SL'";
   $result=mysql_query($query,$conn1);
   while($rows=mysql_fetch_assoc($result))
   if($prodcost < $rows['mpcost'])
   {
   		if($avgprice>=$rows['catfrom'] &&$avgprice<=$rows['catto'])
			{
			
				$rateincentive=$rows['rate1']*$saleweight;
			}
			
   }
   
   
   $query = "select incentive from broiler_mortality where ('$mortper' between frommortality and tomortality) and ('$culldate' between fromdate and todate)";
				$result = mysql_query($query,$conn1) or die(mysql_error());
				$result = mysql_fetch_assoc($result);
				$mincen = $result['incentive'];
				
	   			$mortincentive=$saleweight*$mincen;
				
				
				
				$query = "SELECT SUM(mortality) as sum FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' and age<=7 ORDER BY entrydate ASC ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $mort1 = $row1['sum'];
           }
		 $mortper1 = round (( $mort1 / $chicks ) * 100, 2);
		 
		 $query = "select catfrom,catto,rate3,rate1 from broiler_growingcharges where ('$culldate' between fromdate and todate) and flag = 'M'";
				$result = mysql_query($query,$conn1) or die(mysql_error());
				$result = mysql_fetch_assoc($result);
		$firstweekmort=$mortpenaltry=0;		
		 if($mortper1>$result['catfrom'])
			{
		    	$perdif=$mortper1-$result['catfrom'];
				$noofchicks=($chicks/100)*$perdif;
				$mortpenaltry=$noofchicks*$result['rate1'];
				$firstweekmort=$mortpenaltry;
				
			}
			if($mortper>$result['catto'])
			{
		    	$perdif=$mortper-$result['catto'];
				$noofchicks=($chicks/100)*$perdif;
				$mortpenaltry += $noofchicks*$result['rate3'];
				
			}
			
			
			$excesssh = 0;  
			$excesssh = $chicks - ($mort + $cull + $birdssold + $sentbirds);
			 
			
			$dedfar1 = 0;
			if( $excesssh > 0)
		 {
		 
		 $query = "SELECT max(price) as maxprice FROM oc_cobi where farm = '$farm' and flock='$x_flock' and date = '$culldate' and code like 'Brob%'";
		  $result = mysql_query($query,$conn1) or die(mysql_error());
		  $result = mysql_fetch_assoc($result);
		  if($result['maxprice'])
		  $maxprice = $result['maxprice'];
		  else
		  $maxprice = 60;
		 $dedfar1 = round(( $excesssh * $avgweight * $maxprice),2 ); 
		 
		 
		 }
		 
		 
		 
		 $query = "select feedshortage,birdsshortage,management,others from broiler_transferrate where farmer = '$farm' AND flock = '$x_flock'";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	$res = mysql_fetch_assoc($result);
	if(mysql_num_rows($result))
    $others = $res['feedshortage'] + $res['birdsshortage'] + $res['management'] + $res['others'];
	
	$prodincenpen;
	
	$amount = $amount +  $prodincenpen + $rateincentive + $mortincentive - $mortpenaltry- $dedfar1 + $others;
	
	$dedfar = 0;
 if($_SESSION['db'] == 'souza')
 {
  if($excesssh > 0)
 {
 $dedfar = round(( $excesssh * $avgweight * ($saleamount/$shopweight)),2 );
 }
}	
	
	 $totalcost = round($chickcost + $medcost + $feed +  $weightlossrate + $transferrate + $amount - $dedfar,2) ;
	 $totalcost1= $totalcost;
	 
	 
	 
	  $query = "SELECT min(entrydate) as startdate, max(entrydate) as enddate,max(age) as age FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' AND client = '$client'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
             $sdate = $row1['startdate'];
		     $ldate = $row1['enddate'];
			 $age1 = $row1['age'];
			} 
			
            $sdate = date($datephp, strtotime($sdate));
       	    $ldate = date($datephp, strtotime($ldate));
            $age1 = $age1 -1;
		 
  
   $query200 = "SELECT * FROM broiler_transferrate where farmer = '$farm' and flock = '$x_flock'  ";
           $result200 = mysql_query($query200,$conn1); 
           while($row200 = mysql_fetch_assoc($result200))
           {
              $numb = $row200['numb'];
              $seflag = $row200['seflag'];
           }
      
  
   if($seflag =='Excess') { $balancebirds = ($chicks) - ($mort + $cull + $sentbirds);  } else { $balancebirds = ($chicks) - ($mort+$cull + $sentbirds); } 
  
 $avgweight3 = ($avgweight4 / $balancebirds);

$mortper2 = (( $mort / $chicks ) * 100);
$fcr2 = ($consumed / $farmweight); 

$eef = round((((100 - $mortper2) *  $avgweight3 ) / ($age1 * $fcr2) ) * 100);


$realizationcost = round($saleamount - $totalcost,2);
  
  
   $realizationcostperkg = round($realizationcost/$shopweight, 2) ; 
  
   $amount1 = round(($amount - ($amount * 0.01)), 2);
   $query23 = "SELECT SUM(quantity) as sum23 FROM ims_stocktransfer where towarehouse = '$farm' and cat = 'Broiler Feed' and date > '$pvflockculldate' and date <= '$culldate' AND client = '$client'";
           $result23 = mysql_query($query23,$conn1); 
           while($row23 = mysql_fetch_assoc($result23))
           {
             $feedsent23 = $row23['sum23'];
           }
       
           $feedsent12 = $feedsent23; 
		
  
	 $feedin = 0;
	 $feedout = 0;
	 $feedbal = 0;
	 $query1 = "SELECT sum(quantity) as feedin from ims_stocktransfer where cat = 'Broiler Feed' and aflock = '$x_flock' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $feedin = $row1['feedin'];
	 }
	 $query1 = "SELECT sum(quantity) as feedout from ims_stocktransfer where cat = 'Broiler Feed'  and tflock = '$x_flock' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $feedout = $row1['feedout'];
	 }
	 
	 if($cullflag == 0)
	 {
	 $query1 = "SELECT max(age) as maxage,max(average_weight) as maxwt,sum(mortality) as totmort,sum(feedconsumed) as feedcons,max(cullflag) as cflag FROM broiler_daily_entry WHERE  flock = '$x_flock'  order by max(age) DESC  ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $age = $row1['maxage'];
	  
	   
	   $bodyweight = $row1['maxwt'];
	   $totalmortality = $row1['totmort'];
	   $feedcons = $row1['feedcons'];
	  $cflag = $row1['cflag'];
	 }
	 }
	else
	{
	 $query1 = "SELECT max(age) as maxage,max(average_weight) as maxwt,sum(mortality) as totmort,sum(feedconsumed) as feedcons,max(cullflag) as cflag FROM broiler_daily_entry WHERE  flock = '$x_flock'  ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $age = $row1['maxage'];
	  
	   
	   $bodyweight = $row1['maxwt'];
	   $totalmortality = $row1['totmort'];
	   $feedcons = $row1['feedcons'];
	  $cflag = $row1['cflag'];
	 }
	 }
	$startdate = $x_1; 
	 $feedbal = $feedin - $feedcons - $feedout;
	 $cbirds = $birds - $soldbirds - $totalmortality-$sentbirds;
	 if($_SESSION[db]=='mallikarjunkld') $cbirds = $birds - $soldbirds - $totalmortality - $chickentransfer;
	 $query1 = "SELECT * from broiler_allstandards where age = '$age' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   
	   $cumfeedstd = $row1['cumfeed'];
	   $bodywtstd = $row1['avgweight'];
	 }
	 $costin = 0;
	 $costout = 0;
	 $prodcost = 0;
	  $query1 = "SELECT sum(quantity * price) as costin from ims_stocktransfer where  aflock = '$x_flock' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $costin = $row1['costin'];
	 }
	  $query1 = "SELECT sum(quantity * price) as costout from ims_stocktransfer where tflock = '$x_flock' ";
	 $result1 = mysql_query($query1,$conn1);
	 while($row1 = mysql_fetch_assoc($result1))
	 {
	   $costout = $row1['costout'];
	 }
	 $prodcost = $costin - $costout;
	 
	   
          $query = "SELECT SUM(quantity) as sum FROM ims_stocktransfer where fromwarehouse = '$farm' and cat = 'Broiler Feed' and date BETWEEN '$flockstartdate' AND '$nextflockstartdate' AND client='$client'";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
            $feedreturn = $row1['sum'];
           }
		   
		   
		   $query = "SELECT sum(mortality) as mort  FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' and  age between 1 and 7 ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $mortality1week = $row1['mort'];
           }
		   $permortality=($mortality1week/$birds)*100;
		   $permort=round($permortality,2);
		   
		   
		   $query = "SELECT cull FROM broiler_daily_entry where farm = '$farm' and flock = '$x_flock' ";
           $result = mysql_query($query,$conn1); 
           while($row1 = mysql_fetch_assoc($result))
           {
               $culls = $row1['cull'];
           }
	
        ?>
	 
	 <td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($age) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php if(date("d.m.Y",strtotime($startdate)) <> "01.01.1970") echo ewrpt_ViewValue(date("d.m.Y",strtotime($startdate))); else echo ewrpt_ViewValue(); ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($chicksdate) ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($birds)); $obtotal = $obtotal + $birds; ?>
</td>
<?php if($_SESSION['db'] == 'central')
{?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($sentbirds)echo changequantity($sentbirds); else echo "0";?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($sentweight) echo changeprice($sentweight); else echo "0"; ?>
</td>
<?php } ?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($totalmortality); $morttotal = $morttotal + $totalmortality; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round((($totalmortality/$birds) * 100),2)); ?>
</td>
<?php /*?><td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice(round((($cumfeedstd/1000) * $birds),2))); ?>
</td><?php */?>
<td<?php echo $sItemRowClass; ?> align="right" <?php if($feedcons < (round((($cumfeedstd/1000) * $birds),2))) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>  >
<?php echo ewrpt_ViewValue(changeprice($feedcons)); $feedconstotal = $feedconstotal + $feedcons; ?>
</td>

<td <?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($prodcost)); $totprodcost = $totprodcost + $prodcost; ?>
</td>
<?php /*?><td<?php echo $sItemRowClass; ?> align="right">
<?php if($_SESSION['client'] == "SUMUKH" && $_GET['cullflag'] == "Culled Flocks"){ echo "0"; $totfeedremain = $totfeedremain + 0;}
else
{
 if($feedbal == 0){ echo "0";  } else { echo ewrpt_ViewValue(changeprice($feedbal)); }    
}
 ?>


</td><?php */?>
<?php $totfeedremain = $totfeedremain + $feedbal;?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($_SESSION['client'] == "SUMUKH" && $_GET['cullflag'] == "Culled Flocks"){ echo "0"; $cbtotal = $cbtotal + 0;}
else
{
if($cbirds == 0){ echo "0"; } else { echo ewrpt_ViewValue(changequantity($cbirds)); } $cbtotal = $cbtotal + $cbirds;
} ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $fcr = round($consumed / $farmweight, 2); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($birdssold=="")echo "&nbsp;";
else 
echo $birdssold; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $farmweight1; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $avgweight; ?>
</td>
<?php /*?><td<?php echo $sItemRowClass; ?> align="right">
<?php echo $fcrrate; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php $excesssh = 0; echo $excesssh = $chicks - ($mort + $cull + $birdssold + $sentbirds); ?>
</td><?php */?>
<?php /*?><td<?php echo $sItemRowClass; ?> align="right">
<?php echo $costperkg = round($totalcost / $shopweight, 2); ?>
</td><?php */?>
  <td<?php echo $sItemRowClass; ?> align="right">
<?php echo $medcost; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $feed; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $chickcost; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $admincost; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $chickcost+$admincost+$feed+$medcost; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $eef; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $realizationcostperkg; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedreturn == "") { echo "0"; } else { echo changeprice($feedreturn); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $mortality1week; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $permort; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $culls; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo $totalcost1; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($dedfar1 == "") { echo "0"; } else { echo changeprice($dedfar1); } ?> 
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($mortincentive == "") { echo "0"; } else { echo changeprice($mortincentive); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($rateincentive == "") { echo "0"; } else { echo changeprice($rateincentive); } ?>
</td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo changeprice($mortpenaltry);  ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo changeprice($amount1-$amount); ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo changeprice($amount); ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $otherdebit=0; ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $birdsale=0; ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $equp=0; ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $lessgcpaid=0; ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php  $gc=$costperkg/$birdssold;
echo round($gc,4); ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo  changeprice($penalty); ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $feedsent12; ?> </td>
<td <?php echo $sItemRowClass; ?> align="right"><?php echo $costperkgal; ?> </td>
	</tr>
<?php
}

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_supervisior = $x_supervisior;
		$o_place = $x_place;
		$o_farm = $x_farm;

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
		
		}
		}
		}
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
	<?php /*?><tr>
	<td<?php echo $sItemRowClass; ?> >
	Total
	</td>
	<td<?php echo $sItemRowClass; ?> >
	</td>
	<td<?php echo $sItemRowClass; ?> >
	</td>
	<td<?php echo $sItemRowClass; ?> >
	</td>
	<td<?php echo $sItemRowClass; ?> >
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo ewrpt_ViewValue(changeprice($obtotal)); ?>
	</td>
	<?php if($_SESSION['db'] == 'central')
{?>
<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo changeprice($totalsentbirds); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo changeprice($totalsentweight); ?>
	</td>
<?php } ?>
	<td<?php echo $sItemRowClass; ?> align="right">
	<?php echo ewrpt_ViewValue(changequantity($morttotal)); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo ewrpt_ViewValue(changeprice($feedconstotal)); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo ewrpt_ViewValue(changeprice($totprodcost)); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo ewrpt_ViewValue(changeprice($totfeedremain)); ?>
	</td>
	<td<?php echo $sItemRowClass; ?> align="right" >
	<?php echo ewrpt_ViewValue(changequantity($cbtotal)); ?>
	</td>
    <td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
    <td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
    <td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
    <td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
    <td<?php echo $sItemRowClass; ?> >
	<?php echo ewrpt_ViewValue("&nbsp;"); ?>
	</td>
	
	</tr><?php */?>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_supervisior = $x_supervisior; // Save old group value
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
	<!-- tr><td colspan="4"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="broilercumulative.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="broilercumulative.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="broilercumulative.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="broilercumulative.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="broilercumulative.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<option value="100"<?php if ($nDisplayGrps == 100) echo " selected" ?>>100</option>
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
			return (is_null($GLOBALS["x_supervisior"]) && !is_null($GLOBALS["o_supervisior"])) ||
				(!is_null($GLOBALS["x_supervisior"]) && is_null($GLOBALS["o_supervisior"])) ||
				($GLOBALS["x_supervisior"] <> $GLOBALS["o_supervisior"]);
		case 2:
			return (is_null($GLOBALS["x_place"]) && !is_null($GLOBALS["o_place"])) ||
				(!is_null($GLOBALS["x_place"]) && is_null($GLOBALS["o_place"])) ||
				($GLOBALS["x_place"] <> $GLOBALS["o_place"]) || ChkLvlBreak(1); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_supervisior"] = "";
	if ($lvl <= 2) $GLOBALS["o_place"] = "";
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
		$GLOBALS['x_supervisior'] = "";
	} else {
		$GLOBALS['x_supervisior'] = $rsgrp->fields('supervisior');
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
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_place'] = $rs->fields('place');
		$GLOBALS['x_farm'] = $rs->fields('farm');
		$val[1] = $GLOBALS['x_flock'];
	} else {
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_place'] = "";
		$GLOBALS['x_farm'] = "";
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
			ClearSessionSelection('supervisior');
			ClearSessionSelection('place');
			ClearSessionSelection('farm');
			ClearSessionSelection('flock');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Supervisior selected values

	if (is_array(@$_SESSION["sel_Report1_supervisior"])) {
		LoadSelectionFromSession('supervisior');
	} elseif (@$_SESSION["sel_Report1_supervisior"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_supervisior"] = "";
	}

	// Get Place selected values
	if (is_array(@$_SESSION["sel_Report1_place"])) {
		LoadSelectionFromSession('place');
	} elseif (@$_SESSION["sel_Report1_place"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_place"] = "";
	}

	// Get Farm selected values
	if (is_array(@$_SESSION["sel_Report1_farm"])) {
		LoadSelectionFromSession('farm');
	} elseif (@$_SESSION["sel_Report1_farm"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_farm"] = "";
	}

	// Get Flock selected values
	if (is_array(@$_SESSION["sel_Report1_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_Report1_flock"] == EW_REPORT_INIT_VALUE) { // Select all
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
			$nDisplayGrps = 100; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_Report1_$parm"] = "";
	$_SESSION["rf_Report1_$parm"] = "";
	$_SESSION["rt_Report1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Report1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Report1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Report1_$parm"];
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

	// Field supervisior
	// Setup your default values for the popup filter below, e.g.
	// $seld_supervisior = array("val1", "val2");

	$GLOBALS["seld_supervisior"] = "";
	$GLOBALS["sel_supervisior"] =  $GLOBALS["seld_supervisior"];

	// Field place
	// Setup your default values for the popup filter below, e.g.
	// $seld_place = array("val1", "val2");

	$GLOBALS["seld_place"] = "";
	$GLOBALS["sel_place"] =  $GLOBALS["seld_place"];

	// Field farm
	// Setup your default values for the popup filter below, e.g.
	// $seld_farm = array("val1", "val2");

	$GLOBALS["seld_farm"] = "";
	$GLOBALS["sel_farm"] =  $GLOBALS["seld_farm"];
}

// Check if filter applied
function CheckFilter() {

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;

	// Check supervisior popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_supervisior"], $GLOBALS["sel_supervisior"]))
		return TRUE;

	// Check place popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_place"], $GLOBALS["sel_place"]))
		return TRUE;

	// Check farm popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_farm"], $GLOBALS["sel_farm"]))
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
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "(broiler_daily_entry.flock)", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"]);
	}
	if (is_array($GLOBALS["sel_supervisior"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_supervisior"], "broiler_daily_entry.supervisior", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_supervisior"], $GLOBALS["gb_supervisior"], $GLOBALS["gi_supervisior"], $GLOBALS["gq_supervisior"]);
	}
	if (is_array($GLOBALS["sel_place"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_place"], "broiler_daily_entry.place", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_place"], $GLOBALS["gb_place"], $GLOBALS["gi_place"], $GLOBALS["gq_place"]);
	}
	if (is_array($GLOBALS["sel_farm"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_farm"], "broiler_daily_entry.farm", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_farm"], $GLOBALS["gb_farm"], $GLOBALS["gi_farm"], $GLOBALS["gq_farm"]);
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
			$_SESSION["sort_Report1_supervisior"] = "";
			$_SESSION["sort_Report1_place"] = "";
			$_SESSION["sort_Report1_farm"] = "";
			$_SESSION["sort_Report1_flock"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "(broiler_daily_entry.flock) ASC";
		$_SESSION["sort_Report1_flock"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">
function reloadpage()
{
	var cullflag = document.getElementById('cullflag').value;
	var fromdate = document.getElementById('fromdate').value;
	
	var todate = document.getElementById('todate').value;
	
	document.location = "broilercunulative.php?cullflag=" + cullflag+ "&fromdate=" + fromdate + "&todate=" + todate ;
}
</script>
