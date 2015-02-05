<?php 
$sExport = @$_GET["export"]; 
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
<?php }
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Feed Issue Planning Analysis</font></strong></td>
</tr>
<?php if($orgunit <> "All") { ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">Unit :</font></strong>&nbsp;&nbsp;<?php echo $orgunit; ?></td>
</tr>
<?php } ?>
<tr>
 <td colspan="2" align="center"><strong><font color="#3e3276">No. of Days:</font></strong>&nbsp;&nbsp;<?php echo $days; ?></td>
</tr>

</table>
</td>
<td width="25px"></td>
<td>
<table align="right" style="font-size:xx-small;" cellpadding="0" cellspacing="0">
<tr>
 <th>Age (in weeks)</th>
 <th>Feed Type</th>
</tr>
	<?php 
	$query = "SELECT age,code FROM breeder_feedcodestandards WHERE client = '$client' ORDER BY code";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows = mysql_fetch_assoc($result))
	{
	 ?>
	 <tr>
	  <td><?php echo $rows['age']; ?></td>
	  <td align="center"><?php echo $rows['code']; ?></td>
	 </tr> 
	 <?php
	}
	?>
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
&nbsp;&nbsp;<a href="feed_requiredrpt.php?export=html&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="feed_requiredrpt.php?export=excel&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="feed_requiredrpt.php?export=word&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="feed_requiredrpt.php?cmd=reset&unit=<?php echo $orgunit; ?>&days=<?php echo $days; ?>">Reset All Filters</a>
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

 
 $query4 = "SELECT sum(quantity) as quantity,towarehouse as flk FROM ims_stocktransfer WHERE towarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client' GROUP BY towarehouse ORDER BY towarehouse";
 $result4 = mysql_query($query4,$conn1) or die(mysql_error());
 while($rows4 = mysql_fetch_assoc($result4))
  $rows4['flk'] . " " . $mtransferin[$rows4[flk]] = $rows4['quantity'];
 
 $query5 = "SELECT sum(quantity) as quantity,fromwarehouse as flk FROM ims_stocktransfer WHERE fromwarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client' GROUP BY fromwarehouse ORDER BY fromwarehouse";
 $result5 = mysql_query($query5,$conn1) or die(mysql_error());
 while($rows5 = mysql_fetch_assoc($result5))
  $mtransferout[$rows5[flk]] = $rows5['quantity'];
 
 $query6 = "SELECT sum(quantity) as quantity,flock as flk FROM oc_cobi WHERE flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client' GROUP BY flock ORDER BY flock";
 $result6 = mysql_query($query6,$conn1) or die(mysql_error());
 while($rows6 = mysql_fetch_assoc($result6))
  $msales[$rows6[flk]] = $rows6['quantity'];
 
 $query7 = "SELECT sum(receivedquantity) as quantity,flock as flk FROM pp_sobi WHERE flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Male Birds' AND client = '$client') AND client = '$client' GROUP BY flock ORDER BY flock";
 $result7 = mysql_query($query7,$conn1) or die(mysql_error());
 while($rows7 = mysql_fetch_assoc($result7))
  $mpurchases[$rows7[flk]] = $rows7['quantity'];
 
 $query8 = "SELECT sum(quantity) as quantity,towarehouse as flk FROM ims_stocktransfer WHERE towarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' GROUP BY towarehouse ORDER BY towarehouse";
 $result8 = mysql_query($query8,$conn1) or die(mysql_error());
 while($rows8 = mysql_fetch_assoc($result8))
  $ftransferin[$rows8[flk]] = $rows8['quantity'];
 
 $query9 = "SELECT sum(quantity) as quantity,fromwarehouse as flk FROM ims_stocktransfer WHERE fromwarehouse IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' GROUP BY fromwarehouse ORDER BY fromwarehouse";
 $result9 = mysql_query($query9,$conn1) or die(mysql_error());
 while($rows9 = mysql_fetch_assoc($result9))
  $ftransferout[$rows9[flk]] = $rows9['quantity'];
 
 $query10 = "SELECT sum(quantity) as quantity,flock as flk FROM oc_cobi WHERE flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' GROUP BY flock ORDER BY flock";
 $result10 = mysql_query($query10,$conn1) or die(mysql_error());
 while($rows10 = mysql_fetch_assoc($result10))
  $fsales[$rows10[flk]] = $rows10['quantity'];
 
 $query11 = "SELECT sum(receivedquantity) as quantity,flock as flk FROM pp_sobi WHERE flock IN (SELECT distinct(flockcode) FROM breeder_flock WHERE cullflag = 0 AND client = '$client' ORDER BY flockcode) AND code IN (SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Female Birds' AND client = '$client') AND client = '$client' GROUP BY flock ORDER BY flock";
 $result11 = mysql_query($query11,$conn1) or die(mysql_error());
 while($rows11 = mysql_fetch_assoc($result11))
  $fpurchases[$rows11[flk]] = $rows11['quantity'];




$oldunit = $oldshed = $oldflock = "";
$total = 0;
$query = "SELECT distinct(unitcode) FROM breeder_unit WHERE client = '$client' $cond ORDER BY unitcode";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $unit = $rows['unitcode'];

 $query12 = "SELECT age,code FROM breeder_feedcodestandards WHERE client = '$client' ORDER BY code";
 $result12 = mysql_query($query12,$conn1) or die(mysql_error());
 while($rows12 = mysql_fetch_assoc($result12))
 {
  $af[$rows12[age]] = $rows12['code'];
  $qty[$rows12[code]] = 0;
 }
 
$query1 = "SELECT * FROM breeder_flock WHERE cullflag = 0 AND unitcode = '$unit' AND client = '$client' ORDER BY flockcode";
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
 
 $query3 = "SELECT sum(mmort) as mmort,sum(fmort) as fmort,sum(mcull) as mcull,sum(fcull) as fcull FROM breeder_consumption WHERE flock = '$flock' AND client = '$client'";
 $result3 = mysql_query($query3,$conn1) or die(mysql_error());
 $rows3 = mysql_fetch_assoc($result3);
 $mmort = $rows3['mmort'];
 $fmort = $rows3['fmort'];
 $mcull = $rows3['mcull'];
 $fcull = $rows3['fcull'];

 $mbirds = $mopening + $mpurchases[$flock] + $mtransferin[$flock] - ($mmort + $mculls + $mtransferout[$flock] + $msales[$flock]);
 $fbirds = $fopening + $fpurchases[$flock] + $ftransferin[$flock] - ($fmort + $fculls + $ftransferout[$flock] + $fsales[$flock]);
 $fage = $age + $days;

 //if($unit == "KAMAL2") { echo $mbirds; echo "**".$fbirds."  ".$flock; } 

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

  $t2 += 24 * 60 * 60;
  $date2 = date("Y-m-d",$t2);
  
  $query14 = "SELECT * FROM breeder_feedcodestandards WHERE '$date2' BETWEEN fromdate AND todate AND $week BETWEEN fromage AND toage AND client = '$client'";
  $result14 = mysql_query($query14,$conn1) or die(mysql_error());
  $r14 = mysql_num_rows($result14);
  $rows14 = mysql_fetch_assoc($result14);
  if($r14 > 0)
  {
	$tage = $rows14['age'];
	$temp = substr($tage,-2,1);
	if($temp == 'M')
	 $qty[$rows14['code']] += $daymfeed;
	else if($temp == 'F')
	 $qty[$rows14['code']] += $dayffeed;
	else
	 $qty[$rows14['code']] += $daymfeed + $dayffeed;
	 if($rows14 = mysql_fetch_assoc($result14))	//If the result set contains two rows
	 {
		$tage = $rows14['age'];
		$temp = substr($tage,-2,1);
		if($temp == 'M')
		 $qty[$rows14['code']] += $daymfeed;
		else if($temp == 'F')
		 $qty[$rows14['code']] += $dayffeed;
	 }
  }
  /*else
  {
	  $query15 = "SELECT * FROM breeder_feedcodestandards WHERE '$date2' BETWEEN fromdate AND todate AND toage < $week AND fromage = '>' AND client = '$client'";
	  $result15 = mysql_query($query15,$conn1) or die(mysql_error());
	  $r15 = mysql_num_rows($result15);
	  $rows15 = mysql_fetch_assoc($result15);
	  if($r15 > 0)
	  {
		$tage = $rows['age'];
		$temp = substr($tage,-2,1);
		if($temp == 'M')
		 $qty[$rows15['code']] += $daymfeed;
		else if($temp == 'F')
		 $qty[$rows15['code']] += $dayffeed;
		else
		 $qty[$rows15['code']] += $daymfeed + $dayffeed;  
	  }  
  }*/

 }
}	//end of rows1
?>
<?php
 $query13 = "SELECT age,description,code FROM breeder_feedcodestandards WHERE client = '$client' ORDER BY code";
 $result13 = mysql_query($query13,$conn1) or die(mysql_error());
 while($rows13 = mysql_fetch_assoc($result13))
 {
  if($qty[$rows13[code]] > 0)
  {
	if($oldunit <> $unit)
	 $displayunit = $oldunit = $unit;
	else
	 $displayunit = "";
	
   $total += round(($qty[$rows13[code]] / 1000),2);
?>
	<tr>
<?php if($orgunit == 'All') { ?>	
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displayunit) ?></td>
<?php } ?>
		<td class="ewRptGrpField1" align="center">
<?php echo ewrpt_ViewValue($rows13['code']); ?></td>
		<td class="ewRptGrpField3">
<?php echo ewrpt_ViewValue($rows13['description']); ?></td>
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
}	//end of rows
?>
<tr>
 <td align="right" <?php if($orgunit == 'All') {  echo "colspan='3'";  } else { ?> colspan="2" <?php } ?>><b>Total</b></td>
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
	document.location = "feed_requiredrpt.php?unit=" + unit + "&days=" + days;
}
</script>