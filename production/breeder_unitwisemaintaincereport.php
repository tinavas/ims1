<?php 
if($currencyunits == "")
{
$currencyunits = "Rs";
}

$sExport = @$_GET["export"]; 
include "reportheader.php"; 
$cond = "";
$unit = $_GET['unit'];
if($unit == "")
 $unit = 'All';
elseif($unit <> 'All')
 $cond .= "AND unit = '$unit' ";
$monthcnt = $_GET['month'];
if($monthcnt == "")
 $monthcnt = date("m");
$year = $_GET['year'];
if($year == "")
 $year = date("Y");
$fromdate = $year."-".$monthcnt."-01";
$monthenddate = date("t",strtotime($fromdate));	//It gives no. of days in a month
$todate = $year."-".$monthcnt."-".$monthenddate;
$cond .= "AND  fromdate = '$fromdate' AND todate = '$todate' ";
$type = $_GET['type'];
$expense = $_GET['expense'];
if($expense == "")
 $expense = 'All';
elseif($expense <> 'All')
 $cond .= "AND description = '$expense'";
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits;?></p></center>
<?php include "phprptinc/ewrcfg3.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn3.php"; ?>
<?php include "phprptinc/header.php"; ?>
<?php include "getemployee.php";?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Unit wise Maintaince Cost</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>Month : </strong><?php echo date("F",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong>Year : </strong><?php echo date("Y",strtotime($fromdate)); ?></td>
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
<?php 
$url = "&fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;
$url1 = "?fromdate=" . $fromdate . "&todate=" . $todate . "&warehouse=" . $warehouse ."&cat=" . $cat;
?>


<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="breeder_unitwisemaintaincereport.php?export=html&unit=<?php echo $unit; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&expense=<?php echo $expense; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="breeder_unitwisemaintaincereport.php?export=excel&unit=<?php echo $unit; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&expense=<?php echo $expense; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="breeder_unitwisemaintaincereport.php?export=word&unit=<?php echo $unit; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&expense=<?php echo $expense; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="breeder_unitwisemaintaincereport.php?cmd=reset&unit=<?php echo $unit; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>&expense=<?php echo $expense; ?>">Reset All Filters</a>
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
  <td>Unit&nbsp;&nbsp;</td>
  <td>
   <select id="unit" name="unit" onchange="reloadpage()">
   <option value="All" <?php if($unit == "All") { ?> selected="selected" <?php } ?>>All</option>
   <?php
   if($type == ""){
    $query = "SELECT distinct(unitcode) FROM breeder_unit WHERE client = '$client' ORDER BY unitcode"; } else {
	$query = "SELECT distinct(sector) as unitcode FROM tbl_sector WHERE client = '$client' and type1 = 'Feedmill'"; } 
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	 ?>
	 <option value="<?php echo $rows['unitcode']; ?>" <?php if($unit == $rows['unitcode']) { ?> selected="selected" <?php } ?>><?php echo $rows['unitcode']; ?></option>
	 <?php
	}
    ?>
	</select>	
 <td>Month</td>
 <td>
<select name="month" id="month" onchange="reloadpage();">
<option value="">--Select--</option>
<option  value="01"<?php if($monthcnt == 01){ ?> selected="selected"<?php } ?>>January</option>
<option  value="02"<?php if($monthcnt == 02){ ?> selected="selected"<?php } ?>>February</option>
<option  value="03"<?php if($monthcnt == 03){ ?> selected="selected"<?php } ?>>March</option>
<option  value="04"<?php if($monthcnt == 04){ ?> selected="selected"<?php } ?>>April</option>
<option  value="05"<?php if($monthcnt == 05){ ?> selected="selected"<?php } ?>>May</option>
<option  value="06"<?php if($monthcnt == 06){ ?> selected="selected"<?php } ?>>June</option>
<option  value="07"<?php if($monthcnt == 07){ ?> selected="selected"<?php } ?>>July</option>
<option  value="08"<?php if($monthcnt == 08){ ?> selected="selected"<?php } ?>>August</option>
<option  value="09"<?php if($monthcnt == 09){ ?> selected="selected"<?php } ?>>September</option>
<option  value="10"<?php if($monthcnt == 10){ ?> selected="selected"<?php } ?>>October</option>
<option  value="11"<?php if($monthcnt == 11){ ?> selected="selected"<?php } ?>>November</option>
<option  value="12"<?php if($monthcnt == 12){ ?> selected="selected"<?php } ?>>December</option>
</select>
 </td>
 <td>Year&nbsp;&nbsp;</td>
 <td>
<select name="year" id="year" onchange="reloadpage();">
<option value="">--Select--</option>
<option value="2011"<?php if($year == "2011"){ ?> selected="selected"<?php } ?>>2011</option>
<option value="2012"<?php if($year == "2012"){ ?> selected="selected"<?php } ?>>2012</option>
<option value="2013"<?php if($year == "2013"){ ?> selected="selected"<?php } ?>>2013</option>
<option value="2014"<?php if($year == "2014"){ ?> selected="selected"<?php } ?>>2014</option>
</select>
 </td>
 <td>Expense&nbsp;&nbsp;</td>
 <td>
  <select id="desc" name="desc" onchange="reloadpage();">
   <option value="All" <?php if($expense == "All") { ?> selected="selected" <?php } ?>>All</option>
  <?php
  $query = "SELECT code,description FROM ac_coa WHERE schedule = 'Indirect Expenses' AND client = '$client' ORDER BY description";
  $result = mysql_query($query,$conn1) or die(mysql_error());
  while($rows = mysql_fetch_assoc($result))
  {
   ?>
   <option value="<?php echo $rows['description']; ?>" title="<?php echo $rows['description']; ?>" <?php if($expense == $rows['description']) { ?> selected="selected" <?php } ?>><?php echo $rows['description']; ?></option>
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
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Code</td>
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
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:80px;" align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
if($type == "") { $ut = "and unit NOT IN (select distinct(sector) from tbl_sector where type1 = 'Feedmill')"; } else {
$ut = "and unit IN (select distinct(sector) from tbl_sector where type1 = 'Feedmill')"; } 
$query = "SELECT unit,code,description,amount FROM breeder_unitwisemaintaincecost WHERE client = '$client' $ut $cond ORDER BY fromdate";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['unit']) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['code']); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['description']); ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo ewrpt_ViewValue(changeprice($rows['amount'])); ?></td>
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
function reloadpage()
{
	var unit1 = document.getElementById('unit').value;
	var month = document.getElementById('month').value;
	var year = document.getElementById('year').value;
	var expense = document.getElementById('desc').value;
	var type = "<?php echo $type;?>";
	<?php if($type == "") { ?>
	document.location = "breeder_unitwisemaintaincereport.php?unit=" + unit1 + "&month=" + month + "&year=" + year + "&expense=" + expense; <?php } else { ?>
		document.location = "breeder_unitwisemaintaincereport.php?unit=" + unit1 + "&month=" + month + "&year=" + year + "&expense=" + expense + "&type=" + type; <?php } ?>
}
</script>