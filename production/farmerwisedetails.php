<?php 
$sExport = @$_GET["export"]; 
include "reportheader.php"; 
include "config.php";
if($_GET['fromdate'] <> "")
 $fromdate = date("Y-m-d",strtotime($_GET['fromdate']));
else
 $fromdate = date("Y-m-d"); 
 
$farmer = $_GET['farmer'];
$flock = $_GET['flock']; 
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
 <td colspan="2" align="center"><strong><font color="#3e3276">Farm Wise Details</font></strong></td>
</tr>
<?php if($flock){?>
<tr height="5px"></tr>
<tr>
<td><b>Farmer :</b> &nbsp;</td><td><?php echo $farmer; ?>
</td>
</tr>
<tr>
<td> <b>Flock :</b> &nbsp;</td><td><?php echo $flock; ?></td>
 <!--<td><strong><font color="#3e3276">From Date</font></strong><?php echo date("d.m.Y",strtotime($fromdate)); ?></td>-->
</tr> 
<?php }?>
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
&nbsp;&nbsp;<a href="farmerwisedetails.php?export=html&fromdate=<?php echo $fromdate; ?>&farmer=<?php echo $farmer; ?>&flock=<?php echo $flock; ?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="farmerwisedetails.php?export=excel&fromdate=<?php echo $fromdate; ?>&farmer=<?php echo $farmer; ?>&flock=<?php echo $flock; ?>">Export to Excel</a>
&nbsp;&nbsp;<a href="farmerwisedetails.php?export=word&fromdate=<?php echo $fromdate; ?>&farmer=<?php echo $farmer; ?>&flock=<?php echo $flock; ?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="farmerwisedetails.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&farmer=<?php echo $farmer; ?>&flock=<?php echo $flock; ?>">Reset All Filters</a>
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
 <td> Farmer &nbsp;</td><td><select id="farmer" style="width:100px"  onChange="getflocks(this.value)">
 <option value="" >-Select-</option>
 <?php $result = mysql_query("select distinct(farmcode) from layer_flock",$conn1);
  while($res = mysql_fetch_assoc($result))
  {?>
  
  <option value="<?php echo $res['farmcode']; ?>" <?php if($farmer == $res['farmcode']){?> selected="selected" <?php } ?>> <?php echo $res['farmcode']; ?></option>
 <?php } ?>
 </select>&nbsp;</td>
 
 <td> Flock &nbsp;</td><td><select id="flock" style="width:100px" onChange="reloadpage()">
 <option value="" >-Select-</option>
 
<?php $result = mysql_query("select distinct(flockcode),flockdescription from layer_flock where farmcode = '$farmer'",$conn1);
  while($res = mysql_fetch_assoc($result))
  {?>
  
  <option value="<?php echo $res['flockcode']; ?>" title="<?php echo $res['flockdescription'];?>" <?php if($flock == $res['flockcode']){?> selected="selected" <?php } ?>> <?php echo $res['flockcode']; ?></option>
 <?php } ?>
 
 </select>&nbsp;</td>
 
 
<!-- <td>Date </td>
 <td><input type="text" name="fromdate" id="fromdate" class="datepicker" value="<?php echo date("d.m.Y",strtotime($fromdate)); ?>"  onchange="reloadpage();"/></td>-->
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
			<td  align="center">Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" >
		Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Deascription</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" colspan="2" class="ewTableHeader"  align="center">
		Amount
		</td>
<?php } else { ?>
		<td class="ewTableHeader" colspan="2">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td  align="center">Amount</td>
			</tr></table>
		</td>
<?php } ?>

	</tr>
	<tr class="ewTableHeader"><td>&nbsp;</td><td>&nbsp;</td><td align="center">Cr</td><td align="center">Dr</td></tr>
	</thead>
	<tbody>
<?php 

  $query = "select warehouse from tbl_sector where sector = '$farmer' and warehouse <> '' and client = '$client'";
$result = mysql_query($query,$conn1) or die(mysql_error());
$res = mysql_fetch_assoc($result);
 $warehouse = $res['warehouse'];
$total = 0;
 $query = "select date,description,totalamount from pp_sobi where warehouse = '$warehouse' and client = '$client' order by date"; 
$result = mysql_query($query,$conn1) or die(mysql_error());
while($res = mysql_fetch_assoc($result))
{ 
?>
	<tr>
	<td align="center"> <?php echo date("d.m.Y",strtotime($res['date']));?></td>	
	<td > <?php echo $res['description']; ?></td>
	<td>&nbsp;</td>
	<td align="right"><?php echo $res['totalamount']; $total+=$res['totalamount']; ?></td>
	</tr>
<?php
}
?>
<tr><td colspan="3" align="right"><b>Total </b></td><td align="right"><?php echo $total;?></td></tr>
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

function getflocks(farm)
{
 var id = document.getElementById('flock');
 for($i=id.length;$i>0;$i--)
  id.remove($i);
  
<?php $result = mysql_query("select distinct(farmcode),flockcode,flockdescription from layer_flock where client = '$client'",$conn1)or die (mysql_error());
  while($res = mysql_fetch_assoc($result))
  {?>
    if(farm == "<?php echo $res['farmcode']; ?>")
	{
	theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $res['flockcode']; ?>");
    theOption1.appendChild(theText1);
    theOption1.value = "<?php echo $res['flockcode']; ?>";
    theOption1.title = "<?php echo $res['flockdescription']; ?>";
    id.appendChild(theOption1);
	
	}
	
<?php } ?>	
   
}
function reloadpage()
{
	//var fdate = document.getElementById('fromdate').value;
	var farmer = document.getElementById('farmer').value;
	var flock = document.getElementById('flock').value;
	document.location = "farmerwisedetails.php?farmer=" + farmer + "&flock=" + flock;
}
</script>