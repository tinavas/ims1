<?php 
include "config.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
$cullage = $_GET['cullage'];
if($cullage == '')
 $cullage = 0;
$gapdays = $_GET['gapdays'];
if($gapdays == '')
 $gapdays = 0;
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Tentative Flock Placement Report</font></strong></td>
</tr>
<tr height="5px"></tr>
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
&nbsp;&nbsp;<a href="quail_tentativeplacement.php?export=html&culldays=<?php echo $culldays; ?>&gapdays=<?php echo $gapdays; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_tentativeplacement.php?export=excel&culldays=<?php echo $culldays; ?>&gapdays=<?php echo $gapdays; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_tentativeplacement.php?export=word&culldays=<?php echo $culldays; ?>&gapdays=<?php echo $gapdays; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_tentativeplacement.php?cmd=reset&culldays=<?php echo $culldays; ?>&gapdays=<?php echo $gapdays; ?>">Reset All Filters</a>
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
<td>&nbsp;Cull Age(In Weeks)&nbsp;<input type="text" id="cullage" name="cullage" style="width:50px" value="<?php if($_GET['cullage']) echo $_GET['cullage']; else echo "0"; ?>" onblur="reloadpage();" />&nbsp;</td>
<td> Gap Days&nbsp;<input type="text" id="gapdays" name="gapdays" style="width:50px" value="<?php if($_GET['gapdays']) echo $_GET['gapdays']; else echo "0"; ?>" onblur="reloadpage();" /></td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Shed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Shed</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Age
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Age</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Tentative Cull Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Tentative Cull Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Tentative Placement
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Tentative Placement</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$query1 = "select distinct(farmcode) from quail_flock where cullflag = '0' and client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $farm = $dfarm = $rows1['farmcode'];
 $query2 = "select distinct(unitcode) from quail_flock where cullflag = '0' and farmcode = '$farm' and client = '$client'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
 $unit = $dunit = $rows2['unitcode'];
 $query3 = "select distinct(shedcode) from quail_flock where cullflag = '0' and farmcode = '$farm' and unitcode = '$unit' and client = '$client'";
 $result3 = mysql_query($query3,$conn1) or die(mysql_error());
 while($rows3 = mysql_fetch_assoc($result3))
 {
 $shed = $dshed = $rows3['shedcode'];
 $query4 = "select distinct(flockcode),age,startdate from quail_flock where cullflag = '0' and farmcode = '$farm' and unitcode = '$unit' and shedcode = '$shed' and client = '$client'";
 $result4 = mysql_query($query4,$conn1) or die(mysql_error());
 while($rows4 = mysql_fetch_assoc($result4))
 {
  $flock = $rows4['flockcode'];
  $startdate = $rows4['startdate'];
$age = $rows4['age']; 
  $time = (strtotime($startdate) - ($age * 24 * 60 * 60)) + (7 * $cullage * 24 * 60 * 60);
  $culldate = date($datephp,$time);
  $gaptime = $time + ($gapdays * 24 * 60 * 60);
  $gapdate = date($datephp,$gaptime);
$query5 = "select max(age) as age,max(date2) as date2 from quail_consumption where flock = '$flock' and client = '$client'";
  $result5 = mysql_query($query5,$conn1) or die(mysql_error());
  $rows5 = mysql_fetch_assoc($result5);
  {
  $fage = floor($rows5['age']/7);
 $age1 = $rows5['age']%7;
 $age2 = $fage.".".$age1;
 $ndate = $rows5['date2'];
if($age2 = "0.0")
{
$fage = floor($age/7);
$age1 = $age%7;
$age2 = $fage.".".$age1;
$ndate = $startdate;
}

?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($dfarm) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($dunit); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($dshed); ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($flock) ?></td>
		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue($age2); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue(date($datephp,strtotime($ndate))); ?></td>
		<td class="ewRptGrpField2" align="center">
<?php echo ewrpt_ViewValue($culldate) ?></td>
		<td class="ewRptGrpField3" align="center">
<?php echo ewrpt_ViewValue($gapdate); ?></td>
	</tr>
<?php
 	$dfarm = $dunit = $dshed = "";
    }
   }
  }
 }
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var cullage = document.getElementById('cullage').value;
	var gapdays = document.getElementById('gapdays').value;
	document.location = "quail_tentativeplacement.php?cullage=" + cullage + "&gapdays=" + gapdays;
}
</script>