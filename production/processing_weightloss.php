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
 <td colspan="2" align="center"><strong><font color="#3e3276">Processing Weight Loss Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

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
&nbsp;&nbsp;<a href="processing_weightloss.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="processing_weightloss.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="processing_weightloss.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="processing_weightloss.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
		Processed Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Processed Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sale Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sale Weight</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight Difference
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight Difference</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight Loss %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight Loss %</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$query = "SELECT distinct(date) FROM chicken_chickentransfer WHERE date BETWEEN '$fromdate' AND '$todate' ORDER BY date";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
 $date = $rows['date'];
 $weight = 0;
$query1 = "SELECT distinct(tid),weight FROM chicken_chickentransfer WHERE date = '$date' GROUP BY tid,id";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
 $weight += $rows1['weight'];
$pweight = 0; 

$query1 = "SELECT SUM(kgs) AS kgs,todescription FROM chicken_chickentransfer WHERE date = '$date' GROUP BY todescription";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
  if($rows1['todescription'] == 'BONE LESS')
   $pweight += ($rows1['kgs'] * 277.78 / 100);		// We are adding 177.78% extra weight
  elseif($rows1['todescription'] == 'DRESSED WITH SKIN')
   $pweight += ($rows1['kgs'] * 153.14 / 100);		// We are adding 53.14% extra weight
  elseif($rows1['todescription'] == 'SKIN LESS')
   $pweight += ($rows1['kgs'] * 173.92 / 100);		// We are adding 73.92% extra weight
  else
   $pweight += $rows1['kgs'];
} 

$weightloss = ($weight - $pweight) /$weight * 100;
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($date))); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($weight)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($pweight)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($weight - $pweight)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($weightloss)); ?></td>
	</tr>
<?php
}
?>
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "processing_weightloss.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>