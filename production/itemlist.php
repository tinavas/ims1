<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 

if($_GET['type']<>"")
{
  $type=$_GET['type'];
$cond=" cat='$type' and  "; 
 
 }
 
 else
  {
  
  $type="";
  $cond="";
  
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Item List Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Category:</font></strong><?php  if($_GET['type'] =="") {echo "All";} else { echo $type; } ?> </td>
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
&nbsp;&nbsp;<a href="itemlist.php?export=html&type=<?php echo $type; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="itemlist.php?export=excel&type=<?php echo $type; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="itemlist.php?export=word&type=<?php echo $type; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="itemlist.php?cmd=reset&type=<?php echo $type; ?>">Reset All Filters</a>
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
 <td>Category</td>
 <td><select name="cat" id="cat" onchange="reloadpage();">
 <option value="">--All--</option>
 <?php
 
 
 $query="SELECT DISTINCT (TYPE) as cat
FROM `ims_itemtypes` ";

$result=mysql_query($query,$conn1);
while($row1=mysql_fetch_array($result))
{

 ?>
<option value="<?php echo $row1['cat'];?>" <?php if($type==$row1['cat']) { ?> selected="selected" <?php  }?>><?php echo $row1['cat'];?></option>
 
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
		<td valign="bottom" class="ewTableHeader">
		Category
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Category</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Storage&nbsp;units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Storage&nbsp;units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Storage&nbsp;units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Consumption&nbsp;units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Calculation&nbsp;Mode
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Calculation&nbsp;Mode</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Usage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Usage</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Source
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Source</td>
			</tr></table>
		</td>
<?php } ?>





<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		ItemA/C
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>ItemA/C</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Consumption A/C
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Consumption A/C</td>
			</tr></table>
		</td>
<?php } ?>




	</tr>
	</thead>
	<tbody>
<?php 
{ 

 $query="SELECT distinct(cat),code,description,sunits,cunits,cm,iusage,source,iac,wpac FROM ims_itemcodes WHERE $cond (client = '$client') GROUP BY ims_itemcodes.code ORDER BY ims_itemcodes.cat ";
$result=mysql_query($query,$conn1);

while($row=mysql_fetch_array($result))
{


$x_cat=$row['cat'];
$x_code=$row['code'];
$x_description=$row['description'];
$x_sunits=$row['sunits'];
$x_cunits=$row['cunits'];

$x_cm=$row['cm'];
$x_iusage=$row['iusage'];

$x_source=$row['source'];
$x_itemac=$row['iac'];
$x_wpac=$row['wpac'];

?>
	<tr>
	
	<td<?php echo $sItemRowClass; ?>>
<?php if(($x_cat <> $oldcode) or ($dumm == 0)){ echo ewrpt_ViewValue($x_cat);
     $oldcode = $x_cat; $dumm = 1; }
	 else{
	 echo ewrpt_ViewValue("&nbsp;");
	 } ?>
	
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_code) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_description) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_sunits) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cunits) ?>
</td>

		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_cm) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_iusage) ?>
</td>
		<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_source) ?>
</td>


<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_itemac) ?>
</td>
<td<?php echo $sItemRowClass; ?>>
<?php echo ewrpt_ViewValue($x_wpac) ?>
</td>
	</tr>
<?php

}
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
	var type = document.getElementById('cat').value;

	document.location = "itemlist.php?type="+type;
}
</script>