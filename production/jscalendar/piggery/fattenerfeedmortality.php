<?php
session_start();
ob_start();
$mortcumm = "0";
$cummfeed = "0";
$start="1";
$oldfarmer = "";
$oldflock = "";
$birds = "";
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
<table align="center" border="0" >
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Fattener Feed Consumed And Mortality 
</font></strong></td>
</tr>

</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Report1", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Report1_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Report1_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Report1_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Report1_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Report1_orderby", TRUE);


// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`pig_daily_entry`";
/*$EW_REPORT_TABLE_SQL_FROM = "`pig_daily_entry` Inner Join
  `pig_herd` On `pig_daily_entry`.`flock` = `pig_herd`.`herdcode` Inner Join
  `pig_shed` On `pig_herd`.`shedcode` = `pig_shed`.`shedcode`";*/
/*$EW_REPORT_TABLE_SQL_FROM = "`pig_daily_entry` Inner Join
  `pig_herd` On `pig_daily_entry`.`flock` = `pig_herd`.`herdcode` Inner Join
  `pig_shed` On `pig_herd`.`shedcode` = `pig_shed`.`shedcode`";*/
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
//$EW_REPORT_TABLE_SQL_WHERE = "`pig_daily_entry`.`flock` In (select distinct(herdcode) from pig_herd where shedcode In (select distinct(shedcode) from pig_shed where shedtype='Fattener'))";
$EW_REPORT_TABLE_SQL_WHERE = "`pig_daily_entry`.`flock` In (select distinct(herdcode) from pig_herd where shedtype ='Fattener')";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`flock` ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`flock`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `flock` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(`mortality`) AS SUM_mortality, SUM(`cull`) AS SUM_cull, SUM(`feedconsumed`) AS SUM_feedconsumed, SUM(`birds`) AS SUM_birds FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_flock = NULL; // Popup filter for flock
$af_age = NULL; // Popup filter for age
$af_mortality = NULL; // Popup filter for mortality
$af_cull = NULL; // Popup filter for cull
$af_feedtype = NULL; // Popup filter for feedtype
$af_feedconsumed = NULL; // Popup filter for feedconsumed
$af_average_weight = NULL; // Popup filter for average_weight
$af_medicine_name = NULL; // Popup filter for medicine_name
$af_medicine_quantity = NULL; // Popup filter for medicine_quantity
$af_vaccine_name = NULL; // Popup filter for vaccine_name
$af_vaccine_quantity = NULL; // Popup filter for vaccine_quantity
$af_entrydate = NULL; // Popup filter for entrydate
$af_birds = NULL; // Popup filter for birds
$af_entrytype = NULL; // Popup filter for entrytype
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
$EW_REPORT_FIELD_FLOCK_SQL_SELECT = "SELECT DISTINCT `flock` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FLOCK_SQL_ORDERBY = "`flock`";
$EW_REPORT_FIELD_ENTRYDATE_SQL_SELECT = "SELECT DISTINCT `entrydate` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_ENTRYDATE_SQL_ORDERBY = "`entrydate`";
?>
<?php

// Field variables
$x_SrNo = NULL;
$x_flock = NULL;
$x_age = NULL;
$x_mortality = NULL;
$x_cull = NULL;
$x_feedtype = NULL;
$x_feedconsumed = NULL;
$x_average_weight = NULL;
$x_medicine_name = NULL;
$x_medicine_quantity = NULL;
$x_vaccine_name = NULL;
$x_vaccine_quantity = NULL;
$x_entrydate = NULL;
$x_birds = NULL;
$x_cullflag = NULL;
$x_updated = NULL;
$x_client = NULL;
$x_entrytype = NULL;
$x_phoneno = NULL;

// Group variables
$o_flock = NULL; $g_flock = NULL; $dg_flock = NULL; $t_flock = NULL; $ft_flock = 200; $gf_flock = $ft_flock; $gb_flock = ""; $gi_flock = "0"; $gq_flock = ""; $rf_flock = NULL; $rt_flock = NULL;

// Detail variables
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_mortality = NULL; $t_mortality = NULL; $ft_mortality = 2; $rf_mortality = NULL; $rt_mortality = NULL;
$o_cull = NULL; $t_cull = NULL; $ft_cull = 5; $rf_cull = NULL; $rt_cull = NULL;
$o_feedtype = NULL; $t_feedtype = NULL; $ft_feedtype = 200; $rf_feedtype = NULL; $rt_feedtype = NULL;
$o_feedconsumed = NULL; $t_feedconsumed = NULL; $ft_feedconsumed = 5; $rf_feedconsumed = NULL; $rt_feedconsumed = NULL;
$o_average_weight = NULL; $t_average_weight = NULL; $ft_average_weight = 5; $rf_average_weight = NULL; $rt_average_weight = NULL;
$o_medicine_name = NULL; $t_medicine_name = NULL; $ft_medicine_name = 200; $rf_medicine_name = NULL; $rt_medicine_name = NULL;
$o_medicine_quantity = NULL; $t_medicine_quantity = NULL; $ft_medicine_quantity = 200; $rf_medicine_quantity = NULL; $rt_medicine_quantity = NULL;
$o_vaccine_name = NULL; $t_vaccine_name = NULL; $ft_vaccine_name = 200; $rf_vaccine_name = NULL; $rt_vaccine_name = NULL;
$o_vaccine_quantity = NULL; $t_vaccine_quantity = NULL; $ft_vaccine_quantity = 200; $rf_vaccine_quantity = NULL; $rt_vaccine_quantity = NULL;
$o_entrydate = NULL; $t_entrydate = NULL; $ft_entrydate = 133; $rf_entrydate = NULL; $rt_entrydate = NULL;
$o_birds = NULL; $t_birds = NULL; $ft_birds = 5; $rf_birds = NULL; $rt_birds = NULL;
$o_entrytype = NULL; $t_entrytype = NULL; $ft_entrytype = 200; $rf_entrytype = NULL; $rt_entrytype = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 14;
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
$col = array(FALSE, FALSE, TRUE, TRUE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_flock = "";
$seld_flock = "";
$val_flock = "";
$sel_entrydate = "";
$seld_entrydate = "";
$val_entrydate = "";

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
<?php $jsdata = ewrpt_GetJsData($val_flock, $sel_flock, $ft_flock) ?>
ewrpt_CreatePopup("Report1_flock", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_entrydate, $sel_entrydate, $ft_entrydate) ?>
ewrpt_CreatePopup("Report1_entrydate", [<?php echo $jsdata ?>]);
</script>
<div id="Report1_flock_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report1_entrydate_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="fattenerfeedmortality.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="fattenerfeedmortality.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="fattenerfeedmortality.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="fattenerfeedmortality.php?cmd=reset">Reset All Filters</a>
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
<form action="fattenerfeedmortality.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">
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
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Report1_flock', false, '<?php echo $rf_flock; ?>', '<?php echo $rt_flock; ?>');return false;" name="x_flock<?php echo $cnt[0][0]; ?>" id="x_flock<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Entrydate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Entrydate</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Report1_entrydate', true, '<?php echo $rf_entrydate; ?>', '<?php echo $rt_entrydate; ?>');return false;" name="x_entrydate<?php echo $cnt[0][0]; ?>" id="x_entrydate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Mortality">
		Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Mortality">Mort.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality">
		C.Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality">C.Mort.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality %">
		C.Mort %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality %">C.Mort %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Type">
		F.type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed Type">F.type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Consumed">
		F.cons
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed Consumed">F.cons</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed Consumed">
		C.Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Consumed">C.Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Fatteners
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Fatteners</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_flock, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_flock, EW_REPORT_DATATYPE_STRING, $gb_flock, $gi_flock, $gq_flock);
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
		$dg_flock = $x_flock;
		if ((is_null($x_flock) && is_null($o_flock)) ||
			(($x_flock <> "" && $o_flock == $dg_flock) && !ChkLvlBreak(1))) {
			$dg_flock = "&nbsp;";
		} elseif (is_null($x_flock)) {
			$dg_flock = EW_REPORT_NULL_LABEL;
		} elseif ($x_flock == "") {
			$dg_flock = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_flock = $x_flock; $x_flock = $dg_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
		<?php $x_flock = $t_flock; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_entrydate,7)) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_age) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_mortality) ?>
</td>
<?php 
if ( $o_flock ==  $x_flock )
{ 
  //$birds = 0;
  $x = "0"; $mortcumm = $mortcumm + $x_mortality; $cummfeed = $cummfeed + $x_feedconsumed; 
  $oobirds = $birds;
  $birds = $birds - $mortcumm - $cull;
}
else if($o_flock == "")
{
$birds = 0;$oobirds =0;$mortcumm = 0;$cummfeed=0;$x = "0";
 $query111 = "SELECT sum(fatteneropening) as open from pig_herd where herdcode = '$x_flock'  ";
  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $birds = $row111['open'];  } }
	//$birds = 0;
  $x = "0"; $mortcumm =  $x_mortality; $cummfeed =  $x_feedconsumed; 
  $oobirds = $birds;
   $birds = $birds - $mortcumm - $cull;
}
else
{
$birds = 0;$oobirds =0;$mortcumm = 0;$cummfeed=0;$x = "0";
$query111 = "SELECT sum(fatteneropening) as open from pig_herd where herdcode = '$x_flock'  ";
  $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $birds = $row111['open'];  } }
  

  $mortcumm = $mortcumm + $x_mortality; $cummfeed = $cummfeed + $x_feedconsumed; 
  $oobirds = $birds;
  $birds = $birds - $mortcumm - $cull;
}

$feedperbird = round((($x_feedconsumed/$birds) * 1000),2);
$cumfeedperbird = round((($cummfeed/$oobirds) * 1000),2);
$feedstd = 0;
$cumfeedstd = 0;
$stdfcr = 0;
$stdwt = 0;
include "config.php";
$queryaa = "SELECT * FROM fattener_allstandards WHERE age = '$x_age' ";
$resultaa = mysql_query($queryaa,$conn1);
while($rowaa = mysql_fetch_assoc($resultaa))
{
  $feedstd = $rowaa['feed'];
  $cumfeedstd = $rowaa['cumfeed'];
  $stdfcr = $rowaa['fcr'];
  $stdwt = $rowaa['avgweight'];
} 
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($mortcumm) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round(($mortcumm / ($oobirds)) * 100,2)) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php  include "../config.php";
 $fdesc = ""; $q1 = "SELECT * FROM ims_itemcodes WHERE code = '$x_feedtype'";
 $r1 = mysql_query($q1,$conn1);
 while($row1 = mysql_fetch_assoc($r1))
 {
  $fdesc = $row1['description'];
 }
?>
<?php echo ewrpt_ViewValue($x_feedtype."/".$fdesc) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_feedconsumed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($cummfeed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($birds) ?>
</td>	
		
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_flock = $x_flock;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
?>
	<tr>
		<td colspan="10" class="ewRptGrpSummary1"><b>Summary for Flock: <?php $t_flock = $x_flock; $x_flock = $o_flock; ?>
<?php echo ewrpt_ViewValue($x_flock) ?>
<?php $x_flock = $t_flock; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</b></td></tr>
	<tr>
		<td colspan="1" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		
		<td class="ewRptGrpSummary1">
		<?php $t_mortality = $x_mortality; ?>
		<?php $x_mortality = $smry[1][2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_mortality) ?>
		<?php $x_mortality = $t_mortality; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">
		<?php $t_feedconsumed = $x_feedconsumed; ?>
		<?php $x_feedconsumed = $smry[1][5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedconsumed) ?>
		<?php $x_feedconsumed = $t_feedconsumed; ?>
		</td>
		
		
		<td class="ewRptGrpSummary1">
		<?php $t_birds = $x_birds; ?>
		<?php $x_birds = $smry[1][12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_birds) ?>
		<?php $x_birds = $t_birds; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_flock = $x_flock; // Save old group value
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
		$grandsmry[2] = $rsagg->fields("SUM_mortality");
		$grandsmry[3] = $rsagg->fields("SUM_cull");
		$grandsmry[5] = $rsagg->fields("SUM_feedconsumed");
		$grandsmry[12] = $rsagg->fields("SUM_birds");
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
	<!-- tr><td colspan="14"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="10">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="1" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_mortality = $x_mortality; ?>
		<?php $x_mortality = $grandsmry[2]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_mortality) ?>
		<?php $x_mortality = $t_mortality; ?>
		</td>
		<td>&nbsp;</td>
		<?php /*?><td>
		<?php $t_cull = $x_cull; ?>
		<?php $x_cull = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_cull) ?>
		<?php $x_cull = $t_cull; ?>
		</td><?php */?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		
		<td>
		<?php $t_feedconsumed = $x_feedconsumed; ?>
		<?php $x_feedconsumed = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_feedconsumed) ?>
		<?php $x_feedconsumed = $t_feedconsumed; ?>
		</td>
		<td>&nbsp;</td>
		
		<?php /*?><td>
		<?php $t_birds = $x_birds; ?>
		<?php $x_birds = $grandsmry[12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_birds) ?>
		<?php $x_birds = $t_birds; ?>
		</td><?php */?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="fattenerfeedmortality.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="fattenerfeedmortality.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_flock"]) && !is_null($GLOBALS["o_flock"])) ||
				(!is_null($GLOBALS["x_flock"]) && is_null($GLOBALS["o_flock"])) ||
				($GLOBALS["x_flock"] <> $GLOBALS["o_flock"]);
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
	if ($lvl <= 1) $GLOBALS["o_flock"] = "";

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
		$GLOBALS['x_flock'] = "";
	} else {
		$GLOBALS['x_flock'] = $rsgrp->fields('flock');
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
		$GLOBALS['x_SrNo'] = $rs->fields('SrNo');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_mortality'] = $rs->fields('mortality');
		$GLOBALS['x_cull'] = $rs->fields('cull');
		$GLOBALS['x_feedtype'] = $rs->fields('feedtype');
		$GLOBALS['x_feedconsumed'] = $rs->fields('feedconsumed');
		$GLOBALS['x_average_weight'] = $rs->fields('average_weight');
		$GLOBALS['x_medicine_name'] = $rs->fields('medicine_name');
		$GLOBALS['x_medicine_quantity'] = $rs->fields('medicine_quantity');
		$GLOBALS['x_vaccine_name'] = $rs->fields('vaccine_name');
		$GLOBALS['x_vaccine_quantity'] = $rs->fields('vaccine_quantity');
		$GLOBALS['x_entrydate'] = $rs->fields('entrydate');
		$GLOBALS['x_birds'] = $rs->fields('birds');
		$GLOBALS['x_cullflag'] = $rs->fields('cullflag');
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$GLOBALS['x_entrytype'] = $rs->fields('entrytype');
		$GLOBALS['x_phoneno'] = $rs->fields('phoneno');
		$val[1] = $GLOBALS['x_age'];
		$val[2] = $GLOBALS['x_mortality'];
		$val[3] = $GLOBALS['x_cull'];
		$val[4] = $GLOBALS['x_feedtype'];
		$val[5] = $GLOBALS['x_feedconsumed'];
		$val[6] = $GLOBALS['x_average_weight'];
		$val[7] = $GLOBALS['x_medicine_name'];
		$val[8] = $GLOBALS['x_medicine_quantity'];
		$val[9] = $GLOBALS['x_vaccine_name'];
		$val[10] = $GLOBALS['x_vaccine_quantity'];
		$val[11] = $GLOBALS['x_entrydate'];
		$val[12] = $GLOBALS['x_birds'];
		$val[13] = $GLOBALS['x_entrytype'];
	} else {
		$GLOBALS['x_SrNo'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_mortality'] = "";
		$GLOBALS['x_cull'] = "";
		$GLOBALS['x_feedtype'] = "";
		$GLOBALS['x_feedconsumed'] = "";
		$GLOBALS['x_average_weight'] = "";
		$GLOBALS['x_medicine_name'] = "";
		$GLOBALS['x_medicine_quantity'] = "";
		$GLOBALS['x_vaccine_name'] = "";
		$GLOBALS['x_vaccine_quantity'] = "";
		$GLOBALS['x_entrydate'] = "";
		$GLOBALS['x_birds'] = "";
		$GLOBALS['x_cullflag'] = "";
		$GLOBALS['x_updated'] = "";
		$GLOBALS['x_client'] = "";
		$GLOBALS['x_entrytype'] = "";
		$GLOBALS['x_phoneno'] = "";
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
	// Build distinct values for flock

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FLOCK_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FLOCK_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_flock = $rswrk->fields[0];
		if (is_null($x_flock)) {
			$bNullValue = TRUE;
		} elseif ($x_flock == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_flock = $x_flock;
			$dg_flock = $x_flock;
			ewrpt_SetupDistinctValues($GLOBALS["val_flock"], $g_flock, $dg_flock, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_flock"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for entrydate
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_ENTRYDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_ENTRYDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_entrydate = $rswrk->fields[0];
		if (is_null($x_entrydate)) {
			$bNullValue = TRUE;
		} elseif ($x_entrydate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_entrydate = ewrpt_FormatDateTime($x_entrydate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], $x_entrydate, $t_entrydate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_entrydate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('flock');
			ClearSessionSelection('entrydate');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Flock selected values

	if (is_array(@$_SESSION["sel_Report1_flock"])) {
		LoadSelectionFromSession('flock');
	} elseif (@$_SESSION["sel_Report1_flock"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_flock"] = "";
	}

	// Get Entrydate selected values
	if (is_array(@$_SESSION["sel_Report1_entrydate"])) {
		LoadSelectionFromSession('entrydate');
	} elseif (@$_SESSION["sel_Report1_entrydate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_entrydate"] = "";
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
	$_SESSION["sel_Report1_$parm"] = "";
	$_SESSION["rf_Report1_$parm"] = "";
	$_SESSION["rt_Report1_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Report1_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Report1_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Report1_$parm"];
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

	// Field flock
	// Setup your default values for the popup filter below, e.g.
	// $seld_flock = array("val1", "val2");

	$GLOBALS["seld_flock"] = "";
	$GLOBALS["sel_flock"] =  $GLOBALS["seld_flock"];

	// Field entrydate
	// Setup your default values for the popup filter below, e.g.
	// $seld_entrydate = array("val1", "val2");

	$GLOBALS["seld_entrydate"] = "";
	$GLOBALS["sel_entrydate"] =  $GLOBALS["seld_entrydate"];
}

// Check if filter applied
function CheckFilter() {

	// Check flock popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_flock"], $GLOBALS["sel_flock"]))
		return TRUE;

	// Check entrydate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_entrydate"], $GLOBALS["sel_entrydate"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field flock
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_flock"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_flock"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Flock<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field entrydate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_entrydate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_entrydate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Entrydate<br />";
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
	if (is_array($GLOBALS["sel_flock"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_flock"], "`flock`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_flock"], $GLOBALS["gb_flock"], $GLOBALS["gi_flock"], $GLOBALS["gq_flock"]);
	}
	if (is_array($GLOBALS["sel_entrydate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_entrydate"], "`entrydate`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_entrydate"]);
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
			$_SESSION["sort_Report1_flock"] = "";
			$_SESSION["sort_Report1_age"] = "";
			$_SESSION["sort_Report1_mortality"] = "";
			$_SESSION["sort_Report1_cull"] = "";
			$_SESSION["sort_Report1_feedtype"] = "";
			$_SESSION["sort_Report1_feedconsumed"] = "";
			$_SESSION["sort_Report1_average_weight"] = "";
			$_SESSION["sort_Report1_medicine_name"] = "";
			$_SESSION["sort_Report1_medicine_quantity"] = "";
			$_SESSION["sort_Report1_vaccine_name"] = "";
			$_SESSION["sort_Report1_vaccine_quantity"] = "";
			$_SESSION["sort_Report1_entrydate"] = "";
			$_SESSION["sort_Report1_birds"] = "";
			$_SESSION["sort_Report1_entrytype"] = "";
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
