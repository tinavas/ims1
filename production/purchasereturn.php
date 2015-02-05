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
if($_GET['name'] == "")
 $name = "All";
else
 $name = $_GET['name'];
if($_GET['code'] == "")
 $code = "All";
else
 $code = $_GET['code'];
if($_GET['desc'] == "")
 $desc = "All";
else
 $desc = $_GET['desc'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Purchase Return Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="purchasereturn.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name; ?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchasereturn.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name; ?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="purchasereturn.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name; ?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchasereturn.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name; ?>&code=<?php echo $code;?>&desc=<?php echo $desc;?>">Reset All Filters</a>
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
</tr>
<tr>
	<td>Supplier Name</td>
	<td>
	<select name="name" id="name" onChange="reloadpage();" style="width:140px">
      <option value="All" <?php if($name == "All") { ?> selected="selected"<?php } ?>>All </option>
      <?php      
        $q3="SELECT distinct(`vendor`) FROM `pp_purchasereturn` where flag = 1 ORDER BY vendor ASC ";
		$r3 = mysql_query($q3,$conn1);
		while($qr3 = mysql_fetch_assoc($r3))
		{
	 ?>
      <option title="<?php echo $qr3['vendor']; ?>" value="<?php echo $qr3['vendor']; ?>" <?php if($name == $qr3['vendor']) { ?> selected="selected" <?php } ?>><?php echo $qr3['vendor']; ?></option>
      <?php } ?>
    </select>	</td>
	<td>Item Code</td>
	<td><select name="code" id="code" onChange="changecode(this.value)" style="width:140px">
      <option value="All" <?php if($code == "All") { ?> selected="selected"<?php } ?>>All</option>
      <?php     
  		$q4="SELECT DISTINCT (`code`), `description` FROM `pp_purchasereturn` WHERE flag =1
ORDER BY code ASC ";
		$r4 = mysql_query($q4,$conn1);
		while($qr4 = mysql_fetch_assoc($r4)) 
           
           {
?>
      <option title="<?php echo $qr4['code']; ?>" value="<?php echo $qr4['code']."@".$qr4['description']; ?>" <?php if($code == $qr4['code']) { ?> selected="selected" <?php } ?>><?php echo $qr4['code']; ?></option>
      <?php } ?>
    </select></td>
	<td>Item Description</td>
	<td>
		<td><select name="desc" id="desc" onChange="changedesc(this.value)" style="width:140px">
      <option value="All" <?php if($code == "All") { ?> selected="selected"<?php } ?>>All</option>
      <?php     
  		$q4="SELECT DISTINCT (`code`), `description` FROM `pp_purchasereturn` WHERE flag =1
ORDER BY code ASC ";
		$r4 = mysql_query($q4,$conn1);
		while($qr4 = mysql_fetch_assoc($r4)) 
           
           {
?>
      <option title="<?php echo $qr4['code']; ?>" value="<?php echo $qr4['code']."@".$qr4['description']; ?>" <?php if($desc == $qr4['description']) { ?> selected="selected" <?php } ?>><?php echo $qr4['description']; ?></option>
      <?php } ?>
    </select></td>
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
		<td valign="bottom" class="ewTableHeader" >
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Suplier Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Suplier Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		SOBI
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">SOBI</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Units
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Units</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Purchase Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Purchase Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Return Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Return Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Warehouse</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
	<?php
		if($name=="All")
		{$name2="";}
		else
		{$name2="and vendor='$_GET[name]'";}
		if($code=="All")
		{$code2="";}
		else
		{$code2=" and code='$_GET[code]'";}
$q1 ="SELECT `date`,`vendor`,`sobi`,`code`,`description`,`purchasedquantity`,`returnquantity`,`warehouse` FROM `pp_purchasereturn`  WHERE date between '$fromdate' and '$todate'".$name2.$code2;
		$r1 = mysql_query($q1,$conn1);
		while($qr1 = mysql_fetch_assoc($r1))
		 {
		 	$q2 ="SELECT `sunits` FROM `ims_itemcodes` where `code`='$qr1[code]'";
			$r2 = mysql_query($q2,$conn1);
			while($qr2 = mysql_fetch_assoc($r2))
		 	{
				$units=$qr2['sunits'];
			}
			$date1=date("d.m.Y",strtotime($qr1['date']));
	?>
	<tr>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($date1); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['vendor']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['sobi']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['code']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['description']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($units); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['purchasedquantity']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['returnquantity']); ?>
		</td>
		<td class="ewRptGrpField2">
			<?php echo ewrpt_ViewValue($qr1['warehouse']); ?>
		</td>
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var name3 = document.getElementById('name').value;
	var code3 = document.getElementById('code').value;
	if(code3!="All")
	{
		var code4=new Array();
	code4=code3.split("@");
	code3=code4[0];
	}
	var desc3 = document.getElementById('desc').value;
	if(desc3!="All")
	{
		var desc4=new Array();
	desc4=desc3.split("@");
	desc3=desc4[1];
	}
	document.location = "purchasereturn.php?fromdate=" + fdate + "&todate=" + tdate+"&name="+name3+"&code="+code3+"&desc="+desc3;
}
function changecode(code)
{
	document.getElementById("desc").value=code;
	reloadpage();
}
function changedesc(desc)
{
	document.getElementById("code").value=desc;
	reloadpage();
}
</script>