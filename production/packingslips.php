<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
include "getemployee.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
 $cond='';
 if($_GET['party'] <> "")
 $party = $_GET['party'];
 else
 $party = ''; 
 if($party!='') {  $cond="and  party='$party' "; }
 else $cond.='';
 
  if($_GET['itemcode'] <> "")
  $itemcode = $_GET['itemcode'];
  else
  $itemcode = ''; 
  if($itemcode!='') {  $cond.="and  itemcode='$itemcode' "; }
  else $cond.='';
 
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Packing Slips Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="packingslips.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="packingslips.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="packingslips.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="packingslips.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>">Reset All Filters</a>
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
 <td>Party</td>
 <td>
 <select onchange="reloadpage()" id="party">
 <option value="">All</option>
 <?php  
 $r=mysql_query("select name as party from contactdetails where type like '%party%'");
 while($a=mysql_fetch_array($r))
  { ?>
  <option <?php if($party==$a[party]) echo 'selected="selected"'; ?> value="<?php echo $a[party] ?>"><?php echo $a[party] ?></option>
 <?php } ?>
 </select>
 </td>
  <td>Item Code</td>
 <td>
 <select onchange="reloadpage()" id="itemcode">
 <option value="">All</option>
 <?php  
 $r=mysql_query("select distinct(itemcode),description from oc_packslip order by itemcode");
 while($a=mysql_fetch_array($r))
  { ?>
  <option <?php if($a[itemcode]==$itemcode) echo 'selected="selected"'; ?> title="<?php echo $a[description] ?>" value="<?php echo $a[itemcode] ?>"><?php echo $a[itemcode] ?></option>
 <?php } ?>
 </select>
 </td>
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
		Packing Slip
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Packing Slip</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Delivery No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Delivery No</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Party
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Party</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Narration
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Narration</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
  $query2 = "SELECT sum(quantity) AS quantity,itemcode,description,docno,date,party,remarks,ps FROM oc_packslip where date >='$fromdate' and date <= '$todate' $cond GROUP BY ps,itemcode ORDER BY date ASC, docno Asc ";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
while($array2=mysql_fetch_array($result2))
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo date($datephp,strtotime($array2['date'])); ?></td>
<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($array2['ps']); ?></td>
		<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($array2['docno']); ?></td>
<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($array2['party']); ?></td>
		<td class="ewRptGrpField1" >
<?php echo ewrpt_ViewValue($array2['itemcode']); ?></td>
<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($array2['description']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo changeprice($array2['quantity']); $total+=$array2['quantity']; ?></td>
<td class="ewRptGrpField1" align="right">
<?php if( $array2['remarks']=='') echo '&nbsp;'; else echo $array2['remarks']; ?></td>
	</tr>
<?php
}
?>
	</tbody>
	<tfoot>
<tr><td align="right" colspan="6"><strong>Total</strong></td><td align="right"><?php echo changeprice($total); ?></td><td>&nbsp;</td></tr>
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
		var party = document.getElementById('party').value;
		var itemcode = document.getElementById('itemcode').value;
	document.location = "packingslips.php?fromdate=" + fdate + "&todate=" + tdate + "&party=" + party + "&itemcode=" + itemcode;
}
</script>