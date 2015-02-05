 <?php 
$sExport = @$_GET["export"]; 

if (@$sExport == "") { ?>
 
 <!-- <style type="text/css">
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
    </style>-->
<?php } ?> 


<?php
session_start();$currencyunits=$_SESSION['currency'];
$client = $_SESSION['client'];
ob_start();
$flock = $_GET['flock'];
$url = "&flock=" . $_GET['flock'] ;

include "config.php";
  $qb = "SELECT breed FROM layer_flock WHERE flkmain = '$flock' and breed <> ''";
  $rb = mysql_query($qb,$conn1); 
  while($rb1 = mysql_fetch_assoc($rb))  
  {
  $breedi = $rb1['breed'];
  }         

if($_SESSION['db'] == "albustanlayer" || $_SESSION['db']=="gujarath")
{
$flkmain = $_GET['flock'];
$query = "SELECT flockcode FROM layer_flock WHERE flkmain = '$flkmain' and shedcode in (select distinct(shedcode) from layer_shed where shedtype = 'LAYER') AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$flock = $rows['flockcode'];
}
else
 $flock = $_GET['flock'];


if($_SESSION['db'] == "albustanlayer"|| $_SESSION['db']=="gujarath")
{
$flk='';
$flkmain = $_GET['flock'];
$query = "SELECT flockcode FROM layer_flock WHERE flkmain = '$flkmain' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
$flk.= "'".$rows['flockcode']."',";
$flk=substr($flk,0,-1);
}



$agequery = "select max(age) as age from layer_pstandards where breed = '$breedi'";
$resultage = mysql_query($agequery,$conn1) or die(mysql_error());
$res = mysql_fetch_assoc($resultage);
$maxagee = $res['age'];
//$fdatedump = $_POST['date2'];

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
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Layer Weekly Report</font></strong></td>
</tr>
<tr>
<td colspan="2" style="text-align:center" ><strong><font color="#3e3276" size="2"><?php if($_SESSION['db'] == "albustanlayer" || $_SESSION['db']=="gujarath") { echo "Flock:"; } else { echo "Flock:"; } ?><?php echo $_GET['flock']; ?></font></strong></td>
</tr>
</table>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
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
$EW_REPORT_TABLE_SQL_GROUPBY = "";
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
&nbsp;&nbsp;<a href="layerrep.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="layerrep.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="layerrep.php?export=word<?php echo $url; ?>">Export to Word</a><br /><br />
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
<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<!--<div class="ewGridUpperPanel">
<form action="Report1smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
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
</div>-->
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
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Transfers
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td colspan="2" >Transfers</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Livability %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"  ><tr>
			<td align="center" >Livability %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Production</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  colspan="2" align="center">
		Production %
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"  ><tr>
			<td align="center">Production %</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="3" align="center">
		Egg/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td align="center">Egg/Bird</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Feed/Bird" ><tr>
			<td align="center">Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	<tr>

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
		<td valign="bottom" class="ewTableHeader">
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Transfer-In">
		In
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Transfer-In">In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Transfer-Out">
		Out
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Transfer-Out">Out</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Sales</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Livability % Standard">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Livability % Standard" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Livability % Actual">
		Actual 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Livability % Actual" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Week
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Week</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cumulative Production">
		Cumulative
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Cumulative Production"><tr>
			<td>Cumulative</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Production %">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Production %" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Actual Production %">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Actual Production %" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Difference">
		Diff
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Difference">Diff</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Feed/Bird">
		Standard
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" title="Standard Feed/Bird" ><tr>
			<td>Standard</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Actual Feed/Bird">
		Actual
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td title="Actual Feed/Bird">Actual</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Total Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">&nbsp;
		Feed/Bird Cum
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Feed/Bird Cum</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed/Egg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Feed/Egg</td>
			</tr></table>
		</td>
<?php } ?>
<!--<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cost Incurred
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn" ><tr>
			<td>Cost Incurred</td>
			</tr></table>
		</td>
<?php } ?> -->
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}


?>
<?php
$mindatep = "";
$maxdatep = "";
$mindate = "";
$maxdate = "";
$minage = 0;
$maxage = 0;

      $query1 = "SELECT min(date1) as mindate,max(date1) as maxdate from layer_production where flock in ($flk) and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	    $minp = $row2['mindate'];
		$maxp = $row2['maxdate'];
	  }
$minc = "";
$maxc = "";
 $query1 = "SELECT min(date2) as mindate,max(date2) as maxdate,min(age) as minage,max(age) as maxage from layer_consumption where  flock in ($flk) and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $minc = $row2['mindate'];
		$maxc = $row2['maxdate'];
		$mxage = $row2['maxage'];
		$mnage = $row2['minage'];
	  }

 $foping = 0;
             $q = "select * from layer_flock where flockcode in ($flk) and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $foping += $qr['femaleopening'];
             }
             
 
             $minus1 = 0; 
             $q = "select distinct(date2),fmort,fcull from layer_consumption where flock in ($flk) and client = '$client'  and date2 < '$minc' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus1 = $minus1 + $qr['fmort'] + $qr['fcull'];
             }

        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse in ($flk) and date < '$minc'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer1 = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer1 = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock in ($flk) and client = '$client'  and date < '$minc'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale1 = $qr['quantity'];
               }
             }
             else
             {
                $tsale1 = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse in ($flk) and date < '$minc'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer1 = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer1 = 0;
             } 

             $remaining1 = ($foping - $minus1 - $ftransfer1 + $ttransfer1) - $tsale1;
			



      $query1 = "SELECT min(date1) as mindate,max(date1) as maxdate from layer_production where flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	     $mindatep = $row2['mindate'];
		$maxdatep = $row2['maxdate'];
	  }
$mindatec = "";
$maxdatec = "";
      $query1 = "SELECT min(date2) as mindate,max(date2) as maxdate,min(age) as minage,max(age) as maxage from layer_consumption where flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $mindatec = $row2['mindate'];
		$maxdatec = $row2['maxdate'];
		 $maxage = $row2['maxage'];
		  $minage = $row2['minage'];
	  }
	 
	 $max = $maxdatep;
	 if($maxdatec < $maxdatep)
	 $max = $maxdatec;
	 
	
	 $query = "select age from layer_consumption where date2 = '$max' and flock = '$flock' and client = '$client'";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 $page = $rows['age'];
	 }
    	 
		 
	  $agemin = ceil($page/7)*7;
	 
	  if($mindatec <= $mindatep)
	  {
	       $query1 = "SELECT age from layer_consumption where date2 = '$mindatep' and flock = '$flock' and client = '$client'  ";
      $result1 = mysql_query($query1,$conn1);
	  while($row2 = mysql_fetch_assoc($result1))
      {
	     $minage = $row2['age'];
	   }
	   
	   
	   $query2 = "select date2 from layer_consumption where age = '$minage' and flock = '$flock' and client = '$client'";
	   $result2 = mysql_query($query2,$conn1) or die(mysql_error());
	   while($rows3 = mysql_fetch_assoc($result2))
	   {
	   $mindatep = date("Y-m-d",strtotime($rows3['date2']));
	   }
	   
	  
	  $startweek = $minage/7;
	  $firstweek = $startweek;
	  $endweek = $maxage/7;
	  $endweek = $endweek + 1;
	  $span = $maxage - $minage;
	  if(($minage % 7) == 1)
	 {
	    $agefrom = $minage;
	    $ageto = $agefrom + 7;
	 } 
	 
	 else
	 {
	   $agefrom = $minage;
	   $ageto = $minage + (8 - ($minage % 7));
	 }	 
?>
<?php
  $fopening = 0;
             $q = "select * from layer_flock where flockcode = '$flock' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
 
             $minus = 0; 
            $q = "select distinct(date2),fmort,fcull from layer_consumption where flock = '$flock' and client = '$client'  and date2 < '$mindatep' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }
//echo $minus;
        
             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$flock' and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
//echo $ftransfer ;
             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flock' and client = '$client'  and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 
			//echo $tsale;

            $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date < '$mindatep'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
			//echo $ttransfer;
            $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;
			 $nxtbirds = $remaining;
			 $birdsper = (3/100)*$nxtbirds;
			 $status1 = $status2 = $allweeks=0;
?>
<?php
$minwkdate = "";
$maxwkdate = "";
$query1 = "SELECT  min(date2) as minwkdate,max(date2) as maxwkdate from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age <= '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  $minwkdate = $row2['minwkdate'];
	   $maxwkdate = $row2['maxwkdate']; 
	  }
	  $toteggs = 0;
	  $totmort = 0;
	  $totcull = 0;
	  $tottrin = 0;
	  $tottrout = 0;
	  $totsale = 0;
	  $totcost = 0;
	  $totfeedstd = 0;
	  $totfeedkg = 0;
	  $totalweekfeed = 0;
	  $cum = 0;
	   
	  
	  $query1 = "SELECT  sum(quantity) as quant,max(avgwt) as bdwt from layer_consumption where client = '$client' and flock in ($flk) and age < '$agefrom' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $wfeed1 = $row2['quant'];
	  }
	  
	 
while($agefrom <= $agemin )
{

   
  $wmort = 0;
  $wcull = 0;
  $wfeed = 0;
  $wtrin = 0;
  $wtrout = 0;
  $wsale = 0;
  $wprod = 0;
  $inccost = 0;
  $livstd = 0;
  $feedstd = 0;
  $prodstd = 0;
  $actliv = 0;
  $nxtlive = 0;
  $weggs = 0;
  $wprodper = 0;
  $hecumstd = 0;
  $hecumact = 0;
  $fperegg = 0;
  $cost = 0;
  $daycount=0;
  

  
  $query1 = "SELECT  distinct(date2),fmort,fcull from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {  
	    $wmort = $wmort + $row2['fmort'];
		$wcull = $wcull + $row2['fcull'];
		$daycount++;
	  }
	 $query1 = "SELECT  sum(quantity) as quant from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $wfeed = $row2['quant'];
	  }
	  $query1 = "SELECT  sum(quantity) as quant from layer_production where client = '$client' and flock = '$flock' and date1 >= '$minwkdate' and date1 < '$maxwkdate' and itemcode in (select code from ims_itemcodes where cat = 'Layer Eggs' and client = '$client') ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $weggs = $row2['quant'];
	  }
	 $toteggs = $toteggs + $weggs;

	  
	  $totmort = $totmort + $wmort;
	  $totcull = $totcull + $wcull;
	  
	  
	 $tmort = $totmort + $totcull;
	  
	  $query1 = "SELECT  itemcode,sum(quantity) as quant,max(date2) as date from layer_consumption where client = '$client' and flock = '$flock' and age >= '$agefrom' and age < '$ageto' and itemcode in (select code from ims_itemcodes where cat = 'Layer Feed' and client = '$client') group by itemcode ";
	
       $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   
	  
	$q = "select sum(materialcost)/sum(production) as cost from feed_productionunit where mash = '$row2[itemcode]' and client = '$client'"; 
		
		
    		// $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $cost = $cost + round(($qr['cost'] * $row2['quant']),2);
               }
	  }
	 
	    $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and fromwarehouse = '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrout = $qr['quantity'];
               }
          $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Layer Birds' and client = '$client'  and towarehouse = '$flock' and date < '$maxwkdate' and date >= '$minwkdate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wtrin = $qr['quantity'];
               }
             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$flock' and client = '$client'  and date < '$maxwkdate' and date >= '$minwkdate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              while($qr = mysql_fetch_assoc($qrs))
    		   {
                $wsale = $qr['quantity'];
               }
			   $agewk = ceil($agefrom/7);
			   $nowbirds = $nxtbirds;
			   
			   $nxtlive = $nxtbirds - $wmort - $wcull;
			   
			   $actliv = round((($nxtlive/$remaining) * 100),2);
             $nxtbirds = $nxtbirds - $wmort - $wcull - $wtrout + $wtrin - $wsale;
			 
			if($agewk > $maxagee)
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$maxagee' and  breed = '$breedi' "; 
			 else
			 $q = "select * from layer_pstandards  where client = '$client' and age = '$agewk' and  breed = '$breedi' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
              while($qr = mysql_fetch_assoc($qrs))
    		   {
                $livstd = round($qr['livability'],2);
				$prodstd = $qr['henday'];
				$feedstd = $qr['fm'];
				$hecumstd = round(($qr['hecum']),2);
               }
			   $wprodper = round((($weggs/$nowbirds) * 100),2);
			   $wprodper = round(($wprodper/$daycount),2);
			   
			   
			   
			   
			   if($_SESSION['db'] == "albustanlayer"  || $_SESSION['db']=="gujarath") 
			   { 
			    if($tmort > $birdsper && $status2 == 0)
				   {
					   $status2 = $status1 = 1;
				   }
                if($status1 == 1 ) 
				{
                 $allweeks = $nowbirds - $wmort - $wcull;
                 $status1 = 0;
                } 
                if($status1 == 0 && $status2 ==0)
                $allweeks = $nowbirds;
			   
			   $hecumact = round(($toteggs/$allweeks),2);
               }
			   else
			   $hecumact = round(($toteggs/$remaining),2);
			   
			   
			   
			   $fperegg = round((($wfeed * 1000)/$weggs),2);
			   $totfeedkg = $totfeedkg + $wfeed;
			   $weekfeed = $wfeed;
			   $wfeed = $wfeed/$nowbirds;
			   $wfeed = round((($wfeed * 1000)/$daycount),2);
			   $tottrin = $tottrin + $wtrin;
			   $tottrout = $tottrout + $wtrout;
			   $totsale = $totsale + $wsale;
			   $totfeed = $totfeed +  $wfeed;
			   
			   
	            
			   
			   ?>
			   
			   <tr>
			   
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(round($agefrom/7),0); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice1($nowbirds)); 
  
   ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wmort > 0){ echo ewrpt_ViewValue(changeprice1($wmort)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wcull > 0){ echo ewrpt_ViewValue($wcull); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wtrin > 0){ echo ewrpt_ViewValue($wtrin); } else { echo ewrpt_ViewValue("0");  } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wtrout > 0){ echo ewrpt_ViewValue($wtrout); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($wsale > 0) { echo ewrpt_ViewValue($wsale); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($livstd > 0) { echo ewrpt_ViewValue($livstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" <?php if($actliv < $livstd) {  ?> style="color:#FF0000" <?php } else { ?> style="color:#009900" <?php } ?> >
<?php if($actliv > 0) {  echo ewrpt_ViewValue($actliv); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($weggs > 0) {  echo ewrpt_ViewValue(changeprice1($weggs)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($toteggs > 0) {  echo ewrpt_ViewValue(changeprice1($toteggs)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($prodstd > 0) {  echo ewrpt_ViewValue($prodstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" <?php if($prodstd < $wprodper) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>>
<?php if($wprodper > 0) {  echo ewrpt_ViewValue($wprodper); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($hecumstd > 0) {  echo ewrpt_ViewValue($hecumstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td <?php echo $sItemRowClass; ?> align="right" <?php if($hecumstd < $hecumact) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?> ><?php if($hecumact > 0) {  echo ewrpt_ViewValue($hecumact); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php $dum1 = $hecumact - $hecumstd;  if($hecumact >= 0) {  echo ewrpt_ViewValue(round($dum1,3)); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td <?php echo $sItemRowClass; ?> align="right">
<?php if($feedstd > 0) {  echo ewrpt_ViewValue($feedstd); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td <?php echo $sItemRowClass;  ?> align="right" <?php if($wfeed < $feedstd) { ?> style="color:#009900" <?php } else { ?> style="color:#FF0000" <?php } ?>>
<?php if($wfeed > 0) {  echo ewrpt_ViewValue($wfeed); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($weekfeed > 0) {  echo ewrpt_ViewValue(changeprice($weekfeed)); $totalweekfeed +=$weekfeed; } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<td <?php echo $sItemRowClass; ?> align="right">
<?php if($a == '') { $a = $wfeed1 + $weekfeed; } else { $a = $weekfeed; } $cum += $a; $weekcum = $cum/$remaining1; echo ewrpt_ViewValue(round($weekcum,2)); ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($fperegg > 0) {  echo ewrpt_ViewValue($fperegg); } else { echo ewrpt_ViewValue("0"); } ?>
</td>
<!--<td<?php echo $sItemRowClass; ?> align="right">
<?php if($cost > 0) {  echo ewrpt_ViewValue($cost); } else { echo ewrpt_ViewValue("0"); } ?>
</td>-->
			   </tr>
			   <?php
			   
        $agefrom = $ageto  ;
		$ageto = $ageto + 7;
		$minwkdate = $maxwkdate;
		$temp = strtotime($maxwkdate);
		$temp = $temp + (7 * 24 * 60 * 60);
		$maxwkdate = date("Y-m-d",$temp);
		$totfeedstd = $totfeedstd + $feedstd;
		$totcost = $totcost + $cost;
		

}

//$totfeedstd = $totfeedstd * 7;
//$totfeed = $totfeed * 7;
$finprodper = round(((($toteggs/$remaining) * 100)/$span),2);
$finstdprodper = round((($hecumstd * 100)/$span),2);
$fineggpb = round((($totfeedkg/$toteggs)*1000),2);
?>
<tr>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php echo changeprice1($remaining); ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totmort > 0){ echo ewrpt_ViewValue(changeprice1($totmort)); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcull > 0){ echo ewrpt_ViewValue($totcull); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($tottrin > 0){ echo ewrpt_ViewValue($tottrin); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($tottrout > 0){ echo ewrpt_ViewValue($tottrout); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totsale > 0){ echo ewrpt_ViewValue($totsale); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo "&nbsp;"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($toteggs > 0){ echo ewrpt_ViewValue(changeprice1($toteggs)); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($toteggs > 0){ echo ewrpt_ViewValue(changeprice1($toteggs)); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finstdprodper > 0){ echo ewrpt_ViewValue($finstdprodper); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finprodper > 0){ echo ewrpt_ViewValue($finprodper); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($hecumstd > 0){ echo ewrpt_ViewValue($hecumstd); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($hecumact > 0){ echo ewrpt_ViewValue($hecumact); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($finprodper > 0){ echo ewrpt_ViewValue(round(($hecumact - $hecumstd),2)); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeedstd > 0){ echo ewrpt_ViewValue($totfeedstd); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totfeed > 0){ echo ewrpt_ViewValue($totfeed); } else { echo ewrpt_ViewValue("0"); } ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totalweekfeed > 0){ echo ewrpt_ViewValue(changeprice($totalweekfeed)); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($weekcum > 0){ echo ewrpt_ViewValue(round($weekcum,2)); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($fineggpb > 0){ echo ewrpt_ViewValue($fineggpb); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>
<!--<td<?php echo $sItemRowClass; ?> align="right"><b>
<?php if($totcost > 0){ echo ewrpt_ViewValue($totcost); } else { echo ewrpt_ViewValue("0"); }  ?></b>
</td>-->
</tr>
			
<?php

	// Next group
	$o_type = $x_type; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while

}
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
