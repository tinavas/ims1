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
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "reportheader.php";?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "quail_stocksmry", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "quail_stocksmry_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "quail_stocksmry_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "quail_stocksmry_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "quail_stocksmry_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "quail_stocksmry_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ims_itemcodes Inner Join quail_category On ims_itemcodes.cat = quail_category.cat";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT quail_category.cat, ims_itemcodes.code, ims_itemcodes.description FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "quail_category.cat ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "quail_category.cat", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `cat` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_cat = NULL; // Popup filter for cat
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
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
?>
<?php

// Field variables
$x_cat = NULL;
$x_code = NULL;
$x_description = NULL;

// Group variables
$o_cat = NULL; $g_cat = NULL; $dg_cat = NULL; $t_cat = NULL; $ft_cat = 200; $gf_cat = $ft_cat; $gb_cat = ""; $gi_cat = "0"; $gq_cat = ""; $rf_cat = NULL; $rt_cat = NULL;

// Detail variables
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 3;
$nGrps = 2;
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

// No filter
$bFilterApplied = FALSE;

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
</script>
<?php } ?>
<table align="center" border="0" align="center">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Processing Summary <br/> From : <?php echo $_GET['fdate']; ?>&nbsp;To : &nbsp;<?php echo $_GET['tdate']; ?></font></strong></td>
</tr>
</table>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3" align="center"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="quail_stocksmrysmry.php?export=html&fdate=<?php echo $_GET['fdate'];?>&tdate=<?php echo $_GET['tdate']; ?>&pu=<?php echo $_GET['pu'];?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_stocksmrysmry.php?export=excel&fdate=<?php echo $_GET['fdate'];?>&tdate=<?php echo $_GET['tdate']; ?>&pu=<?php echo $_GET['pu'];?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_stocksmrysmry.php?export=word&fdate=<?php echo $_GET['fdate'];?>&tdate=<?php echo $_GET['tdate']; ?>&pu=<?php echo $_GET['pu'];?>">Export to Word</a>
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="quail_stocksmrysmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="quail_stocksmrysmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="quail_stocksmrysmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="quail_stocksmrysmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="quail_stocksmrysmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Cat
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cat</td>
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
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_cat, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_cat, EW_REPORT_DATATYPE_STRING, $gb_cat, $gi_cat, $gq_cat);
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
		$dg_cat = $x_cat;
		if ((is_null($x_cat) && is_null($o_cat)) ||
			(($x_cat <> "" && $o_cat == $dg_cat) && !ChkLvlBreak(1))) {
			$dg_cat = "&nbsp;";
		} elseif (is_null($x_cat)) {
			$dg_cat = EW_REPORT_NULL_LABEL;
		} elseif ($x_cat == "") {
			$dg_cat = EW_REPORT_EMPTY_LABEL;
		}
		$cat = $x_cat;
		$code = $x_code;
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_cat = $x_cat; $x_cat = $dg_cat; ?>
<?php echo ewrpt_ViewValue($x_cat) ?>
		<?php $x_cat = $t_cat; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_code) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php 
$quant = 0;

 $query = "select sum(amount) as quantity from quail_processing where code = '$x_code'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$n = mysql_num_rows($result);
while($rows = mysql_fetch_assoc($result))
{
$quant = $rows['quantity'];
?>

<?php if($quant <> "") { echo ewrpt_ViewValue($quant); } else { echo "0"; } ?>

<?php } ?>
</td>

	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_cat = $x_cat;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_cat = $x_cat; // Save old group value
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
	<!-- tr><td colspan="3"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>

<div class="ewGridLowerPanel">
<?php $fdate = date("Y-m-d",strtotime($_GET['fdate']));
$tdate = date("Y-m-d",strtotime($_GET['tdate']));

$pu = $_GET['pu'];
/////////////////////////////OPENING BALANCE///////////////////////////////////////////////
if($pu == 'All')
{
$query = "SELECT sum(birdsreceived) as brob,sum(birdsmortality)as tmort,sum(shortage) as recvmort from chicken_birdsreceiving where date < '$fdate' and chickenshop in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and client = '$client' ";
}
else
{
$query = "SELECT sum(birdsreceived) as brob,sum(birdsmortality)as tmort,sum(shortage) as recvmort from chicken_birdsreceiving where date < '$fdate' and chickenshop = '$pu' and client = '$client' ";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$birdsreceivedob = $rows['brob'];
$tmort = $rows['tmort'];
$recvmort = $rows['recvmort'];
}
$birdsalequant = 0;
if($pu == 'All')
{
$query = "SELECT sum(birds) as birdsalequant FROM oc_cobi WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Birds%' and client = '$client') and client = '$client' and warehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and date < '$fdate'";
}
else
{
$query = "SELECT sum(birds) as birdsalequant FROM oc_cobi WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Birds%' and client = '$client') and client = '$client' and warehouse = '$pu' and date < '$fdate'";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$birdsalequant = $rows['birdsalequant']; 
$transferout = 0;
if($pu == 'All')
{
$query = "SELECT sum(quantity) as transferout from ims_stocktransfer where date < '$fdate' and fromwarehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and cat LIKE '%Birds%' and client = '$client'";
}
else
{
$query = "SELECT sum(quantity) as transferout from ims_stocktransfer where date < '$fdate' and fromwarehouse = '$pu' and cat LIKE '%Birds%' and client = '$client'";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$transferout = $rows['transferout'];
$chickenprocessing = 0;
if($pu == 'All')
{
$query = "SELECT sum(birds) as cprocessing from chicken_chickentransfer where date < '$fdate' and unit in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and category LIKE '%Birds%' ";
}
else
{
$query = "SELECT sum(birds) as cprocessing from chicken_chickentransfer where date < '$fdate' and unit = '$pu' and category LIKE '%Birds%' ";
}

$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$chickenprocessing = $rows['cprocessing'];
$transferin = 0;
if($pu == 'All')
{
$query = "SELECT sum(quantity) as transferin from ims_stocktransfer where date < '$fdate' and towarehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and cat LIKE '%Birds%' and client = '$client'";
}
else
{
$query = "SELECT sum(quantity) as transferin from ims_stocktransfer where date < '$fdate' and towarehouse = '$pu' and cat LIKE '%Birds%' and client = '$client'";
}

$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$transferin = $rows['transferin'];
//echo $birdsreceivedob."/".$birdssalequant."/".$transferout."/".$chickenprocessing."/".$transferin."/".$tmort."/".$recvmort;
$openingbirds = ($birdsreceivedob) - ($birdsalequant + $transferout + $chickenprocessing) +  ($transferin) -($tmort + $recvmort);

///////////////////////////////ACTUAL BIRDS RECEIVED FROM FARM/////////////////////////////
$birdssent = 0;
if($pu == 'All')
{
$query = "SELECT sum(birdssent) as birdssent from chicken_birdsreceiving where (date between '$fdate' and '$tdate') and chickenshop in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and client = '$client' ";
}
else
{
$query = "SELECT sum(birdssent) as birdssent from chicken_birdsreceiving where (date between '$fdate' and '$tdate') and chickenshop = '$pu' and client = '$client' ";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$birdssent = $rows['birdssent'];

/////////////////////////////LIVE BIRDS TO SALES////////////////////////////////////////////
$lbtransfer = 0;
if($pu == 'All')
{
$query = "SELECT sum(quantity) as transferout from ims_stocktransfer where (date between '$fdate' and '$tdate') and fromwarehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and cat LIKE '%Birds%' and client = '$client'";
}
else
{
$query = "SELECT sum(quantity) as transferout from ims_stocktransfer where (date between '$fdate' and '$tdate') and fromwarehouse = '$pu' and cat LIKE '%Birds%' and client = '$client'";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lbtransfer = $rows['transferout'];
if($pu == 'All')
{
$query = "SELECT sum(birds) as birdsalequant FROM oc_cobi WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Birds%' and client = '$client') and client = '$client' and warehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and (date between '$fdate' and '$tdate')";
}
else
{
$query = "SELECT sum(birds) as birdsalequant FROM oc_cobi WHERE code in (select distinct(code) from ims_itemcodes where cat LIKE '%Birds%' and client = '$client') and client = '$client' and warehouse = '$pu' and (date between '$fdate' and '$tdate')";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$lbsales = $rows['birdsalequant']; 
 
$lbtsales = $lbtransfer + $lbsales;


//////////////////////////////////TRANSFER MORTALITY FROM FARM/////////////////
if($pu == 'All')
{
$query = "SELECT sum(birdsmortality)as tmort,sum(shortage)as shortage from chicken_birdsreceiving where (date between '$fdate' and '$tdate') and chickenshop in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and client = '$client' ";
}
else
{
$query = "SELECT sum(birdsmortality)as tmort,sum(shortage)as shortage from chicken_birdsreceiving where (date between '$fdate' and '$tdate') and chickenshop = '$pu' and client = '$client' ";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$tmortality = $rows['tmort']; 
$shortage = $rows['shortage']; 
}

//////////////////////////////processing//////////////////////////////////////
if($pu == 'All')
{
$query = "SELECT sum(birds) as cprocessing from chicken_chickentransfer where (date between '$fdate' and '$tdate') and unit in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and fromtype LIKE '%Birds%' ";
}
else
{
$query = "SELECT sum(birds) as cprocessing from chicken_chickentransfer where (date between '$fdate' and '$tdate') and unit = '$pu' and fromtype LIKE '%Birds%' ";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$processing = $rows['cprocessing'];

//////////////////////////////BIRDS AS PER DELIVERY NOTE//////////////////////////////////////
if($pu == 'All')
{
$query = "SELECT sum(birds) as birds from broiler_chickentransfer where (date between '$fdate' and '$tdate') and chickenshop in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and client = '$client' ";
}
else
{
$query = "SELECT sum(birds) as birds from broiler_chickentransfer where (date between '$fdate' and '$tdate') and chickenshop = '$pu' and client = '$client' ";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$birds = $rows['birds'];
/////////////////////////////OVER/SHORTAGE FROM FARM////////////////////////////
$over = $birds - $birdssent;
////////////////////////////RETURN BIRDS FROM PROCESSING////////////////////////
if($pu == 'All')
{
$query = "SELECT sum(quantity) as btp from ims_stocktransfer where (date between '$fdate' and '$tdate') and towarehouse in (select distinct(sector) from tbl_sector where type1 = 'Processing Unit' and client = '$client') and cat LIKE '%Birds%' and client = '$client'";
}
else
{
$query = "SELECT sum(quantity) as btp from ims_stocktransfer where (date between '$fdate' and '$tdate') and towarehouse = '$pu' and cat LIKE '%Birds%' and client = '$client'";
}
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$btp= $rows['btp'];
////////////////////////////CLOSING BALANCE////////////////
//echo $openingbirds."/".$birdssent."/".$lbtsales."/".$tmortality."/".$shortage."/".$processing."/".$btp;
$closingbalance = ($openingbirds + $birdssent + $btp) - ($lbtsales + $tmortality + $shortage + $processing);
?>
<div class="ewGridLowerPanel">

<form action="quail_stocksmrysmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table align="center" border="0" align="center">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Live Birds Summary</font></strong></td>
</tr>
</table>
<table id="paraID" border="0" >
<tr>

	<td<?php echo $sItemRowClass1; ?> colspan="8">Opening Birds</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($openingbirds <> "") { echo $openingbirds; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Actual Birds Received From Farm</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($birdssent <> "") { echo $birdssent; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Live Birds To Sales</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($lbtsales <> "") { echo $lbtsales; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Transfer Mortality From Farm</td>
   	<td<?php echo $sItemRowClass1; ?> align="right"><?php if($tmortality <> "") { echo $tmortality; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Receiving Day Mortality</td>
   	<td<?php echo $sItemRowClass1; ?> align="right"><?php if($shortage <> "") { echo $shortage; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Processing</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($processing <> "") { echo $processing; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Birds As Per Deliver Note</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($birds <> "") { echo $birds; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Over/Shortage From Farm</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($over <> "") { echo $over; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Return Birds From Processing</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($btp <> "") { echo $btp; } else { echo "0";} ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass1; ?> colspan="8">Closing Birds</td>
    <td<?php echo $sItemRowClass1; ?> align="right"><?php if($closingbalance <> "") { echo $closingbalance; } else { echo "0";}  ?></td>
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
			return (is_null($GLOBALS["x_cat"]) && !is_null($GLOBALS["o_cat"])) ||
				(!is_null($GLOBALS["x_cat"]) && is_null($GLOBALS["o_cat"])) ||
				($GLOBALS["x_cat"] <> $GLOBALS["o_cat"]);
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
	if ($lvl <= 1) $GLOBALS["o_cat"] = "";

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
		$GLOBALS['x_cat'] = "";
	} else {
		$GLOBALS['x_cat'] = $rsgrp->fields('cat');
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
		$val[1] = $GLOBALS['x_code'];
		$val[2] = $GLOBALS['x_description'];
	} else {
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
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
			ResetPager();
		}
	}

	// Load selection criteria to array
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

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
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
			$_SESSION["sort_quail_stocksmry_cat"] = "";
			$_SESSION["sort_quail_stocksmry_code"] = "";
			$_SESSION["sort_quail_stocksmry_description"] = "";
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
