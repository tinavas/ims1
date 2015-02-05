<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
include "../getemployee.php";
if($currencyunits == "")
{
$currencyunits = "Rs";
}
$fdatedump = $_GET['fromdate'];
$fdate = date("Y-m-j", strtotime($fdatedump));

$tdatedump = $_GET['todate'];
$tdate = date("Y-m-j", strtotime($tdatedump));


$ven = $_GET['vendor'];
$vflag = 0;
$cflag = 0;
include "config.php";
$quer1 = "select * from contactdetails where name = '$ven'   ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	  if ( ($row11['type'] == "party") or ($row11['type'] == "vendor and party") )
	  {
	    $cflag = 1;
	  }
	}

$url = "&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate']."&vendor=" . $_GET['vendor'];

?>

<?php include "reportheader.php"; ?>

<table align="center" border="0">
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Ageing Analysis</font></strong></td>
</tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Customer Name&nbsp;<?php echo $ven; ?></font></strong></td>
</tr>

<tr>
<td colspan="2" align="center"><font size="2">Till Date&nbsp;<?php echo $tdatedump; ?></font></td>
</tr>
</table>
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
$EW_REPORT_TABLE_SQL_WHERE = "";
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
&nbsp;&nbsp;<a href="vendorageing.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="vendorageing.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="vendorageing.php?export=word<?php echo $url; ?>">Export to Word</a>
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
<table class="ewGrid" align="center" cellspacing="0"><tr>
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
		<td valign="bottom" class="ewTableHeader">
		Supplier Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supplier Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Invoice No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Invoice No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		0 To 30 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>0 To 30 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		31 To 60 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>31 To 60 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		61 To 90 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>61 To 90 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		91 To 120 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>91 To 120 Days</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		121 To 150 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>121 To 150 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		151 To 180 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>151 To 180 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		181 Days And More
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>181 Days And More</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Grand Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Grand Total</td>
			</tr></table>
		</td>
<?php } ?>
</tr>
	
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}
 if ( $vflag == 1) 
 {
 ?>
	<?php
	$sumbal = 0;
$dup = 0;
$nubal = 0;
		$thbal = 0;
		$sibal = 0;
		$nibal = 0;
		$twbal = 0;
		$fibal = 0;
		$eibal = 0;
	 $q = "select adate,grandtotal,so from pp_sobi where vendor = '$ven' and adate <= '$tdate' group by so order by date   ";
	$qrs = mysql_query($q,$conn1) ;
	while($qr = mysql_fetch_assoc($qrs))
	{
		
		$amountpaid = 0;
		
	   $balamt = 0;
	 $quer11 = "select sum(sobiamount)  from pp_sobiclearance where sobi = '$qr[so]'   ";
	  $quers11 = mysql_query($quer11,$conn1) or die(mysql_error());
	  while($row111 = mysql_fetch_assoc($quers11))
	  { 
	     if ( $row111['sum(sobiamount)'] <> "")
		 {
		   $amountpaid = $row111['sum(sobiamount)'];
		 }
	    
	  }	
	   $quer11 = "select sum(amountpaid)  from pp_payment where posobi = '$qr[so]'   ";
	  $quers11 = mysql_query($quer11,$conn1) or die(mysql_error());
	  while($row111 = mysql_fetch_assoc($quers11))
	  { 
	     if ( $row111['sum(amountpaid)'] <> "")
		 {
		   $amountpaid = $amountpaid + $row111['sum(amountpaid)'];
		 }
	    
	  }	
	  $balamt = $qr['grandtotal'] - $amountpaid;
	  $diffdays = 0;
	  if ( $balamt > 0 )
	  {
	  
	   $dumdate = strtotime($qr['adate']);
		$dumdate1 = strtotime($tdate);
		$difsecs = $dumdate1 - $dumdate;
		 $difdays = round(($difsecs/(60 * 60 * 24)),0); 
?>
   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue(date("d-m-Y",strtotime($qr['adate']))) ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue($qr['so']) ?>
		</td>
		<td align="right">
<?php if ($difdays < 31) { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt;  $nubal = $nubal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
		<td align="right">
<?php if (($difdays > 30) and ($difdays < 61))  {  echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 60) and ($difdays < 91))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt;  }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 90) and ($difdays < 121))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 120) and ($difdays < 151))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 150) and ($difdays < 181))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if ($difdays > 180)   { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal)); ?>
</td>

	</tr>
	 <?php 
	 }
	 }
	 $clamt = 0;
	  $quer1 = "select sum(sobiamount) as clpmt from pp_sobiclearance where sourcetype = 'Payment' and vendor = '$ven' and date <= '$tdate' ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	$clamt = $row11['clpmt'];
	}
	 $quer1 = "select sum(amountpaid) as opmt from pp_payment where choice = 'On A/C' and vendor = '$ven' and adate <= '$tdate' ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	   if ( $row11['opmt'] <> "" ) {
	  ?>
	  <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("On Account Payment") ?>
		</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;"); 
 ?>
</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;"); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice(($row11['opmt'] - $clamt))); $sumbal = $sumbal + $clamt - ($row11['opmt'] );  ?>
</td>

	</tr>
	  <?php } ?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("Outstanding Balance") ?>
		</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nubal)); 
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal));?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal));  ?>
</td>

	</tr>
	 
<?php }	} // End detail records loop
	
?>
<?php 
  if ( $cflag == 1) 
 {
 ?>
 <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("Customer Account") ?>
		</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;"); 
 ?>
</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;"); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($row11['opmt'])); $sumbal = $sumbal - $row11['opmt'];  ?>
</td>

	</tr>
	<?php
	$sumbal = 0;
$dup = 0;
$nubal = 0;
$thbal = 0;
$sibal = 0;
$nibal = 0;
$twbal = 0;
$fibal = 0;
$eibal = 0;

	 $q = "select date as adate,finaltotal,invoice from oc_cobi where party = '$ven' and date <= '$tdate' group by invoice order by date ";
	$qrs = mysql_query($q,$conn1) ;
	while($qr = mysql_fetch_assoc($qrs))
	{
		
		$amountpaid = 0;
	   $balamt = 0;
	   $quer11 = "select sum(amountreceived)  from oc_receipt where socobi = '$qr[invoice]'  ";
	  $quers11 = mysql_query($quer11,$conn1) or die(mysql_error());
	  while($row111 = mysql_fetch_assoc($quers11))
	  { 
	     if ( $row111['sum(amountreceived)'] <> "")
		 {
		    $amountpaid = $row111['sum(amountreceived)'];
		 }
	    
	  }	
	  $quer11 = "select sum(sourceamount)  from oc_cobiclearance where cobi = '$qr[invoice]'  ";
	  $quers11 = mysql_query($quer11,$conn1) or die(mysql_error());
	  while($row111 = mysql_fetch_assoc($quers11))
	  { 
	     if ( $row111['sum(sourceamount)'] <> "")
		 {
		    $amountpaid = $mountpaid + $row111['sum(sourceamount)'];
		 }
	    
	  }	
	  $balamt = $qr['finaltotal'] - $amountpaid;
	  $diffdays = 0;
	  if ( $balamt > 0 )
	  {
	  
	    $dumdate = strtotime($qr['adate']);
		$dumdate1 = strtotime($tdate);
		$difsecs = $dumdate1 - $dumdate;
		 $difdays = round(($difsecs/(60 * 60 * 24)),0); 
?>
   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue(date("d-m-Y",strtotime($qr['adate']))) ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue($qr['invoice']) ?>
		</td>
		<td align="right">
<?php if ($difdays < 31) { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $nubal = $nubal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
		<td align="right">
<?php if (($difdays > 30) and ($difdays < 61))  {  echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 60) and ($difdays < 91))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 90) and ($difdays < 121))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 120) and ($difdays < 151))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 150) and ($difdays < 181))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if ($difdays > 180)   { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal)); ?>
</td>

	</tr>
	 <?php 
	 }
	 }
	$quer11 = "select sum(sourceamount)  from oc_cobiclearance where party = '$ven' and sourcetype = 'Advance'  ";
	  $quers11 = mysql_query($quer11,$conn1) or die(mysql_error());
	  while($row111 = mysql_fetch_assoc($quers11))
	  { 
	     if ( $row111['sum(sourceamount)'] <> "")
		 {
		    $amountpaid = $row111['sum(sourceamount)'];
		 }
	    
	  }	
	 $quer1 = "select sum(amount) as opmt from oc_receipt where choice = 'On A/C' and party = '$ven' and adate <= '$tdate' ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	   if ( $row11['opmt'] <> "" ) {
	  ?>
	  <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("On Account Payment") ?>
		</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;"); 
 ?>
</td>
		<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td>
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;"); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue("&nbsp;");?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($row11['opmt'])); $sumbal = $sumbal + $amountpaid - $row11['opmt'];  ?>
</td>

	</tr>
	  <?php } ?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("Outstanding Balance") ?>
		</td>
		<td style="text-align:right ">
<?php echo ewrpt_ViewValue(changeprice($nubal)); 
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal));?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal));  ?>
</td>

	</tr>
	 
<?php }	} // End detail records loop
	
?>
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


