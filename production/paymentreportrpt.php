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
?>

<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php
include "reportheader.php";

$a9=date($datephp);

if($_GET['id3'] <> "All" && $_GET['id3']<>"")
{
 $vendor=$_GET['id3'];
 
}
else
{
   $vendor="All";
}

 $from1=$_GET['id1'];
$to1=$_GET['id2'];

if($_GET['id4'] <> "All" && $_GET['id4']<>"")
{
$mode=$_GET['id4'];
}
else
{
  $mode="All";
}
 $code=$_GET['id5'];
// $from=strtotime($from1);
//		$fromda=date("Y-m-d",$from);
//		$to=strtotime($to1);
//		$toda=date("Y-m-d",$to);

if($_GET['id1'] <> "")
 $fromda = date("Y-m-d",strtotime($_GET['id1']));
else
 $fromda = date("Y-m-d");
if($_GET['id2'] <> "")
 $toda = date("Y-m-d",strtotime($_GET['id2']));
else
 $toda = date("Y-m-d");




 ?>


<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Payment  Report</font></strong></td>
</tr>

<tr>
 <td colspan="1" align="center"><strong><font color="#3e3276">From : </font></strong><?php if($from1=="")
 {
 echo $a9; } else
 {
 echo $from1;}?></td>
<td colspan="1" align="center"><strong><font color="#3e3276">To : </font></strong><?php if($to1=="")
 {
 echo $a9; } else
 {
 echo $to1;} ?></td>

 </tr>


<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Vendor: </font></strong><?php if($vendor=="All")
 {
 $all='All';
 echo $all;} else
 {
 echo $vendor;} ?></td>
</tr>

</table>

<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "paymentreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "paymentreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "paymentreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "paymentreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "paymentreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "paymentreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "pp_payment";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT pp_payment.date, pp_payment.doc_no, pp_payment.vendor, pp_payment.paymentmethod, pp_payment.paymentmode, pp_payment.code, pp_payment.amount, pp_payment.cheque, pp_payment.cdate FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "date";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";
$af_date = NULL; // Popup filter for date
$af_doc_no = NULL; // Popup filter for doc_no
$af_vendor = NULL; // Popup filter for vendor
$af_paymentmethod = NULL; // Popup filter for paymentmethod
$af_paymentmode = NULL; // Popup filter for paymentmode
$af_code = NULL; // Popup filter for code
$af_amount = NULL; // Popup filter for amount
$af_cheque = NULL; // Popup filter for cheque
$af_cdate = NULL; // Popup filter for cdate
?>
<?php
if($vendor=='All'&& $mode!='All' )
{
$EW_REPORT_TABLE_SQL_WHERE = "date between '$fromda' and '$toda' and paymentmode='$mode' and code='$code' ";
}

else if($vendor=='All' && $mode=='All' )
{
$EW_REPORT_TABLE_SQL_WHERE = "date between '$fromda' and '$toda'";
}
else if($vendor!='All'&& $mode=='All' )
{
$EW_REPORT_TABLE_SQL_WHERE = "date between '$fromda' and '$toda' and vendor='$vendor'";
}
else
{
$EW_REPORT_TABLE_SQL_WHERE = "vendor='$vendor'and date between '$fromda' and '$toda'and paymentmode='$mode' and code='$code'";
}
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
$nDisplayGrps = 3; // Groups per page
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
$x_doc_no = NULL;
$x_vendor = NULL;
$x_paymentmethod = NULL;
$x_paymentmode = NULL;
$x_code = NULL;
$x_amount = NULL;
$x_cheque = NULL;
$x_cdate = NULL;

// Detail variables
$o_date = NULL; $t_date = NULL; $ft_date = 133; $rf_date = NULL; $rt_date = NULL;
$o_doc_no = NULL; $t_doc_no = NULL; $ft_doc_no = 200; $rf_doc_no = NULL; $rt_doc_no = NULL;
$o_vendor = NULL; $t_vendor = NULL; $ft_vendor = 200; $rf_vendor = NULL; $rt_vendor = NULL;
$o_paymentmethod = NULL; $t_paymentmethod = NULL; $ft_paymentmethod = 200; $rf_paymentmethod = NULL; $rt_paymentmethod = NULL;
$o_paymentmode = NULL; $t_paymentmode = NULL; $ft_paymentmode = 200; $rf_paymentmode = NULL; $rt_paymentmode = NULL;
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_amount = NULL; $t_amount = NULL; $ft_amount = 5; $rf_amount = NULL; $rt_amount = NULL;
$o_cheque = NULL; $t_cheque = NULL; $ft_cheque = 200; $rf_cheque = NULL; $rt_cheque = NULL;
$o_cdate = NULL; $t_cdate = NULL; $ft_cdate = 133; $rf_cdate = NULL; $rt_cdate = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 10;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

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
var EW_REPORT_DATE_SEPARATOR = ".";
if (EW_REPORT_DATE_SEPARATOR == "") EW_REPORT_DATE_SEPARATOR = "."; // Default date separator
</script>
<script type="text/javascript" src="../../wwwroot/production/phprptjs/ewrpt.js"></script>
<?php } ?>
<?php if (@$sExport == "") { ?>
<script src="../../wwwroot/production/phprptjs/popup.js" type="text/javascript"></script>
<script src="../../wwwroot/production/phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="../../wwwroot/production/FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
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
<?php
session_start();
$client = $_SESSION['client'];
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



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="paymentreportrpt.php?export=html&id1=<?php echo $from1; ?>&id2=<?php echo $to1; ?>&id3=<?php echo $vendor; ?>&id4=<?php echo $mode; ?>&id5=<?php echo $code; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="paymentreportrpt.php?export=excel&id1=<?php echo $from1; ?>&id2=<?php echo $to1; ?>&id3=<?php echo $vendor; ?>&id4=<?php echo $mode; ?>&id5=<?php echo $code; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="paymentreportrpt.php?export=word&id1=<?php echo $from1; ?>&id2=<?php echo $to1; ?>&id3=<?php echo $vendor; ?>&id4=<?php echo $mode; ?>&id5=<?php echo $code; ?>">Export to Word</a>
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
	<div class="ewGridUpperPanel">
	<table >
<tr ><td>Fromdate:</td><td><input type="text" name="da" style="width:100px" id="da1" onchange="p2()"  <?php if ($from1=="") { ?>value="<?php echo $a9 ?>" <?php }  else {?>value=<?php echo $from1 ?><?php } ?> class="datepicker" /></td>

<td >Todate:</td><td><input type="text" name="da1" style="width:100px" id="da11" onchange="p2()" <?php if ($to1=="") { ?> value="<?php echo $a9 ?>" <?php }  else {?>value=<?php echo $to1; ?> <?php } ?> class="datepicker"  /></td>

<td>Vendor:</td><td><select name="sup" id="sup1" style="width:200px" onchange="p2()">
<option  value="All" <?php if ($vendor=='All') { ?> selected="selected" <?php } ?> >All</option>
<?php
$query= "select distinct(vendor) as w1 from pp_payment order by vendor";
$res=mysql_query($query,$conn1)or die(mysql_error());
while( $row=mysql_fetch_assoc($res))
{ 
$a=$row['w1'];

?> 
<option <?php if ($vendor==$a) { ?> selected="selected" <?php } ?> value="<?php echo $a ?>"><?php echo $a ?></option>
<?php } ?>
</select></td>

<td>Mode:</td><td><select name="mode" id="mode" onchange="cashcheque(this.value);">

<option value="All" <?php if ($mode=='All') { ?> selected="selected" <?php } ?> >All</option>
<?php
$query= "select distinct(paymentmode) as w2 from pp_payment order by paymentmode";
$res=mysql_query($query,$conn1)or die(mysql_error());
while( $row=mysql_fetch_assoc($res))
{ 
$pay=$row['w2'];

?> 
<option <?php if ($mode==$pay) { ?> selected="selected" <?php } ?> value="<?php echo $pay ?>"><?php echo $pay ?></option>
<?php } ?>
</select>
</td>

<td>Code:</td><td><select name="code" id="code" onchange="p2()" style="width:140px">
<?php if($mode=='Cash')
{

	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$cod=$qr['code'];
?>
<option <?php if ($code==$cod) { ?> selected="selected" <?php } ?> value="<?php echo $cod ?>"><?php echo $cod ?></option>
<?php } }
else if($mode == "Cheque" )
{

	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$acn=$qr['acno'];
	?>
<option <?php if ($code==$acn) { ?> selected="selected" <?php } ?> value="<?php echo $acn ?>"><?php echo $acn ?></option>
<?php } }
 ?>
</select>
</td>
</tr>
	</table>

<script type="text/javascript">

function p2()
{
var vendor=document.getElementById("sup1").value;
var from=document.getElementById("da1").value;
var to=document.getElementById("da11").value;
var mode=document.getElementById("mode").value;
var code=document.getElementById("code").value;

if(from>to)
{
alert("from date should not morethan to date");
}
else
document.location='paymentreportrpt.php?id1='+from + '&id2='+to+'&id3='+vendor +'&id4='+mode +'&id5='+code;
}
function cashcheque(a)
{
var c=document.getElementById("code").options.length;
    for(var i=c;i>=0;i--)
    {
        document.getElementById("code").remove(i);
    }
var code = document.getElementById('code');
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.value="All";
theOption1.appendChild(theText1);
code.appendChild(theOption1);
if(a == "Cash")
{

<?php 
	$q = "select distinct(code) from ac_bankmasters where mode = 'Cash' order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	$a1=$qr['code'];
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['code']; ?>");
theOption1.appendChild(theText1);
<?php if($code==$a1){ ?>theOption1.selected="selected";<?php } ?>
theOption1.value = "<?php echo $qr['code']; ?>";
code.appendChild(theOption1);
<?php
	}
?>

}
else if(a == "Cheque" )
{


<?php 
	$q = "select distinct(acno) from ac_bankmasters where mode = 'Bank' order by acno";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $qr['acno']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $qr['acno']; ?>";
code.appendChild(theOption1);
<?php
	}
?>
}
 
}
</script>
<?php } ?>
</div>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php
$tot=0;
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Doc No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Doc No</td>
			</tr></table>
		</td>
<?php } ?>
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
		Paymentmethod
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Paymentmethod</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Paymentmode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Paymentmode</td>
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
		Cheque
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cheque</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cdate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cdate</td>
			</tr></table>
		</td>
<?php } ?>
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
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
	<tr>
		<td<?php echo $sItemRowClass; ?>>
		<?php $x_date=strtotime($x_date);
		$date=date("d.m.Y",$x_date);?>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($date,5)) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="center">
<?php echo ewrpt_ViewValue($x_doc_no) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_vendor) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_paymentmethod) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_paymentmode) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_code) ?>
</td>
	<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cheque) ?>
</td>	
<?php
$cdat=strtotime($x_cdate);
		$chdate=date("d.m.Y",$cdat); ?>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(ewrpt_FormatDateTime($chdate,5)) ?>
</td>
<td align="right"<?php echo $sItemRowClass; ?>>
<?php 
$tot=$tot+$x_amount;
echo ewrpt_ViewValue($x_amount) ?>
</td>
	</tr>

<?php

		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
	$nGrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	<tr>
<td colspan="8">Total</td><td align="right"><?php echo $tot;?></td>
</tr>
	</tfoot>
</table>


<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="paymentreportrpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="paymentreportrpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="paymentreportrpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="paymentreportrpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="paymentreportrpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="../../wwwroot/production/phprptimages/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
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
		<td align="right" valign="top" nowrap><span class="phpreportmaker">Records Per Page&nbsp;
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
	for ($ix = 1; $ix < $cntx; $ix++) 
          {
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
		$GLOBALS['x_doc_no'] = $rs->fields('doc_no');
		$GLOBALS['x_vendor'] = $rs->fields('vendor');
		$GLOBALS['x_paymentmethod'] = $rs->fields('paymentmethod');
		$GLOBALS['x_paymentmode'] = $rs->fields('paymentmode');
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_amount'] = $rs->fields('amount');
		$GLOBALS['x_cheque'] = $rs->fields('cheque');
		$GLOBALS['x_cdate'] = $rs->fields('cdate');
		$val[1] = $GLOBALS['x_date'];
		$val[2] = $GLOBALS['x_doc_no'];
		$val[3] = $GLOBALS['x_vendor'];
		$val[4] = $GLOBALS['x_paymentmethod'];
		$val[5] = $GLOBALS['x_paymentmode'];
		$val[6] = $GLOBALS['x_code'];
		$val[7] = $GLOBALS['x_amount'];
		$val[8] = $GLOBALS['x_cheque'];
		$val[9] = $GLOBALS['x_cdate'];
	} else {
		$GLOBALS['x_date'] = "";
		$GLOBALS['x_doc_no'] = "";
		$GLOBALS['x_vendor'] = "";
		$GLOBALS['x_paymentmethod'] = "";
		$GLOBALS['x_paymentmode'] = "";
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_amount'] = "";
		$GLOBALS['x_cheque'] = "";
		$GLOBALS['x_cdate'] = "";
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
				$nDisplayGrps = 3; // Non-numeric, load default
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
			$nDisplayGrps = 3; // Load default
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
			$_SESSION["sort_paymentreport_date"] = "";
			$_SESSION["sort_paymentreport_doc_no"] = "";
			$_SESSION["sort_paymentreport_vendor"] = "";
			$_SESSION["sort_paymentreport_paymentmethod"] = "";
			$_SESSION["sort_paymentreport_paymentmode"] = "";
			$_SESSION["sort_paymentreport_code"] = "";
			$_SESSION["sort_paymentreport_amount"] = "";
			$_SESSION["sort_paymentreport_cheque"] = "";
			$_SESSION["sort_paymentreport_cdate"] = "";
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
