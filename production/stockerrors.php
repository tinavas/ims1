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
 <td colspan="2" align="center"><strong><font color="#3e3276">Errors in Stock Quantity</font></strong></td>
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
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="stockerrors.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="stockerrors.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="stockerrors.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="stockerrors.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Postings Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Postings Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Actual Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Actual Quantity</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$query1 = "SELECT distinct(itemcode) FROM ac_financialpostings WHERE date BETWEEN '$fromdate' AND '$todate' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat IN ('Medicines','Ingredients') ORDER BY code AND client = '$client') AND client = '$client' ORDER BY itemcode";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
 $code = $rows1['itemcode'];
// $iac = $rows1['iac'];
$query = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$iac = $rows['iac'];
 $query2 = "SELECT date,trnum,type,crdr,quantity,warehouse FROM ac_financialpostings WHERE coacode = '$iac' AND itemcode = '$code' AND date BETWEEN '$fromdate' AND '$todate' AND client = '$client'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $date = $rows2['date'];
  $trnum = $rows2['trnum'];
  $type = $rows2['type'];
  $pqty = $rows2['quantity'];
  $warehouse = $rows2['warehouse'];
  $crdr = $rows2['crdr'];
  $aqty = 0;
  if($type == 'COBI')
  {
   $query3 = "SELECT quantity FROM oc_cobi WHERE date = '$date' AND invoice = '$trnum' AND code = '$code' AND client = '$client'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
  }
  elseif($type == 'Consumption' or $type == 'Production')
  {
   $query3 = "SELECT quantity FROM breeder_consumption WHERE date2 = '$date' AND flock = '$trnum' AND itemcode = '$code' AND client = '$client'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
  }
  elseif($type == 'Feed Produced' or $type == 'Item Consumed')
  {
  $query3 = "SELECT sum(quantity) as quantity FROM feed_itemwise WHERE date = '$date' AND pid = (SELECT id FROM feed_productionunit WHERE date = '$date' AND formula = '$trnum' AND feedmill LIKE '%$warehouse%' AND client = '$client') AND feedmill LIKE '%$warehouse%' AND ingredient = '$code' AND flag = 0 AND client = '$client'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
  }
  elseif($type == 'IR')
  {
   $query3 = "SELECT quantity FROM ims_intermediatereceipt WHERE date = '$date' AND tid = '$trnum' AND code = '$code' AND client = '$client' AND warehouse = '$warehouse' AND riflag = 'R'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
   }
  elseif($type == 'II')
  {
   $query3 = "SELECT quantity FROM ims_intermediatereceipt WHERE date = '$date' AND tid = '$trnum' AND code = '$code' AND client = '$client' AND warehoue = '$warehouse' AND riflag = 'I'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
  }
  elseif($type == 'SOBI')
  {
   $query3 = "SELECT receivedquantity FROM pp_sobi WHERE date = '$date' AND so = '$trnum' AND code = '$code' AND client = '$client'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['receivedquantity'];
  }
  elseif($type == 'TR')
  {
   if($crdr == 'Cr')
   {
   $query3 = "SELECT quantity FROM ims_stocktransfer WHERE date = '$date' AND id = '$trnum' AND code = '$code' AND client = '$client' AND fromwarehouse='$warehouse'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
   }
   if($crdr == 'Dr')
   {
   $query3 = "SELECT quantity FROM ims_stocktransfer WHERE date = '$date' AND id = '$trnum' AND code = '$code' AND client = '$client' AND towarehouse = '$warehouse'";
   $result3 = mysql_query($query3,$conn1);
   $rows3 = mysql_fetch_assoc($result3);
   $aqty = $rows3['quantity'];
   }
  }
   
  if($pqty <> $aqty)
  {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($type); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($trnum); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($code); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($pqty); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($aqty); ?></td>
	</tr>
<?php
  }	//End of if(pqty <> aqty)
 }	//End of rows2
}	//end of rows1
?>
<tr><td colspan="6">The following are the records for which the postings are not done (OR) incorrect</td></tr>
<?php	//Direct Sales
$query = "SELECT date,invoice,code,quantity FROM oc_cobi WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $code = $rows['code'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[code]' AND trnum = '$rows[invoice]' AND coacode = '$iac' AND client = '$client'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("COBI"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['invoice']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Breeder Daily Entry
$query = "SELECT date2,flock,itemcode,quantity FROM breeder_consumption WHERE date2 BETWEEN '$fromdate' AND '$todate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$code = $rows['itemcode'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date2]' AND itemcode = '$rows[itemcode]' AND trnum = '$rows[flock]' AND coacode = '$iac' AND client = '$client' AND type = 'BDE'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date2']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("Breeder DE"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['flock']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['itemcode']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Production Unit
$query = "SELECT date,formulae,ingredient,quantity FROM feed_itemwise WHERE date BETWEEN '$fromdate' AND '$todate' AND pid IN (SELECT id FROM feed_productionunit WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client') AND client = '$client' AND flag = 0 AND quantity > 0";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$code = $rows['ingredient'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[ingredient]' AND trnum = '$rows[formulae]' AND coacode = '$iac' AND client = '$client'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("Production Unit"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['formulae']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['ingredient']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Intermediate Receipt
$query = "SELECT date,tid,code,warehouse,quantity FROM ims_intermediatereceipt WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client' AND riflag = 'R'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$code = $rows['code'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[code]' AND trnum = '$rows[tid]' AND coacode = '$iac' AND client = '$client' AND type = 'IR'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("Inter. Receipt"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['tid']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Intermediate Issue
$query = "SELECT date,tid,code,warehouse,quantity FROM ims_intermediatereceipt WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client' AND riflag = 'I'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$code = $rows['code'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[code]' AND trnum = '$rows[tid]' AND coacode = '$iac' AND client = '$client' AND type = 'II'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("Inter. Issue"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['tid']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Direct Purchases
$query = "SELECT date,so,code,receivedquantity FROM pp_sobi WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $code = $rows['code'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[code]' AND trnum = '$rows[so]' AND coacode = '$iac' AND client = '$client'";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count == 0)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("SOBI"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['so']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['receivedquantity']); ?></td>
	</tr>
<?php } } ?>

<?php	//Stock Transfer-From Warehouse
$query = "SELECT date,id,code,quantity,fromwarehouse FROM ims_stocktransfer WHERE date BETWEEN '$fromdate' AND '$todate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $code = $rows['code'];
$query0 = "SELECT iac FROM ims_itemcodes WHERE code = '$code' AND client = '$client'";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
$rows0 = mysql_fetch_assoc($result0);
$iac = $rows0['iac'];

 $query1 = "SELECT id FROM ac_financialpostings WHERE date = '$rows[date]' AND itemcode = '$rows[code]' AND trnum = '$rows[id]' AND coacode = '$iac' AND client = '$client' ";
 $result1 = mysql_query($query1,$conn1) or die(mysql_error());
 $count = mysql_num_rows($result1);
 if($count <> 2)
 {
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['date']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue("Stock Transfer"); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['id']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(""); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
	</tr>
<?php } } ?>

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
	document.location = "stockerrors.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>