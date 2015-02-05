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
 
 
 $vendor = $_GET['vendor'];
 $code1 = $_GET['code'];
 $code2 = explode('@',$code1);
 $code = $code2[0];
 $desc = $code2[1];
 $desc1 = $_GET['desc'];
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Purchase Report</font></strong></td>
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
&nbsp;&nbsp;<a href="purchasereport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vendor=<?php echo $vendor; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchasereport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vendor=<?php echo $vendor; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="purchasereport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vendor=<?php echo $vendor; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchasereport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&vendor=<?php echo $vendor; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Reset All Filters</a>
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
 <td>Supplier</td>
 <td><select name="vendor" id="vendor" onchange="reloadpage();">
     <option value="All">All</option>
	 <?php 
	 include "config.php";
	 $query = "select distinct(vendor) from pp_sobi order by vendor";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['vendor']; ?>" <?php if($vendor == $rows['vendor']) { ?> selected="selected" <?php } ?>><?php echo $rows['vendor']; ?></option>
	 <?php } ?>
	 </select>
 </td>
 <td>Code</td>
 <td><select name="code" id="code" onchange="itemselect(this.value);reloadpage();">
     <option value="All">All</option>
	 <?php 
	 $query = "select distinct(code),description from pp_sobi order by code";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>"<?php if($rows['code'] == $code) { ?> selected="selected" <?php } ?>><?php echo $rows['code']; ?></option>
	 <?php } ?>
	 </select>
 </td>
 <td>Description</td>
 <td><select name="desc" id="desc" onchange="descselect(this.value);reloadpage();">
     <option value="All">All</option>
	 <?php 
	 $query = "select distinct(description),code from pp_sobi order by description";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['code'].'@'.$rows['description']; ?>"<?php if($desc == $rows['description']) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
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
		Supplier
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Supplier</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Supplier Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Supplier Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		So#
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">So#</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Invoice No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Invoice No.</td>
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
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Units</td>
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
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Price</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Total Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Discount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Discount</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
include "config.php";
if($vendor == "All")
{
$a = '';
}
else
{
$a = "vendor = '$vendor' and";
}
if($code == "All")
{
$b = '';
}
else
{
$b = "and code = '$code'";
}

$query = "select distinct(so) as so from pp_sobi where $a date between '$fromdate' and '$todate' $b group by so order by vendor,so,code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
$so = $rows['so'];
$query2  = "select * from pp_sobi where so = '$so' order by vendor,code";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($result2))
{
$vendor = $rows2['vendor'];
$vendorcode = $rows2['vendorcode'];
$date = $rows2['date'];
$invoice = $rows2['invoice'];
$code = $rows2['code'];
$desc = $rows2['description'];
$units = $rows2['itemunits'];
$quantity = $rows2['sentquantity'];
$price = $rows2['rateperunit'];
$gtotal = $rows2['grandtotal'];
$discount = $rows2['discountamount'];

$query1 = "select sum(sentquantity) as totalquantity from pp_sobi where so = '$so' order by vendor,so,code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
$tqty = $rows1['totalquantity'];

?>
	<tr>
		<td class="ewRptGrpField3" align="left">
<?php if($dupcheck <> $vendor) {  echo ewrpt_ViewValue($vendor);  } else { echo ewrpt_ViewValue("&nbsp;"); }  ?></td>
		<td class="ewRptGrpField3" align="left">
<?php if($dupcheck1 <> $vendorcode) { echo ewrpt_ViewValue($vendorcode); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
		<td class="ewRptGrpField1" align="left">
<?php if($dupcheck2 <> $date) { echo ewrpt_ViewValue(date($datephp,strtotime($date))); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="left">
<?php if($dupcheck3 <> $so) { echo ewrpt_ViewValue($so); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck4 <> $invoice) { echo ewrpt_ViewValue($invoice); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($code);  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($desc);  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($units); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($quantity); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($price); ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck10 <> $so) { echo ewrpt_ViewValue($tqty); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck11 <> $so) { echo ewrpt_ViewValue($gtotal); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($discount); ?></td>
	</tr>
<?php
$dupcheck = $vendor;
$dupcheck1 = $vendorcode;
$dupcheck2 = $date;
$dupcheck3 = $so;
$dupcheck4 = $invoice;
$dupcheck5 = $code;
$dupcheck6 = $desc;
$dupcheck7 = $units;
$dupcheck10 = $so;
$dupcheck11 = $so;
}
}
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
function itemselect(y)
{
if(y=="select")
{
document.getElementById("desc").value="select";
}
else
{
document.getElementById("desc").value=y;
}
}

function descselect(z)
{
if(z=="select")
{
document.getElementById("code").value="select";
}
else
{
document.getElementById("code").value=z;
}
}


function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var vendor = document.getElementById('vendor').value;
	var code = document.getElementById('code').value;
	var desc = document.getElementById('desc').value;
	
	document.location = "purchasereport.php?fromdate=" + fdate + "&todate=" + tdate + "&vendor=" + vendor + "&code=" + code + "&desc=" + desc;
	<?php 
	$vendor = $_GET['vendor'];
	if($vendor != '')
	{
	$vendor = $vendor;
	}
	else
	{
	$vendor = "All";
	}
	
	$code1 = $_GET['code'];
	$code2 = explode('@',$code1);
	$code = $code2[0];
	$desc = $code2[1];
    if($code != '')
	{
	$code = $code;
	}
	else
	{
	$code = "All";
	}
	
	?>
}
</script>