<?php 
$sExport = @$_GET["export"]; /*
if (@$sExport == "") { ?>
 
  <style type="text/css">
        thead tr {
            position: absolute; 
            height: 20px;
            top: expression(this.offsetParent.scrollTop);
        }
        tbody {
            height: auto;
        }
        .ewGridMiddlePanel {
        	border: 0;	
            height: 435px;
            padding-top:20px; 
            overflow: scroll; 
        }
    </style>
<?php } */

include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Hatchery Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>Date : </strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="hatcheryreport.php?export=html&fromdate=<?php echo $fromdate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="hatcheryreport.php?export=excel&fromdate=<?php echo $fromdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="hatcheryreport.php?export=word&fromdate=<?php echo $fromdate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="hatcheryreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
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
		Hatchery
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatchery</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Capacity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Capacity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Filled
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Filled</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
include "config.php";
$i = 0;

if($_SESSION[db]=='alkhumasiyabrd')
$query = "SELECT hatcher,hatcheggs as hatchercount FROM transferdetails_hatchery WHERE '$fromdate' BETWEEN transferdate AND hatchdate AND client = '$client' AND hatcher <> 'NULL' group by transferdate";
else
$query = "SELECT hatcher,hatchercount FROM hatchery_hatchrecord WHERE '$fromdate' BETWEEN transferdate AND hatchdate AND client = '$client' AND hatcher <> 'NULL'";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ 
$temp1 = explode(',',$rows['hatcher']);
$temp2 = explode(',',$rows['hatchercount']);
	for($k = 0; $k < count($temp1); $k++,$i++)
	{
	 $hatcher[$i] = $temp1[$k];
	 $hatchercount[$i] = $temp2[$k];
	} 
}
for($l = 0; $l<$i; $l++)
{
 for($m = 0; $m <$i; $m++)
 { 
  if(strcmp($hatcher[$l],$hatcher[$m])<0)
  {
    $temp1 = $hatcher[$l];
	$hatcher[$l] = $hatcher[$m];
	$hatcher[$m] = $temp1;
	
	$temp2 = $hatchercount[$l];
	$hatchercount[$l] = $hatchercount[$m];
	$hatchercount[$m] = $temp2;
  }
 }
}
$j = 0;
for($l = 0; $l <$i; $l++)
{
 if($l == 0)
 {
  $h1[$j] = $hatcher[$l];
  $h2[$j] = $hatchercount[$l];
 }
 else if($h1[$j] == $hatcher[$l])
 {
  $h2[$j] += $hatchercount[$l];
 }
 else
 {
  $j++;
  $h1[$j] = $hatcher[$l];
  $h2[$j] = $hatchercount[$l];
 }  
} 

for($i=0; $i<=$j; $i++)
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($h1[$i]) ?></td>
<?php
if($_SESSION[db]=='alkhumasiyabrd')
$query = "SELECT * FROM hatchery_hatchercapacity WHERE hatcher = '$h1[$i]' AND client = '$client'";
else
$query = "SELECT * FROM hatchery_hatchercapacity WHERE hatchery = '$h1[$i]' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
?>
		<td class="ewRptGrpField3" align="right" style="padding-right:15px;">
<?php echo ewrpt_ViewValue($rows['capacity']); ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo ewrpt_ViewValue($h2[$i]); ?></td>
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
	document.location = "hatcheryreport.php?fromdate=" + fdate;
}
</script>