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
if($_GET['alert'] == "")
 $alerttype = "vaccination";
else
 $alerttype = $_GET['alert'];
if($alerttype == "stock") $heading = "Stock Alerts Report";
elseif($alerttype == "vaccination") $heading = "Vaccination Alerts Report";

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
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276"><?php echo $heading; ?></font></strong></td>
</tr>
</table>


<?php

// Get page start time
$starttime = ewrpt_microtime();

// Open connection to the database
$conn = ewrpt_Connect();

// Table level constants
define("EW_REPORT_TABLE_VAR", "farm", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "farm_grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "farm_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "farm_search", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "farm_childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_ORDER_BY", "farm_orderby", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "breeder_farm";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT breeder_farm.code, breeder_farm.description, breeder_farm.capacity FROM " . $EW_REPORT_TABLE_SQL_FROM;
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
$af_code = NULL; // Popup filter for code
$af_description = NULL; // Popup filter for description
$af_capacity = NULL; // Popup filter for capacity
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
$x_code = NULL;
$x_description = NULL;
$x_capacity = NULL;

// Detail variables
$o_code = NULL; $t_code = NULL; $ft_code = 200; $rf_code = NULL; $rt_code = NULL;
$o_description = NULL; $t_description = NULL; $ft_description = 201; $rf_description = NULL; $rt_description = NULL;
$o_capacity = NULL; $t_capacity = NULL; $ft_capacity = 5; $rf_capacity = NULL; $rt_capacity = NULL;
?>
<?php

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 4;
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
$col = array(FALSE, FALSE, FALSE, FALSE);

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
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="alertsreport.php?export=html&alert=<?php echo $alerttype; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="alertsreport.php?export=excel&alert=<?php echo $alerttype; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="alertsreport.php?export=word&alert=<?php echo $alerttype; ?>">Export to Word</a>
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
<select id="alerttype" name="alerttype" onChange="reloadpage();">
<option value="">-Select-</option>
<option value="stock" title="Stock" <?php if($alerttype == 'stock') echo "selected='selected'"?>>Stock</option>
<?php
if($_SESSION['client'] == 'FEEDATIVES')
{
?>
<option value="purchase" title="Purchase Order- Pendiing" <?php if($alerttype == 'purchase') echo "selected='selected'"?>>Purchase Order</option>
<option value="payments" title="Payments" <?php if($alerttype == 'payments') echo "selected='selected'"?>>Payments</option>
<?php
}
?>

<!--<option value="receipts" title="Receipts" <?php //if($alerttype == 'receipts') echo "selected='selected'"?>>Receipts</option>-->
<option value="vaccination" title="Vaccination" <?php if($alerttype == 'vaccination') echo "selected='selected'"?>>Vaccination</option>

</select>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">
<?php


?>
<?php
if($alerttype == "stock")
{
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Minimum Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Minimum Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Available Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Available Quantity</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
		
	<tbody>

<?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user'];
						 $count = 0; $count1 = 0; $count2 = 0;
                         $query1 = "SELECT * FROM common_alerts"; 
                         $result1 = mysql_query($query1,$conn1); 
                         while($row1 = mysql_fetch_assoc($result1)) 
                         {
						  if($row1['type'] == "Ingredients")
						  {
						  $minqty = $row1['minqty'] * 1000;
						  $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity < '$minqty'"; 
						  }
						  else
						  {
						  $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity < '$row1[minqty]'"; 
						  }
                            
                            $result11 = mysql_query($query11,$conn1); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) { 
							  $count1 = $count1 + 1; ?>
							  	<tr>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
								
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row1['item']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row1['minqty']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row11['quantity']; ?>
</td>
	</tr>
					<?php
							   }
                            }
                            if($row1['type'] == "Ingredients")
							{$maxqty = $row1['maxqty'] * 1000;
							 $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity > '$row1[maxqty]'"; 
							}
							else
							{
							 $query11 = "SELECT sum(quantity) as 'quantity' FROM ims_stock where itemcode = '$row1[item]' and quantity > '$row1[maxqty]'"; 
							}
                           
                            $result11 = mysql_query($query11,$conn1); 
                            while($row11 = mysql_fetch_assoc($result11)) 
                            {
                              if(!is_null($row11['quantity'])) { $count2 = $count2 + 1; 
							   ?>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
							   
                            	<tr>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row1['item']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row1['maxqty']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $row11['quantity']; ?>
</td>
	</tr>
<?php }
                            }

 
                         }
						 
						 ?>

<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
	//$nGrpCount++; ?>

<?php
$count = $count1 + $count2;
if($count == 0)
{ ?><tr><td colspan="3">No records found</tr> <?php }
 } 	//End of if alerttype = stock ?>	

<?php
if($alerttype == "purchase")
{
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Purchase Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchase Order</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Delivery Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Delivery Date</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
		
	<tbody>

<?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user']; 
						 $count = 0;
						
					    $fromdate = date("Y-m-j");
						$to_date = strtotime($fromdate) + 7 * 24 * 60 * 60;
						$todate = date("Y-m-j",$to_date);
					    $query1 = "SELECT po,description,deliverydate FROM pp_purchaseorder WHERE deliverydate >= '$fromdate' AND deliverydate <= '$todate' AND client = '$client' ORDER BY deliverydate ASC";
						$result1 = mysql_query($query1,$conn1) or die(mysql_error());
						while($rows1 = mysql_fetch_assoc($result1))
						{
							
							$count++; ?>
							  	<tr>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
								
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['po']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['description']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo date("d-m-Y",strtotime($rows1['deliverydate'])); ?>
</td>
	</tr>
							
<?php							
						}
						

						 
						 ?>

<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
	//$nGrpCount++; ?>

<?php
if($count == 0)
{ ?><tr><td colspan="3">No records found</tr> <?php }
 } 	//End of if alerttype = purchase ?>
 
 <?php
if($alerttype == "vaccination")
{
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
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
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
		
	<tbody>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>

<?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user']; 
						 					    $count = 0;
					    $fromdate = date("Y-m-j");
						$to_date = strtotime($fromdate) + 7 * 24 * 60 * 60;
						$todate = date("Y-m-j",$to_date);
					   $query1 = "SELECT vaccode,flock,date FROM breeder_flockvacschedule WHERE date >= '$fromdate' AND date <= '$todate' AND client = '$client' ORDER BY date ASC";
						$result1 = mysql_query($query1,$conn1);
						while($rows1 = mysql_fetch_assoc($result1))
						{
							$query2 = "SELECT description FROM ims_itemcodes WHERE code = '$rows1[vaccode]' AND client = '$client'";
							$result2 = mysql_query($query2,$conn1);
							$rows2 = mysql_fetch_assoc($result2);
							
							$count++; ?>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
							
		<tr>					
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows2['description']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['flock']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo date("d-m-Y",strtotime($rows1['date'])); ?>
</td>
	</tr>

							
<?php						}
						
						 
						 ?>

<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
	//$nGrpCount++; ?>

<?php
if($count == 0)
{ ?><tr><td colspan="3">No records found</tr> <?php }
 } 	//End of if alerttype = vaccination ?>
 
 <?php
if($alerttype == "payments")
{
?>
	<thead>
	<tr>
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
		Purchase Order Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchase Order Cost</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Credit Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Credit Date</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
		
	<tbody>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>

<?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user']; 
					    $count = 0;

						$fromdate = date("Y-m-d");
						$to_date = strtotime($fromdate) + 7 * 24 * 60 * 60;
						$todate = date("Y-m-d",$to_date);
										
				$query1 = "SELECT distinct(so), pocost,vendor,creditdate FROM pp_sobi WHERE creditdate > '$fromdate' AND creditdate < '$todate' AND client = '$client' ORDER BY creditdate ASC";
						$result1 = mysql_query($query1,$conn1) or die(mysql_error());
						while($rows1 = mysql_fetch_assoc($result1))
						{
						  	
							$poindex++;
							$count5++;
							$vendor1[$poindex] = $rows1['vendor'];
							$pocost1[$poindex] = $rows1['pocost'];
							
							$creditdate[$poindex] = date("d-m-Y",strtotime($rows1['creditdate']));
							
							$count++; ?>
		<tr>					
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['vendor']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['pocost']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo date("d-m-Y",strtotime($rows1['creditdate'])); ?>
</td>
	</tr>

							
<?php						}
						
						 
						 ?>

<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
	//$nGrpCount++; ?>

<?php
if($count == 0)
{ ?><tr><td colspan="3">No records found</tr> <?php }
 } 	//End of if alerttype =payments ?>
 
  <?php
if($alerttype == "receipts")
{
?>
	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
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
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
		
	<tbody>
<?php
		//$bShowFirstHeader = FALSE;
	
	$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>

<?php
                         include "config.php"; session_start(); $user = $_SESSION['valid_user']; 
						 					    $count = 0;
					    $fromdate = date("Y-m-j");
						$to_date = strtotime($fromdate) + 7 * 24 * 60 * 60;
						$todate = date("Y-m-j",$to_date);
					   $query1 = "SELECT vaccode,flock,date FROM breeder_flockvacschedule WHERE date >= '$fromdate' AND date <= '$todate' AND client = '$client' ORDER BY date ASC";
						$result1 = mysql_query($query1,$conn1);
						while($rows1 = mysql_fetch_assoc($result1))
						{
							$query2 = "SELECT description FROM ims_itemcodes WHERE code = '$rows1[vaccode]' AND client = '$client'";
							$result2 = mysql_query($query2,$conn1);
							$rows2 = mysql_fetch_assoc($result2);
							
							$count++; ?>
		<tr>					
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows2['description']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo $rows1['flock']; ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo date("d-m-Y",strtotime($rows1['date'])); ?>
</td>
	</tr>

							
<?php						}
						
						 
						 ?>

<?php

		// Accumulate page summary
		//AccumulateSummary();

		// Get next record
		//GetRow(2);
	//$nGrpCount++; ?>

<?php
if($count == 0)
{ ?><tr><td colspan="3">No records found</tr> <?php }
 } 	//End of if alerttype =receipts ?> 
 
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
		$GLOBALS['x_code'] = $rs->fields('code');
		$GLOBALS['x_description'] = $rs->fields('description');
		$GLOBALS['x_capacity'] = $rs->fields('capacity');
		$val[1] = $GLOBALS['x_code'];
		$val[2] = $GLOBALS['x_description'];
		$val[3] = $GLOBALS['x_capacity'];
	} else {
		$GLOBALS['x_code'] = "";
		$GLOBALS['x_description'] = "";
		$GLOBALS['x_capacity'] = "";
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
			$_SESSION["sort_farm_code"] = "";
			$_SESSION["sort_farm_description"] = "";
			$_SESSION["sort_farm_capacity"] = "";
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
		@$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY] = "breeder_farm.code ASC";
		$_SESSION["sort_farm_code"] = "ASC";
	}
	return @$_SESSION[EW_REPORT_TABLE_SESSION_ORDER_BY];
}
?>


<script type="text/javascript">
function reloadpage()
{
	
	var alerttype = document.getElementById('alerttype').value;
	document.location = "alertsreport.php?alert=" + alerttype;
}
</script>
