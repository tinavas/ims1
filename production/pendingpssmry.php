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
      include "reportheader.php"; ?>
	  
	  
<?php
// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "pendinggrl", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "pendinggrl_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "pendinggrl_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "pendinggrl_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "pendinggrl_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "pendinggrl_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`oc_packslip`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "oc_packslip.cobiflag <> 1";
$EW_REPORT_TABLE_SQL_GROUPBY = "oc_packslip.ps";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = NULL; // Popup filter for date
$af_itemcode = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for desc1
$af_party = NULL; // Popup filter for vendor
$af_ps = NULL; // Popup filter for ge
$af_quantity = NULL; // Popup filter for quantity
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
$nGrpCount = "All"; // Group count
$nDisplayGrps = "All"; // Groups per page
$nGrpRange = "All";

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "`date`";
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT `code` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "`code`";
$EW_REPORT_FIELD_DESC1_SQL_SELECT = "SELECT DISTINCT `desc1` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DESC1_SQL_ORDERBY = "`desc1`";
$EW_REPORT_FIELD_VENDOR_SQL_SELECT = "SELECT DISTINCT `vendor` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_VENDOR_SQL_ORDERBY = "`vendor`";
$EW_REPORT_FIELD_GE_SQL_SELECT = "SELECT DISTINCT `ge` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_GE_SQL_ORDERBY = "`ge`";
?>
<?php

// Field variables
$x_id = NULL;
$x_psincr = NULL;
$x_m = NULL;
$x_y = NULL;
$x_date = NULL;
$x_itemcode = NULL;
$x_description = NULL;
$x_partyid = NULL;
$x_party = NULL;
$x_credittermcode = NULL;
$x_credittermdescription = NULL;
$x_credittermvalue = NULL;
$x_brokerid = NULL;
$x_broker = NULL;
$x_combinedpo = NULL;
$x_qc = NULL;
$x_ps = NULL;
$x_vehicleno = NULL;
$x_weight = NULL;
$x_flag = NULL;
$x_aflag = NULL;
$x_qcaflag = NULL;
$x_cobiflag = NULL;
$x_taxcode = NULL;
$x_taxvalue = NULL;
$x_taxie = NULL;
$x_taxamount = NULL;
$x_taxformula = NULL;
$x_freightcode = NULL;
$x_freightvalue = NULL;
$x_freightie = NULL;
$x_freightamount = NULL;
$x_freightformula = NULL;
$x_brokeragecode = NULL;
$x_brokeragevalue = NULL;
$x_brokerageie = NULL;
$x_brokerageamount = NULL;
$x_brokerageformula = NULL;
$x_discountcode = NULL;
$x_discountvalue = NULL;
$x_discountie = NULL;
$x_discountamount = NULL;
$x_discountformula = NULL;
$x_quantity = NULL;
$x_receivedquantity = NULL;
$x_acceptedquantity = NULL;
$x_rateperunit = NULL;
$x_unit = NULL;
$x_basic = NULL;
$x_finalcost = NULL;
$x_pocost = NULL;
$x_tandccode = NULL;
$x_tandc = NULL;
$x_empid = NULL;
$x_empname = NULL;
$x_sector = NULL;
$x_adate = NULL;
$x_aempid = NULL;
$x_aempname = NULL;
$x_asector = NULL;
$x_updated = NULL;
$x_client = NULL;

// Detail variables
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_desc1 = NULL; $t_desc1 = NULL; $ft_desc1 = 200; $rf_desc1 = NULL; $rt_desc1 = NULL;
$o_vendor = NULL; $t_vendor = NULL; $ft_vendor = 200; $rf_vendor = NULL; $rt_vendor = NULL;
$o_ge = NULL; $t_ge = NULL; $ft_ge = 200; $rf_ge = NULL; $rt_ge = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 7;
$nGrps = 1;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_code = "";
$seld_code = "";
$val_code = "";
$sel_desc1 = "";
$seld_desc1 = "";
$val_desc1 = "";
$sel_vendor = "";
$seld_vendor = "";
$val_vendor = "";
$sel_ge = "";
$seld_ge = "";
$val_ge = "";

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

// Get total count
$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sFilter, @$sSort);
$nTotalGrps = GetCnt($sSql);
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

// Get current page records
$rs = GetRs($sSql, $nStartGrp, $nDisplayGrps);
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
ewrpt_CreatePopup("pendinggrl_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code) ?>
ewrpt_CreatePopup("pendinggrl_code", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_desc1, $sel_desc1, $ft_desc1) ?>
ewrpt_CreatePopup("pendinggrl_desc1", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_vendor, $sel_vendor, $ft_vendor) ?>
ewrpt_CreatePopup("pendinggrl_vendor", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_ge, $sel_ge, $ft_ge) ?>
ewrpt_CreatePopup("pendinggrl_ge", [<?php echo $jsdata ?>]);
</script>
<div id="pendinggrl_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="pendinggrl_code_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="pendinggrl_desc1_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="pendinggrl_vendor_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="pendinggrl_ge_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Pending Pack Slip</font></strong></td>
</tr>
</table>
<?php if (@$sExport == "") { ?>
<center>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<center>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="pendingpssmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="pendingpssmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="pendingpssmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="pendingpssmry.php?cmd=reset">Reset All Filters</a>
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
<form action="pendingpssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="pendingpssmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="pendingpssmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="pendingpssmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="pendingpssmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
	GetRow(1);
	$nGrpCount = 1;
}
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Pack Slip Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Pack Slip Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'pendinggrl_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Pack Slip No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Pack Slip No</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'pendinggrl_ge', false, '<?php echo $rf_ge; ?>', '<?php echo $rt_ge; ?>');return false;" name="x_ps<?php echo $cnt[0][0]; ?>" id="x_ps<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td align="center" valign="bottom" class="ewTableHeader">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Customer</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'pendinggrl_vendor', false, '<?php echo $rf_vendor; ?>', '<?php echo $rt_vendor; ?>');return false;" name="x_party<?php echo $cnt[0][0]; ?>" id="x_party<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Code</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'pendinggrl_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_itemcode<?php echo $cnt[0][0]; ?>" id="x_itemcode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Description</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'pendinggrl_desc1', false, '<?php echo $rf_desc1; ?>', '<?php echo $rt_desc1; ?>');return false;" name="x_description<?php echo $cnt[0][0]; ?>" id="x_description<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
	<tr>
		<td align="center" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(date($datephp,strtotime($x_date))) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_ps) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_party) ?>
</td>
	<?php
		$item = $desc = $qty = "";
		if($_SESSION['db'] == "alkhumasiyabrd")
		$query = "SELECT SUM(quantity) AS quantity,itemcode,description FROM oc_packslip WHERE ps = '$x_ps' GROUP BY itemcode,description ORDER BY id";
		
		else
		$query = "SELECT itemcode,description,quantity FROM oc_packslip WHERE ps = '$x_ps' ORDER BY id";
		$result = mysql_query($query,$conn1) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result))
		{
			$item .= $rows['itemcode'] . " / ";
			$desc .= $rows['description'] ." / ";
			$qty .= $rows['quantity'] . " / ";
		}
		$item = substr($item,0,-3);
		$desc = substr($desc,0,-3);
		$qty = substr($qty,0,-3);
	?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($item) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($desc) ?>
</td>
		<td align="right" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($qty) ?>
</td>
<td align="left" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_unit) ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
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
	<!-- tr><td colspan="6"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="7">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
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

// Get count
function GetCnt($sql) {
	global $conn;

	//echo "sql (GetCnt): " . $sql . "<br>";
	$rscnt = $conn->Execute($sql);
	$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
	return $cnt;
}

// Get rs
function GetRs($sql, $start, $grps) {
	global $conn;
	$wrksql = $sql . " LIMIT " . ($start-1) . ", " . ($grps);

	//echo "wrksql: (rsgrp)" . $sSql . "<br>";
	$rswrk = $conn->Execute($wrksql);
	return $rswrk;
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
		$GLOBALS['x_psincr'] = $rs->fields('geincr');
		$GLOBALS['x_m'] = $rs->fields('m');
		$GLOBALS['x_y'] = $rs->fields('y');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_itemcode'] = $rs->fields('itemcode');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_partyid'] = $rs->fields('vendorid');
		$GLOBALS['x_party'] = $rs->fields('party');
		$GLOBALS['x_credittermcode'] = $rs->fields('credittermcode');
		$GLOBALS['x_credittermdescription'] = $rs->fields('credittermdescription');
		$GLOBALS['x_credittermvalue'] = $rs->fields('credittermvalue');
		$GLOBALS['x_brokerid'] = $rs->fields('brokerid');
		$GLOBALS['x_broker'] = $rs->fields('broker');
		$GLOBALS['x_combinedpo'] = $rs->fields('combinedpo');
		$GLOBALS['x_qc'] = $rs->fields('qc');
		$GLOBALS['x_ps'] = $rs->fields('ps');
		$GLOBALS['x_vehicleno'] = $rs->fields('vehicleno');
		$GLOBALS['x_weight'] = $rs->fields('weight');
		$GLOBALS['x_flag'] = $rs->fields('flag');
		$GLOBALS['x_aflag'] = $rs->fields('aflag');
		$GLOBALS['x_qcaflag'] = $rs->fields('qcaflag');
		$GLOBALS['x_cobiflag'] = $rs->fields('cobiflag');
		$GLOBALS['x_taxcode'] = $rs->fields('taxcode');
		$GLOBALS['x_taxvalue'] = $rs->fields('taxvalue');
		$GLOBALS['x_taxie'] = $rs->fields('taxie');
		$GLOBALS['x_taxamount'] = $rs->fields('taxamount');
		$GLOBALS['x_taxformula'] = $rs->fields('taxformula');
		$GLOBALS['x_freightcode'] = $rs->fields('freightcode');
		$GLOBALS['x_freightvalue'] = $rs->fields('freightvalue');
		$GLOBALS['x_freightie'] = $rs->fields('freightie');
		$GLOBALS['x_freightamount'] = $rs->fields('freightamount');
		$GLOBALS['x_freightformula'] = $rs->fields('freightformula');
		$GLOBALS['x_brokeragecode'] = $rs->fields('brokeragecode');
		$GLOBALS['x_brokeragevalue'] = $rs->fields('brokeragevalue');
		$GLOBALS['x_brokerageie'] = $rs->fields('brokerageie');
		$GLOBALS['x_brokerageamount'] = $rs->fields('brokerageamount');
		$GLOBALS['x_brokerageformula'] = $rs->fields('brokerageformula');
		$GLOBALS['x_discountcode'] = $rs->fields('discountcode');
		$GLOBALS['x_discountvalue'] = $rs->fields('discountvalue');
		$GLOBALS['x_discountie'] = $rs->fields('discountie');
		$GLOBALS['x_discountamount'] = $rs->fields('discountamount');
		$GLOBALS['x_discountformula'] = $rs->fields('discountformula');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_receivedquantity'] = $rs->fields('receivedquantity');
		$GLOBALS['x_acceptedquantity'] = $rs->fields('acceptedquantity');
		$GLOBALS['x_rateperunit'] = $rs->fields('rateperunit');
		$GLOBALS['x_unit'] = $rs->fields('units');
		$GLOBALS['x_basic'] = $rs->fields('basic');
		$GLOBALS['x_finalcost'] = $rs->fields('finalcost');
		$GLOBALS['x_pocost'] = $rs->fields('pocost');
		$GLOBALS['x_tandccode'] = $rs->fields('tandccode');
		$GLOBALS['x_tandc'] = $rs->fields('tandc');
		$GLOBALS['x_empid'] = $rs->fields('empid');
		$GLOBALS['x_empname'] = $rs->fields('empname');
		$GLOBALS['x_sector'] = $rs->fields('sector');
		$GLOBALS['x_adate'] = $rs->fields('adate');
		$GLOBALS['x_aempid'] = $rs->fields('aempid');
		$GLOBALS['x_aempname'] = $rs->fields('aempname');
		$GLOBALS['x_asector'] = $rs->fields('asector');
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_date'];
		$val[2] = $GLOBALS['x_itemcode'];
		$val[3] = $GLOBALS['x_description'];
		$val[4] = $GLOBALS['x_party'];
		$val[5] = $GLOBALS['x_ps'];
		$val[6] = $GLOBALS['x_quantity'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_psincr'] = "";
		$GLOBALS['x_m'] = "";
		$GLOBALS['x_y'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_itemcode'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_partyid'] = "";
		$GLOBALS['x_party'] = "";
		$GLOBALS['x_credittermcode'] = "";
		$GLOBALS['x_credittermdescription'] = "";
		$GLOBALS['x_credittermvalue'] = "";
		$GLOBALS['x_brokerid'] = "";
		$GLOBALS['x_broker'] = "";
		$GLOBALS['x_combinedpo'] = "";
		$GLOBALS['x_qc'] = "";
		$GLOBALS['x_ps'] = "";
		$GLOBALS['x_vehicleno'] = "";
		$GLOBALS['x_weight'] = "";
		$GLOBALS['x_flag'] = "";
		$GLOBALS['x_aflag'] = "";
		$GLOBALS['x_qcaflag'] = "";
		$GLOBALS['x_cobiflag'] = "";
		$GLOBALS['x_taxcode'] = "";
		$GLOBALS['x_taxvalue'] = "";
		$GLOBALS['x_taxie'] = "";
		$GLOBALS['x_taxamount'] = "";
		$GLOBALS['x_taxformula'] = "";
		$GLOBALS['x_freightcode'] = "";
		$GLOBALS['x_freightvalue'] = "";
		$GLOBALS['x_freightie'] = "";
		$GLOBALS['x_freightamount'] = "";
		$GLOBALS['x_freightformula'] = "";
		$GLOBALS['x_brokeragecode'] = "";
		$GLOBALS['x_brokeragevalue'] = "";
		$GLOBALS['x_brokerageie'] = "";
		$GLOBALS['x_brokerageamount'] = "";
		$GLOBALS['x_brokerageformula'] = "";
		$GLOBALS['x_discountcode'] = "";
		$GLOBALS['x_discountvalue'] = "";
		$GLOBALS['x_discountie'] = "";
		$GLOBALS['x_discountamount'] = "";
		$GLOBALS['x_discountformula'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_receivedquantity'] = "";
		$GLOBALS['x_acceptedquantity'] = "";
		$GLOBALS['x_rateperunit'] = "";
		$GLOBALS['x_unit'] = "";
		$GLOBALS['x_basic'] = "";
		$GLOBALS['x_finalcost'] = "";
		$GLOBALS['x_pocost'] = "";
		$GLOBALS['x_tandccode'] = "";
		$GLOBALS['x_tandc'] = "";
		$GLOBALS['x_empid'] = "";
		$GLOBALS['x_empname'] = "";
		$GLOBALS['x_sector'] = "";
		$GLOBALS['x_adate'] = "";
		$GLOBALS['x_aempid'] = "";
		$GLOBALS['x_aempname'] = "";
		$GLOBALS['x_asector'] = "";
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
			$t_date = ewrpt_FormatDateTime($x_date,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_date"], $x_date, $t_date, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_date"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for code
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_CODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_CODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_itemcode = $rswrk->fields[0];
		if (is_null($x_itemcode)) {
			$bNullValue = TRUE;
		} elseif ($x_itemcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_code = $x_itemcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_code"], $x_itemcode, $t_code, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_code"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_code"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for desc1
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DESC1_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DESC1_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_description = $rswrk->fields[0];
		if (is_null($x_description)) {
			$bNullValue = TRUE;
		} elseif ($x_description == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_desc1 = $x_description;
			ewrpt_SetupDistinctValues($GLOBALS["val_desc1"], $x_description, $t_desc1, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_desc1"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_desc1"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for vendor
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_party = $rswrk->fields[0];
		if (is_null($x_party)) {
			$bNullValue = TRUE;
		} elseif ($x_party == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_vendor = $x_party;
			ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], $x_party, $t_vendor, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for ge
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_GE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_GE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_ps = $rswrk->fields[0];
		if (is_null($x_ps)) {
			$bNullValue = TRUE;
		} elseif ($x_ps == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_ge = $x_ps;
			ewrpt_SetupDistinctValues($GLOBALS["val_ge"], $x_ps, $t_ge, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_ge"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_ge"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('code');
			ClearSessionSelection('desc1');
			ClearSessionSelection('vendor');
			ClearSessionSelection('ge');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Date selected values

	if (is_array(@$_SESSION["sel_pendinggrl_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_pendinggrl_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Code selected values
	if (is_array(@$_SESSION["sel_pendinggrl_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_pendinggrl_code"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_code"] = "";
	}

	// Get Desc 1 selected values
	if (is_array(@$_SESSION["sel_pendinggrl_desc1"])) {
		LoadSelectionFromSession('desc1');
	} elseif (@$_SESSION["sel_pendinggrl_desc1"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_desc1"] = "";
	}

	// Get Vendor selected values
	if (is_array(@$_SESSION["sel_pendinggrl_vendor"])) {
		LoadSelectionFromSession('vendor');
	} elseif (@$_SESSION["sel_pendinggrl_vendor"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_vendor"] = "";
	}

	// Get Ge selected values
	if (is_array(@$_SESSION["sel_pendinggrl_ge"])) {
		LoadSelectionFromSession('ge');
	} elseif (@$_SESSION["sel_pendinggrl_ge"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_ge"] = "";
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
				$nDisplayGrps = 10; // Non-numeric, load default
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
			$nDisplayGrps = 10; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_pendinggrl_$parm"] = "";
	$_SESSION["rf_pendinggrl_$parm"] = "";
	$_SESSION["rt_pendinggrl_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_pendinggrl_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_pendinggrl_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_pendinggrl_$parm"];
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

	// Field code
	// Setup your default values for the popup filter below, e.g.
	// $seld_code = array("val1", "val2");

	$GLOBALS["seld_code"] = "";
	$GLOBALS["sel_code"] =  $GLOBALS["seld_code"];

	// Field desc1
	// Setup your default values for the popup filter below, e.g.
	// $seld_desc1 = array("val1", "val2");

	$GLOBALS["seld_desc1"] = "";
	$GLOBALS["sel_desc1"] =  $GLOBALS["seld_desc1"];

	// Field vendor
	// Setup your default values for the popup filter below, e.g.
	// $seld_vendor = array("val1", "val2");

	$GLOBALS["seld_vendor"] = "";
	$GLOBALS["sel_vendor"] =  $GLOBALS["seld_vendor"];

	// Field ge
	// Setup your default values for the popup filter below, e.g.
	// $seld_ge = array("val1", "val2");

	$GLOBALS["seld_ge"] = "";
	$GLOBALS["sel_ge"] =  $GLOBALS["seld_ge"];
}

// Check if filter applied
function CheckFilter() {

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check code popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_code"], $GLOBALS["sel_code"]))
		return TRUE;

	// Check desc1 popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_desc1"], $GLOBALS["sel_desc1"]))
		return TRUE;

	// Check vendor popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_vendor"], $GLOBALS["sel_vendor"]))
		return TRUE;

	// Check ge popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_ge"], $GLOBALS["sel_ge"]))
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

	// Field desc1
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_desc1"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_desc1"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Desc 1<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field vendor
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_vendor"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_vendor"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Vendor<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field ge
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_ge"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_ge"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Ge<br />";
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
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "`date`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"]);
	}
	if (is_array($GLOBALS["sel_code"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_code"], "`code`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_itemcode"]);
	}
	if (is_array($GLOBALS["sel_desc1"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_desc1"], "`desc1`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_description"]);
	}
	if (is_array($GLOBALS["sel_vendor"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_vendor"], "`vendor`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_party"]);
	}
	if (is_array($GLOBALS["sel_ge"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_ge"], "`ge`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_ps"]);
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
			$_SESSION["sort_pendinggrl_date"] = "";
			$_SESSION["sort_pendinggrl_code"] = "";
			$_SESSION["sort_pendinggrl_desc1"] = "";
			$_SESSION["sort_pendinggrl_vendor"] = "";
			$_SESSION["sort_pendinggrl_ge"] = "";
			$_SESSION["sort_pendinggrl_quantity"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "`date` DESC";
		$_SESSION["sort_pendinggrl_date"] = "DESC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
