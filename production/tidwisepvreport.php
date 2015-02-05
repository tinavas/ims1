<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";

if($_GET['from'] <> "")
 $from = date("Y-m-d",strtotime($_GET['from']));
else
 $from = date("Y-m-d");
if($_GET['to'] <> "")
 $to = date("Y-m-d",strtotime($_GET['to']));
else
 $to = date("Y-m-d"); 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Payment Vouchers Summary</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date :</font></strong><?php echo date("d.m.Y",strtotime($from)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date :</font></strong><?php echo date("d.m.Y",strtotime($to)); ?></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>
<?php $temp = time() + ((5 * 60 * 60) + ( 30 * 60 ));	// It is to calculate the present time
$ptime = date("d.m.Y H:i:s",$temp);	
?>
<!--<center><p style="padding-left:300px;"> Report Time Stamp: <b><?php echo $ptime;?></b></p></center>
-->
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
&nbsp;&nbsp;<a href="tidwisepvreport.php?export=html&from=<?php echo $from; ?>&to=<?php echo $to; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="tidwisepvreport.php?export=excel&from=<?php echo $from; ?>&to=<?php echo $to; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="tidwisepvreport.php?export=word&from=<?php echo $from; ?>&to=<?php echo $to; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="tidwiservreport.php?cmd=reset&from=<?php echo $from; ?>&to=<?php echo $to; ?>">Reset All Filters</a>
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
 <td>From Date</td>
 <td><input type="text" name="from" id="from" size="11" class="datepicker" value="<?php echo date("d.m.Y",strtotime($from)); ?>"  onchange="reloadpage();"/></td>
 <td>To Date</td>
 <td><input type="text" name="to" id="to" size="11" class="datepicker" value="<?php echo date("d.m.Y",strtotime($to)); ?>" onchange="reloadpage();"  /></td>
 

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
		Transaction Id
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Transaction Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Mode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Mode</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Cash Code / Bank A/c No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Cash Code / Bank A/c No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		COA Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">COA Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Dr Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Dr Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Cr Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Cr Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$query = "SELECT * FROM ac_gl WHERE date BETWEEN '$from' AND '$to' AND voucher = 'P' ORDER BY date ";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result)) 
{
 if($pvdate <> $rows['date'])
  $displaydate = date("d.m.Y",strtotime($rows['date']));
 else
  $displaydate = "";

 if($pvtid <> $rows['transactioncode'])
 {
  $displaytid = $rows['transactioncode'];
  $displaymode = $rows['mode'];
  $displaybccodeno = $rows['bccodeno'];
  $displaydocno = $rows['vouchernumber'];
 } 
 else
  $displaytid = $displaymode = $displaybccodeno = $displaydocno = "";
  
 $totalcr += $rows['cramount'];
 $totaldr += $rows['dramount'];
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displaydate) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displaytid); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displaymode); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($displaybccodeno); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['description']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['dramount'])); ?></td>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue(changeprice($rows['cramount'])) ?></td>
	</tr>
<?php
 $pvdate = $rows['date'];
 $pvtid = $rows['transactioncode'];
}
?>
<tr>
	<td colspan="6" align="right"><b>Total</b></td>
	<td align="right"><?php echo changeprice($totaldr); ?></td>
	<td align="right"><?php echo changeprice($totalcr); ?></td>
</tr>

	</tbody>
	<tfoot>

 </tfoot>
</table>
</div>
</td></tr></table>
</div>
<br/><br/>

<?php if (@$sExport == "") { ?>
	</div><br /></td>
</tr>
</table>
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var from = document.getElementById('from').value;
	var to = document.getElementById('to').value;
	document.location = "tidwisepvreport.php?from=" + from + "&to=" + to;
}
</script>