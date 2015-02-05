<?php 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Errors in Financialpostings</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>Date : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?></td>
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
<?php if (@$sExport == "") { 
	
	$url = "&fromdate=" . $fromdate . "&todate=" . $todate ;
	
	
	
	?>
&nbsp;&nbsp;<a href="postingserrors.php?export=html<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="postingserrors.php?export=excel<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="postingserrors.php?export=word<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="postingserrors.php?cmd=reset<?php echo $url; ?>">Reset All Filters</a>
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
 <td> From Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td> To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
		Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Tr. No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Tr. No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Cr Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Cr Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Dr Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Dr Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
	<tr><td colspan="5" align="center"><b>The following are Cr-Amount and Dr-Amount are not matching</b></td></tr>
<?php 
$query1 = "SELECT distinct(date) FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client' ORDER BY date";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
  $date = $rows1['date'];
 $query2 = "SELECT sum(amount) as cramount1 FROM ac_financialpostings WHERE date = '$date' AND crdr = 'Cr' AND client = '$client'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $cramount1 = $rows2['cramount1'];
 $cramount1=round($cramount1,4);
 $query2 = "SELECT sum(amount) as dramount1 FROM ac_financialpostings WHERE date = '$date' AND crdr = 'Dr' AND client = '$client'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $dramount1 = $rows2['dramount1'];
 $dramount1=round($dramount1,4);
 if($cramount1 <> $dramount1)
 {
  $query3 = "SELECT distinct(type) FROM ac_financialpostings WHERE date = '$date' AND client = '$client' ORDER BY type";
  $result3 = mysql_query($query3,$conn1) or die(mysql_error());
  while($rows3 = mysql_fetch_assoc($result3))
  { 
   $type = $rows3['type'];
   if($type == 'Consumption' or $type == 'Production' or $type == 'CONSUMPTION' or $type == 'PRODUCTION')
    $cond1 = "(type LIKE 'Consumption' or type LIKE 'Production')";
   elseif($type == 'Feed Produced' or $type == 'Item Consumed' or $type == 'FEED PRODUCED' or $type == 'ITEM CONSUMED')
    $cond1 = "(type LIKE 'Feed Produced' or type LIKE 'Item Consumed')";
   else if($type == 'LB Production' or $type ==  'LB Consumption')
    $cond1 = "(type LIKE 'LB Production' or type LIKE 'LB Consumption')";
   else
    $cond1 = "type = '$type'";	
   $query2 = "SELECT sum(amount) as cramount1 FROM ac_financialpostings WHERE date = '$date' AND $cond1 AND crdr = 'Cr' AND client = '$client'";
   $result2 = mysql_query($query2,$conn1) or die(mysql_error());
   $rows2 = mysql_fetch_assoc($result2);
   $cramount2 = $rows2['cramount1'];
   $cramount2=round($cramount2,4);
   $query2 = "SELECT sum(amount) as dramount1 FROM ac_financialpostings WHERE date = '$date' AND $cond1 AND crdr = 'Dr' AND client = '$client'";
   $result2 = mysql_query($query2,$conn1) or die(mysql_error());
   $rows2 = mysql_fetch_assoc($result2);
   $dramount2 = $rows2['dramount1'];
   $dramount2=round($dramount2,4);
   if($cramount2 <> $dramount2)
   { 
    $query4 = "SELECT distinct(trnum) FROM ac_financialpostings WHERE date = '$date' AND $cond1 AND client = '$client' ORDER BY trnum";
	$result4 = mysql_query($query4,$conn1) or die(mysql_error());
	while($rows4 = mysql_fetch_assoc($result4))
	{
	 $trnum = $rows4['trnum'];
     $query2 = "SELECT sum(amount) as cramount1 FROM ac_financialpostings WHERE date = '$date' AND $cond1 AND trnum = '$trnum' AND crdr = 'Cr' AND client = '$client'";
     $result2 = mysql_query($query2,$conn1) or die(mysql_error());
     $rows2 = mysql_fetch_assoc($result2);
     $cramount3 = $rows2['cramount1'];
	 $cramount3=round($cramount3,4);
     $query2 = "SELECT sum(amount) as dramount1 FROM ac_financialpostings WHERE date = '$date' AND $cond1 AND trnum = '$trnum' AND crdr = 'Dr' AND client = '$client'";
     $result2 = mysql_query($query2,$conn1) or die(mysql_error());
     $rows2 = mysql_fetch_assoc($result2);
     $dramount3 = $rows2['dramount1'];
	 $dramount3=round($dramount3,4);
	 if($cramount3 <> $dramount3)
	 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($type); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($trnum); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($cramount3); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($dramount3); ?></td>
	</tr>
<?php
	 }//end of if-3
	}//end of rows4
   }//end of if-2
  }	//end of rows3
 }	//end of if-1
}	//end of rows1
?>
<tr><td colspan="5" align="center"><b>The following are COA Codes are Empty</b></td></tr>
<?php
$query = "SELECT * FROM ac_financialpostings WHERE coacode = '' AND date BETWEEN '$fromdate' AND '$todate' ORDER BY date";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 ?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['type']); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['trnum']); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['crdr']); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['dramount']); ?></td>
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
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "postingserrors.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>