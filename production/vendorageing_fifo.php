<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$ven = $_GET['vendor'];
$quer1 = "select * from contactdetails where name = '$ven'   ";
	$quers1 = mysql_query($quer1,$conn1) or die(mysql_error());
	while($row11 = mysql_fetch_assoc($quers1))
	{ 
	  if ( ($row11['type'] == "vendor") or ($row11['type'] == "vendor and party") )
	  {
	    $vflag = 1;
	  }
	  if ( ($row11['type'] == "party") or ($row11['type'] == "vendor and party") )
	  {
	    $cflag = 1;
	  }
	  $ca = $row11['ca'];
	  $cac = $row11['cac'];
	  $va = $row11['va'];
	  $vppac = $row11['vppac'];
	}

$url = "&fromdate=" . $_GET['fromdate'] . "&todate=" . $_GET['todate']."&vendor=" . $_GET['vendor'];
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Ageing Analysis</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<td colspan="2" align="center"><strong><font color="#3e3276">Supplier/Customer Name&nbsp;</font></strong><?php echo $ven; ?></td>
</tr>

<tr>
 <td align="center"><strong><font color="#3e3276">Till Date </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="vendorageing_fifo.php?export=html&fromdate=<?php echo $url; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="vendorageing_fifo.php?export=excel&fromdate=<?php echo $url; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="vendorageing_fifo.php?export=word&fromdate=<?php echo $url; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="vendorageing_fifo.php?cmd=reset&fromdate=<?php echo $url; ?>">Reset All Filters</a>
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
 <td>Till Date</td>
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
		<td valign="bottom" class="ewTableHeader">
		Supplier Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Supplier Name</td>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Invoice No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Invoice No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		0 To 30 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>0 To 30 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		31 To 60 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>31 To 60 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		61 To 90 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>61 To 90 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		91 To 120 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>91 To 120 Days</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		121 To 150 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>121 To 150 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		151 To 180 Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>151 To 180 Days</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		181 Days And More
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>181 Days And More</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Grand Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Grand Total</td>
			</tr></table>
		</td>
<?php } ?>
</tr>

	</thead>
	<tbody>
<?php
if($cflag == 1)
{
$sumbal = 0;
$dup = 0;
$nubal = 0;
$thbal = 0;
$sibal = 0;
$nibal = 0;
$twbal = 0;
$fibal = 0;
$eibal = 0;

$query = "SELECT SUM(amount) AS amountreceived FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Cr' AND coacode = '$ca'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$amountrecv = $bal = $rows['amountreceived'];
if($bal == "") $bal = 0;

echo $query = "SELECT date,trnum,amount AS finaltotal FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Dr' AND coacode = '$ca'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $pamount = $rows['finaltotal'];
 if($pamount <= $bal)
  $bal -= $pamount;
 else
{
if($bal > 0)
 $balamt = ($pamount - $bal);
else
 $balamt = $pamount;
 $bal = 0;
$pdate = $rows['date'];
$difdays = round(((strtotime($todate) - strtotime($pdate)) / (24 * 60 * 60)),0);
?>
   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue(date($datephp,strtotime($rows['date']))) ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue($rows['trnum']) ?>
		</td>
		<td align="right">
<?php if ($difdays < 31) { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt;  $nubal = $nubal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
		<td align="right">
<?php if (($difdays > 30) and ($difdays < 61))  {  echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 60) and ($difdays < 91))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt;  }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 90) and ($difdays < 121))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 120) and ($difdays < 151))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 150) and ($difdays < 181))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if ($difdays > 180)   { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal)); ?>
</td>

	</tr>
<?php
}
}
?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("Outstanding Balance") ?>
		</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nubal)); 
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal));?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal));  ?>
</td>

	</tr>
<?php } ?>

<?php
if($vflag == 1)
{
$sumbal = 0;
$dup = 0;
$nubal = 0;
$thbal = 0;
$sibal = 0;
$nibal = 0;
$twbal = 0;
$fibal = 0;
$eibal = 0;

$query = "SELECT SUM(amount) AS amountpaid FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Dr' AND coacode = '$va'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$amountrecv = $bal = $rows['amountpaid'];
if($bal == "") $bal = 0;

$query = "SELECT date,trnum,amount AS finaltotal FROM ac_financialpostings WHERE date <= '$todate' AND venname = '$ven' AND crdr = 'Cr' AND coacode = '$va' ORDER BY date ASC,id";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $pamount = $rows['finaltotal'];
 if($pamount <= $bal)
  $bal -= $pamount;
 else
{
if($bal > 0)
 $balamt = ($pamount - $bal);
else
 $balamt = $pamount;
$bal = 0; 
$pdate = $rows['date'];
$difdays = round(((strtotime($todate) - strtotime($pdate)) / (24 * 60 * 60)),0);
?>
   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue($ven) ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue(date($datephp,strtotime($rows['date']))) ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue($rows['trnum']) ?>
		</td>
		<td align="right">
<?php if ($difdays < 31) { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt;  $nubal = $nubal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
		<td align="right">
<?php if (($difdays > 30) and ($difdays < 61))  {  echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $thbal = $thbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 60) and ($difdays < 91))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $sibal = $sibal + $balamt;  }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 90) and ($difdays < 121))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $nibal = $nibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 120) and ($difdays < 151))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $twbal = $twbal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if (($difdays > 150) and ($difdays < 181))  { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $fibal = $fibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php if ($difdays > 180)   { echo ewrpt_ViewValue(changeprice($balamt)); $sumbal = $sumbal + $balamt; $eibal = $eibal + $balamt; }
else { echo ewrpt_ViewValue("&nbsp;"); } ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal)); ?>
</td>

	</tr>
<?php
}
}
?>
	   <tr>
		<td class="ewRptGrpField1">
		<?php echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField2">
		<?php  echo ewrpt_ViewValue() ?>
		</td>
		<td class="ewRptGrpField3">
		<?php echo ewrpt_ViewValue("Outstanding Balance") ?>
		</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nubal)); 
 ?>
</td>
		<td align="right">
<?php echo ewrpt_ViewValue(changeprice($thbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($nibal)); ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($twbal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($fibal));  ?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($eibal));?>
</td>
<td align="right">
<?php echo ewrpt_ViewValue(changeprice($sumbal));  ?>
</td>

	</tr>
<?php } ?>

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
	document.location = "vendorageing_fifo.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>