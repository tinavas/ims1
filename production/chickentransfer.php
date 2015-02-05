<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
$unit = $_GET['unit'];
if($unit == "" or $unit == 'All')
{
 $unit = "All";
 $cond = "unit <> '$unit'";
}
else
 $cond = "unit = '$unit'";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Processing Day Sheet</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Unit: </font></strong><?php echo $unit; ?></td>
</tr> 
<tr height="5px"></tr>
<tr>
 <td align="center"><strong><font color="#3e3276">Date: </font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?></td>
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



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="chickentransfer.php?export=html&fromdate=<?php echo $fromdate; ?>&unit=<?php echo $unit; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chickentransfer.php?export=excel&fromdate=<?php echo $fromdate; ?>&unit=<?php echo $unit; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chickentransfer.php?export=word&fromdate=<?php echo $fromdate; ?>&unit=<?php echo $unit; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chickentransfer.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&unit=<?php echo $unit; ?>">Reset All Filters</a>
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
 <td>Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td width="10px"></td>
 <td>Unit</td>
 <td><select id="unit" name="unit" onchange="reloadpage()">
 <option value="All" <?php if($unit == 'All') { ?> selected="selected" <?php } ?>>All</option>
<?php
 $q1 = "SELECT * FROM tbl_sector WHERE (type1 = 'Processing Unit') and client = '$client' order by sector";
 $r1 = mysql_query($q1,$conn1);
 $n1 = mysql_num_rows($r1);
 while($row1 = mysql_fetch_assoc($r1))
 {
?>
<option value="<?php echo $row1['sector']; ?>" <?php if($unit == $row1['sector']) { ?> selected="selected" <?php } ?>><?php echo $row1['sector']; ?></option>
<?php } ?>
</select></td>
</tr>
</table>	  
<?php } ?>
<table align="center">
<?php
$date1 = date("Y-m-d",strtotime($fromdate));
$query = "select distinct(fromtype) from  chicken_chickentransfer where date =  '$date1' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $cat[$rows['fromtype']] = 0;
$ab1=0;
$query = "select distinct(tid) as tid from  chicken_chickentransfer where date =  '$date1' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
	$tid1=$rows['tid'];
	
 if($_SESSION['db']=="vista") 
 $q2 = "select sum(kgs) as qt, weight  from chicken_chickentransfer where  client = '$client'  and tid='$tid1' group by tid";
else
$q2 = "select weight  from chicken_chickentransfer where  client = '$client'  and tid='$tid1' group by tid";


$r2 = mysql_query($q2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_array($r2)){

	$weight=$weight+$rows2['weight'];
	$qt=$qt+$rows2['qt'];
  }
 $q2 = "select fromtype,birds,weight from chicken_chickentransfer where tid = '$rows[tid]' and client = '$client' LIMIT 1";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($r2))
  $cat[$rows2['fromtype']] += $rows2['birds'];
 
}
$query = "select distinct(fromtype) from  chicken_chickentransfer where date =  '$date1' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
<tr>

<?php if($_SESSION['db']=="vista") { ?>
 <td><strong><?php echo $rows['fromtype']."/(pieces)"; ?></strong></td>
 <?php } else {?>
  <td><strong><?php echo $rows['fromtype']; ?></strong></td>
 <?php } ?>
 <td><?php echo $ab=$cat[$rows['fromtype']]; ?></td>
 
 
<?php
}
?>

<td><strong>Weight:</strong></td>
 
 
 <td><?php echo $weight;?></td>
</tr>
<?php if($_SESSION['db']=="vista") { ?>
<tr><td><strong>Shrinkage</strong></td><td><?php echo $per=$weight-$qt;?></td>
<td><strong>Shrinkage Percent</strong></td>
<td><?php echo round(($per/$weight)*100,2);?></td>
<td>&nbsp;</td>
<td>&nbsp;</td></tr>
<?php } ?>
</table>
</div>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		To Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">To Category</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		<?php if($_SESSION['db']=="vista") {?>Pieces <?php } else { ?> Quantity<?php } ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php if($_SESSION['db']=="vista") {?>Pieces <?php } else { ?> Quantity<?php } ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		<?php if($_SESSION['db']=="vista") {?>Weight(Kgs) <?php } else { ?> Kgs<?php } ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php if($_SESSION['db']=="vista") {?>Weight(Kgs) <?php } else { ?> Kgs<?php } ?></td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$date1 = date("Y-m-d",strtotime($fromdate));
$query = "select * from chicken_chickentransfer where date =  '$date1' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
	<tr>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows['category']); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($rows['tocode']); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows['todescription']) ?></td>
		<td class="ewRptGrpField3" align="right" style="padding-right:15px;">
<?php $q=$q+$rows['quantity']; echo ewrpt_ViewValue($rows['quantity']); ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php $k=$k+$rows['kgs']; echo ewrpt_ViewValue($rows['kgs']); ?></td>
	</tr>
<?php
}
?>
<tr><td colspan="3" align="right">Total</td>
<td align="right" ><?php echo round($q) ;?></td>
<td align="right"><?php echo round($k) ;?></td>
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
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var unit1 = document.getElementById('unit').value
	document.location = "chickentransfer.php?fromdate=" + fdate + "&unit=" + unit1;
}
</script>