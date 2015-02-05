<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
session_start();
ob_start();
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");$year = $_GET['year'];
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



$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

$genlink = "&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];

$month = $_GET['month'];
$fromdate =  "01" . "." . $month . "." . $_GET['year'];
$todate =  $days_in_month[$month-1] . "." . $month . "." . $_GET['year'];
$fd = date("Y-m-j",strtotime($fromdate));
$td = date("Y-m-j",strtotime($todate));

include "config.php";

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
define("EW_REPORT_TABLE_VAR", "NewSalaryReport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "NewSalaryReport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "NewSalaryReport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "NewSalaryReport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "NewSalaryReport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "NewSalaryReport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee Inner Join hr_salaryparameters On hr_employee.employeeid = hr_salaryparameters.eid";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_employee.sector, hr_employee.employeeid, hr_employee.name, hr_employee.designation, hr_employee.salary, hr_salaryparameters.pffix, hr_salaryparameters.ptaxfix FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $sc '$_GET[sector]' and hr_employee.name $nc '$_GET[empname]'";
$EW_REPORT_TABLE_SQL_GROUPBY = "hr_employee.sector, hr_employee.employeeid, hr_employee.name, hr_employee.designation, hr_employee.salary, hr_salaryparameters.pffix, hr_salaryparameters.ptaxfix";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hr_employee.sector ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "hr_employee.sector", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `sector` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hr_employee.salary) AS SUM_salary, SUM(hr_salaryparameters.pffix) AS SUM_pffix, SUM(hr_salaryparameters.ptaxfix) AS SUM_ptaxfix FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_sector = NULL; // Popup filter for sector
$af_employeeid = NULL; // Popup filter for employeeid
$af_name = NULL; // Popup filter for name
$af_designation = NULL; // Popup filter for designation
$af_salary = NULL; // Popup filter for salary
$af_pffix = NULL; // Popup filter for pffix
$af_ptaxfix = NULL; // Popup filter for ptaxfix
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
$nDisplayGrps = 200; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
?>
<?php

// Field variables
$x_sector = NULL;
$x_employeeid = NULL;
$x_name = NULL;
$x_designation = NULL;
$x_salary = NULL;
$x_pffix = NULL;
$x_ptaxfix = NULL;

// Group variables
$o_sector = NULL; $g_sector = NULL; $dg_sector = NULL; $t_sector = NULL; $ft_sector = 201; $gf_sector = $ft_sector; $gb_sector = ""; $gi_sector = "0"; $gq_sector = ""; $rf_sector = NULL; $rt_sector = NULL;

// Detail variables
$o_employeeid = NULL; $t_employeeid = NULL; $ft_employeeid = 201; $rf_employeeid = NULL; $rt_employeeid = NULL;
$o_name = NULL; $t_name = NULL; $ft_name = 201; $rf_name = NULL; $rt_name = NULL;
$o_designation = NULL; $t_designation = NULL; $ft_designation = 201; $rf_designation = NULL; $rt_designation = NULL;
$o_salary = NULL; $t_salary = NULL; $ft_salary = 5; $rf_salary = NULL; $rt_salary = NULL;
$o_pffix = NULL; $t_pffix = NULL; $ft_pffix = 5; $rf_pffix = NULL; $rt_pffix = NULL;
$o_ptaxfix = NULL; $t_ptaxfix = NULL; $ft_ptaxfix = 5; $rf_ptaxfix = NULL; $rt_ptaxfix = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 7;
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
$col = array(FALSE, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);

// Set up groups per page dynamically
SetUpDisplayGrps();

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

// No filter
$bFilterApplied = FALSE;

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
</script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<center><strong>Salary Report for <?php echo $montharr[$month-1]; ?>, <?php echo $year; ?> </strong></center>
<br/>
<?php
 $query1 = "SELECT * FROM common_useraccess where username= '$userlogged' ORDER BY username ASC ";
           $result1 = mysql_query($query1,$conn); 
           while($row11 = mysql_fetch_assoc($result1))
           {
		   $currencyunits = $row11['currencyunit'];
           }
		   if($currencyunits == "")
{
$currencyunits = "Rs";
}
?>
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
&nbsp;&nbsp;<a href="SalaryNewReportsmry.php?export=html<?php echo $genlink; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="SalaryNewReportsmry.php?export=excel<?php echo $genlink; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="SalaryNewReportsmry.php?export=word<?php echo $genlink; ?>">Export to Word</a>
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
<div id="report_summary" align="center">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="NewSalaryReportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->FirstButton->Start; echo $genlink; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->PrevButton->Start;echo $genlink; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->NextButton->Start;echo $genlink; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->LastButton->Start;echo $genlink; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" disabled="disabled" onChange="this.form.submit();" class="phpreportmaker">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="200">200</option>
<option value="ALL" selected="selected">All</option>
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
		Sector
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sector</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Emp ID
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Emp Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if($pa1[0] == '1') { ?>
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
<?php } } ?>

<?php if($pa1[1] == '1') { ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Designation
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Designation</td>
			</tr></table>
		</td>
<?php } } ?>
<td valign="bottom" class="ewTableHeader" title="No. of Days">
		N.O.D
		</td>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Salary
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Salary</td>
			</tr></table>
		</td>
<?php } ?>
<td valign="bottom" class="ewTableHeader">
		Net Salary
		</td>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Provident Fund">
		P.F
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Provident Fund">P.F</td>
			</tr></table>
		</td>
<?php } ?>		
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Professional Tax">
		P.T
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Professional Tax">P.T</td>
			</tr></table>
		</td>
<?php } ?>
		<td valign="bottom" class="ewTableHeader">
		Mess
		</td>
		<?php 
		
		if(($_GET['sector'] == "Integration") || ($_GET['sector'] == "Hatchery") || ($_GET['sector'] == "Breeding Farm") || ($_GET['sector'] == "All") )
		{
		?>
		<td valign="bottom" class="ewTableHeader">
		Culls
		</td>
		<?php } ?>
		
		<td valign="bottom" class="ewTableHeader">
		Advance
		</td>
		<td valign="bottom" class="ewTableHeader">
		Total Deduction
		</td>
		<td valign="bottom" class="ewTableHeader">
		Balance
		</td>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_sector, EW_REPORT_DATATYPE_MEMO);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_sector, EW_REPORT_DATATYPE_MEMO, $gb_sector, $gi_sector, $gq_sector);
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
		$dg_sector = $x_sector;
		if ((is_null($x_sector) && is_null($o_sector)) ||
			(($x_sector <> "" && $o_sector == $dg_sector) && !ChkLvlBreak(1))) {
			$dg_sector = "&nbsp;";
		} elseif (is_null($x_sector)) {
			$dg_sector = EW_REPORT_NULL_LABEL;
		} elseif ($x_sector == "") {
			$dg_sector = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td class="ewRptGrpField1">
		<?php $t_sector = $x_sector; $x_sector = $dg_sector; ?>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_sector)); ?>
		<?php $x_sector = $t_sector; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_employeeid)); ?>
</td>
<?php if($pa1[0] == '1') { ?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_name)); ?>
</td>
<?php } ?>
<?php if($pa1[1] == '1') { ?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_designation)); ?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?> align="right">
	<?php 
		$q1 = "select * from hr_attendance where eid = '$x_employeeid' and month1 = '$_GET[month]' and year1 = '$_GET[year]' ";
		$q1rs = mysql_query($q1,$conn1) or die(mysql_error());
		$pres = 0;
		while($q1r = mysql_fetch_assoc($q1rs))
		{
		if($q1r['daytype'] == "Full")
		$pres++;
		else
		$pres +=0.5;
		}
		echo $pres;
	?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_salary) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php $netsal = round((($x_salary/($days_in_month[$month-1]))*$pres),0); 
	  if($pres == $days_in_month[$month-1])
	  $netsal = $x_salary;
	  $sectornetsalary+=$netsal;
	  echo $netsal; 
?>
</td>

		<td<?php echo $sItemRowClass; ?>  align="right">
<?php echo ewrpt_ViewValue($x_pffix); $sectorpf+= $x_pffix; ?>
</td>
		<td<?php echo $sItemRowClass; ?>  align="right">
<?php echo ewrpt_ViewValue($x_ptaxfix); $sectorpt+= $x_ptaxfix; ?>
</td>
		<td<?php echo $sItemRowClass; ?>  align="right">
	<?php 
		$mess =0;
		$q3 = "select * from expenses where eid = '$x_employeeid' and exp <> 'Advance' and month1 = '$_GET[month]' and year1 = '$_GET[year]' and flag = '0' ";
		$q3rs = mysql_query($q3,$conn1);
		while($q3r = mysql_fetch_assoc($q3rs))
		{
			$mess = $mess + $q3r['amount'];
		}
		$sectormess+=$mess;
		echo $mess;
	?>
</td>
		<?php 
		if(($_GET['sector'] == "Integration") || ($_GET['sector'] == "Hatchery") || ($_GET['sector'] == "Breeding Farm") || ($_GET['sector'] == "All"))
		{
		?>
	
		<td<?php echo $sItemRowClass; ?>  align="right">
	<?php 
		$culls = 0;
		$qsector = "select sector,employeeid from hr_employee where employeeid = '$x_employeeid'";
		$qsectorrs = mysql_query($qsector,$conn1) or die(mysql_error());
		while($qsectorr = mysql_fetch_assoc($qsectorrs))
		{
			$sector = $qsectorr['sector'];
		}
	 if(($sector == "Integration") || ($sector == "Hatchery") || ($sector == "Breeding Farm") )
	 {
		$q4 = "select * from broiler_birdsale where type = 'employee' and farm = '$x_name'";
		$q4rs = mysql_query($q4,$conn1) or die(mysql_error());
		while($q4r = mysql_fetch_assoc($q4rs))
		{
			if(( $q4r['date'] <= $td ) && ( $q4r['date'] >= $fd ))
			$culls+= $q4r['birds'];
			
		}
		
		$q5 = "select * from sales where party = '$x_name'";
		$q5rs = mysql_query($q5,$conn1) or die(mysql_error());
		while($q5r = mysql_fetch_assoc($q5rs))
		{
			if(( $q5r['date'] <= $td ) && ( $q5r['date'] >= $fd ))
			$culls+= ($q5r['fbirds'] + $q5r['mbirds']);
		}
		
	}
	echo $culls;
	$sectorculls+=$culls;
	?>
</td>
<?php } ?>
		<td<?php echo $sItemRowClass; ?>  align="right">
	<?php 
		$q2 = "select sum(amount) as adv from expenses where eid = '$x_employeeid' and flag = '0' and exp = 'Advance'";
		$q2rs = mysql_query($q2,$conn1) or die(mysql_error());
		if($q2r = mysql_fetch_assoc($q2rs))
		{
			if($q2r['adv'] == 0)
			$adv = 0;
			else
			$adv = $q2r['adv'];
			echo $adv;
		}
		$sectoradv+=$adv;
	?>
</td>
		<td<?php echo $sItemRowClass; ?>  align="right">
<?php $totalded = $x_pffix + $x_ptaxfix + $mess + $culls + $adv; 
	  $sectortotalded+=$totalded;
	  echo $totalded;
?>
</td>
		<td<?php echo $sItemRowClass; ?>  align="right">
<?php echo ($netsal - $totalded); 
	  $sectorbal+=($netsal - $totalded); 
?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_sector = $x_sector;

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
		<td colspan="1" class="ewRptGrpSummary1">SUM</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php if($pa1[0] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa1[1] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_salary = $x_salary; ?>
		<?php $x_salary = $smry[1][4]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_salary); $totalsalary+= $x_salary; ?>
		<?php $x_salary = $t_salary; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectornetsalary; $totalnetsalary+=$sectornetsalary; $sectornetsalary = 0; ?></td>
		<td class="ewRptGrpSummary1" align="right">
		<?php echo $sectorpf; $totalpf+=$sectorpf; $sectorpf = 0; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right">
		<?php echo $sectorpt; $totalpt+=$sectorpt; $sectorpt = 0; ?>
		</td>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectormess; $totalmess+=$sectormess; $sectormess = 0; ?></td>
			<?php	if(($_GET['sector'] == "Integration") || ($_GET['sector'] == "Hatchery") || ($_GET['sector'] == "Breeding Farm") || ($_GET['sector'] == "All") )
		{
		?>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectorculls; $totalculls+=$sectorculls; $sectorculls = 0; ?></td>
		<?php } ?>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectoradv; $totaladv+=$sectoradv; $sectoradv = 0; ?></td>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectortotalded; $totaltotalded+=$sectortotalded; $sectortotalded = 0; ?></td>
		<td class="ewRptGrpSummary1" align="right"><?php echo $sectorbal; $totalbal+=$sectorbal; $sectorbal = 0; ?></td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_sector = $x_sector; // Save old group value
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
		$grandsmry[4] = $rsagg->fields("SUM_salary");
		$grandsmry[5] = $rsagg->fields("SUM_pffix");
		$grandsmry[6] = $rsagg->fields("SUM_ptaxfix");
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
	<!-- tr><td colspan="7"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->

	<tr class="ewRptGrandSummary">
		<td colspan="1" class="ewRptGrpAggregate">GRAND SUM</td>
		<td>&nbsp;</td>
		<?php if($pa1[0] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa1[1] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<td>&nbsp;</td>
		<td align="right">
<?php echo $totalsalary; ?>
		</td>
		<td align="right"><?php echo $totalnetsalary; ?></td>
		<td align="right">
<?php echo $totalpf; ?>
		</td>
		<td align="right">
<?php echo $totalpt; ?>
		</td>
		<td align="right"><?php echo $totalmess; ?></td>
		<?php 		if(($_GET['sector'] == "Integration") || ($_GET['sector'] == "Hatchery") || ($_GET['sector'] == "Breeding Farm") || ($_GET['sector'] == "All") )
		{
		?>
		<td align="right"><?php echo $totalculls; ?></td>
		<?php } ?>
		<td align="right"><?php echo $totaladv; ?></td>
		<td align="right"><?php echo $totaltotalded; ?></td>
		<td align="right"><?php echo $totalbal; ?></td>

	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="NewSalaryReportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->FirstButton->Start;?> <?php echo $genlink;?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->PrevButton->Start; echo $genlink; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->NextButton->Start;echo $genlink; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="NewSalaryReportsmry.php?start=<?php echo $Pager->LastButton->Start;echo $genlink; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<select name="<?php echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>" disabled="disabled" onChange="this.form.submit();" class="phpreportmaker">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="20">20</option>
<option value="50">50</option>
<option value="200">200</option>
<option value="ALL" selected="selected">All</option></select>
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
			return (is_null($GLOBALS["x_sector"]) && !is_null($GLOBALS["o_sector"])) ||
				(!is_null($GLOBALS["x_sector"]) && is_null($GLOBALS["o_sector"])) ||
				($GLOBALS["x_sector"] <> $GLOBALS["o_sector"]);
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
	if ($lvl <= 1) $GLOBALS["o_sector"] = "";

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
		$GLOBALS['x_sector'] = "";
	} else {
		$GLOBALS['x_sector'] = $rsgrp->fields('sector');
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
		$GLOBALS['x_employeeid'] = $rs->fields('employeeid');
		$GLOBALS['x_name'] = $rs->fields('name');
		$GLOBALS['x_designation'] = $rs->fields('designation');
		$GLOBALS['x_salary'] = $rs->fields('salary');
		$GLOBALS['x_pffix'] = $rs->fields('pffix');
		$GLOBALS['x_ptaxfix'] = $rs->fields('ptaxfix');
		$val[1] = $GLOBALS['x_employeeid'];
		$val[2] = $GLOBALS['x_name'];
		$val[3] = $GLOBALS['x_designation'];
		$val[4] = $GLOBALS['x_salary'];
		$val[5] = $GLOBALS['x_pffix'];
		$val[6] = $GLOBALS['x_ptaxfix'];
	} else {
		$GLOBALS['x_employeeid'] = "";
		$GLOBALS['x_name'] = "";
		$GLOBALS['x_designation'] = "";
		$GLOBALS['x_salary'] = "";
		$GLOBALS['x_pffix'] = "";
		$GLOBALS['x_ptaxfix'] = "";
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
			ResetPager();
		}
	}

	// Load selection criteria to array
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
				$nDisplayGrps = 200; // Non-numeric, load default
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
			$nDisplayGrps = 200; // Load default
		}
	}
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
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
			$_SESSION["sort_NewSalaryReport_sector"] = "";
			$_SESSION["sort_NewSalaryReport_employeeid"] = "";
			$_SESSION["sort_NewSalaryReport_name"] = "";
			$_SESSION["sort_NewSalaryReport_designation"] = "";
			$_SESSION["sort_NewSalaryReport_salary"] = "";
			$_SESSION["sort_NewSalaryReport_pffix"] = "";
			$_SESSION["sort_NewSalaryReport_ptaxfix"] = "";
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
