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




$warehouse = $_GET['warehouse'];

if($warehouse == "All"||$warehouse =="")
{

$cond1='';
} 
else
{
$wh=$_GET['warehouse'];
$cond1="and ims_stocktransfer.fromwarehouse='$_GET[warehouse]'";
}

$category = $_GET['category'];
if($category == "All"||$category =="")
{
$fmd = '';
}
else
{
$fmd = "AND ims_stocktransfer.cat = '$_GET[category]'";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Stock Transfer</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td align="center"><strong><font color="#3e3276">Warehouse:</font></strong><?php if($_GET['warehouse']==""||$_GET['warehouse']=="All") echo "All" ;else echo $_GET['warehouse'];?></td>
</tr>
<tr height="5px"></tr>
<tr>
<td align="center"><strong><font color="#3e3276">Category:</font></strong><?php if($_GET['category']==""||$_GET['category']=="All") echo "All";else echo $_GET['category'];?></td>
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
&nbsp;&nbsp;<a href="stocktransferreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&category=<?php echo $_GET['ptype']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="stocktransferreport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&category=<?php echo $_GET['ptype']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="stocktransferreport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&category=<?php echo $_GET['ptype']; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="stocktransferreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&warehouse=<?php echo $_GET['warehouse']; ?>&category=<?php echo $_GET['ptype']; ?>">Reset All Filters</a>
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
 <td><select name="warehouse" id="warehouse" onchange="reloadpage()">
<option value="">All</option>
<?php $q1=mysql_query("select distinct(fromwarehouse) as wh from ims_stocktransfer");
 while($r1=mysql_fetch_array($q1))
 {?>
 <option value="<?php echo $r1[wh];?>" <?php if($wh==$r1[wh]){?> selected="selected"<?php }?>><?php echo $r1[wh];?></option>
 <?php 
 }?>
</select>
 
 </td>
 <td>Category</td>
 <td>
				<select id="category" name="category" onchange="reloadpage();">
			<option value="">-Select-</option>
			<option value="All" <?php if($category == "All") { ?> selected="selected" <?php } ?>>All</option>
			<?php
			include "config.php";
			$query = "SELECT distinct(cat) FROM ims_itemcodes ORDER BY cat";
			$result = mysql_query($query,$conn1) or die(mysql_error());
			while($rows = mysql_fetch_assoc($result))
			{
			?>
			<option value="<?php echo $rows['cat']; ?>" <?php if($category == $rows['cat']) { ?> selected="selected" <?php } ?>><?php echo $rows['cat']; ?></option>
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
		<td valign="bottom" class="ewTableHeader" style="width:80px;">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			<td style="width: 20px;" align="right"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:130px;">
		From Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>From Warehouse</td>
			<td style="width: 20px;" align="right"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		To Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>To Warehouse</td>
			<td style="width: 20px;" align="right"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		DC No.
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>DC No.</td>
			<td style="width: 20px;" align="right"></td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item</td>
			<td style="width: 20px;" align="right"></td>
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
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Quantity</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Price
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Price</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Amount</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 

$q="select ims_stocktransfer.date, ims_stocktransfer.fromwarehouse, ims_stocktransfer.towarehouse, ims_stocktransfer.tmno, ims_stocktransfer.code, ims_itemcodes.description, ims_stocktransfer.tounits, ims_stocktransfer.quantity, ims_stocktransfer.price, ims_stocktransfer.quantity * ims_stocktransfer.price As 'amount' from ims_stocktransfer ims_stocktransfer Inner Join ims_itemcodes On ims_stocktransfer.code = ims_itemcodes.code where date>='$fromdate' and date<='$todate' and ims_stocktransfer.client = '$client' $cond1 order by ims_stocktransfer.date ASC, ims_stocktransfer.fromwarehouse ASC";
$res=mysql_query($q);
$prev_date="";
while($r=mysql_fetch_assoc($res))
{
 
?>
	<tr>
		<td class="ewRptGrpField3" align="left">
<?php 
 if($r['date']!=$prev_date)
 {
 $date_arr=explode('-',$r['date']);
echo ewrpt_ViewValue($date_arr[2].".". $date_arr[1].".". $date_arr[0]); 
}
else { echo "&nbsp;"; }
?></td>
		<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['fromwarehouse']); ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['towarehouse']); ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['tmno']); ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['code']); ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['description']); ?></td>
<td class="ewRptGrpField1" align="left">
<?php echo ewrpt_ViewValue($r['tounits']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['quantity']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['price']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['amount']); ?></td>
	</tr>
<?php
$prev_date=$r['date'];
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
	var warehouse = document.getElementById("warehouse").value;
	var category = document.getElementById("category").value;
	
	document.location = "stocktransferreport.php?fromdate=" + fdate + "&todate=" + tdate+"&warehouse="+warehouse+"&category="+category;
}
</script>