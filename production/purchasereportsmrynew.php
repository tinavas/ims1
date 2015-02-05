<?php
session_start();$currencyunits=$_SESSION['currency'];
ob_start();
include "config.php";
include "../getemployee.php";
if($currencyunits == "")
{
$currencyunits = "Rs";
}
if(!isset($_GET['fdate']))
$fdate = date("Y-m-d");
else
$fdate = date("Y-m-d",strtotime($_GET['fdate']));
$datef = date("d.m.Y",strtotime($fdate));
if(!isset($_GET['tdate']))
$tdate = date("Y-m-d");
else
$tdate = date("Y-m-d",strtotime($_GET['tdate']));
$datet = date("d.m.Y",strtotime($tdate));
if(!isset($_GET['vendor']))
$vendor = "All";
else
$vendor = $_GET['vendor'];

if($vendor == "All")
$vc = "<>";
else
$vc = "=";

$date1 = "1970-01-01";
$totalquantity = $totalamount = 0;
if(!isset($_GET['code']))
$code = "All";
else
$code = $_GET['code'];
if($code== "All")
$cod = "<>";
else
$cod = "=";
if(!isset($_GET['description']))
$description = "All";
else
$description = $_GET['description'];
if($description== "All")
$desc = "<>";
else
$desc = "=";


if(!isset($_GET['warehouse']))
$warehouse = "All";
else
$warehouse = $_GET['warehouse'];
if($warehouse== "All")
$ware = "<>";
else
$ware = "=";

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
<?php include "reportheader.php";?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Purchases Report</font></strong></td>
</tr>

<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">From : </font></strong><?php echo $datef; ?></td>
<td colspan="1" align="center"><strong><font color="#3e3276">To : </font></strong><?php echo $datet; ?></td>

 </tr>


<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Supplier : </font></strong><?php echo $vendor; ?></td>
</tr>

</table>



<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "purchasereportsmrynew", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Report123_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Report123_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Report123_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Report123_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Report123_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "pp_sobi";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT pp_sobi.date, pp_sobi.vendor, pp_sobi.so, pp_sobi.invoice, pp_sobi.code, pp_sobi.description, pp_sobi.receivedquantity, pp_sobi.rateperunit, pp_sobi.totalquantity, pp_sobi.totalamount,pp_sobi.warehouse FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = " pp_sobi.vendor $vc '$vendor' and pp_sobi.code $cod '$code' and pp_sobi.description $desc '$description'and pp_sobi.date >= '$fdate' and pp_sobi.date <= '$tdate' and pp_sobi.warehouse $ware '$warehouse' ";

$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "pp_sobi.date ASC,pp_sobi.so asc";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date = NULL; // Popup filter for date
$af_vendor = NULL; // Popup filter for vendor
$af_so = NULL; // Popup filter for so
$af_invoice = NULL; // Popup filter for invoice
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
$af_receivedquantity = NULL; // Popup filter for receivedquantity
$af_rateperunit = NULL; // Popup filter for rateperunit
$af_totalquantity = NULL; // Popup filter for totalquantity
$af_totalamount = NULL; // Popup filter for totalamount
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
?>
<?php

// Field variables
$x_date = NULL;
$x_vendor = NULL;
$x_so = NULL;
$x_invoice = NULL;
$x_code = NULL;
$x_description = NULL;
$x_receivedquantity = NULL;
$x_rateperunit = NULL;
$x_totalquantity = NULL;
$x_totalamount = NULL;

// Detail variables
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_vendor = NULL; $t_vendor = NULL; $ft_vendor = 200; $rf_vendor = NULL; $rt_vendor = NULL;
$o_so = NULL; $t_so = NULL; $ft_so = 200; $rf_so = NULL; $rt_so = NULL;
$o_invoice = NULL; $t_invoice = NULL; $ft_invoice = 200; $rf_invoice = NULL; $rt_invoice = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 200; $rf_description = NULL; $rt_description = NULL;
$o_receivedquantity = NULL; $t_receivedquantity = NULL; $ft_receivedquantity = 5; $rf_receivedquantity = NULL; $rt_receivedquantity = NULL;
$o_rateperunit = NULL; $t_rateperunit = NULL; $ft_rateperunit = 5; $rf_rateperunit = NULL; $rt_rateperunit = NULL;
$o_totalquantity = NULL; $t_totalquantity = NULL; $ft_totalquantity = 5; $rf_totalquantity = NULL; $rt_totalquantity = NULL;
$o_totalamount = NULL; $t_totalamount = NULL; $ft_totalamount = 5; $rf_totalamount = NULL; $rt_totalamount = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 11;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

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

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="purchasereportsmrynew.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchasereportsmrynew.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="purchasereportsmrynew.php?export=word&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchasereportsmrynew.php?cmd=reset&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&vendor=<?php echo $vendor; ?>&warehouse=<?php echo $warehouse; ?>">Reset All Filters</a>
<?php } ?>
<?php } ?>

<?php if (@$sExport == "") { ?>
<br /><br />
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel" align="left">
From Date
<input type="text" size="12" id="date" name="date" value="<?php echo date("d.m.Y",strtotime($fdate)); ?>" class="datepicker" onchange="reloadpage();"/>


To Date
<input type="text" size="12" id="date1" name="date1" value="<?php echo date("d.m.Y",strtotime($tdate)); ?>" class="datepicker" onchange="reloadpage();"/>

Supplier
<select id="vendor" name="vendor" style ="width:160px" onchange="reloadpage();">
<option value="All" <?php if($vendor == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$q = "select distinct(vendor) from pp_sobi order by vendor";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>

<option value="<?php echo $qr['vendor']; ?>" <?php if($vendor == $qr['vendor']) { ?> selected="selected" <?php } ?> ><?php echo $qr['vendor']; ?></option>
<?php } ?>

</select>

Code
<select id="code" name="code" style="width:80px;" onchange = "getdescription(this.id);">
<option value="All" <?php if($code == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php
$q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['code']; ?>" <?php if($code == $qr['code']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['code']; ?></option>
<?php } ?>
</select>

Description
<select id="desc" name="desc" style="width:100px;"  onchange = "getcode(this.id);">
<option value="All" <?php if($description == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$q = "select distinct(description) from pp_sobi order by description";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['description']; ?>" <?php if($description == $qr['description']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['description']; ?></option>
<?php } ?>
</select>

Warehouse
<select id="warehouse" name="warehouse" style="width:100px;"  onchange="reloadwarehouse();">
<option value="All" <?php if($warehouse == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$query1 = "SELECT distinct(warehouse) FROM pp_sobi";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['warehouse']; ?>" <?php if($warehouse == $rows1['warehouse']) { ?> selected="selected" <?php } ?>><?php echo $rows1['warehouse']; ?></option>
<?php
}
?>
</select>


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
	GetRow(1);
	$nGrpCount = 1;
}
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
	$Oldso = "";
?>
	<thead>
	<tr>
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
<?php  if($_SESSION['db'] == 'suriya' )
		{	
			if (@$sExport <> "") { ?>
			<td valign="bottom" class="ewTableHeader">
			Bill Date		
			</td>
<?php 	} 
	   else 
	    { ?>
			<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Bill Date</td>
			</tr></table>		</td>
<?php } }?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Vendor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Vendor</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		So
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>So</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Invoice
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Invoice</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Price</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Warehouse</td>
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
<?php 
$code = $description = $quantity = $price = $binvoice = "";
$q = "select * from pp_sobi where date = '$x_date' and vendor = '$x_vendor' and so = '$x_so' order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	$quantity.= $qr['receivedquantity'] . "/";
	$price.= $qr['rateperunit'] . "/";
	$binvoice = $qr['invoice'];
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);

if($oldso != $x_so)
{
?>

	<tr>
	<?php
$date = date("d.m.Y",strtotime($x_date));	
	?>
	<td<?php echo $sItemRowClass; ?>>
<?php if((ewrpt_FormatDateTime($date,5) <> $oldcode) or ($dumm == 0)){ echo ewrpt_ViewValue(ewrpt_FormatDateTime($date,5));
     $oldcode = ewrpt_FormatDateTime($date,5); $dumm = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
	 
</td>	 
	 
<?php
include "config.php";
$q = "select warehouse,grandtotal from pp_sobi where so = '$x_so'";
$r = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($r))
{
$wh = $qr['warehouse'];
$gt = $qr['grandtotal'];
}
$oldso =  $x_so;
?>
<?php if($_SESSION[db]=='suriya') {?>	
	<?php 
		include "config.php";
		$so=ewrpt_ViewValue($x_so);
		$query="SELECT `billdate` FROM `pp_sobi` where `so`='$so'";
		$result=mysql_query($query,$conn1);
		while($rows=mysql_fetch_assoc($result))
		 {
			$billdate=$rows['billdate'];
		 }
		$billdate1=date("d.m.Y",strtotime($billdate));
	?>	
	<td<?php echo $sItemRowClass; ?>>
	<?php echo ewrpt_ViewValue($billdate1); ?>
	</td>
<?php }?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_vendor) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_so) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_invoice) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($code) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($description) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($quantity);  ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($price) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($x_totalquantity)); $totquant = $totquant + $x_totalquantity; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($gt)); $totgt = $totgt + $gt; ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($wh) ?>
</td>
	</tr>
<?php 

} 
?>	

<?php

		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
	$nGrpCount++;
} // End while
?>
	<tr><td <?php echo $sItemRowClass; ?>><b> Total</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($totquant);?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changeprice($totgt);?></b></td>
<td <?php echo $sItemRowClass; ?>><b>&nbsp;</b></td>
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
	<!-- tr><td colspan="10"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="purchasereportsmrynew.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="purchasereportsmrynew.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="purchasereportsmrynew.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="purchasereportsmrynew.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="purchasereportsmrynew.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<option value="100"<?php if ($nDisplayGrps == 100) echo " selected" ?>>100</option>
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
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_vendor'] = $rs->fields('vendor');
		$GLOBALS['x_so'] = $rs->fields('so');
		$GLOBALS['x_invoice'] = $rs->fields('invoice');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_receivedquantity'] = $rs->fields('receivedquantity');
		$GLOBALS['x_rateperunit'] = $rs->fields('rateperunit');
		$GLOBALS['x_totalquantity'] = $rs->fields('totalquantity');
		$GLOBALS['x_totalamount'] = $rs->fields('totalamount');
		$val[1] = $GLOBALS['x_date'];
		$val[2] = $GLOBALS['x_vendor'];
		$val[3] = $GLOBALS['x_so'];
		$val[4] = $GLOBALS['x_invoice'];
		$val[5] = $GLOBALS['x_code'];
		$val[6] = $GLOBALS['x_description'];
		$val[7] = $GLOBALS['x_receivedquantity'];
		$val[8] = $GLOBALS['x_rateperunit'];
		$val[9] = $GLOBALS['x_totalquantity'];
		$val[10] = $GLOBALS['x_totalamount'];
	} else {
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_vendor'] = "";
		$GLOBALS['x_so'] = "";
		$GLOBALS['x_invoice'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_receivedquantity'] = "";
		$GLOBALS['x_rateperunit'] = "";
		$GLOBALS['x_totalquantity'] = "";
		$GLOBALS['x_totalamount'] = "";
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
			$_SESSION["sort_Report123_date"] = "";
			$_SESSION["sort_Report123_vendor"] = "";
			$_SESSION["sort_Report123_so"] = "";
			$_SESSION["sort_Report123_invoice"] = "";
			$_SESSION["sort_Report123_code"] = "";
			$_SESSION["sort_Report123_description"] = "";
			$_SESSION["sort_Report123_receivedquantity"] = "";
			$_SESSION["sort_Report123_rateperunit"] = "";
			$_SESSION["sort_Report123_totalquantity"] = "";
			$_SESSION["sort_Report123_totalamount"] = "";
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
function reloadpage1()
{
if(document.getElementById('code').value == "All")
{
var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value = "All";
	
	document.location = "purchasereportsmrynew.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" + code + "&description=" + "All";

}
else if(document.getElementById('desc').value == "All")
{
var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value = "All";
	var description = document.getElementById('desc').value ;
	
	document.location = "purchasereportsmrynew.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" +"All" + "&description=" + "All";

}
else
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	
	document.location = "purchasereportsmrynew.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&code=" + code + "&description=" + description;
}
}


function reloadpage()
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	
	document.location = "purchasereportsmrynew.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor;
}
function reloadwarehouse()
{
	var date = document.getElementById('date').value;
	var date1 = document.getElementById('date1').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	var warehouse = document.getElementById('warehouse').value;
	document.location = "purchasereportsmrynew.php?fdate=" + date + "&tdate=" + date1 + "&vendor=" + vendor + "&warehouse=" + warehouse;
}

function getdescription(codeid)
{

var temp = codeid.split("e");
     var tempindex = temp[1];
var y = document.getElementById(codeid).value;

removeAllOptions(document.getElementById('desc'+ tempindex));
myselect1 = document.getElementById('desc' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");

theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "desc";
myselect1.style.width = "100px";
<?php 
	$q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{    
	
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['description']; ?>");
theOption1.value = "<?php echo $qr['description']; ?>";
<?php echo "if(y == '$qr[code]') { "; ?>

theOption1.selected= true;
<?php echo "}"; ?>
theOption1.title = "<?php echo $qr['code']; ?>";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


<?php }?>
reloadpage1();

}
function getcode(codeid)
{

var temp = codeid.split("c");
     var tempindex = temp[1];
var y = document.getElementById(codeid).value;

removeAllOptions(document.getElementById('code'+ tempindex));
myselect1 = document.getElementById('code' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "code";
myselect1.style.width = "160px";
<?php 
	    $q = "select distinct(code),description from pp_sobi order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{    
?>


theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.value = "<?php echo $qr['code']; ?>";
<?php echo "if(y == '$qr[description]') {"; ?>
theOption1.selected= true;


<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);


<?php }?>
reloadpage1();
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}
</script>
