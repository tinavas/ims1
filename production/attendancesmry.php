<?php 
$ttdp = 0;
$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December");
$empname = $_GET['empname'];
if($empname == "All")
{
$compareempname = '<>';
}
else
{
$compareempname = '=';
}

$sector = $_GET['sector'];
if($sector == "All")
{
$comparesector = '<>';
}
else
{
$comparesector = '=';
}

//$genlink = "&m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];

//define('GLF',"m=".$_GET['m']."&n=".$_GET['n']."&empname=".$_GET['empname']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector']);

define('GLF',"m=".$_GET['m']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector']);


//$name = $_GET['empname'];
$sector = $_GET['sector'];
$month = $_GET['month'];
$year = $_GET['year'];
$m = $_GET['m'];
$para = split(",",$m);

//$n = $_GET['n'];
//$para1 = split(",",$n);

$dpara = array('attendance');
$dpara1 = array('en','d','p');

$pa = array('0');
$pa1 = array('0','0','0');
for($i=1;$i < sizeof($para);$i++)
{
	for( $j=0; $j < sizeof($dpara); $j++ )
	{
		if($dpara[$j] == $para[$i])
		{
		$pa[$j] = '1';
		}		
	}
}


//for($i=1;$i < sizeof($para1);$i++)
//{
//	for( $j=0; $j < sizeof($dpara1); $j++ )
//	{
//		if($dpara1[$j] == $para1[$i])
//		{
//		$pa1[$j] = '1';
//		}		
//	}
//}

?>


<?php 
$sExport = @$_GET["export"]; 
if (@$sExport == "") { ?>
 <?php /*?>
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
    </style><?php */?>
<?php } ?>

<?php 
function leapYear($year){ 
if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) return TRUE; 
return FALSE; 
} 
function daysInMonth($month = 0, $year = '')
{ 
$days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
$d = array("Jan" => 31, "Feb" => 28, "Mar" => 31, "Apr" => 30, "May" => 31, "Jun" => 30, "Jul" => 31, "Aug" => 31, "Sept" => 30, "Oct" => 31, "Nov" => 30, "Dec" => 31); 
if(!is_numeric($year) || strlen($year) != 4) $year = date('Y'); 
if($month == 2 || $month == 'Feb'){ 
if(leapYear($year)) return 29; 
} 
if(is_numeric($month)){ 
if($month < 1 || $month > 12) return 0; 
else return $days_in_month[$month - 1]; 
} 
else{ 
if(in_array($month, array_keys($d))) return $d[$month]; 
else return 0; 
} 
} 
?> 


<?php
session_start();
ob_start();
include "reportheader.php";
$month = $_GET['month'];
if($month == "All")
{
$comparemonth = '<>';
}
else
{
$comparemonth = '=';
}

$year = $_GET['year'];
if($year == "All")
{
$compareyear = '<>';
}
else
{
$compareyear = '=';
}
$max  =  daysInMonth($month,$year);  

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
define("EW_REPORT_TABLE_VAR", "attendance", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "attendance_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "attendance_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "attendance_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "attendance_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "attendance_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "hr_employee";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT hr_employee.sector, hr_employee.name, hr_employee.designation As DESIG FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "hr_employee.sector $comparesector '$sector' ";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
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
$af_name = NULL; // Popup filter for name
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
$nDisplayGrps = "All"; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Non-Text Extended Filters
// Text Extended Filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
$EW_REPORT_FIELD_NAME_SQL_SELECT = "SELECT DISTINCT hr_employee.name FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_NAME_SQL_ORDERBY = "hr_employee.name";
?>
<?php

// Field variables
$x_name = NULL;
$x_DESIG = NULL;
// Detail variables
$o_name = NULL; $t_name = NULL; $ft_name = 200; $rf_name = NULL; $rt_name = NULL;
?>
<?php

// Filter
$sFilter = "";
$af_DESIG = NULL; // Popup filter for DESIG

$o_DESIG = NULL; $t_DESIG = NULL; $ft_DESIG = 201; $rf_DESIG = NULL; $rt_DESIG = NULL;

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 2;
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
$col = array(FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_name = "";
$seld_name = "";
$val_name = "";

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
<?php $jsdata = ewrpt_GetJsData($val_name, $sel_name, $ft_name) ?>
ewrpt_CreatePopup("attendance_name", [<?php echo $jsdata ?>]);
</script>
<div id="attendance_name_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table align="center"  id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Attendance for <?php echo $montharr[$month-1]; ?>, <?php echo $year; ?></font></strong></td>
</tr>
</table>
<br/>
<?php if (@$sExport == "") { 
$htmllink = "attendancesmry.php?export=html&m=".$_GET['m']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$excellink = "attendancesmry.php?export=excel&m=".$_GET['m']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$wordlink = "attendancesmry.php?export=word&m=".$_GET['m']."&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
?>
<br />
&nbsp;&nbsp;<a href="<?php echo $htmllink; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="<?php echo $excellink; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="<?php echo $wordlink; ?>">Export to Word</a>
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
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker" style="width:auto">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary" style="width:auto" align="center">
<?php if (defined("EW_REPORT_SHOW_CURRENT_FILTER")) { ?>
<div id="ewrptFilterList">
<?php ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0" width="950" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="attendancesmry.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		
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
	GetRow(1);
	$nGrpCount = 1;
}

while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php 

//if($pa1[0] == '1')
 { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Employee Name
		</td>

<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Employee Name</td>
			<td style="width: 20px;" align="right"><?php /*?><a href="#" onClick="ewrpt_ShowPopup(this.name, 'attendance_name', false, '<?php echo $rf_name; ?>', '<?php echo $rt_name; ?>');return false;" name="x_name<?php echo $cnt[0][0]; ?>" id="x_name<?php echo $cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt=""></a><?php */?></td>
			
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php //if($pa1[1] == '1')
 { ?>

		<td valign="bottom" class="ewTableHeader">
		Designation
		</td>
<?php } ?>
<?php 
for ( $b = 1;$b <= $max;$b++ )
{
?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="
		<?php 
			include "config.php";
			if($b < 10)
			$b = "0".$b;
			$hdate = ($_GET['year']."-".$_GET['month']."-".$b);
			$q = "select date,reason from hr_holidays where date = '$hdate'";
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			echo $qr['reason'];
		?>
		">
		<?php echo $b; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" title="<?php 
			include "config.php";
			
			if($b < 10)
			$b = "0".$b;
			$hdate = ($_GET['year']."-".$_GET['month']."-".$b);
			$q = "select date,reason from hr_holidays where date = '$hdate'";
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if(mysql_num_rows($qrs) > 0)
			if($qr = mysql_fetch_assoc($qrs))
			echo $qr['reason'];
		?>">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td><?php echo $b; ?></td>
			</tr></table>
		</td>
<?php } ?>

<?php } ?>
		<td valign="bottom" class="ewTableHeader">
		TDP
		</td>
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
<?php	//if($pa1[0] == '1')
 { ?>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_name) ?>
</td>
<?php } ?>
<?php //if($pa1[1] == '1')
 { ?>

<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue(str_replace(chr(10), "<br>", $x_DESIG)); ?>
</td>
<?php } ?>
<?php 
$w = 0;
for ( $a = 1;$a <= $max;$a++ )
{
?>


		<td<?php echo $sItemRowClass; ?>>
<?php
include "config.php";
$ispresent = "0";
$isexist = "0";
$isreleaved = "0";
$day = $a;
if($day < 10)
$day = "0".$day;
$date = $year."-".$month."-".$day;

$wky = getdate(strtotime($date));

  $query2 = "SELECT * FROM hr_employee where name = '$x_name' ORDER BY name DESC ";
  $result2 = mysql_query($query2,$conn1); 
  while($row2 = mysql_fetch_assoc($result2)) 
  { 
    $isreleaved = $row2['releaved'];
  }
  if($isreleaved == "1")
  {
  	$query99 = "SELECT * FROM releave where name = '$x_name' ORDER BY name DESC ";
	$result99 = mysql_query($query99,$conn1);
	while($r99 = mysql_fetch_assoc($result99))
	{
	$rldate = $r99['rdate'];
	}
  }

$query3 = "SELECT * FROM hr_attendance where date = '$date' and name = '$x_name' ORDER BY date DESC ";
$result3 = mysql_query($query3,$conn1); 

$isexist = mysql_num_rows($result3);
#echo $date;
#echo $x_name;
#if ($isexist > 0)
{
  $query4 = "SELECT * FROM hr_attendance where name = '$x_name' and date = '$date' ORDER BY date DESC ";
  $result4 = mysql_query($query4,$conn1); 
  $ispresent = mysql_num_rows($result4);
  while($row4 = mysql_fetch_assoc($result4))
  {
  $daytype = $row4['daytype'];
  }
  if($daytype == "Full")
  {
  $dt = "F";
  
  }
  else
  {
  $dt = "H";
  
  }
  
  $kk = 0;
  $flag = 0;
  
  if($wky[wday] == 0)
  {
  echo "S";
  $flag = 1;
  }
  else if($wky[wday] > 0)
  {
  $query100 = "SELECT * FROM hr_holidays ORDER BY date DESC";
  $result100 = mysql_query($query100,$conn1); 
  $hd = mysql_num_rows($result100);
  while($row100 = mysql_fetch_assoc($result100))
  {
		$hdate = $row100['date'];
		$hdate1 = split("-",$hdate);
		if( ($hdate1[0] == $year) &&  ($hdate1[1] == $month) && ($hdate1[2] == $day) )
		{
		echo "H"; 
		$flag = 1;
		}
  }
 }
  
  if( $flag == 0 )
  {
  if ($ispresent <> "0") 
  {
    echo "P(".$dt.")"; 
	if($dt == "F")
	$w++;
	else
	$w = $w + 0.5;
  }
  else if($isreleaved == "1") 
  {
  	if($date >= $rldate)
    echo "R";
	else
	echo "L";
  } 
  else 
  { 
    echo "L"; 
  }
  }
   
}

/*if ($isexist <= 0)
{
  $query4 = "SELECT * FROM hr_attendance where name = '$x_name' and date = '$date' ORDER BY date DESC ";
  $result4 = mysql_query($query4,$conn1); 
   $ispresent = mysql_num_rows($result4);
   while($row4 = mysql_fetch_assoc($result4))
  {
  $daytype = $row4['daytype'];
  }
  if($daytype == "Full")
  $dt = F;
  else
  $dt = H;
  if($wky[wday] == 0)
    echo "S";
  else if ($ispresent <> "0") { echo "P(".$dt.")"; $w++;} else if($isreleaved == "1") { echo "R"; } else { echo "A"; }
}
else
{
   echo ewrpt_ViewValue();
}
*/
 ?>

</td>

<?php } ?>

<td<?php echo $sItemRowClass; ?>>
<?php echo $w; $ttdp+= $w;?>
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
<?php	//if($pa1[0] == '1')
 { ?>
<td<?php echo $sItemRowClass; ?>>&nbsp;

</td>
<?php } ?>
<?php	//if($pa1[1] == '1')
 { ?>
<td<?php echo $sItemRowClass; ?>>&nbsp;

</td>
<?php } ?>
<td align="right" colspan="<?php echo $max; ?>" <?php echo $sItemRowClass; ?>>
Total
</td>

<td<?php echo $sItemRowClass; ?>>
<?php echo $ttdp; ?>
</td>
</tr>
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
	<!-- tr><td colspan="1"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="attendancesmry.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		
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
		$GLOBALS['x_name'] = $rs->fields('name');
		$val[1] = $GLOBALS['x_name'];
		$GLOBALS['x_DESIG'] = $rs->fields('DESIG');
		$val[2] = $GLOBALS['x_DESIG'];
	} else {
		$GLOBALS['x_name'] = "";
		$GLOBALS['x_DESIG'] = "";
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
	// Build distinct values for name

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_NAME_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_NAME_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_name = $rswrk->fields[0];
		if (is_null($x_name)) {
			$bNullValue = TRUE;
		} elseif ($x_name == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_name = $x_name;
			ewrpt_SetupDistinctValues($GLOBALS["val_name"], $x_name, $t_name, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_name"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_name"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('name');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Name selected values

	if (is_array(@$_SESSION["sel_attendance_name"])) {
		LoadSelectionFromSession('name');
	} elseif (@$_SESSION["sel_attendance_name"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_name"] = "";
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
				$nDisplayGrps = 200; // Non-numeric, load default
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
			$nDisplayGrps = "All"; // Load default
		}
	}
}
?>
<?php

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_attendance_$parm"] = "";
	$_SESSION["rf_attendance_$parm"] = "";
	$_SESSION["rt_attendance_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_attendance_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_attendance_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_attendance_$parm"];
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

	// Field name
	// Setup your default values for the popup filter below, e.g.
	// $seld_name = array("val1", "val2");

	$GLOBALS["seld_name"] = "";
	$GLOBALS["sel_name"] =  $GLOBALS["seld_name"];
}

// Check if filter applied
function CheckFilter() {

	// Check name popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_name"], $GLOBALS["sel_name"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field name
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_name"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_name"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Name<br />";
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
	if (is_array($GLOBALS["sel_name"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_name"], "hr_employee.name", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_name"]);
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
			$_SESSION["sort_PAYSLIP3_DESIG"] = "";
			$_SESSION["sort_attendance_name"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "hr_employee.name ASC";
		$_SESSION["sort_attendance_name"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}

?>
