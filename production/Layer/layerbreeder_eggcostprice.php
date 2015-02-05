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
<?php include "phprptinc/ewrfn3.php"; 
      include "reportheader.php";   ?>
<?php
include "../getemployee.php";
$client = $_SESSION['client'];
$totaleggs=0;
$totalfeed=0;
$fdatedump = $_GET['fromdate'];
$fdate = date("Y-m-d", strtotime($fdatedump));
$tdatedump = $_GET['todate'];
$tdate = date("Y-m-d", strtotime($tdatedump));
$url = "fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate'];

include "config.php";

if($_SESSION['db'] == "albustanlayer")
{
$cresult = mysql_query("select avg(rateperunit) as feedcost from pp_sobi  where code IN (select code from ims_itemcodes where cat = 'Layer Feed') and date < '$tdate' and client = '$client'",$conn1) or die(mysql_error());
$cres = mysql_fetch_assoc($cresult);
$feedcost = $cres['feedcost'];
}
else
{
$qu="select sum(materialcost) as mcost,sum(production) as production from feed_productionunit where date<='$x_date1' and mash in(select distinct(code) from ims_itemcodes where cat In ('Layer Feed')) and date < '$tdate' ";
$re1=mysql_query($qu,$conn1);
$re1=mysql_fetch_assoc($re1);
$mcost=$re1['mcost'];
$production=$re1['production'];
$feedcost=$mcost/$production;
}

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "eggcostprice", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "eggcostprice_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "eggcostprice_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "eggcostprice_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "eggcostprice_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "eggcostprice_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`layerbreeder_production`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layerbreeder_production.date1,sum(layerbreeder_production.quantity) as quantity, sum(layerbreeder_production.price) as price FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "`date1`>='$fdate' and `date1`<'$tdate'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "`date1` ASC";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "`date1`", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `date1` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_date1 = NULL; // Popup filter for date1
$af_quantity = NULL; // Popup filter for quantity
$af_price = NULL; // Popup filter for price
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
$nDisplayGrps = "ALL"; // Groups per page
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
$x_date1 = NULL;
$x_flock = NULL;
$x_wo = NULL;
$x_reportedby = NULL;
$x_itemcode = NULL;
$x_itemdesc = NULL;
$x_units = NULL;
$x_quantity = NULL;
$x_lotno = NULL;
$x_slno = NULL;
$x_price = NULL;
$x_flag = NULL;
$x_entrytype = NULL;
$x_phoneno = NULL;
$x_client = NULL;

// Group variables
$o_date1 = NULL; $g_date1 = NULL; $dg_date1 = NULL; $t_date1 = NULL; $ft_date1 = 133; $gf_date1 = $ft_date1; $gb_date1 = ""; $gi_date1 = "0"; $gq_date1 = ""; $rf_date1 = NULL; $rt_date1 = NULL;

// Detail variables
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_price = NULL; $t_price = NULL; $ft_price = 5; $rf_price = NULL; $rt_price = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 3;
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
       
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Cost Per Egg 
	    From&nbsp;<?php echo date($datephp,strtotime($fdatedump)); ?> &nbsp;To&nbsp;<?php echo date($datephp,strtotime($tdatedump));?></font></strong></td>
</tr>
</table>


<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="layerbreeder_eggcostprice.php?<?php echo $url; ?>&export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="layerbreeder_eggcostprice.php?<?php echo $url; ?>&export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="layerbreeder_eggcostprice.php?<?php echo $url; ?>&export=word">Export to Word</a><br /><br />
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
	<tr class="ewTableHeader">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="3" align="center">Including Chick&amp;Grower</td>
	<td colspan="3" align="center">Excluding Chick&amp;Grower</td>
	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Eggs Produced
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Eggs Produced</td>
			</tr></table>
		</td>
		
	<?php } ?>	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed Consumed
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Consumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Medicines/Vaccines Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Medicines/Vaccines Consumed</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cost Per Egg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cost Per Egg</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Feed Consumed
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Feed Consumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Medicines/Vaccines Consumed
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Medicines/Vaccines Consumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Cost Per Egg 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cost Per Egg</td>
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
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_date1, EW_REPORT_DATATYPE_DATE);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_date1, EW_REPORT_DATATYPE_DATE, $gb_date1, $gi_date1, $gq_date1);
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
		$dg_date1 = $x_date1;
		if ((is_null($x_date1) && is_null($o_date1)) ||
			(($x_date1 <> "" && $o_date1 == $dg_date1) && !ChkLvlBreak(1))) {
			$dg_date1 = "&nbsp;";
		} elseif (is_null($x_date1)) {
			$dg_date1 = EW_REPORT_NULL_LABEL;
		} elseif ($x_date1 == "") {
			$dg_date1 = EW_REPORT_EMPTY_LABEL;
		}
?>
	<tr>
		<td <?php echo $sItemRowClass; ?>>
		<?php $t_date1 = $x_date1; $x_date1 = $dg_date1; ?>
<?php $datecur=date($datephp,strtotime($x_date1));
        echo $datecur; ?>
		<?php $x_date1 = $t_date1; ?></td>
		
		<td<?php echo $sItemRowClass; ?> align="right">
		<?php $totaleggs+=$x_quantity; echo ewrpt_ViewValue(changequantity($x_quantity)) ?>
</td>
<?php

//retriving the the production flocks of the day
$productionflocks = "'";
 $query = "select distinct(flock) from layerbreeder_production where date1 = '$x_date1'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
 $productionflocks .= $res['flock']."','";
 
 $productionflocks = substr($productionflocks,0,-2);

// including chick and grower
$qu="select sum(materialcost) as mcost,sum(production) as production from feed_productionunit where date >= '$fdate' and date<='$x_date1' and mash in(select distinct(code) from ims_itemcodes where cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1);
$re1=mysql_fetch_assoc($re1);
$mcost=$re1['mcost'];
$production=$re1['production'];
$feedcost=$mcost/$production;
if($feedcost=='' or $feedcost==0) 
{
$qu="select sum(materialcost) as mcost,sum(production) as production from feed_productionunit where date <= '$x_date1' and mash in(select distinct(code) from ims_itemcodes where cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1);
$re1=mysql_fetch_assoc($re1);
$mcost=$re1['mcost'];
$production=$re1['production'];
$feedcost=$mcost/$production;

}

if($feedcost=='' or $feedcost==0) {
$qu="select sum(receivedquantity*rateperunit) as mcost,sum(receivedquantity) as production from pp_sobi where date >= '$fdate' and date<='$x_date1' and code in(select distinct(code) from ims_itemcodes where cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1) or die(mysql_error());
$re1=mysql_fetch_assoc($re1);
$mcost=$re1['mcost'];
$production=$re1['production']; 
 $feedcost=$mcost/$production;
}
if($feedcost=='' or $feedcost==0) {
$qu="select sum(receivedquantity*rateperunit) as mcost,sum(receivedquantity) as production from pp_sobi where date <= '$x_date1' and code in(select distinct(code) from ims_itemcodes where cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1) or die(mysql_error());
$re1=mysql_fetch_assoc($re1);
$mcost=$re1['mcost'];
$production=$re1['production'];
 $feedcost=$mcost/$production;
}

 $q="select sum(quantity) as quantity from layerbreeder_consumption where date2='$x_date1' and itemcode in(select distinct(code) from ims_itemcodes where cat LIKE'%Feed') ";
$r=mysql_query($q,$conn1);
$r=mysql_fetch_assoc($r);
$quantity=$r['quantity'];

$medvacc = 0;
$medvacctotal = 0;
 $q4="select sum(quantity) as quantity,itemcode from layerbreeder_consumption where date2='$x_date1' and itemcode in(select distinct(code) from ims_itemcodes  where cat In ('Medicines','Vaccines') ) group by itemcode";
$r4=mysql_query($q4,$conn1) or die(mysql_error());
while($rrows=mysql_fetch_assoc($r4))
{
$medvacc+= $rrows['quantity'];

$medvaccitemcode = $rrows['itemcode'];



  $que = "select distinct(cm) as mode from ims_itemcodes where code = '$medvaccitemcode' order by mode";
$res = mysql_query($que,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($res))
{
$medvaccmode = $res['mode']; 

$medvaccrate = calculate($medvaccmode,$medvaccitemcode,$x_date1,$medvacc);

$medvacctotal += ($medvacc * $medvaccrate);
}
}
//excluding chick and grower only

$qu="select sum(materialcost) as mcost,sum(production) as production from feed_productionunit where date >= '$fdate' and date<='$x_date1' and mash in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1);
$re1=mysql_fetch_assoc($re1);
$cgmcost=$re1['mcost'];
$cgproduction=$re1['production'];
$cgfeedcost=$cgmcost/$cgproduction;
if($cgfeedcost=='' or $cgfeedcost==0) 
{
$qu="select sum(materialcost) as mcost,sum(production) as production from feed_productionunit where date<='$x_date1' and mash in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1);
$re1=mysql_fetch_assoc($re1);
$cgmcost=$re1['mcost'];
$cgproduction=$re1['production'];
$cgfeedcost=$cgmcost/$cgproduction;

}

if($cgfeedcost=='' or $cgfeedcost==0) {
$qu="select sum(receivedquantity*rateperunit) as mcost,sum(receivedquantity) as production from pp_sobi where date >='$fdate' and date<='$x_date1' and code in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1) or die(mysql_error());
$re1=mysql_fetch_assoc($re1);
$cgmcost=$re1['mcost'];
$cgproduction=$re1['production'];
 $cgfeedcost=$cgmcost/$cgproduction;
}
if($cgfeedcost=='' or $cgfeedcost==0) {
$qu="select sum(receivedquantity*rateperunit) as mcost,sum(receivedquantity) as production from pp_sobi where date<='$x_date1' and code in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat LIKE '%Feed') ";
$re1=mysql_query($qu,$conn1) or die(mysql_error());
$re1=mysql_fetch_assoc($re1);
$cgmcost=$re1['mcost'];
$cgproduction=$re1['production'];
$cgfeedcost=$cgmcost/$cgproduction;
}

$q = "select sum(quantity) as quantity from layerbreeder_consumption  where date2 = '$x_date1' and itemcode in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat LIKE '%Feed') and flock in ($productionflocks)";
$result = mysql_query($q,$conn1) or die(mysql_error());
$cgfeed = mysql_fetch_assoc($result);
$cgfeed = $cgfeed['quantity'];

$cgfeedmedvacc = 0;
$cgfeedtotmedvacc = 0;
$q8 = "select sum(quantity) as quantity,itemcode from layerbreeder_consumption  where date2 = '$x_date1' and itemcode in(select distinct(code) from ims_itemcodes where description <> 'CHICK FEED' and description <> 'GROWER FEED' and cat In ('Medicines','Vaccines') ) and flock in ($productionflocks) group by itemcode";
$result8 = mysql_query($q8,$conn1) or die(mysql_error());
while($cgfeed8 = mysql_fetch_assoc($result8))
{
$cgfeedmedvacc+= $cgfeed8['quantity'];

$cgfeedmedvaccitemcode = $cgfeed8['itemcode'];


   $que1 = "select distinct(cm) as mode from ims_itemcodes where code = '$cgfeedmedvaccitemcode' order by mode";
$res1 = mysql_query($que1,$conn1) or die(mysql_error());
while($res11 = mysql_fetch_assoc($res1))
{
 $cgfeedmedvaccmode = $res11['mode'];

 $cgfeedtotmedvaccrate = calculate($cgfeedmedvaccmode,$cgfeedmedvaccitemcode,$x_date1,$cgfeedmedvacc);

$cgfeedtotmedvacc += ($cgfeedmedvacc * $cgfeedtotmedvaccrate);
}
}


$totprice=$quantity*$feedcost;
$totalcgprice = $cgfeed * $cgfeedcost;
$dd = $x_date1;
$days1 = 0;

 $totalcgprice;
//echo "ctotal".
$cgfeedtotmedvacc;

$tp = $totprice + $days1 + $medvacctotal;
$totalcgprice += ($days1 + $cgfeedtotmedvacc);


$date = $x_date1;


?>
<td<?php echo $sItemRowClass; ?> align="right"><?php $totalfeed+=$quantity; echo changeprice(round($quantity,2)); ?></td>




<td<?php echo $sItemRowClass; ?> align="right"><?php if($medvacc <> '') { ?><a href="details.php?date=<?php echo $date; ?>" target="_blank" ><?php echo changeprice(round($medvacc,2));  $totmedvacc += $medvacc;?></a> <?php } else { echo '0.00'; } ?> </td>

<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice(round(($tp/$x_quantity),2)); ?></td>

<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice(round($cgfeed,2)); $totalcgfeed += $cgfeed; ?></td>

<td<?php echo $sItemRowClass; ?> align="right"><?php if($cgfeedmedvacc <> '') { ?><a href="details1.php?date=<?php echo $date; ?>&production=<?php echo $productionflocks; ?>" target="_blank"><?php echo changeprice(round($cgfeedmedvacc,2)); $totalcgfeedmedvacc += $cgfeedmedvacc;  ?> </a> <?php } else { echo '0.00'; } ?></td>

<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice(round(($totalcgprice/$x_quantity),2)); ?>
</td>

	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();

		// Save old group values
		$o_date1 = $x_date1;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<?php
	} // End detail records loop
?>
<?php

	// Next group
	$o_date1 = $x_date1; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
} // End while
?>
<?php 
$nRecCount++;
if ($nRecCount % 2 <> 1)
	$sItemRowClass = " class=\"ewTableAltRow\"";
	else
	$sItemRowClass = " class=\"ewTableRow\"";
?>	
<tr>	
<td <?php echo $sItemRowClass; ?>><b> Total</b></td>	
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changequantity($totaleggs); ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changeprice(round($totalfeed,2)); ?></b></td>
<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice(round($totmedvacc,2)); ?></td>
<td <?php echo $sItemRowClass; ?> align="right"><b> <?php echo changeprice(round((($totalfeed * $feedcost)/$totaleggs),2)); ?></b></td>
<td <?php echo $sItemRowClass; ?> align="right"><b><?php echo changeprice(round($totalcgfeed,2)); ?></b></td>
<td<?php echo $sItemRowClass; ?> align="right"><?php echo changeprice(round($totalcgfeedmedvacc,2)); ?></td>
<td <?php echo $sItemRowClass; ?> align="right"><b> <?php echo changeprice(round((($totalcgfeed * $feedcost)/$totaleggs),2)); ?></b></td>
</tr>
	</tbody>
	
</table>
</div>
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
			return (is_null($GLOBALS["x_date1"]) && !is_null($GLOBALS["o_date1"])) ||
				(!is_null($GLOBALS["x_date1"]) && is_null($GLOBALS["o_date1"])) ||
				($GLOBALS["x_date1"] <> $GLOBALS["o_date1"]);
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
	if ($lvl <= 1) $GLOBALS["o_date1"] = "";

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
		$GLOBALS['x_date1'] = "";
	} else {
		$GLOBALS['x_date1'] = $rsgrp->fields('date1');
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
		$GLOBALS['x_flock'] = $rs->fields('flock');
		$GLOBALS['x_wo'] = $rs->fields('wo');
		$GLOBALS['x_reportedby'] = $rs->fields('reportedby');
		$GLOBALS['x_itemcode'] = $rs->fields('itemcode');
		$GLOBALS['x_itemdesc'] = $rs->fields('itemdesc');
		$GLOBALS['x_units'] = $rs->fields('units');
		$GLOBALS['x_quantity'] = $rs->fields('quantity');
		$GLOBALS['x_lotno'] = $rs->fields('lotno');
		$GLOBALS['x_slno'] = $rs->fields('slno');
		$GLOBALS['x_price'] = $rs->fields('price');
		$GLOBALS['x_flag'] = $rs->fields('flag');
		$GLOBALS['x_entrytype'] = $rs->fields('entrytype');
		$GLOBALS['x_phoneno'] = $rs->fields('phoneno');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_quantity'];
		$val[2] = $GLOBALS['x_price'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_flock'] = "";
		$GLOBALS['x_wo'] = "";
		$GLOBALS['x_reportedby'] = "";
		$GLOBALS['x_itemcode'] = "";
		$GLOBALS['x_itemdesc'] = "";
		$GLOBALS['x_units'] = "";
		$GLOBALS['x_quantity'] = "";
		$GLOBALS['x_lotno'] = "";
		$GLOBALS['x_slno'] = "";
		$GLOBALS['x_price'] = "";
		$GLOBALS['x_flag'] = "";
		$GLOBALS['x_entrytype'] = "";
		$GLOBALS['x_phoneno'] = "";
		$GLOBALS['x_client'] = "";
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
				$nDisplayGrps = "ALL"; // Non-numeric, load default
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
			$nDisplayGrps = "ALL"; // Load default
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
			$_SESSION["sort_layer_eggcostprice_date1"] = "";
			$_SESSION["sort_layer_eggcostprice_quantity"] = "";
			$_SESSION["sort_layer_eggcostprice_price"] = "";
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
