<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
 if($_GET['type'])
 $type = $_GET['type'];
 else
  $type = "Layer Eggs";
 include "../getemployee.php";
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
 <td colspan="2" align="center"><strong><font color="#3e3276"><?php echo $type; ?> Stock Report</font></strong></td>
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
<table align="center" id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="eggstocksmryalb.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="eggstocksmryalb.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="eggstocksmryalb.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="eggstocksmryalb.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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

<table align="center" class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if (@$sExport == "") { ?>
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>Eggs Type&nbsp;</td>
 <td>
<select id="type" name="type" onChange="reloadpage();">
<option value="Layer Eggs" <?php if($type == "Layer Eggs"){?> selected="selected" <?php } ?>>Loose Eggs</option>
<option value="Packed Eggs" <?php if($type == "Packed Eggs"){?> selected="selected" <?php } ?>>Packed Eggs</option>
</select>
</td>
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
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
		<td class="ewTableHeader" >
		Egg Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  >Egg Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  >
		Opening
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  >Opening</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  >
		Received
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  >Received</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  >
		Issued
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  >Issued</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  >
		Closing
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  >Closing</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php

$query = "select code from ims_itemcodes where cat='$type'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
$opening[$res['code']] = 0;
$issued[$res['code']] = 0;
$received[$res['code']] = 0;
}

if($type == "Packed Eggs")
{
/// Opening calculation
 $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'R' AND cat = '$type' AND date < '$fromdate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] += $res['quantity'];

$query = "select packetcode,sum(packets) as quantity from layer_packets where date < '$fromdate' group by packetcode";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$opening[$res['packetcode']] += $res['quantity'];

 $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'I' AND cat = '$type' AND date < '$fromdate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] -= $res['quantity'];
  
$query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date < '$fromdate' AND type = 'Add'";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] += $res['quantity'];
  
$query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date >= '$fromdate' and date <= '$todate' AND type = 'Deduct'";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] -= $res['quantity'];  
  
//Calculating Received  
 $query = "select packetcode,sum(packets) as quantity from layer_packets where date >= '$fromdate' and date <= '$todate' group by packetcode";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$received[$res['packetcode']] += $res['quantity'];

 $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'R' AND cat = '$type' AND date >= '$fromdate' and date <= '$todae' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $received[$res['code']] += $res['quantity'];

$query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date >= '$fromdate' and date <= '$todate' AND type = 'Add'";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
 $received[$res['code']] += $res['quantity'];

//Calculating Issued
$query = "select code,sum(quantity) as quantity from oc_cobi where code in (select code from ims_itemcodes where cat = '$type') and date >= '$fromdate' and date <= '$todate' group by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$issued[$res['code']] = $res['quantity'];

$query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'I' AND cat = '$type' AND date >= '$fromdate' and date <= '$todae' group by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
$issued[$res['code']] += $res['quantity'];
 
$query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date >= '$fromdate' and date <= '$todate' AND type = 'Deduct'";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
 $issued[$res['code']] -= $res['quantity']; 
 }
 else
 {
 /// category Layer Eggs
 
 //Opening calculations
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'R' AND cat = '$type' AND date < '$fromdate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] += $res['quantity'];
  
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'I' AND cat = '$type' AND date < '$fromdate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] -= $res['quantity'];
  
 $query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date < '$fromdate' AND type = 'Add' group by code ";
 $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] += $res['quantity'];
  
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date < '$fromdate' AND type = 'Add' group by code ";
 $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['code']] -= $res['quantity'];
  
  $query = "SELECT itemcode,SUM(quantity) as quantity FROM layer_production WHERE date1 < '$fromdate' group by itemcode";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['itemcode']] += $res['quantity'];
  
  $query = "SELECT eggcode,SUM(packets*capacity) as quantity,wastage FROM layer_packets WHERE date < '$fromdate' group by eggcode";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $opening[$res['eggcode']] -= $res['quantity'] + $res['wastage'];
  
  
 $query = "SELECT tocode,SUM(toeggs) as quantity,wastage FROM ims_eggtransfer WHERE tocode in (select distinct(code) from ims_itemcodes where cat = '$type' ) AND date < '$fromdate' group by tocode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 $opening[$res['tocode']] += $res['quantity'] +$res['wastage'];

 $query = "SELECT fromcode,SUM(fromeggs) as quantity FROM ims_eggtransfer WHERE fromcode in (select distinct(code) from ims_itemcodes where cat = '$type' ) AND date < '$fromdate' group by fromcode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 $opening[$res['fromcode']] -= $res['quantity'];
 
 ///calculating received quantity
 $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'R' AND cat = '$type' AND date between '$fromdate' and '$todate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $received[$res['code']] += $res['quantity'];
  
  
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date between '$fromdate' and '$todate' AND type = 'Add' group by code ";
 $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $received[$res['code']] -= $res['quantity'];
  
 $query = "SELECT itemcode,SUM(quantity) as quantity FROM layer_production WHERE date1 between '$fromdate' and '$todate' group by itemcode";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $received[$res['itemcode']] += $res['quantity'];
  
 $query = "SELECT tocode,SUM(toeggs) as quantity,wastage FROM ims_eggtransfer WHERE tocode in (select distinct(code) from ims_itemcodes where cat = '$type' ) AND date between '$fromdate' and '$todate' group by tocode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 $received[$res['tocode']] += $res['quantity'] +$res['wastage'];
  
  
 //Issued calculation 
  
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_intermediatereceipt WHERE riflag = 'I' AND cat = '$type' AND date between '$fromdate' and '$todate' group by code";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $issued[$res['code']] += $res['quantity'];
  
   $query = "SELECT code,SUM(quantity) as quantity FROM ims_stockadjustment WHERE category = '$type' AND date between '$fromdate' and '$todate' AND type = 'Add' group by code ";
 $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $issued[$res['code']] += $res['quantity'];
  
  
  $query = "SELECT eggcode,SUM(packets*capacity) as quantity,wastage FROM layer_packets WHERE date between '$fromdate' and '$todate' group by eggcode";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($res = mysql_fetch_assoc($result))
  $issued[$res['eggcode']] += $res['quantity'] + $res['wastage'];
  

 $query = "SELECT fromcode,SUM(fromeggs) as quantity FROM ims_eggtransfer WHERE fromcode in (select distinct(code) from ims_itemcodes where cat = '$type' ) AND date between '$fromdate' and '$todate' group by fromcode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 $issued[$res['fromcode']] += $res['quantity'];
 }
 
$query = "select code,description from ims_itemcodes where cat = '$type' order by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{ 
?>
	<tr>
		<td class="ewRptGrpField3">
<?php echo $res['code']."(".$res['description'].")"; ?></td>
		<td class="ewRptGrpField3" align="right">
<?php 
 if($res['code'] == "LEG108") echo "0"; else if($opening[$res['code']]){ echo changeprice1($opening[$res['code']]); $topening += $opening[$res['code']];}else echo "0";

 ?></td>
		<td class="ewRptGrpField3" align="right">
<?php 
 if($received[$res['code']]){ echo changeprice1($received[$res['code']]); $treceived +=$received[$res['code']];}  else echo "0";

 ?></td>
<td class="ewRptGrpField3" align="right">
<?php 
 if($issued[$res['code']]){ echo changeprice1($issued[$res['code']]); $tissued += $issued[$res['code']];} else echo "0";

 ?></td>
<td class="ewRptGrpField3" align="right">
<?php if($res['code'] == "LEG108") echo "0"; else echo changeprice1($closing=$opening[$res['code']]+$received[$res['code']]-$issued[$res['code']]); $tclosing += $closing; ?></td>
	</tr>
<?php
}
?>
<tr >
<td class="ewRptGrpField3" align="right"><b>Total</b></td>
<td class="ewRptGrpField3" align="right"><b><?php if($topening) echo changeprice1($topening); else echo "0";  ?></b></td>
<td class="ewRptGrpField3" align="right"><b><?php  if($treceived) echo changeprice1($treceived); else echo "0"; ?></b></td>
<td class="ewRptGrpField3" align="right"><b><?php  if($tissued)echo changeprice1($tissued); else echo "0"; ?></b></td>
<td class="ewRptGrpField3" align="right"><b><?php  if($tclosing)echo changeprice1($tclosing); else echo "0"; ?></b></td>
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var type = document.getElementById('type').value;
	document.location = "eggstocksmryalb.php?fromdate=" + fdate + "&todate=" + tdate + "&type=" + type;
}
</script>

