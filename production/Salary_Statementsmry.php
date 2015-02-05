
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
//$noofwrkdays = $days_in_month[$month-1];
$dateq =  $cyear ."-". $month . "-" . $days_in_month[$month-1];

include "config.php";
$qtt ="SELECT noofdays  FROM `hr_workingdays` where month='$month' and year='$cyear'";
 $qttr = mysql_query($qtt,$conn1) or die(mysql_error());
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $noofwrkdays = $qttrs['noofdays'];
	  }

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

<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Report for <?php echo $montharr[$month-1]; ?>, <?php echo $cyear; ?></font></strong></td>
</tr>

</table>
<?php


// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Salary_Statement", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Salary_Statement_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Salary_Statement_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Salary_Statement_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Salary_Statement_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Salary_Statement_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee Inner Join hr_payment On hr_employee.employeeid = hr_payment.eid Inner Join hr_salaryparameters On hr_salaryparameters.eid = hr_payment.eid";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_employee.name, hr_employee.sector, hr_salaryparameters.bfix, hr_salaryparameters.compallowance, hr_salaryparameters.hrafix, hr_salaryparameters.tafix, hr_salaryparameters.kitallowance, hr_salaryparameters.dressmaintain, hr_salaryparameters.travelexpense, hr_salaryparameters.pffix, hr_salaryparameters.ptaxfix, hr_salaryparameters.esic, hr_salaryparameters.finalsal, hr_payment.paymode, hr_salaryparameters.eid FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $sc '$_GET[sector]' and hr_employee.name $nc '$_GET[empname]' and hr_payment.month1='$month' and  hr_payment.year1 = '$cyear' and hr_salaryparameters.fromdate <= '$dateq' and hr_salaryparameters.todate >= '$dateq'";
//$EW_REPORT_TABLE_SQL_GROUPBY = "hr_employee.sector, hr_employee.employeeid, hr_employee.name, hr_employee.designation, hr_employee.salary"; and hr_salaryparameters.fromdate <= '$dateq' hr_salaryparameters.todate >= '$dateq'
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hr_employee.sector";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hr_salaryparameters.bfix) AS SUM_bfix, SUM(hr_salaryparameters.compallowance) AS SUM_compallowance, SUM(hr_salaryparameters.hrafix) AS SUM_hrafix, SUM(hr_salaryparameters.tafix) AS SUM_tafix, SUM(hr_salaryparameters.kitallowance) AS SUM_kitallowance, SUM(hr_salaryparameters.dressmaintain) AS SUM_dressmaintain, SUM(hr_salaryparameters.travelexpense) AS SUM_travelexpense, SUM(hr_salaryparameters.pffix) AS SUM_pffix, SUM(hr_salaryparameters.ptaxfix) AS SUM_ptaxfix, SUM(hr_salaryparameters.esic) AS SUM_esic, SUM(hr_salaryparameters.finalsal) AS SUM_finalsal FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_name = NULL; // Popup filter for name
$af_sector = NULL; // Popup filter for sector
$af_bfix = NULL; // Popup filter for bfix
$af_compallowance = NULL; // Popup filter for compallowance
$af_hrafix = NULL; // Popup filter for hrafix
$af_tafix = NULL; // Popup filter for tafix
$af_kitallowance = NULL; // Popup filter for kitallowance
$af_dressmaintain = NULL; // Popup filter for dressmaintain
$af_travelexpense = NULL; // Popup filter for travelexpense
$af_pffix = NULL; // Popup filter for pffix
$af_ptaxfix = NULL; // Popup filter for ptaxfix
$af_esic = NULL; // Popup filter for esic
$af_finalsal = NULL; // Popup filter for finalsal
$af_paymode = NULL; // Popup filter for paymode
$af_eid = NULL; // Popup filter for eid
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
$EW_REPORT_FIELD_PAYMODE_SQL_SELECT = "SELECT DISTINCT hr_payment.paymode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_PAYMODE_SQL_ORDERBY = "hr_payment.paymode";
?>
<?php

// Field variables
$x_name = NULL;
$x_sector = NULL;
$x_bfix = NULL;
$x_compallowance = NULL;
$x_hrafix = NULL;
$x_tafix = NULL;
$x_kitallowance = NULL;
$x_dressmaintain = NULL;
$x_travelexpense = NULL;
$x_pffix = NULL;
$x_ptaxfix = NULL;
$x_esic = NULL;
$x_finalsal = NULL;
$x_paymode = NULL;
$x_eid = NULL;

// Detail variables
$o_name = NULL; $t_name = NULL; $ft_name = 201; $rf_name = NULL; $rt_name = NULL;
$o_sector = NULL; $t_sector = NULL; $ft_sector = 201; $rf_sector = NULL; $rt_sector = NULL;
$o_bfix = NULL; $t_bfix = NULL; $ft_bfix = 5; $rf_bfix = NULL; $rt_bfix = NULL;
$o_compallowance = NULL; $t_compallowance = NULL; $ft_compallowance = 5; $rf_compallowance = NULL; $rt_compallowance = NULL;
$o_hrafix = NULL; $t_hrafix = NULL; $ft_hrafix = 5; $rf_hrafix = NULL; $rt_hrafix = NULL;
$o_tafix = NULL; $t_tafix = NULL; $ft_tafix = 5; $rf_tafix = NULL; $rt_tafix = NULL;
$o_kitallowance = NULL; $t_kitallowance = NULL; $ft_kitallowance = 5; $rf_kitallowance = NULL; $rt_kitallowance = NULL;
$o_dressmaintain = NULL; $t_dressmaintain = NULL; $ft_dressmaintain = 5; $rf_dressmaintain = NULL; $rt_dressmaintain = NULL;
$o_travelexpense = NULL; $t_travelexpense = NULL; $ft_travelexpense = 5; $rf_travelexpense = NULL; $rt_travelexpense = NULL;
$o_pffix = NULL; $t_pffix = NULL; $ft_pffix = 5; $rf_pffix = NULL; $rt_pffix = NULL;
$o_ptaxfix = NULL; $t_ptaxfix = NULL; $ft_ptaxfix = 5; $rf_ptaxfix = NULL; $rt_ptaxfix = NULL;
$o_esic = NULL; $t_esic = NULL; $ft_esic = 5; $rf_esic = NULL; $rt_esic = NULL;
$o_finalsal = NULL; $t_finalsal = NULL; $ft_finalsal = 5; $rf_finalsal = NULL; $rt_finalsal = NULL;
$o_paymode = NULL; $t_paymode = NULL; $ft_paymode = 200; $rf_paymode = NULL; $rt_paymode = NULL;
$o_eid = NULL; $t_eid = NULL; $ft_eid = 3; $rf_eid = NULL; $rt_eid = NULL;
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
$col = array(FALSE, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, TRUE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_finalsal = "";
$seld_finalsal = "";
$val_finalsal = "";
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
ewrpt_CreatePopup("Salary_Statement_finalsal", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_paymode, $sel_paymode, $ft_paymode) ?>
ewrpt_CreatePopup("Salary_Statement_paymode", [<?php echo $jsdata ?>]);
</script>
<div id="Salary_Statement_finalsal_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Salary_Statement_paymode_Popup" class="ewPopup">
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

<?php if (@$sExport == "") { 
$genlinkm = "&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
?>
&nbsp;&nbsp;<a href="Salary_Statementsmry.php<?php echo $genlinkm; ?>&export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="Salary_Statementsmry.php<?php echo $genlinkm; ?>&export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="Salary_Statementsmry.php<?php echo $genlinkm; ?>&export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Salary_Statementsmry.php<?php echo $genlinkm; ?>&cmd=reset">Reset All Filters</a>
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
		SI. No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>SI. No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Station
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Station</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Days Present">
		Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Days Present"><tr>
			<td>Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Basic (Incl D.A.)">
		Basic
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Basic (Incl D.A.)"><tr>
			<td>Basic</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Comp Allowance">
		Comp <br/>Allow.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Comp Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Comp <br/>Allow.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		H R A
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>H R A</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Transportation Allowance">
		Transp<br/> Allow
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Transportation Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Transp<br/> Allow</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Kit Allowance">
		Kit<br/> Allow.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Kit Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Kit<br/> Allow.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Dress Maintain/Wash Allowance">
		Dress<br/> Allow.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Dress Maintain/Wash Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"  ><tr>
			<td>Dress<br/> Allow.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Travel Expense">
		Travel<br/> expen.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Travel Expense">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td >Travel<br/> expn.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Total without deductions">
		<b>Total</b>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Total without deductions">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td><b>Total</b></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Provident Fund">
		P.F.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Provident Fund">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>P.F.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Professional Tax">   
		Prof.<br/> Tax.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Professional Tax">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Prof.<br/> Tax.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		ESIC
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>ESIC</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Total Deductions">
		<b>Total</b>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Total Deductions">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><b>Total</b></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Net Payable Amount">
		<b>Net<br/> Amount</b>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Net Payable Amount">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><b>Net<br/> Amount</b></td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Salary_Statement_finalsal', true, '<?php echo $rf_finalsal; ?>', '<?php echo $rt_finalsal; ?>');return false;" name="x_finalsal<?php echo $cnt[0][0]; ?>" id="x_finalsal<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Terms
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Terms</td>
			<td style="width: 20px;" align="right"><a href="#" onClick="ewrpt_ShowPopup(this.name, 'Salary_Statement_paymode', false, '<?php echo $rf_paymode; ?>', '<?php echo $rt_paymode; ?>');return false;" name="x_paymode<?php echo $cnt[0][0]; ?>" id="x_paymode<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a></td>
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
		<td><?php $sino++;echo $sino;?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_name)); ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_sector)); ?>
</td>
<?php

 include "config.php";
$days = 0;
$qtt ="SELECT dayspresent,workingdays  FROM `hr_mnthattendance` where employeename = '$x_name' and sector='$x_sector' and month='$month' and year='$cyear'";
 $qttr = mysql_query($qtt,$conn1) or die(mysql_error());
	  if($qttrs = mysql_fetch_assoc($qttr))
	  {
	  $days = $qttrs['dayspresent'];
	  }
	  if($days == "0")
	  {
	  $ddays = $noofwrkdays;
	  }
	  else
	  {
	  $ddays = $days;
	  }
?>
<td<?php echo $sItemRowClass; ?>><b><?php echo $ddays;?></b></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_bfix) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_compallowance) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_hrafix) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_tafix) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_kitallowance) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_dressmaintain) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_travelexpense) ?>
</td>
		<td<?php echo $sItemRowClass; ?>><b>
<?php echo ewrpt_ViewValue($x_bfix + $x_compallowance + $x_hrafix + $x_tafix + $x_kitallowance + $x_dressmaintain + $x_travelexpense) ?></b>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_pffix) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_ptaxfix) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ceil($x_esic)) ?>
</td>
	<td<?php echo $sItemRowClass; ?>><b>
<?php echo ewrpt_ViewValue($x_pffix + $x_ptaxfix + $x_esic) ?></b>
</td>
		<td<?php echo $sItemRowClass; ?>><b>
<?php echo ewrpt_ViewValue(round($x_finalsal)) ?></b>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_paymode) ?>
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
		$grandsmry[3] = $rsagg->fields("SUM_bfix");
		$grandsmry[4] = $rsagg->fields("SUM_compallowance");
		$grandsmry[5] = $rsagg->fields("SUM_hrafix");
		$grandsmry[6] = $rsagg->fields("SUM_tafix");
		$grandsmry[7] = $rsagg->fields("SUM_kitallowance");
		$grandsmry[8] = $rsagg->fields("SUM_dressmaintain");
		$grandsmry[9] = $rsagg->fields("SUM_travelexpense");
		$grandsmry[10] = $rsagg->fields("SUM_pffix");
		$grandsmry[11] = $rsagg->fields("SUM_ptaxfix");
		$grandsmry[12] = $rsagg->fields("SUM_esic");
		$grandsmry[13] = $rsagg->fields("SUM_finalsal");
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
	<!-- tr><td colspan="16"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="18">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td>&nbsp;</td>
		<td colspan="1" class="ewRptGrpAggregate">Total(Rs.)</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td style=" font-weight:bold">
		<?php $t_bfix = $x_bfix; ?>
		<?php $x_bfix = $grandsmry[3]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_bfix) ?>
		<?php $x_bfix = $t_bfix; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_compallowance = $x_compallowance; ?>
		<?php $x_compallowance = $grandsmry[4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_compallowance) ?>
		<?php $x_compallowance = $t_compallowance; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_hrafix = $x_hrafix; ?>
		<?php $x_hrafix = $grandsmry[5]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_hrafix) ?>
		<?php $x_hrafix = $t_hrafix; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_tafix = $x_tafix; ?>
		<?php $x_tafix = $grandsmry[6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_tafix) ?>
		<?php $x_tafix = $t_tafix; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_kitallowance = $x_kitallowance; ?>
		<?php $x_kitallowance = $grandsmry[7]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_kitallowance) ?>
		<?php $x_kitallowance = $t_kitallowance; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_dressmaintain = $x_dressmaintain; ?>
		<?php $x_dressmaintain = $grandsmry[8]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_dressmaintain) ?>
		<?php $x_dressmaintain = $t_dressmaintain; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_travelexpense = $x_travelexpense; ?>
		<?php $x_travelexpense = $grandsmry[9]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_travelexpense) ?>
		<?php $x_travelexpense = $t_travelexpense; ?>
		</td>
		<td style=" font-weight:bold"><?php $tot1 = $grandsmry[3] + $grandsmry[4]+ $grandsmry[5]+ $grandsmry[6]+ $grandsmry[7] + $grandsmry[8]+ $grandsmry[9];?>
<?php echo ewrpt_ViewValue($tot1) ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_pffix = $x_pffix; ?>
		<?php $x_pffix = $grandsmry[10]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_pffix) ?>
		<?php $x_pffix = $t_pffix; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_ptaxfix = $x_ptaxfix; ?>
		<?php $x_ptaxfix = $grandsmry[11]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_ptaxfix) ?>
		<?php $x_ptaxfix = $t_ptaxfix; ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_esic = $x_esic; ?>
		<?php $x_esic = $grandsmry[12]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_esic) ?>
		<?php $x_esic = $t_esic; ?>
		</td>
		<td style=" font-weight:bold"><?php $tot2 = $grandsmry[10] + $grandsmry[11]+ $grandsmry[12];?>
<?php echo ewrpt_ViewValue($tot2) ?>
		</td>
		<td style=" font-weight:bold">
		<?php $t_finalsal = $x_finalsal; ?>
		<?php $x_finalsal = $grandsmry[13]; // Load SUM ?>
<?php echo ewrpt_ViewValue(round($x_finalsal)) ?>
		<?php $x_finalsal = $t_finalsal; ?>
		</td>
		<td>&nbsp;</td>
		
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="Salary_Statementsmry.php?<?php echo $genlinkm; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Salary_Statementsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Salary_Statementsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Salary_Statementsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Salary_Statementsmry.php?<?php echo $genlinkm; ?>&start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		$GLOBALS['x_name'] = $rs->fields('name');
		$GLOBALS['x_sector'] = $rs->fields('sector');
		$GLOBALS['x_bfix'] = $rs->fields('bfix');
		$GLOBALS['x_compallowance'] = $rs->fields('compallowance');
		$GLOBALS['x_hrafix'] = $rs->fields('hrafix');
		$GLOBALS['x_tafix'] = $rs->fields('tafix');
		$GLOBALS['x_kitallowance'] = $rs->fields('kitallowance');
		$GLOBALS['x_dressmaintain'] = $rs->fields('dressmaintain');
		$GLOBALS['x_travelexpense'] = $rs->fields('travelexpense');
		$GLOBALS['x_pffix'] = $rs->fields('pffix');
		$GLOBALS['x_ptaxfix'] = $rs->fields('ptaxfix');
		$GLOBALS['x_esic'] = $rs->fields('esic');
		$GLOBALS['x_finalsal'] = $rs->fields('finalsal');
		$GLOBALS['x_paymode'] = $rs->fields('paymode');
		$GLOBALS['x_eid'] = $rs->fields('eid');
		$val[1] = $GLOBALS['x_name'];
		$val[2] = $GLOBALS['x_sector'];
		$val[3] = $GLOBALS['x_bfix'];
		$val[4] = $GLOBALS['x_compallowance'];
		$val[5] = $GLOBALS['x_hrafix'];
		$val[6] = $GLOBALS['x_tafix'];
		$val[7] = $GLOBALS['x_kitallowance'];
		$val[8] = $GLOBALS['x_dressmaintain'];
		$val[9] = $GLOBALS['x_travelexpense'];
		$val[10] = $GLOBALS['x_pffix'];
		$val[11] = $GLOBALS['x_ptaxfix'];
		$val[12] = $GLOBALS['x_esic'];
		$val[13] = $GLOBALS['x_finalsal'];
		$val[14] = $GLOBALS['x_paymode'];
		$val[15] = $GLOBALS['x_eid'];
	} else {
		$GLOBALS['x_name'] = "";
		$GLOBALS['x_sector'] = "";
		$GLOBALS['x_bfix'] = "";
		$GLOBALS['x_compallowance'] = "";
		$GLOBALS['x_hrafix'] = "";
		$GLOBALS['x_tafix'] = "";
		$GLOBALS['x_kitallowance'] = "";
		$GLOBALS['x_dressmaintain'] = "";
		$GLOBALS['x_travelexpense'] = "";
		$GLOBALS['x_pffix'] = "";
		$GLOBALS['x_ptaxfix'] = "";
		$GLOBALS['x_esic'] = "";
		$GLOBALS['x_finalsal'] = "";
		$GLOBALS['x_paymode'] = "";
		$GLOBALS['x_eid'] = "";
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
			ClearSessionSelection('paymode');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Finalsal selected values

	if (is_array(@$_SESSION["sel_Salary_Statement_finalsal"])) {
		LoadSelectionFromSession('finalsal');
	} elseif (@$_SESSION["sel_Salary_Statement_finalsal"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_finalsal"] = "";
	}

	// Get Paymode selected values
	if (is_array(@$_SESSION["sel_Salary_Statement_paymode"])) {
		LoadSelectionFromSession('paymode');
	} elseif (@$_SESSION["sel_Salary_Statement_paymode"] == EW_REPORT_INIT_VALUE) { // Select all
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
	$_SESSION["sel_Salary_Statement_$parm"] = "";
	$_SESSION["rf_Salary_Statement_$parm"] = "";
	$_SESSION["rt_Salary_Statement_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Salary_Statement_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Salary_Statement_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Salary_Statement_$parm"];
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

	// Check for a resetsort command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if ($sCmd == "resetsort") {
			$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "";
			$_SESSION[EW_REPORT_TABLE_SESSION_START_GROUP] = 1;
			$_SESSION["sort_Salary_Statement_name"] = "";
			$_SESSION["sort_Salary_Statement_sector"] = "";
			$_SESSION["sort_Salary_Statement_bfix"] = "";
			$_SESSION["sort_Salary_Statement_compallowance"] = "";
			$_SESSION["sort_Salary_Statement_hrafix"] = "";
			$_SESSION["sort_Salary_Statement_tafix"] = "";
			$_SESSION["sort_Salary_Statement_kitallowance"] = "";
			$_SESSION["sort_Salary_Statement_dressmaintain"] = "";
			$_SESSION["sort_Salary_Statement_travelexpense"] = "";
			$_SESSION["sort_Salary_Statement_pffix"] = "";
			$_SESSION["sort_Salary_Statement_ptaxfix"] = "";
			$_SESSION["sort_Salary_Statement_esic"] = "";
			$_SESSION["sort_Salary_Statement_finalsal"] = "";
			$_SESSION["sort_Salary_Statement_paymode"] = "";
			$_SESSION["sort_Salary_Statement_eid"] = "";
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
