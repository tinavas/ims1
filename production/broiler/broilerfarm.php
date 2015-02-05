<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
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
<?php include "phprptinc/header.php";
include "../getemployee.php";
?>
<table align="center" border="0">
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Broiler Farms Details</font></strong></td>
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
$total=0;?>



<?php if (@$sExport == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0" align="center">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<?php } ?>
<?php if (@$sExport == "") { ?>
&nbsp;&nbsp;<a href="broilerfarm.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="broilerfarm.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="broilerfarm.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broilerfarm.php?cmd=reset">Reset All Filters</a>
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
<!--/*<table>
 <tr>
 <td>Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
</tr>
</table>*/-->	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Supervisor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Supervisor</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Place
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Place</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Farm Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Farm Code</td>	
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Farm
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Farm</td>
			</tr></table>
		</td>
<?php } ?>
	


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Farmer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Farmer</td>	
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
		Capacity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">Capacity</td>	
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
	
<?php
$q='select distinct(farm),supervisor,place,farmcode,farmer,capacity from broiler_farm order by supervisor,place,farm';
$r=mysql_query($q);
while($a=mysql_fetch_assoc($r)) 
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
       <?php  if($dup_sup==$a[supervisor]) echo '&nbsp;' ;
              else echo ewrpt_ViewValue($a[supervisor]);
	   $dup_sup=$a[supervisor]; ?></td>
		<td class="ewRptGrpField3"  style="padding-right:15px;">
<?php if($dup_place==$a[place]) echo '&nbsp;'; else echo ewrpt_ViewValue($a[place]); $dup_place=$a[place]; ?></td>
		
	<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($a[farmcode]) ?></td>
<td class="ewRptGrpField1"  style="padding-right:15px;">
<?php echo ewrpt_ViewValue($a[farm]); ?></td>
		<td class="ewRptGrpField3"  style="padding-right:15px;">
<?php echo ewrpt_ViewValue($a[farmer]); ?></td>
		<td  align="right">
<?php echo ewrpt_ViewValue(changeprice1($a[capacity])); $total+=$a[capacity]; ?></td>
	
	</tr>
<?php
}
?>
<tr>
	<td colspan="5" align="right"><b>Total</b></td>
	<td align="right"><b><?php echo changeprice1($total); ?></b></td>
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
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "broilerfarm.php?fromdate=" + fdate;
}
</script>