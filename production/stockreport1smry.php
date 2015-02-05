<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
?>

<?php
include "config.php";
include "../getemployee.php";
if(!isset($_GET['date']))
$date = date($datephp);
else
$date = $_GET['date'];

if(!isset($_GET['cat']))
$cat = "";
else
$cat = $_GET['cat'];

if($cat == "All")
$cc = "<>";
else
$cc = "=";

$oldwarehouse = "&nbsp;";

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
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "stockreport1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "stockreport1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "stockreport1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "stockreport1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "stockreport1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "stockreport1_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ims_itemcodes";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT ims_itemcodes.warehouse, ims_itemcodes.code, ims_itemcodes.description, ims_itemcodes.sunits FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "ims_itemcodes.cat $cc '$cat' ";
$EW_REPORT_TABLE_SQL_GROUPBY = "ims_itemcodes.warehouse, ims_itemcodes.code, ims_itemcodes.description, ims_itemcodes.sunits";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "ims_itemcodes.warehouse ASC, ims_itemcodes.code ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "ims_itemcodes.warehouse", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `warehouse` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_warehouse = NULL; // Popup filter for warehouse
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
$af_sunits = NULL; // Popup filter for sunits
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
$EW_REPORT_FIELD_WAREHOUSE_SQL_SELECT = "SELECT DISTINCT ims_itemcodes.warehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_WAREHOUSE_SQL_ORDERBY = "ims_itemcodes.warehouse";
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT ims_itemcodes.code FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "ims_itemcodes.code";
?>
<?php

// Field variables
$x_warehouse = NULL;
$x_code = NULL;
$x_description = NULL;
$x_sunits = NULL;

// Group variables
$o_warehouse = NULL; $g_warehouse = NULL; $dg_warehouse = NULL; $t_warehouse = NULL; $ft_warehouse = 200; $gf_warehouse = $ft_warehouse; $gb_warehouse = ""; $gi_warehouse = "0"; $gq_warehouse = ""; $rf_warehouse = NULL; $rt_warehouse = NULL;
$o_code = NULL; $g_code = NULL; $dg_code = NULL; $t_code = NULL; $ft_code = 200; $gf_code = $ft_code; $gb_code = ""; $gi_code = "0"; $gq_code = ""; $rf_code = NULL; $rt_code = NULL;

// Detail variables
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
$o_sunits = NULL; $t_sunits = NULL; $ft_sunits = 200; $rf_sunits = NULL; $rt_sunits = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 3;
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
$col = array(FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_warehouse = "";
$seld_warehouse = "";
$val_warehouse = "";
$sel_code = "";
$seld_code = "";
$val_code = "";

$sel_description = "";
$val_description = array();
$ft_description = 200;

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
<?php $jsdata = ewrpt_GetJsData($val_warehouse, $sel_warehouse, $ft_warehouse,$val_warehouse) ?>
ewrpt_CreatePopup("stockreport1_warehouse", [<?php echo $jsdata ?>]);
<?php 
	$q = "select code,description from ims_itemcodes where cat $cc '$cat' order by code";
	$qrs = mysql_query($q,$conn1);
	while($qr = mysql_fetch_assoc($qrs))
	$val_description[$i++] = $qr['description'];
?>
<?php  $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code,$val_description); ?>
ewrpt_CreatePopup("stockreport1_code", [<?php echo $jsdata; ?>]);
</script>
<div id="stockreport1_warehouse_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="stockreport1_code_Popup" class="ewPopup">
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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Stock Report As On <?php echo $date; ?></font></strong></td>
</tr>
</table>
<br/>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="stockreport1smry.php?export=html&date=<?php echo $date; ?>&cat=<?php echo $cat; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="stockreport1smry.php?export=excel&date=<?php echo $date; ?>&cat=<?php echo $cat; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="stockreport1smry.php?export=word&date=<?php echo $date; ?>&cat=<?php echo $cat; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="stockreport1smry.php?cmd=reset&date=<?php echo $date; ?>&cat=<?php echo "All"; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>

<br /><br />

<?php if (@$sExport == "") { ?>
<strong></strong>
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
<table border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<span class="phpreportmaker">
Date&nbsp;
<input type="text" size="15" id="date" name="date" value="<?php echo $date;?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;

Category&nbsp;
<select id="cat" name="cat" onchange="reloadpage();">
<option value="">-Select-</option>
<?php
$q = "select distinct(cat) from ims_itemcodes order by cat";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['cat']; ?>" <?php if($cat == $qr['cat']) { ?> selected="selected" <?php } ?> ><?php echo $qr['cat']; ?></option>
<?php } ?>
<option value="All" <?php if($cat == 'All') { ?> selected="selected" <?php } ?>>All</option>
</select>
&nbsp;&nbsp;&nbsp;
</span>
</td>
<td width="400px">&nbsp;</td>

</tr>
</table>
</div>
<?php } ?>
</td>
</tr>
</table>
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
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Warehouse</td>
			<td style="width: 20px;" align="right">
			<a href="#" onClick="ewrpt_ShowPopup(this.name, 'stockreport1_warehouse', false, '<?php echo $rf_warehouse; ?>', '<?php echo $rt_warehouse; ?>');return false;" name="x_warehouse<?php echo $cnt[0][0]; ?>" id="x_warehouse<?php echo $cnt[0][0]; ?>">
			<img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			<td style="width: 20px;" align="right">
			<a href="#" onClick="ewrpt_ShowPopup(this.name, 'stockreport1_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_code<?php echo $cnt[0][0]; ?>" id="x_code<?php echo $cnt[0][0]; ?>">
			<img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Opening</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Purchased
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchased</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Consumption</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Production</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sold
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sold</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Closing</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Value
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Value</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_warehouse, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_warehouse, EW_REPORT_DATATYPE_STRING, $gb_warehouse, $gi_warehouse, $gq_warehouse);
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
		$dg_warehouse = $x_warehouse;
		if ((is_null($x_warehouse) && is_null($o_warehouse)) ||
			(($x_warehouse <> "" && $o_warehouse == $dg_warehouse) && !ChkLvlBreak(1))) {
			$dg_warehouse = "&nbsp;";
		} elseif (is_null($x_warehouse)) {
			$dg_warehouse = EW_REPORT_NULL_LABEL;
		} elseif ($x_warehouse == "") {
			$dg_warehouse = EW_REPORT_EMPTY_LABEL;
		}
		$dg_code = $x_code;
		if ((is_null($x_code) && is_null($o_code)) ||
			(($x_code <> "" && $o_code == $dg_code) && !ChkLvlBreak(2))) {
			$dg_code = "&nbsp;";
		} elseif (is_null($x_code)) {
			$dg_code = EW_REPORT_NULL_LABEL;
		} elseif ($x_code == "") {
			$dg_code = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php 
			  $warehouse1 = "";
			  $stdcost = 0;
			  $mode = "";
			  $q = "select cm,warehouse,stdcost from ims_itemcodes where code = '$dg_code'";
			  $qrs = mysql_query($q,$conn1);
			  if($qr = mysql_fetch_assoc($qrs))
			  {
			  $warehouse = $warehouse1 = $qr['warehouse'];
			  $stdcost = $qr['stdcost'];
			  $mode = $qr['cm'];
			  }
			  
			  if($warehouse1 == $oldwarehouse)
			  $warehouse1 = "&nbsp;";
			  if($stdcost == "")
			  $stdcost = 0;
			  
		?>
<?php echo $warehouse1;
		$oldwarehouse = $warehouse;
?>
		</td>
	
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_code = $x_code; $x_code = $dg_code; ?>
<?php echo ewrpt_ViewValue($x_code) ?>
		<?php $x_code = $t_code; ?></td>
		
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_sunits) ?>
</td>

<?php 
$date1 = date("Y-m-d",strtotime($date));
///// Calculating Opening stock ////////
$opening = 0;

$q = "select quantity from ac_financialpostings where type = 'IR' and itemcode = '$x_code' and crdr = 'Dr' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());

if($qr = mysql_fetch_assoc($qrs))
$opening = $qr['quantity'];
if($opening == "")
$opening = 0;

$initialpurchased = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'SOBI' or type = 'GR') and itemcode = '$x_code' and crdr = 'Dr' and date < '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$initialpurchased = $qr['quantity'];
if($initialpurchased == "")
$initialpurchased = 0;

$initialconsumed = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'Consumption' or type = 'Item Consumed') and itemcode = '$x_code' and crdr = 'Cr' and date < '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$initialconsumed = $qr['quantity'];
if($initialconsumed == "")
$initialconsumed = 0;


$initialproduced = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'Production' or type = 'Feed Produced') and itemcode = '$x_code' and crdr = 'Dr' and warehouse = '$warehouse' and date < '$date1'";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$initialproduced = $qr['quantity'];
if($initialproduced == "")
$initialproduced = 0;

$initialsold = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'COBI' or type = 'PS') and itemcode = '$x_code' and crdr = 'Cr' and date < '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$initialsold = $qr['quantity'];
if($initialsold == "")
$initialsold = 0;


$opening = $opening + $initialpurchased - $initialconsumed + $initialproduced - $initialsold;

//////end of calculating opeing stock/////////////






///// Calculating Purchased stock ////////
$purchased = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'SOBI' or type = 'GR') and itemcode = '$x_code' and crdr = 'Dr' and date = '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$purchased = $qr['quantity'];
if($purchased == "")
$purchased = 0;


///// Calculating Consumed stock ////////
$consumed = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'Consumption' or type = 'Item Consumed') and itemcode = '$x_code' and crdr = 'Cr' and date = '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$consumed = $qr['quantity'];
if($consumed == "")
$consumed = 0;

///// Calculating Produced stock ////////
$produced = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'Production' or type = 'Feed Produced') and itemcode = '$x_code' and crdr = 'Dr' and warehouse = '$warehouse' and date = '$date1'";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$produced = $qr['quantity'];
if($produced == "")
$produced = 0;

///// Calculating Sold stock ////////
$sold = 0;
$q = "select SUM(quantity) as quantity from ac_financialpostings where (type = 'COBI' or type = 'PS') and itemcode = '$x_code' and crdr = 'Cr' and date = '$date1' and warehouse = '$warehouse' ";
$qrs = mysql_query($q,$conn1);
if($qr = mysql_fetch_assoc($qrs))
$sold = $qr['quantity'];
if($sold == "")
$sold = 0;

$closing = $opening + $purchased - $consumed + $produced - $sold;


if(($stdcost == 0) || ($stdcost == ""))
$stdcost = calculate1($mode,$x_code,$date1,$warehouse);

//if($stdcost == "")
//$stdcost = 0;

$value = $closing * $stdcost;
?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($opening); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($purchased); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($consumed); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($produced); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($sold); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice1($closing); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo changeprice($value); ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_warehouse = $x_warehouse;
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
	$o_warehouse = $x_warehouse; // Save old group value
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
	<tr class="ewRptGrandSummary"><td colspan="11">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="stockreport1smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="stockreport1smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="stockreport1smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="stockreport1smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="stockreport1smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_warehouse"]) && !is_null($GLOBALS["o_warehouse"])) ||
				(!is_null($GLOBALS["x_warehouse"]) && is_null($GLOBALS["o_warehouse"])) ||
				($GLOBALS["x_warehouse"] <> $GLOBALS["o_warehouse"]);
		case 2:
			return (is_null($GLOBALS["x_code"]) && !is_null($GLOBALS["o_code"])) ||
				(!is_null($GLOBALS["x_code"]) && is_null($GLOBALS["o_code"])) ||
				($GLOBALS["x_code"] <> $GLOBALS["o_code"]) || ChkLvlBreak(1); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_warehouse"] = "";
	if ($lvl <= 2) $GLOBALS["o_code"] = "";

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
		$GLOBALS['x_warehouse'] = "";
	} else {
		$GLOBALS['x_warehouse'] = $rsgrp->fields('warehouse');
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
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_sunits'] = $rs->fields('sunits');
		$val[1] = $GLOBALS['x_description'];
		$val[2] = $GLOBALS['x_sunits'];
	} else {
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_sunits'] = "";
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
	// Build distinct values for warehouse

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_WAREHOUSE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_WAREHOUSE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_warehouse = $rswrk->fields[0];
		if (is_null($x_warehouse)) {
			$bNullValue = TRUE;
		} elseif ($x_warehouse == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_warehouse = $x_warehouse;
			$dg_warehouse = $x_warehouse;
			ewrpt_SetupDistinctValues($GLOBALS["val_warehouse"], $g_warehouse, $dg_warehouse, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_warehouse"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_warehouse"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('warehouse');
			ClearSessionSelection('code');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Warehouse selected values

	if (is_array(@$_SESSION["sel_stockreport1_warehouse"])) {
		LoadSelectionFromSession('warehouse');
	} elseif (@$_SESSION["sel_stockreport1_warehouse"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_warehouse"] = "";
	}

	// Get Code selected values
	if (is_array(@$_SESSION["sel_stockreport1_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_stockreport1_code"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_code"] = "";
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
	$_SESSION["sel_stockreport1_$parm"] = "";
	$_SESSION["rf_stockreport1_$parm"] = "";
	$_SESSION["rt_stockreport1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_stockreport1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_stockreport1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_stockreport1_$parm"];
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

	// Field warehouse
	// Setup your default values for the popup filter below, e.g.
	// $seld_warehouse = array("val1", "val2");

	$GLOBALS["seld_warehouse"] = "";
	$GLOBALS["sel_warehouse"] =  $GLOBALS["seld_warehouse"];

	// Field code
	// Setup your default values for the popup filter below, e.g.
	// $seld_code = array("val1", "val2");

	$GLOBALS["seld_code"] = "";
	$GLOBALS["sel_code"] =  $GLOBALS["seld_code"];
}

// Check if filter applied
function CheckFilter() {

	// Check warehouse popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_warehouse"], $GLOBALS["sel_warehouse"]))
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

	// Field warehouse
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_warehouse"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_warehouse"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Warehouse<br />";
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
	if (is_array($GLOBALS["sel_warehouse"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_warehouse"], "ims_itemcodes.warehouse", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_warehouse"], $GLOBALS["gb_warehouse"], $GLOBALS["gi_warehouse"], $GLOBALS["gq_warehouse"]);
	}
	if (is_array($GLOBALS["sel_code"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_code"], "ims_itemcodes.code", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_code"], $GLOBALS["gb_code"], $GLOBALS["gi_code"], $GLOBALS["gq_code"]);
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
			$_SESSION["sort_stockreport1_warehouse"] = "";
			$_SESSION["sort_stockreport1_code"] = "";
			$_SESSION["sort_stockreport1_description"] = "";
			$_SESSION["sort_stockreport1_sunits"] = "";
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
	var date = document.getElementById('date').value;
	var cat = document.getElementById('cat').value;
	document.location = "stockreport1smry.php?date=" + date + "&cat=" + cat;
	
}

</script>
