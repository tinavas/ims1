<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 


$status = $_GET['status'];

if($status == 'Received')
{
$statuscond = "and aflag = 0 and rflag = 1";
$cond9= " where aflag = 0 and rflag = 1";
}
else if($status == "Not Received")
{
$statuscond = "and aflag = 0 and rflag = 0";
$cond9= " where aflag = 0 and rflag = 0";
}
else if($status == "Authorized")
{
$statuscond = "and aflag = 1";
$cond9=" where aflag = 1";
}
 else
 {
 $statuscond = "";
 $cond9="";
 }


if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
if($_GET['warehouse'] <> "")
{
	$warehouse=$_GET['warehouse'];
	$cond1=" and warehouse='$warehouse' ";
}
else
{
	$warehouse="";
	$cond1="";
}
if($_GET['vendor'] <> "")
{
	$vendor=$_GET['vendor'];
	$cond2=" and party='$vendor' ";
}
else
{
	$vendor="";
	$cond2="";
}
if($_GET['salesorder'] <> "")
{
	$salesorder=$_GET['salesorder'];
	$cond3=" and so='$salesorder' ";
}
else
{
	$salesorder="";
	$cond3="";
}


if($_GET['itemcode'] <> "")
{
	$itemcode=$_GET['itemcode'];
	$cond5=" and itemcode='$itemcode' ";
}
else
{
	$itemcode="";
	$cond5="";
}
if($_GET['description'] <> "")
{
	$description =$_GET['description'];
	$cond6=" and description='$description' ";
}
else
{
	$description ="";
	$cond6="";
}




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
 <td colspan="2" align="center"><strong><font color="#3e3276">Packslip Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
</table>
<?php /*?><center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center><?php */?>

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
&nbsp;&nbsp;<a href="oc_packslipreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $warehouse; ?>&vendor=<?php echo $vendor; ?>&salesorder=<?php echo $salesorder; ?>&dvlocation=<?php echo $dvlocation; ?>&itemcode=<?php echo $itemcode; ?>&description=<?php echo $description; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="oc_packslipreport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $warehouse; ?>&vendor=<?php echo $vendor; ?>&salesorder=<?php echo $salesorder; ?>&dvlocation=<?php echo $dvlocation; ?>&itemcode=<?php echo $itemcode; ?>&description=<?php echo $description; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="oc_packslipreport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $warehouse; ?>&vendor=<?php echo $vendor; ?>&salesorder=<?php echo $salesorder; ?>&dvlocation=<?php echo $dvlocation; ?>&itemcode=<?php echo $itemcode; ?>&description=<?php echo $description; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="oc_packslipreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $warehouse; ?>&vendor=<?php echo $vendor; ?>&salesorder=<?php echo $salesorder; ?>&dvlocation=<?php echo $dvlocation; ?>&itemcode=<?php echo $itemcode; ?>&description=<?php echo $description; ?>">Reset All Filters</a>
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
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();" size="11"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();" size="11"/></td>
 <td>Warehouse</td>
 <td>
 <select id="warehouse" name="warehouse" onchange="reloadpage();" style="width:100px" >
 	<option value="">-All-</option>
 <?php
 	 $query="select distinct(warehouse) as warehouse FROM `oc_packslip` order by warehouse";
	 $result=mysql_query($query,$conn1);
	 while($rows=mysql_fetch_assoc($result))
		{
 ?>
 		<option value="<?php echo $rows['warehouse'];?>" <?php if($warehouse==$rows['warehouse']) { ?> selected="selected" <?php } ?> title="<?php echo $rows['warehouse'];?>" ><?php echo $rows['warehouse'];?></option>
 <?php
 		}
 ?>
 </select>
 </td>
 <td>Customer</td>
 <td>
 <select id="vendor" name="vendor" onchange="reloadpage();" style="width:100px" >
 	<option value="">-All-</option>
 <?php
 	 $query="select distinct(party) as vendor FROM `oc_packslip` order by party";
	 $result=mysql_query($query,$conn1);
	 while($rows=mysql_fetch_assoc($result))
		{
 ?>
 		<option value="<?php echo $rows['vendor'];?>" <?php if($vendor==$rows['vendor']) { ?> selected="selected" <?php } ?> title="<?php echo $rows['vendor'];?>"><?php echo $rows['vendor'];?></option>
 <?php
 		}
 ?>

 </select>
 </td>
 <td>Salesorder</td>
 <td>
 <select id="salesorder" name="salesorder" onchange="reloadpage();">
 	<option value="">-All-</option>
 <?php
 	 $query="select distinct(so) as salesorder FROM `oc_packslip` order by so";
	 $result=mysql_query($query,$conn1);
	 while($rows=mysql_fetch_assoc($result))
		{
 ?>
 		<option value="<?php echo $rows['salesorder'];?>" <?php if($salesorder==$rows['salesorder']) { ?> selected="selected" <?php } ?>><?php echo $rows['salesorder'];?></option>
 <?php
 		}
 ?>

 </select>
 </td>
 
 <td>Item Code</td>
 <td>
 <select id="itemcode" name="itemcode" onchange="reloadpage();">
 	<option value="">-All-</option>
 <?php
 	 $query="select distinct(itemcode) as itemcode FROM `oc_packslip` order by itemcode";
	 $result=mysql_query($query,$conn1);
	 while($rows=mysql_fetch_assoc($result))
		{
 ?>
 		<option value="<?php echo $rows['itemcode'];?>" <?php if($itemcode==$rows['itemcode']) { ?> selected="selected" <?php } ?>><?php echo $rows['itemcode'];?></option>
 <?php
 		}
 ?>
 </select>
 </td>
 <td>Item Desc</td>
 <td>
 <select id="description" name="description" onchange="reloadpage();" style="width:100px">
 	<option value="">-All-</option>
 <?php
 	 $query="select distinct(description) as description FROM `oc_packslip` order by description";
	 $result=mysql_query($query,$conn1);
	 while($rows=mysql_fetch_assoc($result))
		{
 ?>
 		<option value="<?php echo $rows['description'];?>" <?php if($description==$rows['description']) { ?> selected="selected" <?php } ?> title="<?php echo $rows['description'];?>"><?php echo $rows['description'];?></option>
 <?php
 		}
 ?>
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
		Delivary Challan
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Delivary Challan</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Customer</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sales Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sales Order</td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Item Desc
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Desc</td>
			</tr></table>
		</td>
		
<?php } 

 if($_SESSION['db']=='vista'){?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Pieces
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Pieces</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>
<?php } }  else if($_SESSION['db']!='vista') {
 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Pieces</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sent Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Weight</td>
			</tr></table>
		</td>

<?php }}  if($_SESSION['db']=='vista'){?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sent Pieces
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sent Pieces</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sent Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sent Weight</td>
			</tr></table>
		</td>
<?php } }?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Status
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Status</td>
			</tr></table>
		</td>
<?php }  ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		COBI
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">COBI</td>
			</tr></table>
		</td>
<?php }  ?>

	</tr>
	</thead>
	<tbody>
<?php 
$totalquantity=0;
$totalpieces=0;
$query="SELECT `date`, `ps`, `party`, `so`, `warehouse`, `packets`, `itemcode`, `description`,`ordermode`, `quantity` FROM `oc_packslip` where 1 AND date between '$fromdate' AND '$todate' $cond1 $cond2 $cond3 $cond5 $cond6 order by date,ps";
$result=mysql_query($query,$conn1);
while($rows=mysql_fetch_assoc($result))
{ 
$cobii = "";$cntt = 0;$done="";
	$query1="SELECT invoice FROM `oc_cobi`  where `ps`='$rows[ps]' ";
			$result1=mysql_query($query1,$conn1);
			$cntt = mysql_num_rows($result1);
			while($rows1=mysql_fetch_assoc($result1))
			{
			$cobii = $rows1['invoice'];
			$done="COBI Done";
			}
			if($cntt == 0)
			{
				$cobii = "N.A";
				$done="COBI Not Done";
			}
			$query2="select quantity,packets from oc_salesorder where po='$rows[so]' and code='$rows[itemcode]' and vendor='$rows[party]' and warehouse='$rows[warehouse]' ";
			$r2=mysql_query($query2);
			while($r=mysql_fetch_array($r2))
			{
			$qnt=$r['quantity'];
			$pkts=$r['packets'];
			}
	?>
	<tr><?php if($d1==$rows['date'] && $pss==$rows['ps']){?>
		<td class="ewRptGrpField1">
			<?php echo ewrpt_ViewValue(); ?>
		</td><?php } else {?>
		<td class="ewRptGrpField1">
			<?php echo ewrpt_ViewValue(date('d-m-Y',strtotime($rows['date']))); ?>
		</td>
		<?php } ?>
		<?php if($pss==$rows['ps']){?>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue(); ?>
		</td><?php } else {?>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($rows['ps']); ?>
		</td><?php } ?>
		<td class="ewRptGrpField3">
			<?php echo ewrpt_ViewValue($rows['warehouse']); ?>
		</td>
		<td class="ewRptGrpField4">
			<?php echo ewrpt_ViewValue($rows['party']) ?>
		</td>
		<td class="ewRptGrpField5">
			<?php echo ewrpt_ViewValue($rows['so']) ?>
		</td>
		
		<td class="ewRptGrpField7">
			<?php echo ewrpt_ViewValue($rows['itemcode']) ?>
		</td>
		<td class="ewRptGrpField8">
			<?php echo ewrpt_ViewValue($rows['description']) ?>
		</td>
		<?php if($_SESSION['db']=='vista') {?>
		<td class="ewRptGrpField8">
			<?php echo ewrpt_ViewValue($rows['ordermode']) ?>
		</td>
		
		
        <td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($pkts); $totalpieces+=$pkts; ?>
		</td>
		<td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($qnt); $totalquantity+=$qnt; ?>
		</td>
		<?php }?>
		<?php if($_SESSION['db']=='vista') {?>
		<td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($rows['packets']); $totalpieces1+=$rows['packets']; ?>
		</td>
        <td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($rows['quantity']); $totalquantity1+=$rows['quantity']; ?>
		</td>
		<?php }?>
		<?php if($_SESSION['db']!='vista') {?>
		
		<td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($qnt); $totalquantity+=$qnt; ?>
		</td>
		
		<td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($rows['quantity']); $totalpieces+=$rows['quantity']; ?>
		</td>
		<?php }?>
        <td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($done); ?>
		</td>
        <td class="ewRptGrpField9">
			<?php echo ewrpt_ViewValue($cobii); ?>
		</td>
		
		
	</tr>
	<?php
$d1=$rows['date'];
$pss=$rows['ps'];	
	
}
?>
<tr>
	<td class="ewRptGrpField9" colspan="8" align="right">
			<b>Total</b>
		</td>
    <td class="ewRptGrpField9">
			<b><?php echo ewrpt_ViewValue($totalpieces); ?></b>
		</td>
    <td class="ewRptGrpField9">
			<b><?php echo ewrpt_ViewValue($totalquantity); ?></b>
		</td>
		<?php if($_SESSION['db']=='vista') {?>
		<td class="ewRptGrpField9">
			<b><?php echo ewrpt_ViewValue($totalpieces1); ?></b>
		</td>
    <td class="ewRptGrpField9">
			<b><?php echo ewrpt_ViewValue($totalquantity1); ?></b>
		</td>
		<?php }?>
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
	var warehouse = document.getElementById('warehouse').value;
	var vendor = document.getElementById('vendor').value;
	var salesorder = document.getElementById('salesorder').value;
	
	var itemcode = document.getElementById('itemcode').value;
	var description = document.getElementById('description').value;
	
	
	document.location = "oc_packslipreport.php?fromdate=" + fdate + "&todate=" + tdate+ "&warehouse=" + warehouse+ "&vendor=" + vendor+ "&salesorder=" + salesorder+ "&itemcode=" + itemcode+ "&description=" + description;
}
</script>