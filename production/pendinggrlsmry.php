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
 
 if($_GET['wh']<>'')
 {
 $wh=$_GET['wh'];
 $cond="warehouse='$wh'";
 }
 else
 {
 $wh='';
 $cond="warehouse<>''";
 }
 
 if($_GET['ven']<>'')
 {
 $ven=$_GET['ven'];
 $cond1="and vendor='$ven'";
 }
 else
 {
 $ven='';
 $cond1=" and vendor<>''";
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
<?php include "getemployee.php";?>
<table align="center" border="0">

<tr>

 <td colspan="2" align="center"><strong><font color="#3e3276"> Pending Goods Receipt Report</font></strong></td>

</tr>
<tr>
 <td><strong><font color="#3e3276">From Date </font></strong><?php echo date($datephp,strtotime($fromdate)); ?>&nbsp;&nbsp;<strong><font color="#3e3276">To Date </font></strong><?php echo date($datephp,strtotime($todate)); ?></td>
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
&nbsp;&nbsp;<a href="pendinggrlsmry.php?export=html&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&wh=<?php echo $wh;?>&ven=<?php echo $ven;?>">Printer Friendly</a>
&nbsp;&nbsp;<a href="pendinggrlsmry.php?export=excel&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&wh=<?php echo $wh;?>&ven=<?php echo $ven;?>">Export to Excel</a>
&nbsp;&nbsp;<a href="pendinggrlsmry.php?export=word&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&wh=<?php echo $wh;?>&ven=<?php echo $ven;?>">Export to Word</a>
<?php if ($bFilterApplied) { ?>
&nbsp;&nbsp;<a href="pendinggrlsmry.php?cmd=reset&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&wh=<?php echo $wh;?>&ven=<?php echo $ven;?>">Reset All Filters</a>
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
 <td>Location</td>
 <td><select name="wh" id="wh" onchange="reloadpage()">
 <option value="">-All-</option>
 <?php
 $q1="select distinct(sector) from tbl_sector where type1='warehouse'";
 $r1=mysql_query($q1);
 while($rs=mysql_fetch_array($r1))
 {?>
 <option value="<?php echo $rs['sector'];?>" <?php if($wh==$rs['sector']){?> selected="selected" <?php }?>><?php echo $rs['sector'];?></option>
 <?php 
 }
 
 ?>
 </select></td>
 <td>Vendor</td>
 <td><select name="ven" id="ven" onchange="reloadpage()">
 <option value="">-All-</option>
 <?php
 $q1="select distinct(vendor) as vendor from pp_goodsreceipt where vendor<>''";
 $r1=mysql_query($q1);
 while($rs=mysql_fetch_array($r1))
 {?>
 <option value="<?php echo $rs['vendor'];?>" <?php if($ven==$rs['vendor']){?> selected="selected" <?php }?>><?php echo $rs['vendor'];?></option>
 <?php 
 }
 
 ?>
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
		Location
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Location</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Goods Receipt Date
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Goods Receipt Date</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Goods Receipt No
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Goods Receipt No</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
		Supplier
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Supplier</td>
			</tr></table>
		</td>
<?php } ?>


<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Item Code
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Code</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;">
		Item Description
		</td>
<?php } else { ?>
		<td class="ewTableHeader">
			<table cellspacing="0" class="ewTableHeaderBtn"><tr>
			<td style="width:100px;" align="center">Item Description</td>
			</tr></table>
		</td>
<?php } ?>
<?php if (@$sExport <> "") { ?>
		<td valign="bottom" class="ewTableHeader" style="width:100px;" align="center">
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

		<td valign="bottom" class="ewTableHeader">

		Received Quantity

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>Received Quantity</td>

			</tr></table>

		</td>

<?php } ?>


<?php if (@$sExport <> "") { ?>

		<td valign="bottom" class="ewTableHeader">

		PO Cost

		</td>

<?php } else { ?>

		<td class="ewTableHeader">

			<table cellspacing="0" class="ewTableHeaderBtn"><tr>

			<td>PO Cost</td>

			</tr></table>

		</td>

<?php } ?>





	</tr>
	</thead>
	<tbody>
<?php 
{ 

		$dumm12 = 0;
			$oldcode="";
		$oldcode1="";
		$oldwh='';
		$abd="";
		
$q21 = "select distinct(gr) as gr from pp_goodsreceipt where pp_goodsreceipt.gr not in(select distinct(pp_sobi.gr) from pp_sobi where gr IS NOT NULL) and $cond and date between '$fromdate' and '$todate' $cond1 order by date";
$r21 = mysql_query($q21);
while($row21 = mysql_fetch_array($r21))
{

$query="SELECT * FROM `pp_goodsreceipt` where gr = '$row21[gr]'";
	$result=mysql_query($query,$conn1);
	while($rows=mysql_fetch_array($result))
	{
		
		$x_wh=$rows['warehouse'];
			$x_gr=$row21['gr'];
			$x_date=$rows['date'];
			$x_vendor=$rows['vendor'];
			$x_code=$rows['code'];
			$x_description=$rows['description'];
			$x_units=$rows['units'];
			$x_receivedquantity=$rows['receivedquantity'];			
			
	
	
	

?>
	<tr>
	
	<?php $datesample = date("d.m.Y",strtotime($x_date));?>
	
    <td class="ewRptGrpField2">
		<?php if(($x_wh <> $oldwh) ){ echo ewrpt_ViewValue($x_wh);

   $oldwh = $x_wh; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>

</td>
		<td class="ewRptGrpField2">
		<?php if(($datesample <> $oldcode) or ($dumm == 0)){ echo ewrpt_ViewValue($datesample);

   $oldcode = $datesample; $dumm = 1; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");

	 } ?>

</td>
		<td class="ewRptGrpField3" align="right">

<?php if(($x_gr <> $oldcode1) or ($dumm11 == 0)){ echo ewrpt_ViewValue($x_gr);

     $oldcode1 = $x_gr; 
	 $abd="n"; }

	 else{

	 echo ewrpt_ViewValue("&nbsp;");
$abd="";
	 } ?></td>
		
	
	<td class="ewRptGrpField1" align="right">
<?php  if($abd!="")
{
	echo ewrpt_ViewValue($x_vendor);

}  
else 		
echo ewrpt_ViewValue("&nbsp;");
		
?></td>

<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($x_code) ?></td>

<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($x_description) ?></td>

<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue($x_units)

 ?>
</td>
	
	
	<td class="ewRptGrpField1" align="right">
<?php echo ewrpt_ViewValue(changeprice($x_receivedquantity),2); ?></td>
	
	<?php 
	$pocost = 0;
 $query11 = "SELECT sum(amount) as pocost  FROM ac_financialpostings where trnum ='$x_gr' and coacode='AS110' and client = '$client'";
$result2= mysql_query($query11,$conn1); 
           while($row1 = mysql_fetch_assoc($result2))
           {
          	$ab=$pocost = $row1['pocost'];
			
			  
           }
		   
?>

	
	<td class="ewRptGrpField1" align="right">
<?php  if($abd<>"")
{
	$tot11=$tot11+$pocost;
	echo ewrpt_ViewValue(changeprice($pocost));

}  
else 		
echo ewrpt_ViewValue("&nbsp;");
		
?></td>

</tr>	
	
	
<?php
} } }
?>
	</tbody>
	
	<tr><td colspan="7">Total:</td><td>&nbsp;</td><td align="right"><?php echo changeprice($tot11);?></td></tr>
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
	var fdate = document.getElementById('fromdate').value;
	var tdate = document.getElementById('todate').value;
	var wh= document.getElementById('wh').value;
	var ven= document.getElementById('ven').value;
	document.location = "pendinggrlsmry.php?fromdate=" + fdate + "&todate=" + tdate +"&wh=" +wh + "&ven=" + ven;
}
</script>