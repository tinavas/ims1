<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<center>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "reportheader.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Chicken_Transfer", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Chicken_Transfer_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Chicken_Transfer_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Chicken_Transfer_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Chicken_Transfer_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Chicken_Transfer_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "chicken_chickentransfer";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT chicken_chickentransfer.date, chicken_chickentransfer.tid, chicken_chickentransfer.fromtype, chicken_chickentransfer.fromcode, chicken_chickentransfer.fromdescription, chicken_chickentransfer.birds, chicken_chickentransfer.tocode, chicken_chickentransfer.todescription, chicken_chickentransfer.units, chicken_chickentransfer.quantity, chicken_chickentransfer.narration, chicken_chickentransfer.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "chicken_chickentransfer.date ASC, chicken_chickentransfer.tid ASC, chicken_chickentransfer.fromcode ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "chicken_chickentransfer.date", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(chicken_chickentransfer.birds) AS SUM_birds, SUM(chicken_chickentransfer.quantity) AS SUM_quantity FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = NULL; // Popup filter for date
$af_tid = NULL; // Popup filter for tid
$af_fromtype = NULL; // Popup filter for fromtype
$af_fromcode = NULL; // Popup filter for fromcode
$af_fromdescription = NULL; // Popup filter for fromdescription
$af_birds = NULL; // Popup filter for birds
$af_tocode = NULL; // Popup filter for tocode
$af_todescription = NULL; // Popup filter for todescription
$af_units = NULL; // Popup filter for units
$af_quantity = NULL; // Popup filter for quantity
$af_narration = NULL; // Popup filter for narration
$af_unit = NULL; // Popup filter for unit
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
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "chicken_chickentransfer.date";
$EW_REPORT_FIELD_FROMCODE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.fromcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMCODE_SQL_ORDERBY = "chicken_chickentransfer.fromcode";
$EW_REPORT_FIELD_FROMTYPE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.fromtype FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMTYPE_SQL_ORDERBY = "chicken_chickentransfer.fromtype";
$EW_REPORT_FIELD_FROMDESCRIPTION_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.fromdescription FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMDESCRIPTION_SQL_ORDERBY = "chicken_chickentransfer.fromdescription";
$EW_REPORT_FIELD_TOCODE_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.tocode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TOCODE_SQL_ORDERBY = "chicken_chickentransfer.tocode";
$EW_REPORT_FIELD_TODESCRIPTION_SQL_SELECT = "SELECT DISTINCT chicken_chickentransfer.todescription FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TODESCRIPTION_SQL_ORDERBY = "chicken_chickentransfer.todescription";
$EW_REPORT_FIELD_UNIT_SQL_SELECT = "SELECT DISTINCT `unit` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNIT_SQL_ORDERBY = "`unit`";
?>
<?php

// Field variables
$x_date = NULL;
$x_tid = NULL;
$x_fromtype = NULL;
$x_fromcode = NULL;
$x_fromdescription = NULL;
$x_birds = NULL;
$x_tocode = NULL;
$x_todescription = NULL;
$x_units = NULL;
$x_quantity = NULL;
$x_narration = NULL;
$x_unit = NULL;

// Group variables
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_tid = NULL; $g_tid = NULL; $dg_tid = NULL;$dg_fromtype = NULL; $t_tid = NULL; $ft_tid = 3; $gf_tid = $ft_tid; $gb_tid = ""; $gi_tid = "0"; $gq_tid = ""; $rf_tid = NULL; $rt_tid = NULL;
$o_fromcode = NULL;$o_fromdescription = NULL;$o_birds = NULL;$dg_fromcode = NULL; $dg_fromcode = NULL;$dg_fromdescription = NULL; $dg_birds = NULL;$t_fromcode = NULL; $ft_fromcode = 200; $gf_fromcode = $ft_fromcode; $gb_fromcode = ""; $gi_fromcode = "0"; $gq_fromcode = ""; $rf_fromcode = NULL; $rt_fromcode = NULL;

// Detail variables
$o_fromtype = NULL; $t_fromtype = NULL; $ft_fromtype = 200; $rf_fromtype = NULL; $rt_fromtype = NULL;
$o_fromdescription = NULL; $t_fromdescription = NULL; $ft_fromdescription = 200; $rf_fromdescription = NULL; $rt_fromdescription = NULL;
$o_birds = NULL; $t_birds = NULL; $ft_birds = 3; $rf_birds = NULL; $rt_birds = NULL;
$o_tocode = NULL; $t_tocode = NULL; $ft_tocode = 200; $rf_tocode = NULL; $rt_tocode = NULL;
$o_todescription = NULL; $t_todescription = NULL; $ft_todescription = 200; $rf_todescription = NULL; $rt_todescription = NULL;
$o_units = NULL; $t_units = NULL; $ft_units = 3; $rf_units = NULL; $rt_units = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 3; $rf_quantity = NULL; $rt_quantity = NULL;
$o_narration = NULL; $t_narration = NULL; $ft_narration = 200; $rf_narration = NULL; $rt_narration = NULL;
$o_unit = NULL; $t_unit = NULL; $ft_unit = 200; $rf_unit = NULL; $rt_unit = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 10;
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
$col = array(FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_fromcode = "";
$seld_fromcode = "";
$val_fromcode = "";
$sel_fromtype = "";
$seld_fromtype = "";
$val_fromtype = "";
$sel_fromdescription = "";
$seld_fromdescription = "";
$val_fromdescription = "";
$sel_tocode = "";
$seld_tocode = "";
$val_tocode = "";
$sel_todescription = "";
$seld_todescription = "";
$val_todescription = "";
$sel_unit = "";
$seld_unit = "";
$val_unit = "";

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
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("Chicken_Transfer_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromcode, $sel_fromcode, $ft_fromcode) ?>
ewrpt_CreatePopup("Chicken_Transfer_fromcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromtype, $sel_fromtype, $ft_fromtype) ?>
ewrpt_CreatePopup("Chicken_Transfer_fromtype", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromdescription, $sel_fromdescription, $ft_fromdescription) ?>
ewrpt_CreatePopup("Chicken_Transfer_fromdescription", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_tocode, $sel_tocode, $ft_tocode) ?>
ewrpt_CreatePopup("Chicken_Transfer_tocode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_todescription, $sel_todescription, $ft_todescription) ?>
ewrpt_CreatePopup("Chicken_Transfer_todescription", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unit, $sel_unit, $ft_unit) ?>
ewrpt_CreatePopup("Chicken_Transfer_unit", [<?php echo $jsdata ?>]);
</script>
<div id="Chicken_Transfer_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_fromcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_fromtype_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_fromdescription_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_tocode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_todescription_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Chicken_Transfer_unit_Popup" class="ewPopup">
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

<table  border="0" align="center">
<tr>
<td ><strong><font color="#3e3276">Chicken Transfer</font></strong></td>
</tr>
</table>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Chicken_Transfersmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="Chicken_Transfersmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="Chicken_Transfersmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Chicken_Transfersmry.php?cmd=reset">Reset All Filters</a>
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
<form action="Chicken_Transfersmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_date', true, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Fromtype
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Fromtype</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_fromtype', false, '<?php echo $rf_fromtype; ?>', '<?php echo $rt_fromtype; ?>');return false;" name="x_fromtype<?php echo $cnt[0][0]; ?>" id="x_fromtype<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_fromcode', false, '<?php echo $rf_fromcode; ?>', '<?php echo $rt_fromcode; ?>');return false;" name="x_fromcode<?php echo $cnt[0][0]; ?>" id="x_fromcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Description</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_fromdescription', false, '<?php echo $rf_fromdescription; ?>', '<?php echo $rt_fromdescription; ?>');return false;" name="x_fromdescription<?php echo $cnt[0][0]; ?>" id="x_fromdescription<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Birds Processed">
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Birds Processed">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Chicken Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Chicken Item</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_tocode', false, '<?php echo $rf_tocode; ?>', '<?php echo $rt_tocode; ?>');return false;" name="x_tocode<?php echo $cnt[0][0]; ?>" id="x_tocode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Chicken Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Chicken Description</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_todescription', false, '<?php echo $rf_todescription; ?>', '<?php echo $rt_todescription; ?>');return false;" name="x_todescription<?php echo $cnt[0][0]; ?>" id="x_todescription<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Chicken_Transfer_unit', false, '<?php echo $rf_unit; ?>', '<?php echo $rt_unit; ?>');return false;" name="x_unit<?php echo $cnt[0][0]; ?>" id="x_unit<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_date, EW_REPORT_DATATYPE_DATE);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_date, EW_REPORT_DATATYPE_DATE, $gb_date, $gi_date, $gq_date);
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
		$dg_date = $x_date;
		if ((is_null($x_date) && is_null($o_date)) ||
			(($x_date <> "" && $o_date == $dg_date) && !ChkLvlBreak(1))) {
			$dg_date = "&nbsp;";
		} elseif (is_null($x_date)) {
			$dg_date = EW_REPORT_NULL_LABEL;
		} elseif ($x_date == "") {
			$dg_date = EW_REPORT_EMPTY_LABEL;
		}
		$dg_tid = $x_tid;
		if ((is_null($x_tid) && is_null($o_tid)) ||
			(($x_tid <> "" && $o_tid == $dg_tid) && !ChkLvlBreak(2))) {
			$dg_tid = "&nbsp;";
		} elseif (is_null($x_tid)) {
			$dg_tid = EW_REPORT_NULL_LABEL;
		} elseif ($x_tid == "") {
			$dg_tid = EW_REPORT_EMPTY_LABEL;
		}
		$dg_fromcode = $x_fromcode;
		if ((is_null($x_fromcode) && is_null($o_fromcode)) ||
			(($x_fromcode <> "" && $o_fromcode == $dg_fromcode) && !ChkLvlBreak(3))) {
			$dg_fromcode = "&nbsp;";
		} elseif (is_null($x_fromcode)) {
			$dg_fromcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_fromcode == "") {
			$dg_fromcode = EW_REPORT_EMPTY_LABEL;
		}
		$dg_fromtype = $x_fromtype;
		if ((is_null($x_fromtype) && is_null($o_fromtype)) ||
			(($x_fromtype <> "" && $o_fromtype == $dg_fromtype) && !ChkLvlBreak(3))) {
			$dg_fromtype = "&nbsp;";
		} elseif (is_null($x_fromtype)) {
			$dg_fromtype = EW_REPORT_NULL_LABEL;
		} elseif ($x_fromtype == "") {
			$dg_fromtype = EW_REPORT_EMPTY_LABEL;
		}
		$dg_fromdescription = $x_fromdescription;
		if ((is_null($x_fromdescription) && is_null($o_fromdescription)) ||
			(($x_fromdescription <> "" && $o_fromdescription == $dg_fromdescription) && !ChkLvlBreak(3))) {
			$dg_fromdescription = "&nbsp;";
		} elseif (is_null($x_fromdescription)) {
			$dg_fromdescription = EW_REPORT_NULL_LABEL;
		} elseif ($x_fromdescription == "") {
			$dg_fromdescription = EW_REPORT_EMPTY_LABEL;
		}
		$dg_birds = $x_birds;
		if ((is_null($x_birds) && is_null($o_birds)) ||
			(($x_birds <> "" && $o_birds == $dg_birds) && !ChkLvlBreak(3))) {
			$dg_birds = "&nbsp;";
		} elseif (is_null($x_birds)) {
			$dg_birds = EW_REPORT_NULL_LABEL;
		} elseif ($x_birds == "") {
			$dg_birds = EW_REPORT_EMPTY_LABEL;
		}
		
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
		<?php $x_date = $t_date; ?></td>
		<?php /*?><td class="ewRptGrpField2">
		<?php $t_tid = $x_tid; $x_tid = $dg_tid; ?>
<?php echo ewrpt_ViewValue($x_tid) ?>
		<?php $x_tid = $t_tid; ?></td><?php */?>
		
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_fromtype = $x_fromtype; $x_fromtype = $dg_fromtype; ?>
<?php echo ewrpt_ViewValue($x_fromtype) ?>
        <?php $x_fromtype = $t_fromtype; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_fromcode = $x_fromcode; $x_fromcode = $dg_fromcode; ?>
<?php echo ewrpt_ViewValue($x_fromcode) ?>
		<?php $x_fromcode = $t_fromcode; ?></td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_fromdescription = $x_fromdescription; $x_fromdescription= $dg_fromdescription; ?>
<?php echo ewrpt_ViewValue($x_fromdescription) ?>
		<?php $x_fromdescription = $t_fromdescription; ?></td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_birds = $x_birds; $x_birds= $dg_birds; ?>
<?php echo ewrpt_ViewValue($x_birds) ?>
		<?php $x_birds = $t_birds; ?></td>
				<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_tocode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_todescription) ?>
</td>
		<?php /*?><td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_units) ?>
</td><?php */?>
        <td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_unit) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_quantity) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_narration) ?>
</td>
		
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date = $x_date;
		$o_tid = $x_tid;
		$o_fromcode = $x_fromcode;
		$o_fromtype = $x_fromtype;
		$o_fromdescription = $x_fromdescription;
		$o_birds = $x_birds;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	<?php /*?><tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="11" class="ewRptGrpSummary2">Summary for Tid: <?php $t_tid = $x_tid; $x_tid = $o_tid; ?>
<?php echo ewrpt_ViewValue($x_tid) ?>
<?php $x_tid = $t_tid; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="2" class="ewRptGrpSummary2">SUM</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">
		<?php $t_birds = $x_birds; ?>
		<?php $x_birds = $smry[2][3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_birds) ?>
		<?php $x_birds = $t_birds; ?>
		</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[2][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
	</tr><?php */?>
<?php

			// Reset level 2 summary
			ResetLevelSummary(2);
		} // End check level check
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_date = $x_date; // Save old group value
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
		$grandsmry[3] = $rsagg->fields("SUM_birds");
		$grandsmry[7] = $rsagg->fields("SUM_quantity");
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
	<!-- tr><td colspan="12"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="10">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="3" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php /*?><td>
		<?php $t_birds = $x_birds; ?>
		<?php $x_birds = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_birds) ?>
		<?php $x_birds = $t_birds; ?>
		</td><?php */?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $grandsmry[7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td>&nbsp;</td>
		
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="Chicken_Transfersmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Chicken_Transfersmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_date"]) && !is_null($GLOBALS["o_date"])) ||
				(!is_null($GLOBALS["x_date"]) && is_null($GLOBALS["o_date"])) ||
				($GLOBALS["x_date"] <> $GLOBALS["o_date"]);
		case 2:
			return (is_null($GLOBALS["x_tid"]) && !is_null($GLOBALS["o_tid"])) ||
				(!is_null($GLOBALS["x_tid"]) && is_null($GLOBALS["o_tid"])) ||
				($GLOBALS["x_tid"] <> $GLOBALS["o_tid"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_fromcode"]) && !is_null($GLOBALS["o_fromcode"])) ||
				(!is_null($GLOBALS["x_fromcode"]) && is_null($GLOBALS["o_fromcode"])) ||
				($GLOBALS["x_fromcode"] <> $GLOBALS["o_fromcode"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_date"] = "";
	if ($lvl <= 2) $GLOBALS["o_tid"] = "";
	if ($lvl <= 3) $GLOBALS["o_fromcode"] = "";

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
		$GLOBALS['x_date'] = "";
	} else {
		$GLOBALS['x_date'] = $rsgrp->fields('date');
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
		$GLOBALS['x_tid'] = $rs->fields('tid');
		$GLOBALS['x_fromtype'] = $rs->fields('fromtype');
		$GLOBALS['x_fromcode'] = $rs->fields('fromcode');
		$GLOBALS['x_fromdescription'] = $rs->fields('fromdescription');
		$GLOBALS['x_birds'] = $rs->fields('birds');
		$GLOBALS['x_tocode'] = $rs->fields('tocode');
		$GLOBALS['x_todescription'] = $rs->fields('todescription');
		$GLOBALS['x_units'] = $rs->fields('units');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_narration'] = $rs->fields('narration');
		$GLOBALS['x_unit'] = $rs->fields('unit');
		$val[1] = $GLOBALS['x_fromtype'];
		$val[2] = $GLOBALS['x_fromdescription'];
		$val[3] = $GLOBALS['x_birds'];
		$val[4] = $GLOBALS['x_tocode'];
		$val[5] = $GLOBALS['x_todescription'];
		$val[6] = $GLOBALS['x_units'];
		$val[7] = $GLOBALS['x_quantity'];
		$val[8] = $GLOBALS['x_narration'];
		$val[9] = $GLOBALS['x_unit'];
	} else {
		$GLOBALS['x_tid'] = "";
		$GLOBALS['x_fromtype'] = "";
		$GLOBALS['x_fromcode'] = "";
		$GLOBALS['x_fromdescription'] = "";
		$GLOBALS['x_birds'] = "";
		$GLOBALS['x_tocode'] = "";
		$GLOBALS['x_todescription'] = "";
		$GLOBALS['x_units'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_narration'] = "";
		$GLOBALS['x_unit'] = "";
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

	// Build distinct values for fromcode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FROMCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FROMCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_fromcode = $rswrk->fields[0];
		if (is_null($x_fromcode)) {
			$bNullValue = TRUE;
		} elseif ($x_fromcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_fromcode = $x_fromcode;
			$dg_fromcode = $x_fromcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_fromcode"], $g_fromcode, $dg_fromcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for fromtype
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FROMTYPE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FROMTYPE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_fromtype = $rswrk->fields[0];
		if (is_null($x_fromtype)) {
			$bNullValue = TRUE;
		} elseif ($x_fromtype == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_fromtype = $x_fromtype;
			ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], $x_fromtype, $t_fromtype, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromtype"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for fromdescription
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FROMDESCRIPTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FROMDESCRIPTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_fromdescription = $rswrk->fields[0];
		if (is_null($x_fromdescription)) {
			$bNullValue = TRUE;
		} elseif ($x_fromdescription == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_fromdescription = $x_fromdescription;
			ewrpt_SetupDistinctValues($GLOBALS["val_fromdescription"], $x_fromdescription, $t_fromdescription, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromdescription"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromdescription"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for tocode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TOCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TOCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_tocode = $rswrk->fields[0];
		if (is_null($x_tocode)) {
			$bNullValue = TRUE;
		} elseif ($x_tocode == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_tocode = $x_tocode;
			ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], $x_tocode, $t_tocode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tocode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for todescription
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TODESCRIPTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TODESCRIPTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_todescription = $rswrk->fields[0];
		if (is_null($x_todescription)) {
			$bNullValue = TRUE;
		} elseif ($x_todescription == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_todescription = $x_todescription;
			ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], $x_todescription, $t_todescription, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_todescription"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('date');
			ClearSessionSelection('fromcode');
			ClearSessionSelection('fromtype');
			ClearSessionSelection('fromdescription');
			ClearSessionSelection('tocode');
			ClearSessionSelection('todescription');
			ClearSessionSelection('unit');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_Chicken_Transfer_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_Chicken_Transfer_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Fromcode selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_fromcode"])) {
		LoadSelectionFromSession('fromcode');
	} elseif (@$_SESSION["sel_Chicken_Transfer_fromcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromcode"] = "";
	}

	// Get Fromtype selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_fromtype"])) {
		LoadSelectionFromSession('fromtype');
	} elseif (@$_SESSION["sel_Chicken_Transfer_fromtype"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromtype"] = "";
	}

	// Get Fromdescription selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_fromdescription"])) {
		LoadSelectionFromSession('fromdescription');
	} elseif (@$_SESSION["sel_Chicken_Transfer_fromdescription"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromdescription"] = "";
	}

	// Get Tocode selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_tocode"])) {
		LoadSelectionFromSession('tocode');
	} elseif (@$_SESSION["sel_Chicken_Transfer_tocode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_tocode"] = "";
	}

	// Get Todescription selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_todescription"])) {
		LoadSelectionFromSession('todescription');
	} elseif (@$_SESSION["sel_Chicken_Transfer_todescription"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_todescription"] = "";
	}

	// Get Unit selected values
	if (is_array(@$_SESSION["sel_Chicken_Transfer_unit"])) {
		LoadSelectionFromSession('unit');
	} elseif (@$_SESSION["sel_Chicken_Transfer_unit"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unit"] = "";
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
				$nDisplayGrps = "ALL"; // Non-numeric, load default
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
			$nDisplayGrps = "ALL"; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_Chicken_Transfer_$parm"] = "";
	$_SESSION["rf_Chicken_Transfer_$parm"] = "";
	$_SESSION["rt_Chicken_Transfer_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Chicken_Transfer_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Chicken_Transfer_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Chicken_Transfer_$parm"];
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

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];

	// Field fromtype
	// Setup your default values for the popup filter below, e.g.
	// $seld_fromtype = array("val1", "val2");

	$GLOBALS["seld_fromtype"] = "";
	$GLOBALS["sel_fromtype"] =  $GLOBALS["seld_fromtype"];

	// Field fromcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_fromcode = array("val1", "val2");

	$GLOBALS["seld_fromcode"] = "";
	$GLOBALS["sel_fromcode"] =  $GLOBALS["seld_fromcode"];

	// Field fromdescription
	// Setup your default values for the popup filter below, e.g.
	// $seld_fromdescription = array("val1", "val2");

	$GLOBALS["seld_fromdescription"] = "";
	$GLOBALS["sel_fromdescription"] =  $GLOBALS["seld_fromdescription"];

	// Field tocode
	// Setup your default values for the popup filter below, e.g.
	// $seld_tocode = array("val1", "val2");

	$GLOBALS["seld_tocode"] = "";
	$GLOBALS["sel_tocode"] =  $GLOBALS["seld_tocode"];

	// Field todescription
	// Setup your default values for the popup filter below, e.g.
	// $seld_todescription = array("val1", "val2");

	$GLOBALS["seld_todescription"] = "";
	$GLOBALS["sel_todescription"] =  $GLOBALS["seld_todescription"];

	// Field unit
	// Setup your default values for the popup filter below, e.g.
	// $seld_unit = array("val1", "val2");

	$GLOBALS["seld_unit"] = "";
	$GLOBALS["sel_unit"] =  $GLOBALS["seld_unit"];
}

// Check if filter applied
function CheckFilter() {

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check fromtype popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromtype"], $GLOBALS["sel_fromtype"]))
		return TRUE;

	// Check fromcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromcode"], $GLOBALS["sel_fromcode"]))
		return TRUE;

	// Check fromdescription popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromdescription"], $GLOBALS["sel_fromdescription"]))
		return TRUE;

	// Check tocode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_tocode"], $GLOBALS["sel_tocode"]))
		return TRUE;

	// Check todescription popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_todescription"], $GLOBALS["sel_todescription"]))
		return TRUE;

	// Check unit popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unit"], $GLOBALS["sel_unit"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

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

	// Field fromtype
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_fromtype"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_fromtype"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fromtype<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field fromcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_fromcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_fromcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fromcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field fromdescription
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_fromdescription"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_fromdescription"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fromdescription<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field tocode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_tocode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_tocode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Tocode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field todescription
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_todescription"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_todescription"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Todescription<br />";
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
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "chicken_chickentransfer.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_fromtype"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromtype"], "chicken_chickentransfer.fromtype", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromtype"]);
	}
	if (is_array($GLOBALS["sel_fromcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromcode"], "chicken_chickentransfer.fromcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromcode"], $GLOBALS["gb_fromcode"], $GLOBALS["gi_fromcode"], $GLOBALS["gq_fromcode"]);
	}
	if (is_array($GLOBALS["sel_fromdescription"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromdescription"], "chicken_chickentransfer.fromdescription", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromdescription"]);
	}
	if (is_array($GLOBALS["sel_tocode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_tocode"], "chicken_chickentransfer.tocode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_tocode"]);
	}
	if (is_array($GLOBALS["sel_todescription"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_todescription"], "chicken_chickentransfer.todescription", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_todescription"]);
	}
	if (is_array($GLOBALS["sel_unit"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unit"], "`unit`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unit"]);
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
			$_SESSION["sort_Chicken_Transfer_date"] = "";
			$_SESSION["sort_Chicken_Transfer_tid"] = "";
			$_SESSION["sort_Chicken_Transfer_fromcode"] = "";
			$_SESSION["sort_Chicken_Transfer_fromtype"] = "";
			$_SESSION["sort_Chicken_Transfer_fromdescription"] = "";
			$_SESSION["sort_Chicken_Transfer_birds"] = "";
			$_SESSION["sort_Chicken_Transfer_tocode"] = "";
			$_SESSION["sort_Chicken_Transfer_todescription"] = "";
			$_SESSION["sort_Chicken_Transfer_units"] = "";
			$_SESSION["sort_Chicken_Transfer_quantity"] = "";
			$_SESSION["sort_Chicken_Transfer_narration"] = "";
			$_SESSION["sort_Chicken_Transfer_unit"] = "";
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
