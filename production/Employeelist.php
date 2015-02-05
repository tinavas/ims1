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
 
 //if($_GET['sector']<>"")
// $sector=$_GET['sector'];
// else
// $sector="";
 
 //For Sector
$sec="All";
$cond1="";
if(isset($_GET['sector']) && $_GET['sector']=="all")
;
else if(isset($_GET['sector']) && $_GET['sector']!="all")
{
	$cond1=" AND sector='".$_GET['sector']."'";
	$sec=$_GET['sector'];
}

//For Designation
$des="All";
$cond2="";
if(isset($_GET['desig']) && $_GET['desig']=="all")
;
else if(isset($_GET['desig']) && $_GET['desig']!="all")
{
	$cond2=" AND designation='".$_GET['desig']."'";
	$des=$_GET['desig'];
}
// for Groupname
$group="All";
$cond3="";
if(isset($_GET['group']) && $_GET['group']=="all")
;
else if(isset($_GET['group']) && $_GET['group']!="all")
{
	$cond3=" AND groupname='".$_GET['group']."'";
	$group=$_GET['group'];
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Employee List</font></strong></td>
</tr>
<tr height="5px"></tr>
<?php /*?><tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>
</tr><?php */?> 
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
&nbsp;&nbsp;<a href="Employeelist.php?export=html&sector=<?php echo $_GET['sector']; ?>&desig=<?php echo $_GET['desig']; ?>&group=<?php echo $_GET['group']; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="Employeelist.php?export=excel&sector=<?php echo $_GET['sector']; ?>&desig=<?php echo $_GET['desig']; ?>&group=<?php echo $_GET['group']; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="Employeelist.php?export=word&sector=<?php echo $_GET['sector'] ;?>&desig=<?php echo $_GET['desig']; ?>&group=<?php echo $_GET['group'] ;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="Employeelist.php?cmd=reset&sector=<?php echo $_GET['sector']; ?>&desig=<?php echo $_GET['desig']; ?>&group=<?php echo $_GET['group']; ?>">Reset All Filters</a>
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
 <td>Sector</td>
 <td><select name="sector" id="sector" onchange="reloadpage();"/>
 <option value="all">All</option>
<?php
$q = "select distinct(sector) from hr_employee  order by sector";
$qrs = mysql_query($q);
 while($qr = mysql_fetch_assoc($qrs))
{
?>
<option value="<?php echo $qr['sector']; ?>" <?php if($_GET['sector'] == $qr['sector']) { ?> selected="selected" <?php } ?> ><?php echo $qr['sector']; ?></option>
<?php } ?>
</select>
 
 </td>
 <td>Designation:</td>
 <td>
 	<select id="desig" name="desig" onchange="reloadpage()"  style="width:120px">
	<option value="all">-All-</option>
	<?php
		$query1 = "select DISTINCT(designation) from hr_employee ORDER BY designation";
		$result1 = mysql_query($query1,$conn1) or die(mysql_error());
		while($rows = mysql_fetch_assoc($result1))
		{
	?>
			<option title="<?php echo $rows['designation'];?>" value="<?php echo $rows['designation'];?>" <?php if($_GET['desig']==$rows['designation']){?> selected="selected" <?php } ?> ><?php echo $rows['designation'];?></option>
	<?php
		}
	?>
	</select>
 </td>
 <td>Group:</td>
 <td>
 	<select id="group" name="group" onchange="reloadpage()"  style="width:120px">
	<option value="all">-All-</option>
	<?php
		$query2 = "select DISTINCT(groupname) from hr_employee where groupname <> '' ORDER BY groupname";
		$result2 = mysql_query($query2,$conn1) or die(mysql_error());
		while($rows2 = mysql_fetch_assoc($result2))
		{
	?>
			<option title="<?php echo $rows2['groupname'];?>" value="<?php echo $rows2['groupname'];?>" <?php if($_GET['group']==$rows2['groupname']){?> selected="selected" <?php } ?> ><?php echo $rows2['groupname'];?></option>
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
		Sector
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sector</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Name</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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
		Group
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Group</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Salary Type
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Salary Type</td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Contact
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Contact</td>
			</tr></table>
		</td>
<?php } ?>



<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Qualification
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Qualification</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Blood Group
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Blood Group</td>
			</tr></table>
		</td>
<?php } ?>



	</tr>
	</thead>
	<tbody>
<?php 

  $q="select * from hr_employee where 1 $cond1 $cond2 $cond3 ORDER BY name, sector, designation";
$res=mysql_query($q);
while($r=mysql_fetch_assoc($res))
{
  
?>
	<tr>
		<td class="ewRptGrpField2">
<?php 
if($sect!=$r['sector'])
echo ewrpt_ViewValue($r['sector']);
else
 ?>
 &nbsp; 
 </td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r['name']); ?></td>
		<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['designation']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['groupname']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['salarytype']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['personalcontact']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['qualification']); ?></td>
<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($r['bloodgroup']); ?></td>
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

<script type="text/javascript">
function reloadpage()
{
	var sect = document.getElementById("sector").value;
	var dec = document.getElementById("desig").value;
	 var group = document.getElementById("group").value;
	document.location = "Employeelist.php?sector="+sect+"&desig="+dec +"&group="+group;
}
</script>