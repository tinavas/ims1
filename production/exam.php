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
<?php }
include "reportheader.php"; 
//include "config.php"; 

 $db = 'onlinetest';
 
 $db_host = "localhost";

 $db_user = "poultry";

 $db_pass = "tulA0#s!";
 
$conn1=mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
 mysql_select_db($db);

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Exam Results</font></strong></td>
</tr>
<tr height="5px"></tr>
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
&nbsp;&nbsp;<a href="exam.php?export=html">Printer Friendly</a>
&nbsp;&nbsp;<a href="exam.php?export=excel">Export to Excel</a>
&nbsp;&nbsp;<a href="exam.php?export=word">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="exam.php?cmd=reset">Reset All Filters</a>
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
		S NO
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">S NO</td>
			</tr></table>
		</td>
<?php } ?>
	
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		ID
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">ID</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		User ID
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">User Id</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Verbal
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Verbal</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Apptitude
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Apptitude</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Technical
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Technical</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
	Total
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center" >Total</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$q="SELECT distinct(userid) FROM `results` where userid <> 1 order by userid ";
$r=mysql_query($q,$conn1) or die(mysql_error());
$i=0;
while($a=mysql_fetch_assoc($r))
{  $i++; $userid=$a['userid'];
 
 $q="select user_name from users where userid = '$userid' ";
 $r1 = mysql_query($q,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($r1);
 $username= $rows1['user_name'];
 
 $q="select result_points from results where userid = '$userid' and testid='4'";
 $r1 = mysql_query($q,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($r1);
 $verbal=$rows1['result_points'];
 
 $q="select result_points from results where userid = '$userid'  and testid='3'";
 $r1 = mysql_query($q,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($r1);
 $technical=$rows1['result_points'];
 
 $q="select result_points from results where userid = '$userid'  and testid='2'";
 $r1 = mysql_query($q,$conn1) or die(mysql_error());
 $rows1 = mysql_fetch_assoc($r1);
 $apptitude=$rows1['result_points'];
 $total=$technical+$verbal+$apptitude;
?>
	<tr>
	 <td class="ewRptGrpField3"  >
<?php echo ewrpt_ViewValue($i); ?></td>
		<td class="ewRptGrpField1">
<?php echo ewrpt_ViewValue($userid) ?></td>
		<td class="ewRptGrpField2"  >
<?php echo ewrpt_ViewValue($username); ?></td>
		<td class="ewRptGrpField1"  >
<?php echo ewrpt_ViewValue($verbal); ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($apptitude) ?></td>
<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($technical) ?></td>
		<td class="ewRptGrpField3"  >
<?php echo ewrpt_ViewValue($total) ?></td>
		
		
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
<?php  } ?>
<?php include "phprptinc/footer.php"; ?>
