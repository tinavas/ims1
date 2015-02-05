<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['days'] <> "")
 $days = $_GET['days'];
else
 $days = 0;
$cond = "";
if($_GET['unit'] <> "" && $_GET['unit'] <> 'All')
{
 $orgunit = $_GET['unit'];
 $cond = "AND unitcode = '$orgunit'";
}
else
{
 $unit = "All"; 
 $orgunit = 'All';
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
<td>
<table>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Breeder Feed Planning Analysis</font></strong></td>
</tr>
<?php if($orgunit <> "All") { ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Unit :</font></strong>&nbsp;&nbsp;<?php echo $orgunit; ?></td>
</tr>
<?php } ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">No. of Days:</font></strong>&nbsp;&nbsp;<?php echo $days; ?></td>
</tr>
<?php if($_SESSION['db'] == 'golden') { ?>
</table>
</td>
<td width="25px"></td>
<td>
<table align="right" style="font-size:xx-small;" cellpadding="0" cellspacing="0">
<tr>
 <th>Age (in weeks)</th>
 <th>Feed Type</th>
</tr>
<tr>
 <td>0-6</td>
 <td align="center">FD101</td>
</tr>
<tr>
 <td>7-17</td>
 <td align="center">FD102</td>
</tr>
<tr>
 <td>18-23</td>
 <td align="center">FD103</td>
</tr>
<tr>
 <td title="Female">24-40(F)</td>
 <td align="center">FD104</td>
</tr>
<tr>
 <td title="Female">41-60(F)</td>
 <td align="center">FD105</td>
</tr>
<tr>
 <td title="Female">>60(F)</td>
 <td align="center">FD106</td>
</tr>
<tr>
 <td title="Male">>23(M)</td>
 <td align="center">FD107</td>
</tr>
<?php } ?>
</tr>
</table>

</td>
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
&nbsp;&nbsp;<a href="futurestockreport.php?export=html&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="futurestockreport.php?export=excel&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="futurestockreport.php?export=word&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="futurestockreport.php?cmd=reset&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Reset All Filters</a>
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
 <td>Unit</td>
 <td><select id="unit" name="unit" onchange="reloadpage()">
 <option value="All" <?php if($orgunit == 'All') { ?> selected="selected" <?php } ?>>All</option>
 <?php
 $query = "SELECT distinct(unitcode) FROM breeder_unit WHERE client = '$client' ORDER BY unitcode";
 $result = mysql_query($query,$conn1) or die(mysql_error());
 while($rows = mysql_fetch_assoc($result))
 {
  ?>
  <option value="<?php echo $rows['unitcode']; ?>" <?php if($orgunit == $rows[unitcode]) { ?> selected="selected" <?php } ?>><?php echo $rows['unitcode']; ?></option>
  <?php
 }
 ?>
 </select>
 </td>
 <td width="20px"></td>
 <td>Number of Days</td>
 <td><input type="text" id="noofdays" name="noofdays" value="<?php echo $days; ?>" onkeyup="reloadpage();"/></td>
</tr>
</table>	  
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
<?php if($orgunit == 'All') { ?>	
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
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Feed Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Feed Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Feed Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Feed Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Quantity (Kg's)
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity (Kg's)</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$oldunit = $oldshed = $oldflock = "";
$total = 0;
$query = "SELECT distinct(unitcode) FROM breeder_unit WHERE client = '$client' $cond ORDER BY unitcode";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $unit = $rows['unitcode'];
$query0 = "SELECT distinct(shedcode) FROM breeder_shed WHERE client = '$client' AND unitcode = '$unit' ORDER BY shedcode";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
while($rows0 = mysql_fetch_assoc($result0))
{
$shed = $rows0['shedcode'];
$query1 = "SELECT * FROM breeder_flock WHERE cullflag = 0 AND unitcode = '$unit' AND shedcode = '$rows0[shedcode]' AND client = '$client' ORDER BY flockcode";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
 $flock = $rows1['flockcode'];
 $startage = $rows1['age'];
 $startdate = $rows1['startdate'];
 $fopening = $rows1['femaleopening'];
 $mopening = $rows1['maleopening'];

 $t1 = strtotime($startdate);
 $t2 = strtotime(date("Y-m-d"));
 $diff = $t2 - $t1;
 $d = ceil($diff / (24 * 60 * 60));
 $age = $startage + $d;
 
 $query3 = "SELECT sum(mmort) as mmort,sum(fmort) as fmort,sum(mcull) as mcull,sum(fcull) as fcull FROM breeder_consumption WHERE flock = '$flock'";
 $result3 = mysql_query($query3,$conn1) or die(mysql_error());
 $rows3 = mysql_fetch_assoc($result3);
 $mmort = $rows3['mmort'];
 $fmort = $rows3['fmort'];
 $mcull = $rows3['mcull'];
 $fcull = $rows3['fcull'];
 
 $query4 = "SELECT sum(quantity) as quantity FROM ims_stocktransfer WHERE towarehouse = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client'";
 $result4 = mysql_query($query4,$conn1) or die(mysql_error());
 $rows4 = mysql_fetch_assoc($result4);
 $mtransferin = $rows4['quantity'];
 
 $query5 = "SELECT sum(quantity) as quantity FROM ims_stocktransfer WHERE fromwarehouse = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client'";
 $result5 = mysql_query($query5,$conn1) or die(mysql_error());
 $rows5 = mysql_fetch_assoc($result5);
 $mtransferout = $rows5['quantity'];
 
 $query6 = "SELECT sum(quantity) as quantity FROM oc_cobi WHERE flock = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client'";
 $result6 = mysql_query($query6,$conn1) or die(mysql_error());
 $rows6 = mysql_fetch_assoc($result6);
 $msales = $rows6['quantity'];
 
 $query7 = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client'";
 $result7 = mysql_query($query7,$conn1) or die(mysql_error());
 $rows7 = mysql_fetch_assoc($result7);
 $mpurchases = $rows7['quantity'];
 
 $query8 = "SELECT sum(quantity) as quantity FROM ims_stocktransfer WHERE towarehouse = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client'";
 $result8 = mysql_query($query8,$conn1) or die(mysql_error());
 $rows8 = mysql_fetch_assoc($result8);
 $ftransferin = $rows8['quantity'];
 
 $query9 = "SELECT sum(quantity) as quantity FROM ims_stocktransfer WHERE fromwarehouse = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client'";
 $result9 = mysql_query($query9,$conn1) or die(mysql_error());
 $rows9 = mysql_fetch_assoc($result9);
 $ftransferout = $rows9['quantity'];
 
 $query10 = "SELECT sum(quantity) as quantity FROM oc_cobi WHERE flock = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client'";
 $result10 = mysql_query($query10,$conn1) or die(mysql_error());
 $rows10 = mysql_fetch_assoc($result10);
 $fsales = $rows10['quantity'];
 
 $query11 = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock = '$flock' AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client'";
 $result11 = mysql_query($query11,$conn1) or die(mysql_error());
 $rows11 = mysql_fetch_assoc($result11);
 $fpurchases = $rows11['quantity'];
 
 $mbirds = $mopening + $mpurchases + $mtransferin - ($mmort + $mculls + $mtransferout + $msales);
 $fbirds = $fopening + $fpurchases + $ftransferin - ($fmort + $fculls + $ftransferout + $fsales);
 $fage = $age + $days;
 
 $query12 = "SELECT distinct(code) FROM ims_itemcodes WHERE cat LIKE '%Feed%' ORDER BY code";
 $result12 = mysql_query($query12,$conn1) or die(mysql_error());
 while($rows12 = mysql_fetch_assoc($result12))
 {
  $qty[$rows12[code]] = 0;
 }

 for($i = $age + 1; $i <= $fage && $days > 0; $i++)
 { 
  $week = floor($i / 7);
  $query13 = "SELECT mfeed,ffeed FROM breeder_standards WHERE age = '$week' AND client = '$client'";
  $result13 = mysql_query($query13,$conn1) or die(mysql_error());
  $rows13 = mysql_fetch_assoc($result13);
  $mfeed = $rows13['mfeed'];
  $ffeed = $rows13['ffeed'];
  
  $daymfeed = $mfeed * $mbirds;
  $dayffeed = $ffeed * $fbirds;
  
  if($_SESSION['db'] == 'golden')
  if($week >= 0 && $week <= 23)
  {
   if($week >= 0 && $week <= 6)
    $qty['FD101'] += $daymfeed + $dayffeed;
   elseif($week >=7 && $week <= 17)
    $qty['FD102'] += $daymfeed + $dayffeed;
   elseif($week >= 18 && $week <= 23)
    $qty['FD103'] += $daymfeed + $dayffeed;
  }
  else
  {
    $qty['FD107'] += $daymfeed;
   if($week >= 24 && $week <= 40)
    $qty['FD104'] += $dayffeed;
   elseif($week >= 41 && $week <= 60)
    $qty['FD105'] += $dayffeed;
   elseif($week >= 61)
    $qty['FD106'] += $dayffeed;	
  }
 }
?>
<?php
echo $query13 = "SELECT distinct(code) FROM ims_itemcodes WHERE cat LIKE '%Feed%' ORDER BY code";
 $result13 = mysql_query($query13,$conn1) or die(mysql_error());
 while($rows13 = mysql_fetch_assoc($result13))
 {
  if($qty[$rows13[code]] > 0)
  {
    $query15 = "SELECT description FROM ims_itemcodes WHERE code = '$rows13[code]' AND client = '$client'";
	$result15 = mysql_query($query15,$conn1) or die(mysql_error());
	$rows15 = mysql_fetch_assoc($result15);
	$desc = $rows15['description'];
	
	if($oldunit <> $unit)
	 $displayunit = $oldunit = $unit;
	else
	 $displayunit = "";
	if($oldshed <> $shed)
	 $displayshed = $oldshed = $shed;
	else
	 $displayshed = "";
	if($oldflock <> $flock)
	 $displayflock = $oldflock = $flock;
	else
	 $displayflock = "";
	
   $total += round(($qty[$rows13[code]] / 1000),2);
?>
	<tr>
<?php if($orgunit == 'All') { ?>	
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displayunit) ?></td>
<?php } ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displayshed) ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($displayflock); ?></td>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows13['code']); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($desc); ?></td>
		<td class="ewRptGrpField1" align="right" style="padding-right:15px;">
<?php echo ewrpt_ViewValue(changeprice($qty[$rows13[code]] / 1000)); ?></td>
	</tr>
<?php
   $shed = "";
   $flock = "";
  }
 }
?>	
<?php
}	//end of rows1
}	//end of rows0
}	//end of rows
?>
<tr>
 <td align="right" <?php if($orgunit == 'All') { ?> colspan="5" <?php } else { ?> colspan="4" <?php } ?>><b>Total</b></td>
 <td align="right" style="padding-right:15px;"><b><?php echo changeprice($total); ?></b></td>
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
<?php } 

function changeprice($num){
$pos = strpos((string)$num, ".");
if ($pos === false) { $decimalpart="00";}
else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

if(strlen($num)>3 & strlen($num) <= 12){
$last3digits = substr($num, -3 );
$numexceptlastdigits = substr($num, 0, -3 );
$formatted = makecomma($numexceptlastdigits);
$stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
}elseif(strlen($num)<=3){
$stringtoreturn = $num.".".$decimalpart ;
}elseif(strlen($num)>12){
$stringtoreturn = number_format($num, 2);
}

if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}
$a  = explode('.',$stringtoreturn);
$c = "";
if(strlen($a[1]) < 2) { $c = "0"; }
$stringtoreturn = $stringtoreturn.$c;
return $stringtoreturn;
}

function makecomma($input)
{
if(strlen($input)<=2)
{ return $input; }
$length=substr($input,0,strlen($input)-2);
$formatted_input = makecomma($length).",".substr($input,-2);
return $formatted_input;
}

?>
<script type="text/javascript">
function reloadpage()
{
	var days = document.getElementById('noofdays').value;
	var unit = document.getElementById('unit').value;
	document.location = "futurestockreport.php?unit=" + unit + "&days=" + days;
}
</script>