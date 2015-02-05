<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
?>
<script type="text/javascript">
function abc()
{
window.location="broilerfarm.php?supervisor="+document.getElementById("supervisor").value;
<?php 
echo $supervisor=$_GET['supervisor'];
if($supervisor=="")
{
$supervisor="All";
}
?>
}
</script>
</script>

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Supervisor Details</font></strong></td>
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
&nbsp;&nbsp;<a href="broilerfarm.php?export=html&supervisor=<?php echo $supervisor; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="broilerfarm.php?export=excel&supervisor=<?php echo $supervisor; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="broilerfarm.php?export=word&supervisor=<?php echo $supervisor; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broilerfarm.php?cmd=reset&supervisor=<?php echo $supervisor; ?>">Reset All Filters</a>
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
<td>Supervisor:</td><td><select id="supervisor" style="width:100px" name="supervisor" onchange="abc();">
    <option <?php if($supervisor=="All") {?> selected="selected" <?php } ?> value="All">All</option>
	<?php 
	echo $query0120 = "SELECT distinct(supervisor) FROM broiler_farm where supervisor != ''";
	echo $result0120 = mysql_query($query0120,$conn1) or die(mysql_error());
	while($rows0120 = mysql_fetch_assoc($result0120))
	{
	?>
	<option value="<?php echo $rows0120['supervisor']; ?>"<?php if($rows0120['supervisor'] == $supervisor) { ?> selected="selected"<?php } ?> ><?php echo $rows0120['supervisor']; ?></option>
	<?php } ?>
	</select></td></tr></table>



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
		Farm
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Farm</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
	
<?php
if($supervisor=="All")
{
$a="";
 } 
else
{
$supervisor;
$a="where supervisor='$supervisor'";
}
$q="select distinct(farm),supervisor,place from broiler_farm $a order by supervisor,place,farm";
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
<td class="ewRptGrpField1"  style="padding-right:15px;">
<?php echo ewrpt_ViewValue($a[farm]); ?></td>
		
	
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
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "broilerfarm.php?fromdate=" + fdate;
}
</script>