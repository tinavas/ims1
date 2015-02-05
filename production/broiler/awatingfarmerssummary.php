<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['date'])
$date = date($datephp,$gaptime=strtotime($_GET['date']));
else
{
$date = date($datephp);
$gaptime=strtotime($date);
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
 <td colspan="2" align="center"><strong><font color="#3e3276"></font>Awaiting Farmers Summary</strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>    Date : </strong><?php echo date($datephp,strtotime($date)); ?></td>
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
&nbsp;&nbsp;<a href="awatingfarmerssummary.php?export=html&date=<?php echo $date; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="awatingfarmerssummary.php?export=excel&date=<?php echo $date; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="awatingfarmerssummary.php?export=word&date=<?php echo $date; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="awatingfarmerssummary.php?cmd=reset&date=<?php echo $date; ?>">Reset All Filters</a>
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
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($date)); ?>"  onchange="reloadpage();"/></td>
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
		Supervisor
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Supervisor</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Farmer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Farmer</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Flock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Flock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Start Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Start Date</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Mortality %
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Mortality %</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center" title="Feed Cost Ratio">
		FCR
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center" title="Feed Cost Ratio">FCR</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Cull Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Cull Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Gap Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Gap Days</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

$query = "select distinct(farm) from broiler_daily_entry where cullflag = 0";
$result = mysql_query($query,$conn1) or die(mysql_error()); 
while($res = mysql_fetch_assoc($result))
$runningfarm[$res['farm']] = 1;

$presuper=$prefarm="";
$query = "select distinct(supervisior),farm from broiler_daily_entry where cullflag = 1 group by farm order by supervisior,farm";
$result = mysql_query($query,$conn1) or die(mysql_error()); 
while($res = mysql_fetch_assoc($result))
if($runningfarm[$res['farm']])
{
}
else
{
$flockresult = mysql_query("select flock,max(entrydate) as culldate,min(entrydate) as startdate from broiler_daily_entry where farm = '$res[farm]' and supervisior = '$res[supervisior]' group by flock order by entrydate desc limit 0,1",$conn1);
$flockres = mysql_fetch_assoc($flockresult);


$query2 = "select sum(mortality) as cmortality,sum(feedconsumed) as cfeedconsumed,sum(cull) as ccull,max(average_weight) as avw from broiler_daily_entry where flock = '$flockres[flock]' and supervisior = '$res[supervisior]' and farm = '$res[farm]'";
$result2 = mysql_query($query2,$conn1) or die(mysql_error());
$res2 = mysql_fetch_assoc($result2);

	$cmortality = $res2['cmortality'];
	$cfeedconsumed = $res2['cfeedconsumed'];
    $ccull = $res2['ccull'];
	$avw = $res2['avw'];
	
 $birds = 0;
  $soldbirds = 0;
  $query111a = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where aflock = '$flockres[flock]' and towarehouse = '$res[farm]' AND cat = 'Broiler Chicks'"; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
  if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) { $birds = $birds + $row111a['chicks'];  } }

  //if(($birds == "") OR ($birds == 0))
  {
   $query111a = "SELECT sum(receivedquantity) as chicks FROM pp_sobi where flock = '$flockres[flock]' and warehouse = '$res[farm]' and description = 'Broiler Chicks' "; $result111a = mysql_query($query111a,$conn1);  $rowsa = mysql_num_rows($result111a);
   if ( $rowsa > 0) { while($row111a = mysql_fetch_assoc($result111a)) {   $birds = $birds + $row111a['chicks'];  } }
  }
  
  $query111 = "SELECT sum(birds) as chicks,sum(quantity) as weight FROM oc_cobi where flock = '$flockres[flock]' and warehouse = '$res[farm]' and code = 'BROB101'"; 
  
   $result111 = mysql_query($query111,$conn1);   $rows = mysql_num_rows($result111);
  if ( $rows > 0) {  while($row111 = mysql_fetch_assoc($result111))  {   $soldbirds = $row111['chicks']; $soldweight = $row111['weight'];  } }
  
 // broiler send birds calculation
if($_SESSION['db'] == 'central')
{
  $sentquery = "SELECT sum(birds) as birds,sum(weight) as weight from broiler_chickentransfer where flock = '$flockres[flock]'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
  $birds = $birds - $sentres['birds']; 
  $sentbirds = $sentres['birds']; 
  $sentweight = $sentres['weight']; 
  }
     
  $oobirds = $birds;
  $birds = $birds - $cmortality - $soldbirds - $ccull;	
 

 ?>
	<tr>
		<td >
<?php if($presuper == $res['supervisior'] ) echo "&nbsp;"; else  echo $presuper = $res['supervisior']; ?></td>
		<td   >
<?php if($prefarm == $res['farm'] ) echo "&nbsp;"; else echo $prefarm=$res['farm']; ?></td>
		<td >
<?php echo $flockres['flock']; ?></td>
<td><?php echo date($datephp,strtotime($flockres['startdate'])); ?></td>
<td align="right"><?php echo round(($cmortality / ($oobirds)) * 100,2) ?></td>
<td align="right"><?php $fcr=round(($cfeedconsumed / ($soldweight+ $sentweight)),2); if($fcr < 0) echo "0"; else echo $fcr; ?></td>
<td ><?php echo date($datephp,$flocktime=strtotime($flockres['culldate'])); ?></td>
<td align="right"><?php 

echo ($gaptime-$flocktime)/86400;

?>


</td>
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
	var fdate = document.getElementById('fromdate').value;
	document.location = "awatingfarmerssummary.php?date=" + fdate;
}
</script>