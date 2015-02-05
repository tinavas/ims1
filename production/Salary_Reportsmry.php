
<?php
session_start();$currencyunits=$_SESSION['currency'];
ob_start();

$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");

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
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php include "getemployee.php"; ?>
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
define("EW_REPORT_TABLE_VAR", "Salary_Report", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Salary_Report_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Salary_Report_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Salary_Report_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Salary_Report_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Salary_Report_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee Inner Join hr_salary_payment On hr_employee.employeeid = hr_salary_payment.eid";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_salary_payment.name, hr_employee.sector, hr_employee.designation, hr_salary_payment.totalsal, hr_salary_payment.advded, hr_salary_payment.oded,hr_salary_payment.incometax, hr_salary_payment.paid, hr_salary_payment.paymode, hr_salary_payment.leavesded, hr_salary_payment.cddno, hr_salary_payment.salparamid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $sc '$_GET[sector]' and hr_employee.name $nc '$_GET[empname]'  and hr_salary_payment.month1='$month' and hr_salary_payment.year1 = '$cyear'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hr_employee.designation ASC, hr_employee.sector ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "hr_employee.designation", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `designation` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hr_salary_payment.totalsal) AS SUM_totalsal, SUM(hr_salary_payment.advded) AS SUM_advdeduction, SUM(hr_salary_payment.oded) AS SUM_deduction, SUM(hr_salary_payment.incometax) AS SUM_ot, SUM(hr_salary_payment.paid) AS SUM_paid, SUM(hr_salary_payment.leavesded) AS SUM_leavesded FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_name = NULL; // Popup filter for name
$af_sector = NULL; // Popup filter for sector
$af_designation = NULL; // Popup filter for designation
$af_totalsal = NULL; // Popup filter for totalsal
$af_advdeduction = NULL; // Popup filter for advdeduction
$af_deduction = NULL; // Popup filter for deduction
$af_pbonus = NULL; // Popup filter for pbonus
$af_bonus = NULL; // Popup filter for bonus
$af_ot = NULL; // Popup filter for ot
$af_paid = NULL; // Popup filter for paid
$af_paymode = NULL; // Popup filter for paymode
$af_leavesded = NULL; // Popup filter for leavesded
$af_cddno = NULL; // Popup filter for cddno
$af_salparamid = NULL; // Popup filter for salparamid
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
$nDisplayGrps = 50; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_NAME_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.name FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_NAME_SQL_ORDERBY = "hr_salary_payment.name";
$EW_REPORT_FIELD_TOTALSAL_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.totalsal FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_TOTALSAL_SQL_ORDERBY = "hr_salary_payment.totalsal";
$EW_REPORT_FIELD_ADVDEDUCTION_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.advded FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_ADVDEDUCTION_SQL_ORDERBY = "hr_salary_payment.advdeduction";
$EW_REPORT_FIELD_DEDUCTION_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.oded FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_OT_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.incometax FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_OT_SQL_ORDERBY = "hr_salary_payment.incometax";
$EW_REPORT_FIELD_PAID_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.paid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PAID_SQL_ORDERBY = "hr_salary_payment.paid";
$EW_REPORT_FIELD_PAYMODE_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.paymode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PAYMODE_SQL_ORDERBY = "hr_salary_payment.paymode";
$EW_REPORT_FIELD_LEAVESDED_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.leavesded FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_LEAVESDED_SQL_ORDERBY = "hr_salary_payment.leavesded";
$EW_REPORT_FIELD_CDDNO_SQL_SELECT = "SELECT DISTINCT hr_salary_payment.cddno FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_CDDNO_SQL_ORDERBY = "hr_salary_payment.cddno";
?>
<?php

// Field variables
$x_name = NULL;
$x_sector = NULL;
$x_designation = NULL;
$x_totalsal = NULL;
$x_advdeduction = NULL;
$x_deduction = NULL;
$x_pbonus = NULL;
$x_bonus = NULL;
$x_ot = NULL;
$x_paid = NULL;
$x_paymode = NULL;
$x_leavesded = NULL;
$x_cddno = NULL;
$x_salparamid = NULL;

// Group variables
$o_designation = NULL; $g_designation = NULL; $dg_designation = NULL; $t_designation = NULL; $ft_designation = 201; $gf_designation = $ft_designation; $gb_designation = ""; $gi_designation = "0"; $gq_designation = ""; $rf_designation = NULL; $rt_designation = NULL;
$o_sector = NULL; $g_sector = NULL; $dg_sector = NULL; $t_sector = NULL; $ft_sector = 201; $gf_sector = $ft_sector; $gb_sector = ""; $gi_sector = "0"; $gq_sector = ""; $rf_sector = NULL; $rt_sector = NULL;

// Detail variables
$o_name = NULL; $t_name = NULL; $ft_name = 200; $rf_name = NULL; $rt_name = NULL;
$o_totalsal = NULL; $t_totalsal = NULL; $ft_totalsal = 5; $rf_totalsal = NULL; $rt_totalsal = NULL;
$o_advdeduction = NULL; $t_advdeduction = NULL; $ft_advdeduction = 5; $rf_advdeduction = NULL; $rt_advdeduction = NULL;
$o_deduction = NULL; $t_deduction = NULL; $ft_deduction = 5; $rf_deduction = NULL; $rt_deduction = NULL;
$o_pbonus = NULL; $t_pbonus = NULL; $ft_pbonus = 5; $rf_pbonus = NULL; $rt_pbonus = NULL;
$o_bonus = NULL; $t_bonus = NULL; $ft_bonus = 5; $rf_bonus = NULL; $rt_bonus = NULL;
$o_ot = NULL; $t_ot = NULL; $ft_ot = 5; $rf_ot = NULL; $rt_ot = NULL;
$o_paid = NULL; $t_paid = NULL; $ft_paid = 5; $rf_paid = NULL; $rt_paid = NULL;
$o_paymode = NULL; $t_paymode = NULL; $ft_paymode = 200; $rf_paymode = NULL; $rt_paymode = NULL;
$o_leavesded = NULL; $t_leavesded = NULL; $ft_leavesded = 5; $rf_leavesded = NULL; $rt_leavesded = NULL;
$o_cddno = NULL; $t_cddno = NULL; $ft_cddno = 200; $rf_cddno = NULL; $rt_cddno = NULL;
$o_salparamid = NULL; $t_salparamid = NULL; $ft_salparamid = 5; $rf_salparamid = NULL; $rt_salparamid = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 13;
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
$col = array(FALSE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, TRUE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_name = "";
$seld_name = "";
$val_name = "";
$sel_totalsal = "";
$seld_totalsal = "";
$val_totalsal = "";
$sel_advdeduction = "";
$seld_advdeduction = "";
$val_advdeduction = "";
$sel_deduction = "";
$seld_deduction = "";
$val_deduction = "";
$sel_pbonus = "";
$seld_pbonus = "";
$val_pbonus = "";
$sel_bonus = "";
$seld_bonus = "";
$val_bonus = "";
$sel_ot = "";
$seld_ot = "";
$val_ot = "";
$sel_paid = "";
$seld_paid = "";
$val_paid = "";
$sel_paymode = "";
$seld_paymode = "";
$val_paymode = "";
$sel_leavesded = "";
$seld_leavesded = "";
$val_leavesded = "";
$sel_cddno = "";
$seld_cddno = "";
$val_cddno = "";

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
var EW_REPORT_DATE_SEPARATOR = ".";
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
<?php $jsdata = ewrpt_GetJsData($val_name, $sel_name, $ft_name) ?>
ewrpt_CreatePopup("Salary_Report_name", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_totalsal, $sel_totalsal, $ft_totalsal) ?>
ewrpt_CreatePopup("Salary_Report_totalsal", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_advdeduction, $sel_advdeduction, $ft_advdeduction) ?>
ewrpt_CreatePopup("Salary_Report_advdeduction", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_deduction, $sel_deduction, $ft_deduction) ?>
ewrpt_CreatePopup("Salary_Report_deduction", [<?php echo $jsdata ?>]);
<?php /*?><?php $jsdata = ewrpt_GetJsData($val_pbonus, $sel_pbonus, $ft_pbonus) ?>
ewrpt_CreatePopup("Salary_Report_pbonus", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_bonus, $sel_bonus, $ft_bonus) ?>
ewrpt_CreatePopup("Salary_Report_bonus", [<?php echo $jsdata ?>]);<?php */?>
<?php $jsdata = ewrpt_GetJsData($val_ot, $sel_ot, $ft_ot) ?>
ewrpt_CreatePopup("Salary_Report_ot", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_paid, $sel_paid, $ft_paid) ?>
ewrpt_CreatePopup("Salary_Report_paid", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_paymode, $sel_paymode, $ft_paymode) ?>
ewrpt_CreatePopup("Salary_Report_paymode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_leavesded, $sel_leavesded, $ft_leavesded) ?>
ewrpt_CreatePopup("Salary_Report_leavesded", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_cddno, $sel_cddno, $ft_cddno) ?>
ewrpt_CreatePopup("Salary_Report_cddno", [<?php echo $jsdata ?>]);
</script>
<div id="Salary_Report_name_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_totalsal_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_advdeduction_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_deduction_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<!--<div id="Salary_Report_pbonus_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_bonus_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>-->
<div id="Salary_Report_ot_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_paid_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_paymode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_leavesded_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Report_cddno_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<center>
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
&nbsp;&nbsp;<a href="Salary_Reportsmry.php<?php echo $genlinkm; ?>&export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="Salary_Reportsmry.php<?php echo $genlinkm; ?>&export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="Salary_Reportsmry.php<?php echo $genlinkm; ?>&export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Salary_Reportsmry.php<?php echo $genlinkm; ?>&cmd=reset">Reset All Filters</a>
<?php } ?>
<br /><br />
<?php } ?>

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
<center>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php /*?><?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="Salary_Reportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?><?php */?>
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
        <td valign="bottom" class="ewTableHeader"> Name </td>
        <?php } else { ?>
        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Name</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_name', false, '<?php echo $rf_name; ?>', '<?php echo $rt_name; ?>');return false;" name="x_name<?php echo $cnt[0][0]; ?>" id="x_name<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewRptGrpHeader1"> Designation </td>
        <?php } else { ?>
        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Designation</td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewRptGrpHeader2"> Sector </td>
        <?php } else { ?>
        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Sector</td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader"> Total Salary </td>
        <?php } else { ?>
        <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Total Salary</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_totalsal', true, '<?php echo $rf_totalsal; ?>', '<?php echo $rt_totalsal; ?>');return false;" name="x_totalsal<?php echo $cnt[0][0]; ?>" id="x_totalsal<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Deduction From Advance/Loan taken"> Adv. Ded. </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Deduction From Advance/Loan taken"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Adv. Ded.</td>
            <td style="width: 20px;" align="right"><?php /*?><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_advdeduction', true, '<?php echo $rf_advdeduction; ?>', '<?php echo $rt_advdeduction; ?>');return false;" name="x_advdeduction<?php echo $cnt[0][0]; ?>" id="x_advdeduction<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a><?php */?></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Other Deductions"> O. Ded. </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Other Deductions"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>O. Ded.</td>
            <td style="width: 20px;" align="right"><?php /*?><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_deduction', true, '<?php echo $rf_deduction; ?>', '<?php echo $rt_deduction; ?>');return false;" name="x_deduction<?php echo $cnt[0][0]; ?>" id="x_deduction<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a><?php */?></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php /*?><?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Previous Balance Cleared/Advance Given"> P.B. Cl. </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Previous Balance Cleared/Advance Given"><table cellspacing="0" class="ewTableHeaderBtn" >
          <tr>
              <td>P.B. Cl.</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_pbonus', true, '<?php echo $rf_pbonus; ?>', '<?php echo $rt_pbonus; ?>');return false;" name="x_pbonus<?php echo $cnt[0][0]; ?>" id="x_pbonus<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Other Bonus"> O. Bon. </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Other Bonus"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>O. Bon.</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_bonus', true, '<?php echo $rf_bonus; ?>', '<?php echo $rt_bonus; ?>');return false;" name="x_bonus<?php echo $cnt[0][0]; ?>" id="x_bonus<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td> 
        <?php } ?><?php */?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Over Time Salary Paid">Income Tax </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Over Time Salary Paid"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Income Tax</td>
            <td style="width: 20px;" align="right"><?php /*?><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_ot', true, '<?php echo $rf_ot; ?>', '<?php echo $rt_ot; ?>');return false;" name="x_ot<?php echo $cnt[0][0]; ?>" id="x_ot<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a><?php */?></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Salary Paid"> Sal. Paid </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Salary Paid"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Sal. Paid</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_paid', true, '<?php echo $rf_paid; ?>', '<?php echo $rt_paid; ?>');return false;" name="x_paid<?php echo $cnt[0][0]; ?>" id="x_paid<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Payment Mode"> Pay Mode </td>
        <?php } else { ?>
        <td class="ewTableHeader" title="Payment Mode"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Pay Mode</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_paymode', false, '<?php echo $rf_paymode; ?>', '<?php echo $rt_paymode; ?>');return false;" name="x_paymode<?php echo $cnt[0][0]; ?>" id="x_paymode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
       
        <?php if (@$sExport <> "") { ?>
        <td valign="bottom" class="ewTableHeader" title="Cheque Number"> Cheque </td>
        <?php } else { ?>
        <td class="ewTableHeader"  title="Cheque Number"><table cellspacing="0" class="ewTableHeaderBtn">
          <tr>
              <td>Cheque</td>
            <td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Salary_Report_cddno', false, '<?php echo $rf_cddno; ?>', '<?php echo $rt_cddno; ?>');return false;" name="x_cddno<?php echo $cnt[0][0]; ?>" id="x_cddno<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="" /></a></td>
          </tr>
        </table></td>
        <?php } ?>
        <?php /*if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Salparamid
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Salparamid</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_designation, EW_REPORT_DATATYPE_MEMO);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_designation, EW_REPORT_DATATYPE_MEMO, $gb_designation, $gi_designation, $gq_designation);
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
		$dg_designation = $x_designation;
		if ((is_null($x_designation) && is_null($o_designation)) ||
			(($x_designation <> "" && $o_designation == $dg_designation) && !ChkLvlBreak(1))) {
			$dg_designation = "&nbsp;";
		} elseif (is_null($x_designation)) {
			$dg_designation = EW_REPORT_NULL_LABEL;
		} elseif ($x_designation == "") {
			$dg_designation = EW_REPORT_EMPTY_LABEL;
		}
		$dg_sector = $x_sector;
		if ((is_null($x_sector) && is_null($o_sector)) ||
			(($x_sector <> "" && $o_sector == $dg_sector) && !ChkLvlBreak(2))) {
			$dg_sector = "&nbsp;";
		} elseif (is_null($x_sector)) {
			$dg_sector = EW_REPORT_NULL_LABEL;
		} elseif ($x_sector == "") {
			$dg_sector = EW_REPORT_EMPTY_LABEL;
		}
?>
      <tr>
        <td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($x_name) ?> </td>
        <td class="ewRptGrpField1"><?php $t_designation = $x_designation; $x_designation = $dg_designation; ?>
            <?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_designation)); ?>
            <?php $x_designation = $t_designation; ?></td>
        <td class="ewRptGrpField2"><?php $t_sector = $x_sector; $x_sector = $dg_sector; ?>
            <?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_sector)); ?>
            <?php $x_sector = $t_sector; ?></td>
        <?php /*?><td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($x_designation) ?>
		</td>
		<td class="ewRptGrpField2">
		<?php echo ewrpt_ViewValue($x_sector) ?>
		</td><?php */?>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_totalsal) ?></b> </td>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_advdeduction) ?></b> </td>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_deduction) ?></b> </td>
       <?php /*?> <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_pbonus) ?></b> </td>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_bonus) ?></b> </td><?php */?>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_ot) ?></b> </td>
        <td<?php echo $sItemRowClass; ?>><b><?php echo ewrpt_ViewValue($x_paid) ?></b> </td>
        <td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($x_paymode) ?> </td>
       <?php /*?> <td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($x_leavesded) ?> </td><?php */?>
        <td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($x_cddno) ?> </td>
       <?php /*?> <td<?php echo $sItemRowClass; ?>><?php echo ewrpt_ViewValue($x_salparamid) ?> </td><?php */?>
      </tr>
      <?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_designation = $x_designation;
		$o_sector = $x_sector;

		// Get next record
		GetRow(2);

		// Show Footers
?>
      <?php
	} // End detail records loop
?>
      <?php

	// Next group
	$o_designation = $x_designation; // Save old group value
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
		$grandsmry[2] = $rsagg->fields("SUM_totalsal");
		$grandsmry[3] = $rsagg->fields("SUM_advdeduction");
		$grandsmry[4] = $rsagg->fields("SUM_deduction");
		//$grandsmry[5] = $rsagg->fields("SUM_pbonus");
		//$grandsmry[6] = $rsagg->fields("SUM_bonus");
		$grandsmry[7] = $rsagg->fields("SUM_ot");
		$grandsmry[8] = $rsagg->fields("SUM_paid");
		//$grandsmry[10] = $rsagg->fields("SUM_leavesded");
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
      <tr class="ewRptGrandSummary">
        <td colspan="13">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td>
      </tr>
      <tr class="ewRptGrandSummary">
        <td colspan="2" class="ewRptGrpAggregate">SUM</td>
        <td>&nbsp;</td>
        <td><?php $t_totalsal = $x_totalsal; ?>
            <?php $x_totalsal = $grandsmry[2]; // Load SUM ?>
            <b><?php echo changeprice($x_totalsal) ?></b>
            <?php $x_totalsal = $t_totalsal; ?>        </td>
        <td><?php $t_advdeduction = $x_advdeduction; ?>
            <?php $x_advdeduction = $grandsmry[3]; // Load SUM ?>
            <b><?php echo changeprice($x_advdeduction) ?></b>
            <?php $x_advdeduction = $t_advdeduction; ?>        </td>
        <td><?php $t_deduction = $x_deduction; ?>
            <?php $x_deduction = $grandsmry[4]; // Load SUM ?>
            <b><?php echo changeprice($x_deduction) ?></b>
            <?php $x_deduction = $t_deduction; ?>        </td>
      <?php /*?>  <td><?php $t_pbonus = $x_pbonus; ?>
            <?php $x_pbonus = $grandsmry[5]; // Load SUM ?>
            <b><?php echo ewrpt_ViewValue($x_pbonus) ?></b>
            <?php $x_pbonus = $t_pbonus; ?>        </td>
        <td><?php $t_bonus = $x_bonus; ?>
            <?php $x_bonus = $grandsmry[6]; // Load SUM ?>
            <b><?php echo ewrpt_ViewValue($x_bonus) ?></b>
            <?php $x_bonus = $t_bonus; ?>        </td><?php */?>
        <td><?php $t_ot = $x_ot; ?>
            <?php $x_ot = $grandsmry[7]; // Load SUM ?>
            <b><?php echo changeprice($x_ot) ?></b>
            <?php $x_ot = $t_ot; ?>        </td>
        <td><?php $t_paid = $x_paid; ?>
            <?php $x_paid = $grandsmry[8]; // Load SUM ?>
            <b><?php echo changeprice($x_paid) ?></b>
            <?php $x_paid = $t_paid; ?>        </td>
        <td>&nbsp;</td>
       <?php /*?> <td><?php $t_leavesded = $x_leavesded; ?>
            <?php $x_leavesded = $grandsmry[10]; // Load SUM ?>
            <?php echo ewrpt_ViewValue($x_leavesded) ?>
            <?php $x_leavesded = $t_leavesded; ?>        </td><?php */?>
        <td>&nbsp;</td>
        <!--<td>&nbsp;</td>-->
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php /*?><?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="Salary_Reportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Salary_Reportsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpreportmaker">No records found</span>
	<?php } ?>
<?php } ?>		</td>
<?php if ($nTotalGrps > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" onChange="this.form.submit();" class="phpreportmaker">
<option value="50"<?php if ($nDisplayGrps == 50) echo " selected" ?>>50</option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?><?php */?>
<?php } ?></td></tr></table>
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
<?php include "phprptinc/footer.php"; ?>
 
<?php
$conn->Close();

// display elapsed time
if (defined("EW_REPORT_DEBUG_ENABLED"))
	echo ewrpt_calcElapsedTime($starttime);
?>
<?php

// Check level break
function ChkLvlBreak($lvl) {
	switch ($lvl) {
		case 1:
			return (is_null($GLOBALS["x_designation"]) && !is_null($GLOBALS["o_designation"])) ||
				(!is_null($GLOBALS["x_designation"]) && is_null($GLOBALS["o_designation"])) ||
				($GLOBALS["x_designation"] <> $GLOBALS["o_designation"]);
		case 2:
			return (is_null($GLOBALS["x_sector"]) && !is_null($GLOBALS["o_sector"])) ||
				(!is_null($GLOBALS["x_sector"]) && is_null($GLOBALS["o_sector"])) ||
				($GLOBALS["x_sector"] <> $GLOBALS["o_sector"]) || ChkLvlBreak(1); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_designation"] = "";
	if ($lvl <= 2) $GLOBALS["o_sector"] = "";

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
		$GLOBALS['x_designation'] = "";
	} else {
		$GLOBALS['x_designation'] = $rsgrp->fields('designation');
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
		$GLOBALS['x_name'] = $rs->fields('name');
		$GLOBALS['x_sector'] = $rs->fields('sector');
		$GLOBALS['x_totalsal'] = $rs->fields('totalsal');
		$GLOBALS['x_advdeduction'] = $rs->fields('advded');
		$GLOBALS['x_deduction'] = $rs->fields('oded');
		 //$GLOBALS['x_pbonus'] = $rs->fields('pbonus');
		//$GLOBALS['x_bonus'] = $rs->fields('bonus');
	
		$GLOBALS['x_ot'] = $rs->fields('incometax');
		$GLOBALS['x_paid'] = $rs->fields('paid');
		$GLOBALS['x_paymode'] = $rs->fields('paymode');
	//	$GLOBALS['x_leavesded'] = $rs->fields('leavesded');
		$GLOBALS['x_cddno'] = $rs->fields('cddno');
		$GLOBALS['x_salparamid'] = $rs->fields('salparamid');
		$val[1] = $GLOBALS['x_name'];
		$val[2] = $GLOBALS['x_totalsal'];
		$val[3] = $GLOBALS['x_advdeduction'];
		$val[4] = $GLOBALS['x_deduction'];
		//$val[5] = $GLOBALS['x_pbonus'];
		//$val[6] = $GLOBALS['x_bonus'];
		$val[7] = $GLOBALS['x_ot'];
		$val[8] = $GLOBALS['x_paid'];
		$val[9] = $GLOBALS['x_paymode'];
		$val[10] = $GLOBALS['x_leavesded'];
		$val[11] = $GLOBALS['x_cddno'];
		$val[12] = $GLOBALS['x_salparamid'];
	} else {
		$GLOBALS['x_name'] = "";
		$GLOBALS['x_sector'] = "";
		$GLOBALS['x_totalsal'] = "";
		$GLOBALS['x_advdeduction'] = "";
		$GLOBALS['x_deduction'] = "";
		//$GLOBALS['x_pbonus'] = "";
		//$GLOBALS['x_bonus'] = "";
		$GLOBALS['x_ot'] = "";
		$GLOBALS['x_paid'] = "";
		$GLOBALS['x_paymode'] = "";
		//$GLOBALS['x_leavesded'] = "";
		$GLOBALS['x_cddno'] = "";
		$GLOBALS['x_salparamid'] = "";
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
	// Build distinct values for name

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_NAME_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_NAME_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_name = $rswrk->fields[0];
		if (is_null($x_name)) {
			$bNullValue = TRUE;
		} elseif ($x_name == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_name = $x_name;
			ewrpt_SetupDistinctValues($GLOBALS["val_name"], $x_name, $t_name, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_name"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_name"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for totalsal
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_TOTALSAL_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_TOTALSAL_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_totalsal = $rswrk->fields[0];
		if (is_null($x_totalsal)) {
			$bNullValue = TRUE;
		} elseif ($x_totalsal == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_totalsal = $x_totalsal;
			ewrpt_SetupDistinctValues($GLOBALS["val_totalsal"], $x_totalsal, $t_totalsal, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_totalsal"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_totalsal"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for advdeduction
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_ADVDEDUCTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_ADVDEDUCTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_advdeduction = $rswrk->fields[0];
		if (is_null($x_advdeduction)) {
			$bNullValue = TRUE;
		} elseif ($x_advdeduction == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_advdeduction = $x_advdeduction;
			ewrpt_SetupDistinctValues($GLOBALS["val_advdeduction"], $x_advdeduction, $t_advdeduction, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_advdeduction"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_advdeduction"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for deduction
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_DEDUCTION_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_DEDUCTION_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_deduction = $rswrk->fields[0];
		if (is_null($x_deduction)) {
			$bNullValue = TRUE;
		} elseif ($x_deduction == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_deduction = $x_deduction;
			ewrpt_SetupDistinctValues($GLOBALS["val_deduction"], $x_deduction, $t_deduction, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_deduction"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_deduction"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for pbonus
	  /*?>$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_PBONUS_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_PBONUS_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_pbonus = $rswrk->fields[0];
		if (is_null($x_pbonus)) {
			$bNullValue = TRUE;
		} elseif ($x_pbonus == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_pbonus = $x_pbonus;
			ewrpt_SetupDistinctValues($GLOBALS["val_pbonus"], $x_pbonus, $t_pbonus, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_pbonus"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_pbonus"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for bonus
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_BONUS_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_BONUS_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_bonus = $rswrk->fields[0];
		if (is_null($x_bonus)) {
			$bNullValue = TRUE;
		} elseif ($x_bonus == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_bonus = $x_bonus;
			ewrpt_SetupDistinctValues($GLOBALS["val_bonus"], $x_bonus, $t_bonus, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_bonus"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_bonus"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);
<?php */?><?php
	// Build distinct values for ot
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_OT_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_OT_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_ot = $rswrk->fields[0];
		if (is_null($x_ot)) {
			$bNullValue = TRUE;
		} elseif ($x_ot == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_ot = $x_ot;
			ewrpt_SetupDistinctValues($GLOBALS["val_ot"], $x_ot, $t_ot, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_ot"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_ot"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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

	// Build distinct values for leavesded
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_LEAVESDED_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_LEAVESDED_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_leavesded = $rswrk->fields[0];
		if (is_null($x_leavesded)) {
			$bNullValue = TRUE;
		} elseif ($x_leavesded == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_leavesded = $x_leavesded;
			ewrpt_SetupDistinctValues($GLOBALS["val_leavesded"], $x_leavesded, $t_leavesded, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_leavesded"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_leavesded"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for cddno
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_CDDNO_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_CDDNO_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_cddno = $rswrk->fields[0];
		if (is_null($x_cddno)) {
			$bNullValue = TRUE;
		} elseif ($x_cddno == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_cddno = $x_cddno;
			ewrpt_SetupDistinctValues($GLOBALS["val_cddno"], $x_cddno, $t_cddno, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_cddno"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_cddno"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('name');
			ClearSessionSelection('totalsal');
			ClearSessionSelection('advded');
			ClearSessionSelection('oded');
			//ClearSessionSelection('pbonus');
			//ClearSessionSelection('bonus');
			ClearSessionSelection('incometax');
			ClearSessionSelection('paid');
			ClearSessionSelection('paymode');
			//ClearSessionSelection('leavesded');
			ClearSessionSelection('cddno');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Name selected values

	if (is_array(@$_SESSION["sel_Salary_Report_name"])) {
		LoadSelectionFromSession('name');
	} elseif (@$_SESSION["sel_Salary_Report_name"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_name"] = "";
	}

	// Get Totalsal selected values
	if (is_array(@$_SESSION["sel_Salary_Report_totalsal"])) {
		LoadSelectionFromSession('totalsal');
	} elseif (@$_SESSION["sel_Salary_Report_totalsal"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_totalsal"] = "";
	}

	// Get Advdeduction selected values
	if (is_array(@$_SESSION["sel_Salary_Report_advdeduction"])) {
		LoadSelectionFromSession('advdeduction');
	} elseif (@$_SESSION["sel_Salary_Report_advdeduction"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_advdeduction"] = "";
	}

	// Get Deduction selected values
	if (is_array(@$_SESSION["sel_Salary_Report_deduction"])) {
		LoadSelectionFromSession('deduction');
	} elseif (@$_SESSION["sel_Salary_Report_deduction"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_deduction"] = "";
	}

	// Get Pbonus selected values
	//if (is_array(@$_SESSION["sel_Salary_Report_pbonus"])) {
//		LoadSelectionFromSession('pbonus');
//	} elseif (@$_SESSION["sel_Salary_Report_pbonus"] == EW_REPORT_INIT_VALUE) { // Select all
//		$GLOBALS["sel_pbonus"] = "";
//	}
//
//	// Get Bonus selected values
//	if (is_array(@$_SESSION["sel_Salary_Report_bonus"])) {
//		LoadSelectionFromSession('bonus');
//	} elseif (@$_SESSION["sel_Salary_Report_bonus"] == EW_REPORT_INIT_VALUE) { // Select all
//		$GLOBALS["sel_bonus"] = "";
//	}

	// Get Ot selected values
	if (is_array(@$_SESSION["sel_Salary_Report_ot"])) {
		LoadSelectionFromSession('ot');
	} elseif (@$_SESSION["sel_Salary_Report_ot"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_ot"] = "";
	}

	// Get Paid selected values
	if (is_array(@$_SESSION["sel_Salary_Report_paid"])) {
		LoadSelectionFromSession('paid');
	} elseif (@$_SESSION["sel_Salary_Report_paid"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_paid"] = "";
	}

	// Get Paymode selected values
	if (is_array(@$_SESSION["sel_Salary_Report_paymode"])) {
		LoadSelectionFromSession('paymode');
	} elseif (@$_SESSION["sel_Salary_Report_paymode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_paymode"] = "";
	}

	// Get Leavesded selected values
	//if (is_array(@$_SESSION["sel_Salary_Report_leavesded"])) {
//		LoadSelectionFromSession('leavesded');
//	} elseif (@$_SESSION["sel_Salary_Report_leavesded"] == EW_REPORT_INIT_VALUE) { // Select all
//		$GLOBALS["sel_leavesded"] = "";
//	}

	// Get Cddno selected values
	if (is_array(@$_SESSION["sel_Salary_Report_cddno"])) {
		LoadSelectionFromSession('cddno');
	} elseif (@$_SESSION["sel_Salary_Report_cddno"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_cddno"] = "";
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
				$nDisplayGrps = 50; // Non-numeric, load default
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
			$nDisplayGrps = 50; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_Salary_Report_$parm"] = "";
	$_SESSION["rf_Salary_Report_$parm"] = "";
	$_SESSION["rt_Salary_Report_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Salary_Report_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Salary_Report_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Salary_Report_$parm"];
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

	// Field name
	// Setup your default values for the popup filter below, e.g.
	// $seld_name = array("val1", "val2");

	$GLOBALS["seld_name"] = "";
	$GLOBALS["sel_name"] =  $GLOBALS["seld_name"];

	// Field totalsal
	// Setup your default values for the popup filter below, e.g.
	// $seld_totalsal = array("val1", "val2");

	$GLOBALS["seld_totalsal"] = "";
	$GLOBALS["sel_totalsal"] =  $GLOBALS["seld_totalsal"];

	// Field advdeduction
	// Setup your default values for the popup filter below, e.g.
	// $seld_advdeduction = array("val1", "val2");

	$GLOBALS["seld_advdeduction"] = "";
	$GLOBALS["sel_advdeduction"] =  $GLOBALS["seld_advdeduction"];

	// Field deduction
	// Setup your default values for the popup filter below, e.g.
	// $seld_deduction = array("val1", "val2");

	$GLOBALS["seld_deduction"] = "";
	$GLOBALS["sel_deduction"] =  $GLOBALS["seld_deduction"];

	// Field pbonus
	// Setup your default values for the popup filter below, e.g.
	// $seld_pbonus = array("val1", "val2");

	//$GLOBALS["seld_pbonus"] = "";
//	$GLOBALS["sel_pbonus"] =  $GLOBALS["seld_pbonus"];

	// Field bonus
	// Setup your default values for the popup filter below, e.g.
	// $seld_bonus = array("val1", "val2");

	//$GLOBALS["seld_bonus"] = "";
//	$GLOBALS["sel_bonus"] =  $GLOBALS["seld_bonus"];

	// Field ot
	// Setup your default values for the popup filter below, e.g.
	// $seld_ot = array("val1", "val2");

	$GLOBALS["seld_ot"] = "";
	$GLOBALS["sel_ot"] =  $GLOBALS["seld_ot"];

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

	// Field leavesded
	// Setup your default values for the popup filter below, e.g.
	// $seld_leavesded = array("val1", "val2");

	//$GLOBALS["seld_leavesded"] = "";
//	$GLOBALS["sel_leavesded"] =  $GLOBALS["seld_leavesded"];

	// Field cddno
	// Setup your default values for the popup filter below, e.g.
	// $seld_cddno = array("val1", "val2");

	$GLOBALS["seld_cddno"] = "";
	$GLOBALS["sel_cddno"] =  $GLOBALS["seld_cddno"];
}

// Check if filter applied
function CheckFilter() {

	// Check name popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_name"], $GLOBALS["sel_name"]))
		return TRUE;

	// Check totalsal popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_totalsal"], $GLOBALS["sel_totalsal"]))
		return TRUE;

	// Check advdeduction popup filter
	if (!ewrpt_MatchedArray($GLOBALS["sel_advdeduction"], $GLOBALS["sel_advded"]))
		return TRUE;

	// Check deduction popup filter
	if (!ewrpt_MatchedArray($GLOBALS["sel_deduction"], $GLOBALS["sel_oded"]))
		return TRUE;

	// Check pbonus popup filter
	//if (!ewrpt_MatchedArray($GLOBALS["seld_pbonus"], $GLOBALS["sel_pbonus"]))
//		return TRUE;

	// Check bonus popup filter
	//if (!ewrpt_MatchedArray($GLOBALS["seld_bonus"], $GLOBALS["sel_bonus"]))
//		return TRUE;

	// Check ot popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_ot"], $GLOBALS["sel_incometax"]))
		return TRUE;

	// Check paid popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_paid"], $GLOBALS["sel_paid"]))
		return TRUE;

	// Check paymode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_paymode"], $GLOBALS["sel_paymode"]))
		return TRUE;

	// Check leavesded popup filter
	//if (!ewrpt_MatchedArray($GLOBALS["seld_leavesded"], $GLOBALS["sel_leavesded"]))
//		return TRUE;

	// Check cddno popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_cddno"], $GLOBALS["sel_cddno"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field name
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_name"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_name"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Name<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field totalsal
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_totalsal"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_totalsal"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Totalsal<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field advdeduction
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_advdeduction"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_advdeduction"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Advdeduction<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field deduction
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_deduction"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_deduction"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Deduction<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field pbonus
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_pbonus"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_pbonus"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Pbonus<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field bonus
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_bonus"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_bonus"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Bonus<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field ot
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_ot"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_ot"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Ot<br />";
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

	// Field leavesded
	//$sExtWrk = "";
//	$sWrk = "";
//	if (is_array($GLOBALS["sel_leavesded"]))
//		$sWrk = ewrpt_JoinArray($GLOBALS["sel_leavesded"], ", ", EW_REPORT_DATATYPE_NUMBER);
//	if ($sExtWrk <> "" || $sWrk <> "")
//		$sFilterList .= "Leavesded<br />";
//	if ($sExtWrk <> "")
//		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
//	if ($sWrk <> "")
//		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field cddno
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_cddno"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_cddno"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Cddno<br />";
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
	if (is_array($GLOBALS["sel_name"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_name"], "hr_salary_payment.name", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_name"]);
	}
	if (is_array($GLOBALS["sel_totalsal"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_totalsal"], "hr_salary_payment.totalsal", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_totalsal"]);
	}
	if (is_array($GLOBALS["sel_advdeduction"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_advdeduction"], "hr_salary_payment.advdeduction", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_advdeduction"]);
	}
	if (is_array($GLOBALS["sel_deduction"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_deduction"], "hr_salary_payment.deduction", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_deduction"]);
	}
	if (is_array($GLOBALS["sel_pbonus"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_pbonus"], "hr_salary_payment.pbonus", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_pbonus"]);
	}
	if (is_array($GLOBALS["sel_bonus"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_bonus"], "hr_salary_payment.bonus", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_bonus"]);
	}
	if (is_array($GLOBALS["sel_ot"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_ot"], "hr_salary_payment.ot", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_ot"]);
	}
	if (is_array($GLOBALS["sel_paid"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_paid"], "hr_salary_payment.paid", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_paid"]);
	}
	if (is_array($GLOBALS["sel_paymode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_paymode"], "hr_salary_payment.paymode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_paymode"]);
	}
	//if (is_array($GLOBALS["sel_leavesded"])) {
//		if ($sWrk <> "") $sWrk .= " AND ";
//		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_leavesded"], "hr_salary_payment.leavesded", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_leavesded"]);
//	}
	if (is_array($GLOBALS["sel_cddno"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_cddno"], "hr_salary_payment.cddno", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_cddno"]);
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
			$_SESSION["sort_Salary_Report_designation"] = "";
			$_SESSION["sort_Salary_Report_sector"] = "";
			$_SESSION["sort_Salary_Report_name"] = "";
			$_SESSION["sort_Salary_Report_totalsal"] = "";
			$_SESSION["sort_Salary_Report_advdeduction"] = "";
			$_SESSION["sort_Salary_Report_deduction"] = "";
			//$_SESSION["sort_Salary_Report_pbonus"] = "";
			//$_SESSION["sort_Salary_Report_bonus"] = "";
			$_SESSION["sort_Salary_Report_ot"] = "";
			$_SESSION["sort_Salary_Report_paid"] = "";
			$_SESSION["sort_Salary_Report_paymode"] = "";
		//	$_SESSION["sort_Salary_Report_leavesded"] = "";
			$_SESSION["sort_Salary_Report_cddno"] = "";
			$_SESSION["sort_Salary_Report_salparamid"] = "";
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
