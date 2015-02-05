<!-- <?php 
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
<?php } ?> -->


<?php

session_start();
ob_start();
$client = $_SESSION['client'];
include "config.php";
$unit = $_GET['unit'];
$cull = $_GET['cull'];
if($unit == 'All')
{
$cond = "in (select distinct(unitcode) from breeder_unit where client = '$client')";
}
else
{
$cond = "=".""."'".$unit."'";
}

if($_GET['weeks'] <> "")
 $weeks = $_GET['weeks'];
else
 $weeks = "0";
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
include "../getemployee.php";
?>
<?php include "reportheader.php"; ?>

<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Breeder Future Production Analysis<br/> For Weeks : <?php echo $weeks;?></font></strong></td>
</tr>
</table>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

if($currencyunits == "")
{
    $currencyunits = "Rs";
	if($_SESSION[db] == "alkhumasiyabrd")
     	$currencyunits = "SR";
}
 if($_SESSION['client'] == 'KEHINDE')
{?><center><p style="padding-left:430px;color:red"> All amounts in ?</p></center>
<?php }else{?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits;?></p></center>
<?php } ?>
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
$EW_REPORT_TABLE_SQL_FROM = "`ac_financialpostings`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT count(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "client = '$client'";
$EW_REPORT_TABLE_SQL_GROUPBY = "$cond";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`date` ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`type`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `type` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
$af_type = NULL; // Popup filter for type
$af_controltype = NULL; // Popup filter for controltype
$af_schedule = NULL; // Popup filter for schedule
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
$nDisplayGrps = 20; // Groups per page
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
$x_id = NULL;
$x_code = NULL;
$x_description = NULL;
$x_type = NULL;
$x_controltype = NULL;
$x_schedule = NULL;
$x_flag = NULL;
$x_tflag = NULL;

// Group variables
$o_type = NULL; $g_type = NULL; $dg_type = NULL; $t_type = NULL; $ft_type = 200; $gf_type = $ft_type; $gb_type = ""; $gi_type = "0"; $gq_type = ""; $rf_type = NULL; $rt_type = NULL;
$o_schedule = NULL; $g_schedule = NULL; $dg_schedule = NULL; $t_schedule = NULL; $ft_schedule = 200; $gf_schedule = $ft_schedule; $gb_schedule = ""; $gi_schedule = "0"; $gq_schedule = ""; $rf_schedule = NULL; $rt_schedule = NULL;
$o_controltype = NULL; $g_controltype = NULL; $dg_controltype = NULL; $t_controltype = NULL; $ft_controltype = 200; $gf_controltype = $ft_controltype; $gb_controltype = ""; $gi_controltype = "0"; $gq_controltype = ""; $rf_controltype = NULL; $rt_controltype = NULL;

// Detail variables
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 3;
$nGrps = 4;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE);

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
<table id="ewContainer" align="center" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="futureplanning.php?export=html&weeks=<?php echo $weeks;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="futureplanning.php?export=excel&weeks=<?php echo $weeks;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="futureplanning.php?export=word&weeks=<?php echo $weeks;?>">Export to Word</a>

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
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>


<div class="ewGridUpperPanel">
<form action="Report1smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>

 <td>Number of Weeks</td>
 <td><input type="text" id="weeks" name="weeks" value="<?php echo $weeks; ?>" onkeyup="reloadpage();" /></td>
 
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
	<span class="phpreportmaker"></span>
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

$bShowFirstHeader = true;
while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	
	<tr>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Shed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Shed</td>
			</tr></table>
		</td>
<?php } ?>	
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center" colspan="2">Birds</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="3" align="center">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center" colspan="3">Production</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Feed Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center" colspan="2">Feed Consumption</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Production Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Production Cost</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	<tr>
	
	
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center"></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center"></td>
			</tr></table>
		</td>
<?php } ?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Female</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Male</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Hatch Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Hatch Eggs</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Table Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Table Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Total Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Total Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Male</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center"></td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
		$dumma = 0;
		$dumma1 = 0;
		$dumm = 0;
		$dumm1 = 0;
		$dumm2 = 0;
		$j = "";
		$s = "";
		$k = "";
		$t = "";
		$q = "";
		$u[$shed] = 0;
		$temp = "";
		$d[$x]= 0;
		
	}
	$productioncost = 0;
	$cst = 0;
	$female = 0;
$q1 = "select * from breeder_flock where cullflag = '0' and unitcode $cond order by unitcode";
	$r1 = mysql_query($q1,$conn1) or die(mysql_error());
	while($qr1 = mysql_fetch_assoc($r1))
	{
$flock = $qr1['flockcode'];
$unit = $qr1['unitcode'];
$shed = $qr1['shedcode'];
$breed = $qr1['breed'];

$q2 = "select * from breeder_flock where flockcode = '$flock' and unitcode $cond and client = '$client' and shedcode = '$shed' order by shedcode";
$r2 = mysql_query($q2,$conn1);
while($qr2 = mysql_fetch_assoc($r2))
{
$flo = $qr2['flockcode'];
$female = $qr2['femaleopening'];
$male = $qr2['maleopening'];
$fg = $qr2['age'];
$ageflock = floor($qr2['age']/7);
}
$fage = 0;
$q2 = "select max(age) as age from breeder_consumption where flock = '$flock'";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
if($qr2 = mysql_fetch_assoc($r2))
{

$fage = ceil($qr2['age']/7);
if($fage == " ")
{
$fage = $ageflock;
$age1 = $fg%7;
$age2 = $fage.".".$age1;
$tage = $fage + $weeks;
}
else
{
 $age1 = $qr2['age']%7;
 $age2 = $fage.".".$age1;
$tage = $fage + $weeks;
}
}
//echo $tage."/".$cull;
$maximumage = $cull;
if($tage > $maximumage)
{
$mage_array[$j] = $shed;
$tage = $maximumage;
$j++;
}
else
{
$flock_array[$s] = $shed;
$f_array[$q] = $flock;
$tage = $tage;
$s++;
$q++;
}


$q3 = "select * from breeder_standards where (age = '$fage' || age = '$tage') and client = '$client' order by age";
$r3 = mysql_query($q3,$conn1) or die(mysql_error());
while($qr3 = mysql_fetch_assoc($r3))
{
$age = $qr3['age'];
$cumhhp[ $age] = $qr3['cumhhp'];
$cumhhe[$age] = $qr3['cumhhe'];
}

$cffeed = 0;
$cmfeed = 0;

$q9 = "select * from breeder_standards where age > $fage and age <= $tage and breed = '$breed' and client = '$client'";
$r9 = mysql_query($q9,$conn1) or die(mysql_error());
while($qr9 = mysql_fetch_assoc($r9))
{
$cffeed = $cffeed + $qr9['cffeed'];
$cmfeed = $cmfeed + $qr9['cmfeed'];

}
//echo $cffeed;
$hhpdif =  $cumhhp[$tage] - $cumhhp[$fage];
$hhedif = $cumhhe[$tage] - $cumhhe[$fage];
//echo $cumhhe[$tage]."/".$hhedif."/".$cumhhe[$fage];

//echo $cummhhe[$toage]."/".$cumhhe[$fromage]."/".$hhedif;
 $minus = 0; 
$q4 = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$flock' and client = '$client'";
        $r4 = mysql_query($q4,$conn1);
	    while($qr4 = mysql_fetch_assoc($r4))
        {
	   $minus = $minus + $qr4['fmort'] + $qr4['fcull'];
	    }
//Inward
	 $q5 = "select sum(quantity) as trinbirds from ims_stocktransfer where towarehouse = '$flock' and cat = 'Female Birds' and client = '$client'";
        $r5 = mysql_query($q5,$conn1);
	    while($qr5 = mysql_fetch_assoc($r5))
        {
	      $transferin = $qr5['trinbirds'];
		 }
 //Outward
		$q6= "select sum(quantity) as troutbirds from ims_stocktransfer where fromwarehouse = '$flock' and cat = 'Female Birds' and client = '$client'";
        $r6 = mysql_query($q6,$conn1);
	    while($qr6 = mysql_fetch_assoc($r6))
        {
	      $transferout = $qr6['troutbirds'];
		 }
//Sale
		 $q7 = "select sum(quantity) as soldbirds from oc_cobi where flock = '$flock' and code in (select code from ims_itemcodes where cat = 'Female Birds') and client = '$client'";
        $r7 = mysql_query($q7,$conn1);
	    while($qr7 = mysql_fetch_assoc($r7))
        {
	      $soldbirds = $qr7['soldbirds'];
		}
		//Purchase
		 $q8 = "select sum(receivedquantity) as purchasebirds from pp_sobi where flock = '$flock' and code in (select code from ims_itemcodes where cat = 'Female Birds') and client = '$client'";
        $r8 = mysql_query($q8,$conn1);
	    while($qr8 = mysql_fetch_assoc($r8))
        {
	      $prchbirds = $qr8['purchasebirds'];
		}
//echo $female."/".$minus."/".$transferin."/".$transferout."/".$soldbirds."/".$prchbirds;
$birds = $female -  $minus + $transferin - $transferout - $soldbirds + $prchbirds;

///////////////For Mortality and Culls
 $minus = 0; 
$q4 = "select distinct(date2),mmort,mcull from breeder_consumption where flock = '$flock' and client = '$client'";
        $r4 = mysql_query($q4,$conn1);
	    while($qr4 = mysql_fetch_assoc($r4))
        {
	   $minus = $minus + $qr4['mmort'] + $qr4['mcull'];
	    }
//Inward
$transferin = 0;
	 $q5 = "select sum(quantity) as trinbirds from ims_stocktransfer where towarehouse = '$flock' and cat = 'Male Birds' and client = '$client'";
        $r5 = mysql_query($q5,$conn1);
	    while($qr5 = mysql_fetch_assoc($r5))
        {
	      $transferin = $qr5['trinbirds'];
		 }
 //Outward
 $transferout = 0;
		 $q6= "select sum(quantity) as troutbirds from ims_stocktransfer where fromwarehouse = '$flock' and cat = 'Male Birds' and client = '$client'";
        $r6 = mysql_query($q6,$conn1);
	    while($qr6 = mysql_fetch_assoc($r6))
        {
	      $transferout = $qr6['troutbirds'];
		 }
//Sale
$soldbirds = 0;
		 $q7 = "select sum(quantity) as soldbirds from oc_cobi where flock = '$flock' and code in (select code from ims_itemcodes where cat = 'Male Birds') and client = '$client'";
        $r7 = mysql_query($q7,$conn1);
	    while($qr7 = mysql_fetch_assoc($r7))
        {
	      $soldbirds = $qr7['soldbirds'];
		}
		//Purchase
		$prchbirds = 0;
		 $q8 = "select sum(receivedquantity) as purchasebirds from pp_sobi where flock = '$flock' and code in (select code from ims_itemcodes where cat = 'Male Birds') and client = '$client'";
        $r8 = mysql_query($q8,$conn1);
	    while($qr8 = mysql_fetch_assoc($r8))
        {
	      $prchbirds = $qr8['purchasebirds'];
		}
		//echo $male."/".$minus."/".$transferin."/".$transferout."/".$soldbirds."/".$prchbirds;
 $male = $male - $minus + $transferin - $transferout - $soldbirds + $prchbirds;
$feedcons = round((($cffeed * $birds)/1000),2);
$feedconsmale = round((($cmfeed * $male)/1000),2);
$totaleggs = round(($birds * $hhpdif),0);
$tp = round(($birds * $hhedif),0);
$tableeggs = round(($totaleggs - $tp),0);

$q10 = "select * from breeder_feedcodestandards where ((fromage <= $fage and toage >= $fage) or (fromage <= $tage and toage >= $tage) or (fromage >= $fage and toage <= $tage)) and fromage <> '>' and code in(select code from ims_itemcodes where cat = 'Female Feed') order by fromage";


$r10 = mysql_query($q10,$conn1) or die(mysql_error());
$n = mysql_num_rows($r10);
while($qr10 = mysql_fetch_assoc($r10))
{

$code = $qr10['code'];
 $desc = $qr10['description'];
$fromage = $qr10['fromage'];
$toage = $qr10['toage'];
$q11 = "select sum(ffeed) as ffeed from breeder_standards where (age between $fromage and $toage) and (age >= $fage and age <= $tage)";
$r11 = mysql_query($q11,$conn1) or die(mysql_error());
while($qr11 = mysql_fetch_assoc($r11))
{
 $feed = $qr11['ffeed'];
}
$query3 = "select * from feed_cost where code = '$code' and client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
while($qr3 = mysql_fetch_assoc($result3))
{
$costperkg[$feedtype] = $qr3['costperkg'];
$cst = $costperkg[$feedtype];
}
$a = $feedcons * $cst;
$b = $feedconsmale * $cst;
$mul = round(($a + $b),2);
}
$productioncost = $productioncost + $mul;
 
	 ?>
	 <?php 
$realage[$shed] = $age2;
$dif[$shed] = 0;
$hage = $fage + $weeks;
$f[$shed] = $hage;
$c[$shed] = $cull;
if($f[$shed] < $c[$shed])
{
$u[$shed] = $u[$shed] + $birds;
$mal[$shed] = $mal[$shed] + $male;

}
else
{
$x = $shed;
$dif[$x] = $f[$x] - $c[$x];
if($dif[$x] > $d[$x])
{
$d[$x]= $dif[$x];
}
else
{
$d[$x] = $d[$x];
}
}
$j++;
$k++;
$t++;
if($cull > $age2){
?>
    <tr>
	<td<?php echo $sItemRowClass; ?>>
<?php if(($unit <> $oldcode) or ($dumma == 0)){ echo ewrpt_ViewValue($unit);
     $oldcode = $unit; $dumma = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td>
<td<?php echo $sItemRowClass; ?>>
<?php if(($shed <> $oldcode1) or ($dumma1 == 0)){ echo ewrpt_ViewValue($shed);
     $oldcode1 = $shed; $dumma1 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td>
<?php $newcull = $cull- $age2; 
if($newcull > $weeks)
{
$newcull = $weeks;
}
else
{
$newcull = $newcull;
}?>
	<td class="ewRptGrpField2"><?php if(($flock <> "") && ($cull > $age2)) { ?><a href="indiflock.php?flock=<?php echo $flock;?>&weeks=<?php echo $newcull; ?>"><?php echo ewrpt_ViewValue($flock); ?></a><?php } else { ?><?php echo ewrpt_ViewValue($flock); ?><?php } ?></td>
	
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($age2) ?>
</td>


<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($birds > 0 ) { echo ewrpt_ViewValue($birds); } else { echo ewrpt_ViewValue("0"); } $totbirds = $totbirds + $birds;?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($male > 0 ) { echo ewrpt_ViewValue($male); } else { echo ewrpt_ViewValue("0"); } $totmbirds = $totmbirds + $male;?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($tp > 0 ) { echo ewrpt_ViewValue($tp); } else { echo ewrpt_ViewValue("0"); } $hatcheggs = $hatcheggs + $tp;?>
</td>

</td>
<td<?php echo $sItemRowClass; ?> align="right">																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															<?php if($tableeggs > 0 ) { echo ewrpt_ViewValue($tableeggs); } else { echo ewrpt_ViewValue("0"); } $tottable = $tottable + $tableeggs; ?>
</td>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($totaleggs > 0 ) { echo ewrpt_ViewValue($totaleggs); } else { echo ewrpt_ViewValue("0"); } $tottotal = $tottotal + $totaleggs; ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedcons > 0 ) { echo ewrpt_ViewValue($feedcons); } else { echo ewrpt_ViewValue("0"); } $totfeedcons = $totfeedcons + $feedcons?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedconsmale > 0 ) { echo ewrpt_ViewValue($feedconsmale); } else { echo ewrpt_ViewValue("0"); } $totfeedconsmale = $totfeedconsmale + $feedconsmale?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($productioncost > 0 ) { echo ewrpt_ViewValue(changeprice($productioncost)); } else { echo ewrpt_ViewValue("0"); } $totpc = $totpc + $productioncost;?>
</td> 
</tr>
<?php
$productioncost = 0;
$cst = 0;


 //echo $shed."/".$hage; echo "<br/>";

 } 
 else
 { ?>
    <tr>
	<td<?php echo $sItemRowClass; ?>>
<?php if(($unit <> $oldcode) or ($dumma == 0)){ echo ewrpt_ViewValue($unit);
     $oldcode = $unit; $dumma = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td>
<td<?php echo $sItemRowClass; ?>>
<?php if(($shed <> $oldcode1) or ($dumma1 == 0)){ echo ewrpt_ViewValue($shed);
     $oldcode1 = $shed; $dumma1 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td>
<?php $newcull = $cull- $age2; 
if($newcull > $weeks)
{
$newcull = $weeks;
}
else
{
$newcull = $newcull;
}?>
	<td class="ewRptGrpField2"><?php if(($flock <> "") && ($cull > $age2)) { ?><a href="indiflock.php?flock=<?php echo $flock;?>&weeks=<?php echo $newcull; ?>"><?php echo ewrpt_ViewValue($flock); ?></a><?php } else { ?><?php echo ewrpt_ViewValue($flock); ?><?php } ?></td>
	
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($age2) ?>
</td>


<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($birds > 0 ) { echo ewrpt_ViewValue($birds); } else { echo ewrpt_ViewValue("0"); } ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($male > 0 ) { echo ewrpt_ViewValue($male); } else { echo ewrpt_ViewValue("0"); } ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($tp > 0 ) { echo ewrpt_ViewValue($tp); } else { echo ewrpt_ViewValue("0"); } ?>
</td>

</td>
<td<?php echo $sItemRowClass; ?> align="right">																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															<?php if($tableeggs > 0 ) { echo ewrpt_ViewValue($tableeggs); } else { echo ewrpt_ViewValue("0"); }  ?>
</td>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($totaleggs > 0 ) { echo ewrpt_ViewValue($totaleggs); } else { echo ewrpt_ViewValue("0"); }  ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedcons > 0 ) { echo ewrpt_ViewValue($feedcons); } else { echo ewrpt_ViewValue("0"); } ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedconsmale > 0 ) { echo ewrpt_ViewValue($feedconsmale); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($productioncost > 0 ) { echo ewrpt_ViewValue(changeprice($productioncost)); } else { echo ewrpt_ViewValue("0"); } ?>
</td> 
</tr>
<?php
$productioncost = 0;
$cst = 0;
 }
}
	 // End detail records loop
?>

		
	
<?php

	// Next group
	$o_type = $x_type; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
	} // End while
?>

<tr><td <?php echo $sItemRowClass; ?>><b> Total</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totbirds; ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totmbirds; ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $hatcheggs; ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $tottable;?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $tottotal;?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b> <?php echo $totfeedcons; ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo $totfeedconsmale;?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b> <?php echo changeprice($totpc); ?></b></td>
</tr>
<tr height="20px"></tr>
<tr ><td <?php echo $sItemRowClass; ?> align="center" colspan="12"><b> Upcoming Flocks</b></td>
</tr>
<?php 

$dum = 0;
$rt = "";
$upshe = "";

foreach($mage_array as $upshed)
{
if(($upshed <> $oldcodes) or ($dum == 0))
{

?>
<tr>
<?php 
$s1 = "select * from breeder_shed where shedcode in('$upshed') GROUP BY shedcode";
$r1 = mysql_query($s1,$conn1) or die(mysql_error());
while($sr1 = mysql_fetch_assoc($r1))
{
$fcap = $sr1['shedcapacity'];
$shed = $sr1['shedcode'];
$unit = $sr1['unitcode'];
$mcap = round(($fcap/10),0);
if($d[$shed] > $weeks)
{
$newage = $weeks;
}
else
{
$newage = $d[$shed];
}
$q1 = "select * from breeder_flock where cullflag = '0' and unitcode $cond order by unitcode";
$r1 = mysql_query($q1,$conn1) or die(mysql_error());
while($qr1 = mysql_fetch_assoc($r1))
{
$breed = $qr1['breed'];
}
$fdif = round(($fcap - $u[$shed]),0); 
$mdif = round(($mcap - $mal[$shed]),0); 
$q3 = "select * from breeder_standards where age = $newage and client = '$client' order by age";
$r3 = mysql_query($q3,$conn1) or die(mysql_error());
while($qr3 = mysql_fetch_assoc($r3))
{
$cumhhp[$newage] = $qr3['cumhhp'];
$cumhhe[$newage] = $qr3['cumhhe'];
}

$cffeed = 0;
$cmfeed = 0;

$q9 = "select * from breeder_standards where age <= $newage and breed = '$breed' and client = '$client'";
$r9 = mysql_query($q9,$conn1) or die(mysql_error());
while($qr9 = mysql_fetch_assoc($r9))
{
$cffeed = $cffeed + $qr9['cffeed'];
$cmfeed = $cmfeed + $qr9['cmfeed'];
}
//echo $cffeed; echo "<br/>";
$hhpdif =  $cumhhp[$newage]; 
$hhedif = $cumhhe[$newage];

$feedcons = round((($cffeed * $fdif)/1000),2);
$feedconsmale = round((($cmfeed * $mdif)/1000),2);
$totaleggs = round(($fdif * $hhpdif),0);
$tp = round(($fdif * $hhedif),0);
$tableeggs = round(($totaleggs - $tp),0);
$a = 0;
$b = 0;
$mul = 0;
$productioncost = 0;
$q10 = "select * from breeder_feedcodestandards where ((fromage <= '0' and toage >= $newage) or (fromage <= $newage and toage >= $newage) or (fromage >= '0' and toage <= $newage)) and code in(select code from ims_itemcodes where cat = 'Female Feed') order by fromage";
$r10 = mysql_query($q10,$conn1) or die(mysql_error());
$n = mysql_num_rows($r10);
while($qr10 = mysql_fetch_assoc($r10))
{

$code = $qr10['code'];
 $desc = $qr10['description'];
$fromage = $qr10['fromage'];
$toage = $qr10['toage'];
$q11 = "select sum(ffeed) as ffeed from breeder_standards where (age between $fromage and $toage) and (age >= '0' and age <= $newage)";
$r11 = mysql_query($q11,$conn1) or die(mysql_error());
$qr11 = mysql_fetch_assoc($r11);
$feed = $qr11['ffeed'];

$query3 = "select * from feed_cost where code = '$code' and client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
while($qr3 = mysql_fetch_assoc($result3))
{
$costperkg[$feedtype] = $qr3['costperkg'];
$cst = $costperkg[$feedtype];
}
//echo $feedcons."/".$cst;
$a = $feedcons * $cst;
}
$q10 = "select * from breeder_feedcodestandards where ((fromage <= '0' and toage >= $newage) or (fromage <= $newage and toage >= $newage) or (fromage >= '0' and toage <= $newage)) and code in(select code from ims_itemcodes where cat = 'Male Feed') order by fromage";
$r10 = mysql_query($q10,$conn1) or die(mysql_error());
$n = mysql_num_rows($r10);
while($qr10 = mysql_fetch_assoc($r10))
{

$code = $qr10['code'];
 $desc = $qr10['description'];
$fromage = $qr10['fromage'];
$toage = $qr10['toage'];

 $query3 = "select * from feed_cost where code = '$code' and client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
while($qr3 = mysql_fetch_assoc($result3))
{
$costperkg[$feedtype] = $qr3['costperkg'];
$mcst = $costperkg[$feedtype];
}
$b = $feedconsmale * $mcst;

}
$mul = round(($a + $b),2);

$productioncost = $productioncost + $mul;

?>

<td<?php echo $sItemRowClass; ?>>
<?php if(($unit <> $oldcode) or ($dumma == 0)){ echo ewrpt_ViewValue($unit);
     $oldcode = $unit; $dumma = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>

</td>
<?php 
if($realage[$shed] >$cull)
{
$d[$shed] = $weeks;
}
else
{
$d[$shed] = $d[$shed];
}
?>

<td class="ewRptGrpField2"><?php if($shed <> "") { ?><a href="indiflockshed.php?shed=<?php echo $shed;?>&weeks=<?php echo $d[$shed]; ?>&female=<?php echo $fdif; ?>&male=<?php echo $mdif; ?>"><?php echo ewrpt_ViewValue($shed); ?></a><?php } else { ?>&nbsp;<?php } ?></td>
	

<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue("") ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($d[$shed]) ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  echo ewrpt_ViewValue($fdif); ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($mdif); ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php  if($tp > 0 ) { echo ewrpt_ViewValue($tp); } else { echo ewrpt_ViewValue("0"); } $hatcheggs = $hatcheggs + $tp;?>
</td>
</td>
<td<?php echo $sItemRowClass; ?> align="right">																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																															<?php if($tableeggs > 0 ) { echo ewrpt_ViewValue($tableeggs); } else { echo ewrpt_ViewValue("0"); } $tottable = $tottable + $tableeggs; ?>
</td>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($totaleggs > 0 ) { echo ewrpt_ViewValue($totaleggs); } else { echo ewrpt_ViewValue("0"); } $tottotal = $tottotal + $totaleggs; ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedcons > 0 ) { echo ewrpt_ViewValue($feedcons); } else { echo ewrpt_ViewValue("0"); } $totfeedcons = $totfeedcons + $feedcons?>
</td>

<td<?php echo $sItemRowClass; ?> align="right">
<?php if($feedconsmale > 0 ) { echo ewrpt_ViewValue($feedconsmale); } else { echo ewrpt_ViewValue("0"); } $totfeedconsmale = $totfeedconsmale + $feedconsmale?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($productioncost > 0 ) { echo ewrpt_ViewValue(changeprice($productioncost)); } else { echo ewrpt_ViewValue("0"); } $totpc = $totpc + $productioncost;?>
</td> 

<?php
$productioncost = 0;
$cst = 0;
$j++;
$oldcodes = $upshed; 
$dum = 1; } } } 
	 // End detail records loop
?>

</tr>
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
	<!-- tr><td colspan="5"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="5">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report1smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report1smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
			return (is_null($GLOBALS["x_type"]) && !is_null($GLOBALS["o_type"])) ||
				(!is_null($GLOBALS["x_type"]) && is_null($GLOBALS["o_type"])) ||
				($GLOBALS["x_type"] <> $GLOBALS["o_type"]);
		case 2:
			return (is_null($GLOBALS["x_schedule"]) && !is_null($GLOBALS["o_schedule"])) ||
				(!is_null($GLOBALS["x_schedule"]) && is_null($GLOBALS["o_schedule"])) ||
				($GLOBALS["x_schedule"] <> $GLOBALS["o_schedule"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_controltype"]) && !is_null($GLOBALS["o_controltype"])) ||
				(!is_null($GLOBALS["x_controltype"]) && is_null($GLOBALS["o_controltype"])) ||
				($GLOBALS["x_controltype"] <> $GLOBALS["o_controltype"]) || ChkLvlBreak(2); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_type"] = "";
	if ($lvl <= 2) $GLOBALS["o_schedule"] = "";
	if ($lvl <= 3) $GLOBALS["o_controltype"] = "";

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
		$GLOBALS['x_type'] = "";
	} else {
		$GLOBALS['x_type'] = $rsgrp->fields('type');
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
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_controltype'] = $rs->fields('controltype');
		$GLOBALS['x_schedule'] = $rs->fields('schedule');
		$GLOBALS['x_flag'] = $rs->fields('flag');
		$GLOBALS['x_tflag'] = $rs->fields('tflag');
		$val[1] = $GLOBALS['x_code'];
		$val[2] = $GLOBALS['x_description'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_controltype'] = "";
		$GLOBALS['x_schedule'] = "";
		$GLOBALS['x_flag'] = "";
		$GLOBALS['x_tflag'] = "";
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
				$nDisplayGrps = 20; // Non-numeric, load default
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
			$nDisplayGrps = 20; // Load default
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
			$_SESSION["sort_Report1_type"] = "";
			$_SESSION["sort_Report1_schedule"] = "";
			$_SESSION["sort_Report1_controltype"] = "";
			$_SESSION["sort_Report1_code"] = "";
			$_SESSION["sort_Report1_description"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "`code` ASC, `description` ASC";
		$_SESSION["sort_Report1_code"] = "ASC";
		$_SESSION["sort_Report1_description"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>
<script type="text/javascript">
function reloadpage(form)
{
	
	
	var weeks = document.getElementById('weeks').value;
	var uni = "<?php echo $_GET['unit'];?>";
	var cull = "<?php echo $_GET['cull'];?>";
	document.location = "futureplanning.php?weeks=" + weeks + "&unit=" +  uni + "&cull=" + cull;

}
</script>
