<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php 
/*$sExport = @$_GET["export"]; 
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
<?php }*/
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
?>

<?php
session_start();
ob_start();
include "config.php";
include "reportheader.php";
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

            $agequery = "select max(age) as age from layerbreeder_standards";
			$resultage = mysql_query($agequery,$conn1) or die(mysql_error());
			$res = mysql_fetch_assoc($resultage);
			$maxagee = $res['age'];
 ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "dummy", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "dummy_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "dummy_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "dummy_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "dummy_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "dummy_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layerbreeder_consumption";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layerbreeder_consumption.id FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "layerbreeder_consumption.id = 1";
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
$af_id = NULL; // Popup filter for id
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
$x_id = NULL;

// Detail variables
$o_id = NULL; $t_id = NULL; $ft_id = 3; $rf_id = NULL; $rt_id = NULL;
?>
<?php

// Filter
$sFilter = "";

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
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php 

if($_GET['date'])
$comparedate = date("Y-m-d",strtotime($_GET['date']));
else
{
  include "config.php";
  if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
      $q = "select max(date2) as 'date2' from layerbreeder_consumption group by flock order by date2 ASC"; 
  else
      $q = "select max(date2) as 'date2' from layerbreeder_consumption where flock in ($_GET[flock]) group by flock order by date2 ASC"; 
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
         $comparedate = $qr['date2'];
      }
}
$dummydate = date("d.m.Y",strtotime($comparedate));

?>
<br />
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Daily Consumption & Production Report on <?php echo $dummydate; ?></font></strong></td>
</tr>
</table>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="lbdailyreport.php?export=html&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="lbdailyreport.php?export=excel&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="lbdailyreport.php?export=word&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Export to Word</a>
<?php } else { ?>
<center>
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
<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="lbdailyreport.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr>
<td>


</td>


<td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="lbdailyreport.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="lbdailyreport.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="lbdailyreport.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="lbdailyreport.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		<!-- <td align="right" valign="top" nowrap><span class="phpreportmaker">Groups Per Page&nbsp;
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
		</span></td> -->
<?php } ?>


<tr>
	<td >
<span class="phpreportmaker">
Date&nbsp;
<input type="text" class="datepicker" id="date1" name="date1" value="<?php if($_GET['date']) { echo $_GET['date']; } else { echo $dummydate; }  ?>" onchange="reload(this.value);" />
&nbsp;&nbsp;&nbsp;
</span><br />

	<b>F.Cons :</b> Feed Consumed&nbsp;&nbsp;&nbsp;<b>Std. :</b> Standard&nbsp;&nbsp;&nbsp;<b>HE :</b>Hatch Eggs&nbsp;&nbsp;&nbsp;<b>OB :</b>Opening Birds&nbsp;&nbsp;&nbsp;<b>F :</b> Female&nbsp;&nbsp;&nbsp;<b>M :</b> Male &nbsp;&nbsp;&nbsp;<b>CB. :</b> Closing Birds&nbsp;&nbsp;&nbsp;<b>Wt :</b> Weight&nbsp;&nbsp;&nbsp;<b>Prod% :</b> Production%&nbsp;&nbsp;&nbsp;
	</td>
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


//while (($rs && !$rs->EOF) || $bShowFirstHeader) {
	// Show header
	if ($bShowFirstHeader) {
?>
	<!--<thead >

	</thead>-->
	<tbody >
<?php
		$bShowFirstHeader = FALSE;
	}
	$nRecCount++;


		$sItemRowClass = " class=\"ewTableRow\"";
		$sItemRowClass1 = " class=\"ewTableAltRow\"";
?>
<thead>
	<th class="ewTableHeader">Details</th>
         <?php 
            $f = 0;
            include "config.php";
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
              $q = "select distinct(flock) from layerbreeder_consumption where date2 = '$comparedate' order by flock"; 
            else
              $q = "select distinct(flock) from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $flo[$f] = $qr['flock'];
			  $qbr = "select breed from layerbreeder_flock where flockcode = '$qr[flock]'"; 
  		$qrsbr = mysql_query($qbr,$conn1) or die(mysql_error());
		while($qrbr = mysql_fetch_assoc($qrsbr))
		{
		$flkbreed[$f] = $qrbr['breed'];
		}
			  
			  
         ?>
	     <th class="ewTableHeader"><?php echo $qr['flock']; ?></th>
         <?php $f = $f + 1; } ?>   
	<th class="ewTableHeader">Total</th>

</thead>


<tr>
	<td<?php echo $sItemRowClass1; ?>>Age</td>
         <?php 
            include "config.php";
			$f = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q = "select age from layerbreeder_consumption where date2 = '$comparedate' group by flock order by flock "; 
            else
               $q = "select age from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $age = $qr['age'];
              //$age1 = $age % 7; 
              //$age = round($age / 7);
              $nrSeconds = $age * 24 * 60 * 60;
              $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
              $nrWeeksPassed = floor($nrSeconds / 604800); 
              $nrYearsPassed = floor($nrSeconds / 31536000); 
			  $age1[$f++] = $nrWeeksPassed;
			  ?>
	     <td<?php echo $sItemRowClass1; ?>><?php echo $nrWeeksPassed; ?>.<?php echo $nrDaysPassed; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass1; ?>>&nbsp;</td>
</tr>

<tr>
	<td<?php echo $sItemRowClass; ?>>Feed Consumed(Kgs) &nbsp;&nbsp;</td>
         <?php 
            include "config.php";
            $feedtype = "'dummy'";
			$feedtype1 = "'dummy'";
			$mtot = 0;
			$ftot = 0;
			$dummf = 0;
			$fquantfc = 0;
			$mquantfc = 0;
            $q = "select * from ims_itemcodes where cat = 'Female Feed'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $feedtype = $feedtype . ",'" . $qr['code'] . "'";
            } 
            $q = "select * from ims_itemcodes where cat = 'Male Feed'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $feedtype1 = $feedtype1 . ",'" . $qr['code'] . "'";
            } 
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from layerbreeder_consumption where itemcode in ($feedtype) and date2 = '$comparedate' group by flock order by flock"; 
            else
               $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from layerbreeder_consumption where itemcode in ($feedtype) and date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		 $flockkk = $qr['flock'];
		 if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
                $q11 = "select mfeed from layerbreeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat LIKE '%Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
            else
               $q11 = "select mfeed from layerbreeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat LIKE '%Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
  		$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());
		while($qr11 = mysql_fetch_assoc($qrs11))
		{
		    $malef =  $qr11['mfeed'];
		}
		
		if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q11 = "select ffeed from layerbreeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
            else
               $q11 = "select ffeed from layerbreeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
  		$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());
		while($qr11 = mysql_fetch_assoc($qrs11))
		{
		    $femalef =  $qr11['ffeed'];
		}
		//Birds Calculation
		$qj = "select * from layerbreeder_flock where flockcode = '$flockkk'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $fopening = $qrj['femaleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $qj = "select distinct(date2),fmort,fcull,mmort,mcull from layerbreeder_consumption where flock = '$flockkk' and date2 < '$comparedate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $minus = $minus + $qrj['fmort'] + $qrj['fcull'];

            $ftransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$flockkk' and date < '$comparedate'"; 
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
			 
			 /* $femtransferout = 0;
             $qj = "select * from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$flockkk' and date = '$comparedate'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $femtransferout = $femtransferout +  $qrj['quantity'];
               }
             }
             else
             {
                $femtransferout = 0;
             }
			
			$femtransferin = 0;
            $qj = "select * from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$flockkk' and date = '$comparedate'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $femtransferin = $femtransferin + $qrj['quantity'];
               }
             }
             else
             {
                $femtransferin = 0;
             } */
			 
			$ttransfer = 0;
            $qj = "select * from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$flockkk' and date < '$comparedate'"; 
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
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
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
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
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
			 
			 
			 
             $remaining = 0;
			 //echo $flockkk."/".$fopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$fquantfc; echo"/B";
             //$remaining = $fopening - $minus - $ftransfer + $ttransfer + $fquantfc - $fquantso;
			 
			 $remaining = $fopening - $minus - $ftransfer + $ttransfer + $fquantfc ;
			 $ftot = $ftot + $remaining;
		//Birds Calculation Ends
		//LB Male Birds
		$qj = "select * from layerbreeder_flock where flockcode = '$flockkk'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $mopening = $qrj['maleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $qj = "select distinct(date2),mmort,mcull from layerbreeder_consumption where flock = '$flockkk' and date2 < '$comparedate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $minus = $minus + $qrj['mmort'] + $qrj['mcull'];

             $ftransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$flockkk' and date < '$comparedate'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $ftransfer = $ftransfer + $qrj['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
             $ttransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$flockkk' and date < '$comparedate'"; 
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
			 $mquantfc = 0;
$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantfc = $mquantfc + $qr['quant'];
               }
             }
             else
             {
                $mquantfc = 0;
             } 
			 
			  $mquantso = 0;
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
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
			 
			 /* $maletransferout = 0;
             $qj = "select * from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$flockkk' and date = '$comparedate'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
			   
                $maletransferout = $maletransferout +  $qrj['quantity'];
               }
             }
             else
             {
                $maletransferout = 0;
             }
			
			$maletransferin = 0;
            $qj = "select * from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$flockkk' and date = '$comparedate'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrsj))
             {
		   while($qrj = mysql_fetch_assoc($qrsj))
    		   {
                $maletransferin = $maletransferin + $qrj['quantity'];
               }
             }
             else
             {
                $maletransferin = 0;
             } */
			 
             $mremaining = 0;
			 
			 //echo $flockkk."/".$mopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$mquantfc; echo"/B";
             $mremaining = $mopening - $minus - $ftransfer + $ttransfer + $mquantfc ;
			 $mtot = $mtot + $mremaining;
			 
		//LB Male Birds Ends
		//echo "</br>".$finalfeed."/";
		//echo round($femalef,0)."/";
         ?>
	     <td<?php echo $sItemRowClass; ?>>
		 <!-- <?php //echo $qr['quantity'] . " (Female) <br/> " . $qr['quantity1'] . " (Male) "; 
		 //$finalfeed = $finalfeed + $qr['quantity'] + $qr['quantity1']; ?> -->
		 <?php echo round($femalef,0)."/".round($malef,0); 
		 $actualff[$dummf] = round((($femalef * 1000)/$remaining),0);
		 $actualmf[$dummf] = round((($malef * 1000)/$mremaining),0);
		
		 $dummf = $dummf + 1;
		?> 
		 </td>
         <?php 
		//echo $flockkk."/".$femalef."/".$remaining;
		 $finalfeed = $finalfeed + round($femalef,0); 
		  $finalfeed1 = $finalfeed1 + round($malef,0); 
		  //echo ($finalfeed1);
		   } ?>   
	<td<?php echo $sItemRowClass; ?>><?php /*echo $finalfeed = $finalfeed / 2; */ echo round(($finalfeed),0) ."/".round(($finalfeed1),0); ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Feed Consumed/Bird">F.Cons/Bird(gms.)</td>
         <?php 
            include "config.php";
			
            for($f = 0;$f<count($age1);$f++)
            {
			
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $actualff[$f]."/".$actualmf[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php /*echo $finalfeed = $finalfeed / 2; */ echo round((($finalfeed * 1000)/($ftot)),0)."/".round((($finalfeed1 * 1000)/($mtot)),0); ?></td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Standard Feed Consumed">Std. F.Cons(gms.)</td>
         <?php 
            include "config.php";
			
            for($f = 0;$f<count($age1);$f++)
            {
			$fstd = "0";
			$mstd = "0";
			if($flkbreed[$f] != "")
			{
			$q11 = "select * from layerbreeder_standards where age = '$age1[$f]' and breed = '$flkbreed[$f]'";
			}
			else
			{
			$q11 = "select * from layerbreeder_standards where age = '$age1[$f]'";
			}
			$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());
			if($qr11 = mysql_fetch_assoc($qrs11))
			{
				$fstd = $qr11['ffeed'];
				$mstd = $qr11['mfeed'];
			}
			if($mstd == "")
			$mstd = 0;
			if($fstd == "")
			$fstd = 0;
			$stdff[$f] = $fstd;
			$stdmf[$f] = $mstd;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $fstd."/".$mstd; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?>  title="Difference">Difference</td>
         <?php 
            include "config.php";
			
            for($f = 0;$f<count($age1);$f++)
            {
			$fediff = round(($actualff[$f] - $stdff[$f]),0);
			
         ?>
	     <td<?php echo $sItemRowClass2; if($fediff <= 0) {?> style="color:#66CC66" <?php } else { ?> style="color:#FF0000" <?php } ?>><?php echo round(($actualff[$f] - $stdff[$f]),0)."/".round(($actualmf[$f] - $stdmf[$f]),0); ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<?php
            $eggtype = "'dummy'";
            $q = "select * from ims_itemcodes where cat = 'Layer Breeder Eggs' or cat = 'Layer Hatch Eggs' "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $eggtype = $eggtype . ",'" . $qr['code'] . "'";
            } 
            $st = 0;
            $sItemRowClass2 = $sItemRowClass1;
            $q = "select distinct(itemcode) from layerbreeder_production where itemcode in ($eggtype) and date1 = '$comparedate'  order by itemcode"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $q12 = "select * from ims_itemcodes where code = '$qr[itemcode]'"; 
     		  $qrs12 = mysql_query($q12,$conn1) or die(mysql_error());
		  while($qr12 = mysql_fetch_assoc($qrs12))
		  {
                $idesc = $qr12['description'];
              }
?>
<tr>
	<td<?php echo $sItemRowClass2; ?>><?php echo $qr['itemcode']; ?><br />(<?php echo $idesc; ?>)</td>
       <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
            include "config.php";
            $q1 = "select sum(quantity) as 'quantity' from layerbreeder_production where itemcode = '$qr[itemcode]' and flock = '$flo[$l]' and date1 = '$comparedate' group by flock order by flock"; 
  		$qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1))
            {
              
		  while($qr1 = mysql_fetch_assoc($qrs1))
		  {
         ?>
	          <td<?php echo $sItemRowClass2; ?>><?php echo $qr1['quantity']; if($idesc == "HATCH EGGS") $heggs[$l] = $qr1['quantity']; $finaleggs = $finaleggs + $qr1['quantity']; ?></td>
         <?php } } else { ?>   
	          <td<?php echo $sItemRowClass2; ?>><?php echo "0"; $finaleggs = $finaleggs; ?></td>
         <?php } ?>
       <?php } ?>
	<td<?php echo $sItemRowClass2; ?>><?php echo $finaleggs; $finaleggs = 0; ?></td>
</tr>
<?php
  $st = $st + 1;
  if($st % 2) { $sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; }
}  

?>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass1; } else { $sItemRowClass2 = $sItemRowClass; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Total Eggs</td>
  <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
           //$l = 0;
            include "config.php";
            $q = "select sum(quantity) as 'quantity' from layerbreeder_production where itemcode in ($eggtype) and date1 = '$comparedate' and flock = '$flo[$l]' group by flock order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs))
            {
  		 while($qr = mysql_fetch_assoc($qrs))
		 {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $tegg[$l] = $qr['quantity']; $fegg = $fegg + $qr['quantity']; ?></td>
         <?php } } else { ?>   
	          <td<?php echo $sItemRowClass2; ?>><?php echo "0";$fegg = $fegg ; ?></td>
 <?php } } ?>
	<td<?php echo $sItemRowClass2; ?>><?php echo $fegg; ?></td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Opening Female Birds" >Female OB</td>
         <?php 
		 $finalrem = 0;
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
			 $fopening = 0; $ftransfer = 0; $ttransfer = 0; $fquantob = 0;$fquantobso = 0;
             $q = "select * from layerbreeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $fopening = $qr['femaleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),fmort,fcull,mmort,mcull from layerbreeder_consumption where flock = '$flo[$f]' and date2 < '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $minus = $minus + $qr['fmort'] + $qr['fcull'];


             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $ftransfer + $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $ttransfer + $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
			 
			 		 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fquantobso = $fquantobso + $qr['quant'];
               }
             }
             else
             {
                $fquantobso = 0;
             } 
			 
			 
			$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $fquantob = $fquantob + $qr['quant'];
               }
             }
             else
             {
                $fquantob = 0;
             } 
			 
			// $fopening."/".$fquantob."/".$minus."/".$ftransfer."/".$ttransfer;
			// $remaining = $fopening - $minus - $ftransfer + $ttransfer + $fquantob - $fquantobso;
			  $remaining = $fopening + $fquantob - $minus - $ftransfer + $ttransfer ;
		  //echo $flo[$f]."/".$fopening."/".$minus."/".$ftransfer."/".$ttransfer;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $remaining; $bopen[$f] = $remaining; $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Opening Male Birds" >Male OB</td>
         <?php 
            include "config.php";
			$finalrem = 0;
            for($f = 0;$f<count($flo);$f++)
            {
			 $mopening = 0; $ftransfer = 0; $ttransfer = 0; $mquantob = 0;$mquantobso = 0;
             $q = "select * from layerbreeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $mopening = $qr['maleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),mmort,mcull from layerbreeder_consumption where flock = '$flo[$f]' and date2 < '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $minus = $minus + $qr['mmort'] + $qr['mcull'];


             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $ftransfer +  $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$flo[$f]' and date < '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $ttransfer + $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

			 
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantob = $mquantob + $qr['quant'];
               }
             }
             else
             {
                $mquantob = 0;
             } 
			 
			  $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $mquantobso = $mquantobso + $qr['quant'];
               }
             }
             else
             {
                $mquantobso = 0;
             } 

             //$remaining = $mopening - $minus - $ftransfer + $ttransfer + $mquantob - $mquantobso;
			 $remaining = $mopening + $mquantob - $minus - $ftransfer + $ttransfer;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $remaining; $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Female Mortality" >F.Mortality</td>
         <?php 
            include "config.php";
			$finalmort = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
                $q = "select fmort from layerbreeder_consumption where date2 = '$comparedate' group by flock order by flock"; 
            else
                $q = "select fmort from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['fmort']; $finalmort = $finalmort + $qr['fmort']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalmort; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Male Mortality" >M.Mortality</td>
         <?php 
            include "config.php";
			$finalmort = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
                $q = "select mmort from layerbreeder_consumption where date2 = '$comparedate' group by flock order by flock"; 
            else
                $q = "select mmort from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 
 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['mmort']; $finalmort = $finalmort + $qr['mmort']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalmort; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Female Culls" >F.Culls</td>
         <?php 
            include "config.php";
			$finalcull = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
                $q = "select fcull from layerbreeder_consumption where date2 = '$comparedate' group by flock order by flock"; 
            else
                $q = "select fcull from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['fcull']; $finalcull = $finalcull + $qr['fcull']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcull; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Male Culls" >M.Culls</td>
         <?php 
            include "config.php";
			$finalcull = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
                $q = "select mcull from layerbreeder_consumption where date2 = '$comparedate' group by flock order by flock"; 
            else
                $q = "select mcull from layerbreeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['mcull']; $finalcull = $finalcull + $qr['mcull']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcull; ?></td>
</tr>



<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr style="display:none">

	<td<?php echo $sItemRowClass2; ?>>Transfered Out Female Birds</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ftransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr style="display:none">

	<td<?php echo $sItemRowClass2; ?>>Transfered In Female Birds</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ttransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr style="display:none">

	<td<?php echo $sItemRowClass2; ?>>Transfered Out Male Birds </td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ftransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr style="display:none">

	<td<?php echo $sItemRowClass2; ?>>Transfered In Male Birds</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$flo[$f]' and date = '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $ttransfer;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Closing Female Birds" >Female CB</td>
         <?php 
            include "config.php";
            $finalrem = 0;
            for($f = 0;$f<count($flo);$f++)
            {
			$fopening = 0; $ftransfer = 0; $ttransfer = 0; $cquantfb = 0;
             $q = "select * from layerbreeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
			

             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from layerbreeder_consumption where flock = '$flo[$f]' and date2 <= '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and fromwarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $ftransfer +  $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select * from ims_stocktransfer where cat = 'LB Female Birds' and towarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $ttransfer + $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
			
			 
			$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $cquantfb = $cquantfb + $qr['quant'];
               }
             }
             else
             {
                $cquantfb = 0;
             } 
			   /*if($flo[$f] == "T-09-18")
			 {
			 echo "opening".$fopening."mort,cull".$minus."tr out".$ftransfer."Tr in".$ttransfer."sale".$cquantfb;
			 }*/
			 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Female Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $cquantfbso = $cquantfbso + $qr['quant'];
               }
             }
             else
             {
                $cquantfbso = 0;
             } 
			  /* if($flo[$f] == "T-09-18")
			 {
			 echo "opening".$fopening."mort,cull".$minus."tr out".$ftransfer."Tr in".$ttransfer."sale".$cquantfb."sale2".$cquantfbso;
			 }*/
             //$remaining = $fopening - $minus - $ftransfer + $ttransfer + $cquantfb - $cquantfbso;
			 $remaining = $fopening + $cquantfb - $minus - $ftransfer + $ttransfer;
			 //echo $flo[$f]."/".$fopening."/".$minus."/".$ftransfer."/".$ttransfer;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $remaining; $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Closing Male Birds" >Male CB</td>
         <?php 
            include "config.php";
           $finalrem = 0;
            for($f = 0;$f<count($flo);$f++)
            {
			 $mopening = 0; $ftransfer = 0; $ttransfer = 0; $cquantmb = 0;
             $q = "select * from layerbreeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $mopening = $qr['maleopening'];
             }

             $minus = 0; 
             $q = "select distinct(date2),mmort,mcull from layerbreeder_consumption where flock = '$flo[$f]' and date2 <= '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['mmort'] + $qr['mcull'];
             }


             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and fromwarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $ftransfer + $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select * from ims_stocktransfer where cat = 'LB Male Birds' and towarehouse = '$flo[$f]' and date <= '$comparedate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $ttransfer + $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 
$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $cquantmb = $cquantmb + $qr['quant'];
               }
             }
             else
             {
                $cquantmb = 0;
             } 
			 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'LB Male Birds')";  
             $r = mysql_query($q,$conn1) or die(mysql_error());
			 if(mysql_num_rows($r))
             {
		   while($qr = mysql_fetch_assoc($r))
    		   {
			 $cquantmbso = $cquantmbso + $qr['quant'];
               }
             }
             else
             {
                $cquantmbso = 0;
             } 
			 
             //$remaining = $mopening - $minus - $ftransfer + $ttransfer + $cquantmb - $cquantmbso;
			 $remaining = $mopening + $cquantmb - $minus - $ftransfer + $ttransfer;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $remaining; $finalrem = $finalrem + $remaining; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalrem; ?></td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Female Body Weight" >F.Body.Wt</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select fweight from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fweight = $qr['fweight'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $fweight; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Standard Female Body Weight">Std.F.Body.Wt</td>
         <?php
			
            include "config.php";
            for($f = 0;$f<count($age1);$f++)
            {
			$sfbw = "0";
			if($flkbreed[$f] != "")
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards)";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$sfbw = $qr['fweight'];
			}
			if($sfbw == "")
			$sfbw = 0;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $sfbw; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td title = "Male Body Weight" <?php echo $sItemRowClass2; ?>>M.Body.Wt</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select mweight from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $mweight = $qr['mweight'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $mweight; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<tr>
	<td<?php echo $sItemRowClass2; ?> title="Standard Male Body Weight">Std.M.Body.Wt</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($age1);$f++)
            {
			$smbw = "0";
			if($flkbreed[$f] != "")
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards)";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$smbw = $qr['mweight'];
			}
			if($smbw == "")
			$smbw = 0;
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $smbw; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr style="display:none">
	<td<?php echo $sItemRowClass2; ?>>Water</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select water from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $water = $qr['water'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $water; $twater = $twater + $water; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $twater; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Egg Weight</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select eggwt from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $eggwt = $qr['eggwt'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $eggwt; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr style="display:none">
	<td<?php echo $sItemRowClass2; ?>>Average Weight</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select avgwt from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $avgwt = $qr['avgwt'];
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $avgwt; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr style="display:none">
	<td<?php echo $sItemRowClass2; ?>>Temperature</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select tempmin,tempmax from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $temperature = $qr['tempmin']."(min)<br />".$qr['tempmax']."(max)";
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $temperature; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Production%">Prod%</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo round(($tegg[$f]/$bopen[$f]) * 100,2); $actualmain[$f] = round(($tegg[$f]/$bopen[$f]) * 100,2); ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Standard Production Percentage">Std. Prod%</td>
         <?php 
            include "config.php";
			
			
            for($f = 0;$f<count($age1);$f++)
            {
			$spp = "0";
			if($flkbreed[$f] != "")
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards)";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'";
			}
				
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			$qr = mysql_fetch_assoc($qrs);
			if($qr['productionper'])
			$spp = $qr['productionper'];
			else
			$spp = "0";
        	
		?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $sppmain[$f] = $spp; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<tr>
	<td<?php echo $sItemRowClass2; ?> >Difference</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($age1);$f++)
            {
			$diff = round(($actualmain[$f] - $sppmain[$f]),2);
         ?>
	     <td <?php echo $sItemRowClass2; if($diff > 0) {?> style="color:#66CC66" <?php } else { ?> style="color:#FF0000" <?php } ?>><?php echo round(($actualmain[$f] - $sppmain[$f]),2); ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<tr>
	<td<?php echo $sItemRowClass2; ?> title = "Hatch Eggs %" >HE%</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo round(($heggs[$f]/$tegg[$f]) * 100,2); $acthemain[$f] = round(($heggs[$f]/$tegg[$f]) * 100,2); ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> title="Standard Hatch Eggs Percentage">Std.HE%</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($age1);$f++)
            {
			 $shep = "0";
			if($flkbreed[$f] != "")
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM layerbreeder_standards WHERE age in (select max(age) from layerbreeder_standards)";
			 else	
			$q = "select * from layerbreeder_standards where Age = '$age1[$f]'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			$qr = mysql_fetch_assoc($qrs);
			if($qr['heggper'])
			$shep = $qr['heggper'];
			else
			$shep = "0";
			
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $shep; $sheper[$f] = $shep; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>
<tr>
	<td<?php echo $sItemRowClass2; ?> >Difference</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($age1);$f++)
            {
			$difff = round(($acthemain[$f] - $sheper[$f]),2);
         ?>
	     <td<?php echo $sItemRowClass2; if($difff > 0) {?> style="color:#66CC66" <?php } else { ?> style="color:#FF0000" <?php } ?>><?php echo $difff;  ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<!--
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Consumption Cost</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select price from layerbreeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $camount[$f] = round($qr['price'],2);
             }
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $camount[$f]; $finalcamount = $finalcamount + $camount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcamount; ?></td>
</tr>



<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Production Cost</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select price from layerbreeder_production where flock = '$flo[$f]' and date1 = '$comparedate' limit 1"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $pamount[$f] = round($qr['price'],2);

         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $pamount[$f]; $finalpamount = $finalpamount + $pamount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalpamount; ?></td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Price Varience</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $pamount[$f] - $camount[$f]; ?></td>
         <?php }  ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalpamount - $finalcamount; ?></td>
</tr>
-->

<?php  
		// Accumulate page summary
		AccumulateSummary();

		// Get next record
		GetRow(2);
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
	<!-- tr><td colspan="1"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<!-- <tr class="ewRptGrandSummary"><td colspan="1">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr> -->
<?php } ?>
	</tfoot>
</table>


</div>

<?php if ($nTotalGrps > 0) { ?>
<div class="ewGridLowerPanel">
<form action="lbdailyreport.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table>
  <tr height="15px"><td></td></tr>
  <tr>
    <td>Total Production</td><td width="15px"></td><td><?php echo $fegg; ?></td>
    <td width="30px"></td>
    <td>Total Feed</td><td width="15px"></td><td><?php echo $lastfinalfeed =  round((($finalfeed + $finalfeed1)),2); ?></td>
  </tr>
  <tr>
    <td>Eggs per 1 Ton Feed</td><td width="15px"></td><td><?php echo round($fegg / ($lastfinalfeed/1000)); ?></td>
    <td width="30px"></td>
    <td>Feed per 1 Egg(grams)</td><td width="15px"></td><td><?php echo round((($lastfinalfeed * 1000) / $fegg) /1000,3) * 1000; ?></td>
  </tr>
  
  
  <?php 
  $p = 0;
include "config.php";
$qury1aq = "select distinct(itemcode) from layerbreeder_consumption where date2 = '$comparedate' and flock in (select distinct(flock) from layerbreeder_production where date1 = '$comparedate')";
$reslt1aq = mysql_query($qury1aq,$conn1);
while($qr1aq = mysql_fetch_assoc($reslt1aq))
{
$ic = $qr1aq['itemcode'];
$qry1 = "select sum(production) as production,sum(materialcost) as mc from feed_productionunit where mash = '$ic'";
$res1 = mysql_query($qry1,$conn1);
while($qr12 = mysql_fetch_assoc($res1))
{

$p = $p + $qr12['production'];
$mc = $mc + $qr12['mc'];

}

}
$c = ($mc)/($p);
$cr = round((($lastfinalfeed * 1000) / $fegg) /1000,3) * 1000;
$cost = $c * (($cr)/1000);
?>
  
  
  <tr>
    <td>Feed cost per 1 Egg</td><td width="15px"></td><td><?php echo round(($cost),2); ?></td>
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
		$val[1] = $GLOBALS['x_id'];
	} else {
		$GLOBALS['x_id'] = "";
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
			$_SESSION["sort_dummy_id"] = "";
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
function reload(a)
{
document.location="lbdailyreport.php?flock=<?php echo $_GET['flock']; ?>&date=" + a; 
}
</script>
