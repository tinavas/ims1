 <?php 
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
<?php } ?> 
<?php include "reportheader.php";
include "getemployee.php";
$unit = $_GET['unit']; 
$shed = $_GET['shed'];
?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="4"><strong><font color="#3e3276">Quail Shed History</font></strong></td>
</tr>
<tr>
 <td><strong>Unit:</strong></td>
 <td><?php echo $unit; ?></td>
 <td><strong>&nbsp;&nbsp;&nbsp;Shed:</strong></td>
 <td align="left"><?php echo $shed; ?></td>
</tr> 
</table>

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
?>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "shedreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "shedreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "shedreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "shedreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "shedreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "shedreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "quail_shed";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "client = '$client'";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = "";

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "quail_shed.farmcode", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " AS `farmcode` FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT SUM(quail_shed.shedcapacity) AS SUM_shedcapacity FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_shedcode = NULL; // Popup filter for shedcode
$af_sheddescription = NULL; // Popup filter for sheddescription
$af_shedtype = NULL; // Popup filter for shedtype
$af_shedcapacity = NULL; // Popup filter for shedcapacity
$af_farmcode = NULL; // Popup filter for farmcode
$af_farmdescription = NULL; // Popup filter for farmdescription
$af_unitcode = NULL; // Popup filter for unitcode
$af_unitdescription = NULL; // Popup filter for unitdescription
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
$EW_REPORT_FIELD_FARMCODE_SQL_SELECT = "SELECT DISTINCT quail_shed.farmcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_FARMCODE_SQL_ORDERBY = "quail_shed.farmcode";
$EW_REPORT_FIELD_UNITCODE_SQL_SELECT = "SELECT DISTINCT quail_shed.unitcode FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY = "quail_shed.unitcode";
?>
<?php

// Field variables
$x_shedcode = NULL;
$x_sheddescription = NULL;
$x_shedtype = NULL;
$x_shedcapacity = NULL;
$x_farmcode = NULL;
$x_farmdescription = NULL;
$x_unitcode = NULL;
$x_unitdescription = NULL;

// Group variables
$o_farmcode = NULL; $g_farmcode = NULL; $dg_farmcode = NULL; $t_farmcode = NULL; $ft_farmcode = 200; $gf_farmcode = $ft_farmcode; $gb_farmcode = ""; $gi_farmcode = "0"; $gq_farmcode = ""; $rf_farmcode = NULL; $rt_farmcode = NULL;
$o_farmdescription = NULL; $g_farmdescription = NULL; $dg_farmdescription = NULL; $t_farmdescription = NULL; $ft_farmdescription = 200; $gf_farmdescription = $ft_farmdescription; $gb_farmdescription = ""; $gi_farmdescription = "0"; $gq_farmdescription = ""; $rf_farmdescription = NULL; $rt_farmdescription = NULL;
$o_unitcode = NULL; $g_unitcode = NULL; $dg_unitcode = NULL; $t_unitcode = NULL; $ft_unitcode = 200; $gf_unitcode = $ft_unitcode; $gb_unitcode = ""; $gi_unitcode = "0"; $gq_unitcode = ""; $rf_unitcode = NULL; $rt_unitcode = NULL;
$o_unitdescription = NULL; $g_unitdescription = NULL; $dg_unitdescription = NULL; $t_unitdescription = NULL; $ft_unitdescription = 200; $gf_unitdescription = $ft_unitdescription; $gb_unitdescription = ""; $gi_unitdescription = "0"; $gq_unitdescription = ""; $rf_unitdescription = NULL; $rt_unitdescription = NULL;

// Detail variables
$o_shedcode = NULL; $t_shedcode = NULL; $ft_shedcode = 200; $rf_shedcode = NULL; $rt_shedcode = NULL;
$o_sheddescription = NULL; $t_sheddescription = NULL; $ft_sheddescription = 200; $rf_sheddescription = NULL; $rt_sheddescription = NULL;
$o_shedtype = NULL; $t_shedtype = NULL; $ft_shedtype = 200; $rf_shedtype = NULL; $rt_shedtype = NULL;
$o_shedcapacity = NULL; $t_shedcapacity = NULL; $ft_shedcapacity = 5; $rf_shedcapacity = NULL; $rt_shedcapacity = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 5;
$nGrps = 5;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, FALSE, TRUE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_farmcode = "";
$seld_farmcode = "";
$val_farmcode = "";
$sel_unitcode = "";
$seld_unitcode = "";
$val_unitcode = "";

// Load default filter values
LoadDefaultFilters();

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

// Check if filter applied
$bFilterApplied = CheckFilter();

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
<?php $jsdata = ewrpt_GetJsData($val_farmcode, $sel_farmcode, $ft_farmcode) ?>
ewrpt_CreatePopup("shedreport_farmcode", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_unitcode, $sel_unitcode, $ft_unitcode) ?>
ewrpt_CreatePopup("shedreport_unitcode", [<?php echo $jsdata ?>]);
</script>
<div id="shedreport_farmcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="shedreport_unitcode_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
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
&nbsp;&nbsp;<a href="quail_shedhistory.php?export=html&shed=<?php echo $shed; ?>&unit=<?php echo $unit; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_shedhistory.php?export=excel&shed=<?php echo $shed; ?>&unit=<?php echo $unit; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_shedhistory.php?export=word&shed=<?php echo $shed; ?>&unit=<?php echo $unit; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_shedhistory.php?cmd=reset&shed=<?php echo $shed; ?>&unit=<?php echo $unit; ?>">Reset All Filters</a>
<?php } ?>
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
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
  <td>Unit </td>
  <td><select id="unitcode" name="unitcode" onchange="getSheds(this.value);">
      <option value="select">-Select</option>
      <?php
	  include "config.php";
	  $query = "SELECT distinct(unitcode),unitdescription FROM quail_unit WHERE client = '$client' ORDER BY unitcode ASC";
	  $result = mysql_query($query,$conn1) or die(mysql_error());
	  while($rows = mysql_fetch_assoc($result))
	  {
	   ?>
	   <option value="<?php echo $rows['unitcode']; ?>" title="<?php echo $rows['unitdescription']; ?>" <?php if($unit == $rows['unitcode']) { ?> selected="selected" <?php } ?>><?php echo $rows['unitcode']; ?></option>
	   <?php
	  }
	  ?>
</select>
</td>
 <td width="20px"></td>
  <td>Shed </td>
  <td><select id="shed" name="shed" onchange="reloadpage();">
      <option value="">-Select</option>
      <?php
	  include "config.php";
	  $query = "SELECT distinct(shedcode),sheddescription FROM quail_shed WHERE client = '$client' AND unitcode = '$unit' ORDER BY shedcode ASC";
	  $result = mysql_query($query,$conn1) or die(mysql_error());
	  while($rows = mysql_fetch_assoc($result))
	  {
	   ?>
	   <option value="<?php echo $rows['shedcode']; ?>" title="<?php echo $rows['sheddescription']; ?>" <?php if($shed == $rows['shedcode']) { ?> selected="selected" <?php } ?>><?php echo $rows['shedcode']; ?></option>
	   <?php
	  }
	  ?>
</select>
</td>
</tr>
</table>	  
</div>
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
//while (($rsgrp && !$rsgrp->EOF && $nGrpCount <= $nDisplayGrps) || $bShowFirstHeader) {

	// Show header

?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:50px;">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:50px;">Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		From Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;">From Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		To Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;">To Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Female Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;">Female Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Male Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;">Male Birds</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	

	// Build detail SQL
	//$sWhere = EW_REPORT_TABLE_FIRST_GROUP_FIELD . " = " . ewrpt_QuotedValue($x_farmcode, EW_REPORT_DATATYPE_STRING);

	$sWhere = ewrpt_DetailFilterSQL(EW_REPORT_TABLE_FIRST_GROUP_FIELD, $x_farmcode, EW_REPORT_DATATYPE_STRING, $gb_farmcode, $gi_farmcode, $gq_farmcode);
	if ($sFilter != "")
		$sWhere = "($sFilter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, $sWhere, @$sSort);

//	echo "sql: " . $sSql . "<br>";
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		GetRow(1);
//	while ($rs && !$rs->EOF) { // Loop detail records
		$nRecCount++;
$femaleopening = $maleopening = 0;		
 $query2 = "SELECT distinct(flock) FROM `quail_consumption` WHERE flock IN ( SELECT distinct(flockcode) FROM quail_flock WHERE shedcode = '$shed' AND client = '$client' and unitcode = '$unit') AND client = '$client'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($result2))
{

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";


?>
	<tr>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows2['flock']) ?>
		<?php $x_farmcode = $t_farmcode; ?></td>
<?php
 $query3 = "SELECT max(age) as age,min(date2) as fromdate,max(date2) as todate FROM quail_consumption WHERE flock = '$rows2[flock]' AND client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
$rows3 = mysql_fetch_assoc($result3);

$fromdate = date($datephp,strtotime($rows3['fromdate']));
$todate = date($datephp,strtotime($rows3['todate']));
?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows3['age']) ?>

		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($fromdate) ?>

		<td class="ewRptGrpField4">
<?php echo ewrpt_ViewValue($todate) ?>
	</tr>
	<?php
	
	$qj = "select * from quail_flock where flockcode = '$rows2[flock]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
		 {
                $fopening = $qrj['femaleopening'];
				$cullflag = $qrj['cullflag'];
				}

             $minus = 0; 
			 $minus1 = 0;
             $qj = "select distinct(date2),fmort,fcull,mmort,mcull from quail_consumption where flock = '$rows2[flock]'  "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $minus = $minus + $qrj['fmort'] + $qrj['fcull'];

            $ftransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'Quail Female Birds' and fromwarehouse = '$rows2[flock]' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $ftransfer = $ftransfer +  $qrj['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
			 
			
			$ttransfer = 0;
            $qj = "select * from ims_stocktransfer where cat = 'Quail Female Birds' and towarehouse = '$rows2[flock]' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $ttransfer = $ttransfer + $qrj['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

			 $fquantfc = 0;
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$rows2[flock]'  AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fquantfc = $fquantfc + $qr['quant'];
               }
             }
             else
             {
                $fquantfc = 0;
             } 
			 
			 $fquantso = 0;
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$rows2[flock]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fquantso = $fquantso + $qr['quant'];
               }
             }
             else
             {
                $fquantso = 0;
             } 
			 
			
			 $birdssend = 0;
			 $q = "select * from quail_breeder_sender where cat = 'Quail Female Birds' and farm = '$unit' and flock = '$rows2[flock]' and client = '$client'";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $birdssend = $birdssend + $qr['birds'];
               }
             }
             else
             {
                $birdssend = 0;
             } 
             $remaining = 0;
			// echo $fopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$fquantfc."/".$fquantso."/".$birdssend; 
             $remaining = $fopening - $minus - $ftransfer + $ttransfer + $fquantfc - $fquantso - $birdssend;
			 
	?>
	<?php
	
	$qj = "select * from quail_flock where flockcode = '$rows2[flock]'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $mopening = $qrj['maleopening'];

             $mminus = 0; 
			 $mminus1 = 0;
             $qj = "select distinct(date2),mmort,mcull from quail_consumption where flock = '$rows2[flock]'  "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $mminus = $mminus + $qrj['mmort'] + $qrj['mcull'];

            $mtransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'Quail Male Birds' and fromwarehouse = '$rows2[flock]' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $mtransfer = $mtransfer +  $qrj['quantity'];
               }
             }
             else
             {
                $mftransfer = 0;
             } 
			 
			
			$mttransfer = 0;
            $qj = "select * from ims_stocktransfer where cat = 'Quail Male Birds' and towarehouse = '$rows2[flock]' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $mttransfer = $mttransfer + $qrj['quantity'];
               }
             }
             else
             {
                $mttransfer = 0;
             } 

			 $mfquantfc = 0;
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$rows2[flock]'  AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mfquantfc = $mfquantfc + $qr['quant'];
               }
             }
             else
             {
                $mfquantfc = 0;
             } 
			 
			 $mfquantso = 0;
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$rows2[flock]' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantso = $mquantso + $qr['quant'];
               }
             }
             else
             {
                $mquantso = 0;
             } 
			 
			  $birdssend = 0;
			 $q = "select * from quail_breeder_sender where cat = 'Quail Male Birds' and farm = '$unit' and flock = '$rows2[flock]' and client = '$client'";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $birdssend = $birdssend + $qr['birds'];
               }
             }
             else
             {
                $birdssend = 0;
             } 
			             $mremaining = 0;
			 //echo $flockkk."/".$mopening."/".$mminus."/".$mtransfer."/".$mttransfer."/".$mfquantfc; echo"/B";
             $mremaining = $mopening - $mminus - $mtransfer + $mttransfer + $mfquantfc - $mfquantso - $birdssend;
			 
	?>

		<td class="ewRptGrpField4"  align="right" style="padding-right:15px;" align="right">
<?php if($cullflag == 1){ echo ewrpt_ViewValue("Shifted"); } else { echo ewrpt_ViewValue(changequantity($remaining)); } ?>
	</tr>

		<td class="ewRptGrpField4"  align="right" style="padding-right:15px;" align="right">
<?php if($cullflag == 1){ echo ewrpt_ViewValue("Shifted"); } else { echo ewrpt_ViewValue(changequantity($mremaining)); }  ?>
	</tr>

<?php
if($cullflag <> 1)
{
$femaleopening += $remaining;
$maleopening += $mremaining;
}
}

		// Accumulate page summary
		//AccumulateSummary();

		// Save old group values
		$o_farmcode = $x_farmcode;
		$o_farmdescription = $x_farmdescription;
		$o_unitcode = $x_unitcode;
		$o_unitdescription = $x_unitdescription;

		// Get next record
		GetRow(2);

		// Show Footers
?>
<tr>
 <td colspan="4" align="right" style="padding-right:15px;"><b>SUM</b></td>
 <td align="right" style="padding-right:15px;"><b><?php echo $femaleopening; ?></b></td>
 <td align="right" style="padding-right:15px;"><b><?php echo $maleopening; ?></b></td>
</tr>
<tr>
 <td colspan="4" align="right" style="padding-right:15px;"><b>Shed Capacity</b></td>
 <td colspan="2" align="center"><b>
 <?php
  $query = "SELECT shedcapacity FROM quail_shed WHERE shedcode = '$shed' AND client = '$client'";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  $rows = mysql_fetch_assoc($result);
  echo $rows['shedcapacity'];
 ?></b>
 </td>
</tr>   
<?php
	//} // End detail records loop
?>

<?php

	// Next group
	$o_farmcode = $x_farmcode; // Save old group value
	GetGrpRow(2);
	$nGrpCount++;
//} // End while
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
		$grandsmry[4] = $rsagg->fields("SUM_shedcapacity");
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
 </tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">

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
			return (is_null($GLOBALS["x_farmcode"]) && !is_null($GLOBALS["o_farmcode"])) ||
				(!is_null($GLOBALS["x_farmcode"]) && is_null($GLOBALS["o_farmcode"])) ||
				($GLOBALS["x_farmcode"] <> $GLOBALS["o_farmcode"]);
		case 2:
			return (is_null($GLOBALS["x_farmdescription"]) && !is_null($GLOBALS["o_farmdescription"])) ||
				(!is_null($GLOBALS["x_farmdescription"]) && is_null($GLOBALS["o_farmdescription"])) ||
				($GLOBALS["x_farmdescription"] <> $GLOBALS["o_farmdescription"]) || ChkLvlBreak(1); // Recurse upper level
		case 3:
			return (is_null($GLOBALS["x_unitcode"]) && !is_null($GLOBALS["o_unitcode"])) ||
				(!is_null($GLOBALS["x_unitcode"]) && is_null($GLOBALS["o_unitcode"])) ||
				($GLOBALS["x_unitcode"] <> $GLOBALS["o_unitcode"]) || ChkLvlBreak(2); // Recurse upper level
		case 4:
			return (is_null($GLOBALS["x_unitdescription"]) && !is_null($GLOBALS["o_unitdescription"])) ||
				(!is_null($GLOBALS["x_unitdescription"]) && is_null($GLOBALS["o_unitdescription"])) ||
				($GLOBALS["x_unitdescription"] <> $GLOBALS["o_unitdescription"]) || ChkLvlBreak(3); // Recurse upper level
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
	if ($lvl <= 1) $GLOBALS["o_farmcode"] = "";
	if ($lvl <= 2) $GLOBALS["o_farmdescription"] = "";
	if ($lvl <= 3) $GLOBALS["o_unitcode"] = "";
	if ($lvl <= 4) $GLOBALS["o_unitdescription"] = "";

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
		$GLOBALS['x_farmcode'] = "";
	} else {
		$GLOBALS['x_farmcode'] = $rsgrp->fields('farmcode');
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
		$GLOBALS['x_shedcode'] = $rs->fields('shedcode');
		$GLOBALS['x_sheddescription'] = $rs->fields('sheddescription');
		$GLOBALS['x_shedtype'] = $rs->fields('shedtype');
		$GLOBALS['x_shedcapacity'] = $rs->fields('shedcapacity');
		$GLOBALS['x_farmdescription'] = $rs->fields('farmdescription');
		$GLOBALS['x_unitcode'] = $rs->fields('unitcode');
		$GLOBALS['x_unitdescription'] = $rs->fields('unitdescription');
		$val[1] = $GLOBALS['x_shedcode'];
		$val[2] = $GLOBALS['x_sheddescription'];
		$val[3] = $GLOBALS['x_shedtype'];
		$val[4] = $GLOBALS['x_shedcapacity'];
	} else {
		$GLOBALS['x_shedcode'] = "";
		$GLOBALS['x_sheddescription'] = "";
		$GLOBALS['x_shedtype'] = "";
		$GLOBALS['x_shedcapacity'] = "";
		$GLOBALS['x_farmdescription'] = "";
		$GLOBALS['x_unitcode'] = "";
		$GLOBALS['x_unitdescription'] = "";
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
	// Build distinct values for farmcode

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_FARMCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_FARMCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_farmcode = $rswrk->fields[0];
		if (is_null($x_farmcode)) {
			$bNullValue = TRUE;
		} elseif ($x_farmcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_farmcode = $x_farmcode;
			$dg_farmcode = $x_farmcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], $g_farmcode, $dg_farmcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_farmcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for unitcode
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_UNITCODE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_unitcode = $rswrk->fields[0];
		if (is_null($x_unitcode)) {
			$bNullValue = TRUE;
		} elseif ($x_unitcode == "") {
			$bEmptyValue = TRUE;
		} else {
			$g_unitcode = $x_unitcode;
			$dg_unitcode = $x_unitcode;
			ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], $g_unitcode, $dg_unitcode, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_unitcode"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('farmcode');
			ClearSessionSelection('unitcode');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Farmcode selected values

	if (is_array(@$_SESSION["sel_shedreport_farmcode"])) {
		LoadSelectionFromSession('farmcode');
	} elseif (@$_SESSION["sel_shedreport_farmcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_farmcode"] = "";
	}

	// Get Unitcode selected values
	if (is_array(@$_SESSION["sel_shedreport_unitcode"])) {
		LoadSelectionFromSession('unitcode');
	} elseif (@$_SESSION["sel_shedreport_unitcode"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_unitcode"] = "";
	}
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

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_shedreport_$parm"] = "";
	$_SESSION["rf_shedreport_$parm"] = "";
	$_SESSION["rt_shedreport_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_shedreport_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_shedreport_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_shedreport_$parm"];
}

// Load default value for filters
function LoadDefaultFilters() {

	/**
	* Set up default values for non Text filters
	*/

	/**
	* Set up default values for extended filters
	* function SetDefaultExtFilter($parm, $so1, $sv1, $sc, $so2, $sv2)
	* Parameters:
	* $parm - Field name
	* $so1 - Default search operator 1
	* $sv1 - Default ext filter value 1
	* $sc - Default search condition (if operator 2 is enabled)
	* $so2 - Default search operator 2 (if operator 2 is enabled)
	* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
	*/

	/**
	* Set up default values for popup filters
	* NOTE: if extended filter is enabled, use default values in extended filter instead
	*/

	// Field farmcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_farmcode = array("val1", "val2");

	$GLOBALS["seld_farmcode"] = "";
	$GLOBALS["sel_farmcode"] =  $GLOBALS["seld_farmcode"];

	// Field unitcode
	// Setup your default values for the popup filter below, e.g.
	// $seld_unitcode = array("val1", "val2");

	$GLOBALS["seld_unitcode"] = "";
	$GLOBALS["sel_unitcode"] =  $GLOBALS["seld_unitcode"];
}

// Check if filter applied
function CheckFilter() {

	// Check farmcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_farmcode"], $GLOBALS["sel_farmcode"]))
		return TRUE;

	// Check unitcode popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_unitcode"], $GLOBALS["sel_unitcode"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field farmcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_farmcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_farmcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Farmcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field unitcode
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_unitcode"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_unitcode"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Unitcode<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Show Filters
	if ($sFilterList <> "")
		echo "CURRENT FILTERS:<br />$sFilterList";
}

/**
 * Regsiter your Custom filters here
 */

// Setup custom filters
function SetupCustomFilters() {

	// 1. Register your custom filter below (see example)
	// 2. Write your custom filter function (see example fucntions: GetLastMonthFilter, GetStartsWithAFilter)

}

/**
 * Write your Custom filters here
 */

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression) {
	$today = getdate();
	$lastmonth = mktime(0, 0, 0, $today['mon']-1, 1, $today['year']);
	$sVal = date("Y|m", $lastmonth);
	$sWrk = $FldExpression . " BETWEEN " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 1), EW_REPORT_DATATYPE_DATE) .
		" AND " .
		ewrpt_QuotedValue(DateVal("month", $sVal, 2), EW_REPORT_DATATYPE_DATE);
	return $sWrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression) {
	return $FldExpression . " LIKE 'A%'";
}
?>
<?php

// Return poup filter
function GetPopupFilter() {
	$sWrk = "";
	if (is_array($GLOBALS["sel_farmcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_farmcode"], "breeder_shed.farmcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_farmcode"], $GLOBALS["gb_farmcode"], $GLOBALS["gi_farmcode"], $GLOBALS["gq_farmcode"]);
	}
	if (is_array($GLOBALS["sel_unitcode"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_unitcode"], "breeder_shed.unitcode", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_unitcode"], $GLOBALS["gb_unitcode"], $GLOBALS["gi_unitcode"], $GLOBALS["gq_unitcode"]);
	}
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
			$_SESSION["sort_shedreport_farmcode"] = "";
			$_SESSION["sort_shedreport_farmdescription"] = "";
			$_SESSION["sort_shedreport_unitcode"] = "";
			$_SESSION["sort_shedreport_unitdescription"] = "";
			$_SESSION["sort_shedreport_shedcode"] = "";
			$_SESSION["sort_shedreport_sheddescription"] = "";
			$_SESSION["sort_shedreport_shedtype"] = "";
			$_SESSION["sort_shedreport_shedcapacity"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "breeder_shed.shedcode ASC";
		$_SESSION["sort_shedreport_shedcode"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>

<script type="text/javascript">
function test()
{

}

function getSheds(a)
{
 var shed = document.getElementById("shed");
 for(i=shed.options.length-1;i>=0;i--)
  shed.remove(i);
 var shed = document.getElementById('shed');
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  theOption1.value = "";
  shed.appendChild(theOption1);
<?php
$query1 = "SELECT distinct(unitcode) FROM quail_unit WHERE client = '$client' ORDER BY unitcode ASC";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 echo "if(a == '$rows1[unitcode]') { ";
 $query2 = "SELECT distinct(shedcode),sheddescription FROM quail_shed WHERE unitcode = '$rows1[unitcode]' AND client = '$client' ORDER BY shedcode ASC";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 ?>
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("<?php echo $rows2['shedcode']; ?>");
  theOption1.appendChild(theText1);
  theOption1.value = "<?php echo $rows2['shedcode']; ?>";
  theOption1.title = "<?php echo $rows2['sheddescription']; ?>";
  shed.appendChild(theOption1);

 <?php
 }
 echo " } ";
}
?>  
  
}
function reloadpage()
{
	var shed = document.getElementById('shed').value;
	var unitcode = document.getElementById('unitcode').value;
	document.location = "quail_shedhistory.php?shed=" + shed + "&unit=" + unitcode;
}
</script>
