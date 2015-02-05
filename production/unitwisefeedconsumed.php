<?php 
include "getemployee.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 

if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$unit = $_GET['unit'];
$feedtype = $_GET['feedtype']; 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Unit Wise Feed Consumed</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Unit:</font></strong><?php echo $unit; ?>&nbsp;<strong><font color="#3e3276">Feed Type:</font></strong><?php echo $feedtype; ?></td>
</tr> 
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From: </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;<strong><font color="#3e3276">To:</font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="unitwisefeedconsumed.php?export=html&unit=<?php echo $unit; ?>&feedtype=<?php echo $feedtype; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="unitwisefeedconsumed.php?export=excel&unit=<?php echo $unit; ?>&feedtype=<?php echo $feedtype; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="unitwisefeedconsumed.php?export=word&&unit=<?php echo $unit; ?>&feedtype=<?php echo $feedtype; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="unitwisefeedconsumed.php?cmd=reset&unit=<?php echo $unit; ?>&feedtype=<?php echo $feedtype; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
<table>
 <tr>
 <td>Unit </td>
 <td>
  <select id="unit1" name="unit1" onchange="reloadpage();">
  <option value="">-Select-</option>
  <?php
 echo $query = "select distinct(unitcode) as unit from breeder_unit order by unitcode";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
   ?>
   <option value="<?php echo $rows['unit']; ?>" <?php if($unit == $rows['unit']) { ?> selected="selected" <?php } ?>><?php echo $rows['unit']; ?></option>
   <?php
  }
  ?>
  </select>
  </td>

 <td>Feed Type </td>
 <td>
  <select id="feedtype" name="feedtype" onchange="reloadpage();">
  <option value="">-Select-</option>
  <?php
  $query = "select distinct(code),description from ims_itemcodes WHERE cat IN ('Male Feed','Female Feed') order by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
   ?>
   <option value="<?php echo $rows['code']; ?>" title="<?php echo $rows['description']; ?>" <?php if($feedtype == $rows['code']) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
   <?php
  }
  ?>
  </select>
  </td> 
 <td>From:</td>  
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" size="12" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To:</td>  
 <td><input type="text" name="todate" id="todate" class="datepicker" size="12" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Feed Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Feed Consumed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Total Feed Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total Feed Consumed</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Transfer In/Purchased
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transfer In/Purchased</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Remaining
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Remaining</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$query = "select cat from ims_itemcodes where code = '$feedtype'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$cat = $rows['cat'];
$query = "select warehouse from tbl_sector where sector = '$unit'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$warehouse = $rows['warehouse'];

 $query2 = "select sum(quantity) as feed from breeder_consumption where date2 < '$fromdate' and itemcode = '$feedtype' AND flock IN (select flockcode from breeder_flock where unitcode = '$unit')";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
    $oqty = $rows2['feed'];

 $sum = 0;
 $once = 0;
$query1 = "(select distinct(date2) from breeder_consumption where flock IN (select flockcode from breeder_flock where unitcode = '$unit') and itemcode = '$feedtype' and date2 between '$fromdate' and '$todate' order by date2)";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $date = $rows1['date2'];
 if(strtotime($date) > strtotime($fromdate) && $once == 0)
 {
  $q = "select date,quantity from ims_stocktransfer where towarehouse = '$warehouse' and code = '$feedtype' and date >= '$fromdate' and date < '$date' ORDER BY date";
  $r = mysql_query($q,$conn1) or die(mysql_error());
  while($rr = mysql_fetch_assoc($r))
  {
   $date1 = $rr['date'];
   $qty = $rr['quantity'];
   $grandqty += $qty;
 $query2 = "select sum(quantity) as qty from ims_stocktransfer where date < '$date1' and towarehouse = '$warehouse' and code = '$feedtype'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $trin= $rows2['qty'];
 $query2 = "select sum(quantity) as qty from ims_stocktransfer where date < '$date1' and fromwarehouse = '$warehouse' and code = '$feedtype'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $trout= $rows2['qty'];
 $remaining = round(($trin - $oqty - $trout + $qty),2);	 
   
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($date1))); ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right" >
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue($rr['quantity']); ?></td>
		<td class="ewRptGrpField3" align="right" >
<?php echo ewrpt_ViewValue($remaining); ?></td>
	</tr>
<?php
  
  }
 }
 $once = 1;
 $sum1 = 0;
 $flock = ""; $feed = "";
 $query2 = "select flock,quantity from breeder_consumption where date2 = '$date' and itemcode = '$feedtype' and flock IN (select flockcode from breeder_flock where unitcode = '$unit') order by flock";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $flock .= $rows2['flock']."/";
  $qty = $rows2['quantity'];
  $feed .= $qty."/";
  $sum += $qty;
  $sum1 += $qty;
  $grandsum += $qty;
  $qty = changeprice($rows2['quantity']);
 }
 $flock = substr($flock,0,-1);
 $feed = substr($feed,0,-1);
 $query2 = "select sum(quantity) as qty from ims_stocktransfer where date = '$date' and towarehouse = '$warehouse' and code = '$feedtype'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $qty = $rows2['qty'];
	if($qty == "")
	 $qty = 0;
 $trin = $trout =0;	
 $stadd = $stded = 0;
 $grandqty += $qty; 
 $query2 = "select sum(quantity) as qty from ims_stocktransfer where date < '$date' and towarehouse = '$warehouse' and code = '$feedtype'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $trin= $rows2['qty'];
 $query2 = "select sum(quantity) as qty from ims_stocktransfer where date < '$date' and fromwarehouse = '$warehouse' and code = '$feedtype'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $trout= $rows2['qty'];
  $query2 = "SELECT SUM(quantity) as qty FROM ims_stockadjustment WHERE code = '$feedtype' AND date < '$date' AND unit = '$warehouse' and type = 'Add'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $stadd = $rows2['qty'];
 $query2 = "SELECT SUM(quantity) as qty FROM ims_stockadjustment WHERE code = '$feedtype' AND date < '$date' AND unit = '$warehouse' and type = 'Deduct'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $stded = $rows2['qty'];
// echo $date."/".$trin."/".$sum."/".$oqty."/".$trout."/".$qty;
 $remaining = round(($trin - $sum - $oqty - $trout + $qty + $stadd - $stded),2);	 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($date))); ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($flock); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($feed); ?></td>
		<td class="ewRptGrpField1" align="right" >
<?php echo ewrpt_ViewValue(changeprice($sum1)); ?></td>
		<td class="ewRptGrpField2" align="right">
<?php if($qty <> "") { echo ewrpt_ViewValue(changeprice($qty)); } else { echo "0.00"; } ?></td>
		<td class="ewRptGrpField3" align="right" >
<?php echo ewrpt_ViewValue(changeprice($remaining)); ?></td>
	</tr>
<?php
}
?>
	<tr>
		<td class="ewRptGrpField3" align="right" colspan="3">
<?php echo ewrpt_ViewValue("Grand Total"); ?></td>
		<td class="ewRptGrpField1" align="right" >
<?php echo ewrpt_ViewValue(changeprice($grandsum)); ?></td>
		<td class="ewRptGrpField2" align="right">
<?php if($grandqty <> "") { echo ewrpt_ViewValue(changeprice($grandqty)); } else { echo "0.00"; }?></td>
		<td class="ewRptGrpField3" align="right" >
<?php echo ewrpt_ViewValue(changeprice($remaining)); ?></td>
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
	var unitcode = document.getElementById('unit1').value;
	var feedtype = document.getElementById('feedtype').value;
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	if(unitcode != "" && feedtype != "")
	document.location = "unitwisefeedconsumed.php?unit="+unitcode + "&feedtype=" + feedtype + "&fromdate=" + fdate + "&todate=" + tdate;
}
</script>