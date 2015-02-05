<?php 
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

 $ptype =$_GET['ptype'];
if($ptype == "All" ||$ptype =="")
{
$pt = '<>';
}
else
{
$pt = '=';
}


$warehouse = $_GET['warehouse'];

if($warehouse == "All"||$warehouse =="")
{
$ware = '<>';
} 
else
{
$ware = '=';
}

$formula = $_GET['formula'];
if($formula == "All"||$formula =="")
{
$fm = '<>';
}
else
{
$fm = '=';
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Production Unit</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td align="center"><strong><font color="#3e3276">Warehouse:</font></strong><?php if($_GET['warehouse']==""||$_GET['warehouse']=="All") echo "All" ;else echo $_GET['warehouse'];?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td align="center"><strong><font color="#3e3276">Product Type:</font></strong><?php if($_GET['ptype']==""||$_GET['ptype']=="All") echo "All";else echo $_GET['ptype'];?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td align="center"><strong><font color="#3e3276">Formula:</font></strong><?php if($_GET['formula']==""||$_GET['formula']=="All") echo "All";else echo $_GET['formula'];?></td>
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
&nbsp;&nbsp;<a href="productionsmry.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&ptype=<?php echo $_GET['ptype']; ?>&formula=<?php echo $_GET['formula']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="productionsmry.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&ptype=<?php echo $_GET['ptype']; ?>&formula=<?php echo $_GET['formula']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="productionsmry.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&ptype=<?php echo $_GET['ptype']; ?>&formula=<?php echo $_GET['formula']; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="productionsmry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&ptype=<?php echo $_GET['ptype']; ?>&formula=<?php echo $_GET['formula']; ?>">Reset All Filters</a>
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
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>
 <td>To</td>
 <td><input type="text" name="todate" id="todate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  onchange="reloadpage();"/></td>
 <td>Warehouse</td>
 <td><select name="warehouse" id="warehouse" onchange="reloadpage();"/>
 <option value="All">All</option>
<?php
$q = "select distinct(warehouse) from product_productionunit  order by warehouse";
$qrs = mysql_query($q);
 while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['warehouse']; ?>" <?php if($_GET['warehouse'] == $qr['warehouse']) { ?> selected="selected" <?php } ?> ><?php echo $qr['warehouse']; ?></option>
<?php } ?>
</select>
 
 </td>
 <td>Product Type</td>
 <td>
 	<select id="producttype" name="producttype" onchange="reloadpage()"  style="width:120px">
	<option value="All">-All-</option>
	<?php
		$query1 = "select DISTINCT(producttype) from product_productionunit ORDER BY producttype";
		$result1 = mysql_query($query1,$conn1) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result1))
		{
	?>
			<option title="<?php echo $rows['producttype'];?>" value="<?php echo $rows['producttype'];?>" <?php if($_GET['ptype']==$rows['producttype']){?> selected="selected" <?php } ?> ><?php echo $rows['producttype'];?></option>
	<?php
		}
	?>
	</select>
 </td>
 <td>Formula</td>
 <td>
 	<select id="formula" name="formula" onchange="reloadpage()"  style="width:120px">
	<option value="All">-All-</option>
	<?php
		$query2 = "select DISTINCT(formula) from product_productionunit ORDER BY formula";
		$result2 = mysql_query($query2,$conn1) or die(mysql_error());
		while($rows2 = mysql_fetch_assoc($result2))
		{
	?>
			<option title="<?php echo $rows2['formula'];?>" value="<?php echo $rows2['formula'];?>" <?php if($_GET['formula']==$rows2['formula']){?> selected="selected" <?php } ?> ><?php echo $rows2['formula'];?></option>
	<?php
		}
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
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Product Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Product Type</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Formula
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Formula</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Batches
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Batches</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Mat.Consumed
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Mat.Consumed</td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Production
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Production</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Shrinkage
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Shrinkage</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Mat.Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Mat.Cost</td>
			</tr></table>
		</td>
<?php } ?>

<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Shrnk.Cost
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Shrnk.Cost</td>
			</tr></table>
		</td>
<?php } ?><?php */?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Product Cost/Kg
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Product Cost/Kg</td>
			</tr></table>
		</td>
<?php } ?>


	</tr>
	</thead>
	<tbody>
<?php 

$q="select * from product_productionunit where date>='$fromdate' and date<='$todate' and warehouse $ware '$warehouse' and producttype $pt '$ptype' and formula $fm '$formula' ORDER BY warehouse, producttype, formula";
$res=mysql_query($q);
while($r=mysql_fetch_assoc($res))
{
  
?>
	<tr>
		<td class="ewRptGrpField2">
<?php 
if($ware1!=$r['warehouse'])
echo ewrpt_ViewValue($r['warehouse']);
else
 ?>
 &nbsp; 
 </td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r['producttype']); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['formula']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php 
 $date = date("d.m.Y",strtotime($r['date']));
echo ewrpt_ViewValue($date); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['batches']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round($r['matconsumed'],2)); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['production']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['shrinkage']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(round($r['materialcost'],2)); ?></td>
<td class="ewRptGrpField1" align="right">
<?php /*?><?php echo ewrpt_ViewValue($r['shrinkagecost']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php */?><?php echo ewrpt_ViewValue(round($r['productcostperkg'],2)); ?></td>
	</tr>
<?php
$ware1=$r['warehouse'];
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var sect = document.getElementById("warehouse").value;
	var product= document.getElementById("producttype").value;
	 var formula = document.getElementById("formula").value;
	document.location = "productionsmry.php?fromdate=" + fdate + "&todate=" + tdate+"&warehouse="+sect+"&ptype="+product+"&formula="+formula;
}
</script>