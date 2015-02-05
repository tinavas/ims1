<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
 $formula =$_GET['formula'];

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Feed Formula Summary</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td>&nbsp;</td>
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
&nbsp;&nbsp;<a href="#" onclick="reloadpage('html','','SELECT');">Printer Friendly</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('excel','','');">Export to Excel</a>
&nbsp;&nbsp;<a href="#" onclick="reloadpage('word','','');">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Feed_Millsmry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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

<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	<tr>
  <td valign="bottom" class="ewTableHeader">Item Code</td><td valign="bottom" class="ewTableHeader">Item Description</td>	

  <td valign="bottom" class="ewTableHeader"><?php  echo $formula;  ?></td>


</tr>  
	</thead>
	<tbody>
<?php 
 $query = "SELECT sum( quantity ) AS quantity, ingredient,sid FROM feed_fformula where sid = '$formula' GROUP BY ingredient ORDER BY ingredient";

$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{
 $values[$res['ingredient']][$res['sid']] = $res['quantity']; 
 $total[$res['sid']] += $res['quantity'];
} 
 
 $query = "select distinct(ingredient),description from feed_fformula f,ims_itemcodes i where sid = '$formula' and f.ingredient = i.code ORDER BY f.ingredient";
$result = mysql_query($query,$conn1) or die(mysql_error());
$size = sizeof($sidvalues);
while($res = mysql_fetch_assoc($result))
{
?>
<tr><td><?php echo $res['ingredient'];?></td><td><?php echo $res['description'];?></td>

   <td align="right"><?php if($values[$res['ingredient']][$formula]) echo round($values[$res['ingredient']][$formula],2); else echo "0"; ?> </td> 

</tr>
<?php } ?>
<tr>
 <td colspan="2" align="right" style="padding-right:5px;">Total</td>

  <td align="right"><?php echo round($total[$formula],2); ?></td>

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
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<script type="text/javascript">

function reloadpage(type,limittype,sel)
{
var formula = "<?php echo $formula; ?>";
	document.location = 'feedformulasummary.php?formula=' + formula + '&export='+type; 
	
	//document.location = 'Feed_Millsmry.php?feedtype=' + feedtype + '&export=' + type + '&limit=' + limit;
}
function resetpage()
{
var formula = "<?php echo $formula; ?>";
document.location = 'feedformulasummary.php?formula=' + formula;
}
</script>