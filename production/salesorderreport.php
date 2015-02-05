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
$vendor = $_GET['vendor'];
$item = $_GET['item'];
$description = $_GET['description'];
$hatchery = $_GET['hatchery'];
if(($_GET['fromdate'] == "") OR ($_GET['todate'] == ""))
{
 
  $fromdate = date("Y-m-d");
  $todate = date("Y-m-d");

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

 if($_GET['fdd'] <> "")
 {
$fdd=$_GET['fdd'];
}
else
 {
 $fdd=date("Y-m-d");
}
 if($_GET['tdd'] <> "")
 {
$tdd=$_GET['tdd'];
}
else
 {
 $tdd=date("Y-m-d");
}

//echo $fdd,"<br/>";
//echo $tdd,"<br/>";
 $datecond="and deliverydate >= '$fdd' and deliverydate <= '$tdd' "



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
&nbsp;&nbsp;<a href="salesorderreport.php?export=html&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&fdd=<?php echo $fdd;?>&tdd=<?php echo $tdd;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="salesorderreport.php?export=excel&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&fdd=<?php echo $fdd;?>&tdd=<?php echo $tdd;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="salesorderreport.php?export=word&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&fdd=<?php echo $fdd;?>&tdd=<?php echo $tdd;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="salesorderreport.php?cmd=reset&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&hatchery=<?php echo $hatchery; ?>&fdd=<?php echo $fdd;?>&tdd=<?php echo $tdd;?>">Reset All Filters</a>
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
<input type="text" class="datepicker" id="fromdate" name="fromdate" size="8" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>" onchange="reloadpage();"/>
</td>
<td>To Date</td>
<td>
<input type="text" class="datepicker" id="todate" name="todate" size="8" value="<?php echo date("d.m.Y",strtotime($todate)); ?>" onchange="reloadpage();"/></td>

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
 
 <td>From Delivery Date</td>
 <td><select name="fdd" id="fdd" style="width:100px;" onchange="reloadpage();">
     <option value="" >-select-</option>
	 <?php
	 $query = "SELECT distinct(deliverydate) as dd FROM oc_salesorder ORDER BY date desc";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['dd']; ?>" <?php if($fdd == $rows['dd']) { ?> selected="selected" <?php } ?>>
	<?php echo date("d.m.Y",strtotime($rows['dd'])); ?></option>
	 <?php
	 }
	 ?>
     </select> 
 </td>
 
  <td>To Delivery Date</td>
 <td><select name="tdd" id="tdd" style="width:100px;" onchange="reloadpage();">
     <option value="" >-select-</option>
	 <?php
	 $query = "SELECT distinct(deliverydate) as dd FROM oc_salesorder ORDER BY date desc";
	 $result = mysql_query($query,$conn1) or die(mysql_error());
	 while($rows = mysql_fetch_assoc($result))
	 {
	 ?>
	 <option value="<?php echo $rows['dd']; ?>" <?php if($tdd == $rows['dd']) { ?> selected="selected" <?php } ?>>
	<?php echo date("d.m.Y",strtotime($rows['dd'])); ?></option>
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
		<td valign="bottom" class="ewTableHeader"  align="center">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Customer</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		SO Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center" title="Sales Order Date">SO Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Delivery Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center">Delivery Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Sales Order
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Sales Order</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Mode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Mode</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:60px;" align="center">Item</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">
		Ordered <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center" title="Ordered Quantity">Ordered <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Sent <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Sent <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>.</td>
			</tr></table>
		</td>
<?php } ?>

<?php if($_SESSION['db']=="vista") { ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Pieces
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Pieces</td>
			</tr></table>
		</td>
<?php } ?>

<?php }  ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Price</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Amount</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Delivery Time
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Delivery Time</td>
			</tr></table>
		</td>
<?php } ?>


<?php if($_SESSION['db']=="vista")
{ ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Terms And Conditions
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Terms And Conditions</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">
		Remarks
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:70px;" align="center" title="Sent Quantity">Remarks</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>

	</tr>
	</thead>
	<tbody>
	
<?php

$oldvendor = $newvendor = ""; 
  $query = "SELECT * FROM oc_salesorder WHERE client = '$client' AND vendor $vop '$customer' AND code $iop '$item' and date >= '$fromdate' and date <= '$todate' $datecond  ORDER BY vendor,date,po,code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $rows['rateperunit'];
if($oldvendor == $rows['vendor'])
 $newvendor = "";
else
{
 $newvendor = $oldvendor = $rows['vendor']; 
}

?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($newvendor) ?></td>
<?php $datesample = date("d.m.Y",strtotime($rows['date']));?>
	<td<?php echo $sItemRowClass; ?>>
<?php if(($datesample <> $oldcode) || ($newvendor <> "")){ echo ewrpt_ViewValue($datesample);
     $oldcode = $datesample; $dumm = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?></td>
<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($rows['deliverydate']))); ?></td>
<td<?php echo $sItemRowClass; ?>>
<?php if(($rows['po'] <> $oldcode1) or ($dumm11 == 0)){ echo ewrpt_ViewValue($rows['po']);
     $oldcode1 = $rows['po']; $dumm11 = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
	   <td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['mode']) ?></td>
	 <td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['code']) ?></td>
		<td class="ewRptGrpField3" align="left">
<?php echo ewrpt_ViewValue($rows['description']); ?></td>
		<td class="ewRptGrpField1" align="right" >
<?php echo changeprice1($rows['quantity']); $totqty+=$rows['quantity']; ?></td>
<?php
 $query2 = "SELECT * from oc_packslip WHERE so ='$rows[po]' AND itemcode = '$rows[code]'   AND client = '$client'";
$result2 = mysql_query($query2,$conn1) ;
$rows2 = mysql_fetch_assoc($result2);
if($rows2['date'] <> "")
  $rdate = date("d.m.Y",strtotime($rows2['date']));
else
 $rdate = "Yet to be Delivered";

$rqty = $rows2['acceptedqty'] - $rows2['freequantity']; 
if($rqty == "")
 $rqty = "0" ;
 
 $totsqty += $rqty;
?>	    
		
		
		
		
		<td class="ewRptGrpField2" align="right" >
<?php 
$totsqty += $rows['sentquantity'];
 echo changeprice1($rows['sentquantity']); ?></td> 

<?php if($_SESSION['db']=="vista") { ?>
<td class="ewRptGrpField2" align="right" >
<?php
$totsqty1 +=$rows['packets'];

 echo changeprice1($rows['packets']); ?></td> 
<?php } ?>
		<td class="ewRptGrpField1" align="right" >
<?php echo changeprice($rows['rateperunit']); ?></td> 
		<td class="ewRptGrpField1" align="right" >
<?php echo changeprice($rows['finalcost']); $totamount += $rows['finalcost']; ?></td>
<td class="ewRptGrpField1" align="right" >
<?php echo $rows['deliverytime']; ?></td>
<?php if($_SESSION['db']=="vista") {?>
<td class="ewRptGrpField2" align="right" >
<?php  $acf=$rows['tandc']; if($acf=="") {
echo ewrpt_ViewValue("&nbsp;");	
} else {echo ewrpt_ViewValue($acf);	 } ?></td>

<td class="ewRptGrpField2" align="right" >
<?php  $acf1=$rows['remarks']; if($acf1=="") {
echo ewrpt_ViewValue("&nbsp;");	
} else {echo ewrpt_ViewValue($acf1);	 } ?></td>

<?php } ?>		
		
<?php
$goodsstatus = "Sales Order";
$querys = "SELECT ps FROM oc_packslip WHERE so = '$rows[po]' AND itemcode = '$rows[code]' LIMIT 1";
$results = mysql_query($querys,$conn1) or die(mysql_error());
$counts = mysql_num_rows($results);
if($counts > 0)
{
 $goodsstatus = "DC";
 $rowss = mysql_fetch_assoc($results);
	$querys = "SELECT invoice FROM oc_cobi WHERE ps = '$rowss[ps]' AND code = '$rows[code]' LIMIT 1";
	$results = mysql_query($querys,$conn1) or die(mysql_error());
	$counts = mysql_num_rows($results);
	if($counts > 0)
	{
	 $goodsstatus = "COBI";	
	 $rowsss = mysql_fetch_assoc($results);
	 $querys = "SELECT * FROM oc_receipt WHERE socobi = '$rowsss[invoice]' ";
	$results = mysql_query($querys,$conn1) or die(mysql_error());
	$counts = mysql_num_rows($results);
	if($counts > 0)
	$goodsstatus = "Receipt";
	}
	 
}
?>		

	</tr>
<?php
}
if($totqty > 0 or $totsqty > 0 or $totamount > 0)
{
?>
<tr><td align="right"><b>Total</b></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align="right"><?php echo changeprice1($totqty); ?></td><td align="right"><?php echo changeprice1($totsqty); ?> </td><td align="right" ><?php echo $totsqty1;?></td><td>&nbsp;</td><td align="right"><?php echo changeprice($totamount); ?></td></tr>
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
		var fdd = document.getElementById('fdd').value;
		var tdd = document.getElementById('tdd').value;
	document.location = "salesorderreport.php?vendor=" + vendor +"&item=" + item1 + "&description=" + description + "&fromdate=" + fdate + "&todate=" + tdate+"&fdd="+fdd+"&tdd="+tdd;
}
</script>