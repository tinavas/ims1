<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";

$name = $_GET['name'];
if(($name == 'All') || ($name == '-select-') || ($name == ""))
{
	$cond="";
}
else
{
	$cond=" and ename='$name'";
}
if($_GET['fromdate']<>"")
$fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
$fromdate = date("Y-m-d");

if($_GET['todate']<>"")
$todate = date("Y-m-d",strtotime($_GET['todate'])); 

else
$todate=date("Y-m-d");

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Employee Debit Note Report</font></strong></td>
</tr>
<?php 
if(($name == 'All') || ($name == '-select-') || ($name == ""))
{}else
{
?>
<tr height="5px"></tr>
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Supplier Name : <?php echo $name;?></font></strong></td>
</tr>
<?php } ?>
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
&nbsp;&nbsp;<a href="empbebitnotereport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="empbebitnotereport.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="empbebitnotereport.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="empbebitnotereport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&name=<?php echo $name;?>">Reset All Filters</a>
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
		Crnum
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Crnum</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if(($name == 'All') || ($name == '-select-') || ($name == ""))
			{

		?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Name
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Name</td>
			</tr></table>
		</td>
		<?php }
		}?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
		Coa
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Coa</td>
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
		Dr
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Dr</td>
			</tr></table>
		</td>
		<?php } ?>
		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader">
			Cr
		</td>
		<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td>Cr</td>
			</tr></table>
		</td>
		<?php } ?>
	</tr>
</thead>
	<tbody>
<?php
$dramnt=0;
$cramnt=0; 
$query="SELECT `tid`, `date`, `ename`, `code`, `description`, `crdr`, `dramount`, `cramount` FROM `hr_empcrdrnote` where mode = 'EDN' and `date` >='$fromdate' and `date` <= '$todate' $cond order by tid ";
$result=mysql_query($query,$conn1);
while($rows=mysql_fetch_assoc($result))
{ 
?>
	<tr>
	<tr>
	
	
	
		
		
<?php $datesample = date("d.m.Y",strtotime($rows['date']));?>

	<td<?php echo $sItemRowClass; ?>>

<?php if(($datesample <> $oldcode) || ($dumm == 0)){ echo ewrpt_ViewValue($datesample);

     $oldcode = $datesample; $dumm = 1; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>
	
	
			
	<td<?php echo $sItemRowClass; ?>>

<?php if(($rows['tid'] <> $oldtid) || ($dumm2 == 0)){ echo ewrpt_ViewValue($rows['tid']);

     $oldtid = $rows['tid']; $dumm2 = 1; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>
	</td>
	<td<?php echo $sItemRowClass; ?>>
	
		<?php if(($name == 'All') || ($name == '-select-') || ($name == ""))
			{
		 if(($rows['ename'] <> $oldname) or ($dumm15 == 0)){ echo ewrpt_ViewValue($rows['ename']);

     $oldname = $rows['ename']; $dumm15 = 1; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 }  } ?>

		<td class="ewRptGrpField4">
			<?php echo ewrpt_ViewValue($rows['code']); ?>
		</td>
		<td class="ewRptGrpField5">
			<?php echo ewrpt_ViewValue($rows['description']); ?>
		</td>
		<td class="ewRptGrpField6">
			<?php echo ewrpt_ViewValue($rows['dramount']); $dramnt=$dramnt+$rows['dramount']; ?>
		</td>
		<td class="ewRptGrpField7">
			<?php echo ewrpt_ViewValue($rows['cramount']); $cramnt=$cramnt+$rows['cramount'];?>
		</td>
	</tr>
<?php
}
?>
<tr>
	<td colspan="3" class="ewRptGrpField1">&nbsp;</td>
	<?php if(($name == 'All') || ($name == '-select-') || ($name == ""))
			{
		?>
	<td colspan="2" class="ewRptGrpSummary4">Sum</td>
	<?php } else
	{?>
	<td colspan="1" class="ewRptGrpSummary4">Sum</td>
	<?php } ?>
	<td colspan = "1" class="ewRptGrpSummary5" align="right">
	<?php echo $dramnt; ?>
	<td colspan = "1" class="ewRptGrpSummary6" align="right">
	<?php echo $cramnt; ?>
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
	var tdate = document.getElementById('todate').value;
	document.location = "empdebitnotereport.php?fromdate=" + fdate + "&todate=" + tdate + "&name=<?php echo $name;?>" ;
}
</script>