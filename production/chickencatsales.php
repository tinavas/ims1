<!-- <?php 
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
<?php } ?> -->

<?php 
include "jquery.php";
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
if($_GET['todate'] <> "")
 $todate = date("Y-m-d",strtotime($_GET['todate']));
else
 $todate = date("Y-m-d"); 
$cat = $_GET['cat'];
$unit = $_GET['unit']; 
?>
<?php
session_start();
$client = $_SESSION['client'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Chicken Sales</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>Unit : </strong><?php echo $unit; ?>&nbsp;&nbsp;<strong>Category : </strong><?php echo $cat; ?></td>
</tr> 
<tr height="5px"></tr>
<tr>
 <td><strong>From : </strong><?php echo date("d.m.Y",strtotime($fromdate)); ?>&nbsp;&nbsp;<strong>To : </strong><?php echo date("d.m.Y",strtotime($todate)); ?></td>
</tr> 
</table>
<?php 
  if($_SESSION['currency']) $currencyunits=$_SESSION['currency']; else $currencyunits = "Rs";?>
<center><p style="padding-left:430px;color:red"> All amounts in <?php echo $currencyunits ?></p></center>

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
&nbsp;&nbsp;<a href="chickencatsales.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&cat=<?php echo $cat; ?>&unit=<?php echo $unit; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="chickencatsales.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&cat=<?php echo $cat; ?>&unit=<?php echo $unit; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="chickencatsales.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&cat=<?php echo $cat; ?>&unit=<?php echo $unit; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="chickencatsales.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&cat=<?php echo $cat; ?>&unit=<?php echo $unit; ?>">Reset All Filters</a>
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
 <td>From </td>
 <td><input type="text" name="from" id="from" class="datepicker" size="12" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To </td>
 <td><input type="text" name="to" id="to" class="datepicker" size="12" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
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
		Date/Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php
$i = -1;
$query = " select distinct(code),description from ims_itemcodes where cat = '$cat' order by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $itemcode = $rows['code'];
?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		<?php echo $rows['description']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php echo $rows['description']; ?></td>
			</tr></table>
		</td>
<?php } 
$array[++$i] = $rows['code'];
}
?>
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

$query = " select distinct(date) from oc_cobi where code in (select distinct(code) from ims_itemcodes where cat = '$cat') and date between '$fromdate' and '$todate' order by code";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{
 $date = $rows['date'];
?>
	<tr>
		<td class="ewRptGrpField2"><strong><?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($date))) ?></strong></td>
<?php
 $gtotal = 0;
 for($i = 0; $i < count($array); $i++)
 {
 $query2 = "select sum(quantity) as quantity from oc_cobi where code = '$array[$i]' and date = '$date'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 while($rows2 = mysql_fetch_assoc($result2))
 {
  $gtotal += $qty = $rows2['quantity'];
?>
		<td class="ewRptGrpField3" align="right" style="padding-right:5px;"><?php echo ewrpt_ViewValue($qty); ?></td>
<?php
  }	// End of rows2
 }	// End of for
 if($gtotal == '')
  $gtotal = 0;
?>
	<td class="ewRptGrpField3" align="right" style="padding-right:5px;"><?php echo ewrpt_ViewValue($gtotal); ?></td>
	</tr>
<?php	 
}	// End of rows
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
<script type="text/javascript">
function reloadpage()
{
var fromdate = document.getElementById('from').value;
var todate = document.getElementById('to').value;
var cat = "<?php echo $cat; ?>";
var unit1 = "<?php echo $unit; ?>";
document.location = "chickencatsales.php?fromdate=" + fromdate + "&todate=" + todate + "&cat=" + cat + "&unit=" + unit1; 
}
</script>