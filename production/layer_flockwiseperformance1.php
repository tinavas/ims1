<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php 
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('error_reporting', E_ALL);
?>

<?php
$flocktype = $_GET['flocktype'];
if($flocktype == "")
 $flocktype = 0;
session_start();
ob_start();
include "config.php";
include "reportheader.php";
include "getemployee.php";
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
define("EW_REPORT_TABLE_VAR", "dummy", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "dummy_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "dummy_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "dummy_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "dummy_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "dummy_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layer_consumption";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layer_consumption.id FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "layer_consumption.id = 1";
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
<center>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<br />
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Flockwise Performance Report</font></strong></td>
</tr>
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276"><?php if($flocktype == 0) echo "Live Flocks"; else echo "Cull Flocks"; ?></font></strong></td>
</tr>

</table>
<br />
<center>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="layer_flockwiseperformance.php?export=html&date=<?php echo $_GET['date']; ?>&flocktype=<?php echo $_GET['flocktype']; ?>&unit=<?php echo $_GET['unit']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="layer_flockwiseperformance.php?export=excel&date=<?php echo $_GET['date']; ?>&flocktype=<?php echo $_GET['flocktype']; ?>&unit=<?php echo $_GET['unit']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="layer_flockwiseperformance.php?export=word&date=<?php echo $_GET['date']; ?>&flocktype=<?php echo $_GET['flocktype']; ?>&unit=<?php echo $_GET['unit']; ?>">Export to Word</a>
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

<?php 
/*if(!isset($_GET['unit']))
{
$query="select distinct(unitcode) from breeder_flock order by unitcode limit 0 , 1";
$result=mysql_query($query,$conn1) or die(mysql_error());
if($unit=mysql_fetch_assoc($result))
 
  $_GET['unit']=$unit['unitcode'];
}

if($_GET['date'])
$comparedate = date("Y-m-d",strtotime($_GET['date']));
else
{
  include "config.php";
  if($_GET['unit'] != "")
  {
  $q = "select max(date2) as 'date2' from layer_consumption where flock in (select distinct(flockcode) from breeder_flock where unitcode = '$_GET[unit]') group by flock order by date2 ASC"; 
  }
  else if(!isset($_GET['flock']) || $_GET['flock'] == "All" || $_GET['flock'] == "")
      $q = "select max(date2) as 'date2' from layer_consumption group by flock order by date2 ASC"; 
  else
      $q = "select max(date2) as 'date2' from layer_consumption where flock in ($_GET[flock]) group by flock order by date2 ASC"; 
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
         $comparedate = $qr['date2'];
		 
      }
}
$dummydate = date("d.m.Y",strtotime($comparedate));*/

?>
<!-- summary report starts -->
<div id="report_summary">

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
Flock Type&nbsp;&nbsp;
<select id="flocktype" name="flocktype" onchange="reload(this.value)" >
<option value="0" <?php if($flocktype == 0) { ?> selected="selected" <?php } ?>>Live Flocks</option>
<option value="1" <?php if($flocktype == 1) { ?> selected="selected" <?php } ?>>Cull Flocks</option>
</select>

<form action="flockwiseperformance.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr>
<td>


<span class="phpreportmaker">
<!--Date&nbsp;-->
<input type="hidden"  id="date1" name="date1" value="<?php if($_GET['date']) { echo $_GET['date']; } else { echo $dummydate; }  ?>"  />
&nbsp;&nbsp;&nbsp;
</span>
</td>


<td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="flockwiseperformance.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="flockwiseperformance.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="flockwiseperformance.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="flockwiseperformance.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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


//while (($rs && !$rs->EOF) || $bShowFirstHeader) 
if(1){
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
	<th class="ewTableHeader">Flock</th>
         <?php 
            $f = 0;
            include "config.php";
			
			$q = "select distinct(flockcode) from layer_flock where cullflag = '$flocktype' AND flockcode <> 'NULL' and flockcode <> ''  and flockcode in (select distinct(flock) from layer_consumption where client='$client') and client='$client'  order by flockcode";
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
              $flo[$f] = $qr['flockcode'];
			  $qbr = "select breed from layer_flock where flockcode = '$qr[flockcode]' and client = '$client'"; 
  		$qrsbr = mysql_query($qbr,$conn1) or die(mysql_error());
		while($qrbr = mysql_fetch_assoc($qrsbr))
		{
		$flkbreed[$f] = $qrbr['breed'];
		}
         ?>
	     <th class="ewTableHeader"><?php echo $qr['flockcode']; ?></th>
         <?php $f = $f + 1; } ?>   
	<th class="ewTableHeader">Total</th>

</thead>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass1; ?>>Age</td>
         <?php 
            include "config.php";
			
			for($k = 0; $k < sizeof($flo); $k++)
			{
			$flockfinalid = $flo[$k];
			$q = "select max(age) as age from layer_consumption where flock like '$flockfinalid' and client='$client'"; 
  		$qrs = mysql_query($q,$conn1) or die(mysql_error());
		if($qr = mysql_fetch_assoc($qrs))
		{
              $age = round($qr['age']);
             
            $age1[$k] = round($age / 7);
              
			  ?>
	     <td<?php echo $sItemRowClass1; ?>><?php echo $age1[$k]; ?></td>
         <?php 
		  }
		}
		 ?>   
	<td<?php echo $sItemRowClass1; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass; ?>>Feed Consumed(Kgs) &nbsp;&nbsp;</td>
         <?php 
		 $totalfinalfeed = 0;
		 
for($k=0; $k <sizeof($flo); $k++)
{
$flockfinalid = $flo[$k];
$query = "select quantity as tot,fweight as femaleweight from layer_consumption where flock like '$flockfinalid' and itemcode in (select distinct(code) from ims_itemcodes where cat ='Layer Feed' and client='$client') and client='$client'  group by date2";
$totffeedd = 0;
$result = mysql_query($query,$conn1);
while($result1 = mysql_fetch_assoc($result))
if($result1['tot'])
{
 $totffeedd +=$result1['tot'];
}

if($totffeedd)
$feed1[$k] = $totffeedd;
else
$feed1[$k] = 0;

$query1 = "select sum(ffeedqty) as tot,sum(fweight) as femaleweight from layer_initial where ( flock like '$flockfinalid' ) and client='$client'";

$result1 = mysql_query($query1,$conn1);
$result2 = mysql_fetch_assoc($result1);
if($result2['tot'])
{
$feed2[$k] = $result2['tot'];
$weight2[$k] = $result2['femaleweight'];
}
else
{
$feed2[$k] = 0;
$weight2[$k]= 0;
}

?>
<td <?php echo $sItemRowClass; ?>><?php $feedcm = 0; $feedcm= $feed1[$k]+$feed2[$k];echo changeprice1($feedcm);   $totalfinalfeed += $feed1[$k]+$feed2[$k]; ?>  </td>
<?php

}
?>
       
	<td<?php echo $sItemRowClass; ?> ><?php echo changeprice1($totalfinalfeed); ?></td>
</tr>



<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC">Opening Birds</td>
      
	  <?php

  
	  
$openingfemalefinal = 0;
for($k=0; $k <sizeof($flo); $k++)
{
$flockfinalid = $flo[$k];
$fflloo = $flo[$k];

$query1 = "select min(date2) as mindate from layer_consumption where flock like '$flockfinalid' and client='$client'";
$birdsresult = mysql_query($query1,$conn1) or die(mysql_error());
if($mindt = mysql_fetch_assoc($birdsresult))
$mindate = $mindt['mindate'];

$query1 = "select female as openingbirds from layer_initial where flock like '$fflloo' and client='$client'";
$birdsresult = mysql_query($query1,$conn1) or die(mysql_error());
if($birds = mysql_fetch_assoc($birdsresult))
$fopeningbirds = $birds['openingbirds'];
else
$fopeningbirds = 0;

//if(mysql_num_rows($birdsresult)>0)
if($fopeningbirds == 0)
 {

   $query2 = "select sum(femaleopening) as fopeningbirds from layer_flock where flockcode = '$fflloo' and client='$client'";
    $birdsresult1 = mysql_query($query2,$conn1) or die(mysql_error());
    
	if($birds2 = mysql_fetch_assoc($birdsresult1))
      //$femaleopeningbirds[$k] = $birds2['fopeningbirds'];
	  $fopeningbirds = $birds2['fopeningbirds'];
     else 
      $fopeningbirds  = 0;
	 
  }
  
 $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and client = '$client'  and fromwarehouse = '$fflloo' and date < '$mindate'"; 
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
	 //  echo "transfer out ".$ftransfer;
	$q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$fflloo' and   code in ( select distinct(code) from ims_itemcodes where description = 'Birds' and client='$client') and client = '$client'  and date < '$mindate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 
			// echo "sale".$tsale;
			if($client == "STR")
			 {
			 $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where flock = '$fflloo' and client = '$client'  and date <= '$mindate'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpurchase = $qr['quantity'];
               }
             }
             else
             {
                $tpurchase = 0;
             } 
			 }
			 if($_SESSION['db'] == "chowdarypf")
			 {
			 $q = "select sum(receivedquantity) as 'quantity' from pp_sobi where warehouse = '$fflloo' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tpurchase = $qr['quantity'];
               }
             }
             else
             {
                $tpurchase = 0;
             } 
			 }
			 //echo "purchase".$tpurchase ;
			 $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and client = '$client'  and towarehouse = '$fflloo' and date < '$mindate'"; 
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
			 //echo "transfer in".$ttransfer;
			 
			 $q = "SELECT sum(shortagefemale) - sum(excessfemale) AS female FROM layer_birdsadjustment WHERE flock = '$fflloo' AND date < '$mindate'";
			 $r = mysql_query($q,$conn1) or die(mysql_error());
			 $rr = mysql_fetch_assoc($r);
			 $fadjust = $rr['female'];
			 
			 $fopeningbirds1 = $fopeningbirds  - $ftransfer  - $tsale + $tpurchase + $ttransfer;
			 $femaleopeningbirds[$k] = $fopeningbirds1;
  
  ?>
 <td style="background-color:#00CCCC"><?php echo changeprice1($femaleopeningbirds[$k]);$openingfemalefinal += $femaleopeningbirds[$k]; ?></td>
  <?php
  
}

?>   
<td style="background-color:#00CCCC"><?php echo changeprice1($openingfemalefinal); ?></td>	     
       
	
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC">Mortality</td>
       <?php 
$totalfemalemortality = 0;
$totalfemalecull = 0;
for($k = 0; $k<sizeof($flo);$k++)
{
$fmort = 0;
$fcull = 0;
$flockfinalid = $flo[$k];
$query = "select distinct(date2),fmort,fcull from layer_consumption where  flock like '$flockfinalid' and client='$client'";

$result1 = mysql_query($query,$conn1);
while($result2 = mysql_fetch_assoc($result1))
if($result2['fmort'] || $result2['fcull'])
{

$fmort += $result2['fmort'];
$fcull += $result2['fcull'];
}
$femalemort[$k] = $fmort;
$femalecull[$k] = $fcull;
?>
<td style="background-color:#00CCCC"><?php echo changeprice1($femalemort[$k]); $totalfemalemortality += $femalemort[$k]; $totalfemalecull += $femalecull[$k] ;?></td>
<?php
}
?> 
		
		   
	<td style="background-color:#00CCCC"><?php echo changeprice1($totalfemalemortality); ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC" >Culls</td>
        <?php
		for($k=0;$k<sizeof($flo); $k++)
		{
		?>
		<td style="background-color:#00CCCC"><?php echo changeprice1($femalecull[$k]);  ?></td>
		<?php
		}
		?>
		
		  
	<td style="background-color:#00CCCC"><?php echo changeprice1($totalfemalecull); ?></td>
</tr>

<?php /*?><?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC">Sales</td>
       <?php 
	   $closingbirds = 0;
	   for($k=0;$k<sizeof($flo); $k++)
	   {
	     $flockfinalid = $flo[$k];
         $q = "select sum(quantity) as total from oc_cobi where  flock = '$flockfinalid' and   code in ( select distinct(code) from ims_itemcodes where description = 'Birds' and client='$client') and client='$client'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
            
		   $qr = mysql_fetch_assoc($qrs);
    		   
		   if($qr['total'])
              $femaleclosing[$k] =  $qr['total'];
            else
              $femaleclosing[$k] = 0;
                   
	   
	   ?>
	   <td style="background-color:#00CCCC"><?php  $salebirds +=  $femaleclosing[$k];  echo ($femaleclosing[$k]);  ?></td>
	   <?php
	   }
	   ?> 
	       
	<td style="background-color:#00CCCC"><?php echo $salebirds; ?></td>
</tr><?php */?>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC">Closing Birds</td>
       <?php 
	   $closingbirds = 0;
	   for($k=0;$k<sizeof($flo); $k++)
	   {
	   $flockfinalid = $flo[$k];
	    $q = "select sum(quantity) as total from oc_cobi where  flock = '$flockfinalid' and   code in ( select distinct(code) from ims_itemcodes where description = 'Birds' and client='$client') and client='$client'"; 
    		 $qrs = mysql_query($q,$conn1) or die(mysql_error());
            
		   $qr = mysql_fetch_assoc($qrs);
    		   
		   if($qr['total'])
              $femaleclosing[$k] =  $qr['total'];
            else
              $femaleclosing[$k] = 0;
	   ?>
	   <td style="background-color:#00CCCC"><?php  $closingbirds += ( $femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] );  echo changeprice1(( $femaleopeningbirds[$k] - $femalemort[$k] - $femalecull[$k] ));  ?></td>
	   <?php
	   }
	   ?> 
	       
	<td style="background-color:#00CCCC"><?php echo changeprice1($closingbirds); ?></td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC">Body Weight(gms.)</td>
         <?php 
 for($k=0; $k<sizeof($flo);$k++)
 {      
    $flockfinalid = $flo[$k];
$query = "select max(fweight) as femaleweight from layer_consumption where  flock like '$flockfinalid' and client='$client'";
$result = mysql_query($query,$conn1);
$result1 = mysql_fetch_assoc($result);
if($result1['femaleweight'])
$weight = $result1['femaleweight'];
else
$weight = 0;

 ?>
 <td style="background-color:#00CCCC"><?php  $fbodyweight[$k] = $weight; echo changeprice1($fbodyweight[$k]); ?> </td>
 <?php
  }      ?> 
	<td style="background-color:#00CCCC">&nbsp;</td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td style="background-color:#00CCCC" title="Standard Female Body Weight">Std. Body Weight(gms.)</td>
      <?php
	  for($k=0;$k<sizeof($flo);$k++)
	  {
	  $sfbw = "0";
	  if($flkbreed[$k] != "")
	  {
	  $q = "select * from layer_pstandards where age = '$age1[$k]' and breed='$flkbreed[$k]' and client='$client'";
	  }
	  else
	  {
		$q = "select * from layer_pstandards where age = '$age1[$k]' and client='$client'";
	  }
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			{
				$sfbw = $qr['bodyweight'];
			}
			else
			{
			if($flkbreed[$k] != "")
	  {
			$q = "select * from layer_pstandards where age in (select max(age) from layer_pstandards where breed='$flkbreed[$k]' and  client='$client') and breed = '$flkbreed[$k]' and client='$client'";
			}
			else
			{
			$q = "select * from layer_pstandards where age in (select max(age) from layer_pstandards where client='$client') and client='$client'";
			}
			$qrs = mysql_query($q,$conn1) or die(mysql_error());
			if($qr = mysql_fetch_assoc($qrs))
			
				$sfbw = $qr['bodyweight'];
			
			
			}
	  ?>  
		<td style="background-color:#00CCCC"><?php $stdfw[$k] = $sfbw; echo changeprice1($stdfw[$k]); ?></td>
		<?php
		}
		?>
	<td style="background-color:#00CCCC">&nbsp;</td>
</tr>
<tr>
	<td style="background-color:#00CCCC" >Difference</td>
      <?php
	  for($k=0;$k<sizeof($flo);$k++)
	  {
	  $fdiff = $fbodyweight[$k] - $stdfw[$k];
	  ?>
	  <td style="background-color:#00CCCC; <?php if($fdiff > 0 ){ echo "color:#FF0000";} else { echo "color:#0066FF";}?>"><?php echo changeprice1($fdiff); ?> </td>
	  <?php
	  }
	  ?>
	<td style="background-color:#00CCCC">&nbsp;</td>
</tr>

<?php /*?><?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr><td <?php echo $sItemRowClass2; ?>>Hatch Eggs</td>
<?php 
$totalhatcheggsfinal = 0;
for($k=0;$k<sizeof($flo);$k++)
{
$flockfinalid = $flo[$k];
$query = "select sum(quantity) as tot from layer_production where flock like '$flockfinalid' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Eggs')";
$result = mysql_query($query,$conn1);
$result = mysql_fetch_assoc($result);
if($result['tot'])
$hatchheggs = $result['tot'];
else
$hatchheggs = 0;

$index = 0;
$eggsquery = "select eggs from breeder_initial where ( flock like '$flockfinalid' and eggs <> '' and eggs <> 'NULL' ) ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
$maineggs[$index] = $eggsmain['eggs'];
$index++;

}
$query = "select code from ims_itemcodes where description = 'Table EGGS'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($eggcode = mysql_fetch_assoc($result)) 
   $itemcode = $eggcode['code'];
 $hatchinitial = 0;
 $tableinitial = 0;
  
for($j=0;$j<$index;$j++)
{
$sub1 = explode(',',$maineggs[$j]);
 for($l=0; $l < sizeof($sub1); $l++)
 { 
    $sub2 = explode(':',$sub1[$l]);
	if($itemcode == $sub2[0])
	 $hatchinitial +=  $sub2[1];
	 else
	 $tableinitial += $sub2[1];
	
	
 }
}

?>
<td <?php echo $sItemRowClass2; ?>><?php $counthatch[$k] = $hatchheggs + $hatchinitial; echo $counthatch[$k]; $totalhatcheggsfinal += $hatchheggs + $hatchinitial;?></td>
<?php

}
?>
	
	<td<?php echo $sItemRowClass2; ?>><?php echo $totalhatcheggsfinal; ?></td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr><td <?php echo $sItemRowClass2; ?>>Table Eggs</td>
<?php 
$totalhatcheggsfinal = 0;
for($k=0;$k<sizeof($flo);$k++)
{
$flockfinalid = "%".$flo[$k];
$query = "select sum(quantity) as tot from layer_production where ( flock like '$flockfinalid' and itemcode not in (select code from ims_itemcodes where description = 'HATCH EGGS') )";
$result = mysql_query($query,$conn1);
$result = mysql_fetch_assoc($result);
if($result['tot'])
$hatchheggs = $result['tot'];
else
$hatchheggs = 0;

$index = 0;
$eggsquery = "select eggs from breeder_initial where ( flock like '$flockfinalid' and eggs <> '' and eggs <> 'NULL' ) ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
$maineggs[$index] = $eggsmain['eggs'];
$index++;

}
$query = "select code from ims_itemcodes where description = 'HATCH EGGS'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($eggcode = mysql_fetch_assoc($result)) 
   $itemcode = $eggcode['code'];
 $hatchinitial = 0;
 $tableinitial = 0;
  
for($j=0;$j<$index;$j++)
{
$sub1 = explode(',',$maineggs[$j]);
 for($l=0; $l < sizeof($sub1); $l++)
 { 
    $sub2 = explode(':',$sub1[$l]);
	if($itemcode == $sub2[0])
	 $hatchinitial +=  $sub2[1];
	 else
	 $tableinitial += $sub2[1];
	
	
 }
}

?>
<td <?php echo $sItemRowClass2; ?>><?php  $counttable[$k] = $hatchheggs + $hatchinitial; echo $counttable[$k]; $totalhatcheggsfinal += $hatchheggs + $hatchinitial;?></td>
<?php

}
?>
	
	<td<?php echo $sItemRowClass2; ?>><?php echo $totalhatcheggsfinal; ?></td>
</tr><?php */?>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr><td <?php echo $sItemRowClass2; ?>>Eggs</td>
<?php 
$totaleggsfinal = 0;
for($k=0;$k<sizeof($flo);$k++)
{
$flockfinalid = $flo[$k];
 $query = "select sum(quantity) as tot from layer_production where flock like '$flockfinalid' and itemcode in (select distinct(code) from ims_itemcodes where cat = 'Layer Eggs' and client='$client') and client='$client'";
$result = mysql_query($query,$conn1);
$result = mysql_fetch_assoc($result);
if($result['tot'])
$heggs = $result['tot'];
else
$heggs = 0;

$index = 0;
$eggsquery = "select eggs from layer_initial where ( flock like '$flockfinalid' and eggs <> '' and eggs <> 'NULL' ) and client='$client' ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
$maineggs[$index] = $eggsmain['eggs'];
$index++;
}

/*$query = "select code from ims_itemcodes where description = 'Table Eggs'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($eggcode = mysql_fetch_assoc($result)) 
   $itemcode = $eggcode['code'];*/
 $itemcode = "EG101";
 $otherinitial = 0;
 $tableinitial = 0;
  
for($j=0;$j<$index;$j++)
{
$sub1 = explode(',',$maineggs[$j]);
 for($l=0; $l < sizeof($sub1); $l++)
 { 
    $sub2 = explode(':',$sub1[$l]);
	if($itemcode == $sub2[0])
	 $tableinitial +=  $sub2[1];
	 else
	 $otherinitial += $sub2[1];	
 }
}

?>
<td <?php echo $sItemRowClass2; ?>><?php $counteggs[$k] = $heggs + $tableinitial + $otherinitial; echo changeprice1($counteggs[$k]); $totaleggsfinal += $heggs + $tableinitial + $otherinitial;?></td>
<?php

}
?>
	
	<td<?php echo $sItemRowClass2; ?>><?php echo changeprice1($totaleggsfinal); ?></td>
</tr>

<?php /*?><?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Cummulative HHP</td>
        <?php
		for($k=0;$k<sizeof($flo);$k++)
		{
		?>
		<td <?php echo $sItemRowClass2; ?>><?php echo round((($counteggs[$k])/$femaleopeningbirds[$k]),1) ?></td>	
		<?php }
		?>  
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr><?php */?>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Act. Eggs Per Bird</td>
         <?php 
		 for($k=0; $k<sizeof($flo);$k++)
		 {?>
		 <td <?php echo $sItemRowClass2; ?>><?php $acthatch[$k] = round($counteggs[$k] / $femaleopeningbirds[$k]); echo changeprice1($acthatch[$k]);  ?></td>
		<?php }
			?>
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>

<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td<?php echo $sItemRowClass2; ?>>Std. Eggs Per Bird</td>
         <?php 
		 
		 $eggsquery = "select max(age) as maxage from layer_pstandards where client='$client'  ";
$eggsresult = mysql_query($eggsquery,$conn1) or die(mysql_error());
while($eggsmain = mysql_fetch_assoc($eggsresult))
{
 $mxage = $eggsmain['maxage'];
}
		 for($k=0; $k<sizeof($flo);$k++)
		 {
		 
		 
		 if($_SESSION['db'] == "chowdarypf")
		 {
		 
		  $stdquery = "select min(age) as minage,max(age) as maxage from layer_consumption where flock like '$flo[$k]' and client='$client'";
		 $stdresult = mysql_query($stdquery,$conn1);
		 $stdres = mysql_fetch_assoc($stdresult);
          $minage = round($stdres['minage']/7);
		  $maxage = round($stdres['maxage']/7);
		  
		   if($flkbreed[$k] != "")
		  $query = "select hecum from layer_pstandards where breed = '$flkbreed[$k]' and ( age = '$minage' or age = '$maxage') and client='$client' order by age";
		  else		 		
		 $query = "select hecum from layer_pstandards where ( age = '$minage' or age = '$maxage') and client='$client' order by age";
		  	 
		   $stdcc=0;
		  $result = mysql_query($query,$conn1);
		  while($hatch = mysql_fetch_assoc($result))
		  {
            if($stdcc == 0)
		    {
		    $stdmin = $hatch['hecum'];
			$stdcc =1;
		    }
		    else
		    $stdmax = $hatch['hecum'];
		  }
		  
		  
		 
		  $stdhat = abs($stdmax-$stdmin);
		  	  
		 }
		 else
		 {
		 
		 if($flkbreed[$k] != "")
		 {
		  if($age1[$k] <= $mxage)
		  {
		 $query = "select hecum from layer_pstandards where breed = '$flkbreed[$k]' and age = '$age1[$k]' and client='$client'";
		  }
		  else
		  {
		  $query = "select hecum from layer_pstandards where breed = '$flkbreed[$k]' and age = '$mxage' and client='$client'";
		  }
		 }
		 else
		 {
		  if($age1[$k] <= $mxage)
		  {
		  $query = "select hecum from layer_pstandards where age = '$age1[$k]' and client='$client'";
		  }
		  else
		  {
		  $query = "select hecum from layer_pstandards where age = '$mxage' and client='$client'";
		  }
		  }
		  
		  $result = mysql_query($query,$conn1);
		  if($hatch = mysql_fetch_assoc($result))
		  $stdhat = $hatch['hecum'];
		  else
		  $stdhat = 0;
		  }
		  
		   ?>
		 <td <?php echo $sItemRowClass2; ?>><?php $stdhatch[$k] = round($stdhat,2);  echo $stdhatch[$k];?> </td>
		<?php }
			?>
	<td<?php echo $sItemRowClass2; ?>>&nbsp;</td>
</tr>


<?php if($sItemRowClass2 == $sItemRowClass1) {$sItemRowClass2 = $sItemRowClass; } else { $sItemRowClass2 = $sItemRowClass1; } ?>
<tr>
	<td >Difference</td>
         <?php
		 for($k=0;$k<sizeof($flo);$k++)
		 {
		  $hatchdiff = round(($acthatch[$k] - $stdhatch[$k]),2);
		 ?>
		 
		 <td style="<?php if($hatchdiff > 0 ){ echo "color:#FF0000";} else { echo "color:#0066FF";}?>"><?php echo $hatchdiff; ?> </td> 
		 <?php
		 }
		 ?>
	<td>&nbsp;</td>
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
<!--<form action="flockwiseperformance.php" name="ewpagerform" id="ewpagerform" class="ewForm">
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
</table>
</form>-->
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
//var unitcode = document.getElementById("unit").value;
//document.location="flockwiseperformance.php?flock=<?php echo $_GET['flock']; ?>&date=" + a + "&unit=" + unitcode; 
document.location="layer_flockwiseperformance1.php?flocktype="+a;
}
function selectunit(a)
{

var date1=document.getElementById("date1").value;
document.location="layer_flockwiseperformance1.php?unit=" + a + "&date=" + date1; 
}
</script>
