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

 
 if($_GET['cat'] == "")
 {
  $cat = 'Hatch Eggs';
 }
 else
 {
  $cat = $_GET['cat'];
 }

 
$warehouse = "Hatchery";;

if(($_GET['fromdate'] == "") OR ($_GET['todate'] == ""))
{
 $q1 = "SELECT * FROM ac_definefy";
 $r1 = mysql_query($q1,$conn1);
 while($row1 = mysql_fetch_assoc($r1))
 {
  $fromdate = $row1['fdate'];
  $todate = $row1['tdate'];
 }
}
else
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}

//echo $cat; echo $warehouse; echo $fromdate; echo $todate;

$url = "&fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;
$url1 = "?fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
include "getemployee.php";
?>
<?php include "reportheader.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="3"><strong><font color="#3e3276">Hatch Egg Stock Report </font></strong></td></tr>

<tr><td> <strong>From ::</strong> <?php echo date($datephp,strtotime($fromdate));?> </td> <td> <strong>To ::</strong><?php echo date($datephp,strtotime($todate));?> </td><td> <strong>Category :: </strong><?php echo $cat;?></td>
</tr>
</table>
<?php 
if($currencyunits == "")
{
$currencyunits = "Rs";

	if($_SESSION[db] == "alkhumasiyabrd")
	{
	$currencyunits = "SR";
	}
}
 if($_SESSION['client'] == 'KEHINDE')
{
?>
<center><p style="padding-left:430px;color:red"> All amounts in ?</p></center>
<?php 
}
else
{
?>

<center><p style="padding-left:430px;color:red"> All Quantities in <?php echo Numbers;?></p></center>
<?php } ?>
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
&nbsp;&nbsp;<a href="hatcheggreport.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatcheggreport.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatcheggreport.php?export=word<?php echo $url; ?>">Export to Word</a>
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
Category&nbsp;
<select id="cat" name="cat" onchange="reloadpage();">
<option value="">-Select-</option>
<?php

$q = "select distinct(type) from ims_itemtypes WHERE (type = 'Hatch Eggs' || type = 'Layer Chicks') order by type";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['type']; ?>" <?php if($cat == $qr['type']) { ?> selected="selected" <?php } ?> ><?php echo $qr['type']; ?></option>
<?php } ?>
</select>
&nbsp;&nbsp;&nbsp;
From Date&nbsp;
<input type="text" size="15" id="fromdate" name="fromdate" value="<?php echo date($datephp,strtotime($fromdate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;
To Date&nbsp;
<input type="text" size="15" id="todate" name="todate" value="<?php echo date($datephp,strtotime($todate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;
Warehouse&nbsp;
<select id="warehouse" name="warehouse" onchange="reloadpage();">
<option value="">-Select-</option>
<?php
$q = "select distinct(sector) from tbl_sector WHERE (type1 = 'Hatchery') order by sector";
$qrs = mysql_query($q,$conn1);
$n1 = mysql_num_rows($qrs);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php  echo $qr['sector']; ?>" <?php if($n1 == 1) { ?> selected=selected<?php } ?> <?php if($warehouse == $qr['sector']) { ?> selected="selected" <?php } ?> ><?php echo $qr['sector']; ?></option>
<?php } ?>

</select>
&nbsp;&nbsp;&nbsp;
<form action="hatcheggreport.php" name="ewpagerform" id="ewpagerform" class="ewForm">
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
		<td valign="bottom" class="ewTableHeader" style="width:70px">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader" style="width:70px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:120px">
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader" style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Opening</td>
			</tr></table>
		</td>
<?php } ?>


<?php if(($cat == 'Broiler Chicks') || ($cat == 'Layer Chicks'))
{
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:120px">
		Purchased/Hatched
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td >Purchased/Hatched</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  style="width:120px">
		Chicks Transferred
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Chicks Transferred
		</td>
			</tr></table>
		</td>
<?php }
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  style="width:120px">
		Chicks Sold
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Chicks Sold
		</td>
			</tr></table>
		</td>
<?php }
 } else { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:120px">
		Purchased/Transfer In
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td >Purchased/Transfer In</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px">
		Eggs set
		</td>
<?php } else { ?>
		<td class="ewTableHeader" style="width:80px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Eggs Set
		</td>
			</tr></table>
		</td>
<?php }

if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px">
		Eggs Sold
		</td>
<?php } else { ?>
		<td class="ewTableHeader" style="width:80px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>	
		Eggs Sold
		</td>
			</tr></table>
		</td>
<?php }

 }?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  style="width:120px">
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader" style="width:120px">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Closing</td>
			</tr></table>
		</td>
<?php } ?>
</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}
$q1 = "select distinct(flkmain) as flock from breeder_flock where client = '$client' order by flock";
$r1 = mysql_query($q1,$conn1);
while($qr = mysql_fetch_assoc($r1))
{
$flock = $qr['flock'];
///////////////Intermediate Receipt
$irecop = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE date < '$fromdate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and cat = '$cat' and riflag = 'R' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$irecop = $rowop['quantity'];
if($irecop == "") $irecop = 0;
///////////////Intermediate Issue
$iiscop = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE date < '$fromdate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and riflag = 'I' and cat = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$iiscop = $rowop['quantity'];
if($iiscop == "") $iiscop = 0;
///////////////Hatchery Tray Setting
if($cat == 'Hatch Eggs')
{
$trayop = 0;
$getop = "SELECT SUM(eggsset) as quantity FROM hatchery_traysetting WHERE settingdate < '$fromdate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse') and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$trayop =$rowop['quantity'];
}
else
{
$trayop = 0;
$getop = "SELECT SUM(saleablechicks) as salablechicks FROM hatchery_hatchrecord WHERE hatchdate < '$fromdate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse') and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$trayop =$rowop['salablechicks'];
$stockfrom = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE date < '$fromdate' and (fromwarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || fromwarehouse =  '$warehouse') and cat = 'Broiler Chicks'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$stockfrom = $rowop['quantity'];
}
////////////////////Stock Adjustment (Add)
$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date < '$fromdate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Add' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staadd = $rowop['quantity'];
if($staadd == "") $staadd = 0;
////////////////////Stock Adjustment (Deduct)
$staded = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date < '$fromdate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Deduct' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staded = $rowop['quantity'];
if($staded == "") $staded = 0;
////////////Eggs Received
$eggreceive = 0;
$getop = "select sum(toeggs) as toeggs from ims_eggreceiving where date < '$fromdate' and tocode in (select distinct(code) from ims_itemcodes where cat = '$cat') and (towarehouse in (select distinct(warehouse) from tbl_sector where sector = '$warehouse') || (towarehouse =  '$warehouse')) and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggreceive = $rowop['toeggs'];

////////////////////////////Sales
$sales = 0;
$getop = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE date < '$fromdate' and (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and code in (select distinct(code) from ims_itemcodes where cat = 'Hatch Eggs') and dflag = 0 and flock LIKE '%$flock%'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$sales = $rowop['quantity'];

///////////////////////Pack Slip
$packslip = 0;
$getop = "SELECT SUM(quantity) as quantity FROM oc_packslip WHERE date < '$fromdate'  and flock LIKE '%$flock%' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Hatch Eggs')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$packslip = $rowop['quantity'];
/////////end of getting the OPENING/////////
//echo $purchasedop."/".$stadd."/".$grop."/".$trayop."/".$stockto."/".$irecop."/".$staded."/".$stockfrom."/".$iiscop;
if($cat == 'Hatch Eggs')
{
$opening = $staadd + $eggreceive + $irecop - ($staded + $iiscop + $trayop + $sales + $packslip);
}
else
{
//echo $staadd."/".$irecop."/".$trayop."/".$staded."/".$iiscop."/".$sales."/".$packslip."/".$stockfrom; echo "<br/>";
$opening =  $staadd + $irecop + $trayop - ($staded + $iiscop + $sales + $packslip + $stockfrom);
}

/////////////////////////////////////PURCHASES/TRANSFERRED/HATCHED
///////////Eggs Received
$eggreceive = 0;
$getop = "select sum(toeggs) as toeggs from ims_eggreceiving where date >= '$fromdate' AND  date <= '$todate' and tocode in (select distinct(code) from ims_itemcodes where cat = '$cat') and (towarehouse in (select distinct(warehouse) from tbl_sector where sector = '$warehouse') || (towarehouse =  '$warehouse')) and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggreceive = $rowop['toeggs'];
$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Add' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staadd = $rowop['quantity'];
if($staadd == "") $staadd = 0;
///////////////Stock Adjustment (Deduct)
$staded = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Deduct' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staded = $rowop['quantity'];
if($staded == "") $staded = 0;
if($cat == 'Hatch Eggs')
{$purchase = $eggreceive + $staadd;}
else
{
///////////////Intermediate Receipt
$irecop = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE date >= '$fromdate' AND  date <= '$todate' AND (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and cat = '$cat' and riflag = 'R' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$irecop = $rowop['quantity'];
if($irecop == "") $irecop = 0;

$getop = "SELECT SUM(saleablechicks) as salablechicks FROM hatchery_hatchrecord WHERE hatchdate >= '$fromdate' AND  hatchdate <= '$todate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse') and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$trayop =$rowop['salablechicks'];

$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Add' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staadd = $rowop['quantity'];
if($staadd == "") $staadd = 0;
$purchase = $irecop + $trayop + $staadd;
}
///////////////////////////Eggs Set
if($cat == 'Hatch Eggs'){
$eggset = 0;
$getop = "SELECT SUM(eggsset) as quantity,sum(reject) as reject,sum(waste) as waste FROM hatchery_traysetting WHERE settingdate >= '$fromdate' AND  settingdate <= '$todate' and (hatchery in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || hatchery =  '$warehouse') and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$eggset1 = $rowop['quantity'];
$sales = 0;
 $getop = "SELECT SUM(quantity) as quantity FROM oc_cobi WHERE date >= '$fromdate' AND date <= '$todate' and (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and code in (select distinct(code) from ims_itemcodes where cat = 'Hatch Eggs') and dflag = 0 and flock LIKE '%$flock%'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$sales = $rowop['quantity'];
///////////////////////Pack Slip
$packslip = 0;
$getop = "SELECT SUM(quantity) as quantity FROM oc_packslip WHERE date >= '$fromdate' AND date <= '$todate' and flock LIKE '%$flock%' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Hatch Eggs')";
$resultop = mysql_query($getop,$conn1);
if($rowop = mysql_fetch_assoc($resultop))
   $packslip = $rowop['quantity'];
$eggset = $eggset1 ;
 $sold=$sales + $packslip;
}
else
{
 $getop = "SELECT SUM(quantity) as chicksales FROM oc_cobi WHERE date >= '$fromdate' AND date <= '$todate' and (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and code in (select distinct(code) from ims_itemcodes where cat = 'Broiler Chicks') and client = '$client' and flock LIKE '%$flock%' and dflag = 0";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$chicksales = $rowop['chicksales'];

$packslip = 0;
$getop = "SELECT SUM(quantity) as quantity FROM oc_packslip WHERE date >= '$fromdate' AND date <= '$todate' and (warehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || warehouse =  '$warehouse') and code in (select distinct(code) from ims_itemcodes where cat = 'Broiler Chicks')";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$packslip = $rowop['quantity'];

$staadd = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stockadjustment WHERE date >= '$fromdate' AND  date <= '$todate' AND (unit in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || unit =  '$warehouse') and type = 'Deduct' and category = '$cat' and flock = '$flock'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$staded= $rowop['quantity']; 
if($staded == "") $staded = 0;

$stockfrom = 0;
$getop = "SELECT SUM(quantity) as quantity FROM ims_stocktransfer WHERE date >= '$fromdate' AND  date <= '$todate' and (fromwarehouse in(select distinct(warehouse) from tbl_sector where sector = '$warehouse') || fromwarehouse =  '$warehouse') and cat = 'Broiler Chicks' and flock = '$flock' and client = '$client'";
$resultop = mysql_query($getop,$conn1);
$rowop = mysql_fetch_assoc($resultop);
$stockfrom = $rowop['quantity'];
$eggset = $staded + $stockfrom;
$sold=$chicksales + $packslip;
}
//////////////////Closing
$closing = $opening + $purchase - ($eggset+$sold);

?>

<tr>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($flock); ?>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($opening); $total_opening+=$opening; ?>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php if($purchase <> "") { echo changequantity($purchase); } else { echo "0";} $total_purchase+=$purchase; ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php if($eggset <> "") { echo changequantity($eggset); } else {echo "0";}$total_eggs+=$eggset; ?>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php if($sold <> "") { echo changequantity($sold); } else {echo "0";}$total_sales+=$sold; ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changequantity($closing); $total_closing+=$closing; ?>
</td>
</tr>
<?php
 }
	// Next group
	$o_type = $x_type; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
<tr><td <?php echo $sItemRowClass; ?>><b> Total</b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($total_opening);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($total_purchase);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($total_eggs);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($total_sales);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($total_closing);?></b></td>
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
function reloadpage()
{
	var cat = document.getElementById('cat').value;
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
	var warehouse = document.getElementById('warehouse').value;
	//document.location = "hatcheggreportsmry.php?fromdate=" + fromdate + "&todate=" + todate + "&cat=" + cat + "&warehouse=" + warehouse;
	var dt1  = parseInt(fromdate.substring(0,2),10); 
var mon1 = parseInt(fromdate.substring(3,5),10);
var yr1  = parseInt(fromdate.substring(6,10),10); 
var dt2  = parseInt(todate.substring(0,2),10); 
var mon2 = parseInt(todate.substring(3,5),10); 
var yr2  = parseInt(todate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

if(Date.parse(date1) <= Date.parse(date2))
	{
	document.location = "hatcheggreport.php?fromdate=" + fromdate + "&todate=" + todate + "&warehouse=" + warehouse + "&cat=" + cat;
	}
	else
	{
	alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}
</script>