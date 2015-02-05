<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
session_start();
$currencyunits=$_SESSION['currency'];
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
if(!isset($_GET['party']))
$party = "All";
else
$party = $_GET['party'];

if($party == "All")
$pc = "<>";
else
$pc = "=";

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
if($_SESSION['db'] == 'fortress')
{
if(!isset($_GET['warehouse']))
$warehouse = "All";
else
$warehouse = $_GET['warehouse'];
if($warehouse== "All")
$ware = "<>";
else
$ware = "=";
}

?>
<?php include "reportheader.php"; ?>

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

<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Retail Sales Report</font></strong></td>
</tr>

<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">From : </font></strong><?php echo $datef; ?></td>
<td colspan="1" align="center"><strong><font color="#3e3276">To : </font></strong><?php echo $datet; ?></td>

 </tr>


<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Customer : </font></strong><?php echo $party; ?></td>
</tr>

</table>


<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "salesreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "salesreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "salesreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "salesreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "salesreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "salesreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "oc_cobi";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT oc_cobi.party, oc_cobi.date, oc_cobi.invoice, oc_cobi.totalquantity, oc_cobi.finaltotal, oc_cobi.code,oc_cobi.description FROM " . $EW_REPORT_TABLE_SQL_FROM;
if($_SESSION['db'] == 'fortress' && $warehouse <> "All") { 
$EW_REPORT_TABLE_SQL_WHERE = "oc_cobi.party $pc '$party' and oc_cobi.code $cod '$code' and oc_cobi.description $desc '$description' and oc_cobi.date >= '$fdate' and oc_cobi.date <= '$tdate' AND oc_cobi.warehouse = '$warehouse'";
} else { 
$EW_REPORT_TABLE_SQL_WHERE = "oc_cobi.party $pc '$party' and oc_cobi.code $cod '$code' and oc_cobi.description $desc '$description' and oc_cobi.date >= '$fdate' and oc_cobi.date <= '$tdate' and oc_cobi.dflag = '3' ";
}
$EW_REPORT_TABLE_SQL_GROUPBY = "oc_cobi.party, oc_cobi.date, oc_cobi.invoice, oc_cobi.totalquantity, oc_cobi.finaltotal , oc_cobi.code,oc_cobi.description";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "oc_cobi.date ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "oc_cobi.party", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `party` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(oc_cobi.totalquantity) AS SUM_totalquantity, SUM(oc_cobi.finaltotal) AS SUM_finaltotal FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_party = NULL; // Popup filter for party
$af_date = NULL; // Popup filter for date
$af_invoice = NULL; // Popup filter for invoice
$af_totalquantity = NULL; // Popup filter for totalquantity
$af_finaltotal = NULL; // Popup filter for finaltotal
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
$nDisplayGrps = 500; // Groups per page
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
$x_party = NULL;
$x_date = NULL;
$x_invoice = NULL;
$x_totalquantity = NULL;
$x_finaltotal = NULL;

// Group variables
$o_party = NULL; $g_party = NULL; $dg_party = NULL; $t_party = NULL; $ft_party = 200; $gf_party = $ft_party; $gb_party = ""; $gi_party = "0"; $gq_party = ""; $rf_party = NULL; $rt_party = NULL;

// Detail variables
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_invoice = NULL; $t_invoice = NULL; $ft_invoice = 200; $rf_invoice = NULL; $rt_invoice = NULL;
$o_totalquantity = NULL; $t_totalquantity = NULL; $ft_totalquantity = 5; $rf_totalquantity = NULL; $rt_totalquantity = NULL;
$o_finaltotal = NULL; $t_finaltotal = NULL; $ft_finaltotal = 5; $rf_finaltotal = NULL; $rt_finaltotal = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 5;
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
$col = array(FALSE, FALSE, FALSE, TRUE, TRUE);

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
&nbsp;&nbsp;<a href="retailsalesreportsmry.php?export=html&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&party=<?php echo $party; ?>&warehouse=<?php echo $warehouse; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="retailsalesreportsmry.php?export=excel&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&party=<?php echo $party; ?>&warehouse=<?php echo $warehouse; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="retailsalesreportsmry.php?export=word&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&party=<?php echo $party; ?>&warehouse=<?php echo $warehouse; ?>">Export to Word</a>
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
<div id="report_summary" align="center">
<table align="center" class="ewGrid" cellspacing="0" ><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table align="center" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td>
<span class="phpreportmaker">
From Date
<input type="text" size="15" id="fdate" name="fdate" value="<?php echo date("d.m.Y",strtotime($fdate));?>" class="datepicker" onchange="reloadpage();"/>


To Date
<input type="text" size="15" id="tdate" name="tdate" value="<?php echo date("d.m.Y",strtotime($tdate));?>" class="datepicker" onchange="reloadpage();"/>

<!--<input type="hidden" type="text" value="Retail" name="party" id="party"/>-->
Customer
<select id="party" name="party" onchange="reloadpage();">
<option value="">-Select-</option>
<option value="All" <?php if($party == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php
$q = "select distinct(party) from oc_cobi where dflag='3'  order by party ";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['party']; ?>" <?php if($party == $qr['party']) { ?> selected="selected" <?php } ?> ><?php echo $qr['party']; ?></option>
<?php } ?>
</select>
Code
<select id="code" name="code" style="width:80px;" onchange="getdescription(this.id);">
<option value="">-Select-</option>
<option value="All" <?php if($code == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php
$q = "select distinct(code),description from oc_cobi where code in (select distinct(code) from ims_itemcodes where cat in (SELECT distinct(type) FROM ims_itemtypes where type ='Chicken')) order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title = "<?php echo $qr['description'];?>" value="<?php echo $qr['code']; ?>" <?php if($code == $qr['code']) { ?> selected="selected" <?php } ?> ><?php echo $qr['code']; ?></option>
<?php } ?>
</select>
Description
<select id="desc" name="desc" style="width:100px;" onchange="getcode(this.id);">
<option value="">-Select-</option>
<option value="All" <?php if($description == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php
$q =  "select distinct(description),code from oc_cobi where code in (select distinct(code) from ims_itemcodes where cat in (SELECT distinct(type) FROM ims_itemtypes where type ='Chicken')) order by description";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title="<?php echo $qr['code']; ?>" value="<?php echo $qr['description']; ?>" <?php if($description == $qr['description']) { ?> selected="selected" <?php } ?> ><?php echo $qr['description']; ?></option>
<?php } ?>
</select>
Warehouse
<select id="warehouse" name="warehouse" style="width:100px;"  onchange="reloadwarehouse();">
<option value="All" <?php if($warehouse == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
$query1 = "SELECT sector FROM tbl_sector WHERE type1 IN ('Administration Office', 'Egg Centre' , 'Chicken Center' , 'Audit Office') AND client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
<option value="<?php echo $rows1['sector']; ?>" title="<?php echo $rows1['sector']; ?>" <?php if($warehouse == $rows1['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows1['sector']; ?></option>
<?php
}
?>
</select>
</span>
</td>


</tr>
</table>

</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table align="center" class="ewTable ewTableSeparate" cellspacing="0">
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
	
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Customer</td>
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
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if($_SESSION['db'] == "johnson")
{
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php
} ?>
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

<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Total Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Total Quantity</td>
			</tr></table>
		</td>
<?php } ?><?php */?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Amount</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	}

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_party, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_party, EW_REPORT_DATATYPE_STRING, $gb_party, $gi_party, $gq_party);
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
		$dg_party = $x_party;
		if ((is_null($x_party) && is_null($o_party)) ||
			(($x_party <> "" && $o_party == $dg_party) && !ChkLvlBreak(1))) {
			$dg_party = "&nbsp;";
		} elseif (is_null($x_party)) {
			$dg_party = EW_REPORT_NULL_LABEL;
		} elseif ($x_party == "") {
			$dg_party = EW_REPORT_EMPTY_LABEL;
		}
?>

<?php 
$code = $description = $quantity = $price  = $flock ="" ;
//$q = "select * from oc_cobi where date = '$x_date' and party = '$x_party' and invoice = '$x_invoice' order by code";
$q = "select sum(quantity) as quantity,code,description,flock,avg(price) as price from oc_cobi where date = '$x_date' and party = '$x_party' and invoice = '$x_invoice' group by code order by code";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	$quantity.= $qr['quantity'] . "/";
	$price.= $qr['price'] . "/";
if($_SESSION['db'] == "johnson")
{
$flock.=$qr['flock']. "/";
}
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
if($_SESSION['db'] == "johnson")
{

$flock = substr($flock,0,-1);
}
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);


?>
	<tr>
	
<?php
$oldinvoice;
if($oldinvoice <> $x_invoice)
{
?>

<?php

$query11 = "SELECT warehouse FROM oc_cobi WHERE invoice = '$x_invoice' AND client = '$client'";
$result11 = mysql_query($query11,$conn1) or die(mysql_error());
$rows11 = mysql_fetch_assoc($result11);
$ware = $rows11['warehouse'];
?>
<td class="ewRptGrpField2" align="left">
<?php echo ewrpt_ViewValue($ware) ?>

	
		<td class="ewRptGrpField1" align="left">
		<?php $t_party = $x_party; $x_party = $dg_party; ?>
<?php echo ewrpt_ViewValue($x_party) ?>
		<?php $x_party = $t_party; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php if($date1 != $x_date) echo ewrpt_ViewValue(ewrpt_FormatDateTime($x_date,7)); else echo "&nbsp;";  $date1 = $x_date?>
</td>
<?php 
$oldinvoice = $x_invoice;
?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_invoice) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $code; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $description; ?>
</td><?php
if($_SESSION['db'] == "johnson")
{
?>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $flock; ?>
</td>
<?php
}?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $quantity; ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="left">
<?php echo $price; ?>
</td>
<?php $totalquantity+= $x_totalquantity; ?>
		<?php /*?><td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_totalquantity); $totalquantity+= $x_totalquantity; ?>
</td><?php */?>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue($x_finaltotal); $totalamount+= $x_finaltotal; ?>
</td>
	</tr>
<?php }

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_party = $x_party;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php
?>
	<!--<tr>-->
<?php
/*if($_SESSION['db'] == 'fortress' && $warehouse == 'All')
{*/
?>
<!--<td colspan="2" class="ewRptGrpSummary1" align="left">TOTAL</td>
--><?php
/*} else {*/
?>
<!--<td colspan="1" class="ewRptGrpSummary1" align="left">TOTAL</td>	
--><?php //} ?>	
		<!--/*<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1">&nbsp;</td>
		<td class="ewRptGrpSummary1" align="right">*/-->
		<?php #$t_totalquantity = $x_totalquantity; ?>
		<?php #if ($cnt[1][3] > 0) $x_totalquantity = $smry[1][3]/$cnt[1][3]; // Load AVG ?>
<?php //echo $totalquantity; $totalquantity = 0; #ewrpt_ViewValue($x_totalquantity) ?>
		<?php #$x_totalquantity = $t_totalquantity; ?>
		<!--</td>
		<td class="ewRptGrpSummary1" align="right">-->
		<?php #$t_finaltotal = $x_finaltotal; ?>
		<?php #if ($cnt[1][4] > 0) $x_finaltotal = $smry[1][4]/$cnt[1][4]; // Load AVG ?>
<?php //echo $totalamount; $totalamount = 0; #ewrpt_ViewValue($x_finaltotal) ?>
		<?php #$x_finaltotal = $t_finaltotal; ?>
		<!--</td>
	</tr>-->
	<?php /*if($_SESSION['db'] == 'fortress' && $warehouse == "All") { ?>
		<tr><td colspan="10" class="ewRptGrpSummary1" align="left">&nbsp;</td></tr>
	<?php } else { ?>
		<tr><td colspan="9" class="ewRptGrpSummary1" align="left">&nbsp;</td></tr>
	<?php }*/ ?>

<?php

			// Reset level 1 summary
			ResetLevelSummary(1);
?>
<?php

	// Next group
	$o_party = $x_party; // Save old group value
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
		$grandsmry[3] = $rsagg->fields("SUM_totalquantity");
		$grandsmry[4] = $rsagg->fields("SUM_finaltotal");
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
	<tr class="ewRptGrandSummary" style="display:none"><td colspan="5">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
	<tr class="ewRptGrandSummary" style="display:none">
		<td colspan="1" class="ewRptGrpAggregate">AVERAGE</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>
		<?php $t_totalquantity = $x_totalquantity; ?>
		<?php if ($rstotcnt > 0) $x_totalquantity = $grandsmry[3]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_totalquantity) ?>
		<?php $x_totalquantity = $t_totalquantity; ?>
		</td>
		<td>
		<?php $t_finaltotal = $x_finaltotal; ?>
		<?php if ($rstotcnt > 0) $x_finaltotal = $grandsmry[4]/$rstotcnt; // Load AVG ?>
<?php echo ewrpt_ViewValue($x_finaltotal) ?>
		<?php $x_finaltotal = $t_finaltotal; ?>
		</td>
	</tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel" style="display:none">
<form action="retailsalesreportsmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="retailsalesreportsmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="retailsalesreportsmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="retailsalesreportsmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="retailsalesreportsmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<option value="500"<?php if ($nDisplayGrps == 500) echo " selected" ?>>500</option>
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
			return (is_null($GLOBALS["x_party"]) && !is_null($GLOBALS["o_party"])) ||
				(!is_null($GLOBALS["x_party"]) && is_null($GLOBALS["o_party"])) ||
				($GLOBALS["x_party"] <> $GLOBALS["o_party"]);
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
	if ($lvl <= 1) $GLOBALS["o_party"] = "";

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
		$GLOBALS['x_party'] = "";
	} else {
		$GLOBALS['x_party'] = $rsgrp->fields('party');
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
		$GLOBALS['x_date'] = $rs->fields('date');
		$GLOBALS['x_invoice'] = $rs->fields('invoice');
		$GLOBALS['x_totalquantity'] = $rs->fields('totalquantity');
		$GLOBALS['x_finaltotal'] = $rs->fields('finaltotal');
		$val[1] = $GLOBALS['x_date'];
		$val[2] = $GLOBALS['x_invoice'];
		$val[3] = $GLOBALS['x_totalquantity'];
		$val[4] = $GLOBALS['x_finaltotal'];
	} else {
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_invoice'] = "";
		$GLOBALS['x_totalquantity'] = "";
		$GLOBALS['x_finaltotal'] = "";
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
				$nDisplayGrps = 500; // Non-numeric, load default
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
			$nDisplayGrps = 500; // Load default
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
			$_SESSION["sort_salesreport_party"] = "";
			$_SESSION["sort_salesreport_date"] = "";
			$_SESSION["sort_salesreport_invoice"] = "";
			$_SESSION["sort_salesreport_totalquantity"] = "";
			$_SESSION["sort_salesreport_finaltotal"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "oc_cobi.invoice ASC";
		$_SESSION["sort_salesreport_invoice"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>

<script type="text/javascript">


function getdescription(codeid)
{
var temp = codeid.split("e");
var tempindex = temp[1];
var y = document.getElementById(codeid).value;

if(y == 'All')
{

reloadpage1();
}
removeAllOptions(document.getElementById('desc'+ tempindex));
myselect1 = document.getElementById('desc' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.name = "desc";
myselect1.style.width = "100px";
<?php 
	$q = "select distinct(code),description from oc_cobi order by description";
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
if(y == 'All')
{

reloadpage1();
}
removeAllOptions(document.getElementById('code'+ tempindex));
myselect1 = document.getElementById('code' + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value = "";
theOption1.appendChild(theText1);


myselect1.appendChild(theOption1);

myselect1.name = "code";
myselect1.style.width = "80px";
<?php 
	    $q = "select distinct(code),description from oc_cobi order by code";
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
function reloadpage()
{
	var date = document.getElementById('fdate').value;
	var date1 = document.getElementById('tdate').value;
	var party = document.getElementById('party').value;
	
	document.location = "retailsalesreportsmry.php?fdate=" + date + "&tdate=" + date1 + "&party=" + party ;
	
}
function reloadpage1()
{
if(document.getElementById('code').value == "All")
{
var date = document.getElementById('fdate').value;
	var date1 = document.getElementById('tdate').value;
	
	
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value = "All";
	document.location = "retailsalesreportsmry.php?fdate=" + date + "&tdate=" + date1 + "&party=" + party + "&code=" + code + "&description=" +"All" ;

}
else if(document.getElementById('desc').value == "All")
{
var date = document.getElementById('fdate').value;
	var date1 = document.getElementById('tdate').value;
	
	
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value = "All";
	var description = document.getElementById('desc').value;
	document.location = "retailsalesreportsmry.php?fdate=" + date + "&tdate=" + date1 + "&party=" + party + "&code=" + "All" + "&description=" + description ;

}
else
{
	var date = document.getElementById('fdate').value;
	var date1 = document.getElementById('tdate').value;
	
	
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	document.location = "retailsalesreportsmry.php?fdate=" + date + "&tdate=" + date1 + "&party=" + party + "&code=" + code + "&description=" +description ;
}
}
function reloadwarehouse()
{
	var date = document.getElementById('fdate').value;
	var date1 = document.getElementById('tdate').value;
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value;
	var description = document.getElementById('desc').value;
	var warehouse = document.getElementById('warehouse').value;
	document.location = "retailsalesreportsmry.php?fdate=" + date + "&tdate=" + date1 + "&party=" + party + "&warehouse=" + warehouse;
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
