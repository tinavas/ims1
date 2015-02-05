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
define("EW_REPORT_TABLE_VAR", "hparagallab", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "hparagallab_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "hparagallab_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "hparagallab_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "hparagallab_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "hparagallab_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "lab_hparagalab";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "lab_hparagalab.trid ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "lab_hparagalab.trid", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `trid` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_trid = NULL; // Popup filter for trid
$af_sampledate = NULL; // Popup filter for sampledate
$af_reportdate = NULL; // Popup filter for reportdate
$af_source = NULL; // Popup filter for source
$af_collectedby = NULL; // Popup filter for collectedby
$af_sample = NULL; // Popup filter for sample
$af_macagar = NULL; // Popup filter for macagar
$af_bloodagar = NULL; // Popup filter for bloodagar
$af_choclateagar = NULL; // Popup filter for choclateagar
$af_catalase = NULL; // Popup filter for catalase
$af_remarks = NULL; // Popup filter for remarks
$af_id = NULL; // Popup filter for id
$af_client = NULL; // Popup filter for client
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
$EW_REPORT_FIELD_SAMPLEDATE_SQL_SELECT = "SELECT DISTINCT lab_hparagalab.sampledate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SAMPLEDATE_SQL_ORDERBY = "lab_hparagalab.sampledate";
$EW_REPORT_FIELD_REPORTDATE_SQL_SELECT = "SELECT DISTINCT lab_hparagalab.reportdate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_REPORTDATE_SQL_ORDERBY = "lab_hparagalab.reportdate";
$EW_REPORT_FIELD_SOURCE_SQL_SELECT = "SELECT DISTINCT lab_hparagalab.source FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SOURCE_SQL_ORDERBY = "lab_hparagalab.source";
$EW_REPORT_FIELD_COLLECTEDBY_SQL_SELECT = "SELECT DISTINCT lab_hparagalab.collectedby FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_COLLECTEDBY_SQL_ORDERBY = "lab_hparagalab.collectedby";
?>
<?php

// Field variables
$x_trid = NULL;
$x_sampledate = NULL;
$x_reportdate = NULL;
$x_source = NULL;
$x_collectedby = NULL;
$x_sample = NULL;
$x_macagar = NULL;
$x_bloodagar = NULL;
$x_choclateagar = NULL;
$x_catalase = NULL;
$x_remarks = NULL;
$x_id = NULL;
$x_client = NULL;

// Group variables
$o_trid = NULL; $g_trid = NULL; $dg_trid = NULL; $t_trid = NULL; $ft_trid = 3; $gf_trid = $ft_trid; $gb_trid = ""; $gi_trid = "0"; $gq_trid = ""; $rf_trid = NULL; $rt_trid = NULL;

// Detail variables
$o_sampledate = NULL; $t_sampledate = NULL; $ft_sampledate = 133; $rf_sampledate = NULL; $rt_sampledate = NULL;
$o_reportdate = NULL; $t_reportdate = NULL; $ft_reportdate = 133; $rf_reportdate = NULL; $rt_reportdate = NULL;
$o_source = NULL; $t_source = NULL; $ft_source = 200; $rf_source = NULL; $rt_source = NULL;
$o_collectedby = NULL; $t_collectedby = NULL; $ft_collectedby = 200; $rf_collectedby = NULL; $rt_collectedby = NULL;
$o_sample = NULL; $t_sample = NULL; $ft_sample = 200; $rf_sample = NULL; $rt_sample = NULL;
$o_macagar = NULL; $t_macagar = NULL; $ft_macagar = 200; $rf_macagar = NULL; $rt_macagar = NULL;
$o_bloodagar = NULL; $t_bloodagar = NULL; $ft_bloodagar = 200; $rf_bloodagar = NULL; $rt_bloodagar = NULL;
$o_choclateagar = NULL; $t_choclateagar = NULL; $ft_choclateagar = 200; $rf_choclateagar = NULL; $rt_choclateagar = NULL;
$o_catalase = NULL; $t_catalase = NULL; $ft_catalase = 200; $rf_catalase = NULL; $rt_catalase = NULL;
$o_remarks = NULL; $t_remarks = NULL; $ft_remarks = 201; $rf_remarks = NULL; $rt_remarks = NULL;
$o_id = NULL; $t_id = NULL; $ft_id = 3; $rf_id = NULL; $rt_id = NULL;
$o_client = NULL; $t_client = NULL; $ft_client = 200; $rf_client = NULL; $rt_client = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 13;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_sampledate = "";
$seld_sampledate = "";
$val_sampledate = "";
$sel_reportdate = "";
$seld_reportdate = "";
$val_reportdate = "";
$sel_source = "";
$seld_source = "";
$val_source = "";
$sel_collectedby = "";
$seld_collectedby = "";
$val_collectedby = "";

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
<?php $jsdata = ewrpt_GetJsData($val_sampledate, $sel_sampledate, $ft_sampledate) ?>
ewrpt_CreatePopup("hparagallab_sampledate", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_reportdate, $sel_reportdate, $ft_reportdate) ?>
ewrpt_CreatePopup("hparagallab_reportdate", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_source, $sel_source, $ft_source) ?>
ewrpt_CreatePopup("hparagallab_source", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_collectedby, $sel_collectedby, $ft_collectedby) ?>
ewrpt_CreatePopup("hparagallab_collectedby", [<?php echo $jsdata ?>]);
</script>
<div id="hparagallab_sampledate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hparagallab_reportdate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hparagallab_source_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="hparagallab_collectedby_Popup" class="ewPopup">
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
<center>
<table align="center" border="0">
<tr>

<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Heamophilus Paragallinarum</font></strong></td>
</tr>

</table>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="hparagallabsmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="hparagallabsmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="hparagallabsmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hparagallabsmry.php?cmd=reset">Reset All Filters</a>
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
<form action="hparagallabsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Trid
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Trid</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sampledate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sampledate</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hparagallab_sampledate', true, '<?php echo $rf_sampledate; ?>', '<?php echo $rt_sampledate; ?>');return false;" name="x_sampledate<?php echo $cnt[0][0]; ?>" id="x_sampledate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Reportdate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Reportdate</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hparagallab_reportdate', true, '<?php echo $rf_reportdate; ?>', '<?php echo $rt_reportdate; ?>');return false;" name="x_reportdate<?php echo $cnt[0][0]; ?>" id="x_reportdate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Source
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Source</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hparagallab_source', true, '<?php echo $rf_source; ?>', '<?php echo $rt_source; ?>');return false;" name="x_source<?php echo $cnt[0][0]; ?>" id="x_source<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Collectedby
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Collectedby</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'hparagallab_collectedby', true, '<?php echo $rf_collectedby; ?>', '<?php echo $rt_collectedby; ?>');return false;" name="x_collectedby<?php echo $cnt[0][0]; ?>" id="x_collectedby<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sample
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sample</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Macagar
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Macagar</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Bloodagar
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Bloodagar</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Choclateagar
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Choclateagar</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Catalase
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Catalase</td>
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
<?php /*if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Id
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Client
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Client</td>
			</tr></table>
		</td>
<?php }*/ ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_trid, EW_REPORT_DATATYPE_NUMBER);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_trid, EW_REPORT_DATATYPE_NUMBER, $gb_trid, $gi_trid, $gq_trid);
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
		$dg_trid = $x_trid;
		if ((is_null($x_trid) && is_null($o_trid)) ||
			(($x_trid <> "" && $o_trid == $dg_trid) && !ChkLvlBreak(1))) {
			$dg_trid = "&nbsp;";
		} elseif (is_null($x_trid)) {
			$dg_trid = EW_REPORT_NULL_LABEL;
		} elseif ($x_trid == "") {
			$dg_trid = EW_REPORT_EMPTY_LABEL;
		}
		
		$dg_sampledate = $x_sampledate;
		if ((is_null($x_sampledate) && is_null($o_sampledate)) ||
			(($x_sampledate <> "" && $o_sampledate == $dg_sampledate) && !ChkLvlBreak(1))) {
			$dg_sampledate = "&nbsp;";
		} elseif (is_null($x_sampledate)) {
			$dg_sampledate = EW_REPORT_NULL_LABEL;
		} elseif ($x_sampledate == "") {
			$dg_sampledate = EW_REPORT_EMPTY_LABEL;
		}
		
		
		$dg_reportdate = $x_reportdate;
		if ((is_null($x_reportdate) && is_null($o_reportdate)) ||
			(($x_reportdate <> "" && $o_reportdate == $dg_reportdate) && !ChkLvlBreak(1))) {
			$dg_reportdate = "&nbsp;";
		} elseif (is_null($x_reportdate)) {
			$dg_reportdate = EW_REPORT_NULL_LABEL;
		} elseif ($x_reportdate == "") {
			$dg_reportdate = EW_REPORT_EMPTY_LABEL;
		}
		
		$dg_source = $x_source;
		if ((is_null($x_source) && is_null($o_source)) ||
			(($x_source <> "" && $o_source == $dg_source) && !ChkLvlBreak(1))) {
			$dg_source = "&nbsp;";
		} elseif (is_null($x_source)) {
			$dg_source = EW_REPORT_NULL_LABEL;
		} elseif ($x_source == "") {
			$dg_source = EW_REPORT_EMPTY_LABEL;
		}
		
		$dg_collectedby = $x_collectedby;
		if ((is_null($x_collectedby) && is_null($o_collectedby)) ||
			(($x_collectedby <> "" && $o_collectedby == $dg_collectedby) && !ChkLvlBreak(1))) {
			$dg_collectedby = "&nbsp;";
		} elseif (is_null($x_collectedby)) {
			$dg_collectedby = EW_REPORT_NULL_LABEL;
		} elseif ($x_collectedby == "") {
			$dg_collectedby = EW_REPORT_EMPTY_LABEL;
		}
		
		$dg_remarks = $x_remarks;
		if ((is_null($x_remarks) && is_null($o_remarks)) ||
			(($x_remarks <> "" && $o_remarks == $dg_remarks) && !ChkLvlBreak(1))) {
			$dg_remarks = "&nbsp;";
		} elseif (is_null($x_remarks)) {
			$dg_remarks = EW_REPORT_NULL_LABEL;
		} elseif ($x_remarks == "") {
			//$dg_remarks = EW_REPORT_EMPTY_LABEL;
			$dg_remarks = "&nbsp;";
		}
		
		
		
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_trid = $x_trid; $x_trid = $dg_trid; ?>
<?php echo ewrpt_ViewValue($x_trid) ?>
		<?php $x_trid = $t_trid; ?></td>
		
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_sampledate = $x_sampledate; $x_sampledate = $dg_sampledate; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_sampledate,7)) ?>
<?php $x_sampledate = $t_sampledate; ?></td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_reportdate = $x_reportdate; $x_reportdate = $dg_reportdate; ?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_reportdate,7)) ?>
<?php $x_reportdate = $t_reportdate; ?></td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_source = $x_source; $x_source = $dg_source; ?>
<?php echo ewrpt_ViewValue($x_source) ?>
<?php $x_source = $t_source; ?></td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_collectedby = $x_collectedby; $x_collectedby = $dg_collectedby; ?>
<?php echo ewrpt_ViewValue($x_collectedby) ?>
<?php $x_collectedby = $t_collectedby; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_sample) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_macagar) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_bloodagar) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_choclateagar) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_catalase) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
		<?php $t_remarks = $x_remarks; $x_remarks = $dg_remarks; ?>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_remarks)); ?>
<?php $x_remarks = $t_remarks; ?></td>
	<?php /*?>	<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_id) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_client) ?>
</td><?php */?>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_trid = $x_trid;
		$o_sampledate = $x_sampledate;
		$o_reportdate = $x_reportdate;
		$o_source = $x_source;
		$o_collectedby = $x_collectedby;
		$o_remarks = $x_remarks;
		

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_trid = $x_trid;
	$o_sampledate = $x_sampledate;
	$o_reportdate = $x_reportdate; 
	$o_source = $x_source;
	$o_collectedbye = $x_collectedby;
	$o_remarks = $x_remarks;// Save old group value
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
	<!-- tr><td colspan="13"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="11">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="hparagallabsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="hparagallabsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_trid"]) && !is_null($GLOBALS["o_trid"])) ||
				(!is_null($GLOBALS["x_trid"]) && is_null($GLOBALS["o_trid"])) ||
				($GLOBALS["x_trid"] <> $GLOBALS["o_trid"]);
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
	if ($lvl <= 1) $GLOBALS["o_trid"] = "";

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
		$GLOBALS['x_trid'] = "";
	} else {
		$GLOBALS['x_trid'] = $rsgrp->fields('trid');
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
		$GLOBALS['x_sampledate'] = $rs->fields('sampledate');
		$GLOBALS['x_reportdate'] = $rs->fields('reportdate');
		$GLOBALS['x_source'] = $rs->fields('source');
		$GLOBALS['x_collectedby'] = $rs->fields('collectedby');
		$GLOBALS['x_sample'] = $rs->fields('sample');
		$GLOBALS['x_macagar'] = $rs->fields('macagar');
		$GLOBALS['x_bloodagar'] = $rs->fields('bloodagar');
		$GLOBALS['x_choclateagar'] = $rs->fields('choclateagar');
		$GLOBALS['x_catalase'] = $rs->fields('catalase');
		$GLOBALS['x_remarks'] = $rs->fields('remarks');
		$GLOBALS['x_id'] = $rs->fields('id');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_sampledate'];
		$val[2] = $GLOBALS['x_reportdate'];
		$val[3] = $GLOBALS['x_source'];
		$val[4] = $GLOBALS['x_collectedby'];
		$val[5] = $GLOBALS['x_sample'];
		$val[6] = $GLOBALS['x_macagar'];
		$val[7] = $GLOBALS['x_bloodagar'];
		$val[8] = $GLOBALS['x_choclateagar'];
		$val[9] = $GLOBALS['x_catalase'];
		$val[10] = $GLOBALS['x_remarks'];
		$val[11] = $GLOBALS['x_id'];
		$val[12] = $GLOBALS['x_client'];
	} else {
		$GLOBALS['x_sampledate'] = "";
		$GLOBALS['x_reportdate'] = "";
		$GLOBALS['x_source'] = "";
		$GLOBALS['x_collectedby'] = "";
		$GLOBALS['x_sample'] = "";
		$GLOBALS['x_macagar'] = "";
		$GLOBALS['x_bloodagar'] = "";
		$GLOBALS['x_choclateagar'] = "";
		$GLOBALS['x_catalase'] = "";
		$GLOBALS['x_remarks'] = "";
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_client'] = "";
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
	// Build distinct values for sampledate

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SAMPLEDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SAMPLEDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_sampledate = $rswrk->fields[0];
		if (is_null($x_sampledate)) {
			$bNullValue = TRUE;
		} elseif ($x_sampledate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_sampledate = ewrpt_FormatDateTime($x_sampledate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_sampledate"], $x_sampledate, $t_sampledate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sampledate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sampledate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for reportdate
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_REPORTDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_REPORTDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_reportdate = $rswrk->fields[0];
		if (is_null($x_reportdate)) {
			$bNullValue = TRUE;
		} elseif ($x_reportdate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_reportdate = ewrpt_FormatDateTime($x_reportdate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_reportdate"], $x_reportdate, $t_reportdate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_reportdate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_reportdate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for source
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SOURCE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SOURCE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_source = $rswrk->fields[0];
		if (is_null($x_source)) {
			$bNullValue = TRUE;
		} elseif ($x_source == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_source = $x_source;
			ewrpt_SetupDistinctValues($GLOBALS["val_source"], $x_source, $t_source, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_source"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_source"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for collectedby
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_COLLECTEDBY_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_COLLECTEDBY_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_collectedby = $rswrk->fields[0];
		if (is_null($x_collectedby)) {
			$bNullValue = TRUE;
		} elseif ($x_collectedby == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_collectedby = $x_collectedby;
			ewrpt_SetupDistinctValues($GLOBALS["val_collectedby"], $x_collectedby, $t_collectedby, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_collectedby"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_collectedby"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('sampledate');
			ClearSessionSelection('reportdate');
			ClearSessionSelection('source');
			ClearSessionSelection('collectedby');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Sampledate selected values

	if (is_array(@$_SESSION["sel_hparagallab_sampledate"])) {
		LoadSelectionFromSession('sampledate');
	} elseif (@$_SESSION["sel_hparagallab_sampledate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_sampledate"] = "";
	}

	// Get Reportdate selected values
	if (is_array(@$_SESSION["sel_hparagallab_reportdate"])) {
		LoadSelectionFromSession('reportdate');
	} elseif (@$_SESSION["sel_hparagallab_reportdate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_reportdate"] = "";
	}

	// Get Source selected values
	if (is_array(@$_SESSION["sel_hparagallab_source"])) {
		LoadSelectionFromSession('source');
	} elseif (@$_SESSION["sel_hparagallab_source"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_source"] = "";
	}

	// Get Collectedby selected values
	if (is_array(@$_SESSION["sel_hparagallab_collectedby"])) {
		LoadSelectionFromSession('collectedby');
	} elseif (@$_SESSION["sel_hparagallab_collectedby"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_collectedby"] = "";
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
	$_SESSION["sel_hparagallab_$parm"] = "";
	$_SESSION["rf_hparagallab_$parm"] = "";
	$_SESSION["rt_hparagallab_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_hparagallab_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_hparagallab_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_hparagallab_$parm"];
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

	// Field sampledate
	// Setup your default values for the popup filter below, e.g.
	// $seld_sampledate = array("val1", "val2");

	$GLOBALS["seld_sampledate"] = "";
	$GLOBALS["sel_sampledate"] =  $GLOBALS["seld_sampledate"];

	// Field reportdate
	// Setup your default values for the popup filter below, e.g.
	// $seld_reportdate = array("val1", "val2");

	$GLOBALS["seld_reportdate"] = "";
	$GLOBALS["sel_reportdate"] =  $GLOBALS["seld_reportdate"];

	// Field source
	// Setup your default values for the popup filter below, e.g.
	// $seld_source = array("val1", "val2");

	$GLOBALS["seld_source"] = "";
	$GLOBALS["sel_source"] =  $GLOBALS["seld_source"];

	// Field collectedby
	// Setup your default values for the popup filter below, e.g.
	// $seld_collectedby = array("val1", "val2");

	$GLOBALS["seld_collectedby"] = "";
	$GLOBALS["sel_collectedby"] =  $GLOBALS["seld_collectedby"];
}

// Check if filter applied
function CheckFilter() {

	// Check sampledate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_sampledate"], $GLOBALS["sel_sampledate"]))
		return TRUE;

	// Check reportdate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_reportdate"], $GLOBALS["sel_reportdate"]))
		return TRUE;

	// Check source popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_source"], $GLOBALS["sel_source"]))
		return TRUE;

	// Check collectedby popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_collectedby"], $GLOBALS["sel_collectedby"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field sampledate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_sampledate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_sampledate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Sampledate<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field reportdate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_reportdate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_reportdate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Reportdate<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field source
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_source"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_source"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Source<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field collectedby
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_collectedby"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_collectedby"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Collectedby<br />";
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
	if (is_array($GLOBALS["sel_sampledate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_sampledate"], "lab_hparagalab.sampledate", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_sampledate"]);
	}
	if (is_array($GLOBALS["sel_reportdate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_reportdate"], "lab_hparagalab.reportdate", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_reportdate"]);
	}
	if (is_array($GLOBALS["sel_source"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_source"], "lab_hparagalab.source", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_source"]);
	}
	if (is_array($GLOBALS["sel_collectedby"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_collectedby"], "lab_hparagalab.collectedby", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_collectedby"]);
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
			$_SESSION["sort_hparagallab_trid"] = "";
			$_SESSION["sort_hparagallab_sampledate"] = "";
			$_SESSION["sort_hparagallab_reportdate"] = "";
			$_SESSION["sort_hparagallab_source"] = "";
			$_SESSION["sort_hparagallab_collectedby"] = "";
			$_SESSION["sort_hparagallab_sample"] = "";
			$_SESSION["sort_hparagallab_macagar"] = "";
			$_SESSION["sort_hparagallab_bloodagar"] = "";
			$_SESSION["sort_hparagallab_choclateagar"] = "";
			$_SESSION["sort_hparagallab_catalase"] = "";
			$_SESSION["sort_hparagallab_remarks"] = "";
			$_SESSION["sort_hparagallab_id"] = "";
			$_SESSION["sort_hparagallab_client"] = "";
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
