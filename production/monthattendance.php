<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php";

 $month = $_GET['month'];
 $datep = date("d-m-Y");
$monthcnt = "";
$yearcnt = "";
$year = $_GET['year'];
if($year == "")
{

$arr = explode('-',$datep);
 $year = $arr[2];
}
if($month == "")
{
  $arr = explode('-',$datep);
 $monthcnt = $arr[1];
}
else if($month == "January")
{
$monthcnt = "01";
}
else if ($month == "February")
{
$monthcnt = "02";
}
else if($month == "March")
{
$monthcnt = "03";
}
else if($month == "April")
{
$monthcnt = "04";
}
else if($month == "May")
{
$monthcnt = "05";
}
else if($month == "June")
{
$monthcnt = "06";
}
else if($month == "July")
{
$monthcnt = "07";
}
else if($month == "August")
{
 $monthcnt = "08";
}
else if($month == "September")
{
$monthcnt = "09";
}
else if($month == "October")
{
$monthcnt = "10";
}
else if($month == "November")
{
$monthcnt = "11";
}
else if($month == "December")
{
$monthcnt = "12";
}
 $fromdate = $year."-".$month."-01";
 $todate = $year."-".$month."-31";



$montharr = array("January","February","March","April","May","June","July","August","September","October","November","December"); 
$month = $_GET['month'];
if($month == "All")
{
$comparemonth = '<>';
}
else
{
$comparemonth = '=';
}


$year = $_GET['year'];

if($year == "All")
{
$compareyear = '<>';
}
else
{
$compareyear = '=';
}

$sector = $_GET['sector'];
if($sector == "All")
{
$comparesector = '<>';
}
else
{
$comparesector = '=';
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Monthly Attendance</font></strong></td>
</tr>
<tr height="5px"></tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Sector : &nbsp;&nbsp;&nbsp;<?php echo $sector; ?></font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
<td style="text-align:center" colspan="2"><strong><font color="#3e3276">Attendance for  <?php echo $montharr[$month-1]; ?>, <?php echo $year; ?></font></strong></td>
<?php /*?><tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr><?php */?> 
</tr>
</table>
 </br>
 </br>
 </br>
 </br>
 
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
<?php if (@$sExport == "") {

$htmllink = "monthattendance.php?export=html&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$excellink = "monthattendance.php?export=excel&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];
$wordlink = "monthattendance.php?export=word&month=".$_GET['month']."&year=".$_GET['year']."&sector=".$_GET['sector'];

?>
&nbsp;&nbsp;<a href="<?php echo $htmllink; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="<?php echo $excellink; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="<?php echo $wordlink; ?>">Export to Word</a>>

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
	<?php if($sector=="All") { ?>
	<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Sector
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sector</td>
			</tr></table>
		</td>
<?php } ?>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Employee Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Employee Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Designation
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Designation</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		From Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">From Date</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		To Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">To Date</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		No.Of Days
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">No.Of Days</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
$tot=$tot1=$tot2=0;
$q="select * from hr_newattendance where sector $comparesector '$sector'  and fromdate between '$fromdate'  and '$todate' order by sector ";
$res=mysql_query($q,$conn1) or die(mysql_error());
while($r=mysql_fetch_assoc($res))
{
$q2=mysql_query("select datediff('$todate','$r[fromdate]') as leaves",$conn1) or die(mysql_error());
$r2=mysql_fetch_array($q2);
?>
	<tr>
	<?php if($sector=="All") { ?>
	    <td class="ewRptGrpField3" align="right">
<?php 
if($sect!=$r['sector'])
echo ewrpt_ViewValue($r['sector']); else
 ?>&nbsp;</td>
<?php } ?>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r['employee']); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['designation']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r[fromdate]); ?></td>
<td class="ewRptGrpField1" align="right">
<?php if($r[fromdate]==$r[todate]) { echo "&nbsp;";} else echo ewrpt_ViewValue($r['todate']); ?></td>

<td class="ewRptGrpField1" align="right">
<?php if($r['leavestaken']==0)  echo ewrpt_ViewValue($r2['leaves']); else echo ewrpt_ViewValue($r['leavestaken']);$tot2=$tot2+ $r['leavestaken']; ?></td>
	</tr>
<?php
$sect=$r['sector'];
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
