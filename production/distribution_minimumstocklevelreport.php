<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 

if($_GET['areacode']<>"")
{

$areacode=$_GET['areacode'];

$cond="and areacode ='$areacode'";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Minimum Stock Level Area Wise</font></strong></td>
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
&nbsp;&nbsp;<a href="distribution_minimumstocklevelreport.php?export=html&areacode=<?php echo $_GET['areacode']; ?>&areaname=<?php echo $_GET['areacode']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="distribution_minimumstocklevelreport.php?export=excel&areacode=<?php echo $_GET['areacode']; ?>&areaname=<?php echo $_GET['areacode']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="distribution_minimumstocklevelreport.php?export=word&areacode=<?php echo $_GET['areacode']; ?>&areaname=<?php echo $_GET['areacode']; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="distribution_minimumstocklevelreport.php?cmd=reset&areacode=<?php echo $_GET['areacode']; ?>&areaname=<?php echo $_GET['areacode']; ?>">Reset All Filters</a>
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
 <td><b>Area Code</b></td>
 <td><select name="areacode" id="areacode" onchange="reloadpage('areacode')">
 <option value="">-All-</option>
 <?php
 $q1="select distinct areacode,areaname from distribution_stocklevel order by areacode";
 
 $q1=mysql_query($q1) or(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 
 
 ?>
 
  <option value="<?php echo $r1['areacode'];?>" title="<?php echo $r1['areaname'];?>" <?php if($_GET['areacode']==$r1['areacode']){?> selected="selected" <?php }?>><?php echo $r1['areacode'];?></option>
 <?php }
 
 ?>
 
 
 
 </select></td>
 <td><b>Area Name</b></td>
 <td><select name="areaname" id="areaname"  onchange="reloadpage('areaname')">
 <option value="">-All-</option>
  <?php
 $q1="select distinct areacode,areaname from distribution_stocklevel order by areacode";
 
 $q1=mysql_query($q1) or(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 {
 
 
 ?>
 
  <option value="<?php echo $r1['areaname'];?>" title="<?php echo $r1['areaname'];?>"<?php if($_GET['areaname']==$r1['areaname']){?> selected="selected" <?php }?>><?php echo $r1['areaname'];?></option>
 <?php }
 
 ?>
 
 </select></td>
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
		From Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		To Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">To Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Category</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Code 
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Description</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Units</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Stock
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Stock</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
<?php 

$dupareacode="";

$q1="SELECT * FROM `distribution_stocklevel` where 1 $cond order by areacode";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{ 

if($dupareacode==$r1['areacode'])
{
$areacode="";
$areaname="";
$fromdate="";
$todate="";
}
else
{
$areacode=$r1['areacode'];
$areaname=$r1['areaname'];
$fromdate=$r1['fromdate'];
$todate=$r1['todate'];
}





?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($areacode) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($areaname); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($fromdate); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($todate) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['category']) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['code']) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['description']) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['units']) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r1['stock']) ?></td>
	</tr>
<?php

$dupareacode=$r1['areacode'];


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
function reloadpage(value)
{
if(value=="areacode")
{
document.getElementById("areaname").options[document.getElementById("areacode").options.selectedIndex].selected="selected";
}

if(value=="areaname")
{
document.getElementById("areacode").options[document.getElementById("areaname").options.selectedIndex].selected="selected";
}


	var areacode = document.getElementById('areacode').value;
	var areaname = document.getElementById('areaname').value;
	document.location = "distribution_minimumstocklevelreport.php?areacode=" + encodeURIComponent(areacode) + "&areaname=" + encodeURIComponent(areaname);
}
</script>