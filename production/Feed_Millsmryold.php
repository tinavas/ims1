<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  
<?php } ?>
<?php
include "reportheader.php";
include "config.php";
session_start();
ob_start();
$grandtotal = 0;
if(!isset($_GET['export']))
$c = 6;
else
$c = 5;
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
define("EW_REPORT_TABLE_VAR", "Feed_Mill", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Feed_Mill_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Feed_Mill_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Feed_Mill_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Feed_Mill_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Feed_Mill_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "feed_fformula Inner Join feed_formula On feed_fformula.sid = feed_formula.name And feed_fformula.feedtype = feed_formula.feedtype And feed_fformula.feedmill = feed_formula.feedmill";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT feed_fformula.feedmill, feed_fformula.feedtype, feed_fformula.sid, feed_formula.date, feed_fformula.ingredient, feed_fformula.quantity, feed_fformula.unit FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "feed_fformula.feedmill, feed_fformula.feedtype, feed_fformula.sid, feed_formula.date, feed_fformula.ingredient, feed_fformula.quantity, feed_fformula.unit";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "feed_fformula.feedmill ASC, feed_fformula.feedtype ASC, feed_fformula.sid ASC, feed_formula.date ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "feed_fformula.feedmill", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `feedmill` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(feed_fformula.quantity) AS SUM_quantity FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_feedmill = NULL; // Popup filter for feedmill
$af_feedtype = NULL; // Popup filter for feedtype
$af_sid = NULL; // Popup filter for sid
$af_date = NULL; // Popup filter for date
$af_ingredient = NULL; // Popup filter for ingredient
$af_quantity = NULL; // Popup filter for quantity
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
$EW_REPORT_FIELD_FEEDMILL_SQL_SELECT = "SELECT DISTINCT feed_fformula.feedmill FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FEEDMILL_SQL_ORDERBY = "feed_fformula.feedmill";
$EW_REPORT_FIELD_FEEDTYPE_SQL_SELECT = "SELECT DISTINCT feed_fformula.feedtype FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FEEDTYPE_SQL_ORDERBY = "feed_fformula.feedtype";
$EW_REPORT_FIELD_SID_SQL_SELECT = "SELECT DISTINCT feed_fformula.sid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SID_SQL_ORDERBY = "feed_fformula.sid";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT feed_formula.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "feed_formula.date";
?>
<?php

// Field variables
$x_feedmill = NULL;
$x_feedtype = NULL;
$x_sid = NULL;
$x_date = NULL;
$x_ingredient = NULL;
$x_quantity = NULL;
$x_unit = NULL;

// Group variables
$o_feedmill = NULL; $g_feedmill = NULL; $dg_feedmill = NULL; $t_feedmill = NULL; $ft_feedmill = 200; $gf_feedmill = $ft_feedmill; $gb_feedmill = ""; $gi_feedmill = "0"; $gq_feedmill = ""; $rf_feedmill = NULL; $rt_feedmill = NULL;
$o_feedtype = NULL; $g_feedtype = NULL; $dg_feedtype = NULL; $t_feedtype = NULL; $ft_feedtype = 200; $gf_feedtype = $ft_feedtype; $gb_feedtype = ""; $gi_feedtype = "0"; $gq_feedtype = ""; $rf_feedtype = NULL; $rt_feedtype = NULL;
$o_sid = NULL; $g_sid = NULL; $dg_sid = NULL; $t_sid = NULL; $ft_sid = 200; $gf_sid = $ft_sid; $gb_sid = ""; $gi_sid = "0"; $gq_sid = ""; $rf_sid = NULL; $rt_sid = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;

// Detail variables
$o_ingredient = NULL; $t_ingredient = NULL; $ft_ingredient = 200; $rf_ingredient = NULL; $rt_ingredient = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 131; $rf_quantity = NULL; $rt_quantity = NULL;
$o_unit = NULL; $t_unit = NULL; $ft_unit = 200; $rf_unit = NULL; $rt_unit = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 4;
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
$col = array(FALSE, FALSE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_feedmill = "";
$seld_feedmill = "";
$val_feedmill = "";
$sel_feedtype = "";
$seld_feedtype = "";
$val_feedtype = "";
$sel_sid = "";
$seld_sid = "";
$val_sid = "";
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
<?php $jsdata = ewrpt_GetJsData($val_feedmill, $sel_feedmill, $ft_feedmill) ?>
ewrpt_CreatePopup("Feed_Mill_feedmill", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_feedtype, $sel_feedtype, $ft_feedtype) ?>
ewrpt_CreatePopup("Feed_Mill_feedtype", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_sid, $sel_sid, $ft_sid) ?>
ewrpt_CreatePopup("Feed_Mill_sid", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("Feed_Mill_date", [<?php echo $jsdata ?>]);
</script>
<div id="Feed_Mill_feedmill_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Feed_Mill_feedtype_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Feed_Mill_sid_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Feed_Mill_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<center>
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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Feed Mill Report</font></strong></td>
</tr>
</table>
<br/>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?cmd=reset">Reset All Filters</a>
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
<form action="Feed_Millsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Feed Mill
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Mill</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Feed_Mill_feedmill', false, '<?php echo $rf_feedmill; ?>', '<?php echo $rt_feedmill; ?>');return false;" name="x_feedmill<?php echo $cnt[0][0]; ?>" id="x_feedmill<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Type</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Feed_Mill_feedtype', false, '<?php echo $rf_feedtype; ?>', '<?php echo $rt_feedtype; ?>');return false;" name="x_feedtype<?php echo $cnt[0][0]; ?>" id="x_feedtype<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Formula
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Formula</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Feed_Mill_sid', false, '<?php echo $rf_sid; ?>', '<?php echo $rt_sid; ?>');return false;" name="x_sid<?php echo $cnt[0][0]; ?>" id="x_sid<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if($c == 6) { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Standards
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Standards</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Feed_Mill_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Ingredient
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Ingredient</td>
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
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Units</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_feedmill, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_feedmill, EW_REPORT_DATATYPE_STRING, $gb_feedmill, $gi_feedmill, $gq_feedmill);
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
		$dg_feedmill = $x_feedmill;
		if ((is_null($x_feedmill) && is_null($o_feedmill)) ||
			(($x_feedmill <> "" && $o_feedmill == $dg_feedmill) && !ChkLvlBreak(1))) {
			$dg_feedmill = "&nbsp;";
		} elseif (is_null($x_feedmill)) {
			$dg_feedmill = EW_REPORT_NULL_LABEL;
		} elseif ($x_feedmill == "") {
			$dg_feedmill = EW_REPORT_EMPTY_LABEL;
		}
		$dg_feedtype = $x_feedtype;
		if ((is_null($x_feedtype) && is_null($o_feedtype)) ||
			(($x_feedtype <> "" && $o_feedtype == $dg_feedtype) && !ChkLvlBreak(2))) {
			$dg_feedtype = "&nbsp;";
		} elseif (is_null($x_feedtype)) {
			$dg_feedtype = EW_REPORT_NULL_LABEL;
		} elseif ($x_feedtype == "") {
			$dg_feedtype = EW_REPORT_EMPTY_LABEL;
		}
		$dg_sid = $x_sid;
		if ((is_null($x_sid) && is_null($o_sid)) ||
			(($x_sid <> "" && $o_sid == $dg_sid) && !ChkLvlBreak(3))) {
			$dg_sid = "&nbsp;";
		} elseif (is_null($x_sid)) {
			$dg_sid = EW_REPORT_NULL_LABEL;
		} elseif ($x_sid == "") {
			$dg_sid = EW_REPORT_EMPTY_LABEL;
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
		<?php $t_feedmill = $x_feedmill; $x_feedmill = $dg_feedmill; ?>
<?php echo ewrpt_ViewValue($x_feedmill) ?>
		<?php $x_feedmill = $t_feedmill; ?></td>
		<?php 
		$q = "select description from ims_itemcodes where code = '$x_feedtype'";
		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		if($qr = mysql_fetch_assoc($qrs))
		$description = " ( " . $qr['description'] . " ) ";
		if($dg_feedtype == "&nbsp;")
		$description = "&nbsp;";
		?>
		<td class="ewRptGrpField2">
		<?php $t_feedtype = $x_feedtype; $x_feedtype = $dg_feedtype; ?>
<?php echo ewrpt_ViewValue($x_feedtype) . $description; ?>
		<?php $x_feedtype = $t_feedtype; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_sid = $x_sid; $x_sid = $dg_sid; ?>
<?php echo ewrpt_ViewValue($x_sid) ?>
		<?php $x_sid = $t_sid; ?></td>
		<?php if($c == 6) { ?>
		<td class="ewRptGrpField5">
		<?php if($dg_feedtype != "&nbsp;") { ?>
<a href="#" onClick="script1('standards.php?feed=<?php echo $x_feedtype; ?>&feedmill=<?php echo $x_feedmill; ?>&formula=<?php echo $x_sid; ?>');" style="text-decoration:underline;color:black">Compare Standards</a>
		<?php } else echo "&nbsp;"; ?>
</td>
<?php } ?>
		<?php if($c == 6) { ?>
		<td class="ewRptGrpField3">
		<?php } else { ?>
		<td class="ewRptGrpField4">
		<?php } ?>
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
		<?php $x_date = $t_date; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_ingredient) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_quantity) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_unit) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_feedmill = $x_feedmill;
		$o_feedtype = $x_feedtype;
		$o_sid = $x_sid;
		$o_date = $x_date;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(4)) {
?>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField3">&nbsp;</td>
		<td colspan="4" class="ewRptGrpSummary4">Summary for Date: <?php $t_date = $x_date; $x_date = $o_date; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
<?php $x_date = $t_date; ?> (<?php echo ewrpt_FormatNumber($cnt[4][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td class="ewRptGrpField3">&nbsp;</td>
		<td colspan="1" class="ewRptGrpSummary4">SUM</td>
		<td class="ewRptGrpSummary4">&nbsp;</td>
		<td class="ewRptGrpSummary4" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[4][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td class="ewRptGrpSummary4">&nbsp;</td>
	</tr>
<?php

			// Reset level 4 summary
			ResetLevelSummary(4);
		} // End check level check
?>
<?php
		if (ChkLvlBreak(3)) {
?>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="<?php echo $c; ?>" class="ewRptGrpSummary3">Summary for Formula: <?php $t_sid = $x_sid; $x_sid = $o_sid; ?>
<?php echo ewrpt_ViewValue($x_sid) ?>
<?php $x_sid = $t_sid; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="2" class="ewRptGrpSummary3">SUM</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<?php if($c == 6) { ?>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<?php } ?>
		<td class="ewRptGrpSummary3" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[3][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
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
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="<?php echo $c+1; ?>" class="ewRptGrpSummary2">Summary for Feedtype: <?php $t_feedtype = $x_feedtype; $x_feedtype = $o_feedtype; ?>
<?php echo ewrpt_ViewValue($x_feedtype) ?>
<?php $x_feedtype = $t_feedtype; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="3" class="ewRptGrpSummary2">SUM</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<?php if($c == 6) { ?>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<?php } ?>
		<td class="ewRptGrpSummary2" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[2][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
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
	<tr>
		<td colspan="<?php echo $c+2; ?>" class="ewRptGrpSummary1">Summary for Feedmill: <?php $t_feedmill = $x_feedmill; $x_feedmill = $o_feedmill; ?>
<?php echo ewrpt_ViewValue($x_feedmill) ?>
<?php $x_feedmill = $t_feedmill; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="4" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php if($c == 6) { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $grandtotal+= $x_quantity = $smry[1][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_quantity) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_feedmill = $x_feedmill; // Save old group value
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
		$grandsmry[2] = $rsagg->fields("SUM_quantity");
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
	<!-- tr><td colspan="7"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="<?php echo $c+2; ?>">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="4" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<?php if($c == 6) { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<td align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $grandsmry[2]; // Load SUM ?>
<?php echo $grandtotal;#ewrpt_ViewValue($x_quantity) ?>
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
<form action="Feed_Millsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Feed_Millsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_feedmill"]) && !is_null($GLOBALS["o_feedmill"])) ||
				(!is_null($GLOBALS["x_feedmill"]) && is_null($GLOBALS["o_feedmill"])) ||
				($GLOBALS["x_feedmill"] <> $GLOBALS["o_feedmill"]);
		case 2:
			return (is_null($GLOBALS["x_feedtype"]) && !is_null($GLOBALS["o_feedtype"])) ||
				(!is_null($GLOBALS["x_feedtype"]) && is_null($GLOBALS["o_feedtype"])) ||
				($GLOBALS["x_feedtype"] <> $GLOBALS["o_feedtype"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_sid"]) && !is_null($GLOBALS["o_sid"])) ||
				(!is_null($GLOBALS["x_sid"]) && is_null($GLOBALS["o_sid"])) ||
				($GLOBALS["x_sid"] <> $GLOBALS["o_sid"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_feedmill"] = "";
	if ($lvl <= 2) $GLOBALS["o_feedtype"] = "";
	if ($lvl <= 3) $GLOBALS["o_sid"] = "";
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
		$GLOBALS['x_feedmill'] = "";
	} else {
		$GLOBALS['x_feedmill'] = $rsgrp->fields('feedmill');
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
		$GLOBALS['x_feedtype'] = $rs->fields('feedtype');
		$GLOBALS['x_sid'] = $rs->fields('sid');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_ingredient'] = $rs->fields('ingredient');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_unit'] = $rs->fields('unit');
		$val[1] = $GLOBALS['x_ingredient'];
		$val[2] = $GLOBALS['x_quantity'];
		$val[3] = $GLOBALS['x_unit'];
	} else {
		$GLOBALS['x_feedtype'] = "";
		$GLOBALS['x_sid'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_ingredient'] = "";
		$GLOBALS['x_quantity'] = "";
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
	// Build distinct values for feedmill

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FEEDMILL_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FEEDMILL_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_feedmill = $rswrk->fields[0];
		if (is_null($x_feedmill)) {
			$bNullValue = TRUE;
		} elseif ($x_feedmill == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_feedmill = $x_feedmill;
			$dg_feedmill = $x_feedmill;
			ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], $g_feedmill, $dg_feedmill, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedmill"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for feedtype
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FEEDTYPE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FEEDTYPE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_feedtype = $rswrk->fields[0];
		if (is_null($x_feedtype)) {
			$bNullValue = TRUE;
		} elseif ($x_feedtype == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_feedtype = $x_feedtype;
			$dg_feedtype = $x_feedtype;
			ewrpt_SetupDistinctValues($GLOBALS["val_feedtype"], $g_feedtype, $dg_feedtype, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedtype"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_feedtype"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for sid
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SID_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SID_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_sid = $rswrk->fields[0];
		if (is_null($x_sid)) {
			$bNullValue = TRUE;
		} elseif ($x_sid == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_sid = $x_sid;
			$dg_sid = $x_sid;
			ewrpt_SetupDistinctValues($GLOBALS["val_sid"], $g_sid, $dg_sid, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sid"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sid"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('feedmill');
			ClearSessionSelection('feedtype');
			ClearSessionSelection('sid');
			ClearSessionSelection('date');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Feedmill selected values

	if (is_array(@$_SESSION["sel_Feed_Mill_feedmill"])) {
		LoadSelectionFromSession('feedmill');
	} elseif (@$_SESSION["sel_Feed_Mill_feedmill"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_feedmill"] = "";
	}

	// Get Feedtype selected values
	if (is_array(@$_SESSION["sel_Feed_Mill_feedtype"])) {
		LoadSelectionFromSession('feedtype');
	} elseif (@$_SESSION["sel_Feed_Mill_feedtype"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_feedtype"] = "";
	}

	// Get Sid selected values
	if (is_array(@$_SESSION["sel_Feed_Mill_sid"])) {
		LoadSelectionFromSession('sid');
	} elseif (@$_SESSION["sel_Feed_Mill_sid"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_sid"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_Feed_Mill_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_Feed_Mill_date"] == EW_REPORT_INIT_VALUE) { // Select all
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
	$_SESSION["sel_Feed_Mill_$parm"] = "";
	$_SESSION["rf_Feed_Mill_$parm"] = "";
	$_SESSION["rt_Feed_Mill_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Feed_Mill_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Feed_Mill_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Feed_Mill_$parm"];
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

	// Field feedmill
	// Setup your default values for the popup filter below, e.g.
	// $seld_feedmill = array("val1", "val2");

	$GLOBALS["seld_feedmill"] = "";
	$GLOBALS["sel_feedmill"] =  $GLOBALS["seld_feedmill"];

	// Field feedtype
	// Setup your default values for the popup filter below, e.g.
	// $seld_feedtype = array("val1", "val2");

	$GLOBALS["seld_feedtype"] = "";
	$GLOBALS["sel_feedtype"] =  $GLOBALS["seld_feedtype"];

	// Field sid
	// Setup your default values for the popup filter below, e.g.
	// $seld_sid = array("val1", "val2");

	$GLOBALS["seld_sid"] = "";
	$GLOBALS["sel_sid"] =  $GLOBALS["seld_sid"];

	// Field date
	// Setup your default values for the popup filter below, e.g.
	// $seld_date = array("val1", "val2");

	$GLOBALS["seld_date"] = "";
	$GLOBALS["sel_date"] =  $GLOBALS["seld_date"];
}

// Check if filter applied
function CheckFilter() {

	// Check feedmill popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_feedmill"], $GLOBALS["sel_feedmill"]))
		return TRUE;

	// Check feedtype popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_feedtype"], $GLOBALS["sel_feedtype"]))
		return TRUE;

	// Check sid popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_sid"], $GLOBALS["sel_sid"]))
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

	// Field feedmill
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_feedmill"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_feedmill"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Feedmill<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field feedtype
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_feedtype"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_feedtype"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Feedtype<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field sid
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_sid"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_sid"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Sid<br />";
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
	if (is_array($GLOBALS["sel_feedmill"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_feedmill"], "feed_fformula.feedmill", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_feedmill"], $GLOBALS["gb_feedmill"], $GLOBALS["gi_feedmill"], $GLOBALS["gq_feedmill"]);
	}
	if (is_array($GLOBALS["sel_feedtype"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_feedtype"], "feed_fformula.feedtype", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_feedtype"], $GLOBALS["gb_feedtype"], $GLOBALS["gi_feedtype"], $GLOBALS["gq_feedtype"]);
	}
	if (is_array($GLOBALS["sel_sid"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_sid"], "feed_fformula.sid", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_sid"], $GLOBALS["gb_sid"], $GLOBALS["gi_sid"], $GLOBALS["gq_sid"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "feed_formula.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
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
			$_SESSION["sort_Feed_Mill_feedmill"] = "";
			$_SESSION["sort_Feed_Mill_feedtype"] = "";
			$_SESSION["sort_Feed_Mill_sid"] = "";
			$_SESSION["sort_Feed_Mill_date"] = "";
			$_SESSION["sort_Feed_Mill_ingredient"] = "";
			$_SESSION["sort_Feed_Mill_quantity"] = "";
			$_SESSION["sort_Feed_Mill_unit"] = "";
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
function script1(a) {
window.open(a,'BIMS','width=600,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
}
</script>
