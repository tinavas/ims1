<?php 
$sExport = @$_GET["export"]; 
 
$a9=date("d.m.Y");
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php"; 

$vendor = $_GET['vendor'];

$item = $_GET['item'];

$porder = $_GET['porder'];

$greceipt = $_GET['greceipt'];



$description = $_GET['description'];

$warehouse = $_GET['warehouse'];



$vop = $po= $iop = $dop = $grop = $geop = $wop = "=";

if($vendor == "")
 $vendor = "All";
 
if($item == "")
 $item = "All";
 
 if($porder == "")
 $porder = "All";
 
 if($greceipt == "")
 $greceipt = "All";
 
 if($gentry == "")
 $gentry = "All";
 
 if($warehouse == "")
 $warehouse = "All";
 
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
 
 if($warehouse == "All")
 $wop = "<>";
 
 
 if($greceipt == "All")
  $grop = "<>";
  
 
 
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
 <td colspan="0" align="center"><strong><font color="#3e3276">Goods Receipt Report</font></strong></td>
</tr>

<?php if($vendor <> "All") { ?>
<tr>
 <td colspan="0" align="center"><strong><font color="#3e3276">Vendor : </font></strong><?php echo $vendor; ?></td>
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

&nbsp;&nbsp;<a href="goodsreceiptreport.php?export=html&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&poorder=<?php echo $_GET['poorder'];?>&greceipt=<?php echo $_GET['greceipt'];?>&warehouse=<?php echo $_GET['warehouse'];?>">Printer Friendly</a>

&nbsp;&nbsp;<a href="goodsreceiptreport.php?export=excel&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&poorder=<?php echo $_GET['poorder'];?>&greceipt=<?php echo $_GET['greceipt'];?>&warehouse=<?php echo $_GET['warehouse'];?>">Export to Excel</a>

&nbsp;&nbsp;<a href="goodsreceiptreport.php?export=word&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>&poorder=<?php echo $_GET['poorder'];?>&greceipt=<?php echo $_GET['greceipt'];?>&warehouse=<?php echo $_GET['warehouse'];?>">Export to Word</a>

<?php if ($bFilterApplied) { ?>

&nbsp;&nbsp;<a href="goodsreceiptreport.php?cmd=reset&vendor=<?php echo $vendor; ?>&item=<?php echo $item; ?>&description=<?php echo $description; ?>&fromdate=<?php echo $_GET['fromdate'];?>&todate=<?php echo $_GET['todate'];?>">Reset All Filters</a>

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


	 <option value="All" <?php if($vendor == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(vendor) FROM pp_goodsreceipt ORDER BY vendor ASC";

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

    

	 <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(code) FROM pp_goodsreceipt ORDER BY code ASC";

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

 <td><select name="description" id="description" style="width:193px" onchange="getcode(); reloadpage();">


	 <option value="All" <?php if($item == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(code),description FROM pp_goodsreceipt ORDER BY description ASC";

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
 <td colspan="4"></td>
 <td>Goods Receipt</td>
 <td><select name="gr" id="gr" style="width:193px" onchange="reloadpage();">

     
	 <option value="All" <?php if($greceipt == 'All' ) { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(gr) FROM pp_goodsreceipt where date>='$fromdate' and date<='$todate' ORDER BY gr ASC ";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['gr']; ?>" <?php if($greceipt == $rows['gr']) { ?> selected="selected" <?php } ?>><?php echo $rows['gr']; ?></option>

	 <?php

	 }

	 ?>

     </select> </td>
	 
 <td>Purchase Order</td>
 <td><select name="po" id="po" style="width:193px" onchange=" reloadpage();">

    
	 <option value="All" <?php if($porder == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(po) FROM pp_goodsreceipt where date>='$fromdate' and date<='$todate' ORDER BY po ASC ";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['po']; ?>" <?php if($porder == $rows['po']) { ?> selected="selected" <?php } ?>><?php echo $rows['po']; ?></option>

	 <?php

	 }

	 ?>

     </select> </td>
	 <td>Warehouse</td>
	<td><select name="wh" id="wh" style="width:193px" onchange=" reloadpage();">

	 <option value="All" <?php if($warehouse == 'All') { ?> selected="selected" <?php } ?>>All</option>

	 <?php

	 $query = "SELECT distinct(warehouse) FROM pp_goodsreceipt where date>='$fromdate' and date<='$todate' ORDER BY warehouse ASC ";

	 $result = mysql_query($query,$conn1) or die(mysql_error());

	 while($rows = mysql_fetch_assoc($result))

	 {

	 ?>

	 <option value="<?php echo $rows['warehouse']; ?>" <?php if($warehouse == $rows['warehouse']) { ?> selected="selected" <?php } ?>><?php echo $rows['warehouse']; ?></option>

	 <?php

	 }

	 ?>

     </select></td>

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

		GR Date

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:80px;" align="center" title="Goods Receipt Date">GR Date</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">

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

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		Goods Receipt No.

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:60px;" align="center">Goods Receipt No.</td>

			</tr></table>

		</td>

<?php } ?>


<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">

		PO No.

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:100px;" align="center">PO No.</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:80px;" align="center">

		Item Code

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:80px;" align="center" >Item Code</td>

			</tr></table>

		</td>

<?php } ?>

<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Description

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" >Description</td>

			</tr></table>

		</td>

<?php } ?>



<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader" style="width:70px;" align="center">

		Received Qty.

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td style="width:70px;" align="center" >Received Qty.</td>

			</tr></table>

		</td>

<?php } ?>




	</tr>

	</thead>

	<tbody>

	

<?php



$oldvendor = $newvendor = ""; 

 $query = "SELECT * FROM pp_goodsreceipt WHERE client = '$client' and date >='$fromdate' and date <= '$todate' AND vendor $vop '$vendor' AND code $iop '$item' AND po $po '$porder'  AND gr $grop '$greceipt' AND warehouse $wop '$warehouse'  ORDER BY vendor,date,warehouse,gr,ge,po,code";

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

<?php if(($datesample <> $oldcode) ){ echo ewrpt_ViewValue($datesample);

     $oldcode = $datesample;  }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>



<td<?php echo $sItemRowClass; ?>>

<?php if(($rows['warehouse'] <> $oldcode1)){ echo ewrpt_ViewValue($rows['warehouse']);

     $oldcode1 = $rows['warehouse']; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>

	 

		
<td class="ewRptGrpField2">

<?php 

	 echo ewrpt_ViewValue($rows['gr']);

	 ?>
</td>
	

		<td class="ewRptGrpField3" align="left">

<?php echo ewrpt_ViewValue($rows['po']); ?></td>

		<td class="ewRptGrpField1" align="right" style="padding-right:15px">

<?php echo ewrpt_ViewValue($rows['code']); ?></td>



		<td class="ewRptGrpField2" align="right" style="padding-right:15px;">

<?php echo ewrpt_ViewValue($rows['description']); ?></td>


<td class="ewRptGrpField2" align="right" style="padding-right:15px;">

<?php echo changeprice($rows['receivedquantity']) ?></td>

	
		

	</tr>

<?php

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


<?php } ?>
<?php include "phprptinc/footer.php"; ?>
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

	var warehouse = document.getElementById('wh').value;
	var vendor = document.getElementById('vendor').value;

	var item1 = document.getElementById('item').value;
	var porder = document.getElementById('po').value;
	var greceipt = document.getElementById('gr').value;
	

    var w = document.getElementById("description").selectedIndex; 

    var description = document.getElementById("description").options[w].text;


	document.location = "goodsreceiptreport.php?vendor=" + vendor + "&item=" + item1 + "&description=" + description  + "&fromdate="+from +"&todate="+to+"&porder="+porder+"&warehouse="+warehouse+"&greceipt="+greceipt;

}

</script>