<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
 <!-- <style type="text/css">
        thead tr {
            position: absolute; 
            height: 20px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:20px; 
            overflow: scroll; 
        }
    </style>-->
<?php } ?>
<?php
session_start();
ob_start();
if($_GET['fromdate'] <> "")
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}
else
$fromdate = $todate = date("Y-m-d");
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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Broiler Feed Transfer</font></strong></td>
</tr>
<tr>
<td> From : <?php echo date($datephp,strtotime($fromdate)); ?></td><td>&nbsp; To : <?php echo date($datephp,strtotime($todate)); ?></td>
</tr>
</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "broiler_feedtransfer", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "broiler_feedtransfer_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "broiler_feedtransfer_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "broiler_feedtransfer_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "broiler_feedtransfer_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "broiler_feedtransfer_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "ims_stocktransfer Inner Join ims_itemcodes On ims_stocktransfer.code = ims_itemcodes.code";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT ims_stocktransfer.date, ims_stocktransfer.fromwarehouse, ims_stocktransfer.towarehouse, ims_stocktransfer.tmno, ims_stocktransfer.code, ims_itemcodes.description, ims_stocktransfer.tounits, ims_stocktransfer.quantity, ims_stocktransfer.price, ims_stocktransfer.quantity * ims_stocktransfer.price As 'amount' FROM " . $EW_REPORT_TABLE_SQL_FROM;

if($_SESSION['db'] == "feedatives")
{
   if($_SESSION['sectorr'] == "all")
   {
	$EW_REPORT_TABLE_SQL_WHERE = "ims_stocktransfer.cat = 'Broiler Feed' and ims_stocktransfer.date >= '$fromdate' and ims_stocktransfer.date <= '$todate'";
   }
   else
   { 
   $sectorr = $_SESSION['sectorr'];
  $EW_REPORT_TABLE_SQL_WHERE = "ims_stocktransfer.cat = 'Broiler Feed' and ims_stocktransfer.date >= '$fromdate' and ims_stocktransfer.date <= '$todate' AND (ims_stocktransfer.towarehouse IN (select distinct(broiler_farm.farm) from broiler_farm where broiler_farm.place = '$sectorr' and broiler_farm.type <> 'rental'))";
   }   
 }
else
{
   $EW_REPORT_TABLE_SQL_WHERE = "ims_stocktransfer.cat = 'Broiler Feed' and ims_stocktransfer.date >= '$fromdate' and ims_stocktransfer.date <= '$todate'";
}

$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "ims_stocktransfer.date ASC, ims_stocktransfer.fromwarehouse ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "ims_stocktransfer.date", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(ims_stocktransfer.quantity) AS SUM_quantity, SUM(`amount`) AS SUM_amount FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = array(); // Popup filter for date
$af_date[0][0] = "@@1";
$af_date[0][1] = "Past";
$af_date[0][2] = ewrpt_IsPast(); // Return sql part
$af_date[1][0] = "@@2";
$af_date[1][1] = "Future";
$af_date[1][2] = ewrpt_IsFuture(); // Return sql part
$af_date[2][0] = "@@3";
$af_date[2][1] = "Last 30 days";
$af_date[2][2] = ewrpt_IsLast30Days(); // Return sql part
$af_date[3][0] = "@@4";
$af_date[3][1] = "Last 14 days";
$af_date[3][2] = ewrpt_IsLast14Days(); // Return sql part
$af_date[4][0] = "@@5";
$af_date[4][1] = "Last 7 days";
$af_date[4][2] = ewrpt_IsLast7Days(); // Return sql part
$af_date[5][0] = "@@6";
$af_date[5][1] = "Next 7 days";
$af_date[5][2] = ewrpt_IsNext7Days(); // Return sql part
$af_date[6][0] = "@@7";
$af_date[6][1] = "Next 14 days";
$af_date[6][2] = ewrpt_IsNext14Days(); // Return sql part
$af_date[7][0] = "@@8";
$af_date[7][1] = "Next 30 days";
$af_date[7][2] = ewrpt_IsNext30Days(); // Return sql part
$af_date[8][0] = "@@9";
$af_date[8][1] = "Yesterday";
$af_date[8][2] = ewrpt_IsYesterday(); // Return sql part
$af_date[9][0] = "@@10";
$af_date[9][1] = "Today";
$af_date[9][2] = ewrpt_IsToday(); // Return sql part
$af_date[10][0] = "@@11";
$af_date[10][1] = "Tomorrow";
$af_date[10][2] = ewrpt_IsTomorrow(); // Return sql part
$af_date[11][0] = "@@12";
$af_date[11][1] = "Last month";
$af_date[11][2] = ewrpt_IsLastMonth(); // Return sql part
$af_date[12][0] = "@@13";
$af_date[12][1] = "This month";
$af_date[12][2] = ewrpt_IsThisMonth(); // Return sql part
$af_date[13][0] = "@@14";
$af_date[13][1] = "Next month";
$af_date[13][2] = ewrpt_IsNextMonth(); // Return sql part
$af_date[14][0] = "@@15";
$af_date[14][1] = "Last two weeks";
$af_date[14][2] = ewrpt_IsLast2Weeks(); // Return sql part
$af_date[15][0] = "@@16";
$af_date[15][1] = "Last week";
$af_date[15][2] = ewrpt_IsLastWeek(); // Return sql part
$af_date[16][0] = "@@17";
$af_date[16][1] = "This week";
$af_date[16][2] = ewrpt_IsThisWeek(); // Return sql part
$af_date[17][0] = "@@18";
$af_date[17][1] = "Next week";
$af_date[17][2] = ewrpt_IsNextWeek(); // Return sql part
$af_date[18][0] = "@@19";
$af_date[18][1] = "Next two weeks";
$af_date[18][2] = ewrpt_IsNext2Weeks(); // Return sql part
$af_date[19][0] = "@@20";
$af_date[19][1] = "Last year";
$af_date[19][2] = ewrpt_IsLastYear(); // Return sql part
$af_date[20][0] = "@@21";
$af_date[20][1] = "This year";
$af_date[20][2] = ewrpt_IsThisYear(); // Return sql part
$af_date[21][0] = "@@22";
$af_date[21][1] = "Next year";
$af_date[21][2] = ewrpt_IsNextYear(); // Return sql part
$af_tmno = NULL; // Popup filter for tmno
$af_fromwarehouse = NULL; // Popup filter for fromwarehouse
$af_towarehouse = NULL; // Popup filter for towarehouse
$af_code = NULL; // Popup filter for code
$af_tounits = NULL; // Popup filter for tounits
$af_quantity = NULL; // Popup filter for quantity
$af_price = NULL; // Popup filter for price
$af_amount = NULL; // Popup filter for amount
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
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "ims_stocktransfer.date";
$EW_REPORT_FIELD_FROMWAREHOUSE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.fromwarehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FROMWAREHOUSE_SQL_ORDERBY = "ims_stocktransfer.fromwarehouse";
$EW_REPORT_FIELD_TMNO_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.tmno FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TMNO_SQL_ORDERBY = "ims_stocktransfer.tmno";
$EW_REPORT_FIELD_TOWAREHOUSE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.towarehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TOWAREHOUSE_SQL_ORDERBY = "ims_stocktransfer.towarehouse";
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT ims_stocktransfer.code FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "ims_stocktransfer.code";
?>
<?php

// Field variables
$x_date = NULL;
$x_tmno = NULL;
$x_fromwarehouse = NULL;
$x_towarehouse = NULL;
$x_code = NULL;
$x_tounits = NULL;
$x_quantity = NULL;
$x_price = NULL;
$x_amount = NULL;
$x_description = NULL;

// Group variables
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;
$o_fromwarehouse = NULL; $g_fromwarehouse = NULL; $dg_fromwarehouse = NULL; $t_fromwarehouse = NULL; $ft_fromwarehouse = 200; $gf_fromwarehouse = $ft_fromwarehouse; $gb_fromwarehouse = ""; $gi_fromwarehouse = "0"; $gq_fromwarehouse = ""; $rf_fromwarehouse = NULL; $rt_fromwarehouse = NULL;

// Detail variables
$o_tmno = NULL; $t_tmno = NULL; $ft_tmno = 200; $rf_tmno = NULL; $rt_tmno = NULL;
$o_towarehouse = NULL; $t_towarehouse = NULL; $ft_towarehouse = 200; $rf_towarehouse = NULL; $rt_towarehouse = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_tounits = NULL; $t_tounits = NULL; $ft_tounits = 200; $rf_tounits = NULL; $rt_tounits = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_price = NULL; $t_price = NULL; $ft_price = 5; $rf_price = NULL; $rt_price = NULL;
$o_amount = NULL; $t_amount = NULL; $ft_amount = 5; $rf_amount = NULL; $rt_amount = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 9;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_fromwarehouse = "";
$seld_fromwarehouse = "";
$val_fromwarehouse = "";
$sel_tmno = "";
$seld_tmno = "";
$val_tmno = "";
$sel_towarehouse = "";
$seld_towarehouse = "";
$val_towarehouse = "";
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
<center>

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
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("broiler_feedtransfer_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_fromwarehouse, $sel_fromwarehouse, $ft_fromwarehouse) ?>
ewrpt_CreatePopup("broiler_feedtransfer_fromwarehouse", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_tmno, $sel_tmno, $ft_tmno) ?>
ewrpt_CreatePopup("broiler_feedtransfer_tmno", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_towarehouse, $sel_towarehouse, $ft_towarehouse) ?>
ewrpt_CreatePopup("broiler_feedtransfer_towarehouse", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code) ?>
ewrpt_CreatePopup("broiler_feedtransfer_code", [<?php echo $jsdata ?>]);
</script>
<div id="broiler_feedtransfer_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="broiler_feedtransfer_fromwarehouse_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="broiler_feedtransfer_tmno_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="broiler_feedtransfer_towarehouse_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="broiler_feedtransfer_code_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" align="center" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="broilerfeedtransfer.php?export=html&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="broilerfeedtransfer.php?export=excel&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="broilerfeedtransfer.php?export=word&fromdate=<?php echo date($datephp,strtotime($fromdate)); ?>&todate=<?php echo date($datephp,strtotime($todate)); ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broilerfeedtransfer.php?cmd=reset">Reset All Filters</a>
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
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="broilerfeedtransfer.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table>
 <tr>
 <td>From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage('');"/></td>
  <td>To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage('');"/></td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="text-align:center">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<!-- Report Grid (Begin) --><center>
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" style="text-align:center">
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'broiler_feedtransfer_date', true, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'broiler_feedtransfer_fromwarehouse', false, '<?php echo $rf_fromwarehouse; ?>', '<?php echo $rt_fromwarehouse; ?>');return false;" name="x_fromwarehouse<?php echo $cnt[0][0]; ?>" id="x_fromwarehouse<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		To Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>To Warehouse</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'broiler_feedtransfer_towarehouse', false, '<?php echo $rf_towarehouse; ?>', '<?php echo $rt_towarehouse; ?>');return false;" name="x_towarehouse<?php echo $cnt[0][0]; ?>" id="x_towarehouse<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Tmno
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Tmno</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'broiler_feedtransfer_tmno', false, '<?php echo $rf_tmno; ?>', '<?php echo $rt_tmno; ?>');return false;" name="x_tmno<?php echo $cnt[0][0]; ?>" id="x_tmno<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'broiler_feedtransfer_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_code<?php echo $cnt[0][0]; ?>" id="x_code<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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

<?php
if($_SESSION['client'] == "SKDNEW")
{
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="No. Of Bags">
		Bags
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="No. Of Bags">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Bags</td>
			</tr></table>
		</td>
<?php } 
}?>

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
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php if(date("d.m.Y",strtotime($x_date)) <> "01.01.1970") echo ewrpt_ViewValue(date($datephp,strtotime($x_date))); else echo ewrpt_ViewValue(); ?>
		<?php $x_date = $t_date; ?></td>
		<td class="ewRptGrpField2" align="left">
		<?php $t_fromwarehouse = $x_fromwarehouse; $x_fromwarehouse = $dg_fromwarehouse; ?>
<?php echo ewrpt_ViewValue($x_fromwarehouse) ?>
		<?php $x_fromwarehouse = $t_fromwarehouse; ?></td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo ewrpt_ViewValue($x_towarehouse) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_tmno) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_code) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_tounits) ?>
</td>
<?php if($_SESSION['client'] == "SKDNEW")
{ 
$qty = 0;$qty = $x_quantity; $bags= 0; $bags=round(($qty/70),2);?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($bags) ?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_quantity)) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_price)) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_amount)) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date = $x_date;
		$o_fromwarehouse = $x_fromwarehouse;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	
		<?php $t_fromwarehouse = $x_fromwarehouse; $x_fromwarehouse = $o_fromwarehouse; ?>

 
	<?php /*?><tr>
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="4" class="ewRptGrpSummary2">SUM for Fromwarehouse:<?php echo ewrpt_ViewValue($x_fromwarehouse) ?></td>
		<?php $x_fromwarehouse = $t_fromwarehouse; ?>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<?php if($_SESSION['client'] == "SKDNEW")
		{?>
		<td class="ewRptGrpSummary2" align="right">
		<?php $qty = 0;$bags=0;$qty = $smry[2][5];$bags=round(($qty/70),2);// Load SUM ?>
     <?php echo ewrpt_ViewValue($bags) ?>
		</td>
		<?php }?>
		<td class="ewRptGrpSummary2" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[2][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_quantity)) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2" align="right">
		<?php $t_amount = $x_amount; ?>
		<?php $x_amount = $smry[2][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_amount)) ?>
		<?php $x_amount = $t_amount; ?>
		</td>
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
?>
	<?php $t_date = $x_date; $x_date = $o_date; ?>

 
	<?php /*?><tr>
		<td colspan="5" class="ewRptGrpSummary1">SUM for Date:<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?><?php $x_date = $t_date; ?></td>
		
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		
		<?php if($_SESSION['client'] == "SKDNEW")
		{?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $qty = 0;$bags=0;$qty = $smry[1][5];$bags=round(($qty/70),2);// Load SUM ?>
     <?php echo ewrpt_ViewValue($bags) ?>
		</td>
		<?php }?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $smry[1][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_quantity)) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_amount = $x_amount; ?>
		<?php $x_amount = $smry[1][7]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_amount)) ?>
		<?php $x_amount = $t_amount; ?>
		</td>
	</tr><?php */?>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
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
		$grandsmry[5] = $rsagg->fields("SUM_quantity");
		$grandsmry[7] = $rsagg->fields("SUM_amount");
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
	<!-- tr><td colspan="10"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="11">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="2" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php if($_SESSION['client'] == "SKDNEW")
		{?>
		<td align="right">
		<?php $qty = 0;$bags=0;$qty = $grandsmry[5];$bags=round(($qty/70),2);
		//$bags=round(($qty/70),2); ?>
     <?php echo ewrpt_ViewValue($bags) ?>
		</td>
		<?php }?>
		
		<td align="right">
		<?php $t_quantity = $x_quantity; ?>
		<?php $x_quantity = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_quantity)) ?>
		<?php $x_quantity = $t_quantity; ?>
		</td>
		<td>&nbsp;</td>
		<td align="right">
		<?php $t_amount = $x_amount; ?>
		<?php $x_amount = $grandsmry[7]; // Load SUM ?>
<?php echo ewrpt_ViewValue(changeprice($x_amount)) ?>
		<?php $x_amount = $t_amount; ?>
		</td>
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="broilerfeedtransfer.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="broilerfeedtransfer.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
</center>
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
		$GLOBALS['x_tmno'] = $rs->fields('tmno');
		$GLOBALS['x_fromwarehouse'] = $rs->fields('fromwarehouse');
		$GLOBALS['x_towarehouse'] = $rs->fields('towarehouse');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_tounits'] = $rs->fields('tounits');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_price'] = $rs->fields('price');
		$GLOBALS['x_amount'] = $rs->fields('amount');
		$GLOBALS['x_description'] = $rs->fields('description');
		$val[1] = $GLOBALS['x_tmno'];
		$val[2] = $GLOBALS['x_towarehouse'];
		$val[3] = $GLOBALS['x_code'];
		$val[4] = $GLOBALS['x_tounits'];
		$val[5] = $GLOBALS['x_quantity'];
		$val[6] = $GLOBALS['x_price'];
		$val[7] = $GLOBALS['x_amount'];
		$val[8] = $GLOBALS['x_description'];
	} else {
		$GLOBALS['x_tmno'] = "";
		$GLOBALS['x_fromwarehouse'] = "";
		$GLOBALS['x_towarehouse'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_tounits'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_price'] = "";
		$GLOBALS['x_amount'] = "";
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
	// Build distinct values for date

	ewrpt_SetupDistinctValuesFromFilter($GLOBALS["val_date"], $GLOBALS["af_date"]); // Set up popup filter
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
			$t_towarehouse = $x_towarehouse;
			ewrpt_SetupDistinctValues($GLOBALS["val_towarehouse"], $x_towarehouse, $t_towarehouse, FALSE);
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
			$t_code = $x_code;
			ewrpt_SetupDistinctValues($GLOBALS["val_code"], $x_code, $t_code, FALSE);
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
			ClearSessionSelection('date');
			ClearSessionSelection('fromwarehouse');
			ClearSessionSelection('tmno');
			ClearSessionSelection('towarehouse');
			ClearSessionSelection('code');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_broiler_feedtransfer_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_broiler_feedtransfer_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Fromwarehouse selected values
	if (is_array(@$_SESSION["sel_broiler_feedtransfer_fromwarehouse"])) {
		LoadSelectionFromSession('fromwarehouse');
	} elseif (@$_SESSION["sel_broiler_feedtransfer_fromwarehouse"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_fromwarehouse"] = "";
	}

	// Get Tmno selected values
	if (is_array(@$_SESSION["sel_broiler_feedtransfer_tmno"])) {
		LoadSelectionFromSession('tmno');
	} elseif (@$_SESSION["sel_broiler_feedtransfer_tmno"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_tmno"] = "";
	}

	// Get Towarehouse selected values
	if (is_array(@$_SESSION["sel_broiler_feedtransfer_towarehouse"])) {
		LoadSelectionFromSession('towarehouse');
	} elseif (@$_SESSION["sel_broiler_feedtransfer_towarehouse"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_towarehouse"] = "";
	}

	// Get Code selected values
	if (is_array(@$_SESSION["sel_broiler_feedtransfer_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_broiler_feedtransfer_code"] == EW_REPORT_INIT_VALUE) { // Select all
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
			$nDisplayGrps = 100; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_broiler_feedtransfer_$parm"] = "";
	$_SESSION["rf_broiler_feedtransfer_$parm"] = "";
	$_SESSION["rt_broiler_feedtransfer_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_broiler_feedtransfer_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_broiler_feedtransfer_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_broiler_feedtransfer_$parm"];
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

	// Field tmno
	// Setup your default values for the popup filter below, e.g.
	// $seld_tmno = array("val1", "val2");

	$GLOBALS["seld_tmno"] = "";
	$GLOBALS["sel_tmno"] =  $GLOBALS["seld_tmno"];

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

	// Check tmno popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_tmno"], $GLOBALS["sel_tmno"]))
		return TRUE;

	// Check fromwarehouse popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_fromwarehouse"], $GLOBALS["sel_fromwarehouse"]))
		return TRUE;

	// Check towarehouse popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_towarehouse"], $GLOBALS["sel_towarehouse"]))
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
	if (is_array($GLOBALS["sel_tmno"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_tmno"], "ims_stocktransfer.tmno", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_tmno"]);
	}
	if (is_array($GLOBALS["sel_fromwarehouse"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_fromwarehouse"], "ims_stocktransfer.fromwarehouse", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_fromwarehouse"], $GLOBALS["gb_fromwarehouse"], $GLOBALS["gi_fromwarehouse"], $GLOBALS["gq_fromwarehouse"]);
	}
	if (is_array($GLOBALS["sel_towarehouse"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_towarehouse"], "ims_stocktransfer.towarehouse", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_towarehouse"]);
	}
	if (is_array($GLOBALS["sel_code"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_code"], "ims_stocktransfer.code", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_code"]);
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
			$_SESSION["sort_broiler_feedtransfer_date"] = "";
			$_SESSION["sort_broiler_feedtransfer_fromwarehouse"] = "";
			$_SESSION["sort_broiler_feedtransfer_tmno"] = "";
			$_SESSION["sort_broiler_feedtransfer_towarehouse"] = "";
			$_SESSION["sort_broiler_feedtransfer_code"] = "";
			$_SESSION["sort_broiler_feedtransfer_tounits"] = "";
			$_SESSION["sort_broiler_feedtransfer_quantity"] = "";
			$_SESSION["sort_broiler_feedtransfer_price"] = "";
			$_SESSION["sort_broiler_feedtransfer_amount"] = "";
			$_SESSION["sort_broiler_feedtransfer_description"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "ims_stocktransfer.towarehouse ASC";
		$_SESSION["sort_broiler_feedtransfer_towarehouse"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">

function reloadpage(a)
{
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;
document.location = 'broilerfeedtransfer.php?export=' + a + '&fromdate=' + fdate + '&todate=' + tdate;
}
</script>