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
<?php }
session_start();
$client = $_SESSION['client'];
$flock = $_GET['flock'];
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
<?php include "../../getemployee.php"; ?>
<?php include "reportheader.php"; ?>
<?php include "config.php"; 
      include "getemployee.php";?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Flock wise HHCC Report</font></strong></td>
</tr>
</table>

<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "flockwiseHHCCreport", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "flockwiseHHCCreport_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "flockwiseHHCCreport_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "flockwiseHHCCreport_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "flockwiseHHCCreport_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "flockwiseHHCCreport_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "`breeder_production`";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$EW_REPORT_TABLE_SQL_CHART_BASE = $EW_REPORT_TABLE_SQL_FROM;

// Table Level Group SQL
define("EW_REPORT_TABLE_FIRST_GROUP_FIELD", "", TRUE);
$EW_REPORT_TABLE_SQL_SELECT_GROUP = "SELECT DISTINCT " . EW_REPORT_TABLE_FIRST_GROUP_FIELD . " FROM " . $EW_REPORT_TABLE_SQL_FROM;

// Table Level Aggregate SQL
$EW_REPORT_TABLE_SQL_SELECT_AGG = "SELECT * FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_AGG_PFX = "";
$EW_REPORT_TABLE_SQL_AGG_SFX = "";
$EW_REPORT_TABLE_SQL_SELECT_COUNT = "SELECT COUNT(*) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$af_id = NULL; // Popup filter for id
$af_date1 = NULL; // Popup filter for date1
$af_flock = NULL; // Popup filter for flock
$af_wo = NULL; // Popup filter for wo
$af_reportedby = NULL; // Popup filter for reportedby
$af_itemcode = NULL; // Popup filter for itemcode
$af_itemdesc = NULL; // Popup filter for itemdesc
$af_units = NULL; // Popup filter for units
$af_quantity = NULL; // Popup filter for quantity
$af_lotno = NULL; // Popup filter for lotno
$af_slno = NULL; // Popup filter for slno
$af_price = NULL; // Popup filter for price
$af_flag = NULL; // Popup filter for flag
$af_updated = NULL; // Popup filter for updated
$af_client = NULL; // Popup filter for client
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
$nDisplayGrps = 10; // Groups per page
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
$x_updated = NULL;
$x_client = NULL;

// Detail variables
$o_id = NULL; $t_id = NULL; $ft_id = 3; $rf_id = NULL; $rt_id = NULL;
$o_date1 = NULL; $t_date1 = NULL; $ft_date1 = 133; $rf_date1 = NULL; $rt_date1 = NULL;
$o_flock = NULL; $t_flock = NULL; $ft_flock = 200; $rf_flock = NULL; $rt_flock = NULL;
$o_wo = NULL; $t_wo = NULL; $ft_wo = 200; $rf_wo = NULL; $rt_wo = NULL;
$o_reportedby = NULL; $t_reportedby = NULL; $ft_reportedby = 200; $rf_reportedby = NULL; $rt_reportedby = NULL;
$o_itemcode = NULL; $t_itemcode = NULL; $ft_itemcode = 200; $rf_itemcode = NULL; $rt_itemcode = NULL;
$o_itemdesc = NULL; $t_itemdesc = NULL; $ft_itemdesc = 200; $rf_itemdesc = NULL; $rt_itemdesc = NULL;
$o_units = NULL; $t_units = NULL; $ft_units = 200; $rf_units = NULL; $rt_units = NULL;
$o_quantity = NULL; $t_quantity = NULL; $ft_quantity = 5; $rf_quantity = NULL; $rt_quantity = NULL;
$o_lotno = NULL; $t_lotno = NULL; $ft_lotno = 200; $rf_lotno = NULL; $rt_lotno = NULL;
$o_slno = NULL; $t_slno = NULL; $ft_slno = 200; $rf_slno = NULL; $rt_slno = NULL;
$o_price = NULL; $t_price = NULL; $ft_price = 5; $rf_price = NULL; $rt_price = NULL;
$o_flag = NULL; $t_flag = NULL; $ft_flag = 3; $rf_flag = NULL; $rt_flag = NULL;
$o_updated = NULL; $t_updated = NULL; $ft_updated = 135; $rf_updated = NULL; $rt_updated = NULL;
$o_client = NULL; $t_client = NULL; $ft_client = 200; $rf_client = NULL; $rt_client = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 16;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

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
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker" align="center">
<!-- top slot -->
<a name="top"></a>
<?php } ?>

<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="flockwiseHHCCreportsmry.php?flock=<?php echo $flock; ?>&export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="flockwiseHHCCreportsmry.php?flock=<?php echo $flock; ?>&export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="flockwiseHHCCreportsmry.php?flock=<?php echo $flock; ?>&export=word">Export to Word</a><br /><br />
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
<center>
<div id="report_summary">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">

</div>

<?php } ?>




<?php
	//Manual Coding Starts Here
$cummeggsset = 0;	
$cummhatch = 0;
//$query1 = "SELECT age from breeder_flock WHERE flockcode = '$flock' AND client = '$client' ORDER BY age ASC";
$query1 = "SELECT DISTINCT (b2.date2), b2.age FROM breeder_production b1, breeder_consumption b2 WHERE b2.flock = '$flock' AND b1.flock = '$flock' AND b1.date1 = b2.date2 ORDER BY `b2`.`age` ASC LIMIT 1";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
$age = $rows1['age'];
$from_date = $rows1['date2'];
$to = strtotime($from_date) + (7 * 24 * 60 * 60);
$to_date = date("Y-m-d",$to);
$from_age = $age;
$get_weeks = floor($age/7);
$get_rem = $age%7;
$to_age = ($age + (7 - $get_rem));

//Get Production
$query2 = "SELECT sum(quantity) quantity FROM breeder_production WHERE date1 >= '$from_date' AND date1 <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$quantity = $rows2['quantity'];


//Get Rejections, Eggset
$query3 = "SELECT sum(reject) reject, sum(eggsset) eggsset FROM hatchery_traysetting WHERE settingdate >= '$from_date' AND settingdate <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
$rows3 = mysql_fetch_assoc($result3);
$reject = $rows3['reject'];
$eggsset = $rows3['eggsset'];
$cummeggsset += $eggsset;

//Get Chicks hatched
$query4 = "SELECT sum(hatch) hatch FROM hatchery_hatchrecord WHERE settingdate >= '$from_date' AND settingdate <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result4 = mysql_query($query4,$conn1) or die(mysql_error());
$rows4 = mysql_fetch_assoc($result4);
$hatch = $rows4['hatch'];

if($reject == 0)
{ 
 $reject = "0";
 $eggsset = "0";
}
if($hatch == 0)
 $hatch = "0";

$cummhatch += $hatch; 

$age = floor($age/7);

//Standard Chicks per week,Cumm. chicks
$query5 = "SELECT chicksperweek,cumchicks FROM breeder_standards WHERE age = '$age' and client = '$client'";
$result5 = mysql_query($query5,$conn1) or die(mysql_error());
$rows5 = mysql_fetch_assoc($result5);
$chicksperweek = $rows5['chicksperweek'];
$cumchicks = $rows5['cumchicks'];

//Actual chicks per weeek
$query6 = "SELECT femaleopening FROM breeder_flock WHERE flockcode = '$flock' and client = '$client'";
$result6 = mysql_query($query6,$conn1) or die(mysql_error());
$rows6 = mysql_fetch_assoc($result6);
$femaleopen = $rows6['femaleopening'];

$query7 = "SELECT fmort,fcull FROM breeder_consumption WHERE flock = '$flock' AND date2 = '$from_date' AND client = '$client' LIMIT 1";
$result7 = mysql_query($query7,$conn1) or die(mysql_error());
$rows7 = mysql_fetch_assoc($result7);
$sum1 = $rows7['fmort'] + $rows7['fcull'];
$ob = $femaleopen - $sum1;
$achicksperweek = ($hatch / $ob);
$temp = explode('.',$achicksperweek);
if($temp[1])
 $achicksperweek = $temp[0].".".substr($temp[1],0,1);
else
 $achicksperweek = $temp[0];
$chicksdiff = $achicksperweek - $chicksperweek;

//Actual Cummulative Chicks per bird
$acumchicks = ($cummhatch/$femaleopen);
$temp = explode('.',$acumchicks);
if($temp[1])
 $acumchicks = $temp[0].".".substr($temp[1],0,1);
else
 $acumchicks = $temp[0];
$cumchicksdiff = $acumchicks - $cumchicks;
	//Manual Coding ends here
	
?>


<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Age in weeks">Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Production</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Rejections
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Rejections</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Eggs set
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Eggs set</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Eggsset">
		C. Eggs set
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Eggs set">C.Eggs set</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Chicks Hatched
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Chicks Hatched</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Chicks per week Actual">
		Act.Chicks/week
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Actual Chicks per week">Act. Chicks/week</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Chicks per week Standard">
		Std. Chicks/week
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Standard Chicks per week">Std. Chicks/week </td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Diff.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Difference between Actual and Standard Chicks per week">Diff.</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Chicks Hatched">
		C. Chicks Hatched
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Chicks Hatched">C.Chicks Hatched</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Act. C. Chicks/bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Actual Cummulative Chicks per bird">Act. C.Chicks/bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std. C. Chicks/bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Standard Cummulative Chicks per bird">Std. C.Chicks/bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:auto">
		Diff.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Difference between Actual and Standard Cummulative Chicks per bird" align="center">Diff.</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
		$bShowFirstHeader = FALSE;
	//}
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
<!-- Displaying 1st Record-->
	<tr>
		<td<?php echo $sItemRowClass; ?> align="center">
<?php echo ewrpt_ViewValue($age) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($quantity)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($reject)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($eggsset)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right" style="padding-right:20px">
<?php echo ewrpt_ViewValue(changequantity($cummeggsset)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($hatch)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($achicksperweek)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($chicksperweek)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($chicksdiff)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right" style="padding-right:20px">
<?php echo ewrpt_ViewValue(changequantity($cummhatch)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($acumchicks)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($cumchicks)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($cumchicksdiff)); ?>
</td>

	</tr>



<!--Displaying Remaining Records-->

<?php
	//Manual Coding Starts Here
$query = "SELECT max(date1) maxdate FROM breeder_production WHERE flock = '$flock' AND client = '$client'";	
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_array($result);
$maxdate = $rows['maxdate'];

$from_date = $to_date;
$to = strtotime($from_date) + (7 * 24 * 60 * 60);
$to_date = date("Y-m-d",$to);

$maxdate;
$rcolor=0;
while($from_date <= $maxdate)
{


//Get Production
$query2 = "SELECT sum(quantity) quantity FROM breeder_production WHERE date1 >= '$from_date' AND date1 <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
$quantity = $rows2['quantity'];


//Get Rejections, Eggset
$query3 = "SELECT sum(reject) reject, sum(eggsset) eggsset FROM hatchery_traysetting WHERE settingdate >= '$from_date' AND settingdate <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result3 = mysql_query($query3,$conn1) or die(mysql_error());
$rows1 = mysql_num_rows($result3);
$rows3 = mysql_fetch_assoc($result3);
$reject = $rows3['reject'];
$eggsset = $rows3['eggsset'];
$cummeggsset += $eggsset;

//Get Chicks hatched
$query4 = "SELECT sum(hatch) hatch FROM hatchery_hatchrecord WHERE settingdate >= '$from_date' AND settingdate <= '$to_date' AND flock = '$flock' AND client = '$client'";
$result4 = mysql_query($query4,$conn1) or die(mysql_error());
$rows2 = mysql_num_rows($result4);
$rows4 = mysql_fetch_assoc($result4);
$hatch = $rows4['hatch'];
$cummhatch += $hatch; 
if($reject == 0)
{ 
 $reject = "0";
 $eggsset = "0";
}
if($hatch == 0)
 $hatch = "0";
//Standard Chicks per week,Cumm. chicks
$query5 = "SELECT chicksperweek,cumchicks FROM breeder_standards WHERE age = '$age' and client = '$client'";
$result5 = mysql_query($query5,$conn1) or die(mysql_error());
$rows5 = mysql_fetch_assoc($result5);
$chicksperweek = $rows5['chicksperweek'];
$cumchicks = $rows5['cumchicks'];

//Actual chicks per weeek
$query6 = "SELECT femaleopening FROM breeder_flock WHERE flockcode = '$flock' and client = '$client'";
$result6 = mysql_query($query6,$conn1) or die(mysql_error());
$rows6 = mysql_fetch_assoc($result6);
$femaleopen = $rows6['femaleopening'];

$query7 = "SELECT fmort,fcull FROM breeder_consumption WHERE flock = '$flock' AND date2 = '$from_date' AND client = '$client' LIMIT 1";
$result7 = mysql_query($query7,$conn1) or die(mysql_error());
$rows7 = mysql_fetch_assoc($result7);
$sum1 = $rows7['fmort'] + $rows7['fcull'];
$ob = $femaleopen - $sum1;
$achicksperweek = ($hatch / $ob);
$temp = explode('.',$achicksperweek);
if($temp[1])
 $achicksperweek = $temp[0].".".substr($temp[1],0,1);
else
 $achicksperweek = $temp[0];
$chicksdiff = $achicksperweek - $chicksperweek;

//Actual Cummulative Chicks per bird
$acumchicks = ($cummhatch/$femaleopen);
$temp = explode('.',$acumchicks);
if($temp[1])
 $acumchicks = $temp[0].".".substr($temp[1],0,1);
else
 $acumchicks = $temp[0];
$cumchicksdiff = $acumchicks - $cumchicks;



	//Manual Coding ends here
$age++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($rcolor % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";

?>


	<tr>
		<td<?php echo $sItemRowClass; ?> align="center">
<?php echo ewrpt_ViewValue($age) ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($quantity)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($reject)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($eggsset)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right" style="padding-right:20px">
<?php echo ewrpt_ViewValue(changequantity($cummeggsset)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changequantity($hatch)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($achicksperweek)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($chicksperweek)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($chicksdiff)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right" style="padding-right:20px">
<?php echo ewrpt_ViewValue(changequantity($cummhatch)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($acumchicks)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($cumchicks)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> align="right">
<?php echo ewrpt_ViewValue(changeprice($cumchicksdiff)); ?>
</td>

	</tr>



<?php
$from_date = $to_date;
$to = strtotime($from_date) + (7 * 24 * 60 * 60);
$to_date = date("Y-m-d",$to);
$rcolor++;
}
?>





<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
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
	<!-- tr><td colspan="15"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
<!--	<tr class="ewRptGrandSummary"><td colspan="15">Grand Total (<?php //echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>--><?php } ?>
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
		$GLOBALS['x_id'] = $rs->fields('id');
		$GLOBALS['x_date1'] = $rs->fields('date1');
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
		$GLOBALS['x_updated'] = $rs->fields('updated');
		$GLOBALS['x_client'] = $rs->fields('client');
		$val[1] = $GLOBALS['x_id'];
		$val[2] = $GLOBALS['x_date1'];
		$val[3] = $GLOBALS['x_flock'];
		$val[4] = $GLOBALS['x_wo'];
		$val[5] = $GLOBALS['x_reportedby'];
		$val[6] = $GLOBALS['x_itemcode'];
		$val[7] = $GLOBALS['x_itemdesc'];
		$val[8] = $GLOBALS['x_units'];
		$val[9] = $GLOBALS['x_quantity'];
		$val[10] = $GLOBALS['x_lotno'];
		$val[11] = $GLOBALS['x_slno'];
		$val[12] = $GLOBALS['x_price'];
		$val[13] = $GLOBALS['x_flag'];
		$val[14] = $GLOBALS['x_updated'];
		$val[15] = $GLOBALS['x_client'];
	} else {
		$GLOBALS['x_id'] = "";
		$GLOBALS['x_date1'] = "";
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
		$GLOBALS['x_updated'] = "";
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
				$nDisplayGrps = 10; // Non-numeric, load default
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
			$nDisplayGrps = 10; // Load default
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
			$_SESSION["sort_flockwiseHHCCreport_id"] = "";
			$_SESSION["sort_flockwiseHHCCreport_date1"] = "";
			$_SESSION["sort_flockwiseHHCCreport_flock"] = "";
			$_SESSION["sort_flockwiseHHCCreport_wo"] = "";
			$_SESSION["sort_flockwiseHHCCreport_reportedby"] = "";
			$_SESSION["sort_flockwiseHHCCreport_itemcode"] = "";
			$_SESSION["sort_flockwiseHHCCreport_itemdesc"] = "";
			$_SESSION["sort_flockwiseHHCCreport_units"] = "";
			$_SESSION["sort_flockwiseHHCCreport_quantity"] = "";
			$_SESSION["sort_flockwiseHHCCreport_lotno"] = "";
			$_SESSION["sort_flockwiseHHCCreport_slno"] = "";
			$_SESSION["sort_flockwiseHHCCreport_price"] = "";
			$_SESSION["sort_flockwiseHHCCreport_flag"] = "";
			$_SESSION["sort_flockwiseHHCCreport_updated"] = "";
			$_SESSION["sort_flockwiseHHCCreport_client"] = "";
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
