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

$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $arrayfeed[++$i] = $rows['feedtype'];
$countfeedtypes = count($arrayfeed);
 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Day wise Raw Material Consumed</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong></td>
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
&nbsp;&nbsp;<a href="feed_daywiseRM.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="feed_daywiseRM.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="feed_daywiseRM.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="feed_daywiseRM.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td>Date</td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" rowspan="2" valign="middle">
		Raw Materials
		</td>
<?php } else { ?>
		<td class="ewTableHeader" rowspan="2" valign="middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center" valign="middle">Raw Materials</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" colspan="<?php echo $countfeedtypes; ?>" align="center">
		Ratio (Doctor)
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="<?php echo $countfeedtypes; ?>" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Ratio (Doctor)</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" colspan="<?php echo $countfeedtypes; ?>">
		Used Stock
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="<?php echo $countfeedtypes; ?>" align="center">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Used Stock</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center" rowspan="2" valign="middle">
		Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader" rowspan="2" valign="middle">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Total</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
<tr>
<?php
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		<?php echo $rows['feedtype']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php echo $rows['feedtype']; ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		<?php echo $rows['feedtype']; ?>
		</td>
<?php } else { ?>
		<td class="ewTableHeader" >
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"><?php echo $rows['feedtype']; ?></td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
</tr>	
	</thead>
	<tbody>
<?php
$i = -1; $codes = "'',";
$query1 = "SELECT DISTINCT(ingredient),quantity,feedtype FROM feed_fformula WHERE formulaid IN (SELECT distinct(formulaid) FROM `feed_productionunit` f1 WHERE mash IN (SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype) AND formulaid = (SELECT formulaid FROM feed_productionunit f2 WHERE f2.mash = f1.mash ORDER BY date DESC LIMIT 1 )) AND quantity > 0 ORDER BY ingredient";
	//The query will give all the raw materials with latest (feed formula with production)
$result1 = mysql_query($query1,$conn1) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 $arraycode[++$i] = $rows1['ingredient'];
 $arrayqty[$rows1['feedtype']][$rows1['ingredient']] = $rows1['quantity'];
 $codes .= "'".$rows1['ingredient']."',";
}

$query = "SELECT sum(quantity) AS quantity,ingredient,feedtype FROM feed_itemwise WHERE date = '$fromdate' AND pid IN (SELECT distinct(id) FROM `feed_productionunit` f1 WHERE mash IN (SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype) AND id = (SELECT id FROM feed_productionunit f2 WHERE f2.mash = f1.mash ORDER BY id DESC LIMIT 1 )) GROUP BY feedtype,ingredient ORDER BY feedtype,ingredient";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
 $usedqty[$rows['feedtype']][$rows['ingredient']] = $rows['quantity'];


$codes = substr($codes,0,-1);
$uniquecodes = array_unique($arraycode,SORT_STRING);
for($i = 0; $i < count($arraycode); $i++) 
{ 
 $code = $uniquecodes[$i];
 if($code <> "")
 {
  $query2 = "SELECT description,cat FROM ims_itemcodes WHERE code = '$code'";
 $result2 = mysql_query($query2,$conn1) or die(mysql_error());
 $rows2 = mysql_fetch_assoc($result2);
 $description = $rows2['description'];

?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($description) ?></td>
<?php
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $arrayqtytot[$rows['feedtype']] += $arrayqty[$rows['feedtype']][$code]; ?>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($arrayqty[$rows['feedtype']][$code]); ?></td>
<?php } ?>
<?php $total = 0;
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ $total += $usedqty[$rows['feedtype']][$code];
$usedqtytot[$rows['feedtype']] += $usedqty[$rows['feedtype']][$code];  ?>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($usedqty[$rows['feedtype']][$code]); ?></td>
<?php } ?>
		<td class="ewRptGrpField2" align="right">
<?php echo ewrpt_ViewValue(changeprice($total)); $grandtotal += $total; ?></td>

	</tr>
<?php
 }
}
?>
	<tr>
		<td class="ewRptGrpField2" align="right"><b>
<?php echo ewrpt_ViewValue("Total") ?></b></td>
<?php
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ ?>
		<td class="ewRptGrpField3" align="right"><b>
<?php echo ewrpt_ViewValue($arrayqtytot[$rows['feedtype']]); ?></b></td>
<?php } ?>
<?php
$query = "SELECT distinct(feedtype) FROM feed_formula ORDER BY feedtype";
$result = mysql_query($query,$conn1) or die(mysql_error());
while($rows = mysql_fetch_assoc($result))
{ ?>
		<td class="ewRptGrpField3" align="right"><b>
<?php echo ewrpt_ViewValue($usedqtytot[$rows['feedtype']]); ?></b></td>
<?php } ?>
		<td class="ewRptGrpField2" align="right"><b>
<?php echo ewrpt_ViewValue(changeprice($grandtotal)); ?></b></td>

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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "feed_daywiseRM.php?fromdate=" + fdate;
}
</script>