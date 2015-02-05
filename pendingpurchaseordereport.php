<?php 
$sExport = @$_GET["export"]; 


include "reportheader.php"; 
include "getemployee.php"; 
$vendor = $_GET['vendor'];
$item = $_GET['item'];

$porder = $_GET['porder'];

$dl = $_GET['dl'];

$description = $_GET['description'];

 $rcdate = $_GET['rcdate'];
 


$vop = $po= $iop = $dop = "=";
if($vendor == "")

 $vendor = "All";
 
 if($dl == "")
 $dl = "All";
 
if($item == "")
 $item = "All";
 
 if($porder == "")
 $porder = "All";
 
if($description == "")
 $description = "All";
 

 

 if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
 else
 $fromdate=date("Y-m-d");
 
 if($_GET['todate'] <>"")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
 
 else
 $todate=date("Y-m-d");


if($vendor == "All")
 $vop = "<>";
 
 if($porder == "All")
 $po = "<>";
 
if($item == "All")
 $iop = "<>"; 
 
 if($dl == "All")
 $dop = "<>"; 
 
 
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
 <td colspan="0" align="center"><strong><font color="#3e3276">Pending Purchase Order Report</font></strong></td>
</tr>

<?php if($vendor <> "All") { ?>
<tr>
 <td colspan="0" align="center"><strong><font color="#3e3276">Vendor : </font></strong><?php echo $vendor; ?></td>
</tr>
<?php }
if($dl <> "All") { ?>
<tr>
 <td colspan="0" align="center"><strong><font color="#3e3276">Delivery Location : </font></strong><?php echo $dl; ?></td>
</tr>
<?php }

if($item <> "All") { ?>
<tr>
 <td colspan="0" align="center"><strong><font color="#3e3276">Item Code : </font></strong><?php echo $item; ?>&nbsp;&nbsp;<strong><font color="#3e3276">Description : </font></strong><?php echo $description; ?></td>
</tr>
<?php } ?>
<tr><td colspan="0" align="center"><strong><font color="#3e3276">From : </font></strong><?php  echo date("d.m.Y",strtotime($fromdate));?></td>
<td colspan="0" align="center"><strong><font color="#3e3276">To : </font></strong><?php  echo date("d.m.Y",strtotime($todate)); ?></td></tr>
</table>
<?php
session_start();
$currencyunits=$_SESSION['currency'];
$client = $_SESSION['client'];

?>

<?php

$sExport = @$_GET["export"]; 



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

&nbsp;&nbsp;<a href="pendingpurchaseorder.php?export=html&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&dl=<?php echo $_GET['dl'];?>">Printer Friendly</a>

&nbsp;&nbsp;<a href="pendingpurchaseorder.php?export=excel&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&dl=<?php echo $_GET['dl'];?>">Export to Excel</a>

&nbsp;&nbsp;<a href="pendingpurchaseorder.php?export=word&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&dl=<?php echo $_GET['dl'];?>">Export to Word</a>

<?php if ($bFilterApplied) { ?>

&nbsp;&nbsp;<a href="pendingpurchaseorder.php?cmd=reset&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Reset All Filters</a>

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
 <td>Fromdate:</td><td><input type="text" name="da" style="width:100px" id="fromdate" onchange="reloadpage();"   value="<?php echo date("d.m.Y",strtotime($fromdate));?>" class="datepicker" /></td>

<td >Todate:</td><td><input type="text" name="da1" style="width:100px" id="todate" onchange="reloadpage();" value="<?php echo date("d.m.Y",strtotime($todate));?>" class="datepicker"  /></td>

 <td>Supplier</td>

 <td><select name="vendor" id="vendor" onchange="reloadpage();">

     <option value="select">-Select-</option>

	 <option value="All" <?php if($vendor == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(vendor) FROM pp_purchaseorder ORDER BY vendor ASC";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['vendor']; ?>" <?php if($vendor == $rows['vendor']) { ?> selected="selected" <?php } ?>><?php echo $rows['vendor']; ?></option>

	 <?php

	 }

	 ?>

	 </select>

 </td>

 <td>Item</td>

 <td><select name="item" id="item" onchange="getdesc(); reloadpage();">

     <option value="select">-Select-</option>

	 <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(code) FROM pp_purchaseorder ORDER BY code ASC";

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

 <td><select name="description" id="description" onchange="getcode(); reloadpage();">

     <option value="select">-Select-</option>

	 <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(code),description FROM pp_purchaseorder ORDER BY description ASC";

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

 </tr>
 <tr height="5px;">
 <td colspan="6"></td>
  <td>D.Location</td>
 <td><select name="dl" id="dl" style="width:193px" onchange=" reloadpage();">

     <option value="select">-Select-</option>

	 <option value="All" <?php if($dl == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(deliverylocation) FROM pp_purchaseorder where date>='$fromdate' and date<='$todate' ORDER BY po ASC ";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['deliverylocation']; ?>" <?php if($dl == $rows['deliverylocation']) { ?> selected="selected" <?php } ?>><?php echo $rows['deliverylocation']; ?></option>

	 <?php

	 }

	 ?>

     </select> </td>
 <td>Purchase Order</td>
 <td><select name="po" id="po" style="width:193px" onchange=" reloadpage();">

     <option value="select">-Select-</option>

	 <option value="All" <?php if($porder == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(po) FROM pp_purchaseorder where date>='$fromdate' and date<='$todate'  and flag!=1 ORDER BY po ASC ";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['po']; ?>" <?php if($porder == $rows['po']) { ?> selected="selected" <?php } ?>><?php echo $rows['po']; ?></option>

	 <?php

	 }

	 ?>

     </select> </td>


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

		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">

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

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		PO Date

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:80px;" align="center" title="Purchase Order Date">PO Date</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">

		Purchase Order

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:100px;" align="center">Purchase Order</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		Purchase Request Number

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:60px;" align="center">Purchase Request Number</td>

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

		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">

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

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		Ordered Qty.

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:80px;" align="center" title="Ordered Quantity">Ordered Qty.</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Rec. Qty

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" title="Received Quantity">Rec. Qty.</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Bal Qty

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" title="Received Quantity">Bal Qty.</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Rate

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" >Rate</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Value

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" >Value</td>

			</tr></table>

		</td>

<?php } ?>
<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		T. Date

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:80px;" align="center" title="Tentative Date">T. Date</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" title="Delivery Location"  align="center">

		D.Location

		</td>

<?php } else { ?>

		<td class="ewTableHeader" title="Delivery Location">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td  align="center">D.Location</td>

			</tr></table>

		</td>

<?php } ?>

	</tr>

	</thead>

	<tbody>

	

<?php


$oldvendor11 =$newvendor11 = "";
$oldvendor = $newvendor =  ""; 
$ordertotal = $rectotal = $baltotal = $valtotal = 0;

$query = "SELECT * FROM pp_purchaseorder WHERE client = '$client'  and grflag=0 and date >='$fromdate' and date <= '$todate' AND flag=1 and vendor $vop '$vendor' AND deliverylocation $dop '$dl' AND code $iop '$item' AND po $po '$porder' and quantity <> receivedquantity ORDER BY vendor,date,po,code";

$result = mysql_query($query,$conn1) or die(mysql_error());

while($rows = mysql_fetch_assoc($result))

{






?>


	<tr>

		<td class="ewRptGrpField2">
		
		<?php if(($rows['vendor'] <> $oldvendor) ){ echo ewrpt_ViewValue($rows['vendor']);

     $oldvendor = $rows['vendor']; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?></td>



<?php $datesample = date("d.m.Y",strtotime($rows['date']));?>

	<td<?php echo $sItemRowClass; ?>>

<?php if(($datesample <> $oldcode) || ($newvendor <> "")){ echo ewrpt_ViewValue($datesample);

     $oldcode = $datesample;
	 
	  }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>



<td<?php echo $sItemRowClass; ?>>

<?php if(($rows['po'] <> $oldcode1)){ echo ewrpt_ViewValue($rows['po']);

     $oldcode1 = $rows['po']; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>

	 

		
<td class="ewRptGrpField2">

<?php if(($rows['pr'] <> $oldcode12) ){ echo ewrpt_ViewValue($rows['pr']);

     $oldcode12 = $rows['pr']; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>
</td>
		<td class="ewRptGrpField2">

<?php echo ewrpt_ViewValue($rows['code']) ?></td>

		<td class="ewRptGrpField3" align="left">

<?php echo ewrpt_ViewValue($rows['description']); ?></td>

		<td class="ewRptGrpField1" align="right" >

<?php echo ewrpt_ViewValue($rows['quantity']); $ordertotal = $ordertotal + $rows['quantity'];?></td>




		<td class="ewRptGrpField2" align="right" >

<?php echo ewrpt_ViewValue($rows['receivedquantity']); $rectotal = $rectotal + $rows['receivedquantity']; ?></td>
<td class="ewRptGrpField2" align="right" >

<?php $balqty=$rows['quantity']-$rows['receivedquantity']; echo $balqty; $baltotal = $baltotal + $balqty; ?></td>

<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($rows['rateperunit']) ?></td>

<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($rows['quantity'] * $rows['rateperunit']); $valtotal = $valtotal + ($rows['quantity'] * $rows['rateperunit']); ?></td>

		<td class="ewRptGrpField3" align="center">

<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($rows['deliverydate']))); ?></td>

		
<td class="ewRptGrpField1" align="left">

<?php if($rows['deliverylocation'])echo $rows['deliverylocation']; else echo "&nbsp;"; ?>

</td>

	</tr>

<?php


}

?>
<tr>
<td colspan="6" align="right"><b>Total</b></td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($ordertotal) ?></td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($rectotal) ?></td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($baltotal) ?></td>
<td>&nbsp;
</td>
<td class="ewRptGrpField2" align="right" >

<?php echo changeprice($valtotal) ?></td>
<td colspan="4"></td>
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
var from=document.getElementById("fromdate").value;
var to=document.getElementById("todate").value;

var dl = document.getElementById("dl").value;


	var vendor = document.getElementById('vendor').value;

	var item1 = document.getElementById('item').value;
	var porder = document.getElementById('po').value;

    var w = document.getElementById("description").selectedIndex; 

    var description = document.getElementById("description").options[w].text;

	


	document.location = "pendingpurchaseordereport.php?vendor=" + vendor + "&item=" + item1 + "&description=" + description + "&fromdate="+from +"&todate="+to+"&porder="+porder+"&dl="+dl;


}

</script>