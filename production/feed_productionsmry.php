<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
$sExport = @$_GET["export"]; /*
if (@$sExport == "") { ?>
 
  <style type="text/css">
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
    </style>
<?php }*/
session_start();
ob_start();
include "config.php";
include "reportheader.php";
include "getemployee.php";
if($currencyunits == "")
{
$currencyunits = "Rs";
}
include "jquery.php";
$feedmill = $_GET['feedmill'];
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
$extracount = 0;
$totcnt = 0;
 $q = "select sum(labourcharges) as labcharges,sum(noofunits) as totunits,sum(costperunit) as cperunit,sum(elecharges) as echrgs,sum(packing) as pckng,sum(transport) as trnsprt,count(*) as cnt from feed_productionunit where feedmill = '$feedmill' and date >= '$fromdate' and date <= '$todate' ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	  if(($qr['labcharges'] > 0) or ($qr['totunits'] > 0) or ($qr['cperunit'] > 0) or ($qr['pckng'] > 0) or ($qr['trnsprt'] > 0))
	  {
	    $extracount = 1;
	  }
	   $totcnt = $qr['cnt'];
	} 
	$feedcosttotal = 0;	
?>
<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 
  
<?php } ?>
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
define("EW_REPORT_TABLE_VAR", "feed_production", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "feed_production_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "feed_production_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "feed_production_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "feed_production_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "feed_production_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "feed_productionunit";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT feed_productionunit.feedmill, feed_productionunit.mash, feed_productionunit.formula, feed_productionunit.date, feed_productionunit.batches, feed_productionunit.matconsumed, feed_productionunit.production, feed_productionunit.shrinkage, feed_productionunit.materialcost, feed_productionunit.shrinkagecost, feed_productionunit.bagtype, feed_productionunit.noofbags, feed_productionunit.labourcharges, feed_productionunit.noofunits, feed_productionunit.costperunit, feed_productionunit.packing, feed_productionunit.transport, feed_productionunit.other, feed_productionunit.feedcostperbag, feed_productionunit.feedcostperkg, feed_productionunit.formulaid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = " feed_productionunit.feedmill = '$feedmill' and '$fromdate' <= feed_productionunit.date and feed_productionunit.date <= '$todate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "feed_productionunit.feedmill, feed_productionunit.mash, feed_productionunit.formula, feed_productionunit.date, feed_productionunit.batches, feed_productionunit.matconsumed, feed_productionunit.production, feed_productionunit.shrinkage, feed_productionunit.materialcost, feed_productionunit.shrinkagecost, feed_productionunit.bagtype, feed_productionunit.noofbags, feed_productionunit.labourcharges, feed_productionunit.noofunits, feed_productionunit.costperunit, feed_productionunit.packing, feed_productionunit.transport, feed_productionunit.other, feed_productionunit.feedcostperbag, feed_productionunit.feedcostperkg, feed_productionunit.formulaid";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "feed_productionunit.feedmill ASC, feed_productionunit.date ASC, feed_productionunit.mash ASC, feed_productionunit.formula ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "feed_productionunit.feedmill", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `feedmill` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(feed_productionunit.batches) AS SUM_batches, SUM(feed_productionunit.matconsumed) AS SUM_matconsumed, SUM(feed_productionunit.production) AS SUM_production, SUM(feed_productionunit.shrinkage) AS SUM_shrinkage, SUM(feed_productionunit.materialcost) AS SUM_materialcost, SUM(feed_productionunit.shrinkagecost) AS SUM_shrinkagecost, SUM(feed_productionunit.noofbags) AS SUM_noofbags, SUM(feed_productionunit.labourcharges) AS SUM_labourcharges, SUM(feed_productionunit.noofunits) AS SUM_noofunits, SUM(feed_productionunit.costperunit) AS SUM_costperunit, SUM(feed_productionunit.packing) AS SUM_packing, SUM(feed_productionunit.transport) AS SUM_transport, SUM(feed_productionunit.other) AS SUM_other, SUM(feed_productionunit.feedcostperbag) AS SUM_feedcostperbag, SUM(feed_productionunit.feedcostperkg) AS SUM_feedcostperkg FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_feedmill = NULL; // Popup filter for feedmill
$af_mash = NULL; // Popup filter for mash
$af_formula = NULL; // Popup filter for formula
$af_date = NULL; // Popup filter for date
$af_batches = NULL; // Popup filter for batches
$af_matconsumed = NULL; // Popup filter for matconsumed
$af_production = NULL; // Popup filter for production
$af_shrinkage = NULL; // Popup filter for shrinkage
$af_materialcost = NULL; // Popup filter for materialcost
$af_shrinkagecost = NULL; // Popup filter for shrinkagecost
$af_bagtype = NULL; // Popup filter for bagtype
$af_noofbags = NULL; // Popup filter for noofbags
$af_labourcharges = NULL; // Popup filter for labourcharges
$af_noofunits = NULL; // Popup filter for noofunits
$af_costperunit = NULL; // Popup filter for costperunit
$af_packing = NULL; // Popup filter for packing
$af_transport = NULL; // Popup filter for transport
$af_other = NULL; // Popup filter for other
$af_feedcostperbag = NULL; // Popup filter for feedcostperbag
$af_feedcostperkg = NULL; // Popup filter for feedcostperkg
$af_formulaid = NULL; // Popup filter for formulaid
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
$EW_REPORT_FIELD_FEEDMILL_SQL_SELECT = "SELECT DISTINCT feed_productionunit.feedmill FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FEEDMILL_SQL_ORDERBY = "feed_productionunit.feedmill";
$EW_REPORT_FIELD_MASH_SQL_SELECT = "SELECT DISTINCT feed_productionunit.mash FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_MASH_SQL_ORDERBY = "feed_productionunit.mash";
$EW_REPORT_FIELD_FORMULA_SQL_SELECT = "SELECT DISTINCT feed_productionunit.formula FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FORMULA_SQL_ORDERBY = "feed_productionunit.formula";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT feed_productionunit.date FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "feed_productionunit.date";
?>
<?php

// Field variables
$x_feedmill = NULL;
$x_mash = NULL;
$x_formula = NULL;
$x_date = NULL;
$x_batches = NULL;
$x_matconsumed = NULL;
$x_production = NULL;
$x_shrinkage = NULL;
$x_materialcost = NULL;
$x_shrinkagecost = NULL;
$x_bagtype = NULL;
$x_noofbags = NULL;
$x_labourcharges = NULL;
$x_noofunits = NULL;
$x_costperunit = NULL;
$x_packing = NULL;
$x_transport = NULL;
$x_other = NULL;
$x_feedcostperbag = NULL;
$x_feedcostperkg = NULL;
$x_formulaid = NULL;

// Group variables
$o_feedmill = NULL; $g_feedmill = NULL; $dg_feedmill = NULL; $t_feedmill = NULL; $ft_feedmill = 200; $gf_feedmill = $ft_feedmill; $gb_feedmill = ""; $gi_feedmill = "0"; $gq_feedmill = ""; $rf_feedmill = NULL; $rt_feedmill = NULL;
$o_mash = NULL; $g_mash = NULL; $dg_mash = NULL; $t_mash = NULL; $ft_mash = 200; $gf_mash = $ft_mash; $gb_mash = ""; $gi_mash = "0"; $gq_mash = ""; $rf_mash = NULL; $rt_mash = NULL;
$o_formula = NULL; $g_formula = NULL; $dg_formula = NULL; $t_formula = NULL; $ft_formula = 200; $gf_formula = $ft_formula; $gb_formula = ""; $gi_formula = "0"; $gq_formula = ""; $rf_formula = NULL; $rt_formula = NULL;
$o_date = NULL; $g_date = NULL; $dg_date = NULL; $t_date = NULL; $ft_date = 133; $gf_date = $ft_date; $gb_date = ""; $gi_date = "0"; $gq_date = ""; $rf_date = NULL; $rt_date = NULL;

// Detail variables
$o_batches = NULL; $t_batches = NULL; $ft_batches = 5; $rf_batches = NULL; $rt_batches = NULL;
$o_matconsumed = NULL; $t_matconsumed = NULL; $ft_matconsumed = 5; $rf_matconsumed = NULL; $rt_matconsumed = NULL;
$o_production = NULL; $t_production = NULL; $ft_production = 5; $rf_production = NULL; $rt_production = NULL;
$o_shrinkage = NULL; $t_shrinkage = NULL; $ft_shrinkage = 5; $rf_shrinkage = NULL; $rt_shrinkage = NULL;
$o_materialcost = NULL; $t_materialcost = NULL; $ft_materialcost = 5; $rf_materialcost = NULL; $rt_materialcost = NULL;
$o_shrinkagecost = NULL; $t_shrinkagecost = NULL; $ft_shrinkagecost = 5; $rf_shrinkagecost = NULL; $rt_shrinkagecost = NULL;
$o_bagtype = NULL; $t_bagtype = NULL; $ft_bagtype = 200; $rf_bagtype = NULL; $rt_bagtype = NULL;
$o_noofbags = NULL; $t_noofbags = NULL; $ft_noofbags = 5; $rf_noofbags = NULL; $rt_noofbags = NULL;
$o_labourcharges = NULL; $t_labourcharges = NULL; $ft_labourcharges = 5; $rf_labourcharges = NULL; $rt_labourcharges = NULL;
$o_noofunits = NULL; $t_noofunits = NULL; $ft_noofunits = 5; $rf_noofunits = NULL; $rt_noofunits = NULL;
$o_costperunit = NULL; $t_costperunit = NULL; $ft_costperunit = 5; $rf_costperunit = NULL; $rt_costperunit = NULL;
$o_packing = NULL; $t_packing = NULL; $ft_packing = 5; $rf_packing = NULL; $rt_packing = NULL;
$o_transport = NULL; $t_transport = NULL; $ft_transport = 5; $rf_transport = NULL; $rt_transport = NULL;
$o_other = NULL; $t_other = NULL; $ft_other = 5; $rf_other = NULL; $rt_other = NULL;
$o_feedcostperbag = NULL; $t_feedcostperbag = NULL; $ft_feedcostperbag = 5; $rf_feedcostperbag = NULL; $rt_feedcostperbag = NULL;
$o_feedcostperkg = NULL; $t_feedcostperkg = NULL; $ft_feedcostperkg = 5; $rf_feedcostperkg = NULL; $rt_feedcostperkg = NULL;
$o_formulaid = NULL; $t_formulaid = NULL; $ft_formulaid = 3; $rf_formulaid = NULL; $rt_formulaid = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 18;
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
$col = array(FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_feedmill = "";
$seld_feedmill = "";
$val_feedmill = "";
$sel_mash = "";
$seld_mash = "";
$val_mash = "";
$sel_formula = "";
$seld_formula = "";
$val_formula = "";
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
ewrpt_CreatePopup("feed_production_feedmill", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_mash, $sel_mash, $ft_mash) ?>
ewrpt_CreatePopup("feed_production_mash", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_formula, $sel_formula, $ft_formula) ?>
ewrpt_CreatePopup("feed_production_formula", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("feed_production_date", [<?php echo $jsdata ?>]);
</script>
<div id="feed_production_feedmill_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_mash_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_formula_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="feed_production_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<center>
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Feed Production Report for Feedmill: <?php echo $feedmill;?> <br /> From <?php echo $_GET['fromdate'];?> To <?php echo $_GET['todate'];?></font></strong></td>
</tr>
</table>
<br/>

<?php if($_SESSION['client'] == 'KEHINDE')
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in ₦</p></center>

<?php 
}
else
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits;?></p></center>
<?php } ?>
<br/>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="feed_productionsmry.php?export=html&feedmill=<?php echo $feedmill;?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="feed_productionsmry.php?export=excel&feedmill=<?php echo $feedmill;?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Excel</a>
&nbsp;&nbsp;<a href="feed_productionsmry.php?export=word&feedmill=<?php echo $feedmill;?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="feed_productionsmry.php?cmd=reset&feedmill=<?php echo $feedmill;?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Reset All Filters</a>
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
<center>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="feed_productionsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
	<td>Feedmill&nbsp;&nbsp;&nbsp;</td>
	<td>
	<select id="feedmill">
	<option value="">-Select-</option>
	<?php 
	$q = "select distinct(feedmill) from feed_productionunit";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
	<option value="<?php echo $qr['feedmill'];?>" <?php if($qr['feedmill'] == $feedmill) { ?> selected="selected"<?php } ?>><?php echo $qr['feedmill'];?></option>
	<?php } ?>
	</td>
	
	<td>
<span class="phpreportmaker">
From Date&nbsp;
<input type="text" class="datepicker" id="fromdate" name="fromdate" value="<?php if($_GET['fromdate']) { echo $_GET['fromdate']; } else { echo date($datephp); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;

To Date&nbsp;
<input type="text" class="datepicker" id="todate" name="todate" value="<?php if($_GET['todate']) { echo $_GET['todate']; } else { echo date($datephp); }  ?>" onchange="reloadfun();" />
&nbsp;&nbsp;&nbsp;
</span>
</td>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Feedmill
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feedmill</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'feed_production_feedmill', false, '<?php echo $rf_feedmill; ?>', '<?php echo $rt_feedmill; ?>');return false;" name="x_feedmill<?php echo $cnt[0][0]; ?>" id="x_feedmill<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'feed_production_mash', false, '<?php echo $rf_mash; ?>', '<?php echo $rt_mash; ?>');return false;" name="x_mash<?php echo $cnt[0][0]; ?>" id="x_mash<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'feed_production_formula', false, '<?php echo $rf_formula; ?>', '<?php echo $rt_formula; ?>');return false;" name="x_formula<?php echo $cnt[0][0]; ?>" id="x_formula<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'feed_production_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Batches
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Batches</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Material Consumed">
		Mat. Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Material Consumed">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Mat. Consumed</td>
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
		Shrinkage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shrinkage</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Material Cost">
		Mat. Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Material Cost">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Mat. Cost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Shrinkage Cost">
		Shrnk. Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Shrinkage Cost">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shrnk. Cost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Bag Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Bag Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		No. of Bags
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>No. of Bags</td>
			</tr></table>
		</td>
<?php } ?>
<?php if($extracount > 0) { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Labour Charges">
		Lab. Charges
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Labour Charges">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Lab. Charges</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		No. of Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>No. of Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cost Per Unit">
		Cost/Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Cost Per Unit">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cost/Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Packing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Packing</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Transport
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Transport</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Other
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Other</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Cost Per Bag">
		Feed Cost/Bag
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Feed Cost Per Bag">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Cost/Bag</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Cost Per Kg">
		Feed Cost/Kg
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Feed Cost Per Kg">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Cost/Kg</td>
			</tr></table>
		</td>
<?php } ?>
<!--
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Formulaid
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Formulaid</td>
			</tr></table>
		</td>
<?php } ?>
-->
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
		$dg_mash = $x_mash;
		if ((is_null($x_mash) && is_null($o_mash)) ||
			(($x_mash <> "" && $o_mash == $dg_mash) && !ChkLvlBreak(2))) {
			$dg_mash = "&nbsp;";
		} elseif (is_null($x_mash)) {
			$dg_mash = EW_REPORT_NULL_LABEL;
		} elseif ($x_mash == "") {
			$dg_mash = EW_REPORT_EMPTY_LABEL;
		}
		$dg_formula = $x_formula;
		if ((is_null($x_formula) && is_null($o_formula)) ||
			(($x_formula <> "" && $o_formula == $dg_formula) && !ChkLvlBreak(3))) {
			$dg_formula = "&nbsp;";
		} elseif (is_null($x_formula)) {
			$dg_formula = EW_REPORT_NULL_LABEL;
		} elseif ($x_formula == "") {
			$dg_formula = EW_REPORT_EMPTY_LABEL;
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
		$feedtype = "";
		 $q = "select description from ims_itemcodes where code = '$x_mash' ";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	  $feedtype = $x_mash."/".$qr['description'];
	}
		?>
		<td class="ewRptGrpField2">
		<?php $t_mash = $x_mash; $x_mash = $dg_mash; ?>
<?php echo ewrpt_ViewValue($feedtype); ?>
		<?php $x_mash = $t_mash; ?></td>
		<td class="ewRptGrpField3">
		<?php $t_formula = $x_formula; $x_formula = $dg_formula; ?>
<?php echo ewrpt_ViewValue($x_formula) ?>
		<?php $x_formula = $t_formula; ?></td>
		<td class="ewRptGrpField4">
		<?php $t_date = $x_date; $x_date = $dg_date; ?>
<?php if(date("d.m.Y",strtotime($x_date)) <> "01.01.1970") echo ewrpt_ViewValue(date($datephp,strtotime($x_date))); else echo ewrpt_ViewValue(); ?>
		<?php $x_date = $t_date; ?></td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_batches) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($x_matconsumed,2)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($x_production,2)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_shrinkage) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($x_materialcost,2)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_shrinkagecost) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_bagtype) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($x_noofbags,0)); ?>
</td>
<?php if($extracount > 0) { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_labourcharges) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_noofunits) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_costperunit) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_packing) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_transport) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_other) ?>
<?php } ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_feedcostperbag) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_feedcostperkg); $feedcosttotal = $feedcosttotal + $x_feedcostperkg; ?>
</td>
<!--		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_formulaid) ?>
</td>-->
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_feedmill = $x_feedmill;
		$o_mash = $x_mash;
		$o_formula = $x_formula;
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
		<td colspan="18" class="ewRptGrpSummary3">Summary for Formula: <?php $t_formula = $x_formula; $x_formula = $o_formula; ?>
<?php echo ewrpt_ViewValue($x_formula) ?>
<?php $x_formula = $t_formula; ?> (<?php echo ewrpt_FormatNumber($cnt[3][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td class="ewRptGrpField2">&nbsp;</td>
		<td colspan="2" class="ewRptGrpSummary3">SUM</td>
		<td class="ewRptGrpSummary3">
		<?php $t_batches = $x_batches; ?>
		<?php $x_batches = $smry[3][1]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_batches) ?>
		<?php $x_batches = $t_batches; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_matconsumed = $x_matconsumed; ?>
		<?php $x_matconsumed = $smry[3][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_matconsumed,2)); ?>
		<?php $x_matconsumed = $t_matconsumed; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_production = $x_production; ?>
		<?php $x_production = $smry[3][3]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_production,2)); ?>
		<?php $x_production = $t_production; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_shrinkage = $x_shrinkage; ?>
		<?php $x_shrinkage = $smry[3][4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkage) ?>
		<?php $x_shrinkage = $t_shrinkage; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_materialcost = $x_materialcost; ?>
		<?php $x_materialcost = $smry[3][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_materialcost,2)); ?>
		<?php $x_materialcost = $t_materialcost; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_shrinkagecost = $x_shrinkagecost; ?>
		<?php $x_shrinkagecost = $smry[3][6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkagecost) ?>
		<?php $x_shrinkagecost = $t_shrinkagecost; ?>
		</td>
		<td class="ewRptGrpSummary3">&nbsp;</td>
		<td class="ewRptGrpSummary3">
		<?php $t_noofbags = $x_noofbags; ?>
		<?php $x_noofbags = $smry[3][8]; // Load SUM ?>
		<?php echo $bags = ceil($x_noofbags); ?>
<?php echo ewrpt_ViewValue($bags); ?>
		<?php $x_noofbags = $t_noofbags; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_labourcharges = $x_labourcharges; ?>
		<?php $x_labourcharges = $smry[3][9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_labourcharges) ?>
		<?php $x_labourcharges = $t_labourcharges; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_noofunits = $x_noofunits; ?>
		<?php $x_noofunits = $smry[3][10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofunits) ?>
		<?php $x_noofunits = $t_noofunits; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_costperunit = $x_costperunit; ?>
		<?php $x_costperunit = $smry[3][11]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_costperunit) ?>
		<?php $x_costperunit = $t_costperunit; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_packing = $x_packing; ?>
		<?php $x_packing = $smry[3][12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_packing) ?>
		<?php $x_packing = $t_packing; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_transport = $x_transport; ?>
		<?php $x_transport = $smry[3][13]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_transport) ?>
		<?php $x_transport = $t_transport; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_other = $x_other; ?>
		<?php $x_other = $smry[3][14]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_other) ?>
		<?php $x_other = $t_other; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_feedcostperbag = $x_feedcostperbag; ?>
		<?php $x_feedcostperbag = $smry[3][15]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperbag) ?>
		<?php $x_feedcostperbag = $t_feedcostperbag; ?>
		</td>
		<td class="ewRptGrpSummary3">
		<?php $t_feedcostperkg = $x_feedcostperkg; ?>
		<?php $x_feedcostperkg = $smry[3][16]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperkg) ?>
		<?php $x_feedcostperkg = $t_feedcostperkg; ?>
		</td>
		<!--<td class="ewRptGrpSummary3">&nbsp;</td>-->
	</tr>
<?php

			// Reset level 3 summary
			ResetLevelSummary(3);
		} // End check level check
?>
<?php
		if (ChkLvlBreak(2)) {
?>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="19" class="ewRptGrpSummary2">Summary for Feed Type: <?php $t_mash = $x_mash; $x_mash = $o_mash; ?>
<?php echo ewrpt_ViewValue($x_mash) ?>
<?php $x_mash = $t_mash; ?> (<?php echo ewrpt_FormatNumber($cnt[2][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr style="display:none">
		<td class="ewRptGrpField1">&nbsp;</td>
		<td colspan="3" class="ewRptGrpSummary2">SUM</td>
		<td class="ewRptGrpSummary2">
		<?php $t_batches = $x_batches; ?>
		<?php $x_batches = $smry[2][1]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_batches) ?>
		<?php $x_batches = $t_batches; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_matconsumed = $x_matconsumed; ?>
		<?php $x_matconsumed = $smry[2][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_matconsumed,2)); ?>
		<?php $x_matconsumed = $t_matconsumed; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_production = $x_production; ?>
		<?php $x_production = $smry[2][3]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_production,2)); ?>
		<?php $x_production = $t_production; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_shrinkage = $x_shrinkage; ?>
		<?php $x_shrinkage = $smry[2][4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkage) ?>
		<?php $x_shrinkage = $t_shrinkage; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_materialcost = $x_materialcost; ?>
		<?php $x_materialcost = $smry[2][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_materialcost,2)); ?>
		<?php $x_materialcost = $t_materialcost; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_shrinkagecost = $x_shrinkagecost; ?>
		<?php $x_shrinkagecost = $smry[2][6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkagecost) ?>
		<?php $x_shrinkagecost = $t_shrinkagecost; ?>
		</td>
		<td class="ewRptGrpSummary2">&nbsp;</td>
		<td class="ewRptGrpSummary2">
		<?php $t_noofbags = $x_noofbags; ?>
		<?php $x_noofbags = $smry[2][8]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofbags) ?>
		<?php $x_noofbags = $t_noofbags; ?>
		</td>
		<?php if($extracost > 0) { ?>
		<td class="ewRptGrpSummary2">
		<?php $t_labourcharges = $x_labourcharges; ?>
		<?php $x_labourcharges = $smry[2][9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_labourcharges) ?>
		<?php $x_labourcharges = $t_labourcharges; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_noofunits = $x_noofunits; ?>
		<?php $x_noofunits = $smry[2][10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofunits) ?>
		<?php $x_noofunits = $t_noofunits; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_costperunit = $x_costperunit; ?>
		<?php $x_costperunit = $smry[2][11]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_costperunit) ?>
		<?php $x_costperunit = $t_costperunit; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_packing = $x_packing; ?>
		<?php $x_packing = $smry[2][12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_packing) ?>
		<?php $x_packing = $t_packing; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_transport = $x_transport; ?>
		<?php $x_transport = $smry[2][13]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_transport) ?>
		<?php $x_transport = $t_transport; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_other = $x_other; ?>
		<?php $x_other = $smry[2][14]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_other) ?>
		<?php $x_other = $t_other; ?>
		</td>
		<?php } ?>
		<td class="ewRptGrpSummary2">
		<?php $t_feedcostperbag = $x_feedcostperbag; ?>
		<?php $x_feedcostperbag = $smry[2][15]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperbag) ?>
		<?php $x_feedcostperbag = $t_feedcostperbag; ?>
		</td>
		<td class="ewRptGrpSummary2">
		<?php $t_feedcostperkg = $x_feedcostperkg; ?>
		<?php $x_feedcostperkg = $smry[2][16]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperkg) ?>
		<?php $x_feedcostperkg = $t_feedcostperkg; ?>
		</td>
		<!--<td class="ewRptGrpSummary2">&nbsp;</td>-->
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
		<td colspan="20" class="ewRptGrpSummary1">Summary for Feedmill: <?php $t_feedmill = $x_feedmill; $x_feedmill = $o_feedmill; ?>
<?php echo ewrpt_ViewValue($x_feedmill) ?>
<?php $x_feedmill = $t_feedmill; $ncnt = 0;$ncnt =$cnt[1][0];?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr>
		<td colspan="4" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_batches = $x_batches; ?>
		<?php $x_batches = $smry[1][1]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_batches) ?>
		<?php $x_batches = $t_batches; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_matconsumed = $x_matconsumed; ?>
		<?php $x_matconsumed = $smry[1][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_matconsumed,2)); ?>
		<?php $x_matconsumed = $t_matconsumed; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_production = $x_production; ?>
		<?php $x_production = $smry[1][3]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_production,2)); ?>
		<?php $x_production = $t_production; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_shrinkage = $x_shrinkage; ?>
		<?php $x_shrinkage = $smry[1][4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkage) ?>
		<?php $x_shrinkage = $t_shrinkage; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_materialcost = $x_materialcost; ?>
		<?php $x_materialcost = $smry[1][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_materialcost,2)); ?>
		<?php $x_materialcost = $t_materialcost; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_shrinkagecost = $x_shrinkagecost; ?>
		<?php $x_shrinkagecost = $smry[1][6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkagecost) ?>
		<?php $x_shrinkagecost = $t_shrinkagecost; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_noofbags = $x_noofbags; ?>
		<?php $x_noofbags = $smry[1][8]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofbags) ?>
		<?php $x_noofbags = $t_noofbags; ?>
		</td>
		<?php if($extracost > 0) { ?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_labourcharges = $x_labourcharges; ?>
		<?php $x_labourcharges = $smry[1][9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_labourcharges) ?>
		<?php $x_labourcharges = $t_labourcharges; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_noofunits = $x_noofunits; ?>
		<?php $x_noofunits = $smry[1][10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofunits) ?>
		<?php $x_noofunits = $t_noofunits; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_costperunit = $x_costperunit; ?>
		<?php $x_costperunit = $smry[1][11]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_costperunit) ?>
		<?php $x_costperunit = $t_costperunit; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_packing = $x_packing; ?>
		<?php $x_packing = $smry[1][12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_packing) ?>
		<?php $x_packing = $t_packing; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_transport = $x_transport; ?>
		<?php $x_transport = $smry[1][13]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_transport) ?>
		<?php $x_transport = $t_transport; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_other = $x_other; ?>
		<?php $x_other = $smry[1][14]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_other) ?>
		<?php $x_other = $t_other; ?>
		</td>
		<?php } ?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_feedcostperbag = $x_feedcostperbag; ?>
		<?php $x_feedcostperbag = $smry[1][15]; // Load SUM ?>
<?php /*echo ewrpt_ViewValue($x_feedcostperbag)*/ ?>
<?php echo ewrpt_ViewValue(round(($x_feedcostperbag/$ncnt),2)) ?>
		<?php $x_feedcostperbag = $t_feedcostperbag; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_feedcostperkg = $x_feedcostperkg; ?>
		<?php $x_feedcostperkg = $smry[1][16]; // Load SUM ?>
		<?php /* $finalfeedcost = round(($feedcosttotal/$totcnt),2);*/ ?>
		<?php $finalfeedcost = round(($feedcosttotal/$ncnt),2); ?>
<?php echo ewrpt_ViewValue($finalfeedcost) ?>
		<?php $x_feedcostperkg = $t_feedcostperkg; ?>
		</td>
		<!--<td class="ewRptGrpSummary1">&nbsp;</td>-->
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
		$grandsmry[1] = $rsagg->fields("SUM_batches");
		$grandsmry[2] = $rsagg->fields("SUM_matconsumed");
		$grandsmry[3] = $rsagg->fields("SUM_production");
		$grandsmry[4] = $rsagg->fields("SUM_shrinkage");
		$grandsmry[5] = $rsagg->fields("SUM_materialcost");
		$grandsmry[6] = $rsagg->fields("SUM_shrinkagecost");
		$grandsmry[8] = $rsagg->fields("SUM_noofbags");
		$grandsmry[9] = $rsagg->fields("SUM_labourcharges");
		$grandsmry[10] = $rsagg->fields("SUM_noofunits");
		$grandsmry[11] = $rsagg->fields("SUM_costperunit");
		$grandsmry[12] = $rsagg->fields("SUM_packing");
		$grandsmry[13] = $rsagg->fields("SUM_transport");
		$grandsmry[14] = $rsagg->fields("SUM_other");
		$grandsmry[15] = $rsagg->fields("SUM_feedcostperbag");
		$grandsmry[16] = $rsagg->fields("SUM_feedcostperkg");
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
	<!-- tr><td colspan="21"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="21">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="4" class="ewRptGrpAggregate">SUM</td>
		<td>
		<?php $t_batches = $x_batches; ?>
		<?php $x_batches = $grandsmry[1]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_batches) ?>
		<?php $x_batches = $t_batches; ?>
		</td>
		<td>
		<?php $t_matconsumed = $x_matconsumed; ?>
		<?php $x_matconsumed = $grandsmry[2]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_matconsumed,2)); ?>
		<?php $x_matconsumed = $t_matconsumed; ?>
		</td>
		<td>
		<?php $t_production = $x_production; ?>
		<?php $x_production = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_production,2)); ?>
		<?php $x_production = $t_production; ?>
		</td>
		<td>
		<?php $t_shrinkage = $x_shrinkage; ?>
		<?php $x_shrinkage = $grandsmry[4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkage) ?>
		<?php $x_shrinkage = $t_shrinkage; ?>
		</td>
		<td>
		<?php $t_materialcost = $x_materialcost; ?>
		<?php $x_materialcost = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_materialcost,2)); ?>
		<?php $x_materialcost = $t_materialcost; ?>
		</td>
		<td>
		<?php $t_shrinkagecost = $x_shrinkagecost; ?>
		<?php $x_shrinkagecost = $grandsmry[6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_shrinkagecost) ?>
		<?php $x_shrinkagecost = $t_shrinkagecost; ?>
		</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_noofbags = $x_noofbags; ?>
		<?php $x_noofbags = $grandsmry[8]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofbags) ?>
		<?php $x_noofbags = $t_noofbags; ?>
		</td>
		<?php if($extracost > 0) { ?>
		<td>
		<?php $t_labourcharges = $x_labourcharges; ?>
		<?php $x_labourcharges = $grandsmry[9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_labourcharges) ?>
		<?php $x_labourcharges = $t_labourcharges; ?>
		</td>
		<td>
		<?php $t_noofunits = $x_noofunits; ?>
		<?php $x_noofunits = $grandsmry[10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_noofunits) ?>
		<?php $x_noofunits = $t_noofunits; ?>
		</td>
		<td>
		<?php $t_costperunit = $x_costperunit; ?>
		<?php $x_costperunit = $grandsmry[11]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_costperunit) ?>
		<?php $x_costperunit = $t_costperunit; ?>
		</td>
		<td>
		<?php $t_packing = $x_packing; ?>
		<?php $x_packing = $grandsmry[12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_packing) ?>
		<?php $x_packing = $t_packing; ?>
		</td>
		<td>
		<?php $t_transport = $x_transport; ?>
		<?php $x_transport = $grandsmry[13]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_transport) ?>
		<?php $x_transport = $t_transport; ?>
		</td>
		<td>
		<?php $t_other = $x_other; ?>
		<?php $x_other = $grandsmry[14]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_other) ?>
		<?php $x_other = $t_other; ?>
		</td>
		<?php } ?>
		<td>
		<?php $t_feedcostperbag = $x_feedcostperbag; ?>
		<?php $x_feedcostperbag = $grandsmry[15]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperbag) ?>
		<?php $x_feedcostperbag = $t_feedcostperbag; ?>
		</td>
		<td>
		<?php $t_feedcostperkg = $x_feedcostperkg; ?>
		<?php $x_feedcostperkg = $grandsmry[16]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedcostperkg) ?>
		<?php $x_feedcostperkg = $t_feedcostperkg; ?>
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
<form action="feed_productionsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="feed_productionsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_mash"]) && !is_null($GLOBALS["o_mash"])) ||
				(!is_null($GLOBALS["x_mash"]) && is_null($GLOBALS["o_mash"])) ||
				($GLOBALS["x_mash"] <> $GLOBALS["o_mash"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_formula"]) && !is_null($GLOBALS["o_formula"])) ||
				(!is_null($GLOBALS["x_formula"]) && is_null($GLOBALS["o_formula"])) ||
				($GLOBALS["x_formula"] <> $GLOBALS["o_formula"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 2) $GLOBALS["o_mash"] = "";
	if ($lvl <= 3) $GLOBALS["o_formula"] = "";
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
		$GLOBALS['x_mash'] = $rs->fields('mash');
		$GLOBALS['x_formula'] = $rs->fields('formula');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_batches'] = $rs->fields('batches');
		$GLOBALS['x_matconsumed'] = $rs->fields('matconsumed');
		$GLOBALS['x_production'] = $rs->fields('production');
		$GLOBALS['x_shrinkage'] = $rs->fields('shrinkage');
		$GLOBALS['x_materialcost'] = $rs->fields('materialcost');
		$GLOBALS['x_shrinkagecost'] = $rs->fields('shrinkagecost');
		$GLOBALS['x_bagtype'] = $rs->fields('bagtype');
		$GLOBALS['x_noofbags'] = $rs->fields('noofbags');
		$GLOBALS['x_labourcharges'] = $rs->fields('labourcharges');
		$GLOBALS['x_noofunits'] = $rs->fields('noofunits');
		$GLOBALS['x_costperunit'] = $rs->fields('costperunit');
		$GLOBALS['x_packing'] = $rs->fields('packing');
		$GLOBALS['x_transport'] = $rs->fields('transport');
		$GLOBALS['x_other'] = $rs->fields('other');
		$GLOBALS['x_feedcostperbag'] = $rs->fields('feedcostperbag');
		$GLOBALS['x_feedcostperkg'] = $rs->fields('feedcostperkg');
		$GLOBALS['x_formulaid'] = $rs->fields('formulaid');
		$val[1] = $GLOBALS['x_batches'];
		$val[2] = $GLOBALS['x_matconsumed'];
		$val[3] = $GLOBALS['x_production'];
		$val[4] = $GLOBALS['x_shrinkage'];
		$val[5] = $GLOBALS['x_materialcost'];
		$val[6] = $GLOBALS['x_shrinkagecost'];
		$val[7] = $GLOBALS['x_bagtype'];
		$val[8] = $GLOBALS['x_noofbags'];
		$val[9] = $GLOBALS['x_labourcharges'];
		$val[10] = $GLOBALS['x_noofunits'];
		$val[11] = $GLOBALS['x_costperunit'];
		$val[12] = $GLOBALS['x_packing'];
		$val[13] = $GLOBALS['x_transport'];
		$val[14] = $GLOBALS['x_other'];
		$val[15] = $GLOBALS['x_feedcostperbag'];
		$val[16] = $GLOBALS['x_feedcostperkg'];
		$val[17] = $GLOBALS['x_formulaid'];
	} else {
		$GLOBALS['x_mash'] = "";
		$GLOBALS['x_formula'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_batches'] = "";
		$GLOBALS['x_matconsumed'] = "";
		$GLOBALS['x_production'] = "";
		$GLOBALS['x_shrinkage'] = "";
		$GLOBALS['x_materialcost'] = "";
		$GLOBALS['x_shrinkagecost'] = "";
		$GLOBALS['x_bagtype'] = "";
		$GLOBALS['x_noofbags'] = "";
		$GLOBALS['x_labourcharges'] = "";
		$GLOBALS['x_noofunits'] = "";
		$GLOBALS['x_costperunit'] = "";
		$GLOBALS['x_packing'] = "";
		$GLOBALS['x_transport'] = "";
		$GLOBALS['x_other'] = "";
		$GLOBALS['x_feedcostperbag'] = "";
		$GLOBALS['x_feedcostperkg'] = "";
		$GLOBALS['x_formulaid'] = "";
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

	// Build distinct values for mash
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_MASH_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_MASH_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_mash = $rswrk->fields[0];
		if (is_null($x_mash)) {
			$bNullValue = TRUE;
		} elseif ($x_mash == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_mash = $x_mash;
			$dg_mash = $x_mash;
			ewrpt_SetupDistinctValues($GLOBALS["val_mash"], $g_mash, $dg_mash, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_mash"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_mash"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for formula
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FORMULA_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FORMULA_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_formula = $rswrk->fields[0];
		if (is_null($x_formula)) {
			$bNullValue = TRUE;
		} elseif ($x_formula == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_formula = $x_formula;
			$dg_formula = $x_formula;
			ewrpt_SetupDistinctValues($GLOBALS["val_formula"], $g_formula, $dg_formula, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_formula"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_formula"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('mash');
			ClearSessionSelection('formula');
			ClearSessionSelection('date');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Feedmill selected values

	if (is_array(@$_SESSION["sel_feed_production_feedmill"])) {
		LoadSelectionFromSession('feedmill');
	} elseif (@$_SESSION["sel_feed_production_feedmill"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_feedmill"] = "";
	}

	// Get Mash selected values
	if (is_array(@$_SESSION["sel_feed_production_mash"])) {
		LoadSelectionFromSession('mash');
	} elseif (@$_SESSION["sel_feed_production_mash"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_mash"] = "";
	}

	// Get Formula selected values
	if (is_array(@$_SESSION["sel_feed_production_formula"])) {
		LoadSelectionFromSession('formula');
	} elseif (@$_SESSION["sel_feed_production_formula"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_formula"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_feed_production_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_feed_production_date"] == EW_REPORT_INIT_VALUE) { // Select all
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
				$nDisplayGrps = 3; // Non-numeric, load default
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
			$nDisplayGrps = 3; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_feed_production_$parm"] = "";
	$_SESSION["rf_feed_production_$parm"] = "";
	$_SESSION["rt_feed_production_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_feed_production_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_feed_production_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_feed_production_$parm"];
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

	// Field mash
	// Setup your default values for the popup filter below, e.g.
	// $seld_mash = array("val1", "val2");

	$GLOBALS["seld_mash"] = "";
	$GLOBALS["sel_mash"] =  $GLOBALS["seld_mash"];

	// Field formula
	// Setup your default values for the popup filter below, e.g.
	// $seld_formula = array("val1", "val2");

	$GLOBALS["seld_formula"] = "";
	$GLOBALS["sel_formula"] =  $GLOBALS["seld_formula"];

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

	// Check mash popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_mash"], $GLOBALS["sel_mash"]))
		return TRUE;

	// Check formula popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_formula"], $GLOBALS["sel_formula"]))
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

	// Field mash
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_mash"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_mash"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Mash<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field formula
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_formula"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_formula"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Formula<br />";
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
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_feedmill"], "feed_productionunit.feedmill", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_feedmill"], $GLOBALS["gb_feedmill"], $GLOBALS["gi_feedmill"], $GLOBALS["gq_feedmill"]);
	}
	if (is_array($GLOBALS["sel_mash"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_mash"], "feed_productionunit.mash", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_mash"], $GLOBALS["gb_mash"], $GLOBALS["gi_mash"], $GLOBALS["gq_mash"]);
	}
	if (is_array($GLOBALS["sel_formula"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_formula"], "feed_productionunit.formula", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_formula"], $GLOBALS["gb_formula"], $GLOBALS["gi_formula"], $GLOBALS["gq_formula"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "feed_productionunit.date", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"], $GLOBALS["gb_date"], $GLOBALS["gi_date"], $GLOBALS["gq_date"]);
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
			$_SESSION["sort_feed_production_feedmill"] = "";
			$_SESSION["sort_feed_production_mash"] = "";
			$_SESSION["sort_feed_production_formula"] = "";
			$_SESSION["sort_feed_production_date"] = "";
			$_SESSION["sort_feed_production_batches"] = "";
			$_SESSION["sort_feed_production_matconsumed"] = "";
			$_SESSION["sort_feed_production_production"] = "";
			$_SESSION["sort_feed_production_shrinkage"] = "";
			$_SESSION["sort_feed_production_materialcost"] = "";
			$_SESSION["sort_feed_production_shrinkagecost"] = "";
			$_SESSION["sort_feed_production_bagtype"] = "";
			$_SESSION["sort_feed_production_noofbags"] = "";
			$_SESSION["sort_feed_production_labourcharges"] = "";
			$_SESSION["sort_feed_production_noofunits"] = "";
			$_SESSION["sort_feed_production_costperunit"] = "";
			$_SESSION["sort_feed_production_packing"] = "";
			$_SESSION["sort_feed_production_transport"] = "";
			$_SESSION["sort_feed_production_other"] = "";
			$_SESSION["sort_feed_production_feedcostperbag"] = "";
			$_SESSION["sort_feed_production_feedcostperkg"] = "";
			$_SESSION["sort_feed_production_formulaid"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "feed_productionunit.batches ASC";
		$_SESSION["sort_feed_production_batches"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">
function reloadfun()
{
var fdml = document.getElementById('feedmill').value;
var fdate = document.getElementById('fromdate').value;
var tdate = document.getElementById('todate').value;
//document.location='feed_productionsmry.php?feedmill=' + fdml + '&fromdate=' + fdate + '&todate=' + tdate;
var dt1  = parseInt(fdate.substring(0,2),10); 
var mon1 = parseInt(fdate.substring(3,5),10);
var yr1  = parseInt(fdate.substring(6,10),10); 
var dt2  = parseInt(tdate.substring(0,2),10); 
var mon2 = parseInt(tdate.substring(3,5),10); 
var yr2  = parseInt(tdate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

if(Date.parse(date1) < Date.parse(date2))
	{
	document.location='feed_productionsmry.php?feedmill=' + fdml + '&fromdate=' + fdate + '&todate=' + tdate;

}
else
{

alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}
</script>