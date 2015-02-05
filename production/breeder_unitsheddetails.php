<?php 
include "config.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 

 if($_GET['unitcode'])
 $unitcode = $_GET['unitcode'];
 if($_GET['type'])
 $type = $_GET['type'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">&nbsp;Flock Placement Analysis</font></strong></td>
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
<div class="ewGridUpperPanel">
<table>
 <tr>
 <td>Type </td>
 <td>&nbsp;&nbsp;<select id="type" style="width:100px" onChange="reloadpage('');">
 <option value="">-Select-</option>
 <?php
 
 $query = " select distinct(shedtype) from breeder_shed order by shedtype";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
 {
 ?>
 <option value="<?php echo $res['shedtype']; ?>" <?php if($type == $res['shedtype']){?> selected="selected" <?php } ?>><?php echo $res['shedtype']; ?></option>
 
 <?php } ?>
 </select>
 </td>
 <td>&nbsp;&nbsp;Unit</td><td><select id="unit" style="width:100px" onChange="reloadpage('');" >
<option value="">-Select</option>
<?php
	$query = " select distinct(unitcode),unitdescription from breeder_shed order by unitcode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($res = mysql_fetch_assoc($result))
  {
 ?>
 <option value="<?php echo $res['unitcode'];?>" <?php if($unitcode == $res['unitcode']){?> selected="selected" <?php } ?>><?php echo $res['unitcode'];?></option>
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
		Unit
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Unit</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Shed Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Shed Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Shed Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Shed Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Capacity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Capacity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Existing Flocks
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Existing Flocks</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Remaining Birds
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Remaining Birds</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php 
	
	$query = "select distinct(flockcode),femaleopening,maleopening from breeder_flock where unitcode = '$unitcode'";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($res = mysql_fetch_assoc($result))
	 $opening[$res['flockcode']]=$res['femaleopening']+$res['maleopening'];
	
	 $query4 = "SELECT sum(quantity) as quantity,towarehouse as flock FROM ims_stocktransfer WHERE towarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 and unitcode = '$unitcode' ) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE (cat = 'Female Birds' or cat = 'Male Birds') and client = '$client') AND client = '$client' GROUP BY towarehouse ORDER BY towarehouse";
 $result4 = mysql_query($query4,$conn1) or die(mysql_error());
 while($rows4 = mysql_fetch_assoc($result4))
  $transferin[$rows4['flock']] = $rows4['quantity'];
  
 $query5 = "SELECT sum(quantity) as quantity,fromwarehouse as flock FROM ims_stocktransfer WHERE fromwarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND unitcode = '$unitcode') AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE (cat = 'Female Birds' or cat = 'Male Birds') AND client = '$client') AND client = '$client' GROUP BY fromwarehouse ORDER BY fromwarehouse";
 $result5 = mysql_query($query5,$conn1) or die(mysql_error());
 while($rows5 = mysql_fetch_assoc($result5))
  $transferout[$rows5['flock']] = $rows5['quantity']; 
	 
$qeury = "select distinct(flockcode) from breeder_consumption where unitcode = '$unitcode'"; 	 
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
 $fmort = 0;
 $fcull = 0;
 $query = "select distinct(date2),fmort,fcull,mmort,mcull from breeder_consumption where flock = '$res[flockcode]'";
 $result2 = mysql_query($query,$conn1) or die(mysql_error());
 while($res2 = mysql_fetch_assoc($result2))
 {
 $fmort+=$res2['fmort']+$res2['mmort'];
 $fcull+=$res2['fcull']+$res2['mcull'];
 }
 
 $mortality[$res['flockcode']] = $fmort;
 $culls[$res['flockcode']] = $fcull;
}
	 
$i =0;	
$preshed = "";
$query = "select s.shedcapacity,f.unitcode,s.shedcode,s.sheddescription,f.flockcode from breeder_flock f,breeder_shed s where f.cullflag = 0 and f.shedcode = s.shedcode and f.unitcode = s.unitcode and f.unitcode = '$unitcode' and s.shedtype = '$type' group by s.shedcode,f.flockcode order by s.shedcode,f.flockcode";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))	
{ 
?>
	<tr>
<td><?php if($i == 0) echo $res['unitcode']; else echo "&nbsp;"; ?></td>
<td><?php if($preshed!=$res['shedcode']) echo $res['shedcode']; else echo "&nbsp;"; ?></td>		
<td><?php  if($preshed!=$res['shedcode']) echo $res['sheddescription']; else echo "&nbsp;"; ?></td>
<td align="right"><?php if($preshed!=$res['shedcode']) echo $res['shedcapacity']; else echo "&nbsp;"; ?></td>
<td><?php echo $res['flockcode']; ?></td>
<td align="right"><?php echo $opening[$res['flockcode']] + $transferin[$res['flockcode']] - $mortality[$res['flockcode']] - $culls[$res['flockcode']] - $transferout[$res['flockcode']]; ?></td>		
	</tr>
<?php
$i++;
$preshed = $res['shedcode'];}
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