


<?php 
include "config.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 

$flock = $_GET['flock'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">&nbsp;Medicine/Vaccine Consumption of Flock <?php echo $flock;?></font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>&nbsp; </strong></td>
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
&nbsp;&nbsp;<a href="#" onclick="reloadpage('html');">Printer Friendly</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('excel');">Export to Excel</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('word');">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatcheryreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
<?php } ?>
<?php } else { ?>
<center><b>Shed Type: <?php echo $_GET['type']; ?></b></center><br />
<?php } ?>

<?php if (@$sExport == "") { ?>
<br /><br />
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

<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Medicine/Vaccine
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Medicine/Vaccine</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Consumption</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Units</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
	<?php 
	

	 
//$i =0;	
//$preshed = "";
$date = "";$odate = "";$fdate = "";$cdate = "";
$query = "select distinct(date2),itemdesc,itemcode,quantity,units from breeder_consumption where flock LIKE '%$flock' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))	
{ 
$date = date("d.m.Y",strtotime($res['date2']));
if($fdate == "")
{
$fdate = $date;
$odate = $date;
$cdate = $date;
}
else
{
if($odate == $date)
{
$cdate == "";
}
else
{
$odate = $date;
$cdate = $date;
}
}
?>
	<tr>
<td><?php echo $cdate; ?></td>
<td><?php echo $res['itemdesc']; ?></td>		
<td><?php echo $res['itemcode']; ?></td>
<td align="right"><?php echo $res['quantity']; ?></td>
<td><?php echo $res['units']; ?></td>
	</tr>
<?php
//$i++;
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
function reloadpage(opt)
{
	var unitcode = document.getElementById('unit').value;
	var type = document.getElementById('type').value;
	document.location = "breeder_unitsheddetails.php?unitcode=" + unitcode + "&type=" + type + "&export=" + opt;
}

</script>