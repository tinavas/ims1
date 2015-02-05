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
<?php include "reportheader.php"; ?>
<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "Breeder_Standards", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "Breeder_Standards_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "Breeder_Standards_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "Breeder_Standards_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "Breeder_Standards_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "Breeder_Standards_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "layerbreeder_standards";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT layerbreeder_standards.breed, layerbreeder_standards.age, layerbreeder_standards.livability, layerbreeder_standards.ffeed, layerbreeder_standards.mfeed, layerbreeder_standards.fweight, layerbreeder_standards.mweight, layerbreeder_standards.eggwt, layerbreeder_standards.productionper, layerbreeder_standards.heggper, layerbreeder_standards.cumhhp, layerbreeder_standards.cumhhe, layerbreeder_standards.eggbird, layerbreeder_standards.hatchper FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "breed,age";
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
$af_breed = NULL; // Popup filter for breed
$af_age = NULL; // Popup filter for age
$af_livability = NULL; // Popup filter for livability
$af_ffeed = NULL; // Popup filter for ffeed
$af_mfeed = NULL; // Popup filter for mfeed
$af_fweight = NULL; // Popup filter for fweight
$af_mweight = NULL; // Popup filter for mweight
$af_eggwt = NULL; // Popup filter for eggwt
$af_productionper = NULL; // Popup filter for productionper
$af_heggper = NULL; // Popup filter for heggper
$af_cumhhp = NULL; // Popup filter for cumhhp
$af_cumhhe = NULL; // Popup filter for cumhhe
$af_eggbird = NULL; // Popup filter for eggbird
$af_hatchper = NULL; // Popup filter for hatchper
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
$EW_REPORT_FIELD_BREED_SQL_SELECT = "SELECT DISTINCT layerbreeder_standards.breed FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_BREED_SQL_ORDERBY = "layerbreeder_standards.breed";
$EW_REPORT_FIELD_AGE_SQL_SELECT = "SELECT DISTINCT layerbreeder_standards.age FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_FIELD_AGE_SQL_ORDERBY = "layerbreeder_standards.age";
?>
<?php

// Field variables
$x_breed = NULL;
$x_age = NULL;
$x_livability = NULL;
$x_ffeed = NULL;
$x_mfeed = NULL;
$x_fweight = NULL;
$x_mweight = NULL;
$x_eggwt = NULL;
$x_productionper = NULL;
$x_heggper = NULL;
$x_cumhhp = NULL;
$x_cumhhe = NULL;
$x_eggbird = NULL;
$x_hatchper = NULL;

// Detail variables
$o_breed = NULL; $t_breed = NULL; $ft_breed = 200; $rf_breed = NULL; $rt_breed = NULL;
$o_age = NULL; $t_age = NULL; $ft_age = 3; $rf_age = NULL; $rt_age = NULL;
$o_livability = NULL; $t_livability = NULL; $ft_livability = 5; $rf_livability = NULL; $rt_livability = NULL;
$o_ffeed = NULL; $t_ffeed = NULL; $ft_ffeed = 5; $rf_ffeed = NULL; $rt_ffeed = NULL;
$o_mfeed = NULL; $t_mfeed = NULL; $ft_mfeed = 5; $rf_mfeed = NULL; $rt_mfeed = NULL;
$o_fweight = NULL; $t_fweight = NULL; $ft_fweight = 5; $rf_fweight = NULL; $rt_fweight = NULL;
$o_mweight = NULL; $t_mweight = NULL; $ft_mweight = 5; $rf_mweight = NULL; $rt_mweight = NULL;
$o_eggwt = NULL; $t_eggwt = NULL; $ft_eggwt = 5; $rf_eggwt = NULL; $rt_eggwt = NULL;
$o_productionper = NULL; $t_productionper = NULL; $ft_productionper = 5; $rf_productionper = NULL; $rt_productionper = NULL;
$o_heggper = NULL; $t_heggper = NULL; $ft_heggper = 5; $rf_heggper = NULL; $rt_heggper = NULL;
$o_cumhhp = NULL; $t_cumhhp = NULL; $ft_cumhhp = 5; $rf_cumhhp = NULL; $rt_cumhhp = NULL;
$o_cumhhe = NULL; $t_cumhhe = NULL; $ft_cumhhe = 5; $rf_cumhhe = NULL; $rt_cumhhe = NULL;
$o_eggbird = NULL; $t_eggbird = NULL; $ft_eggbird = 5; $rf_eggbird = NULL; $rt_eggbird = NULL;
$o_hatchper = NULL; $t_hatchper = NULL; $ft_hatchper = 5; $rf_hatchper = NULL; $rt_hatchper = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 15;
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
$col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();
$sel_breed = "";
$seld_breed = "";
$val_breed = "";
$sel_age = "";
$seld_age = "";
$val_age = "";

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
<?php $jsdata = ewrpt_GetJsData($val_breed, $sel_breed, $ft_breed) ?>
ewrpt_CreatePopup("Breeder_Standards_breed", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($val_age, $sel_age, $ft_age) ?>
ewrpt_CreatePopup("Breeder_Standards_age", [<?php echo $jsdata ?>]);
</script>
<div id="Breeder_Standards_breed_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Breeder_Standards_age_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<center>
<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<table align="center" border="0">
          <tr>
            <td style="text-align:center" colspan="2"><strong><font color="#3e3276">Layer Breeder Standards Report</font></strong></td>
          </tr>
        </table>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="LayerLayerBreeder_Standardssmry.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="LayerLayerBreeder_Standardssmry.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="LayerLayerBreeder_Standardssmry.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="LayerLayerBreeder_Standardssmry.php?cmd=reset">Reset All Filters</a>
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
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<form action="LayerLayerBreeder_Standardssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="LayerLayerBreeder_Standardssmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="LayerLayerBreeder_Standardssmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
<option value="ALL"<?php if (@$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] == -1) echo " selected" ?>>All</option>
</select>
		</span></td>
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
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"> Breed </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Breed</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"> Age </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Age</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"> Livability </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Livability</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Female Feed"> F.Feed </td>
                          <?php } else { ?>
                          <td class="ewTableHeader" title="Female Feed"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>F.Feed</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Male Feed"> M.Feed </td>
                          <?php } else { ?>
                          <td class="ewTableHeader" title="Male Feed"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>M.Feed</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Female Body Weight"> F.Weight </td>
                          <?php } else { ?>
                          <td class="ewTableHeader" title="Female Body Weight"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>F.Weight</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Male Body Weight"> M.Weight </td>
                          <?php } else { ?>
                          <td class="ewTableHeader" title="Male Body Weight"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>M.Weight</td>
                            </tr>
                          </table></td>
                          <?php } ?>
						  <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Egg Weight"> E.Weight </td>
                          <?php } else { ?>
                          <td class="ewTableHeader" title="Egg Weight"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>E.Weight</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Production Percentage"> Production % </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="Production Percentage"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Production %</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"  title="Hatch Egg %"> HE % </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="Hatch Egg %"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>HE %</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"  title="Egg/Bird"> Egg/Bird </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="Egg/Bird"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Egg/Bird</td>
                            </tr>
                          </table></td>
                          <?php } ?>
						   <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"  title="HHE/Week"> HHE/Week </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="HHE/Week"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>HHE/Week</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader"  title="Hatch Egg/Bird"> Cum HHP </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="Hatch Egg/Bird"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Cum HHP</td>
                            </tr>
                          </table></td>
                          <?php } ?>
                         
                          <?php if (@$sExport <> "") { ?>
                          <td valign="bottom" class="ewTableHeader" title="Hatch Percentage"> Hatch % </td>
                          <?php } else { ?>
                          <td class="ewTableHeader"  title="Hatch Percentage"><table cellspacing="0" class="ewTableHeaderBtn">
                            <tr>
                                <td>Hatch %</td>
                            </tr>
                          </table></td>
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
<?php echo ewrpt_ViewValue($x_breed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_age) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_livability) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_ffeed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_mfeed) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_fweight) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_mweight) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_eggwt) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_productionper) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_heggper) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cumhhp) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cumhhe) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_eggbird) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_hatchper) ?>
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
	<!-- tr><td colspan="14"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr class="ewRptGrandSummary"><td colspan="14">Grand Total (<?php echo ewrpt_FormatNumber($rstotcnt,0,-2,-2,-2); ?> Detail Records)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($nTotalGrps > 0) { ?>
<?php if (@$sExport == "") { ?>
<div class="ewGridLowerPanel">
<form action="LayerBreeder_Standardssmry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartGrp, $nDisplayGrps, $nTotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="LayerBreeder_Standardssmry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
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
		$GLOBALS['x_breed'] = $rs->fields('breed');
		$GLOBALS['x_age'] = $rs->fields('age');
		$GLOBALS['x_livability'] = $rs->fields('livability');
		$GLOBALS['x_ffeed'] = $rs->fields('ffeed');
		$GLOBALS['x_mfeed'] = $rs->fields('mfeed');
		$GLOBALS['x_fweight'] = $rs->fields('fweight');
		$GLOBALS['x_mweight'] = $rs->fields('mweight');
		$GLOBALS['x_eggwt'] = $rs->fields('eggwt');
		$GLOBALS['x_productionper'] = $rs->fields('productionper');
		$GLOBALS['x_heggper'] = $rs->fields('heggper');
		$GLOBALS['x_cumhhp'] = $rs->fields('cumhhp');
		$GLOBALS['x_cumhhe'] = $rs->fields('cumhhe');
		$GLOBALS['x_eggbird'] = $rs->fields('eggbird');
		$GLOBALS['x_hatchper'] = $rs->fields('hatchper');
		$val[1] = $GLOBALS['x_breed'];
		$val[2] = $GLOBALS['x_age'];
		$val[3] = $GLOBALS['x_livability'];
		$val[4] = $GLOBALS['x_ffeed'];
		$val[5] = $GLOBALS['x_mfeed'];
		$val[6] = $GLOBALS['x_fweight'];
		$val[7] = $GLOBALS['x_mweight'];
		$val[8] = $GLOBALS['x_eggwt'];
		$val[9] = $GLOBALS['x_productionper'];
		$val[10] = $GLOBALS['x_heggper'];
		$val[11] = $GLOBALS['x_cumhhp'];
		$val[12] = $GLOBALS['x_cumhhe'];
		$val[13] = $GLOBALS['x_eggbird'];
		$val[14] = $GLOBALS['x_hatchper'];
	} else {
		$GLOBALS['x_breed'] = "";
		$GLOBALS['x_age'] = "";
		$GLOBALS['x_livability'] = "";
		$GLOBALS['x_ffeed'] = "";
		$GLOBALS['x_mfeed'] = "";
		$GLOBALS['x_fweight'] = "";
		$GLOBALS['x_mweight'] = "";
		$GLOBALS['x_eggwt'] = "";
		$GLOBALS['x_productionper'] = "";
		$GLOBALS['x_heggper'] = "";
		$GLOBALS['x_cumhhp'] = "";
		$GLOBALS['x_cumhhe'] = "";
		$GLOBALS['x_eggbird'] = "";
		$GLOBALS['x_hatchper'] = "";
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
	// Build distinct values for breed

	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_BREED_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_BREED_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_breed = $rswrk->fields[0];
		if (is_null($x_breed)) {
			$bNullValue = TRUE;
		} elseif ($x_breed == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_breed = $x_breed;
			ewrpt_SetupDistinctValues($GLOBALS["val_breed"], $x_breed, $t_breed, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_breed"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_breed"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

	// Build distinct values for age
	$bNullValue = FALSE;
	$bEmptyValue = FALSE;
	$sSql = ewrpt_BuildReportSql($GLOBALS["EW_REPORT_FIELD_AGE_SQL_SELECT"], $GLOBALS["EW_REPORT_TABLE_SQL_WHERE"], $GLOBALS["EW_REPORT_TABLE_SQL_GROUPBY"], $GLOBALS["EW_REPORT_TABLE_SQL_HAVING"], $GLOBALS["EW_REPORT_FIELD_AGE_SQL_ORDERBY"], $sFilter, "");
	$rswrk = $conn->Execute($sSql);
	while ($rswrk && !$rswrk->EOF) {
		$x_age = $rswrk->fields[0];
		if (is_null($x_age)) {
			$bNullValue = TRUE;
		} elseif ($x_age == "") {
			$bEmptyValue = TRUE;
		} else {
			$t_age = $x_age;
			ewrpt_SetupDistinctValues($GLOBALS["val_age"], $x_age, $t_age, FALSE);
		}
		$rswrk->MoveNext();
	}
	if ($rswrk)
		$rswrk->Close();
	if ($bEmptyValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_age"], EW_REPORT_EMPTY_VALUE, EW_REPORT_EMPTY_LABEL, FALSE);
	if ($bNullValue)
		ewrpt_SetupDistinctValues($GLOBALS["val_age"], EW_REPORT_NULL_VALUE, EW_REPORT_NULL_LABEL, FALSE);

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
			ClearSessionSelection('breed');
			ClearSessionSelection('age');
			ResetPager();
		}
	}

	// Load selection criteria to array
	// Get Breed selected values

	if (is_array(@$_SESSION["sel_Breeder_Standards_breed"])) {
		LoadSelectionFromSession('breed');
	} elseif (@$_SESSION["sel_Breeder_Standards_breed"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_breed"] = "";
	}

	// Get Age selected values
	if (is_array(@$_SESSION["sel_Breeder_Standards_age"])) {
		LoadSelectionFromSession('age');
	} elseif (@$_SESSION["sel_Breeder_Standards_age"] == EW_REPORT_INIT_VALUE) { // Select all
		$GLOBALS["sel_age"] = "";
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

// Clear selection stored in session
function ClearSessionSelection($parm) {
	$_SESSION["sel_Breeder_Standards_$parm"] = "";
	$_SESSION["rf_Breeder_Standards_$parm"] = "";
	$_SESSION["rt_Breeder_Standards_$parm"] = "";
}

// Load selection from session
function LoadSelectionFromSession($parm) {
	$GLOBALS["sel_$parm"] = @$_SESSION["sel_Breeder_Standards_$parm"];
	$GLOBALS["rf_$parm"] = @$_SESSION["rf_Breeder_Standards_$parm"];
	$GLOBALS["rt_$parm"] = @$_SESSION["rt_Breeder_Standards_$parm"];
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

	// Field breed
	// Setup your default values for the popup filter below, e.g.
	// $seld_breed = array("val1", "val2");

	$GLOBALS["seld_breed"] = "";
	$GLOBALS["sel_breed"] =  $GLOBALS["seld_breed"];

	// Field age
	// Setup your default values for the popup filter below, e.g.
	// $seld_age = array("val1", "val2");

	$GLOBALS["seld_age"] = "";
	$GLOBALS["sel_age"] =  $GLOBALS["seld_age"];
}

// Check if filter applied
function CheckFilter() {

	// Check breed popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_breed"], $GLOBALS["sel_breed"]))
		return TRUE;

	// Check age popup filter
	if (!ewrpt_MatchedArray($GLOBALS["seld_age"], $GLOBALS["sel_age"]))
		return TRUE;
	return FALSE;
}

// Show list of filters
function ShowFilterList() {

	// Initialize
	$sFilterList = "";

	// Field breed
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_breed"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_breed"], ", ", EW_REPORT_DATATYPE_STRING);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Breed<br />";
	if ($sExtWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
	if ($sWrk <> "")
		$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

	// Field age
	$sExtWrk = "";
	$sWrk = "";
	if (is_array($GLOBALS["sel_age"]))
		$sWrk = ewrpt_JoinArray($GLOBALS["sel_age"], ", ", EW_REPORT_DATATYPE_NUMBER);
	if ($sExtWrk <> "" || $sWrk <> "")
		$sFilterList .= "Age<br />";
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
	if (is_array($GLOBALS["sel_breed"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_breed"], "layerbreeder_standards.breed", EW_REPORT_DATATYPE_STRING, $GLOBALS["af_breed"]);
	}
	if (is_array($GLOBALS["sel_age"])) {
		if ($sWrk <> "") $sWrk .= " AND ";
		$sWrk .= ewrpt_FilterSQL($GLOBALS["sel_age"], "layerbreeder_standards.age", EW_REPORT_DATATYPE_NUMBER, $GLOBALS["af_age"]);
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
			$_SESSION["sort_Breeder_Standards_breed"] = "";
			$_SESSION["sort_Breeder_Standards_age"] = "";
			$_SESSION["sort_Breeder_Standards_livability"] = "";
			$_SESSION["sort_Breeder_Standards_ffeed"] = "";
			$_SESSION["sort_Breeder_Standards_mfeed"] = "";
			$_SESSION["sort_Breeder_Standards_fweight"] = "";
			$_SESSION["sort_Breeder_Standards_mweight"] = "";
			$_SESSION["sort_Breeder_Standards_eggwt"] = "";
			$_SESSION["sort_Breeder_Standards_productionper"] = "";
			$_SESSION["sort_Breeder_Standards_heggper"] = "";
			$_SESSION["sort_Breeder_Standards_cumhhp"] = "";
			$_SESSION["sort_Breeder_Standards_cumhhe"] = "";
			$_SESSION["sort_Breeder_Standards_eggbird"] = "";
			$_SESSION["sort_Breeder_Standards_hatchper"] = "";
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
