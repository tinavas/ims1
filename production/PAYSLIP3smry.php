<?php
session_start();
$currencyunits=$_SESSION['currency'];
ob_start();
include "reportheader.php";
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");$totexp = 0; 
$totl = 0;
include "config.php";


$genlink = "&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];

define('GLF',"m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector']);

$name = $_GET['empname'];
$sector = $_GET['sector'];
$month = $_GET['month'];
$year = $_GET['year'];
$m = $_GET['m'];
$para = split(",",$m);

$n = $_GET['n'];
$para1 = split(",",$n);

$dpara = array('ba','hra','ma','cca','ta','sa','c','ea','oa','pf','pt','it','lr','od');
$dpara1 = array('en','d','p');

$pa = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0');
$pa1 = array('0','0','0');



for($i=1;$i < sizeof($para);$i++)
{
	for( $j=0; $j < sizeof($dpara); $j++ )
	{
		if($dpara[$j] == $para[$i])
		{
		$pa[$j] = '1';
		}
		
	}
}


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
define("EW_REPORT_TABLE_VAR", "PAYSLIP3", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "PAYSLIP3_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "PAYSLIP3_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "PAYSLIP3_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "PAYSLIP3_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "PAYSLIP3_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee Inner Join hr_salaryparameters On hr_employee.employeeid = hr_salaryparameters.eid";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_employee.sector As SECTOR, hr_employee.employeeid As ID, hr_employee.name As NAME, hr_employee.designation As DESIG, hr_salaryparameters.month1 As MON, hr_salaryparameters.year1 As YEAR, hr_salaryparameters.salary As SALARY, hr_salaryparameters.bfix As BA, hr_salaryparameters.hrafix As HRA, hr_salaryparameters.mafix As MA, hr_salaryparameters.ccafix As CCA, hr_salaryparameters.tafix As TA, hr_salaryparameters.sallowancefix As SA, hr_salaryparameters.conveyancefix As C, hr_salaryparameters.eallowancefix As EA, hr_salaryparameters.oallowancefix As OA, hr_salaryparameters.pffix As PF, hr_salaryparameters.ptaxfix As PT, hr_salaryparameters.incometaxfix As IT, hr_salaryparameters.loanfix As LR, hr_salaryparameters.otherfix As OD, hr_salaryparameters.finalsal As FINALSAL FROM " . $EW_REPORT_TABLE_SQL_FROM;

if(($sector == "All"))
$sc = '<>';
else if(($sector !="All"))
$sc ='=';

if(($name == "All"))
$nc = '<>';
else if(($name !="All"))
$nc ='=';

if(($month == "All"))
$mc = '<>';
else if(($month !="All"))
$mc ='=';

if(($year == "All"))
$yc = '<>';
else if(($year !="All"))
$yc ='=';

$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $sc '$sector' and hr_employee.name $nc '$name' ";
#and hr_salaryparameters.month1 $mc '$month' and hr_salaryparameters.year1 $yc '$year'
$EW_REPORT_TABLE_SQL_GROUPBY = "hr_employee.sector, hr_employee.id, hr_employee.name, hr_employee.designation, hr_salaryparameters.month1, hr_salaryparameters.year1, hr_salaryparameters.salary, hr_salaryparameters.bfix, hr_salaryparameters.hrafix, hr_salaryparameters.mafix, hr_salaryparameters.ccafix, hr_salaryparameters.tafix, hr_salaryparameters.sallowancefix, hr_salaryparameters.conveyancefix, hr_salaryparameters.eallowancefix, hr_salaryparameters.oallowancefix, hr_salaryparameters.pffix, hr_salaryparameters.ptaxfix, hr_salaryparameters.incometaxfix, hr_salaryparameters.loanfix, hr_salaryparameters.otherfix, hr_salaryparameters.finalsal";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "hr_employee.sector, hr_employee.name ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "hr_employee.sector", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `SECTOR` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(hr_salaryparameters.salary) AS SUM_SALARY, SUM(hr_salaryparameters.finalsal) AS SUM_FINALSAL FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_SECTOR = NULL; // Popup filter for SECTOR
$af_ID = NULL; // Popup filter for ID
$af_NAME = NULL; // Popup filter for NAME
$af_DESIG = NULL; // Popup filter for DESIG
$af_MON = NULL; // Popup filter for MON
$af_YEAR = NULL; // Popup filter for YEAR
$af_SALARY = NULL; // Popup filter for SALARY
$af_BA = NULL; // Popup filter for BA
$af_HRA = NULL; // Popup filter for HRA
$af_MA = NULL; // Popup filter for MA
$af_CCA = NULL; // Popup filter for CCA
$af_TA = NULL; // Popup filter for TA
$af_SA = NULL; // Popup filter for SA
$af_C = NULL; // Popup filter for C
$af_EA = NULL; // Popup filter for EA
$af_OA = NULL; // Popup filter for OA
$af_PF = NULL; // Popup filter for PF
$af_PT = NULL; // Popup filter for PT
$af_IT = NULL; // Popup filter for IT
$af_LR = NULL; // Popup filter for LR
$af_OD = NULL; // Popup filter for OD
$af_FINALSAL = NULL; // Popup filter for FINALSAL
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
$nDisplayGrps = 5; // Groups per page
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
$x_SECTOR = NULL;
$x_ID = NULL;
$x_NAME = NULL;
$x_DESIG = NULL;
$x_MON = NULL;
$x_YEAR = NULL;
$x_SALARY = NULL;
$x_BA = NULL;
$x_HRA = NULL;
$x_MA = NULL;
$x_CCA = NULL;
$x_TA = NULL;
$x_SA = NULL;
$x_C = NULL;
$x_EA = NULL;
$x_OA = NULL;
$x_PF = NULL;
$x_PT = NULL;
$x_IT = NULL;
$x_LR = NULL;
$x_OD = NULL;
$x_FINALSAL = NULL;

// Group variables
$o_SECTOR = NULL; $g_SECTOR = NULL; $dg_SECTOR = NULL; $t_SECTOR = NULL; $ft_SECTOR = 201; $gf_SECTOR = $ft_SECTOR; $gb_SECTOR = ""; $gi_SECTOR = "0"; $gq_SECTOR = ""; $rf_SECTOR = NULL; $rt_SECTOR = NULL;

// Detail variables
$o_ID = NULL; $t_ID = NULL; $ft_ID = 3; $rf_ID = NULL; $rt_ID = NULL;
$o_NAME = NULL; $t_NAME = NULL; $ft_NAME = 201; $rf_NAME = NULL; $rt_NAME = NULL;
$o_DESIG = NULL; $t_DESIG = NULL; $ft_DESIG = 201; $rf_DESIG = NULL; $rt_DESIG = NULL;
$o_MON = NULL; $t_MON = NULL; $ft_MON = 200; $rf_MON = NULL; $rt_MON = NULL;
$o_YEAR = NULL; $t_YEAR = NULL; $ft_YEAR = 200; $rf_YEAR = NULL; $rt_YEAR = NULL;
$o_SALARY = NULL; $t_SALARY = NULL; $ft_SALARY = 5; $rf_SALARY = NULL; $rt_SALARY = NULL;
$o_BA = NULL; $t_BA = NULL; $ft_BA = 5; $rf_BA = NULL; $rt_BA = NULL;
$o_HRA = NULL; $t_HRA = NULL; $ft_HRA = 5; $rf_HRA = NULL; $rt_HRA = NULL;
$o_MA = NULL; $t_MA = NULL; $ft_MA = 5; $rf_MA = NULL; $rt_MA = NULL;
$o_CCA = NULL; $t_CCA = NULL; $ft_CCA = 5; $rf_CCA = NULL; $rt_CCA = NULL;
$o_TA = NULL; $t_TA = NULL; $ft_TA = 5; $rf_TA = NULL; $rt_TA = NULL;
$o_SA = NULL; $t_SA = NULL; $ft_SA = 5; $rf_SA = NULL; $rt_SA = NULL;
$o_C = NULL; $t_C = NULL; $ft_C = 5; $rf_C = NULL; $rt_C = NULL;
$o_EA = NULL; $t_EA = NULL; $ft_EA = 5; $rf_EA = NULL; $rt_EA = NULL;
$o_OA = NULL; $t_OA = NULL; $ft_OA = 5; $rf_OA = NULL; $rt_OA = NULL;
$o_PF = NULL; $t_PF = NULL; $ft_PF = 5; $rf_PF = NULL; $rt_PF = NULL;
$o_PT = NULL; $t_PT = NULL; $ft_PT = 5; $rf_PT = NULL; $rt_PT = NULL;
$o_IT = NULL; $t_IT = NULL; $ft_IT = 5; $rf_IT = NULL; $rt_IT = NULL;
$o_LR = NULL; $t_LR = NULL; $ft_LR = 5; $rf_LR = NULL; $rt_LR = NULL;
$o_OD = NULL; $t_OD = NULL; $ft_OD = 5; $rf_OD = NULL; $rt_OD = NULL;
$o_FINALSAL = NULL; $t_FINALSAL = NULL; $ft_FINALSAL = 5; $rf_FINALSAL = NULL; $rt_FINALSAL = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 22;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);

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
</script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table align="center"  id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<?php if($_GET['month'] == "All" && $_GET['year'] == "All") { ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Parameters Report</font></strong></td>
</tr>
</table>
<br/>
<?php } else if($_GET['month'] != "All" && $_GET['year'] == "All") { ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Parameters Report for <?php echo $montharr[$_GET['month']-1]; ?></font></strong></td>
</tr>
</table>
<br/>
<?php } else if($_GET['month'] == "All" && $_GET['year'] != "All") { ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Parameters Report for <?php echo $_GET['year']; ?>m</font></strong></td>
</tr>
</table>
<br/>
<?php } else if($_GET['month'] != "All" && $_GET['year'] != "All") { ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Salary Parameters Report for <?php echo $montharr[$_GET['month']-1]; ?>, <?php echo $_GET['year']; ?></font></strong></td>
</tr>
</table>
<br/>
<?php } ?>

<?php if (@$sExport == "") { 
$htmllink = "PAYSLIP3smry.php?export=html&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$excellink = "PAYSLIP3smry.php?export=excel&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$wordlink = "PAYSLIP3smry.php?export=word&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
?>
<br />
&nbsp;&nbsp;<a href="<?php echo $htmllink; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="<?php echo $excellink; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="<?php echo $wordlink; ?>">Export to Word</a>
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
<table align="center"  class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="" name="pagerform" id="pagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->FirstButton->Start; echo $genlink; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->PrevButton->Start; echo $genlink; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo GLF; echo '&'; ?>pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->NextButton->Start; echo $genlink; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->LastButton->Start; echo $genlink; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		</span></td>
<?php } ?>

<td>
&nbsp;&nbsp; <h3><i>Place your mouse pointer on Field head to know the abbreviation.</i> </h3>
</td>

</table>



</form>
</div>
<?php } 

else
{?>


<div class="ewGridUpperPanel">
<form action="" name="pagerform" id="pagerform" class="ewForm">

<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="attendancesmry.php?start=<?php echo $Pager->FirstButton->Start; echo $genlink; ?>">&nbsp;</a></td>
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="attendancesmry.php?start=<?php echo $Pager->PrevButton->Start; echo $genlink; ?>">&nbsp;</a></td>
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>
<!--current page number-->
	<td>&nbsp;</td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="attendancesmry.php?start=<?php echo $Pager->NextButton->Start; echo $genlink; ?>">&nbsp;</a></td>	
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="attendancesmry.php?start=<?php echo $Pager->LastButton->Start; echo $genlink; ?>">&nbsp;</a></td>	
	<?php } else { ?>
	<td>&nbsp;</td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp; </span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"> &nbsp;</span>
<?php } else { ?>
	<?php if ($sFilter == "0=101") { ?>
	<span class="phpreportmaker">&nbsp;</span>
	<?php } else { ?>
	<span class="phpreportmaker">&nbsp;</span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($nTotalGrps > 0) { ?>
		
            <td nowrap style="padding-left:10px"><b>BA</b> - Basic Allowance</td>
            <td nowrap style="padding-left:10px"><b>HRA</b> - HR Allowance</td>
			<td nowrap style="padding-left:10px"><b>MA</b> - Medical Allowance</td>
            <td nowrap style="padding-left:10px"><b>CCA</b> - City Compensation Allowance</td>  
            <td nowrap style="padding-left:10px"><b>TA</b> - Travelling Allowance</td> 
            <td nowrap style="padding-left:10px"><b>SA</b> - Special Allowance</td>
			<td nowrap style="padding-left:10px"><b>C</b> - Conveyance</td> 
            <td nowrap style="padding-left:10px"><b>EA</b> - Education Allowance</td>
			<td nowrap style="padding-left:10px"><b>OA</b> - Other Allowance</td>
			<td nowrap style="padding-left:10px"><b>PF</b> - Provident Fund</td> 
			<td nowrap style="padding-left:10px"><b>PT</b> - Professional Tax</td> 
			<td nowrap style="padding-left:10px"><b>IT</b> - Income Tax</td>
			<td nowrap style="padding-left:10px"><b>LR</b> - Loan Repayments</td>
			<td nowrap style="padding-left:10px"><b>OD</b> - Other Deductions</td> 
            <td nowrap style="padding-left:10px"><b>TS</b> - Total Salary</td>
			<td nowrap style="padding-left:10px"><b>Exp</b> - Expenses</td>
			<td nowrap style="padding-left:10px"><b>LS</b> - Leave Salary</td>

<!--
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
-->
<?php } ?>
	</tr>
</table>
</form>
</div><?php 
}




?>
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
		<td valign="bottom" class="ewRptGrpHeader1" title="This is Sector" align="center">
		&nbsp;SECTOR&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Sector to which employee belongs" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;SECTOR&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Employee ID" align="center">
		&nbsp;ID&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Employee ID">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;ID&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>

<?php if($pa1[0] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Employee Name" align="center">
		&nbsp;NAME&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Employee Name">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;NAME&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php if($pa1[1] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Employee Designation" align="center">
		DESIGNATION&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Employee Designation">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;DESIGNATION&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Employee Salary" align="center">
		&nbsp;SALARY&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Employee Salary">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;SALARY&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>

<?php if($pa[0] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Basic Allowance" align="center">
		&nbsp;BA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Basic Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;BA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[1] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="HR Allowance" align="center">
		&nbsp;HRA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="HR Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;HRA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[2] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Medical Allowance" align="center">
		&nbsp;MA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Medical Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;MA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[3] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="City Compensation Allowance" align="center">
		&nbsp;CCA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="City Compensation Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;CCA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[4] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Travelling Allowance" align="center">
		&nbsp;TA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Travelling Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;TA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[5] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Special Allowance" align="center">
		&nbsp;SA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Special Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;SA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[6] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Conveyance" align="center">
		&nbsp;C&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Conveyancee">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;C&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[7] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Education Allowance" align="center">
		&nbsp;EA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Education Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;EA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[8] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Other Allowance" align="center">
		&nbsp;OA&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Other Allowance">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;OA&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[9] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Provident Fund" align="center">
		&nbsp;PF&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Provident Fund">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;PF&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[10] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Professional Tax" align="center">
		&nbsp;PT&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Professional Tax">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;PT&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[11] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Income Tax" align="center">
		&nbsp;IT&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Income Tax">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;IT&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[12] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Loan Repayment" align="center">
		&nbsp;LR&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Loan Replayment">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;LR&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if($pa[13] == '1') { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Other Deductions" align="center">
		&nbsp;OD&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Other Deductions">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;OD&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Total Salary" align="center">
		&nbsp;TS&nbsp;
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="Total Salary">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">&nbsp;TS&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<td valign="bottom" class="ewTableHeader" title="Expenses" align="center">
		&nbsp;Exp&nbsp;
		</td>
<td valign="bottom" class="ewTableHeader" title="Leave Salary" align="center">
		&nbsp;LS&nbsp;
		</td>
		
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_SECTOR, EW_REPORT_DATATYPE_MEMO);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_SECTOR, EW_REPORT_DATATYPE_MEMO, $gb_SECTOR, $gi_SECTOR, $gq_SECTOR);
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
		$dg_SECTOR = $x_SECTOR;
		if ((is_null($x_SECTOR) && is_null($o_SECTOR)) ||
			(($x_SECTOR <> "" && $o_SECTOR == $dg_SECTOR) && !ChkLvlBreak(1))) {
			$dg_SECTOR = "&nbsp;";
		} elseif (is_null($x_SECTOR)) {
			$dg_SECTOR = EW_REPORT_NULL_LABEL;
		} elseif ($x_SECTOR == "") {
			$dg_SECTOR = EW_REPORT_EMPTY_LABEL;
		}
?>

	<tr>
		<td class="ewRptGrpField1">
		<?php $t_SECTOR = $x_SECTOR; $x_SECTOR = $dg_SECTOR; ?>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_SECTOR)); ?>
		<?php $x_SECTOR = $t_SECTOR; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_ID) ?>
</td>
<?php if($pa1[0] == '1') { ?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_NAME)); ?>
</td>
<?php } ?>

<?php if($pa1[1] == '1') { ?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_DESIG)); ?>
</td>
<?php } ?>


		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_SALARY) ?>
</td>
<?php if($pa[0] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_BA) ?>
</td>
<?php } ?>
<?php if($pa[1] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_HRA) ?>
</td>
<?php } ?>
<?php if($pa[2] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_MA) ?>
</td>
<?php } ?>
<?php if($pa[3] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_CCA) ?>
</td>
<?php } ?>
<?php if($pa[4] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_TA) ?>
</td>
<?php } ?>
<?php if($pa[5] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_SA) ?>
</td>
<?php } ?>
<?php if($pa[6] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_C) ?>
</td>
<?php } ?>
<?php if($pa[7] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_EA) ?>
</td>
<?php } ?>
<?php if($pa[8] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_OA) ?>
</td>
<?php } ?>
<?php if($pa[9] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_PF) ?>
</td>
<?php } ?>
<?php if($pa[10] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_PT) ?>
</td>
<?php } ?>
<?php if($pa[11] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_IT) ?>
</td>
<?php } ?>
<?php if($pa[12] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_LR) ?>
</td>
<?php } ?>
<?php if($pa[13] == '1') { ?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_OD) ?>
</td>
<?php } ?>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_FINALSAL) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">0
<?php 
/*
if($_GET['month'] == "All")
$mc = "<>";
else
$mc = "=";
if($_GET['year'] == "All")
$yc = "<>";
else
$yc = "=";

$expq = "select month1,flag,sum(amount) as tot from expenses where eid = '$x_ID' and flag = '0' and month1 $mc '".$_GET['month']."' and year1 $yc '".$_GET['year']."'";
$exprs = mysql_query($expq,$conn1) or die(mysql_error());

while($expr = mysql_fetch_assoc($exprs))
{
if($expr['tot'] == 0)
echo 0;
else
echo $expr['tot'];
if($expr['tot'] != 0)
$totexp = ($totexp + $expr['tot']);
}*/
?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php
$ls = 0; 
$lsq = "select sum(leavesal) as ltot from hr_leaves where empid = '$x_ID' and flag <> '1' ";
$lsrs = mysql_query($lsq,$conn1) or die(mysql_error());
if($lsr = mysql_fetch_assoc($lsrs))
$ls = $lsr['ltot'];

if($ls == "")
$ls = 0;

echo $ls;

$totl = ($totl + $lsr['ltot']);


?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_SECTOR = $x_SECTOR;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
?>
	<!-- <tr>
		<td colspan="22" class="ewRptGrpSummary1">Summary for Sector: <?php $t_SECTOR = $x_SECTOR; $x_SECTOR = $o_SECTOR; ?>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_SECTOR)); ?>
<?php $x_SECTOR = $t_SECTOR; ?> (<?php echo ewrpt_FormatNumber($cnt[1][0],0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr> -->
		<td colspan="1" class="ewRptGrpSummary1">SUM</td>
	
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php if($pa1[0] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa1[1] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_SALARY = $x_SALARY; ?>
		<?php $x_SALARY = $smry[1][6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_SALARY) ?>
		<?php $x_SALARY = $t_SALARY; ?>
		</td>
		
		<?php if($pa[0] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[1] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[2] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[3] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[4] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[5] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[6] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[7] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[8] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[9] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[10] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[11] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[12] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		<?php if($pa[13] == '1') { ?>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<?php } ?>
		
		<td class="ewRptGrpSummary1" align="right">
		<?php $t_FINALSAL = $x_FINALSAL; ?>
		<?php $x_FINALSAL = $smry[1][21]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_FINALSAL) ?>
		<?php $x_FINALSAL = $t_FINALSAL; ?>
		</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
	</tr>
<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_SECTOR = $x_SECTOR; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php if (intval(@$cnt[0][21]) > 0) { ?>
	<!-- <tr class="ewRptPageSummary"><td colspan="22">Page Total (<?php echo ewrpt_FormatNumber($cnt[0][21],0,-2,-2,-2); ?> Detail Records)</td></tr> -->
	<tr class="ewRptPageSummary">
		<td colspan="1" class="ewRptGrpAggregate">GRAND SUM</td>

	<?php if($pa1[0] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa1[1] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<td>&nbsp;</td>
		<td align="right">
		<?php $t_SALARY = $x_SALARY; ?>
		<?php $x_SALARY = $smry[0][6]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_SALARY) ?>
		<?php $x_SALARY = $t_SALARY ?>
		</td>
	<?php if($pa[0] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[1] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[2] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[3] == '1') { ?>
		<td >&nbsp;</td>
		<?php } ?>
		<?php if($pa[4] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[5] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[6] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[7] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[8] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[9] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[10] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[11] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[12] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<?php if($pa[13] == '1') { ?>
		<td>&nbsp;</td>
		<?php } ?>
		<td align="right">
		<?php $t_FINALSAL = $x_FINALSAL; ?>
		<?php $x_FINALSAL = $smry[0][21]; // Load SUM ?>
<?php echo ewrpt_ViewValue($x_FINALSAL) ?>
		<?php $x_FINALSAL = $t_FINALSAL ?>
		</td>
		
		<td align="right"><?php echo $totexp; ?></td>
		<td align="right"><?php echo $totl; ?></td>		
		
	</tr>
	<!-- tr class="ewRptPageSummary"><td colspan="22"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
<?php } ?>
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
		$grandsmry[6] = $rsagg->fields("SUM_SALARY");
		$grandsmry[21] = $rsagg->fields("SUM_FINALSAL");
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
	<!-- tr><td colspan="22"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<!--<tr class="ewRptGrandSummary"><td colspan="22">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary">
		<td colspan="1" class="ewRptGrpAggregate">SUM</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_SALARY = $x_SALARY; ?>
		<?php $x_SALARY = $grandsmry[6]; // Load SUM ?>
<?php #echo ewrpt_ViewValue($x_SALARY) ?>
		<?php $x_SALARY = $t_SALARY; ?>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_FINALSAL = $x_FINALSAL; ?>
		<?php $x_FINALSAL = $grandsmry[21]; // Load SUM ?>
<?php #echo ewrpt_ViewValue($x_FINALSAL) ?>
		<?php $x_FINALSAL = $t_FINALSAL; ?>
		</td>
	</tr> -->
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="" name="pagerform1" id="pagerform1" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->FirstButton->Start; echo $genlink; ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->PrevButton->Start; echo $genlink; ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->NextButton->Start; echo $genlink; ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="PAYSLIP3smry.php?start=<?php echo $Pager->LastButton->Start; echo $genlink; ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_SECTOR"]) && !is_null($GLOBALS["o_SECTOR"])) ||
				(!is_null($GLOBALS["x_SECTOR"]) && is_null($GLOBALS["o_SECTOR"])) ||
				($GLOBALS["x_SECTOR"] <> $GLOBALS["o_SECTOR"]);
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
	if ($lvl <= 1) $GLOBALS["o_SECTOR"] = "";

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
		$GLOBALS['x_SECTOR'] = "";
	} else {
		$GLOBALS['x_SECTOR'] = $rsgrp->fields('SECTOR');
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
		$GLOBALS['x_ID'] = $rs->fields('ID');
		$GLOBALS['x_NAME'] = $rs->fields('NAME');
		$GLOBALS['x_DESIG'] = $rs->fields('DESIG');
		$GLOBALS['x_MON'] = $rs->fields('MON');
		$GLOBALS['x_YEAR'] = $rs->fields('YEAR');
		$GLOBALS['x_SALARY'] = $rs->fields('SALARY');
		$GLOBALS['x_BA'] = $rs->fields('BA');
		$GLOBALS['x_HRA'] = $rs->fields('HRA');
		$GLOBALS['x_MA'] = $rs->fields('MA');
		$GLOBALS['x_CCA'] = $rs->fields('CCA');
		$GLOBALS['x_TA'] = $rs->fields('TA');
		$GLOBALS['x_SA'] = $rs->fields('SA');
		$GLOBALS['x_C'] = $rs->fields('C');
		$GLOBALS['x_EA'] = $rs->fields('EA');
		$GLOBALS['x_OA'] = $rs->fields('OA');
		$GLOBALS['x_PF'] = $rs->fields('PF');
		$GLOBALS['x_PT'] = $rs->fields('PT');
		$GLOBALS['x_IT'] = $rs->fields('IT');
		$GLOBALS['x_LR'] = $rs->fields('LR');
		$GLOBALS['x_OD'] = $rs->fields('OD');
		$GLOBALS['x_FINALSAL'] = $rs->fields('FINALSAL');
		$val[1] = $GLOBALS['x_ID'];
		$val[2] = $GLOBALS['x_NAME'];
		$val[3] = $GLOBALS['x_DESIG'];
		$val[4] = $GLOBALS['x_MON'];
		$val[5] = $GLOBALS['x_YEAR'];
		$val[6] = $GLOBALS['x_SALARY'];
		$val[7] = $GLOBALS['x_BA'];
		$val[8] = $GLOBALS['x_HRA'];
		$val[9] = $GLOBALS['x_MA'];
		$val[10] = $GLOBALS['x_CCA'];
		$val[11] = $GLOBALS['x_TA'];
		$val[12] = $GLOBALS['x_SA'];
		$val[13] = $GLOBALS['x_C'];
		$val[14] = $GLOBALS['x_EA'];
		$val[15] = $GLOBALS['x_OA'];
		$val[16] = $GLOBALS['x_PF'];
		$val[17] = $GLOBALS['x_PT'];
		$val[18] = $GLOBALS['x_IT'];
		$val[19] = $GLOBALS['x_LR'];
		$val[20] = $GLOBALS['x_OD'];
		$val[21] = $GLOBALS['x_FINALSAL'];
	} else {
		$GLOBALS['x_ID'] = "";
		$GLOBALS['x_NAME'] = "";
		$GLOBALS['x_DESIG'] = "";
		$GLOBALS['x_MON'] = "";
		$GLOBALS['x_YEAR'] = "";
		$GLOBALS['x_SALARY'] = "";
		$GLOBALS['x_BA'] = "";
		$GLOBALS['x_HRA'] = "";
		$GLOBALS['x_MA'] = "";
		$GLOBALS['x_CCA'] = "";
		$GLOBALS['x_TA'] = "";
		$GLOBALS['x_SA'] = "";
		$GLOBALS['x_C'] = "";
		$GLOBALS['x_EA'] = "";
		$GLOBALS['x_OA'] = "";
		$GLOBALS['x_PF'] = "";
		$GLOBALS['x_PT'] = "";
		$GLOBALS['x_IT'] = "";
		$GLOBALS['x_LR'] = "";
		$GLOBALS['x_OD'] = "";
		$GLOBALS['x_FINALSAL'] = "";
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
				$nDisplayGrps = 5; // Non-numeric, load default
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
			$nDisplayGrps = 5; // Load default
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
			$_SESSION["sort_PAYSLIP3_SECTOR"] = "";
			$_SESSION["sort_PAYSLIP3_ID"] = "";
			$_SESSION["sort_PAYSLIP3_NAME"] = "";
			$_SESSION["sort_PAYSLIP3_DESIG"] = "";
			$_SESSION["sort_PAYSLIP3_MON"] = "";
			$_SESSION["sort_PAYSLIP3_YEAR"] = "";
			$_SESSION["sort_PAYSLIP3_SALARY"] = "";
			$_SESSION["sort_PAYSLIP3_BA"] = "";
			$_SESSION["sort_PAYSLIP3_HRA"] = "";
			$_SESSION["sort_PAYSLIP3_MA"] = "";
			$_SESSION["sort_PAYSLIP3_CCA"] = "";
			$_SESSION["sort_PAYSLIP3_TA"] = "";
			$_SESSION["sort_PAYSLIP3_SA"] = "";
			$_SESSION["sort_PAYSLIP3_C"] = "";
			$_SESSION["sort_PAYSLIP3_EA"] = "";
			$_SESSION["sort_PAYSLIP3_OA"] = "";
			$_SESSION["sort_PAYSLIP3_PF"] = "";
			$_SESSION["sort_PAYSLIP3_PT"] = "";
			$_SESSION["sort_PAYSLIP3_IT"] = "";
			$_SESSION["sort_PAYSLIP3_LR"] = "";
			$_SESSION["sort_PAYSLIP3_OD"] = "";
			$_SESSION["sort_PAYSLIP3_FINALSAL"] = "";
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
<script type="text/javascript">
function setaction()
{
//var x = "<?php echo GLF; ?>";
//alert(x);
//alert("We r in action");
//document.getElementById("pagerform").action = "<?php #echo GLF; ?>";
//document.getElementById("pagerform").submit();
//alert("Submitted");
}
</script>
<?php #echo EW_REPORT_TABLE_GROUP_PER_PAGE; ?>