<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'])
{
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
 $todate = date("Y-m-d",strtotime($_GET['todate']));
}
else
{
 $fromdate = date("Y-m-d"); 
 $todate = date("Y-m-d");
 }
 $fcr = $_GET['fcr'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">FCR Rate Details</font></strong></td>
</tr>
<!--<tr height="5px"></tr>
<tr>
 <td><strong>Date : </strong>&nbsp;<?php echo date("d.m.Y",strtotime($fromdate)); ?></td><td><strong> To Date </strong>&nbsp;
 &nbsp;<?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr>--> 
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
&nbsp;&nbsp;<a href="fcrratedetails.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&fcr=<?php echo $fcr; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="fcrratedetails.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&fcr=<?php echo $fcr; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="fcrratedetails.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&fcr=<?php echo $fcr; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="fcrratedetails.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&fcr=<?php echo $fcr; ?>">Reset All Filters</a>
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
 <!--<td>Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
  <td>&nbsp;&nbsp;To Date </td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>-->
 <td>&nbsp;&nbsp;FCR </td>
 <td>&nbsp;&nbsp;<select id="fcr" name="fcr" style="width:80px" onchange="reloadpage()">
<option value="">-Select-</option>
<?php 
$result = mysql_query("select distinct(FCR) from broiler_fcrrate order by FCR",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
?>
<option value="<?php echo $res['FCR'];?>" <?php if($fcr==$res['FCR']){?> selected="selected"<?php } ?>><?php echo $res['FCR'];?></option>
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
		<td valign="bottom" class="ewTableHeader" >
		From Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">From Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		To Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">To Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		From Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">From Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		To Weight
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">To Weight</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		From FCR
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">From FCR</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		To FCR
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">To FCR</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		FCR Rate
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td align="center">FCR Rate</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
/*$query = "select * from broiler_fcrrate where  '$fromdate' between fromdate and todate ";*/
$result = mysql_query("select * from broiler_fcrrate where '$fcr' between FCR and fcrto order by fromdate",$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{ 
?> 
	<tr>
		<td >
<?php echo date("d.m.Y",strtotime($res['fromdate'])); ?></td>
		<td >
<?php echo date("d.m.Y",strtotime($res['todate'])); ?></td>
		
<td><?php echo $res['fromweight']; ?></td>
<td><?php echo $res['toweight']; ?></td>		
<td><?php echo $res['FCR']; ?></td>
<td><?php echo $res['fcrto']; ?></td>
<td ><?php echo $res['FCRRATE']; ?></td>
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
	/*var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;*/
	var fcr = document.getElementById('fcr').value;
	document.location = "fcrratedetails.php?fcr=" + fcr;
}
</script>