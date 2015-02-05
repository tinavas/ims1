<?php
session_start();
ob_start();
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
<?php include "reportheader.php";?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Processed Quails Transfer</font></strong></td>
</tr>
</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "quail_livebirdtransfer", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "quail_livebirdtransfer_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "quail_livebirdtransfer_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "quail_livebirdtransfer_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "quail_livebirdtransfer_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "quail_livebirdtransfer_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ims_stocktransfer";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT ims_stocktransfer.date, ims_stocktransfer.fromwarehouse, ims_stocktransfer.towarehouse, ims_stocktransfer.tmno, ims_stocktransfer.code, ims_stocktransfer.sentquantity, ims_stocktransfer.tmort, ims_stocktransfer.quantity, ims_stocktransfer.price FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "(fromwarehouse in (select sector from tbl_sector where type1='Quail Processing Unit') or towarehouse in (select sector from tbl_sector where type1='Quail Processing Unit'))";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "ims_stocktransfer.date ASC, ims_stocktransfer.fromwarehouse ASC, ims_stocktransfer.towarehouse ASC, ims_stocktransfer.code ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "ims_stocktransfer.date", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = NULL; // Popup filter for date
$af_fromwarehouse = NULL; // Popup filter for fromwarehouse
$af_towarehouse = NULL; // Popup filter for towarehouse
$af_tmno = NULL; // Popup filter for tmno
$af_code = NULL; // Popup filter for code
$af_sentquantity = NULL; // Popup filter for sentquantity
$af_tmort = NULL; // Popup filter for tmort
$af_quantity = NULL; // Popup filter for quantity
$af_price = NULL; // Popup filter for price
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
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "ims_stocktransfer.date";
$EW_REPORT_FIELD_FROMWAREHOUSE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.fromwarehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMWAREHOUSE_SQL_ORDERBY = "ims_stocktransfer.fromwarehouse";
$EW_REPORT_FIELD_TOWAREHOUSE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.towarehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TOWAREHOUSE_SQL_ORDERBY = "ims_stocktransfer.towarehouse";
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.code FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "ims_stocktransfer.code";
$EW_REPORT_FIELD_TMNO_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.tmno FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TMNO_SQL_ORDERBY = "ims_stocktransfer.tmno";
?>
<?php

// Field variables
$x_date = NULL;
$x_fromwarehouse = NULL;
$x_towarehouse = NULL;
$x_tmno = NULL;
$x_code = NULL;
$x_sentquantity = NULL;
$x_tmort = NULL;
$x_quantity = NULL;
$x_price = NULL;

// Group variables
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_fromwarehouse = NULL; $g_fromwarehouse = NULL; $dg_fromwarehouse = NULL; $t_fromwarehouse = NULL; $ft_fromwarehouse = 200; $gf_fromwarehouse = $ft_fromwarehouse; $gb_fromwarehouse = ""; $gi_fromwarehouse = "0"; $gq_fromwarehouse = ""; $rf_fromwarehouse = NULL; $rt_fromwarehouse = NULL;
$o_towarehouse = NULL; $g_towarehouse = NULL; $dg_towarehouse = NULL; $t_towarehouse = NULL; $ft_towarehouse = 200; $gf_towarehouse = $ft_towarehouse; $gb_towarehouse = ""; $gi_towarehouse = "0"; $gq_towarehouse = ""; $rf_towarehouse = NULL; $rt_towarehouse = NULL;
$o_code = NULL; $g_code = NULL; $dg_code = NULL; $t_code = NULL; $ft_code = 200; $gf_code = $ft_code; $gb_code = ""; $gi_code = "0"; $gq_code = ""; $rf_code = NULL; $rt_code = NULL;

// Detail variables
$o_tmno = NULL; $t_tmno = NULL; $ft_tmno = 200; $rf_tmno = NULL; $rt_tmno = NULL;
$o_sentquantity = NULL; $t_sentquantity = NULL; $ft_sentquantity = 3; $rf_sentquantity = NULL; $rt_sentquantity = NULL;
$o_tmort = NULL; $t_tmort = NULL; $ft_tmort = 5; $rf_tmort = NULL; $rt_tmort = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_price = NULL; $t_price = NULL; $ft_price = 5; $rf_price = NULL; $rt_price = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 6;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_fromwarehouse = "";
$seld_fromwarehouse = "";
$val_fromwarehouse = "";
$sel_towarehouse = "";
$seld_towarehouse = "";
$val_towarehouse = "";
$sel_code = "";
$seld_code = "";
$val_code = "";
$sel_tmno = "";
$seld_tmno = "";
$val_tmno = "";

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
ewrpt_CreatePopup("quail_livebirdtransfer_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromwarehouse, $sel_fromwarehouse, $ft_fromwarehouse) ?>
ewrpt_CreatePopup("quail_livebirdtransfer_fromwarehouse", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_towarehouse, $sel_towarehouse, $ft_towarehouse) ?>
ewrpt_CreatePopup("quail_livebirdtransfer_towarehouse", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code) ?>
ewrpt_CreatePopup("quail_livebirdtransfer_code", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_tmno, $sel_tmno, $ft_tmno) ?>
ewrpt_CreatePopup("quail_livebirdtransfer_tmno", [<?php echo $jsdata ?>]);
</script>
<div id="quail_livebirdtransfer_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_livebirdtransfer_fromwarehouse_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_livebirdtransfer_towarehouse_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_livebirdtransfer_code_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="quail_livebirdtransfer_tmno_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3" align="center"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="quail_livebirdtransfersmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_livebirdtransfersmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_livebirdtransfersmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_livebirdtransfersmry.php?cmd=reset">Reset All Filters</a>
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
<!-- Report Grid (Begin) -->
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="quail_livebirdtransfersmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
</div>
<?php } ?>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'quail_livebirdtransfer_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader2">
		From Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>From Warehouse</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'quail_livebirdtransfer_fromwarehouse', false, '<?php echo $rf_fromwarehouse; ?>', '<?php echo $rt_fromwarehouse; ?>');return false;" name="x_fromwarehouse<?php echo $cnt[0][0]; ?>" id="x_fromwarehouse<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		To Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>To Warehouse</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'quail_livebirdtransfer_towarehouse', false, '<?php echo $rf_towarehouse; ?>', '<?php echo $rt_towarehouse; ?>');return false;" name="x_towarehouse<?php echo $cnt[0][0]; ?>" id="x_towarehouse<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader3">
		DC
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>DC</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'quail_livebirdtransfer_tmno', false, '<?php echo $rf_tmno; ?>', '<?php echo $rt_tmno; ?>');return false;" name="x_tmno<?php echo $cnt[0][0]; ?>" id="x_tmno<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader4">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'quail_livebirdtransfer_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_code<?php echo $cnt[0][0]; ?>" id="x_code<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		sent Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>sent Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Received Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Received Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Price</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Amount</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
		$dumm1 = 0;
		$dumm3 = 0;
		$dumm4  = 0;
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
		$dg_fromwarehouse = $x_fromwarehouse;
		if ((is_null($x_fromwarehouse) && is_null($o_fromwarehouse)) ||
			(($x_fromwarehouse <> "" && $o_fromwarehouse == $dg_fromwarehouse) && !ChkLvlBreak(2))) {
			$dg_fromwarehouse = "&nbsp;";
		} elseif (is_null($x_fromwarehouse)) {
			$dg_fromwarehouse = EW_REPORT_NULL_LABEL;
		} elseif ($x_fromwarehouse == "") {
			$dg_fromwarehouse = EW_REPORT_EMPTY_LABEL;
		}
		$dg_towarehouse = $x_towarehouse;
		if ((is_null($x_towarehouse) && is_null($o_towarehouse)) ||
			(($x_towarehouse <> "" && $o_towarehouse == $dg_towarehouse) && !ChkLvlBreak(3))) {
			$dg_towarehouse = "&nbsp;";
		} elseif (is_null($x_towarehouse)) {
			$dg_towarehouse = EW_REPORT_NULL_LABEL;
		} elseif ($x_towarehouse == "") {
			$dg_towarehouse = EW_REPORT_EMPTY_LABEL;
		}
		$dg_code = $x_code;
		if ((is_null($x_code) && is_null($o_code)) ||
			(($x_code <> "" && $o_code == $dg_code) && !ChkLvlBreak(4))) {
			$dg_code = "&nbsp;";
		} elseif (is_null($x_code)) {
			$dg_code = EW_REPORT_NULL_LABEL;
		} elseif ($x_code == "") {
			$dg_code = EW_REPORT_EMPTY_LABEL;
		}
		$date = date("d.m.Y",strtotime($x_date));
		
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php if(($date <> $oldcode1) or ($dumm1 == 0)){ echo ewrpt_ViewValue($date);
     $oldcode1 = $date; $dumm1 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
</td>
		<td class="ewRptGrpField2">
		<?php $t_fromwarehouse = $x_fromwarehouse; $x_fromwarehouse = $dg_fromwarehouse; ?>
<?php echo ewrpt_ViewValue($x_fromwarehouse) ?>
		<?php $x_fromwarehouse = $t_fromwarehouse; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_towarehouse = $x_towarehouse; $x_towarehouse = $dg_towarehouse; ?>
<?php echo ewrpt_ViewValue($x_towarehouse) ?>
		<?php $x_towarehouse = $t_towarehouse; ?></td>
		
		<td<?php echo $sItemRowClass; ?>>
<?php if(($x_tmno <> $oldcode3) or ($dumm3 == 0)){ echo ewrpt_ViewValue($x_tmno);
     $oldcode3 = $x_tmno; $dumm3 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
</td>

<td class="ewRptGrpField4">
		<?php $t_code = $x_code; $x_code = $dg_code; ?>
<?php echo ewrpt_ViewValue($x_code) ?>
		<?php $x_code = $t_code; ?></td>
		<?php 
$query1 = "select * from ims_itemcodes where code = '$x_code'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result1))
{
$desc = $rows['description'];
?>
<td<?php echo $sItemRowClass; ?>>
<?php if(($desc <> $oldcode4) or ($dumm4 == 0)){ echo ewrpt_ViewValue($desc);
     $oldcode4 = $desc; $dumm4 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_sentquantity) ?>
<?php $totsentquant = $totsentquant + $x_sentquantity; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_tmort) ?>
<?php $totmort = $totmort + $x_tmort; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_quantity) ?>
<?php $totquant = $totquant + $x_quantity; ?>
</td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_price)) ?>
<?php $totprice = $totprice  + $x_price; ?>
</td>
<?php $amount = $x_quantity * $x_price; ?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($amount)) ?>
<?php $totamount = $totamount  + $amount; ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date = $x_date;
		$o_fromwarehouse = $x_fromwarehouse;
		$o_towarehouse = $x_towarehouse;
		$o_code = $x_code;

		// Get next record
		GetRow(2);

		// Show Footers
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
<?php if (@$sExport <> "") { ?>
<tr>
<td <?php echo $sItemRowClass; ?> align="center" ><b> Total</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totsentquant; ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totmort;?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totquant;?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changeprice($totprice);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changeprice($totamount);?></b></td>
</tr>
	</tbody>
	<tfoot>
<?php }

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
	<!-- tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>

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
			return (is_null($GLOBALS["x_fromwarehouse"]) && !is_null($GLOBALS["o_fromwarehouse"])) ||
				(!is_null($GLOBALS["x_fromwarehouse"]) && is_null($GLOBALS["o_fromwarehouse"])) ||
				($GLOBALS["x_fromwarehouse"] <> $GLOBALS["o_fromwarehouse"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_towarehouse"]) && !is_null($GLOBALS["o_towarehouse"])) ||
				(!is_null($GLOBALS["x_towarehouse"]) && is_null($GLOBALS["o_towarehouse"])) ||
				($GLOBALS["x_towarehouse"] <> $GLOBALS["o_towarehouse"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_code"]) && !is_null($GLOBALS["o_code"])) ||
				(!is_null($GLOBALS["x_code"]) && is_null($GLOBALS["o_code"])) ||
				($GLOBALS["x_code"] <> $GLOBALS["o_code"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 2) $GLOBALS["o_fromwarehouse"] = "";
	if ($lvl <= 3) $GLOBALS["o_towarehouse"] = "";
	if ($lvl <= 4) $GLOBALS["o_code"] = "";

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
		$GLOBALS['x_fromwarehouse'] = $rs->fields('fromwarehouse');
		$GLOBALS['x_towarehouse'] = $rs->fields('towarehouse');
		$GLOBALS['x_tmno'] = $rs->fields('tmno');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_sentquantity'] = $rs->fields('sentquantity');
		$GLOBALS['x_tmort'] = $rs->fields('tmort');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_price'] = $rs->fields('price');
		$val[1] = $GLOBALS['x_tmno'];
		$val[2] = $GLOBALS['x_sentquantity'];
		$val[3] = $GLOBALS['x_tmort'];
		$val[4] = $GLOBALS['x_quantity'];
		$val[5] = $GLOBALS['x_price'];
	} else {
		$GLOBALS['x_fromwarehouse'] = "";
		$GLOBALS['x_towarehouse'] = "";
		$GLOBALS['x_tmno'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_sentquantity'] = "";
		$GLOBALS['x_tmort'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_price'] = "";
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
			$dg_date = ewrpt_FormatDateTime($x_date,5);
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

	// Build distinct values for fromwarehouse
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FROMWAREHOUSE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FROMWAREHOUSE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_fromwarehouse = $rswrk->fields[0];
		if (is_null($x_fromwarehouse)) {
			$bNullValue = TRUE;
		} elseif ($x_fromwarehouse == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_fromwarehouse = $x_fromwarehouse;
			$dg_fromwarehouse = $x_fromwarehouse;
			ewrpt_SetupDistinctValues($GLOBALS["val_fromwarehouse"], $g_fromwarehouse, $dg_fromwarehouse, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromwarehouse"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_fromwarehouse"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for towarehouse
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TOWAREHOUSE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TOWAREHOUSE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_towarehouse = $rswrk->fields[0];
		if (is_null($x_towarehouse)) {
			$bNullValue = TRUE;
		} elseif ($x_towarehouse == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_towarehouse = $x_towarehouse;
			$dg_towarehouse = $x_towarehouse;
			ewrpt_SetupDistinctValues($GLOBALS["val_towarehouse"], $g_towarehouse, $dg_towarehouse, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_towarehouse"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_towarehouse"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for code
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_CODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_CODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_code = $rswrk->fields[0];
		if (is_null($x_code)) {
			$bNullValue = TRUE;
		} elseif ($x_code == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_code = $x_code;
			$dg_code = $x_code;
			ewrpt_SetupDistinctValues($GLOBALS["val_code"], $g_code, $dg_code, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_code"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_code"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for tmno
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TMNO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TMNO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_tmno = $rswrk->fields[0];
		if (is_null($x_tmno)) {
			$bNullValue = TRUE;
		} elseif ($x_tmno == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_tmno = $x_tmno;
			ewrpt_SetupDistinctValues($GLOBALS["val_tmno"], $x_tmno, $t_tmno, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tmno"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_tmno"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('fromwarehouse');
			ClearSessionSelection('towarehouse');
			ClearSessionSelection('code');
			ClearSessionSelection('tmno');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_quail_livebirdtransfer_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_quail_livebirdtransfer_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Fromwarehouse selected values
	if (is_array(@$_SESSION["sel_quail_livebirdtransfer_fromwarehouse"])) {
		LoadSelectionFromSession('fromwarehouse');
	} elseif (@$_SESSION["sel_quail_livebirdtransfer_fromwarehouse"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromwarehouse"] = "";
	}

	// Get Towarehouse selected values
	if (is_array(@$_SESSION["sel_quail_livebirdtransfer_towarehouse"])) {
		LoadSelectionFromSession('towarehouse');
	} elseif (@$_SESSION["sel_quail_livebirdtransfer_towarehouse"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_towarehouse"] = "";
	}

	// Get Code selected values
	if (is_array(@$_SESSION["sel_quail_livebirdtransfer_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_quail_livebirdtransfer_code"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_code"] = "";
	}

	// Get Tmno selected values
	if (is_array(@$_SESSION["sel_quail_livebirdtransfer_tmno"])) {
		LoadSelectionFromSession('tmno');
	} elseif (@$_SESSION["sel_quail_livebirdtransfer_tmno"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_tmno"] = "";
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
	$_SESSION["sel_quail_livebirdtransfer_$parm"] = "";
	$_SESSION["rf_quail_livebirdtransfer_$parm"] = "";
	$_SESSION["rt_quail_livebirdtransfer_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_quail_livebirdtransfer_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_quail_livebirdtransfer_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_quail_livebirdtransfer_$parm"];
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

	// Field fromwarehouse
	// Setup your default values for the popup filter below, e.g.
	// $seld_fromwarehouse = array("val1", "val2");

	$GLOBALS["seld_fromwarehouse"] = "";
	$GLOBALS["sel_fromwarehouse"] =  $GLOBALS["seld_fromwarehouse"];

	// Field towarehouse
	// Setup your default values for the popup filter below, e.g.
	// $seld_towarehouse = array("val1", "val2");

	$GLOBALS["seld_towarehouse"] = "";
	$GLOBALS["sel_towarehouse"] =  $GLOBALS["seld_towarehouse"];

	// Field tmno
	// Setup your default values for the popup filter below, e.g.
	// $seld_tmno = array("val1", "val2");

	$GLOBALS["seld_tmno"] = "";
	$GLOBALS["sel_tmno"] =  $GLOBALS["seld_tmno"];

	// Field code
	// Setup your default values for the popup filter below, e.g.
	// $seld_code = array("val1", "val2");

	$GLOBALS["seld_code"] = "";
	$GLOBALS["sel_code"] =  $GLOBALS["seld_code"];
}

// Check if filter applied
function CheckFilter() {

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check fromwarehouse popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromwarehouse"], $GLOBALS["sel_fromwarehouse"]))
		return TRUE;

	// Check towarehouse popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_towarehouse"], $GLOBALS["sel_towarehouse"]))
		return TRUE;

	// Check tmno popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_tmno"], $GLOBALS["sel_tmno"]))
		return TRUE;

	// Check code popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_code"], $GLOBALS["sel_code"]))
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

	// Field fromwarehouse
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_fromwarehouse"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_fromwarehouse"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Fromwarehouse<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field towarehouse
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_towarehouse"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_towarehouse"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Towarehouse<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field tmno
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_tmno"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_tmno"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Tmno<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field code
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_code"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_code"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Code<br />";
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
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "ims_stocktransfer.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
	}
	if (is_array($GLOBALS["sel_fromwarehouse"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromwarehouse"], "ims_stocktransfer.fromwarehouse", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromwarehouse"], $GLOBALS["gb_fromwarehouse"], $GLOBALS["gi_fromwarehouse"], $GLOBALS["gq_fromwarehouse"]);
	}
	if (is_array($GLOBALS["sel_towarehouse"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_towarehouse"], "ims_stocktransfer.towarehouse", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_towarehouse"], $GLOBALS["gb_towarehouse"], $GLOBALS["gi_towarehouse"], $GLOBALS["gq_towarehouse"]);
	}
	if (is_array($GLOBALS["sel_tmno"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_tmno"], "ims_stocktransfer.tmno", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_tmno"]);
	}
	if (is_array($GLOBALS["sel_code"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_code"], "ims_stocktransfer.code", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_code"], $GLOBALS["gb_code"], $GLOBALS["gi_code"], $GLOBALS["gq_code"]);
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
			$_SESSION["sort_quail_livebirdtransfer_date"] = "";
			$_SESSION["sort_quail_livebirdtransfer_fromwarehouse"] = "";
			$_SESSION["sort_quail_livebirdtransfer_towarehouse"] = "";
			$_SESSION["sort_quail_livebirdtransfer_code"] = "";
			$_SESSION["sort_quail_livebirdtransfer_tmno"] = "";
			$_SESSION["sort_quail_livebirdtransfer_sentquantity"] = "";
			$_SESSION["sort_quail_livebirdtransfer_tmort"] = "";
			$_SESSION["sort_quail_livebirdtransfer_quantity"] = "";
			$_SESSION["sort_quail_livebirdtransfer_price"] = "";
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
