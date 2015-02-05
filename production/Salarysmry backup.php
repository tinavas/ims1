<?php 
$sExport = @$_GET["export"]; 
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
<?php } ?>
<?php
session_start();
ob_start();


$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$sino =0;
if($_GET['sector'] == "All")
$sc = "<>";
else
$sc = "=";

if($_GET['empname'] == "All")
$nc = "<>";
else
$nc = "=";

$n = $_GET['n'];
$para1 = split(",",$n);
$dpara1 = array('en','d','p');
$pa1 = array('0','0','0');
for($i=1;$i < sizeof($para1);$i++)
{
	for( $j=0; $j < sizeof($dpara1); $j++ )
	{
		if($dpara1[$j] == $para1[$i])
		{
		$pa1[$j] = '1';
		}
		
	}
}
$sino =0;
$totalsalary = 0;
$totalnetsalary = 0;
$totalpf = 0;
$totalpt = 0;
$totalmess = 0;
$totalculls = 0;
$totaladv = 0;
$totaltotalded = 0;
$totalbal = 0;

$sectornetsalary = 0;
$sectormess = 0;
$sectorculls = 0;
$sectoradv = 0;
$sectortotalded = 0;
$sectorbal = 0;
$sectorpf = 0;
$sectorpt = 0;



$days_in_month = array(31,28,31,30,31,30,31,31,30,31,30,31);

$genlink = "&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];

$month = $_GET['month'];
$cyear = $_GET['year'];
$fromdate =  "01" . "." . $month . "." . $_GET['year'];
$todate =  $days_in_month[$month-1] . "." . $month . "." . $_GET['year'];
$fd = date("Y-m-j",strtotime($fromdate));
$td = date("Y-m-j",strtotime($todate));
//$noofwrkdays = $days_in_month[$month-1];
//$dateq =  $cyear ."-". $month . "-" . $days_in_month[$month-1];

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
<?php include "reportheader.php"; ?>
<center>
<table align="center" border="0">
<tr>

<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Report for <?php echo $montharr[$month-1]; ?>, <?php echo $cyear; ?></font></strong></td>
</tr>

</table>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "SalaryNewReportsmry", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "SalaryNewReportsmry_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "SalaryNewReportsmry_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "SalaryNewReportsmry_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "SalaryNewReportsmry_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "SalaryNewReportsmry_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee Inner Join hr_payment On hr_payment.eid = hr_employee.employeeid Inner Join hr_salaryparameters On hr_salaryparameters.eid = hr_payment.eid";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_employee.name, hr_employee.sector, hr_employee.designation, hr_employee.salary, hr_salaryparameters.bfix, hr_salaryparameters.hrafix, hr_salaryparameters.mafix, hr_salaryparameters.ccafix, hr_salaryparameters.tafix, hr_salaryparameters.pffix, hr_salaryparameters.ptaxfix, hr_salaryparameters.finalsal, hr_payment.eid, hr_salaryparameters.id, hr_payment.paid, hr_payment.deduction, hr_payment.totalsal, hr_payment.paymode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $sc '$_GET[sector]' and hr_employee.name $nc '$_GET[empname]' and hr_payment.month1='$month' and hr_payment.year1 = '$cyear'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hr_employee.sector,hr_employee.designation,hr_employee.name ";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hr_employee.salary) AS SUM_salary, SUM(hr_salaryparameters.bfix) AS SUM_bfix, SUM(hr_salaryparameters.hrafix) AS SUM_hrafix, SUM(hr_salaryparameters.mafix) AS SUM_mafix, SUM(hr_salaryparameters.ccafix) AS SUM_ccafix, SUM(hr_salaryparameters.tafix) AS SUM_tafix, SUM(hr_salaryparameters.pffix) AS SUM_pffix, SUM(hr_salaryparameters.ptaxfix) AS SUM_ptaxfix, SUM(hr_payment.paid) AS SUM_paid, SUM(hr_payment.deduction) AS SUM_deduction FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_name = NULL; // Popup filter for name
$af_sector = NULL; // Popup filter for sector
$af_designation = NULL; // Popup filter for designation
$af_salary = NULL; // Popup filter for salary
$af_bfix = NULL; // Popup filter for bfix
$af_hrafix = NULL; // Popup filter for hrafix
$af_mafix = NULL; // Popup filter for mafix
$af_ccafix = NULL; // Popup filter for ccafix
$af_tafix = NULL; // Popup filter for tafix
$af_pffix = NULL; // Popup filter for pffix
$af_ptaxfix = NULL; // Popup filter for ptaxfix
$af_finalsal = NULL; // Popup filter for finalsal
$af_paid = NULL; // Popup filter for paid
$af_deduction = NULL; // Popup filter for deduction
$af_paymode = NULL; // Popup filter for paymode
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
$EW_REPORT_FIELD_FINALSAL_SQL_SELECT = "SELECT DISTINCT hr_salaryparameters.finalsal FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FINALSAL_SQL_ORDERBY = "hr_salaryparameters.finalsal";
$EW_REPORT_FIELD_PAID_SQL_SELECT = "SELECT DISTINCT hr_payment.paid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PAID_SQL_ORDERBY = "hr_payment.paid";
$EW_REPORT_FIELD_PAYMODE_SQL_SELECT = "SELECT DISTINCT hr_payment.paymode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PAYMODE_SQL_ORDERBY = "hr_payment.paymode";
?>
<?php

// Field variables
$x_name = NULL;
$x_sector = NULL;
$x_designation = NULL;
$x_salary = NULL;
$x_bfix = NULL;
$x_hrafix = NULL;
$x_mafix = NULL;
$x_ccafix = NULL;
$x_tafix = NULL;
$x_pffix = NULL;
$x_ptaxfix = NULL;
$x_finalsal = NULL;
$x_eid = NULL;
$x_id = NULL;
$x_paid = NULL;
$x_deduction = NULL;
$x_totalsal = NULL;
$x_paymode = NULL;

// Detail variables
$o_name = NULL; $t_name = NULL; $ft_name = 201; $rf_name = NULL; $rt_name = NULL;
$o_sector = NULL; $t_sector = NULL; $ft_sector = 201; $rf_sector = NULL; $rt_sector = NULL;
$o_designation = NULL; $t_designation = NULL; $ft_designation = 201; $rf_designation = NULL; $rt_designation = NULL;
$o_salary = NULL; $t_salary = NULL; $ft_salary = 5; $rf_salary = NULL; $rt_salary = NULL;
$o_bfix = NULL; $t_bfix = NULL; $ft_bfix = 5; $rf_bfix = NULL; $rt_bfix = NULL;
$o_hrafix = NULL; $t_hrafix = NULL; $ft_hrafix = 5; $rf_hrafix = NULL; $rt_hrafix = NULL;
$o_mafix = NULL; $t_mafix = NULL; $ft_mafix = 5; $rf_mafix = NULL; $rt_mafix = NULL;
$o_ccafix = NULL; $t_ccafix = NULL; $ft_ccafix = 5; $rf_ccafix = NULL; $rt_ccafix = NULL;
$o_tafix = NULL; $t_tafix = NULL; $ft_tafix = 5; $rf_tafix = NULL; $rt_tafix = NULL;
$o_pffix = NULL; $t_pffix = NULL; $ft_pffix = 5; $rf_pffix = NULL; $rt_pffix = NULL;
$o_ptaxfix = NULL; $t_ptaxfix = NULL; $ft_ptaxfix = 5; $rf_ptaxfix = NULL; $rt_ptaxfix = NULL;
$o_finalsal = NULL; $t_finalsal = NULL; $ft_finalsal = 5; $rf_finalsal = NULL; $rt_finalsal = NULL;
$o_paid = NULL; $t_paid = NULL; $ft_paid = 5; $rf_paid = NULL; $rt_paid = NULL;
$o_deduction = NULL; $t_deduction = NULL; $ft_deduction = 5; $rf_deduction = NULL; $rt_deduction = NULL;
$o_paymode = NULL; $t_paymode = NULL; $ft_paymode = 200; $rf_paymode = NULL; $rt_paymode = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 16;
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
$col = array(FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, TRUE, TRUE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_finalsal = "";
$seld_finalsal = "";
$val_finalsal = "";
$sel_paid = "";
$seld_paid = "";
$val_paid = "";
$sel_paymode = "";
$seld_paymode = "";
$val_paymode = "";

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
<?php $jsdata = ewrpt_GetJsData($val_finalsal, $sel_finalsal, $ft_finalsal) ?>
ewrpt_CreatePopup("SalaryNewReportsmry_finalsal", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_paid, $sel_paid, $ft_paid) ?>
ewrpt_CreatePopup("SalaryNewReportsmry_paid", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_paymode, $sel_paymode, $ft_paymode) ?>
ewrpt_CreatePopup("SalaryNewReportsmry_paymode", [<?php echo $jsdata ?>]);
</script>
<div id="SalaryNewReportsmry_finalsal_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="SalaryNewReportsmry_paid_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="SalaryNewReportsmry_paymode_Popup" class="ewPopup">
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
<?php $genlinkm = "?m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="Salarysmry.php<?php echo $genlinkm; ?>&export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="Salarysmry.php<?php echo $genlinkm; ?>&export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="Salarysmry.php<?php echo $genlinkm; ?>&export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Salarysmry.php<?php echo $genlinkm; ?>&cmd=reset">Reset All Filters</a>
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
<form action="Salarysmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="" class="phpreportmaker">
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
		Sl No		</td>
<?php } else { ?>
		<td class="ewTableHeader"  >
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center" style="font-size:11px">Sl No</td>
			</tr></table>		</td>
<?php } ?>	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Employee Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td class="ewPointer" onmousedown="ewrpt_Sort(event, 'Salarysmry.php?<?php echo EW_REPORT_TABLE_ORDER_BY . "=" . urlencode("name") . "&" . EW_REPORT_TABLE_ORDER_BY_TYPE . "=" . ewrpt_ReverseSort(@$_SESSION["sort_SalaryNewReportsmry_name"]); ?>');">Employee Name</td><td style="width: 10px;">
			<?php if (@$_SESSION["sort_SalaryNewReportsmry_name"] == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION["sort_SalaryNewReportsmry_name"] == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sector
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td class="ewPointer" onmousedown="ewrpt_Sort(event, 'Salarysmry.php?<?php echo EW_REPORT_TABLE_ORDER_BY . "=" . urlencode("sector") . "&" . EW_REPORT_TABLE_ORDER_BY_TYPE . "=" . ewrpt_ReverseSort(@$_SESSION["sort_SalaryNewReportsmry_sector"]); ?>');">Sector</td><td style="width: 10px;">
			<?php if (@$_SESSION["sort_SalaryNewReportsmry_sector"] == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION["sort_SalaryNewReportsmry_sector"] == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Designation
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td class="ewPointer" onmousedown="ewrpt_Sort(event, 'Salarysmry.php?<?php echo EW_REPORT_TABLE_ORDER_BY . "=" . urlencode("designation") . "&" . EW_REPORT_TABLE_ORDER_BY_TYPE . "=" . ewrpt_ReverseSort(@$_SESSION["sort_SalaryNewReportsmry_designation"]); ?>');">Designation</td><td style="width: 10px;">
			<?php if (@$_SESSION["sort_SalaryNewReportsmry_designation"] == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION["sort_SalaryNewReportsmry_designation"] == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="No Of Days Present">
		Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="No of Days Present">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td class="ewPointer" onmousedown="ewrpt_Sort(event, 'Salarysmry.php?<?php echo EW_REPORT_TABLE_ORDER_BY . "=" . urlencode("designation") . "&" . EW_REPORT_TABLE_ORDER_BY_TYPE . "=" . ewrpt_ReverseSort(@$_SESSION["sort_SalaryNewReportsmry_designation"]); ?>');">Days</td><td style="width: 10px;">
			<?php if (@$_SESSION["sort_SalaryNewReportsmry_designation"] == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION["sort_SalaryNewReportsmry_designation"] == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Extra Days worked">Ext. Days
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Extra Days worked">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Ext. Days</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">Basic
			</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Basic</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Basis Allowance">Allow.
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Basis Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Allow.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  title="Earned Salary">Salary
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Earned Salary">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Salary</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  title="Extra Earned Salary">Ext. Sal.
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Extra Earned Salary">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Ext. Sal.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  title="Earned Allowance">Allow.
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Earned Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Allow.</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  title="Net Salary">NET
			</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Net Salary">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">NET</td>
			</tr></table>		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">Signature
			</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" style="font-size:11px">Signature</td>
			</tr></table>		</td>
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
		 
		<td<?php echo $sItemRowClass; ?>>
<?php $sino = $sino+1; echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $sino)); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_name)); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_sector)); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_designation)); ?>
</td>
<?php 
$ba =0 ;
$q1 = "SELECT bfix ,hrafix, mafix, ccafix, tafix,finalsal FROM hr_salaryparameters WHERE sector= '$x_sector' AND name ='$x_name' order by id limit 1";
 $q1rs = mysql_query($q1,$conn1) or die(mysql_error());
		while($q1r = mysql_fetch_assoc($q1rs))
		{
		$ba = $q1r['bfix'];
		$hra = $q1r['hrafix'];
		$ma = $q1r['mafix'];
		$cca = $q1r['ccafix'];
		$ta = $q1r['ttafix'];
		$pf = $q1r['pffix'];
		$pta = $q1r['ptafix'];
		$final = $q1r['finalsal'];
		}
	 	$qid = "select employeeid as id  from hr_employee where sector= '$x_sector' AND name ='$x_name' and designation = '$x_designation'";
		 $qidrs = mysql_query($qid,$conn1);
		while($qidr = mysql_fetch_assoc($qidrs))
		{
		$cid = $qidr['id'];
		}
			$totaldays =0;$workingd=0;
		$qtt ="SELECT dayspresent as noofdays FROM `hr_mnthattendance` where eid='$cid' and month='$month' and year='$cyear' and client='$client'";
 $qttr = mysql_query($qtt,$conn1) ;
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $totaldays = $qttrs['noofdays'];
	  
	  }
	  $query1="select noofdays from hr_workingdays where month = '$month' AND year = '$cyear'";
$result1 = mysql_query($query1,$conn1); 
while($row1 = mysql_fetch_assoc($result1))
{
 $workingd = $row1['noofdays'];
}
	  $ot =0;$extdays=0;
	  $qott ="SELECT ot  FROM `hr_payment` where eid='$cid' and month='$month' and year='$cyear' and client='$client'";
 $qottr = mysql_query($qott,$conn1) ;
	  if($qottrs = mysql_fetch_assoc($qottr))
	  {
	  $ot = $qottrs['ot'];
	  $extdays = (($ot*$workingd)/$ba);
	  }
	  
	 
		
		/*$nooffull=0;$noofhalf=0;$totaldays =0;
		$qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$cid' and month1='$month' and year1='$cyear' and daytype='Full' and client='$client'";
 $qttr = mysql_query($qtt,$conn1) ;
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $nooffull = $qttrs['noofdays'];
	  }
	  
	 $qtt ="SELECT count(*) as noofdays FROM `hr_attendance` where eid='$cid' and month1='$month' and year1='$cyear' and daytype='Half' and client='$client'";
 $qttr = mysql_query($qtt,$conn1) ;
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $noofhalf = $qttrs['noofdays'];
	  } 
	  $totaldays = $nooffull + ($noofhalf/2);*/

		?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($totaldays) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($extdays) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($ba))
//ewrpt_ViewValue($x_bfix) ?>
</td>
<?php $allow =0 ;$allow =$x_salary -$ba;?>
		<td<?php echo $sItemRowClass; ?>>
<?php  echo ewrpt_ViewValue(round($allow))?>
</td>
		<?php $sal=0; $sal = ($ba*$totaldays)/$workingd;?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($sal)) 
//ewrpt_ViewValue($x_hrafix) ?>
</td>
<?php $extsal = 0;$extsal = ($ba*$extdays)/$workingd;?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($extsal))
//ewrpt_ViewValue($x_mafix) ?>
</td>
<?php $allosal =0;$allosal = ($allow*$totaldays)/$workingd;?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($allosal))
//ewrpt_ViewValue($x_ccafix) ?>
</td>
<?php $net=0; $net = $sal+$extsal +$allosal;?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(round($net))
//ewrpt_ViewValue($x_finalsal) ?>
</td>
<td<?php echo $sItemRowClass; ?> width="150px" style="border-bottom-color:#FFFFFF; border-bottom-width:thin">
<?php echo ewrpt_ViewValue("  ");
//ewrpt_ViewValue($x_finalsal) ?>
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
		$grandsmry[4] = $rsagg->fields("SUM_salary");
		$grandsmry[5] = $rsagg->fields("SUM_bfix");
		$grandsmry[6] = $rsagg->fields("SUM_hrafix");
		$grandsmry[7] = $rsagg->fields("SUM_mafix");
		$grandsmry[8] = $rsagg->fields("SUM_ccafix");
		$grandsmry[9] = $rsagg->fields("SUM_tafix");
		$grandsmry[10] = $rsagg->fields("SUM_pffix");
		$grandsmry[11] = $rsagg->fields("SUM_ptaxfix");
		$grandsmry[13] = $rsagg->fields("SUM_paid");
		$grandsmry[14] = $rsagg->fields("SUM_deduction");
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
<?php $nTotalGrps =0;if ($nTotalGrps > 0) { ?>
	<!-- tr><td colspan="16"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="17">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="1" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;
	<?php /*?>	<?php $t_salary = $x_salary; ?>
		<?php $x_salary = $grandsmry[4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_salary) ?>
		<?php $x_salary = $t_salary; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_bfix = $x_bfix; ?>
		<?php $x_bfix = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_bfix) ?>
		<?php $x_bfix = $t_bfix; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_hrafix = $x_hrafix; ?>
		<?php $x_hrafix = $grandsmry[6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_hrafix) ?>
		<?php $x_hrafix = $t_hrafix; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_mafix = $x_mafix; ?>
		<?php $x_mafix = $grandsmry[7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_mafix) ?>
		<?php $x_mafix = $t_mafix; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_ccafix = $x_ccafix; ?>
		<?php $x_ccafix = $grandsmry[8]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_ccafix) ?>
		<?php $x_ccafix = $t_ccafix; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_tafix = $x_tafix; ?>
		<?php $x_tafix = $grandsmry[9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_tafix) ?>
		<?php $x_tafix = $t_tafix; ?><?php */?>
		</td>
		<td>&nbsp;
		<?php /*?><?php $t_pffix = $x_pffix; ?>
		<?php $x_pffix = $grandsmry[10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_pffix) ?>
		<?php $x_pffix = $t_pffix; ?><?php */?>
		</td>
		
	</tr>
<?php } ?>
	</tfoot>

</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="Salarysmry.php?<?php echo $genlinkm; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Salarysmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<!--<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">-->

<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit()" class="phpreportmaker">
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
</center>
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
		$GLOBALS['x_name'] = $rs->fields('name');
		$GLOBALS['x_sector'] = $rs->fields('sector');
		$GLOBALS['x_designation'] = $rs->fields('designation');
		$GLOBALS['x_salary'] = $rs->fields('salary');
		$GLOBALS['x_bfix'] = $rs->fields('bfix');
		$GLOBALS['x_hrafix'] = $rs->fields('hrafix');
		$GLOBALS['x_mafix'] = $rs->fields('mafix');
		$GLOBALS['x_ccafix'] = $rs->fields('ccafix');
		$GLOBALS['x_tafix'] = $rs->fields('tafix');
		$GLOBALS['x_pffix'] = $rs->fields('pffix');
		$GLOBALS['x_ptaxfix'] = $rs->fields('ptaxfix');
		$GLOBALS['x_finalsal'] = $rs->fields('finalsal');
		$GLOBALS['x_eid'] = $rs->fields('eid');
		$GLOBALS['x_id'] = $rs->fields('id');
		$GLOBALS['x_paid'] = $rs->fields('paid');
		$GLOBALS['x_deduction'] = $rs->fields('deduction');
		$GLOBALS['x_totalsal'] = $rs->fields('totalsal');
		$GLOBALS['x_paymode'] = $rs->fields('paymode');
		$val[1] = $GLOBALS['x_name'];
		$val[2] = $GLOBALS['x_sector'];
		$val[3] = $GLOBALS['x_designation'];
		$val[4] = $GLOBALS['x_salary'];
		$val[5] = $GLOBALS['x_bfix'];
		$val[6] = $GLOBALS['x_hrafix'];
		$val[7] = $GLOBALS['x_mafix'];
		$val[8] = $GLOBALS['x_ccafix'];
		$val[9] = $GLOBALS['x_tafix'];
		$val[10] = $GLOBALS['x_pffix'];
		$val[11] = $GLOBALS['x_ptaxfix'];
		$val[12] = $GLOBALS['x_finalsal'];
		$val[13] = $GLOBALS['x_paid'];
		$val[14] = $GLOBALS['x_deduction'];
		$val[15] = $GLOBALS['x_paymode'];
	} else {
		$GLOBALS['x_name'] = "";
		$GLOBALS['x_sector'] = "";
		$GLOBALS['x_designation'] = "";
		$GLOBALS['x_salary'] = "";
		$GLOBALS['x_bfix'] = "";
		$GLOBALS['x_hrafix'] = "";
		$GLOBALS['x_mafix'] = "";
		$GLOBALS['x_ccafix'] = "";
		$GLOBALS['x_tafix'] = "";
		$GLOBALS['x_pffix'] = "";
		$GLOBALS['x_ptaxfix'] = "";
		$GLOBALS['x_finalsal'] = "";
		$GLOBALS['x_eid'] = "";
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_paid'] = "";
		$GLOBALS['x_deduction'] = "";
		$GLOBALS['x_totalsal'] = "";
		$GLOBALS['x_paymode'] = "";
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
	// Build distinct values for finalsal

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FINALSAL_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FINALSAL_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_finalsal = $rswrk->fields[0];
		if (is_null($x_finalsal)) {
			$bNullValue = TRUE;
		} elseif ($x_finalsal == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_finalsal = $x_finalsal;
			ewrpt_SetupDistinctValues($GLOBALS["val_finalsal"], $x_finalsal, $t_finalsal, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_finalsal"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_finalsal"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for paid
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_PAID_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_PAID_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_paid = $rswrk->fields[0];
		if (is_null($x_paid)) {
			$bNullValue = TRUE;
		} elseif ($x_paid == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_paid = $x_paid;
			ewrpt_SetupDistinctValues($GLOBALS["val_paid"], $x_paid, $t_paid, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_paid"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_paid"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for paymode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_PAYMODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_PAYMODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_paymode = $rswrk->fields[0];
		if (is_null($x_paymode)) {
			$bNullValue = TRUE;
		} elseif ($x_paymode == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_paymode = $x_paymode;
			ewrpt_SetupDistinctValues($GLOBALS["val_paymode"], $x_paymode, $t_paymode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_paymode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_paymode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('finalsal');
			ClearSessionSelection('paid');
			ClearSessionSelection('paymode');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Finalsal selected values

	if (is_array(@$_SESSION["sel_SalaryNewReportsmry_finalsal"])) {
		LoadSelectionFromSession('finalsal');
	} elseif (@$_SESSION["sel_SalaryNewReportsmry_finalsal"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_finalsal"] = "";
	}

	// Get Paid selected values
	if (is_array(@$_SESSION["sel_SalaryNewReportsmry_paid"])) {
		LoadSelectionFromSession('paid');
	} elseif (@$_SESSION["sel_SalaryNewReportsmry_paid"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_paid"] = "";
	}

	// Get Paymode selected values
	if (is_array(@$_SESSION["sel_SalaryNewReportsmry_paymode"])) {
		LoadSelectionFromSession('paymode');
	} elseif (@$_SESSION["sel_SalaryNewReportsmry_paymode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_paymode"] = "";
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

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_SalaryNewReportsmry_$parm"] = "";
	$_SESSION["rf_SalaryNewReportsmry_$parm"] = "";
	$_SESSION["rt_SalaryNewReportsmry_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_SalaryNewReportsmry_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_SalaryNewReportsmry_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_SalaryNewReportsmry_$parm"];
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

	// Field finalsal
	// Setup your default values for the popup filter below, e.g.
	// $seld_finalsal = array("val1", "val2");

	$GLOBALS["seld_finalsal"] = "";
	$GLOBALS["sel_finalsal"] =  $GLOBALS["seld_finalsal"];

	// Field paid
	// Setup your default values for the popup filter below, e.g.
	// $seld_paid = array("val1", "val2");

	$GLOBALS["seld_paid"] = "";
	$GLOBALS["sel_paid"] =  $GLOBALS["seld_paid"];

	// Field paymode
	// Setup your default values for the popup filter below, e.g.
	// $seld_paymode = array("val1", "val2");

	$GLOBALS["seld_paymode"] = "";
	$GLOBALS["sel_paymode"] =  $GLOBALS["seld_paymode"];
}

// Check if filter applied
function CheckFilter() {

	// Check finalsal popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_finalsal"], $GLOBALS["sel_finalsal"]))
		return TRUE;

	// Check paid popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_paid"], $GLOBALS["sel_paid"]))
		return TRUE;

	// Check paymode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_paymode"], $GLOBALS["sel_paymode"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field finalsal
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_finalsal"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_finalsal"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Finalsal<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field paid
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_paid"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_paid"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Paid<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field paymode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_paymode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_paymode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Paymode<br />";
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
	if (is_array($GLOBALS["sel_finalsal"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_finalsal"], "hr_salaryparameters.finalsal", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_finalsal"]);
	}
	if (is_array($GLOBALS["sel_paid"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_paid"], "hr_payment.paid", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_paid"]);
	}
	if (is_array($GLOBALS["sel_paymode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_paymode"], "hr_payment.paymode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_paymode"]);
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

	// Check for Ctrl pressed
	if (strlen(@$_GET["ctrl"]) > 0) {
		$bCtrl = true;
	} else {
		$bCtrl = false;
	}

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_SalaryNewReportsmry_name"] = "";
			$_SESSION["sort_SalaryNewReportsmry_sector"] = "";
			$_SESSION["sort_SalaryNewReportsmry_designation"] = "";
			$_SESSION["sort_SalaryNewReportsmry_salary"] = "";
			$_SESSION["sort_SalaryNewReportsmry_bfix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_hrafix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_mafix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_ccafix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_tafix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_pffix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_ptaxfix"] = "";
			$_SESSION["sort_SalaryNewReportsmry_finalsal"] = "";
			$_SESSION["sort_SalaryNewReportsmry_paid"] = "";
			$_SESSION["sort_SalaryNewReportsmry_deduction"] = "";
			$_SESSION["sort_SalaryNewReportsmry_paymode"] = "";
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

		// Field name
		if ($sOrder == "name") {
			$sSortField = "hr_employee.name";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_name"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_name"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_name"] <> "") { $_SESSION["sort_SalaryNewReportsmry_name"] = "" ; }
		}

		// Field sector
		if ($sOrder == "sector") {
			$sSortField = "hr_employee.sector";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_sector"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_sector"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_sector"] <> "") { $_SESSION["sort_SalaryNewReportsmry_sector"] = "" ; }
		}

		// Field designation
		if ($sOrder == "designation") {
			$sSortField = "hr_employee.designation";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_designation"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_designation"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_designation"] <> "") { $_SESSION["sort_SalaryNewReportsmry_designation"] = "" ; }
		}

		// Field salary
		if ($sOrder == "salary") {
			$sSortField = "hr_employee.salary";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_salary"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_salary"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_salary"] <> "") { $_SESSION["sort_SalaryNewReportsmry_salary"] = "" ; }
		}

		// Field bfix
		if ($sOrder == "bfix") {
			$sSortField = "hr_salaryparameters.bfix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_bfix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_bfix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_bfix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_bfix"] = "" ; }
		}

		// Field hrafix
		if ($sOrder == "hrafix") {
			$sSortField = "hr_salaryparameters.hrafix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_hrafix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_hrafix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_hrafix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_hrafix"] = "" ; }
		}

		// Field mafix
		if ($sOrder == "mafix") {
			$sSortField = "hr_salaryparameters.mafix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_mafix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_mafix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_mafix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_mafix"] = "" ; }
		}

		// Field ccafix
		if ($sOrder == "ccafix") {
			$sSortField = "hr_salaryparameters.ccafix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_ccafix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_ccafix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_ccafix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_ccafix"] = "" ; }
		}

		// Field tafix
		if ($sOrder == "tafix") {
			$sSortField = "hr_salaryparameters.tafix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_tafix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_tafix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_tafix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_tafix"] = "" ; }
		}

		// Field pffix
		if ($sOrder == "pffix") {
			$sSortField = "hr_salaryparameters.pffix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_pffix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_pffix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_pffix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_pffix"] = "" ; }
		}

		// Field ptaxfix
		if ($sOrder == "ptaxfix") {
			$sSortField = "hr_salaryparameters.ptaxfix";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_ptaxfix"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_ptaxfix"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_ptaxfix"] <> "") { $_SESSION["sort_SalaryNewReportsmry_ptaxfix"] = "" ; }
		}

		// Field finalsal
		if ($sOrder == "finalsal") {
			$sSortField = "hr_salaryparameters.finalsal";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_finalsal"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_finalsal"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_finalsal"] <> "") { $_SESSION["sort_SalaryNewReportsmry_finalsal"] = "" ; }
		}

		// Field paid
		if ($sOrder == "paid") {
			$sSortField = "hr_payment.paid";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_paid"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_paid"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_paid"] <> "") { $_SESSION["sort_SalaryNewReportsmry_paid"] = "" ; }
		}

		// Field deduction
		if ($sOrder == "deduction") {
			$sSortField = "hr_payment.deduction";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_deduction"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_deduction"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_deduction"] <> "") { $_SESSION["sort_SalaryNewReportsmry_deduction"] = "" ; }
		}

		// Field paymode
		if ($sOrder == "paymode") {
			$sSortField = "hr_payment.paymode";
			$sLastSort = @$_SESSION["sort_SalaryNewReportsmry_paymode"];
			if ($sOrderType == "ASC" || $sOrderType == "DESC") {
				$sThisSort = $sOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$_SESSION["sort_SalaryNewReportsmry_paymode"] = $sThisSort;
		} else {
			if (!($bCtrl) && @$_SESSION["sort_SalaryNewReportsmry_paymode"] <> "") { $_SESSION["sort_SalaryNewReportsmry_paymode"] = "" ; }
		}
		if ($bCtrl) {
			$sOrderBy = @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
			$sOrderBy = ewrpt_UpdateSortFields($sOrderBy, $sSortField . " " . $sThisSort);
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = $sOrderBy;
		} else {
			if ($sSortField <> "") {
				if ($sSortSql <> "") $sSortSql .= ", ";
				$sSortSql .= $sSortField . " " . $sThisSort;
			}
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = $sSortSql;
		}
		$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
