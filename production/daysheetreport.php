<?php 
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
<?php } ?> 
<?php 

include "reportheader.php"; 
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Day Sheet Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong>Date : </strong><?php echo date("d.m.Y"); ?></td>
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
&nbsp;&nbsp;<a href="daysheetreport.php?export=html&fromdate=<?php echo $fromdate; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="daysheetreport.php?export=excel&fromdate=<?php echo $fromdate; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="daysheetreport.php?export=word&fromdate=<?php echo $fromdate; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="daysheetreport.php?cmd=reset&fromdate=<?php echo $fromdate; ?>">Reset All Filters</a>
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
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0" align="center">

	<thead>
	 <tr>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Client
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Client</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Breeder DE
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Breeder DE</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Hatchery
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Hatchery</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Feed Mill
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Feed Mill</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Broiler DE
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Broiler DE</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Purchases
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Purchases</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Sales
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sales</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Payments
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Payments</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Receipts
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Receipts</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php
$conn = mysql_connect("localhost","poultry","tulA0#s!");
mysql_select_db("users");
$query1 = "select name,db,client from bims union select name,db,client from pms2";
$result1 = mysql_query($query1,$conn) or die(mysql_error());
while($rows1 = mysql_fetch_assoc($result1))
{
 mysql_select_db($rows1['db']);
 $client = $rows1['client'];
?>
	<tr>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($rows1['name']) ?></td>
<?php
 $date = "";
 $query2 = "select max(date2) as date from breeder_consumption where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(hatchdate) as date from hatchery_hatchrecord where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(date) as date from feed_productionunit where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(entrydate) as date from broiler_daily_entry where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(date) as date from pp_sobi where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(date) as date from oc_cobi where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(date) as date from pp_payment where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>
<?php
 $date = "";
 $query2 = "select max(date) as date from oc_receipt where client = '$client'";
 $result2 = mysql_query($query2,$conn);
 $rows2 = mysql_fetch_assoc($result2);
 $date = date("d.m.Y",strtotime($rows2['date']));
 if($date == "01.01.1970")
  $date = "";
 ?>
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($date) ?></td>

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
<script type="text/javascript">
function reloadpage()
{
	var fdate = document.getElementById('fromdate').value;
	document.location = "daysheetreport.php?fromdate=" + fdate;
}
</script>