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
include "../getemployee.php";
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

            $agequery = "select max(age) as age from breeder_standards";
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
$EW_REPORT_TABLE_SQL_FROM = "breeder_consumption";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT min(breeder_consumption.id) FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
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
  $fdate=$comparedate = date("Y-m-d",strtotime($_GET['date']));
else
  $fdate= $comparedate = date("Y-m-d");
      

$dummydate = date("d.m.Y",strtotime($comparedate));

?>
<br />
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Daysheet Report on <?php echo $dummydate; ?></font></strong></td>
</tr>
</table>
<br />
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="daysheet.php?export=html&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="daysheet.php?export=excel&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="daysheet.php?export=word&date=<?php echo $_GET['date']; ?>&flock=<?php echo $_GET['flock']; ?>">Export to Word</a>
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
<form action="daysheet.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr>
<td>

<script type="text/javascript">
function reload(a)
{
document.location="daysheet.php?flock=<?php echo $_GET['flock']; ?>&date=" + a; 
}
</script>

<span class="phpreportmaker">
Date&nbsp;
<input type="text" class="datepicker" id="date1" name="date1" value="<?php if($_GET['date']) { echo $_GET['date']; } else { echo $dummydate; }  ?>" onchange="reload(this.value);" />
&nbsp;&nbsp;&nbsp;
</span>
</td>


<td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="daysheet.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="daysheet.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="daysheet.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="daysheet.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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

<?php if($_SESSION['db']!='suriya') { ?>
<tr>
	<td >
	<b>F.Cons :</b> Feed Consumed&nbsp;&nbsp;&nbsp;<b>Std. :</b> Standard&nbsp;&nbsp;&nbsp;<b>HE :</b>Hatch Eggs&nbsp;&nbsp;&nbsp;<b>OB :</b>Opening Birds&nbsp;&nbsp;&nbsp;<b>F :</b> Female&nbsp;&nbsp;&nbsp;<b>M :</b> Male &nbsp;&nbsp;&nbsp;<b>CB. :</b> Closing Birds&nbsp;&nbsp;&nbsp;<b>Wt :</b> Weight&nbsp;&nbsp;&nbsp;<b>Prod% :</b> Production%&nbsp;&nbsp;&nbsp;
	</td>
	</tr>




<tr><td ><br /><br /><b><u>Breeder:</u></b><br /><br /></td></tr>
<?php } ?>
</table>
</form>
</div>
<?php } else {?>
<div class="ewGridUpperPanel">
<?php if($_SESSION['db']!='suriya') { ?>
<table>
<tr><td ><br /><br /><b><u>Breeder:</u></b><br /><br /></td></tr></table> <?php } ?>
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
<?php if($_SESSION['db']!='suriya') { ?>
<thead>
	<th class="ewTableHeader">Details</th>
         <?php 
            $f = 0;
            include "config.php";
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
              $q = "select distinct(flock) from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) order by flock"; 
            else
              $q = "select distinct(flock) from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) order by flock"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $flo[$f] = $qr['flock'];
			  $qbr = "select breed from breeder_flock where flockcode = '$qr[flock]'"; 
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
	<td<?php $sItemRowClass1=$sItemRowClass; echo $sItemRowClass1; ?>>Age</td>
         <?php 
            include "config.php";
			$f = 0;
            if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q = "select age from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0)group by flock order by flock "; 
            else
               $q = "select age from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock "; 
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
              /* $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from breeder_consumption where itemcode in ($feedtype) and date2 = '$comparedate'  and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
               $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from breeder_consumption where itemcode in ($feedtype) and date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; */
			    $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from breeder_consumption where date2 = '$comparedate'  and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
               $q = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1',flock from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 
			     			   
			   $qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
	
		 $flockkk = $qr['flock'];
		 //$femalef = 0;$malef = 0;
		 if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q11 = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1' from breeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Male Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
            else
               $q11 = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1' from breeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Male Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
  		$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());
		while($qr11 = mysql_fetch_assoc($qrs11))
		{
		   $malef =  $qr11['quantity'];
		}
		
		if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
               $q11 = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1' from breeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
            else
               $q11 = "select sum(quantity) as 'quantity',sum(quantity1) as 'quantity1' from breeder_consumption where itemcode in (select distinct(code) from ims_itemcodes where cat = 'Female Feed') and date2 = '$comparedate' and flock = '$qr[flock]' order by flock"; 
  		$qrs11 = mysql_query($q11,$conn1) or die(mysql_error());
		while($qr11 = mysql_fetch_assoc($qrs11))
		{
		   $femalef =  $qr11['quantity'];
		}
		//Birds Calculation
		$qj = "select * from breeder_flock where flockcode = '$flockkk'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $fopening = $qrj['femaleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $qj = "select distinct(date2),fmort,fcull,mmort,mcull from breeder_consumption where flock = '$flockkk' and date2 < '$comparedate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $minus = $minus + $qrj['fmort'] + $qrj['fcull'];

            $ftransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$flockkk' and date < '$comparedate'"; 
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
            $qj = "select * from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$flockkk' and date < '$comparedate'"; 
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
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
		//Male Birds
		$qj = "select * from breeder_flock where flockcode = '$flockkk'"; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $mopening = $qrj['maleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $qj = "select distinct(date2),mmort,mcull from breeder_consumption where flock = '$flockkk' and date2 < '$comparedate' "; 
    		 $qrsj = mysql_query($qj,$conn1) or die(mysql_error());
		 while($qrj = mysql_fetch_assoc($qrsj))
                $minus = $minus + $qrj['mmort'] + $qrj['mcull'];

             $ftransfer = 0;
             $qj = "select * from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$flockkk' and date < '$comparedate'"; 
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
             $qj = "select * from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$flockkk' and date < '$comparedate'"; 
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
$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flockkk' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
			 
		
			 
             $mremaining = 0;
			 
			 //echo $flockkk."/".$mopening."/".$minus."/".$ftransfer."/".$ttransfer."/".$mquantfc; echo"/B";
             $mremaining = $mopening - $minus - $ftransfer + $ttransfer + $mquantfc ;
			 $mtot = $mtot + $mremaining;
			 
		//Male Birds Ends
		//echo "</br>".$finalfeed."/";
		//echo round($femalef,0)."/";
         ?>
	     <td<?php echo $sItemRowClass; ?>>
		 <!-- <?php //echo $qr['quantity'] . " (Female) <br/> " . $qr['quantity1'] . " (Male) "; 
		 //$finalfeed = $finalfeed + $qr['quantity'] + $qr['quantity1']; ?> -->
		 <?php 
		 $actualff[$dummf] = round((($femalef * 1000)/$remaining),0);
		 $actualmf[$dummf] = round((($malef * 1000)/$mremaining),0);
		
		 $dummf = $dummf + 1;
		 echo round($femalef,0)."/".round($malef,0); 
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
	<td<?php $sItemRowClass2=$sItemRowClass; echo $sItemRowClass2; ?> title="Feed Consumed/Bird">F.Cons/Bird(gms.)</td>
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
			$q11 = "select * from breeder_standards where age = '$age1[$f]' and breed = '$flkbreed[$f]'";
			}
			else
			{
			$q11 = "select * from breeder_standards where age = '$age1[$f]'";
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
            $q = "select * from ims_itemcodes where cat = 'Eggs' or cat = 'Hatch Eggs' "; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $eggtype = $eggtype . ",'" . $qr['code'] . "'";
            } 
            $st = 0;
            $sItemRowClass2 = $sItemRowClass1;
            $q = "select distinct(itemcode) from breeder_production where itemcode in ($eggtype) and date1 = '$comparedate'  order by itemcode"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $q12 = "select * from ims_itemcodes where code = '$qr[itemcode]'"; 
     		  $qrs12 = mysql_query($q12,$conn1) or die(mysql_error());
		  while($qr12 = mysql_fetch_assoc($qrs12))
		  {
                $idesc = $qr12['description'];
				$hyes = 0;
				if($qr12['cat'] == "Hatch Eggs")
				{
				$hyes = 1;
				}
              }
?>
<tr>
	<td<?php echo $sItemRowClass2; ?>><?php echo $qr['itemcode']; ?><br />(<?php echo $idesc; ?>)</td>
       <?php for($l = 0;$l < count($flo);$l++) { ?>
         <?php 
            include "config.php";
            $q1 = "select sum(quantity) as 'quantity' from breeder_production where itemcode = '$qr[itemcode]' and flock = '$flo[$l]' and date1 = '$comparedate' group by flock order by flock"; 
  		$qrs1 = mysql_query($q1,$conn1) or die(mysql_error());
            if(mysql_num_rows($qrs1))
            {
              
		  while($qr1 = mysql_fetch_assoc($qrs1))
		  { 
         ?>
	          <td<?php echo $sItemRowClass2; ?>><?php echo $qr1['quantity']; if($hyes == 1) $heggs[$l] = $heggs[$l] + $qr1['quantity']; $finaleggs = $finaleggs + $qr1['quantity']; ?></td>
         <?php  } } else { ?>   
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
            $q = "select sum(quantity) as 'quantity' from breeder_production where itemcode in ($eggtype) and date1 = '$comparedate' and flock = '$flo[$l]' group by flock order by flock"; 
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
             $q = "select * from breeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $fopening = $qr['femaleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),fmort,fcull,mmort,mcull from breeder_consumption where flock = '$flo[$f]' and date2 < '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $minus = $minus + $qr['fmort'] + $qr['fcull'];


             $q = "select * from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$flo[$f]' and date < '$comparedate'"; 
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

             $q = "select * from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$flo[$f]' and date < '$comparedate'"; 
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
			 
			 		 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
			 
			 
			$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
             $q = "select * from breeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $mopening = $qr['maleopening'];

             $minus = 0; 
			 $minus1 = 0;
             $q = "select distinct(date2),mmort,mcull from breeder_consumption where flock = '$flo[$f]' and date2 < '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
                $minus = $minus + $qr['mmort'] + $qr['mcull'];


             $q = "select * from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$flo[$f]' and date < '$comparedate'"; 
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

             $q = "select * from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$flo[$f]' and date < '$comparedate'"; 
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

			 
			 $q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
			 
			  $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date < '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
                $q = "select fmort from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
                $q = "select fmort from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

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
                $q = "select mmort from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
                $q = "select mmort from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 
 
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
                $q = "select fcull from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
                $q = "select fcull from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

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
                $q = "select mcull from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flockcode) from breeder_flock where cullflag = 0) group by flock order by flock"; 
            else
                $q = "select mcull from breeder_consumption where date2 = '$comparedate' and flock in ($_GET[flock]) group by flock order by flock"; 

  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
         ?>
	     <td<?php echo $sItemRowClass2; ?>><?php echo $qr['mcull']; $finalcull = $finalcull + $qr['mcull']; ?></td>
         <?php } ?>   
	<td<?php echo $sItemRowClass2; ?>><?php echo $finalcull; ?></td>
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
             $q = "select * from breeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
			

             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$flo[$f]' and date2 <= '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select * from ims_stocktransfer where cat = 'Female Birds' and fromwarehouse = '$flo[$f]' and date <= '$comparedate'"; 
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

             $q = "select * from ims_stocktransfer where cat = 'Female Birds' and towarehouse = '$flo[$f]' and date <= '$comparedate'"; 
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
			
			 
			$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
			 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Female Birds')";  
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
             $q = "select * from breeder_flock where flockcode = '$flo[$f]'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $mopening = $qr['maleopening'];
             }

             $minus = 0; 
             $q = "select distinct(date2),mmort,mcull from breeder_consumption where flock = '$flo[$f]' and date2 <= '$comparedate' "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['mmort'] + $qr['mcull'];
             }


             $q = "select * from ims_stocktransfer where cat = 'Male Birds' and fromwarehouse = '$flo[$f]' and date <= '$comparedate'"; 
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

             $q = "select * from ims_stocktransfer where cat = 'Male Birds' and towarehouse = '$flo[$f]' and date <= '$comparedate'"; 
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
$q = "SELECT sum(receivedquantity) as quant FROM pp_sobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
			 
			 $q = "SELECT sum(quantity) as quant FROM oc_cobi WHERE flock = '$flo[$f]' AND date <= '$comparedate' AND code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Male Birds')";  
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
             $q = "select fweight from breeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
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
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards)";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'";
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
             $q = "select mweight from breeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
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
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards)";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'";
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
<tr>
	<td<?php echo $sItemRowClass2; ?>>Egg Weight</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select eggwt from breeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' "; 
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
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards)";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'";
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
            { //echo $heggs[$f];echo "</br>";
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
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards where breed = '$flkbreed[$f]')";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'  and breed = '$flkbreed[$f]'";
			}
			else
			{
			if( $age1[$f] > $maxagee )
			 $q = "SELECT * FROM breeder_standards WHERE age in (select max(age) from breeder_standards)";
			 else	
			$q = "select * from breeder_standards where Age = '$age1[$f]'";
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

<?php } ?>
<!--
<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Consumption Cost</td>
         <?php 
            include "config.php";
            for($f = 0;$f<count($flo);$f++)
            {
             $q = "select price from breeder_consumption where flock = '$flo[$f]' and date2 = '$comparedate' limit 1"; 
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
             $q = "select price from breeder_production where flock = '$flo[$f]' and date1 = '$comparedate' limit 1"; 
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
	<!-- tr><td colspan="1"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<!-- <tr class="ewRptGrandSummary"><td colspan="1">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr> -->
<?php } ?>
	</tfoot>
</table>
</div>

<?php if ($nTotalGrps > 0) { ?>
<div class="ewGridLowerPanel">
<form action="daysheet.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<?php if($_SESSION['db']!='suriya') { ?>
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
$qury1aq = "select distinct(itemcode) from breeder_consumption where date2 = '$comparedate' and flock in (select distinct(flock) from breeder_production where date1 = '$comparedate')";
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
	<?php } ?>
	<tr  >
	<td >
	<br /><br />

	<b><u>Broiler:</u></b><br /><br />


	</td>
	</tr>
</table>



<table class="ewTable ewTableSeparate" cellspacing="0" align="center">
   
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Place</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Supervisor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supervisor</td>
			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Farmer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Farmer</td>
			
			</tr></table>
		</td>
<?php } ?>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Mortality">
		Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Mortality">Mort.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality">
		C.Mort.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality">C.Mort.</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Mortality">
		C.Mort %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Mortality %">C.Mort %</td>
			</tr></table>
		</td>
<?php } ?> 
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Birds</td>
			</tr></table>
		</td>
<?php } ?>

<?php
if($_SESSION['db'] == 'central')
{
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer <br /> Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer <br /> Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php 

if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sent/Transfer<br />Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sent/Transfer<br /> Weight</td>
			</tr></table>
		</td>
<?php } } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Consumed">
		F.cons
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed Consumed">F.cons</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed Consumed">
		C.Feed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Consumed">C.Feed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed/Bird Standard">
		Feed/Bird Std
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Feed/Bird Standard">Feed/Bird Std</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Feed Intake Per Bird">
		Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Consumed">Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed Per Bird Standard">
		C.Feed/Bird Std
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed Per Bird Standard">C.Feed/Bird Std</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Cummulative Feed/Bird ">
		C.Feed/Bird
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Cummulative Feed/Bird">C.Feed/Bird</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Standard Average Weight">
		Std A.Weight 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Standard Average Weight">Std A.Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Average Weight">
		A.Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Average Weight">A.Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Std F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Std F.C.R</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="F.C.R">
		F.C.R
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="F.C.R">F.C.R</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Medicine Name">
		M.Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Medicine Name">M.Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Medicine Quantity">
		M.Qty
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Medicine Quantity">M.Qty</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Vaccine Name">
		V.Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Vaccine Name">V.Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="Vaccine Quantity">
		V.Qty
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="Vaccine Quantity">V.Qty</td>
			</tr></table>
		</td>
<?php } ?>	
	</tr>
	</thead>
<?php 

// Retrieving Standard Values
$queryaa = "SELECT feed,cumfeed,fcr,avgweight,age FROM broiler_allstandards order by age";
$resultaa = mysql_query($queryaa,$conn1);
while($rowaa = mysql_fetch_assoc($resultaa))
{
  $feedstdarr[$rowaa['age']] = $rowaa['feed'];
  $cumfeedstdarr[$rowaa['age']] = $rowaa['cumfeed'];
  $stdfcrarr[$rowaa['age']] = $rowaa['fcr'];
  $stdwtarr[$rowaa['age']] = $rowaa['avgweight'];
} 
	
$tmort=$tcmort=$tbirds=$tfeed=$tcfeed=$tmed=$tvac=0;

$query = "SELECT d1.place,d1.supervisior,d1.farm,d1.flock,d1.entrydate,d1.age,d1.mortality,d1.feedconsumed,d1.average_weight,d1.medicine_name,d1.medicine_quantity,d1.vaccine_name,d1.vaccine_quantity FROM broiler_daily_entry d1 INNER JOIN ( SELECT flock, entrydate FROM broiler_daily_entry where cullflag <> 1 and entrydate='$fdate' GROUP BY flock) d2 ON d2.flock = d1.flock AND d2.entrydate = d1.entrydate group by flock order by d1.place,d1.supervisior,d1.farm,d1.flock";
$result = mysql_query($query,$conn1) or die(mysql_error()); 
$preplace=$presuper=$prefarm="";
while($res = mysql_fetch_assoc($result))
{
$query2 = "select sum(mortality) as cmortality,sum(feedconsumed) as cfeedconsumed,sum(cull) as ccull,max(average_weight) as avw from broiler_daily_entry where flock = '$res[flock]' and supervisior = '$res[supervisior]' and farm = '$res[farm]'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$res2 = mysql_fetch_assoc($result2);

	$cmortality = $res2['cmortality'];
	$cfeedconsumed = $res2['cfeedconsumed'];
    $ccull = $res2['ccull'];
	$avw = $res2['avw'];
	
 $birds = 0;
  $soldbirds = 0;
  $query111a = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where aflock = '$res[flock]' and towarehouse = '$res[farm]' AND cat = 'Broiler Chicks'"; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
  if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { $birds = $birds + $row111a['chicks'];  } }

  //if(($birds == "") OR ($birds == 0))
  {
   $query111a = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$res[flock]' and warehouse = '$res[farm]' and description = 'Broiler Chicks' "; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds + $row111a['chicks'];  } }
  }
  
  $query111 = "SELECT sum(birds) as chicks FROM oc_cobi where flock = '$res[flock]' and warehouse = '$res[farm]' and code = 'BROB101'"; 
  
   $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $soldbirds = $row111['chicks'];  } }
  
 // broiler send birds calculation
if($_SESSION['db'] == 'central')
{
  $sentquery = "SELECT sum(birds) as birds,sum(weight) as weight from broiler_chickentransfer where flock = '$res[flock]'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
  $birds = $birds - $sentres['birds']; 
  $sentbirds = $sentres['birds']; 
  $sentweight = $sentres['weight']; 
  }
     
  $oobirds = $birds;
  $birds = $birds - $cmortality - $soldbirds - $ccull;	

	
  $feedstd = $feedstdarr[$res['age']];
  $cumfeedstd = $cumfeedstdarr[$res['age']];
  $stdfcr = $stdfcrarr[$res['age']];
  $stdwt = $stdwtarr[$res['age']];

	?>
	<tr >
	<td class="ewTableRow"><?php if($preplace !=$res['place']) { echo $preplace=$res['place']; $presuper = ""; } else  echo "&nbsp;";   ?></td>	
	<td><?php if($preplace ==$res['place'] and $presuper==$res['supervisior'] ) echo "&nbsp;"; else  echo $presuper=$res['supervisior']; ?></td>
	<td class="ewTableRow"><?php echo $res['farm']; ?></td>
	<td class="ewTableRow"><?php echo $res['flock']; ?></td>
	<td class="ewTableRow"><?php echo $res['age']; ?></td>
	<td class="ewTableRow"><?php echo $res['mortality']; $tmort+=$res['mortality']; ?></td>
	<td class="ewTableRow"><?php echo $cmortality; $tcmort+=$cmortality;  ?></td>
	<td class="ewTableRow"><?php echo round(($cmortality / ($oobirds)) * 100,2) ?></td>
	<td class="ewTableRow"><?php echo $birds; $tbirds+=$birds; ?></td>
	<?php if($_SESSION['db'] == 'central')
{?>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($sentbirds)echo $sentbirds; else echo "0";?>
</td>
<td<?php echo $sItemRowClass; ?> align="right">
<?php if($sentweight) echo $sentweight; else echo "0"; ?>
</td>
<?php } ?>
	<td class="ewTableRow"><?php echo $res['feedconsumed']; $tfeed+=$res['feedconsumed']; ?></td>
	<td class="ewTableRow"><?php echo $cfeedconsumed; $tcfeed+=$cfeedconsumed; ?></td>
	<td class="ewTableRow"><?php echo $feedstd; ?></td>
	<td class="ewTableRow"><?php echo round((($res['feedconsumed']/$birds) * 1000),2); ?></td>
	<td class="ewTableRow"><?php echo $cumfeedstd; ?></td>
	<td class="ewTableRow"><?php echo round((($cfeedconsumed/$oobirds) * 1000),2); ?></td>
	
	<td class="ewTableRow"><?php echo $stdwt; ?></td>
	
	<td class="ewTableRow"><?php echo $avw; ?></td>
	<td class="ewTableRow"><?php echo $stdfcr; ?></td>
	<td class="ewTableRow"><?php echo round(($cfeedconsumed / (($avw / 1000) * $birds )),2); ?></td>
	
	<td class="ewTableRow"><?php if($res['medicine_name'])echo $res['medicine_name']; else echo "0";  ?></td>
	<td class="ewTableRow"><?php if($res['medicine_quantity'])echo $res['medicine_quantity']; else echo "0"; $tmed+=$res[medicine_quantity];  ?></td>
	<td class="ewTableRow"><?php if($res['vaccine_name'])echo $res['vaccine_name']; else echo "0";?></td>
	<td class="ewTableRow"><?php if($res['vaccine_quantity'])echo $res['vaccine_quantity']; else echo "0"; $tvac+=$res[vaccine_quantity]; ?></td>
		
		
	</tr>
<?php } ?>
	<tr>
	<td align="right" colspan="5"> Total </td>
	<td><?php echo $tmort; ?></td>
	<td><?php echo $tcmort; ?></td>
	<td><?php echo '&nbsp;'; ?></td>
	<td><?php echo $tbirds; ?></td>
	<td><?php echo $tfeed; ?></td>
	<td><?php echo $tcfeed; ?></td>
	<td colspan="9"><?php echo '&nbsp;' ?></td>
	<td><?php echo $tmed; ?></td>
	<td><?php echo '&nbsp;'; ?></td>
	<td><?php echo $tvac; ?></td>
	</tr>
	
</table>



<?php $i=0;
$q43 = "SELECT pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal FROM pp_sobi where pp_sobi.date = '$fdate' and client = '$client' group by pp_sobi.vendor, pp_sobi.date, pp_sobi.so, pp_sobi.totalquantity, pp_sobi.grandtotal order by pp_sobi.vendor ASC, pp_sobi.date ASC"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
while($qr43 = mysql_fetch_assoc($qrs43))
{
if($i==0)
{ $i=1; ?>
<br /><br /><br /><br /><br />
<b><u>Purchases</u></b><br /><br />
<table>
<tr>
    <td><b>Vendor</b></td><td width="15px"></td>
    <td><b>So #</b></td><td width="15px"></td>
    <td><b>Item Code</b></td><td width="15px"></td>
    <td><b>Item Description</b></td><td width="15px"></td>
    <td><b>Quantity</b></td><td width="15px"></td>
    <td><b>Price</b></td><td width="15px"></td>
    <td><b>Total Quantity</b></td><td width="15px"></td>
    <td><b>Amount</b></td><td width="15px"></td>
</tr>
<?php
}


$code = $description = $quantity = $price = "";
 $q = "select * from pp_sobi where date = '$qr43[date]' and vendor = '$qr43[vendor]' and client = '$client' and so = '$qr43[so]' order by date asc";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	 $quantity.= $qr['receivedquantity'] . "/";
	$price.= $qr['rateperunit'] . "/";
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);

?>

<tr height="5px"><td></td></tr>
<tr>
    <td><?php echo $qr43['vendor']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['so']; ?></td><td width="15px"></td>
    <td><?php echo $code; ?></td><td width="15px"></td>
    <td><?php echo $description; ?></td><td width="15px"></td>
    <td><?php echo changeprice($quantity); ?></td><td width="15px"></td>
    <td><?php echo changeprice($price); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['totalquantity']); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['grandtotal']); ?></td><td width="15px"></td>
</tr>
<?php $ttq = $ttq + $qr43['totalquantity']; $tgt = $tgt + $qr43['grandtotal']; } 

if($i==1) { ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($ttq); $ttq = 0; ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($tgt); $tgt = 0; ?></td><td width="15px"></td>
</tr>
</table>
<?php } ?>


<?php $i=0;
$q43 = "SELECT * FROM oc_cobi where oc_cobi.date = '$fdate' and client = '$client' group by oc_cobi.party, oc_cobi.date, oc_cobi.invoice, oc_cobi.totalquantity, oc_cobi.finaltotal order by oc_cobi.code ASC, oc_cobi.date ASC, oc_cobi.party ASC"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
while($qr43 = mysql_fetch_assoc($qrs43))
{

if($i==0)
{
$i=1;
 ?>
<br /><b><u>Sales</u></b><br /><br />
<table>
<tr>
    <td><b>Customer</b></td><td width="15px"></td>
    <td><b>Invoice</b></td><td width="15px"></td>
    <td><b>Item Code</b></td><td width="15px"></td>
    <td><b>Item Description</b></td><td width="15px"></td>
    <td><b>Quantity</b></td><td width="15px"></td>
    <td><b>Price</b></td><td width="15px"></td>
    <td><b>Total Quantity</b></td><td width="15px"></td>
    <td><b>Amount</b></td><td width="15px"></td>
</tr>

<?php }

$code = $description = $quantity = $price = "";
$q = "select * from oc_cobi where date = '$qr43[date]' and party = '$qr43[party]' and client = '$client' and invoice = '$qr43[invoice]' order by date asc";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
	$code.= $qr['code'] . "/";
	$description.= $qr['description'] . "/";
	$quantity.= $qr['quantity'] . "/";
	$price.= $qr['price'] . "/";
	
}

$code = substr($code,0,-1);
$description = substr($description,0,-1);
$quantity = substr($quantity,0,-1);
$price = substr($price,0,-1);

  ?>
<tr height="2px"><td></td></tr>
<tr>
    <td><?php echo $qr43['party']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['invoice']; ?></td><td width="15px"></td>
    <td><?php echo $code; ?></td><td width="15px"></td>
    <td><?php echo $description; ?></td><td width="15px"></td>
    <td><?php echo changeprice($quantity); ?></td><td width="15px"></td>
    <td><?php echo changeprice($price); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['totalquantity']); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['finaltotal']); ?></td><td width="15px"></td>
</tr>
<?php $ttq = $ttq + $qr43['totalquantity']; $tgt = $tgt + $qr43['finaltotal']; } if($i==1) { ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($ttq); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($tgt); ?></td><td width="15px"></td>
</tr>
</table>
<?php } ?>

<?php 
$i=0;
$q43 = "SELECT * from pp_payment where adate='$fdate'"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
$tpayment= $tpaymentpaid=0;
while($qr43 = mysql_fetch_assoc($qrs43))
{

if($i==0)
{ $i=1; ?>
<table>
<tr height="5px"><td></td></tr>
<b><u>Payments</u></b><br /><br />
<tr>
    <td><b>Vendor</b></td><td width="15px"></td>
    <td><b>Doc No #</b></td><td width="15px"></td>
    <td><b>Code</b></td><td width="15px"></td>
    <td><b>Description</b></td><td width="15px"></td>
    <td><b>Amount Paid</b></td><td width="15px"></td>

    
</tr>
<?php } 
 $tpayment=$tpayment+$qr43['actualamount'];
 $tpaymentpaid=$tpaymentpaid+$qr43['amountpaid'];
 ?><tr>
    <td><?php echo $qr43['vendor']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['doc_no']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['code']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['description']; ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['actualamount']); ?></td><td width="15px"></td>
  </tr>
 <?php
}
if($i==1) { ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
 
  
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
   
    <td  align="right"><?php echo changeprice($tpayment); ?></td><td width="15px"></td>
    
</tr>
</table>
<?php } ?>

<?php  $i=0;
$q43 = "SELECT * from oc_receipt where adate='$fdate'"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
$tpayment= $tpaymentpaid=0;
while($qr43 = mysql_fetch_assoc($qrs43))
{

 if($i==0) { $i=1;
 ?>
 <table>
<tr height="5px"><td></td></tr>
<b><u>Receipts</u></b><br /><br />
<tr>
    <td><b>Party</b></td><td width="15px"></td>
    <td><b>Doc No #</b></td><td width="15px"></td>
    <td><b>Code</b></td><td width="15px"></td>
    <td><b>Description</b></td><td width="15px"></td>
    <td><b>Amount Received</b></td><td width="15px"></td>
	
    
</tr>
 <?php }
 $tpayment=$tpayment+$qr43['amount'];
 $tpaymentpaid=$tpaymentpaid+$qr43['totalamount'];
 ?>
 <tr>
    <td><?php echo $qr43['party']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['doc_no']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['code']; ?></td><td width="15px"></td>
    <td><?php echo $qr43['description']; ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($qr43['amount']); ?></td><td width="15px"></td>
  </tr>  
 <?php
}
if($i==1) { ?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
 
    <td><hr /></td><td width="15px"></td>
    
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
   
    <td  align="right"><?php echo changeprice($tpayment); ?></td><td width="15px"></td>
    
</tr>
</table>
<?php } ?>

<?php  $i=0;
$q = "SELECT distinct(transactioncode) from ac_gl where date='$fdate' and voucher='P' and type='Expense'"; 
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$tdrcr=0;

while($qr = mysql_fetch_assoc($qrs))
{

if($i==0) { $i=1; ?>

<table>
<tr height="5px"><td></td></tr>
<b><u>Expenses</u></b><br /><br />
<tr>
    <td><b>Type</b></td><td width="15px"></td>
	<td><b>Transaction No</b></td><td width="15px"></td>

    <td><b>Expenses</b></td><td width="15px"></td>
    <td><b>Amount</b></td><td width="15px"></td> 
</tr>
<?php
}

$q43 = "SELECT description,voucher,transactioncode,controltype,crdr,dramount,cramount,crtotal,drtotal from ac_gl where date='$fdate' and transactioncode='$qr[transactioncode]' and voucher='P' and type='Expense'  order by controltype"; 
$qrs43 = mysql_query($q43,$conn1) or die(mysql_error());
$description='';
while($qr43 = mysql_fetch_assoc($qrs43))
{
$description.= $qr43['description'] . "/";
$transactioncode=$qr43['transactioncode'];
$voucher=$qr43['voucher'];
$drtotal=$qr43['drtotal'];
$crtotal=$qr43['crtotal'];
}
 ?>
  <tr>
    <td>
	<?php if($voucher=='R'){ echo 'Receipt Voucher'; $amount=$drtotal;  $tdrcr=$tdrcr+$amount; }
	else if($voucher=='P') { echo 'Payment Voucher'; $amount=$crtotal;  $tdrcr=$tdrcr+$amount; } ?></td><td width="15px"></td>
	<td><?php echo $transactioncode; ?></td><td width="15px"></td>
   
    <td><?php echo substr($description,0,-1); ?></td><td width="15px"></td>
    <td align="right"><?php echo changeprice($amount); ?></td><td width="15px"></td>
    </tr>
 <?php
} if($i==1) {
?>
<tr height="2px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
   
  <td></td><td width="15px"></td>
  
    <td><hr /></td><td width="15px"></td>
</tr>
<tr height="5px"><td></td></tr>
<tr>
    <td></td><td width="15px"></td>
    <td></td><td width="15px"></td>
 
   <td></td><td width="15px"></td>
 
   
    <td  align="right"><?php echo changeprice($tdrcr); ?></td><td width="15px"></td>
</tr>
</table>
<?php } ?>

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
