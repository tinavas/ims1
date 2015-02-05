


<?php 
include "config.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">&nbsp;Medicine/Vaccine Consumption of Flock <?php echo $flock;?></font></strong></td>
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
&nbsp;&nbsp;<a href="medvac.php?flock=<?php echo $flock;?>&export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="medvac.php?flock=<?php echo $flock;?>&export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="medvac.php?flock=<?php echo $flock;?>&export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="medvac.php?cmd=reset&flock=<?php echo $flock; ?>">Reset All Filters</a>
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
		Medicine/Vaccine
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Medicine/Vaccine</td>
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
		Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Consumption</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center" title="Average Cost">
		Avg. Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader"  title="Average Cost">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Avg. Cost</td>
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
$date = "";$odate = "";$fdate = "";$cdate = "";
$totmedvaccost = 0;
$totmedvac = 0;
  $query = "select date2,itemdesc,itemcode,sum(quantity) as quantity,units from breeder_consumption where flock LIKE '%$flock' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat In ('Medicines','Vaccines')) And client = '$client' group by date2,itemcode order by date2";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))	
{ 
 $qua=$res['quantity'];
$date = date("d.m.Y",strtotime($res['date2']));
$medvac = $res['itemcode'];
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
$medvaccost  = 0;
 $query2 = "SELECT avg(rateperunit) as medvaccost FROM pp_sobi WHERE code = '$medvac' AND client = '$client'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$rows2 = mysql_fetch_assoc($result2);
if($rows2['medvaccost'])
{
  $medvaccost = $rows2['medvaccost'];
}
else
{
 $query = "select sum(amount)/sum(quantity) as avgprice from ac_financialpostings where crdr = 'Dr' and itemcode = '$medvac'";
$mvresult = mysql_query($query,$conn1) or die(mysql_error());
$mvres = mysql_fetch_assoc($mvresult);
 $medvaccost = $mvres['avgprice'];
}
if($medvaccost == "") { $medvaccost = 0;}
 $totmedvaccost = $totmedvaccost + round(($medvaccost*$res['quantity']),3);

$totmedvac = $totmedvac + $res['quantity'];
?>
	<tr>
<td class="ewRptGrpField1"><?php echo $cdate; ?></td>
<td><?php echo $res['itemdesc']; ?></td>		
<td><?php echo $res['itemcode']; ?></td>
<td align="right"><?php  echo changeprice(round(($res['quantity']),3)); ?></td>
<td><?php echo $res['units']; ?></td>
<td align="right"><?php echo changeprice(round($medvaccost,3)); ?></td>
<td align="right"><?php echo changeprice(round(($medvaccost*$res['quantity']),2)); ?></td>

	</tr>
<?php
//$i++;
}
?>
	<tr>
<td class="ewRptGrpField1"><b>TOTAL</b></td>
<td>&nbsp;</td>		
<td>&nbsp;</td>	
<td align="right"><?php echo changeprice(round($totmedvac,5)); ?></td>	
<td>&nbsp;</td>	
<td>&nbsp;</td>	
<td align="right"><?php echo changeprice(round($totmedvaccost,5)); ?></td>

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
