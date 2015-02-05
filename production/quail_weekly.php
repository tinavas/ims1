<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
$flock = $_GET['flock'];

$query = "SELECT min(date1) as mindate,max(date1) as maxdate FROM quail_production WHERE flock = '$flock' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
if($rows = mysql_fetch_assoc($result)) {
$orgmindate = $mindate = $rows['mindate'];
$maxenddate = $maxdate = $rows['maxdate'];
}

$query = "SELECT age FROM quail_consumption WHERE flock = '$flock' AND date2 = '$mindate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$minage = $rows['age'];
$diff = $minage % 7;
if($diff <> 0)
{
$mindate = strtotime($mindate) + ((7 - $diff) * 24 * 60 * 60);
$startage = $minage + (7 - $diff);
$weekenddate = date("Y-m-d",$mindate);
} 

$query = "SELECT age FROM quail_consumption WHERE flock = '$flock' AND date2 = '$maxdate' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$maxage = $rows['age'];
$diff = $maxage % 7;
if($diff <> 0)
{
 $maxdate = strtotime($maxdate) - ($diff * 24 * 60 * 60);
 $endage = $maxage - $diff;
 $maxenddate = date("Y-m-d",$maxdate);
} 

$query = "SELECT breed FROM quail_flock WHERE flockcode = '$flock' AND client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);

$istart = $startage / 7;		//$_SESSION['istartage'];	//Production Starting week
$iend = $endage / 7;			//$_SESSION['iage'];			//Production End week
$jstart = $_SESSION['jstartage'];
$jend = $_SESSION['jage'];
$breedi = $rows['breed'];		//$_SESSION['breedi'] ;

if($breedi != "")
 $query34 = "SELECT * FROM quail_standards where client = '$client' and breed = '$breedi' ORDER BY age ASC ";
else
 $query34 = "SELECT * FROM quail_standards where client = '$client' ORDER BY age ASC ";
$result34 = mysql_query($query34,$conn); 
while($row134 = mysql_fetch_assoc($result34))
{ 
  $istdhdper[$row134['age']] = $row134['productionper'];
  $istdheggper[$row134['age']] = $row134['heggper'];
  $istdeggwt[$row134['age']] = $row134['eggwt'];
  $istdfweight[$row134['age']] = $row134['fweight'];
  $istdmweight[$row134['age']] = $row134['mweight'];
}

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Quail Weekly Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Flock </font></strong><?php echo $flock; ?>
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
&nbsp;&nbsp;<a href="quail_weekly.php?export=html&flock=<?php echo $flock; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="quail_weekly.php?export=excel&flock=<?php echo $flock; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="quail_weekly.php?export=word&flock=<?php echo $flock; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="quail_weekly.php?cmd=reset&flock=<?php echo $flock; ?>">Reset All Filters</a>
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
  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td class="ewTableHeader" style="width:100px; vertical-align:middle;" rowspan = "2" align="center">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader" rowspan = "2" style="vertical-align:middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td class="ewTableHeader" style="width:100px;vertical-align:middle" align="center" rowspan="2">
		Age<br/>(in weeks)
		</td>
<?php } else { ?>
		<td class="ewTableHeader"rowspan = "2" style="vertical-align:middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Age<br/>(in weeks)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="2">
		No. of Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">No. of Birds</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="2">
		Mortality
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Mortality</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="2">
		Culls
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Culls</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;"  align="center" colspan="2">
		Sexing
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sexing</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="3">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Production</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="3">
		Hatch Eggs
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatch Eggs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td class="ewTableHeader" style="width:100px;vertical-align:middle" align="center" rowspan="2">
		Total Feed in Kgs
		</td>
<?php } else { ?>
		<td class="ewTableHeader"rowspan = "2" style="vertical-align:middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total Feed in Kgs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="4">
		Feed Consumption
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="4">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Feed Consumption</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;"  align="center" colspan="3">
		Quail Female Body Wt. in gms
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Female Body Wt. in gms</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="3">
		Quail Male Body Wt. in gms
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Male Body Wt. in gms</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="3">
		Egg Wt.
		</td>
<?php } else { ?>
		<td class="ewTableHeader" align="center" colspan="3">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Egg Wt.</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	<tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Male</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Male</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Male</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Female
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Female</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quail Male
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quail Male</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		St.%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">St.%</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">No.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">%</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		St.%
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">St.%</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		F Total in Kgs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">F Total in Kgs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Per Bird/day in gms
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Per Bird/day in gms</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		M Total in Kgs
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">M Total in Kgs</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Per Bird/day in gms
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Per Bird/day in gms</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Std.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Std.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Act.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Act.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		+/-
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">+/-</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Std.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Std.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Act.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Act.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		+/-
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">+/-</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Std.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Std.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Act.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Act.</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		+/-
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">+/-</td>
			</tr></table>
		</td>
<?php } ?>

	
	</tr>
	</thead>
	<tbody>
<?php
$temp = strtotime($weekenddate) - (6 * 24 * 60 * 60);
$weekstartdate = $orgmindate; //date("Y-m-d",$temp);
$flockget = $flock;
$query = "SELECT femaleopening,maleopening FROM quail_flock WHERE flockcode = '$flock'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$fop = $rows['femaleopening'];
$mop = $rows['maleopening'];

$query1 = "SELECT fmort,mmort,fcull,mcull FROM quail_consumption WHERE flock like '$flockget' AND date2 < '$weekstartdate' GROUP BY date2 ORDER BY date2 ASC";
$result1 = mysql_query($query1,$conn1); 
while($row1 = mysql_fetch_assoc($result1))
{
 $fmort += $row1['fmort'];
 $mmort += $row1['mmort'];
 $fcull += $row1['fcull'];
 $mcull += $row1['mcull'];
}

$query1 = "SELECT sum(quantity) as trin  FROM `ims_stocktransfer` WHERE cat ='Quail Female Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$ftrin = $rows1['trin'];

$query1 = "SELECT sum(quantity) as trout  FROM `ims_stocktransfer` WHERE cat ='Quail Female Birds' AND  fromwarehouse like '$flockget' and towarehouse not like '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$ftrout = $rows1['trout'];

$query1 = "SELECT sum(quantity) as pur  FROM `pp_sobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds') AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fpur = $rows1['pur'];

$query1 = "SELECT sum(quantity) as sal  FROM `oc_cobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds') AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fsal = $rows1['sal'];

$query1 = "SELECT sum(birds) as fsender  FROM `quail_breeder_sender` WHERE cat = 'Quail Female Birds' AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fsender = $rows1['fsender'];

$query1 = "SELECT sum(quantity) as trin  FROM `ims_stocktransfer` WHERE cat ='Quail Male Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mtrin = $rows1['trin'];

$query1 = "SELECT sum(quantity) as trout  FROM `ims_stocktransfer` WHERE cat ='Quail Male Birds' AND  fromwarehouse like '$flockget' and towarehouse not like '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mtrout = $rows1['trout'];

$query1 = "SELECT sum(quantity) as pur  FROM `pp_sobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds') AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mpur = $rows1['pur'];

$query1 = "SELECT sum(quantity) as sal  FROM `oc_cobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds') AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$msal = $rows1['sal'];

$query1 = "SELECT sum(birds) as msender  FROM `quail_breeder_sender` WHERE cat = 'Quail Male Birds' AND  flock = '$flockget' AND date < '$weekstartdate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$msender = $rows1['msender'];

$fbal = $fob = $fop + $ftrin + $fpur - ($fmort + $fcull + $ftrout + $fsal + $fsender);
$mbal = $mob = $mop + $mtrin + $mpur - ($mmort + $mcull + $mtrout + $msal + $msender);
$flag = 1;
while($flag)
{
if($maxenddate == $weekenddate)
 $flag = 0;
$fmort = $mmort = $fcull = $mcull = $ffeed = $mfeed = $fweight = $mweigth = $eggwt = 0;
$query1 = "SELECT fmort,mmort,fcull,mcull,ffeed,mfeed,fweight,mweight,eggwt FROM quail_consumption WHERE flock like '$flockget' AND date2 BETWEEN '$weekstartdate' AND '$weekenddate' GROUP BY date2 ORDER BY date2 ASC";
$result1 = mysql_query($query1,$conn1); 
while($row1 = mysql_fetch_assoc($result1))
{
 $fmort += $row1['fmort'];
 $mmort += $row1['mmort'];
 $fcull += $row1['fcull'];
 $mcull += $row1['mcull'];
 $ffeed += $row1['ffeed'];
 $mfeed += $row1['mfeed'];
 $fweight += $row1['fweight'];
 $mweight += $row1['mweight'];
 $eggwt += $row1['eggwt'];
}

if($fmort == "") $fmort = 0;
if($mmort == "") $mmort = 0;
if($fcull == "") $fcull = 0;
if($mcull == "") $mcull = 0;

$query1 = "SELECT sum(quantity) as trin  FROM `ims_stocktransfer` WHERE cat ='Quail Female Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$ftrin = $rows1['trin'];

$query1 = "SELECT sum(quantity) as trout  FROM `ims_stocktransfer` WHERE cat ='Quail Female Birds' AND  fromwarehouse like '$flockget' and towarehouse not like '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$ftrout = $rows1['trout'];

$query1 = "SELECT sum(quantity) as pur  FROM `pp_sobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds') AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fpur = $rows1['pur'];

$query1 = "SELECT sum(quantity) as sal  FROM `oc_cobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Female Birds') AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fsal = $rows1['sal'];

$query1 = "SELECT sum(birds) as fsender  FROM `quail_breeder_sender` WHERE cat = 'Quail Female Birds' AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$fsender = $rows1['fsender'];

$query1 = "SELECT sum(quantity) as trin  FROM `ims_stocktransfer` WHERE cat ='Quail Male Birds' AND  towarehouse like '$flockget' and fromwarehouse not like '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mtrin = $rows1['trin'];

$query1 = "SELECT sum(quantity) as trout  FROM `ims_stocktransfer` WHERE cat ='Quail Male Birds' AND  fromwarehouse like '$flockget' and towarehouse not like '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mtrout = $rows1['trout'];

$query1 = "SELECT sum(quantity) as pur  FROM `pp_sobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds') AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$mpur = $rows1['pur'];

$query1 = "SELECT sum(quantity) as sal  FROM `oc_cobi` WHERE code IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Male Birds') AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$msal = $rows1['sal'];

$query1 = "SELECT sum(birds) as msender  FROM `quail_breeder_sender` WHERE cat = 'Quail Male Birds' AND  flock = '$flockget' AND date BETWEEN '$weekstartdate' AND '$weekenddate' ";
$result1 = mysql_query($query1,$conn1);
$rows1 = mysql_fetch_assoc($result1);
$msender = $rows1['msender'];
 
$fbal = $fbal + $ftrin + $fpur - ($fmort + $fcull + $ftrout + $fsal + $fsender);
$mbal = $mbal + $mtrin + $mpur - ($mmort + $mcull + $mtrout + $msal + $msender);

$eggs = 0;
$query1 = "SELECT sum(quantity) as quantity FROM quail_production WHERE flock like '$flockget' and date1 BETWEEN '$weekstartdate' AND '$weekenddate' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Eggs' or cat = 'Quail Hatch Eggs') ORDER BY date1 ASC";
$result1 = mysql_query($query1,$conn1); 
while($row1 = mysql_fetch_assoc($result1))
 $eggs += $row1['quantity'];

$heggs = 0;
$query1 = "SELECT sum(quantity) as quantity FROM quail_production WHERE flock like '$flockget' and date1 BETWEEN '$weekstartdate' AND '$weekenddate' AND itemcode IN (SELECT code FROM ims_itemcodes WHERE cat = 'Quail Hatch Eggs') ORDER BY date1 ASC";
$result1 = mysql_query($query1,$conn1); 
while($row1 = mysql_fetch_assoc($result1))
 $heggs += $row1['quantity'];

$query1 = "SELECT productionper,heggper,fweight,mweight,eggwt FROM quail_standards WHERE age = '$istart'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
$rows1 = mysql_fetch_assoc($result1);
$prodper = $rows1['productionper'];
$heggper = $rows1['heggper'];
$stdfwt = $rows1['fweight'];
$stdmwt = $rows1['mweight']; 
$stdeggwt = $rows1['eggwt'];
 
$gapdays = (strtotime($weekenddate) - strtotime($weekstartdate)) / (24 * 60 * 60) + 1;
$totfmort += $fmort;
$totmmort += $mmort;
$totfcull += $fcull;
$totmcull += $mcull;
$totprod += $eggs;
$totheggs += $heggs;
$totffeed += $ffeed;
$totmfeed += $mfeed;
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date("d-M",strtotime($weekenddate))); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($istart++); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($fbal); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($mbal); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo $fmort; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($mmort); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo $fcull; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo $mcull; ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue("0"); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue("0"); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($eggs); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round(($eggs/($fbal* $gapdays) * 100),2)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round($prodper),2); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($heggs); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round(($heggs/($eggs) * 100),2)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round($heggper,2)); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($ffeed + $mfeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($ffeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round( (($ffeed * 1000) / ($fbal * $gapdays) ),2)); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($mfeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round( (($mfeed * 1000) / ($mbal * $gapdays) ),2)); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($stdfwt); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo $fweight; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($fweight - $stdfwt); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($stdmwt); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo $mweight; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($mweight - $stdmwt); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($stdeggwt); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo $eggwt; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($eggwt - $stdeggwt); ?></td>

	</tr>
<?php
$temp = strtotime($weekenddate) + (24 * 60 *60);
$weekstartdate = date("Y-m-d",$temp);
$temp = strtotime($weekstartdate) + (6 * 24 * 60 *60);
$weekenddate = date("Y-m-d",$temp);
}
?>
<tr style="font-weight:bold">
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue("Total"); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo $totfmort; ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totmmort); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totfcull); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totmcull); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue("0"); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue("0"); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totprod); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totheggs); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totffeed + $totmfeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totffeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($totmfeed); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "quail_weekly.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>