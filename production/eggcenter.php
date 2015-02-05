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
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
include "../getemployee.php";
#$fdatedump = $_POST['date2'];

$fdatedump = $_GET['fromdate'];
$fdate = date("Y-m-d", strtotime($fdatedump));
if($_GET['warehouse'] == "")
 $warehouse = "All";
else
 $warehouse = $_GET['warehouse'];
#$tdatedump = $_POST['date3'];
$tdatedump = $_GET['todate'];
$tdate = date("Y-m-d", strtotime($tdatedump));
$url = "&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];
?>
<?php include "reportheader.php"; ?>

<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Egg Center Profit &amp; Loss</font></strong></td>
</tr>
<tr>
<td colspan="2" align="center"><font size="2">Ware House :&nbsp;<?php echo $warehouse; ?>
              
</tr>
<tr>
<td colspan="2"><font size="2">From Date&nbsp;<?php echo $fdatedump; ?>
                To Date &nbsp;<?php echo $tdatedump;?></font></td>
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
include "config.php";





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
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="eggcenter.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="eggcenter.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="eggcenter.php?export=word<?php echo $url; ?>">Export to Word</a>
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
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<!--<div class="ewGridUpperPanel">
<form action="eggcenter.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">
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
		<td valign="bottom" class="ewTableHeader" colspan="2" align="center">
		Expense
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Expense</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Revenue
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Revenue</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

	<tr>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

$leftcount = 0;
$rightcount = 0;
	 ?>
	<?php 
	
	$drtotal = 0;
  $crtotal = 0;
  $nexpsum = 0;
  $nrevsum = 0;
  $ecount = 0;
  $rcount = 0;
  $startdate = "";
  $grleftcount = 0;
  $grrightcount = 0;
  //Opening Balance
	include "config.php";
	if($_SESSION['db'] == "skpfnew")
	{
	$query1 = "select min(fdate) as startdate from ac_definefy where client = '$client'   ";
	}
	else
	{
	$query1 = "select min(date) as startdate from ac_financialpostings where client = '$client'   ";
	}
  
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $startdate = $row2['startdate'];
	  }
	  
	//Ingredient Opening Stock
	   $query1 = "select distinct(iac) from ims_itemcodes where cat = 'Ingredients' and client = '$client'   ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $ingacc = $row2['iac'];
	  }
	 $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$ingacc' and client = '$client'  and crdr = 'Cr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $inginitcr = $row2['cramount']; 
	   //$eggnuminitcr = $row2['quant'];
	  }
   $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$ingacc' and client = '$client'  and crdr = 'Dr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $inginitdr = $row2['dramount']; 
	   //$eggnuminitdr = $row2['quant'];
	  }
	 $inginitbal = $inginitdr - $inginitcr; 
	// $eggnuminitbal = $eggnuminitdr - $eggnuminitcr;
	  
	  if($fdate <= $startdate)
	  {
	   $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$ingacc' and client = '$client'  and crdr = 'Dr' and date = '$fdate' and type = 'IR'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $inginitir = $row2['cramount']; 
	   
	  }
	  $inginitbal = $inginitbal + $inginitir; 
	  }
	   $leftarray1[$leftcount] = "Opening Stock";
	  $leftarray2[$leftcount] = "";
	  $leftcount = $leftcount + 1;
	  /*$leftarray1[$leftcount] = "";
	  $leftarray2[$leftcount] = "";
	  $leftcount = $leftcount + 1;*/
	  //$grleftcount = $grleftcount + round($inginitbal,2);
	  //Medicine Opening Stock
	  $query1 = "select distinct(iac) from ims_itemcodes where cat = 'Medicines' and client = '$client'   ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $medacc = $row2['iac'];
	  }
	 $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$medacc' and client = '$client'  and crdr = 'Cr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $medinitcr = $row2['cramount']; 
	  }
	  $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$medacc' and client = '$client'  and crdr = 'Dr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $medinitdr = $row2['dramount'];  
	  }
	  $medinitbal = $medinitdr - $medinitcr;
	  if($fdate <= $startdate)
	  {
	   $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$medacc' and client = '$client'  and crdr = 'Dr' and date = '$fdate' and type = 'IR'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $medinitir = $row2['cramount'];
	   
	  }
	  $medinitbal = $medinitbal + $medinitir;
	  }
	  /*$leftarray1[$leftcount] = "Medicine Opening";
	  $leftarray2[$leftcount] = round($medinitbal,2);
	  $leftcount = $leftcount + 1;*/
	  //$grleftcount = $grleftcount + round($medinitbal,2);
	  /*///Eggs Opening Stock
	  $query1 = "select distinct(iac),pvac from ims_itemcodes where cat = 'Layer Eggs' and client = '$client'   ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggacc = $row2['iac'];
	   $eggpvac = $row2['pvac'];
	  }
	   $query1 = "select sum(amount) as cramount,sum(quantity) as quant from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Cr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $egginitcr = $row2['cramount'];
	   $eggnuminitcr = $row2['quant'];
	  }
	   $query1 = "select sum(amount) as dramount,sum(quantity) as quant from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Dr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $egginitdr = $row2['dramount'];
	   $eggnuminitdr = $row2['quant'];
	  }
	  $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$eggpvac' and client = '$client'  and crdr = 'Cr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  $eggpvinitcr = $row2['cramount'];
	   
	  }
	  $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$eggpvac' and client = '$client'  and crdr = 'Dr' and date < '$fdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggpvinitdr = $row2['dramount'];
	   
	  }
	  
	  $eggpvfin = $eggpvinitdr - $eggpvinitcr;
	  $egginitbal = $egginitdr - $egginitcr ;
	  $eggnuminitbal = $eggnuminitdr - $eggnuminitcr;
	  if($fdate <= $startdate)
	  {
	  $query1 = "select sum(amount) as cramount,sum(quantity) as quant from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Dr' and date = '$fdate' and type = 'IR'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $egginitir = $row2['cramount'];
	   $eggnuminitir = $row2['quant'];
	  }
	  $egginitbal = $egginitbal + $egginitir;
	  $eggnuminitbal = $eggnuminitbal + $egginitir;
	  }
	  $eggreccnt = 0;
	  if($_SESSION['db'] == "skpfnew" )
	  {
	 $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$fdate'  and code = 'EG101'  ";
	$query11 = "select * from oc_cobi where client = '$client' and date = '$fdate'  and code = 'EG101'  ";
	  }
	  else
	  {
	  $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$fdate'  and code = 'EG103'  ";
	  $query11 = "select * from oc_cobi where client = '$client' and date = '$fdate'  and code = 'EG103'  ";
	  }
	   
      $result1 = mysql_query($query1,$conn1);
	  $result11 = mysql_query($query11,$conn1);
	  $eggreccnt = mysql_num_rows($result11);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $egginitprice = $row2['price'];
	  }
	  if($eggreccnt == 0)
	  {
	   $maxdate = "";
	   if($_SESSION['db'] == "skpfnew" )
	  {
	  $query1 = "select max(date) as maxdate from oc_cobi where client = '$client' and date <= '$fdate'  and code = 'EG101'  ";
	  }
	  else
	  {
	  $query1 = "select max(date) as maxdate from oc_cobi where client = '$client' and date <= '$fdate'  and code = 'EG103'  ";
	  }
	   
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $maxdate = $row2['maxdate'];
	  }
	   if($_SESSION['db'] == "skpfnew" )
	  {
	 $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$maxdate'  and code = 'EG101' ";
	  }
	  else
	  {
	  $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$maxdate'  and code = 'EG103'  ";
	  }
	    
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $egginitprice = $row2['price'];
	  }
	  }
	  //echo $egginitprice;
	  //echo $eggnuminitbal;
	  $egginitbalmain = $eggnuminitbal * $egginitprice;
	  $leftarray1[$leftcount] = "Eggs Opening";
	  $leftarray2[$leftcount] = round($egginitbalmain,2);
	  $leftarray3[$leftcount] = round($eggnuminitbal,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($egginitbal,2);*/
	  
	  
	  //Eggs Opening
	 
	  
	///////////////Intermediate Receipt  
	if($warehouse == "All")
	{
 $q11a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and cat LIKE '%Eggs%' and client = '$client' and riflag = 'R' and date < '$fdate' ";
 }
 else
 {
 $q11a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse = '$warehouse' and cat LIKE '%Eggs%' and client = '$client' and riflag = 'R' and date < '$fdate' ";
 }
$r11a = mysql_query($q11a,$conn1);
while($q11ra = mysql_fetch_assoc($r11a))
{
 $irquant = $q11ra['quant'];
}
////////////Towarehouse//////////////
if($warehouse == "All")
	{
$q12a = "select sum(toeggs) as te from ims_eggtransfer where towarehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and tocode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date < '$fdate'";
}
else
 {
 $q12a = "select sum(toeggs) as te from ims_eggtransfer where towarehouse = '$warehouse' and tocode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date < '$fdate'";
 }
$r12a = mysql_query($q12a,$conn1);
while($q12ra = mysql_fetch_assoc($r12a))
{
$te = $q12ra['te'];
}


////////////////////////////Purchases  
if($warehouse == "All")
	{
 $q13a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and date < '$fdate' and client = '$client'";
 }
 else
 {
 $q13a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse = '$warehouse' and date < '$fdate' and client = '$client'";
 }
		$r13a = mysql_query($q13a,$conn1);
		while($q13ra = mysql_fetch_assoc($r13a))
		{
		$bfpquantity = $q13ra['rq'];
		}
		///////////////////////////////////Sales
		if($warehouse == "All")
	{
 $q18a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and unit in(select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and date < '$fdate' and client = '$client'";
 }
 else
 {
 $q18a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and unit = '$warehouse' and date < '$fdate' and client = '$client'";
 }
		$r18a = mysql_query($q18a,$conn1);
		while($q18ra = mysql_fetch_assoc($r18a))
		{
		 $sbirds = $q18ra['soldbirds'];
		}
		///////////////////Intermediate Issue
		if($warehouse == "All")
	{
		 $q17a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and cat LIKE '%Eggs%' and client = '$client' and riflag = 'I' and date < '$fdate'";
		 }
		 else
		 {
		 $q17a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse = '$warehouse' and cat LIKE '%Eggs%' and client = '$client' and riflag = 'I' and date < '$fdate'";
		 
		 }
$r17a = mysql_query($q11a,$conn1);
while($q17ra = mysql_fetch_assoc($r17a))
{
$iiquant = $q17ra['quant'];
}
		////////////fromwarehouse//////////////
		if($warehouse == "All")
	{
 $q14a = "select sum(fromeggs) as fe from ims_eggtransfer where fromwarehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and fromcode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date < '$fdate'";
 }
 else
 {
 $q14a = "select sum(fromeggs) as fe from ims_eggtransfer where fromwarehouse = '$warehouse' and fromcode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date < '$fdate'";
 }
$r14a = mysql_query($q14a,$conn1);
while($q14ra = mysql_fetch_assoc($r14a))
{
$fe = $q14ra['fe'];
}

		////////////////////////Stock Adjust
		if($warehouse == "All")
	{
		$q15a = "select sum(quantity) as quant from ims_stockadjustment where unit in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and category LIKE '%Eggs%' and type = 'Add' and date < '$fdate' and client = '$client'";
		}
		else
		{
		$q15a = "select sum(quantity) as quant from ims_stockadjustment where warehouse = '$warehouse' and category LIKE '%Eggs%' and type = 'Add' and date < '$fdate' and client = '$client'";
		}
		$r15a = mysql_query($q15a,$conn1);
		while($q15ra = mysql_fetch_assoc($r15a))
		{
		$saquant = $q15ra['quant'];
		}
		if($warehouse == "All")
	{
		$q16a = "select sum(quantity) as quant1 from ims_stockadjustment where warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and category LIKE '%Eggs%' and type = 'Deduct' and date < '$fdate' and client = '$client'";
		}
		else
		{
		$q16a = "select sum(quantity) as quant1 from ims_stockadjustment where warehouse = '$warehouse' and category LIKE '%Eggs%' and type = 'Deduct' and date < '$fdate' and client = '$client'";
		
		}
		$r16a = mysql_query($q16a,$conn1);
		while($q16ra = mysql_fetch_assoc($r16a))
		{
		$saquant1 = $q16ra['quant1'];
		}
		

	  
//echo $irquant."/".$te."/".$bfpquantity."/".$sbirds."/".$iiquant."/".$fe."/".$saquant."/".$saquant1;
	     $layereggs = ($irquant + $te + $bfpquantity + $saquant) - ($sbirds + $iiquant + $fe + $saquant1);
		 if($warehouse == "All")
	{
	 $q19a = "select max(date) as date,price from oc_cobi where code in (select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and warehouse in (select distinct(sector) from tbl_sector where client = '$client' and type1 = 'Egg Center') and client = '$client' and date < '$fdate'";
	 }
	 else
	 {
	 $q19a = "select max(date) as date,price from oc_cobi where code in (select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and warehouse = '$warehouse' and client = '$client' and date < '$fdate'";
	 
	 }
	  $r19a = mysql_query($q19a,$conn1);
	  while($q19ra = mysql_fetch_assoc($r19a))
	  {
	  $price = $q19ra['price'];
	  }
	 $amount1 = $layereggs * $price;
	 // echo $feedinitbal;
	  $leftarray1[$leftcount] = "Eggs Opening";
	  $leftarray2[$leftcount] = round($amount1,2);
	  $leftarray3[$leftcount] = round($layereggs,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($amount1,2);
	  //Birds Opening Stock
	  //////////stock transfer//////
		$q1a = "SELECT sum( quantity ) AS quant FROM `ims_stocktransfer` WHERE (cat = 'Broiler Chicks'OR cat = 'Broiler Day Old Chicks') and date < '$fdate' and client = '$client'";
		$r1a = mysql_query($q1a,$conn1);
		while($qra = mysql_fetch_assoc($r1a))
		{
		$stquantity = $qra['quant'];
		}
		/////////purchases/////////
		$q2a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' and client = '$client') and date < '$fdate' and client = '$client'";
		$r2a = mysql_query($q2a,$conn1);
		while($qr2a = mysql_fetch_assoc($r2a))
		{
		$pquantity = $qr2a['rq'];
		}
		/////////mort,culls//////
		$q3a = "select sum(mortality) as mort,sum(cull) as culls from broiler_daily_entry where entrydate < '$fdate' and client = '$client'";
		$r3a = mysql_query($q3a,$conn1);
		while($qr3a = mysql_fetch_assoc($r3a))
		{
		$mort = $qr3a['mort'];
		$cull = $qr3a['culls'];
		}
		/////////////////sales//////////
		$q4a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' and client = '$client') and date < '$fdate' and client = '$client'";
		$r4a = mysql_query($q4a,$conn1);
		while($qr4a = mysql_fetch_assoc($r4a))
		{
		$sbirds = $qr4a['soldbirds'];
		}
		$rembirds = ($stquantity + $pquantity) - ($mort + $cull + $sbirds);
		
		$q5a = "select stdcost from ims_itemcodes where cat = 'Broiler Birds'";
		$r5a = mysql_query($q5a,$conn1);
		while($qr5a = mysql_fetch_assoc($r5a))
		{
		$scost = $qr5a['stdcost'];
		}
		
			
		//echo $row2['flock']; echo "&nbsp;";
		//echo $birds; echo "&nbsp;";
		//echo $birdsinit; echo "&nbsp;";
		//echo $mortality; echo "&nbsp;";
		//echo $cull; echo "&nbsp;";
		//echo $transferin; echo "&nbsp;";
		//echo $transferout; echo "</br>";
		//echo $age; echo "&nbsp;";
		//echo $stdprice; echo "</br>";
		
		//$amuntnew = $scost * $rembirds;
	//echo $totbirds; 
	//  $totbirdscost;
	  //$birdsinitbal = $birdob - $mortality - $cull + $birdsinitdr - $birdsinitcr;
	  //$birdsinitrate = $birdsinitbal * $birdsstdcost;
	  /*$leftarray1[$leftcount] = "Broiler Birds Opening";
	  $leftarray2[$leftcount] = $amuntnew;
	  $leftarray3[$leftcount] = $rembirds;
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + $amuntnew;*/
	?>
	
<?php
$leftarray1[$leftcount] = "Purchases";
	  $leftarray2[$leftcount] = "";
	  $leftcount = $leftcount + 1;
//Purchases
//Ingredients Purchase
if($warehouse == "All")
{
 $q1aa = "select sum(receivedquantity * rateperunit) as product,sum(receivedquantity) as rq from pp_sobi where code in (select distinct(code) from ims_itemcodes where cat LIKE '%Eggs%' and client = '$client') and warehouse in (select distinct(sector) from tbl_sector where client = '$client' and type1 = 'Egg Center')and client = '$client' and date >= '$fdate' and date <='$tdate'";
}
else
{
$q1aa = "select sum(receivedquantity * rateperunit) as product,sum(receivedquantity) as rq from pp_sobi where code in (select distinct(code) from ims_itemcodes where cat LIKE '%Eggs%' and client = '$client') and warehouse = '$warehouse' and client = '$client' and date >= '$fdate' and date <='$tdate'";
}
$r1aa = mysql_query($q1aa,$conn1);
while($qraa = mysql_fetch_assoc($r1aa))
{
 $rq = $qraa['rq'];
 $product = $qraa['product'];
}
 
	  $leftarray1[$leftcount] = "Eggs Purchased";
	  $leftarray2[$leftcount] = round($product,2);
	    $leftarray3[$leftcount] = round($rq,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($product,2);
	  ?>
	  <?php
//Broiler Chicks Purchase

 $query1 = "select sum(quantity) as quan from ims_stocktransfer where client = '$client' and (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') and (date >= '$fdate' and date <= '$tdate')";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $bcprch = $row2['quan'];
	  }
	   $query2 = "select sum(receivedquantity * rateperunit ) as rq from pp_sobi where code in (select distinct(code) from ims_itemcodes where (cat = 'Broiler Chicks' )) and client = 'LAKSHMI' and date >= '$fdate' and date <= '$tdate'";
	  $result2 = mysql_query($query2,$conn1);
	  while($row1 = mysql_fetch_assoc($result2))
	  {
	   $rq = $row1['rq'];
	  
	  
	  }
	  /*$leftarray1[$leftcount] = "Broiler Chicks Purchase";
	  $leftarray2[$leftcount] = round($rq,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($rq,2);*/
	  /*
//Feed Purchase
$query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$feedacc' and client = '$client'  and crdr = 'Dr' and date >= '$fdate' and date <= '$tdate' and type = 'SOBI'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $feedprch = $row2['dramount'];
	  }
	  $leftarray1[$leftcount] = "Feed Purchases";
	  $leftarray2[$leftcount] = round($feedprch,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($feedprch,2);
//Eggs Purchase
$query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Dr' and date >= '$fdate' and date <= '$tdate' and type = 'SOBI'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggprch = $row2['dramount'];
	  }
	  $leftarray1[$leftcount] = "Eggs Purchase";
	  $leftarray2[$leftcount] = round($eggprch,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($eggprch,2);
//Birds Purchase
$birdsprch = 0;
 $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$birdsacc' and client = '$client'  and crdr = 'Dr' and date >= '$fdate' and date <= '$tdate' and type = 'SOBI'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $birdsprch = $row2['dramount'];
	  }
	  $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$birdsacc' and client = '$client'  and crdr = 'Cr' and date >= '$fdate' and date <= '$tdate' and type = 'II'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $birdsprch = $birdsprch - $row2['dramount'];
	  }
	  $leftarray1[$leftcount] = "Birds Purchase";
	  $leftarray2[$leftcount] = round($birdsprch,2);
	  $leftcount = $leftcount + 1;
	  $grleftcount = $grleftcount + round($birdsprch,2);
	  */
?>
<?php 
$rightarray1[$rightcount] = "Sales";
$rightarray2[$rightcount] = "";
$rightarray3[$rightcount] = "";
$rightcount = $rightcount + 1;
//Sales
if($warehouse == "All")
{
$q1aa = "select sum(quantity * price) as price,sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and unit in(select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and date >= '$fdate' and date <='$tdate' and client = '$client'";
}
else
{
$q1aa = "select sum(quantity * price) as price,sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and unit = '$warehouse' and date >= '$fdate' and date <='$tdate' and client = '$client'";

}
$r1aa = mysql_query($q1aa,$conn1);
while($qraa = mysql_fetch_assoc($r1aa))
{
$price = $qraa['price'];
 $soldbirds = $qraa['soldbirds'];

}
	 
	  
	  $rightarray1[$rightcount] = "Eggs Sales";
	  $rightarray2[$rightcount] = round($price,2);
	  $rightarray3[$rightcount] = round($soldbirds,2);
	  $rightcount = $rightcount + 1;
	  $grrightcount = $grrightcount + round($price,2);

?>	
<?php
//Closing Stock
//Ingredient Closing Stock
	  $rightarray1[$rightcount] = "Closing Stock";
	  $rightarray2[$rightcount] = "";
	  $rightcount = $rightcount + 1;
	 $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$ingacc' and client = '$client'  and crdr = 'Cr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $ingclscr = $row2['cramount']; 
	  }
	   $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$ingacc' and client = '$client'  and crdr = 'Dr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $ingclsdr = $row2['dramount']; 
	  }
	  $ingclsbal = 0;
	  $ingclsbal = $ingclsdr - $ingclscr;
	  
	  /*$rightarray1[$rightcount] = "Ingredient Closing Stock";
	  $rightarray2[$rightcount] = round($ingclsbal,2);
	  $rightcount = $rightcount + 1;*/
	   //$grrightcount = $grrightcount + round($ingclsbal,2);
	  //Medicine Closing Stock
	
	 $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$medacc' and client = '$client'  and crdr = 'Cr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $medclscr = $row2['cramount'];
	  }
	   $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$medacc' and client = '$client'  and crdr = 'Dr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $medclsdr = $row2['dramount'];
	  }
	  $medclsbal = 0;
	  $medclsbal = $medclsdr - $medclscr;
	  
	   /*$rightarray1[$rightcount] = "Medicine Closing Stock";
	  $rightarray2[$rightcount] = round($medclsbal,2);
	  $rightcount = $rightcount + 1;*/
	  //$grrightcount = $grrightcount + round($medclsbal,2);
	  //Eggs Closing Stock
	  
	 $query1 = "select sum(amount) as cramount,sum(quantity) as crqty from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Cr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggclscr = $row2['cramount'];
	   $eggnumclscr = $row2['crqty'];
	  }
	  $query1 = "select sum(amount) as dramount,sum(quantity) as drqty from ac_financialpostings where coacode = '$eggacc' and client = '$client'  and crdr = 'Dr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggclsdr = $row2['dramount'];
	   $eggnumclsdr = $row2['drqty'];
	  }
	  $eggstock = $eggnumclsdr - $eggnumclscr;
 $finnxtdate = strtotime($tdate);
	  $finnxtdate = $finnxtdate + (24 * 60 * 60);
	  $finnxtdate = date("Y-m-d",$finnxtdate);
        $eggreccnt = 0;
		$eggprice = 0;
		if($_SESSION['db'] == "skpfnew")
		{
		$query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$finnxtdate' and code = 'EG101'  ";
		}
		else
		{
		$query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$finnxtdate' and code = 'EG103'  ";
		}
        
      $result1 = mysql_query($query1,$conn1);
	  $eggreccnt = mysql_num_rows($result1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $eggprice = $row2['price'];
	  }
	  
      if($eggprice == 0)
	  {
	   $maxdate = "";
	   if($_SESSION['db'] == "skpfnew")
	   {
	   $query1 = "select max(date) as maxdate from oc_cobi where client = '$client' and date <= '$finnxtdate'  and code = 'EG101'  ";
	   }
	   else
	   {
	   $query1 = "select max(date) as maxdate from oc_cobi where client = '$client' and date <= '$finnxtdate'  and code = 'EG103'  ";
	   }
	   
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $maxdate = $row2['maxdate'];
	  }
	  if($_SESSION['db'] == "skpfnew")
	  {
	  $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$maxdate'  and code = 'EG101'  ";
	  }
	  else
	  {
	  $query1 = "select sum(quantity * price)/sum(quantity) as price from oc_cobi where client = '$client' and date = '$maxdate'  and code = 'EG103'  ";
	  }
	    
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	    $eggprice = $row2['price'];
	  }
	  }
         $eggprice;
	   $query1 = "select sum(amount) as cramount from ac_financialpostings where coacode = '$eggpvac' and client = '$client'  and crdr = 'Cr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggpvclscr = $row2['cramount'];
	  }
	   $query1 = "select sum(amount) as dramount from ac_financialpostings where coacode = '$eggpvac' and client = '$client'  and crdr = 'Dr' and date <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $eggpvclsdr = $row2['dramount'];
	  }
	  
	  $eggpvfin = $eggpvclsdr - $eggpvclscr;
	  $totprod = 0;
	   $query1 = "select sum(quantity) as totprod from breeder_production where client = '$client'  and date1 <= '$tdate'  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	   $totprod = $row2['totprod'];
	  }
	  $variance = round(($eggpvfin/$totprod),2);
	  $variance = round(($variance * $eggstock),2);
	  $eggclsbal = 0;
	 // $eggclsbal = $eggclsdr - $eggclscr + $variance ;
	  //$eggclsbal = $eggclsdr - $eggclscr ;
	  
	   /*$rightarray1[$rightcount] = "Eggs Closing Stock";
	  $rightarray2[$rightcount] = round(($eggstock * $eggprice),2);
	   $rightarray3[$rightcount] = round($eggstock,2);
	  $rightcount = $rightcount + 1;
	 $grrightcount = $grrightcount + round(($eggstock * $eggprice),2);*/

	   //Eggs Closing Stock
	 
	  
	///////////////Intermediate Receipt  
	if($warehouse == "All")
	{
 $q11a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and cat LIKE '%Eggs%' and client = '$client' and riflag = 'R' and date <= '$tdate' ";
 }
 else
 {
 $q11a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse = '$warehouse' and cat LIKE '%Eggs%' and client = '$client' and riflag = 'R' and date <= '$tdate' ";
 
 }
 
$r11a = mysql_query($q11a,$conn1);
while($q11ra = mysql_fetch_assoc($r11a))
{
 $irquant = $q11ra['quant'];
}
////////////Towarehouse//////////////
if($warehouse == "All")
	{
$q12a = "select sum(toeggs) as te from ims_eggtransfer where towarehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and tocode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date <= '$tdate'";
}
else
{
$q12a = "select sum(toeggs) as te from ims_eggtransfer where towarehouse = '$warehouse' and tocode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date <= '$tdate'";
}
$r12a = mysql_query($q12a,$conn1);
while($q12ra = mysql_fetch_assoc($r12a))
{
$te = $q12ra['te'];
}


////////////////////////////Purchases  
if($warehouse == "All")
	{
 $q13a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and date <= '$tdate' and client = '$client'";
 }
 else
 {
 $q13a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse = '$warehouse' and date <= '$tdate' and client = '$client'";
 }
		$r13a = mysql_query($q13a,$conn1);
		while($q13ra = mysql_fetch_assoc($r13a))
		{
		$bfpquantity = $q13ra['rq'];
		}
		///////////////////////////////////Sales
		if($warehouse == "All")
	{
 $q18a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse in(select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and date <= '$tdate' and client = '$client'";
 }
 else
 {
 $q18a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat LIKE '%Eggs%' and client = '$client') and warehouse = '$warehouse' and date <= '$tdate' and client = '$client'";
 
 }
		$r18a = mysql_query($q18a,$conn1);
		while($q18ra = mysql_fetch_assoc($r18a))
		{
		 $sbirds = $q18ra['soldbirds'];
		}
		///////////////////Intermediate Issue
		if($warehouse == "All")
	{
		 $q17a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and cat LIKE '%Eggs%' and client = '$client' and riflag = 'I' and date <= '$tdate'";
		 }
		 else
		 {
		 $q17a = "select sum(quantity) as quant from ims_intermediatereceipt where warehouse = '$warehouse' and cat LIKE '%Eggs%' and client = '$client' and riflag = 'I' and date <= '$tdate'";
		 }
$r17a = mysql_query($q11a,$conn1);
while($q17ra = mysql_fetch_assoc($r17a))
{
$iiquant = $q17ra['quant'];
}
		////////////fromwarehouse//////////////
		if($warehouse == "All")
	{
 $q14a = "select sum(fromeggs) as fe from ims_eggtransfer where fromwarehouse in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and fromcode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date <= '$tdate'";
 }
 else
 {
 $q14a = "select sum(fromeggs) as fe from ims_eggtransfer where fromwarehouse = '$warehouse' and fromcode in(select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and client = '$client' and date <= '$tdate'";
 }
$r14a = mysql_query($q14a,$conn1);
while($q14ra = mysql_fetch_assoc($r14a))
{
$fe = $q14ra['fe'];
}

		////////////////////////Stock Adjust
		if($warehouse == "All")
	{
		$q15a = "select sum(quantity) as quant from ims_stockadjustment where unit in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and category LIKE '%Eggs%' and type = 'Add' and date <= '$tdate' and client = '$client'";
		}
		else
		{
		$q15a = "select sum(quantity) as quant from ims_stockadjustment where unit = '$warehouse' and category LIKE '%Eggs%' and type = 'Add' and date <= '$tdate' and client = '$client'";
		}
		$r15a = mysql_query($q15a,$conn1);
		while($q15ra = mysql_fetch_assoc($r15a))
		{
		$saquant = $q15ra['quant'];
		}
		if($warehouse == "All")
	{
		$q16a = "select sum(quantity) as quant1 from ims_stockadjustment where unit in (select distinct(sector) from tbl_sector where type1 = 'Egg Center' and client = '$client') and category LIKE '%Eggs%' and type = 'Deduct' and date <= '$tdate' and client = '$client'";
		}
		else
		{
		$q16a = "select sum(quantity) as quant1 from ims_stockadjustment where unit = '$warehouse' and category LIKE '%Eggs%' and type = 'Deduct' and date <= '$tdate' and client = '$client'";
		}
		$r16a = mysql_query($q16a,$conn1);
		while($q16ra = mysql_fetch_assoc($r16a))
		{
		$saquant1 = $q16ra['quant1'];
		}
		

	  
//echo $irquant."/".$te."/".$bfpquantity."/".$sbirds."/".$iiquant."/".$fe."/".$saquant."/".$saquant1;
	     $layereggs = ($irquant + $te + $bfpquantity + $saquant) - ($sbirds + $iiquant + $fe + $saquant1);
		 if($warehouse == "All")
		 {
	 $q19a = "select max(date) as date,price from oc_cobi where code in (select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and unit in (select distinct(sector) from tbl_sector where client = '$client' and type1 = 'Egg Center') and client = '$client' and date <= '$tdate'";
	 }
	 else
	 {
	 $q19a = "select max(date) as date,price from oc_cobi where code in (select distinct(code) from ims_itemcodes where client = '$client' and cat LIKE '%Eggs%') and unit = '$warehouse' and client = '$client' and date <= '$tdate'";
	 
	 }
	  $r19a = mysql_query($q19a,$conn1);
	  while($q19ra = mysql_fetch_assoc($r19a))
	  {
	  $price = $q19ra['price'];
	  }
	 $amount1 = $layereggs * $price;
	  //echo "/".$feedclsbal;
	   $rightarray1[$rightcount] = "Eggs Closing";
	  $rightarray2[$rightcount] = round($amount1,2);
	  $rightarray3[$rightcount] = round($layereggs,2);
	  $rightcount = $rightcount + 1;
	  $grrightcount = $grrightcount + round($amount1,2);
	  //Birds Closing Stock
	  
	  //////////stock transfer//////
		$q1a = "SELECT sum( quantity ) AS quant FROM `ims_stocktransfer` WHERE (cat = 'Broiler Chicks'OR cat = 'Broiler Day Old Chicks') and date <= '$tdate' and client = '$client'";
		$r1a = mysql_query($q1a,$conn1);
		while($qra = mysql_fetch_assoc($r1a))
		{
		$stquantity = $qra['quant'];
		}
		
		/////////purchases/////////
		$q2a = "SELECT sum( receivedquantity ) AS rq FROM pp_sobi WHERE code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' and client = '$client') and date <= '$tdate' and client = '$client'";
		$r2a = mysql_query($q2a,$conn1);
		while($qr2a = mysql_fetch_assoc($r2a))
		{
		$pquantity = $qr2a['rq'];
		}
		/////////mort,culls//////
		$q3a = "select sum(mortality) as mort,sum(cull) as culls from broiler_daily_entry where entrydate <= '$tdate' and client = '$client'";
		$r3a = mysql_query($q3a,$conn1);
		while($qr3a = mysql_fetch_assoc($r3a))
		{
		$mort = $qr3a['mort'];
		$cull = $qr3a['culls'];
		}
		/////////////////sales//////////
		$q4a = "select sum(quantity) as soldbirds from oc_cobi where code IN (SELECT DISTINCT (code) FROM ims_itemcodes WHERE cat = 'Broiler Chicks' OR cat = 'Broiler Day Old Chicks' and client = '$client') and date <= '$tdate' and client = '$client'";
		$r4a = mysql_query($q4a,$conn1);
		while($qr4a = mysql_fetch_assoc($r4a))
		{
		$sbirds = $qr4a['soldbirds'];
		}
		$rembirds = ($stquantity + $pquantity) - ($mort + $cull + $sbirds);
		
		$q5a = "select stdcost from ims_itemcodes where cat = 'Broiler Birds'";
		$r5a = mysql_query($q5a,$conn1);
		while($qr5a = mysql_fetch_assoc($r5a))
		{
		$scost = $qr5a['stdcost'];
		}
			
		$amuntnew = $scost * $rembirds;
		//echo "Closing";
		//echo $row2['flock']; echo "&nbsp;";
		//echo $agecls; echo "&nbsp;";
           // echo $birdsfinal; echo "&nbsp;";
		//echo $stdpricecls; echo "</br>";
		
	 //echo $totbirdscls;
	  
	  
	 
	  /* $rightarray1[$rightcount] = "Broiler Birds Closing Stock";
	  $rightarray2[$rightcount] = round($amuntnew,2);
	  $rightarray3[$rightcount] = $rembirds;
	  $rightcount = $rightcount + 1;
	 $grrightcount = $grrightcount + round($amuntnew,2);*/
?>
<?php
$grlag = "";
$gramount = 0;

if($grrightcount > $grleftcount)
{
  $grflag = "left";
  $gramount = $grrightcount - $grleftcount;
}
else
{
  $grflag = "right";
  $gramount = $grleftcount - $grrightcount;
}
if($grflag == "left")
{
 $leftarray1[$leftcount] = "Gross Profit";
 $leftarray2[$leftcount] = $gramount;
 $leftcount = $leftcount + 1;
 
 $rightarray1[$rightcount] = "Gross Profit C/D";
 $rightarray2[$rightcount] = $gramount;
 $rightcount = $rightcount + 1;
}
else
{
 $leftarray1[$leftcount] = "Gross Loss C/D";
 $leftarray2[$leftcount] = $gramount;
 $leftcount = $leftcount + 1;
 
 $rightarray1[$rightcount] = "Gross Loss";
 $rightarray2[$rightcount] = $gramount;
 $rightcount = $rightcount + 1;
}
?>
	<?php
	$drtotal = 0;
  $crtotal = 0;
 
  $ecount = 0;
  $rcount = 0;
  $expsum = $grleftcount;
  $revsum = $grrightcount;
  $leftarray1[$leftcount] = "Indirect Expense";
 $leftarray2[$leftcount] = "";
 $leftcount = $leftcount + 1;
 
 $rightarray1[$rightcount] = "Indirect Income";
 $rightarray2[$rightcount] = "";
 $rightcount = $rightcount + 1;
	 include "config.php";
    $query1 = "select * from ac_coa where (type = 'Expense' or type = 'Revenue') and schedule in (select schedule from ac_schedule where (type = 'Expense' or type = 'Revenue') and client = '$client' and ptype <> 'Direct' ) and code <> '99999' order by description  ";
      $result1 = mysql_query($query1,$conn1);
	   while($row2 = mysql_fetch_assoc($result1))
      {
	  
	  $code = $row2['code']; 
	   $cramount = 0;
	   $dramount = 0;
	   $bal = 0;
	   $mbal = 0;
	   if($warehouse == "All")
	   {
	  $q = "select sum(amount) as cramount  from ac_financialpostings where crdr = 'Cr' and date >='$fdate' and client = '$client' and date <= '$tdate' and coacode = '$code' and warehouse in(select distinct(sector) from tbl_sector where type1 =  'Egg Center' and client = '$client') ";
	  }
	  else
	  {
	  $q = "select sum(amount) as cramount  from ac_financialpostings where crdr = 'Cr' and date >='$fdate' and client = '$client' and date <= '$tdate' and coacode = '$code' and warehouse = '$warehouse' ";
	  
	  }
	    $qrs = mysql_query($q,$conn1) or die(mysql_error());
	    while($qr = mysql_fetch_assoc($qrs))
	   {
	     $cramount = $cramount + $qr['cramount'];
	   }
	   if($warehouse == "All")
	   {
	   
	    $q = "select sum(amount) as dramount  from ac_financialpostings where crdr = 'Dr' and date >='$fdate' and client = '$client' and date <= '$tdate'  and coacode = '$code' and warehouse in(select distinct(sector) from tbl_sector where type1 =  'Egg Center' and client = '$client')  ";
		}
		else
		{
		 $q = "select sum(amount) as dramount  from ac_financialpostings where crdr = 'Dr' and date >='$fdate' and client = '$client' and date <= '$tdate'  and coacode = '$code' and warehouse = '$warehouse'  ";
		
		}
	    $qrs = mysql_query($q,$conn1) or die(mysql_error());
	    while($qr = mysql_fetch_assoc($qrs))
	   {
	     $dramount = $dramount + $qr['dramount'];
	   }
	 
	
	   
	  if ( $row2['type'] == "Expense" )
	  {
	    $mbal = $dramount - $cramount;
	  }
	  else
	  {
	   $mbal = $cramount - $dramount;
	  }
	  
	  if ( $row2['type'] == "Expense") 
	  {
           if ( $mbal == 0)
          {

          }
          else
          {
	   
		$leftarray1[$leftcount] = $row2['description'];
		$leftarray2[$leftcount] = $mbal;
		$expsum = $expsum + $mbal;
		$leftcount = $leftcount + 1;
          }
		
	  }
	  if ( $row2['type'] == "Revenue") 
	  {
           if ( $mbal == 0)
           {

           }
           else
           {
	    
		$rightarray1[$rightcount] = $row2['description'];
		$rightarray2[$rightcount] = $mbal;
		$revsum = $revsum + $mbal;
		$rightcount = $rightcount + 1;
           }
	  }  
?>
   
	
<?php	
	} // End detail records loop
	
?>
<?php
$netflag = "";
$netamt = 0;
if($revsum > $expsum)
{
 $netflag = "left";
 $netamt = $revsum - $expsum;
 $tot = $revsum;
}
else
{
 $netflag = "right";
 $netamt = $expsum - $revsum;
 $tot = $expsum;
}
if($netflag == "left")
{
 $leftarray1[$leftcount] = "Net Profit";
 $leftarray2[$leftcount] = $netamt;
 $leftcount = $leftcount + 1;
}
else
{
 $rightarray1[$rightcount] = "Net Loss";
 $rightarray2[$rightcount] = $netamt;
 $rightcount = $rightcount + 1;
}
?>
<?php 
 $highcount = 0;
   $highflag = "";
   $commncount = 0;
   if ( $rightcount > $leftcount)
   {
     $highcount = $rightcount;
	 $highflag = "right";
	 $commncount = $leftcount;
   }
   else
   {
     $highcount = $leftcount;
	 $highflag = "left";
	 $commncount = $rightcount;
   }
 $dumm = 0;
   while ( $dumm <= $commncount )
   { ?>
    <tr>
	
		
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue($leftarray1[$dumm]) ?>
		</td>
		<td class="ewRptGrpField3" align="right">
		<?php if( $leftarray3[$dumm] == "" ) { echo ewrpt_ViewValue("&nbsp;");  } else { echo ewrpt_ViewValue(changeprice($leftarray3[$dumm]));  } ?>
		</td>
		<td class="ewRptGrpField3" align="right">
		<?php if( $leftarray2[$dumm] == "" ) { echo ewrpt_ViewValue("&nbsp;");  } else { echo ewrpt_ViewValue(changeprice($leftarray2[$dumm])); $abal = $abal + $leftarray2[$dumm]; } ?>
		</td>
		
		<td>
         <?php echo ewrpt_ViewValue($rightarray1[$dumm]) ?>
        </td>
		<td align="right"> 
		 <?php if ( $rightarray3[$dumm] == "" ) { echo ewrpt_ViewValue("&nbsp;");  } else { echo ewrpt_ViewValue(changeprice($rightarray3[$dumm])); } ?>
         </td>
         <td align="right"> 
		 <?php if ( $rightarray2[$dumm] == "" ) { echo ewrpt_ViewValue("&nbsp;");  } else { echo ewrpt_ViewValue(changeprice($rightarray2[$dumm])); $lbal = $lbal + $rightarray2[$dumm]; } ?>
         </td>

	</tr> 
  <?php $dumm = $dumm + 1;  }
   ?>
	<?php if ( $highflag == "left" ) {
	while ($dumm < $leftcount) { ?>
	 <tr>
	
		
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue($leftarray1[$dumm]) ?>
		</td>
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
		<td class="ewRptGrpField3" align="right">
		<?php if( $leftarray2[$dumm] == "" ) { echo ewrpt_ViewValue("0.00");  } else { echo ewrpt_ViewValue(changeprice($leftarray2[$dumm])); $abal = $abal + $leftarray2[$dumm]; } ?>
		</td>
		
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
         <td align="right"> 
		 <?php  echo ewrpt_ViewValue("&nbsp;") ?>
         </td>

	</tr> 
	<?php $dumm = $dumm + 1; } } ?>
	<?php if ( $highflag == "right" ) { 
	    while( $dumm < $rightcount ) { ?>
	 <tr>
	
		
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue("&nbsp;") ?>
		</td>
		<td class="ewRptGrpField3" align="right">
		<?php  echo ewrpt_ViewValue("&nbsp;") ?>
		</td>
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
		<td>
         <?php echo ewrpt_ViewValue($rightarray1[$dumm]) ?>
        </td>
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
         <td align="right"> 
		 <?php if ( $rightarray2[$dumm] == "" ) { echo ewrpt_ViewValue("0.00");  } else { echo ewrpt_ViewValue(changeprice($rightarray2[$dumm])); $lbal = $lbal + $rightarray2[$dumm]; } ?>
         </td>

	</tr> 
	<?php $dumm = $dumm + 1; } } ?>
	
	
			
	<tr>
		
		<td class="ewRptGrpField2">
		<?php echo ewrpt_ViewValue("Total") ?>
		</td>
		<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
		<td class="ewRptGrpField3" align="right">
		<?php  echo ewrpt_ViewValue(changeprice($tot));  ?>
		</td>
		
		<td>
<?php echo ewrpt_ViewValue("Total") ?>
</td>
<td>

         <?php echo ewrpt_ViewValue("&nbsp;") ?>
        </td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($tot)); ?>
</td>

	</tr>
	
<?php

	// Next group
	$o_type = $x_type; // Save old group value
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
<form action="eggcenter.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>

	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="eggcenter.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
