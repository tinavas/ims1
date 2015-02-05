<?php 
$sExport = @$_GET["export"]; 

if (@$sExport == "") { ?>
<!-- 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 30px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:30px; 
            overflow: scroll; 
        }
    </style>-->
<?php } ?>

<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "../getemployee.php";

$item = $_GET['item'];
$vendor = $_GET['vendor'];
$description = $_GET['description'];
$hatchery = $_GET['hatchery'];
if(($_GET['fromdate'] == "") OR ($_GET['todate'] == ""))
{
 
  $fromdate = date("Y-m-d");
  $todate = date("y-m-d");

}
else
{
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
$todate = date("Y-m-d",strtotime($_GET['todate']));
}

$vop = $iop = $dop = "=";
 if($_GET['vendor'] == "")
 $customer = "All";
else
 $customer = $_GET['vendor'];
 if($_GET['hatchery'] == "")
 $hatchery = "All";
else
 $hatchery = $_GET['hatchery'];

if( $customer == "All")
 $vop = "<>";
 if($item == "")
 $item = "All";
if($description == "")
 $description = "All";
if($item == "All")
 $iop = "<>"; 
if($hatchery == "All")
$hat = "<>";
else
$hat = "=";
$totqty=$totsqty=$totamount=0;
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Order Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">From Date: </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date: </font></strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
<tr height="5px"></tr>
<?php if($vendor <> "All") { ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Customer : </font></strong><?php echo $vendor; ?></td>
</tr>
<?php }
if($item <> "All") { ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Item Code : </font></strong><?php echo $item; ?>&nbsp;&nbsp;<strong><font color="#3e3276">Description : </font></strong><?php echo $description; ?></td>
</tr>
<?php } ?>
</table>

<?php
session_start();
$currencyunits=$_SESSION['currency'];
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
&nbsp;&nbsp;<a href="salesorderreport2.php?export=html&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="salesorderreport2.php?export=excel&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="salesorderreport2.php?export=word&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="salesorderreport2.php?cmd=reset&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>">Reset All Filters</a>
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
 <td>
<span class="phpreportmaker">

<td>From Date</td>
<td>
<input type="text" class="datepicker" id="fromdate" name="fromdate" size="10" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" onchange="reloadpage();"/>
</td>
<td>To Date</td>
<td>
<input type="text" class="datepicker" id="todate" name="todate" size="10" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" onchange="reloadpage();"/></td>

 <td>Item</td>
 <td><select name="item" id="item" style="width:75px;" onchange="getdesc(); reloadpage();">
   	 <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>
	 <?php
	 $query = "SELECT distinct(code) FROM oc_salesorder ORDER BY code ASC";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['code']; ?>" <?php if($item == $rows['code']) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
	 <?php
	 }
	 ?>
	 </select>
 </td>
 <td>Description</td>
 <td><select name="description" id="description" style="width:100px;" onchange="getcode(); reloadpage();">
     <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>
	 <?php
	 $query = "SELECT distinct(code),description FROM oc_salesorder ORDER BY description ASC";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['code']; ?>" <?php if($item == $rows['code']) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
	 <?php
	 }
	 ?>
     </select> 
 </td>
 <td>Customer</td>
 <td>
	<select id="customer" onchange=" reloadpage();" style="width:100px">
	<option value="All" <?php if($customer == "All") { ?> selected="selected"<?php } ?>>All</option>
	<?php 
	$q = "select distinct(vendor) from oc_salesorder order by vendor";
	$qrs = mysql_query($q,$conn1) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
	<option value="<?php echo $qr['vendor'];?>" <?php if($qr['vendor'] == $customer) { ?> selected="selected"<?php } ?> title="<?php echo $qr['vendor'];?>" ><?php echo $qr['vendor'];?></option>
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
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center" title="Sales Order Date">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center">Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:60px;" align="center">Customer</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Ordered Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Ordered Quantity</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Ordered Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:60px;" align="center">Ordered Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Total Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:60px;" align="center">Total Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Total Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:60px;" align="center">Total Weight</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
	
<?php

$oldvendor = $newvendor = ""; 
$query1 = "SELECT code,description,unit FROM `oc_salesorder` WHERE 1 AND code $iop '$item' AND vendor $vop '$customer' AND date between '$fromdate' and '$todate' GROUP BY code ORDER BY code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
?>
	<tr>
    	<td class="ewRptGrpField3"><?php echo ewrpt_ViewValue($rows1['code']) ?></td>
        <td class="ewRptGrpField3"><?php echo ewrpt_ViewValue($rows1['description']) ?></td>
        <td class="ewRptGrpField3" align="center"><?php echo ewrpt_ViewValue($rows1['unit']) ?></td>	
<?php
	 $query = "SELECT vendor,packets,quantity FROM `oc_salesorder` WHERE 1 AND code='".$rows1['code']."' AND vendor $vop '$customer' AND date between '$fromdate' and '$todate' ORDER BY vendor";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	$rows = mysql_fetch_assoc($result);
?>
        <td class="ewRptGrpField1"><?php echo ewrpt_ViewValue($rows['vendor']) ?></td>
        <td class="ewRptGrpField2" align="right"><?php echo ewrpt_ViewValue(changeprice1($rows['packets'])); ?></td>
        <td class="ewRptGrpField2" align="right"><?php echo ewrpt_ViewValue(changeprice1($rows['quantity'])); ?></td>
        <?php
			$query3=mysql_query("SELECT SUM(packets) as totpacks, SUM(quantity) as totweights FROM oc_salesorder WHERE code='".$rows1['code']."' AND vendor $vop '$customer' AND date between '$fromdate' and '$todate'",$conn1);
			$data=mysql_fetch_array($query3);
		?>
        <td class="ewRptGrpField2" align="right"><b><?php echo ewrpt_ViewValue(changeprice1($data['totpacks'])); $totqty+=$data['totpacks']; ?></b></td>
        <td class="ewRptGrpField2" align="right"><b><?php echo ewrpt_ViewValue(changeprice1($data['totweights'])); $totsqty+=$data['totweights']; ?></b></td>
    </tr>
    
<?php
	while($rows = mysql_fetch_assoc($result))
	{
?>
	<tr>
		<td class="ewRptGrpField1" align="center">&nbsp;</td>
        <td class="ewRptGrpField1" align="center">&nbsp;</td>
        <td class="ewRptGrpField1" align="center">&nbsp;</td>
        <td class="ewRptGrpField1"><?php echo ewrpt_ViewValue($rows['vendor']) ?></td>
        <td class="ewRptGrpField2" align="right"><?php echo ewrpt_ViewValue(changeprice1($rows['packets']));  ?></td>
        <td class="ewRptGrpField2" align="right"><?php echo ewrpt_ViewValue(changeprice1($rows['quantity']));  ?></td>
       	<td class="ewRptGrpField2" align="center">&nbsp;</td>
        <td class="ewRptGrpField2" align="center">&nbsp;</td>
    </tr>
<?php
	}
?>
		
    
<?php
}
if($totqty > 0 or $totsqty > 0 or $totamount > 0)
{
?>
<tr><td align="right" colspan="6"><b>Total</b></td><td align="right"><b><?php echo changeprice1($totqty); ?></b></td><td align="right"><b><?php echo changeprice1($totsqty); ?></b></td></tr>
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
<?php } ?>
<script type="text/javascript">
function getdesc()
{
 document.getElementById('description').value = document.getElementById('item').value;
}
function getcode()
{
 document.getElementById('item').value = document.getElementById('description').value;
}
 
function reloadpage()
{
	
	var vendor = document.getElementById('customer').value;
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	//var hatchery = document.getElementById('hatchery').value;
	var item1 = document.getElementById('item').value;
    var w = document.getElementById("description").selectedIndex; 
    var description = document.getElementById("description").options[w].text;
	document.location = "salesorderreport2.php?vendor=" + vendor +"&item=" + item1 + "&description=" + description + "&fromdate=" + fdate + "&todate=" + tdate ;
}
</script>