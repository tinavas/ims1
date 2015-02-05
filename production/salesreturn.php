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
if($_GET['status'] == "")
 $status = "All";
else
 $status = $_GET['status'];
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
	 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Return Report
	 	</font></strong>
	 </td>
</tr>
<tr height="5px"></tr>
<tr>
	<td><strong><font color="#3e3276">From Date </font></strong>
	    <?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;
		<strong><font color="#3e3276">To Date </font></strong>
		<?php echo date($datephp,strtotime($todate)); ?>
	</td>
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
&nbsp;&nbsp;<a href="salesreturn.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>&code=<?php echo $code?>&desc=<?php echo $desc;?>&status=<?php echo $status;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="salesreturn.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>&code=<?php echo $code?>&desc=<?php echo $desc;?>&status=<?php echo $status;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="salesreturn.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>&code=<?php echo $code?>&desc=<?php echo $desc;?>&status=<?php echo $status;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="salesreturn.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>&code=<?php echo $code?>&desc=<?php echo $desc;?>&status=<?php echo $status;?>">Reset All Filters</a>
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
 	<td><input type="text" name="fromdate" id="fromdate" class="datepicker" 
		value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  
		onChange="reloadpage();"/></td>
 	<td>To</td>
 	<td><input type="text" name="todate" id="todate" class="datepicker" 
		value="<?php echo date("d.m.Y",strtotime($todate)); ?>"  
		onchange="reloadpage();"/></td>
 	<td>Party Name</td>
 	<td><select name="name" id="name" onChange="reloadpage();" style="width:140px">
      <option value="All" <?php if($name == "All") { ?> selected="selected"<?php } ?>>All </option>
      <?php      
           $query = "SELECT distinct(party) FROM `oc_salesreturn` where flag = 1 
		   ORDER BY party ASC ";
           $result = mysql_query($query,$conn1) ; 
           while($row1 = mysql_fetch_assoc($result))
           {
	 ?>
      <option title="<?php echo $row1['party']; ?>" value="<?php echo $row1['party']; ?>" <?php if($name == $row1['party']) { ?> selected="selected" <?php } ?>><?php echo $row1['party']; ?></option>
      <?php } ?>
    </select></td>
</tr>
<td>ItemCode</td>
<td>
<select name="code" id="code" onChange="changecode(this.value);" style="width:140px">
<option value="All" <?php if($code == "All") { ?> selected="selected"<?php } ?>>All</option>
<?php      
           $query2 = "SELECT distinct(`code`),`description` FROM `oc_salesreturn` where flag = 1 ORDER BY code ASC  ";
           $result2 = mysql_query($query2,$conn1); 
           while($row2 = mysql_fetch_assoc($result2))
           {
?>
<option title="<?php echo $row2['code']; ?>" value="<?php echo $row2['code']."@".$row2['description']; ?>" <?php if($code == $row2['code']) { ?> selected="selected" <?php } ?>><?php echo $row2['code']; ?></option>
<?php } ?>
</select></td>
<td>Description</td>
<td>
<select name="desc" id="desc" onChange="changedesc(this.value);" style="width:140px">
<option value="All" <?php if($desc == "All") { ?> selected="selected"<?php } ?>>All</option>
<?php      
           $query3 = "SELECT distinct(`code`),`description` FROM `oc_salesreturn` where flag = 1 ORDER BY description ASC";
           $result3 = mysql_query($query3,$conn1); 
           while($row3 = mysql_fetch_assoc($result3))
           {
?>
<option title="<?php echo $row3['description']; ?>" value="<?php echo $row3['code']."@".$row3['description']; ?>" <?php if($desc == $row3['description']) { ?> selected="selected" <?php } ?>><?php echo $row3['description']; ?></option>
<?php } ?>
</select></td>

	<td>Goods Status</td>
	<td>
		<select name="status" id="status" onChange="reloadpage();" style="width:140px">
		<option value="All" <?php if($status == "All") { ?> selected="selected"<?php } ?>>			         All</option>
		<?php      
           $query4 = "SELECT distinct(`type`) FROM `oc_salesreturn` where flag = 1 
		   ORDER BY type ASC";
           $result4= mysql_query($query4,$conn1); 
           while($row4 = mysql_fetch_assoc($result4))
           {
		?>
		<option title="<?php echo $row4['type']; ?>" value="<?php echo $row4['type']; ?>" <?php if($status == $row4['type']) { ?> selected="selected" <?php } ?>><?php echo $row4['type']; ?></option>
		<?php } ?>
		</select>	</td>
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
			<td style="width:100px;" align="center">Date</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Document No
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Document No</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Party Name
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Party Name</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
		COBI
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">COBI</td>
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
			<td style="width:100px;" align="center">Item Code</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader"  align="center">
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
		<td valign="bottom" class="ewTableHeader"  align="center">
		Returned <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?>
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Returned <?php if($_SESSION['db']=="vista") { ?>Weight <?php } else { ?>Quantity<?php } ?></td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" align="center">
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
		<td valign="bottom" class="ewTableHeader"  align="center">
		Goods Status
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Goods Status</td>
			</tr></table>
		</td>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php
		include "config.php";
		if($name=="All")
		{$name2="";}
		else
		{$name2="and party='$_GET[name]'";}
		if($code=="All")
		{$code2="";}
		else
		{$code2=" and code='$_GET[code]'";}
		if($status=="All")
		{$status2="";}
		else       
		{$status2=" and type='$_GET[status]'";}
		$q1 ="SELECT `date`,`trid`,`party`,`cobi`,`code`,`description`,`quantity`,`type` FROM `oc_salesreturn` WHERE date between '$fromdate' and '$todate'".$name2.$code2.$status2;
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
				<td class="ewRptGrpField1" >
					<?php echo ewrpt_ViewValue($date1); ?></td>
				<td class="ewRptGrpField2">
					<?php echo ewrpt_ViewValue($qr1['trid']) ?></td>
				<td class="ewRptGrpField8" >
					<?php echo ewrpt_ViewValue($qr1['party']); ?></td>
				<td class="ewRptGrpField3" >
					<?php echo ewrpt_ViewValue($qr1['cobi']); ?></td>
				<td class="ewRptGrpField4" >
					<?php echo ewrpt_ViewValue($qr1['code']); ?></td>
				<td class="ewRptGrpField5" >
					<?php echo ewrpt_ViewValue($qr1['description']); ?></td>
				<td class="ewRptGrpField6" align="right">
					<?php echo ewrpt_ViewValue($qr1['quantity']); ?></td>
				<td class="ewRptGrpField8" >
					<?php echo ewrpt_ViewValue($units); ?></td>
				<td class="ewRptGrpField7" >
					<?php echo ewrpt_ViewValue($qr1['type']); ?></td>				
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

<?php } ?>
<?php include "phprptinc/footer.php"; ?>
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
	var status3 = document.getElementById('status').value;
	document.location = "salesreturn.php?fromdate=" + fdate + "&todate=" + tdate+"&name="+name3+"&code="+code3+"&desc="+desc3+"&status="+status3;
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