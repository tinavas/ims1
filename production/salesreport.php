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
 
 
 $party = $_GET['party'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Report</font></strong></td>
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
&nbsp;&nbsp;<a href="salesreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="salesreport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="salesreport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="salesreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&party=<?php echo $party; ?>&code=<?php echo $code; ?>&desc=<?php echo $desc; ?>">Reset All Filters</a>
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
 <td>Customer</td>
 <td><select name="party" id="party" onchange="reloadpage();">
     <option value="All">All</option>
	 <?php 
	 include "config.php";
	 $query = "select distinct(party) from oc_cobi order by party";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['party']; ?>" <?php if($party == $rows['party']) { ?> selected="selected" <?php } ?>><?php echo $rows['party']; ?></option>
	 <?php } ?>
	 </select>
 </td>
 <td>Code</td>
 <td><select name="code" id="code" onchange="itemselect(this.value);reloadpage();">
     <option value="All">All</option>
	 <?php 
	 $query = "select distinct(code),description from oc_cobi order by code";
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
	 $query = "select distinct(description),code from oc_cobi order by description";
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Customer Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Customer Code</td>
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
		Invoice
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Invoice</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Book Invoice
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Book Invoice</td>
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
		Free Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Free Quantity</td>
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
if($party == "All")
{
$a = '';
}
else
{
$a = "party = '$party' and";
}
if($code == "All")
{
$b = '';
}
else
{
$b = "and code = '$code'";
}
$tfqty = 0;
$tquantity = 0;
$grandtotal = 0;
$tdis = 0;
$query = "select distinct(invoice) as invoice from oc_cobi where $a date between '$fromdate' and '$todate' $b group by invoice order by party,invoice,code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
$invoice = $rows['invoice'];


$query2  = "select * from oc_cobi where invoice = '$invoice' order by party,code";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$count = mysql_num_rows($result2);
while($rows2 = mysql_fetch_assoc($result2))
{
$party = $rows2['party'];
$partycode = $rows2['partycode'];
$date = $rows2['date'];
$bookinvoice = $rows2['bookinvoice'];
$code = $rows2['code'];
$desc = $rows2['description'];
$units = $rows2['units'];
$quantity = $rows2['quantity'];
$freequantity = $rows2['freequantity'];
$price = $rows2['price'];
$gtotal = $rows2['finaltotal'];
$discount = $rows2['idiscount'];
$itype = $rows2['itype'];
$disamount = $rows2['discountamount'];
if($itype == "%")
{
$amt = $quantity * $price;
$discount = ($discount/ 100)* $amt;
}
if($discount == '' && $itype == '')
{
$discount = $disamount / $count;
}

$tdis += $discount;
$query1 = "select sum(quantity) as totalquantity,sum(freequantity) as tfquantity from oc_cobi where invoice = '$invoice' order by party,invoice,code";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
$tqty1 = $rows1['totalquantity'];
$tfquantity = $rows1['tfquantity'];


?>
	<tr>
		<td class="ewRptGrpField3" align="left">
<?php if($dupcheck <> $party) {  echo ewrpt_ViewValue($party);  } else { echo ewrpt_ViewValue("&nbsp;"); }  ?></td>
		<td class="ewRptGrpField3" align="left">
<?php if($dupcheck1 <> $partycode) { echo ewrpt_ViewValue($partycode); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
		<td class="ewRptGrpField1" align="left">
<?php if($dupcheck2 <> $date) { echo ewrpt_ViewValue(date($datephp,strtotime($date))); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="left">
<?php if($dupcheck3 <> $invoice) { echo ewrpt_ViewValue($invoice); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck4 <> $bookinvoice) { echo ewrpt_ViewValue($bookinvoice); } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($code);  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($desc);  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($units); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($quantity); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($freequantity); $tfqty += $freequantity; ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($price); ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck10 <> $invoice) { echo ewrpt_ViewValue($tqty1); $tquantity += $tqty1; } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($dupcheck11 <> $invoice) { echo ewrpt_ViewValue($gtotal); $grandtotal += $gtotal; } else { echo ewrpt_ViewValue("&nbsp;"); } ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round($discount,2)); ?></td>
	</tr>
<?php
$dupcheck = $party;
$dupcheck1 = $partycode;
$dupcheck2 = $date;
$dupcheck3 = $invoice;
$dupcheck4 = $invoice;
$dupcheck5 = $code;
$dupcheck6 = $desc;
$dupcheck7 = $units;
$dupcheck10 = $invoice;
$dupcheck11 = $invoice;
}
}
}
?>
	</tbody>
	<tfoot>
<tr>
<td class="ewRptGrpField1" align="left">
<b><?php echo ewrpt_ViewValue(Total);  ?></b></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue();  ?></td>
<td class="ewRptGrpField1" align="right">
<b><?php echo ewrpt_ViewValue($tfqty); ?></b></td>
<td class="ewRptGrpField1" align="right">
<b><?php $tper = $grandtotal / $tquantity; echo ewrpt_ViewValue(round($tper,2));  ?></b></td>
<td class="ewRptGrpField1" align="right">
<b><?php echo ewrpt_ViewValue(round($tquantity,2));  ?></b></td>
<td class="ewRptGrpField1" align="right">
<b><?php echo ewrpt_ViewValue(round($grandtotal,2));  ?></b></td>
<td class="ewRptGrpField1" align="right">
<b><?php echo ewrpt_ViewValue(round($tdis,2));  ?></b></td>
</tr>

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
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value;
	var desc = document.getElementById('desc').value;
	
	document.location = "salesreport.php?fromdate=" + fdate + "&todate=" + tdate + "&party=" + party + "&code=" + code + "&desc=" + desc;
	<?php 
	$party = $_GET['party'];
	if($party != '')
	{
	$party = $party;
	}
	else
	{
	$party = "All";
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