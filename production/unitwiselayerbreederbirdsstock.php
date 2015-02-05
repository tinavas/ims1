<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";

if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 

//echo $cat; echo $warehouse; echo $fromdate; echo $todate;

$url = "&fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $_GET['cat'];
$url1 = "?fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $_GET['cat'];
 
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
<?php include "phprptinc/header.php"; ?>
<table align="center" border="0">
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Layer Breeder House wise Breeder Birds Stock Report from &nbsp;<?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;to&nbsp;<?php echo date("d.m.Y",strtotime($todate)); ?></font></strong></td>
</tr>
</table>


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
	header('Content-Disposition: attachment; filename=House wise Layer Breeder Birds Stock.xls');
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
&nbsp;&nbsp;<a href="unitwiselayerbreederbirdsstock.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="unitwiselayerbreederbirdsstock.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="unitwiselayerbreederbirdsstock.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="unitwiselayerbreederbirdsstock.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
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

<table class="ewGrid" cellspacing="0" align="center"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">

From Date&nbsp;
<input type="text" size="15" id="fromdate" name="fromdate" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;
To Date&nbsp;
<input type="text" size="15" id="todate" name="todate" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" class="datepicker" onchange="reloadpage();"/>
&nbsp;&nbsp;&nbsp;

</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		House
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>House</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
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
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Sunits
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sunits</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Opening</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Purchased
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Purchased</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Consumed</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Sold
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Sold</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" colspan="2">
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Closing</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewRptGrpHeader1">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>			
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td></td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
<?php } ?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
<?php } ?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
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
$query0 = "SELECT shedcode,warehouse FROM layerbreeder_shed ORDER BY shedcode";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
while($rows0 = mysql_fetch_assoc($result0))
{
 $warehouse = $rows0['warehouse'];
 $shedcode = $rows0['shedcode'];
 
 $unitobqty = $unitobamt = $unitpurqty = $unitpuramt = $unitconsumedqty = $unitconsumedamt = $unitsoldqty = $unitsoldamt = $unitcbqty = $unitcbamt = 0;
$query = "SELECT code,description,sunits,iac FROM ims_itemcodes WHERE cat IN ('LB Male Birds','LB Female Birds') ORDER BY code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $code = $rows['code'];
 $description = $rows['description'];
 $sunits = $rows['sunits'];
 $itemcode = $rows['iac'];
$preissueqty = 0;
$prercvqty = 0;
$preissueamt = $prercvamt = 0;

	//Issues
 $q = "select SUM(quantity) AS quantity, SUM(amount) AS amount from ac_financialpostings where date < '$fromdate' and coacode = '$itemcode' and itemcode  = '$code' and warehouse = '$warehouse' AND crdr = 'Cr' order by date ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
 $preissueqty = $preissueqty + $qr['quantity'];
 $preissueamt += $qr['amount']; 
   // Receipts 
 $q = "select SUM(quantity) AS quantity, SUM(amount) AS amount from ac_financialpostings where date < '$fromdate' and coacode = '$itemcode' and itemcode  = '$code' and warehouse = '$warehouse' AND crdr = 'Dr' order by date ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
 $prercvqty = $prercvqty + $qr['quantity'];
 $prercvamt += $qr['amount'];
 
	$opening = $prercvqty - $preissueqty;
    $openingamt = $prercvamt - $preissueamt;
 
	//Purchased
$q = "select SUM(quantity) AS quantity, SUM(amount) AS amount from ac_financialpostings where date BETWEEN '$fromdate' AND '$todate' and coacode = '$itemcode' and itemcode  = '$code' and warehouse = '$warehouse' AND crdr = 'Dr' order by date ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
 $purchased = $qr['quantity'];
 $purchasedamt = $qr['amount'];
   // Consumed 
$q = "select SUM(quantity) AS quantity, SUM(amount) AS amount from ac_financialpostings where date BETWEEN '$fromdate' AND '$todate' and coacode = '$itemcode' and itemcode  = '$code' and warehouse = '$warehouse' AND type NOT IN ('COBI','PS') AND crdr = 'Cr' order by date ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
 $consumed = $qr['quantity'];
 $consumedamt = $qr['amount'];

    // Sold 
$q = "select SUM(quantity) AS quantity, SUM(amount) AS amount from ac_financialpostings where date BETWEEN '$fromdate' AND '$todate' and coacode = '$itemcode' and itemcode  = '$code' and warehouse = '$warehouse' AND type IN ('COBI','PS') AND crdr = 'Cr' order by date ";
$qrs = mysql_query($q,$conn1) or die(mysql_error());
$qr = mysql_fetch_assoc($qrs);
 $sold = $qr['quantity'];
 $soldamt = $qr['amount'];

 $closing = $opening + $purchased - ($consumed + $sold);
 $closingamt = $openingamt + $purchasedamt - ($consumedamt + $soldamt);
if(( $opening  == 0) && ( $purchased  == 0) && ( $closing  == 0) && ( $consumed  == 0) && ( $sales  == 0))
{
}
else {
if($prevwarehouse == $warehouse)
{ $diswarehouse = ""; $disshed = ""; }
else
{ $diswarehouse = $warehouse; $disshed = $shedcode; }
?>
	<tr>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($disshed) ?>
		</td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($code) ?>
		<?php $x_code = $t_code; ?></td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($description) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($sunits) ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice1(round($opening,2)); $totalopening += $opening; 
$unitobqty += round($opening,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice(round($openingamt,2)); $totalopeningamt += round($openingamt,2); 
$unitobamt += round($openingamt,2); ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice1(round($purchased,2)); $totalpurchased += $purchased; 
$unitpurqty += round($purchased,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice(round($purchasedamt,2)); $totalpurchasedamt += round($purchasedamt,2);  $unitpuramt += round($purchasedamt,2); ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice1(round($consumed,2)); $totalconsumed += $consumed; 
$unitconsumedqty += round($consumed,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice(round($consumedamt,2)); $totalconsumedamt += round($consumedamt,2);
$unitconsumedamt += round($consumedamt,2);  ?>
</td>

<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice1(round($sold,2)); $totalsold += $sold; 
$soldqty += round($sold,2); ?>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice(round($soldamt,2)); $totalsoldamt += round($soldamt,2); 
$soldamt += round($soldamt,2); ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice1(round(($closing),2)); $unitcbqty += round($closing,2); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;">
<?php echo changeprice(round(($closingamt),2)); $unitcbamt += round($closingamt,2); ?>
</td>

	</tr>
	<?php
	$prevwarehouse = $warehouse;
	}
	}
	if(!($unitobqty == 0 && $unitpurqty ==0 && $unitconsumedqty == 0 && $unitsoldqty == 0))
	{
	?>
	<tr>
		<td class="ewRptGrpField1" colspan="4" align="right"><b>
<?php echo ewrpt_ViewValue("$shedcode ( $warehouse ) Total") ?></b></td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($unitobqty,2)); ?></b>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($unitobamt,2)); ?></b>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($unitpurqty,2)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($unitpuramt,2)); ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($unitconsumedqty,2)); ?></b>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($unitconsumedamt,2)); ?></b>
</td>

<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($unitsoldqty,2)); ?></b>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($unitsoldamt,2)); ?></b>
</td>
<?php $unitclosing = $unitobqty + $unitpurqty - $unitconsumedqty - $unitsoldqty; ?>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round(($unitcbqty),2)); ?></b>
</td>
<?php $unitclosingamt = $unitobamt + $unitpuramt - $unitconsumedamt - $unitsoldamt; ?>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round(($unitcbamt),2)); ?></b>
</td>

	</tr>	
	<?php 
	}
	}
?>

	<tr>
		<td class="ewRptGrpField1" colspan="4" align="right"><b>
<?php echo ewrpt_ViewValue("Grand Total") ?></b></td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($totalopening,2)); ?></b>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($totalopeningamt,2)); ?></b>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($totalpurchased,2)); ?>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($totalpurchasedamt,2)); ?>
</td>

		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($totalconsumed,2)); ?></b>
</td>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($totalconsumedamt,2)); ?></b>
</td>

<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round($totalsold,2)); ?></b>
</td>
<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round($totalsoldamt,2)); ?></b>
</td>
<?php $totalclosing = $totalopening + $totalpurchased - $totalconsumed - $totalsold; ?>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice1(round(($totalclosing),2)); ?></b>
</td>
<?php $totalclosingamt = $totalopeningamt + $totalpurchasedamt - $totalconsumedamt - $totalsoldamt; ?>
		<td<?php echo $sItemRowClass; ?> style="text-align:right;"><b>
<?php echo changeprice(round(($totalclosingamt),2)); ?></b>
</td>

	</tr>

	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
var dt1  = parseInt(fromdate.substring(0,2),10); 
var mon1 = parseInt(fromdate.substring(3,5),10);
var yr1  = parseInt(fromdate.substring(6,10),10); 
var dt2  = parseInt(todate.substring(0,2),10); 
var mon2 = parseInt(todate.substring(3,5),10); 
var yr2  = parseInt(todate.substring(6,10),10); 
var date1 = new Date(yr1, mon1, dt1); 
var date2 = new Date(yr2, mon2, dt2); 

if(Date.parse(date1) <= Date.parse(date2))
	{
	document.location = "unitwiselayerbreederbirdsstock.php?fromdate=" + fromdate + "&todate=" + todate;
	}
	else
	{
	alert("From Date should be less than To Date");
document.getElementById('fromdate').focus();
}
}

</script>