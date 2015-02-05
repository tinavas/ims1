<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['superstockist']<>"")
{

$superstockist=$_GET['superstockist'];

$cond1="and superstockist='$superstockist'";

}
else
{

$superstockist="";

$cond1="";

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Area List Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $_SESSION['currency'];?></p></center>

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
&nbsp;&nbsp;<a href="distribution_areareport.php?export=html&superstockist=<?php echo $superstockist; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="distribution_areareport.php?export=excel&superstockist=<?php echo $superstockist; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="distribution_areareport.php?export=word&superstockist=<?php echo $superstockist; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="distribution_areareport.php?cmd=reset&superstockist=<?php echo $superstockist; ?>">Reset All Filters</a>
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
 <td>Super Stockist</td>
 <td>
 <select name="superstockist" id="superstockist" onchange="reloadpage()">
 <option value="">-All-</option>
 <?php
 $q1="select distinct superstockist from distribution_area ";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 
 {
 
 ?>
 <option value="<?php echo $r1['superstockist'];?>" <?php if($r1['superstockist']==$_GET['superstockist']){?> selected="selected"<?php }?>><?php echo $r1['superstockist'];?></option>
 
<?php }?>
 
 
 
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
		Area Code 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Area Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Area Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Area Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		CNF/Super Stockist
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">CNF/Super Stockist</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		State
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">State</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
<?php 

$q1="select * from distribution_area where 1 $cond1 order by superstockist";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{ 
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['areacode']) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r1['areaname']); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r1['superstockist']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r1['state']); ?></td>
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var superstockist = document.getElementById('superstockist').value;
	
	document.location = "distribution_areareport.php?superstockist=" + superstockist ;
}
</script>