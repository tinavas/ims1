<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 

include "../distribution_getsuperstockist_singh.php";

if($_GET['superstockist']<>"")
{

$superstockist=$_GET['superstockist'];

$cond1="and superstockist='$superstockist'";

}
else
{

$superstockist="none";

$cond1="and superstockist='$superstockist'";

}

if($_GET['salesman']<>"")
{

$salesman=$_GET['salesman'];

$cond2="and salesman='$salesman'";

}
else
{

$salesman="";

$cond2="and salesman='$salesman'";

}


if($_GET['state']<>"")
{

$state=$_GET['state'];

$cond3="and areacode in (select areacode from distribution_area where state='$state')";

}
else
{

$state="";

$cond3="";

}


if($_GET['district']<>"")
{


$district=$_GET['district'];

$cond4="and areacode in (select areacode from distribution_area where state='$state' and district='$district')";


}
else
{

$district="";

$cond4="";

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
 <td colspan="2" align="center"><strong><font color="#3e3276">Sales Man Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td></td>
</tr> 
</table>
<center><p style="padding-left:430px;color:red"></p></center>

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
&nbsp;&nbsp;<a href="distribution_salesmanreport.php?export=html&superstockist=<?php echo $superstockist; ?>&salesman=<?php echo $salesman; ?>&state=<?php echo $state; ?>&district=<?php echo $district; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="distribution_salesmanreport.php?export=excel&superstockist=<?php echo $superstockist; ?>&salesman=<?php echo $salesman; ?>&state=<?php echo $state; ?>&district=<?php echo $district; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="distribution_salesmanreport.php?export=word&superstockist=<?php echo $superstockist; ?>&salesman=<?php echo $salesman; ?>&state=<?php echo $state; ?>&district=<?php echo $district; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="distribution_salesmanreport.php?cmd=reset&superstockist=<?php echo $superstockist; ?>&salesman=<?php echo $salesman; ?>&state=<?php echo $state; ?>&district=<?php echo $district; ?>">Reset All Filters</a>
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
 
 <td>Super Stockist</td>
 <td>
 
 <select name="superstockist" id="superstockist" onchange="reloadpage()">
 <option value="">-All-</option>
 <?php
 $q1="select distinct superstockist from distribution_salesman where superstockist in ($authorizedsuperstockistlist)";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 
 {
 
 ?>
 <option value="<?php echo $r1['superstockist'];?>" <?php if($r1['superstockist']==$_GET['superstockist']){?> selected="selected"<?php }?>><?php echo $r1['superstockist'];?></option>
 
<?php }?>
 
 
 
 </select>
 
</td>



<td>State</td>
 <td>
 <select name="state" id="state" onchange="reloadpage()">
 <option value="">-Select-</option>
<?php
$q1="select distinct state from `state_districts` order by state";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['state'];?>"<?php if($r1['state']==$state){?> selected="selected"<?php }?>><?php echo $r1['state'];?></option>

<?php }?>
 
  </select>
 
 </td>


 <td>District</td>
 <td>
 <select name="district" id="district" onchange="reloadpage()">
 <option value="">-All-</option>
 
<?php
$q1="select distinct district from  `state_districts` where state='$state' order by district";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['district'];?>"<?php if($r1['district']==$district){?> selected="selected"<?php }?>><?php echo $r1['district'];?></option>

<?php }?>
 
  </select>
 
 </td>
<td>Sales Man</td>
 <td>
 <select name="salesman" id="salesman" onchange="reloadpage()">
 <option value="">-Select-</option>
 <?php
 $q1="select distinct salesman from distribution_salesman where superstockist='$superstockist' ";
 
 $q1=mysql_query($q1) or die(mysql_error());
 
 while($r1=mysql_fetch_assoc($q1))
 
 {
 
 ?>
 <option value="<?php echo $r1['salesman'];?>" <?php if($r1['salesman']==$_GET['salesman']){?> selected="selected"<?php }?>><?php echo $r1['salesman'];?></option>
 
<?php }?>
 
 
 
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Sales Man
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Sales Man</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		State
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">State</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		District
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">District</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Area code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Area Code</td>
			</tr></table>
		</td>
<?php } ?>

<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Area Name
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Area Name</td>
			</tr></table>
		</td>
<?php } ?>



	</tr>
	</thead>
	<tbody>
<?php 

$dsalesman="";

 $q1="select fromdate,todate,salesman,superstockist,areacode,areaname  from distribution_salesman where 1 $cond1 $cond2 $cond3 $cond4 order by areaname";

$q1=mysql_query($q1) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))
{ 

$fromdate=date("d.m.Y",strtotime($r1['fromdate']));

$todate=date("d.m.Y",strtotime($r1['todate']));

$salesman=$r1['salesman'];

if($salesman==$dsalesman)
{

$salesman1="";

$fromdate="";

$todate="";

$superstockist="";

}
else
{
$salesman1=$salesman;

$fromdate=date("d.m.Y",strtotime($r1['fromdate']));

$todate=date("d.m.Y",strtotime($r1['todate']));

$superstockist=$r1['superstockist'];
}


$q7="select state,district from distribution_area where areacode='$r1[areacode]'";

$q7=mysql_query($q7) or die(mysql_error());

$r7=mysql_fetch_assoc($q7);




?>
	<tr>
    
    <td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($salesman1); ?></td>
    
		<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue($fromdate) ?></td>
		<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($fromdate); ?></td>

<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r7['state']); ?></td>

<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue($r7['district']); ?></td>
		
<td class="ewRptGrpField1" style="text-align:left">
<?php echo ewrpt_ViewValue($r1['areacode']); ?></td>

<td class="ewRptGrpField1" style="text-align:left">
<?php echo ewrpt_ViewValue($r1['areaname']); ?></td>
	</tr>
<?php

$dsalesman=$r1['salesman'];

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
	var salesman = document.getElementById('salesman').value;
	var superstockist = document.getElementById('superstockist').value;
	
	var state = document.getElementById('state').value;
	
	var district = document.getElementById('district').value;
	
	document.location = "distribution_salesmanreport.php?salesman=" + salesman + "&superstockist=" + superstockist+"&state="+state+"&district="+district;
}
</script>