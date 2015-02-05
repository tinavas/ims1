


<?php 
include "config.php";
include "reportheader.php";
$sExport = @$_GET["export"]; 

include "getemployee.php"; 
$flock = $_GET['flock'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">&nbsp;Revenue from Sale Of Eggs of Flock <?php echo $flock;?></font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>&nbsp; </strong></td>
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
	header('Content-Disposition: attachment; filename=' . EW_REPORT_TABLE_VAR .'.xls');
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
&nbsp;&nbsp;<a href="revenue.php?flock=<?php echo $flock;?>&export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="revenue.php?flock=<?php echo $flock;?>&export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="revenue.php?flock=<?php echo $flock;?>&export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="revenue.php?cmd=reset&flock=<?php echo $flock; ?>">Reset All Filters</a>
<?php } ?>
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

<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Egg Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Egg Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php /*if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Units</td>
			</tr></table>
		</td>
<?php }*/ ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center" title="Average Cost">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Average Cost">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Price</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
	<?php 
	

	 
//$i =0;	
//$preshed = "";
$date = "";$odate = "";$fdate = "";$cdate = "";$totcost = 0;$totqty = 0;

$query = "SELECT date,sum(quantity) as qty,price,sum(quantity*price) as amt, code,description,units FROM oc_cobi WHERE flock like  '%$flock' and code  IN (SELECT code FROM ims_itemcodes WHERE cat LIKE '%Eggs') AND client = '$client' and price <> 0  group by date order by date";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))	
{ 
$amt = 0;$qty= 0;$price = 0;
$date = date("d.m.Y",strtotime($res['date']));
$eggcode = $res['code'];
$eggdesc = $res['description'];
$qty = $res['qty'];
$price = $res['price'];
$amt = $res['amt'];
if($fdate == "")
{
$fdate = $date;
$odate = $date;
$cdate = $date;
}
else
{
if($odate == $date)
{ 
$cdate = "";
}
else
{
$odate = $date;
$cdate = $date;
}
}
$totqty  = $totqty + $qty;
$totcost = $totcost + $amt;
if(($cdate >= '01.04.2012') and ($price > 0)){
?>
	<tr>
<td class="ewRptGrpField1"><?php echo $cdate; ?></td>
<td><?php echo $eggdesc; ?></td>		
<td><?php echo $eggcode; ?></td>
<td align="right"><?php echo changequantity(round($qty,2)); ?></td>
<?php /*?><td><?php echo $res['units']; ?></td><?php */?>
<td align="right"><?php echo changeprice(round($price,2)); ?></td>
<td align="right"><?php echo changeprice(round($amt,2)); ?></td>

	</tr>
<?php
}
//$i++;
}
?>
	<tr>
<td class="ewRptGrpField1"><b>TOTAL</b></td>
<td>&nbsp;</td>		
<td>&nbsp;</td>	
<td align="right"><?php echo changequantity(round($totqty,2)); ?></td>
<td>&nbsp;</td>	
<td align="right"><?php echo changeprice(round($totcost,2)); ?></td>

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
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
