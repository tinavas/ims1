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
 if($_GET[party]<>'')
 {
 $party=$_GET[party];
 $cond="and party='$_GET[party]'";
 }
 else
 {
 $party='';
 $cond="and party<>''";
 }
 
 if($_GET[cat]<>'' )
 {
 $cat=$_GET[cat];
 $cond1="and category='$_GET[cat]'";
 }
 else
 {
 $cat="";
 $cond1="and category<>''";
 }
 
 if($_GET[code]<>'' && $_GET[code]<>'undefined')
 {
 @$code=$_GET[code];
 $description=$_GET[desc];
 $cond2="and code='$_GET[code]'";
 }
 else
 {
 $code="";
 $description="";
 $cond2="and code<>' '";
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Receive Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
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
&nbsp;&nbsp;<a href="templet.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="templet.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="templet.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="templet.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>">Reset All Filters</a>
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
 <td>Customer</td>
 <td><select id="party" name="party" onchange="reloadpage();">
<option value="" >All</option>

<?php
$q = "select distinct(party) from oc_cobi order by party";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['party']; ?>" <?php if($party == $qr['party']) { ?> selected="selected" <?php } ?> ><?php echo $qr['party']; ?></option>
<?php } ?>
</select></td>
<td>Category</td>
<td><select id="cat" name="cat" style="width:80px;" onchange="reloadpage();">
<option value="" >All</option>

<?php
$q = "SELECT distinct(category) as cat FROM distribution_salesreceipt ";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title = "<?php echo $qr['cat'];?>" value="<?php echo $qr['cat']; ?>" <?php if($cat == $qr['cat']) { ?> selected="selected" <?php } ?> ><?php echo $qr['cat']; ?></option>
<?php } ?>
</select></td>
<td>Code</td>
<td>
<select id="code" name="code" style="width:80px;" onchange="reloadpage()">
<option value="" >All</option>

<?php
$q = "select distinct(code),description from distribution_salesreceipt where category='$cat' order by code";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title = "<?php echo $qr['description'];?>" value="<?php   echo $qr[code]."@".$qr['description']; ?>"  <?php if($code == $qr['code']) { ?> selected="selected" <?php } ?> ><?php echo $qr['code']; ?></option>
<?php } ?>
</select></td>
<td>Description</td>
<td>
<select id="desc" name="desc" style="width:100px;" onchange="reloadpage1()">
<option value="" >All</option>

<?php
$q = "select distinct(description),code from distribution_salesreceipt where category='$cat' order by description";
$qrs = mysql_query($q,$conn1);
while($qr = mysql_fetch_assoc($qrs))
{
?>
<option title="<?php echo $qr['code']; ?>" value="<?php   echo $qr[code]."@".$qr['description']; ?>" <?php if($description == $qr['description']) { ?> selected="selected" <?php } ?> ><?php echo $qr['description']; ?></option>
<?php } ?>
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
		<td valign="bottom" class="ewTableHeader">
		Customer
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Customer</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Warehouse
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Warehouse</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Invoice
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Invoice</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Book Invoice
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Book Invoice</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Item Description</td>
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
<?php /*?><?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Free Quantity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Free Quantity</td>
			</tr></table>
		</td>
<?php } ?><?php */?>

	</tr>
	</thead>
	<tbody>
<?php 
$qq="select * from distribution_salesreceipt  where date between '$fromdate' and '$todate' $cond $cond1 $cond2 order by `date`,trnum,invoice";
$q1=mysql_query($qq,$conn1);
while($r=mysql_fetch_array($q1))
{ 
?>
	<tr>
    <?php if($trnum==$r[trnum])
	{?>
    		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
	<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue() ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
		<td class="ewRptGrpField1" align="right">
    <?php 
	} else
	{?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r[party]) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r[warehouse]); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['date']); ?></td>
	<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r[invoice]) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r[trnum]); ?></td>
		<td class="ewRptGrpField1" align="right">
        <?php }?>
<?php echo ewrpt_ViewValue($r[code]); ?></td>
	<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($r[description]) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r[cquantity]); ?></td>
	
	</tr>
<?php
$trnum=$r[trnum];
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
	var party = document.getElementById('party').value;
	var code = document.getElementById('code').value;
	if(code!="")
	{
	 document.getElementById('desc').value=code;
	 code=code.split("@");
	 }
	
	var cat = document.getElementById('cat').value;
	document.location = "salereceivereport.php?fromdate=" + fdate + "&todate=" + tdate+ "&party=" + party+ "&cat=" + cat+ "&code=" + code[0]+ "&desc=" + code[1];
}
function reloadpage1()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var party = document.getElementById('party').value;
	var desc = document.getElementById('desc').value;
	if(desc!="")
	{
	 document.getElementById('code').value=desc;
	 code=desc.split("@");
	 }
	
	var cat = document.getElementById('cat').value;
	document.location = "salereceivereport.php?fromdate=" + fdate + "&todate=" + tdate+ "&party=" + party+ "&cat=" + cat+ "&code=" + code[0]+ "&desc=" + code[1];
}
</script>