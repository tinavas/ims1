<?php
session_start();$currencyunits=$_SESSION['currency'];
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
$checkflag=0;
$checkpo=0;
// Table level constants
define("EW_REPORT_TABLE_VAR", "purchaseorderdetails", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "purchaseorderdetails_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "purchaseorderdetails_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "purchaseorderdetails_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "purchaseorderdetails_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "purchaseorderdetails_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`pp_purchaseorder`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
//$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "pp_purchaseorder.vendor,pp_purchaseorder.po,pp_purchaseorder.code,pp_purchaseorder.date";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "pp_purchaseorder.vendor,pp_purchaseorder.po,pp_purchaseorder.code,pp_purchaseorder.date asc";
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
$af_po = NULL; // Popup filter for po
$af_vendor = NULL; // Popup filter for vendor
$af_date = NULL; // Popup filter for date
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
$af_quantity = NULL; // Popup filter for quantity
$af_deliverydate = NULL; // Popup filter for deliverydate
$af_deliverylocation = NULL; // Popup filter for deliverylocation
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
$nDisplayGrps = 'ALL'; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_PO_SQL_SELECT = "SELECT DISTINCT `po` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PO_SQL_ORDERBY = "`po`";
$EW_REPORT_FIELD_VENDOR_SQL_SELECT = "SELECT DISTINCT `vendor` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_VENDOR_SQL_ORDERBY = "`vendor`";
$EW_REPORT_FIELD_DATE_SQL_SELECT = "SELECT DISTINCT `date` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DATE_SQL_ORDERBY = "`date`";
$EW_REPORT_FIELD_CODE_SQL_SELECT = "SELECT DISTINCT `code` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CODE_SQL_ORDERBY = "`code`";
$EW_REPORT_FIELD_DESCRIPTION_SQL_SELECT = "SELECT DISTINCT `description` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DESCRIPTION_SQL_ORDERBY = "`description`";
$EW_REPORT_FIELD_DELIVERYDATE_SQL_SELECT = "SELECT DISTINCT `deliverydate` FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_DELIVERYDATE_SQL_ORDERBY = "`deliverydate`";
?>
<?php

// Field variables
$x_id = NULL;
$x_poincr = NULL;
$x_m = NULL;
$x_y = NULL;
$x_pr = NULL;
$x_po = NULL;
$x_vendorid = NULL;
$x_vendor = NULL;
$x_credittermcode = NULL;
$x_credittermdescription = NULL;
$x_credittermvalue = NULL;
$x_brokerid = NULL;
$x_broker = NULL;
$x_date = NULL;
$x_category = NULL;
$x_code = NULL;
$x_description = NULL;
$x_quantity = NULL;
$x_unit = NULL;
$x_rateperunit = NULL;
$x_deliverydate = NULL;
$x_deliverylocation = NULL;
$x_receiver = NULL;
$x_initiatorid = NULL;
$x_initiator = NULL;
$x_initiatorsector = NULL;
$x_taxcode = NULL;
$x_taxvalue = NULL;
$x_taxformula = NULL;
$x_taxie = NULL;
$x_taxamount = NULL;
$x_totalwithtax = NULL;
$x_freightcode = NULL;
$x_freightvalue = NULL;
$x_freightformula = NULL;
$x_freightie = NULL;
$x_freightamount = NULL;
$x_totalwithfreight = NULL;
$x_brokeragecode = NULL;
$x_brokeragevalue = NULL;
$x_brokerageformula = NULL;
$x_brokerageie = NULL;
$x_brokerageamount = NULL;
$x_totalwithbrokerage = NULL;
$x_discountcode = NULL;
$x_discountvalue = NULL;
$x_discountformula = NULL;
$x_discountie = NULL;
$x_discountamount = NULL;
$x_totalwithdiscount = NULL;
$x_basic = NULL;
$x_finalcost = NULL;
$x_pocost = NULL;
$x_tandccode = NULL;
$x_tandc = NULL;
$x_acceptedquantity = NULL;
$x_receivedquantity = NULL;
$x_flag = NULL;
$x_geflag = NULL;
$x_adate = NULL;
$x_aempid = NULL;
$x_aempname = NULL;
$x_asector = NULL;
$x_updated = NULL;
$x_client = NULL;

// Detail variables
$o_po = NULL; $t_po = NULL; $ft_po = 200; $rf_po = NULL; $rt_po = NULL;
$o_vendor = NULL; $t_vendor = NULL; $ft_vendor = 200; $rf_vendor = NULL; $rt_vendor = NULL;
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_deliverydate = NULL; $t_deliverydate = NULL; $ft_deliverydate = 133; $rf_deliverydate = NULL; $rt_deliverydate = NULL;
$o_deliverylocation = NULL; $t_deliverylocation = NULL; $ft_deliverylocation = 200; $rf_deliverylocation = NULL; $rt_deliverylocation = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 9;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_po = "";
$seld_po = "";
$val_po = "";
$sel_vendor = "";
$seld_vendor = "";
$val_vendor = "";
$sel_date = "";
$seld_date = "";
$val_date = "";
$sel_code = "";
$seld_code = "";
$val_code = "";
$sel_description = "";
$seld_description = "";
$val_description = "";
$sel_deliverydate = "";
$seld_deliverydate = "";
$val_deliverydate = "";

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
<?php $jsdata = ewrpt_GetJsData($val_po, $sel_po, $ft_po) ?>
ewrpt_CreatePopup("purchaseorderdetails_po", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_vendor, $sel_vendor, $ft_vendor) ?>
ewrpt_CreatePopup("purchaseorderdetails_vendor", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_date, $sel_date, $ft_date) ?>
ewrpt_CreatePopup("purchaseorderdetails_date", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_code, $sel_code, $ft_code) ?>
ewrpt_CreatePopup("purchaseorderdetails_code", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_description, $sel_description, $ft_description) ?>
ewrpt_CreatePopup("purchaseorderdetails_description", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_deliverydate, $sel_deliverydate, $ft_deliverydate) ?>
ewrpt_CreatePopup("purchaseorderdetails_deliverydate", [<?php echo $jsdata ?>]);
</script>
<div id="purchaseorderdetails_po_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchaseorderdetails_vendor_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchaseorderdetails_date_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchaseorderdetails_code_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchaseorderdetails_description_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="purchaseorderdetails_deliverydate_Popup" class="ewPopup">
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
<center>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Purchase Order Details</font></strong></td>
</tr>
</table>
<br/>
<div><h6>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PO Date : Purchase Order Date<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TD Date : Tentative Delivery Date<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GR Date : Goods Receipt Date</h6></div>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="purchaseorderdetailssmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchaseorderdetailssmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="purchaseorderdetailssmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchaseorderdetailssmry.php?cmd=reset">Reset All Filters</a>
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
<form action="purchaseorderdetailssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="purchaseorderdetailssmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="purchaseorderdetailssmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="purchaseorderdetailssmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="purchaseorderdetailssmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<td align="center" valign="bottom" class="ewTableHeader">
		Supplier
		</td>
<?php } else { ?>
		<td align="center" class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Supplier</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_vendor', false, '<?php echo $rf_vendor; ?>', '<?php echo $rt_vendor; ?>');return false;" name="x_vendor<?php echo $cnt[0][0]; ?>" id="x_vendor<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Purchase Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchase Order</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_po', false, '<?php echo $rf_po; ?>', '<?php echo $rt_po; ?>');return false;" name="x_po<?php echo $cnt[0][0]; ?>" id="x_po<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_code', false, '<?php echo $rf_code; ?>', '<?php echo $rt_code; ?>');return false;" name="x_code<?php echo $cnt[0][0]; ?>" id="x_code<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_description', false, '<?php echo $rf_description; ?>', '<?php echo $rt_description; ?>');return false;" name="x_description<?php echo $cnt[0][0]; ?>" id="x_description<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
		<td align="center" valign="bottom" class="ewTableHeader" title="Purchase Order Date">
		PO Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" title="Purchase Order Date">PO Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_date', false, '<?php echo $rf_date; ?>', '<?php echo $rt_date; ?>');return false;" name="x_date<?php echo $cnt[0][0]; ?>" id="x_date<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td align="center" title="Tentative Delivery Date" valign="bottom" class="ewTableHeader">
		TD Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" title="Tentative Delivery Date">TD Date</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'purchaseorderdetails_deliverydate', false, '<?php echo $rf_deliverydate; ?>', '<?php echo $rt_deliverydate; ?>');return false;" name="x_deliverydate<?php echo $cnt[0][0]; ?>" id="x_deliverydate<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td align="center" title="Goods Receipt Date" valign="bottom" class="ewTableHeader">
		GR Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" title="Goods Receipt Date">GR Date</td>
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
		
		<td <?php echo $sItemRowClass; ?>>
<?php
  if($checkflag == 0)
  {
 echo ewrpt_ViewValue($x_vendor);
 $previous_vendor = $x_vendor;
 $checkflag = 1;
 }
 else if($x_vendor == $previous_vendor)
  echo "&nbsp;";
  else
  {
   echo ewrpt_ViewValue($x_vendor) ;
    $previous_vendor = $x_vendor;
  }
 
 ?>

</td>
      <td width="90px" <?php echo $sItemRowClass; ?>>
<?php
if($checkpo == 0)
  {
 echo ewrpt_ViewValue($x_po) ;
 $previous_po = $x_po;
 $checkpo = 1;
 }
 else if($x_po == $previous_po)
  echo "&nbsp;";
  else
  {
   echo ewrpt_ViewValue($x_po) ;
    $previous_po = $x_po;
  }
 

 ?>
</td>
      <td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_code) ?>
</td>
		<td align="left" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td align="right"<?php echo $sItemRowClass; ?> >
<?php echo ewrpt_ViewValue($x_quantity) ?>
</td>
	<td align="right"<?php echo $sItemRowClass; ?> >
<?php echo $x_rateperunit; ?>
</td>
		<td width="80px" align="center" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)) ?>
</td>
		
		<td width="80px" align="center" <?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_deliverydate,7)) ?>
</td>
		<td align="right" <?php echo $sItemRowClass; ?>>
<?php 
     include "config.php";
	 $query="select date,rateperunit from pp_goodsreceipt where po='$x_po'";
	 $result=mysql_query($query,$conn1);
	 $result=mysql_fetch_assoc($result);
	 $receiptdate=$result['date'];
	 if($receiptdate)
	 echo date("d-m-Y",strtotime($receiptdate));
	 else
	 echo "Yet To Be Received";
	 ?>
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
	<!-- tr><td colspan="8"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="8">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
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
		$GLOBALS['x_poincr'] = $rs->fields('poincr');
		$GLOBALS['x_m'] = $rs->fields('m');
		$GLOBALS['x_y'] = $rs->fields('y');
		$GLOBALS['x_pr'] = $rs->fields('pr');
		$GLOBALS['x_po'] = $rs->fields('po');
		$GLOBALS['x_vendorid'] = $rs->fields('vendorid');
		$GLOBALS['x_vendor'] = $rs->fields('vendor');
		$GLOBALS['x_credittermcode'] = $rs->fields('credittermcode');
		$GLOBALS['x_credittermdescription'] = $rs->fields('credittermdescription');
		$GLOBALS['x_credittermvalue'] = $rs->fields('credittermvalue');
		$GLOBALS['x_brokerid'] = $rs->fields('brokerid');
		$GLOBALS['x_broker'] = $rs->fields('broker');
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_category'] = $rs->fields('category');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_unit'] = $rs->fields('unit');
		$GLOBALS['x_rateperunit'] = $rs->fields('rateperunit');
		$GLOBALS['x_deliverydate'] = $rs->fields('deliverydate');
		$GLOBALS['x_deliverylocation'] = $rs->fields('deliverylocation');
		$GLOBALS['x_receiver'] = $rs->fields('receiver');
		$GLOBALS['x_initiatorid'] = $rs->fields('initiatorid');
		$GLOBALS['x_initiator'] = $rs->fields('initiator');
		$GLOBALS['x_initiatorsector'] = $rs->fields('initiatorsector');
		$GLOBALS['x_taxcode'] = $rs->fields('taxcode');
		$GLOBALS['x_taxvalue'] = $rs->fields('taxvalue');
		$GLOBALS['x_taxformula'] = $rs->fields('taxformula');
		$GLOBALS['x_taxie'] = $rs->fields('taxie');
		$GLOBALS['x_taxamount'] = $rs->fields('taxamount');
		$GLOBALS['x_totalwithtax'] = $rs->fields('totalwithtax');
		$GLOBALS['x_freightcode'] = $rs->fields('freightcode');
		$GLOBALS['x_freightvalue'] = $rs->fields('freightvalue');
		$GLOBALS['x_freightformula'] = $rs->fields('freightformula');
		$GLOBALS['x_freightie'] = $rs->fields('freightie');
		$GLOBALS['x_freightamount'] = $rs->fields('freightamount');
		$GLOBALS['x_totalwithfreight'] = $rs->fields('totalwithfreight');
		$GLOBALS['x_brokeragecode'] = $rs->fields('brokeragecode');
		$GLOBALS['x_brokeragevalue'] = $rs->fields('brokeragevalue');
		$GLOBALS['x_brokerageformula'] = $rs->fields('brokerageformula');
		$GLOBALS['x_brokerageie'] = $rs->fields('brokerageie');
		$GLOBALS['x_brokerageamount'] = $rs->fields('brokerageamount');
		$GLOBALS['x_totalwithbrokerage'] = $rs->fields('totalwithbrokerage');
		$GLOBALS['x_discountcode'] = $rs->fields('discountcode');
		$GLOBALS['x_discountvalue'] = $rs->fields('discountvalue');
		$GLOBALS['x_discountformula'] = $rs->fields('discountformula');
		$GLOBALS['x_discountie'] = $rs->fields('discountie');
		$GLOBALS['x_discountamount'] = $rs->fields('discountamount');
		$GLOBALS['x_totalwithdiscount'] = $rs->fields('totalwithdiscount');
		$GLOBALS['x_basic'] = $rs->fields('basic');
		$GLOBALS['x_finalcost'] = $rs->fields('finalcost');
		$GLOBALS['x_pocost'] = $rs->fields('pocost');
		$GLOBALS['x_tandccode'] = $rs->fields('tandccode');
		$GLOBALS['x_tandc'] = $rs->fields('tandc');
		$GLOBALS['x_acceptedquantity'] = $rs->fields('acceptedquantity');
		$GLOBALS['x_receivedquantity'] = $rs->fields('receivedquantity');
		$GLOBALS['x_flag'] = $rs->fields('flag');
		$GLOBALS['x_geflag'] = $rs->fields('geflag');
		$GLOBALS['x_adate'] = $rs->fields('adate');
		$GLOBALS['x_aempid'] = $rs->fields('aempid');
		$GLOBALS['x_aempname'] = $rs->fields('aempname');
		$GLOBALS['x_asector'] = $rs->fields('asector');
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_po'];
		$val[2] = $GLOBALS['x_vendor'];
		$val[3] = $GLOBALS['x_date'];
		$val[4] = $GLOBALS['x_code'];
		$val[5] = $GLOBALS['x_description'];
		$val[6] = $GLOBALS['x_quantity'];
		$val[7] = $GLOBALS['x_deliverydate'];
		$val[8] = $GLOBALS['x_deliverylocation'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_poincr'] = "";
		$GLOBALS['x_m'] = "";
		$GLOBALS['x_y'] = "";
		$GLOBALS['x_pr'] = "";
		$GLOBALS['x_po'] = "";
		$GLOBALS['x_vendorid'] = "";
		$GLOBALS['x_vendor'] = "";
		$GLOBALS['x_credittermcode'] = "";
		$GLOBALS['x_credittermdescription'] = "";
		$GLOBALS['x_credittermvalue'] = "";
		$GLOBALS['x_brokerid'] = "";
		$GLOBALS['x_broker'] = "";
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_category'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_unit'] = "";
		$GLOBALS['x_rateperunit'] = "";
		$GLOBALS['x_deliverydate'] = "";
		$GLOBALS['x_deliverylocation'] = "";
		$GLOBALS['x_receiver'] = "";
		$GLOBALS['x_initiatorid'] = "";
		$GLOBALS['x_initiator'] = "";
		$GLOBALS['x_initiatorsector'] = "";
		$GLOBALS['x_taxcode'] = "";
		$GLOBALS['x_taxvalue'] = "";
		$GLOBALS['x_taxformula'] = "";
		$GLOBALS['x_taxie'] = "";
		$GLOBALS['x_taxamount'] = "";
		$GLOBALS['x_totalwithtax'] = "";
		$GLOBALS['x_freightcode'] = "";
		$GLOBALS['x_freightvalue'] = "";
		$GLOBALS['x_freightformula'] = "";
		$GLOBALS['x_freightie'] = "";
		$GLOBALS['x_freightamount'] = "";
		$GLOBALS['x_totalwithfreight'] = "";
		$GLOBALS['x_brokeragecode'] = "";
		$GLOBALS['x_brokeragevalue'] = "";
		$GLOBALS['x_brokerageformula'] = "";
		$GLOBALS['x_brokerageie'] = "";
		$GLOBALS['x_brokerageamount'] = "";
		$GLOBALS['x_totalwithbrokerage'] = "";
		$GLOBALS['x_discountcode'] = "";
		$GLOBALS['x_discountvalue'] = "";
		$GLOBALS['x_discountformula'] = "";
		$GLOBALS['x_discountie'] = "";
		$GLOBALS['x_discountamount'] = "";
		$GLOBALS['x_totalwithdiscount'] = "";
		$GLOBALS['x_basic'] = "";
		$GLOBALS['x_finalcost'] = "";
		$GLOBALS['x_pocost'] = "";
		$GLOBALS['x_tandccode'] = "";
		$GLOBALS['x_tandc'] = "";
		$GLOBALS['x_acceptedquantity'] = "";
		$GLOBALS['x_receivedquantity'] = "";
		$GLOBALS['x_flag'] = "";
		$GLOBALS['x_geflag'] = "";
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
	// Build distinct values for po

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_PO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_PO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_po = $rswrk->fields[0];
		if (is_null($x_po)) {
			$bNullValue = TRUE;
		} elseif ($x_po == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_po = $x_po;
			ewrpt_SetupDistinctValues($GLOBALS["val_po"], $x_po, $t_po, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_po"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_po"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for vendor
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_VENDOR_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_vendor = $rswrk->fields[0];
		if (is_null($x_vendor)) {
			$bNullValue = TRUE;
		} elseif ($x_vendor == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_vendor = $x_vendor;
			ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], $x_vendor, $t_vendor, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_vendor"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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

	// Build distinct values for description
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DESCRIPTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DESCRIPTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_description = $rswrk->fields[0];
		if (is_null($x_description)) {
			$bNullValue = TRUE;
		} elseif ($x_description == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_description = $x_description;
			ewrpt_SetupDistinctValues($GLOBALS["val_description"], $x_description, $t_description, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_description"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_description"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for deliverydate
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DELIVERYDATE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DELIVERYDATE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_deliverydate = $rswrk->fields[0];
		if (is_null($x_deliverydate)) {
			$bNullValue = TRUE;
		} elseif ($x_deliverydate == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_deliverydate = ewrpt_FormatDateTime($x_deliverydate,7);
			ewrpt_SetupDistinctValues($GLOBALS["val_deliverydate"], $x_deliverydate, $t_deliverydate, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_deliverydate"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_deliverydate"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('po');
			ClearSessionSelection('vendor');
			ClearSessionSelection('date');
			ClearSessionSelection('code');
			ClearSessionSelection('description');
			ClearSessionSelection('deliverydate');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Po selected values

	if (is_array(@$_SESSION["sel_purchaseorderdetails_po"])) {
		LoadSelectionFromSession('po');
	} elseif (@$_SESSION["sel_purchaseorderdetails_po"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_po"] = "";
	}

	// Get Vendor selected values
	if (is_array(@$_SESSION["sel_purchaseorderdetails_vendor"])) {
		LoadSelectionFromSession('vendor');
	} elseif (@$_SESSION["sel_purchaseorderdetails_vendor"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_vendor"] = "";
	}

	// Get Date selected values
	if (is_array(@$_SESSION["sel_purchaseorderdetails_date"])) {
		LoadSelectionFromSession('date');
	} elseif (@$_SESSION["sel_purchaseorderdetails_date"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_date"] = "";
	}

	// Get Code selected values
	if (is_array(@$_SESSION["sel_purchaseorderdetails_code"])) {
		LoadSelectionFromSession('code');
	} elseif (@$_SESSION["sel_purchaseorderdetails_code"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_code"] = "";
	}

	// Get Description selected values
	if (is_array(@$_SESSION["sel_purchaseorderdetails_description"])) {
		LoadSelectionFromSession('description');
	} elseif (@$_SESSION["sel_purchaseorderdetails_description"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_description"] = "";
	}

	// Get Deliverydate selected values
	if (is_array(@$_SESSION["sel_purchaseorderdetails_deliverydate"])) {
		LoadSelectionFromSession('deliverydate');
	} elseif (@$_SESSION["sel_purchaseorderdetails_deliverydate"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_deliverydate"] = "";
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
	$_SESSION["sel_purchaseorderdetails_$parm"] = "";
	$_SESSION["rf_purchaseorderdetails_$parm"] = "";
	$_SESSION["rt_purchaseorderdetails_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_purchaseorderdetails_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_purchaseorderdetails_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_purchaseorderdetails_$parm"];
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

	// Field po
	// Setup your default values for the popup filter below, e.g.
	// $seld_po = array("val1", "val2");

	$GLOBALS["seld_po"] = "";
	$GLOBALS["sel_po"] =  $GLOBALS["seld_po"];

	// Field vendor
	// Setup your default values for the popup filter below, e.g.
	// $seld_vendor = array("val1", "val2");

	$GLOBALS["seld_vendor"] = "";
	$GLOBALS["sel_vendor"] =  $GLOBALS["seld_vendor"];

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

	// Field description
	// Setup your default values for the popup filter below, e.g.
	// $seld_description = array("val1", "val2");

	$GLOBALS["seld_description"] = "";
	$GLOBALS["sel_description"] =  $GLOBALS["seld_description"];

	// Field deliverydate
	// Setup your default values for the popup filter below, e.g.
	// $seld_deliverydate = array("val1", "val2");

	$GLOBALS["seld_deliverydate"] = "";
	$GLOBALS["sel_deliverydate"] =  $GLOBALS["seld_deliverydate"];
}

// Check if filter applied
function CheckFilter() {

	// Check po popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_po"], $GLOBALS["sel_po"]))
		return TRUE;

	// Check vendor popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_vendor"], $GLOBALS["sel_vendor"]))
		return TRUE;

	// Check date popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_date"], $GLOBALS["sel_date"]))
		return TRUE;

	// Check code popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_code"], $GLOBALS["sel_code"]))
		return TRUE;

	// Check description popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_description"], $GLOBALS["sel_description"]))
		return TRUE;

	// Check deliverydate popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_deliverydate"], $GLOBALS["sel_deliverydate"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field po
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_po"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_po"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Po<br />";
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

	// Field description
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_description"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_description"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Description<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field deliverydate
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_deliverydate"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_deliverydate"], ", ", EW_REPORT_DATATYPE_DATE);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Deliverydate<br />";
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
	if (is_array($GLOBALS["sel_po"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_po"], "`po`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_po"]);
	}
	if (is_array($GLOBALS["sel_vendor"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_vendor"], "`vendor`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_vendor"]);
	}
	if (is_array($GLOBALS["sel_date"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_date"], "`date`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_date"]);
	}
	if (is_array($GLOBALS["sel_code"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_code"], "`code`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_code"]);
	}
	if (is_array($GLOBALS["sel_description"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_description"], "`description`", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_description"]);
	}
	if (is_array($GLOBALS["sel_deliverydate"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_deliverydate"], "`deliverydate`", EW_REPORT_DATATYPE_DATE, $GLOBALS["af_deliverydate"]);
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
			$_SESSION["sort_purchaseorderdetails_po"] = "";
			$_SESSION["sort_purchaseorderdetails_vendor"] = "";
			$_SESSION["sort_purchaseorderdetails_date"] = "";
			$_SESSION["sort_purchaseorderdetails_code"] = "";
			$_SESSION["sort_purchaseorderdetails_description"] = "";
			$_SESSION["sort_purchaseorderdetails_quantity"] = "";
			$_SESSION["sort_purchaseorderdetails_deliverydate"] = "";
			$_SESSION["sort_purchaseorderdetails_deliverylocation"] = "";
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
		$_SESSION["sort_purchaseorderdetails_date"] = "DESC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
