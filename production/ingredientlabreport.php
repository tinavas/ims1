<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
 	$fromdate=$_GET['fromdate'];
	$time1=strtotime($fromdate);
	$fromdate1=date('d.m.Y',$time1);
	$todate=$_GET['todate'];
	$time2=strtotime($todate);
	$todate1=date('d.m.Y',$time2);
	$suppliers=$_GET['suppliers'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Ingredient Lab Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
	<td colspan="2" align="center"><strong><font color="#3e3276">Supplier:</font></strong><?php echo $suppliers; ?></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo $fromdate1; ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo $todate1; ?>
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
&nbsp;&nbsp;<a href="ingredientlabreport.php?export=html&fromdate=<?php echo $fromdate1;?> &todate=<?php echo $todate1;?>&suppliers=<?php echo $suppliers;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="ingredientlabreport.php?export=excel&fromdate=<?php echo $fromdate1;?> &todate=<?php echo $todate1;?>&suppliers=<?php echo $suppliers;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="ingredientlabreport.php?export=word&fromdate=<?php echo $fromdate1;?> &todate=<?php echo $todate1;?>&suppliers=<?php echo $suppliers;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="ingredientlabreport.php?cmd=reset">Reset All Filters</a>
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
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Bill No/Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Bill No/Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Lab No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Lab No</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Item Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		MOIS
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">MOIS</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		SAND
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">SAND</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		PROT
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">PROT</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		FAT
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">FAT</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		FIBRE
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">FIBRE</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		SALT
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">SALT</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		CALC
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">CALC</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		PHOS
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">PHOS</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		O & A
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">O & A</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		FLOUR
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">FLOUR</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		FFA
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">FFA</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		U/A
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">U/A</td>
			</tr></table>
		</td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php 
	
	include "config.php";
	$query = "select `date1`,`documentno`,`desc`,`labno`,`misture`,`sand`,`protein`,`fat`,`fiber`,`salt`,`calcium`,`phosphorous`,`o_a`,`flour`,`ffa`,`u_a`,`narration` from `lab_ingredient` where suppliers='$suppliers'";
	$result = mysql_query($query,$conn1) or die(mysql_error());
	while($rows=mysql_fetch_assoc($result))
	{
	$date1=$rows['date1'];
	$time3=strtotime($date1);
	 $date2=date('d.m.Y',$time3);
	 if($time3>=$time1 && $time3<=$time2)
	 {
?>
	<tr>
		<td class="ewRptGrpField2" align="right">
			<?php echo $rows['documentno']."/".$rows['date1']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['labno']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['desc']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['misture']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['sand']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['protein']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['fat']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['fiber']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['salt']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['calcium']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['phosphorous']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['o_a']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['flour']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['ffa']; ?>
		</td>
		<td class="ewRptGrpField3" align="right">
			<?php echo $rows['u_a']; ?>
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
<?php include "phprptinc/footer.php"; ?>
<?php } ?>
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	document.location = "templet.php?fromdate=" + fdate + "&todate=" + tdate;
}
</script>