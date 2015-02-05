
<?php /*
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 25px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:25px; 
            overflow: scroll; 
        }
    </style>
<?php } */?>

<link href="../css/calendars.css" rel="stylesheet" type="text/css">
<?php 
include "reportheader.php";
include "getemployee.php";

 
 if($_GET['cat'] == "")
 {
  $cat = 'Hatch Eggs';
 }
 else
 {
  $cat = $_GET['cat'];
 }

 
$warehouse = "Hatchery";;

if(($_GET['fromdate'] == "") OR ($_GET['todate'] == ""))
{
 $q1 = "SELECT * FROM ac_definefy";
 $r1 = mysql_query($q1,$conn1);
 while($row1 = mysql_fetch_assoc($r1))
 {
  $fromdate = $row1['fdate'];
  $todate = $row1['tdate'];
 }
}
else
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}

//echo $cat; echo $warehouse; echo $fromdate; echo $todate;

$url = "&fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;
$url1 = "?fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;

?>

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
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "stockreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "stockreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "stockreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "stockreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "stockreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "stockreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ims_itemcodes";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT ims_itemcodes.code, ims_itemcodes.description, ims_itemcodes.sunits FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "ims_itemcodes.cat = '$cat'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "ims_itemcodes.code ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "ims_itemcodes.code", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `code` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
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
$nDisplayGrps = 200; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT ims_itemcodes.code FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "ims_itemcodes.code";
?>
<?php

// Field variables
$x_code = NULL;
$x_description = NULL;
$x_sunits = NULL;

// Group variables
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
$sel_code = "";
$seld_code = "";
$val_code = "";

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
<?php $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code) ?>
ewrpt_CreatePopup("stockreport_code", [<?php echo $jsdata ?>]);
</script>
<div id="stockreport_code_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Hatchery Stock Report from &nbsp;<?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;to&nbsp;<?php echo date($datephp,strtotime($todate)); ?></font></strong></td>
</tr>
</table>
<br/>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="hatcheggreportsmry.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatcheggreportsmry.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatcheggreportsmry.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatcheggreportsmry.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
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
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">

Category&nbsp;
<select id="cat" name="cat" onchange="reloadpage();">
<option value="">-Select-</option>
<?php

$q = "select distinct(type) from ims_itemtypes WHERE (type = 'Hatch Eggs' || type = 'Broiler Chicks' || type = 'Layer Chicks') order by type";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['type']; ?>" <?php if($cat == $qr['type']) { ?> selected="selected" <?php } ?> ><?php echo $qr['type']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;


From Date&nbsp;
<input type="text" size="15" id="fromdate" name="fromdate" value="<?php echo date($datephp,strtotime($fromdate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;
To Date&nbsp;
<input type="text" size="15" id="todate" name="todate" value="<?php echo date($datephp,strtotime($todate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;

Warehouse&nbsp;
<select id="warehouse" name="warehouse" onchange="reloadpage();">
<option value="">-Select-</option>
<?php
$q = "select distinct(sector) from tbl_sector WHERE (type1 = 'Hatchery') order by sector";
$qrs = mysql_query($q,$conn1);
$n1 = mysql_num_rows($qrs);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option  value="<?php echo $qr['sector']; ?>" <?php if($n1 == 1) { ?> selected=selected<?php } ?> <?php if($warehouse == $qr['sector']) { ?> selected="selected" <?php } ?> ><?php echo $qr['sector']; ?></option>
<?php } ?>

</select>
&nbsp;&nbsp;&nbsp;
<form action="hatcheggreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table style="display:none" align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'stockreport_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_code<?php echo $cnt[0][0]; ?>" id="x_code<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
		Storage Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Storage Units</td>
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
		Purchased/Hatched
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchased/Hatched</td>
			</tr></table>
		</td>
<?php } ?>
<?php if(($cat == 'Broiler Chicks') || ($cat == 'Layer Chicks'))
{
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Chicks Transferred
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Chicks Transferred
		</td>
			</tr></table>
		</td>
<?php } } else { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Eggs set
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Eggs Set
		</td>
			</tr></table>
		</td>
<?php } }?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Rejected
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Rejected</td>
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





	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
		$total_opening=$total_purchase=$total_consumed=$total_sold=$total_closing=$total_amount=$total_salesreturn=0;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_code, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_code, EW_REPORT_DATATYPE_STRING, $gb_code, $gi_code, $gq_code);
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
		$dg_code = $x_code;
		if ((is_null($x_code) && is_null($o_code)) ||
			(($x_code <> "" && $o_code == $dg_code) && !ChkLvlBreak(1))) {
			$dg_code = "&nbsp;";
		} elseif (is_null($x_code)) {
			$dg_code = EW_REPORT_NULL_LABEL;
		} elseif ($x_code == "") {
			$dg_code = EW_REPORT_EMPTY_LABEL;
		}
		
?>
<?php 
  /////////getting the OPENING/////////
//////Purchases
$getop = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$x_code' AND date < '$fromdate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') AND dflag = '0'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$purchasedop = $rowop['quantity'];
if($purchasedop == "") $purchasedop = 0;
///////////Goods Receipt
$grop = 0; 
$getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$x_code' AND date < '$fromdate' and po in (select distinct(po) from pp_purchaseorder where (deliverylocation in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || deliverylocation =  '$warehouse')) ";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$grop = $rowop['quantity'];
///////////////Intermediate Receipt
$irecop = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$x_code' AND date < '$fromdate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and riflag = 'R'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$irecop = $rowop['quantity'];
if($irecop == "") $irecop = 0;
///////////////Intermediate Issue
$iiscop = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE code = '$x_code' AND date < '$fromdate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and riflag = 'I'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$iiscop = $rowop['quantity'];
if($iiscop == "") $iiscop = 0;
///////////////Hatchery Tray Setting
if($cat == 'Hatch Eggs')
{
$trayop = 0;
$getop = "SELECT SUM(eggsset) as quantity FROM hatchery_traysetting WHERE settingdate < '$fromdate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$trayop =$rowop['quantity'];
}
else
{
$trayop = 0;
$getop = "SELECT SUM(saleablechicks) as salablechicks FROM hatchery_hatchrecord WHERE hatchdate < '$fromdate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$trayop =$rowop['salablechicks'];
}
////////////////////Stock Adjustment (Add)
$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$x_code' AND date < '$fromdate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Add'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staadd = $rowop['quantity'];
if($staadd == "") $staadd = 0;
////////////////////Stock Adjustment (Deduct)
$staded = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$x_code' AND date < '$fromdate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Deduct'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staded = $rowop['quantity'];
if($staded == "") $staded = 0;
////////////Stock Transfer in
$stockto = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$x_code' AND date < '$fromdate' and (towarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || towarehouse =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$stockto = $rowop['quantity'];
////////////Stock Transfer out
$stockfrom = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$x_code' AND date < '$fromdate' and (fromwarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || fromwarehouse =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$stockfrom = $rowop['quantity'];
/////////end of getting the OPENING/////////
//echo $purchasedop."/".$stadd."/".$grop."/".$trayop."/".$stockto."/".$irecop."/".$staded."/".$stockfrom."/".$iiscop;
if($cat == 'Hatch Eggs')
{
$opening = $purchasedop + $staadd + $grop + $stockto + $irecop - ($staded + $stockfrom + $iiscop + $trayop);
}
else
{
$opening = $purchasedop + $staadd + $grop + $stockto + $irecop + $trayop - ($staded + $stockfrom + $iiscop);
}
////////////////////////////Purchases
//////////////////////////Purchases
$purchased = 0;
$get = "SELECT SUM(receivedquantity) as quantity FROM pp_sobi WHERE code = '$x_code' AND date >= '$fromdate' AND date <= '$todate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') AND dflag = '0'";
$result = mysql_query($get,$conn1);
$row = mysql_fetch_assoc($result);
$purchased = $row['quantity'];
///////////////////////Eggtransfer (from)
$fromeggtrans = 0;
$get = "SELECT SUM(fromeggs) as quantity FROM ims_eggtransfer WHERE fromcode = '$x_code' AND date >= '$fromdate' AND date <= '$todate' AND (fromwarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || fromwarehouse =  '$warehouse')";
$result = mysql_query($get,$conn1);
$row = mysql_fetch_assoc($result);
$fromeggtrans = $row['quantity'];
////////////////Egg Transfer (To)
$toeggtrans = 0;
$get = "SELECT SUM(toeggs) as quantity FROM ims_eggtransfer WHERE tocode = '$x_code' AND date >= '$fromdate' AND date <= '$todate' AND (towarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || towarehouse =  '$warehouse')";
$result = mysql_query($get,$conn1);
$row = mysql_fetch_assoc($result);
$toeggtrans = $row['quantity'];
////////////////Stock Adjustment(Add)
$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$x_code' AND date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Add'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staadd = $rowop['quantity'];
if($staadd == "") $staadd = 0;
///////////////Stock Adjustment (Deduct)
$staded = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE code = '$x_code' AND date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Deduct'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staded = $rowop['quantity'];
if($staded == "") $staded = 0;
////////////////Goods Receipt
$grop = 0;
$getop = "SELECT SUM(receivedquantity) as quantity FROM pp_goodsreceipt WHERE code = '$x_code' AND date >= '$fromdate' AND date <= '$todate' and po in (select distinct(po) from pp_purchaseorder where (deliverylocation in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || deliverylocation =  '$warehouse')) ";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$grop = $rowop['quantity'];
/////////////////Stock Transfer (To)
$stockto =0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$x_code' AND date >= '$fromdate' AND  date <= '$todate' and (towarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || towarehouse =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$stockto = $rowop['quantity'];
$purchase = $purchased + $toeggtrans + $staadd + $stockto + $grop - ($fromeggtrans + $staded); 
if((($purchase == "") || ($purchase == "0")) && ($cat == 'Hatch Eggs'))
{
$getop = "SELECT SUM(quantity) as quantity FROM breeder_production WHERE itemcode in(select distinct(code) from ims_itemcodes where cat = 'Hatch Eggs') AND date1 >= '$fromdate' AND  date1 <= '$todate'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$purchase = $rowop['quantity'];
}


///////////////////////////Eggs Set
if($cat == 'Hatch Eggs'){
$eggset = 0;
$getop = "SELECT SUM(eggsset) as quantity,sum(reject) as reject,sum(waste) as waste FROM hatchery_traysetting WHERE settingdate >= '$fromdate' AND  settingdate <= '$todate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggset = $rowop['quantity'];
$reject = $rowop['reject'];
$waste = $rowop['waste'];
$rejected = $staded + $reject + $waste;
}
else
{
$eggset = 0;
$getop = "SELECT SUM(saleablechicks) as saleablechicks FROM hatchery_hatchrecord WHERE hatchdate >= '$fromdate' AND  hatchdate <= '$todate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$purchase += $rowop['saleablechicks'];
$stockfrom = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE code = '$x_code' AND date >= '$fromdate' AND date <= '$todate' and (fromwarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || fromwarehouse =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggset = $rowop['quantity'];

$getop = "SELECT SUM(quantity) as chicksales FROM oc_cobi WHERE code = '$x_code' AND date >= '$fromdate' AND date <= '$todate' and (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggset += $rowop['chicksales'];
}
//////////////////Closing
$closing = $opening + $purchase - ($eggset + $rejected);
if(( $opening  == 0) && ( $purchased  == 0) && ( $closing  == 0) && ( $consumed  == 0) && ( $sales  == 0))
{
}
else {
?>

	<tr>
		<td class="ewRptGrpField1">
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
$opening = round($opening,2);
$purchase = round($purchase,2);
$closing = round(($closing),2);

?>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($opening); $total_opening+=$opening; ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($purchase); $total_purchase+=$purchase; ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($eggset); $total_eggs+=$eggset; ?>
</td>

<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php if($rejected <> "") {echo changequantity($rejected);} else { echo "0"; } $total_reject+=$rejected; ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($closing); $total_closing+=$closing; ?>
</td>
	</tr>
<?php }

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_code = $x_code;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
?>


	<tr style="display:none">
		<td colspan="3" class="ewRptGrpSummary1">Summary for Code: <?php $t_code = $x_code; $x_code = $o_code; ?>
<?php echo ewrpt_ViewValue($x_code) ?>
<?php $x_code = $t_code; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_code = $x_code; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
<tr><td colspan="3" align="right">Total</td><td align="right" ><?php echo changequantity(round($total_opening,2)) ;?></td><td align="right" ><?php echo changequantity(round($total_purchase,2)) ;?></td><td align="right" ><?php echo changequantity(round($total_eggs,2)) ;?></td><td align="right" ><?php echo changequantity(round($total_reject,2)) ;?></td><td align="right" ><?php echo changequantity(round($total_closing,2)) ;?></td></tr>
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
	<tr class="ewRptGrandSummary"><td colspan="3">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="hatcheggreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table style="display:none" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hatcheggreportsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_code"]) && !is_null($GLOBALS["o_code"])) ||
				(!is_null($GLOBALS["x_code"]) && is_null($GLOBALS["o_code"])) ||
				($GLOBALS["x_code"] <> $GLOBALS["o_code"]);
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
	if ($lvl <= 1) $GLOBALS["o_code"] = "";

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
		$GLOBALS['x_code'] = "";
	} else {
		$GLOBALS['x_code'] = $rsgrp->fields('code');
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
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_sunits'] = $rs->fields('sunits');
		$val[1] = $GLOBALS['x_description'];
		$val[2] = $GLOBALS['x_sunits'];
	} else {
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
			ClearSessionSelection('code');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Code selected values

	if (is_array(@$_SESSION["sel_stockreport_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_stockreport_code"] == EW_REPORT_INIT_VALUE) { // Select all
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
				$nDisplayGrps = 200; // Non-numeric, load default
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
			$nDisplayGrps = 200; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_stockreport_$parm"] = "";
	$_SESSION["rf_stockreport_$parm"] = "";
	$_SESSION["rt_stockreport_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_stockreport_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_stockreport_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_stockreport_$parm"];
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

	// Field code
	// Setup your default values for the popup filter below, e.g.
	// $seld_code = array("val1", "val2");

	$GLOBALS["seld_code"] = "";
	$GLOBALS["sel_code"] =  $GLOBALS["seld_code"];
}

// Check if filter applied
function CheckFilter() {

	// Check code popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_code"], $GLOBALS["sel_code"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

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
			$_SESSION["sort_stockreport_code"] = "";
			$_SESSION["sort_stockreport_description"] = "";
			$_SESSION["sort_stockreport_sunits"] = "";
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
	var cat = document.getElementById('cat').value;
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
	var warehouse = document.getElementById('warehouse').value;
	//document.location = "hatcheggreportsmry.php?fromdate=" + fromdate + "&todate=" + todate + "&cat=" + cat + "&warehouse=" + warehouse;
	var dt1  = parseInt(fromdate.substring(0,2),10); 
var mon1 = parseInt(fromdate.substring(3,5),10);
var yr1  = parseInt(fromdate.substring(6,10),10); 
var dt2  = parseInt(todate.substring(0,2),10); 
var mon2 = parseInt(todate.substring(3,5),10); 
var yr2  = parseInt(todate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

if(Date.parse(date1) <= Date.parse(date2))
	{
	document.location = "hatcheggreportsmry.php?fromdate=" + fromdate + "&todate=" + todate + "&warehouse=" + warehouse + "&cat=" + cat;
	}
	else
	{
	alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}
</script>