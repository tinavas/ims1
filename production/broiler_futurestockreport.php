<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['days'] <> "")
 $days = $_GET['days'];
else
 $days = 0;
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Future Stock Report</font></strong></td>
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
&nbsp;&nbsp;<a href="broiler_futurestockreport.php?export=html&days=<?php echo $days; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="broiler_futurestockreport.php?export=excel&days=<?php echo $days; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="broiler_futurestockreport.php?export=word&days=<?php echo $days; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="broiler_futurestockreport.php?cmd=reset&days=<?php echo $days; ?>">Reset All Filters</a>
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
$oldsup = $oldfarm = $oldflock = "";
$query = "SELECT distinct(supervisor) FROM broiler_supervisor WHERE client = '$client' ORDER BY supervisor";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
$supervisor = $rows['supervisor'];

 $query0 = "SELECT distinct(farm) FROM broiler_farm WHERE supervisor = '$supervisor' AND client = '$client' ORDER BY farm";
$result0 = mysql_query($query0,$conn1) or die(mysql_error());
while($rows0 = mysql_fetch_assoc($result0))
{
$farm = $rows0['farm'];
//echo $query1 = "SELECT MIN(entrydate) as entrydate,age,flock FROM broiler_daily_entry WHERE cullflag = 0 AND supervisior = '$supervisor' AND farm = '$farm' AND client = '$client' GROUP BY flock ORDER BY flock";
$query1 = "SELECT distinct(flock) FROM broiler_daily_entry WHERE cullflag = 0 AND supervisior = '$supervisor' AND farm = '$farm' AND client = '$client'";
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{ 
 $flock = $rows1['flock'];
 
 $query2 = "SELECT MIN(entrydate) as entrydate,age FROM broiler_daily_entry WHERE flock = '$flock' AND client = '$client'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $startage = $rows2['age'];
 $startdate = $rows2['entrydate'];

 $t1 = strtotime($startdate);
 $t2 = strtotime(date("Y-m-d"));
 $diff = $t2 - $t1;
 $d = ceil($diff / (24 * 60 * 60));
 $age = $startage + $d;
 
 $query3 = "SELECT sum(mortality) as mort,sum(cull) as cull FROM broiler_daily_entry WHERE flock = '$flock' AND client = '$client'";
 $result3 = mysql_query($query3,$conn1) or die(mysql_error());
 $rows3 = mysql_fetch_assoc($result3);
 $mort = $rows3['mort'];
 $cull = $rows3['cull'];
 
 $query4 = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where aflock = '$flock' and towarehouse = '$farm' AND cat = 'Broiler Chicks' AND client = '$client'";
 $result4 = mysql_query($query4,$conn1) or die(mysql_error());
 $rows4 = mysql_fetch_assoc($result4);
$transferin = $rows4['chicks'];
 
 $query5 = "SELECT (sum(quantity) - sum(tmort) - sum(shortage)) as chicks FROM ims_stocktransfer where tflock = '$flock' and fromwarehouse = '$farm' AND cat = 'Broiler Chicks' AND client = '$client'";
 $result5 = mysql_query($query5,$conn1) or die(mysql_error());
 $rows5 = mysql_fetch_assoc($result5);
 $transferout = $rows5['chicks'];
 
 $query6 = "SELECT sum(birds) as birds FROM oc_cobi WHERE flock = '$flock' AND code IN (select code FROM ims_itemcodes WHERE cat = 'Broiler Chicks' AND client = '$client') AND client = '$client'";
 $result6 = mysql_query($query6,$conn1) or die(mysql_error());
 $rows6 = mysql_fetch_assoc($result6);
 $sales = $rows6['birds'];
 
 $query7 = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock = '$flock' AND code in (select distinct(code) from ims_itemcodes where (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks'))  AND client = '$client'";
 $result7 = mysql_query($query7,$conn1) or die(mysql_error());
 $rows7 = mysql_fetch_assoc($result7);
 $purchases = $rows7['quantity'];
 
  
  if($_SESSION[db]=='mallikarjunkld')
   {
  $query6 = "SELECT birds as chicks from broiler_chickentransfer where flock = '$flock' AND client = '$client'";
 $result6 = mysql_query($query6,$conn1) or die(mysql_error());
 $rows6 = mysql_fetch_assoc($result6);
 $chickentransfer = $rows6['birds'];
 }
 // broiler send birds calculation
 $sentbirds =0;
if($_SESSION['db'] == 'central')
{
  $sentquery = "SELECT sum(birds) as birds,sum(weight) as weight from broiler_chickentransfer where flock = '$flock'";
  $sentresult = mysql_query($sentquery,$conn1) or die(mysql_error()); 
  $sentres = mysql_fetch_assoc($sentresult);
  $sentbirds = $sentres['birds']; 
  $sentweight = $sentres['weight']; 
  }
 
 
 
/* $query7 = "SELECT sum(receivedquantity) as quantity FROM pp_sobi WHERE flock = '$flock' AND category = 'Broiler Chicks' AND client = '$client'";
 $result7 = mysql_query($query7,$conn1) or die(mysql_error());
 $rows7 = mysql_fetch_assoc($result7);
 $purchases = $rows7['quantity'];
 */
 
 $birds = $purchases + $transferin - ($mort + $culls + $transferout + $sales + $sentbirds);
 if($_SESSION[db]=='mallikarjunkld') $birds = $purchases + $transferin - ($mort + $culls + $transferout + $sales+$chickentransfer);
 $fage = $age + $days;
 
 $query12 = "SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Broiler Feed' ORDER BY code";
 $result12 = mysql_query($query12,$conn1) or die(mysql_error());
 while($rows12 = mysql_fetch_assoc($result12))
 {
  $qty[$rows12[code]] = 0;
 }
 for($i = $age + 1; $i <= $fage && $days > 0; $i++)
 { 
  $week = floor($i / 7);
  $query13 = "SELECT feed FROM broiler_allstandards WHERE age = '$week'";
  $result13 = mysql_query($query13,$conn1) or die(mysql_error());
  $rows13 = mysql_fetch_assoc($result13);
  $feed = $rows13['feed'];
   $dayfeed = $feed * $birds;
  
   if($week >= 0 && $week <= 10)
    $qty['FD107'] += $dayfeed;
   elseif($week >=11 && $week <= 20)
    $qty['FD108'] += $dayfeed;
   elseif($week >= 21 && $week <= 30)
    $qty['FD109'] += $dayfeed;
   elseif($week >= 31)
    $qty['FD110'] += $dayfeed;
 }
?>
<?php
 $query13 = "SELECT distinct(code) FROM ims_itemcodes WHERE cat = 'Broiler Feed' ORDER BY code";
 $result13 = mysql_query($query13,$conn1) or die(mysql_error());
 while($rows13 = mysql_fetch_assoc($result13))
 {
  
  if($qty[$rows13[code]] > 0)
  {
  
    $query15 = "SELECT description FROM ims_itemcodes WHERE code = '$rows13[code]' AND client = '$client'";
	$result15 = mysql_query($query15,$conn1) or die(mysql_error());
	$rows15 = mysql_fetch_assoc($result15);
	$desc = $rows15['description'];
	
	if($oldsup <> $supervisor)
	 $displaysup = $oldsup = $supervisor;
	else
	 $displaysup = "";
	if($oldfarm <> $farm)
	 $displayfarm = $oldfarm = $farm;
	else
	 $displayfarm = "";
	if($oldflock <> $flock)
	 $displayflock = $oldflock = $flock;
	else
	 $displayflock = "";
   
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displaysup) ?></td>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($displayfarm) ?></td>
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
  }
 }
?>	
<?php
}	//end of rows1
}	//end of rows0
}	//end of rows
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
	document.location = "broiler_futurestockreport.php?days=" + days;
}
</script>