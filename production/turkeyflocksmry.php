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
<?php include "phprptinc/ewrfn3.php";
      include "reportheader.php";
	  $totalfemale=0;
	  $totalmale=0;  
	  $gf=0; $gm=0;?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "turkeyflock", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "turkeyflock_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "turkeyflock_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "turkeyflock_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "turkeyflock_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "turkeyflock_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`turkey_flock`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`unitcode` ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`unitcode`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `unitcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_unitcode = NULL; // Popup filter for unitcode
$af_shedcode = NULL; // Popup filter for shedcode
$af_sheddescription = NULL; // Popup filter for sheddescription
$af_flockcode = NULL; // Popup filter for flockcode
$af_flockdescription = NULL; // Popup filter for flockdescription
$af_startdate = NULL; // Popup filter for startdate
$af_age = NULL; // Popup filter for age
$af_femaleopening = NULL; // Popup filter for femaleopening
$af_maleopening = NULL; // Popup filter for maleopening
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
$EW_REPORT_FIELD_UNITCODE_SQL_SELECT = "SELECT DISTINCT `unitcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY = "`unitcode`";
$EW_REPORT_FIELD_SHEDCODE_SQL_SELECT = "SELECT DISTINCT `shedcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY = "`shedcode`";
$EW_REPORT_FIELD_SHEDDESCRIPTION_SQL_SELECT = "SELECT DISTINCT `sheddescription` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_SHEDDESCRIPTION_SQL_ORDERBY = "`sheddescription`";
$EW_REPORT_FIELD_STARTDATE_SQL_SELECT = "SELECT DISTINCT `startdate` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_STARTDATE_SQL_ORDERBY = "`startdate`";
?>
<?php

// Field variables
$x_id = NULL;
$x_unitcode = NULL;
$x_unitdescription = NULL;
$x_shedcode = NULL;
$x_sheddescription = NULL;
$x_flockcode = NULL;
$x_flockdescription = NULL;
$x_startdate = NULL;
$x_age = NULL;
$x_femaleopening = NULL;
$x_maleopening = NULL;
$x_cullflag = NULL;
$x_updated = NULL;
$x_client = NULL;

// Group variables
$o_unitcode = NULL; $g_unitcode = NULL; $dg_unitcode = NULL; $t_unitcode = NULL; $ft_unitcode = 200; $gf_unitcode = $ft_unitcode; $gb_unitcode = ""; $gi_unitcode = "0"; $gq_unitcode = ""; $rf_unitcode = NULL; $rt_unitcode = NULL;

// Detail variables
$o_shedcode = NULL; $t_shedcode = NULL; $ft_shedcode = 200; $rf_shedcode = NULL; $rt_shedcode = NULL;
$o_sheddescription = NULL; $t_sheddescription = NULL; $ft_sheddescription = 200; $rf_sheddescription = NULL; $rt_sheddescription = NULL;
$o_flockcode = NULL; $t_flockcode = NULL; $ft_flockcode = 200; $rf_flockcode = NULL; $rt_flockcode = NULL;
$o_flockdescription = NULL; $t_flockdescription = NULL; $ft_flockdescription = 200; $rf_flockdescription = NULL; $rt_flockdescription = NULL;
$o_startdate = NULL; $t_startdate = NULL; $ft_startdate = 133; $rf_startdate = NULL; $rt_startdate = NULL;
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_femaleopening = NULL; $t_femaleopening = NULL; $ft_femaleopening = 3; $rf_femaleopening = NULL; $rt_femaleopening = NULL;
$o_maleopening = NULL; $t_maleopening = NULL; $ft_maleopening = 3; $rf_maleopening = NULL; $rt_maleopening = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 9;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_unitcode = "";
$seld_unitcode = "";
$val_unitcode = "";
$sel_shedcode = "";
$seld_shedcode = "";
$val_shedcode = "";
$sel_sheddescription = "";
$seld_sheddescription = "";
$val_sheddescription = "";
$sel_startdate = "";
$seld_startdate = "";
$val_startdate = "";

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
<?php $jsdata = ewrpt_GetJsData($val_unitcode, $sel_unitcode, $ft_unitcode) ?>
ewrpt_CreatePopup("turkeyflock_unitcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_shedcode, $sel_shedcode, $ft_shedcode) ?>
ewrpt_CreatePopup("turkeyflock_shedcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_sheddescription, $sel_sheddescription, $ft_sheddescription) ?>
ewrpt_CreatePopup("turkeyflock_sheddescription", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_startdate, $sel_startdate, $ft_startdate) ?>
ewrpt_CreatePopup("turkeyflock_startdate", [<?php echo $jsdata ?>]);
</script>
<div id="turkeyflock_unitcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="turkeyflock_shedcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="turkeyflock_sheddescription_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="turkeyflock_startdate_Popup" class="ewPopup">
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

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="turkeyflocksmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="turkeyflocksmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="turkeyflocksmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="turkeyflocksmry.php?cmd=reset">Reset All Filters</a>
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
<form action="turkeyflocksmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="turkeyflocksmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="turkeyflocksmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="turkeyflocksmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="turkeyflocksmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		Unitcode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Unitcode</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'turkeyflock_unitcode', false, '<?php echo $rf_unitcode; ?>', '<?php echo $rt_unitcode; ?>');return false;" name="x_unitcode<?php echo $cnt[0][0]; ?>" id="x_unitcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Shedcode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Shedcode</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'turkeyflock_shedcode', false, '<?php echo $rf_shedcode; ?>', '<?php echo $rt_shedcode; ?>');return false;" name="x_shedcode<?php echo $cnt[0][0]; ?>" id="x_shedcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sheddescription
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sheddescription</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'turkeyflock_sheddescription', false, '<?php echo $rf_sheddescription; ?>', '<?php echo $rt_sheddescription; ?>');return false;" name="x_sheddescription<?php echo $cnt[0][0]; ?>" id="x_sheddescription<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Flockcode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flockcode</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Flockdescription
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flockdescription</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Startdate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Startdate</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'turkeyflock_startdate', false, '<?php echo $rf_startdate; ?>', '<?php echo $rt_startdate; ?>');return false;" name="x_startdate<?php echo $cnt[0][0]; ?>" id="x_startdate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age(In Weeks)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age(In Weeks)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age(In Days)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age(In Days)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Femaleopening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Femaleopening</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Maleopening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Maleopening</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_unitcode, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_unitcode, EW_REPORT_DATATYPE_STRING, $gb_unitcode, $gi_unitcode, $gq_unitcode);
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
		$dg_unitcode = $x_unitcode;
		if ((is_null($x_unitcode) && is_null($o_unitcode)) ||
			(($x_unitcode <> "" && $o_unitcode == $dg_unitcode) && !ChkLvlBreak(1))) {
			$dg_unitcode = "&nbsp;";
		} elseif (is_null($x_unitcode)) {
			$dg_unitcode = EW_REPORT_NULL_LABEL;
		} elseif ($x_unitcode == "") {
			$dg_unitcode = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_unitcode = $x_unitcode; $x_unitcode = $dg_unitcode; ?>
<?php echo ewrpt_ViewValue($x_unitcode) ?>
		<?php $x_unitcode = $t_unitcode; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_shedcode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_sheddescription) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flockcode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_flockdescription) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo date("d-m-Y",strtotime($x_startdate)); ?>
</td>
<?php
 $nume = floor(($x_age / 7));
 $remai = $x_age % 7;
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($nume.'.'.$remai) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_age); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_femaleopening);
        $totalfemale+=$x_femaleopening; 
		$gf+=$x_femaleopening; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_maleopening);
        $totalmale+=$x_maleopening; 
		$gm+=$x_maleopening; ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_unitcode = $x_unitcode;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<tr><td><b>SUM</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?php echo $gf;?></td><td><?php echo $gm;?></td></tr>
<?php

	// Next group
	$o_unitcode = $x_unitcode; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
	$gm=0;
	$gf=0;
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
	<!-- tr><td colspan="9"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="10">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	
	<tr><td><b>SUM</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><?php echo $totalfemale;?></td><td><?php echo $totalmale;?></td></tr>
<?php } ?>

	</tfoot>
	
</table>
</div>
</td></tr>

</table>
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
			return (is_null($GLOBALS["x_unitcode"]) && !is_null($GLOBALS["o_unitcode"])) ||
				(!is_null($GLOBALS["x_unitcode"]) && is_null($GLOBALS["o_unitcode"])) ||
				($GLOBALS["x_unitcode"] <> $GLOBALS["o_unitcode"]);
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
	if ($lvl <= 1) $GLOBALS["o_unitcode"] = "";

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
		$GLOBALS['x_unitcode'] = "";
	} else {
		$GLOBALS['x_unitcode'] = $rsgrp->fields('unitcode');
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
		$GLOBALS['x_id'] = $rs->fields('id');
		$GLOBALS['x_unitdescription'] = $rs->fields('unitdescription');
		$GLOBALS['x_shedcode'] = $rs->fields('shedcode');
		$GLOBALS['x_sheddescription'] = $rs->fields('sheddescription');
		$GLOBALS['x_flockcode'] = $rs->fields('flockcode');
		$GLOBALS['x_flockdescription'] = $rs->fields('flockdescription');
		$GLOBALS['x_startdate'] = $rs->fields('startdate');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_femaleopening'] = $rs->fields('femaleopening');
		$GLOBALS['x_maleopening'] = $rs->fields('maleopening');
		$GLOBALS['x_cullflag'] = $rs->fields('cullflag');
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_shedcode'];
		$val[2] = $GLOBALS['x_sheddescription'];
		$val[3] = $GLOBALS['x_flockcode'];
		$val[4] = $GLOBALS['x_flockdescription'];
		$val[5] = $GLOBALS['x_startdate'];
		$val[6] = $GLOBALS['x_age'];
		$val[7] = $GLOBALS['x_femaleopening'];
		$val[8] = $GLOBALS['x_maleopening'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_unitdescription'] = "";
		$GLOBALS['x_shedcode'] = "";
		$GLOBALS['x_sheddescription'] = "";
		$GLOBALS['x_flockcode'] = "";
		$GLOBALS['x_flockdescription'] = "";
		$GLOBALS['x_startdate'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_femaleopening'] = "";
		$GLOBALS['x_maleopening'] = "";
		$GLOBALS['x_cullflag'] = "";
		$GLOBALS['x_updated'] = "";
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
	// Build distinct values for unitcode

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_unitcode = $rswrk->fields[0];
		if (is_null($x_unitcode)) {
			$bNullValue = TRUE;
		} elseif ($x_unitcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_unitcode = $x_unitcode;
			$dg_unitcode = $x_unitcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], $g_unitcode, $dg_unitcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for shedcode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SHEDCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SHEDCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_shedcode = $rswrk->fields[0];
		if (is_null($x_shedcode)) {
			$bNullValue = TRUE;
		} elseif ($x_shedcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_shedcode = $x_shedcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], $x_shedcode, $t_shedcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_shedcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for sheddescription
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_SHEDDESCRIPTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_SHEDDESCRIPTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_sheddescription = $rswrk->fields[0];
		if (is_null($x_sheddescription)) {
			$bNullValue = TRUE;
		} elseif ($x_sheddescription == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_sheddescription = $x_sheddescription;
			ewrpt_SetupDistinctValues($GLOBALS["val_sheddescription"], $x_sheddescription, $t_sheddescription, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sheddescription"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_sheddescription"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for startdate
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_STARTDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_STARTDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_startdate = $rswrk->fields[0];
		if (is_null($x_startdate)) {
			$bNullValue = TRUE;
		} elseif ($x_startdate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_startdate = ewrpt_FormatDateTime($x_startdate,5);
			ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], $x_startdate, $t_startdate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_startdate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('unitcode');
			ClearSessionSelection('shedcode');
			ClearSessionSelection('sheddescription');
			ClearSessionSelection('startdate');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Unitcode selected values

	if (is_array(@$_SESSION["sel_turkeyflock_unitcode"])) {
		LoadSelectionFromSession('unitcode');
	} elseif (@$_SESSION["sel_turkeyflock_unitcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unitcode"] = "";
	}

	// Get Shedcode selected values
	if (is_array(@$_SESSION["sel_turkeyflock_shedcode"])) {
		LoadSelectionFromSession('shedcode');
	} elseif (@$_SESSION["sel_turkeyflock_shedcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_shedcode"] = "";
	}

	// Get Sheddescription selected values
	if (is_array(@$_SESSION["sel_turkeyflock_sheddescription"])) {
		LoadSelectionFromSession('sheddescription');
	} elseif (@$_SESSION["sel_turkeyflock_sheddescription"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_sheddescription"] = "";
	}

	// Get Startdate selected values
	if (is_array(@$_SESSION["sel_turkeyflock_startdate"])) {
		LoadSelectionFromSession('startdate');
	} elseif (@$_SESSION["sel_turkeyflock_startdate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_startdate"] = "";
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
	$_SESSION["sel_turkeyflock_$parm"] = "";
	$_SESSION["rf_turkeyflock_$parm"] = "";
	$_SESSION["rt_turkeyflock_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_turkeyflock_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_turkeyflock_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_turkeyflock_$parm"];
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

	// Field unitcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_unitcode = array("val1", "val2");

	$GLOBALS["seld_unitcode"] = "";
	$GLOBALS["sel_unitcode"] =  $GLOBALS["seld_unitcode"];

	// Field shedcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_shedcode = array("val1", "val2");

	$GLOBALS["seld_shedcode"] = "";
	$GLOBALS["sel_shedcode"] =  $GLOBALS["seld_shedcode"];

	// Field sheddescription
	// Setup your default values for the popup filter below, e.g.
	// $seld_sheddescription = array("val1", "val2");

	$GLOBALS["seld_sheddescription"] = "";
	$GLOBALS["sel_sheddescription"] =  $GLOBALS["seld_sheddescription"];

	// Field startdate
	// Setup your default values for the popup filter below, e.g.
	// $seld_startdate = array("val1", "val2");

	$GLOBALS["seld_startdate"] = "";
	$GLOBALS["sel_startdate"] =  $GLOBALS["seld_startdate"];
}

// Check if filter applied
function CheckFilter() {

	// Check unitcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unitcode"], $GLOBALS["sel_unitcode"]))
		return TRUE;

	// Check shedcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_shedcode"], $GLOBALS["sel_shedcode"]))
		return TRUE;

	// Check sheddescription popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_sheddescription"], $GLOBALS["sel_sheddescription"]))
		return TRUE;

	// Check startdate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_startdate"], $GLOBALS["sel_startdate"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field unitcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_unitcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_unitcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Unitcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field shedcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_shedcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_shedcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Shedcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field sheddescription
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_sheddescription"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_sheddescription"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Sheddescription<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field startdate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_startdate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_startdate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Startdate<br />";
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
	if (is_array($GLOBALS["sel_unitcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unitcode"], "`unitcode`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unitcode"], $GLOBALS["gb_unitcode"], $GLOBALS["gi_unitcode"], $GLOBALS["gq_unitcode"]);
	}
	if (is_array($GLOBALS["sel_shedcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_shedcode"], "`shedcode`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_shedcode"]);
	}
	if (is_array($GLOBALS["sel_sheddescription"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_sheddescription"], "`sheddescription`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_sheddescription"]);
	}
	if (is_array($GLOBALS["sel_startdate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_startdate"], "`startdate`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_startdate"]);
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
			$_SESSION["sort_turkeyflock_unitcode"] = "";
			$_SESSION["sort_turkeyflock_shedcode"] = "";
			$_SESSION["sort_turkeyflock_sheddescription"] = "";
			$_SESSION["sort_turkeyflock_flockcode"] = "";
			$_SESSION["sort_turkeyflock_flockdescription"] = "";
			$_SESSION["sort_turkeyflock_startdate"] = "";
			$_SESSION["sort_turkeyflock_age"] = "";
			$_SESSION["sort_turkeyflock_femaleopening"] = "";
			$_SESSION["sort_turkeyflock_maleopening"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "`shedcode` ASC, `sheddescription` ASC, `flockcode` ASC, `flockdescription` ASC, `startdate` ASC";
		$_SESSION["sort_turkeyflock_shedcode"] = "ASC";
		$_SESSION["sort_turkeyflock_sheddescription"] = "ASC";
		$_SESSION["sort_turkeyflock_flockcode"] = "ASC";
		$_SESSION["sort_turkeyflock_flockdescription"] = "ASC";
		$_SESSION["sort_turkeyflock_startdate"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
