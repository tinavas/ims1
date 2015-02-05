<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "getemployee.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d");
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
 
if($_GET['shed'] <> "")
 $shed = $_GET['shed'];
else
 $shed = ''; 
 if($shed!='') {  $cond="and  flock in (select flockcode from layer_flock where shedcode='$shed') "; }
 else $cond='';
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Packets Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="packetsreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&shed=<?php echo $shed; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="packetsreport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&shed=<?php echo $shed; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="packetsreport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&shed=<?php echo $shed; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="packetsreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&shed=<?php echo $shed; ?>">Reset All Filters</a>
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
 <td>From</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date($datephp,strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date($datephp,strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 <td>
 <select onchange="reloadpage();" id="shed">
 <option  value="">All</option>
 <?php 
 $query=mysql_query("select distinct(shedcode) from layer_flock ");
 while($r=mysql_fetch_array($query))
 {  ?>
  <option <?php if($shed==$r[shedcode]) echo 'selected="selected"'; ?> value="<?php echo $r[shedcode] ?>"><?php echo $r[shedcode] ?></option>
<?php }
 ?>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		House
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">House</td>
			</tr></table>
		</td>
<?php } $i=-1;
       $query = "SELECT code,description FROM ims_itemcodes where cat = 'Packed Eggs' and client = '$client' ORDER BY code ASC ";
              $result = mysql_query($query,$conn1); 
              while($row1 = mysql_fetch_assoc($result))
              {
			  $codearray[++$i]=$row1['code'];
			  $$codearray[$i]=0;
			 if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" title="<?php echo $row1['code']; ?>" style="width:100px;" align="center">
		<?php echo $row1['description']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td title="<?php echo $row1['code']; ?>"  style="width:100px;" align="center"><?php echo $row1['description']; ?></td>
			</tr></table>
		</td>
<?php } } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$query="SELECT distinct(date1) FROM `layer_depro` where date1>='$fromdate' and date1<='$todate' $cond order by date1";
$result=mysql_query($query) or die(mysql_error()); 
while($array=mysql_fetch_array($result))
{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php if($array[date1]!=$dupdate) echo date($datephp,strtotime($array[date1])); else echo '&nbsp;'; ?></td>
		<td class="ewRptGrpField2" >
<?php  
$query="select distinct(flock) from layer_depro where date1='$array[date1]' ";
$result2=mysql_query($query);
$house='';
while($array2=mysql_fetch_assoc($result2))
{
$r=mysql_fetch_array(mysql_query("select shedcode from layer_flock where flockcode='$array2[flock]'"));
$house.= $r[shedcode].',';
echo substr($house,0,-1); 
}  ?></td>
		
	<?php $rtotal=$i=0;
   while( $i < count($codearray))	
	{ 
$query1="SELECT sum(packets) as packets FROM `layer_depro` where date1='$array[date1]' and packetcode='$codearray[$i]'";
$result1=mysql_query($query1) or die(mysql_error());
$array1=mysql_fetch_array($result1);
	?>	
		<td class="ewRptGrpField1" align="right" >
<?php  if($array1[packets]=='' or $array1[packets]=='0') echo '&nbsp;'; else echo changeprice1($array1[packets]); $rtotal+=$array1[packets]; $$codearray[$i]+=$array1[packets]; ?></td>

<?php $i++; } ?>
<td class="ewRptGrpField1" align="right" >
<?php echo changeprice1($rtotal); ?>
</td>


	</tr>
<?php
}
?>
	</tbody>
	<tfoot>
<tr><td align="right" colspan="2"><strong>Total</strong></td>

<?php $total=$i=0;
   while( $i < count($codearray))	
	{ 
	 ?>
	 <td class="ewRptGrpField1" align="right" > <?php  echo $$codearray[$i]; $total+=$$codearray[$i]; ?></td>
	 <?php
	$i++;
	}
?>
<td class="ewRptGrpField1" align="right" >
<?php echo changeprice1($total); ?>
</td>
</tr>
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
	var shed= document.getElementById('shed').value;
	document.location = "packetsreport.php?fromdate=" + fdate + "&todate=" + tdate+ "&shed=" + shed;
}
</script>