<?php include "config.php";
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
if(!isset($_GET['code']) )
 {$code = "All";
 $desc = "All";}
else if($_GET['code']=="All")
{
	$code = "All";
 $desc = "All";
}
else
 {$code1 =explode("@", ($_GET['code']));
 $code=$code1[0];
 $desc =$code1[1]; }
if(!isset($_GET['location']))
 $location="All";
else
 $location = $_GET['location'];
 
 $status = $_GET['status'];
 
 if($status == "PR DONE")
 $statuscond = "and flag=1";
 
 else if($status == "PR NOT DONE")
 $statuscond = "and flag=0 ";
 
 else
 $statuscond = "";
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
 <td colspan="4" align="center"><strong><font color="#3e3276">Purchase Indent Report</font></strong></td>
</tr>
<tr height="5px"></tr>
<tr>
 <td><strong><font color="#3e3276">From Date : </font></strong><?php echo date($datephp,strtotime($fromdate)); ?></td>

  <td colspan="1" align="center"><strong><font color="#3e3276">To Date : </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
</tr> 
<tr>

 <td colspan="1" align="center"><strong><font color="#3e3276">Code : </font></strong><?php echo $code; ?></td>

  <td colspan="1" align="center"><strong><font color="#3e3276">Description : </font></strong><?php echo $desc; ?></td>



</tr>

<tr>

 <td colspan="2" align="center"><strong><font color="#3e3276">Location : </font></strong><?php echo $location; ?></td>

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
&nbsp;&nbsp;<a href="purchaseindentreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&code=<?php echo $_GET['code']; ?>&desc=<?php echo $desc; ?>&location=<?php echo $location; ?>&status=<?php echo $status; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="purchaseindentreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&code=<?php echo $_GET['code']; ?>&desc=<?php echo $desc; ?>&location=<?php echo $location; ?>&status=<?php echo $status; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="purchaseindentreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&code=<?php echo $_GET['code']; ?>&desc=<?php echo $desc; ?>&location=<?php echo $location; ?>&status=<?php echo $status; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="purchaseindentreport.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&code=<?php echo $_GET['code']; ?>&desc=<?php echo $desc; ?>&location=<?php echo $location; ?>&status=<?php echo $status; ?>">Reset All Filters</a>
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
<td> Code </td>
<td><select id="code" name="code" style="width:80px;" onchange = "getdesc() , reloadpage();" >
  <option value="All" <?php if($code == 'All') { ?> selected="selected" <?php } ?>>All</option>
  <?php

$q = "select distinct(icode),name from pp_purchaseindent order by icode";

$qrs = mysql_query($q,$conn1);

while($qr = mysql_fetch_assoc($qrs))

{

?>
  <option value="<?php echo $qr['icode']."@".$qr['name']; ?>" <?php if($code == $qr['icode']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['icode']; ?></option>
  
  <?php } ?>
</select></td>
<td>
Description</td>
<td>
<select id="desc" name="desc" style="width:100px;"  onchange = "getcode() , reloadpage();">
  <option value="All" <?php if($desc == 'All') { ?> selected="selected" <?php } ?>>All</option>
  <?php

$q = "select distinct(name),icode from pp_purchaseindent order by name";

$qrs = mysql_query($q,$conn1);

while($qr = mysql_fetch_assoc($qrs))

{

?>
  <option value="<?php echo $qr['icode']."@".$qr['name']; ?>" <?php if($desc ==$qr['name']) { ?> selected="selected" <?php } ?>  ><?php echo $qr['name']; ?></option>
  <?php } ?>
</select></td>
<td>
 DLocation</td>
<td>
<select id="warehouse" name="warehouse" style="width:100px;"  onchange="reloadpage();">

<option value="All" <?php if($location == 'All') { ?> selected="selected" <?php } ?>>All</option>

<?php

$query1 = "SELECT * FROM tbl_sector where (type1='Cold Room' or type1='Warehouse') AND client = '$client' ORDER BY sector ASC ";

$result1 = mysql_query($query1,$conn1) or die(mysql_error());

while($rows1 = mysql_fetch_assoc($result1))

{

?>

<option value="<?php echo $rows1['sector']; ?>" title="<?php echo $rows1['sector']; ?>" <?php if($location == $rows1['sector']) { ?> selected="selected" <?php } ?>><?php echo $rows1['sector']; ?></option>

<?php

}

?>
</select></td>
<td>Status</td>

 <td><select id="status" name="status" onchange="reloadpage();">

 <option value="All" <?php if($status == 'All') echo "selected='selected'"; ?>>All</option>

 <option value="PR DONE" <?php if($status == 'PR DONE') echo "selected='selected'"; ?>>PR DONE</option>
  <option value="PR NOT DONE" <?php if($status == 'PR NOT DONE') echo "selected='selected'"; ?>>PR  NOT DONE</option>
 

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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Purchase Indent
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Purchase Indent</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		D Location
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center"> D Location</td>
			</tr></table>
		</td>
<?php } ?>


		<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
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
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Qunatity
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Quantity</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Status
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Status</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	</thead>
	<tbody>
<?php 
if($code!="All")
$q1=" and icode='$code'";
else
$q1="";
if($desc!="All")
$q2=" and name='$desc'";
else
$q2="";
if($location!="All")
$q3=" and doffice='$location'";
else
$q3="";





$query="SELECT `date`,`pi`, `icode`, `name`,units, `quantity`, `doffice`,`flag` FROM `pp_purchaseindent` where date>='$fromdate' and date<='$todate'".$q1.$q2.$q3." $statuscond order by pi";
$result=mysql_query($query,$conn1);
while($rows=mysql_fetch_assoc($result))
{ 
?>
<tr>
	<?php if($pi1!=$rows['pi']) { ?>
	<td class="ewRptGrpField2">
<?php echo ewrpt_ViewValue(date("d.m.Y",strtotime($rows['date']))); ?></td>
	<td class="ewRptGrpField3" >
<?php echo ewrpt_ViewValue($rows['pi']); ?></td>

	<?php } else
	{?>

<td class="ewRptGrpField3" align="right">
<?php echo ewrpt_ViewValue(); ?></td>
<td class="ewRptGrpField7" align="right">
<?php echo ewrpt_ViewValue(); ?></td>

<?php }?>
<td class="ewRptGrpField7" >
<?php echo ewrpt_ViewValue($rows['doffice']); ?></td>

	<td class="ewRptGrpField1" >
<?php echo ewrpt_ViewValue($rows['icode']); ?></td>
	<td class="ewRptGrpField4" >
<?php echo ewrpt_ViewValue($rows['name']); ?></td>
<td class="ewRptGrpField4" >
<?php echo ewrpt_ViewValue($rows['units']); ?></td>
	<td class="ewRptGrpField5" align="right">
<?php echo ewrpt_ViewValue($rows['quantity']); ?></td>
<?php  ?>
	<td class="ewRptGrpField8" >
<?php 

if($status == "PR DONE")
{
if($rows['flag']=='1'){ echo "PR Done"; }
}
  
if($status == "PR NOT DONE")
{
if($rows['flag']=='0'){ echo "PR NOT Done"; } 
}
  
  
    
else if($statuscond=="")
{


 if($rows['flag']=='1')
{


echo "PR Done";


}

else
echo "PR NOT DONE";

}

?> 

 </td>

</tr>
<?php
$pi1=$rows['pi'];}
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
	var code = document.getElementById('code').value;
	var desc = document.getElementById('desc').value;
	var location = document.getElementById('warehouse').value;
	var status = document.getElementById('status').value;
	document.location = "purchaseindentreport.php?fromdate=" + fdate + "&todate=" + tdate+"&code="+code+"&desc="+desc+"&location="+location+"&status=" + status;
}
function getdesc()
{
	document.getElementById('desc').value = document.getElementById('code').value;
}
function getcode()
{
	document.getElementById('code').value = document.getElementById('desc').value;
}
</script>