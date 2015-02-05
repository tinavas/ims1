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
#$fdatedump = $_POST['date2'];
$fdatedump = $_GET['fromdate'];
$fdate = date("Y-m-j", strtotime($fdatedump));

#$tdatedump = $_POST['date3'];
$tdatedump = $_GET['todate'];
$tdate = date("Y-m-j", strtotime($tdatedump));
$url = "&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];

?>
<?php include "reportheader.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Ratio Analysis</font></strong></td>
</tr>
<tr>
<td colspan="2"><font size="2">From Date&nbsp;<?php echo $fdatedump; ?>
                To Date &nbsp;<?php echo $tdatedump;?></font></td>
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
<script type="text/javascript" src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptjs/popup.js" type="text/javascript"></script>
<script src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="file:///C|/wamp/www/checkwwwroot/wwwroot/FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
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
<!-- Table Container (Begin) -->
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="file:///C|/wamp/www/checkwwwroot/wwwroot/balancesheet.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="file:///C|/wamp/www/checkwwwroot/wwwroot/balancesheet.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="file:///C|/wamp/www/checkwwwroot/wwwroot/balancesheet.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php } ?>
<br /><br />
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top" ><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker" >
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<table class="ewGrid" cellspacing="0" align="center">
<tr>
	<td class="ewGridContent"></td></tr>
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
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
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
		<td valign="bottom" class="ewTableHeader" colspan="1" align="center">
		Principal Groups
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="1" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Principal Groups</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		<?php 
	
 		?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" width="75"><?php ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		<?php 
	
 		?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" width="45"><?php ?></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="1" align="center">
		Principal Groups
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="1" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Principal Groups</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		
		<?php 
	
 		?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center" width="75"><?php ?></td>
			</tr></table>
		</td>
<?php } ?>


	<!--<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Working Capital</br>
		Current Assets - Current Liabilities
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>
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
		<td valign="bottom" class="ewTableHeader" align="center">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Code</td>
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
		<td valign="bottom" class="ewTableHeader" >&nbsp;
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>&nbsp;</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>-->
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}
////////for Current Assets
 $qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(code) from ac_coa where type = 'Asset') and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];
 
}
 $qury1 = "select sum(amount) as amt1 from ac_financialpostings where coacode in (select distinct(code) from ac_coa where type = 'Asset') and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
$dramount = $r1['amt1'];

}
if($cramount > $dramount)
{
$casset = ($cramount - $dramount);
$crdra = "Cr";
}
else
{
$casset = ($dramount - $cramount);
$crdra = "Dr";
}



///////for current liabilities
$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(code) from ac_coa where type = 'Liability') and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
$cramount = $r1['amt'];

}
$qury1 = "select sum(amount) as amt1 from ac_financialpostings where coacode in (select distinct(code) from ac_coa where type = 'Liability') and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
$dramount = $r1['amt1'];

}
if($cramount > $dramount)
{
$cliab = ($cramount - $dramount);
$crdrl = "Cr";
}
else
{
$cliab = ($dramount - $cramount);
$crdrl = "Dr";
}


$workcap = round(($casset - $cliab),2); 


$cratio = round(($casset / $cliab),2);
if($casset > $cliab)
{
$crdrwc = "$crdrl";
}
else
{
$crdrwc = "$crdra";
}



//////////Cash in hand

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(coacode) from ac_bankmasters 
WHERE MODE = 'Cash') and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}

 $qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(coacode) from ac_bankmasters 
WHERE MODE = 'Cash') and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
$dramount = $r1['amt'];

}

if($cramount > $dramount)
{
$cih = round(($cramount -$dramount),2);
$crdrc = "Cr";

}
else
{
$cih = round(($dramount -$cramount),2);
$crdrc = "Dr";
}


//////////Bank Accounts

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(coacode) from ac_bankmasters 
WHERE MODE = 'Bank') and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(coacode) from ac_bankmasters 
WHERE MODE = 'Bank') and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $dramount = $r1['amt'];

}

if($cramount > $dramount)
{
$ba = round(($cramount -$dramount),2);
$crdrb = "Cr";

}
else
{
$ba = round(($dramount -$cramount),2);
$crdrb = "Dr";
}


/////////////sundry debtors

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vca from ac_vgrmap where flag = 'C' ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}



$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vca from ac_vgrmap where flag = 'C' ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $dramount = $r1['amt'];

}


if($cramount > $dramount)
{
$vcaamt = round(($cramount - $dramount),2);
$crdrvc = "Cr";

}
else
{
$vcaamt = round(($dramount - $cramount),2);
$crdrvc = "Dr";
}


$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vppac from ac_vgrmap where flag = 'C' ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vppac from ac_vgrmap where flag = 'C' ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $dramount = $r1['amt'];

}
if($cramount > $dramount)
{
$vppacamt = ($cramount - $dramount);
$crdrvp = "Cr";
}
else
{
$vppacamt = ($dramount - $cramount);
$crdrvp = "Dr";
}







$sdryd = round(($vcaamt - $vppacamt),2);

if($vcaamt > $vppacamt)
{
$crdrsd = "$crdrvp";
}
else
{
$crdrsd = "$crdrvc";
$sdryd = -($sdryd);
}



///////////Sundry Creditors


$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vca from ac_vgrmap where flag = 'V' ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vca from ac_vgrmap where flag = 'V' ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $dramount = $r1['amt'];

}


if($cramount > $dramount)
{
$vcaamt = ($cramount - $dramount);
$crdrvc = "Cr";

}
else
{
$vcaamt = ($dramount - $cramount);
$crdrvc = "Dr";
}

 

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vppac from ac_vgrmap where flag = 'C' ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $cramount = $r1['amt'];

}

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select vppac from ac_vgrmap where flag = 'C' ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
 $dramount = $r1['amt'];

}

if($cramount > $dramount)
{
$vppacamt = round(($cramount - $dramount),2);
$crdrvp = "Cr";
}
else
{
$vppacamt = round(($dramount - $cramount),2);
$crdrvp = "Dr";
}


$sdryc = round(($vcaamt - $vppacamt),2);

if($vcaamt > $vppacamt)
{

$crdrsc = $crdrvp;
}
else
{
$crdrsc = $crdrvc;
$sdryc = -($sdryc);
}

//////////Sales Account
$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(sac) from ims_itemcodes ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
	 
$cramount = $r1['amt'];

}

$qury1 = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(sac) from ims_itemcodes ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
 $dramount = $r1['amt'];

}
if($cramount > $dramount)
{
$sa = round(($cramount - $dramount),2);
$crdrsa = "Cr";

}
else
{
$sa = round(($dramount - $cramount),2);
$crdrsa = "Dr";
}
///////////Stock in Hand
$qu2a = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(iac) from ims_itemcodes ) and crdr = 'Dr' and (date > '$fdate' and date < '$tdate')";
$res = mysql_query($qu2a,$conn1) or die(mysql_error());
while($r2a = mysql_fetch_assoc($res))
{
$dr1 = $r2a['amt'];
}
$qu22a = "select sum(amount) as amt from ac_financialpostings where coacode in (select distinct(iac) from ims_itemcodes ) and crdr = 'Cr' and (date > '$fdate' and date < '$tdate')";
$res2 = mysql_query($qu22a,$conn1) or die(mysql_error());
while($r22a = mysql_fetch_assoc($res2))
{
$cr1 = $r22a['amt'];
}
if($cr1 > $dr1)
{
$sh = round(($cr1 - $dr1),2);
$crdrsh = "Cr";

}
else
{
$sh = round(($dr1 - $cr1),2);
$crdrsh = "Cr";
}


/////////Purchases Account
 $dramount = 0;
 $qury1 = "SELECT sum( totalamount ) as amt FROM pp_sobi where (date > '$fdate' and date < '$tdate') GROUP BY so ";
$res1 = mysql_query($qury1,$conn1) or die(mysql_error());
	   while($r1 = mysql_fetch_assoc($res1))
	   {
 $dramount =  $dramount + $r1['amt'];

}
$pa = round(($dramount),2);


////wkg.Capital-turnover

$wct = ($sa/$workcap);

	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>

		
	<tr>
	
	
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Working Capital</br>
		(Current Assets - Current Liabilities)"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($workcap)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($crdrwc) ?>
</td>
		
		
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Current Ratio </br>
		(Current Assets : Current Liabilities)"; ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(changeprice($cratio)) ?>
</td>


		
		
	</tr>
	
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Cash-in-hand"; ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(changeprice($cih)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue($crdrc) ?>
</td>


		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo "Quick Ratio</br>
Current Assets-stock-in-hand : Current Liabilities"; ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>

		
	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Bank Accounts"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(changeprice($ba)) ?>
</td>

<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue($crdrb) ?>
</td>
		

	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Bank OD A/c"; ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo "Debt/Equity Ratio </br>
(Loans(Liability) : Capital Account + Nett Profit)"; ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2" align="right">
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>
	
		
	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Sundry Debtors</br> (due till today)"; ?>
</td>

		
		<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(changeprice($sdryd)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue($crdrsd) ?>
</td>

	</tr>

	<tr>
	<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo "Sundry Creditors </br>
(due till today)"; ?>
</td>
<td<?php echo $sItemRowClass; ?> rowspan="2" align="right">
<?php echo ewrpt_ViewValue(changeprice($sdryc)) ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2" align="right">
<?php echo ewrpt_ViewValue($crdrsc) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Gross Profit%"; ?>
</td>
		
		
<td<?php echo $sItemRowClass; ?> >
<?php echo ewrpt_ViewValue($x_description) ?>
</td>

		
		
	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Nett Profit %"; ?>
</td>
		
<td<?php echo $sItemRowClass; ?> >
<?php echo ewrpt_ViewValue($x_description) ?>
</td>


	</tr>
	
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Sales Accounts"; ?>
</td>
		
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($sa)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($crdrsa) ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo "Operating Cost%</br>
(as percentage of Sales Accounts)"; ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>


		
	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Purchase Accounts"; ?>
</td>
		
		<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(changeprice($pa)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right" >
<?php echo ewrpt_ViewValue(Dr) ?>
</td>


	</tr>
<!-- /////////////////////////////////////////////////////////////-->
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Stock-in-hand"; ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(changeprice($sh)) ?>
</td>
		
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($crdrsh) ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo "Recv. Turnover in days</br>
(payment performance of Debtors)"; ?>
</td>
		<td<?php echo $sItemRowClass; ?> rowspan="2">
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>

		
	</tr>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Nett Profit"; ?>
</td>
<td<?php echo $sItemRowClass; ?> >
<?php echo ewrpt_ViewValue($x_description) ?>
</td>

		
		<td<?php echo $sItemRowClass; ?> >
<?php echo ewrpt_ViewValue($x_description) ?>
</td>

	</tr>
	
	
	
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Wkg. Capital Turnover</br>
		(Sales Accounts / Working Capital)"; ?>
</td>

		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($wct)) ?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Return on Investment %</br>
		(Nett Profit / Capital Account + Nett Profit)"; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>
		
		
	</tr>
	
	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Inventory Turnover </br>
		(Sales Accounts /Closing Stock)"; ?>
</td>
		
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo "Return on Wkg. Capital %</br>
(Nett Profit / Working Capital ) %"; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>

		
	</tr>
	
	
	
	
	
<?php

	// Next group
	$o_type = $x_type; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
 }// End while
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
<form action="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="file:///C|/wamp/www/checkwwwroot/wwwroot/Report1smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="file:///C|/wamp/www/checkwwwroot/wwwroot/phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
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
